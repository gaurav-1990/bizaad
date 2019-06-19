<?php include_once ("includes/header.php"); ?>

<div class="slider-area fix">
    <div class="slider-active owl-carousel">
        <div class="single-slider" style="background-image:url(img/slider/lipstick.jpg)">
            <div class="container">
                <div class="row">
                    <div class="slider-text">
                       
                        <p>Best Product & Services  by Expert Professionals. </p>
<!--                        <a href="#">shop now</a>-->
                    </div>
                </div>
            </div>
        </div>
<!--        <div class="single-slider" style="background-image:url(img/slider/liner.jpg)">
            <div class="container">
                <div class="row">
                    <div class="slider-text">
                        <span>NEW COLLECTION</span>
                        <p>Best Baby</p>
                        <p>Products</p>
                        <a href="#">shop now</a>
                    </div>
                </div>
            </div>
        </div>-->
    </div>
</div>
<!-- slider-area-end -->
<!-- banner-area-start -->

<div class="category-block">
    <div class="container">
        <div class="category-block-in">
            <div class="row">
                <?php
                $taxi_id = $nav->encrypt_decrypt("encrypt", 2);

                $astro_id = $nav->encrypt_decrypt("encrypt", 3);

                $prof_id = $nav->encrypt_decrypt("encrypt", 7);

                $beauty_id = $nav->encrypt_decrypt("encrypt", 6);

                $health_id = $nav->encrypt_decrypt("encrypt", '#');

                $repair_id = $nav->encrypt_decrypt("encrypt", 8);

                $gemstone_id = $nav->encrypt_decrypt("encrypt", '5');

                $event_id = $nav->encrypt_decrypt("encrypt", '#');
                ?>
                <div onclick="window.location.href = 'cab-book.php'" class="col-md-3 col-sm-6 col-xs-12 ">

                    <div class="boxes">
                        <a href="cab-book.php"> <img src="img/home-category/car.jpg" alt=""/></a>
                        <div class="tag-line">
                            <h2>Cab Booking Online</h2>
                            <p>Click And Easy Book</p>
                            <a href="cab-book.php">View More</a>
                        </div>
                    </div>

                </div>
                <div onclick="window.location.href = '<?= BASEURL ?>taxi-tour/<?= $taxi_id ?>'" class="col-md-3 col-sm-6 col-xs-12 ">

                    <div class="boxes">
                        <a href="<?= BASEURL ?>taxi-tour/<?= $taxi_id ?>"> <img src="img/home-category/taxi.jpg" alt=""/></a>
                        <div class="tag-line">
                            <h2>Taxi & Tour Package</h2>
                            <p>Click And Easy Book</p>
                            <a href="<?= BASEURL ?>taxi-tour/<?= $taxi_id ?>">View More</a>
                        </div>
                    </div>

                </div>
                <div onclick="window.location.href = '<?= BASEURL ?>astrology/<?= $astro_id ?>'" class="col-md-3 col-sm-6 col-xs-12 ">
                    <div class="boxes">
                        <img src="img/home-category/astro.jpg" alt=""/>
                        <div class="tag-line">
                            <h2>Astrology</h2>
                            <p>Life, Health, & Prosperity</p>
                            <a href="#">View More</a>
                        </div>
                    </div>
                </div>

                <div onclick="window.location.href = '<?= BASEURL ?>professionals/<?= $prof_id ?>'" class="col-md-3 col-sm-6 col-xs-12 ">
                    <div class="boxes">
                        <img src="img/home-category/proff.jpg" alt=""/>
                        <div class="tag-line">
                            <h2>Professionals</h2>
                            <p>Life, Health, & Prosperity</p>
                            <a href="#">View More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<div class="product-style-2 ">
    <div class="container">

        <div class="title text-center mb-30">
            <h3>Other Category</h3>

        </div>		
        <div class="product-category-home owl-carousel">
            <div onclick="window.location.href = '<?= BASEURL ?>beauty-style/<?= $beauty_id ?>'" class="product-wrapper-2">
                <div class="product-thumb">
                    <a href="#"><img src="img/home-category/beauty.jpg" alt=""/></a>


                </div>
                <div class="product-contents text-center">
                    <h5 class="product-name"><a href="#">Beauty & Style</a></h5>


                </div>
            </div>
            <div onclick="window.location.href = '<?= BASEURL ?>health-fitness/<?= $health_id ?>'" class="product-wrapper-2">
                <div class="product-thumb">
                    <a href="#"><img src="img/home-category/fitness.jpg" alt=""/></a>


                </div>
                <div class="product-contents text-center">
                    <h5 class="product-name"><a href="#">Health & Fitness</a></h5>



                </div>
            </div>
            <div onclick="window.location.href = '<?= BASEURL ?>repair-management/<?= $repair_id ?>'" class="product-wrapper-2">
                <div class="product-thumb">
                    <a href="#"> <img src="img/home-category/repair.jpg" alt=""/></a>


                </div>
                <div class="product-contents text-center">
                    <h5 class="product-name"><a href="#">Repair & Maintenance</a></h5>



                </div>
            </div>
            <div onclick="window.location.href = '<?= BASEURL ?>gemstone/<?= $gemstone_id ?>'" class="product-wrapper-2">
                <div class="product-thumb">
                    <a href="#"><img src="img/home-category/stone.jpg" alt=""/></a>


                </div>
                <div class="product-contents text-center">
                    <h5 class="product-name"><a href="#">Gemstones</a></h5>



                </div>
            </div>
            <div onclick="window.location.href = '<?= BASEURL ?>event-shows/<?= $event_id ?>'" class="product-wrapper-2">
                <div class="product-thumb">
                    <a href="#"> <img src="img/home-category/puja.jpg" alt=""/></a>


                </div>
                <div class="product-contents text-center">
                    <h5 class="product-name"><a href="#">Event & Shows</a></h5>



                </div>
            </div>
            <div class="product-wrapper-2">
                <div class="product-thumb">
                    <a href="#"><img src="img/home-category/beauty.jpg" alt=""/></a>


                </div>
                <div class="product-contents text-center">
                    <h5 class="product-name"><a href="#">Beauty & Style</a></h5>


                </div>
            </div>
            <div class="product-wrapper-2">
                <div class="product-thumb">
                    <a href="#"><img src="img/home-category/fitness.jpg" alt=""/></a>


                </div>
                <div class="product-contents text-center">
                    <h5 class="product-name"><a href="#">Health & Fitness</a></h5>



                </div>
            </div>
            <div class="product-wrapper-2">
                <div class="product-thumb">
                    <a href="#"> <img src="img/home-category/repair.jpg" alt=""/></a>


                </div>
                <div class="product-contents text-center">
                    <h5 class="product-name"><a href="#">Repair & Maintenance</a></h5>



                </div>
            </div>
            <div class="product-wrapper-2">
                <div class="product-thumb">
                    <a href="#"><img src="img/home-category/stone.jpg" alt=""/></a>


                </div>
                <div class="product-contents text-center">
                    <h5 class="product-name"><a href="#">Gemstones</a></h5>



                </div>
            </div>
            <div class="product-wrapper-2">
                <div class="product-thumb">
                    <a href="#"> <img src="img/home-category/puja.jpg" alt=""/></a>


                </div>
                <div class="product-contents text-center">
                    <h5 class="product-name"><a href="#">Event & Shows</a></h5>



                </div>
            </div>














        </div>
    </div>
