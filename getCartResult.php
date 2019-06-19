<?php

session_start();
include_once("includes/pdo.php");
include_once("includes/Navigation.php");

include_once("includes/Functions.php");

$sign = new Functions($pdo);

$checkout = BASEURL . "checkout.php?checkout=yes";
$viewCart = BASEURL . "cart.php?checkout=yes";
$cartList = "";
$total = 0.0;

if (isset($_SESSION["cart"])) {
    if (count($_SESSION["cart"]) > 0) {
        foreach ($_SESSION["cart"] as $key => $cart) {	
	    
            $image = $sign->getFirstImageOfPro($cart["pro_id"]);
	    
	    
	    if(isset($cart["ven_id"])&& $cart["ven_id"] != NULL){		
		$proname = $sign->getVendorAssignProduct($cart["ven_id"],$cart["pro_id"]);
	    }else{
		$proname = $sign->getProductById($cart["pro_id"]);
	    }
	  
            $productname = substr(ucwords(strtolower($proname->pro_name)), 0, 25) . "..";
            $image = BASEURL . "Panel/uploads/original/$image->pro_images";
	    if(isset($cart["ven_id"])&&$cart["ven_id"] != NULL){
		$price =$proname->d_price;
            $total = $total + (floatval($proname->d_price) * floatval($cart["quantity"]));
	    }else{
		$price =$proname->dis_price;
	    $total = $total + (floatval($proname->dis_price) * floatval($cart["quantity"]));
	    }
            $key_en = base64_encode($key);
            $cancelUrl = BASEURL . "unset_cart.php?key=$key_en";

            $cartList .= <<<EOD
            
     <li>
                        <div class="cart-img">
                                                <a href="#"><img style="width:80px" src="$image" alt=""></a>
                                            </div>
                                            <div class="cart-content">
                                                <h3><a href="#"> {$cart["quantity"]} X {$productname}</a> </h3>
                                                <span class="cart-price"> <i class="fa fa-inr" aria-hidden="true"></i> {$price}</span>
                                            </div>
                                                <div data-key="$key" onclick="window.location.href='$cancelUrl'" class="cart-del">
						   <i class="fa fa-times-circle"></i>
						 </div>
                                            
    </li>
EOD;
        }
        echo $html = <<<EOD
<ul>
    $cartList
         <hr class="shipping-border" />
        <div class="shipping">
            <span class="f-left"> Total </span>
            <span class="f-right cart-price"><i class="fa fa-inr" aria-hidden="true"></i> $total</span> 
        </div>
       
        <li class="checkout m-0"> <a href="$checkout"> Checkout <i class="fa fa-angle-right"></i></a></li>
        <li class="checkout m-0"> <a href="$viewCart"> View Cart <i class="fa fa-angle-right"></i></a></li>
       
</ul>
EOD;
    } else {
        echo $cartList .= <<<EOD
               <li style='color:white;list-style'> No items available </li>              
EOD;
    }
} else {
    die("No Items Here");
}
