<?php
/**
 * OnePage Widget
 *
 * Licensed under GNU General Public License v.2
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     TBD
 * @link          TBD
 * @package       app.Controller.OnePageController
 * @since         keyStone(SD) v1.0 
 * @license       TBD
 */

class OnePageController extends AppController {
	public $uses = array('Application');
	var $errors = array();
	
	public function beforeFilter() {
		
	
	}

	/**
	 * Set application variables in the user session via ajax
	 */
	public function setSessionDataAjax(){

		$this->layout = null;
		$this->autoRender = false;
		$this->response->type('json');
		if($this->request->is('ajax')){			
			
			//Clean Data
			$this->cleanFormPostData();

			if(isset($this->request->data['LoanAmountSecond']))
			{
				$this->Session->write('Application.LoanAmount', $this->request->data['LoanAmountSecond']);
				$this->Session->write('Application.LoanAmount2', $this->request->data['LoanAmountSecond']);

			}else{

				if(isset($this->request->data['LoanAmountPayday'])){
					$this->Session->write('Application.LoanAmount', $this->request->data['LoanAmountPayday']);
					$this->Session->write('Application.LoanAmount1', $this->request->data['LoanAmountPayday']);
				}
				elseif(isset($this->request->data['LoanAmountPersonal'])){
					$this->Session->write('Application.LoanAmount', $this->request->data['LoanAmountPersonal']);
					$this->Session->write('Application.LoanAmount1', $this->request->data['LoanAmountPersonal']);
				}
			}
			
			foreach($this->request->data as $key=>$value){
				$this->Session->write('Application.'.$key, $value);
			}
		}
	}

	public function processLead(){
		
		$this->layout = null;
		$this->autoRender = false;
		$this->response->type('json');
		if($this->request->is('ajax')){
			
			$this->Session->write('Application.AppType', $this->request->data['AppType']);
			$this->Session->write('Application.Campaign_id', '5a0a907c38e1a');
			$this->Session->write('Application.Campaign_key', 'yVkb3NcHhDBCK4qz2Qgt');
			//Grabs the post and cleans out characters in phone fields.  Returns clean value back into POST
			$this->cleanFormPostData();
			
			$this->Application->set(array_merge($this->Session->read('Application'),$this->request->data));
			$this->Application->addDependencies();

			if($this->Application->validates(array('fieldList' => array('BankAccountType','BankRoutingNumber','BankAccountNumber','BankName','BankTime')))) {
				$s_data = array_merge($this->Application->data['Application'], $this->request->data);
				//Format TCPA phone number
				$s_data['Phone_TCPA'] = preg_replace('/[^0-9.]+/', '', $s_data['Phone_TCPA']);
				$lead_data_json = json_encode($s_data);
				//echo "lead_data_json";print_r($lead_data_json);exit;die();

				/*$url = "https://api.longertermloans.xyz/leads/processCrmLeadSpa";
				$config = array('header'=>array('Content-Type'=>'application/json'));*/

				$url = "https://api.leadstudio.com/processCrmLeadSpa";
				$config = array('header'=>array('X-Api-Id'=>Configure::read('Ajax.Id'),'X-Api-Key'=>Configure::read('Ajax.Key'),'Content-Type'=>'application/json'));

			    $socket = new HttpSocket(array('timeout'=>180));
			    $response = $socket->post($url,$lead_data_json,$config);

			    $status_json = json_decode($response);
			    //echo "status_json :: ";print_r($status_json);

				$response_array = array();
				$response_array['status'] =$status_json->status;
				$response_array['redirect'] = $status_json->redirect;
				$response_array['total_sold'] = $status_json->total_sold;

				$response_file = "test";
				$file = fopen($_SERVER['DOCUMENT_ROOT'] . "/app/tmp/logs/lead.log","a");
				fwrite($file,$response_file);
				fclose($file);
			
				$this->Session->write('Application.lead_id', $status_json->lead_id);

				if($status_json->total_sold == 0){
					
					if($this->Session->read('Application.LoanAmount1')==""){
						$this->Session->write('Application.LoanAmount1', $s_data['LoanAmount']);
					}
				}

				$response_array['AppType'] = $this->Session->read('Application.AppType');

				//echo "response_array :: ";print_r($response_array);
				return json_encode($response_array);
			}else{
				$response_array['status'] = 'error';
				$response_array['redirect'] = '';
				$validation_array = $this->Application->flatErrorArray();
				
				$track_id = $this->Session->read('Application.TrackId');
				$json = json_encode(array('ERRORS' => array(501=>'Failed Validation - Application Controller')));
				//$this->trackLead($json, $track_id);
				
				if(!empty($validation_array))$this->errors = array_merge($this->errors, $validation_array);
				return json_encode($response_array);
			}
		}
	}

