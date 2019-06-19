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

                    <img style="height: 200px;width: 200px" src="<?= base_url() ?>uploads/subcategory/<?= $data->sub_img ?>" alt="" />

                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="panel  panel-white">
                        <div class="panel-body">
                            <?= form_open_multipart('SadminLogin/update_category', array('method' => 'POST', 'id' => 'sform3')) ?>
                            <div  class="panel-body  pb">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label>Category Name</label>
                                        <select class="form-control" name="cat_sub" id="cat_sub">
                                            <option value="">Select Category</option>
                                            <?php
                                            foreach ($categories as $category) {
                                                ?>
                                                <option value="<?= $category->id ?>" <?= $category->id == $data->cid ? "selected" : "" ?>><?= $category->cat_name ?></option>;
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Sub Category Name</label>
                                        <input type="text" id="sub_category" name="sub_category" value="<?= $data->sub_name ?>" class="form-control" placeholder="Sub Category Name"   value="" autocomplete="off" /> 
                                        <input type="hidden" name="hidden_id"  value="<?= $url ?>" />
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Description</label>
                                        <textarea name="sub_cat_desc" id="sub_cat_desc"  class="form-control"><?= $data->sub_desc ?></textarea>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Sub Category Image</label>
                                        <input type="file" name="sub_image"  />
                                        <?php echo form_error('sub_image', '<p class="error">', '</p>'); ?>
                                        <input type="hidden" name="sub_image_two" value="<?= $data->sub_img ?>" />

                                    </div>
                                </div>
                            </div>
                            <div  class="panel-body  pb">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label>Title</label>
                                        <textarea name="sub_title"  id="sub_title" class="form-control"><?= $data->sub_title ?></textarea>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Meta Description</label>
                                        <textarea name="sub_meta_desc"  id="sub_meta_desc" class="form-control"><?= $data->sub_meta_desc ?></textarea>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Meta Keyword</label>
                                        <textarea name="sub_meta_key" id="sub_meta_key" class="form-control"><?= $data->sub_meta_key ?></textarea>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Percentage</label>
                                        <input type="text" name="percentage" id="percentage" value="<?= $data->percentage ?>" class="form-control"/>
                                    </div>
                                </div>
                            </div>
                            <div  class="panel-body  pb">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label>
                                            IS COD AVAILABLE?
                                            <br>
                                            <input type="checkbox"  name="cod" value="1"  <?= $data->cod == 1 ? "checked" : "" ?> />
                                        </label>

                                    </div>
                                </div>
                            </div>
                            <div  class="panel-body  pb">

                                <div class="col-sm-3">
                                    <input type="submit" style="margin-top: 4px" value="Edit Sub-Category " class="btn btn-xs btn-success" >
                                </div>
                            </div>
                        </div>
                        <?= form_close(); ?>


                    </div>
                </div>



            </div>


        </div>
    </div>

    <div id="setMe"></div>

</div>


</main>