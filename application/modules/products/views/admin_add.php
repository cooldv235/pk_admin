<?php

// If access is requested from anywhere other than index.php then exit
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//echo "<div class = "for-group" >";
$input['product'] = array(
						"name" => "data[products][product]",
						"placeholder" => "product name(s) *",
						"max_length" => "64",
						"required" => "required",
						"class"=> "form-control",
						"id" => "product",
					);

$input['product_code'] = array(
						"name" => "data[products][product_code]",
						"placeholder" => "product code *",
						"max_length" => "64",
						"class" => "form-control",
						'id' => "product_code"
					);


$input['profile_image'] = array(
						"name" => "product_categories",
						"placeholder" => "image *",
						"class"=> "form-control",
						"id" => "image",
						"value" => set_value('image'),
					);

$input['product_image'] =  array(
							"name" => "product_image",
							"placeholder" => "product image *",
							//"required" => "required",
							"class" => "form-control",
							//"type"	=> "file",
							"id" => "product_image",
							"value" =>	set_value('product_image'),
							 );

$input['product_categories'] =  array(
							"name" => "product_categories",
							"placeholder" => "product_categories *",
							//"required" => "required",
							"class" => "form-control",
							//"type"	=> "file",
							"id" => "product_categories",
							"value" =>	set_value('product_categories'),
							 );

$input['slug'] = array(
						"name" => "data[products][slug]",
						"placeholder" => "Slug *",
						"max_length" => "100",
						"required" => "required",
						"class"=> "form-control slugify",
						"id" => "slug",
					);					


$input['description'] = array(
						"name" => "data[products][description]",
						"placeholder" => "Description *",
						"required" => "required",
						"class"=> "form-control textarea",
						"id" => "description"
					);

$input['meta_title'] = array(
						"name" => "data[products][meta_title]",
						"placeholder" => "Meta Title ",
						"max_length" => "100",
						"class"=> "form-control",
						"id" => "meta_title"
					);

$input['meta_description'] = array(
						"name" => "data[products][meta_description]",
						"placeholder" => "Meta Description ",
						"max_length" => "100",
						"class"=> "form-control",
						"id" => "meta_description"
					);

$input['meta_keyword'] = array(
						"name" => "data[products][meta_keyword]",
						"placeholder" => "Meta Keyword",
						"max_length" => "100",
						"class"=> "form-control",
						"id" => "meta_keyword"
					);

$input['priority'] = array(
						"name" => "data[products][priority]",
						"placeholder" => "Priority",
						"class"=> "form-control",
						"id" => "priority",
						'type'=>'number'
					);

$input['unit'] = array(
						"name" => "pack_products[unit]",
						"placeholder" => "Unit",
						"max_length" => "100",
						"class"=> "form-control",
						"id" => "unit"
					);

$input['quantity'] = array(
						"name" => "pack_products[quantity]",
						"placeholder" => "Quantity",
						"max_length" => "100",
						"class"=> "form-control",
						"id" => "quantity"
					);