	public function thankyou(){

		$this->layout = 'default';
		$this->Session->destroy();
	}
	
	/*public function processLead(){
		$this->layout = null;
		$this->autoRender = false;
		$this->response->type('json');

			$response_array = array();

		
			//Grabs the post and cleans out characters in phone fields.  Returns clean value back into POST
			$this->cleanFormPostData();
			$this->request->data = $this->request->data+$this->Session->read('Application');
			$this->Application->set($this->request->data);
			
				
			$this->Application->addDependencies();
	
			if($this->Application->validates()) {
				
				$s_data = $this->Application->data['Application'];
				
				$offer_type = $this->getOfferType($this->request->data['OfferId']);
				$price_format = $this->getPriceFormat($this->request->data['CampaignId'], $this->request->data['OfferId'], $this->request->data['AffiliateId']);
				
				if(empty($this->request->data['Sub1']) || !isset($this->request->data['Sub1']))$this->request->data['Sub1']='';//will break is not set
				
				$request_id = $this->getRequestId($this->request->data['AffiliateId'], $this->request->data['CreativeId'], $this->request->data['Sub1'], $offer_type, $price_format);
			
				$track_data = array();
				$track_data['offer_id'] 	= $this->request->data['OfferId'];
				$track_data['campaign_id'] 	= $this->request->data['CampaignId'];
				$track_data['affiliate_id'] = $this->request->data['AffiliateId'];
				$track_data['request_id']	= $request_id;

				//Start Track
				$track_response = $this->trackStart(json_encode($track_data));
						
				if($track_response['status'] == 'success'){
					$this->Session->write('Application.TrackId', $track_response['data']['track_id']);
					$track_id = $track_response['data']['track_id'];
				}
				
				if(empty($track_id) || empty($request_id)){
					$response_array['status'] = 'error';
					$response_array['redirect'] = '';
				
					$this->log('found errors-- Request Or Tracking');
					$json = json_encode(array('ERRORS' => array(701=>'Missing Credentials - Request or Tracking ID')));
					$this->trackLead($json, $track_id);
					return json_encode($response_array);
				}
				
				$lead_data = array();
				$lead_data['Template'] 	= $this->request->data['Template'];
				$lead_data['Theme'] 	= $this->request->data['Theme'];
			
				$tracking_fields = array(	'AppType','LoanAmount','State','CoState','EmployerState','Paydate2','IPAddress','Mobile','CallType','CreditRating','Military','MonthlyNetIncome','LoanPurpose','CoApplicant',
											'FirstName','LastName','Email','Address1','Address2','Zip','City','ResidenceType','RentMortgage','ResidentSinceDate','DateOfBirth','DriversLicenseNumber','DriversLicenseState','PrimaryPhone',
											'PhoneType','SecondaryPhone','EmployeeType','EmployerName','EmploymentTime','WorkPhone','EmployerAddress','EmployerZip','EmployerCity','PayFrequency','Paydate1','CoFirstName','CoLastName',
											'CoPrimaryPhone','CoDateOfBirth','CoEmployeeType','CoEmployerName','CoWorkPhone','CoEmploymentTime','CoMonthlyNetIncome','CoAppSameAddr','CoAddress1','CoAddress2','CoZip','CoCity',
											'BankAccountType','BankName','BankTime','DirectDeposit','Agree','AgreeConsent','AgreePhone','MobilePhone');
				//Add post data to lead track array
				foreach($tracking_fields as $field){
					$val = trim(((isset($this->request->data[$field])) ? $this->request->data[$field] : ''));
					
					if($val != ""){
						$lead_data[$field] = $val;
					}
					
				}
				
				$this->trackLead(json_encode($lead_data), $track_id);
				
				$source = array(		'Affiliate' => trim($this->request->data['AffiliateId']),
										'CampaignId' => trim($this->request->data['CampaignId']),
										'OfferId' => trim($this->request->data['OfferId']),
										'RequestId' => trim($request_id),
										'CreativeId' => trim($this->request->data['CreativeId']),
										'SubId1' => trim($this->request->data['Sub1']),
										'SubId2' => trim($this->request->data['Sub2']),
										'TrackId' => $track_id,
										'Template' => $this->request->data['Template']
				);
				
				$lead_data = array(		"id"=>$track_id, 
										"created"=>date("Y-m-d H:i:s"), 
										"type"=>'lead',	
										"source"=>$source,
										"data"=>$s_data
								  );
								  
				$lead_data_json = json_encode($lead_data);
			
				$url = "https://api.leadstudio.com/processInternalLead";
						    
			    $config = array('header'=>array('X-Api-Id'=>Configure::read('Ajax.Id'),'X-Api-Key'=>Configure::read('Ajax.Key'),'Content-Type'=>'application/json'));
			    $socket = new HttpSocket(array('timeout'=>240));
			    $response = $socket->post($url,$lead_data_json,$config);
				$status_json = json_decode($response);
				
				$status = $status_json->status; 
				$redirect = $status_json->redirect;
				
				if($status == "ACCEPT" && !empty($redirect)){
					$response_array['status'] = 'success';
					$response_array['redirect'] = $redirect;
					
					//Clear cakes cookies because they suck.
					$killCake = new HttpSocket();
					$killCake->get('http://leadstudiotrack.com/t.ashx?callback=jsonp&t=c&o='.$this->request->data['OfferId']);
				}else{
					$response_array['status'] = 'error';
					$response_array['redirect'] = '';
					
				}
				return json_encode($response_array);
			}else{
				$response_array['status'] = 'error';
				$response_array['redirect'] = '';
				$validation_array = $this->Application->flatErrorArray();
			 
				if(!empty($validation_array))$this->errors = array_merge($this->errors, $validation_array);
				$this->log('found errors--');
				$this->log($this->errors);
				$this->log($this->request->data);
				$json = json_encode(array('ERRORS' => array(501=>'Failed Validation - Application Controller')));
				$this->trackLead($json, $track_id);
				return json_encode($response_array);
			}
	}*/

