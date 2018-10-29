<?php
/**
 * keyStone(SD) - Site Development
 *
 * Licensed under GNU General Public License v.2
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     TBD
 * @link          TBD
 * @package       app.Controller.ApplicationController
 * @since         keyStone(SD) v1.0 
 * @license       TBD
 */

App::uses('HttpSocket', 'Network/Http');
class ApplicationController extends AppController {
	var $errors = array();	
	
	public function beforeFilter() {
		parent::beforeFilter();

		
		// //Do we have a trackid, if not create one
		// if(!$this->Session->check('Application.TrackId')){
		// 	$track_data = array();
		// 	$track_data['offer_id'] 	= $this->Session->read('Application.OfferId');
		// 	$track_data['campaign_id'] 	= $this->Session->read('Application.CampaignId');
		// 	$track_data['affiliate_id'] = $this->Session->read('Application.AffiliateId');
		// 	$track_data['request_id']	= $this->Session->read('Application.RequestId');

		// 	//Start Track
		// 	$track_response = $this->trackStart(json_encode($track_data));
						
		// 	if($track_response['status'] == 'success'){
		// 		$this->Session->write('Application.TrackId', $track_response['data']['track_id']);
		// 	}
		// }
		
		
		$this->Session->write('Application.Url', 'https://'.$_SERVER['SERVER_NAME']);
		$this->Session->write('Application.IPAddress', $_SERVER['HTTP_X_FORWARDED_FOR']);
		$this->Session->write('Application.Template', $this->template);
		$this->Session->write('Application.Mobile', ((Configure::read('Global.Mobile') === null) ? 'false' : 'true'));

		$url_param = $this->params['url'];
		if(isset($url_param['s1']))
			$this->Session->write('Application.SubId1', ($url_param['s1']) ? $url_param['s1'] : "");
		if(isset($url_param['s2']))
			$this->Session->write('Application.SubId2', ($url_param['s2']) ? $url_param['s2'] : "");
		if(isset($url_param['s3']))
			$this->Session->write('Application.SubId3', ($url_param['s3']) ? $url_param['s3'] : "");
		if(isset($url_param['s4']))
			$this->Session->write('Application.SubId4', ($url_param['s4']) ? $url_param['s4'] : "");
		if(isset($url_param['s5']))
		$this->Session->write('Application.SubId5', ($url_param['s5']) ? $url_param['s5'] : "");
		
		$this->set('loadApplicationJS',true);
	}
		
