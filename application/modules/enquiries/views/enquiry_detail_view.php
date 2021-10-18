<section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- <div class="box-header">
              <h3 class="box-title">Enquiry</h3>
              <?php echo anchor(custom_constants::new_customer_url, 'New Customer', 'class="btn btn-primary pull-right"'); ?>
            </div> -->
            <!-- /.box-header -->
            <div class="box-body">
              <?php //print_r($this->session->userdata); ?>
              <?php if(count($enquiries)>0){?>
                <table id="example2" class="table table-bordered table-striped example2">
                  <thead>
                    <tr>
                      <th>Sr No</th>
                      <th>Type</th>
                      <th>Name</th>
                      <th>Primary / Secondary Email</th>
                      <th>contact 1 / Contact 2</th>
                      <th>Enquiry Code</th>
                      <th>Message</th>
                      <th>Address</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                      <?php foreach($enquiries as $key => $v) {?>
                        <tr>
                          <td><?=$key+1?></td>
                          <td><?php echo $v['type'] ;?></td>
                          <td><?php echo $v['first_name']." ".$v['middle_name']." ".$v['surname']."-".$v['company_name'] ;?></td>
                          <td><?php 
                            echo $v['primary_email'];
                            echo (!empty($v['secondary_email']))?" / ".$v['secondary_email']:'' ;?></td>
                          <td><?php echo $v['contact_1'].' / '.$v['contact_2'] ;?></td>
                          <td><?php echo $v['enq_code'] ;?></td>
                          <td><?=$v['message']?></td>
                          <td><?=$v['address_1']." ".$v['address_2']." ".$v['area_name']." ".$v['city_name']." ".$v['state_name']." ".$v['name']?></td>
                        </tr>
                      <?php }?>
                    
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Sr No</th>
                      <th>Type</th>
                      <th>Name</th>
                      <th>Primary / Secondary Email</th>
                      <th>contact 1 / Contact 2</th>
                      <th>Enquiry Code</th>
                      <th>Message</th>
                      <th>Address</th>
                    </tr>
                  </tfoot>
                </table>
              <?php } else {?>
                <h2>No Data Found</h2>
                <?php }?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>