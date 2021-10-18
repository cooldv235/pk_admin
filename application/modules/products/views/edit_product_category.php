<?php

// If access is requested from anywhere other than index.php then exit
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//echo "<div class = "for-group" >";
$value='';
// /echo $values_posted['product_categories']['dob'];exit;
$input['category_name'] = array(
					"name" => "data[product_categories][category_name]",
					"placeholder" => "Category name(s) *",
					"max_length" => "64",
					"required" => "required",
					"class"=> "form-control",
					"id" => "category_name",
					);


$input['description'] = array(
						"name" => "data[product_categories][description]",
						"placeholder" => "Description (s) *",
						"max_length" => "64",
						"required" => "required",
						"class"=> "form-control",
						"id" => "description",
					);

$input['slug'] = array(
						'name' => "data[product_categories][slug]",
						'placeholder'=> "Slug(s) *",
						"max_length" =>"64",
						"required" =>"required",
						"class" =>"form-control",
						"id" => "slug",
							 );

$input['gst'] = array(
						"name" => "data[product_categories][gst]",
						"placeholder" => "GST *",
						"max_length" => "64",
						"required" => "required",
						"class" => "form-control",
						'id' => "gst"
					);

$input['meta_title'] =  array(
							"name" => "data[product_categories][meta_title]",
							"placeholder" => "Meta Title",
							"max_length" => "100",
							"class" => "form-control",
							"id" => "meta_title",
							 );

$input['meta_keyword'] =  array(
							"name" => "data[product_categories][meta_keyword]",
							"placeholder" => "Meta Keyword",
							"max_length" => "100",
							"class" => "form-control",
							"id" => "meta_keyword",
							 );							

$input['meta_description'] =  array(
							"name" => "data[product_categories][meta_description]",
							"placeholder" => "Meta Description",
							"max_length" => "100",
							"class" => "form-control",
							"id" => "meta_description",
							 );




$input['image_name_1'] =  array(
							"name" => "image_name_1",
							"placeholder" => "Image Name 1 *",
							"class" => "form-control",
							//"type"	=> "file",
							"id" => "image_name_1",
							"value" =>	set_value('image_name_1'),
							 );

$input['image_name_1_2'] =  array(
							"data[product_categories][image_name_1_2]" => $values_posted['product_categories']['image_name_1'],
							"data[product_categories][id]" => $id,
							//"value" =>	$values_posted['product_categories']['logo_image'],
							 );

$input['image_name_2'] =  array(
							"name" => "image_name_2",
							"placeholder" => "Image Name 2 *",
							"class" => "form-control",
							//"type"	=> "file",
							"id" => "image_name_2",
							"value" =>	set_value('image_name_2'),
							 );

$input['image_name_2_2'] =  array(
							"data[product_categories][image_name_2_2]" => $values_posted['product_categories']['image_name_2'],
							"data[product_categories][id]" => $id,
							//"value" =>	$values_posted['product_categories']['logo_image'],
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
		Module :: product_categories
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i>Dashboard</a></li>
		<li><a href="<?php echo base_url().'product_categories'; ?>" title="product_categories">product_categories</a></li>
		
	</ol>
</section>
<!--Main content -->
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- Custom Tabs -->
			<?php 
			
           	if($this->session->flashdata('message') !== FALSE) {
	            $msg = $this->session->flashdata('message');
	            //print_r($msg);?>
	          	<div class = "<?php echo $msg['class'];?>">
	                <?php echo $msg['message'];?>
	          	</div>
        	<?php } ?>
        	<div class="nav-tabs-custom">
				
				<div class="tab-content">
				
					<?php  
					echo form_open_multipart('products/edit_product_categories'."/".$id, ['class'=>'form-horizontal', 'id'=>'edit_product_categories'])
					?>
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">Existing Product Category</h3>
							</div><!-- /box-header -->
							<!-- form start -->
							<div class="box-body">
								<div class ="row">
									<div class="col-md-6">
										<div class="form-group">
											<?php /*echo '<pre>';
											print_r($values_posted);	
											echo '</pre>';*/
											 ?>
											<label for="inputParent_id" class="col-sm-2 control-label">Parent</label>
											<div class="col-sm-10">
												<?php 
												echo form_dropdown('data[product_categories][parent_id]', $option['parent'], $values_posted['product_categories']['parent_id'], 'class="form-control select2" id="parent_id" style="width:100%"');

												 ?>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="inputCategoryName" class="col-sm-2 control-label">Category Name</label>
											<div class="col-sm-10">
												<?php echo form_input($input['category_name']); ?>
												
											      <?php echo form_error('category_name'); ?>
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
												
											      <?php echo form_error('description'); ?>
											</div>
										</div>
									</div>
										<div class="col-md-6">
											<div class="form-group">                          
												<label for="inputSlug" class="col-sm-2 control-label">Slug</label>
												<div class="col-sm-10">
													<?php echo form_input($input['slug']); ?>
													<?php echo form_error('slug'); ?>
												</div>
											</div>
										</div>
									</div><!-- /row -->
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">                          
												<label for="inputImageName1" class="col-sm-2 control-label">Image Name 1</label>
												<div class="col-sm-10">
													<?php echo form_upload($input['image_name_1']); ?>
													<?php echo form_hidden($input['image_name_1_2']); ?>
													<img src="<?php echo base_url().'assets/uploads/'.(!empty($values_posted['product_categories']['image_name_1'])?'product_categories/'.$values_posted['product_categories']['image_name_1']:'logo.jpg'); ?>" height="80px" width="80px">
													<?php echo form_error('data[product_categories][image_name_1]'); ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">                          
												<label for="inputImageName2" class="col-sm-2 control-label">Image Name 2</label>
												<div class="col-sm-10">
													<?php echo form_upload($input['image_name_2']); ?>
													<?php echo form_hidden($input['image_name_2_2']); ?>
													<img src="<?php echo base_url().'assets/uploads/'.(!empty($values_posted['product_categories']['image_name_2'])?'product_categories/'.$values_posted['product_categories']['image_name_2']:'logo.jpg'); ?>" height="80px" width="80px">
													<?php echo form_error('data[product_categories][image_name_2]'); ?>
												</div>
											</div>
										</div>
									</div><!-- /row -->
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputGst" class="col-sm-2 control-label">GST</label>
												<div class="col-sm-10">
													<?php echo form_input($input['gst']); ?>
													<?php echo form_error('data[product_categories][gst]'); ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputMetaTitle" class="col-sm-2 control-label">Meta Title</label>
												<div class="col-sm-10">
													<?php echo form_input($input['meta_title']); ?>
													<?php echo form_error('data[product_categories][meta_title]'); ?>
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
													<?php echo form_error('data[product_categories][meta_keyword]'); ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputMetaDesciption" class="col-sm-2 control-label">Meta Desciption</label>
												<div class="col-sm-10">
													<?php echo form_input($input['meta_description']); ?>
													<?php echo form_error('data[product_categories][meta_description]'); ?>
												</div>
											</div>
										</div>
									</div><!-- /row -->
								<div class="box-footer">  
									<button type="new_college" class="btn btn-info pull-left">Update</button> &nbsp;&nbsp;&nbsp;&nbsp;
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

