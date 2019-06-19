<?php

if (!defined('BASEURL')) {
    define("BASEURL", "http://localhost/bizaad/");
}

class Functions extends Navigation {

    public function __construct($pdo) {
	parent::__construct($pdo);
	$this->con = $pdo;
    }

    public function getProductById($id) {
	$prepare = $this->con->prepare("select *,tbl_product.id as ID from tbl_product JOIN tbl_categories on tbl_categories.id=tbl_product.cat_id join tbl_subcategory on tbl_subcategory.id=tbl_product.sub_id where tbl_product.id=? ");
	$prepare->execute(array($id));
	return $prepare->fetch();
    }
  

    public function getProductsBySubCategory($subId) {
	$prepare = $this->con->prepare("CALL `getProBySubId` (?)");  //storedProcedure Call Getting Product Details
	$prepare->execute(array($subId));
	return $prepare->fetchAll();
    }

    public function updateKyc($post) {
	$prepare = $this->con->prepare("update tbl_user_reg set firstname=?,lastname=?,telephone=?,email=?,address_1=?,address_2=?,pin_code=?,city=? where  id=?");
	return $prepare->execute(array($post["firstname"], $post["lastname"], $post["telephone"], $post["email"], $post["address_1"], $post["address_2"], $post["postcode"], $post["city"], $_SESSION["userid"]));
    }

    public function updateCustomerOrder($id) {
	try {
	    $prepare = $this->con->prepare("update tbl_customer_order set pay_sta=? where id=?");
	    $prepare->execute([1, $id]);
	    $prepare2 = $this->con->prepare("insert tbl_user_invoice set order_id=?");
	    $prepare2->execute([$id]);	    
	    $mail = $this->sendEmail($id);
	    $mail2 = $this->sendUserEmail($id);
	   
	    return $id;
	} catch (Exception $ex) {
	    return $ex->getMessage();
	}
    }

    public function updatePassword($post) {
	$prepare = $this->con->prepare("update tbl_user_reg set password=?,pass=? where id=?");
	return $prepare->execute(array(password_hash($post["password"], PASSWORD_BCRYPT), $post["password"], $_SESSION["userid"]));
    }

    public function getOrders() {
	// getting data from view (check the view table)
	$prepare = $this->con->prepare("select *,SUM(pro_price) as total_price  from view_customer_product_order_join where registered_user=? and pay_sta=? group by CID");
	$prepare->execute([$_SESSION["userid"], 1]);
	return $prepare->fetchAll();
    }

    public function getOrdersDetails($id) {
	// getting data from view (check the view table)

	$prepare = $this->con->prepare("select * from view_customer_product_order_join  where registered_user=? and CID=?");
	$prepare->execute([$_SESSION["userid"], $id]);
	return $prepare->fetchAll();
    }

    // Ziya code
    public function getCate($id) {
	$prepare = $this->con->prepare("select * from tbl_categories where id=?");
	$prepare->execute([$id]);
	return $prepare->fetchAll()[0];
    }

    public function updtateOTP($otp, $id) {
	$prepare = $this->con->prepare("update tbl_user_reg set is_valid=? where mobile_otp=? and id=?");
	if ($prepare->execute(array(1, $otp, $id)))
	    return true;
	return false;
    }

    public function addCustomerOrder($post, $session) {
	
	$preapare = $this->con->prepare("insert into tbl_customer_order set registered_user=?,user_email=?,first_name=?,last_name=?,country=?,state=?,user_address=?,user_city=?,user_pin_code=?,pay_date=?,user_contact=?,vendor_id=?");
	$preapare->execute([$_SESSION["userid"], $post["user_email"], $post["firstname"], $post["lastname"], $post["country"], $post["state"], $post["user_address"], $post["user_city"], $post["user_pin_code"], date("Y-m-d H:i:s"), $post["contact"],$session[0]['ven_id']]);
	$last = $this->con->lastInsertId();
	
	$returnPrice = $this->addOrder($post, $last);
	return [$returnPrice, $last];
    }

