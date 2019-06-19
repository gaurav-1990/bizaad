<?php

session_start();
$_SESSION['userid'] = "";
unset($_SESSION['userid']);
echo "<script>window.location.href='login.php'; </script>";
?>