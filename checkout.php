<?php

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

session_start();
require('razorpay-php/Razorpay.php');
include_once ("includes/header_1.php");
if (!isset($_SESSION["userid"]) || $_SESSION["userid"] == NULL) {
    if (isset($_GET['checkout'])) {
	echo "<script type='text/javascript'>window.location.href='login.php?checkout=yes'</script>";
    } else {
	echo "<script type='text/javascript'>window.location.href='login.php'</script>";
    }
}

if (!empty($_POST) && !empty($_SESSION["userid"]) && !empty($_SESSION["cart"]) && !isset($_GET["pay_id"])) {


    $sign = new Functions($pdo);
    $orderData32 = $sign->addCustomerOrder($_POST, $_SESSION["cart"]);
    
    $api = new Api($keyId, $keySecret);
   
    if ($_POST['tot_days'] != '' && $_POST["payment_type"] != "advance") {

	$price = $orderData32[0] * $_POST['tot_days'];
    } else {

	$price = $orderData32[0] ;
    }
    if ($_POST["payment_type"] == "advance") {
	    
	     if($_POST['tot_days'] != '' && $_POST['tot_days'] != NULL){
		 $price = $orderData32[0] * $_POST['tot_days'];		
	    }else{
		$price = $orderData32[0];
	    }
          
        }
    

    $base = BASEURL;
    $orderData = [
	'receipt' => $orderData32[1],
	'amount' => floatval($price) * 100, // 2000 rupees in paise
	'currency' => 'INR',
	'payment_capture' => 1 // auto capture
    ];
    $razorpayOrder = $api->order->create($orderData);
    $razorpayOrderId = $razorpayOrder['id'];
    $_SESSION['razorpay_order_id'] = $razorpayOrderId;
    $amount = $orderData['amount'];

    if ($displayCurrency !== 'INR') {
	$url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
	$exchange = json_decode(file_get_contents($url), true);
	$displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
    }
    $encoded_last = $sign->encrypt_decrypt("encrypt", $orderData32[1]);
    $data = [
	"key" => $keyId,
	"amount" => $amount,
	"name" => "Bizaad.com",
	"description" => "Product Order Id $orderData32[1]",
	"image" => "{$base}img/logo/logo.png",
	"prefill" => [
	    "name" => "{$_POST["firstname"]} {$_POST["lastname"]}",
	    "email" => "{$_POST["user_email"]}",
	    "contact" => "{$_POST["contact"]}",
	],
	"notes" => [
	    "merchant_order_id" => "$razorpayOrderId",
	],
	"theme" => [
	    "color" => "#F37254"
	],
	"order_id" => $razorpayOrderId,
    ];
    if ($displayCurrency !== 'INR') {
	$data['display_currency'] = $displayCurrency;
	$data['display_amount'] = $displayAmount;
    }
    $json = json_encode($data);
    echo $html = <<<EOD
            <style>
   .razorpay-payment-button{
       display:none;}             
   </style>
<form id="payform" action="checkout.php?payment=init&&pay_id=$encoded_last&&url=return" method="POST">
    <script
        src="https://checkout.razorpay.com/v1/checkout.js"
        data-key="{$data['key']}"
        data-amount="{$data['amount']}"
        data-currency="INR"
        data-name="{$data['name']}"
        data-image="{$data['image']}"
        data-description="{$data['description']}"
        data-prefill.name="{$data['prefill']['name'] }"
        data-prefill.email="{$data['prefill']['email']}"
        data-prefill.contact="{$data['prefill']['contact']}"
        data-notes.shopping_order_id="{$data['notes']['merchant_order_id']}"
        data-order_id="{$data['order_id'] }">
    </script>
    <input type="hidden"  name="order_id_hi" value="$orderData32[1]">
</form>     <script src="{$base}js/vendor/jquery-1.12.0.min.js"></script> 
            <script type="text/javascript">
   $('#payform').submit();             
   </script>
EOD;
}

