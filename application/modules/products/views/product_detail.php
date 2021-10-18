<?php //print_r($product); ?>
<div class="col-md-3">
    <!-- *** MENUS AND FILTERS ***
_________________________________________________________ -->
    <?php echo $this->load->view('templates/left-content'); ?>
</div>
<div class="col-md-9">

    <div class="row" id="productMain">
        <div class="col-sm-6">
            <div id="mainImage">
                <?php echo img(['src'=>'assets/uploads/products/'.(!empty($product['image_name_1'])?$product['image_name_1']:'default-icon.jpg'), 'class'=>'img-responsive', 'alt'=>'']); ?>
                <!-- <img src="img/detailbig1.jpg" alt="" class="img-responsive"> -->
            </div>
            <?php 
            if($product['is_sale']){ ?>
            <div class="ribbon sale">
                <div class="theribbon">SALE</div>
                <div class="ribbon-background"></div>
            </div>
            <!-- /.ribbon -->
            <?php }  
            if($product['is_new']){ ?>
            <div class="ribbon new">
                <div class="theribbon">NEW</div>
                <div class="ribbon-background"></div>
            </div>
            <!-- /.ribbon -->
            <?php }  ?>
        </div>
        <div class="col-sm-6">
            <div class="box">
                <h1 class="text-center"><?php echo $product['product']; ?></h1>
                <p class="goToDescription"><a href="#details" class="scroll-to">Scroll to product details and other information</a>
                </p>
                <p class="price"><i class="fa fa-inr" aria-hidden="true"></i> <?php echo $product['base_price']; ?></p>

                <p class="text-center buttons">
                    <a href="#" class="btn btn-primary addtocart"><i class="fa fa-shopping-cart"></i> Add to cart</a> 
                    <a href="#" class="btn btn-default addtowishlist"><i class="fa fa-heart"></i> Add to wishlist</a>
                </p>


            </div>
            <?php if(count($productImages)>0){ ?>
            <div class="row" id="thumbs">
                <?php 
                foreach ($productImages as $key => $image) {
                    ?>

                <div class="col-xs-4">
                    <?php 
                    echo anchor('assets/uploads/products/'.$image['image_name_1'], img(['src'=>'assets/uploads/products/'.(!empty($image['image_name_1'])?$image['image_name_1']:'default-icon.jpg'), 'class'=>'img-responsive', 'alt'=>'']), ['class'=>'thumb']);
                     ?>
                    <!-- <a href="img/detailbig1.jpg" class="thumb">
                        <img src="img/detailsquare.jpg" alt="" class="img-responsive">
                    </a> -->
                </div>
                    <?php
                }
                 ?>
                
            </div>
            <?php } ?>
        </div>

    </div>


    <div class="box" id="details">
        <?php echo nl2br($product['description']); ?>
        
            <!-- <h4>Product details</h4>
            <p>White lace top, woven, has a round neck, short sleeves, has knitted lining attached</p>
            <h4>Material & care</h4>
            <ul>
                <li>Polyester</li>
                <li>Machine wash</li>
            </ul>
            <h4>Size & Fit</h4>
            <ul>
                <li>Regular fit</li>
                <li>The model (height 5'8" and chest 33") is wearing a size S</li>
            </ul>
            
            <blockquote>
                <p><em>Define style this season with Armani's new range of trendy tops, crafted with intricate details. Create a chic statement look by teaming this lace number with skinny jeans and pumps.</em>
                </p>
            </blockquote> -->

            <!-- <hr>
            <div class="social">
                <h4>Show it to your friends</h4>
                <p>
                    <a href="#" class="external facebook" data-animate-hover="pulse"><i class="fa fa-facebook"></i></a>
                    <a href="#" class="external gplus" data-animate-hover="pulse"><i class="fa fa-google-plus"></i></a>
                    <a href="#" class="external twitter" data-animate-hover="pulse"><i class="fa fa-twitter"></i></a>
                    <a href="#" class="email" data-animate-hover="pulse"><i class="fa fa-envelope"></i></a>
                </p>
            </div> -->
    </div>
    <?php if(count($relatedProducts)>0){ ?>
    <div class="row same-height-row">
        <div class="col-md-3 col-sm-6">
            <div class="box same-height">
                <h3>You may also like these products</h3>
            </div>
        </div>
        <?php 
        foreach ($relatedProducts as $key => $relatedProduct) {
            ?>

        <div class="col-md-3 col-sm-6">
            <div class="product same-height">
                <div class="flip-container">
                    <div class="flipper">
                        <div class="front">
                            <?php echo anchor('products/'.$relatedProduct['slug'], img(['src'=>'assets/uploads/products/'.(!empty($relatedProduct['image_name_1'])?$relatedProduct['image_name_1']:'default-icon.jpg'), 'class'=>"img-responsive"])); ?>
                            <!-- <a href="detail.html">
                                <img src="img/product2.jpg" alt="" class="img-responsive">
                            </a> -->
                        </div>
                        <div class="back">
                            <?php echo anchor('products/'.$relatedProduct['slug'], img(['src'=>'assets/uploads/products/'.(!empty($relatedProduct['image_name_2'])?$relatedProduct['image_name_2']:'default-icon.jpg'), 'class'=>"img-responsive"])); ?>
                            <!-- <a href="detail.html">
                                <img src="img/product2_2.jpg" alt="" class="img-responsive">
                            </a> -->
                        </div>
                    </div>
                </div>
                 <?php echo anchor('products/'.$relatedProduct['slug'], img(['src'=>'assets/uploads/products/'.(!empty($relatedProduct['image_name_1'])?$relatedProduct['image_name_1']:'default-icon.jpg'), 'class'=>"img-responsive"])); ?>
                <!-- <a href="detail.html" class="invisible">
                    <img src="img/product2.jpg" alt="" class="img-responsive">
                </a> -->
                <div class="text">
                    <h3><?php echo $product['product']; ?></h3>
                    <p class="price"><i class="fa fa-inr" aria-hidden="true"></i> <?php echo $product['base_price']; ?></p>
                </div>
            </div>
            <!-- /.product -->
        </div>
            <?php
        }
         ?>

    </div>
    <?php } ?>

    <!--div class="row same-height-row">
        <div class="col-md-3 col-sm-6">
            <div class="box same-height">
                <h3>Products viewed recently</h3>
            </div>
        </div>


        <div class="col-md-3 col-sm-6">
            <div class="product same-height">
                <div class="flip-container">
                    <div class="flipper">
                        <div class="front">
                            <a href="detail.html">
                                <img src="img/product2.jpg" alt="" class="img-responsive">
                            </a>
                        </div>
                        <div class="back">
                            <a href="detail.html">
                                <img src="img/product2_2.jpg" alt="" class="img-responsive">
                            </a>
                        </div>
                    </div>
                </div>
                <a href="detail.html" class="invisible">
                    <img src="img/product2.jpg" alt="" class="img-responsive">
                </a>
                <div class="text">
                    <h3>Fur coat</h3>
                    <p class="price">$143</p>
                </div>
            </div>
            <!-- /.product -->
        <!--/div>

        <div class="col-md-3 col-sm-6">
            <div class="product same-height">
                <div class="flip-container">
                    <div class="flipper">
                        <div class="front">
                            <a href="detail.html">
                                <img src="img/product1.jpg" alt="" class="img-responsive">
                            </a>
                        </div>
                        <div class="back">
                            <a href="detail.html">
                                <img src="img/product1_2.jpg" alt="" class="img-responsive">
                            </a>
                        </div>
                    </div>
                </div>
                <a href="detail.html" class="invisible">
                    <img src="img/product1.jpg" alt="" class="img-responsive">
                </a>
                <div class="text">
                    <h3>Fur coat</h3>
                    <p class="price">$143</p>
                </div>
            </div>
            <!-- /.product -->
        <!--/div>


        <div class="col-md-3 col-sm-6">
            <div class="product same-height">
                <div class="flip-container">
                    <div class="flipper">
                        <div class="front">
                            <a href="detail.html">
                                <img src="img/product3.jpg" alt="" class="img-responsive">
                            </a>
                        </div>
                        <div class="back">
                            <a href="detail.html">
                                <img src="img/product3_2.jpg" alt="" class="img-responsive">
                            </a>
                        </div>
                    </div>
                </div>
                <a href="detail.html" class="invisible">
                    <img src="img/product3.jpg" alt="" class="img-responsive">
                </a>
                <div class="text">
                    <h3>Fur coat</h3>
                    <p class="price">$143</p>

                </div>
            </div>
            <!-- /.product -->
        <!--/div-->

    </div>

</div>
<!-- /.col-md-9 -->