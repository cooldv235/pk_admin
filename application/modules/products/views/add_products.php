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
						"placeholder" => "product_code *",
						"max_length" => "64",
						"required" => "required",
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
						"class"=> "form-control",
						"id" => "slug",
					);					

$input['base_price'] = array(
						"name" => "data[products][base_price]",
						"placeholder" => "base_price *",
						"max_length" => "100",
						"required" => "required",
						"class"=> "form-control",
						"id" => "base_price"
					);

$input['description'] = array(
						"name" => "data[products][description]",
						"placeholder" => "Description *",
						"max_length" => "100",
						"required" => "required",
						"class"=> "form-control",
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

$input['is_sale'] = array(
					"name" => "data[products][is_sale]",
					"class" => "flat-red",
					"id" => "is_sale",
					"type"=> "checkbox",
					"value" => true,
					);

$input['is_gift']  = array(
					"name" => "data[products][is_gift]",
					"class" => "flat-red",
					"id" => "is_gift",
					"type" => "checkbox",
					"value" => true,
				);

$input['is_new']  = array(
					"name" => "data[products][is_new]",
					"class" => "flat-red",
					"id" => "is_new",
					"type" => "checkbox",
					"value" => true,
				);

// If form has been submitted with errors populate fields that were already filled
if(isset($values_posted))
{	
//print_r($values_posted);

	foreach($values_posted['data'] as $post_name => $post_value)
	{ 
		foreach ($post_value as $field_key => $field_value) {
		print_r($field_value);
			# code...
			$input[$field_key]['value'] = $field_value;
		}
	}
}

?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Module:: Products
  </h1>
  
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
						echo form_open_multipart('products/new_product', ['class'=>'form-horizontal', 'id'=>'new_product']);
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
							<div class="box box-info">
								<div class="box-header with-border">
									<h3 class="box-title"><i class="fa fa-shopping-bag margin-r-5"></i> New Product</h3>
								</div><!-- /box-header -->
								<!-- form start -->
								<div class="box-body">
									<?php if(isset($err)){ ?>
									<div class="alert alert-danger alert-dismissible">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
										<h4><i class="icon fa fa-ban"></i> Alert!</h4>
										<?php echo $this->session->flashdata('err'); ?>
									</div>
									<?php } ?>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputCategory" class="col-sm-2 control-label">Category</label>
												<div class="col-sm-10">
													<?php echo form_dropdown('data[products][product_category_id]', $option['category'], isset($values_posted)?$values_posted['data']['products']['product_category_id']:'',"id='category' required='required' class='form-control select2'"); ?>
													<?php echo form_error('data[products][category]'); ?>
												</div>
											</div>
										</div>
									<div class="col-md-6">
											<div class="form-group">
												<label for="product_code" class="col-sm-2 control-label">Product Type</label>
												<div class="col-sm-10">
													<select name='data[products][product_type]', id="product_type" required="required" class="form-control select2">
														<option value="">Select Product Type</option>
														<option value="1">Product</option>
														<option value="2">Service</option>
														<option value="3">Product & Service</option>
													</select>
													
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
												<label for="inputGst" class="col-sm-2 control-label">Base Price</label>
												<div class="col-sm-10">
													<?php echo form_input($input['base_price']);?>
													<?php echo form_error('data[products][base_price]');?>
												</div>
											</div>
										</div>
										<!-- <div class="col-md-6">
											<div class="form-group">
												<label for="inputGst" class="col-sm-2 control-label">Featured Image</label>
												<div class="col-sm-10">
													<?php echo form_upload($input['product_categories']); ?>
							                          <?php echo form_error('product_categories'); ?>
													
												</div>
											</div>
										</div> -->
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputDesciption" class="col-sm-2 control-label">Desciption</label>
												<div class="col-sm-10">
													<?php echo form_input($input['description']);?>
													<?php echo form_error('data[products][description]');?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputMetaTitle" class="col-sm-2 control-label">Meta Title</label>
												<div class="col-sm-10">
													<?php echo form_input($input['meta_title']);?>
													<?php echo form_error('data[products][meta_title]');?>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputMetaDesciption" class="col-sm-2 control-label">Meta Desciption</label>
												<div class="col-sm-10">
													<?php echo form_input($input['meta_description']);?>
													<?php echo form_error('data[products][meta_description]');?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputMetaKeyword" class="col-sm-2 control-label">Meta Keyword</label>
												<div class="col-sm-10">
													<?php echo form_input($input['meta_keyword']);?>
													<?php echo form_error('data[products][meta_keyword]');?>
												</div>
											</div>
										</div>
									</div>
										<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputIsSale" class="col-sm-2 control-label">Is_Sale</label>
												<div class="col-sm-10">
													<?php echo form_input($input['is_sale']);?>
													<?php echo form_error('data[products][is_sale]');?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputIsNew" class="col-sm-2 control-label">Is_New</label>
												<div class="col-sm-10">
													<?php echo form_input($input['is_new']);?>
													<?php echo form_error('data[products][is_new]');?>
												</div>
											</div>
										</div>
									</div>
										<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputIsGift" class="col-sm-2 control-label">Is_Gift</label>
												<div class="col-sm-10">
													<?php echo form_input($input['is_gift']);?>
													<?php echo form_error('data[products][meta_description]');?>
												</div>
											</div>
										</div>
										
									</div>
									<div class="box-haeder with-border">
										<h2 class="box-title">Product Images</h2>
									</div>
									<div class="box-body" style="overflow-x:scroll">
										<table class="table" id="target">
											<thead>
												<tr>
													<th>Product Image 1</th>
													<th>Product Image 2</th>
													<th>Featured Image</th>
													<th></th>
												</tr>
											</thead>
											<tbody>
												<tr id="0">
													<td><input type="file" name="product_images[0][name]", id="name_0", class="form required">
													</td>
													<td><input type="file" name="product_images[0][image_name_2]", id="image_name_2_0" class="form_required"></td>
													<td><input type="checkbox" name="product_images[0][featured_image]", id="featured_image_0", class="form required"></td>
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
									<button type="new_college" class="btn btn-info pull-left">Add Product Category</button> &nbsp;&nbsp;&nbsp;&nbsp;
									
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

