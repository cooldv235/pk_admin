<?php

// If access is requested from anywhere other than index.php then exit
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$input['mission'] = array(
						"name" => "data[company_details][mission]",
						"placeholder" => "mission",
						"required" => "required",
						"class"=> "form-control",
						"id" => "mission",
					);

$input['vission'] = array(
						"name" => "data[company_details][vission]",
						"placeholder" => "vission",
						"required" => "required",
						"class"=> "form-control",
						"id" => "vission",
					);

$input['team_text'] = array(
						"name" => "data[company_details][team_text]",
						"placeholder" => "team_text",
						"required" => "required",
						"class"=> "form-control",
						"id" => "team_text",
					);

$input['image'] = array(
						"name" => "image",
						'type'=>'file',
						"placeholder" => "image",
						"class"=> "form-control",
						"id" => "image",
					);
// If form has been submitted with errors populate fields that were already filled
if(isset($values_posted['company_details']) && !empty($values_posted['company_details']))
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
<?php echo form_open_multipart('companies/admin_edit_other_details/'.$id, ['class'=>'form-horizontal', 'id'=>'edit_company_details']);?>
		<!-- <input type="hidden" name="product_id" value="<?php echo $id; ?>"> -->

		<?=form_hidden(['data[company_details][id]'=>$values_posted['company_details']['id']])?>
		<?=form_hidden(['data[company_details][company_id]'=>$id])?>
		<div class="box-header with-border">
			<h3 class="box-title">Edit Product Details</h3>
		</div><!-- /box-header -->
		<!-- form start -->
		<div class="box-body">
			<div class="box-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputMission" class="col-sm-2 control-label">Mission</label>
							<div class="col-sm-10">
								<?php echo form_textarea($input['mission']);?>
								<?php echo form_error('data[company_details][mission]');?>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputVission" class="col-sm-2 control-label">Vission</label>
							<div class="col-sm-10">
								<?php echo form_textarea($input['vission']);?>
								<?php echo form_error('data[company_details][vission]');?>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputTeam_text" class="col-sm-2 control-label">Team Text</label>
							<div class="col-sm-10">
								<?php echo form_textarea($input['team_text']);?>
								<?php echo form_error('data[company_details][team_text]');?>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputImage" class="col-sm-2 control-label">Team Image (1140px * 475px)</label>
							<div class="col-sm-10">
								<?php //print_r($values_posted); ?>
								<?php echo form_input($input['image']);?>
								<?php if(isset($values_posted['company_details']['image']) && !empty($values_posted['company_details']['image'])){
									echo form_hidden(['data[company_details][image2]'=> $values_posted['company_details']['image']]);
								 ?>
								<?=img(['src'=>content_url().'uploads/team/'.$values_posted['company_details']['image'], 'width'=>'100px'])?>
								<?php } ?>
								<?php echo form_error('data[company_details][image]');?>
							</div>
						</div>
					</div>
				</div>
				
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