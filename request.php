<?php
date_default_timezone_set("Asia/Kolkata");

session_start();
?>
<!DOCTYPE html>
<html lang="en">


    <head>
        <meta charset="utf-8">
        <title>revantadiplomaticgreens.com</title>

        <!-- Stylesheets -->
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <link href="css/responsive.css" rel="stylesheet">
        <!--Color Switcher Mockup-->


        <!-- Google Tag Manager -->
        <script>(function (w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({'gtm.start':
                            new Date().getTime(), event: 'gtm.js'});
                var f = d.getElementsByTagName(s)[0],
                        j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src =
                        'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', 'GTM-5SC72B4');</script>
        <!-- End Google Tag Manager -->




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
            fbq('init', '429668970920948');
            fbq('track', 'PageView');
        </script>
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=429668970920948&ev=PageView&noscript=1"
                   /></noscript>
    <!-- End Facebook Pixel Code --> 


    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <link rel="icon" href="images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Responsive -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script><![endif]-->
    <!--[if lt IE 9]><script src="js/respond.js"></script><![endif]-->
</head>
<?php
if (isset($_POST["btn_save"])) {
    extract($_POST);
    curl_setopt($ch, CURLOPT_URL, "http://revantadiplomaticgreens.com/enquiry/api.php?name=$name&email=$email&phone=$phone&property_type=$property_type&query=$query");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec($ch);
    curl_close($ch);
     print_r($server_output);
}
?>
<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5SC72B4"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->


    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-137706893-1"></script>
    <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'UA-137706893-1');
    </script>

    <?= Query::render() ?>
    <div class="page-wrapper">

        <header class="main-header header-style-two">

            <div class="header-lower">

                <div class="main-box">
                    <div class="inner-container clearfix">
                        <div class="logo-box">
                            <div class="logo"><a href="index.php"><img src="images/logo-2.png" alt="" title=""></a></div>
                        </div>

                        <div class="nav-outer clearfix">
                            <!-- Main Menu -->
                            <!--
                            <nav class="main-menu navbar-expand-md navbar-light">
                                <div class="navbar-header">
                            <!-- Toggle Button     
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="icon flaticon-menu"></span>
                            </button>
                        </div>

             
                    </nav> 
                            -->



                            <div class="outer-box">
                                <div class="btn-box">
                                    <a href="tel:+91 907-157-5263" class="theme-btn btn-style-five"><i class="la la-phone"></i> +91 907-157-5263</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!--End Header Lower-->

            <!-- Sticky Header  -->
            <!-- End Sticky Menu -->
        </header>
        <!--End Main Header -->

        <!-- Property Search Section Two -->
        <section class="property-search-section-two" >


            <div class="image-top">
                <img src="images/main-slider/image-1.jpg" alt="">
            </div>




            <div class="auto-container" id="forn-ctn">
                <div class="content-box">
                    <div class="image-sec">
                        <img src="images/girl.png" alt="girl-home"> 
                    </div>

                    <form method="post" action="#">
                        <div class="form-group ">
                            <input type="text" class="form-control" name="name" placeholder="Name" required>
                        </div>
                        <div class="form-group ">
                            <input type="email" class="form-control"  name="email" placeholder="Email" required>
                        </div>
                        <div class="form-group ">
                            <input type="text" class="form-control"  name="phone" maxlength="10" minlength="10" placeholder="Contact No" required>
                        </div>
                        <div class="form-group ">
                            <select name="property_type" class="form-control" id="">
                                <option value="1-BHK - 450 sq.ft">1 BHK - 450 sq.ft </option>
                                <option value="2BHK - 715 Sq.Ft">2BHK - 715 Sq.Ft</option>
                                <option value="2BHK+SQ - 860 Sq.Ft">2BHK+SQ - 860 Sq.Ft</option>
                                <option value="3BHK - 1000 Sq.Ft">3BHK - 1000 Sq.Ft</option>
                                <option value="3BHK+SQ - 1200 Sq.Ft">3BHK+SQ - 1200 Sq.Ft</option>
                                <option value="4BHK+S - 1350 Sq.Ft">4BHK+S - 1350 Sq.Ft</option>
                                <option value="4BHK+S+SQ - 1650 Sq.Ft">4BHK+S+SQ - 1650 Sq.Ft</option>
                            </select>
                        </div>
                        <div class="form-group ">
                            <textarea  class="form-control"  name="query" placeholder="message"></textarea>
                        </div>
                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                            <button type="submit" name="btn_save" class="theme-btn btn-style-one">Get free advice</button>
                        </div>
                    </form>

                </div>
            </div>
        </section>
        <section id="property" class="process-section" style="background-image: url(images/background/9.jpg);">
            <div class="row">
                <!-- Process Block -->
                <a href="http://revantadiplomaticgreens.com" target="_blank">
                    <div class="process-block col-lg-2 col-md-6 col-sm-12" style="    background-color: #e3912b;">

                        <div class="inner-box">
                            <div class="icon-box"><span class=" la la-building-o"></span></div>
                            <h4><a href="#">Property Type</a></h4>
                            <div class="text">1/2/3/4 BHK</div>
                        </div>
                    </div>
                </a>


                <!-- Process Block -->
                <a href="http://revantadiplomaticgreens.com" target="_blank">
                    <div class="process-block col-lg-2 col-md-6 col-sm-12" style="        background-color: #00266b;">
                        <div class="inner-box">
                            <div class="icon-box"><span class="la la-map-marker"></span></div>
                            <h4><a href="#"> Location</a></h4>
                            <div class="text"> Dwarka L Zone, New Delhi</div>
                        </div>
                    </div>
                </a>

                <!-- Process Block -->
                <a href="http://revantadiplomaticgreens.com" target="_blank">
                    <div class="process-block col-lg-2 col-md-6 col-sm-12" style="    background-color: #951142;">
                        <div class="inner-box">
                            <div class="icon-box"><span class=" la la-hand-pointer-o"></span></div>
                            <h4><a href="#">Highlights</a></h4>
                            <div class="text">Luxury Apartments</div>
                        </div>
                    </div>
                </a>

                <!-- Process Block -->
                <a href="http://revantadiplomaticgreens.com" target="_blank">
                    <div class="process-block col-lg-2 col-md-6 col-sm-12" style="background-color: #1d3e15;">
                        <div class="inner-box">
                            <div class="icon-box"><span class="la la-car"></span></div>
                            <h4><a href="#">Connectivity</a></h4>
                            <div class="text">Well Connected</div>
                        </div>
                    </div>
                </a> 

                <a href="http://revantadiplomaticgreens.com" target="_blank">
                    <div class="process-block col-lg-2 col-md-6 col-sm-12" style="background-color: #03919f;">
                        <div class="inner-box">
                            <div class="icon-box"><span class="la la-gift"></span></div>
                            <h4><a href="#">Payment Plan</a></h4>
                            <div class="text">Attractive</div>
                        </div>
                    </div>
                </a>

                <a href="http://revantadiplomaticgreens.com" target="_blank">
                    <div class="process-block col-lg-2 col-md-6 col-sm-12" style="background-color: #d43a17;">
                        <div class="inner-box">
                            <div class="icon-box"><span class="la la-file-text"></span></div>
                            <h4><a href="#">Status</a></h4>
                            <div class="text">Ready Launch</div>
                        </div>
                    </div>
                </a>
            </div>

        </section>




        <!-- Testimonial Section -->
        <section id="contact" class="call-back-section" style="background-image: url(images/background/15.jpg);">
            <div class="auto-container">
                <div class="row">




                    <div class="col-md-12">

                        <div class="sec-title">
                            <span class="title">GET IN TOUCH</span>
                            <h2 style="    color: #fff;">Contact Details</h2>
                        </div>
                        <div class="red">
                            <div class="sc-contact-info">
                                <div class="sc-heading">
    <!--                                <p class="first-title">Full Address</p>-->
                                    <p class="description">
                                    <p class="address">Registered Office: <a href="#"> 16/14, 17/2, Opp. Rama Krishna Apt, Dwarka Sector 23, New Delhi 110075</a> <br>


                                    </p>
                                    <p class="address">Corporate office : <a href="#">  C116, 1st Floor, Sector-2, Noida, Uttar Pradesh 201301</a> <br>


                                    </p>
                                </div>
                                <p class="phone">Call: <a href="tel:+91-907-157-5263"> +91-907-157-5263</a></p>
                                <p class="email"> Email:<a href="mailto:info@kampstudioapartments.com"> info@revantadiplomaticgreens.com
                                    </a></p>
                                <p class="email2">Website:<a href="#"> www.revantadiplomaticgreens.com</a></p>

                            </div>
                            <div
                        </div>

                    </div>
                </div>
            </div>
    </section>


    <!-- Main Footer -->
    <footer class="main-footer style-two">
        <!--Footer Bottom-->
        <div class="footer-bottom">

            <div class="inner-container clearfix">
                <div class="footer-nav">
                    <ul>
                        <li><a href="https://www.facebook.com/RevantaDiplomaticGreens/" target="_blank"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li> 
                        <li><a href="https://www.linkedin.com/company/diplomatic-greens/" target="_blank"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li> 
                        <li><a href="https://twitter.com/revantagreens" target="_blank"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li> 
                        <li><a href="https://www.instagram.com/revanta_diplomatic_greens/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li> 

                        <li><a href="https://api.whatsapp.com/send?phone=9999700931&text=Let’s Discuss Your Plan" target="_blank"><i class="fa fa-whatsapp" aria-hidden="true"></i></a></li> 
                    </ul>
                </div>

                <div class="copyright-text">
                    <p>Revantadiplomaticgreens © Copyright 2019 All rights reserved  </p>
                </div>
            </div>

        </div>
    </footer>
    <!-- End Main Footer -->

</div>
<div class="call-tag" >
    <a href="tel:+91 907-157-5263">
        <img src="images/call.gif" alt=""/>
    </a>
</div>

<div class="send-tag" >
    <a href="#forn-ctn">
        <img src="images/send.gif" alt=""/>
    </a>

</div>

<!--End pagewrapper-->

<!-- Color Palate / Color Switcher -->
<!-- End Color Switcher -->

<script src="js/jquery.js"></script> 
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery.fancybox.js"></script>
<script src="js/owl.js"></script>
<script src="js/wow.js"></script>
<script src="js/isotope.js"></script>
<script src="js/appear.js"></script>
<script src="js/validate.js"></script>
<script src="js/script.js"></script>
<!--Google Map APi Key-->

<script src="js/map-script.js"></script>
<!--End Google Map APi-->
<!-- Color Setting -->
<script src="js/color-settings.js"></script>


</body>


</html>