	/**
	 * Display the application form
	 */
	public function index() {
		$this->layout = 'default';
		$this->Application->set($this->request->data);
		$track_data = array();
		$lead_data = array();
		
		//---1-6-2018 for longerterm popup open in Backgroud
		//Validate page 1
		/*if(!$this->Application->validates(array('fieldList' => array('CreditRating','Zip','Military','MonthlyNetIncome','Agree')))) {
			$this->redirect('/');
		}*/
		
		//Add each variable from page 1 to the session
		foreach($this->request->data AS $key=>$value){
			$this->setSessionData($key, $value);
		}
		
		//Do we have a trackid, if not create one
		if(!$this->Session->check('Application.TrackId')){
			$first_time = true;	
			$track_data['campaign_key'] = $this->Session->read('Application.CampaignKey');
			$track_data['campaign_id'] 	= $this->Session->read('Application.CampaignId');
			$track_data['request_id']	= $this->Session->read('Application.RequestId');

			//Start Track
			// $track_response = $this->trackStart(json_encode($track_data));
						
			// if($track_response['status'] == 'success'){
			// 	$this->Session->write('Application.TrackId', $track_response['data']['track_id']);
			// 	$lead_data['TrackId'] = $track_response['data']['track_id'];
			// }
		}
		
		
		//Add Page 1 to track lead
		$lead_data['CallType'] 	= 'internal';
		$lead_data['Template'] 	= $this->template;
		$lead_data['Theme'] 	= $this->theme;
		$lead_data['Mobile'] 	= (Configure::read('Global.Mobile') === null) ? 'false' : 'true';
		$lead_data['sub_id'] 	= $this->Session->read('Application.SubId1');
		$lead_data['sub_id2'] 	= $this->Session->read('Application.SubId2');
		$lead_data['IPAddress'] = $_SERVER['HTTP_X_FORWARDED_FOR'];
			
		//Add post data to lead track array
		foreach($this->request->data AS $key=>$value){
			$lead_data[$key] = $value;
		}
			
		//Send to Tracklead
		$this->trackLead(json_encode($lead_data), $this->Session->read('Application.TrackId'));
				
		//Set conditional items based on CreditRating/Military
		if($this->Session->read('Application.CreditRating')){
			//PL Loan Amount Drop Down
			$this->set('LoanAmount', array(
					'300'=>'$100 - $499', '500'=>'$500 - $999', '1500'=>'$1,000 - $1,999', 
					'2500'=>'$2,000 - $2,999', '3500'=>'$3,000 - $3,999', '4500'=>'$4,000 - $4,999', 
					'5500'=>'$5,000 - $5,999', '6500'=>'$6,000 - $6,999', '7500'=>'$7,000 - $7,999',
					'8500'=>'$8,000 - $8,999', '9500'=>'$9,000 - $9,999', '10000'=>'$10,000 - $10,999',
					'11500'=>'$11,000 - $11,999', '12500'=>'$12,000 - $12,999', '13500'=>'$13,000 - $13,999',
					'14500'=>'$14,000 - $14,999', '15500'=>'$15,000 - $15,999', '16500'=>'$16,000 - $16,999',
					'17500'=>'$17,000 - $17,999', '18500'=>'$18,000 - $18,999', '19500'=>'$19,000 - $19,999',
					'20500'=>'$20,000 - $20,999', '21500'=>'$21,000 - $21,999', '22500'=>'$22,000 - $22,999',
					'23500'=>'$23,000 - $23,999', '24500'=>'$24,000 - $25,000'));
			
			//PL Employee Type Drop Down
			$this->set('LoanAmountPayday', array(
					'200'=>'$200', '300'=>'$300', '400'=>'$400', '500'=>'$500', '600'=>'$600', '700'=>'$700',
					'750'=>'$750', '800'=>'$800', '900'=>'$900', '1000'=>'$1,000', '1001'=>'Get Me As Much As You Can'));

		$this->set('EmployeeType', array(
					'self_employed'=>'Self Employed', 'employed'=>'Employed', 'pension'=>'Retired', 'pension'=>'Disabled', 
					'unemployed'=>'Unemployed with income', 'unemployed'=>'Unemployed without income'));
			$this->Session->write('Application.AppType', 'personalloan');
		}

		//update AppType
	//	$this->trackLead(json_encode(array('AppType'=>$this->Session->read('Application.AppType'))), $this->Session->read('Application.TrackId'));

			
	}
	
	/**
	 * Receives an ajax request to save user input to tracklead.
	 */
	public function applicationStep(){
		if($this->request->is('ajax')){
			foreach($this->request->data as $key=>$value){
				$lead_data[$key]=$value;
			}
			
			//Send to Tracklead
			$this->trackLead(json_encode($lead_data), $this->Session->read('Application.TrackId'));
		}
	}

