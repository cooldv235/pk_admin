<?php
//print_r($values_posted);
$value='';
$startDate = '';
$endDate = '';
// /echo $values_posted['employees']['published_on'];exit;
if(!empty($values_posted['events']['published_on']) && $values_posted['events']['published_on']!='0000-00-00'){ 
	$value = date('d/m/Y',strtotime($values_posted['events']['published_on']));
}
if(!empty($values_posted['events']['start_date']) && $values_posted['events']['start_date']!='0000-00-00'){ 
	$startDate = date('d/m/Y',strtotime($values_posted['events']['start_date']));
}
if(!empty($values_posted['events']['end_date']) && $values_posted['events']['end_date']!='0000-00-00'){ 
	$endDate = date('d/m/Y',strtotime($values_posted['events']['end_date']));
}
//echo $startDate;echo $endDate;
//print_r($value_posted);
$type 	=	array(
				'id'	=>	'type',
				//'required'	=>	'required',
				'class'	=>	'form-control select2 showInput',
				'style' => 'width:100%',
                'tab-index'=>'2'
				);
$input['title'] = array(
                          "name" => "data[events][title]",
                          "placeholder" => "Title(s) *",
                          "max_length" => "255",
                          "required" => "required",
                          "class" => "form-control",
                          "id" =>"title",
                        'tab-index'=>'3'
                          );
$input['slug'] = array(
                      "name" => "data[events][slug]",
                      "placeholder" => "slug(s) *",
                      "max_length" => "255",
                      "required" => "required",
                      "class" => "form-control slugify",
                      "slug-content" => 'title',
                      "id" => "slug",
                      'tab-index' => 4
                    );


$input['short_description'] = array(
                          "name" => "data[events][short_description]",
                          "placeholder" => "Short Description(s) *",
                          "max_length" => "255",
                          "required" => "required",
                          "class" => "form-control",
                          "id" =>"short_description",
                            'tab-index' => 5
                          );

$input['content'] = array(
                          "name" => "data[events][content]",
                          "placeholder" => "Content(s) *",
                          "required" => "required",
                          "class" => "form-control editor1",
                          "id" => "editor1",
                      'tab-index' => 6
                           );

$input['featured_image'] =  array(
              "name" => "featured_image",
              "class" => "form-control",
              "id" => "featured_image",
              "value" =>  set_value('featured_image'),
                      'tab-index' => 7
               );
               
$input['featured_image2'] = array(
								'data[events][featured_image2]' => $values_posted['events']['featured_image'],
								'data[events][id]' => $id,
							);	

$input['date'] =  array(    
              "name" => "data[events][published_on]",
              "placeholder" => "Published Date *",
              "max_length" => "12",
              "required" => "required",
              "class" => "col-xs-3 form-control datepicker datemask",
              "id"  => "date",
              "value" => $value,
                'tab-index' => 8
               );

$input['start_date'] =  array(    
              "name" => "data[events][start_date]",
              "placeholder" => "From Date *",
              "max_length" => "12",
              "required" => "required",
              "class" => "col-xs-3 form-control datepicker datemask",
              "id"  => "date",
              "value" => $startDate,
                'tab-index' => 9
               );
//echo $startDate; echo $endDate;
$input['end_date'] =  array(    
              "name" => "data[events][end_date]",
              "placeholder" => "To Date *",
              "max_length" => "12",
              "required" => "required",
              "class" => "col-xs-3 form-control datepicker datemask",
              "id"  => "date",
              "value" => $endDate,
                'tab-index' => 10
               );

$state 	=	array(
				'id'	=>	'state_id',
				//'required'	=>	'required',
				'class'	=>	'form-control select2 filter',
				'data-link' => 'cities/getStateWiseCities',
				'data-target' => 'city_id',
				'style' => 'width:100%',
                      'tab-index' => 11
				);

$city 	=	array(
				'id'	=>	'city_id',
				//'required'	=>	'required',
				'class'	=>	'form-control select2 filter',
				'multiple' => 'multiple',
				'style' => 'width:100%',
                      'tab-index' => 12
				);	

