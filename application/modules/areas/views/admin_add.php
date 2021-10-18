<style>
	@import url("https://fonts.googleapis.com/css?family=Open+Sans");

form .error {
  color: #ff0000;
}
</style>

<?php 

$country  = array(
				'id' =>	'country_id',
				'required'	=>	'required',
				'class'	=>	'form-control select2 filter viewInput',
				'data-link' => 'states/getCountrywiseStates',
				'data-target' =>'state_id',
				'input-data-target' =>'country',
				'style' => 'width:100%',
				 /*data-target='faq_category_".$faquesKey."'*/
			 );

$state 	=	array(
				'id'	=>	'state_id',
				'required'	=>	'required',
				'class'	=>	'form-control select2 filter viewInput',
				'data-link' => 'cities/getStateWiseCities',
				'data-target' => 'city_id',
				'input-data-target' =>'state',
				'style' => 'width:100%',
				);

$city	= 	array(
				'id' => 'city_id',
				'required' => 'required',
				'class' => 'form-control select2 filter viewInput',
				'data-link' => 'areas/getCityWiseAreas',
				'data-target' => 'area_id',
				'input-data-target' =>'city',
				'style' => 'width:100%',
			);

$area  = array(
				'id' =>	'area_id',
				'required'	=>	'required',
				'class'	=>	'form-control select2 filter viewInput',
				'style' => 'width:100%',
				'input-data-target' => 'area',
			 );


$input['country_input'] = array(
						"name" => "data[address][country_input]",
						"placeholder" => "Country *",
						"class"=> "form-control viewInput",
						"id" => "country_input",

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
<div>

<?php echo form_open_multipart("areas/admin_add", ['name' => 'areasform','class'=>'form-horizontal', 'id'=>'area_form']); ?>
	 
	<!-- <form action="" name="areasform" id="areaform"> -->
	<div class="box box-info">
		<div class="box-header with-border">
			<h3 class="box-title">Area</h3>
		</div><!-- /box-header -->
		<!-- form start -->
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="country_id" class="col-sm-2 control-label">Country</label>
						<div class="col-sm-10">
							  <?php echo form_dropdown('data[states][country_id]', $option['countries'], '', $country); ?>
							  <input type="text" name="data[countries][name]" class="form-control input" id="country" placeholder="Country Not found? Enter here">
							  <!-- <span class="error_form" id="country_error_message"></span> -->
							  <?php echo form_error('data[states][country_id]'); ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="state_id" class="col-sm-2 control-label">State.</label>
							<div class="col-sm-10">
								<?php echo form_dropdown('data[cities][state_id]',$option['states'], '',$state);?>
								<input type="text" name="data[states][state_name]" class="form-control input" id="state" placeholder="State Is Not Listed. Enter here">
								<!-- <span class="error_form" id="state_error_message"></span> -->
								<?php echo form_error('data[cities][state_id]'); ?>
							</div>
					</div>
				</div>
			</div><!-- /row --><br>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="city_id" class="col-sm-2 control-label">City</label>
						<div class="col-sm-10">
							<?php echo form_dropdown('data[areas][city_id]', $option['cities'], '', $city); ?>
							<input type="text" name="data[cities][city_name]" class="form-control input" id="city" placeholder="City Is Not Listed. Enter here">
							<!-- <span class="error_form" id="city_error_message"></span> -->
							<?php echo form_error('data[areas][city_id]'); ?>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="area_id" class="col-sm-2 control-label">Area</label>
						<div class="col-sm-10">
							<input type="text" name="data[areas][area_name]" class="form-control input" id="area" placeholder="Enter Area here">
							<!-- <span class="error_form" id="area_error_message"></span> -->
							<?php echo form_error('data[areas][area_id]'); ?>
						</div>
					</div>
				</div>
			</div><!-- /row -->

			<!-- s --> <!-- /box-body -->  
	                  
		<div class="box-footer">  
			<button type="new_college" class="btn btn-info pull-left">Register</button> &nbsp;&nbsp;&nbsp;&nbsp;
			<?php /*echo nbs(3);*/ ?>
			<button type="submit" class="btn btn-info">cancel</button>
		</div>
		<!-- /.box-footer -->
	</div><!-- /box -->
	</div>
	<?php echo form_close(); ?> 
</div>

<script type="text/javascript">
	// Wait for the DOM to be ready
		$(function() {

		  	 $("#country_error_message").hide();
	       $("#state_error_message").hide();
	       $("#city_error_message").hide();
	       $("#area_error_message").hide();

	       var error_country = false;
	       var error_state = false;
	       var error_city = false;
	       var error_area = false;

	       $("#country").focusout(function(){
            check_country();
         });

         $("#state").focusout(function(){
            check_state();
         });

         $("#city").focusout(function(){
            check_city();
         });

         $("#area").focusout(function(){
            check_area();
         });

         function check_country() {
            var pattern = /^[a-zA-Z ]*$/;
            var country_name = $("#country").val();
            var country_id = $('#country_id').val();
            
            if ((pattern.test(country_name) && country_name !== '') || country_id != 0) {
               $("#country_error_message").hide();
               $("#country").css("border","1px solid #34F458");
            } else {
               $("#country_error_message").html("Please select an option or enter country name");
               $("#country_error_message").show();
               $("#country").css("border","1px solid #F90A0A");
               $("#country_id").css("border","1px solid #F90A0A");
               error_country = true;
            }
         }

         function check_state() {
            var pattern = /^[a-zA-Z ]*$/;
            var state_name = $("#state").val();
            var state_id = $('#state_id').val();
            

            if ((pattern.test(state_name) && state_name !== '') || state_id != 0) {
               $("#state_error_message").hide();
               $("#state").css("border","1px solid #34F458");
            } else {
               $("#state_error_message").html("Please select an option or enter state name");
               $("#state_error_message").show();
               $("#state").css("border","1px solid #F90A0A");
               $("#state_id").css("border","1px solid #F90A0A");
               error_state = true;
            }
         }

         function check_city() {
            var pattern = /^[a-zA-Z ]*$/;
            var city_name = $("#city").val();
            var city_id = $("#state_id").val();
            console.log(city_id);
            if ((pattern.test(city_name) && city_name !== '') || city_id != 0) {
               $("#city_error_message").hide();
               $("#city").css("border","1px solid #34F458");
            } else {
               $("#city_error_message").html("Please select an option or enter city name");
               $("#city_error_message").show();
               $("#city").css("border","1px solid #F90A0A");
               $("#city_id").css("border","1px solid #F90A0A");

               error_city = true;
            }
         }

         function check_area() {
            var pattern = /^[a-zA-Z ]*$/;
            var area_name = $("#area").val();
            if (pattern.test(area_name) && area_name !== '') {
               $("#area_error_message").hide();
               $("#area").css("border","1px solid #34F458");
            } else {
               $("#area_error_message").html("Should contain only Characters");
               $("#area_error_message").show();
               $("#area").css("border","1px solid #F90A0A");
               error_area = true;
            }
         }

         $("#area_form").submit(function() {
            error_country = false;
            error_state = false;
            error_city = false;
            error_area = false;

            check_country();
            check_state();
            check_city();
            check_area();

            if (error_country === false && error_state === false && error_city === false && error_area === false) {
               return true;
            } else {
               alert("Please Fill the form Correctly");
               return false;
            }

         });
       
		});
</script>
