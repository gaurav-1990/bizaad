<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once("includes/pdo.php");
include_once ("includes/header_1.php");
include_once("includes/Functions.php");

$sign = new Functions($pdo);

if (isset($_SESSION["userid"])) {
    include_once("./session_check.php");
    $data = $sign->getUserDataByID($_SESSION["userid"]);
    $filename = [];
    if (isset($_POST["updatekyc"])) {
        if (isset($_FILES['photo_file']) && isset($_FILES["cheque_photo"])) {


            // photo upload start

            $errors = array();
            $file_name = $_FILES['photo_file']['name'];


            $file_size = $_FILES['photo_file']['size'];
            $file_tmp = $_FILES['photo_file']['tmp_name'];
            $file_type = $_FILES['photo_file']['type'];
            $file_ext = strtolower(end(explode('.', $_FILES['photo_file']['name'])));
            $file_name = base64_encode($_FILES['photo_file']['name']) . ".$file_ext";

            $extensions = array("jpeg", "jpg", "png");
            if (in_array($file_ext, $extensions) === false) {
                $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
            }

            if ($file_size > 4194304) {
                $errors[] = 'File size must be less than 2 MB';
            }




            $cheque_photo_name = $_FILES['cheque_photo']['name'];
            $cheque_photo_size = $_FILES['cheque_photo']['size'];
            $cheque_photo_tmp = $_FILES['cheque_photo']['tmp_name'];
            $cheque_photo_type = $_FILES['cheque_photo']['type'];
            $cheque_photo_ext = strtolower(end(explode('.', $_FILES['cheque_photo']['name'])));
            $cheque_photo_name = base64_encode($_FILES['cheque_photo']['name']) . ".$file_ext";

            if (in_array($cheque_photo_ext, $extensions) === false) {
                $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
            }

            if ($cheque_photo_size > 4194304) {
                $errors[] = 'File size must be less than 4 MB';
            }
            if (empty($errors) == true) {
                move_uploaded_file($file_tmp, __DIR__ . "/Panel/uploads/profilePic/" . $file_name);

                move_uploaded_file($cheque_photo_tmp, __DIR__ . "/Panel/uploads/cheque/" . $cheque_photo_name);
                $filename = array("photo" => $file_name, "cheq" => $cheque_photo_name);
            } else {
                $_SESSION["msg"] = $errors;
            }
        }

        $sm = $sign->updateKyc($_POST, $filename);

        if ($sm) {
            $_SESSION["msg"] = "<div class='alert alert-success'> !! Kyc updated !!</div>";
        } else {
            $_SESSION["msg"] = "<div class='alert alert-danger'> !! Something went wrong !!</div>";
        }
    }

    if (isset($_POST["updatepass"])) {
        $sm = $sign->updatePassword($_POST);
        if ($sm) {
            $_SESSION["msg"] = "<div class='alert alert-success'> !! Password updated !!</div>";
        } else {
            $_SESSION["msg"] = "<div class='alert alert-danger'> !! Something went wrong !!</div>";
        }
    }
} else if (isset($_GET["user_check"])) {


    echo "<script>window.location.href='checkout.php?user_check=yes&&checkout=yes'</script>";
} else {

    include_once("./session_check.php");
}

