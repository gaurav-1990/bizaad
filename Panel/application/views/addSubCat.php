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
                            <?= form_open_multipart('SadminLogin/addSubCategory', array('method' => 'POST', 'id' => 'sform2')) ?>
                            <div  class="panel-body  pb">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label>Category Name</label>
                                        <select class="form-control" name="cat_sub" id="cat_sub">
                                            <option value="">Select Category</option>
                                            <?php
                                            foreach ($categories as $category) {
                                                ?>
                                                <option value="<?= $category->id ?>"><?= $category->cat_name ?></option>;
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Sub Category Name</label>
                                        <input type="text" id="sub_category" name="sub_category" class="form-control" placeholder="Sub Category Name"   value="" autocomplete="off" /> 
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Description</label>
                                        <textarea name="sub_cat_desc" id="sub_cat_desc" class="form-control"></textarea>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Sub Category Image</label>
                                        <input type="file"  name="sub_image"  />
                                        <?php echo form_error('sub_image', '<p class="error">', '</p>'); ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label>Title</label>
                                        <textarea name="sub_title" id="sub_title" class="form-control"></textarea>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Meta Description</label>
                                        <textarea name="sub_meta_desc" id="sub_meta_desc" class="form-control"></textarea>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Meta Keyword</label>
                                        <textarea name="sub_meta_key" id="sub_meta_key" class="form-control"></textarea>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Percentage</label>
                                        <input type="text"  id="percentage" name="percentage" class="form-control" placeholder="percentage"   value="" autocomplete="off" /> 
                                    </div>


                                </div>
                            </div>
                            <div  class="panel-body  pb">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label>
                                            IS COD AVAILABLE?
                                            <br>
                                            <input type="checkbox"  name="cod" value="1" checked="checked" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <input type="submit" style="margin-top: 4px" value="Add Sub-Category " class="btn btn-xs btn-success" >
                                </div>
                            </div>
                        </div>
                        <?= form_close(); ?>


                    </div>
                </div>



            </div>


        </div>
    </div>






</main>