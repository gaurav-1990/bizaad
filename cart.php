<?php
include_once ("includes/header_1.php");
include_once("includes/pdo.php");
include_once("includes/Functions.php");
$sign = new Functions($pdo);
?>  
<div class="breadcrumb-banner-area ptb-25">
    <div class="container">
        <div class="breadcrumb-text">
            <div class="breadcrumb-menu">
                <h1 class="entry-title">cart</h1>
                <ul>
                    <li><a href="<?= BASEURL ?>">home</a></li>
                    <li><span>cart </span></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb-banner-area-end -->
<!-- cart-main-area start -->
<div class="cart-main-area pt-40 pb-50">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <?php
                if (count($_SESSION["cart"]) > 0) {
                    ?>
                    <form method="POST" action="updateCart.php">				
                        <div class="table-content table-responsive">
                            <?php
                            if (isset($_SESSION["msg"]) && $_SESSION["msg"] != "") {
                                echo $_SESSION["msg"];
                            } else {
                                $_SESSION["msg"];
                            }
                            $_SESSION["msg"] = "";
                            ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th class="product-thumbnail">Image</th>
                                        <th class="product-name">Product</th>
                                        <th class="product-price"> Price</th>
<!--                                        <th class="product-quantity">Quantity</th>-->
                                        <th class="product-subtotal">Total</th>
                                        <th class="product-remove">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $total = 0.0;
                                    if (count($_SESSION["cart"]) > 0) {


                                        foreach ($_SESSION["cart"] as $key => $cart) {
					    if(isset($cart['ven_id']) && $cart['ven_id'] != ''){
						 $proname = $sign->getVendorAssignProduct($cart["ven_id"],$cart["pro_id"]);
						 $total = $total + (floatval($proname->d_price) * floatval($cart["quantity"]));
					    }else{
						$proname = $sign->getProductById($cart["pro_id"]);
						$total = $total + (floatval($proname->dis_price) * floatval($cart["quantity"]));
					    }
					 					    
                                            $image = $sign->getFirstImageOfPro($cart["pro_id"]);
                                            
                                            $productname = substr(ucwords(strtolower($proname->pro_name)), 0, 40);
                                            $image = BASEURL . "Panel/uploads/original/$image->pro_images";
                                          //  $total = $total + (floatval($proname->dis_price) * floatval($cart["quantity"]));
                                            $key_en = base64_encode($key);
                                            $cancelUrl = BASEURL . "unset_cart.php?key=$key_en";
                                            ?>
                                            <tr>
                                                <td class="product-thumbnail"><a href="#"><img style="width: 100px" src="<?= $image ?>" alt="" /></a></td>
                                                <td class="product-name" title="<?= $proname->pro_name ?>"><a href="#"><?= $productname ?></a></td>
						<?php if(isset($proname->d_price)){ ?>
                                                <td class="product-price"><span class="amount"> <?= $proname->d_price ?></span></td>
						<?php }else{ ?>
						 <td class="product-price"><span class="amount"> <?= $proname->dis_price ?></span></td>
						<?php } ?>
<!--                                                <td class="product-quantity"><input type="number" min="1" name="qty[]" value="<?= $cart["quantity"] ?>" /></td>-->
                                        <input type="hidden" name="key[]" value="<?= $key ?>" />
					<?php if(isset($proname->d_price)){ ?>
                                        <td class="product-subtotal"><?= floatval($proname->d_price) * floatval($cart["quantity"]) ?></td>
					<?php }else{ ?>
					 <td class="product-subtotal"><?= floatval($proname->dis_price) * floatval($cart["quantity"]) ?></td>
					<?php } ?>
                                        <td class="product-remove"><a href="<?= $cancelUrl ?>"><i class="fa fa-times"></i></a></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>

                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-8 col-sm-7 col-xs-12">
                                <div class="buttons-cart">
                                    <input type="submit" name="updateCart" value="Update Cart" />
                                    <a href="<?= BASEURL ?>">Continue Shopping</a>
                                </div>

                            </div>
                            <div class="col-md-4 col-sm-5 col-xs-12">
                                <div class="cart_totals">
                                    <h2>Cart Totals</h2>
                                    <br />
                                    <table>
                                        <tbody>
                                            <tr class="cart-subtotal">
                                                <th>Subtotal</th>
                                                <td><span class="amount"><?= $total ?></span></td>
                                            </tr>
                                            <tr class="order-total">
                                                <th>Total</th>
                                                <td>
                                                    <strong><span class="amount"><?= $total ?></span></strong>
                                                </td>
                                            </tr>											
                                        </tbody>
                                    </table>
                                    <div class="wc-proceed-to-checkout">
                                        <a href="<?= BASEURL ?>checkout.php?checkout=yes">Proceed to Checkout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>	
                    <?php
                } else {
                    ?>
                    <div class="table-content table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th class="product-thumbnail">Image</th>
                                    <th class="product-name">Product</th>
                                    <th class="product-price"> Price</th>
                                    <th class="product-quantity">Quantity</th>
                                    <th class="product-subtotal">Total</th>
                                    <th class="product-remove">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="6">No product available </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php include_once ("includes/footer.php"); ?>