if (isset($_GET["payment"]) && isset($_GET["pay_id"]) && !empty($_GET["pay_id"])) {



    $success = true;
    $error = "Payment Failed";

    if (empty($_POST['razorpay_payment_id']) === false) {
	$api = new Api($keyId, $keySecret);
	try {


	    $attributes = array(
		'razorpay_order_id' => $_SESSION['razorpay_order_id'],
		'razorpay_payment_id' => $_POST['razorpay_payment_id'],
		'razorpay_signature' => $_POST['razorpay_signature']
	    );

	    $api->utility->verifyPaymentSignature($attributes);
	} catch (SignatureVerificationError $e) {
	    $success = false;
	    $error = 'Razorpay Error : ' . $e->getMessage();
	}
    }

    if ($success === true) {
	$order = $_POST["order_id_hi"];
	$sign = new Functions($pdo);
	$returnData = $sign->updateCustomerOrder($order);
	unset($_SESSION["cart"]);
	$html = "<div class='query'>
             <div class='query-success'>
             <p>Your payment was successful</p>
             <p>Payment ID: {$_POST['razorpay_payment_id']}</p><p>Please wait ! do not refresh this page</p></div></div>";
	Functions::add($html);
    } else {

	$html = "<div class='query'>
             <div class='query-danger'><p>Your payment failed</p>
             <p>{$error}</p><p>Please wait ! do not refresh this page</p></div></div>";
	Functions::add($html);
    }
    echo Functions::render();
    echo '<script type="text/javascript">window.setTimeout(function(){
        window.location.href = "myaccount.php";
    }, 2000);</script>';
}
include_once("includes/Functions.php");
$sign = new Functions($pdo);
?>	
<div class="breadcrumb-banner-area ptb-25">
    <div class="container">
        <div class="breadcrumb-text">
            <div class="breadcrumb-menu">
