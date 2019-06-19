<?php

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

require('razorpay-php/Razorpay.php');
include_once ("includes/header_1.php");
include_once("includes/Functions.php");
$sign = new Functions($pdo);

if (isset($_GET["payment"]) && ($_GET["payment"] == "init" && isset($_GET["pay_id"]) && $_GET["pay_id"] != '' && isset($_GET["url"]) && $_GET["url"] == "return")) {
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
	$sign->updateGuestQuery($order);
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
        window.location.href = "booking.php?pro=' . $_GET["pro"] . '";
    }, 2000);</script>';
}

if (isset($_POST["book_now"])) {
    
    
    if (isset($_GET['ven'])) {
	$Vendor_sid = $sign->encrypt_decrypt("decrypt", $_GET['ven']);
	$last_id = $sign->insertIntoGuestVend($_POST, $Vendor_sid);
    } else {
	$last_id = $sign->insertIntoGuest($_POST);
    }


    //  $last_id = $sign->insertIntoGuest($_POST);

    $booking = $sign->getGuestQuery($last_id);

    $base = BASEURL;
    if ($_POST["payment_type"] != "cash_on_delivery") {
	$api = new Api($keyId, $keySecret);

	if ($_POST['tot_days'] != '' && $_POST["payment_type"] == "full_pay") {

	    $price = $booking->pro_price * $_POST['tot_days'];
	} else {
	     $price = $booking->pro_price ;	    
	}
	
        if ($_POST["payment_type"] == "advance") {
	    
	     if($_POST['tot_days'] != '' && $_POST['tot_days'] != NULL){
		 $price = $booking->advance_price * $_POST['tot_days'];		
	    }else{
		$price = $booking->advance_price;
	    }
          
        }
	

	$orderData = [
	    'receipt' => $last_id,
	    'amount' => floatval($price) * 100, // 2000 rupees in paise
	    'currency' => 'INR',
	    'payment_capture' => 1 // auto capture
	];

	$razorpayOrder = $api->order->create($orderData);

	$razorpayOrderId = $razorpayOrder['id'];

	$_SESSION['razorpay_order_id'] = $razorpayOrderId;

	$displayAmount = $amount = $orderData['amount'];

	if ($displayCurrency !== 'INR') {
	    $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
	    $exchange = json_decode(file_get_contents($url), true);
	    $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
	}

	$encoded_last = $sign->encrypt_decrypt("encrypt", $last_id);

	$data = [
	    "key" => $keyId,
	    "amount" => $amount,
	    "name" => "Bizadd.com",
	    "description" => "{$booking->pro_name}",
	    "image" => "{$base}img/logo/logo.png",
	    "prefill" => [
		"name" => "{$booking->fname} {$booking->lname}",
		"email" => "{$booking->email}",
		"contact" => "{$booking->contact}",
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
<form id="payform" action="booking.php?payment=init&&pay_id=$encoded_last&&url=return&&pro={$_GET["pro"]}" method="POST">
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
    <input type="hidden"  name="order_id_hi" value="$last_id">
</form>     <script src="{$base}js/vendor/jquery-1.12.0.min.js"></script> 
            <script type="text/javascript">
   $('#payform').submit();             
   </script>
EOD;
    } else {
	$html = "<div class='query'>
                  <div class='query-success'>
                    <p>Your order has been successful</p>
                  </div>
                 </div>";
	Functions::add($html);
	echo Functions::render();
	echo '<script type="text/javascript">window.setTimeout(function(){
        window.location.href = "booking.php?pro=' . $_GET["pro"] . '";
    }, 2000);</script>';
    }
}

$pro = $sign->encrypt_decrypt("decrypt", $_GET["pro"]);
$proname = $sign->getProductById($pro);
if (isset($_GET["ven"])) {
    $vend_id = $sign->encrypt_decrypt("decrypt", $_GET["ven"]);
    $venPro = $sign->getVendorProductById($vend_id);
}

