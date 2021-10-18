<?php

// If access is requested from anywhere other than index.php then exit
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$input['location'] = array(
						"name" => "data[product_details][location]",
						"placeholder" => "Location",
						"required" => "required",
						"class"=> "form-control",
						"id" => "location",
					);

$input['area'] = array(
						"name" => "data[product_details][area]",
						"placeholder" => "Area",
						"class"=> "form-control",
						"id" => "area",
					);

$input['landarea'] = array(
						"name" => "data[product_details][landarea]",
						"placeholder" => "Landarea",
						"max_length" => "64",
						"class"=> "form-control",
						"id" => "landarea",
					);

$input['status'] = array(
						"name" => "data[product_details][status]",
						"placeholder" => "Status",
						"max_length" => "64",
						"required" => "required",
						"class"=> "form-control",
						"id" => "status",
					);
$input['bedroom'] = array(
						"name" => "data[product_details][bedroom]",
						"placeholder" => "bedroom",
						"max_length" => "64",
						"required" => "required",
						"class"=> "form-control",
						"id" => "bedroom",
						"type"=>'number',
						"min"=>0
					);
$input['bathroom'] = array(
						"name" => "data[product_details][bathroom]",
						"placeholder" => "bathroom",
						"max_length" => "64",
						"required" => "required",
						"class"=> "form-control",
						"id" => "bathroom",
						"type"=>'number',
						"min"=>0
					);
// If form has been submitted with errors populate fields that were already filled
if(isset($values_posted['product_details']) && !empty($values_posted['product_details']))
{	
	//print_r($values_posted);

	foreach($values_posted as $post_name => $post_value)
	{ 
		foreach ($post_value as $field_key => $field_value) {
			if(isset($input[$field_key]['type']) && $input[$field_key]['type']=="checkbox" && $field_value==true){
				$input[$field_key]['checked'] = "checked";
			}else{
				$input[$field_key]['value'] = $field_value;
			}
		}
	}
}

?>
<div class="box box-info">
<?php echo form_open_multipart('products/admin_edit_product_details/'.$id, ['class'=>'form-horizontal', 'id'=>'edit_product_details']);?>
		<!-- <input type="hidden" name="product_id" value="<?php echo $id; ?>"> -->

		<?=form_hidden(['data[product_details][id]'=>$values_posted['product_details']['id']])?>
		<?=form_hidden(['data[product_details][product_id]'=>$id])?>
		<div class="box-header with-border">
			<h3 class="box-title">Edit Product Details</h3>
		</div><!-- /box-header -->
		<!-- form start -->
		<div class="box-body">
			<div class="box-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputLocation" class="col-sm-2 control-label">Location (Area)</label>
							<div class="col-sm-10">
								<?php echo form_input($input['location']);?>
								<?php echo form_error('data[product_details][location]');?>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputArea" class="col-sm-2 control-label">Area in m<sup>2</sup>/ ft<sup>2</sup></label>
							<div class="col-sm-10">
								<?php echo form_input($input['area']);?>
								<?php echo form_error('data[product_details][area]');?>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputlandarea" class="col-sm-2 control-label">Landarea</label>
							<div class="col-sm-10">
								<?php echo form_input($input['landarea']);?>
								<?php echo form_error('data[product_details][landarea]');?>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputStatus" class="col-sm-2 control-label">Status</label>
							<div class="col-sm-10">
								<?php echo form_input($input['status']);?>
								<?php echo form_error('data[product_details][status]');?>
							</div>
						</div>
					</div>
				</div>
				<!--div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputbedroom" class="col-sm-2 control-label">bedroom</label>
							<div class="col-sm-10">
								<?php echo form_input($input['bedroom']);?>
								<?php echo form_error('data[product_details][bedroom]');?>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputbathroom" class="col-sm-2 control-label">bathroom</label>
							<div class="col-sm-10">
								<?php echo form_input($input['bathroom']);?>
								<?php echo form_error('data[product_details][bathroom]');?>
							</div>
						</div>
					</div>
					
				</div-->
			</div>
		</div><!-- /box body-->
		<div class="box-footer">  
			<button type="new_product" class="btn btn-info pull-left">Update</button> &nbsp;&nbsp;&nbsp;&nbsp;
			<?php /*echo nbs(3);*/ ?>
			<button type="submit" class="btn btn-info">cancel</button>
		</div>
		<!-- /.box-footer -->
<?php echo form_close(); ?> 
</div>