$input['is_trend'] = array(
			          "name" => "data[events][is_trend]",
			          "class" => "flat-red",
			          "id" => "is_trend",
			          "type"=> "checkbox",
					    "value" => true,
                      'tab-index' => 13
			         );
$input['is_hot']  = array(
          "name" => "data[events][is_hot]",
          "class" => "flat-red",
          "id" => "is_hot",
          "type" => "checkbox",
          "value" => true,
            'tab-index' => 14
        );
$input['is_active']  = array(
          "name" => "data[events][is_active]",
          "class" => "flat-red",
          "id" => "is_hot",
          "type" => "checkbox",
          "value" => true,
            'tab-index' => 15
        );

$input['is_featured']  = array(
			          "name" => "data[events][is_featured]",
			          "class" => "flat-red",
			          "id" => "is_featured",
			          "type" => "checkbox",
				        "value" => true,
                      'tab-index' => 16
			        );

$input['meta_title'] = array(
                          "name" => "data[events][meta_title]",
                          "placeholder" => "Meta Title",
                          "required" => "required",
                          "class" => "form-control",
                          "id" => "meta_title",
                            'tab-index' => 16
                           );
$input['meta_keyword'] = array(
                          "name" => "data[events][meta_keyword]",
                          "placeholder" => "Meta Keyword",
                          "required" => "required",
                          "class" => "form-control",
                          "id" => "meta_title",
                          "max"=>160,
                            'tab-index' => 17
                           );
            
$input['meta_description'] = array(
                          "name" => "data[events][meta_description]",
                          "placeholder" => "Meta Description",
                          "required" => "required",
                          "class" => "form-control",
                          "id" => "meta_title",
                          "max"=>160,
                      'tab-index' => 18
                           );
/*echo '<pre>';
print_r($value_posted);
echo '</pre>';	*/		
unset($values_posted['events']['start_date']);
unset($values_posted['events']['end_date']);

if(isset($values_posted)) 
	//print_r($values_posted);
	foreach ($values_posted as $post_name => $post_value) {
		//print_r($post_name);
		//print_r($post_value);
		foreach ($post_value as $field_key => $field_value) {
			if(isset($input[$field_key]['type']) && $input[$field_key]['type']=="checkbox" && $field_value==true){
				$input[$field_key]['checked'] = "checked";
			}else{
				$input[$field_key]['value'] = $field_value;
			}
		}
	}


?>
<section class="content-header">
	<h1>Module :: Events</h1>
	<ol class="breadcrumb"> 
		<li><a href="#"><i class="fa fa-dashboard"></i>Dashboard</a></li>
		<li><?php echo anchor(custom_constants::admin_events_listing_url, 'Events'); ?></li>
	</ol>
</section>
<section class="content">
<div class="row">
	<div class="col-md-12">
		<?php if(isset($error)) {
			echo "<div class='alert alert-danger'>";
			echo "<p>" .$form_error."</p>";
			echo "</div>";
		}
		if($this->session->flashdata('message')!== FALSE) {
			$msg = $this->session->flashdata('message');?>
			<div class="<?php echo $msg['class'];?>">
				<?php echo $msg['message'];?>
			</div>
		<?php }
		?>
		<div class="nav-tabs-custom">
			<!-- <ul class="nav nav-tabs">
				<li class="<?php if($tab=="personal_info"){echo "active";} ?>"><a href="#personal_info" data-toggle="tab">Edit Page</a></li>
				
			</ul> -->
			<div class="tab-content">
				<div class="tab-pane <?php if($tab == 'personal_info'){ echo "active";}?>" id="personal_info">
					<?php echo form_open_multipart(custom_constants::edit_events_url."/".$id, ['class' =>'form-horizontal', 'id' => 'events']); ?>
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title">Existing Event</h3>
						</div><!-- /box-header -->
						<div class="box-body">
							<div class="row">
				              <div class="col-md-6">
								<div class="form-group">
									<label for="inputParent" class="col-sm-2 control-label">Event Category</label>
									<div class="col-sm-10">