</div>
<div class="product-style-2 pt-40">
    <div class="container">

        <div class="title text-center mb-30">
            <h3>Trending & stunning. Unique.</h3>

        </div>		
        <div class="product-2-slider owl-carousel">
            <div class="product-wrapper-2">
                <div class="product-thumb">
                    <a href="#"><img src="img/home-category/w-salone.png" alt=""/></a>


                </div>
                <div class="product-contents text-center">
                    <h5 class="product-name"><a href="#">Salon at home for woman</a></h5>

                    <div class="price-box"> 
                        <span class="new-price"> <i class="fa fa-rupee"></i>600 </span>
                    </div>
                    <div class="actions">
                        <div class="actions-inner">
                            <ul class="add-to-links">

                                <li class="cart"><a href="#">Add to cart</a></li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-wrapper-2">
                <div class="product-thumb">
                    <a href="#"><img src="img/home-category/hair-style.png" alt=""/></a>


                </div>
                <div class="product-contents text-center">
                    <h5 class="product-name"><a href="#">Makeup & Hairstyling</a></h5>

                    <div class="price-box"> 
                        <span class="new-price"> <i class="fa fa-rupee"></i>2,000 </span>

                    </div>
                    <div class="actions">
                        <div class="actions-inner">
                            <ul class="add-to-links">

                                <li class="cart"><a href="#">Add to cart</a></li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-wrapper-2">
                <div class="product-thumb">
                    <a href="#"><img src="img/home-category/mahandi.png" alt=""/></a>


                </div>
                <div class="product-contents text-center">
                    <h5 class="product-name"><a href="#">Mehandi Artist</a></h5>

                    <div class="price-box"> 
                        <span class="new-price"> <i class="fa fa-rupee"></i>500.00 </span>
                    </div>
                    <div class="actions">
                        <div class="actions-inner">
                            <ul class="add-to-links">

                                <li class="cart"><a href="#">Add to cart</a></li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-wrapper-2">
                <div class="product-thumb">
                    <a href="#"><img src="img/home-category/make-over.png" alt=""/></a>


                </div>
                <div class="product-contents text-center">
                    <h5 class="product-name"><a href="#">Makeover Artist</a></h5>

                    <div class="price-box"> 
                        <span class="new-price"> <i class="fa fa-rupee"></i>10,000 </span>
                    </div>
                    <div class="actions">
                        <div class="actions-inner">
                            <ul class="add-to-links">

                                <li class="cart"><a href="#">Add to cart</a></li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-wrapper-2">
                <div class="product-thumb">
                    <a href="#"><img src="img/home-category/w-salone.png" alt=""/></a>


                </div>
                <div class="product-contents text-center">
                    <h5 class="product-name"><a href="#">Salon at home for woman</a></h5>

                    <div class="price-box"> 
                        <span class="new-price"> <i class="fa fa-rupee"></i>600 </span>
                    </div>
                    <div class="actions">
                        <div class="actions-inner">
                            <ul class="add-to-links">

                                <li class="cart"><a href="#">Add to cart</a></li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-wrapper-2">
                <div class="product-thumb">
                    <a href="#"><img src="img/home-category/hair-style.png" alt=""/></a>


                </div>
                <div class="product-contents text-center">
                    <h5 class="product-name"><a href="#">Makeup & Hairstyling</a></h5>

                    <div class="price-box"> 
                        <span class="new-price"> <i class="fa fa-rupee"></i>2,000 </span>

                    </div>
                    <div class="actions">
                        <div class="actions-inner">
                            <ul class="add-to-links">

                                <li class="cart"><a href="#">Add to cart</a></li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-wrapper-2">
                <div class="product-thumb">
                    <a href="#"><img src="img/home-category/mahandi.png" alt=""/></a>


                </div>
                <div class="product-contents text-center">
                    <h5 class="product-name"><a href="#">Mehandi Artist</a></h5>

                    <div class="price-box"> 
                        <span class="new-price"> <i class="fa fa-rupee"></i>500.00 </span>
                    </div>
                    <div class="actions">
                        <div class="actions-inner">
                            <ul class="add-to-links">

                                <li class="cart"><a href="#">Add to cart</a></li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-wrapper-2">
                <div class="product-thumb">
                    <a href="#"><img src="img/home-category/make-over.png" alt=""/></a>


                </div>
                <div class="product-contents text-center">
                    <h5 class="product-name"><a href="#">Makeover Artist</a></h5>

                    <div class="price-box"> 
                        <span class="new-price"> <i class="fa fa-rupee"></i>10,000 </span>
                    </div>
                    <div class="actions">
                        <div class="actions-inner">
                            <ul class="add-to-links">

                                <li class="cart"><a href="#">Add to cart</a></li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>












        </div>
    </div>