	/**
	 * 
	 * 
	 */
	public function processLead(){
		$this->layout = null;
		$this->autoRender = false;
		$this->response->type('json');
		if($this->request->is('ajax')){
			$response_array = array();
			$this->Session->write('Application.AppType', $this->request->data['AppType']);
						
			//Grabs the post and cleans out characters in phone fields.  Returns clean value back into POST
			$this->cleanFormPostData();
			
			$this->Application->set(array_merge($this->Session->read('Application'),$this->request->data));
			$this->Application->addDependencies();
			
			if($this->Application->validates()) {
				$s_data = array_merge($this->Application->data['Application'], $this->request->data);
				$track_id = $this->Session->read('Application.TrackId');
			
				$source = array(		'CampaignKey' => trim($this->Session->read('Application.CampaignKey')),
										'CampaignId' => trim($this->Session->read('Application.CampaignId')),
										'TrackId' => $track_id,
										'RequestId' => trim($this->Session->read('Application.RequestId')),
										'Template' => $this->Session->read('Application.Template')
				);
				
				$lead_data = array(		"id"=>$track_id, 
										"created"=>date("Y-m-d H:i:s"), 
										"type"=>'lead',	
										"source"=>$source,
										"data"=>$s_data
								  );
					  
				$lead_data_json = json_encode($lead_data);
			
				$url = "http://api.leadstudio.com/processCrmLeadSpa";
						    
			    $config = array('header'=>array('X-Api-Id'=>Configure::read('Ajax.Id'),'X-Api-Key'=>Configure::read('Ajax.Key'),'Content-Type'=>'application/json'));
			    $socket = new HttpSocket(array('timeout'=>180));
			    $response = $socket->post($url,$lead_data_json,$config);
				$this->log($response);
				$status_json = json_decode($response);
				
				$status = $status_json->status; 
				$redirect = $status_json->redirect;
				
				if($status == "ACCEPT" && !empty($redirect)){
					$response_array['status'] = 'success';
					$response_array['redirect'] = $redirect;
					$this->Session->destroy();
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
				
				$track_id = $this->Session->read('Application.TrackId');
				$json = json_encode(array('ERRORS' => array(501=>'Failed Validation - Application Controller')));
				$this->trackLead($json, $track_id);
				
				return json_encode($response_array);
			}
		}
	}
	
	public function fault(){
		$this->layout = 'default';
		$creditRating = $this->Session->read('Application.CreditRating');
		$offerLink = "http://www.yahoo.com";
		$this->Session->destroy();
		$this->set('offerLink', $offerLink);
	}

	public function thankyou(){

		$this->layout = 'default';
		$this->Session->destroy();
	}
		
	private function trackStart($json){
		$url = Configure::read('Global.ServiceUrl').'/trackStart';

		$config = array('header'=>array('X-Api-Id'=>Configure::read('Ajax.Id'),'X-Api-Key'=>Configure::read('Ajax.Key'),'Content-Type'=>'application/json'));
		$socket = new HttpSocket();
		$response = $socket->post($url,$json,$config);

		return json_decode($response['body'], true);
	}
	
	
	private function trackLead($json, $track_id){
		$url = Configure::read('Global.ServiceUrl').'/trackLead/'.$track_id;
		
		$config = array('header'=>array('X-Api-Id'=>Configure::read('Ajax.Id'),'X-Api-Key'=>Configure::read('Ajax.Key'),'Content-Type'=>'application/json'));
		$socket = new HttpSocket();
		$response = $socket->post($url,$json,$config);
	}
	
	/**
	 * Get the offer type using exportOffer.  Retrieve offer data from CakeM.
	 * @param integer $offer_id
	 */
	private function getOfferType($offer_id){
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
	private function getPriceFormat($campaign_id=0,$offer_id=0,$affiliate_id=0){
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
	private function send($url) {
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
	private function getRequestId($affid, $creative, $sub, $offer_type, $price_format){
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
	private function setSessionData($key, $value){
		$this->Session->write('Application.'.$key, $value);
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
			
			foreach($this->request->data as $key=>$value){
				$this->Session->write('Application.'.$key, $value);
			}
		}
	}
	
	
	//Session data is cleaned.  Now we have to make sure the form data is clean before validation
	private function cleanFormPostData(){
		$filter_array = array('SecondaryPhone','WorkPhone','PrimaryPhone');
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