<?php
include_once ("includes/header.php");

$fun = new Functions($pdo);
$sub_id = $fun->encrypt_decrypt("decrypt", $_GET["sub_id"]);
$products = $fun->getProductsBySubCategory($sub_id);
?>

<div class="inner-top-banner" >
    <div class="inner-top-banner-in" style="background: url(<?= BASEURL ?>Panel/uploads/subcategory/<?=$products[0]->sub_img?>) no-repeat;" >
<!--      <img src="<?= BASEURL ?>img/tour.jpg" alt=""/>-->
        <div class="headline">
            <h2><?= isset($products[0]) ? $products[0]->sub_name : "" ?></h2>
            <a href="#"><?= $products[0]->sub_desc ?></a>  

        </div>

    </div>
</div>

<div class="tour-package">
    <div class="container">
        <div class="tour-package-in">
            <div class="col-md-12">
                <?php foreach ($products as $pro) {		    
		   $results = $fun->vendorAssignedProd($pro->PROID);
		    ?>
                    <div class="list-block">
                        <div class="col-md-2">

                            <img src="<?= BASEURL ?>Panel/uploads/original/<?= $fun->getFirstImageOfPro($pro->PROID)->pro_images ?>" alt="" />
                        </div>
                        <div class="col-md-5 info-sec">
                            <h2><?= $pro->pro_name ?></h2>
                            <ul>
                                <li>
                                    <?= $pro->pro_desc ?>
                                </li>

                            </ul>
                            <div class="list-review">
                                <a href="<?= BASEURL ?><?= $fun->encrypt_decrypt("encrypt", $pro->PROID) ?>">Read more</a>     
                            </div>
                        </div>
                        <div class=" price-show ">
                            <h3>Regular Price</h3>
                            <a href="#" class="view-detail"> <strike>INR <?= $pro->act_price ?></strike>  </a>
                        </div>
                        <div class=" price-show ">
                            <h3>Offer Price</h3>
                            <a href="#" class="view-detail">INR <?= $pro->dis_price ?> <br>  </a>
                        </div>
                        <div class="col-md-2 col-xs-12 booking-set ">
                            <button class="book-now" onclick="window.location.href = '<?= BASEURL ?>booking.php?pro=<?= $fun->encrypt_decrypt("encrypt", $pro->PROID); ?>'">Book Now </button>
                            <button data-pro="<?= $fun->encrypt_decrypt("encrypt", $pro->PROID); ?>" class="book-now add-cart">Add To Cart</button>
                        </div>
                    </div>
                <?php } ?>


            </div>
            <div class="pro-info-area ptb-80">
<!--    <div class="container">
        <div class="pro-info-box">
             Nav tabs 
            <ul class="pro-info-tab" role="tablist">
                <li class="active"><a href="#home3" data-toggle="tab">More info</a></li>
                <li><a href="#profile3" data-toggle="tab">Professionals</a></li>
                <li><a href="#messages3" data-toggle="tab">Reviews</a></li>
            </ul>
             Tab panes 
            <div class="tab-content">
                <div class="tab-pane active" id="home3">
                    <div class="pro-desc">
                        <p>No-information </p>
                    </div>
                </div>

                <div class="tab-pane" id="profile3">
                    <div class="pro-desc">

                        <div class="col-md-2 ">
                            <div class="rew-img">
                                <img src="<?= BASEURL ?>img/travel-agent/travel-agent.jpg" alt="">
                            </div>

                        </div>
                        <div class="col-md-9 rew-cont">
			    <?php if($results !=''){
			     foreach ($results as $res) {	
			     ?>		
                            <h3> <?= ucwords($res->fname) .''. ucwords($res->lname)?> </h3>
                            <p> <?=$res->aboutUs ?$res->aboutUs:'No-information' ?></p>
                            <p> Offer Price : INR <?=$res->dis_price ?$res->dis_price:'No-information' ?></p>
			    <button class="book-now" onclick="window.location.href = '<?= BASEURL ?>booking.php?pro=<?= $fun->encrypt_decrypt("encrypt", $pro->PROID); ?>&ven=<?= $fun->encrypt_decrypt("encrypt", $res->sid); ?>'">Book Now</button>
                            <button data-pro="<?= $fun->encrypt_decrypt("encrypt", $pro->PROID); ?>"  data-ven="<?= $fun->encrypt_decrypt("encrypt", $res->vendor_id); ?>" class="book-now add-cart">Add To Cart</button>
			     <?php } }else{ ?>
			    <p> No-information </p>
			    <?php } ?>
                        </div>


                                                <div class="container">
                                                    <div class="row">
                                                        <h2>Write Here</h2>
                                                        <div class="col-md-6">
                                                            <form class="form-horizontal" action="send.php" method="post">
                                                                <fieldset>
                        
                                                                     Name input
                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label" for="name">Full Name</label>
                                                                        <div class="col-md-9">
                                                                            <input id="name" name="name" type="text" placeholder="Your name" class="form-control">
                                                                        </div>
                                                                    </div>
                        
                                                                     Email input
                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label" for="email">Your E-mail</label>
                                                                        <div class="col-md-9">
                                                                            <input id="email" name="email" type="text" placeholder="Your email" class="form-control">
                                                                        </div>
                                                                    </div>
                        
                                                                     Message body 
                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label" for="message">Your message</label>
                                                                        <div class="col-md-9">
                                                                            <textarea class="form-control" id="message" name="message" placeholder="Please enter your feedback here..." rows="5"></textarea>
                                                                        </div>
                                                                    </div>
                        
                        
                                                                     Rating 
                                                                    <div class="form-group">
                                                                        <label class="col-md-3 control-label" for="message">Your rating</label>
                                                                        <div class="col-md-9">
                                                                            <input id="input-21e" value="0" type="number" class="rating" min=0 max=5 step=0.5 data-size="xs" >
                                                                        </div>
                                                                    </div>
                        
                        
                                                                     Form actions 
                                                                    <div class="form-group">
                                                                        <div class="col-md-12 text-center">
                        
                                                                            <button type="submit" class="rw-sub">Submit</button>
                        
                                                                        </div>
                                                                    </div>
                                                                </fieldset>
                                                            </form>
                                                        </div>
                                                    </div>
                        
                        
                                                </div>

                    </div>	
                </div>
                <div class="tab-pane" id="messages3">
                    <div class="pro-desc">
                        <div class="col-md-2 ">
                            <div class="rew-img">
                                <img src="<?= BASEURL ?>img/travel-agent/travel-agent.jpg" alt="">
                            </div>

                        </div>
                        <div class="col-md-9 rew-cont">
                            <h3>Name here</h3>
                            <p>No-information </p>
                            <span>5/4.5</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>-->
</div>
            
            
            
            <div class="col-md-12">
                <?php if ($products != NULL && is_array($products) && $products[0]->cat_id == 2) { ?>
                    <div class="terms-left">
                        <h3>Terms & Conditions</h3>
                        <ul>
                            <li>State entry, Toll, Parking & any other entry charges payable by customer.</li>
                            <li>Night Driving Charges between 10Pm. To 6 Am. Extra Rs. 250 for Car & 500 for Traveller</li>
                            <li>Air conditioned will be switched off in Hill areas.</li>
                            <li>Round trip fare will be Charge from Customer Pickup Location. </li>
                            <li>Customer will provide accommodation to driver in case of tour more than 2 days.</li>
                        </ul>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php include_once ("includes/footer.php"); ?>