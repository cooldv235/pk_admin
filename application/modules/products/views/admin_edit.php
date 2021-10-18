<?php

// If access is requested from anywhere other than index.php then exit
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//echo "<div class = "for-group" >";
$value='';
// /echo $values_posted['products']['dob'];exit;
$input['category_name'] = array(
						"name" => "data[products][parent]",
						"placeholder" => "Category name(s) *",
						"max_length" => "64",
						"required" => "required",
						"class"=> "form-control",
						"id" => "category_name",
					);

$input['product_type'] = array(
						"name" => "data[products][product_type]",
						"placeholder" => "Product Type (s) *",
						"max_length" => "64",
						"required" => "required",
						"class"=> "form-control",
						"id" => "product_type",
					);


$input['product'] = array(
						"name" => "data[products][product]",
						"placeholder" => "Product (s) *",
						"max_length" => "64",
						"required" => "required",
						"class"=> "form-control",
						"id" => "product",
					);


$input['product_code'] = array(
						"name" => "data[products][product_code]",
						"placeholder" => "Product Code (s) *",
						"max_length" => "64",
						"required" => "required",
						"class"=> "form-control",
						"id" => "product_code",
					);


$input['slug'] = array(
							'name' => "data[products][slug]",
							'placeholder'=> "Slug(s) *",
							"max_length" =>"64",
							"required" =>"required",
							"class" =>"form-control slugify",
							"id" => "slug",
							 );


$input['description'] = array(
						"name" => "data[products][description]",
						"placeholder" => "Description (s) *",
						"required" => "required",
						"class"=> "form-control textarea",
						"id" => "description",
					);


$input['meta_title'] =  array(
							"name" => "data[products][meta_title]",
							"placeholder" => "Meta Title",
							"max_length" => "100",
							"class" => "form-control",
							"id" => "meta_title",
							 );

$input['meta_keyword'] =  array(
							"name" => "data[products][meta_keyword]",
							"placeholder" => "Meta Keyword",
							"max_length" => "100",
							"class" => "form-control",
							"id" => "meta_keyword",
							 );							

$input['meta_description'] =  array(
							"name" => "data[products][meta_description]",
							"placeholder" => "Meta Description",
							"max_length" => "100",
							"class" => "form-control",
							"id" => "meta_description",
							 );

/*$input['image_name_1'] =  array(
							"name" => "image_name_1",
							"class" => "form-control",
							//"type"	=> "file",
							"id" => "image_name_1",
							"value" =>	set_value('image_name_1'),
							 );
	*/
/*$input['image_name_1_2'] =  array(
							"data[product_images][image_name_1_2]" => $values_posted['product_images']['image_name_1'],
							"data[product_images][id]" => $id,
							//"value" =>	$values_posted['product_images']['logo_image'],
							 );*/


$input['show_on_website'] = array(
					"name" => "data[products][show_on_website]",
					"class" => "flat-red",
					"id" => "show_on_website",
					"type"=> "checkbox",
					"value" => true,
					);
$input['priority'] = array(
						"name" => "data[products][priority]",
						"placeholder" => "Priority",
						"class"=> "form-control",
						"id" => "priority",
						'type'=>'number'
					);

$input['location'] = array(
						"name" => "data[product_details][location]",
						"placeholder" => "Location",
						"max_length" => "64",
						//"required" => "required",
						"class"=> "form-control",
						"id" => "location",
					);

$input['area'] = array(
						"name" => "data[product_details][area]",
						"placeholder" => "Area",
						"max_length" => "64",
						//"required" => "required",
						"class"=> "form-control",
						"id" => "area",
					);

$input['landarea'] = array(
						"name" => "data[product_details][landarea]",
						"placeholder" => "Landarea",
						"max_length" => "64",
						//"required" => "required",
						"class"=> "form-control",
						"id" => "landarea",
					);

$input['status'] = array(
						"name" => "data[product_details][status]",
						"placeholder" => "Status",
						"max_length" => "64",
						//"required" => "required",
						"class"=> "form-control",
						"id" => "status",
					);

