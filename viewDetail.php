<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once("includes/pdo.php");
include_once ("includes/header_1.php");
include_once("includes/Functions.php");

$sign = new Functions($pdo);
if(isset($_POST['review'])){
    $res = $sign->insertReview($_POST);
    if($res){
	$sign::add('<div class="alert alert-success" role="alert"> Review posted successfully .</div>');
    }else{
	$sign::add('<div class="alert alert-danger" role="alert"> Review posted Faild ! Try again .</div>');
    }
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<div style="margin-top: 66px;" class="pro-info-area ptb-40">
    <div class="container">
        <div class="pro-info-box profile-tab">
	    <?=
	    Functions::render();
	    ?>
            <div >
                <div  id="profile3">
                    <div class="pro-desc">
                        <table class="table-data-sheet">
                            <thead>
                                <tr>
                                    <th>Product name</th>
<!--                                    <th>Actual Price </th>-->
                                    <th>Qty</th>
                                    <th>Pay date</th>
                                    <th>Paid Price</th>				    
                                    <th>Service Type</th>				    
				    <th>Details </th>
				    <th>Product Review </th>
				</tr>
                            </thead>
                            <tbody>
				<?php
				$data2 = $sign->getOrdersDetails($sign->encrypt_decrypt("decrypt", $_GET["id"]));
				//$data2 = $sign->getUserOrders2($sign->encrypt_decrypt("decrypt", $_GET["id"]));
				$getUser = $sign->getRegistrationInfo($_SESSION['userid']);
				$getReview = $sign->reviewInfo($getUser->email,$sign->encrypt_decrypt("decrypt", $_GET["pro"]));
//				    echo '<pre>';
//				    print_r($data2);
//				    echo '</pre>';
				
				foreach ($data2 as $key => $mycc) {
				    
//				    echo '<pre>';
//				    print_r($sign->encrypt_decrypt("decrypt", $_GET["pro"]));
//				    echo '</pre>';

				    $req = unserialize($mycc->order_prop);
				    $responce = $sign->getCate($mycc->cat_id);
				    ?>
    				<tr>
    				    <td><?= $mycc->pro_name ?></td>
    <!--    				    <td><?= $mycc->dis_price ?></td>-->
    				    <td><?= $mycc->pro_qty ?></td>
    				    <td><?= date("d/M/Y", strtotime($mycc->pay_date)) ?></td>
    				    <td><?= $mycc->pro_price ?></td>
    				    <td><?= $responce->service_type ?></td>
    				    <td>
					    <?php if ($responce->service_type == 'prof') { ?>
						<b>Appointment Date : </b>
						<?= $req['appoint_date'][$key] ?>  <br>
						<b>Time Slot : </b>
						<?= $req['prof_time_slot'][$key] ?> <br>
					    <?php } ?>

					    <?php if ($responce->service_type == 'cab') { ?>
						<b>Trip start Date : </b>
						<?= $req['tripstartdate'][$key] ?> <br>
						<b>Pickup Time : </b>
						<?= $req['cab_pick_time'][$key] ?> <br>
						<b>Trip Closing Date : </b>
						<?= $req['trip_closing_date'][$key] ?> <br>
					    <?php } ?>
					    <?php if ($responce->service_type == 'repair') { ?>
						<b>Appointment Date : </b>
						<?= $req['appoint_date'][$key] ?> <br>
						<b>Time Slot : </b>
						<?= $req['prof_time_slot'][$key] ?> 
					    <?php } ?>
    				    </td>
    				    <td>
					<?php if($getReview != 1){ ?>
    					<a data-toggle="modal" href="#myModal2" >Write your review </a>
					<?php } else { ?>
					<p>Review Already Posted. </p>
					<?php } ?>
    					<div class="modal" id="myModal2" style="display: none;" aria-hidden="true">
    					    <div class="modal-dialog">
    						<div class="modal-content">
    						    <div class="modal-header">
    							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    							<h4 class="modal-title">Write your review </h4>
    						    </div><div class="container"></div>
    						    <div class="modal-body">
    							<div class="container">
    							    <div class="row">
    								<div class="col-md-6">
    								    <form class="form-horizontal" action="" method="post">
    									<fieldset>
    									    <div class="form-group">
    										<label class="col-md-3 control-label" for="name">Full Name</label>
    										<div class="col-md-9">
    										    <input id="name" name="name" type="text" required="" autocomplete="off" readonly="" value="<?=$getUser->firstname?> <?=$getUser->lastname?>" class="form-control">
    										</div>
    									    </div>
    									    <div class="form-group">
    										<label class="col-md-3 control-label" for="email">Your E-mail</label>
    										<div class="col-md-9">																			   
    										    <input type="hidden" name="pro" value="<?=$sign->encrypt_decrypt("decrypt", $_GET["pro"])?> ">
    										    <input type="hidden" name="ven" value="<?=$sign->encrypt_decrypt("decrypt", $_GET["ven"])?> ">
    										    <input id="email" name="email" type="text" readonly="" autocomplete="off" required="" value="<?=$getUser->email?>" class="form-control">							
    										</div>
    									    </div>
    									    <div class="form-group">
    										<label class="col-md-3 control-label" for="message">Your message</label>
    										<div class="col-md-9">
    										    <textarea class="form-control" id="message" autocomplete="off" name="message" required="" minlength="10" placeholder="Please enter your feedback here..." rows="5"></textarea>
    										</div>
    									    </div>
    									    <div class="form-group">
    										<label class="col-md-3 control-label" for="rating">Your rating</label>
    										<div class="col-md-9">
    										    <select required="" class="form-control" name="rating" id="rating">
    											<option value="1">1 star</option>
    											<option value="1.5">1.5 star</option>
    											<option value="2">2 star</option>
    											<option value="2.5">2.5 star</option>
    											<option selected="" value="3">3 star</option>
    											<option value="3.5">3.5 star</option>
    											<option value="4">4 star</option>
    											<option value="4.5">4.5 star</option>
    											<option value="5">5 star</option>
    										    </select>
    										</div>
    									    </div>

    									    <div class="form-group">
    										<div class="col-md-9 pull-right">
										    <button type="submit" name="review" class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4">Submit</button>
    										</div>
    									    </div>
    									</fieldset>
    								    </form>
    								</div>
    							    </div>
    							</div>

    						    </div>
    						    <div class="modal-footer">				
    							<!--			      <a href="#" data-dismiss="modal" class="btn">Close</a>-->			     				
    						    </div>
    						</div>
    					    </div>
    					</div>
    				    </td>
    				</tr>
				<?php } ?>
                            </tbody>
                        </table>						
                    </div>
                </div>
            </div>		
        </div>
    </div>
</div>

<?php include_once ("includes/footer.php"); ?>