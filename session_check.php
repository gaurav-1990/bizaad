<?php

if (!isset($_SESSION['userid']) || empty($_SESSION['userid']) || $_SESSION['userid'] == NULL) {
    echo "<script>window.location.href='login.php'; </script>";
}