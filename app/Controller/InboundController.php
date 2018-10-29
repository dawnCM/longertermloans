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
 * @package       app.Controller.InboundController
 * @since         keyStone(SD) v1.0 
 * @license       TBD
 */

class InboundController extends AppController {	
	
	public function beforeFilter() {
		parent::beforeFilter();
	}

	public function index(){
		$this->layout = null;
		$this->autoRender = false;
		return $this->redirect('/');
	}
	
	public function clear(){
		$this->layout = null;
		$this->autoRender = false;
		
		//Check the settings from before filter of AppController.  If condition true, session has already been destroyed and data points set  
		if(!($this->Session->check('Application.KeepOriginalCredentials') && $this->Session->read('Application.KeepOriginalCredentials') === "true")){
			$this->Session->destroy();		
		}
		
		return $this->redirect('/');
	}
	
	public function prepop(){
		
		//Check the settings from before filter of AppController.  If condition true, session has already been destroyed and data points set  
		if(!($this->Session->check('Application.KeepOriginalCredentials') && $this->Session->read('Application.KeepOriginalCredentials') === "true")){
			$this->Session->destroy();		
		}
		
		$qs = "CreditRating=good&Military=true&MonthlyNetIncome=3232&Zip=36006&Agree=true&LoanAmount=8500&LoanPurpose=debt&CoApplicant=Yes&FirstName=jtest&LastName=wtest&DateOfBirth=02%2F03%2F1987&SocialSecurityNumber=324324234&DriversLicenseNumber=32423423&DriversLicenseState=GA&Email=sdsfs3%40go.com&ResidenceType=ownwmtg&ResidentSinceDate=02%2F2010&Address1=3+fsdfsdf&Address2=suite+4&City=Billingsley&State=AL&RentMortgage=323&PrimaryPhone=7709418932&PhoneType=Mobile&EmployeeType=self_employed&EmployerName=sdfsdf&EmployerAddress=sdfsdf&EmployerCity=austell&EmployerState=GA&EmployerZip=30168&WorkPhone=7709419329&EmploymentTime=06%2F2010&PayFrequency=bi-weekly&DirectDeposit=true&CoFirstName=sdfsd&CoLastName=sfdsdfs&CoPrimaryPhone=7709427821&CoSsn=234324234&CoDateOfBirth=02%2F06%2F1990&CoEmployeeType=employed&CoEmployerName=sdfsdfds&CoWorkPhone=7709417983&CoEmploymentTime=02%2F2010&CoMonthlyNetIncome=34343&CoAppSameAddr=No&CoAddress1=sdfsdf&CoAddress2=sdfsf&CoCity=austell&CoState=GA&CoZip=30106&BankAccountType=checking&BankRoutingNumber=061000052&BankAccountNumber=234234232&BankName=BANK+OF+AMERICA+N.A.&BankTime=60&AgreeConsent=true&AgreePhone=true";
		parse_str($qs,$qsArray);
		
		$skip_array= array();
		if(is_array($qsArray)){
			foreach($qsArray as $k=>$v){
				if(in_array($k, $skip_array))continue;
					$this->setSessionData($k,$v);
			}
		}
		
		return $this->redirect('/');
	}
	
