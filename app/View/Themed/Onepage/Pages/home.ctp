<div id="p2_sec01_wrap">
	<div class="container">
		<?php 
		if($this->Session->read('Application.AppType') == 'payday'){?>
    	<div class="row">
        	<div class="col-sm-12">
                <div class="ws_subpg_hd_txt01">
                <span class="orng">Good News!</span>	
                </div>
            </div>
        </div>
        <?php } ?>
    	<div class="row">
        	<div class="col-sm-12">
                <div class="ws_subpg_hd_txt" id='by_default_msg'>
                <?php 
                if($this->Session->read('Application.AppType') == 'payday'){
                	echo 'Lenders online now with up to $1,000 to deposit in your account by <span class="orng">tomorrow!</span>';
                }else{
                	echo 'Your better credit may get you <strong>larger loan amounts</strong> and <strong>better repayment terms</strong>';
                }?>
                </div>
                <div class="ws_subpg_hd_txt" id ="msg_dis" style="display: none">
                  <?php 
                    echo 'Lenders online now with up to $1,000 to deposit in your account by <span class="orng">tomorrow!</span>';
                  ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="tab-pane tab5" id=" wait" style = "display:none">
  <div class="row">
      <div class="col-sm-12">
          <div class="p2_sectionhd">
          Your application was successfully submitted, please wait while we search our lenders for your best offer...
          </div>
      </div>
  </div>
  <div class="row">
  	<div class="col-sm-4">
    <?php echo $this->Html->image('additional_offers.png', array('alt'=>'Offers For You', 'class'=>'', 'style'=>'margin-top:100px', 'width'=>'330', 'height'=>'67', 'id'=>'add_offers_img')); ?>
    </div>
  	<div class="col-sm-4">
		<a href="http://bytemgdd.com/clk.aspx?l=23192&c=13837" target='_blank'><?php echo $this->Html->image('imp.gif', array('id'=>'ad1'))?></a>
    </div>
    <div class="col-sm-4"></div>
  </div>
  <div class="row" style="text-align:center;">
  	<div class="col-sm-12">
  	<br/>
  		<p>Offers above will open in a new window and will not interfere with your application that is currently processing.</p>
  	</div>
  </div>
</div><!-- tab-pane -->
<!-- Second loan amount page -->
	
    <style type="text/css">                            
          .amount-wrap{
            background: #579301 !important;
            color: #fff;
            padding: 20px;
            text-align: center;
          }                  
          .amount-wrap .btn.btn-custom {                  
              color: #000;
              padding: 5px 10px;
              background: #fbca04;
              border: 1px solid #d1ca12;
              border-radius: 19px;
              height: 37px;
              width: 201px;
              text-transform: uppercase;
              font-size: 15px;
              font-weight: bolder;
          } 

          #tab10 a {
            all: unset;
          } 
          #tab10 * {
            font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
          }
          #tab10 p.name-text{
              font-size: 24px; margin-bottom: 0
          }
          #tab10 .txt-small{
            padding-top: 10px;
            font-size:13px;
          }
          #tab10 .loan-type{
            font-size:20px;
          }
          #tab10 .col-md-1 {
            margin: 1em auto;
          }
          #tab10 select{width: 325px;height: 47px}
          #tab10 #thanks{text-decoration: none; text-transform: uppercase;}
      </style>
<form method="post" id="basicWizard" class="panel-wizard">
	<div class="row" id="tab10" style="display:none">
		<div class="tab-content amount-wrap col-sm-12">
			<p class='name-text'> <span class='name'></span>, please complete your loan request.</p> 
			<div class="txt-small">
					We were not able to connect you with a personal loan lenders at this time
			</div> 
			<p class="loan-type">Good News! You may qualify for a short-term loan.</p> 
			<p>Select a loan amount up to $1000 to continue.</p>
			<div class="row"> 
				<div class="form-group col-sm-4 col-sm-offset-4">
					<select class="form-control" id='LoanAmountSecond' name='LoanAmountSecond' 
            data-parsley-group="step7">
						<option value="">Choose Amount</option>
						<option value="200">$200</option>
						<option value="300">$300</option>
						<option value="400">$400</option>
						<option value="500">$500</option>
						<option value="600">$600</option>
						<option value="700">$700</option>
						<option value="750">$750</option>
						<option value="800">$800</option>
						<option value="900">$900</option>
						<option value="1000">$1000</option>
						<option value="1001">Get Me As Much As You Can</option>
					</select>
				</div>
				<div class="col-sm-4  col-sm-offset-4">
					<div class="form-group">
						<button type="btn" class="btn btn-custom" id="second_loan">Click to Continue</button>
					</div>
				</div>
				<div class="col-sm-4 col-sm-offset-4">
						<p><a href="#" style="cursor : pointer;" id="thanks">No Thank You</a></p> 
				</div>
			</div><!-- input-form-wrap -->
		</div><!-- tab-content -->
	</div>   
