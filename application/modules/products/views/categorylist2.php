<div class="col-md-3">
    <?php echo $this->load->view('templates/left-content'); ?>
</div>
<div class="col-md-9">
    <div class="box">
        <?php //print_r($category); ?>
        <img src="<?php echo base_url().'assets/uploads/product_categories/'.(!empty($category['image_name_1'])?$category['image_name_1']:'default-icon.jpg'); ?>" class="img-responsive">
        <h1><?php echo ucfirst($category['category_name']); ?></h1>
        <p><?php echo nl2br($category['description']); ?></p>
        
    </div>

    <!--<div class="box info-bar">
        <div class="row">
             <div class="col-sm-12 col-md-4 products-showing">
                Showing <strong>12</strong> of <strong>25</strong> products
            </div> 

            <div class="col-sm-12 col-md-8  products-number-sort">
                <div class="row">
                    <form class="form-inline">
                        <div class="col-md-6 col-sm-6">
                            <div class="products-number">
                                <strong>Show</strong>  <a href="#" class="btn btn-default btn-sm btn-primary">12</a>  <a href="#" class="btn btn-default btn-sm">24</a>  <a href="#" class="btn btn-default btn-sm">All</a> products
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="products-sort-by">
                                <strong>Sort by</strong>
                                <select name="sort-by" class="form-control">
                                    <option>Price</option>
                                    <option>Name</option>
                                    <option>Sales first</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div> 
        </div>
    </div>-->
    <div class="row products">
	<?php 
	foreach ($categories as $catKey => $cat) {
        $anchorLink = $cat['is_parent']?'product-category/':'product-list/';
		?>

        <div class="col-md-4 col-sm-4">
            <div class="product">
                <div class="flip-container">
                    <div class="flipper">
                        <div class="front">
                            <!-- <a href="detail.html">
                                <img src="img/product1.jpg" alt="" class="img-responsive">
                            </a> -->
                            <?php echo anchor($anchorLink.$cat['slug'], img(['src'=>'assets/uploads/product_categories/'.$cat['image_name_1'], 'class'=>'img-responsive'])); ?>
                        </div>
                        <div class="back">
                        	 <?php echo anchor($anchorLink.$cat['slug'], img(['src'=>'assets/uploads/product_categories/'.$cat['image_name_2'], 'class'=>'img-responsive'])); ?>
                            <!-- <a href="detail.html">
                                <img src="img/product1_2.jpg" alt="" class="img-responsive">
                            </a> -->
                        </div>
                    </div>
                </div>
                 <?php echo anchor($anchorLink.$cat['slug'], img(['src'=>'assets/uploads/product_categories/'.$cat['image_name_1'], 'class'=>'img-responsive', 'alt'=>$cat['category_name']]), ['class'=>'invisible']); ?>
                <!-- <a href="detail.html" class="invisible">
                    <img src="img/product1.jpg" alt="" class="img-responsive">
                </a> -->
                <div class="text">
                    <h3>
						<?php 
						echo anchor($anchorLink.$cat['slug'], $cat['category_name']); ?>
                    	<!-- <a href="detail.html">Fur coat with very but very very long name</a> -->
                    		
                    </h3>
                    <!-- <p class="price"><i class="fa fa-inr" aria-hidden="true"></i> <?php echo number_format($product['base_price'], 2); ?></p> -->
                    <p class="buttons">
                    	<?php 
                    	echo anchor($anchorLink.$cat['slug'], 'View Detail', ['class'=>"btn btn-default"]);
                    	//echo anchor('#', '<i class="fa fa-shopping-cart"></i> Add To Cart', ['class'=>"btn btn-primary addtocart", 'data-id'=>$product['id']]);

                    	 ?>
                        <!-- <a href="detail.html" class="btn btn-default">View detail</a> -->
                        <!-- <a href="#" class="btn btn-primary addtocart" data-id="<?php echo $product['id']; ?>"><i class="fa fa-shopping-cart"></i>Add to cart</a> -->
                    </p>
                </div>
                <!-- /.text -->
                
            </div>
            <!-- /.product -->
        </div>
		<?php
	}
	 ?>
    </div>
    <!-- /.products -->

    <!-- <div class="pages">
    
        <p class="loadMore">
            <a href="#" class="btn btn-primary btn-lg"><i class="fa fa-chevron-down"></i> Load more</a>
        </p>
    
        <ul class="pagination">
            <li><a href="#">&laquo;</a>
            </li>
            <li class="active"><a href="#">1</a>
            </li>
            <li><a href="#">2</a>
            </li>
            <li><a href="#">3</a>
            </li>
            <li><a href="#">4</a>
            </li>
            <li><a href="#">5</a>
            </li>
            <li><a href="#">&raquo;</a>
            </li>
        </ul>
    </div> -->


</div>
<!-- /.col-md-9 -->