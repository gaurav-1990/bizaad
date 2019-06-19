<?php
$date1 = date_create($_POST["sdate"]);
$date2 = date_create($_POST["close_date"]);
$diff = date_diff($date1, $date2);
echo $diff->d + 1;