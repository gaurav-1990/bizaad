
<!-- /Header -->

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Main container -->
<main class="main-container">


    <!-- Page heading -->
    <header class="page-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">

                    <ol class="breadcrumb">
                        <li>
                            <i class="icon fa fa-home"></i>
                            <a href="#">Home</a>
                        </li>
                        <li><a href="#">Dashboard</a></li>
                        <li class="active"><span>Main page</span></li>
                    </ol>
                    <?php $userProfile = getUserProfile($this->session->userdata('signupSession')['id']); ?>
                </div>
            </div>
        </div> 
    </header>


</main>


