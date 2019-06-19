<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<main class="main-container">

    <header class="page-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <ol class="breadcrumb">
                        <li>
                            <i class="icon fa fa-home"></i>
                            <a href="#"> Categories</a>
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
                            <?= form_open_multipart('SadminLogin/addCategory', array('method' => 'POST', 'id' => 'sform2')) ?>
                            <div  class="panel-body  pb">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label>Category Name</label>
                                        <input type="text" id="category" name="category" class="form-control" placeholder="Category Name"   value="" autocomplete="off" /> 
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Description</label>
                                        <textarea name="cat_desc" id="form-control" class="form-control"></textarea>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Category Image(1920x239)</label>
                                        <input type="file" name="cat_image" value="" />
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Status</label>
                                        <select class="form-control" name="cat_sta" id="cat_sta">
                                            <option value="1">Enable</option>
                                            <option value="0">Disable</option>
                                        </select>
                                    </div>


                                </div>
                       
                                <br/>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label>Type</label>
                                        <select class="form-control" name="type" id="type">
                                            
                                            <option value="product">Product</option>
                                            <option value="service">Service</option>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <input type="submit"  value="Add Category" class="btn btn-xs btn-success" >
                                    </div>
                                </div>
                                
                            </div>
                            <?= form_close(); ?>
                            <div class="table-responsive">

                                <table class="table table-bordered table-striped table-nowrap no-mb">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Action</th>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Type</th>
                                            <th>Image</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 1;
                                        foreach ($data as $categories) {
                                            ?>
                                            <tr>
                                                <td><?= $count ?></td>
                                                <td><a href="<?= site_url('SadminLogin/editCategory/' . $this->encrypt->encode($categories->id, 'Test@123#')) ?>" class="btn btn-xs btn-warning">Edit</a>
                                                    <a href="<?= site_url('SadminLogin/subCategory/' . $this->encrypt->encode($categories->id, 'Test@123#')) ?>" class="btn btn-xs btn-success">See Sub-categories</a> 
                                                    <a onclick="return confirm('Do you want to delete this category')" href="<?= site_url('SadminLogin/deleteCategory/' . $this->encrypt->encode($categories->id, 'Test@123$')) ?>" class="btn btn-xs btn-danger">Delete</a>
                                                </td>
                                                <td><?= $categories->cat_name ?></td>
                                                <td><?= $categories->cat_sta == 0 ? 'Disable' : "enable"; ?></td>
                                                <td><?= $categories->type  ?></td>
                                                <td><img style="width:100px" src="<?= base_url('uploads/category/thumbnail/thumb_') ?><?= $categories->cat_image ?>" alt="" /></td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>



                </div>


            </div>
        </div>

        <div id="setMe"></div>

    </div>


</main>