</div>
<!-- product-area-end -->
<!-- testimonial-area-start  -->
<!--		<div class="testimonial-area bg-img-1 pt-70 pb-30">
                        <div class="container">
                                <div class="row">				
                                        <div class="col-md-8 col-md-offset-2">
                                                <div class="testimonial-active owl-carousel">
                                                        <div class="testimonial-wrapper">
                                                                <div class="test-img text-center">
                                                                        <img src="img/testimonial/1.jpg" alt="" />
                                                                </div>
                                                                <div class="test-content text-center">
                                                                        <h3>orando BLoom</h3>
                                                                        <span>demo@posthemes.com</span>
                                                                        <p>Great theme, excellent support. We had a few small issues with getting the dropdown menus to work and support fixed them and let us know which files were changed.</p>
                                                                </div>
                                                        </div>
                                                        <div class="testimonial-wrapper">
                                                                <div class="test-img text-center">
                                                                        <img src="img/testimonial/2.jpg" alt="" />
                                                                </div>
                                                                <div class="test-content text-center">
                                                                        <h3>orando BLoom</h3>
                                                                        <span>demo@posthemes.com</span>
                                                                        <p>Great theme, excellent support. We had a few small issues with getting the dropdown menus to work and support fixed them and let us know which files were changed.</p>
                                                                </div>
                                                        </div>
                                                        <div class="testimonial-wrapper">
                                                                <div class="test-img text-center">
                                                                        <img src="img/testimonial/3.jpg" alt="" />
                                                                </div>
                                                                <div class="test-content text-center">
                                                                        <h3>orando BLoom</h3>
                                                                        <span>demo@posthemes.com</span>
                                                                        <p>Great theme, excellent support. We had a few small issues with getting the dropdown menus to work and support fixed them and let us know which files were changed.</p>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>-->
<!--                <div class="product-style-2 pt-80">
                    <div class="container">
                        <div class="title text-center mb-30">
                                <h3>Best Baby Product</h3>
                                <p>Trending & stunning. Unique.</p>
                        </div>		
                        <div class="product-2-slider owl-carousel">
                                <div class="product-wrapper-2">
                                        <div class="product-thumb">
                                                <a href="#"><img src="img/porduct/oil.png" alt="" /></a>
                                                <a href="#"><span class="new">new</span></a>
                                                <div class="quick-views">
                                                        <a href="#">Quick View</a>
                                                </div>
                                        </div>
                                        <div class="product-contents text-center">
                                                <h5 class="product-name"><a href="#">Jhonson's Baby Oil</a></h5>
                                                <div class="rating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-o"></i>
                                                </div>
                                                <div class="price-box"> 
                                                        <span class="new-price"> <i class="fa fa-rupee"></i>160.00 </span>
                                                        <span class="old-price"> <i class="fa fa-rupee"></i>170.00 </span>
                                                </div>
                                                <div class="actions">
                                                        <div class="actions-inner">
                                                                <ul class="add-to-links">
                                                                        <li><a class="add-wishlist" href="#"><i class="fa fa-heart"></i></a></li>
                                                                        <li class="cart"><a href="#">Add to cart</a></li>
                                                                        <li><a class="add_to_compare" href="#"><i class="fa fa-adjust" aria-hidden="true"></i></a></li>
                                                                </ul>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                                <div class="product-wrapper-2">
                                        <div class="product-thumb">
                                                <a href="#"><img src="img/porduct/soap.png" alt="" /></a>
                                                <a href="#"><span class="new">new</span></a>
                                                <div class="quick-views">
                                                        <a href="#">Quick View</a>
                                                </div>
                                        </div>
                                        <div class="product-contents text-center">
                                                <h5 class="product-name"><a href="#">Himalaya Baby Soap</a></h5>
                                                <div class="rating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-o"></i>
                                                </div>
                                                <div class="price-box"> 
                                                        <span class="new-price"> <i class="fa fa-rupee"></i>30.00 </span>
                                                </div>
                                                <div class="actions">
                                                        <div class="actions-inner">
                                                                <ul class="add-to-links">
                                                                        <li><a class="add-wishlist" href="#"><i class="fa fa-heart"></i></a></li>
                                                                        <li class="cart"><a href="#">Add to cart</a></li>
                                                                        <li><a class="add_to_compare" href="#"><i class="fa fa-adjust" aria-hidden="true"></i></a></li>
                                                                </ul>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                                <div class="product-wrapper-2">
                                        <div class="product-thumb">
                                                <a href="#"><img src="img/porduct/lotion.png" alt="" /></a>
                                                <a href="#"><span class="new">new</span></a>
                                                <div class="quick-views">
                                                        <a href="#">Quick View</a>
                                                </div>
                                        </div>
                                        <div class="product-contents text-center">
                                                <h5 class="product-name"><a href="#">Jhonson's Baby Lotion</a></h5>
                                                <div class="rating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                </div>
                                                <div class="price-box"> 
                                                        <span class="new-price"> <i class="fa fa-rupee"></i>150.00 </span>
                                                </div>
                                                <div class="actions">
                                                        <div class="actions-inner">
                                                                <ul class="add-to-links">
                                                                        <li><a class="add-wishlist" href="#"><i class="fa fa-heart"></i></a></li>
                                                                        <li class="cart"><a href="#">Add to cart</a></li>
                                                                        <li><a class="add_to_compare" href="#"><i class="fa fa-adjust" aria-hidden="true"></i></a></li>
                                                                </ul>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                                <div class="product-wrapper-2">
                                        <div class="product-thumb">
                                                <a href="#"><img src="img/porduct/diaper.png" alt="" /></a>
                                                <a href="#"><span class="old">-20%</span></a>
                                                <div class="quick-views">
                                                        <a href="#">Quick View</a>
                                                </div>
                                        </div>
                                        <div class="product-contents text-center">
                                                <h5 class="product-name"><a href="#">Pampers diapers</a></h5>
                                                <div class="rating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-o"></i>
                                                </div>
                                                <div class="price-box"> 
                                                        <span class="new-price"> <i class="fa fa-rupee"></i>80.60 </span>
                                                        <span class="old-price"> <i class="fa fa-rupee"></i>110.00 </span>
                                                </div>
                                                <div class="actions">
                                                        <div class="actions-inner">
                                                                <ul class="add-to-links">
                                                                        <li><a class="add-wishlist" href="#"><i class="fa fa-heart"></i></a></li>
                                                                        <li class="cart"><a href="#">Add to cart</a></li>
                                                                        <li><a class="add_to_compare" href="#"><i class="fa fa-adjust" aria-hidden="true"></i></a></li>
                                                                </ul>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                                <div class="product-wrapper-2">
                                        <div class="product-thumb">
                                                <a href="#"><img src="img/porduct/oil.png" alt="" /></a>
                                                <a href="#"><span class="new">new</span></a>
                                                <div class="quick-views">
                                                        <a href="#">Quick View</a>
                                                </div>
                                        </div>
                                        <div class="product-contents text-center">
                                                <h5 class="product-name"><a href="#">Jhonson's Baby Oil</a></h5>
                                                <div class="rating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-o"></i>
                                                </div>
                                                <div class="price-box"> 
                                                        <span class="new-price"> <i class="fa fa-rupee"></i>160.00 </span>
                                                        <span class="old-price"> <i class="fa fa-rupee"></i>170.00 </span>
                                                </div>
                                                <div class="actions">
                                                        <div class="actions-inner">
                                                                <ul class="add-to-links">
                                                                        <li><a class="add-wishlist" href="#"><i class="fa fa-heart"></i></a></li>
                                                                        <li class="cart"><a href="#">Add to cart</a></li>
                                                                        <li><a class="add_to_compare" href="#"><i class="fa fa-adjust" aria-hidden="true"></i></a></li>
                                                                </ul>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                                <div class="product-wrapper-2">
                                        <div class="product-thumb">
                                                <a href="#"><img src="img/porduct/soap.png" alt="" /></a>
                                                <a href="#"><span class="new">new</span></a>
                                                <div class="quick-views">
                                                        <a href="#">Quick View</a>
                                                </div>
                                        </div>
                                        <div class="product-contents text-center">
                                                <h5 class="product-name"><a href="#">Himalaya Baby Soap</a></h5>
                                                <div class="rating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-o"></i>
                                                </div>
                                                <div class="price-box"> 
                                                        <span class="new-price"> <i class="fa fa-rupee"></i>30.00 </span>
                                                </div>
                                                <div class="actions">
                                                        <div class="actions-inner">
                                                                <ul class="add-to-links">
                                                                        <li><a class="add-wishlist" href="#"><i class="fa fa-heart"></i></a></li>
                                                                        <li class="cart"><a href="#">Add to cart</a></li>
                                                                        <li><a class="add_to_compare" href="#"><i class="fa fa-adjust" aria-hidden="true"></i></a></li>
                                                                </ul>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                                <div class="product-wrapper-2">
                                        <div class="product-thumb">
                                                <a href="#"><img src="img/porduct/lotion.png" alt="" /></a>
                                                <a href="#"><span class="new">new</span></a>
                                                <div class="quick-views">
                                                        <a href="#">Quick View</a>
                                                </div>
                                        </div>
                                        <div class="product-contents text-center">
                                                <h5 class="product-name"><a href="#">Jhonson's Baby Lotion</a></h5>
                                                <div class="rating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                </div>
                                                <div class="price-box"> 
                                                        <span class="new-price"> <i class="fa fa-rupee"></i>150.00 </span>
                                                </div>
                                                <div class="actions">
                                                        <div class="actions-inner">
                                                                <ul class="add-to-links">
                                                                        <li><a class="add-wishlist" href="#"><i class="fa fa-heart"></i></a></li>
                                                                        <li class="cart"><a href="#">Add to cart</a></li>
                                                                        <li><a class="add_to_compare" href="#"><i class="fa fa-adjust" aria-hidden="true"></i></a></li>
                                                                </ul>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                                <div class="product-wrapper-2">
                                        <div class="product-thumb">
                                                <a href="#"><img src="img/porduct/diaper.png" alt="" /></a>
                                                <a href="#"><span class="old">-20%</span></a>
                                                <div class="quick-views">
                                                        <a href="#">Quick View</a>
                                                </div>
                                        </div>
                                        <div class="product-contents text-center">
                                                <h5 class="product-name"><a href="#">Pampers diapers</a></h5>
                                                <div class="rating">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-o"></i>
                                                </div>
                                                <div class="price-box"> 
                                                        <span class="new-price"> <i class="fa fa-rupee-sign"></i>80.60 </span>
                                                        <span class="old-price"> <i class="fa fa-rupee"></i>110.00 </span>
                                                </div>
                                                <div class="actions">
                                                        <div class="actions-inner">
                                                                <ul class="add-to-links">
                                                                        <li><a class="add-wishlist" href="#"><i class="fa fa-heart"></i></a></li>
                                                                        <li class="cart"><a href="#">Add to cart</a></li>
                                                                        <li><a class="add_to_compare" href="#"><i class="fa fa-adjust" aria-hidden="true"></i></a></li>
                                                                </ul>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>
                </div>-->
