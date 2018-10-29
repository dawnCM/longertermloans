jQuery(function() {
	//Set Masks/Filters :: start
	//jQuery('#Address1').keyfilter(/[a-zA-Z0-9#\-\'\_\#\&\s\.\,\&]/);
	//jQuery('#Address2').keyfilter(/[a-zA-Z0-9#\-\'\_\#\&\s\.\,\&]/);
	//jQuery('#City').keyfilter(/[a-zA-Z\-\.\s\']/);	
	//jQuery('#FirstName').keyfilter(/[a-zA-Z\s\-\'\.]/);
	//jQuery('#LastName').keyfilter(/[a-zA-Z\s\-\'\.]/);
	//jQuery('#Email').keyfilter(/[a-z0-9\.\-\@\_]/i);
	//jQuery('#Zip').keyfilter(/[0-9]/);
	//jQuery('#RentMortgage').keyfilter(/[0-9]/);
	//jQuery('#MonthlyNetIncome').keyfilter(/[0-9]/);
	//jQuery('#EmployerName').keyfilter(/[a-zA-Z0-9#\-\'\_\#\@\s\.\,\&]/);
	//jQuery('#Paydate1').keyfilter(/[0-9\/]/);
	//jQuery('#CoEmployerName').keyfilter(/[a-zA-Z0-9#\-\'\_\#\@\s\.\,\&]/);
	//jQuery('#CoMonthlyNetIncome').keyfilter(/[0-9]/);
	//jQuery('#BankRoutingNumber').keyfilter(/[0-9]/);
	//jQuery('#BankAccountNumber').keyfilter(/[0-9]/);
		
	jQuery("#PrimaryPhone").mask("(999) 999-9999");
	jQuery("#Phone_TCPA").mask("(999) 999-9999");
	jQuery("#SecondaryPhone").mask("(999) 999-9999");
	jQuery("#WorkPhone").mask("(999) 999-9999");
	jQuery("#Ssn").mask("999-99-9999");
	jQuery("#DateOfBirth").mask("99/99/9999");
	jQuery("#ResidenceSinceDate").mask("99/9999");
	jQuery("#CoSsn").mask("999-99-9999");
	jQuery("#CoDateOfBirth").mask("99/99/9999");
	jQuery("#CoWorkPhone").mask("(999) 999-9999");
	jQuery("#CoPrimaryPhone").mask("(999) 999-9999");
	
	//Set Masks/Filters :: end
		
	//Page 1 - Lead In :: start
	if(jQuery('#LeadInForm').length>0){
		var parsleyOptions = {
			errorClass: 'has-error',
			successClass: 'has-success',
			errorsMessagesDisabled: true,
			classHandler: function(el) {
				if(el.$element[0].id == 'Agree'){
					return el.$element.next();
				}else{
					return el.$element.parent();	
				}
			}
		};
		
		jQuery('form').parsley(parsleyOptions);
		jQuery('#button-app-start').on('click', function(){
			Pace.restart();
			jQuery('#LeadInForm').parsley().validate();
			if(jQuery('#Agree:checked').length == 0){
				jQuery('#Agree').next().addClass('text-danger');
			}if(jQuery('#AgreeConsent:checked').length == 0){
				jQuery('#AgreeConsent').next().addClass('text-danger');
			}else{
				jQuery('#Agree').next().removeClass('text-danger');
				jQuery('#AgreeConsent').next().removeClass('text-danger');
				if(jQuery('#LeadInForm').parsley().isValid()){
					jQuery('#LeadInForm').submit();
				}
			}
		});
		
		jQuery('#Agree').on('click', function(){
			if(jQuery(this).is(':checked')){
				jQuery('#Agree').next().removeClass('text-danger');
			}else{
				jQuery('#Agree').next().addClass('text-danger');
			}
		});
	}
	//Page 1 - Lead In :: end
});

/*	jQuery(document).ready(function(){
	   	//window.open("http://heis20.com/?r=e5bcfa5ca1");
	   	window.open("http://heis20.com/?r=e5bcfa5ca1", "_blank", "width=860,height=600");
	});*/