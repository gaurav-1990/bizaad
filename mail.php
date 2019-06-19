<?php
session_start();
if (isset($_POST['send'])) {
   
    $fname = ucwords($_POST['fname']);
    $lname = ucwords($_POST['lname']);
    $to = 'zeya7270@gmail.com';

    $subject = "Get In Touch Query" . " -" . time();
    $message = '<html><body>';
    $message .= " <br> Get In Touch : Bizaad.com<br><br>";
    $message .= '<table rules="all" style="border-color: #666;" cellpadding="10" cellspacing="10" border="1">';
    $message .= "<tr style='background: #eee;'><td><strong> Name</strong> </td><td>" . "$fname" ." "."$lname" . "</td></tr>";
    $message .= "<tr style='background: #eee;'><td><strong> Email </strong> </td><td>" . "$_POST[email] " . "</td></tr>";
    $message .= "<tr style='background: #eee;'><td><strong> Email </strong> </td><td>" . "$_POST[sub] " . "</td></tr>";
    $message .= "<tr style='background: #eee;'><td><strong> Message </strong> </td><td>" . "$_POST[msg] " . "</td></tr>";
    
    $message .= "</table><br><br>";
    $message .= "</body></html>";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=windows-1254" . "\r\n";
    $headers .= 'From: ' . $_POST['email'] . "\r\n";
    $headers .= 'Reply-To: ' . $_POST['email'] . "\r\n";
    $headers .= 'Bcc: info@nibblesoftware.com,dev@nibblesoftware.com' . "\r\n";
   

    if(mail($to, $subject, $message, $headers)){
        $_SESSION["msg"] = '<div class="alert alert-success"> <<< Message successfully sent .  >>> </div>';
        echo "<script language='javascript' type='text/javascript'>";
        echo "window.location.href='contact-us.php'";
        echo "</script>";

    }else{
	   $_SESSION["msg"] = '<div class="alert alert-danger"> <<< Message sending failed !  >>> </div>';
        echo "<script language='javascript' type='text/javascript'>";
        echo "window.location.href='contact-us.php'";
        echo "</script>";
    }
}
?>

