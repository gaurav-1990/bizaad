
<main class="main-container">
    <header class="page-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">

                    <!-- Breadcrumb -->
                    <ol class="breadcrumb">
                        <li>
                            <i class="icon fa fa-home"></i>
                            <a href="#">Vendor Signup</a>
                        </li>
                        <li>
                            <a href="<?= site_url('SadminLogin/profiles'); ?>">View</a>
                        </li>
                        <li class="active"><span>Add Vendor</span></li>
                    </ol>
                    <!-- /Breadcrumb -->

                    <!-- Page header -->
                    <div class="page-header">

                        <h2 class="page-subtitle">
                            Add Vendor Information
                        </h2>
                    </div>
                    <!-- /Page header -->

                </div>
            </div>
        </div>
    </header>

    <?= $this->session->flashdata('msg'); ?>
    <?= $this->session->flashdata('insert1'); ?>
    <?= $this->session->flashdata('insert2'); ?>
    <?= $this->session->flashdata('insert3'); ?>
    <?= $this->session->flashdata('insert4'); ?>
    <?= $this->session->flashdata('insert5'); ?>
    <?= $this->session->flashdata('insert6'); ?>
    <?= $this->session->flashdata('emailmsg'); ?>
    <div  class="panel panel-white">
        <?= form_open('SadminLogin/vendorCreation', array("enctype" => "multipart/form-data", 'class' => 'form-horizontal', 'autocomplete' => 'off', 'id' => 'sform2', 'method' => 'POST')); ?>

        <div  class="panel-body  pb">
            <div class="row">

                <div class="col-sm-3">
                    <label>First Name </label>
                    <input type="text" id="first_name"  name="first_name" class="form-control" placeholder="First Name">
                </div>
                <div class="col-sm-3">
                    <label>Last Name</label>
                    <input type="text" id="last_name" name="last_name"    class="form-control" placeholder="Last Name"   value=""  /> 
                </div>
                <div class="col-sm-3">
                    <label>Contact Number</label>
                    <input type="text" id="contact_no" name="contact_no"   class="form-control" placeholder="Contact Number"   value=""  /> 
                </div>
                <div class="col-sm-3">
                    <label>Email Address</label>
                    <input type="text" id="email_id" name="email_id"    class="form-control" placeholder="Email Address"   value=""  /> 
                </div>
                <input type="hidden" name="hidden_id"   />
            </div>
        </div>
        <div  class="panel-body  pb">
            <div class="row">

                <div class="col-sm-3">
                    <label>Company</label>
                    <input type="text" id="company"   name="company" class="form-control" placeholder="Company">
                </div>
                <div class="col-sm-3">
                    <label>State</label>
                    <select class="form-control" name="state" id="stateid">
                        <option value="">Select State</option>
                        <?= getState() ?>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label>City</label>
                    <select class="form-control" name="city" id="city">
                        <option value="">Select City</option>

                    </select>
                </div>
                <div class="col-sm-3">
                    <label>Pin Code</label>
                    <input type="text" id="zip" name="zip"  class="form-control" placeholder="Pin Code"   value=""  /> 
                </div>
            </div>
        </div>
        <div  class="panel-body  pb">
            <div class="row">

                <div class="col-sm-3">
                    <label>Address</label>
                    <textarea   id="address" name="address" class="form-control" placeholder="Address"></textarea>
                </div>

                <div class="col-sm-3">
                    <label>Pan no.</label>
                    <input type="text" id="pan_no" name="pan_no"     class="form-control" placeholder="Pan No."   value="" autocomplete="off" /> 
                </div>
                <div class="col-sm-3">
                    <label>TIN</label>
                    <input type="text" id="tin" name="tin"    class="form-control" placeholder="TIN"   value=""  /> 
                </div>
                <div class="col-sm-3">
                    <label>GST no.</label>
                    <input type="text" id="gst_no" name="gst_no"    class="form-control" placeholder="GST No."   value="" autocomplete="off" /> 
                </div>
            </div>
        </div>

        <div  class="panel-body  ">
            <div class="row">
                <div class="col-sm-3 col-md-3">
                    <label>Password *</label>
                    <input type="text" id="password" name="password"  required="" class="form-control"    value="" autocomplete="off" /> 
                </div>
                <div class="col-sm-2 col-md-3">
                    <label>Upload Address Proof *</label>
                    <input type="file" id="add_proof_ad" name="add_proof"  required=""  class="form-control"    value="" autocomplete="off" /> 
                </div>
                <div class="col-sm-3 col-md-3">
                    <label>Upload Pan Number *</label>
                    <input type="file" id="pan_number_ad" name="pan_number" required=""  class="form-control"   value="" autocomplete="off" /> 
                </div>
                <div class="col-sm-3 col-md-3">
                    <label>Upload Profile Pic *</label>
                    <input type="file" id="profile_pic_ad" name="profile_pic"  required=""  class="form-control"   value="" autocomplete="off" /> 
                </div>


            </div>
        </div>
        <div  class="panel-body  ">
            <div class="row">
                <div class="col-sm-3 col-md-3">
                    <label>Upload GST Doc *</label>
                    <input type="file" id="gst_doc_ad" name="gst_doc" required=""  class="form-control"    value="" autocomplete="off" /> 
                </div>
                <div class="col-sm-3 col-md-3">
                    <label>Upload Signature *</label>
                    <input type="file" id="signature_ad" name="signature"  required=""  class="form-control"    value="" autocomplete="off" /> 
                </div>
                <div class="col-sm-3 col-md-3">
                    <label>Upload Cancel Cheque *</label>
                    <input type="file" id="can_cheque_ad" name="can_cheque"  required="" class="form-control"    value="" autocomplete="off" /> 
                </div>
                <div class="col-sm-3 col-md-3">
                    <label>About Us *</label>
		    <textarea name="aboutUs" cols="35" autocomplete="off" required="" placeholder="this is my content...." aria-required="true" spellcheck="false" aria-invalid="false"></textarea>
                </div>
            </div>
        </div>

        <div  class="panel-body  pb">
            <div class="row">
                <div class=" col-sm-4">
                    <button type="submit" class="btn btn-default"> Submit </button>
                </div>
            </div>
        </div>

        <?= form_close(); ?>
    </div>
</main>