echo Functions::render();
if ($proname != NULL) {
    $percentage = $proname->percentage;
    ?>
<div class="breadcrumb-banner-area ptb-25">
    <div class="container">
        <div class="breadcrumb-text">
            <div class="breadcrumb-menu">
<!--                <h3 class="entry-title">Booking</h3>-->
                <ul>
                    <li><a href="<?= BASEURL ?>">home</a></li>
                    <li><span>Booking</span></li>
                </ul>
            </div>
        </div>
    </div>
</div>
    <div class="checkout-area pt-30 pb-30">
        <div   class="container">

    	<div class="row">
    	    <form action="" id="booking_form" method="POST">
    		<div class="col-lg-6 col-md-6">
    		    <div class="checkbox-form">						
    			<h3>Booking Details</h3>
			    <?php
			    if ($proname->service_type == "prof") {
				?>
				<div class="row">

				    <div class="col-md-6">
					<div class="checkout-form-list">
					    <label>Preferred Mode<span class="required">*</span></label>										
					    <select class="form-control" required="" name="preffered_mode" id="preffered_mode">
						<option value="phone">On Phone/Video</option>
						<option value="face_to_face">Face To Face With Person</option>
					    </select>
					</div>
				    </div>
				</div>
			    <?php } ?>      
    			<div class="row">
    			    <input type="hidden" class="tot_days" name="tot_days">
    			    <div class="col-md-6">
    				<div class="checkout-form-list">
    				    <label>First Name <span class="required">*</span></label>										
    				    <input type="text" name="firstname" id="firstname" value="" required=""  placeholder="" />
    				</div>
    			    </div>
    			    <input type="hidden" name="pro_id" id="pro_id" value="<?= $sign->encrypt_decrypt("encrypt", $_GET["pro"]) ?>" />
			    <input type="hidden" name="vend_id" id="vend_id" value="<?php if(isset($venPro->ven_id)){echo $venPro->ven_id ;}?>" />
    			    <div class="col-md-6">
    				<div class="checkout-form-list">
    				    <label>Last Name <span class="required">*</span></label>										
    				    <input type="text" name="lastname"  id="lastname" value="" required=""  placeholder="" />
    				</div>
    			    </div>
    			    <div class="col-md-6">
    				<div class="checkout-form-list">
    				    <label>Email Address 
    				    </label>										
    				    <input type="email" value="" name="user_email" id="user_email"    placeholder="" />
    				</div>
    			    </div>
    			    <div class="col-md-6">
    				<div class="checkout-form-list">
    				    <label>Phone  <span class="required">*</span></label>										
    				    <input type="text" value="" required="" id="contact" name="contact" placeholder="Contact Number" />
    				</div>
    			    </div>
    			    <div  style="display: none"  class="col-md-12">
    				<div class="checkout-form-list">
    				    <label>Address <span class="required">*</span></label>
    				    <input type="text"  required="" value=""  id="user_address" minlength="10" name="user_address" placeholder="Address" />
    				</div>
    			    </div>
    			</div>

			    <?php
			    switch ($proname->service_type) {
				case "cab":
				    ?>
	    			<div class="row">
	    			    <div class="col-md-6">
	    				<div class="checkout-form-list">
	    				    <label>Trip Start Date <span class="required">*</span></label>										
	    				    <input type="text"  autocomplete="off" required="" id="tripstartdate"  name="tripstartdate" placeholder="Trip Start Date" />
	    				</div>
	    			    </div>
	    			    <div class="col-md-6">
	    				<div class="checkout-form-list">
	    				    <label>Pickup time <span class="required">*</span></label>										
	    				    <input type="text"  autocomplete="off" required=""  id="cab_pick_time" name="cab_pick_time" placeholder="Pick Time" />
	    				</div>
	    			    </div>
	    			    <div class="col-md-6">
	    				<div class="checkout-form-list">
	    				    <label>Trip Closing Date <span class="required">*</span></label>										
	    				    <input type="text" autocomplete="off"  required=""  name="trip_closing_date"  id="trip_closing_date" placeholder="Trip Closing Date" />
	    				</div>
	    			    </div>
	    			</div>
				    <?php
				    break;
				case "prof":
				    ?>
	    			<div class="row">

	    			    <div   class="col-md-6">
	    				<div class="checkout-form-list">
	    				    <label>Date Of Appointment<span class="required">*</span></label>										
	    				    <input type="text" autocomplete="off" id="appoint_date"  required=""  name="appoint_date" placeholder="Date Of Appointment" />
	    				</div>
	    			    </div>
	    			    <div   class="col-md-6">
	    				<div class="checkout-form-list">
	    				    <label>Time Slot <span class="required">*</span></label>										
	    				    <input type="text"  autocomplete="off"  id="prof_time_slot"  required=""  name="prof_time_slot" placeholder="Time Slot" />
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
	    				    <input type="text"  autocomplete="off" required="" id="repare_date_booking"  name="repare_date_booking" placeholder="Date Of Booking" />
	    				</div>
	    			    </div>
	    			    <div class="col-md-6">
	    				<div class="checkout-form-list">
	    				    <label>Time Slot <span class="required">*</span></label>										
	    				    <input type="text" autocomplete="off"  required=""  id="repare_time_slot"   name="repare_time_slot" placeholder="Time Slot" />
	    				</div>
	    			    </div>
	    			</div>
				    <?php
				    break;
			    }
			    ?>

    			<div class="row">
    			    <div style="display: none" class="col-md-6">
    				<div class="checkout-form-list">
    				    <label>Postcode / Zip <span class="required">*</span></label>										
    				    <input type="text" required=""   value=""  name="user_pin_code" id="user_pin_code" placeholder="Postcode / Zip" />
    				</div>
    			    </div>

    			</div>
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

					if (isset($_GET["ven"]) == NULL) {
					    $productname = substr(ucwords(strtolower($proname->pro_name)), 0, 25) . "..";
					    $total = $total + (floatval($proname->dis_price) * floatval(1));
					    ?>
					    <tr class="cart_item">
						<td title="<?= $proname->pro_name ?>" class="product-name">
						    <?= $productname ?> <strong class="product-quantity"> × <?= 1 ?></strong>
						</td>
						<td class="product-total">
						    <span class="amount"> <i class="fa fa-inr" aria-hidden="true" ></i> <span id='pro_price'> <?= floatval($proname->dis_price) * floatval(1); ?> </span> </span>
						</td>
					    </tr>


					</tbody>
					<tfoot>
					    <tr class="cart-subtotal">
						<th>Cart Subtotal </th>
						<td><span class="amount"> <i class="fa fa-inr" aria-hidden="true"></i><span class="mySub">  <?= $total ?> </span></span></td>
					    </tr>
					    <tr class="order-total" id="total_order">
					<input type="hidden" id='adv' value="<?= round((($total * $percentage) / 100), 2); ?>">
					<th> Advance Payment </th>
					<td><strong><span class="amount"> <i class="fa fa-inr" aria-hidden="true"></i><span class="myTotal"> <?= round((($total * $percentage) / 100), 2); ?> </span></span></strong>
					</td>
					</tr>
					<?php
				    } else {

					$percentage = $venPro->percentage;
					$productname = substr(ucwords(strtolower($venPro->pro_name)), 0, 25) . "..";
					$total = $total + (floatval($venPro->d_price) * floatval(1));
					?>
					<tr class="cart_item">
					    <td title="<?= $venPro->pro_name ?>" class="product-name">
						<?= $productname ?> <strong class="product-quantity"> × <?= 1 ?></strong>
					    </td>
					    <td class="product-total">
						<span class="amount"> <i class="fa fa-inr" aria-hidden="true"></i>  <?= floatval($venPro->d_price) * floatval(1); ?> </span>
					    </td>
					</tr>


					</tbody>
					<tfoot>
					    <tr class="cart-subtotal">
						<th>Cart Subtotal </th>
						<td><span class="amount"> <i class="fa fa-inr" aria-hidden="true"></i>  <?= $total ?></span></td>
					    </tr>
					    <tr class="order-total" id="total_order">
						<th> Advance Payment </th>

						<td><strong><span class="amount"> <i class="fa fa-inr" aria-hidden="true"></i> <?= round((($total * $percentage) / 100), 2); ?> </span></strong>
						</td>
					    </tr>
					<?php } ?> 

    				    <!-- zeya code end here -->

    				    <tr class="cart-subtotal" id="total_order">
    					<th> Pay Advance</th>
    					<td> <input type="radio" name="payment_type" id="advance" value="advance" onclick="advancePay();" checked="checked" />
    					</td>
    				    </tr>
    				    <tr class="cart-subtotal" id="total_order">
    					<th> Full Payment</th>
    					<td> <input type="radio" name="payment_type" id="full_pay" onclick="fullPay();" value="full_pay"  /></td>

    				    </tr>

					<?php if ($proname->cod == 1) { ?>
					    <tr class="cart-subtotal" id="total_order">
						<th>Cash on spot</th>
						<td> <input type="radio" name="payment_type" value="cash_on_delivery"  /></td>

					    </tr>
					<?php } ?>
    				</tfoot>
    			    </table>
    			</div>
    			<div class="payment-method">
    			    <div class="payment-accordion">
    				<div class="order-button-payment">
    				    <input type="submit" id="rzp-button1" name="book_now"  value="Book Now" />
    				</div>								
    			    </div>
    			</div>
    		    </div>
    		</div>
    	    </form>
    	</div>
        </div>
    </div>
<?php } else { ?>
    <div class="checkout-area pt-30 pb-30">
        <div class="container">
    	<div class="row">
    	    <div class="col-lg-6 col-md-6">
    		<div class="checkbox-form">						
    		    <h3>No Record Found</h3>
    		</div>
    	    </div>
    	</div>
        </div>
    </div>
<?php } ?>
<?php include_once ("includes/footer.php"); ?>
<link  type="text/css" rel="stylesheet" href="<?= BASEURL ?>/css/timepicker.css"/>
<link  type="text/css" rel="stylesheet" href="<?= BASEURL ?>/css/datepicker.css"/>
<script src="<?= BASEURL ?>js/timepicker.js" type="text/javascript"></script>
<script src="<?= BASEURL ?>js/datepicker.js" type="text/javascript"></script>


