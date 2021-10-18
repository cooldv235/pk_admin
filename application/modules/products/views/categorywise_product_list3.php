
<div class="col-md-9">
    <div class="box">
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
	foreach ($categoryWiseProducts as $productKey => $product) {
		?>

        <div class="col-md-4 col-sm-4">
            <div class="product">
                <div class="flip-container">
                    <div class="flipper">
                        <div class="front">
                            <!-- <a href="detail.html">
                                <img src="img/product1.jpg" alt="" class="img-responsive">
                            </a> -->
                            <?php echo anchor('product/'.$product['slug'], img(['src'=>'assets/uploads/products/'.(!empty($product['image_name_1'])?$product['image_name_1']:'default-icon.jpg'), 'class'=>'img-responsive', 'alt'=>$product['product']])); ?>
                        </div>
                        <div class="back">
                        	 <?php echo anchor('product/'.$product['slug'], img(['src'=>'assets/uploads/products/'.(!empty($product['image_name_2'])?$product['image_name_2']:'default-icon.jpg'), 'class'=>'img-responsive', 'alt'=>$product['product']])); ?>
                            <!-- <a href="detail.html">
                                <img src="img/product1_2.jpg" alt="" class="img-responsive">
                            </a> -->
                        </div>
                    </div>
                </div>
                 <?php echo anchor('product/'.$product['slug'], img(['src'=>'assets/uploads/products/'.(!empty($product['image_name_1'])?$product['image_name_1']:'default-icon.jpg'), 'class'=>'img-responsive', 'alt'=>$product['product']]), ['class'=>'invisible']); ?>
                <!-- <a href="detail.html" class="invisible">
                    <img src="img/product1.jpg" alt="" class="img-responsive">
                </a> -->
                <div class="text">
                    <h3>
						<?php 
						echo anchor('product/'.$product['slug'], $product['product']); ?>
                    	<!-- <a href="detail.html">Fur coat with very but very very long name</a> -->
                    		
                    </h3>
                    <p class="price"><i class="fa fa-inr" aria-hidden="true"></i> <?php echo number_format($product['base_price'], 2); ?></p>
                    <p class="buttons">
                    	<?php 
                    	echo anchor('product/'.$product['slug'], 'View Detail', ['class'=>"btn btn-default"]);
                    	//echo anchor('#', '<i class="fa fa-shopping-cart"></i> Add To Cart', ['class'=>"btn btn-primary addtocart", 'data-id'=>$product['id']]);

                    	 ?>
                        <!-- <a href="detail.html" class="btn btn-default">View detail</a> -->
                        <a href="#" class="btn btn-primary addtocart" data-id="<?php echo $product['id']; ?>"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                    </p>
                </div>
                <!-- /.text -->
                <?php if($product['is_sale']){ ?>
                <div class="ribbon sale">
                    <div class="theribbon">SALE</div>
                    <div class="ribbon-background"></div>
                </div>
                <!-- /.ribbon -->
                <?php } ?>
				<?php if($product['is_new']){ ?>
                <div class="ribbon new">
                    <div class="theribbon">NEW</div>
                    <div class="ribbon-background"></div>
                </div>
                <!-- /.ribbon -->
                <?php } ?>
				<?php if($product['is_gift']){ ?>
                <div class="ribbon gift">
                    <div class="theribbon">GIFT</div>
                    <div class="ribbon-background"></div>
                </div>
                <!-- /.ribbon -->
                <?php } ?>
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
<div class="col-md-3">
    <!-- *** MENUS AND FILTERS ***
_________________________________________________________ -->
    <div class="panel panel-default sidebar-menu">

        <div class="panel-heading">
            <h3 class="panel-title">Categories</h3>
        </div>

        <div class="panel-body">
            <ul class="nav nav-pills nav-stacked category-menu">
                <li>
                    <a href="category.html">Men <span class="badge pull-right">42</span></a>
                    <ul>
                        <li><a href="category.html">T-shirts</a>
                        </li>
                        <li><a href="category.html">Shirts</a>
                        </li>
                        <li><a href="category.html">Pants</a>
                        </li>
                        <li><a href="category.html">Accessories</a>
                        </li>
                    </ul>
                </li>
                <li class="active">
                    <a href="category.html">Ladies  <span class="badge pull-right">123</span></a>
                    <ul>
                        <li><a href="category.html">T-shirts</a>
                        </li>
                        <li><a href="category.html">Skirts</a>
                        </li>
                        <li><a href="category.html">Pants</a>
                        </li>
                        <li><a href="category.html">Accessories</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="category.html">Kids  <span class="badge pull-right">11</span></a>
                    <ul>
                        <li><a href="category.html">T-shirts</a>
                        </li>
                        <li><a href="category.html">Skirts</a>
                        </li>
                        <li><a href="category.html">Pants</a>
                        </li>
                        <li><a href="category.html">Accessories</a>
                        </li>
                    </ul>
                </li>

            </ul>

        </div>
    </div>

    <div class="panel panel-default sidebar-menu">

        <div class="panel-heading">
            <h3 class="panel-title">Brands <a class="btn btn-xs btn-danger pull-right" href="#"><i class="fa fa-times-circle"></i> Clear</a></h3>
        </div>

        <div class="panel-body">

            <form>
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox">Armani (10)
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox">Versace (12)
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox">Carlo Bruni (15)
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox">Jack Honey (14)
                        </label>
                    </div>
                </div>

                <button class="btn btn-default btn-sm btn-primary"><i class="fa fa-pencil"></i> Apply</button>

            </form>

        </div>
    </div>

    <div class="panel panel-default sidebar-menu">

        <div class="panel-heading">
            <h3 class="panel-title">Colours <a class="btn btn-xs btn-danger pull-right" href="#"><i class="fa fa-times-circle"></i> Clear</a></h3>
        </div>

        <div class="panel-body">

            <form>
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"> <span class="colour white"></span> White (14)
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"> <span class="colour blue"></span> Blue (10)
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"> <span class="colour green"></span> Green (20)
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"> <span class="colour yellow"></span> Yellow (13)
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"> <span class="colour red"></span> Red (10)
                        </label>
                    </div>
                </div>

                <button class="btn btn-default btn-sm btn-primary"><i class="fa fa-pencil"></i> Apply</button>

            </form>

        </div>
    </div>

    <!-- *** MENUS AND FILTERS END *** -->

    <div class="banner">
        <a href="#">
            <img src="img/banner.jpg" alt="sales 2014" class="img-responsive">
        </a>
    </div>
</div>