    private function addOrder($post, $last) {
	$total = 0.0;
	foreach ($_SESSION["cart"] as $aa) {
	    if(isset($aa["ven_id"]) && $aa['ven_id'] != NULL){
		$vend_id = $aa['ven_id'];
		 $data = $this->getVendorAssignProduct($aa["ven_id"],$aa["pro_id"]);
		 $price = $data->d_price;
	    }else{
		$vend_id = '';
		 $data = $this->getProductById($aa["pro_id"]);
                 $price = $data->dis_price;
	    }
	    
//	    $data = $this->getProductById($aa["pro_id"]);
//	    $price = $data->dis_price;

	    if ($post["payment_type"] == "advance") {
		$price = floatval($price) * floatval($data->percentage) / 100;
		$total = $total + $price;
	    } else {
		 if(isset($aa["ven_id"]) && $aa['ven_id'] != NULL){
		    $total = $total + floatval($data->d_price);
		 }else{
		    $total = $total + floatval($data->dis_price); 
		 }
	    }
	    $preapare = $this->con->prepare("insert into  tbl_order set order_id=?,pro_id=?,order_prop=?,pro_qty=?,pro_price=?,pay_date=?,vendor_id=?");
	    $preapare->execute([$last, $aa["pro_id"], serialize($post), $aa["quantity"], $price, date("Y-m-d H:i:s"), $vend_id]);
	}
	return $total;
    }

    public function login($post) {


	$prepare = $this->con->prepare("select * from tbl_user_reg where email=?");
	$prepare->execute(array($post["email"]));
	$data = $prepare->fetch();
	if ($data != NULL) {
	    if (password_verify($post["password"], $data->password)) {

		$_SESSION["userid"] = $data->id;
		$_SESSION["username"] = $data->firstname;
		return TRUE;
	    } else {
		$this->add("<div class='alert alert-danger'> !! Invalid Credentials !!</div>");
		return FALSE;
	    }
	} else {
	    $this->add("<div class='alert alert-danger'> !! Invalid Credentials !!</div>");
	    return FALSE;
	}
    }
    public function insertIntoGuestVend($post,$sid){
	
	$pro = $this->encrypt_decrypt("decrypt", $post["pro_id"]);
	$pro = $this->encrypt_decrypt("decrypt", $pro);
	$venProname = $this->getVendorProductSpec($pro,$sid);
	
	$firstname = addslashes($post["firstname"]);
	$lastname = addslashes($post["lastname"]);
	$user_email = filter_var($post["user_email"], FILTER_SANITIZE_EMAIL);
	$contact = addslashes($post["contact"]);
	$user_address = addslashes($post["user_address"]);
	$user_pin_code = addslashes($post["user_pin_code"]);

	$first = "";
	$second = "";
	$third = "";
//repare booking
	$repare_date_booking = isset($post["repare_date_booking"]) ? $post["repare_date_booking"] : "";
	$repare_time_slot = isset($post["repare_time_slot"]) ? $post["repare_time_slot"] : "";

//cab  
	$tripstartdate = isset($post["tripstartdate"]) ? $post["tripstartdate"] : "";
	$cab_pick_time = isset($post["cab_pick_time"]) ? $post["cab_pick_time"] : "";
	$trip_closing_date = isset($post["trip_closing_date"]) ? $post["trip_closing_date"] : "";

//professional
	$preffered_mode = isset($post["preffered_mode"]) ? $post["preffered_mode"] : "";
	$appoint_date = isset($post["appoint_date"]) ? $post["appoint_date"] : "";
	$prof_time_slot = isset($post["prof_time_slot"]) ? $post["prof_time_slot"] : "";


//        $state = addslashes($post["state"]);
//        $user_city = addslashes($post["user_city"]);
	
	
	$is_execute = 0;
	$lastid = 0;
	$advance_payment = round((floatval($venProname->d_price) * floatval($venProname->percentage) / 100), 2);
	
	$prepare = $this->con->prepare("insert into tbl_guest_booking set date_of_booking=?,repair_time_slot=?,type=?,fname=?,lname=?,advance_price=?,email=?,contact=?,product_id=?,pro_price=?,zip=?,address=?,pay_type=?,vendor_id=?");
	$prepare->execute(array($repare_date_booking, $repare_time_slot, $venProname->service_type, $firstname, $lastname, $advance_payment, $user_email, $contact, $pro, $venProname->d_price, $user_pin_code, $user_address, $pay_type,$post['vend_id']));
	$lastid = $this->con->lastInsertId();
	$is_execute = 1;
	    
	if ($is_execute === 1) {
	    $mail = $this->sendEmail($lastid);
	    $mailString = "";
	    if (!$mail) {
		$mailString = " and something went wrong with mail";
	    }
//            $baseurl = BASEURL;
	    return $lastid;
	} else {

	    $this->add("<div class='query'><div class='query-success'>Something went wrong <a href='$baseurl'>X</a></div></div>");
	    return $lastid;
	}

    }

