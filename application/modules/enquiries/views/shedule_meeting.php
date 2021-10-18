<?php
// If access is requested from anywhere other than index.php then exit
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$input['date'] = array(
                    'name'=>'data[enquiries][date]',
                    'id'=>'date',
                    'class'=>'form-control date-picker',
                    'type'=>'date',
                    'placeholder' =>'Tour Date',
                    //'required'      => 'required',
);
$input['time'] = array(
                    'Name'      =>    'data[enquiry_details][time]',
                    'id'        =>    'time',
                    'class'     =>    'form-control',
                    'type'      =>    'time',
                    'placeholder'=>   'Tour Time',
                    //'required'  =>    'required',
);

$input['name'] = array(
                    'name'=>'data[enquiry][name]',
                    'id'=>'name',
                    'class'=>'form-control',
                    'placeholder'=>'Full Name',
                    'required'=>'required',
);
$input['message'] = array(
                    'name'=>'data[enquiries][message]',
                    'id'=>'message',
                    'class'=>'form-control',
                    'type'=>'textarea',
                    "row"=>5,
                    'placeholder'=>'Your Message',
);
$input['contact_1'] = array(
                    'name'=>'data[enquiries][contact_1]',
                    'id'=>'contact_1',
                    'class'=>'form-control',
                    'placeholder'=>'Your Contact',
                    'required'=>'required',
);

$input['primary_email'] = array(
                    'name'=>'data[enquiries][primary_email]',
                    'id'=>'primary_email',
                    'class'=>'form-control',
                    'placeholder'=>'Your Mail',
                    'required'=>'required',
);

$input['schedule_visit']  = array(
                    "name" => "data[enquiry_details][schedule_visit]",
                    "class" => "showdiv",
                    "id" => "schedule_visit",
                    "type" => "checkbox",
                    "value" => true,
                    'data-show'=>'schedulevisit'
                );

if(isset($values_posted))
{ 
    //echo '<pre>';print_r($values_posted);echo '</pre>';
    foreach($values_posted as $post_name => $post_value){
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

<div class="contact-realtor-wrapper">
    <div class="realtor-info">
         <div class="realtor---info">
            <h2>Want to know more?</h2>
            <?php //echo form_open_multipart('enquiries/visit_site', ['class'=>'form-horizontal', 'id' => 'register_enquiry']);?>
            <form method="POST" action="<?=($_SERVER['PHP_SELF'])?>"> 
                <?php if($this->session->flashdata('message')!== FALSE) {
                    $msg = $this->session->flashdata('message');?>
                        <div class="<?php echo $msg['class'];?>">
                            <?php echo $msg['message'];?>
                        </div>
                <?php } ?>
                                        
            <?php $_SESSION['product_id'] = $product_id; ?>
            <div class="row">
                <div class="input-group mb-3  input-group-lg">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                    </div>
                    <?php 
                    echo form_input($input['name']); ?> 
                    <span class="text-danger"><?php echo form_error('name'); ?></span>
                </div>
            </div>
            <div class="row">
                <div class="input-group mb-3  input-group-lg">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-phone"></i></span>
                    </div>
                    <?php 
                    echo form_input($input['contact_1']); ?> 
                     <!--<input type="time" name="eta"> -->
                    <span class="text-danger"><?php echo form_error('email'); ?></span>
                </div>
            </div>
            <div class="row">
                <div class="input-group mb-3  input-group-lg">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                    </div>
                    <?php 
                    echo form_input($input['primary_email']); ?> 
                     <!--<input type="time" name="eta"> -->
                    <span class="text-danger"><?php echo form_error('email'); ?></span>
                </div>
            </div>
            
            <div class="col-12 search-form-second-steps" style="display: none;">
                <div class="row">
                    <div class="input-group mb-3  input-group-lg">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                        </div>
                        <?php 
                        echo form_input($input['date']); ?>
                        <span class="text-danger"><?php echo form_error('email'); ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="input-group mb-3  input-group-lg">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-clock-o"></i></span>
                        </div>
                        <?php 
                        echo form_input($input['time']); ?> 
                        <span class="text-danger"><?php echo form_error('email'); ?></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <!-- <label for="inputIsPack" class="col-sm-2 control-label">Schedule Visit</label>
                    <div class="col-sm-10">
                        <?php echo form_input($input['schedule_visit']);?>
                        <?php echo form_error('data[enquiries][schedule_visit]');?>
                    </div> -->
                    <div class="more-filter">
                        <a href="#" id="moreFilter">Schedule Visit</a>
                    </div>
                    <!-- <label><?php echo form_input($input['schedule_visit']);?> Schedule Visit</label> -->
                </div>
            </div>
            <!-- <div class="schedulevisit invisible" id="schedulevisit">
                <div class="row">
                    <div class="input-group mb-3  input-group-lg">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                        </div>
                        <?php 
                        echo form_input($input['date']); ?>
                        <span class="text-danger"><?php echo form_error('email'); ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="input-group mb-3  input-group-lg">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-clock-o"></i></span>
                        </div>
                        <?php 
                        echo form_input($input['time']); ?> 
                        <span class="text-danger"><?php echo form_error('email'); ?></span>
                    </div>
                </div>
            </div> -->
            <!-- Submit -->
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary enquiry">Post Enquiry</button>
                    </div>
                </div>
            </div>
            
            <?php echo form_close();?>
        </div> 
        
    </div>
</div>