	public function fault(){
		//$this->layout = 'onepage';
		$this->Session->destroy();
	}
	
	public function trackStart($json){
		$url = Configure::read('Global.ServiceUrl').'/trackStart';

		$config = array('header'=>array('X-Api-Id'=>Configure::read('Ajax.Id'),'X-Api-Key'=>Configure::read('Ajax.Key'),'Content-Type'=>'application/json'));
		$socket = new HttpSocket();
		$response = $socket->post($url,$json,$config);

		return json_decode($response['body'], true);
	}
	
	
	public function trackLead($json, $track_id){
		$url = Configure::read('Global.ServiceUrl').'/trackLead/'.$track_id;
		
		$config = array('header'=>array('X-Api-Id'=>Configure::read('Ajax.Id'),'X-Api-Key'=>Configure::read('Ajax.Key'),'Content-Type'=>'application/json'));
		$socket = new HttpSocket();
		$response = $socket->post($url,$json,$config);
	}
	
	/**
	 * Get the offer type using exportOffer.  Retrieve offer data from CakeM.
	 * @param integer $offer_id
	 */
	public function getOfferType($offer_id){
		//Setup cache
		$cache['hash'] = md5('offertype_'.$offer_id);
		$cache['value'] = false;
		$cache['value'] = Cache::read($cache['hash']);
	
		if($cache['value'] === false){
			
			$this->request->data['Cake']['offer_id'] = $offer_id;
			$this->request->data['Cake']['offer_name'] = '';
			$this->request->data['Cake']['advertiser_id'] = 0;
			$this->request->data['Cake']['vertical_id'] = 0;
			$this->request->data['Cake']['offer_type_id'] = 0;
			$this->request->data['Cake']['media_type_id'] = 0;
			$this->request->data['Cake']['offer_status_id'] = 0;
			$this->request->data['Cake']['tag_id'] = 0;
			$this->request->data['Cake']['start_at_row'] = 1;
			$this->request->data['Cake']['row_limit'] = 0;
			$this->request->data['Cake']['sort_field'] = 0;
			$this->request->data['Cake']['sort_descending'] = 'true';
	
			$api_key = Configure::read('CakeM.ApiKey');
			$api_array_vars = $this->request->data['Cake'];
			$api_vars = http_build_query($api_array_vars);
			$api_func = '/5/export.asmx/Offers?api_key='.$api_key.'&';
			$api_url = Configure::read('CakeM.Url').$api_func.$api_vars;
	
			$xml = $this->send($api_url);
		
			$cache['value'] = (string) $xml->offers->offer->offer_type->offer_type_name;
			Cache::write($cache['hash'],$cache['value']);
		}
		
		return $cache['value'];
	}
	