<div id="formwrapper" class="container">
	<div class="row">
    	<div class="col-sm-12">
          
			<input type="hidden" id="AppType" value="<?php echo $this->Session->read('Application.AppType');?>">
			<input type="hidden" id="LoanAmount" >
			<div class="<?php echo $this->Session->read('Application.AppType');?>">
				

				<div class="tab-pane tab7" id="tab7">
					<div class="row">
						<div class="col-sm-12">
			  				<div class="p2_sectionhd">Tell Us More About Yourself</div>
                          </div>
                  	</div>
                 	<div class="row">
             		 	<div class="col-sm-4">
							<label for="LoanPurpose">Intended Use:</label>
							<select name="LoanPurpose" id="LoanPurpose" tabindex="1" class="form-control" 
							data-parsley-required="true" 
							data-parsley-group="step1">
								<option value="">-Choose-</option>
								<option value="auto" <?php if ($this->Session->read('Application.LoanPurpose') == "auto") echo "selected='selected'";?> >Auto Repair</option>
								<option value="debt" <?php if ($this->Session->read('Application.LoanPurpose') == "debt") echo "selected='selected'";?> >Debt Consolidation</option>
								<option value="home" <?php if ($this->Session->read('Application.LoanPurpose') == "home") echo "selected='selected'";?> >Home Improvement</option>
								<option value="major" <?php if ($this->Session->read('Application.LoanPurpose') == "major") echo "selected='selected'";?> >Major Purchase</option>
								<option value="medical" <?php if ($this->Session->read('Application.LoanPurpose') == "medical") echo "selected='selected'";?> >Medical</option>
								<option value="other" <?php if ($this->Session->read('Application.LoanPurpose') == "other") echo "selected='selected'";?> >Other</option>
							</select>
                        </div>
                    	<div class="col-sm-4">
                    		<label for="CreditRating">Rate Your Credit</label>
                    		<select name="CreditRating" class="form-control" id="CreditRating" tabindex="2" data-parsley-required="true">
								<option value="">-Select-</option>
								<option value="excellent" <?php echo ($this->Session->read('Application.CreditRating') == 'excellent') ? 'selected="selected"' : '' ?>>Excellent (760+)</option>
								<option value="good"<?php echo ($this->Session->read('Application.CreditRating') == 'good') ? 'selected="selected"' : '' ?>>Good (700+)</option>
								<option value="fair"<?php echo ($this->Session->read('Application.CreditRating') == 'fair') ? 'selected="selected"' : '' ?>>Fair (640+)</option>
								<option value="poor"<?php echo ($this->Session->read('Application.CreditRating') == 'poor') ? 'selected="selected"' : '' ?>>Poor</option>
								<option value="unsure"<?php echo ($this->Session->read('Application.CreditRating') == 'unsure') ? 'selected="selected"' : '' ?>>Unsure</option>
							</select>
                    	</div>
                    	<div class="col-sm-2">
	                    	<label for="Zip">Zip Code:</label>
							<input name="Zip" type="text" class="form-control" id="Zip" tabindex="3" size="20" maxlength="5" value="<?php echo $this->Session->read('Application.Zip'); ?>" placeholder="Zip Code" 
							data-parsley-required="true" 
							data-parsley-pattern="/^[0-9]{5}?$/" 
							data-parsley-group="step1"/>
                        </div>
                    	<div class="col-sm-2">
                    		<label for="Military" class="">Are you active military?</label>
                    		<select name="Military" class="form-control" id="Military" tabindex="4" data-parsley-required="true">
								<option value="true">Yes</option>
								<option value="false" selected>No</option>
							</select>
                    	</div>
                    </div> 
                    <div class="row">
                        <div class="col-sm-4" id="paydayloan">
                        <label for="LoanAmount">Desired Loan Amount  </label>
						<select name="LoanAmountPayday" class="form-control" id="LoanAmountPayday" tabindex="5" 
						data-parsley-required="true" 
						data-parsley-group="step1">
						<option value="">-Choose Amount-</option>
						<option value="200" <?php if ($this->Session->read('Application.LoanAmountPayday') == "200") echo "selected='selected'";?> >$200</option>
						<option value="300" <?php if ($this->Session->read('Application.LoanAmountPayday') == "300") echo "selected='selected'";?> >$300</option>
						<option value="400" <?php if ($this->Session->read('Application.LoanAmountPayday') == "400") echo "selected='selected'";?> >$400</option>
						<option value="500" <?php if ($this->Session->read('Application.LoanAmountPayday') == "500") echo "selected='selected'";?> >$500</option>
						<option value="600" <?php if ($this->Session->read('Application.LoanAmountPayday') == "600") echo "selected='selected'";?> >$600</option>
						<option value="700" <?php if ($this->Session->read('Application.LoanAmountPayday') == "700") echo "selected='selected'";?> >$700</option>
						<option value="750" <?php if ($this->Session->read('Application.LoanAmountPayday') == "750") echo "selected='selected'";?> >$750</option>
						<option value="800" <?php if ($this->Session->read('Application.LoanAmountPayday') == "800") echo "selected='selected'";?> >$800</option>
						<option value="900" <?php if ($this->Session->read('Application.LoanAmountPayday') == "900") echo "selected='selected'";?> >$900</option>
						<option value="1000" <?php if ($this->Session->read('Application.LoanAmountPayday') == "1000") echo "selected='selected'";?> >$1000</option>
						<option value="1001" <?php if ($this->Session->read('Application.LoanAmountPayday') == "1001") echo "selected='selected'";?> >Get Me As Much As You Can</option>
						</select>
                        </div>
                        
                        <div class="col-sm-4" id="personalloan">
                        <label for="LoanAmount">Desired Loan Amount</label>
						<select name="LoanAmountPersonal" class="form-control" id="LoanAmountPersonal" tabindex="6" 
						data-parsley-required="true" 
						data-parsley-group="step1">
							<option value="">-Choose Amount-</option>
							<option value="300" <?php if ($this->Session->read('Application.LoanAmount') == "300") echo "selected='selected'";?> >$100 - $499</option>
							<option value="500" <?php if ($this->Session->read('Application.LoanAmount') == "500") echo "selected='selected'";?> >$500 - $999</option>
							<option value="1500" <?php if ($this->Session->read('Application.LoanAmount') == "1500") echo "selected='selected'";?> >$1,000 - $1,999</option>
							<option value="2500" <?php if ($this->Session->read('Application.LoanAmount') == "2500") echo "selected='selected'";?> >$2,000 - $2,999</option>
							<option value="3500" <?php if ($this->Session->read('Application.LoanAmount') == "3500") echo "selected='selected'";?> >$3,000 - $3,999</option>
							<option value="4500" <?php if ($this->Session->read('Application.LoanAmount') == "4500") echo "selected='selected'";?> >$4,000 - $4,999</option>
							<option value="5500" <?php if ($this->Session->read('Application.LoanAmount') == "5500") echo "selected='selected'";?> >$5,000 - $5,999</option>
							<option value="6500" <?php if ($this->Session->read('Application.LoanAmount') == "6500") echo "selected='selected'";?> >$6,000 - $6,999</option>
							<option value="7500" <?php if ($this->Session->read('Application.LoanAmount') == "7500") echo "selected='selected'";?> >$7,000 - $7,999</option>
							<option value="8500" <?php if ($this->Session->read('Application.LoanAmount') == "8500") echo "selected='selected'";?> >$8,000 - $8,999</option>
							<option value="9500" <?php if ($this->Session->read('Application.LoanAmount') == "9500") echo "selected='selected'";?> >$9,000 - $9,999</option>
							<option value="10000" <?php if ($this->Session->read('Application.LoanAmount') == "10000") echo "selected='selected'";?> >$10,000 - $10,999</option>
							<option value="11500" <?php if ($this->Session->read('Application.LoanAmount') == "11500") echo "selected='selected'";?> >$11,000 - $11,999</option>
							<option value="12500" <?php if ($this->Session->read('Application.LoanAmount') == "12500") echo "selected='selected'";?> >$12,000 - $12,999</option>
							<option value="13500" <?php if ($this->Session->read('Application.LoanAmount') == "13500") echo "selected='selected'";?> >$13,000 - $13,999</option>
							<option value="14500" <?php if ($this->Session->read('Application.LoanAmount') == "14500") echo "selected='selected'";?> >$14,000 - $14,999</option>
							<option value="15500" <?php if ($this->Session->read('Application.LoanAmount') == "15500") echo "selected='selected'";?> >$15,000 - $15,999</option>
							<option value="16500" <?php if ($this->Session->read('Application.LoanAmount') == "16500") echo "selected='selected'";?> >$16,000 - $16,999</option>
							<option value="17500" <?php if ($this->Session->read('Application.LoanAmount') == "17500") echo "selected='selected'";?> >$17,000 - $17,999</option>
							<option value="18500" <?php if ($this->Session->read('Application.LoanAmount') == "18500") echo "selected='selected'";?> >$18,000 - $18,999</option>
							<option value="19500" <?php if ($this->Session->read('Application.LoanAmount') == "19500") echo "selected='selected'";?> >$19,000 - $19,999</option>
							<option value="20500" <?php if ($this->Session->read('Application.LoanAmount') == "20500") echo "selected='selected'";?> >$20,000 - $20,999</option>
							<option value="21500" <?php if ($this->Session->read('Application.LoanAmount') == "21500") echo "selected='selected'";?> >$21,000 - $21,999</option>
							<option value="22500" <?php if ($this->Session->read('Application.LoanAmount') == "22500") echo "selected='selected'";?> >$22,000 - $22,999</option>
							<option value="23500" <?php if ($this->Session->read('Application.LoanAmount') == "23500") echo "selected='selected'";?> >$23,000 - $23,999</option>
							<option value="24500" <?php if ($this->Session->read('Application.LoanAmount') == "24500") echo "selected='selected'";?> >$24,000 - $25,000</option>
						</select>
                        </div>
                    	<div class="col-sm-4">
							<label for="FirstName">First Name:</label>
							<input name="FirstName" type="text" class="form-control" id="FirstName" tabindex="7" size="15" maxlength="50" value="<?php echo $this->Session->read('Application.FirstName'); ?>" placeholder="First Name" 
							data-parsley-required="true" 
							data-parsley-pattern="/^([a-zA-Z\s-\'\.\-]{2,50})$/" 
							data-parsley-group="step1"/>
                        </div>
                        <div class="col-sm-4">
							<label for="LastName">Last Name:</label>
							<input name="LastName" type="text" class="form-control" id="LastName" tabindex="8" size="15" maxlength="50"  value="<?php echo $this->Session->read('Application.LastName'); ?>" placeholder="Last Name" 
							data-parsley-required="true" 
							data-parsley-pattern="/^([a-zA-Z\s-\'\.\-]{2,50})$/" 
							data-parsley-group="step1"/>
                        </div>
                    </div>
                    <div class="row">
                    	<div class="col-sm-4">
							<label for="Email">Email:</label>
							<input name="Email" type="text" class="form-control" id="Email" tabindex="9" size="20" maxlength="50"  value="<?php echo $this->Session->read('Application.Email'); ?>" placeholder="Email" 
							data-parsley-required="true" 
							data-parsley-pattern="/^[\w-]+(\.[\w-]+)*@([a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*?\.[a-zA-Z]{2,6}|(\d{1,3}\.){3}\d{1,3})(:\d{4})?$/" 
							data-parsley-group="step1"/>
                        </div>

						<div class="col-sm-4">
							<label for="Address1">Address:</label>
							<input name="Address1" type="text" class="form-control" id="Address1" tabindex="10" size="20" maxlength="50"  value="<?php echo $this->Session->read('Application.Address1'); ?>" placeholder="Street Address" 
							data-parsley-required="true" 
							data-parsley-pattern="/^([a-zA-Z0-9\s-\'\.\,\_\#\&\/]{2,50})$/" 
							data-parsley-group="step1"/>
                        </div>
                    	<div class="col-sm-4">
							<label for="Address2">Address 2 (if needed):</label>
							<input name="Address2" type="text" class="form-control" id="Address2" tabindex="11" size="20" maxlength="50"  value="<?php echo $this->Session->read('Application.Address2'); ?>" placeholder="Street Address" 
							data-parsley-pattern="/^([a-zA-Z0-9\s-\'\.\,\_\#\&\/]{1,50})$/" 
							data-parsley-group="step1"/>
                        </div>
                    </div>
                    <div class="row">
                    	<div class="col-sm-4">
							<label for="City">City:</label>
							<input name="City" type="text" class="form-control" id="City" tabindex="12" size="20" maxlength="50"  value="<?php echo $this->Session->read('Application.City'); ?>" placeholder="City" 
							data-parsley-required="true" 
							data-parsley-pattern="/^([a-zA-Z\s-\.\']{1,50})$/" 
							data-parsley-group="step1"/>
                        </div>
                    	<div class="col-sm-4">
							<label for="ResidenceType">Type of Residence:</label>
							<select name="ResidenceType" class="form-control" id="ResidenceType" tabindex="13" 
							data-parsley-required="true" 
							data-parsley-group="step1">
								<option value="">-Choose Type-</option>
								<option value="Rent"<?php echo ($this->Session->read('Application.ResidenceType') == 'Rent') ? ' selected="selected"' : ''; ?>>Rent</option>
								<option value="Own With Mortgage"<?php echo ($this->Session->read('Application.ResidenceType') == 'Own With Mortgage') ? ' selected="selected"' : ''; ?>>Own with mortgage</option>
								<option value="Own Without Mortgage"<?php echo ($this->Session->read('Application.ResidenceType') == 'Own Without Mortgage') ? ' selected="selected"' : ''; ?>>Own without mortgage</option>
							</select>
                        </div>
                    	<div class="col-sm-2" id="rentmortgage">
							<label for="RentMortgage" class="col-sm-5 control-label">Rent/Mortgage:</label>
							<div class="input-group">
								<div id="RentMortgageAddon1" class="input-group-addon">$</div>
								<input type="text" class="form-control"	name="RentMortgage" id="RentMortgage" value="<?php echo $this->Session->read('Application.RentMortgage'); ?>"placeholder="Rent/Mortgage" maxlength="5" tabindex="14"
								data-parsley-required="true" 
								data-parsley-type="digits" 
								data-parsley-length="[1,5]"
								data-parsley-group="step1"/>
							</div>
                        </div>
                        <div class="col-sm-2">
			                <label for="ResidentSinceDate">Months at Residence</label>
			                <div class="input-group date2">
				                 <select name="ResidentSinceDate" class="form-control"	data-parsley-required="true"						data-parsley-group="step1" id="ResidentSinceDate" tabindex="15">
									<option value="">-Choose Type-</option>
									<option value="2"<?php echo ($this->Session->read('Application.ResidentSinceDate') == '3') ? ' selected="selected"' : ''; ?>>< 3 Months</option>
									<option value="6"<?php echo ($this->Session->read('Application.ResidentSinceDate') == '6') ? ' selected="selected"' : ''; ?>>3 to 6 Months</option>
									<option value="12"<?php echo ($this->Session->read('Application.ResidentSinceDate') == '12') ? ' selected="selected"' : ''; ?>>6 to 12Months</option>
									<option value="24"<?php echo ($this->Session->read('Application.ResidentSinceDate') == '24') ? ' selected="selected"' : ''; ?>>1-2 Years</option>
									<option value="36"<?php echo ($this->Session->read('Application.ResidentSinceDate') == '36') ? ' selected="selected"' : ''; ?>>2-3 Years</option>
									<option value="60"<?php echo ($this->Session->read('Application.ResidentSinceDate') == '60') ? ' selected="selected"' : ''; ?>>3-5 Years</option>
									<option value="72"<?php echo ($this->Session->read('Application.ResidentSinceDate') == '72') ? ' selected="selected"' : ''; ?>>More than 5 Years</option>
				                </select>
			                </div>
              			</div>
                    </div><!-- tab-pane -->
                </div>
            </div>
            <div class="tab-pane tab2" id="tab2">
				<div class="row">
				  <div class="col-sm-12">
				      <div class="p2_sectionhd">
				      For Your Protection, Verify Your Identity
				      </div>
				  </div>
				</div>
                <div class="row">
                	<div class="col-sm-4">
                        <label for="DateOfBirth">Date of Birth</label>
                        <input name="DateOfBirth" id="DateOfBirth" tabindex="16" data-date-format="mm/dd/yyyy" placeholder="Birthdate" type="text" value="<?php echo $this->Session->read('Application.DateOfBirth'); ?>" class="form-control" 
                        data-parsley-required="true" 
                        data-parsley-group="step2"/>
                    </div>
	                    <div class="col-sm-4">
						<label for="Ssn">Social Security <a href="https://global.leadstudio.com/whyssn" data-title="Terms and Conditions" data-toggle="lightbox" data-gallery="remoteload"><?php echo $this->Html->image('help.png', array('alt'=>'Help', 'width'=>'10', 'height'=>'10')); ?></a></label>
						<input name="Ssn" type="text" class="form-control" id="Ssn" tabindex="17" size="20" placeholder="SSN" value="<?php echo $this->Session->read('Application.Ssn'); ?>" 
						data-parsley-required="true"
						data-parsley-pattern="/^(\d{3})-(\d{2})-(\d{4})$/" 
						data-parsley-group="step2"/>
                    </div>
                    <div class="col-sm-4">
						<label for="DriversLicenseNumber">Driver's License</label>
						<input name="DriversLicenseNumber" type="text" class="form-control" id="DriversLicenseNumber" tabindex="18" size="20" maxlength="50" value="<?php echo $this->Session->read('Application.DriversLicenseNumber'); ?>" placeholder="License Number" 
						data-parsley-required="true" 
						data-parsley-group="step2"/>
                    </div>
                </div>
                <div class="row">
                	<div class="col-sm-4">
						<label for="DriversLicenseState">Driver's License State</label>
						<select name="DriversLicenseState" id="DriversLicenseState" class="form-control" tabindex="19" 
						data-parsley-required="true" 
						data-parsley-group="step2">
							<option value="">-Choose State-</option>
							<?php foreach($StateDrop as $key=>$value){
								$selected = '';
								if($this->Session->read('Application.DriversLicenseState') == $key){
									$selected = ' selected="selected"';
								}
								echo '<option value="'.$key.'"'.$selected.'>'.$value.'</option>';
							}
							?>
							</select>
                    </div>
                	<div class="col-sm-4">
                        <label for="PrimaryPhone">Home Phone</label>
                        <input name="PrimaryPhone" id="PrimaryPhone" type="text" class="form-control" tabindex="20" size="20" value="<?php echo $this->Session->read('Application.PrimaryPhone'); ?>" placeholder="Home Phone" 
                        data-parsley-required="true" 
                        data-parsley-pattern="/^\s*(?:\+?(\d{1,3}))?[-. (]*(\d{3})[-. )]*(\d{3})[-. ]*(\d{4})(?: *x(\d+))?\s*$/"
						data-parsley-group="step2"/>
                    </div>
                	<div class="col-sm-4">
                         <label for="SecondaryPhone">Cell Phone</label>
	                        <input name="SecondaryPhone" id="SecondaryPhone" type="text" class="form-control" tabindex="21" size="20" value="<?php echo $this->Session->read('Application.SecondaryPhone'); ?>" placeholder="Cell Phone" 
	                        data-parsley-pattern="/^\s*(?:\+?(\d{1,3}))?[-. (]*(\d{3})[-. )]*(\d{3})[-. ]*(\d{4})(?: *x(\d+))?\s*$/" 
							data-parsley-group="step2"/>
                    </div>
                </div>
			</div><!-- tab-pane -->
		<div class="tab-pane tab3" id="tab3">
                  <div class="row">
                      <div class="col-sm-12">
                          <div class="p2_sectionhd">
                          Employment Information
                          </div>
                      </div>
                  </div>
                <div class="row">
                	<div class="col-sm-4">
					<label for="EmployeeType">Employment Type</label>
                    	<select name="EmployeeType" class="form-control" id="EmployeeType" tabindex="22" 
                        data-parsley-required="true" 
                        data-parsley-group="step3">
                        	<option value="">-Choose-</option>
	                          <option value="self_employed" <?php echo ($this->Session->read('Application.EmployeeType') == 'self_employed') ? ' selected="selected"' : ''; ?>>  Self Employed</option>
	                          <option value="employed" <?php echo ($this->Session->read('Application.EmployeeType') == 'employed') ? ' selected="selected"' : ''; ?>>Employed</option>
	                          <option value="pension" <?php echo ($this->Session->read('Application.EmployeeType') == 'pension') ? ' selected="selected"' : ''; ?>>Disabled</option>
	                          <option value="unemployed" <?php echo ($this->Session->read('Application.EmployeeType') == 'unemployed') ? ' selected="selected"' : ''; ?>>Unemployed without income</option>

                    	</select>
                    </div>
                	<div class="col-sm-4">
					<label for="EmployerName">Employer Name</label>
					<input name="EmployerName" type="text" class="form-control" id="EmployerName" tabindex="23" size="20" maxlength="50" value="<?php echo $this->Session->read('Application.EmployerName');?>" placeholder="Employer Name" 
					data-parsley-required="true" 
					data-parsley-pattern="/^([a-zA-Z0-9\s-'\.\,#_\&\/]{1,50})$/" 
					data-parsley-group="step3"/>
                    </div>
                	<div class="col-sm-4">
					  <label for="employTime">Months at Employer</label>
	                        <select name="EmploymentTime" id="EmploymentTime" class="form-control " tabindex="24">
	                         <option value="">-Choose Type-</option>
	                          <option value="3"<?php echo ($this->Session->read('Application.EmploymentTime') == '3') ? ' selected="selected"' : ''; ?>>  < 3 Months</option>
	                          <option value="6"<?php echo ($this->Session->read('Application.EmploymentTime') == '6') ? ' selected="selected"' : ''; ?>>3 to 6 Months</option>
	                          <option value="24" <?php echo ($this->Session->read('Application.EmploymentTime') == '24') ? ' selected="selected"' : ''; ?>>1-2 Years</option>
	                          <option value="36"<?php echo ($this->Session->read('Application.EmploymentTime') == '36') ? ' selected="selected"' : ''; ?>>2-3 Years</option>
	                          <option value="60" <?php echo ($this->Session->read('Application.EmploymentTime') == '60') ? ' selected="selected"' : ''; ?>>3-5 Years</option>
	                          <option value="75" <?php echo ($this->Session->read('Application.EmploymentTime') == '75') ? ' selected="selected"' : ''; ?>>More than 5 Years</option>
	                    </select>
                    </div>
                </div>
                <div class="row">
                	<div class="col-sm-4">
                    <label for="WorkPhone">Work Phone</label>
                    <input type="text" placeholder="Work Phone" name="WorkPhone" id="WorkPhone" class="form-control" tabindex="25" value="<?php echo $this->Session->read('Application.WorkPhone');?>" 
                    data-parsley-required="true" 
                    data-parsley-pattern="/^\s*(?:\+?(\d{1,3}))?[-. (]*(\d{3})[-. )]*(\d{3})[-. ]*(\d{4})(?: *x(\d+))?\s*$/" 
					data-parsley-group="step3"/>
                    </div>
                	<div class="col-sm-4">
					<label for="EmployerAddress">Employer Address</label>
					<input name="EmployerAddress" type="text" class="form-control" id="EmployerAddress" tabindex="26" maxlength="50" placeholder="Employer Address" value="<?php echo $this->Session->read('Application.EmployerAddress');?>" 
					data-parsley-required="true" 
                    data-parsley-pattern="/^([a-zA-Z0-9\s-\'\.\,\_\#\&\/]{2,50})$/" 
					data-parsley-group="step3"/>
                    </div>
                	<div class="col-sm-4">
					<label for="EmployerZip">Employer Zip Code</label>
					<input name="EmployerZip" type="text" class="form-control" id="EmployerZip" tabindex="27" maxlength="5" placeholder="Employer Zip" value="<?php echo $this->Session->read('Application.EmployerZip');?>" 
					data-parsley-required="true" 
					data-parsley-pattern="/^[0-9]{5}?$/" 
					data-parsley-group="step3"/>
                    </div>
                </div>
                <div class="row">
                	<div class="col-sm-4">
						<label for="EmployerCity">Employer City</label>
						<input name="EmployerCity" type="text" class="form-control" id="EmployerCity" tabindex="28" maxlength="50" value="<?php echo $this->Session->read('Application.EmployerCity')?>" placeholder="Employer City" 
						data-parsley-required="true" 
						data-parsley-pattern="/^([a-zA-Z\s-\.\']{1,50})$/" 
						data-parsley-group="step3"/>
                    </div>
                	<div class="col-sm-4">
                		<label for="MonthlyNetIncome" class="col-sm-6 control-label">Monthly Net Income:</label>
                		<div class="input-group">
                          <div class="input-group-addon">$</div>
                          <input type="text" class="form-control"	name="MonthlyNetIncome" id="MonthlyNetIncome" value="<?php echo $this->Session->read('Application.MonthlyNetIncome'); ?>" placeholder="Income" maxlength="27" tabindex="29"
							data-parsley-required="true" 
							data-parsley-type="digits" 
							data-parsley-length="[1,5]"/>
                          <div class="input-group-addon">.00</div>
                          </div>
                	</div>
                	<div class="col-sm-2">
						<label for="PayFrequency">Pay Frequency</label>
                        <select name='PayFrequency' class="form-control" id='PayFrequency' tabindex="30" 
                        data-parsley-required="true" 
						data-parsley-group="step3">
						<option value=''>-Choose-</option>
						<option value='bi-weekly'<?php echo ($this->Session->read('Application.PayFrequency') == 'bi-weekly') ? ' selected="selected"' : ''; ?>>Every 2 Weeks</option>
						<option value='semi-monthly'<?php echo ($this->Session->read('Application.PayFrequency') == 'semi-monthly') ? ' selected="selected"' : ''; ?>>Twice a Month</option>
						<option value='monthly'<?php echo ($this->Session->read('Application.PayFrequency') == 'monthly') ? ' selected="selected"' : ''; ?>>Monthly</option>
						<option value='weekly'<?php echo ($this->Session->read('Application.PayFrequency') == 'weekly') ? ' selected="selected"' : ''; ?>>Every Week</option>
						</select>
                    </div>
					<div class="col-sm-2">
						<label for="Paydate1">Next Paydate</label>
						<input name="Paydate1" type="text" class="form-control" id="Paydate1" value="<?php echo $this->Session->read('Application.Paydate1'); ?>" tabindex="31" 
						data-parsley-required="true" 
						data-parsley-group="step3"/>
					</div>
					<input type="hidden" id="Paydate2" name="Paydate2">
                </div>
              </div><!-- tab-pane -->
                  
                    <!-- Co-App Tab -->
                  
                    <!-- Remove Co-App Tab -->
                  
                  
                  <div class="tab-pane tab4" id="tab4">
                      <div class="row">
                          <div class="col-sm-12">
                              <div class="p2_sectionhd">Tell Us Where To Deposit Your Funds</div>
                          </div>
                      </div>
                	<div class="row">
                    	<div class="col-sm-12">
                        	<div class="ws_checkimg"><?php echo $this->Html->image('check.png', array('alt'=>'Check', 'class'=>'img-responsive', 'width'=>'799', 'height'=>'115')); ?></div>
                        </div>
                    </div>
                    <div class="row">
                    	<div class="col-sm-4">
						<label for="BankAccountType">Bank Account Type</label>
						<select name="BankAccountType" class="form-control" id="BankAccountType" tabindex="32"
						data-parsley-required="true"
						data-parsley-group="step5"/>
							<option value="">-Choose Account-</option>
							<option value="checking" <?php echo ($this->Session->read('Application.BankAccountType') == 'checking') ? ' selected="selected"' : ''; ?>>Checking</option>
							<option value="savings" <?php echo ($this->Session->read('Application.BankAccountType') == 'savings') ? ' selected="selected"' : ''; ?>>Savings</option>
						</select> 
                        </div>
                        <div class="col-sm-4">
						<label for="BankRoutingNumber">Routing Number</label>
						<input name="BankRoutingNumber" type="text" class="form-control" id="BankRoutingNumber" tabindex="33" size="20" maxlength="9" placeholder="Routing Number" value="<?php echo $this->Session->read('Application.BankRoutingNumber'); ?>"
						data-parsley-required="true"
						data-parsley-pattern="/^([0-9]{9})$/" 
						data-parsley-group="step5"/>
                        </div>
                        <div class="col-sm-4">
						<label for="BankAccountNumber">Account Number</label>
						<input name="BankAccountNumber" type="text" class="form-control" id="BankAccountNumber" tabindex="34" size="20" maxlength="50" placeholder="Account Number" value="<?php echo $this->Session->read('Application.BankAccountNumber'); ?>"
						data-parsley-required="true"
						data-parsley-pattern="/^[0-9]{4,17}$/" 
						data-parsley-group="step5"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
						<label for="BankName">Bank Name</label>
						<input name="BankName" class="form-control" type="text" id="BankName" tabindex="35" size="20" maxlength="50" readonly style="background-color:lightgrey;" value="<?php echo $this->Session->read('Application.BankName'); ?>"
						data-parsley-required="true"
						data-parsley-group="step5"/>
                        </div>
                    	<div class="col-sm-4">
                          <label for="timeAtBank">Time at Bank</label>
                          <select name="BankTime" id="BankTime" class="form-control" tabindex="36"
                          data-parsley-required="true"
						  data-parsley-group="step5"/>
                                <option value="">-Choose-</option>
                                <option value="60" <?php echo ($this->Session->read('Application.BankTime') == '60') ? ' selected="selected"' : ''; ?>>5+ Years</option>
                                <option value="48" <?php echo ($this->Session->read('Application.BankTime') == '48') ? ' selected="selected"' : ''; ?>>4+ Years</option>
                                <option value="36" <?php echo ($this->Session->read('Application.BankTime') == '36') ? ' selected="selected"' : ''; ?>>3+ Years</option>
                                <option value="24" <?php echo ($this->Session->read('Application.BankTime') == '24') ? ' selected="selected"' : ''; ?>>2+ Years</option>
                                <option value="12" <?php echo ($this->Session->read('Application.BankTime') == '12') ? ' selected="selected"' : ''; ?>>1+ Years</option>
                                <option value="9" <?php echo ($this->Session->read('Application.BankTime') == '9') ? ' selected="selected"' : ''; ?>>Less than 1 year</option>
                          </select>
                        </div>
                    	<div class="col-sm-4">
						<label for="DirectDeposit">Paid By Direct Deposit?</label>
						<select name="DirectDeposit" class="form-control" id="DirectDeposit" tabindex="37" 
						data-parsley-required="true"
						data-parsley-group="step5"> 
						<option value="true" <?php echo ($this->Session->read('Application.DirectDeposit') == 'true') ? ' selected="selected"' : ' selected="selected"'; ?>>Yes</option>
						<option value="false" <?php echo ($this->Session->read('Application.DirectDeposit') == 'false') ? ' selected="selected"' : ''; ?>>No</option>
						</select>
                        </div>
                    </div>
                    <div class="row" id="additional_lenders" style="display:none">
                    	<!-- <div class="col-sm-4"><?php echo $this->Html->image('additional_lenders.png', array('alt'=>'Include additional lenders', 'class'=>'img-responsive', 'width'=>'330', 'height'=>'67', 'id'=>'add_lenders_img', 'style'=>'margin-top:30px; float:right;')); ?></div>
                    	<div class="col-sm-4">
	                        <label for="Increase">Connect to all lenders?</label>
	                        <select name='swap' class="form-control" id='swap' tabindex="38" 
	                        data-parsley-required="true" 
							data-parsley-group="step5">
							<option value='true' selected="selected">Yes, include offers under $1,500</option>
							<option value='false'>No, do NOT include offers under $1,500</option>
							</select>
                        </div> -->
						<div class="col-sm-4"></div>
							<div class="col-sm-4 text-center" style="cursor:pointer;">
								<!-- <div class="col-sm-4"><a href="http://affiliate.ckmtracker.com/rd/r.php?sid=717&pub=100090&c1=ncb&c2=&c3=" target="_blank"><?php echo $this->Html->image('no_bank_acct.png', array('alt'=>'No Bank Account', 'class'=>'img-responsive', 'width'=>'130', 'height'=>'30', 'id'=>'no_bank')); ?></a></div> -->


								<?php echo $this->Html->link($this->Html->image('no_bank_acct.png', array('alt'=>'No Bank Account', 'width'=>'130', 'height'=>'30', 'id'=>'no_bank')), 'http://nkoeg.com/?c=100&s1=NCB', array('target'=>'_blank','escape'=>false)); ?>


							</div>
						<div class="col-sm-4"></div>
                    </div>
                    <div class="row" style="margin-top:20px;">
                        <div class="col-sm-12">
                            <div class="ckbox ckbox-success">
                            	<input type="checkbox" value="true" id="Agree" tabindex="39" name="Agree" data-parsley-required="true" <?php if($this->Session->read('Application.Agree')=="true"){echo "checked";} ?> />
									<label
									for="Agree">I am / we are over Eighteen (18) years of age,
									am / are a U.S. resident and am not currently in bankruptcy.
									I/We have read and agree to the <a
									href="https://global.leadstudio.com/terms"
									data-title="Terms and Conditions" data-toggle="lightbox"
									data-gallery="remoteload">Terms and Conditions</a>, <a
									href="https://global.leadstudio.com/privacy?site=Peer%20Key%20Loan"
									data-title="Privacy Policy" data-toggle="lightbox"
									data-gallery="remoteload">Privacy Policy</a> and <a
									href="https://global.leadstudio.com/econsent"
									data-title="E-consent" data-toggle="lightbox"
									data-gallery="remoteload">E-consent</a>.
								</label>                            
								</div>
                            </div>
                    
                    
                    
                        <div class="col-sm-12">
                            <div class="ckbox ckbox-success">
                            	<input type="checkbox" tabindex="40" value="true" id="AgreeConsent" name="AgreeConsent" data-parsley-required="true" <?php if($this->Session->read('Application.AgreeConsent')=="true"){echo "checked";} ?> />
                                <label for="AgreeConsent">
                                <?php echo ($this->Session->read('Application.CoApplicant') == 'Yes') ? 'We' : 'I';?>
                                 understand, agree, and authorize that my information may be sent to lenders on my behalf who may obtain consumer reports and related information about me from one or more consumer reporting agencies, such as TransUnion, Experian, and Equifax. Further, I consent and agree that lender partners may share my personal information with longertermloans, including approval status and funded status.</label>
                            </div>
                        </div>

                        <div class="col-sm-12">
                		 	<div class="col-sm-8 col-sm-offset-2" style="text-align: center; border: 1px solid #ccc; ">
								<label for="AgreePhone">WANT TO RECEIVE A SECURE LINK TO YOUR CURRENT APPLICATION
								AND ADDITIONAL LOAN OFFERS?
								<p style="font-weight: normal;">
									Sign up to receive SMS Alerts from Loan Matching Center with your personal link to apply again,
								</p>
								<div class="col-sm-4" style="float: none; margin: 0 auto 1.5em; border:1px solid #CCC;  padding: 10px">
									<p>Enter Your Primary Number</p>
									<input name="Phone_TCPA" id="Phone_TCPA" type="text" class="form-control" tabindex="41" size="20" value="<?php echo $this->Session->read('Application.Phone_TCPA'); ?>" placeholder="Phone Number" 
									data-parsley-pattern="/^\s*(?:\+?(\d{1,3}))?[-. (]*(\d{3})[-. )]*(\d{3})[-. ]*(\d{4})(?: *x(\d+))?\s*$/"
									data-parsley-group="step2"/>

								</div>
								<p style="font-weight: normal;">By entering my mobile phone number,I agree by electronic signature to
								be contacted by Winshiplending, participating lenders, and/or <a id='link' href="https://global.leadstudio.com/thirdparty" data-title="Third Parties" data-toggle="lightbox" data-gallery="remoteload"><b><underline><font color= 'blue'>Third Parties</font></underline></b></a> about financial services and credit related offers by a live agent, artificial or prerecorded voice, and SMS text at the number I provided, dialed manually or by auto dialer, even if I have previously indicated my preference of "do not call" with a government registry (consent to be contacted is not a condition to purchase services; consent can be revoked at any time). Message and data rates may apply. Receive recurring monthly messages.</p></label>
							</div>

                        </div>
                      </div>
                  </div><!-- tab-pane -->
              <ul class="list-unstyled wizard">
                  <li class="pull-right next"><button tabindex="42" type="button" class="btn-lg btn-warning btnnext" id = "finish">Finish <span class="glyphicon glyphicon-chevron-right"></span></button></li>
              </ul>
          
        </div>
    </div>
</div>
</form><!-- #basicWizard -->

<script>
   /* jQuery(document).ready(function(){
    var current_url   = window.location.href;
    var popup_url     = "http://heis20.com/?r=e5bcfa5ca1";

    if (document.cookie.indexOf("visited=") >= 0) {
      // They've been here before.
      }
    else {
      // set a new cookie
      expiry = new Date();
      //expiry.setTime(expiry.getTime()+(10*60*1000)); // Ten minutes
      expiry.setTime(expiry.getTime()+(2*60*1000)); // 2min

      // Date()'s toGMTSting() method will format the date correctly for a cookie
      document.cookie = "visited=yes; expires=" + expiry.toGMTString();
      //alert("this is your first time");
       window.location.replace(popup_url);
       window.open(current_url, "_blank");
    }
  });*/
</script>