	/**
	 * Handle inbound offer link and set sessions accordingly.
	 * @param string $a - Affiliate ID
	 * @param string $id - Request ID
	 * @param string $cmp - Campaign ID
	 * @param string $c - Creative ID
	 * @param string $o - Offer ID
	 * @param string $s1 - Sub ID 1
	 * @param string $s2 - Sub ID 2
	 */
	public function offer($a, $id, $cmp, $c, $o, $s1="", $s2="") {
		$this->layout = null;
		$this->autoRender = false;
		$this->Session->destroy();

		if($this->params['url']['Prepop']==true)
		{           
					
			if(isset($this->params['url']['LoanAmountPersonal']))
				$LoanAmount=$this->params['url']['LoanAmountPersonal'];
			else
				$LoanAmount=$this->params['url']['LoanAmount'];

			if(isset($this->params['url']['CoFirstName']))
				$CoFirstName=$this->params['url']['CoFirstName'];
			else
				$CoFirstName="";

			if(isset($this->params['url']['CoLastName']))
				$CoLastName=$this->params['url']['CoLastName'];
			else
				$CoLastName="";	    

			if(isset($this->params['url']['CoPrimaryPhone']))
				$CoPrimaryPhone=$this->params['url']['CoPrimaryPhone'];
			else
				$CoPrimaryPhone="";

			if(isset($this->params['url']['CoDateOfBirth']))
				$CoDateOfBirth=$this->params['url']['CoDateOfBirth'];
			else
				$CoDateOfBirth="";

			if(isset($this->params['url']['CoEmployeeType']))
				$CoEmployeeType=$this->params['url']['CoEmployeeType'];
			else
				$CoEmployeeType="";

			if(isset($this->params['url']['CoEmployerName']))
				$CoEmployerName=$this->params['url']['CoEmployerName'];
			else
				$CoEmployerName="";

			if(isset($this->params['url']['CoEmploymentTime']))
				$CoWorkPhone=$this->params['url']['CoEmploymentTime'];
			else
				$CoWorkPhone="";

			if(isset($this->params['url']['CoMonthlyNetIncome']))
				$CoMonthlyNetIncome=$this->params['url']['CoMonthlyNetIncome'];

			if(isset($this->params['url']['CoAppSameAddr']))
				$CoAppSameAddr=$this->params['url']['CoAppSameAddr'];
			else
				$CoAppSameAddr="";

			if(isset($this->params['url']['CoAddress1']))
				$CoAddress1=$this->params['url']['CoAddress1'];
			else
				$CoAddress1="";

			if(isset($this->params['url']['CoAddress2']))
				$CoAddress2=$this->params['url']['CoAddress2'];
			else
				$CoAddress2="";

			if(isset($this->params['url']['CoCity']))
				$CoCity=$this->params['url']['CoCity'];
			else
				$coCity="";

			if(isset($this->params['url']['CoState']))
				$CoState=$this->params['url']['CoState'];
			else
				$CoState="";

			if(isset($this->params['url']['CoZip']))
				$CoZip=$this->params['url']['CoZip'];
			else
				$CoZip="";


			$qs='&CreditRating=' . $this->params['url']['CreditRating'] .	
			'&Military='. $this->params['url']['Military'] .		
			'&MonthlyNetIncome='. $this->params['url']['MonthlyNetIncome'] .		
			'&Zip=' . $this->params['url']['Zip'].		
			'&Agree='.		
			'&LoanAmountPayday='.  $LoanAmount  .
			'&LoanPurpose='. $this->params['url']['LoanPurpose'].		
			'&CoApplicant='.		
			'&FirstName='. $this->params['url']['FirstName'].		
			'&LastName=' . $this->params['url']['LastName'].		
			'&DateOfBirth='. date('d/m/Y', strtotime($this->params['url']['DateOfBirth'])) .
			'&SocialSecurityNumber=' .		
			'&DriversLicenseNumber='. $this->params['url']['DriversLicenseNumber'] .		
			'&DriversLicenseState='. $this->params['url']['DriversLicenseState'] .		
			'&Email=' . $this->params['url']['Email'] .		
			'&ResidenceType='. $this->params['url']['ResidenceType'] .	
			'&ResidentSinceDate='. date('m/Y', strtotime($this->params['url']['ResidentSinceDate'])) .	
			'&Address1=' . $this->params['url']['Address1'].		
			'&Address2=' . $this->params['url']['Address2'].
			'&City='.$this->params['url']['City'].
			'&State='.$this->params['url']['State'].
			'&PrimaryPhone='.$this->params['url']['PrimaryPhone'].
			'&PhoneType='.$this->params['url']['PhoneType'].
			'&EmployeeType='.$this->params['url']['EmployeeType'].
			'&EmployerName='.$this->params['url']['EmployerName'].
			'&EmployerAddress='.$this->params['url']['EmployerAddress'].
			'&EmployerCity='.$this->params['url']['EmployerCity'].
			'&EmployerState='.$this->params['url']['EmployerState'].
			'&EmployerZip='.$this->params['url']['EmployerZip'].
			'&WorkPhone='.$this->params['url']['WorkPhone'].
			'&EmploymentTime='.$this->params['url']['EmploymentTime'].
			'&PayFrequency='.$this->params['url']['PayFrequency'].
			'&DirectDeposit='.$this->params['url']['DirectDeposit'].
			'&CoFirstName='.$CoFirstName.
			'&CoLastName='.$CoLastName.
			'&CoPrimaryPhone='.$CoPrimaryPhone.
			'&CoDateOfBirth='.date('d/m/Y', strtotime($CoDateOfBirth)).
			'&CoEmployeeType='.$CoEmployeeType.
			'&CoEmployerName='.$CoEmployerName.
			'&CoWorkPhone='.$CoWorkPhone.
			'&CoAppSameAddr='.$CoAppSameAddr.
			'&CoAddress1='.$CoAddress1.
			'&CoAddress2='.$CoAddress2.
			'&CoState='.$CoState.
			'&CoZip='.$CoZip.
			'&BankAccountType='.$this->params['url']['BankAccountType'].
			'&BankTime='.$this->params['url']['BankTime'].
			'$AgreePhone=true';
			
			

		}

		parse_str($qs,$qsArray);
	
		
		$skip_array= array();
		if(is_array($qsArray)){
			foreach($qsArray as $k=>$v){
				if(in_array($k, $skip_array))continue;
					$this->setSessionData($k,$v);
			}
		}

		
		$this->Session->write('Application.AffiliateId',$a);
		$this->Session->write('Application.RequestId',$id);
		$this->Session->write('Application.CampaignId',$cmp);
		$this->Session->write('Application.CreativeId',$c);
		$this->Session->write('Application.OfferId',$o);
		$this->Session->write('Application.SubId1',$s1);
		$this->Session->write('Application.SubId2',$s2);

		//Check file config to get theme or use default
	
		if($theme_config = $this->checkTheme()){
			$this->theme = $theme_config;
			$this->Session->write('Application.Theme', $theme_config);
		}else{
			$this->Session->write('Application.Theme', $this->theme);
		}

		return $this->redirect('/');
	}
	
	/**
	 * Set application variables in the user session
	 * @param string $key
	 * @param mixed $value
	 */
	private function setSessionData($key, $value){
		$this->Session->write('Application.'.$key, $value);
	}
}