    public function insertIntoGuest($post) {
	
	$pro = $this->encrypt_decrypt("decrypt", $post["pro_id"]);
	$pro = $this->encrypt_decrypt("decrypt", $pro);
	$proname = $this->getProductById($pro);
	$firstname = addslashes($post["firstname"]);
	$lastname = addslashes($post["lastname"]);
	$user_email = filter_var($post["user_email"], FILTER_SANITIZE_EMAIL);
	$contact = addslashes($post["contact"]);
	$country = addslashes($post['country']);
	$pay_type = addslashes($post["payment_type"]);
	$type = $proname->service_type;
	$first = "";
	$second = "";
	$third = "";
//repare booking
	$repare_date_booking = isset($post["repare_date_booking"]) ? $post["repare_date_booking"] : "";
	$repare_time_slot = isset($post["repare_time_slot"]) ? $post["repare_time_slot"] : "";

//cab  
	$tripstartdate = isset($post["tripstartdate"]) ? $post["tripstartdate"] : "";
	$cab_pick_time = isset($post["cab_pick_time"]) ? $post["cab_pick_time"] : "";
	$trip_closing_date = isset($post["trip_closing_date"]) ? $post["trip_closing_date"] : "";

//professional
	$preffered_mode = isset($post["preffered_mode"]) ? $post["preffered_mode"] : "";
	$appoint_date = isset($post["appoint_date"]) ? $post["appoint_date"] : "";
	$prof_time_slot = isset($post["prof_time_slot"]) ? $post["prof_time_slot"] : "";


//        $state = addslashes($post["state"]);
//        $user_city = addslashes($post["user_city"]);
	$user_pin_code = addslashes($post["user_pin_code"]);
	$user_address = addslashes($post["user_address"]);
	$is_execute = 0;
	$lastid = 0;
	$advance_payment = round((floatval($proname->dis_price) * floatval($proname->percentage) / 100), 2);
	if ($proname->service_type == "cab") {
	    $prepare = $this->con->prepare("insert into tbl_guest_booking set trip_start=?,pick_time=?,close_date=?,type=?,fname=?,lname=?,advance_price=?,email=?,contact=?,country=?,product_id=?,pro_price=?,zip=?,address=?,pay_type=?");
	    $prepare->execute(array($tripstartdate, $cab_pick_time, $trip_closing_date, $proname->service_type, $firstname, $lastname, $advance_payment, $user_email, $contact, $country, $proname->ID, $proname->dis_price, $user_pin_code, $user_address, $pay_type));
	    $lastid = $this->con->lastInsertId();
	    $is_execute = 1;
	} elseif ($proname->service_type == "prof") {
	    $prepare = $this->con->prepare("insert into tbl_guest_booking set preffered_mode=?,dateofappoint=?,time_slot=?,type=?,fname=?,lname=?,advance_price=?,email=?,contact=?,country=?,product_id=?,pro_price=?,zip=?,address=?,pay_type=?");
	    $prepare->execute(array($preffered_mode, $appoint_date, $prof_time_slot, $proname->service_type, $firstname, $lastname, $advance_payment, $user_email, $contact, $country, $proname->ID, $proname->dis_price, $user_pin_code, $user_address, $pay_type));
	    $lastid = $this->con->lastInsertId();
	    $is_execute = 1;
	} else {
	    $prepare = $this->con->prepare("insert into tbl_guest_booking set date_of_booking=?,repair_time_slot=?,type=?,fname=?,lname=?,advance_price=?,email=?,contact=?,country=?,product_id=?,pro_price=?,zip=?,address=?,pay_type=?");
	    $prepare->execute(array($repare_date_booking, $repare_time_slot, $proname->service_type, $firstname, $lastname, $advance_payment, $user_email, $contact, $country, $proname->ID, $proname->dis_price, $user_pin_code, $user_address, $pay_type));
	    $lastid = $this->con->lastInsertId();
	    $is_execute = 1;
	}
	if ($is_execute === 1) {
	    $mail = $this->sendEmail($lastid);
	    $mail2 = $this->sendUserEmail($lastid);
	    
	    $mailString = "";
	    if (!$mail) {
		$mailString = " and something went wrong with mail";
	    }
//            $baseurl = BASEURL;
	    return $lastid;
	} else {

	    $this->add("<div class='query'><div class='query-success'>Something went wrong <a href='$baseurl'>X</a></div></div>");
	    return $lastid;
	}

//        $base = BASEURL;
//        $proid = $this->encrypt_decrypt("decrypt", $post["pro_id"]);
//        header("Location:{$base}booking.php?pro={$proid}");
    }