$input['show_on_website'] = array(
					"name" => "data[products][show_on_website]",
					"class" => "flat-red",
					"id" => "show_on_website",
					"type"=> "checkbox",
					"value" => true,
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

$type 	=	array(
				'id'	=>	'type_0',
				//'required'	=>	'required',
				'class'	=>	'form-control select2 showInput type',
				'style' => 'width:100%',
                'tab-index'=>'2'
				);
// If form has been submitted with errors populate fields that were already filled
if(isset($values_posted))
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
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
	    Module :: Products
	</h1>
	<ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i>Dashboard</a></li>
	    <li>
	      <?php echo anchor(custom_constants::admin_product_listing_url, 'Products', 'title="products"'); ?>
	    </li>
	    <li>
	      <?php echo anchor(custom_constants::new_product_url, 'New Product'); ?>
	    </li>
	</ol>
</section>
<!--Main content -->
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- Custom Tabs -->
			<div class="nav-tabs-custom">

				<div class="tab-content">
					
						<?php //echo form_open_multipart(custom_constants::new_user_url, ['class'=>'form-horizontal', 'id'=>'register_user']); 
							//print_r($this->session);
						echo form_open_multipart(custom_constants::new_product_url, ['class'=>'form-horizontal', 'id'=>'new_product']);
							
							if($this->session->flashdata('message') !== FALSE) {
								$msg = $this->session->flashdata('message');?>
								<div class = "<?php echo $msg['class'];?>">
									<?php echo $msg['message'];?>
								</div>
							<?php } ?>
							<div class="box box-info">
								<div class="box-header with-border">
									<h3 class="box-title"><i class="fa fa-shopping-bag margin-r-5"></i> New Product</h3>
								</div><!-- /box-header -->
								<!-- form start -->
								<div class="box-body">
									
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputCategory" class="col-sm-2 control-label">Category</label>
												<div class="col-sm-10">
													
													<?php echo form_dropdown('data[products][product_category_id]', $option['category'], isset($values_posted)?$values_posted['products']['product_category_id']:'',"id='category' required='required' class='form-control select2'"); ?>
													<?php echo form_error('data[products][product_category_id]'); ?>
												</div>
											</div>
										</div>
									<div class="col-md-6">
											<div class="form-group">
												<label for="inputProduct_type" class="col-sm-2 control-label">Product Type</label>
												<div class="col-sm-10">
													<?php echo form_dropdown('data[products][product_type]',$product_type, isset($values_posted['products']['product_type'])?$values_posted['products']['product_type']:'',"id='product_type' required='required' class='form-control select2' ");?>
													
													<?php echo form_error('data[products][product_code]'); ?>
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
													<?php echo form_error('data[products][product]'); ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputProfileImage" class="col-sm-2 control-label">Product Code</label>
												<div class="col-sm-10">
							                      <?php echo form_input($input['product_code']);?>
													<?php echo form_error('data[products][product_code]');?>
							                  </div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputSlug" class="col-sm-2 control-label">Slug</label>
												<div class="col-sm-10">
													<?php echo form_input($input['slug']);?>
													<?php echo form_error('data[products][slug]');?>
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
									</div>
									
									<div class="row">
										
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputMetaTitle" class="col-sm-2 control-label">Meta Title</label>
												<div class="col-sm-10">
													<?php echo form_input($input['meta_title']);?>
													<?php echo form_error('data[products][meta_title]');?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputMetaDesciption" class="col-sm-2 control-label">Meta Desciption</label>
												<div class="col-sm-10">
													<?php echo form_input($input['meta_description']);?>
													<?php echo form_error('data[products][meta_description]');?>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputMetaKeyword" class="col-sm-2 control-label">Meta Keyword</label>
												<div class="col-sm-10">
													<?php echo form_input($input['meta_keyword']);?>
													<?php echo form_error('data[products][meta_keyword]');?>
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
									</div>
									<div class="row">
										
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputDesciption" class="col-sm-1 control-label">Desciption</label>
												<div class="col-sm-11">
													<?php echo form_textarea($input['description']);?>
													<?php echo form_error('data[products][description]');?>
												</div>
											</div>
										</div>
									</div>
									<!--<div class="otherDetails" id="otherDetails" >

										<div class="box-header with-border">
											<h2 class="box-title">Other Product Details</h2>
										</div>
										<div class="box-body">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="inputLocation" class="col-sm-2 control-label">Location</label>
														<div class="col-sm-10">
															<?php echo form_input($input['location']);?>
															<?php echo form_error('data[product_details][location]');?>
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="inputArea" class="col-sm-2 control-label">Area</label>
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
										</div>
									</div>-->
								<!-- <div class="box-footer">  --> 


									<div class="box-haeder with-border">
										<h2 class="box-title">Product Images</h2>
									</div>
									<div class="box-body" style="overflow-x:scroll">
										<table class="table" id="target">
											<thead>
												<tr>
													<th>Type</th>
													<th>Product Image 1</th>
													<!--<th>Product Image 2</th>-->
													<th>Title</th>
													<th>Priority</th>
													<th>Featured Image</th>
													<th>Is Active</th>
													<th></th>
												</tr>
											</thead>
											<tbody>
												<tr id="0">
													<td><?php echo form_dropdown('product_images[0][type]',$option['type'], set_value('product_images[0][type]'),$type); ?></td>
													<td><!-- <div id="image_0" class="image"> --><input type="file" name="product_images[0][image_name_1]" id="image_name_1_0" class="form-control image"><!-- </div> -->
														<!-- <div id="video_0" class="video" style="display: none"> --><input type="text" name="product_images[0][video]" id="featured_image_video_0" class="form-control video" placeholder="https://www.youtube.com/embed/fEYx8dQr_cQ" value="<?php echo set_value('product_images[0][video]'); ?>" style="display: none"><!-- </div> -->
													</td>
													<!-- <td id="video" style="display: block"><input type="text" name="product_images[0][video]" id="featured_image_video_0" class="form-control" placeholder="https://www.youtube.com/embed/fEYx8dQr_cQ" value="<?php echo set_value('product_images[0][video]'); ?>">
													</td> -->
													<td><input type="text" name="product_images[0][title]" id="title_0" class="form-control"></td>
													<td><input type="text" name="product_images[0][priority]" id="priority_0" class="form-control"></td>
													<td><input type="checkbox" name="product_images[0][featured_image]" id="featured_image_0" class="form required SingleCheck"></td>
													<td><input type="checkbox" name="product_images[0][is_active]" id="is_active_0" class="form required"></td>
													<td></td>
												</tr>
											</tbody>
											<tfoot>
												<tr>
											   		<td colspan="9"><button type="button" id="AddMoreProductImages" class="btn btn-info pull-right AddMoreRow">Add More</button>
											   		</td>
											   	</tr>
											</tfoot>
										</table>
									</div>
									
								<div class="box-footer">  
									<button type="new_college" class="btn btn-info pull-left">Add Product</button> &nbsp;&nbsp;&nbsp;&nbsp;
									
								</div>
								<!-- /.box-footer -->
							</div><!-- /box -->
							</div>
						<?php echo form_close(); ?> 
					
					
					
				</div><!-- /tab-content -->
			</div><!-- end of nav tab -->
		</div><!-- col-md-12 -->
	</div><!-- /nav-tabs-custom -->
</section> <!-- /section-->

