<?php

session_start();
unset($_SESSION["cart"][base64_decode($_GET["key"])]);
$arr = array_values($_SESSION["cart"]);
$_SESSION["cart"] = $arr;
echo "<script>window.history.go(-1);</script>";
?>