    public function updateGuestQuery($data) {
	$prepare = $this->con->prepare("update tbl_guest_booking set pay_sta=? where id=?");
	$prepare->execute(array(1, $data));
    }

    public function getGuestQuery($id) {
	$prepare = $this->con->prepare("select * from tbl_guest_booking JOIN tbl_product on tbl_product.id=tbl_guest_booking.product_id where tbl_guest_booking.id=?");
	$prepare->execute(array($id));
	return $prepare->fetch();
    }

    public static function render() {
	if (!isset($_SESSION['messages'])) {
	    return null;
	}
	$messages = $_SESSION['messages'];
	unset($_SESSION['messages']);
	return implode('<br/>', $messages);
    }

    public static function add($message) {
	if (!isset($_SESSION['messages'])) {
	    $_SESSION['messages'] = array();
	}
	$_SESSION['messages'][] = $message;
    }

    private function sendEmail($ID) {

	$data = $this->getGuestQuery($ID);
	
	$date1 = date_create($data->trip_start);
	$date2 = date_create($data->close_date);
	$diff = date_diff($date1, $date2);
	$totalDiff = $diff->d + 1;
	$totalAmount = $data->pro_price * $totalDiff;
	
	$to = 'booking@bizaad.com';
	$subject = "Online Booking Query" . " -" . time();
	$message = '<html><body>';
	$message .= " <br> Online Booking Query<br><br>";
	$service = $data->type == "prof" ? "Professional" : ($data->type == "repair" ? "Repair and Maintenance" : ($data->type == "cab" ? "Cab Booking" : ""));
	$message .= '<table rules="all" style="border-color: #666;" cellpadding="10" cellspacing="10" border="1">';
	$message .= "<tr style='background: #eee;'><td><strong>Contact Number</strong> </td><td>" . "$data->contact" . "</td></tr>";
	$message .= "<tr style='background: #eee;'><td><strong>First Name</strong> </td><td>" . "$data->fname" . "</td></tr>";
	$message .= "<tr style='background: #eee;'><td><strong> Last Name</strong> </td><td>" . "$data->lname " . "</td></tr>";
	$message .= "<tr style='background: #eee;'><td><strong> Email </strong> </td><td>" . "$data->email " . "</td></tr>";
	$message .= "<tr style='background: #eee;'><td><strong> Product Name </strong> </td><td>" . "$data->pro_name " . "</td></tr>";
	$message .= "<tr style='background: #eee;'><td><strong> Qty </strong> </td><td>1</td></tr>";
	$message .= "<tr style='background: #eee;'><td><strong> Total Price </strong> </td><td>$totalAmount</td></tr>";
	$message .= "<tr style='background: #eee;'><td><strong> Service Type </strong> </td><td>$service</td></tr>";

	if ($data->type == "cab") {
	    $message .= "<tr style='background: #eee;'><td><strong> Trip Start Date </strong> </td><td>$data->trip_start</td></tr>";
	    $message .= "<tr style='background: #eee;'><td><strong> Pick Time </strong> </td><td>$data->pick_time</td></tr>";
	    $message .= "<tr style='background: #eee;'><td><strong> Drop Date </strong> </td><td>$data->close_date</td></tr>";
	} elseif ($data->type == "repair") {
	    $message .= "<tr style='background: #eee;'><td><strong> Repair Date</strong> </td><td>$data->date_of_booking</td></tr>";
	    $message .= "<tr style='background: #eee;'><td><strong> Repair Time</strong> </td><td>$data->repair_time_slot</td></tr>";
	} else {
	    $message .= "<tr style='background: #eee;'><td><strong> Preffered Mode</strong> </td><td>$data->preffered_mode</td></tr>";
	    $message .= "<tr style='background: #eee;'><td><strong> Date </strong> </td><td>$data->dateofappoint</td></tr>";
	    $message .= "<tr style='background: #eee;'><td><strong> Date </strong> </td><td>$data->time_slot</td></tr>";
	}
	$message .= "</table><br><br>";
	$message .= "</body></html>";
	
	$name = $data->fname . " " . $data->lname;
	$email_from = $name . '<' . $data->email . '>';
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=windows-1254" . "\r\n";
	$headers .= 'From: ' . $data->email . "\r\n";
	$headers .= 'Reply-To: ' . $data->email . "\r\n";
	$headers .= 'Bcc: nibbleppc@gmail.com' . "\r\n";
	if (mail($to, $subject, $message, $headers)) {
	    return 1;
	} else {
	    return 0;
	}
    }
    private function sendUserEmail($ID) {

	$data = $this->getGuestQuery($ID);
	$to = $data->email;
	
	$url = preg_replace("/ /", "%20", "https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey=5sg71ubRqE66B43G8aNquQ&senderid=SMSTST&channel=2&DCS=0&flashsms=0&number=91$data->contact&text=We have received your booking, Our executive will contact you soon.Thanks for booking Bizaad.com");
	$json = file_get_contents($url);
	$result = json_decode($json);
	
		
	$date1 = date_create($data->trip_start);
	$date2 = date_create($data->close_date);
	$diff = date_diff($date1, $date2);
	$totalDiff = $diff->d + 1;
	$totalAmount = $data->pro_price * $totalDiff;
	
	$subject = "Online Booking Query" . " -" . time();
	$message = '<html><body>';
	$message.="<p>Dear " . ucfirst($data->fname) .' '.ucfirst($data->lname). ",</p>";
	$message.="<p>Greetings from Bizaad . Please find your order details below.</p>";
	$service = $data->type == "prof" ? "Professional" : ($data->type == "repair" ? "Repair and Maintenance" : ($data->type == "cab" ? "Cab Booking" : ""));
	$message .= '<table rules="all" style="border-color: #666;" cellpadding="10" cellspacing="10" border="1">';
	$message .= "<tr style='background: #eee;'><td><strong>Contact Number</strong> </td><td>" . "$data->contact" . "</td></tr>";
	$message .= "<tr style='background: #eee;'><td><strong>First Name</strong> </td><td>" . "$data->fname" . "</td></tr>";
	$message .= "<tr style='background: #eee;'><td><strong> Last Name</strong> </td><td>" . "$data->lname " . "</td></tr>";
	$message .= "<tr style='background: #eee;'><td><strong> Email </strong> </td><td>" . "$data->email " . "</td></tr>";
	$message .= "<tr style='background: #eee;'><td><strong> Product Name </strong> </td><td>" . "$data->pro_name " . "</td></tr>";
	$message .= "<tr style='background: #eee;'><td><strong> Qty </strong> </td><td>1</td></tr>";
	$message .= "<tr style='background: #eee;'><td><strong> Total Price </strong> </td><td> $totalAmount </td></tr>";
	$message .= "<tr style='background: #eee;'><td><strong> Service Type </strong> </td><td>$service</td></tr>";

	if ($data->type == "cab") {
	    $message .= "<tr style='background: #eee;'><td><strong> Trip Start Date </strong> </td><td>$data->trip_start</td></tr>";
	    $message .= "<tr style='background: #eee;'><td><strong> Pick Time </strong> </td><td>$data->pick_time</td></tr>";
	    $message .= "<tr style='background: #eee;'><td><strong> Drop Date </strong> </td><td>$data->close_date</td></tr>";
	} elseif ($data->type == "repair") {
	    $message .= "<tr style='background: #eee;'><td><strong> Repair Date</strong> </td><td>$data->date_of_booking</td></tr>";
	    $message .= "<tr style='background: #eee;'><td><strong> Repair Time</strong> </td><td>$data->repair_time_slot</td></tr>";
	} else {
	    $message .= "<tr style='background: #eee;'><td><strong> Preffered Mode</strong> </td><td>$data->preffered_mode</td></tr>";
	    $message .= "<tr style='background: #eee;'><td><strong> Date </strong> </td><td>$data->dateofappoint</td></tr>";
	    $message .= "<tr style='background: #eee;'><td><strong> Date </strong> </td><td>$data->time_slot</td></tr>";
	}
	$message .= "</table><br><br>";
	$message .= "</body></html>";
	
	$name = $data->fname . " " . $data->lname;
	$email_from = $name . '<' . $data->email . '>';
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=windows-1254" . "\r\n";
	$headers .= 'From: ' . $data->email . "\r\n";
	$headers .= 'Reply-To: ' . $data->email . "\r\n";
	$headers .= 'Bcc: nibbleppc@gmail.com' . "\r\n";
	if (mail($to, $subject, $message, $headers)) {
	    return 1;
	} else {
	    return 0;
	}
    }

