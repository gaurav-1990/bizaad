<?php
session_start();
include_once ("includes/header_1.php");
?>


<div class="inner-top-banner" >

</div>

<div class="container">
    <div class="row">
	<div class="contact-set">
	    <div class="col-md-6 contact-detail">
		<h2 >Contact Us</h2>
		<p><strong>Address :</strong> 2162 / T14, Patel Road, Patel Nagar <br>New Delhi - 110008</p>
		<a href="#"><strong>Phone no:</strong> +91 999-993-4211</a>
		<a href="#"><strong>Email:</strong> support@bizaad.com</a>
	    </div>

	    <div class="col-md-6">
	    	<?php if(isset($_SESSION["msg"])){ echo $_SESSION["msg"]; $_SESSION["msg"]=''; }?>
		<div class="contact-form-set">
		    <h2 >Get in Touch</h2>
		    <form id="contacts-form" action="mail.php" method="POST">
			<div class="col-sm-6">
			    <input type="text" name="fname" placeholder="first name*">
			</div>
			<div class="col-sm-6">
			    <input type="text" name="lname" placeholder="last name*">
			</div>
			<div class="col-sm-6">
			    <input type="email" name="email" placeholder="email*">
			</div>
			<div class="col-sm-6">
			    <input type="text" name="sub" placeholder="subject*">
			</div>
			<div class="col-sm-12">
			    <textarea id="message" name="msg" placeholder="message" rows="10" cols="30" name="message"></textarea>
			</div>
			<div class="col-sm-12">
			    <button class="send-email" type="submit" name="send">send email</button>
			</div>

		    </form>
                </div>

	    </div>

	</div>	    
    </div>





</div>
</div>

<?php include_once ("includes/footer.php"); ?>