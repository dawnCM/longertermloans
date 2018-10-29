<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');
App::uses('HttpSocket', 'Network/Http');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $components = array('RequestHandler', 'Session');
	public $theme = 'Onepage';
	public $template = 'crystal';
	
	function beforeFilter() {
		//Ajax must validate
		if ($this->request->is('ajax')) {
			$basekey = Configure::read('Ajax.nonce');
			if($this->request->header('x-keyStone-nonce') != $basekey){
				throw new ForbiddenException();
				exit;
			}
		}
		//Grab current session data
		$campaign_id 	= "5a0a907c38e1a"; 
		$campaign_key 	= "yVkb3NcHhDBCK4qz2Qgt";

		/*if(isset($this->params['url']['lp_request_id']))
		{
			if($this->params['url']['lp_request_id'] == true){ */
			
				$lp_request_id = $this->params['url']['lp_request_id'];
				$this->Session->write('Application.RequestId', $lp_request_id);
			/*}
		}*/

		//---@16/4/2018 Prepop code ---
		//if(isset($this->params['url']['Prepop'])){
			if($this->params['url']['Prepop'] == true){
				$Prepop = $this->params['url']['Prepop'];
				// if Prepop Value is true then set Prepop data to Session
				if($Prepop=="true"){
					$url_prepop = $this->params['url'];
					$skip_array= array();
					if(is_array($url_prepop)){
						foreach($url_prepop as $k=>$v){
							if(in_array($k, $skip_array))continue;
							$this->Session->write('Application.'.$k, $v);
						}
					}
				}
			}
		//}

		$url_param = $this->params['url'];
		$this->Session->write('Application.SubId1', ($url_param['s1']) ? $url_param['s1'] : "");
		$this->Session->write('Application.SubId2', ($url_param['s2']) ? $url_param['s2'] : "");
		$this->Session->write('Application.SubId3', ($url_param['s3']) ? $url_param['s3'] : "");
		$this->Session->write('Application.SubId4', ($url_param['s4']) ? $url_param['s4'] : "");
		$this->Session->write('Application.SubId5', ($url_param['s5']) ? $url_param['s5'] : "");

		if($this->params['url']['check'] == false){ 
			
			$check = $this->params['url']['check'];
			$this->Session->write('Application.Check', $check);
		}else{

			$this->Session->write('Application.Check', 'false');
		}
	
		$request_id		= $this->Session->read('Application.RequestId');
		

		//Keep lead credentials if exist in session.  Remove other data points
		if( (isset($this->request->params['action']) && ($this->request->params['action'] == "clear" || $this->request->params['action'] == "prepop" ))  && (!empty($offer_id) && !empty($campaign_id))) {
			// Start with a clean session
			$this->Session->destroy();
			$this->Session->write('Application.CampaignId',$campaign_id);
			$this->Session->write('Application.AffiliateKey',$campaign_key);
		}else{
		
			// Set organic offer if we do not have any offers set
			if(!$this->Session->check('Application.RequestId')) {
				$this->Session->write('Application.RequestId', $request_id);
			}	
		}
		

		//Do we have a theme? if not, check theme.json and determine if we 
		//should set one or use the default alpha theme.
		if(!$this->Session->check('Application.Theme')) {
			if($theme_config = $this->checkTheme()){
				$this->theme = $theme_config;
				$this->Session->write('Application.Theme', $theme_config);
			}else{
				$this->Session->write('Application.Theme', $this->theme);	
			}			
		}else{
			$this->theme = $this->Session->read('Application.Theme');
		}
		
		//Set state dropdown
		$this->set('StateDrop', array(
			'AL'=>'ALABAMA','AK'=>'ALASKA','AZ'=>'ARIZONA','AR'=>'ARKANSAS','CA'=>'CALIFORNIA','CO'=>'COLORADO','CT'=>'CONNECTICUT','DE'=>'DELAWARE',
			'DC'=>'DISTRICT OF COLUMBIA','FL'=>'FLORIDA','GA'=>'GEORGIA','HI'=>'HAWAII','ID'=>'IDAHO','IL'=>'ILLINOIS','IN'=>'INDIANA','IA'=>'IOWA','KS'=>'KANSAS','KY'=>'KENTUCKY',
			'LA'=>'LOUISIANA','ME'=>'MAINE','MD'=>'MARYLAND','MA'=>'MASSACHUSETTS','MI'=>'MICHIGAN','MN'=>'MINNESOTA','MS'=>'MISSISSIPPI','MO'=>'MISSOURI','MT'=>'MONTANA','NE'=>'NEBRASKA',
			'NV'=>'NEVADA','NH'=>'NEW HAMPSHIRE','NJ'=>'NEW JERSEY','NM'=>'NEW MEXICO','NY'=>'NEW YORK','NC'=>'NORTH CAROLINA','ND'=>'NORTH DAKOTA','OH'=>'OHIO','OK'=>'OKLAHOMA',
			'OR'=>'OREGON','PA'=>'PENNSYLVANIA','RI'=>'RHODE ISLAND','SC'=>'SOUTH CAROLINA','SD'=>'SOUTH DAKOTA','TN'=>'TENNESSEE','TX'=>'TEXAS','UT'=>'UTAH','VT'=>'VERMONT',
			'VA'=>'VIRGINIA','WA'=>'WASHINGTON','WV'=>'WEST VIRGINIA','WI'=>'WISCONSIN','WY'=>'WYOMING'));
		
		//Smart Load Js
		$this->set('loadApplicationJS',false);
				
		//Set mobile check
		if ($this->RequestHandler->isMobile()) {
     		Configure::write('Global.Mobile', true);
     		$this->Session->write('Application.Mobile', true);
		}

		$this->Session->write('Application.Url', 'https://'.$_SERVER['SERVER_NAME']);
		$this->Session->write('Application.IPAddress', $_SERVER['HTTP_X_FORWARDED_FOR']);
		$this->Session->write('Application.Template', $this->template);
		$this->Session->write('Application.Mobile', ((Configure::read('Global.Mobile') === null) ? 'false' : 'true'));
		$this->Session->write('Application.CallType', 'internal');
		
	}

	/**
	 * Check to see what theme we should set.
	 * @return string
	 */
	protected function checkTheme(){
		//Check cache to get json or pull from file
		$cache['hash'] = md5('JSONTheme');
		$cache['value'] = false;
		$cache['value'] = Cache::read($cache['hash']);
	
		if($cache['value'] === false){
			$result = $this->checkThemeJsonFile();
			if(is_array($result)){
				Cache::write($cache['hash'],json_encode($result),'15m');	
			}
		}else{
			$result = json_decode($cache['value'], true);
		}
		
		$theme=false;
		if(is_array($result)){
			//actions - Campaign(c) Split(s)  Time(t)
			$theme = $this->themeLogic($result);
			if(trim($theme) == false || trim($theme) == ""){
				$theme = $this->theme; //set back to default	
			}else{
				if(!is_dir('../View/Themed/'.$theme)){
					$theme=false;
				}
			}	
		}
	
		return $theme;
	}

	/**
	 * Theme configuration file
	 * @return string|boolean
	 */
	protected function checkThemeJsonFile(){
		$file = new File('../tmp/json/theme.json', false, 0777); //create object - will not error at this level if missing	
		if( $file->exists() ){ //Does file exist
			$file_contents = @$file->read(false, 'rb', false);
			if($file->size() > 0 && $jsonToArray = @json_decode($file_contents,true)){ //check if valid json
				if(is_array($jsonToArray)){
					return $jsonToArray;
				}
			}
		}
		return false;
	}
	
	protected function themeLogic(ARRAY $data){
		//json by time - {"c":"24","a":"t","theme":["alpha","beta"],"v":"23:56"}
		//json by percentage -  {"c":"24","a":"s","theme":["alpha","beta"],"v":["50","50"]}
		//json by campaign only - {"c":"24","a":"c","theme":"alpha"}
		
		$specific_config = false; //array holder for a specific campaign config
		$default_config = false; //array holder for default config for all campaigns
		
		$campaignid = $this->Session->read('Application.CampaignId');
		
		foreach($data as $k=>$v){
			//set default array	if present
			if($v['c'] == "default"){
				$default_config = $v;
				continue;	
			}
			
			//set specific campaign config is present
			if($v['c'] == $campaignid){
				$specific_config = $v;
			}
		}
		
		if($specific_config === false && $default_config === false){ //Use app controller theme
			return false;
		}else if(is_array($specific_config)){ //rank 1
			$config = $specific_config;
		}else if(is_array($default_config)){ // rank 2
			$config = $default_config;
		}else{
			return false; //use app controller theme
		}
		
		
		switch ($config['a']) { //actions - Campaign(c) Split(s)  Time(t)
			case 's': //split percentage
				$campaign_id = $config['c'];
				$theme1 = $config['theme'][0];
				$theme2 = $config['theme'][1];
				$split_percentage1 = (INT) $config['v'][0] / 10; //whole number 1-10
				$split_percentage2 = (INT) $config['v'][1] / 10; //whole number 1-10
				$random_number = rand(1, 10);
				
				return ucfirst((($random_number <= $split_percentage1) ? $theme1 : $theme2 ));
				break;
			
			case 't': //Split by Time
				$campaign_id = $config['c'];
				$theme1 = $config['theme'][0];
				$theme2 = $config['theme'][1];
				$split_unix = strtotime($config['v']); //to unix format HH:MM 24hour format
				$current_unix = strtotime("now");
				return ucfirst((($current_unix < $split_unix) ? $theme1 : $theme2 ));
				break;
			
			case 'c': //Campaign
				$campaign_id = $config['c'];
				$theme = $config['theme'];
				return ucfirst($theme);
				break;
				
			default:
				return false;
				break;
		}
	}

	
}