<script type="text/javascript">
    $('#cab_pick_time,#prof_time_slot,#repare_time_slot').timepicker();
    $('#tripstartdate,#trip_closing_date,#appoint_date,#repare_date_booking').datepicker({
       startDate: new Date(),
	'format': 'dd-mm-yyyy',
	'autoclose': true,
    });

    $("#tripstartdate").datepicker().on("changeDate", function (e) {
	var minDate = new Date(e.date.valueOf());
	$('#trip_closing_date').datepicker('setStartDate', minDate);

    });

    $("#trip_closing_date").datepicker().on("changeDate", function (e) {

	var closedate = new Date(e.date.valueOf());
    });

    var required = false;
<?php if ($proname->service_type != "cab") { ?>
       required = true;
<?php } ?>
	if ($('#preffered_mode').length == 0)
	{
	    $('#user_pin_code').parent().parent().show();
	    $('#user_address').parent().parent().show();
	}



	$('#preffered_mode').change(function () {
	    if ($(this).val() != 'phone')
	    {

		$('#user_pin_code').parent().parent().show();
		$('#user_address').parent().parent().show();
	    } else
	    {

		$('#user_pin_code').parent().parent().hide();
		$('#user_address').parent().parent().hide();

	    }
	});

	$("#booking_form").validate({
	    rules: {
		firstname: {
		    required: true,
		    minlength: 2
		},
		lastname: {
		    required: true,
		    minlength: 2
		},
		user_email: {
		    minlength: 3,
		    email: required,
		},
		contact: {
		    required: true,
		    number: true,
		    minlength: 10,
		    maxlength: 10
		},
		tripstartdate: {
		    required: "#tripstartdate:visible",
		},
		cab_pick_time: {
		    required: "#cab_pick_time:visible",
		},
		preffered_mode: {
		    required: "#preffered_mode:visible",
		},
		appoint_date: {
		    required: "#appoint_date:visible",
		},
		prof_time_slot: {
		    required: "#prof_time_slot:visible",
		},
		repare_date_booking: {
		    required: "#repare_date_booking:visible",
		},
		repare_time_slot: {
		    required: "#repare_time_slot:visible",
		},
		state: {
		    required: true,
		},
		user_city: {
		    required: true,
		},
		user_pin_code: {
		    required: '#user_pin_code:visible',
		    maxlength: 6,
		    minlength: 6,
		    number: true
		},
		user_address: {
		    required: '#user_address:visible',
		    minlength: 10
		}

	    }
	});

	if ($('.query').length != 0)
	{
	    setTimeout(function () {
		$('.query').remove();
		window.location.href = '<?= BASEURL ?>';

	    }, 5000);
	}

