
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Module :: Products
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li class="active"><i class="fa fa-user margin-r-5"></i> Products</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><i class="fa fa-shopping-bag margin-r-5"></i> Products</h3>
          <?php echo anchor(custom_constants::new_product_url, 'New Product', 'class="btn btn-primary pull-right"'); ?>
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="overflow-x: scroll;">
          <?php //print_r($this->session->userdata); ?>
          <table id="example2" class="table table-bordered table-striped example2">
            <thead>
            <tr>
              <th>Sr No</th>
              <th>Product Category</th>
              <th>Thumbnail Image</th>
              <th>Product Type</th>
              <th>Product</th>
              <th>Product Code</th>
              <th>Slug</th>
              <th>Priority</th>
              <!--<th>Description</th>-->
              <th>Meta Title</th>
              <th>Meta Description</th>
              <th>Meta Keyword</th>
              <th>Is Sale|Is Gift|Is New</th>
              <th>Is Active</th>
              <th>Action</th>
              
            </tr>
            </thead>
            <tbody>
                <?php foreach($product_category as $key=> $v) {
                	//print_r($v);?>
            <tr>
              <td><?php echo $key+1 ;?></td>
              <!-- <td><?php echo !empty($v['profile_img'])?'<img src="'.base_url().'assets/uploads/profile_images/'.$v['profile_img'].'" alt="'.$v['first_name'].'" height="80px" width="80px">':'';?></td> -->
              <td><?php echo $v['category_name'];?></td>
              <td><?php echo !empty($v['image_name_1'])?'<img src="'.content_url().'uploads/products/'.$v['image_name_1'].'" alt="'.$v['category_name'].'" height="80px" width="80px">':'';?></td>
              <td>
                <?php 
                if($v['product_type']==1){ 
                  echo 'Product';
                }elseif ($v['product_type']==2) {
                  echo 'Service';
                }elseif ($v['product_type']==3) {
                  echo 'Product & Service';
                }
                ?>
              </td>
              <td><?php echo $v['product'] ;?></td>
              <td><?php echo $v['product_code'] ;?></td>
              <td><?php echo $v['slug'] ;?></td>
              <td><?php echo $v['priority'] ;?></td>
              <!--<td><?php echo word_limiter($v['description'], 20) ;?></td>-->
              <td><?php echo $v['meta_title'] ;?></td>
              <td><?php echo $v['meta_description'] ;?></td>
              <td><?php echo $v['meta_keyword'] ;?></td>
             <!--  <td><?php echo $v['product'] ;?></td> -->
              <td><i class ="<?php echo ($v['is_sale']==true)?'alert-success fa fa-check-circle':'alert-danger fa fa-remove';?>"><?php //echo /*$v['is_sale'].*/"|".$v['is_new']."|".$v['is_gift'] ;?></i><?php echo "|";?>
              	<i class="<?php echo ($v['is_gift']==true)?'alert-success fa fa-check-circle':'alert-danger fa fa-remove';?>"></i><?php echo "|";?>
              	<i class="<?php echo ($v['is_new']==true)?'alert-success fa fa-check-circle':'alert-danger fa fa-remove';?>"></i>
              </td>

              <td><i class="<?php echo ($v['is_active']==true)?'alert-success fa fa-check-circle':'alert-danger fa fa-remove' ;?>"></i></td>
              <td>
               <!-- <?= anchor("Colleges/admin_Edit/".$v['id']);?>  -->
               <div class="input-group-btn">
                   <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Action
                   <span class="fa fa-caret-down" ></span></button>
                 <ul class="dropdown-menu">
                  <li><?php echo anchor(custom_constants::admin_product_view.'/'.$v['id'], 'View', ['class'=>'']);  ?></li>
                   <li><?php echo anchor(custom_constants::edit_product_url."/".$v['id'], 'Edit', ['class'=>'']); ?></li>
                  
                  </ul>
                </div>
              </td>  
              
             <!--  <td>
              <?= anchor("Colleges/admin_Edit/".$v['id']);?>
             
             </td> -->

            </tr>
            <?php }?>
            </tbody>
            <tfoot>
              <tr>
              	
	              <th>Sr No</th>
	              <th>Product Category</th>
                  <th>Thumbnail Image</th>
	              <th>Product Type</th>
	              <th>Product</th>
	              <th>Product Code</th>
	              <th>Slug</th>
	              <th>Priority</th>
	              <!--<th>Description</th>-->
	              <th>Meta Title</th>
	              <th>Meta Description</th>
	              <th>Meta Keyword</th>
	              <th>Is Sale|Is Gift|Is New</th>
	              <th>Is Active</th>
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

