<?php
include_once ("includes/header_1.php");
include_once("includes/pdo.php");

include_once("includes/Functions.php");



if (isset($_SESSION['userid']) & !empty($_SESSION['userid'])) {
    echo "<script>window.location.href='myaccount.php'; </script>";
}
?>
<div class="breadcrumb-banner-area ptb-25">
    <div class="container">
        <div class="breadcrumb-text">
            <div class="breadcrumb-menu">
                <h1 class="entry-title">login</h1>
                <ul>
                    <li><a href="<?= BASEURL ?>">home</a></li>
                    <li><span>login</span></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['login'])) {
    $sign = new Functions($pdo);
    $id = $sign->login($_POST);
    if ($id) {
        echo "<script>window.location.href='myaccount.php'; </script>";
    }
}
?>
<!-- breadcrumb-banner-area-end -->
<!-- PAGE SECTION START -->
<div style="margin-top: -81px;"  class="page-section form-back section pt-100 pb-100">
    <div class="container">
        <div class="row">

            <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
                <div class="login-reg-form">
                    <?= Functions::render(); ?>
                    <form action="" method="POST">
                        <div class="row">
                            <div class="col-xs-12 mb-20">
                                <label for="email">Email Id <span class="required">*</span></label>
                                <input name="email" required="" id="aaimaid" type="email">
                            </div>

                            <div class="col-xs-12 mb-20">
                                <label for="password"> Password <span class="required">*</span></label>
                                <input name="password" required="" id="password" type="password">
                            </div>
                            <div class="col-xs-6 mb-20">
                                <input value="Login" name="login" class="inline" type="submit">
                            </div>

                            <div class="col-xs-12">
                                <a href="<?= BASEURL ?>signup.php"> Sign up </a>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once ("includes/footer.php"); ?>