    public function updateOTP($requestID) {
	$prepare1 = $this->con->prepare("select * from tbl_user_reg where id=?");
	$prepare1->execute(array(base64_decode($requestID)));


	$preotp = $this->con->prepare("update tbl_user_reg set mobile_otp=? where id=?");
	$otp = rand(9999, 9999999);

	$preotp->execute(array($otp, base64_decode($requestID)));
	return $prepare1->fetch();
    }

    public function getFirstImageOfPro($pro) {
	$prepare = $this->con->prepare("select * from tbl_pro_img where pro_id=? Limit 0,1");
	$preapre = $prepare->execute(array($pro));
	return $prepare->fetch();
    }

    public function getAllImageOfPro($pro) {
	$prepare = $this->con->prepare("select * from tbl_pro_img where pro_id=?");
	$preapre = $prepare->execute(array($pro));
	return $prepare->fetchAll();
    }

    public function getOneTimePassword($id) {

	if ((int) $this->encrypt_decrypt("decrypt", $id) != 0) {

	    return $this->getRegistrationInfo($this->encrypt_decrypt("decrypt", $id));
	} else {
	    die("invalid url");
	}
    }

    public function getRegistrationInfo($id) {

	$prepare = $this->con->prepare("select * from tbl_user_reg where id=?");
	$prepare->execute(array($id));
	return $rs = $prepare->fetch();
    }

