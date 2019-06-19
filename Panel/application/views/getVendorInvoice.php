<main class="main-container">
    <header class="page-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <ol class="breadcrumb">
                        <li>
                            <i class="icon fa fa-home"></i>
                            <a href="#">Vendor Products </a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </header>

    <div  class="panel panel-white">
        <?= $this->session->flashdata('msg'); ?>
        <div  class="panel-body  pb">
            <?php
            $output = '';
            $output .= form_open_multipart('uploadInvoice/save');
            $output .= '<div class="row">';
            $output .= '<div class="col-lg-3 col-sm-4"><div class="form-group">';
            $output .= form_label('Select Vendors', 'vendors');
            $output .= '<select class="form-control" name="vendor" id="vendor">
                            <option value="">Select Vendors</option>';
            foreach ($vendors as $vendor) {
                $output .= "<option value='$vendor->id'>$vendor->company</option>";
            }
            $output .= '</select>';
            $output .= '</div></div>';
            $output .= '<div class="col-lg-3 col-sm-4"><div class="form-group">';

            $output .= form_label('Import Vendor Invoice', 'image');
            $data = array(
                'name' => 'userfile',
                'id' => 'userfile',
                'class' => 'form-control ',
                'value' => '',
            );
            $output .= form_upload($data);
            $output .= '</div> <span style="color:red;">*Please choose an Excel file(.csv) as Input</span></div>';
            $output .= '<div class="col-lg-12 col-sm-12"><div class="form-group text-right">';
            $data = array(
                'name' => 'importfile',
                'id' => 'importfile-id',
                'class' => 'btn btn-primary',
                'value' => 'Import',
            );
            $output .= form_submit($data, 'Import Data');
            $output .= '</div>
                    </div>
                        </div>';
            $output .= form_close();
            echo $output;
            ?>


        </div>
    </div>
</main>
