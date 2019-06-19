<?php
include_once ("includes/header_1.php");
include_once("includes/pdo.php");
include_once("includes/Functions.php");
?>
<?php
if (isset($_POST["register"])) {
    $sign = new Functions($pdo);
    $post = $sign->registration($_POST);
}
if (isset($_POST["one_time_btn"])) {
    $sign = new Functions($pdo);
    $id = $sign->encrypt_decrypt("decrypt", $_POST["otp_id"]);

    $result = $sign->getRegistrationInfo($id);

    if ($result->mobile_otp == $_POST["otp_confirm"]) {
        $sign = new Functions($pdo);
        $isUpdate = $sign->updtateOTP($_POST["otp_confirm"], $id);

        if ($isUpdate) {

            $_SESSION["userid"] = $id;
            $_SESSION["username"] = $result->fname;

            echo "<script>window.location.href='myaccount.php'; </script>";
        } else {
            die("Something went wrong");
        }
    } else {
        Functions::add("<div class='alert alert-danger'>Invalid Otp</div>");
    }
}
?>

<div class="breadcrumb-banner-area ptb-25">
    <div class="container">
        <div class="breadcrumb-text">
            <div class="breadcrumb-menu">
                <ul>
                    <li><a href="./">home</a></li>
                    <li><span>register</span></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div style="" class="page-section form-back section pt-100 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 col-xs-12">
                <div class="login-reg-form">
                    <form id="signForm" action="" method="POST">
                        <?=
                        Functions::render();
                        ?>
                        <div class="row">
                            <?php if (!isset($_GET['requested_id']) && !isset($_GET['otp'])) { ?>
                                <div class="col-sm-6 col-xs-12 mb-20">
                                    <label for="firstname">First name <span class="required">*</span></label>										
                                    <input id="firstname" name="firstname" type="text"/>
                                </div>
                                <div class="col-sm-6 col-xs-12 mb-20">
                                    <label for="lastname">Last name <span class="required">*</span></label>										
                                    <input id="lastname" name="lastname" type="text"/>
                                </div>
                                <div class="col-sm-6 col-xs-12 mb-20">
                                    <label for="email">Email Address <span class="required">*</span></label>										
                                    <input id="email" name="email" type="email"/>
                                </div>
                                <div class="col-sm-6 col-xs-12 mb-20">
                                    <label for="telephone">Phone  <span class="required">*</span></label>										
                                    <input id="telephone" name="telephone" type="text" />
                                </div>
                                <div class="col-xs-12 mb-20">
                                    <label class="" for="password"> Password<span class="required">*</span></label>
                                    <input id="password" required=""  name="password" type="password">
                                </div>
                                <div class="col-xs-12 mb-20">
                                    <label class="" for="confirm_password">Confirm password<span class="required">*</span></label>
                                    <input id="confirm_password" required=""  name="confirm_password" type="password">
                                </div>

                                <div class="col-xs-12">
                                    <input value="register" name="register" type="submit">
                                </div>

                                <?php
                            } elseif (isset($_GET['requested_id']) && isset($_GET['otp']) && $_GET["otp"] == "yes") {
                                $sign = new Functions($pdo);
                                $result = $sign->getOneTimePassword($_GET['requested_id']);
                                ?>
                                <div class="col-xs-12 mb-20">
                                    <label class="" for="otp_confirm">One Time Password<span class="required">*</span></label>
                                    <input id="otp_confirm" name="otp_confirm" type="text">
                                </div>

                                <div class="col-xs-12">
                                    <input type="hidden" name="otp_id" value="<?= $sign->encrypt_decrypt("encrypt", $result->id) ?>" />
                                    <input value="Submit" name="one_time_btn" type="submit">
                                </div>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once ("includes/footer.php"); ?>