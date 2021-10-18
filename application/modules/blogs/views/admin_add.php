<?php 
$tab = "basic details";
if(!defined('BASEPATH')) exit('No direct script access allowed ');

$type 	=	array(
				'id'	=>	'type',
				//'required'	=>	'required',
				'class'	=>	'form-control select2 showInput',
				'style' => 'width:100%',
                'tab-index'=>'2'
				);
				
$input['title'] = array(
                          "name" => "data[blogs][title]",
                          "placeholder" => "Title(s) *",
                          "max_length" => "255",
                          "required" => "required",
                          "class" => "form-control",
                          "id" =>"title",
                          'tab-index'=>'3'
                          );
$input['slug'] = array(
                      "name" => "data[blogs][slug]",
                      "placeholder" => "slug(s) *",
                      "max_length" => "255",
                      "required" => "required",
                      "class" => "form-control slugify",
                      "slug-content" => 'title',
                      "id" => "slug",
                        'tab-index'=>'4'
                    );
                          

$input['short_description'] = array(
                          "name" => "data[blogs][short_description]",
                          "placeholder" => "Short Description *",
                          "max_length" => "255",
                          "required" => "required",
                          "class" => "form-control",
                          "id" =>"title",
                          'tab-index'=>'5'
                          );

$input['content'] = array(
                          "name" => "data[blogs][content]",
                          "placeholder" => "Content(s) *",
                          "required" => "required",
                          "class" => "form-control editor1",
                          "id" => "editor1",
                          'tab-index'=>'6',
                          'value' => set_value('data[blogs][content]')
                           );


$input['featured_image'] =  array(
              "name" => "featured_image",
              "class" => "form-control",
              "id" => "featured_image",
              "value" =>  set_value('featured_image'),
              'tab-index'=>'7',
               );

$input['date'] =  array(    
              "name" => "data[blogs][published_on]",
              "placeholder" => "Published Date *",
              "max_length" => "12",
              "required" => "required",
              "class" => "col-xs-3 form-control datepicker datemask",
              "id"  => "date",
                          'tab-index'=>'8'
               );

$state 	=	array(
				'id'	=>	'state_id',
				//'required'	=>	'required',
				'class'	=>	'form-control select2 filter',
				'data-link' => 'cities/getStateWiseCities',
				'data-target' => 'city_id',
				"tab-index" => 9,
				'style' => 'width:100%',
				);
				


$city 	=	array(
				'id'	=>	'city_id',
				//'required'	=>	'required',
				'class'	=>	'form-control select2',
				"tab-index" => 10,
				'multiple' => 'multiple',
				'style' => 'width:100%',
				);

$input['is_trend'] = array(
          "name" => "data[blogs][is_trend]",
          "class" => "flat-red",
          "id" => "is_trend",
          "type"=> "checkbox",
          "value" => true,
          'tab-index'=>'11',
          'checked'=> set_value('data[blogs][is_trend]')?'checked':''
          );
          
$input['is_hot']  = array(
          "name" => "data[blogs][is_hot]",
          "class" => "flat-red",
          "id" => "is_hot",
          "type" => "checkbox",
          "value" => true,
          'tab-index'=>'12',
          'checked'=> set_value('data[blogs][is_hot]')?'checked':''
        );

$input['is_featured']  = array(
          "name" => "data[blogs][is_featured]",
          "class" => "flat-red",
          "id" => "is_featured",
          "type" => "checkbox",
          "value" => true,
          'tab-index'=>'13',
          'checked'=> set_value('data[blogs][is_featured]')?'checked':''
        );


        
$input['meta_title'] = array(
                          "name" => "data[blogs][meta_title]",
                          "placeholder" => "Meta Title",
                          "required" => "required",
                          "class" => "form-control",
                          "id" => "meta_title",
                          'tab-index'=>'14'
                           );
$input['meta_keyword'] = array(
                          "name" => "data[blogs][meta_keyword]",
                          "placeholder" => "Meta Keyword",
                          "required" => "required",
                          "class" => "form-control",
                          "id" => "meta_title",
                          "max"=>160,
                          'tab-index'=>'15'
                           );
            
$input['meta_description'] = array(
                          "name" => "data[blogs][meta_description]",
                          "placeholder" => "Meta Description",
                          "required" => "required",
                          "class" => "form-control",
                          "id" => "meta_title",
                          "max"=>160,
                          'tab-index'=>'16'
                           );
$input['send_notification']  = array(
          "name" => "data[fcm][send_notification]",
          "class" => "flat-red notify",
          "id" => "send_notification",
          "type" => "checkbox",
          "value" => true,
          'tab-index'=>'17',
          'checked'=> set_value('data[fcm][send_notification]')?'checked':''
        );

if(isset($value_posted)) {
  foreach ($value_posted as $post_name => $post_value) {
    foreach ($post_value as $field_key => $field_value) {
      $input[$field_key]['value'] = $field_value;
    }
  }
}
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?=$title?>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li><?php echo anchor(custom_constants::admin_blogs_listing_url, ' blogs'); ?></li>
    <li class="active"><?php echo anchor(custom_constants::new_blogs_url, 'New Blog'); ?></li>
  </ol> 
</section>


