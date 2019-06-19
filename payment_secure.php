<?php

session_start();

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

include_once 'includes/pdo.php';
include_once 'includes/Navigation.php';

$nav = new Navigation($pdo);
require('razorpay-php/Razorpay.php');
include_once("includes/Functions.php");
$sign = new Functions($pdo);
if (!empty($_POST) && !empty($_SESSION["userid"]) && !empty($_SESSION["cart"])) {
    $orderData32 = $sign->addCustomerOrder($_POST, $_SESSION["cart"]);
    $api = new Api($keyId, $keySecret);
    $price = $orderData32[0];
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
 