<!--                <h3 class="entry-title">checkout</h3>-->
                <ul>
                    <li><a href="<?= BASEURL ?>">home</a></li>
                    <li><span>checkout</span></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="checkout-area pt-30 pb-30">
    <div class="container">
        <div class="row">
            <form action="" method="POST">
                <div class="col-lg-6 col-md-6">
                    <div class="checkbox-form">						
                        <h3>Billing Details</h3>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="checkout-form-list">
                                    <label>First Name <span class="required">*</span></label>										
                                    <input type="text" name="firstname" value="" required=""  placeholder="" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="checkout-form-list">
                                    <label>Last Name <span class="required">*</span></label>										
                                    <input type="text" name="lastname" value="" required=""  placeholder="" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="checkout-form-list">
                                    <label>Email Address <span class="required">*</span></label>										
                                    <input type="email" value="" name="user_email"  required=""  placeholder="" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="checkout-form-list">
                                    <label>Phone  <span class="required">*</span></label>										
                                    <input type="text" value="" required=""  name="contact" placeholder="Contact Number" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="country-select">
                                    <label>Country <span class="required">*</span></label>
                                    <select name="country" required=""  id="country">
                                        <option value="India">India</option>
                                    </select> 										
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="checkout-form-list">
                                    <label>State <span class="required">*</span></label>										
                                    <input type="text"  required=""  name="state" placeholder="State" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="checkout-form-list">
                                    <label>City <span class="required">*</span></label>										
                                    <input type="text" required="" value=""  name="user_city" placeholder="City" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="checkout-form-list">
                                    <label>Postcode / Zip <span class="required">*</span></label>										
                                    <input type="text" required="" minlength="6" maxlength="6"  value=""  name="user_pin_code" id="user_pin_code" placeholder="Postcode / Zip" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="checkout-form-list">
                                    <label>Address <span class="required">*</span></label>
                                    <input type="text"  required="" value=""   minlength="10" name="user_address" placeholder="Address" />
                                </div>
                            </div>
                        </div>



			<?php
			$count = 0;
			foreach ($_SESSION['cart'] as $key => $cart) {
			    $proname = $sign->getProductById($cart["pro_id"]);
			    echo " <label>For : " . $proname->pro_name . "</label>";
			    switch ($proname->service_type) {
				case "cab":
				    ?>
	    			<div class="row">
	    			    <div class="col-md-6">
	    				<div class="checkout-form-list">
	    				    <label>Trip Start Date <span class="required">*</span></label>										
	    				    <input type="text"  autocomplete="off" class="tripstartdate" required="" id="tripstartdate"  name="tripstartdate[<?= $key ?>]" placeholder="Trip Start Date" />
	    				</div>
	    			    </div>
	    			    <div class="col-md-6">
	    				<div class="checkout-form-list">
	    				    <label>Pickup time <span class="required">*</span></label>										
	    				    <input type="text"  autocomplete="off" class="cab_pick_time" required=""  id="cab_pick_time" name="cab_pick_time[<?= $key ?>]" placeholder="Pick Time" />
	    				</div>
	    			    </div>
	    			    <div class="col-md-6">
	    				<div class="checkout-form-list">
	    				    <label>Trip Closing Date <span class="required">*</span></label>										
	    				    <input type="text" autocomplete="off" class="trip_closing_date"  required=""  name="trip_closing_date[<?= $key ?>]" id="trip_closing_date" placeholder="Trip Closing Date" />
	    				</div>
	    			    </div>
	    			</div>
				    <?php
				    break;
				case "prof":
				    ?>

	    			<div class="row">
	    			    <div class="col-md-6">
	    				<label>Preferred Mode<span class="required">*</span></label>										
	    				<select class="form-control" required="" name="preffered_mode[<?= $key ?>]" id="preffered_mode">
	    				    <option value="phone">On Phone/Video</option>
	    				    <option value="face_to_face">Face To Face With Person</option>
	    				</select>
	    			    </div>
	    			    <div   class="col-md-6">
	    				<div class="checkout-form-list">
	    				    <label>Date Of Appointment<span class="required">*</span></label>										
	    				    <input type="text" autocomplete="off" id="appoint_date" class="appoint_date"  required=""  name="appoint_date[<?= $key ?>]" placeholder="Date Of Appointment" />
	    				</div>
	    			    </div>
	    			    <div   class="col-md-6">
	    				<div class="checkout-form-list">
	    				    <label>Time Slot <span class="required">*</span></label>										
	    				    <input type="text"  autocomplete="off"  id="prof_time_slot"  class="prof_time_slot" required=""  name="prof_time_slot[<?= $key ?>]" placeholder="Time Slot" />
	    				</div>
	    			    </div>
	    			</div>
				    <?php
				    break;
				case "repair":
				    ?>
	    			<div class="row">

	    			    <div class="col-md-6">
	    				<div class="checkout-form-list">
	    				    <label>Date Of Booking<span class="required">*</span></label>										
	    				    <input type="text"  autocomplete="off" required="" class="repare_date_booking" id="repare_date_booking"  name="repare_date_booking[<?= $key ?>]" placeholder="Date Of Booking" />
	    				</div>
	    			    </div>
	    			    <div class="col-md-6">
	    				<div class="checkout-form-list">
	    				    <label>Time Slot <span class="required">*</span></label>										
	    				    <input type="text" autocomplete="off" class="repare_time_slot"   required=""  id="repare_time_slot"   name="repare_time_slot[<?= $key ?>]" placeholder="Time Slot" />
	    				</div>
	    			    </div>
	    			</div>
				    <?php
				    break;
			    }
			}
			?>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="your-order">
                        <h3>Order Detail</h3>
                        <div class="your-order-table table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="product-name">Product</th>
                                        <th class="product-total">Total</th>
                                    </tr>							
                                </thead>
                                <tbody>
				    <?php
				    $total = 0;
				    $advance = 0.0;
				    foreach ($_SESSION['cart'] as $cart) {

					if (isset($cart["ven_id"]) && $cart['ven_id'] != '') {
					    $proname = $sign->getVendorAssignProduct($cart["ven_id"], $cart["pro_id"]);
					    $total = $total + (floatval($proname->d_price) * floatval($cart["quantity"]));
					    $advance = $advance + (floatval($proname->d_price) * floatval($cart["quantity"]) * floatval($proname->percentage) / 100);
					} else {
					    $proname = $sign->getProductById($cart["pro_id"]);
					    $total = $total + (floatval($proname->dis_price) * floatval($cart["quantity"]));
					    $advance = $advance + (floatval($proname->dis_price) * floatval($cart["quantity"]) * floatval($proname->percentage) / 100);
					}


					$productname = substr(ucwords(strtolower($proname->pro_name)), 0, 25) . "..";

					//$total = $total + (floatval($proname->dis_price) * floatval($cart["quantity"]));
					?>
    				    <tr class="cart_item">

    					<td title="<?= $proname->pro_name ?>" class="product-name">
						<?= $productname ?> <strong class="product-quantity"> × <?= $cart["quantity"] ?></strong>
    					</td>
    					<td class="product-total">
						<?php if (isset($proname->d_price)) { ?>
					    <span class="amount" > <i class="fa fa-inr" aria-hidden="true"></i>   <?= floatval($proname->d_price) * floatval($cart["quantity"]) ?> 
							<?= $proname->percentage != 100 ? ( "[ advance: (" . (floatval($proname->d_price) * floatval($cart["quantity"]) * floatval($proname->percentage) / 100) . ")]") : ""; ?>
						    </span>
						<?php } else { ?>
					    <span class="amount" > <i class="fa fa-inr" aria-hidden="true"></i> <?= floatval($proname->dis_price) * floatval($cart["quantity"]) ?> 
							<?= $proname->percentage != 100 ? ( "[ advance: (" . (floatval($proname->dis_price) * floatval($cart["quantity"]) * floatval($proname->percentage) / 100) . ")]") : ""; ?>
						    </span>
						<?php } ?>
    					</td>
    				    </tr>
					<?php
				    }
				    ?>
                                </tbody>
                                <tfoot>
                                    <tr class="cart-subtotal">
                                        <th>Cart Subtotal </th><input type="hidden" id="myTotal" value="<?= $total ?>">
                                        <td><span class="amount"> <i class="fa fa-inr" aria-hidden="true"></i><span class="myTotal">  <?= $total ?> </span></span></td>
                                    </tr>
                                    <tr class="cart-subtotal">
                                        <th>Advance</th><input type="hidden" class="myadvance" value="<?= $advance ?>">
                                        <td><span class="amount"> <i class="fa fa-inr" aria-hidden="true"></i> <span id="myadvance"> <?= $advance ?> </span></span></td>
                                    </tr>


                                    <tr class="order-total" id="total_order">
                                        <th>Order Total </th>
                                        <td><strong><span class="amount"> <i class="fa fa-inr" aria-hidden="true"></i><span class="grandTotal"> <?= $total ?> </span> </span></strong> </td>
				<input type="hidden" class="tot_days" name="tot_days">
				</tr>

				<tr class="cart-subtotal" id="total_order">
				    <th> Pay Advance ( <i class="fa fa-inr" aria-hidden="true"></i><span id="payAvd"> <?= $advance ?></span>)</th>
				    <td> <input type="radio" name="payment_type" onclick="advancePay();" value="advance" checked="checked" />
				    </td>
				</tr>
				<tr class="cart-subtotal" id="total_order">
				    <th> Full Payment ( <i class="fa fa-inr" aria-hidden="true"></i> <span class="myFull"><?= $total ?></span>)</th>
				    <td> <input type="radio" name="payment_type" value="full_pay"  /></td>

				</tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="payment-method">
                            <div class="payment-accordion">
                                <div class="order-button-payment">
                                    <input type="submit" value="Place order" />
                                </div>								
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once ("includes/footer.php"); ?>

