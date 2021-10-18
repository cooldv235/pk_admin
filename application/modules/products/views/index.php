
	<?php 
	foreach ($products as $productKey => $product) {
		?>

        <div class="col-md-3 col-sm-4">
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
                        	 <?php echo anchor('product/'.$product['slug'], img(['src'=>'assets/uploads/products/'.$product['image_name_2'], 'class'=>'img-responsive', 'alt'=>$product['product']])); ?>
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

        if($productKey>0 && $productKey%3==0){
            //echo '</div><div class="row products">';
        }
	}
	 ?>
   