<div class="product-item pt-40 pb-50">
    <div class="container">

        <div class="col-md-6 mb-30">
            <div class="section-title">
                <h2>Health & Fittness</h2>
            </div>

            <div class="item-active owl-carousel">
                <div class="col-md-12 remove-pad">
                    <div class="product-wrapper">
                        <div class="products-img">
                            <a href="#"><img src="img/home-category/dietician.png" alt=""/></a>

                        </div>
                        <div class="product-text">
                            <h5><a href="#">Dietician &amp; Nutritionist</a></h5>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="price-box"> 
                                <span class="new-price"> <i class="fa fa-rupee"></i>1500 </span>
                            </div>
                        </div>
                    </div>
                    <div class="product-wrapper">
                        <div class="products-img">
                            <a href="#"><img src="img/home-category/yoga.png" alt=""/></a>
                        </div>
                        <div class="product-text">
                            <h5><a href="#"> Yoga Trainer</a></h5>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                            </div>
                            <div class="price-box"> 
                                <span class="new-price"> <i class="fa fa-rupee"></i>1,500 </span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-12 remove-pad">
                    <div class="product-wrapper">
                        <div class="products-img">
                            <a href="#"><img src="img/home-category/physiotherapist.png" alt=""/></a>
                        </div>
                        <div class="product-text">
                            <h5><a href="#"> Physiotherapist</a></h5>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-o"></i>
                            </div>
                            <div class="price-box"> 
                                <span class="new-price"> <i class="fa fa-rupee"></i>1,500 </span>
                            </div>
                        </div>
                    </div>
                    <div class="product-wrapper">
                        <div class="products-img">
                            <a href="#"><img src="img/home-category/weight.png" alt=""/></a>
                        </div>
                        <div class="product-text">
                            <h5><a href="#">Weight Loss Package</a></h5>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="price-box"> 
                                <span class="new-price"> <i class="fa fa-rupee"></i>3,500 </span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-12 remove-pad">
                    <div class="product-wrapper">
                        <div class="products-img">
                            <a href="#"><img src="img/home-category/dietician.png" alt=""/></a>

                        </div>
                        <div class="product-text">
                            <h5><a href="#">Dietician &amp; Nutritionist</a></h5>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="price-box"> 
                                <span class="new-price"> <i class="fa fa-rupee"></i>1500 </span>
                            </div>
                        </div>
                    </div>
                    <div class="product-wrapper">
                        <div class="products-img">
                            <a href="#"><img src="img/home-category/yoga.png" alt=""/></a>
                        </div>
                        <div class="product-text">
                            <h5><a href="#"> Yoga Trainer</a></h5>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                            </div>
                            <div class="price-box"> 
                                <span class="new-price"> <i class="fa fa-rupee"></i>1,500 </span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-12 remove-pad">
                    <div class="product-wrapper">
                        <div class="products-img">
                            <a href="#"><img src="img/home-category/physiotherapist.png" alt=""/></a>
                        </div>
                        <div class="product-text">
                            <h5><a href="#"> Physiotherapist</a></h5>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-o"></i>
                            </div>
                            <div class="price-box"> 
                                <span class="new-price"> <i class="fa fa-rupee"></i>1,500 </span>
                            </div>
                        </div>
                    </div>
                    <div class="product-wrapper">
                        <div class="products-img">
                            <a href="#"><img src="img/home-category/weight.png" alt=""/></a>
                        </div>
                        <div class="product-text">
                            <h5><a href="#">Weight Loss Package</a></h5>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="price-box"> 
                                <span class="new-price"> <i class="fa fa-rupee"></i>3,500 </span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <div class="col-md-6 mb-30">
            <div class="section-title">
                <h2> Gemstones  </h2>
            </div>

            <div class="item-active owl-carousel">
                <div class="col-md-12 remove-pad">
                    <div class="product-wrapper">
                        <div class="products-img">
                            <a href="#"><img src="img/stone/yellow.png" alt=""/></a>

                        </div>
                        <div class="product-text">
                            <h5><a href="#">YELLOW SAPPHIRE<br> (Pukhraj)</a></h5>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="price-box"> 
                                <span class="new-price"> <i class="fa fa-rupee"></i>1,200 </span>

                            </div>
                        </div>
                    </div>
                    <div class="product-wrapper">
                        <div class="products-img">
                            <a href="#"><img src="img/stone/blue-neelam.png" alt=""/></a>
                        </div>
                        <div class="product-text">
                            <h5><a href="#">BLUE SAPPHIRE <br>(Neelam)</a></h5>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="price-box"> 
                                <span class="new-price"> <i class="fa fa-rupee"></i>1,200 </span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-12 remove-pad">
                    <div class="product-wrapper">
                        <div class="products-img">
                            <a href="#"><img src="img/stone/panna.png" alt=""/></a>
                        </div>
                        <div class="product-text">
                            <h5><a href="#">EMERALD (Panna)</a></h5>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-o"></i>
                            </div>
                            <div class="price-box"> 
                                <span class="new-price"> <i class="fa fa-rupee"></i>1,200 </span>
                            </div>
                        </div>
                    </div>
                    <div class="product-wrapper">
                        <div class="products-img">
                            <a href="#"><img src="img/stone/ruby.png" alt=""/></a>
                        </div>
                        <div class="product-text">
                            <h5><a href="#">RUBY (Manik)</a></h5>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="price-box"> 
                                <span class="new-price"> <i class="fa fa-rupee"></i>1,200 </span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-12 remove-pad">
                    <div class="product-wrapper">
                        <div class="products-img">
                            <a href="#"><img src="img/stone/opal.png" alt=""/></a>
                        </div>
                        <div class="product-text">
                            <h5><a href="#">OPAL</a></h5>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="price-box"> 
                                <span class="new-price"> <i class="fa fa-rupee"></i>700.00 </span>

                            </div>
                        </div>
                    </div>
                    <div class="product-wrapper">
                        <div class="products-img">
                            <a href="#"><img src="img/stone/lapis.png" alt=""/></a>
                        </div>
                        <div class="product-text">
                            <h5><a href="#">LAPIS LAZULI</a></h5>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="price-box"> 
                                <span class="new-price"> <i class="fa fa-rupee"></i>700.00 </span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-12 remove-pad">
                    <div class="product-wrapper">
                        <div class="products-img">
                            <a href="#"><img src="img/stone/red-moonga.png" alt=""/></a>
                        </div>
                        <div class="product-text">
                            <h5><a href="#">RED CORAL ( Moonga)</a></h5>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-o"></i>
                            </div>
                            <div class="price-box"> 
                                <span class="new-price"> <i class="fa fa-rupee"></i>800.00 </span>
                            </div>
                        </div>
                    </div>
                    <div class="product-wrapper">
                        <div class="products-img">
                            <a href="#"><img src="img/stone/cateye.png" alt=""/></a>
                        </div>
                        <div class="product-text">
                            <h5><a href="#">CATS EYE (Lehsunia)</a></h5>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <div class="price-box"> 
                                <span class="new-price"> <i class="fa fa-rupee"></i>300.00 </span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>
