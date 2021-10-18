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
							"class" =>"form-control",
							"id" => "slug",
							 );

$input['base_price'] = array(
						"name" => "data[products][base_price]",
						"placeholder" => "Base Price (s) *",
						"max_length" => "64",
						"required" => "required",
						"class"=> "form-control",
						"id" => "base_price",
					);


$input['description'] = array(
						"name" => "data[products][description]",
						"placeholder" => "Description (s) *",
						"max_length" => "64",
						"required" => "required",
						"class"=> "form-control",
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

$input['image_name_1'] =  array(
							"name" => "image_name_1",
							"class" => "form-control",
							//"type"	=> "file",
							"id" => "image_name_1",
							"value" =>	set_value('image_name_1'),
							 );
	
/*$input['image_name_1_2'] =  array(
							"data[product_images][image_name_1_2]" => $values_posted['product_images']['image_name_1'],
							"data[product_images][id]" => $id,
							//"value" =>	$values_posted['product_images']['logo_image'],
							 );*/


$input['is_sale'] = array(
					"name" => "data[products][is_sale]",
					"class" => "flat-red",
					"id" => "is_sale",
					"type"=> "checkbox",
					"checked" => (True == $values_posted['products']['is_sale'])?"checked":'',
					"value" => true,
					);

$input['is_gift'] = array(
					"name" => "data[products][is_gift]",
					"class" => "flat-red",
					"id" => "is_gift",
					"type"=> "checkbox",
					"checked" => (True == $values_posted['products']['is_gift'])?"checked":'',
					"value" => true,
					);

$input['is_new'] = array(
					"name" => "data[products][is_new]",
					"class" => "flat-red",
					"id" => "is_new",
					"type"=> "checkbox",
					"checked" => (True == $values_posted['products']['is_sale'])?"checked":'',
					"value" => true,
					);

// If form has been submitted with errors populate fields that were already filled
//print_r($values_posted);
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
			if(isset($form_error))
			{
				echo "<div class='alert alert-danger'>";
				echo "<p>" . $form_error . "</p>";
				echo "</div>";
			}
           	if($this->session->flashdata('message') !== FALSE) {
	            $msg = $this->session->flashdata('message');?>
	          	<div class = "<?php echo $msg['class'];?>">
	                <?php echo $msg['message'];?>
	          	</div>
        	<?php } ?>
        	<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="<?php if($tab=="product_details"){echo "active";} ?>"><a href="#product_images" data-toggle="tab">Product Details</a></li>

					<li class="<?php if($tab=="product_images"){echo "active";} ?>"><a href="#product_images" data-toggle="tab">Product Images</a></li>
					<li class="<?php if($tab=="order_details"){echo "active";} ?>"><a href="#order_details" data-toggle="tab">Order Details</a></li>
					<li class="<?php if($tab=="document"){echo "active";} ?>"><a href="#document" data-toggle="tab">Document</a></li>
					
					<!-- <li class="<?php if($tab=="login"){echo "active";} ?>"><a href="#login" data-toggle="tab">Login</a></li> -->
					<li class="pull-right">
						<?php echo anchor("companies/admin_company_details/".$id, '<i class="fa fa-sticky-note"></i>', ['class'=>'text-muted', 'title'=>'View Details']);  ?>
					</li>
				</ul> 
				<div class="tab-content">
					<div class="tab-pane <?php if($tab=="product_images"){echo "active";} ?>" id="personal_info"> 
						<?php //echo form_open_multipart(custom_constants::edit_employee_url ."/".$id, ['class'=>'form-horizontal', 'id'=>'register_user']); 
						echo form_open_multipart('products/edit_product_details'."/".$id, ['class'=>'form-horizontal', 'id'=>'edit_products'])
						?>
							<div class="box box-info">
								<div class="box-header with-border">
									<h3 class="box-title">Existing Product Images</h3>
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
									<div class ="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputParent" class="col-sm-2 control-label">Product Category</label>
												<div class="col-sm-10">
													<?php //echo form_dropdown('data[products][parent_id]', $option['parent'], $products['id'], "id='parent_id' class='form-control' required='required'"); ?>
													
														
													 <select name="data[products][product_category_id]" id='product_category_id' class="form-control select2">
														
														<?php foreach($productCategories as $productKey => $productCategory) {?>
														<option value="<?php echo $productCategory['id'];?>" <?php if($productCategory['id'] == $values_posted['products']['product_category_id']){echo " selected='selected'";}?>><?php echo $productCategory['category_name'];?></option>
														<?php } ?>
													</select>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputProductType" class="col-sm-2 control-label">Product Type</label>
												<div class="col-sm-10">
													<select name = 'data[products][product_type]' id='product_type', class="form-control select2">

														<option value="<?php echo $products['id'];; ?>"><?php echo $products['product_type'];; ?></option>
													</select>
													
												      <?php echo form_error('category_name'); ?>
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
											 <label for="inputBasePrice" class="col-sm-2 control-label">Base Price</label>
												<div class="col-sm-10">
													<?php echo form_input($input['base_price']); ?>
													<?php echo form_error('base_price'); ?>
												</div>                      
											</div>
										</div>
									</div><!-- /row -->
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputDescription" class="col-sm-2 control-label">Description</label>
												<div class="col-sm-10">
													<?php echo form_input($input['description']); ?>
													<?php echo form_error('data[products][description]'); ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputMetaTitle" class="col-sm-2 control-label">Meta Title</label>
												<div class="col-sm-10">
													<?php echo form_input($input['meta_title']); ?>
													<?php echo form_error('data[products][meta_title]'); ?>
												</div>
											</div>
										</div>
									</div><!-- /row -->
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputMetaKeyWord" class="col-sm-2 control-label">Meta KeyWord</label>
												<div class="col-sm-10">
													<?php echo form_input($input['meta_keyword']); ?>
													<?php echo form_error('data[products][meta_keyword]'); ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputMetaDesciption" class="col-sm-2 control-label">Meta Desciption</label>
												<div class="col-sm-10">
													<?php echo form_input($input['meta_description']); ?>
													<?php echo form_error('data[products][meta_description]'); ?>
												</div>
											</div>
										</div>
									</div><!-- /row -->
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputIsSale" class="col-sm-2 control-label">Is Sale</label>
												<div class="col-sm-10">
													<?php echo form_input($input['is_sale']); ?>
													<?php echo form_error('data[products][is_sale]'); ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputIsNew" class="col-sm-2 control-label">Is New</label>
												<div class="col-sm-10">
													<?php echo form_input($input['is_new']); ?>
													<?php echo form_error('data[products][is_new]'); ?>
												</div>
											</div>
										</div>
									</div><!-- /row -->
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputIsGift" class="col-sm-2 control-label">Is Gift</label>
												<div class="col-sm-10">
													<?php echo form_input($input['is_gift']); ?>
													<?php echo form_error('data[products][is_gift]'); ?>
												</div>
											</div>
										</div>
									</div><!-- /row -->
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
												<!-- <?php print_r($values_posted['product_images']['image_name_1']);?> -->
													<?php foreach($product_images as $productImageKey =>$product_image) {
														//print_r($product_image);
														//print_r($product_image['image_name_1']);
														//print_r($product_image['image_name_2']);
														//print_r($product_image['featured_image']);
														?>

												<tr id="<?php echo $productImageKey; ?>">
													<td>
														<input type="hidden" name="product_images[<?php echo $productImageKey;?>][id]" class="form-control" id="id_<?php echo $productImageKey;?>" value="<?php echo $product_image['id']; ?>">
														<input type="file" name="product_images[<?php echo $productImageKey; ?>][image_name_1]", id="image_name_1_<?php echo $productImageKey; ?>", class="form required">
														<input type="hidden" name=product_images[<?php echo $productImageKey; ?>][image_name_1_2]" id="image_name_1_<?php echo $productImageKey; ?>", value= "<?php echo $product_image['image_name_1']; ?>"class="form required">
														
													<img src="<?php echo base_url().'assets/uploads/'.(!empty($product_image['image_name_1'])?'products/'.$product_image['image_name_1']:'no_image.jpg'); ?>" height="80px" width="80px">
													
													</td>
													<td>
														<input type="file" name="product_images[<?php echo $productImageKey; ?>][image_name_2]", id="image_name_1_<?php echo $productImageKey; ?>", class="form required">
														<input type="hidden" name=product_images[<?php echo $productImageKey; ?>][image_name_2_2]" id="image_name_1_<?php echo $productImageKey; ?>", value= "<?php echo $product_image['image_name_2'];?>"class="form required">
														
													<img src="<?php echo base_url().'assets/uploads/'.(!empty($product_image['image_name_2'])?'products/'.$product_image['image_name_2']:'no_image.jpg'); ?>" 	height="80px" width="80px">
														<?php //echo form_input('data[product_image']);?>
													</td>
													
													<td><input type="checkbox" name="product_images[<?php echo $productImageKey; ?>][featured_image]", id="featured_image_<?php echo $productImageKey; ?>", <?php if($product_image['featured_image']){echo "checked='checked'";}?> class="form required"></td>
													<td></td>
												</tr>
													<?php } ?>
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
									<button type="new_product" class="btn btn-info pull-left">Update</button> &nbsp;&nbsp;&nbsp;&nbsp;
									<?php /*echo nbs(3);*/ ?>
									<button type="submit" class="btn btn-info">cancel</button>
								</div>
								<!-- /.box-footer -->
							</div><!-- /box -->
							</div>
						<?php echo form_close(); ?> 
					<!-- </div> -->
				</div>
				<div class="tab content">
					echo form_open_multipart('products/edit_product_details'."/".$id, ['class'=>'form-horizontal', 'id'=>'edit_products'])
						?>
							<div class="box box-info">
								<div class="box-header with-border">
									<h3 class="box-title">Existing Product</h3>
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
									<div class ="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputParent" class="col-sm-2 control-label">Product Category</label>
												<div class="col-sm-10">
													<?php //echo form_dropdown('data[products][parent_id]', $option['parent'], $products['id'], "id='parent_id' class='form-control' required='required'"); ?>
													
														
													 <select name="data[products][product_category_id]" id='product_category_id' class="form-control select2">
														
														<?php foreach($productCategories as $productKey => $productCategory) {?>
														<option value="<?php echo $productCategory['id'];?>" <?php if($productCategory['id'] == $values_posted['products']['product_category_id']){echo " selected='selected'";}?>><?php echo $productCategory['category_name'];?></option>
														<?php } ?>
													</select>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputProductType" class="col-sm-2 control-label">Product Type</label>
												<div class="col-sm-10">
													<select name = 'data[products][product_type]' id='product_type', class="form-control select2">

														<option value="<?php echo $products['id'];; ?>"><?php echo $products['product_type'];; ?></option>
													</select>
													
												      <?php echo form_error('category_name'); ?>
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
											 <label for="inputBasePrice" class="col-sm-2 control-label">Base Price</label>
												<div class="col-sm-10">
													<?php echo form_input($input['base_price']); ?>
													<?php echo form_error('base_price'); ?>
												</div>                      
											</div>
										</div>
									</div><!-- /row -->
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputDescription" class="col-sm-2 control-label">Description</label>
												<div class="col-sm-10">
													<?php echo form_input($input['description']); ?>
													<?php echo form_error('data[products][description]'); ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputMetaTitle" class="col-sm-2 control-label">Meta Title</label>
												<div class="col-sm-10">
													<?php echo form_input($input['meta_title']); ?>
													<?php echo form_error('data[products][meta_title]'); ?>
												</div>
											</div>
										</div>
									</div><!-- /row -->
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputMetaKeyWord" class="col-sm-2 control-label">Meta KeyWord</label>
												<div class="col-sm-10">
													<?php echo form_input($input['meta_keyword']); ?>
													<?php echo form_error('data[products][meta_keyword]'); ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputMetaDesciption" class="col-sm-2 control-label">Meta Desciption</label>
												<div class="col-sm-10">
													<?php echo form_input($input['meta_description']); ?>
													<?php echo form_error('data[products][meta_description]'); ?>
												</div>
											</div>
										</div>
									</div><!-- /row -->
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputIsSale" class="col-sm-2 control-label">Is Sale</label>
												<div class="col-sm-10">
													<?php echo form_input($input['is_sale']); ?>
													<?php echo form_error('data[products][is_sale]'); ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputIsNew" class="col-sm-2 control-label">Is New</label>
												<div class="col-sm-10">
													<?php echo form_input($input['is_new']); ?>
													<?php echo form_error('data[products][is_new]'); ?>
												</div>
											</div>
										</div>
									</div><!-- /row -->
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputIsGift" class="col-sm-2 control-label">Is Gift</label>
												<div class="col-sm-10">
													<?php echo form_input($input['is_gift']); ?>
													<?php echo form_error('data[products][is_gift]'); ?>
												</div>
											</div>
										</div>
									</div><!-- /row -->
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
												<!-- <?php print_r($values_posted['product_images']['image_name_1']);?> -->
													<?php foreach($product_images as $productImageKey =>$product_image) {
														//print_r($product_image);
														//print_r($product_image['image_name_1']);
														//print_r($product_image['image_name_2']);
														//print_r($product_image['featured_image']);
														?>

												<tr id="<?php echo $productImageKey; ?>">
													<td>
														<input type="hidden" name="product_images[<?php echo $productImageKey;?>][id]" class="form-control" id="id_<?php echo $productImageKey;?>" value="<?php echo $product_image['id']; ?>">
														<input type="file" name="product_images[<?php echo $productImageKey; ?>][image_name_1]", id="image_name_1_<?php echo $productImageKey; ?>", class="form required">
														<input type="hidden" name=product_images[<?php echo $productImageKey; ?>][image_name_1_2]" id="image_name_1_<?php echo $productImageKey; ?>", value= "<?php echo $product_image['image_name_1']; ?>"class="form required">
														
													<img src="<?php echo base_url().'assets/uploads/'.(!empty($product_image['image_name_1'])?'products/'.$product_image['image_name_1']:'no_image.jpg'); ?>" height="80px" width="80px">
													
													</td>
													<td>
														<input type="file" name="product_images[<?php echo $productImageKey; ?>][image_name_2]", id="image_name_1_<?php echo $productImageKey; ?>", class="form required">
														<input type="hidden" name=product_images[<?php echo $productImageKey; ?>][image_name_2_2]" id="image_name_1_<?php echo $productImageKey; ?>", value= "<?php echo $product_image['image_name_2'];?>"class="form required">
														
													<img src="<?php echo base_url().'assets/uploads/'.(!empty($product_image['image_name_2'])?'products/'.$product_image['image_name_2']:'no_image.jpg'); ?>" 	height="80px" width="80px">
														<?php //echo form_input('data[product_image']);?>
													</td>
													
													<td><input type="checkbox" name="product_images[<?php echo $productImageKey; ?>][featured_image]", id="featured_image_<?php echo $productImageKey; ?>", <?php if($product_image['featured_image']){echo "checked='checked'";}?> class="form required"></td>
													<td></td>
												</tr>
													<?php } ?>
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
									<button type="new_product" class="btn btn-info pull-left">Update</button> &nbsp;&nbsp;&nbsp;&nbsp;
									<?php /*echo nbs(3);*/ ?>
									<button type="submit" class="btn btn-info">cancel</button>
								</div>
								<!-- /.box-footer -->
							</div><!-- /box -->
							</div>
						<?php echo form_close(); ?> 
					<!-- </div> -->
				</div>
			</div><!-- /nav-tabs-custom -->
        </div>
    </div>
</section>

