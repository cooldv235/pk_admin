
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?=$title?>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li class="active"><i class="fa fa-user margin-r-5"></i> Blog Categories</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?=$heading?></h3>
          <?php echo anchor(custom_constants::new_news_url, 'New News', 'class="btn btn-primary pull-right"'); ?>
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="overflow-x: scroll;">
          <?php //print_r($this->session->userdata); ?>
          <table id="example2" class="table table-bordered table-striped example2">
            <thead>
            <tr>
              <th>Sr No</th>
              <th>News Category</th>
              <th>Title</th>
              <th>Short Description</th>
              <th>Content</th>
              <th>Author</th>
              <th>Featured Image</th>
              <th>Published Date</th>
              <th>Slug</th>
              <th>Meta Title</th>
              <th>Meta Description</th>
              <th>Meta Keyword</th>
              <th>Is Active</th>
              <th>Action</th>
              
            </tr>
            </thead>
            <tbody>
                <?php foreach($category as $key=> $v) {
                	//print_r($v);?>
            <tr>
              <td><?php echo $key+1 ;?></td>
              <!-- <td><?php echo !empty($v['profile_img'])?'<img src="'.base_url().'uploads/profile_images/'.$v['profile_img'].'" alt="'.$v['first_name'].'" height="80px" width="80px">':'';?></td> -->
              <td><?php echo $v['category_name'];?></td>
              <td><?php echo $v['title'];?></td>
              <td><?php echo $v['short_description'];?></td>
              <td><?php echo word_limiter($v['content'], 20);?></td>
              <td><?php echo $v['first_name']." ". $v['surname'];?></td>
              <td><?php echo $v['featured_image'];?></td>
              <td><?php echo $v['published_on'];?></td>
              <td><?php echo $v['slug'];?></td>
              <td><?php echo $v['meta_title'] ;?></td>
              <td><?php echo $v['meta_description'] ;?></td>
              <td><?php echo $v['meta_keyword'] ;?></td>

              <td><i class="<?php echo ($v['is_active']==true)?'alert-success fa fa-check-circle':'alert-danger fa fa-remove' ;?>"></i></td>
              <td>
               <!-- <?= anchor("Colleges/admin_Edit/".$v['id']);?>  -->
               <div class="input-group-btn">
                   <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Action
                   <span class="fa fa-caret-down" ></span></button>
                 <ul class="dropdown-menu">
                  <!-- <li><?php echo anchor(custom_constants::admin_product_view.'/'.$v['id'], 'View', ['class'=>'']);  ?></li> -->
                   <li><?php echo anchor(custom_constants::edit_news_url."/".$v['id'], 'Edit', ['class'=>'']); ?></li>
                  
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
              <th>News Category</th>
              <th>Title</th>
              <th>Short Description</th>
              <th>Content</th>
              <th>Author</th>
              <th>Featured Image</th>
              <th>Published Date</th>
              <th>Meta Title</th>
              <th>Meta Description</th>
              <th>Meta Keyword</th>
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

