<?php

// If access is requested from anywhere other than index.php then exit
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//echo "<div class = "for-group" >";
$input['first_name'] = array(
						"name" => "data[enquiries][first_name]",
						"max_length" => "64",
						"required" => "required",
						"id" => "first_name",
						"class" => "form-control",
						'placeholder'=>'First Name',
					);

$input['surname'] = array(
						"name" => "data[enquiries][surname]",
						"max_length" => "64",
						"required" => "required",
						"class" => "form-control",
						'id' => "surname",
						'placeholder'=>'Last Name',
					);





$input['primary_email'] =  array(
							"type" => "email",
							"name" => "data[enquiries][primary_email]",
							"max_length" => "100",
							"required" => "required",
							"class" => "form-control",
							"id" => "primary_email",
							'placeholder'=>'Email (Required)',
						);
$input['contact_1'] = array(
						"name" => "data[enquiries][contact_1]",
						"max_length" => "15",
						"class"=> "form-control",
						"required" => "required",
						"id" => "contact_1",
						'placeholder'=>'Phone(eg.+123456789)',
					);
$input['address_1'] = array(
						"name" => "data[address][address_1]",
						"max_length" => "255",
						"class"=> "form-control",
						"required" => "required",
						"id" => "address",
						'placeholder'=>'Address For Shipping Samples(Optional)',
					);

$input['address_2'] = array(
						"name" => "data[address][address_2]",
						"max_length" => "255",
						"class"=> "form-control",
						"required" => "required",
						"id" => "address",
						'placeholder'=>'Address For Shipping Samples(Optional)',
					);
$input['pincode'] = array(
						"name" => "data[address][pincode]",
						"max_length" => "6",
						"class"=> "form-control",
						"required" => "required",
						"id" => "pincode",
						'placeholder'=>'Postal/Zip Code',
					);
$input['message'] = array(
						"name" => "data[enquiries][message]",
						"max_length" => "100",
						"required" => "required",
						"class"=> "form-control",
						"rows" =>5,
						"id"=>"message",
						"placeholder" => "Tell Us What Kind of Products You Need From India. Amazon, Ebay or Alibaba Product links will be helpful.",
					);
$input['state'] = array(
						"required" => "required",
						"class"=> "form-control input-lg select2",
						"id"=>"country",
						);
$input['country'] = array(
						"required" => "required",
						"class"=> "form-control input-lg select2",
						"id"=>"country",
						);
$country  = array(
				'id' =>	'country_id',
				'required'	=>	'required',
				'class'	=>	'form-control input-lg select2 filter viewInput',
				'data-link' => 'states/getCountrywiseStates',
				'data-target' =>'state_id',
				'input-data-target' =>'country',
				'style' => 'width:100%',
				 /*data-target='faq_category_".$faquesKey."'*/
			 );

$state 	=	array(
				'id'	=>	'state_id',
				'required'	=>	'required',
				'class'	=>	'form-control input-lg select2 filter viewInput',
				'data-link' => 'cities/getStateWiseCities',
				'data-target' => 'city_id',
				'input-data-target' =>'state',
				'style' => 'width:100%',
				);

$city	= 	array(
				'id' => 'city_id',
				'required' => 'required',
				'class' => 'form-control input-lg select2 filter viewInput',
				'data-link' => 'areas/getCityWiseAreas',
				'data-target' => 'area_id',
				'input-data-target' =>'city',
				'style' => 'width:100%',
			);

$area  = array(
				'id' =>	'area_id',
				'required'	=>	'required',
				'class'	=>	'form-control input-lg select2 filter viewInput',
				'style' => 'width:100%',
				'input-data-target' => 'area',
			 );
$input['captcha'] = array(
						"name" => "data[captcha]",
						"placeholder" => "Your Answer *",
						'required' => 'required',
						"class"=> "form-control input-lg",
						"id" => "captcha"
					);


// If form has been submitted with errors populate fields that were already filled
if(isset($values_posted))
{ //print_r($values_posted);
	foreach($values_posted as $post_name => $post_value)
	{
		foreach ($post_value as $field_key => $field_value) {
			# code...
			$input[$field_key]['value'] = $field_value;
		}
	}
}

?>
<!-- Content Header (Page header) -->
<!-- <section class="content-header">
  <h2>
    Contact Form
  </h2>
  
