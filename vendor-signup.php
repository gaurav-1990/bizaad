<?php include_once ("includes/header_1.php"); ?>
<?php
error_reporting(0);
$sign = new Functions($pdo);
if (isset($_POST['opt_submit'])) {

    $key = $sign->encrypt_decrypt("decrypt", $_GET['get']);

    $smtp = $pdo->prepare('SELECT * FROM tbl_signups where mobile_otp=? and id=?');
    $smtp->execute([$_POST['otp'], $key]);
    if ($smtp->rowCount() > 0) {
	$s = $pdo->prepare('update tbl_signups set otp_verify=? where id=?');
	$s->execute([3, $key]);
	 
	Functions:: add('<div class="alert alert-success"> <<<  Registration successfully done. >>> </div>');
	
	 echo "<script>window.location.href='vendor-signup.php'</script>";
    } else {
	Functions:: add('<div class="alert alert-danger"> <<< OTP does not matched ! Try again >>> </div>');
	 
    }
}
if (isset($_POST['register'])) {
    $smtp = $pdo->prepare('SELECT * FROM tbl_signups where emailadd=?');
    $smtp->execute([$_POST['r_email']]);
    if ($smtp->rowCount() > 0) {
	 Functions:: add('<div class="alert alert-danger"> <<< Email already exist ! >>> </div>');
    } else {
	if ($_POST['r_password'] == $_POST['r_c_password']) {
	    $fname = filter_var($_POST["r_f_name"], FILTER_SANITIZE_STRING);
	    $lname = filter_var($_POST["r_l_name"], FILTER_SANITIZE_STRING);
	    $mob = filter_var($_POST["r_phone"], FILTER_SANITIZE_STRING);
	    $email = filter_var($_POST["r_email"], FILTER_SANITIZE_EMAIL);
	    $company = filter_var($_POST["company"], FILTER_SANITIZE_STRING);
	    $state = filter_var($_POST["state"], FILTER_SANITIZE_STRING);
	    $pin = filter_var($_POST["r_zip"], FILTER_SANITIZE_STRING);
	    $city = filter_var($_POST["r_city"], FILTER_SANITIZE_STRING);
	    $about = filter_var($_POST["aboutUs"], FILTER_SANITIZE_STRING);
	    $address1 = filter_var($_POST["address1"], FILTER_SANITIZE_STRING);
	    $address2 = filter_var($_POST["address2"], FILTER_SANITIZE_STRING);

	    $adr = $address1 . ' ' . $address2;
	    $hash = password_hash($_POST['r_password'], PASSWORD_DEFAULT);
	    $otp = rand(9999, 9999999);

	    $qry = $pdo->prepare("INSERT INTO tbl_signups (fname, lname, contactno, emailadd, company, state, passw, address, zip, city, mobile_otp ,aboutUs) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
	    $qry->execute([$fname,$lname,$mob, $email, $company, $state, $hash, $adr, $pin, $city, $otp,$about]);

	    $last_id = $pdo->lastInsertId();
	    $url = preg_replace("/ /", "%20", "https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey=5sg71ubRqE66B43G8aNquQ&senderid=SMSTST&channel=2&DCS=0&flashsms=0&number=91{$_POST['r_phone']}&text=Welcome to bizaad.com.You have initiated signup process ,please enter following OTP on verifcation page,Your OTP is $otp");
	    $json = file_get_contents($url);
	   
	    $key_id = $sign->zeya_otp($last_id);
	    foreach ($_POST['category'] as $cat) {
		$q = $pdo->prepare("INSERT INTO vendor_assigned_category (user_id,cate_id) VALUES (?,?)");
		if ($q->execute([$last_id, $cat])) {
		    echo "<script>window.location.href='vendor-signup.php?otp_process=init&&get=$key_id'</script>";
		} else {
		    Functions:: add('<div class="alert alert-danger"> <<< Registeration Failed ! Try again >>> </div>');
		}
	    }
	} else {
	   
	     Functions:: add('<div class="alert alert-danger"> <<< Password and Confirm Password does not matched ! >>> </div>');
	}
    }
}
?>
<div class="breadcrumb-banner-area ptb-25">
    <div class="container">
	<div class="breadcrumb-text">
	    <div class="breadcrumb-menu">
		<ul>
		    <li><a href="#">home</a></li>
		    <li><span>register</span></li>
		</ul>
	    </div>
	</div>
    </div>
</div>
<div class="page-section form-back section pt-50 pb-70">
    <div class="container">

	    <div class="col-md-8 col-md-offset-2 col-xs-12">
                <h3 style="
    color: #fe4800;
    font-size: 15px;
    padding-bottom: 12px;
    text-align: center;
">Strat online business at Bizzad.com. Sale products and offer your services to customer register today.</h3>
    <div class="row">
		<?php		
		if ( !isset($_GET["otp_process"]) && ($_GET["otp_process"] != "init")) {
		    ?>
    		<div class="login-reg-form">
		    <?= Functions::render(); ?>
    		    <form action="vendor-signup.php" method="POST">

    			<div class="row">

    			    <div class="col-sm-6 col-xs-12 mb-20">
    				<label for="r_f_name">First Name <span class="required">*</span></label>										
    				<input id="r_f_name" name="r_f_name" type="text" placeholder="First Name" required onkeypress="if (!isNaN(this.value + String.fromCharCode(event.keyCode)))
                                                return false;" />
    			    </div>
    			    <div class="col-sm-6 col-xs-12 mb-20">
    				<label for="r_l_name">Last Name <span class="required">*</span></label>									
    				<input id="r_l_name" name="r_l_name" type="text" placeholder="Last Name" required onkeypress="if (!isNaN(this.value + String.fromCharCode(event.keyCode)))
                                                return false;" />
    			    </div>
    			    <div class="col-xs-12 mb-20">
    				<label for="r_c_name">Company Name</label>									
    				<input id="r_c_name" name="company" type="text" placeholder="Company Name"/>
    			    </div>
    			    <div class="col-sm-6 col-xs-12 mb-20">
    				<label for="r_email">Email Address <span class="required">*</span></label>										
    				<input id="r_email" name="r_email" type="email" required placeholder="Email Address "/>
    			    </div>
    			    <div class="col-sm-6 col-xs-12 mb-20">
    				<label for="r_phone">Phone  <span class="required">*</span></label>										
    				<input id="r_phone" name="r_phone" type="text" placeholder="Phone" minlength="10" maxlength="10" required onkeypress="if (isNaN(this.value + String.fromCharCode(event.keyCode)))
                                                return false;"/>
    			    </div>
    			    <div class="col-xs-12 mb-20">
    				<label for="r_country">Country <span class="required">*</span></label>
				<input id="r_country" name="r_country" type="text" value="india" required />
<!--    				<select id="r_country" name="r_country">
    				    <option value="india">india</option>  				    
    				</select>-->
    			    </div>
    			    <div class="col-xs-12 mb-20">
    				<label>Address <span class="required">*</span></label>
    				<input type="text" name="address1" placeholder="Street address" required/>
    			    </div>
    			    <div class="col-xs-12 mb-20">
    				<input type="text" name="address2" placeholder="Apartment, suite, unit etc. (optional)" />
    			    </div>
    			    <div class="col-xs-12 mb-20">
    				<label for="r_city">Town / City <span class="required">*</span></label>
    				<input id="r_city" name="r_city" type="text" placeholder="Town / City " required/>
    			    </div>
    			    <div class="col-sm-6 col-xs-12 mb-20">
    				<label>State / County <span class="required">*</span></label>										
    				<input type="text" name="state"  placeholder="State / County " required/>
    			    </div>
    			    <div class="col-sm-6 col-xs-12 mb-20">
    				<label for="r_zip">Postcode / Zip <span class="required">*</span></label>										
    				<input id="r_zip" type="text" name="r_zip" placeholder="Postcode / Zip" minlength="6" maxlength="6"  required onkeypress="if (isNaN(this.value + String.fromCharCode(event.keyCode)))
                                                return false;"/>
    			    </div>
    			    <div class="col-xs-12 mb-20">
    				<label class="" for="r_password">Account password<span class="required">*</span></label>
    				<input id="r_password" type="password" name="r_password" placeholder="Account password" autocomplete="off" required>
    			    </div>
    			    <div class="col-xs-12 mb-20">
    				<label class="" for="r_c_password">Confirm password<span class="required">*</span></label>
    				<input id="r_c_password" type="password" name="r_c_password" placeholder="Confirm password" autocomplete="off" required>
    			    </div>
			<div class="row">
			    <div class="col-md-6">
				<div class="col-xs-12 mb-20">
    				<label for="category">Select Services <span class="required">*</span></label>
				    <?php
				    include_once('includes/pdo.php');
				    $qry = $pdo->prepare("select * from tbl_categories");
				    $qry->execute();
				    while ($res = $qry->fetch()) {
					?>
					<label><input type="checkbox" name="category[]" value="<?= $res->id ?>"><?= $res->cat_name ?></label>
				    <?php } ?>

    			    </div>
			    </div>
			    <div class="col-md-6">
				<label for="r_zip">About Us </label>	
				<textarea name="aboutUs" rows="4" cols="30" placeholder="write here ..."></textarea>
			    </div>
    			    
			</div>

    			    <div class="col-xs-12 mb-20">
    				<input id="rememberme" type="checkbox" required="">
    				<label for="rememberme">I agree <a href="#">Terms &amp; Condition</a></label>
    			    </div>
    			    <div class="col-xs-12">
    				<input value="register" type="submit" name="register">
    			    </div>
    			</div>
    		    </form>
    		</div>
		    <?php
		} else {
		    ?>
    		<div class="login-reg-form">
    		    <form action="" method="POST">

    			<div class="row">

    			    <div class="col-xs-offset-2 col-sm-5 col-xs-12 mb-20">
    				<label for="otp">Enter OTP <span class="required">*</span></label>										
    				<input id="otp" name="otp" type="text" placeholder="Enter OTP" required onkeypress="if (isNaN(this.value + String.fromCharCode(event.keyCode)))
                                                return false;" />
    			    </div>

    			    <div class="col-xs-offset-2 col-xs-12">
    				<input value="Submit" type="submit" name="opt_submit">
    			    </div>
    			</div>
    		    </form>
    		</div>
		<?php }
		?>
	    </div>
	</div>
    </div>
</div>

<?php include_once ("includes/footer.php"); ?>