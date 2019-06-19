<!doctype html>
<?php
session_start();
error_reporting(E_ALL);
define("BASEURL", "http://localhost:8080/bizaad/");
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
<html class="no-js" lang="zxx">


    <head>


        <!-- Facebook Pixel Code -->
        <script>
            !function (f, b, e, v, n, t, s)
            {
                if (f.fbq)
                    return;
                n = f.fbq = function () {
                    n.callMethod ?
                            n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq)
                    f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                    'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '772204063139451');
            fbq('track', 'PageView');
        </script>
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=772204063139451&ev=PageView&noscript=1"
                   /></noscript>
    <!-- End Facebook Pixel Code -->
    <meta name="google-site-verification" content="google4e60067489de8d36.html" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?= isset($meta->sub_title) ? $meta->sub_title : "Bizaad: The way of Booking | Hire Expert Professionals Consultant & Services"; ?></title>
    <meta name="description" content="<?= isset($meta->sub_meta_desc) ? $meta->sub_meta_desc : " Book Services Online or Call 9999934211 for Support, Hire Astrologer Consultant It Professionals for ecommerce website Software Application Developer, Digital Marketing  Advertising Agenct, Event Organiser & Wedding Service provider"; ?>">
    <meta name="keywords" content="<?= isset($meta->sub_meta_key) ? $meta->sub_meta_key : ""; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-touch-icon.png">
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
    <link rel="stylesheet" href="<?= BASEURL ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASEURL ?>css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= BASEURL ?>css/animate.css">
    <link rel="stylesheet" href="<?= BASEURL ?>css/ionicons.min.css">
    <link rel="stylesheet" href="<?= BASEURL ?>css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= BASEURL ?>css/meanmenu.css">
    <link rel="stylesheet" href="<?= BASEURL ?>css/magnific-popup.css">
    <link rel="stylesheet" href="<?= BASEURL ?>css/jquery-ui.min.css">
    <link rel="stylesheet" href="<?= BASEURL ?>css/et-line-icon.css">
    <link rel="stylesheet" href="<?= BASEURL ?>css/Pe-icon-7-stroke.css">
    <link rel="stylesheet" href="<?= BASEURL ?>css/icofont.css">
    <link rel="stylesheet" href="<?= BASEURL ?>css/style.css">
    <link rel="stylesheet" href="<?= BASEURL ?>css/review.css">
    <link href="<?= BASEURL ?>software_ibe_box/css/blue-red.css" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" href="<?= BASEURL ?>css/responsive.css">

    <script src="<?= BASEURL ?>js/vendor/modernizr-2.8.3.min.js"></script>



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
                            <a href="tel:+91 999-993-4211"><img src="<?= BASEURL ?>img/logo/call.png" alt="" /> +91 999-993-4211</a>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
        <div class="header-top-area">
            <div class="row">

                <div class="col-md-3 col-sm-12 col-xs-12">
                    <div class="logo">
                        <a href="<?= BASEURL ?>"><img src="<?= BASEURL ?>img/logo/logo.png" alt="" /></a>
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
                            <a href="javascript:void(0);"><span><?= isset($_SESSION["cart"]) ? count($_SESSION["cart"]) : "0" ?></span>Cart</a>
                            <div class="cart_details"></div>
                        </div>
                    </div>



                </div>
            </div>

        </div>



    </header>

    <div class="menu-area ">

        <nav class="navbar navbar-inverse">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>                        
                </button>

            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <h3> <i class="fa fa-bars" aria-hidden="true"></i> All Categories </h3>
                <ul class="nav navbar-nav">
                    <li>
                        <a href="<?= BASEURL ?>cab-book.php"> Cab Booking Online </a>
                    </li>
            <?php
            $cat = $nav->getCategory();

            foreach ($cat as $ca) {
            $sub_cat = $nav->getSubCategory($ca->id);
            ?>
                <li <?= count($sub_cat) > 0 ? 'class="dropdown"' : "" ?> >

                <a <?= count($sub_cat) > 0 ? 'class="dropdown-toggle" data-toggle="dropdown"' : "" ?>   href="<?= count($sub_cat) > 0 ? "#" : (BASEURL . "" . $nav->cleanString(strtolower($ca->cat_name))) . "/" . $nav->encrypt_decrypt("encrypt", $ca->id) ?>"> <?= $ca->cat_name ?>  <?php
                if (count($sub_cat) > 0) {
                    ?> <span class="caret"></span>
                <?php } ?>
                </a>
                <?php
                if (count($sub_cat) > 0) {
                ?>
                <ul class="dropdown-menu">
                    <?php
                    foreach ($sub_cat as $subname) {
                    ?>
                        <li><a href="<?= BASEURL ?><?= $nav->cleanString(strtolower($ca->cat_name)) ?>/<?= $nav->cleanString(strtolower($subname->sub_name)) ?>/<?= $nav->encrypt_decrypt("encrypt", $subname->ID) ?>"><?= ucwords($subname->sub_name) ?></a></li>
                    <?php } ?>
                </ul>
                <?php } ?>
                </li>
            <?php } ?>
                </ul>

            </div>

        </nav>

    </div>

