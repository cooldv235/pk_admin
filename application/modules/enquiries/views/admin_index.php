
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Module :: Enquiries
      </h1>
      <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Customers</li>
      </ol> -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Enquiry</h3>
              <?php echo anchor(custom_constants::new_customer_url, 'New Customer', 'class="btn btn-primary pull-right"'); ?>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <?php //print_r($this->session->userdata); ?>
              <table id="example2" class="table table-bordered table-striped example2">
                <thead>
                  <tr>
                    <th>Sr No</th>
                    <th>Type</th>
                    <th>Referred By</th>
                    <th>Name</th>
                    <th>Company Name</th>
                    <th>Primary / Secondary Email</th>
                    <th>contact 1 / Contact 2</th>
                    <th>Enquiry Code</th>
                    <th>Message</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  //print_r($customers);
                  foreach($enquiries as $key => $v) {?>
                <tr>
                  <td><?=$key+1?></td>
                  <td><?php echo $v['type'] ;?></td>
                  <td><?=$v['referred_by']?></td>
                  <td><?php echo $v['first_name']." ".$v['middle_name']." ".$v['surname'] ;?></td>
                  <td><?php echo $v['company_name'] ;?></td>
                  <td><?php 
                    echo $v['primary_email'];
                    echo (!empty($v['secondary_email']))?" / ".$v['secondary_email']:'' ;?></td>
                  <td><?php echo $v['contact_1'].' / '.$v['contact_2'] ;?></td>
                  <td><?php echo $v['enq_code'] ;?></td>
                  <td><?=word_limiter($v['message'],20)?></td>
                  <td>
                    <!-- <div class="input-group-btn">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Action
                        <span class="fa fa-caret-down" ></span></button>
                        <ul class="dropdown-menu">
                          <li><?php //echo anchor(custom_constants::edit_customer.$customer['id'], 'Edit', ['class'=>'']);  ?>
                        </ul>
                    </div> -->
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Action
                      <span class="fa fa-caret-down" ></span></button>
                      <ul class="dropdown-menu">
                        <li><?php echo anchor(custom_constants::admin_customer_view."/".$v['id'], 'View', ['class'=>'']);  ?></li>
                        <li><?php echo anchor('enquiries/enquiry_wise_details/'.$v['enq_code'], 'Edit', ['class'=>'']);  ?></li>
                        
                      </ul>
                    </div>
                  </td>  
                </tr>
                <?php }?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>Sr No</th>
                    <th>Name</th>
                    <th>Company Name</th>
                    <th>Primary / Secondary Email</th>
                    <th>contact 1 / Contact 2</th>
                    <th>Blood Group</th>
                    <th>Action</th>
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