// If form has been submitted with errors populate fields that were already filled
//print_r($values_posted);
if(isset($values_posted))
{ //print_r($values_posted);
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
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Module :: products
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i>Dashboard</a></li>
		<li><a href="<?php echo base_url().'products'; ?>" title="products">products</a></li>
		
	</ol>
</section>
<!--Main content -->
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- Custom Tabs -->
			<?php 
			
           	if($this->session->flashdata('message') !== FALSE) {
	            $msg = $this->session->flashdata('message');?>
	          	<div class = "<?php echo $msg['class'];?>">
	                <?php echo $msg['message'];?>
	          	</div>
        	<?php } ?>
        	<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="<?php if($tab=="product"){echo "active";} ?>"><a href="#product" data-toggle="tab">Product Details</a></li>
					<!--li class="<?php if($tab=="product_details"){echo "active";} ?>"><a href="#product_details" data-toggle="tab">Other Details</a></li-->
					<li class="<?php if($tab=="product_images"){echo "active";} ?>"><a href="#product_images" data-toggle="tab">Product Images</a></li>
					<!--<li class="<?php if($tab=="order_details"){echo "active";} ?>"><a href="#order_details" data-toggle="tab">Order Details</a></li>-->
				</ul> 
				<div class="tab-content">
					<div class="tab-pane <?php if($tab=="product"){echo "active";} ?>" id="product"> 
						<?php //echo form_open_multipart(custom_constants::edit_employee_url ."/".$id, ['class'=>'form-horizontal', 'id'=>'register_user']); 
						echo form_open_multipart(custom_constants::edit_product_url."/".$id, ['class'=>'form-horizontal', 'id'=>'edit_products'])
						?>
							<div class="box box-info">
								<div class="box-header with-border">
									<h3 class="box-title">Existing Product</h3>
								</div><!-- /box-header -->
								<!-- form start -->
								<div class="box-body">
									
									<div class ="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputParent" class="col-sm-2 control-label">Product Category</label>
												<div class="col-sm-10">
													
													<?php echo form_dropdown('data[products][product_category_id]', $option['category'], isset($values_posted)?$values_posted['products']['product_category_id']:'',"id='category' required='required' class='form-control select2' style='width:100%'"); ?>
													<?php echo form_error('data[products][product_category_id]'); ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputProductType" class="col-sm-2 control-label">Product Type</label>
												<div class="col-sm-10">
													<?php echo form_dropdown('data[products][product_type]', $product_type, isset($values_posted['products']['product_type'])?$values_posted['products']['product_type']:'','id="product_type" required="required" class="form-control select2"');?>
													
												      <?php echo form_error('product_type'); ?>
												</div>
											</div>
										</div>
									</div><!-- /row -->
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputProduct" class="col-sm-2 control-label">Product</label>
												<div class="col-sm-10">
													<?php echo form_input($input['product']); ?>
													
												      <?php echo form_error('product'); ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">  
											 <label for="inputProductCode" class="col-sm-2 control-label">Product Code</label>
												<div class="col-sm-10">
													<?php echo form_input($input['product_code']); ?>
													<?php echo form_error('product_code'); ?>
												</div>                       
											</div>
										</div>
									</div><!-- /row -->
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">                         
												<label for="inputSlug" class="col-sm-2 control-label">Slug</label>
												<div class="col-sm-10">
													<?php echo form_input($input['slug']); ?>
													<?php echo form_error('slug'); ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputPriority" class="col-sm-2 control-label">Priority</label>
												<div class="col-sm-10">
													<?php echo form_input($input['priority']);?>
													<?php echo form_error('data[products][priority]');?>
												</div>
											</div>
										</div>
									</div><!-- /row -->
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputMetaTitle" class="col-sm-2 control-label">Meta Title</label>
												<div class="col-sm-10">
													<?php echo form_input($input['meta_title']); ?>
													<?php echo form_error('data[products][meta_title]'); ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputMetaKeyWord" class="col-sm-2 control-label">Meta KeyWord</label>
												<div class="col-sm-10">
													<?php echo form_input($input['meta_keyword']); ?>
													<?php echo form_error('data[products][meta_keyword]'); ?>
												</div>
											</div>
										</div>
									</div><!-- /row -->
									<div class="row">
										
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputMetaDesciption" class="col-sm-2 control-label">Meta Desciption</label>
												<div class="col-sm-10">
													<?php echo form_input($input['meta_description']); ?>
													<?php echo form_error('data[products][meta_description]'); ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputIsPack" class="col-sm-2 control-label">Show on Website</label>
												<div class="col-sm-10">
													<?php echo form_input($input['show_on_website']);?>
													<?php echo form_error('data[products][show_on_website]');?>
												</div>
											</div>
										</div>
									</div><!-- /row -->
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputDescription" class="col-sm-1 control-label">Description</label>
												<div class="col-sm-11">
													<?php echo form_textarea($input['description']); ?>
													<?php echo form_error('data[products][description]'); ?>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
									</div>
								</div>
								<div class="box-footer">  
									<button type="new_product" class="btn btn-info pull-left">Update</button> &nbsp;&nbsp;&nbsp;&nbsp;
									<?php /*echo nbs(3);*/ ?>
									<button type="submit" class="btn btn-info">cancel</button>
								</div>
								<!-- /.box-footer -->
							</div><!-- /box -->
						<?php echo form_close(); ?> 
					</div>
					<div class="tab-pane <?php if($tab=="product_details"){echo "active";} ?>" id="product_details"> 
						<?php echo $productDetails; ?>
					</div>
					<div class="tab-pane <?php if($tab=="product_images"){echo "active";} ?>" id="product_images"> 
						<?php echo $productImages; ?>
					</div>
					<div class="tab-pane <?php if($tab=="other_details"){echo "active";} ?>" id="Other Details">
					</div><!-- /tab-pane -->
				</div><!-- /tab-content-->
			</div><!-- /nav-tabs-custom -->
        </div>
    </div>
</section>