<?php echo form_dropdown('data[events][event_category_id]', $option['category'], isset($values_posted)?$values_posted['events']['event_category_id']:'',"id='category' required='required' class='form-control select2' tab-index=1"); ?>
										
									</div>
								</div>
				              </div>
				              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="inputType" class="col-sm-2 control-label">Event Type</label>
                                  <div class="col-sm-10">
                                      <?php echo form_dropdown('data[events][type]',$option['type'], isset($values_posted)?$values_posted['events']['type']:'',$type); ?>
                                      <?php echo form_error('data[events][type]'); ?>
                                  </div>
                                </div>
                              </div>
				            </div>
							<div class="row">
				              <div class="col-md-6">
				                <div class="form-group">
				                  <label for="inputtitle" class="col-sm-2 control-label">Events Title</label>
				                  <div class="col-sm-10">
				                   <?php echo form_input($input['title']);?>
				                   <?php echo form_error('data[events][title]');?>
				                  </div>
				                </div>
				              </div>
				            
				              <div class="col-md-6">
				                <div class="form-group">
				                  <label for="inputslug" class="col-sm-2 control-label">Slug</label>
				                  <div class="col-sm-10">
				                   <?php echo form_input($input['slug']);?>
				                   <?php echo form_error('data[events][slug]');?>
				                  </div>
				                </div>
				              </div>
				            </div>
				            <div class="row">
				              <div class="col-md-12">
				                <div class="form-group">
				                  <label for="inputshortDescription" class="col-sm-1 control-label">Short Description</label>
				                  <div class="col-sm-11">
				                   <?php echo form_input($input['short_description']);?>
				                   <?php echo form_error('data[events][short_description]');?>
				                  </div>
				                </div>
				              </div>
				            </div>
				           
				            <div class="row">
				            	<div class="col-md-6">
					                <div class="form-group">
					                	<label for="inputPublishedOn" class="col-sm-2 control-label">Start Date</label>
				                  		<div class="col-sm-10">
				                  			<?php echo form_input($input['start_date']);?>
				                  			<?php echo form_error('data[events][start_date]'); ?>
				                  		</div>
					                </div>
					            </div>
					            <div class="col-md-6">
					                <div class="form-group">
					                	<label for="inputEndDate" class="col-sm-2 control-label">End Date</label>
				                  		<div class="col-sm-10">
				                  			<?php echo form_input($input['end_date']);?>
				                  			<?php echo form_error('data[events][end_date]'); ?>
				                  		</div>
					                </div>
					            </div>
				            </div>
				            
				            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="inputMetatitle" class="col-sm-2 control-label">Meta Title</label>
                  <div class="col-sm-10">
                   <?php echo form_input($input['meta_title']);?>
                   <?php echo form_error('data[events][meta_title]');?>
                  </div>
                </div>
              </div>
              
                
              <div class="col-md-6">
                <div class="form-group">
                  <label for="inputMetakeyword" class="col-sm-2 control-label">Meta Keyword</label>
                  <div class="col-sm-10">
                   <?php echo form_input($input['meta_keyword']);?>
                   <?php echo form_error('data[events][meta_keyword]');?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
	            <div class="col-md-6">
	              <div class="form-group">
	                  <label for="inputMetadescription" class="col-sm-2 control-label">Meta Description</label>
	                  <div class="col-sm-10">
	                   <?php echo form_input($input['meta_description']);?>
	                   <?php echo form_error('data[events][meta_description]');?>
	                  </div>
	                </div>
	              </div>
	            <div class="col-md-6">
	                <div class="form-group">
	                  <label for="inputIsActive" class="col-sm-2 control-label">Is Active</label>
	                  <div class="col-sm-10">
	                    <?php echo form_input($input['is_active']);?>
	                    <?php echo form_error('data[events][is_active]');?>
	                  </div>
	                </div>
	              </div>
			</div><!-- /box-body -->
						<div class="box-footer">
							<button type="submit" class="btn btn-info pull-left">Update</button>
							<?php echo nbs(3); ?>
							<button type="reset" class="btn btn-info">Reset</button>
						</div><!-- /box-footer -->
					</div><!-- /box box-info -->
					<?php echo form_close(); ?>
				</div> 
				
			</div>
		</div><!-- /nav-tabs-custom -->
	</div><!-- /col-md-12 -->
</div>
</section>