if (isset($_POST)) {
    $data = $sign->getUserDataByID($_SESSION["userid"]);
}
if (isset($_POST["claim"])) {

    $sm = $sign->claimStatus($_POST['withdrawal_id']);
    if ($sm) {
        $_SESSION["msg"] = "<div class='alert alert-success'> !! Claimed Successfully !!</div>";
    } else {
        $_SESSION["msg"] = "<div class='alert alert-danger'> !! Something went wrong !!</div>";
    }
}
?>
<div style="margin-top: 66px;" class="pro-info-area ptb-40">
    <div class="container">
        <div class="pro-info-box profile-tab">
            <?php
            if (isset($_SESSION["msg"]) && $_SESSION["msg"] != "") {
                if (!is_array($_SESSION["msg"])) {
                    echo $_SESSION["msg"];
                } else {
                    print_r($_SESSION["msg"]);
                }
                $_SESSION["msg"] = "";
            }
            ?>

            <ul class="pro-info-tab" role="tablist">
                <li class="active"><a href="#home3" data-toggle="tab">Profile</a></li>
                <li><a href="#profile3" data-toggle="tab">Order</a></li>
                <li><a href="#messages5" data-toggle="tab">Update K.Y.C</a></li>
                <li><a href="#messages3" data-toggle="tab">Wallet amount</a></li>
                <li><a href="#messages4" data-toggle="tab">Withdrawal Amount</a></li>
                <li><a href="#messages6" data-toggle="tab">Update password</a></li>

            </ul>




            <div class="tab-content">
                <div class="tab-pane active" id="home3">
                    <div class="pro-desc">
                        <table class="table-data-sheet">
                            <tbody>
                                <tr class="odd">
                                    <td>Name</td>
                                    <td><?= $data->firstname ?> <?= $data->lastname ?></td>
                                </tr>
                                <tr class="even">
                                    <td>Email</td>
                                    <td><?= $data->email ?></td>
                                </tr>
                                <tr class="odd">
                                    <td>Phone No</td>
                                    <td><?= $data->telephone ?></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="profile3">
                    <div class="pro-desc">
                        <table class="table-data-sheet">
                            <tbody>
                                <tr>
                                    <th>Order Id</th>
                                    <th>Name </th>
                                    <th>Mobile</th>
                                    <th>Address</th>
                                    <th>City/State/Pin</th>
                                    <th>AAIMA Price</th>
                                    <th>View </th>
                                    <th>Invoice </th>
                                </tr>

                                <?php
                                $customerOrder = $sign->getCustomerOrders();
                                if (count($customerOrder) > 0) {
                                    foreach ($customerOrder as $order) {
                                        $signOrder = $sign->orderDetails($order->id);
                                        $price = 0.0;
                                        foreach ($signOrder as $ord) {
                                            $price = floatval($price) + floatval($ord->pro_price);
                                        }
                                        ?>
                                        <tr class="odd">
                                            <td><?= $order->id ?></td>
                                            <td><?= $order->first_name ?> <?= $order->last_name ?></td>
                                            <td><?= $order->user_contact ?> </td>
                                            <td><?= $order->user_address ?> </td>
                                            <td><?= $order->user_city ?> / <?= $order->state ?> /<?= $order->user_pin_code ?></td>
                                            <td>  
                                                <?= $price ?>
                                            </td>
                                            <td> <a href="<?= BASEURL ?>orderInfo.php?order=<?= base64_encode($order->id) ?>"><i class="fa fa-info"></i></a> </td>
                                            <td> <a href="<?= BASEURL ?>userInvoice.php?order=<?= base64_encode($order->id) ?>"><i class="fa fa-list"></i></a> </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                <td colspan="8"> Currently no orders </td>
                            <?php } ?>

                            </tbody>
                        </table>						
                    </div>
                </div>
                <div class="tab-pane" id="messages3">
                    <div class="pro-desc">
                        <a href="#"><?php
                            $wallet = $sign->getWalletAmount();
                            echo "Purchase Points: " . $wallet->wallet_amount;
                            ?>
                        </a>
                    </div>
                </div>

                <div class="tab-pane" id="messages4">
                    <div class="pro-desc">
                        <a href="#"><?php
                            $withdrawal = $sign->getWithdrawalAmount();
                            echo "Withdrawal Points: " . $withdrawal->withdrawal_amount;
                            ?>
                        </a>
                        <table class="table-data-sheet">
                            <tbody>
                                <tr>
                                    <th>Sr.</th>
                                    <th>Remarks </th>
                                    <th>Amount</th>
                                    <th>TDS</th>
                                    <th>Admin Charges</th>
                                    <th>Payable Amount</th>
                                    <th>Date </th>
                                    <th>Claim</th>
                                    <th>Paid</th>
                                </tr>
                                <?php
                                $withdrawal_history = $sign->getWithdrawalHistory();
                                $sr = 1;
                                foreach ($withdrawal_history as $val) {
                                    //amount calculation
                                    $amount = $val->withdrawal_amount;
                                    if ($amount == '') {
                                        $amount = 0;
                                    }

                                    $tds = $amount * 5 / 100;
                                    $admin_charges = $amount * 10 / 100;
                                    $payable_amount = $amount - $tds - $admin_charges;
                                    //claim status
                                    $claim_status = $val->claim_status;

                                    //paid status
                                    $paid_status = $val->status;
                                    if ($paid_status == 1) {
                                        $paid = "Paid";
                                    } else {
                                        $paid = "Unpaid";
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $sr++; ?></td>
                                        <td><?php echo $val->remark; ?></td>                                
                                        <td><?php echo $amount; ?></td>
                                        <td><?php echo $tds ?></td>
                                        <td><?php echo $admin_charges; ?></td>
                                        <td><?php echo $payable_amount; ?></td>
                                        <td><?php
                                            $date = explode(' ', $val->created_at);
                                            echo $date[0];
                                            ?></td>
                                        <td><?php
                                            if ($claim_status == 1) {
                                                echo "Claimed";
                                            } else {
                                                ?>
                                                <form   action="" method="POST">

                                                    <input id="withdrawal_id" name="withdrawal_id" value="<?= $val->id ?>"  type="hidden">
                                                    <input id="claim_status" name="claim_status" value="1"  type="hidden">

                                                    <input value="claim" name="claim" type="submit">

                                                </form>
                                            <?php }
                                            ?></td>
                                        <td><?php echo $paid; ?></td>
                                    </tr>
                                <?php }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="messages5">
                    <div class="col-md-12   col-xs-12">
                        <div class="login-reg-form">
                            <form enctype="multipart/form-data" action="" method="POST">
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12 mb-20">
                                        <label for="firstname">First name <span class="required">*</span></label>										
                                        <input id="firstname" value="<?= $data->firstname ?>" name="firstname" required="" type="text"/>
                                    </div>
                                    <div class="col-sm-6 col-xs-12 mb-20">
                                        <label for="lastname">Last name <span class="required">*</span></label>										
                                        <input id="lastname" value="<?= $data->lastname ?>" name="lastname"  required="" type="text"/>
                                    </div>
                                    <div class="col-sm-6 col-xs-12 mb-20">
                                        <label for="email">Email <span class="required">*</span></label>                                        
                                        <input id="email" value="<?= $data->email ?>" name="email"  required="" type="email"/>
                                    </div>
                                    <div class="col-sm-6 col-xs-12 mb-20">
                                        <label for="telephone">Contact Number<span class="required">*</span></label>                                        
                                        <input id="telephone" value="<?= $data->telephone ?>" name="telephone"  required="" type="text"/>
                                    </div>
                                    <div class="col-sm-6 col-xs-12 mb-20">
                                        <label for="photo"> Upload Photo <span class="required">*</span></label>										
                                        <input id="photo_file" name="photo_file"   type="file"/>
                                        <?php
                                        if ($data->photo != '') {
                                            ?>
                                            <a  target="_blank" href="<?= BASEURL ?>Panel/uploads/profilePic/<?= $data->photo ?>">Photo</a>
                                        <?php } ?>
                                    </div>
                                    <div class="col-sm-6 col-xs-12 mb-20">
                                        <label for="cheque_photo">Cheque Photo <span class="required">*</span> </label>										
                                        <input id="cheque_photo" name="cheque_photo"  type="file" />
                                        <?php
                                        if ($data->cheque_photo != '') {
                                            ?>
                                            <a target="_blank" href="<?= BASEURL ?>Panel/uploads/cheque/<?= $data->cheque_photo ?>"> Cheque</a>
                                        <?php } ?>
                                    </div>
                                    <div class="col-sm-6 col-xs-12 mb-20">
                                        <label for="aadhar_card">Aadhar Card  <span class="required">*</span></label>										
                                        <input id="aadhar_card"   value="<?= $data->aadhar_card ?>" name="aadhar_card" required="" type="text" />
                                    </div>
                                    <div class="col-sm-6 col-xs-12 mb-20">
                                        <label for="bank_account">Bank Account Number  <span class="required">*</span> </label>										
                                        <input id="bank_account"  value="<?= $data->bank_account ?>" name="bank_account"  required="" type="text" />

                                    </div>
                                    <div class="col-sm-6 col-xs-12 mb-20">
                                        <label for="pan_card">Pan card <span class="required">*</span> </label>										
                                        <input id="pan_card" value="<?= $data->pan_card ?>" name="pan_card"  required="" type="text"/>

                                    </div>
                                    <div class="col-sm-6 col-xs-12 mb-20">
                                        <label for="ifsc_code">IFSC Code <span class="required">*</span> </label>										
                                        <input id="ifsc_code" value="<?= $data->ifsc_code ?>" name="ifsc_code"  required="" type="text"/>
                                    </div>
                                    <div class="col-sm-6 col-xs-12 mb-20">
                                        <label for="nominee_name">Nominee Name <span class="required">*</span> </label>										
                                        <input id="nominee_name" value="<?= $data->nominee_name ?>" name="nominee_name"  required="" type="text"/>
                                    </div>
                                    <div class="col-sm-6 col-xs-12 mb-20">
                                        <label for="nominee_relation">Nominee Relation <span class="required">*</span> </label>										
                                        <input id="nominee_name" value="<?= $data->nominee_relation ?>" name="nominee_relation"  required="" type="text"/>
                                    </div>
                                    <div class="col-sm-6 col-xs-12 mb-20">
                                        <label for="aadhar_nominee">Nominee Aadhaar  <span class="required">*</span> </label>										
                                        <input id="aadhar_nominee" value="<?= $data->aadhar_nominee ?>" name="aadhar_nominee"  required="" type="text"/>
                                    </div>
                                    <div class="col-sm-6 col-xs-12 mb-20">
                                        <label for="address_1"> Nominee Address 1 <span class="required">*</span> </label>										
                                        <input id="address_1" value="<?= $data->address_1 ?>" name="address_1"  required="" type="text"/>
                                    </div>
                                    <div class="col-sm-6 col-xs-12 mb-20">
                                        <label for="address_2"> Nominee Address 2   </label>										
                                        <input id="address_2" value="<?= $data->address_2 ?>" name="address_2"  type="text"/>
                                    </div>
                                    <div class="col-sm-6 col-xs-12 mb-20">
                                        <label for="postcode"> Post code <span class="required">*</span> </label>										
                                        <input id="postcode" value="<?= $data->postcode ?>" name="postcode"  required="" type="text"/>
                                    </div>
                                    <div class="col-sm-6 col-xs-12 mb-20">
                                        <label for="city"> City <span class="required">*</span> </label>										
                                        <input id="city" value="<?= $data->city ?>" name="city"  required="" type="text"/>
                                    </div>
                                    <div class="col-xs-12">
                                        <input value="updatekyc" name="updatekyc" type="submit">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="messages6">
                    <div class="col-md-12   col-xs-12">
                        <div class="login-reg-form">
                            <form   action="" method="POST">
                                <div class="row">
                                    <div class="col-sm-6 mb-20">
                                        <label class="" for="password">New Password</label>
                                        <input id="password" name="password" value="<?= $data->pass ?>"  type="text">
                                    </div>
                                    <div class="col-xs-12">
                                        <input value="updatepass" name="updatepass" type="submit">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>		
        </div>
    </div>
</div>

<?php include_once ("includes/footer.php"); ?>