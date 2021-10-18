<?php

// If access is requested from anywhere other than index.php then exit
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//echo "<div class = "for-group" >";
$input['parent_id'] = array(
						"name" => "data[blogs_categories][parent_id]",
						"required" => "required",
						"class" => "form-control select2",
						'id' => "parent_id"
					);

$input['category_name'] = array(
						"name" => "data[blogs_categories][category_name]",
						"placeholder" => "Category Name *",
						"max_length" => "255",
						"required" => "required",
						"class" => "form-control",
						'id' => "category_name"
					);

$input['description'] =  array(
							"name" => "data[blogs_categories][description]",
                          "placeholder" => "Description *",
                          //"required" => "required",
                          "class" => "form-control editor1",
                          "id" => "editor1",
							 );

$input['slug'] =  array(
							"name" => "data[blogs_categories][slug]",
							"placeholder" => "slug *",
							"max_length" => "255",
							"required" => "required",
							"class" => "form-control slugify",
							"id" => "slug",
						);

$input['image_name_1'] = array(
						"name" => "image_name_1",
						"class"=> "form-control",
						"id" => "image_name_1",
/*						"value" => set_value('image_name_1'),
*/					);

$input['image_name_2'] =  array(
							"name" => "image_name_2",
							"placeholder" => "Image Name 2 *",
							//"required" => "required",
							"class" => "form-control",
							//"type"	=> "file",
							"id" => "image_name_2",
/*							"value" =>	set_value('blogs_categories'),
*/							 );

$input['meta_title'] =  array(
							"name" => "data[blogs_categories][meta_title]",
							"placeholder" => "Meta Title",
							"max_length" => "160",
							/*"required" => "required",*/
							"class" => "form-control",
							"id" => "meta_title",
						);

$input['meta_keyword'] =  array(
							"name" => "data[blogs_categories][meta_keyword]",
							"placeholder" => "Meta Keyword",
							"max_length" => "160",
							/*"required" => "required",*/
							"class" => "form-control",
							"id" => "meta_keyword",
						);

$input['meta_description'] =  array(
							"name" => "data[blogs_categories][meta_description]",
							"placeholder" => "Meta Description",
							"max_length" => "160",
							/*"required" => "required",*/
							"class" => "form-control",
							"id" => "meta_description",
						);
/*$input['description'] =  array(
							"name" => "data[blogs_categories][description]",
							"placeholder" => "Description",
							"required" => "required",
							"class" => "form-control",
							"id" => "description",
						);*/

$input['is_active'] =  array(
							"name" => "data[blogs_categories][is_active]",
							"type" => "checkbox",
							"class" => "flat-red",
							"id" => "is_active",
							"value" => true
						);

/*if(isset($values_posted['data']['blogs_categories']['is_active'])){
	$input['is_active'] = "checked='checked'";
	unset($values_posted['data']['blogs_categories']['is_active']);
}*/

// If form has been submitted with errors populate fields that were already filled
if(isset($values_posted))
{	
//print_r($values_posted);

	foreach($values_posted['data'] as $post_name => $post_value)
	{ 
		foreach ($post_value as $field_key => $field_value) {
		//print_r($field_value);
			# code...
			//$input[$field_key]['value'] = $field_value;
			if(isset($input[$field_key]['type']) && $input[$field_key]['type']=="checkbox" && $field_value==true){
				$input[$field_key]['checked'] = "checked";
			}else{
				$input[$field_key]['value'] = $field_value;
			}
		}
	}
}
/*echo '<pre>';
print_r($input);
echo '</pre>';*/
?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
	    <?=$title?>
	</h1>
	<ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i>Dashboard</a></li>
	    <li>
	      <?php echo anchor(custom_constants::admin_blogs_category_listing_url, 'blogs Categories', 'title="blogs_category" id="blogs_categories"'); ?>
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
						echo form_open_multipart(custom_constants::new_blogs_category_url, ['class'=>'form-horizontal', 'id'=>'blogs_categories']);
							
							if($this->session->flashdata('message') !== FALSE) {
								$msg = $this->session->flashdata('message');?>
								<div class = "<?php echo $msg['class'];?>">
									<?php echo $msg['message'];?>
								</div>
							<?php } ?>
							<div class="box box-info">
								<div class="box-header with-border">
									<h3 class="box-title"><?=$heading?></h3>
								</div><!-- /box-header -->
								<!-- form start -->
								<div class="box-body">
									
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputParent_id" class="col-sm-2 control-label">Parent Category</label>
												<div class="col-sm-10">
													<?php echo form_dropdown('data[blogs_categories][parent_id]', $option['parent'], isset($values_posted)?$values_posted['data']['blogs_categories']['parent_id']:'', $input['parent_id']); ?>
													<?php echo form_error('data[blogs_categories][parent_id]'); ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputCategory_name" class="col-sm-2 control-label">Category Name</label>
												<div class="col-sm-10">
													<?php echo form_input($input['category_name']); ?>
													<?php echo form_error('data[blogs_categories][category_name]'); ?>
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
													<?php echo form_error('data[blogs_categories][slug]'); ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputImage_name_1" class="col-sm-2 control-label">Image 1</label>
												<div class="col-sm-10">
							                      <?php echo form_upload($input['image_name_1']); ?>
							                          <?php echo form_error('data[blogs_categories][image_name_1]'); ?>
							                  </div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputInput_name_2" class="col-sm-2 control-label">Image 2</label>
												<div class="col-sm-10">
							                      <?php echo form_upload($input['image_name_2']); ?>
							                          <?php echo form_error('data[blogs_categories][image_name_2]'); ?>
							                  </div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputMeta_title" class="col-sm-2 control-label">Meta Title</label>
												<div class="col-sm-10">
							                      <?php echo form_input($input['meta_title']); ?>
							                          <?php echo form_error('data[blogs_categories][meta_title]'); ?>
							                  </div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputMeta_keyword" class="col-sm-2 control-label">Meta Keywords</label>
												<div class="col-sm-10">
													<?php echo form_input($input['meta_keyword']);?>
													<?php echo form_error('data[blogs_categories][meta_keyword]');?>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputMeta_description" class="col-sm-2 control-label">Meta Description</label>
												<div class="col-sm-10">
													<?php echo form_input($input['meta_description']);?>
													<?php echo form_error('data[blogs_categories][meta_description]');?>
												</div>
											</div>
										</div>
										
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputIs_active" class="col-sm-2 control-label">Is Active</label>
												<div class="col-sm-10">
													<?php echo form_input($input['is_active']);?>
													<?php echo form_error('data[blogs_categories][is_active]');?>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputDescription" class="col-sm-1 control-label">Description</label>
												<div class="col-sm-11">
													<?php echo form_input($input['description']);?>
                  									<?php echo form_error('data[blogs_categories][description]'); ?>
												</div>
											</div>
										</div>
									</div>
								</div><!-- /box -->
								<div class="box-footer">  
									<button type="submit" class="btn btn-info pull-left">Add Blog Category</button> &nbsp;&nbsp;&nbsp;&nbsp;
									
								</div>
								<!-- /.box-footer -->
							</div>
						<?php echo form_close(); ?> 
					
					
					
				</div><!-- /tab-content -->
			</div><!-- end of nav tab -->
		</div><!-- col-md-12 -->
	</div><!-- /nav-tabs-custom -->
</section> <!-- /section-->