</script>

<script>
    function advancePay() {
        var d1;
        var d2;
        var dis_price = $(".product-total").find(".amount").find('#pro_price').html();
        var getTotal = $('#adv').val();
        
        d1 = $('#tripstartdate').val();
        d2 = $('#trip_closing_date').val();
	 if (d1 && d2) {
	      $.ajax({
            type: "POST",
            url: "dateDiff.php",
            data: {"sdate": d1, "close_date": d2},
            success: function (data) {
                var final = data * getTotal;
		
                $(".order-total").find(".myTotal").html(final);
		if ($('#advance').prop('checked')) {
            $(".cart-subtotal").find(".mySub").html(dis_price*data);
        }
		
            }
	    
	
        });
	     
	 }
       
    }
    function fullPay() {

        var d1;
        var d2;
        var getTotal = $(".product-total").find(".amount").find('#pro_price').html();

        d1 = $('#tripstartdate').val();
        d2 = $('#trip_closing_date').val();
	 if (d1 && d2) {
	    $.ajax({
            type: "POST",
            url: "dateDiff.php",
            data: {"sdate": d1, "close_date": d2},
            success: function (data) {		
                var final = data * getTotal;
                $(".order-total").find(".myTotal").html(final);
                $(".cart-subtotal").find(".mySub").html(final);             
            }
        }); 
	 }
      
    }

    $(document).ready(function () {
        var totaldays = 0;
        var d1;
        var d2;
        var dis_price = $(".product-total").find(".amount").find('#pro_price').html();
        var getTotal = $(".order-total").find(".myTotal").html();

        var selector = function (dateStr) {
            //console.log($(this).attr("id"));

            if ($(this).attr("id") == "tripstartdate")
            {
                d1 = $('#tripstartdate').datepicker('getDate');
            } else
            {
                d2 = $('#trip_closing_date').datepicker('getDate');
            }
            var diff = 0;

            if (d1 && d2) {
                diff = Math.floor((d2.getTime() - d1.getTime()) / 86400000); // ms per day
            }

            //console.log(diff);
            if (diff > 0) {
                totaldays = diff + 1;
            }
            if ($('#full_pay').prop('checked')) {

                $("#full_pay").prop("checked", false);
                $("#advance").prop("checked", true);
            }
            if ($('#advance').prop('checked')) {

                $(".cart-subtotal").find(".mySub").html(dis_price);
            }

            if (totaldays > 0) {
                var final = getTotal * totaldays;
                var subtotal = dis_price * totaldays;
                $(".order-total").find(".myTotal").html(final);
                $(".tot_days").val(totaldays);
		$(".cart-subtotal").find(".mySub").html(subtotal);
            }
	    

        }
//        $('#tripstartdate').datepicker({
//            minDate: new Date(2012, 7 - 1, 8),
//            maxDate: new Date(2012, 7 - 1, 28)
//        });
//        $('#trip_closing_date').datepicker({
//            minDate: new Date(2012, 7 - 1, 9),
//            maxDate: new Date(2012, 7 - 1, 28)
//        });
        $('#tripstartdate,#trip_closing_date').on("changeDate", selector);

    });

</script>
