<div class="col-md-3">
    <!-- *** MENUS AND FILTERS ***
_________________________________________________________ -->
    <?php //echo $this->load->view('templates/left_content'); ?>
        <div class="panel panel-default sidebar-menu">

        <div class="panel-heading">
            <h3 class="panel-title">Pages</h3>
        </div>

        <div class="panel-body">
            <ul class="nav nav-pills nav-stacked">
                <li>
                    <?php echo anchor('/', 'Home'); ?>
                </li>
                <li>
                    <?php echo anchor('about-us', 'About Us'); ?>
                </li>
                <li>
                    <?php echo anchor('product-category', 'Products'); ?>
                </li>
                <li>
                    <?php echo anchor('contact-us', 'Contact Us'); ?>
                </li>
                <li>
                    <?php echo anchor('faqs', 'FAQs'); ?>
                </li>
            </ul>

        </div>
    </div>

    
</div>
<div class="col-md-9">


                    <div class="box" id="contact">
                        <h1>Frequently asked questions</h1>

                        <p class="lead">Are you curious about something? Do you have some kind of problem with our products?</p>
                        <p>Please feel free to contact us, our customer service center is working for you 24/7.</p>

                        <hr>

                        <div class="panel-group" id="accordion">
                            <?php foreach($faqDetail as $key => $faq) {?>

                            <div class="panel panel-primary">

                                <div class="panel-heading">
                                    <h4 class="panel-title">

                        <a data-toggle="collapse" data-parent="#accordion" href="#faq_<?php echo $faq['id'];?>">

                        <?php echo $key+1;?>
                        <?php echo $faq['question'];?>
                        </a>

                    </h4>
                                </div>
                                <div id="faq_<?php echo $faq['id'];?>" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <!-- <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper.
                                            Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
                                        <ul>
                                            <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
                                            <li>Aliquam tincidunt mauris eu risus.</li>
                                            <li>Vestibulum auctor dapibus neque.</li>
                                        </ul> -->
                                        <?php echo $faq['answer'];?>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <!-- /.panel -->


                        </div>
                        <!-- /.panel-group -->


                    </div>


                </div>
                <!-- /.col-md-9 -->