<?php if($this->session->flashdata('message') !== FALSE) {
    $msg = $this->session->flashdata('message');?>
    <div class = "<?php echo $msg['class'];?>">
      <?php echo $msg['message'];?>
    </div>
  <?php } ?> 
<!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><i class="fa fa-book margin-r-5"></i> FAQS</h3>
              <?php if(!isset($module)){ echo anchor(custom_constants::new_faq_url, 'New FAQ', ['title'=>"", 'class'=>"btn btn-primary pull-right"]); } ?>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="overflow-x: scroll;">
              <?php //print_r($this->session->userdata); ?>
              <table id="example2" class="table table-bordered table-striped example2">
                <thead>
                <tr>
                  <th>Sr No</th>
                  <th>FAQ Category</th>
                  <th>Question</th>
                  <th>Answer</th>
                  <th>Is Active</th>
                  <!-- <th>Action</th> -->
                </tr>
                </thead>
                <tbody>
                  <?php 
                  /*echo '<pre>';
                  print_r($address);
                  echo '</pre>';*/
                  //$url = $module;
                  foreach($faqs as $key=> $faq) { //print_r($document); ?>
                <tr>
                  <td><?php echo $key+1 ;?></td>
                  <td><?php echo $faq['faq_category'] ;?></td>
                  <td><?php echo $faq['question'];?></td>
                  <td><?php echo $faq['answer'] ;?></td>
                  <td>
                      <i class="<?php echo (true==$faq['is_active'])?'fa fa-check-circle alert-success':' fa-remove alert-danger';?>"></i> 
                  </td>
                  <!-- <td>
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Action
                       <span class="fa fa-caret-down" ></span>
                      </button>
                      <ul class="dropdown-menu">
                       <li>
                        <?php 
                        $url = ($document['user_type']=='employees')?custom_constants::edit_employee_url:'upload_documents/new_document';
                        echo anchor($url."/".$document['user_id']."?tab=document", 'Edit', ['class'=>'']);  ?> 
                          
                        </li> 
                      </ul>
                    </div> 
                  </td> -->  
                
                </tr>
                <?php }?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>Sr No</th>
                    <th>FAQ Category</th>
                    <th>Question</th>
                    <th>Anser</th>
                    <th>Is Active</th>
                    <!-- <th>Action</th> -->
                  </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  