    public function getUserByEmail($email) {
	$prepare = $this->con->prepare("select * from tbl_user_reg where email=?");
	$prepare->execute(array($email));

	return $rs = $prepare->fetchAll();
    }

    public function registration($arr) {


	$first_name = filter_var($arr["firstname"], FILTER_SANITIZE_STRING);
	$last_name = filter_var($arr["lastname"], FILTER_SANITIZE_STRING);
	$user_email = filter_var($arr["email"], FILTER_SANITIZE_EMAIL);
	$telephone = filter_var($arr["telephone"], FILTER_SANITIZE_NUMBER_INT);
	$password = $arr["password"];
	$confirm_password = $arr["confirm_password"];


	if ($password == $confirm_password) {
	    $password = password_hash($password, PASSWORD_BCRYPT);
	} else {
	    $this->add("<div class='alert alert-danger'>Password mismatch</div>");
	}
	$otp = rand(9999, 9999999);
	$data = $this->getUserByEmail($user_email);
	if (count($data) == 0) {
	    $prepare = $this->con->prepare("insert into tbl_user_reg  set firstname=?,lastname=?,telephone=?,email=?,password=?,pass=?,mobile_otp=?");
	    $prepare->execute(array($first_name, $last_name, $telephone, $user_email, $password, $confirm_password, $otp));
	} else {

	    echo "<script type='text/javascript'>alert('Email already exist');</script>";
	    echo '<script type="text/javascript">window.location.href="signup.php"</script>';
	    exit();
	}
	$id = $this->con->lastInsertId();
	$id = $this->encrypt_decrypt("encrypt", $id);
	$url = preg_replace("/ /", "%20", "https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey=5sg71ubRqE66B43G8aNquQ&senderid=SMSTST&channel=2&DCS=0&flashsms=0&number=91$telephone&text=Welcome to bizaad.com.You have initiated signup process ,please enter following OTP on verifcation page,Your OTP is $otp");
	$json = file_get_contents($url);


	$result = json_decode($json);
	if ($result->ErrorCode == '000') {
	    echo "<script>window.location.href='signup.php?otp=yes&requested_id=$id'; </script>";
	} else {
	    print_r($json);
	}
    }
    public function zeya_otp($id){
	return $en_id = $this->encrypt_decrypt("encrypt", $id);
    } 

