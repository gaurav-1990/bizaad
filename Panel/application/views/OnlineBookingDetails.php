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
                            <a href="#"> Online Query Details</a>
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

                                <table class="table table-bordered table-striped table-nowrap no-mb">

                                    <tbody id="userOrderModule">
                                     
                                        <tr>
                                            <th>First Name</th>
                                            <td><?= $booking->fname ?> </td>

                                        </tr>
                                        <tr>
                                            <th>Last Name</th>
                                            <td><?= $booking->lname ?> </td>

                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td><?= $booking->email ?> </td>
                                        </tr>
                                        <tr>
                                            <th>Contact</th>
                                            <td><?= $booking->contact ?> </td>
                                        </tr>
                                        <tr>
                                            <th>Product Name</th>
                                            <td><?= $booking->pro_name ?> </td>
                                        </tr>
                                        <tr>
                                            <th>Product Price</th>
                                            <td><?= $booking->dis_price ?> </td>
                                        </tr>
                                        <tr>
                                            <th>Service Type</th>
                                            <td><?= $booking->type ?> </td>
                                        </tr>
                                        <?php
                                        if ($booking->type == "cab") {
                                            ?>
                                            <tr>
                                                <th>Trip Start Date</th>
                                                <td><?= $booking->trip_start ?> </td>
                                            </tr>
                                            <tr>
                                                <th>Pick Time</th>
                                                <td><?= $booking->pick_time ?> </td>
                                            </tr>
                                            <tr>
                                                <th>Close Date</th>
                                                <td><?= $booking->close_date ?> </td>
                                            </tr>
                                        <?php } elseif ($booking->type == "prof") { ?>
                                            <tr>
                                                <th>Preferred Mode</th>
                                                <td><?= $booking->preffered_mode ?> </td>
                                            </tr>
                                            <tr>
                                                <th>Pick Time</th>
                                                <td><?= $booking->dateofappoint ?> </td>
                                            </tr>
                                            <tr>
                                                <th>Close Date</th>
                                                <td><?= $booking->time_slot ?> </td>
                                            </tr>
                                        <?php } else {
                                            ?>
                                            <tr>
                                                <th>Pick Time</th>
                                                <td><?= $booking->date_of_booking ?> </td>
                                            </tr>
                                            <tr>
                                                <th>Close Date</th>
                                                <td><?= $booking->repair_time_slot ?> </td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <th>Address</th>
                                            <td><?= $booking->address ?> </td>
                                        </tr>
                                        <tr>
                                            <th>Pin Code</th>
                                            <td><?= $booking->zip ?> </td>
                                        </tr>
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
