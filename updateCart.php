<?php

session_start();

if (isset($_POST["updateCart"])) {
    if (isset($_SESSION["cart"])) {
        if (count($_SESSION["cart"]) > 0) {
            foreach ($_SESSION["cart"] as $key => $cart) {
                $_SESSION["cart"][$key]["quantity"] = $_POST["qty"][$key];
            }
        }
        $_SESSION["msg"] = "<div class='alert alert-success'>Cart has been updated</div>";
        echo "<script>window.history.go(-1);</script>";
    }
} else {
    die("No value");
}