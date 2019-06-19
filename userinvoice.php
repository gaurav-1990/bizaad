<?php error_reporting(0); ?>
<html>
    <head>
        <title>Invoice generated</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php
	include_once("includes/pdo.php");	
	spl_autoload_register(function ($class_name) {
	    include "includes/" . $class_name . '.php';
	});
	include_once("includes/Functions.php");
	$sign = new Functions($pdo);
	$data2 = $sign->getUserInvoice($sign->encrypt_decrypt("decrypt", $_GET["id"]));
	$data3 = $data2[0];
	foreach ($data2 as $key => $data) {
	  
	}
	?>

	<style type="text/css">
	    #invoice{
		border: #000 1px solid;
		width: 100%;
	    }

	    .invoice {
		position: relative;
		background-color: #FFF;
		min-height: 680px;
		padding: 15px;
	    }

	    .invoice header {
/*		padding: 10px 0;*/
/*		margin-bottom: 5px;*/
		overflow: hidden;
	    }
	    .invoice header .inv-logo{
		width: 20%;
		float: left;
	    }

	    .invoice header .company-details {
		text-align: right;
		width: 23%;
		float: right;
	    }

	    .invoice .company-details .name {
		margin-top: 0;
		margin-bottom: 10px;
		font-size: 23px;
	    }

	    .invoice .company-details .gst-no {

	    }
	    .invoice .company-details .gst-no span{

	    }

	    .invoice .contacts {
		margin-bottom: 20px
	    }

	    .invoice .bill-set {
		overflow: hidden;
	    }

	    .invoice .bill-set .invoice-to {
		float: left;
		width: 33%;
		border: #000 1px solid;
		padding: 5px 14px;
	    }
	    .invoice .bill-set .invoice-to .bill-name{
		font-size: 19px;
		font-weight: 600;
		margin-bottom: 10px;
		color: #3e3e3e;
	    }
	    .invoice .bill-set .invoice-to .bill-name span{
		font-size: 19px;
		font-weight: 100;
		color: #1e77b6;
	    }
	    .invoice .bill-set .invoice-to .address{
		border-bottom: #000 1px solid;
		margin-bottom: 15px;
	    }
	    .invoice .bill-set .invoice-to .state{

	    }
	    .invoice .bill-set .invoice-to .state span{
		border-bottom: #000 1px solid;
		display: inline-block;
		width: 75px;
		text-align: center;
		margin-right: 23px;
	    }

	    .invoice .bill-set .invoice-to .to {
		margin-top: 0;
		margin-bottom: 0
	    }

	    .invoice .bill-set .invoice-details {
		/* text-align: right; */
		float: right;
		width: 33%;
		/* width: 264px; */
		border: #000 1px solid;
		padding: 5px 14px;
	    }

	    .invoice .bill-set .invoice-details .bill-name{
		font-size: 19px;
		font-weight: 600;
		margin-bottom: 10px;
		color: #3e3e3e;
	    }
	    .invoice .bill-set .invoice-details .bill-name span{
		font-size: 19px;
		font-weight: 100;
		color: #1e77b6;
	    }
	    .invoice .bill-set .invoice-details .address{
		border-bottom: #000 1px solid;
		margin-bottom: 15px;
	    }
	    .invoice .bill-set .invoice-details.state{

	    }
	    .invoice .bill-set .invoice-details .state span{
		border-bottom: #000 1px solid;
		display: inline-block;
		width: 75px;
		text-align: center;
		margin-right: 23px;
	    }
	    .invoice .despatch {
		overflow: hidden;
	    }
	    .invoice .despatch .despatch-in {
		float: right;
		width: 35%;
	    }
	    .invoice .despatch .despatch-in p{

	    }
	    .invoice .despatch .despatch-in p span{

	    }
	    .invoice .invoice-details .invoice-id {
		margin-top: 0;
		color: #3989c6
	    }

	    .invoice main {
		padding-bottom: 0px;
	    }

	    .invoice main .thanks {
		margin-top: -100px;
		font-size: 2em;
		margin-bottom: 50px
	    }

	    .invoice main .notices {
		padding-left: 6px;

	    }
	    .invoice main .notices p{
		font-weight: 600;
		color: #575353;
		font-size: 20px;
	    }
	    .invoice main .notices p span{font-weight: 100;}

	    .invoice main .notices .notice {
		font-size: 1.2em
	    }
	    .invoice .tab-block {}
	    .invoice .tab-block table {
		width: 100%;
		border-collapse: collapse;
		border-spacing: 0;
		margin-bottom: 20px
	    }

	    .invoice .tab-block table td,.invoice table th {
		padding: 10px;
		border: 1px solid #c2c2c2;
	    }

	    .invoice .tab-block table th {
		white-space: nowrap;
		font-weight: 400;
		font-size: 16px
	    }

	    .invoice .tab-block table td h3 {
		margin: 0;
		font-weight: 400;
		color: #3989c6;
		font-size: 1.2em
	    }

	    .invoice .tab-block table .qty,.invoice table .total,.invoice table .unit {
		text-align: right;
		font-size: 1.2em
	    }

	    .invoice .tab-block table .no {
		color: #b82525;
		font-size: 18px;
	    }




	    .invoice footer {
		width: 100%;
		text-align: center;
		color: #777;
		border-top: 1px solid #aaa;
		padding: 8px 0
	    }

	    .invoice .value{}
	    .invoice .value p{
		font-size: 22px;
	    }
	    .invoice .value p span{
		font-size: 18px;
		border-bottom: #000 1px solid;
		width: 66%;
		display: inline-block;
		margin-left: 41px;
	    }

	    .invoice .number-block {
		overflow: hidden;
		margin-top: 12px;
	    }
	    .invoice .number-left {
		float: left;
	    }
	    .invoice .number-left a{
		display: block;
		color: #000;
		text-decoration: none;
		text-align: left;
		font-size: 19px;
	    }
	    .invoice .number-right {
		float: right;
	    }
	    .invoice .number-right a{
		display: block;
		color: #000;
		text-decoration: none;
		text-align: left;
		font-size: 19px;
	    }
	    @media print {


		.no-print, .no-print *
		{
		    display: none !important;
		}
		table{
		    width: 100%;
		}

		table > thead > tr > th  {
		    font-weight: bold;
		    -webkit-print-color-adjust: exact; 

		}


	    }
	</style>
    </head>
    <body>

	<div id="invoice">
	    <div class="invoice overflow-auto">
		<div style="min-width: 600px">
		    <header>
			<div style="text-align: center;">
			    <button class="btn btn-dark"  onclick="window.print();">Print</button>
			</div>

			<div class="inv-logo">
			    <a target="_blank" href="#">

				<img src="img/logo/logo.png" style="width: 85%;" alt=""/>
			    </a>
			    <p>
				Techwow Systems Pvt Ltd.</br> 2162 / T14, Patel Road, Patel Nagar New Delhi - 110008
			    </p>
			</div>
			<div class=" company-details">
			    <h2 class="name">

				GSTIN  : <small>07AAGCT9628N1ZK</small>

			    </h2>

			    <div class="gst-no">ORDER NO.: <span><?= $data3->order_id ?></span></div>
			    <div class="gst-no">INVOICE NO.: <span><?= $data3->invoiceid ?></span></div>
			    <div class="gst-no">INVOICE DATE : <span><?= date("d/m/Y"); ?></span></div>
			</div>

		    </header>
		    <main>
			<div class=" contacts bill-set">
			    <div class=" invoice-to">
				<div class="bill-name">BILL TO: <span><?= ucfirst($data->first_name) ?> <?= ucfirst($data->last_name) ?></span></div>
				<div class="address"><?= ucfirst($data->user_address) ?>, <?= ucfirst($data->cus_state) ?></div>
				<span class="state">
				    <a >State</a> <span><?= ucfirst($data->cus_state) ?></span>
				</span>
				<span class="state">
				    <a >Pin</a> <span><?= ucfirst($data->user_pin_code) ?></span>
				</span>
			    </div>
			    <?php
			       
			       if(isset($data->ven_id) && $data->ven_id !=''){
				   $getVendor=$sign->getVendor($data->ven_id);
				    ?>
			    <div class="invoice-details">
				<div class="bill-name">SHIP FROM: <span><?= ucfirst($getVendor->fname) ?> <?= ucfirst($getVendor->lname) ?></span></div>

				<div class="address"><?= ucfirst($getVendor->address) ?>, <?= ucfirst($getVendor->state) ?></div>
				<span class="state">
				    <a >State</a> <span><?= ucfirst($getVendor->state) ?></span>
				</span>
				<span class="state">
				    <a >Pin</a> <span><?= ucfirst($getVendor->zip) ?></span>
				</span>
			    </div>
			    <?php
			       }else{
				   ?>
			    <div class="invoice-details">
				<div class="bill-name">SHIP TO: <span><?= ucfirst($data->first_name) ?> <?= ucfirst($data->last_name) ?></span></div>

				<div class="address"><?= ucfirst($data->user_address) ?>, <?= ucfirst($data->cus_state) ?></div>
				<span class="state">
				    <a >State</a> <span><?= ucfirst($data->cus_state) ?></span>
				</span>
				<span class="state">
				    <a >Pin</a> <span><?= ucfirst($data->user_pin_code) ?></span>
				</span>
			    </div>
			    <?php
				   
			       }
			    ?>
			    
			</div>


			<div class="tab-block">
			    <table border="0" style="border-collapse: collapse;width: 100%" cellspacing="0" cellpadding="0">

				<thead>
				    <tr>
					<th>S.NO</th>
					<th class="text-left">PRODUCT DESCRIPTION</th>
					<th class="text-right">HSN CODE</th>
					<th class="text-right">QTY</th>
					<th class="text-right">BASIC PRICE / UNIT</th>
					<th class="text-right">TAXABLE VALUE</th>
					<th class="text-right">C.G.S.T</th>
					<th class="text-right">S.G.S.T</th>
					<th class="text-right">I.G.S.T</th>
					<th class="text-right">AMOUNT</th>
				    </tr>
				</thead>

				<tbody>
				    <?php
				    $count = 1;
				    $grand = 0.0;
				    $total = 0.0;
				    foreach ($data2 as $in) {
					
					 $getVendorInfo=$sign->getVendorAssignProduct($in->ven_id,$in->pro_id);
					
					if($in->ven_id !=''){	
					$grand = (floatval($getVendorInfo->d_price) * floatval($in->pro_qty));
					$total = $total + $grand;
					}else{
					    $grand = (floatval($in->dis_price) * floatval($in->pro_qty));
					    $total = $total + $grand;
					}
					?>
    				    <tr>
    					<td class="no"><?= $count ?></td>
    					<td class="text-left">
    					    <h3>
						    <?= $in->pro_name ?>
    					    </h3>
    					</td>
    					<td class="unit"><?= $in->hsn_code ?></td>
    					<td class="qty"><?= $in->pro_qty ?></td>
					<?php if($in->ven_id !=''){ ?>
    					<td class="total"><?= number_format($getVendorInfo->d_price, 2, '.', ''); ?></td>
					<?php }else { ?>
					 <td class="total"><?= number_format($in->dis_price, 2, '.', ''); ?></td> 
					<?php } ?>
					    <?php
					    $taxable = (($grand * 100) / ((100) + floatval($in->gst_per)));
					    ?>
    					<td class="unit"><?= number_format($taxable, 2, '.', ''); ?></td>
    					<td class="qty"><?php echo number_format(((floatval($grand) - floatval($taxable)) / 2), 2, '.', ''); ?></td>
    					<td class="total"><?php echo number_format(((floatval($grand) - floatval($taxable)) / 2), 2, '.', ''); ?></td>
    					<td class="total">
						<?php
						echo number_format(floatval($grand) - floatval($taxable), 2);
						?>
    					</td>
					<?php if($in->ven_id !=''){ ?>
    					<td class="total"><?= number_format(floatval($getVendorInfo->d_price) * floatval($in->pro_qty), 2); ?></td>
					<?php }else { ?>
					<td class="total"><?= number_format(floatval($in->dis_price) * floatval($in->pro_qty), 2); ?></td>
					<?php } ?>
    				    </tr>
					<?php
					$count++;
				    }
				    ?>


				    <tr>
					<td class="no"></td>
					<td class="text-left"> 

					</td>
					<td class="unit"></td>
					<td class="qty"></td>
					<td class="total"></td>
					<td class="unit"></td>

					<td colspan="3" class="total" style="background:#dbdbdb;">DELIVERY CHARGES</td>
					<td class="total" >0.00</td>
				    </tr>
				    <tr>
					<td class="no"></td>
					<td class="text-left"> 

					</td>
					<td class="unit"></td>
					<td class="qty"></td>
					<td class="total"></td>
					<td class="unit"></td>


					<td colspan="3" class="total" style="background:#dbdbdb;">Total</td>
					<td class="total"><?= number_format($total, 2, '.', '') ?></td>
				    </tr>



				</tbody>

			    </table>
			</div>
			<div class="value">
			    <p>INVOICE VALUE (in words) <span>     <?= ucwords($sign->numberTowords($total)) ?> Only/- </span></p>
                        </div>
                        <div class="notices">
                            <p>NOTICE:  <span >All disputes are subject to Gurugram juridiction</span>
                            </p>
                        </div>
                    </main>
                    <footer>
                        Invoice was created on a computer and is valid without the signature and seal.
                        <div class="number-block">
                            <div class="number-left">
                                <a href="#"><b>email:</b> support@bizaad.com </a>
                                <a href="#"> <b>contact :</b> +91 999-993-4211 </a>
                            </div>
                            <div class="number-right">
                                <a href="#"> <b>Website:</b> www.bizaad.com </a>                               
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>

