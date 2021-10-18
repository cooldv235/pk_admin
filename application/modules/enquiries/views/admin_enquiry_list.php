
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
   <span class="glyphicon glyphicon-shopping-cart"></span> <?=$title?>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li class="active"><i class="fa fa-shopping-cart margin-r-5"></i> Enquiries</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?=$heading?></h3>
          <?php //echo anchor(custom_constants::new_call_url, 'New Call (Task)', 'class="btn btn-primary pull-right"'); ?>
          
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="overflow-x: scroll;">
          <?php //echo '<pre>';print_r($_SERVER);echo '</pre>'; ?>
          <table id="ajaxLoader" class="table table-bordered table-striped">

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
<?php //echo '<pre>';print_r($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);echo '</pre>';?>
<script type="text/javascript">
     $(document).ready(function(){

        $('#ajaxLoader').DataTable({
          'processing': true,
          'serverSide': true,
          'serverMethod': 'post',
          "pageLength": 25,
          "order": [[2, "desc" ]],
          "lengthMenu": [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]],
          'ajax': {
            
             'url':'<?=$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']?>'
            
          },
          'columns': [
             { data: 'sr_no' },
             { data: 'id' },
             { data: 'type' },
             { data: 'referred_by' },
             { data: 'name' },
             { data: 'company_name' },
             { data: 'email' },
             { data : 'contact' },
             { data: 'enq_code' },
             { data: 'message' },
             
             { data: 'is_active' },
             { data: 'action' },
             
          ],
          "columnDefs": [
            {
                "targets": [ 1 ],
                "visible": false,
                "searchable": false
            }
        ]
        });
     });
     </script>