    public function getUserInvoice($id) {
	
	$prepare = $this->con->prepare("select *,tbl_customer_order.vendor_id as ven_id, tbl_order.id as or_id,tbl_user_invoice.id as invoiceid,tbl_product.gst as gst_per,tbl_signups.state as ven_state,tbl_customer_order.state as cus_state from tbl_order JOIN tbl_customer_order on tbl_customer_order.id=tbl_order.order_id JOIN tbl_user_invoice on tbl_user_invoice.order_id=tbl_customer_order.id JOIN tbl_product on tbl_product.id=tbl_order.pro_id JOIN tbl_signups on tbl_signups.id=tbl_product.vendor_id JOIN tbl_subcategory on tbl_subcategory.id=tbl_product.sub_id where tbl_customer_order.id=? and tbl_customer_order.pay_sta=?");
	$prepare->execute(array($id, 1));
	return $rs = $prepare->fetchAll();
    }
    
    public function numberTowords($num) {
        $ones = array(
            1 => "one",
            2 => "two",
            3 => "three",
            4 => "four",
            5 => "five",
            6 => "six",
            7 => "seven",
            8 => "eight",
            9 => "nine",
            10 => "ten",
            11 => "eleven",
            12 => "twelve",
            13 => "thirteen",
            14 => "fourteen",
            15 => "fifteen",
            16 => "sixteen",
            17 => "seventeen",
            18 => "eighteen",
            19 => "nineteen"
        );
        $tens = array(
            1 => "ten",
            2 => "twenty",
            3 => "thirty",
            4 => "forty",
            5 => "fifty",
            6 => "sixty",
            7 => "seventy",
            8 => "eighty",
            9 => "ninety"
        );
        $hundreds = array(
            "hundred",
            "thousand",
            "million",
            "billion",
            "trillion",
            "quadrillion"
        ); //limit t quadrillion 
        $num = number_format($num, 2, ".", ",");
        $num_arr = explode(".", $num);
        $wholenum = $num_arr[0];
        $decnum = $num_arr[1];
        $whole_arr = array_reverse(explode(",", $wholenum));
        krsort($whole_arr);
        $rettxt = "";
	if(isset($whole_arr)){
	    foreach ($whole_arr as $key => $i) {		
            if ($i < 20) {
                $rettxt .= $ones[$i];
            } elseif ($i < 100) {
                $rettxt .= $tens[substr($i, 0, 1)];
                $rettxt .= " " . $ones[substr($i, 1, 1)];
            } else {
                $rettxt .= $ones[substr($i, 0, 1)] . " " . $hundreds[0];
                $rettxt .= " " . $tens[substr($i, 1, 1)];
                $rettxt .= " " . $ones[substr($i, 2, 1)];
            }
            if ($key > 0) {
                $rettxt .= " " . $hundreds[$key] . " ";
            }
        } 
	}
       
        if ($decnum > 0) {
            $rettxt .= " and ";
            if ($decnum < 20) {
                $rettxt .= $ones[$decnum];
            } elseif ($decnum < 100) {
                $rettxt .= $tens[substr($decnum, 0, 1)];
                $rettxt .= " " . $ones[substr($decnum, 1, 1)];
            }
        }
        return $rettxt;
    }
    
