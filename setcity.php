<?php

session_start();
$_SESSION["city_session"] = $_POST["location"];
header("Location:./");
?>