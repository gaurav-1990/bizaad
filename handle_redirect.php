<?php

session_start();
include_once './vendor/autoload.php';
define("API_KEY", "5a899662cc40ad2eb974716dd5081510");
define("AUTH_TOKEN", "c4ebcd8549613a1d927620c52c6be771");
$api = new Instamojo\Instamojo(API_KEY, AUTH_TOKEN);
include_once("includes/config.php");
include_once ("includes/functions.php");
try {
    $base = BASEURL . "myaccount.php";
    $response = $api->paymentRequestStatus($_GET['payment_request_id']);
    if ($response["payments"][0]["status"] != 'Failed') {
        $sign = new Signup($pdo);
        $sign->updateOrder($_SESSION["last_id"]);


        if (isset($_SESSION["userid"])) {
            $sign->updateWallet($_SESSION['wallet_amt'], $_SESSION["with_amt"], $_SESSION["paymethod"]);
           
        }


        unset($_SESSION["paymethod"]);
        unset($_SESSION["wallet_amt"]);
        unset($_SESSION["with_amt"]);
        unset($_SESSION["cart"]);
        unset($_SESSION["last_id"]);

        $_SESSION["msg"] = "<div class='alert alert-success'>Thanks !!For The Payment </div>";
    } else {
        $_SESSION["msg"] = "<div class='alert alert-danger'>Invalid payment credentials</div>";
    }
    echo "<script type='text/javascript'>";
    echo "window.location.href = '$base' ";
    echo "</script>";
} catch (Exception $e) {
    print('Error: ' . $e->getMessage());
}