</section> -->
<!--Main content -->

						<?php echo form_open_multipart('enquiries/process_sourcing_form', ['class'=>'form-vertical', 'id'=>'sourcing-form']); 
							//print_r($this->session);
						//echo form_open_multipart('enquiries/process_form', ['class' => 'form-horizontal', 'id' => 'register_enquiry']);
							if(isset($form_error))
							{
								echo "<div class='alert alert-danger'>";
								echo $form_error;
								echo "</div>";
							}
							if($this->session->flashdata('message') !== FALSE) {
								$msg = $this->session->flashdata('message');?>
								<div class = "<?php echo $msg['class'];?>">
									<?php echo $msg['message'];?>
								</div>
							<?php } ?>
							
									<?php if(isset($err)){ ?>
									<div class="alert alert-danger alert-dismissible">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
										<h4><i class="icon fa fa-ban"></i> Alert!</h4>
										<?php echo $this->session->flashdata('err'); ?>
									</div>
									<?php } ?>
									<div class="col-md-6 form-group">
                                        <label class="control-label" for="inputFirst_name">
                                            First Name
                                            <span class="form-required" title="This field is required.">*</span>
                                        </label>
                                        
                                            <?php echo form_input($input['first_name']); ?>
											<?php echo form_error('data[enquiries][first_name]'); ?>
                                        
                                    </div><!-- /.form-group -->
                                    <div class="col-md-6 form-group">
                                        <label class="control-label" for="inputFirst_name">
                                            Last Name
                                            <span class="form-required" title="This field is required.">*</span>
                                        </label>
                                        
                                            <?php echo form_input($input['surname']); ?>
											<?php echo form_error('data[enquiries][surname]'); ?>
                                        
                                    </div><!-- /.form-group -->
                                    <div class="form-group col-md-12">
                                        <label class="control-label" for="primary_email">Email ID
                                            <span class="form-required" title="This field is required.">*</span>
                                        </label>
                                        <div class="controls">
                                            <?php echo form_input($input['primary_email']); ?>
											<?php echo form_error('data[enquiries][primary_email]'); ?>
                                        </div><!-- /.controls -->
                                    </div><!-- /.form-group -->
                                    <div class="col-md-12 form-group">
                                        <label class="control-label" for="contact_1">Contact No.
                                            <span class="form-required" title="This field is required.">*</span>
                                        </label>
                                        <div class="controls">
                                            <?php echo form_input($input['contact_1']); ?>
											<?php echo form_error('data[enquiries][contact_1]'); ?>
                                        </div><!-- /.controls -->
                                    </div><!-- /.form-group -->
                                    <div class="col-md-6 form-group">
                                        <label class="control-label" for="inputFirst_name">
                                            Address 1
                                            <span class="form-required" title="This field is required.">*</span>
                                        </label>
                                        
                                            <?php echo form_input($input['address_2']); ?>
											<?php echo form_error('data[address][address_1]'); ?>
                                        
                                    </div><!-- /.form-group -->
                                    <div class="col-md-6 form-group">
                                        <label class="control-label" for="inputFirst_name">
                                            Address 2
                                            <span class="form-required" title="This field is required.">*</span>
                                        </label>
                                        
                                            <?php echo form_input($input['address_1']); ?>
											<?php echo form_error('data[address][address_2]'); ?>
                                        
                                    </div><!-- /.form-group -->
                                     <div class="col-md-6 form-group">
                                        <label class="control-label" for="inputFirst_name">
                                            Country
                                            <span class="form-required" title="This field is required.">*</span>
                                        </label>
                                        
                                            <?php echo form_dropdown('data[address][country_id]', $option['countries'], '', $country); ?>
											<?php echo form_error('data[address][country_id]'); ?>
                                        
                                    </div><!-- /.form-group -->
                                    <div class="col-md-6 form-group">
                                        <label class="control-label" for="inputFirst_name">
                                            State
                                            <span class="form-required" title="This field is required.">*</span>
                                        </label>
                                        
                                            <?php echo form_dropdown('data[address][state_id]',$option['states'], '',$state);?>
											<?php echo form_error('data[address][state_id]'); ?>
                                        
                                    </div><!-- /.form-group -->
                                    <div class="col-md-6 form-group">
                                        <label class="control-label" for="inputFirst_name">
                                            City
                                            <span class="form-required" title="This field is required.">*</span>
                                        </label>
                                        
                                            <?php echo form_dropdown('data[address][city_id]', $option['cities'], '', $city); ?>
											<?php echo form_error('data[address][city_id]'); ?>
                                        
                                    </div><!-- /.form-group -->
                                    <div class="col-md-6 form-group">
                                        <label class="control-label" for="inputFirst_name">
                                            Area
                                            <span class="form-required" title="This field is required.">*</span>
                                        </label>
                                        
                                            
											<?php echo form_dropdown('data[address][area_id]', $option['areas'], '', $area); ?>
											<?php echo form_error('data[address][area_id]'); ?>
                                        	
                                    </div><!-- /.form-group -->
                                    <div class="col-md-6 form-group">
                                        <label class="control-label" for="inputFirst_name">
                                            Postal/Zip Code
                                            <span class="form-required" title="This field is required.">*</span>
                                        </label>
                                        
                                            <?php echo form_input($input['pincode']); ?>
											<?php echo form_error('data[address][pincode]'); ?>
                                        
                                    </div><!-- /.form-group -->
                                   
                                    <div class="col-md-12 form-group">
                                        <label class="control-label" for="inputMessage">
                                            Message
                                            <span class="form-required" title="This field is required.">*</span>
                                        </label>

                                        <div class="controls">
                                            <?php echo form_textarea($input['message']); ?>
											<?php echo form_error('data[enquiries][message]'); ?>
                                        </div><!-- /.controls -->
                                    </div><!-- /.form-group -->
                                    <div class="col-md-12 form-group">
                                        <label class="control-label" for="captcha">Total of <?php echo $num1; ?> + <?php echo $num2; ?> is : 
                                            <span class="form-required" title="This field is required.">*</span>
                                        </label>
                                        <div class="controls">
                                            <?php echo form_input($input['captcha']); ?>
											<?php echo form_error('captcha'); ?>
                                        </div><!-- /.controls -->
                                    </div><!-- /.control-group -->
									
									<div class="col-md-12 form-actions">
                                        <input type="submit" class="btn btn-primary arrow-right" value="Send">
                                    </div><!-- /.form-actions -->
									
						<?php echo form_close(); ?> 
					
				
