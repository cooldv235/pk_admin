<?php

// If access is requested from anywhere other than index.php then exit
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//echo "<div class = "for-group" >";
$input['first_name'] = array(
                        "name" => "data[enquiries][first_name]",
                        "max_length" => "64",
                        "required" => "required",
                        "id" => "first_name",
                        "class" => "form-control input-lg",
                        "placeholder"=>'Your First Name',
                    );

$input['surname'] = array(
                        "name" => "data[enquiries][surname]",
                        "max_length" => "64",
                        "required" => "required",
                        "class" => "form-control",
                        'id' => "surname",
                        'placeholder'=>'Your Surname',
                    );

$input['primary_email'] =  array(
                            "type" => "email",
                            "name" => "data[enquiries][primary_email]",
                            "max_length" => "100",
                            "required" => "required",
                            "class" => "form-control input-lg",
                            "id" => "primary_email",
                            'placeholder'=>'Your Email'
                        );
$input['contact_1'] = array(
                        "name" => "data[enquiries][contact_1]",
                        "max_length" => "15",
                        "class"=> "form-control input-lg",
                        "required" => "required",
                        "id" => "contact_1",
                        'placeholder'=>'Your Contact'
                    );
$input['message'] = array(
                        "name" => "data[enquiries][message]",
                        "max_length" => "100",
                        "required" => "required",
                        "class"=> "form-control input-lg",
                        "rows" =>5,
                        "id" => "message",
                        'placeholder'=>'Your Message'
                    );
$input['captcha'] = array(
                        "name" => "data[captcha]",
                        "placeholder" => "Your Answer *",
                        'required' => 'required',
                        "class"=> "form-control input-lg",
                        "id" => "captcha"
                    );


// If form has been submitted with errors populate fields that were already filled
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
    <div class="col-12 col-lg-8">
        <div class="contact-form">
            <!-- <form action="#" method="post"> -->
            <?php echo form_open_multipart('enquiries/process_form', ['class'=>'', 'id'=>'contact-form']); 
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

                <?php if(isset($err)){ ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                    <?php echo $this->session->flashdata('err'); ?>
                </div>
                <?php } ?>

                <div class="form-group">
                    <?php echo form_input($input['first_name']); ?>
                    <?php echo form_error('data[enquiries][first_name]'); ?>
                </div>
                <div class="form-group">
                    <?php echo form_input($input['surname']); ?>
                    <?php echo form_error('data[enquiries][surname]'); ?>
                </div>
                <div class="form-group">
                    <?php echo form_input($input['contact_1']); ?>
                    <?php echo form_error('data[enquiries][contact_1]'); ?>
                </div>
                <div class="form-group">
                    <?php echo form_input($input['primary_email']); ?>
                    <?php echo form_error('data[enquiries][primary_email]'); ?>
                </div>
                <div class="form-group">
                    <?php echo form_textarea($input['message']); ?>
                    <?php echo form_error('data[enquiries][message]'); ?>
                </div>
                <input type="submit" class="btn south-btn" value="Send Message">
                <!-- <button type="submit" class="btn south-btn">Send Message</button> -->
            <?php echo form_close(); ?> 
        </div>
    </div>
