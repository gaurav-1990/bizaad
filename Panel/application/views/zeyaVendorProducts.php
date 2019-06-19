 
<main class="main-container">
    <div  class="panel panel-white">
	<?= form_open_multipart('', array('class' => 'form-horizontal', 'autocomplete' => 'off', 'name' => 'zsform2', 'id' => 'zsform2', 'method' => 'POST')); ?>
        <div  class="panel-body ">
            <div class="row">
                <div class="col-md-12">
                    <ul class="heading_class">
                        <li id="product_details" onclick="callProductDetails()" class=" active col-md-3 list-group-item list-group-item-action flex-column align-items-start"><a href="#">Product Details</a>     <span class="badge badge-primary badge-pill">1</span></li>
                        <li id="product_price" onclick="callProductPrice()" class="col-md-3 list-group-item list-group-item-action flex-column align-items-start"><a href="#">Product Price</a>  <span class="badge badge-primary badge-pill">2</span></li>
                    </ul>
                </div>
            </div>
        </div>
        <div  class="product_details_class">
            <header class="page-heading">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-header">
                                <h2 class="page-subtitle">
				    Vendor Product Details 
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <div  class="panel-body  ">
		<div class="row">
		    <div class="col-md-4">
			<?= $this->session->flashdata('msg'); ?>
		    </div>
		</div>
		
                <div class="row">
		   <div class="vendor-product"></div>
		   
		    <input type="hidden" id="product_id"   name="product_id" class="form-control" readonly="" value="<?= $this->encrypt->encode($this->userid) ?>">

                    <div class="col-sm-3">
                        <label>Category</label>
                        <select class="form-control" onchange="getSubcategory(this.value)" name="category" id="category">
                            <option value="">Select Category</option>
			    <?php foreach ($categories as $category) { ?>
    			    <option value="<?= $this->encrypt->encode($category->id) ?>"><?= $category->cat_name ?></option>
			    <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label>Sub Category</label>
                        <select class="form-control" onchange="getSubcategoryProducts(this.value);" name="sub_category" id="sub_category_ven">
                            <option value="">Sub Category</option>
                        </select>
                    </div>

                    <div class="col-sm-3">
                        <label>Product Name</label>
			<select class="form-control"  name="prod_name" id="sub_category_ven2">
                            <option value="">Product Name</option>
                        </select>
<!--                        <input type="text" id="product_name"   name="product_name" minlength="10" maxlength="70" class="form-control" placeholder="Product Name">-->
                    </div>


                </div>
            </div>
            <div  class="panel-body  ">
                <div class="row">

                    <div class="col-sm-3">
                        <label>Is Branded ? </label>
                        <select class="form-control" onchange="isBrand(this)" name="isBranded" id="isBranded">
                            <option value="0"> NO</option>
                            <option value="1"> YES</option>
                        </select>
                    </div>
                    <div id="show_brand" style="display: none">
                        <div class="col-sm-3">
                            <label>Brand Name</label>
                            <input type="text" id="brand_name"   name="brand_name" class="form-control" placeholder="Brand Name">
                        </div>
                    </div>

<!--                    <div class="col-sm-3">
                        <label>Serial Number /IMEI Number </label>
                        <input type="text" id="imei"   name="imei" class="form-control" placeholder="IMEI Number">
                    </div>-->

                </div>
            </div>


            <div  class="panel-body  ">
                <div class="row">
                    <div class=" col-sm-4">
                        <label for="">&nbsp;</label>
                        <button onclick="callProductPrice()"  type="button" class="btn btn-warning btn-xs">Next Step</button>
                    </div>
                </div>
            </div>


        </div>
        <div class="product_price_class" style="display: none">
            <header class="page-heading">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-header">
                                <h2 class="page-subtitle">
                                    Product Price 
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <div  class="panel-body  ">
                <div class="row">
                    <div class="col-sm-3">
                        <label>Actual Price</label>
                        <input type="text" id="act_price"   name="act_price" class="form-control" placeholder="Actual Price">
                    </div>
                    <div class="col-sm-3">
                        <label>Offer Price</label>
                        <input type="text" id="dis_price" name="dis_price"     class="form-control" placeholder="Discount Price"   value="" autocomplete="off" /> 
                    </div>
                    <div class="col-sm-3">
                        <label>Total Product In Stock</label>
                        <input type="text" id="pro_stock" name="pro_stock"     class="form-control" placeholder="Total Products"   value="" autocomplete="off" /> 
                    </div>
                    <div class="col-sm-3">
                        <label>In Stock</label>
                        <select class="form-control" name="in_stock" id="in_stock">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>


            </div>

            <div  class="panel-body  ">
                <div class="row">
                    <div class="col-sm-3">
                        <label>GST %</label>
                        <input type="text" id="gst"   name="gst" class="form-control" placeholder="GST %">
                    </div>
<!--                    <div class="col-sm-3">
                        <label>HSN Code</label>
                        <input type="text" id="hsn_code"     name="hsn_code" class="form-control" placeholder="HSN Code">
                    </div>-->

                </div>


            </div>
	    <div  class="panel-body">
                <div class="row">
                    <div class=" col-sm-4">
                        <label for="">&nbsp;</label>
                        <button type="button" onclick="zeya_submitVenForm()"  class="btn btn-default">Submit</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="product_images_class" style="display: none">
            <header class="page-heading">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-header">
                                <h2 class="page-subtitle">
                                    Product Images 
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <div  class="panel-body ">
                <div class="row">
                    <div class="col-sm-3">
                        <label for=""></label><br>
                        <button type="button"   class="btn btn-warning btn-xs add_more">Add Properties</button>
                    </div>

                </div>
            </div>
            <div  class="panel-body ">
                <div class="row">
                    <div class=" col-sm-4">
                        <label for="">&nbsp;</label>
                        <button type="submit"  class="btn btn-default">Add Products</button>
                    </div>
                </div>
            </div>

        </div>

	<?= form_close(); ?>
    </div>
</main>