    public function vendorAssignedProd($pro_id){
	$prepare = $this->con->prepare("select *, tbl_vendor_order.id as sid,fname,lname,dis_price,aboutUs  from tbl_vendor_order JOIN tbl_signups on tbl_vendor_order.vendor_id=tbl_signups.id where tbl_vendor_order.prod_id=?");
	$prepare->execute(array($pro_id));
	return $prepare->fetchAll();
	
    }
    
    public function getVendorProductById($ven_id){
		
	$pre = $this->con->prepare('select *,tbl_vendor_order.dis_price as d_price,tbl_vendor_order.vendor_id as ven_id from tbl_vendor_order join tbl_product on tbl_vendor_order.prod_id=tbl_product.id join tbl_subcategory on tbl_subcategory.id=tbl_product.sub_id where tbl_vendor_order.id=?');
	$pre->execute(array($ven_id));
	return $pre->fetchAll()[0];
	}
    public function getVendorAssignProduct($ven_id,$pro_id){	
	$pre = $this->con->prepare('select *,tbl_vendor_order.dis_price as d_price,tbl_vendor_order.act_price as a_price from tbl_vendor_order join tbl_product on tbl_vendor_order.prod_id=tbl_product.id join tbl_subcategory on tbl_subcategory.id=tbl_product.sub_id join tbl_signups on tbl_signups.id=tbl_vendor_order.vendor_id where tbl_vendor_order.vendor_id=? and tbl_vendor_order.prod_id=?');
	$pre->execute(array($ven_id,$pro_id));
	return $pre->fetchAll()[0];
	}
    public function getVendorProductSpec($pro_id,$sid){
	$pre = $this->con->prepare('select *,tbl_vendor_order.dis_price as d_price from tbl_vendor_order join tbl_product on tbl_vendor_order.prod_id=tbl_product.id JOIN tbl_categories on tbl_categories.id=tbl_product.cat_id join tbl_subcategory on tbl_subcategory.id=tbl_product.sub_id where tbl_vendor_order.prod_id=? and tbl_vendor_order.id=?');
	$pre->execute(array($pro_id,$sid));
	return $pre->fetchAll()[0];
	}
    public function getUserOrders(){
	$pre = $this->con->prepare('select * from tbl_customer_order join tbl_order on tbl_customer_order.id=tbl_order.order_id where tbl_customer_order.registered_user=? and tbl_customer_order.pay_sta=?');
	$pre->execute(array($_SESSION["userid"],1));
	return $pre->fetchAll();
    }
    public function getUserOrders2($cid){
	$pre = $this->con->prepare('select * from tbl_customer_order join tbl_order on tbl_customer_order.id=tbl_order.order_id join tbl_vendor_order on  where tbl_customer_order.registered_user=? and tbl_order.order_id=?');
	$pre->execute(array($_SESSION["userid"],$cid));
	return $pre->fetchAll();
    }
    public function getVendor($id){
	$pre = $this->con->prepare('select * from tbl_signups where id=?');
	$pre->execute(array($id));
	return $pre->fetchAll()[0];
    }
    public function insertReview($post){
	$qry = $this->con->prepare("INSERT INTO tbl_review (pro_id,username,useremail,review,msg,vend_id) VALUES (?,?,?,?,?,?)");
	return $qry->execute([$post['pro'],$post['name'],$post['email'],$post['rating'],$post['message'],$post['ven']]);
	
    }
    public function getReview($prod){
	$pre = $this->con->prepare('select * from tbl_review where pro_id=?');
	$pre->execute([$prod]);
	return $pre->fetchAll();
    }
    public function getReviewVendorwise($ven,$prod){		
	$pre = $this->con->prepare('select * from tbl_review where pro_id=? and vend_id=?');
	$pre->execute([$prod,$ven]);
	return $pre->fetchAll();
    }
    public function reviewInfo($email,$pro){
	$pre = $this->con->prepare('select * from tbl_review where useremail=? and pro_id=?');
	$pre->execute(array($email,$pro));
	if(count($pre->fetchAll()) > 0){
	    return TRUE;
	}else{
	    return FALSE; 
	}	
    }

}