<!-- testimonial-area-end  -->
<!-- blog-area-start -->
<!--		<div class="blog-area pt-80">
                        <div class="container">
                                <div class="section-title">
                                        <h2>FLatest blogs & Updates</h2>
                                </div>
                                <div class="row">
                                        <div class="blog-active owl-carousel">
                                                <div class="col-md-12">
                                                        <div class="blog-wrapper">
                                                                <div class="blog-img">
                                                                        <a href="#"><img src="img/blog/1.jpg" alt="" /></a>
                                                                        <div class="blog-info">
                                                                                <a href="#"><span>Read More</span></a>
                                                                        </div>
                                                                </div>
                                                                <div class="blog-content">
                                                                        <h4><a href="#">when an unknown printer</a></h4>
                                                                        <span class="date-smart">Mar 14, 2017</span>
                                                                        <p> It is a long established fact that a reader will be distracted by the readable content of a page when looking at its...</p>
                                                                        <a href="#"><span>Continue Reading</span></a>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="col-md-12">
                                                        <div class="blog-wrapper">
                                                                <div class="blog-img">
                                                                        <a href="#"><img src="img/blog/2.jpg" alt="" /></a>
                                                                        <div class="blog-info">
                                                                                <a href="#"><span>Read More</span></a>
                                                                        </div>
                                                                </div>
                                                                <div class="blog-content">
                                                                        <h4><a href="#">Answers to your Questions about...</a></h4>
                                                                        <span class="date-smart">Mar 14, 2017</span>
                                                                        <p> It is a long established fact that a reader will be distracted by the readable content of a page when looking at its...</p>
                                                                        <a href="#"><span>Continue Reading</span></a>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="col-md-12">
                                                        <div class="blog-wrapper">
                                                                <div class="blog-img">
                                                                        <a href="#"><img src="img/blog/3.jpg" alt="" /></a>
                                                                        <div class="blog-info">
                                                                                <a href="#"><span>Read More</span></a>
                                                                        </div>
                                                                </div>
                                                                <div class="blog-content">
                                                                        <h4><a href="#">What is Bootstrap? – The History...</a></h4>
                                                                        <span class="date-smart">Mar 14, 2017</span>
                                                                        <p> It is a long established fact that a reader will be distracted by the readable content of a page when looking at its...</p>
                                                                        <a href="#"><span>Continue Reading</span></a>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="col-md-12">
                                                        <div class="blog-wrapper">
                                                                <div class="blog-img">
                                                                        <a href="#"><img src="img/blog/1.jpg" alt="" /></a>
                                                                        <div class="blog-info">
                                                                                <a href="#"><span>Read More</span></a>
                                                                        </div>
                                                                </div>
                                                                <div class="blog-content">
                                                                        <h4><a href="#">From Now we are certified web...</a></h4>
                                                                        <span class="date-smart">Mar 14, 2017</span>
                                                                        <p> It is a long established fact that a reader will be distracted by the readable content of a page when looking at its...</p>
                                                                        <a href="#"><span>Continue Reading</span></a>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>-->