<script src="<?= BASEURL ?>js/timepicker.js" type="text/javascript"></script>
<script src="<?= BASEURL ?>js/datepicker.js" type="text/javascript"></script>
<script type="text/javascript">

    $('.cab_pick_time,.prof_time_slot,.repare_time_slot').timepicker();
    $('.tripstartdate,.trip_closing_date,.appoint_date,.repare_date_booking').datepicker({
	 startDate: new Date(),
	'format': 'dd-mm-yyyy',
	'autoclose': true
    });
</script>

<script>
	
    $('.order-button-payment').mouseenter(function () {
        var diff = 0;
        var totaldays = 0;
	var getTotal = $(".cart-subtotal").find("#myTotal").val();
	var getadv = $(".myadvance").val();
	
        $('.tripstartdate').each(function (i, val) {
            var d1 = $('input[name="tripstartdate[' + i + ']"]').datepicker('getDate');
            var d2 = $('input[name="trip_closing_date[' + i + ']"]').datepicker('getDate');


            if (d1 && d2) {
                diff = Math.floor((d2.getTime() - d1.getTime()) / 86400000); // ms per day
            }

            if (diff > 0) {
                totaldays = totaldays + diff + 1 ;
            }


        });
	 if (totaldays > 0) {
                var final = getTotal * totaldays;
                $(".order-total").find(".grandTotal").html(final);
                $(".myTotal").html(final);
                $(".myFull").html(final);
                $(".tot_days").val(totaldays);
		$("#myadvance").html(getadv * totaldays);
		$("#payAvd").html(getadv * totaldays);
            }
	console.log(totaldays);
    });
   
    
</script>