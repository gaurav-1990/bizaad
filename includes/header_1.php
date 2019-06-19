<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL);
define("BASEURL", "http://localhost/bizaad/");
include_once 'includes/pdo.php';
spl_autoload_register(function ($class_name) {
    include "includes/" . $class_name . '.php';
});

$nav = new Navigation($pdo);
$i = false;
$urlid = "";
if (isset($_GET["sub_id"])) {
    $i = true;
    $urlid = $_GET["sub_id"];
} elseif (isset($_GET["catid"])) {
    $i = false;
    $urlid = $_GET["catid"];
}
$meta = $nav->returnTitle($i, $urlid);
?>
<!doctype html>
<html class="no-js" lang="zxx">
    <head>
        <meta http-equiv="x-ua-compatible" content="ie=edge">

               <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" href="apple-touch-icon.png">

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/animate.css">
        <link rel="stylesheet" href="css/ionicons.min.css">
        <link rel="stylesheet" href="css/owl.carousel.min.css">
        <link rel="stylesheet" href="css/meanmenu.css">
        <link rel="stylesheet" href="css/magnific-popup.css">
        <link rel="stylesheet" href="css/jquery-ui.min.css">
        <link rel="stylesheet" href="css/et-line-icon.css">
        <link rel="stylesheet" href="css/Pe-icon-7-stroke.css">
        <link rel="stylesheet" href="css/icofont.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/review.css">
        <link rel="stylesheet" href="css/responsive.css">
        <!-- Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?= BASEURL ?>img/logo/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= BASEURL ?>img/logo/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= BASEURL ?>img/logo/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= BASEURL ?>img/logo/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= BASEURL ?>img/logo/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= BASEURL ?>img/logo/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?= BASEURL ?>img/logo/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= BASEURL ?>img/logo/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= BASEURL ?>img/logo/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?= BASEURL ?>img/logo/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= BASEURL ?>img/logo/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?= BASEURL ?>img/logo/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= BASEURL ?>img/logo/favicon-16x16.png">
    <link rel="manifest" href="<?= BASEURL ?>img/fav/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!-- all css here -->

        <script src="js/vendor/modernizr-2.8.3.min.js"></script>

    </head>
    <body>


        <header class="header-area">

            <div class="header-up">
                <div class="header-up-in">


                    <div class="col-md-12 col-sm-12">
                        <div class="row">



                            <div class="avl-offer">

                                <h3>Available Now -
                                    <span> Book Online service in </span>

                                    <a href="#"><?= "Delhi"; ?></a>
                                </h3>
                            </div>
                            <div class="head-call">
                                <a href="tel:+91 999-993-4211"><img src="img/logo/call.png" alt="" /> +91 999-993-4211</a>
                            </div>
                        </div> 

                    </div>
                </div>

            </div>


            <div class="header-top-area">


                <div class="row">
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="logo">
                            <a href="index.php"><img src="img/logo/logo.png" alt="" /></a>
                        </div>
                    </div>


                    <div class="col-md-5 col-sm-12 col-xs-12 for-mob">
                        <div class="search-center">
                            <input type="text" placeholder="Search  your favourite beauty products... "/>
                            <button><i class="fa fa-search"></i></button>
                        </div>
                    </div>

                    <div class="col-md-3 col-xs-8 top-cart cart-set ">
                        <div class="current current-icon floatright">
                            <?php
                            if (!isset($_SESSION["userid"])) {
                                ?>
                                <a href="#">My account</a>
                            <?php } else {
                                ?>
                                <a href="#"><?= $_SESSION["username"] ?></a>
                            <?php } ?>
                            <ul class="current-menu">
                                <?php
                                if (!isset($_SESSION["userid"])) {
                                    ?>
                                    <li><a href="<?= BASEURL ?>signup.php">Signup</a></li>
                                    <li><a href="<?= BASEURL ?>login.php">Log In</a></li>
                                <?php } else { ?>
                                    <li><a href="<?= BASEURL ?>myaccount.php">My account</a></li>
                                    <li><a href="<?= BASEURL ?>logout.php">Logout</a></li>

                                <?php } ?>

                            </ul>
                        </div>
                        <div class="cart-search cart-search-icon floatright">
                            <div class="shopping-cart cart-icon">
				 
                                <a href="javascript:void(0);"><span><?= isset($_SESSION["cart"]) ? count($_SESSION["cart"]) : "0" ?></span>Cart </a>
                                <div class="cart_details"></div>

                            </div>
                        </div>



                    </div>
                </div>

            </div>



        </header>