<!-- blog-area-end -->
<!-- product-itemt -->
<!--		<div class="product-item pt-80 pb-50">
                        <div class="container">
                                <div class="row">
                                        <div class="col-md-6 mb-30">
                                                <div class="section-title">
                                                        <h2>Girls Bundle product</h2>
                                                </div>
                                                <div class="row">
                                                        <div class="item-active owl-carousel">
                                                                <div class="col-md-12">
                                                                        <div class="product-wrapper">
                                                                                <div class="products-img">
                                                                                        <a href="#"><img src="img/product-1/g1.jpg" alt="" /></a>
                                                                                </div>
                                                                                <div class="product-text">
                                                                                        <h5><a href="#">Bundle Beauty Kit</a></h5>
                                                                                        <div class="rating">
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                        </div>
                                                                                        <div class="price-box"> 
                                                                                                <span class="new-price"> <i class="fa fa-rupee"></i>280.00 </span>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                        <div class="product-wrapper">
                                                                                <div class="products-img">
                                                                                        <a href="#"><img src="img/product-1/g2.jpg" alt="" /></a>
                                                                                </div>
                                                                                <div class="product-text">
                                                                                        <h5><a href="#">Bundle Beauty Kit</a></h5>
                                                                                        <div class="rating">
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star-o"></i>
                                                                                                <i class="fa fa-star-o"></i>
                                                                                        </div>
                                                                                        <div class="price-box"> 
                                                                                                <span class="new-price"> <i class="fa fa-rupee"></i>268.00 </span>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                        <div class="product-wrapper">
                                                                                <div class="products-img">
                                                                                        <a href="#"><img src="img/product-1/g3.jpg" alt="" /></a>
                                                                                </div>
                                                                                <div class="product-text">
                                                                                        <h5><a href="#">Bundle Beauty Kit</a></h5>
                                                                                        <div class="rating">
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star-o"></i>
                                                                                                <i class="fa fa-star-o"></i>
                                                                                        </div>
                                                                                        <div class="price-box"> 
                                                                                                <span class="new-price"> <i class="fa fa-rupee"></i>368.00 </span>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                        <div class="product-wrapper">
                                                                                <div class="products-img">
                                                                                        <a href="#"><img src="img/product-1/g4.jpg" alt="" /></a>
                                                                                </div>
                                                                                <div class="product-text">
                                                                                        <h5><a href="#">Bundle Beauty Kit</a></h5>
                                                                                        <div class="rating">
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star-o"></i>
                                                                                        </div>
                                                                                        <div class="price-box"> 
                                                                                                <span class="new-price"> <i class="fa fa-rupee"></i>280.00 </span>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                        <div class="product-wrapper">
                                                                                <div class="products-img">
                                                                                        <a href="#"><img src="img/product-1/g5.jpg" alt="" /></a>
                                                                                </div>
                                                                                <div class="product-text">
                                                                                        <h5><a href="#">Bundle Beauty Kit</a></h5>
                                                                                        <div class="rating">
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                        </div>
                                                                                        <div class="price-box"> 
                                                                                                <span class="new-price"> <i class="fa fa-rupee"></i>268.00 </span>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                        <div class="product-wrapper">
                                                                                <div class="products-img">
                                                                                        <a href="#"><img src="img/product-1/g1.jpg" alt="" /></a>
                                                                                </div>
                                                                                <div class="product-text">
                                                                                        <h5><a href="#">Bundle Beauty Kit</a></h5>
                                                                                        <div class="rating">
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star-o"></i>
                                                                                        </div>
                                                                                        <div class="price-box"> 
                                                                                                <span class="new-price"> <i class="fa fa-rupee"></i>260.00 </span>
                                                                                                <span class="old-price"> <i class="fa fa-rupee"></i>300.00 </span>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                        <div class="product-wrapper">
                                                                                <div class="products-img">
                                                                                        <a href="#"><img src="img/product-1/g2.jpg" alt="" /></a>
                                                                                </div>
                                                                                <div class="product-text">
                                                                                        <h5><a href="#">Bundle Beauty Kit</a></h5>
                                                                                        <div class="rating">
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                        </div>
                                                                                        <div class="price-box"> 
                                                                                                <span class="new-price"> <i class="fa fa-rupee"></i>160.00 </span>
                                                                                                <span class="old-price"> <i class="fa fa-rupee"></i>200.00 </span>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                        <div class="product-wrapper">
                                                                                <div class="products-img">
                                                                                        <a href="#"><img src="img/product-1/g3.jpg" alt="" /></a>
                                                                                </div>
                                                                                <div class="product-text">
                                                                                        <h5><a href="#">Bundle Beauty Kit</a></h5>
                                                                                        <div class="rating">
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                        </div>
                                                                                        <div class="price-box"> 
                                                                                                <span class="new-price"> <i class="fa fa-rupee"></i>440.00 </span>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                        <div class="product-wrapper">
                                                                                <div class="products-img">
                                                                                        <a href="#"><img src="img/product-1/g4.jpg" alt="" /></a>
                                                                                </div>
                                                                                <div class="product-text">
                                                                                        <h5><a href="#">Bundle Beauty Kit</a></h5>
                                                                                        <div class="rating">
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                        </div>
                                                                                        <div class="price-box"> 
                                                                                                <span class="new-price"> <i class="fa fa-rupee"></i>550.00 </span>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                        <div class="product-wrapper">
                                                                                <div class="products-img">
                                                                                        <a href="#"><img src="img/product-1/g5.jpg" alt="" /></a>
                                                                                </div>
                                                                                <div class="product-text">
                                                                                        <h5><a href="#">Bundle Beauty Kit</a></h5>
                                                                                        <div class="rating">
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                        </div>
                                                                                        <div class="price-box"> 
                                                                                                <span class="new-price"> <i class="fa fa-rupee"></i>230.00 </span>
                                                                                                <span class="old-price"> <i class="fa fa-rupee"></i>250.00 </span>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                        <div class="product-wrapper">
                                                                                <div class="products-img">
                                                                                        <a href="#"><img src="img/product-1/g1.jpg" alt="" /></a>
                                                                                </div>
                                                                                <div class="product-text">
                                                                                        <h5><a href="#">Bundle Beauty Kit</a></h5>
                                                                                        <div class="rating">
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                        </div>
                                                                                        <div class="price-box"> 
                                                                                                <span class="new-price"> <i class="fa fa-rupee"></i>250.00 </span>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                        <div class="product-wrapper">
                                                                                <div class="products-img">
                                                                                        <a href="#"><img src="img/product-1/g2.jpg" alt="" /></a>
                                                                                </div>
                                                                                <div class="product-text">
                                                                                        <h5><a href="#">Bundle Beauty Kit</a></h5>
                                                                                        <div class="rating">
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                        </div>
                                                                                        <div class="price-box"> 
                                                                                                <span class="new-price"> <i class="fa fa-rupee"></i>350.00 </span>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                        <div class="col-md-6 mb-30">
                                                <div class="section-title">
                                                        <h2> Baby Bundle Product  </h2>
                                                </div>
                                                <div class="row">
                                                        <div class="item-active owl-carousel">
                                                                <div class="col-md-12">
                                                                        <div class="product-wrapper">
                                                                                <div class="products-img">
                                                                                        <a href="#"><img src="img/product-1/p1.jpg" alt="" /></a>
                                                                                </div>
                                                                                <div class="product-text">
                                                                                        <h5><a href="#">Baby bundle product</a></h5>
                                                                                        <div class="rating">
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                        </div>
                                                                                        <div class="price-box"> 
                                                                                                <span class="new-price"> <i class="fa fa-rupee"></i>260.00 </span>
                                                                                                <span class="old-price"> <i class="fa fa-rupee"></i>300.00 </span>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                        <div class="product-wrapper">
                                                                                <div class="products-img">
                                                                                        <a href="#"><img src="img/product-1/p2.jpg" alt="" /></a>
                                                                                </div>
                                                                                <div class="product-text">
                                                                                        <h5><a href="#">Baby bundle product</a></h5>
                                                                                        <div class="rating">
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                        </div>
                                                                                        <div class="price-box"> 
                                                                                                <span class="new-price"> <i class="fa fa-rupee"></i>326.00 </span>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                        <div class="product-wrapper">
                                                                                <div class="products-img">
                                                                                        <a href="#"><img src="img/product-1/p3.jpg" alt="" /></a>
                                                                                </div>
                                                                                <div class="product-text">
                                                                                        <h5><a href="#">Baby bundle product</a></h5>
                                                                                        <div class="rating">
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                        </div>
                                                                                        <div class="price-box"> 
                                                                                                <span class="new-price"> <i class="fa fa-rupee"></i>560.00 </span>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                        <div class="product-wrapper">
                                                                                <div class="products-img">
                                                                                        <a href="#"><img src="img/product-1/p4.jpg" alt="" /></a>
                                                                                </div>
                                                                                <div class="product-text">
                                                                                        <h5><a href="#">Baby bundle product</a></h5>
                                                                                        <div class="rating">
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star-o"></i>
                                                                                        </div>
                                                                                        <div class="price-box"> 
                                                                                                <span class="new-price"> <i class="fa fa-rupee"></i>280.00 </span>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                        <div class="product-wrapper">
                                                                                <div class="products-img">
                                                                                        <a href="#"><img src="img/product-1/p1.jpg" alt="" /></a>
                                                                                </div>
                                                                                <div class="product-text">
                                                                                        <h5><a href="#">Baby bundle product</a></h5>
                                                                                        <div class="rating">
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                        </div>
                                                                                        <div class="price-box"> 
                                                                                                <span class="new-price"> <i class="fa fa-rupee"></i>168.00 </span>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                        <div class="product-wrapper">
                                                                                <div class="products-img">
                                                                                        <a href="#"><img src="img/product-1/p2.jpg" alt="" /></a>
                                                                                </div>
                                                                                <div class="product-text">
                                                                                        <h5><a href="#">Baby bundle product</a></h5>
                                                                                        <div class="rating">
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star-o"></i>
                                                                                        </div>
                                                                                        <div class="price-box"> 
                                                                                                <span class="new-price"> <i class="fa fa-rupee"></i>160.00 </span>
                                                                                                <span class="old-price"> <i class="fa fa-rupee"></i>200.00 </span>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                        <div class="product-wrapper">
                                                                                <div class="products-img">
                                                                                        <a href="#"><img src="img/product-1/p3.jpg" alt="" /></a>
                                                                                </div>
                                                                                <div class="product-text">
                                                                                        <h5><a href="#">Baby bundle product</a></h5>
                                                                                        <div class="rating">
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                        </div>
                                                                                        <div class="price-box"> 
                                                                                                <span class="new-price"> <i class="fa fa-rupee"></i>280.00 </span>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                        <div class="product-wrapper">
                                                                                <div class="products-img">
                                                                                        <a href="#"><img src="img/product-1/p4.jpg" alt="" /></a>
                                                                                </div>
                                                                                <div class="product-text">
                                                                                        <h5><a href="#">Baby bundle product</a></h5>
                                                                                        <div class="rating">
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star-o"></i>
                                                                                                <i class="fa fa-star-o"></i>
                                                                                        </div>
                                                                                        <div class="price-box"> 
                                                                                                <span class="new-price"> <i class="fa fa-rupee"></i>68.00 </span>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                        <div class="product-wrapper">
                                                                                <div class="products-img">
                                                                                        <a href="#"><img src="img/product-1/p1.jpg" alt="" /></a>
                                                                                </div>
                                                                                <div class="product-text">
                                                                                        <h5><a href="#">Baby bundle product</a></h5>
                                                                                        <div class="rating">
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star-o"></i>
                                                                                                <i class="fa fa-star-o"></i>
                                                                                        </div>
                                                                                        <div class="price-box"> 
                                                                                                <span class="new-price"> <i class="fa fa-rupee"></i>168.00 </span>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                        <div class="product-wrapper">
                                                                                <div class="products-img">
                                                                                        <a href="#"><img src="img/product-1/p2.jpg" alt="" /></a>
                                                                                </div>
                                                                                <div class="product-text">
                                                                                        <h5><a href="#">Baby bundle product</a></h5>
                                                                                        <div class="rating">
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                        </div>
                                                                                        <div class="price-box"> 
                                                                                                <span class="new-price"> <i class="fa fa-rupee"></i>430.00 </span>
                                                                                                <span class="old-price"> <i class="fa fa-rupee"></i>588.00 </span>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                        <div class="product-wrapper">
                                                                                <div class="products-img">
                                                                                        <a href="#"><img src="img/product-1/p3.jpg" alt="" /></a>
                                                                                </div>
                                                                                <div class="product-text">
                                                                                        <h5><a href="#">Baby bundle product</a></h5>
                                                                                        <div class="rating">
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                        </div>
                                                                                        <div class="price-box"> 
                                                                                                <span class="new-price"> <i class="fa fa-rupee"></i>120.00 </span>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                        <div class="product-wrapper">
                                                                                <div class="products-img">
                                                                                        <a href="#"><img src="img/product-1/p4.jpg" alt="" /></a>
                                                                                </div>
                                                                                <div class="product-text">
                                                                                        <h5><a href="#">Baby bundle product</a></h5>
                                                                                        <div class="rating">
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                        </div>
                                                                                        <div class="price-box"> 
                                                                                                <span class="new-price"> <i class="fa fa-rupee"></i>68.00 </span>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>-->
