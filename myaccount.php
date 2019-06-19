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
    if (isset($_POST["updatekyc"])) {
        $sm = $sign->updateKyc($_POST);
        if ($sm) {
            Functions::add("<div class='alert alert-success'>!! Profile has been updated !!</div>");
        } else {
            Functions::add("<div class='alert alert-danger'>!! Something went wrong !!</div>");
        }
    }
    if (isset($_POST["updatepass"])) {
        $sm = $sign->updatePassword($_POST);
        if ($sm) {
            Functions::add("<div class='alert alert-success'> !! Password updated !!</div>");
        } else {
            Functions::add("<div class='alert alert-danger'> !! Something went wrong !!</div>");
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
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<div style="margin-top: 66px;" class="pro-info-area ptb-40">
    <div class="container">
        <div class="pro-info-box profile-tab">
            <?=
            Functions::render();
            ?>

            <ul class="pro-info-tab" role="tablist">
                <li class="active"><a href="#home3" data-toggle="tab">Profile</a></li>

                <li><a href="#messages5" data-toggle="tab">Update Profile</a></li>
                <li><a href="#messages6" data-toggle="tab">Update password</a></li>
                <li><a href="#profile3"  data-toggle="tab">Order History</a></li>
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
                                        <label for="address_1">  Address 1 <span class="required">*</span> </label>										
                                        <input id="address_1" value="<?= $data->address_1 ?>" name="address_1"  required="" type="text"/>
                                    </div>
                                    <div class="col-sm-6 col-xs-12 mb-20">
                                        <label for="address_2">  Address 2   </label>										
                                        <input id="address_2" value="<?= $data->address_2 ?>" name="address_2"  type="text"/>
                                    </div>
                                    <div class="col-sm-6 col-xs-12 mb-20">
                                        <label for="postcode"> Post code <span class="required">*</span> </label>										
                                        <input id="postcode" value="<?= $data->pin_code ?>" maxlength="6" minlength="5" name="postcode"  required="" type="text"/>
                                    </div>
                                    <div class="col-sm-6 col-xs-12 mb-20">
                                        <label for="city"> City <span class="required">*</span> </label>										
                                        <input id="city" value="<?= $data->city ?>"  name="city"  required="" type="text"/>
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
                <div class="tab-pane" id="profile3">
                    <div class="pro-desc">
                        <table class="table-data-sheet">
                            <thead>
                                <tr>
                                    <th>Order Id</th>
                                    <th>Name </th>
                                    <th>Mobile</th>
                                    <th>Address</th>
                                    <th>Date</th>
                                    <th>City/State/Pin</th>
                                    <th>Paid Price</th>
                                    <th>View </th>
                                    <th>Invoice </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                //$data2 = $sign->getOrders();
                                $userInfo = $sign->getUserOrders();				
                                foreach ($userInfo as $mycc) {
//				    echo '<pre>';
//				    print_r($mycc);
//				    echo '</pre>';
				  				    
                                    ?>
                                    <tr>
                                        <td><?= $mycc->order_id ?></td>
                                        <td><?= $mycc->first_name ?> <?= $mycc->last_name ?></td>
                                        <td><?= $mycc->user_contact ?></td>
                                        <td><?= $mycc->user_address ?></td>
                                        <td><?= date("d-m-Y H:i", strtotime($mycc->pay_date)) ?></td>
                                        <td><?= $mycc->user_city ?>/<?= $mycc->state ?>/<?= $mycc->user_pin_code ?></td>
                                        <td><?= $mycc->pro_price ?></td>
                                        <td><button   onclick="window.location.href = 'viewDetail.php?id=<?= $sign->encrypt_decrypt("encrypt", $mycc->order_id ); ?>&pro=<?= $sign->encrypt_decrypt("encrypt", $mycc->pro_id ); ?>&&ven=<?= $sign->encrypt_decrypt("encrypt", $mycc->vendor_id ); ?>'"> View </button></td>
                                        <td><button   onclick="window.location.href = 'userinvoice.php?id=<?= $sign->encrypt_decrypt("encrypt", $mycc->order_id ); ?>'"> Invoice  </button></td>
                                    </tr>
                                <?php } ?>

                            </tbody>
                        </table>						
                    </div>
                </div>




            </div>		
        </div>
    </div>
</div>

<?php include_once ("includes/footer.php"); ?>