<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <!-- Horizontal Form -->
      <?php echo form_open_multipart(custom_constants::new_blogs_url, ['class'=>'form-horizontal', 'id' => 'blogs']);
      
        if($this->session->flashdata('message')!== FALSE) {
          $msg = $this->session->flashdata('message');?>
          <div class="<?php echo $msg['class'];?>">
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
                  <label for="inputCategory" class="col-sm-2 control-label">Category</label>
                  <div class="col-sm-10">
                    <?php echo form_dropdown('data[blogs][blogs_category_id]', $option['category'], isset($value_posted)?$value_posted['blogs']['blogs_category_id']:'',"id='category' required='required' class='form-control select2' tab-index=1"); ?>
                    <?php echo form_error('data[blogs][category]'); ?>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="inputState" class="col-sm-2 control-label">blogs Type</label>
                  <div class="col-sm-10">
                      <?php echo form_dropdown('data[blogs][type]',$option['type'], '',$type); ?>
                      <?php echo form_error('data[blogs][type]'); ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="inputtitle" class="col-sm-2 control-label">blogs Title</label>
                  <div class="col-sm-10">
                   <?php echo form_input($input['title']);?>
                   <?php echo form_error('data[blogs][title]');?>
                  </div>
                </div>
              </div>
            
              <div class="col-md-6">
                <div class="form-group">
                  <label for="inputslug" class="col-sm-2 control-label">Slug</label>
                  <div class="col-sm-10">
                   <?php echo form_input($input['slug']);?>
                   <?php echo form_error('data[blogs][slug]');?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="inputShortDescription" class="col-sm-1 control-label">Short Description</label>
                  <div class="col-sm-11">
                   <?php echo form_input($input['short_description']);?>
                   <?php echo form_error('data[blogs][short_description]');?>
                  </div>
                </div>
              </div>
            </div>
             <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="inputcontent" class="col-sm-1 control-label">Content</label>
                  <div class="col-sm-11">
                  <?php echo form_input($input['content']);?>
                  <?php echo form_error('data[blogs][content]'); ?>
                  </div>
                </div>
              </div>
            </div><!-- /row -->
            <div class="row">
              <div class="col-md-6" id="text">
                <div class="form-group">
                  <label for="inputCity" class="col-sm-2 control-label">Featured Image</label>
                  <div class="col-sm-10">
                      <?php echo form_upload($input['featured_image']); ?>
                      
                      <?php echo form_error('data[blogs][featured_image]'); ?>
                  </div>
                </div>
              </div> 
              <div class="col-md-6" id="video" style="display: none">
                <div class="form-group">
                  <label for="inputvideo" class="col-sm-2 control-label">Video url</label>
                  <div class="col-sm-10">
                      <input type="text" name="data[youtube][video]" id="featured_image_video" class="form-control" placeholder="Enter Video Link">
                      <?php echo form_error('data[blogs][featured_image]'); ?>
                  </div>
                </div>
              </div>    
            
              <div class="col-md-6">
                <div class="form-group">
                  <label for="inputCity" class="col-sm-2 control-label">Published On</label>
                  <div class="col-sm-10">
                      <?php echo form_input($input['date']); ?>
                      <?php echo form_error('data[blogs][published_on]'); ?>
                  </div>
                </div>
              </div>     
            </div><!-- /row -->
             <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="inputState" class="col-sm-2 control-label">State</label>
                  <div class="col-sm-10">
                      <?php echo form_dropdown('data[blogs][state_id]',$option['states'], set_value('data[blogs][state_id]'),$state); ?>
                      <?php echo form_error('data[blogs][state_id]'); ?>
                  </div>
                </div>
              </div> 
              <div class="col-md-6">
                <div class="form-group">
                  <label for="inputArea" class="col-sm-2 control-label">City</label>
                  <div class="col-sm-10">

                      <?php echo form_dropdown('data[blogs_cities][city_id][]',$option['cities'], set_value('data[blogs_cities][city_id]'),$city); ?>
                      <?php echo form_error('data[blogs_cities][city_id]'); ?>
                  </div>
                </div>
              </div>    
            </div><!-- /row -->
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="inputIsTrend" class="col-sm-2 control-label">Is Trend</label>
                  <div class="col-sm-10">
                    <?php echo form_input($input['is_trend']);?>
                    <?php echo form_error('data[blogs][is_trend]');?>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="inputIsHot" class="col-sm-2 control-label">Is Hot</label>
                  <div class="col-sm-10">
                    <?php echo form_input($input['is_hot']);?>
                    <?php echo form_error('data[blogs][is_hot]');?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="inputIsFeatured" class="col-sm-2 control-label">Is Featured</label>
                  <div class="col-sm-10">
                    <?php echo form_input($input['is_featured']);?>
                    <?php echo form_error('data[blogs][is_featured]');?>
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
                   <?php echo form_error('data[blogs][meta_title]');?>
                  </div>
                </div>
              </div>
              
                
              <div class="col-md-6">
                <div class="form-group">
                  <label for="inputMetakeyword" class="col-sm-2 control-label">Meta Keyword</label>
                  <div class="col-sm-10">
                   <?php echo form_input($input['meta_keyword']);?>
                   <?php echo form_error('data[blogs][meta_keyword]');?>
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
                   <?php echo form_error('data[blogs][meta_description]');?>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="inputSendNotification" class="col-sm-2 control-label">Send Notification</label>
                  <div class="col-sm-10">
                    <?php echo form_input($input['send_notification']);?>
                    <?php echo form_error('data[fcm][send_notification]');?>
                  </div>
                </div>
              </div>
            </div>
        </div><!-- /box-body -->
        <div class="box-footer">  
          <button type="submit" class="btn btn-info pull-left" id="Save">Save</button>
          <?php echo nbs(3); ?>
          <button type="reset" class="btn btn-info">Reset</button>
        </div>
        <!-- /.box-footer -->
      </div><!-- /box -->
      <?php echo form_close(); ?>
      <?php echo nbs(3); ?>
    </div>
  </div>
</section><!-- /.content -->