	/**
	 * Get priceFormat
	 * @param integer $campaign_id
	 * @param integer $offer_id
	 * @param integer $affiliate_id
	 * @return Ambigous <multitype:string , unknown>
	 */
	public function getPriceFormat($campaign_id=0,$offer_id=0,$affiliate_id=0){
		//Setup cache
		$cache['hash'] = md5('priceformat_'.$campaign_id.$offer_id.$affiliate_id);
		$cache['value'] = false;
		$cache['value'] = Cache::read($cache['hash']);
		
		if($cache['value'] === false){
			$this->request->data['Cake']['campaign_id'] = $campaign_id;
			$this->request->data['Cake']['offer_id'] = $offer_id;
			$this->request->data['Cake']['affiliate_id'] = $affiliate_id;
			$this->request->data['Cake']['account_status_id'] = 0;
			$this->request->data['Cake']['media_type_id'] = 0;
			$this->request->data['Cake']['start_at_row'] = 1;
			$this->request->data['Cake']['row_limit'] = 0;
			$this->request->data['Cake']['sort_field'] = 0;
			$this->request->data['Cake']['sort_descending'] = 'true';
	
			$api_key = Configure::read('CakeM.ApiKey');
			$api_array_vars = $this->request->data['Cake'];
			$api_vars = http_build_query($api_array_vars);
			$api_func = '/6/export.asmx/Campaigns?api_key='.$api_key.'&';
			$api_url = Configure::read('CakeM.Url').$api_func.$api_vars;
			
		    $xml = $this->send($api_url);
			$cache['value'] = (string) $xml->campaigns->campaign->offer_contract->price_format->price_format_name;
			Cache::write($cache['hash'],$cache['value']);
			
		}
		
		return $cache['value'];
	}
	
	/**
	 * Send the request to Cake Marketing.
	 * @param string $url
	 * @return string
	 */
	public function send($url) {
		$socket = new HttpSocket();
		$response = $socket->get($url);
		libxml_use_internal_errors(true);
		$xml = simplexml_load_string($response);
	
		// Clear the model
		unset($this->request->data['Cake']);
	
		$obj = json_decode(json_encode($xml));
			
		if(!$xml){
			return $response;
		}else {
			return $xml;
		}
	}
	
	/**
	 * Retrieve a request id for organic traffic as they did not come through a Cake affiliate link.
	 * @param integer $affid
	 * @param integer $creative
	 * @param string $sub
	 * @param string $offer_type
	 * @param string $price_format
	 */
	public function getRequestId($affid, $creative, $sub, $offer_type, $price_format){
		
	
		if ($offer_type == 'Host-n-Post' && $price_format == 'CPA'){
			$url = Configure::read('CakeM.UrlClickPixel').'?a='.$affid.'&c='.$creative.'&cp=js&s1='.$sub;
		}else if ($offer_type == 'Host-n-Post' && $price_format == 'RevShare'){
			
			$url = Configure::read('CakeM.UrlClickPixel').'?a='.$affid.'&c='.$creative.'&p=r&cp=js&s1='.$sub;
		}else if ($offer_type == 'Host-n-Post' && $price_format == 'Fixed'){
			$url = Configure::read('CakeM.UrlClickPixel').'?a='.$affid.'&c='.$creative.'&p=f&cp=js&s1='.$sub;
		}
	
		$socket = new HttpSocket();
		$cr = $socket->get($url);
	
		preg_match("/var ckm_request_id = (.*);/", $cr, $matches2);
		return trim($matches2[1]);
	}
	
	/**
	 * Set application variables in the user session
	 * @param string $key
	 * @param mixed $value
	 */
	public function setSessionData($key, $value){
		$this->Session->write('Application.'.$key, $value);
	}
	
	
	
	
	//Session data is cleaned.  Now we have to make sure the form data is clean before validation
	public function cleanFormPostData(){
		$filter_array = array('SecondaryPhone','Ssn','CoSsn','WorkPhone','CoPrimaryPhone','CoWorkPhone','PrimaryPhone');
		foreach($this->request->data as $key=>$value){
				
			//take out the characters and spaces					
			if(in_array($key,$filter_array)){
				$this->request->data[$key] = str_replace(array('-','(',')',' '), array('','','',''), $value);	
			}
		}	
	}

	/**
	 * Save form data to track lead
	 */
	public function setTrackLeadAjax(){
		$this->layout = null;
		$this->autoRender = false;
		$this->response->type('json');
		if($this->request->is('ajax')){
			
			//Clean Data
			$this->cleanFormPostData();
			$json = json_encode($this->request->data);
			$track_id = $this->Session->read('Application.TrackId');
			$this->trackLead($json, $track_id);
		}
	}
}
