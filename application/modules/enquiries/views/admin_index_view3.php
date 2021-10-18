
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
            <?php //echo $export;exit;
           if($export){?>

            <input type="button" value="Export" class="btn btn-info text-center pull-right" onclick="exportToExcel('report', 'enquiry_report_<?php echo date('dmyhis'); ?>.xls');">
         <?php } ?>
          
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="overflow-x: scroll;">
            <?php //echo '<pre>';print_r($_SERVER);echo '</pre>'; ?>
            <div class="col-md-12" id="dvData">

                <table id="ajaxLoader" class="table table-bordered table-striped ajaxLoader">

            <thead>
            <tr>
              <th>Sr No</th> 
              <th>Id</th>
              <th>File</th>
              <th>Name</th>
              <th>Contact</th>
              <th>Email</th>
              <th>Enquiry Type</th>
              <th>Message</th>
              <th>Enq Code</th>
              <th>Is Active</th>
              <th>Action</th>
            </tr>
            </thead>
          </table>
          </div>
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

<script type="text/javascript">
     $(document).ready(function(){

        $('#ajaxLoader').DataTable({
          'processing': true,
          'serverSide': true,
          'serverMethod': 'post',
          "pageLength": 25,
          "order": [[7, "desc" ]],
          "lengthMenu": [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]],
          'ajax': {
            
             'url':'<?=$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']?>'
            
          },
          'columns': [
             { data: 'sr_no' },
             { data: 'id' },
             { data: 'image'},
            // { data: 'customer_name' },
             { data: 'first_name' },
             { data: 'contact_1'},
             { data: 'email' },
             { data: 'type' },
             { data: 'message' },
             /*{ data: 'issue' },*/
             { data: 'enq_code'},
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