<!-- product-item-end -->
<!-- our-brand-area-start -->
<!--	<div class="our-brand-area pb-70">
                        <div class="container">
                            <div class="title text-center mb-30">
                                <h3>Our Brands</h3>
                                <p>Trending & stunning. Unique.</p>
                        </div>
                                <div class="row">
                                        <div class="brand-active owl-carousel">
                                                <div class="col-md-12">
                                                        <div class="single-brand">
                                                                <div class="brand-img">
                                                                        <img src="img/brand/1.jpg" alt="" />
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="col-md-12">
                                                        <div class="single-brand">
                                                                <div class="brand-img">
                                                                        <img src="img/brand/2.jpg" alt="" />
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="col-md-12">
                                                        <div class="single-brand">
                                                                <div class="brand-img">
                                                                        <img src="img/brand/3.jpg" alt="" />
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="col-md-12">
                                                        <div class="single-brand">
                                                                <div class="brand-img">
                                                                        <img src="img/brand/4.jpg" alt="" />
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="col-md-12">
                                                        <div class="single-brand">
                                                                <div class="brand-img">
                                                                        <img src="img/brand/5.jpg" alt="" />
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="col-md-12">
                                                        <div class="single-brand">
                                                                <div class="brand-img">
                                                                        <img src="img/brand/6.jpg" alt="" />
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="col-md-12">
                                                        <div class="single-brand">
                                                                <div class="brand-img">
                                                                        <img src="img/brand/7.jpg" alt="" />
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>-->
<!-- our-brand-area-end -->
<!-- footer-area-start -->

