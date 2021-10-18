<?php

// If access is requested from anywhere other than index.php then exit
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$input['faq_category'] = array(
						"name" => "faques[faq_category]",
						"placeholder" => "FAQ Category *",
						"class"=> "form-control viewInput",
						"id" => "faq_category",

					);

$input['module'] = array(
						"name" => "faques[module]",
						"placeholder" => "Module Name *",
						"class"=> "form-control viewInput",
						"id" => "module",

					);
//echo "<div class = "for-group" >";
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
	    Module :: FAQs
	</h1>
	<ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i>Dashboard</a></li>
	    <li>
	      <?php echo anchor(custom_constants::admin_faq_listing_url, 'FAQs', 'title="products"'); ?>
	    </li>
	    <li>
	      <?php echo anchor(custom_constants::new_faq_url, 'New FAQ'); ?>
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
						echo form_open_multipart(custom_constants::new_faq_url, ['class'=>'form-horizontal', 'id'=>'new_product']);
							
							if($this->session->flashdata('message') !== FALSE) {
								$msg = $this->session->flashdata('message');?>
								<div class = "<?php echo $msg['class'];?>">
									<?php echo $msg['message'];?>
								</div>
							<?php } ?>
							<div class="box box-info">
								<div class="box-header with-border">
									<h3 class="box-title"><i class="fa fa-shopping-bag margin-r-5"></i> New FAQ</h3>
								</div><!-- /box-header -->
								<!-- form start -->
								<div class="box-body">
									
									<div class="box-haeder with-border">
										<h2 class="box-title">FAQ</h2>
									</div>
									<div class="box-body" style="overflow-x:scroll">
										<table class="table" id="target">
											<thead>
												<tr>
													<th>Module</th>
													<th>FAQ Category</th>
													<th>Question</th>
													<th>Answer</th>
													<th>Is Active</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody> 
											<?php if(count($faques)>0) {
												
												foreach ($faques as $faquesKey => $faq) {?>
													<tr id="<?php echo $faquesKey;?>">
														<td><input type="hidden" name="faques[<?php echo $faquesKey;?>][id]" value="<?php echo $faq['id'];?>" id="id_<?php echo $faquesKey;?>"><input type="text" name="faques[<?=$faquesKey?>][module]" class="form-control" id="module_<?=$faquesKey?>" value="<?php echo $faq['module'];?>"></td>
														<td><?php echo form_dropdown("faques[".$faquesKey."][faq_category]",$option['category'],isset($faq['faq_category'])?$faq['faq_category']:'',  "id='faq_category_id_".$faquesKey."' class='form-control select2 viewInput' style ='width:100%'' input-data-target='faq_category_".$faquesKey."'");	?><input type="text" name="faques[<?php echo $faquesKey; ?>][faq_category_input]" class="form-control" id="faq_category_<?php echo $faquesKey;?>" style="display:none" placeholder="Category Not found? Enter here"></td>
														<td><input type="text" name="faques[<?php echo $faquesKey;?>][question]" class="form-control" id="question_<?php echo $faquesKey; ?>" value="<?php echo $faq['question'];?>"></td>
														<td><input type="text" name="faques[<?php echo $faquesKey;?>][answer]" class="form-control" id="answer_0" value="<?php echo $faq['answer'];?>"></td>
														<td><input type="checkbox" name="faques[<?php echo $faquesKey; ?>][is_active]" value="true" id="is_active_<?php echo $faquesKey; ?>" class="" <?php if($faq['is_active']){ echo "checked=checked";} ?>>	</td>
														<td>	<?php if($faquesKey>0) {?>		<a href="#" class="removebutton calculate" data-id="<?php echo $faq['id']; ?>" data-link='faqs/deleteFaqDetails' data-table='faques'> <span class="glyphicon glyphicon-trash"></span></a>	<?php }?></td>
													</tr>
													<?php }
												}else {
												//echo "hii";exit; ?>
													<tr id="0">
														<td><input type="text" name="faques[0][module]" class="form-control" id="module_0" ></td>
														<td><?php echo form_dropdown("faques[0][faq_category]",$option['category'],''/*isset($values_posted['products'])?$values_posted['pack_products']['product_id']:''*/,  "id='faq_category_id_0' class='form-control select2 viewInput' required='required' input-data-target='faq_category_0'");?>
															<input type="text" name="faques[0][faq_category_input]" class="form-control" id="faq_category_0" placeholder="Category Not found? Enter here" >
														</td>
														<td><input type="text" name="faques[0][question]" class="form-control" id="question_0" ></td>
														<td>
															<input type="text" name="faques[0][answer]" class="form-control" id="answer_0" ></td>
															<td><input type="checkbox" name="faques[0][is_active]" id="is_active_0" class="" >	</td>
														<td></td>
													</tr>
													<?php }?>
											</tbody>
											<tfoot>
												<tr>
											   		<td colspan="9"><button type="button" id="AddMoreFAQs" class="btn btn-info pull-right AddMoreRow">Add More</button>
											   		</td>
											   	</tr>
											</tfoot>
										</table>
									</div>
									
								<div class="box-footer">  
									<button type="new_college" class="btn btn-info pull-left">Add FAQ</button> &nbsp;&nbsp;&nbsp;&nbsp;
									
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

