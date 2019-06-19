<?php

session_start();
include_once("includes/pdo.php");
include_once("includes/Navigation.php");
include_once("includes/Functions.php");

$fun = new Functions($pdo);
if (!isset($_SESSION['cart']) || $_SESSION['cart'] == NULL) {
    $_SESSION['cart'] = array();
    if (isset($_POST["ven_id"])) {
	array_push($_SESSION['cart'], array("pro_id" => $fun->encrypt_decrypt("decrypt", $_POST["pro_id"]), "ven_id" => $fun->encrypt_decrypt("decrypt", $_POST["ven_id"]), "quantity" => $_POST["qty"]));
    } else {
	array_push($_SESSION['cart'], array("pro_id" => $fun->encrypt_decrypt("decrypt", $_POST["pro_id"]), "quantity" => $_POST["qty"]));
    }
} else {
    $qty = 0;
    if (search($_SESSION['cart'], "pro_id", $_POST["pro_id"])) {
	foreach ($_SESSION['cart'] as $key => $val) {

	    if ($_SESSION['cart'][$key]["pro_id"] == $fun->encrypt_decrypt("decrypt", $_POST["pro_id"])) {
		$qty = $qty + $_SESSION['cart'][$key]["quantity"] + (int) $_POST["qty"];
		$_SESSION['cart'][$key]["quantity"] = $qty;
		$_SESSION['cart'][$key]["ven_id"] = isset($_POST["ven_id"]) ? $_POST["ven_id"] : "";
	    }
	}
    } else {
	   if (isset($_POST["ven_id"])) {
	array_push($_SESSION['cart'], array("pro_id" => $fun->encrypt_decrypt("decrypt", $_POST["pro_id"]), "ven_id" => $fun->encrypt_decrypt("decrypt", $_POST["ven_id"]), "quantity" => $_POST["qty"]));
	   }else
	   {
	       	array_push($_SESSION['cart'], array("pro_id" => $fun->encrypt_decrypt("decrypt", $_POST["pro_id"]), "quantity" => $_POST["qty"]));

	   }
    }
}

function search($array, $key, $val) {
    foreach ($array as $item)
	if (isset($item[$key]) && $item[$key] == $val)
	    return true;
    return false;
}

echo count($_SESSION['cart']);
?>