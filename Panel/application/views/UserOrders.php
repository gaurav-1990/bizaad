<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<main class="main-container">


    <!-- Page heading -->
    <header class="page-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <ol class="breadcrumb">
                        <li>
                            <i class="icon fa fa-home"></i>
                            <a href="#"> Vendor Requested Products</a>
                        </li>
                        <li class="active"><span>View</span></li>
                    </ol>
                    <div class="page-header">
                        <?= $this->session->flashdata('msg') ?>
                        <?= $this->session->flashdata('insert') ?>
                    </div>
                    <!-- /Page header -->

                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="section">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="panel  panel-white">
                        <div class="panel-body">

                            <div class="table-responsive">
                                <?php if ($this->session->userdata('signupSession')['role'] == 1) { ?>
                                    <a href="<?= base_url('Vendor/VendorInvoice') ?>" class="btn btn-success btn-xs"> Upload Vendor Invoice </a>
                                    <a href="<?= base_url('Vendor/generateVendorInvoice') ?>" class="btn btn-danger btn-xs"> Generate Vendor Invoice </a>
                                <?php } ?>

                                
    <div class="container withmargin">
    <!-- <h6>Search the Records Datewise:</h6> -->
        <?php echo form_open('Vendor/userOrder')?>
        
            <div class="row">
                <div class="form-group col-md-2">
                    <label>FROM</label>
                    <?php echo form_input(['class'=>'form-control','name'=>'from','id'=>'tripstartdate','autocomplete'=>'off','value'=>set_value('from')]);?>
                    <!-- <input type="text" id="tripstartdate" class="form-control" name="from"> -->
                </div>

                <div class="form-group col-md-2">
                    <label>TO</label>
                    <?php echo form_input(['class'=>'form-control','name'=>'to','id'=>'trip_closing_date','autocomplete'=>'off','value'=>set_value('to')]);?>
                    <!-- <input type="text" id="trip_closing_date"  class="form-control" name="to"> -->
                </div>

                <div class="form-group col-md-1 find">
                    <?php echo form_submit(['class'=>'btn btn-success','value'=>'FIND', 'name'=>'find']);?>
                    <!-- <input type="submit" class="form-control btn btn-success" name="submit"> -->
                </div>
            </div>
        <?php echo form_close(); ?>   
    </div>


                                <table id="example" class="table table-bordered table-striped table-nowrap no-mb">
                                    <thead>
                                        <tr>
                                            <th>Order Id</th>
                                            <th>Product Name</th>
                                            <th>Order Qty</th>
                                            <?php
                                            if ($this->session->userdata('signupSession')['role'] == 1) {
                                                ?> 
                                                <th>Vendor Name</th>

                                            <?php } ?>
                                            <th>Purchase Date</th>
                                            <th>Ship To Name</th>
                                            <th>State/City</th>
                                            <th>Billing Address</th>
                                            <th>Paid Total</th>
                                            <th>Amount</th>
                                            <th>Payment Status</th>
                                            <th>Delivery Status</th>
                                            <th>Invoice</th>
                                        </tr>
                                    </thead>
                                    <tbody id="userOrderModule">
                                        <?php
                                        foreach ($results as $res) {
				    
					    $getVendor = getVendorPro($res->ven_id,$res->pro_id);
//					    echo '<pre>';
//					    print_r($res);
//					    echo '</pre';
					   
                                            //   $res->pro_sta==1 == > Pending ;
                                            //   $res->pro_sta==2 == > Waiting For Refund ;
                                            //   $res->pro_sta==3 == > Delivered;
                                            ?>
                                            <tr>

                                                <td>0000<?= $res->OID ?></td>
                                                <td><?= $res->pro_name ?></td>
                                                <td><?= $res->pro_qty ?></td>
                                                <?php
                                                if ($this->session->userdata('signupSession')['role'] == 1) {
						    
                                                    ?> 
						<?php if($res->ven_id !=''){?>
                                                    <td><?= $getVendor->fname .' '. $getVendor->lname?></td>
						 <?php }else{?>
						     <td>Bizaad</td>
						    <?php }?>
                                                <?php } ?>
                                                <td><?= $res->pay_date ?></td>
                                                <td><?= $res->first_name ?> <?= $res->last_name ?></td>
                                                <td><?= $res->state ?> / <?= $res->user_city ?></td>
                                                <td title="<?= $res->user_address ?>"><?= substr($res->user_address, 0, 10) ?></td>
                                                <td><?= floatval($res->pro_price) * floatval($res->pro_qty); ?> </td>
						
						<?php if(isset($res->ven_id) && $res->ven_id !=''){?>
                                                <td><?= floatval($getVendor->dis_price) * floatval($res->pro_qty); ?></td>
						<?php }else{?>
						<td><?= floatval($res->dis_price) * floatval($res->pro_qty); ?></td>
						<?php }?>
						
                                                <td><?= $res->pay_sta == 1 ? "Done" : "" ?>  </td>
                                                <td>
                                                    <?php
                                                    if ($res->deliver != 2 && $res->deliver != 5) {
                                                        ?>
                                                        <select data-or="<?= $res->OID ?>" name="delivery_option" id="delivery_option">
                                                            <option <?= $res->deliver == 0 ? "selected" : "" ?>  value="0">Pending</option>
                                                            <option <?= $res->deliver == 1 ? "selected" : "" ?>  value="1">Dispatch</option>
                                                            <?php if ($this->session->userdata('signupSession')['role'] == 1) { ?>
                                                                <option <?= $res->deliver == 2 ? "selected" : "" ?>  value="2">Delivered</option>
                                                            <?php } ?>
                                                            <option <?= $res->deliver == 3 ? "selected" : "" ?>  value="3">Cancellation Requested</option>
                                                            <option <?= $res->deliver == 4 ? "selected" : "" ?>  value="4">Re-Dispatch</option>
                                                            <?php if ($this->session->userdata('signupSession')['role'] == 1) { ?>
                                                                <option <?= $res->deliver == 5 ? "selected" : "" ?>  value="5">Canceled</option>
                                                            <?php } ?>
                                                        </select>
                                                        <?php
                                                    } else {

                                                        echo $res->deliver == 2 ? "Delivered" : ($res->deliver == 5 ? "Canceled" : "");
                                                        if ($res->deliver == 5) {
                                                            ?>
                                                            <label for="" title="<?=$res->cancel_comments?>"><?= substr($res->cancel_comments, 0,20) ?></label>
                                                            <?php
                                                        }
                                                        ?>

                                                    <?php } ?>
                                                </td>
                                                <td style="white-space: nowrap">
                                                    <a title="User Invoice" target="_blank" href="<?= base_url('Vendor/Invoice/') ?><?= $this->encrypt->encode($res->OID) ?>" class="btn btn-success btn-xs"> <i class="fa fa-list"></i></a>

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



    </div>


</main>
