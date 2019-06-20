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

<div class="container withmargin">
    <!-- <h6>Search the Records Datewise:</h6> -->
        <?php echo form_open('Vendor/onlineQuery')?>
        
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
                                            <th>Payment Sta</th>
                                            <th>Pay Type</th>

                                            <th>See Details</th>
                                            <th>Cname</th>
                                            <th>Email</th>
                                            <th>Contact</th>

                                            <th>Pro Name</th>
                                            <th>Advance</th>
                                            <th>Price</th>
                                            <th>Type</th>
                                            <th>Pin Code</th>
                                            <th>Address</th>

                                        </tr>
                                    </thead>
                                    <tbody id="userOrderModule">
                                        <?php
                                        foreach ($booking as $res) {

                                            //   $res->pro_sta==1 == > Pending ;
                                            //   $res->pro_sta==2 == > Waiting For Refund ;
                                            //   $res->pro_sta==3 == > Delivered;
                                            ?>
                                            <tr>
                                                <td><?= $res->pay_sta == 0 ? "Failed" : "Success" ?>  </td>
                                                <td><?= $res->pay_type ?>  </td>
                                                <td><a href="<?= site_url('Vendor/onlineQueryDetails/' . $res->OID) ?>" class="btn btn-xs btn-success">See Details</a></td>
                                                <td><?= $res->fname ?> <?= $res->lname ?></td>
                                                <td><?= $res->email ?></td>
                                                <td><?= $res->contact ?></td>
                                                <td><?= $res->pro_name ?></td>
                                                <td><?= $res->pro_price ?> </td>
                                                <td><?= $res->advance_price ?> </td>
                                                <td><?= $res->type ?></td>
                                                <td><?= $res->zip ?></td>
                                                <td title="<?= $res->address ?>"><?= substr($res->address, 0, 10) . ".." ?></td>
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
