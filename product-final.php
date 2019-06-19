<?php
error_reporting(E_ALL);

include_once ("includes/header_1.php");

$fun = new Functions($pdo);
$pro_id = $fun->encrypt_decrypt("decrypt", $_GET["pro_id"]);

$products = $fun->getProductById($pro_id);

$images = $fun->getAllImageOfPro($pro_id);
$results = $fun->vendorAssignedProd($pro_id);
?>

<div class="shop-area pt-150">
    <div class="container">
        <div class="row">
            <div  class="col-xs-12 col-sm-6 col-md-5">					
                <div  class="for-img-set  owl-carousel">
		    <?php
		    foreach ($images as $image) {
			?>
    		    <div >
    			<img src="<?= BASEURL ?>Panel/uploads/original/<?= $image->pro_images ?>" alt=""/>
    		    </div>
		    <?php } ?>

                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-7">
                <div class="product-details">
                    <h2 class="pro-d-title"><?= $products->pro_name ?> </h2>
                    <!--                    <div class="review-final">
                                            <span>Ratings:<p> 4.5/5</p></span> 
                                        </div>-->
                    <div class="short-desc">
                        <p><?= str_replace(["<p>", "</p>"], "", $products->pro_desc); ?></p>
                    </div>
                    <div class="price-box">
                        <span class="cut-price product-price">INR. <?= $products->act_price ?> </span>
                        <span class="price product-price">INR. <?= $products->dis_price ?></span>

                    </div>

                    <div class="box-quantity">

                        <button data-pro="<?= $fun->encrypt_decrypt("encrypt", $pro_id); ?>" class="book-now add-cart" >add to cart</button>
                        <button onclick="window.location.href = '<?= BASEURL ?>booking.php?pro=<?= $fun->encrypt_decrypt("encrypt", $pro_id); ?>'">Book Now</button>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="pro-info-area ptb-80">
    <div class="container">
	<div class="pro-info-box">
	    <!-- Nav tabs -->
	    <ul class="pro-info-tab" role="tablist">
		<!--		<li class="active"><a href="#profile3" data-toggle="tab">Professionals </a></li>-->
		<li class="active"><a href="#messages3" data-toggle="tab">Professionals </a></li>
		<li><a href="#Reviews" data-toggle="tab">Reviews </a></li>
		<!--		<li><a href="#info" data-toggle="tab">More info </a></li>-->
	    </ul>
	    <!-- Tab panes -->
	    <div class="tab-content">
		<div class="tab-pane active" id="messages3">
		    <?php
		    if ($results != '') {
			foreach ($results as $res) {
			    if (isset($res->vendor_id) && $res->vendor_id != '') {
				$vend_id = $res->vendor_id;
			    } else {
				$vend_id = 0;
			    }
			    $getReview = $fun->getReviewVendorwise($vend_id, $pro_id);
			    foreach ($getReview as $review) {
				
			    }

//				echo '<pre>';
//				print_r($getReview);
//				echo '</pre>';
			    ?> 
			    <div class="pro-desc">
				<div class="col-md-2 ">
				    <div class="rew-img">
					<?php if ($res->profilePic != '') { ?>
	    				<img src="<?= BASEURL ?>Panel/uploads/profilePic/<?= $res->profilePic ?>" alt="">
					<?php } else { ?>
	    				<img src="<?= BASEURL ?>img/travel-agent/travel-agent.jpg" alt="">
					<?php } ?>
				    </div>

				</div>
				<div class="col-md-9 rew-cont">

				    <h3> <?= ucwords($res->fname) . ' ' . ucwords($res->lname) ?> | <small><?= ucwords($res->city) ?></small>  | <small data-toggle="tooltip" data-placement="top" title="<?= ucwords($res->address) ?>"><?= ucwords(substr($res->address, 0, 50)) ?></small>  | <small><?= $res->zip ?></small> |<?php if (isset($review)) { ?> <small><span style="background-color: #69d256;padding: 3px 10px;color: #fff;"><i class="fa fa-star" aria-hidden="true"></i> <?= (isset($review) ? $review->review . '/5' : '') ?></span></small> <?php } ?></h3>
				    <div class="read_more_<?= $res->id ?>">
					<p class="read_more_p_<?= $res->id ?>"> <?php echo substr($res->aboutUs, 0, 250) . ' <i onclick="readMore(' . $res->id . ');" class="fa fa-plus-circle" aria-hidden="true"></i>'; ?></p>
				    </div>
				    <div class="read_more_<?= $res->id ?>" style="display: none;">
					<p class="read_more2_p_<?= $res->id ?>"> <?php echo $res->aboutUs . ' <i onclick="readMore(' . $res->id . ');" class="fa fa-minus-circle" aria-hidden="true"></i>'; ?></p>
				    </div>
				    <p class="prix"> Offer Price : INR <?= $res->dis_price ? $res->dis_price : 'No-information' ?></p>
				    <button class="book-now" onclick="window.location.href = '<?= BASEURL ?>booking.php?pro=<?= $fun->encrypt_decrypt("encrypt", $pro_id); ?>&ven=<?= $fun->encrypt_decrypt("encrypt", $res->sid); ?>'">Book Now</button>
				    <button data-pro="<?= $fun->encrypt_decrypt("encrypt", $pro_id); ?>"  data-ven="<?= $fun->encrypt_decrypt("encrypt", $res->vendor_id); ?>" class="book-now add-cart">Add To Cart</button>
				</div>
			    </div>
			    <?php
			}
		    }
		    ?>
                </div>

		<div class="tab-pane" id="Reviews">
		    <?php
		    if ($results != '') {
			foreach ($results as $res) {
			    if (isset($res->vendor_id) && $res->vendor_id != '') {
				$vend_id = $res->vendor_id;
			    } else {
				$vend_id = 0;
			    }
			    ?> 
			    <div class="pro-desc">
				<div class="col-md-2 ">
				    <div class="rew-img">
					<?php if ($res->profilePic != '') { ?>
	    				<img src="<?= BASEURL ?>Panel/uploads/profilePic/<?= $res->profilePic ?>" alt="">
					<?php } else { ?>
	    				<img src="<?= BASEURL ?>img/travel-agent/travel-agent.jpg" alt="">
					<?php } ?>
				    </div>

				</div>
				<div class="col-md-9 rew-cont">

				    <h3> <?= ucwords($res->fname) . ' ' . ucwords($res->lname) ?> | <small><?= ucwords($res->city) ?></small>  | <small data-toggle="tooltip" data-placement="top" title="<?= ucwords($res->address) ?>"><?= ucwords(substr($res->address, 0, 50)) ?></small>  | <small><?= $res->zip ?></small> |<?php if (isset($review)) { ?> <small><span style="background-color: #69d256;padding: 3px 10px;color: #fff;"><i class="fa fa-star" aria-hidden="true"></i> <?= (isset($review) ? $review->review . '/5' : '') ?></span></small> <?php } ?></h3>
					    <?php
					    $getReview = $fun->getReviewVendorwise($vend_id, $pro_id);
					    foreach ($getReview as $review) {
						$str =ucwords($review->username);
						
						$str2 =substr($str, 0, 1); 
						
						?>
				    
				    <div class=" rew-user">
					<span class="round-lt"><?=$str2?></span>
					<h4> <?= ucwords($review->username) ?></h4>
					<i class="fa fa-star" aria-hidden="true"> <?= $review->review ?></i> 
					<p><?= $review->msg ?></p>
				    </div>
					    
					<?php
				    }
				    ?>
				   
				</div>
			    </div>
			    <?php
			}
		    }
		    ?>

                </div>
		<!--		<div class="tab-pane" id="info">
				    <div class="pro-desc">
					<p>No-information </p>
				    </div>
				</div>-->


	    </div>
	</div>
    </div>
</div>
</div>
</div>



<?php include_once ("includes/footer.php"); ?>
