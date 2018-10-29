/**
 * Blind callback handler for jsonp call
 */
function ajaxreceive(e){
	return e.data;
}

/*
 * Excluded fields
 */
var excluded_fields = ["BankRoutingNumber", "BankAccountNumber", "Ssn", "CoSsn"];
var clicked = false;

jQuery(function() {



	var parsleyOptions = {
		errorClass: 'has-error',
		successClass: 'has-success',
		errorsMessagesDisabled: true,
		classHandler: function(el) {
			return el.$element.parent();
		}
	};
			
	jQuery('#basicWizard').parsley(parsleyOptions);
	
	/*if(jQuery('#CoApplicant').val() == 'Yes'){
		jQuery('#tab6').fadeIn();
	}*/

	jQuery(document).on('keyup keypress', function(e) {
		if(e.which == 13) {
			if(jQuery('#basicWizard').parsley().validate() === false){
				if(jQuery('#Agree:checked').length == 0) {
					jQuery('#Agree').next().addClass('text-danger');
				}
				if(jQuery('#AgreeConsent:checked').length == 0) {
					jQuery('#AgreeConsent').next().addClass('text-danger');
				} 
				e.preventDefault(); 
				return false;
			}
		return false;
		} 
	});
	
	if(jQuery("#CreditRating").val() == "excellent" || jQuery("#CreditRating").val() == "good" || jQuery("#CreditRating").val() == "fair" || jQuery("#CreditRating").val() == "unsure"){
		jQuery("#paydayloan").hide();
		jQuery("#personalloan").fadeIn();
		//jQuery("#coappfield").fadeIn();
		//jQuery("#rentmortgage").fadeIn();
		
		jQuery('#LoanAmountPayday').attr('data-parsley-required','false');
		jQuery('#LoanAmountPersonal').attr('data-parsley-required','true');
		
		jQuery('#AppType').val('personalloan');
		jQuery('#additional_lenders').fadeIn();
				
	}else if(jQuery("#CreditRating").val() == "poor"){
		jQuery("#personalloan").hide();
		jQuery("#paydayloan").fadeIn();
		//jQuery("#coappfield").hide();
		//jQuery("#rentmortgage").hide();
		
		jQuery('#LoanAmountPayday').attr('data-parsley-required','true');
		jQuery('#LoanAmountPersonal').attr('data-parsley-required','false');
		
		jQuery('#AppType').val('payday');
		jQuery('#additional_lenders').fadeOut();
	}else{
		jQuery("#personalloan").hide();
		jQuery("#paydayloan").hide();
		//jQuery("#coappfield").hide();
		//jQuery("#rentmortgage").hide();	
		
		jQuery('#LoanAmountPayday').attr('data-parsley-required','true');
		jQuery('#LoanAmountPersonal').attr('data-parsley-required','true');
		
		jQuery('#additional_lenders').fadeOut();
	}

	
	// if(jQuery("#Military").val() == 'true'){
	// 	jQuery("#paydayloan").hide();
	// 	jQuery("#personalloan").fadeIn();
	// 	jQuery("#rentmortgage").fadeIn();
	// 	jQuery('#AppType').val('personalloan');	
	// 	jQuery('#additional_lenders').fadeIn();
	// }
	

	jQuery('#second_loan').on('click', function(){
		/*if(jQuery('#basicWizard').parsley().validate('step7') === false){
			return false;
		}*/
		$(this).prop('disabled',true); //disable further clicks
		jQuery.ajax({
				url: '/OnePage/setSessionDataAjax',
				data: jQuery('#basicWizard').find(":input:not(:hidden)").serialize(),
				method:'post',
				headers:{
					'x-keyStone-nonce': nonce
				},
				complete: function(xhr, str){
					console.log('distribute lead');
					jQuery('#formwrapper').fadeOut();
					jQuery('#tab10').fadeOut();
					jQuery('#wait').fadeIn();
					processLeadSecond(getHiddenFields());
				}
			});
	});

	$("#thanks" ).click(function() {
		window.location.replace('/OnePage/thankyou');
	});


	function processLeadSecond(data){

		Pace.track(function(){
			jQuery.ajax({
				url: '/OnePage/processLead',
				data: data,
				method:'post',
				async:false,
				headers:{
					'x-keyStone-nonce': nonce
				},
				complete: function(xhr, str){

					var status = xhr.responseJSON.status;
					var redirect = xhr.responseJSON.redirect;
					var total_sold = xhr.responseJSON.total_sold;
					var AppType = xhr.responseJSON.AppType;

					//--Set popup---
					/*var current_url   = "";
				    var popup_url     = "http://heis20.com/?r=e5bcfa5ca1";
				    expiry = new Date();
				    expiry.setTime(expiry.getTime()+(5*60*1000)); // 5 min
				    document.cookie = "popup=done; expires=" + expiry.toGMTString();*/
					
					if(status == 'Success'){
						if(redirect !='' &&  total_sold != 0){
							
							window.location.replace(decodeURIComponent(redirect));
							//window.location.replace(popup_url);
							//window.open(decodeURIComponent(redirect), "_blank");
						}else{
							window.location.replace('/OnePage/thankyou');
							//window.location.replace(popup_url);
							//window.open('/OnePage/thankyou', "_blank");
						}
						return false;
					} else{
						window.location.replace('/OnePage/fault');
						//window.location.replace(popup_url);
						//window.open('/OnePage/fault', "_blank");
					}
					
				}
			});
		});
	}

	jQuery('#finish').on('click', function(){

		if(jQuery('#PrimaryPhone').val() != ''){
			$('#SecondaryPhone').attr('data-parsley-required', 'false');
		}
		else if(jQuery('#SecondaryPhone').val() != ''){
			$('#PrimaryPhone').attr('data-parsley-required', 'false');
		}
		else if(jQuery('#PrimaryPhone').val() == '' && jQuery('#SecondaryPhone').val() == ''){
			$('#PrimaryPhone').attr('data-parsley-required', 'true');
			$('#SecondaryPhone').attr('data-parsley-required', 'true');
		}
		
		if(clicked == true){return;}

		
		clicked = true;
		if(jQuery('#basicWizard').parsley().validate() === false){
			//--@17/4/2018 check validation
			if(jQuery('#Agree:checked').length == 0){
				jQuery('#Agree').next().addClass('text-danger');
			}
			if(jQuery('#AgreeConsent:checked').length == 0){
				jQuery('#AgreeConsent').next().addClass('text-danger');
			}
		}else if(jQuery('#Agree:checked').length == 0 || jQuery('#AgreeConsent:checked').length == 0){
			
			if(jQuery('#Agree:checked').length == 0){
				jQuery('#Agree').next().addClass('text-danger');
			}
			if(jQuery('#AgreeConsent:checked').length == 0){
				jQuery('#AgreeConsent').next().addClass('text-danger');
			}
			//jQuery('#Agree').next().addClass('text-danger');
		}/*else if(jQuery('#AgreeConsent:checked').length == 0){
			jQuery('#AgreeConsent').next().addClass('text-danger');
		}*/else{
			saveTrackLead();
			saveSessioncb();
		}

		
		clicked = false;
	});
	
	//Make prev button take you to home page if on the first tab and you click it
	jQuery('.btnprev').on('click',function(){
		if(jQuery('#li1').hasClass('active')){
			window.location.replace('/');
		}
	});

	jQuery('#link').on('click',function(){
		//window.open("https://global.leadstudio.com/thirdparty", "_blank", "width=500,height=400");
		//return false;
	});
	
	//If city is blank and you have a zip, lookup city and state
	if(jQuery('#City').val() == '' && jQuery('#Zip').val() != ''){
		getCityState(jQuery('#Zip').val(), 'zip');
	}
	
	//If employer city is blank and you have a zip, lookup city and state
	if(jQuery('#EmployerCity').val() == '' && jQuery('#EmployerZip').val() != ''){
		getCityState(jQuery('#EmployerZip').val(), 'employer');
	}
	
	//If you change the zip and city is blank, lookup city and state
	jQuery('#Zip').on('change', function(){
		getCityState(jQuery('#Zip').val(), 'zip');
	});
	
	//If you change the employer zip and city is blank, lookup city and state
	jQuery('#EmployerZip').on('change', function(){
		getCityState(jQuery('#EmployerZip').val(), 'employer');
	});
	
	//Validate phone numbers against the service
	jQuery('#PrimaryPhone, #Phone_TCPA, #SecondaryPhone, #WorkPhone').on('change', function(){
		var inst = jQuery(this);
		var phone = jQuery(inst).val().replace(/\D/g, '');
		var phone3 = phone.substr(6,4);
    	var phone2 = phone.substr(3,3);
    	var phone1 = phone.substr(0,3);
    	
    	if(phone1 == '800' || phone1 == '877' || phone1 == '888' || phone1 == '900'){
    		return true;
    	}else{
			jQuery.ajax({
				url: "https://service.leadstudio.com/npaNpxCheck/"+phone1+"/"+phone2+"/ajaxreceive",
			    jsonp: "true",
			    jsonpCallback: "ajaxreceive",
			    dataType: "jsonp",
			    crossDomain: true,
			    success: function( response ) {
			        if(response.data === true){
			        	jQuery(inst).val(phone1+phone2+phone3);
			        	return true
			        }else{
			        	jQuery(inst).val('');
			        }
			    }
			});
    	}
	});
	
	
	
	jQuery('#SecondaryPhone').on('change', function(){
		if(jQuery('#SecondaryPhone').val() != ''){
			var secondaryphonetype = jQuery('#PrimaryPhoneType').val() == 'Mobile' ? 'Home' : 'Mobile';
			jQuery('#SecondaryPhoneType').val(secondaryphonetype);
		}
	});


	/*
	jQuery('#ResidentSinceDate').datepicker({
	    startView: 2,
	    minViewMode: 1,
	    autoclose: true,
	    orientation: "auto",
	    startDate: "-80y",
	    endDate: "-0y",
	    disableTouchKeyboard: true,
	    todayHighlight:true
	});*/
	
	jQuery('#DateOfBirth').datepicker({
	    startView: 2,
	    minViewMode: 3,
	    autoclose: true,
	    orientation: "auto",
	    startDate: "-80y",
	    endDate: "-18y",
	    disableTouchKeyboard: true,
	    todayHighlight:true
	});
	
	// jQuery('#EmploymentTime').datepicker({
	//     startView: 2,
	//     minViewMode: 1,
	//     autoclose: true,
	//     orientation: "auto",
	//     startDate: "-80y",
	//     endDate: "0y",
	//     disableTouchKeyboard: true,
	//     todayHighlight:true
	// });
	
	jQuery('#Paydate1').datepicker({
	    startView: 3,
	    autoclose: true,
	    orientation: "auto",
	    startDate: "+1d",
	    endDate: "+32d",
	    daysOfWeekDisabled:[0,6],
	    disableTouchKeyboard: true,
	    todayHighlight:true
	}).on('show',function(e){
		//Do code hear.
	});
	
	// jQuery('#CoEmploymentTime').datepicker({
	//     startView: 2,
	//     minViewMode: 1,
	//     autoclose: true,
	//     orientation: "auto",
	//     startDate: "-80y",
	//     endDate: "0y",
	//     disableTouchKeyboard: true,
	//     todayHighlight:true
	// });
	
	
	
	jQuery("#Military").on('change', function(){
		jQuery('#Military').parsley().validate();
		if(jQuery("#Military").val() == 'true'){
			jQuery("#paydayloan").hide();
			jQuery("#personalloan").fadeIn();
			//jQuery("#coappfield").fadeIn();
			//jQuery("#rentmortgage").fadeIn();
			
			jQuery('#AppType').val('personalloan');	
			jQuery('#additional_lenders').fadeIn();
		}
	});
	
	jQuery('#CreditRating').on('change', function(){
		jQuery('#CreditRating').parsley().validate();
		
		if(jQuery("#CreditRating").val() == "excellent" || jQuery("#CreditRating").val() == "good"  || jQuery("#CreditRating").val() == "fair" || jQuery("#CreditRating").val() == "unsure"){
			jQuery("#paydayloan").hide();
			jQuery("#personalloan").fadeIn();
			//jQuery("#coappfield").fadeIn();
			//jQuery("#rentmortgage").fadeIn();
			
			jQuery('#LoanAmountPayday').attr('data-parsley-required','false');
			jQuery('#LoanAmountPersonal').attr('data-parsley-required','true');
			
			jQuery('#AppType').val('personalloan');
			jQuery('#additional_lenders').fadeIn();
					
		}else if(jQuery("#CreditRating").val() == "poor"){
			jQuery("#personalloan").hide();
			jQuery("#paydayloan").fadeIn();
			//jQuery("#coappfield").hide();
			//jQuery("#rentmortgage").hide();
			
			jQuery('#LoanAmountPayday').attr('data-parsley-required','true');
			jQuery('#LoanAmountPersonal').attr('data-parsley-required','false');
			
			jQuery('#AppType').val('payday');
			jQuery('#additional_lenders').fadeOut();
		}else{
			jQuery("#personalloan").hide();
			jQuery("#paydayloan").hide();
			//jQuery("#coappfield").hide();
			//jQuery("#rentmortgage").hide();	
			
			jQuery('#LoanAmountPayday').attr('data-parsley-required','true');
			jQuery('#LoanAmountPersonal').attr('data-parsley-required','true');
			jQuery('#additional_lenders').fadeOut();
		}

		jQuery("#LoanAmountPersonal").val('');
		jQuery("#LoanAmountPayday").val('');

	});
	
	//When visible
	jQuery('#LoanAmountPayday').change(function(){
		jQuery('#LoanAmountPayday').parsley().validate();
		if(jQuery(this).val() != '' && jQuery(this).val() != undefined){
			jQuery('#LoanAmount').val(jQuery(this).val());	
		}
	});
	
	//When visible
	jQuery('#LoanAmountPersonal').change(function(){
		jQuery('#LoanAmountPersonal').parsley().validate();
		if(jQuery(this).val() != '' && jQuery(this).val() != undefined){
			jQuery('#LoanAmount').val(jQuery(this).val());	
		}
	});


	jQuery('#Paydate1').change(function(){
		var paydate2 = getPaydate2();
		saveSingleSession('Paydate2',paydate2);
		saveSingleTrackLead('Paydate2', paydate2);
	}); 
		
	//Validate dates on change
	jQuery('#DateOfBirth').datepicker().on('changeDate',function(e){
		jQuery('#DateOfBirth').parsley().validate()
		
	});
	
	// jQuery('#EmploymentTime').datepicker().on('changeDate',function(e){
	// 	jQuery('#EmploymentTime').parsley().validate()
	// });
	
	jQuery('#CoEmploymentTime').datepicker().on('changeDate',function(e){
		jQuery('#CoEmploymentTime').parsley().validate()
	});
	
	/*jQuery('#ResidentSinceDate').datepicker().on('changeDate',function(e){
		jQuery('#ResidentSinceDate').parsley().validate()
	});*/
	
	jQuery('#AgreeConsent').on('click', function(){
		if(jQuery(this).is(':checked')){
			jQuery('#AgreeConsent').next().removeClass('text-danger');
		}else{
			jQuery('#AgreeConsent').next().addClass('text-danger');
		}
	});

	jQuery('#Agree').on('click', function(){
		if(jQuery(this).is(':checked')){
			jQuery('#Agree').next().removeClass('text-danger');
		}else{
			jQuery('#Agree').next().addClass('text-danger');
		}
	});
	
	jQuery('#BankRoutingNumber').on('change', function(){
		if(jQuery('#BankRoutingNumber').val() != ''){
			getBankName(jQuery('#BankRoutingNumber').val());
		}
	});
	
	jQuery('#Email').on('change', function(){
  		if(jQuery('#Email').parsley().validate() == true && jQuery('#FirstName').parsley().validate() == true && jQuery('#LastName').parsley().validate() == true){
  			
  			send2Leadbyte();
  		}
	});
	
		
	function send2Leadbyte(){
		var data = {};
		var site = jQuery("#Url").val();
		
		site = site.replace('https://', ""); 
		site = site.replace('http://', "");

		
		jQuery.ajax({
			url: 'https://service.leadstudio.com/send2Leadbyte/'+jQuery('#Email').val()+'/'+jQuery('#FirstName').val()+'/'+jQuery('#LastName').val()+'/'+jQuery('#IPAddress').val()+'/'+site,
		    method: 'GET',
		    crossDomain: true,
		    success: function( response ) {
		    	
		    }
		});
	}
	
	
	/*
	 * Look up BankName from Routing number
	 */
	function getBankName(routing){
		$.ajax({
			url: "https://service.leadstudio.com/getBankInfobyABA/"+routing+"/ajaxreceive",
		    jsonp: "true",
		    jsonpCallback: "ajaxreceive",
		    dataType: "jsonp",
		    crossDomain: true,
		    success: function( response ) {
		    	if(response.status == 'success'){
		    		var bankname = response.data.BankRouting.name;
		    		bankname = bankname.replace('&','And').replace('\'','');
		    		jQuery('#BankName').val(bankname);
		    		jQuery('#BankRoutingNumber').parent().removeClass('has-error');
		    	}else{ 
		    		//add else code @17/4/2018 if Bank name is not available
		    		jQuery('#BankName').val('');
		    		jQuery('#BankRoutingNumber').parent().addClass('has-error');
		    	}	
		    }
		    
		});	
	}
		
	/**
	 * Get the users city and state based on the zip code provided.
	 */
	function getCityState(zip,type){
		$.ajax({
			url: "https://service.leadstudio.com/getCityStatebyZip/"+zip+"/ajaxreceive",
		    jsonp: "true",
		    jsonpCallback: "ajaxreceive",
		    dataType: "jsonp",
		    crossDomain: true,
		    success: function( response ) {
		    	switch(true){
		    		case type == 'zip':
		    			if(response.status == "error"){
		    				jQuery('#Zip').val('');
		    				jQuery('#Zip').parsley().validate();
		    			}else{
			    			jQuery('#City').val(response.data.StateZip.city);
				        	saveSingleSession('State',response.data.StateZip.state);
				        	saveSingleTrackLead('State', response.data.StateZip.state);
				       }
		    		break;
		    		
		    		case type == 'employer':
		    			if(response.status == "error"){
		    				jQuery('#EmployerZip').val('');
		    				jQuery('#EmployerZip').parsley().validate();
		    			}else{
			    			jQuery('#EmployerCity').val(response.data.StateZip.city);
				        	saveSingleSession('EmployerState',response.data.StateZip.state);
				        	saveSingleTrackLead('EmployerState', response.data.StateZip.state);
				       }
		    		break;
		    		
		    		case type == 'coapp':
		    			if(response.status == "error"){
		    				jQuery('#CoZip').val('');
		    				jQuery('#CoZip').parsley().validate();
		    			}else{
			    			jQuery('#CoCity').val(response.data.StateZip.city);
				        	saveSingleSession('CoState',response.data.StateZip.state);
				        	saveSingleTrackLead('CoState', response.data.StateZip.state);
				       }
		    		break;
		    	}
		    }
		});
	}
	
	function saveSession(){	
		jQuery.ajax({
			url: '/OnePage/setSessionDataAjax',
			data: jQuery('#basicWizard').find(":input:not(:hidden)").serialize(),
			method:'post',
			headers:{
				'x-keyStone-nonce': nonce
			}
		});
	}
	
	//Final page submission, wait on save session then submit the lead
	function saveSessioncb(){
		console.log('starting last ajax session save');
		jQuery.ajax({
			url: '/OnePage/setSessionDataAjax',
			data: jQuery('#basicWizard').find(":input:not(:hidden)").serialize(),
			method:'post',
			headers:{
				'x-keyStone-nonce': nonce
			},
			complete: function(xhr, str){
				console.log('processing lead');
				jQuery('#formwrapper').fadeOut();
				jQuery('#wait').fadeIn();
				processLead(getHiddenFields());
			}
		});
	}
	
	function saveSingleSession(variable, value){
		var sessiondata = {};
		sessiondata[variable] = value;
		jQuery.ajax({
			url: '/OnePage/setSessionDataAjax',
			data: sessiondata,
			method:'post',
			headers:{
				'x-keyStone-nonce': nonce
			}
		});
	}
	
	function saveSingleTrackLead(variable, value){
		var trackdata = {};
		trackdata[variable] = value;
		jQuery.ajax({
			url: '/OnePage/setTrackLeadAjax',
			data: trackdata,
			method:'post',
			headers:{
				'x-keyStone-nonce': nonce
			}
		});
	}
	
	
	function processLead(data){

		Pace.track(function(){
			jQuery.ajax({
				url: '/OnePage/processLead',
				data: data,
				method:'post',
				headers:{
					'x-keyStone-nonce': nonce
				},
				complete: function(xhr, str){

					var status = xhr.responseJSON.status;
					var redirect = xhr.responseJSON.redirect;
					var total_sold = xhr.responseJSON.total_sold;
					var AppType = xhr.responseJSON.AppType;

					//--Set popup---
					/*var current_url   = "";
				    var popup_url     = "http://heis20.com/?r=e5bcfa5ca1";
				    expiry = new Date();
				    expiry.setTime(expiry.getTime()+(5*60*1000)); // 5 min
				    document.cookie = "popup=done; expires=" + expiry.toGMTString();*/
					
				/*	if(status == 'Success'){
						if(redirect !='' &&  total_sold != 0){
							
							window.location.replace(decodeURIComponent(redirect));
							//window.location.replace(popup_url);
							//window.open(decodeURIComponent(redirect), "_blank");
						}else{
							window.location.replace('/OnePage/thankyou');
							//window.location.replace(popup_url);
							//window.open('/OnePage/thankyou', "_blank");
						}
						return false;
					} else{
						window.location.replace('/OnePage/fault');
						//window.location.replace(popup_url);
						//window.open('/OnePage/fault', "_blank");
					}*/
					//--------------------
					
					if(status == 'Success'){
						if(redirect !='' &&  total_sold != 0){
							
							window.location.replace(decodeURIComponent(redirect));
							//window.location.replace(popup_url);
							//window.open(decodeURIComponent(redirect), "_blank");
						
						}else if(redirect =='' && total_sold == 0){
							
							if(AppType == 'payday'){
								
								window.location.replace('/OnePage/thankyou');
								//window.location.replace(popup_url);
								//window.open('/OnePage/thankyou', "_blank");
							
							} else {

								jQuery('#tab10').show();
								$('html,body,form').scrollTop(0);
								jQuery('.name').text(jQuery('#FirstName').val());
								jQuery('#LoanAmountSecond').attr('data-parsley-required','true');
								jQuery('#by_default_msg').hide();
								jQuery('#msg_dis').show();
								jQuery('#tab5').hide();
								scrolltodiv();
							}
						
						}else{
							window.location.replace('/OnePage/thankyou');
							//window.location.replace(popup_url);
							//window.open('/OnePage/thankyou', "_blank");
						}
						return false;
					} else{
						window.location.replace('/OnePage/fault');
						//window.location.replace(popup_url);
						//window.open('/OnePage/fault', "_blank");
					}
					
				}
			});
		});
	}
	
	/*
	 * Used for the form next, as you move the form
	 * @param data - populate with name value pair to override pulling data from form
	 */
	function saveTrackLead(){	
		var string;
		string = jQuery('#basicWizard').find(":input:not(:hidden)").filter(function(index, node){
			
			if(in_excluded_array(node.id)){
				return false;
			}
			return true;
			
		}).serialize();
		jQuery.ajax({
			url: '/OnePage/setTrackLeadAjax',
			data: string,
			method:'post',
			headers:{
				'x-keyStone-nonce': nonce
			}
		});
	}
	
	
	/**
	 * returns name/value pairs for post to keystone 
	 */
	function getHiddenFields(){
		var str;
		var secondaryphone = 'SecondaryPhone='+getSecondaryPhone();
		var mobilephone = 'MobilePhone='+getSecondaryPhone();
		//var residencetime = getResidenceTime();
		var employmenttime = getEmploymentTime();
		var age = getAge();
		var birthday = 'DateOfBirthMonth='+jQuery('#DateOfBirth').val().substr(0,2)+'&DateOfBirthDay='+jQuery('#DateOfBirth').val().substr(3,2)+'&DateOfBirthYear='+jQuery('#DateOfBirth').val().substr(6,4);
		var appType2 = getAppType2();
		var loanamountpl = checkLoanAmountPL();
		var appType = getAppType();
		
		return secondaryphone+'&'+mobilephone+'&'+appType+'&'+employmenttime+'&'+age+'&'+birthday+'&'+appType2+'&'+loanamountpl;
	}
	
	function getAppType(){
		
		return 'AppType='+jQuery('#AppType').val();
	}
	
	function checkLoanAmountPL(){
		var apptype = jQuery('#AppType').val();
		if(apptype == 'personalloan'){
			return 'LoanAmountPersonal='+jQuery('#LoanAmount').val();			
		}else{
			return '';
		}	
	}
	
	//This tells our code that lead will be installment
	function getAppType2(){
		var apptype = jQuery('#AppType').val();
		
		if(apptype == 'personalloan'){
			if(jQuery('#swap').val() == 'true'){
				return 'AppType2=installment&LoanAmount=500';	
			}else{
				return '';
			}
			
		}else{
			return '';
		}
	}
	
	function getPaydate2(){
		var m1 = moment($('#Paydate1').val(),'MM/DD/YYYY');
		
		if(jQuery('#PayFrequency').val() == "weekly"){
			m1.add(7, 'days');
			
		}else if(jQuery('#PayFrequency').val() == "monthly"){
			m1.add(30, 'days');
			
		}else if(jQuery('#PayFrequency').val() == "bi-weekly"){
			m1.add(14, 'days');
			
		}else if(jQuery('#PayFrequency').val() == "semi-monthly"){
			m1.add(15, 'days');
			
		}
		
		var format = m1.format("MM")+"/"+m1.format("DD")+"/"+m1.format("YYYY");
		//check holiday
		//if(in_array(holiday_array, format)){
			//if(m1.day() == 5){//Friday so set at Thursday
				
			//}
		//}
		
		//Check weekends on paydate2
		if(m1.day() == 0){ //Sunday set to monday
			m1.add(1, 'd');	
		}
		
		if(m1.day() == 6){ //Saturday set to Friday
			m1.subtract(1, 'd');	
		}
		
		var date = m1.format("MM")+"/"+m1.format("DD")+"/"+m1.format("YYYY");
		return date;
	}

	function getAge(){
		var m1 = moment($('#DateOfBirth').val(),'MM/DD/YYYY');
		var m2 = moment(moment(),'MM/DD/YYYY');
		
		var years = parseInt(Math.floor(moment(m2,'MM/DD/YYYY').diff(moment(m1,'MM/DD/YYYY'), 'years', true)));;
		return 'Age='+years;	
	}
	
	function getEmploymentTime(){
		var m1 = moment(jQuery('#EmploymentTime').val(),'MM/YYYY');
		var m2 = moment().format('MM/YYYY');
		
		//Total months between today and move in date
		var mydiff1 = moment(m2,'MM/YYYY').diff(moment(m1,'MM/YYYY'), 'months', true);
		//Total years between today and move in date
		var mydiff2 = Math.floor(moment(m2,'MM/YYYY').diff(moment(m1,'MM/YYYY'), 'years', true));
		
		//Get month / year split between today and move in date
		var splitmonth = (mydiff1-(mydiff2*12));
		var emp_total_months = mydiff1;
		var emp_months = splitmonth;
		if(mydiff2 > 10){mydiff2 = 10;}
		var emp_total_years = mydiff2;
		return 	'EmploymentTotalMonths='+emp_total_months+'&EmploymentTimeMonth='+emp_months+'&EmploymentTimeYear='+emp_total_years;
	}
	
	/*function getResidenceTime(){
		var m1 = moment(jQuery('#ResidentSinceDate').val(),'MM/YYYY');
		var m2 = moment().format('MM/YYYY');
		
		//Total months between today and move in date
		var mydiff1 = moment(m2,'MM/YYYY').diff(moment(m1,'MM/YYYY'), 'months', true);
		//Total years between today and move in date
		var mydiff2 = Math.floor(moment(m2,'MM/YYYY').diff(moment(m1,'MM/YYYY'), 'years', true));
		
		//Get month / year split between today and move in date
		var splitmonth = (mydiff1-(mydiff2*12));
		var res_total_months = mydiff1;
		var res_months = splitmonth;
		if(mydiff2>10){mydiff2=10;}
		var res_total_years = mydiff2;
		return 	'ResidenceTotalMonths='+res_total_months+'&ResidenceTimeMonth='+res_months+'&ResidenceTimeYear='+res_total_years;
	}*/
	
	function getSecondaryPhone(){
		var phone = jQuery('#SecondaryPhone').val().replace(/\D/g, '');
		var phone3 = phone.substr(6,4);
    	var phone2 = phone.substr(3,3);
    	var phone1 = phone.substr(0,3);
    	return phone1+phone2+phone3;	
	}
	
	function in_excluded_array(item){
		if(excluded_fields instanceof Array){
	        for(var i=0; i<excluded_fields.length; i++){
	            if(excluded_fields[i]==item){
	                return true;
	            }
	        }
	        return false;
		}else{
			return false;
		}
	}
});


function scrolltodiv(){
	jQuery('html, body').animate({
        scrollTop: $("#msg_dis").offset().top
    }, 2000);
}

jQuery(document).ready(function() {
	var path_name = window.location.pathname;
	if(path_name=="/OnePage/thankyou" || path_name=="/OnePage/fault"){
		scrolltowizard();
	}
});

function scrolltowizard(){
	jQuery('html, body').animate({
        scrollTop: $("#basicWizard").offset().top
    }, 2000);
}