<!--                <div class="subscribe-select">
                    <div class="container">
                         <div class="title text-center mb-30">
                                <h3>Best Baby Product</h3>
                                <p>Trending & stunning. Unique.</p>
                        </div>
                        
                        <div class="row">
                                                <div class="col-md-3">
                                                    <div class="sub-box">
                                                        <div class="price-part">
                                                            <h3>1 Month</h3>
                                                            <h1>
                                                                <i class="fa fa-inr" aria-hidden="true"></i>399 /- <span>per Box</span>
                                                            </h1>
                                                        </div>
                                                        <div class="include-part">
                                                            <p>4 to 5 Beauty Products</p>
                                                            <h3>
                                                                SHIPPING INCLUDED
                                                            </h3>
                                                        </div>
                                                        <div class="sub-part">
                                                            <p>Total <i class="fa fa-inr" aria-hidden="true"></i>399 Only</p>
                                                            <button>Subscribe</button>
                                                        </div>
                                                        
                                                        
                                                    </div>         
                        
                    </div>
                                                <div class="col-md-3">
                                                    <div class="sub-box">
                                                        <div class="price-part">
                                                            <h3>3 Month</h3>
                                                            <h1>
                                                                <i class="fa fa-inr" aria-hidden="true"></i>349 /- <span>per Box</span>
                                                            </h1>
                                                        </div>
                                                        <div class="include-part">
                                                            <p>4 to 5 Beauty Products</p>
                                                            <h3>
                                                                SHIPPING INCLUDED
                                                            </h3>
                                                        </div>
                                                        <div class="sub-part">
                                                            <p>Total <i class="fa fa-inr" aria-hidden="true"></i>349 Only</p>
                                                            <button>Subscribe</button>
                                                        </div>
                                                        
                                                        
                                                    </div>         
                        
                    </div>
                                                <div class="col-md-3">
                                                    <div class="sub-box">
                                                        <div class="price-part">
                                                            <h3>6 Month</h3>
                                                            <h1>
                                                                <i class="fa fa-inr" aria-hidden="true"></i>319 /- <span>per Box</span>
                                                            </h1>
                                                        </div>
                                                        <div class="include-part">
                                                            <p>4 to 5 Beauty Products</p>
                                                            <h3>
                                                                SHIPPING INCLUDED
                                                            </h3>
                                                        </div>
                                                        <div class="sub-part">
                                                            <p>Total <i class="fa fa-inr" aria-hidden="true"></i>319 Only</p>
                                                            <button>Subscribe</button>
                                                        </div>
                                                        
                                                        
                                                    </div>         
                        
                    </div>
                                                <div class="col-md-3">
                                                    <div class="sub-box">
                                                        <div class="price-part">
                                                            <h3>12 Month</h3>
                                                            <h1>
                                                                <i class="fa fa-inr" aria-hidden="true"></i>299 /- <span>per Box</span>
                                                            </h1>
                                                        </div>
                                                        <div class="include-part">
                                                            <p>4 to 5 Beauty Products</p>
                                                            <h3>
                                                                SHIPPING INCLUDED
                                                            </h3>
                                                        </div>
                                                        <div class="sub-part">
                                                            <p>Total <i class="fa fa-inr" aria-hidden="true"></i>299 Only</p>
                                                            <button>Subscribe</button>
                                                        </div>
                                                        
                                                        
                                                    </div>         
                        
                    </div>
                        </div>
                    </div>
                </div>-->
<?php include_once ("includes/footer.php"); ?>