<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor extends CI_Controller {

    public $role, $userid;

    function __construct() {
	parent::__construct();
	$this->load->library('encrypt');
	if (!$this->session->userdata('signupSession')) {
	    return redirect('Loginvendor');
	} else {
	    $this->role = $this->session->userdata('signupSession')['role'];
	    $this->userid = $this->session->userdata('signupSession')['id'];
	    $this->load->model('Admin_model', 'admin');
	    $this->load->model('Vendor_model', 'vendor');
	    $this->load->model('User_model', 'user');
	    $this->load->helper('getinfo');
	}
    }

    public function userOrder() {
	$this->load->view('config/header', array('title' => 'Please add products'));
	$this->load->view('config/sidebar', array('active' => 'orders', 'action' => ''));
	//$results = $this->vendor->userOrderByVendor($this->session->userdata('signupSession')['id']);
	$results = $this->vendor->ZeyauserOrderByVendor($this->session->userdata('signupSession')['id']);
	$this->load->view('UserOrders', array('results' => $results));
	$this->load->view('config/footer');
    }

    public function addAWB() {
	$orderID = $this->security->xss_clean($this->input->post('orid'));
	$awb = $this->security->xss_clean($this->input->post('awb'));

	$deliverStatus = $this->security->xss_clean($this->input->post('delsta'));
	$return = $this->vendor->addAwb($orderID, $awb, $deliverStatus);
    }

    public function VendorInvoice() {
	$this->load->view('config/header', array('title' => 'Please add products'));
	$this->load->view('config/sidebar', array('active' => 'orders', 'action' => ''));
	$data = $this->admin->getVendorInfo($this->userid, $this->role);

	$this->load->view('getVendorInvoice', array("vendors" => $data));
	$this->load->view('config/footer');
    }

    public function generateVendorInvoice() {
	$this->load->view('config/header', array('title' => 'Please add products'));
	$this->load->view('config/sidebar', array('active' => 'orders', 'action' => ''));
	$data = $this->admin->getVendorInfo($this->userid, $this->role);
	$this->load->view('generateVendorInvoice', array("vendors" => $data));
	$this->load->view('config/footer');
    }

    public function generatePdfInvoice() {

	$data = $this->vendor->vendorInvoice($this->input->post());
	if (count($data) > 0) {
	    $this->load->view('vendor_invoice', array("products" => $data));
	} else {
	    die("No Information");
	}
    }

    public function generatedInvoice() {
	$fromdate = $this->input->post('year') . "-" . sprintf("%02d", $this->input->post('month')) . "-" . "01";
	$todate = $this->input->post('year') . "-" . sprintf("%02d", $this->input->post('month')) . "-" . "31";
	$data = $this->user->vendorInvoice($this->session->userdata('signupSession')['id'], $fromdate, $todate);
	$this->load->view('vendor_invoice', array('data' => $data[0], "products" => $data));
    }

    public function Invoice() {
	$id = (int) $this->encrypt->decode($this->uri->segment(3));
	
	if ($id > 0) {
	   // $data = $this->user->allOrdersOrderId($id);
	    $data = $this->user->zeya_allOrdersOrderId($id);
//	    echo '<pre>';
//	    print_r($data);
//	    echo '</pre>';
//	    die;
	    if (count($data) > 0) {
		$this->load->view('getUserInvoice', array('data' => $data));
	    } else {
		die("No Information");
	    }
	} else {
	    echo show_404();
	}
    }

    public function addAWBOther() {
	$orderID = $this->security->xss_clean($this->input->post('orid'));

	$deliverStatus = $this->security->xss_clean($this->input->post('delsta'));
	$return = $this->vendor->addAwbOther($orderID, $deliverStatus);
    }

    public function getAttribute() {

	//passing property id
	$results = $this->vendor->getAttribute($this->input->post('category'));
	$option = "";
	if (count($results) > 0) {
	    foreach ($results as $result) {
		$option .= "<option value='$result->id'>$result->attr_name </option>";
	    }
	} else {
	    $option .= "<option value=''>No Attribute </option>";
	}
	echo $option;
    }

    private function get_innerAttribute($id) {
	$results = $this->vendor->getAttributeJoin($id);
	$option = "";
	if (count($results) > 0) {
	    foreach ($results as $result) {
		$attr = str_replace(" ", "_", $result->attr_name);
		$prop = str_replace(" ", "_", $result->pop_name);
		$option .= "<option value='" . $prop . "|" . $attr . "'>$result->attr_name </option>";
	    }
	} else {
	    $option .= "<option value=''>No Attribute </option>";
	}
	return $option;
    }

    public function addProperties() {
	$count = $this->input->post('count');
	$selectProp = "";
	$results = $this->vendor->getProperties($this->encrypt->decode($this->input->post('category')), $this->encrypt->decode($this->input->post('subcategory')));

	$varCo = 0;
	foreach ($results as $key => $result) {
	    $prop_name = str_replace(" ", "_", $result->pop_name);
	    $selectProp .= <<<EOD
                 <div class="col-sm-2">
                        <label>$result->pop_name</label>
                         <select class="form-control"   name="propName{$count}[]" id="pd_prop">
                          <option value="">Select $result->pop_name</option>
                          {$this->get_innerAttribute($result->pid)}
                        </select>      
                    </div>
EOD;

	    $varCo++;
	}
	$htm = <<<EOD
       <div  class="panel-body ">
        <div class="row">
                    $selectProp
                      
                    
                     <div class="col-sm-2">
                         <label> Price Difference</label>
                          <input class="form-control" id="changePrice"  type="text" name="changePrice[]" />     
                     </div>
                     <div class="col-sm-2">
                         <label>Quantity</label>
                          <input class="form-control" id="quantity" type="text" name="quantity[]" />     
                     </div>
                <input type="hidden" name="total[]" value="{$varCo}">
                    <div class="col-sm-2">
                         <label>&nbsp;</label><br>
                         <button onclick="deleteMe(this)" class="btn btn-xs btn-danger">delete </button>
                     </div>
            </div>
          </div>
EOD;
	echo $htm;
    }

    public function editRequestedProduct() {
	$actualId = $this->encrypt->decode($this->uri->segment(3));
	if (count($this->vendor->checkProductValid($actualId))) {
	    $this->load->view('config/header', array('title' => 'Edit your products'));
	    $this->load->view('config/sidebar', array('active' => 'addproducts', 'action' => 'addproducts'));
	    $products = $this->vendor->checkProductValid($actualId);
	    $images = $this->vendor->loadMoreImages($actualId);
	    $this->load->library('ckeditor');
	    $ck = $this->ckeditor->loadCk(TRUE, 'pro_desc');
	    $categories = $this->admin->load_categories();
	    $this->load->view('editProducs_request', array('products' => $products[0], 'categories' => $categories, 'ckeditor' => $ck, 'images' => $images));
	    $this->load->view('config/footer');
	} else {
	    echo show_404();
	}
    }
    public function zeya_vendor_editRequestedProduct() {
	
	$actualId = $this->encrypt->decode($this->uri->segment(3));
	
	if (count($this->vendor->zeya_vendor_checkProductValid($actualId))) {
	   
	    $this->load->view('config/header', array('title' => 'Edit your products'));
	    $this->load->view('config/sidebar', array('active' => 'addproducts', 'action' => 'addproducts'));
	    $products = $this->vendor->zeya_vendor_checkProductValid($actualId);	   	  
	    $this->load->library('ckeditor');
	    $ck = $this->ckeditor->loadCk(TRUE, 'pro_desc');
	    $categories = $this->admin->load_categories();
	    $this->load->view('zeya_EditVendorProduct', array('products' => $products[0], 'categories' => $categories));
	    $this->load->view('config/footer');
	} else {
	    echo show_404();
	}
    }

    public function editConfirmedProduct() {
	$actualId = $this->encrypt->decode($this->uri->segment(3));


	if (count($this->vendor->checkProductValid($actualId))) {
	    $this->load->view('config/header', array('title' => 'Edit your products'));
	    $this->load->view('config/sidebar', array('active' => 'addproducts', 'action' => 'addproducts'));
	    $products = $this->vendor->checkProductValid($actualId);
	    $images = $this->vendor->loadMoreImages($actualId);
	    $this->load->library('ckeditor');
	    $ck = $this->ckeditor->loadCk(TRUE, 'pro_desc');
	    $categories = $this->admin->load_categories();
	    $this->load->view('editConfirmedProduct', array('products' => $products[0], 'categories' => $categories, 'ckeditor' => $ck, 'images' => $images));
	    $this->load->view('config/footer');
	} else {
	    echo show_404();
	}
    }

    public function updateVendorRequest() {
	$daa = $this->vendor->updateProducts($this->security->xss_clean($this->input->post()), $this->encrypt->decode($this->input->post('pro_id')));
	if ($daa) {
	    $this->session->set_flashdata('msg', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">Record Updated Successfully, Product has been submitted for review</a></div></div>');
	} else {
	    $this->session->set_flashdata('msg', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline"> Something went wrong</a></div></div>');
	}
	return redirect('Vendor/editRequestedProduct/' . $this->input->post('pro_id'));
    }
    public function zeya_updateVendorRequest() {
	
	$daa = $this->vendor->zeya_updateProducts($this->security->xss_clean($this->input->post()), $this->encrypt->decode($this->input->post('pro_id')));
	if ($daa) {
	    $this->session->set_flashdata('msg', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">Record Updated Successfully, Product has been submitted for review</a></div></div>');
	} else {
	    $this->session->set_flashdata('msg', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline"> Something went wrong</a></div></div>');
	}
	return redirect('Vendor/zeya_vendor_editRequestedProduct/' . $this->input->post('pro_id'));
    }

    public function updateConfirmedVendorRequest() {
	$daa = $this->vendor->updateConfirmedProducts($this->security->xss_clean($this->input->post()), $this->encrypt->decode($this->input->post('pro_id')));
	if ($daa) {
	    $this->session->set_flashdata('emailmsg', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">Record Updated Successfully</a></div></div>');
	} else {
	    $this->session->set_flashdata('emailmsg', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline"> Something went wrong</a></div></div>');
	}
	return redirect('Vendor/vendor_products');
    }

    public function loadProperties() {
	$properties = $this->vendor->properties();

	echo "<option value=''>Select</option>";

	foreach ($properties as $prop) {
	    echo "<option value='$prop->id'>$prop->prop_name</option>";
	}
    }

    public function loadsubProp() {
	$id = (int) $this->input->post('prop_id');
	$sub = $this->vendor->getSubProp($id);
	echo "<option value=''> Select</option>";
	foreach ($sub as $subpr) {
	    echo "<option value=$subpr->subprop_name" . '_' . "$subpr->id>$subpr->subprop_name</option>";
	}
    }

   
    public function addProducts() {

	$this->load->view('config/header', array('title' => 'Please add products'));
	$this->load->view('config/sidebar', array('active' => 'addproducts', 'action' => 'addproducts'));
	$id = $this->session->userdata('signupSession')['id'];
	$data = $this->admin->load_vendor_cat($id);
	$this->load->library('ckeditor');
	$ck = $this->ckeditor->loadCk(TRUE, 'pro_desc');
	$categories = $this->admin->load_categories();
	$max_id = $this->admin->getProductMaxid()->ID;
	 $this->load->view('addProducts', array('categories' => $categories, 'ckeditor' => $ck, 'unique' => $max_id));
	//$this->load->view('zeyaVendorProducts', array('categories' => $data, 'unique' => $max_id));
	$this->load->view('config/footer');
    }
    public function Zeya_vendor_addProducts() {

	$this->load->view('config/header', array('title' => 'Please add products'));
	$this->load->view('config/sidebar', array('active' => 'addproducts', 'action' => 'addproducts'));
	$id = $this->session->userdata('signupSession')['id'];
	$data = $this->admin->load_vendor_cat($id);
	$this->load->library('ckeditor');
	$ck = $this->ckeditor->loadCk(TRUE, 'pro_desc');
	$max_id = $this->admin->getProductMaxid()->ID;
	$this->load->view('zeyaVendorProducts', array('categories' => $data, 'unique' => $max_id));
	$this->load->view('config/footer');
    }

    public function addProductImages() {
	$prod_id = (int) $this->encrypt->decode($this->uri->segment(3));

	if ($prod_id > 0) {
	    $this->load->view('config/header', array('title' => 'Please add product images'));
	    $this->load->view('config/sidebar', array('active' => 'addproducts', 'action' => 'addproducts', 'prod_id' => $prod_id));
	    $detail = $this->vendor->getProduct($prod_id);
	    $this->load->view('addProductImage', array('hidden' => $this->uri->segment(3), 'isBrand' => $detail));
	    $this->load->view('config/footer');
	} else {
	    echo show_404();
	}
    }

    public function getShippingCity() {
	$this->load->helper('destination');
	echo getCityWhere($this->input->post('name'));
    }

    public function getCityPin() {
	$city = $this->input->post('name');
	$url = "http://postalpincode.in/api/postoffice/$city";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	$server_output = curl_exec($ch);


	curl_close($ch);
	$response = json_decode($server_output);
	$html = "";
	if (isset($response->PostOffice)) {
	    foreach ($response->PostOffice as $post) {
		$html .= <<<EOD
        <tr>
          <td><input type="checkbox" checked name="pin[]" value="{$post->PINCode}"> </td>
          <td>{$post->Name}</td>
          <td>{$post->PINCode}</td>
          <td>{$post->District}</td>
          <td>{$post->State}</td>
        <tr>
EOD;
	    }
	} else {
	    $html .= <<<EOD
        <tr>
          <td colspan="5"> No-records found </td>
        <tr>
EOD;
	}

	echo $html;
    }

    public function shipping() {
	$this->load->library('form_validation');
	$this->form_validation->set_error_delimiters('<li class="list-error">', '</li>');

	$this->form_validation->set_rules('state', 'State', 'required');
	$this->form_validation->set_rules('city', 'City', 'required');
	$this->form_validation->set_rules('ship_amt', 'Shipping Amount', 'required|numeric');
	$this->form_validation->set_rules('same_amt', 'Same Day Delivery Shipping Amount', 'required|numeric');
	$this->form_validation->set_rules('pin[]', 'Pin', 'required');

	if ($this->form_validation->run()) {
	    if (is_array($this->input->post('pin'))) {
		$pin = array_unique($this->input->post('pin'));
	    } else {
		$pin = $this->input->post('pin');
	    }
	    $post = $this->input->post();
	    unset($post['pin']);
	    $set = $this->vendor->addVendorShipping($post, $pin, $this->userid);
	    if ($set) {
		$this->session->set_flashdata('msg', '<div class="alert alert-success">Vendor Shipping Detail Entered Successfully</div>');
	    } else {
		$this->session->set_flashdata('msg', '<div class="alert alert-danger">Something Went Wrong</div>');
	    }
	    return redirect('Vendor/shipping');
	} else {

	    $this->load->helper('destination');
	    $this->load->view('config/header', array('title' => 'Add delivery area'));
	    $this->load->view('config/sidebar', array('active' => 'shipping', 'action' => ''));
	    $this->load->view('shpping', array('hidden' => $this->uri->segment(3)));
	    $this->load->view('config/footer');
	}
    }

    public function checkPin() {

	$id = (int) $this->encrypt->decode($this->uri->segment(3));
	if ($id > 0) {
	    $data = $this->vendor->loadZip($id);
	    $this->load->view('config/header', array('title' => 'All Pin Codes'));
	    $this->load->view('config/sidebar', array('active' => 'shipping', 'action' => ''));
	    $this->load->view('AllPin', array('pin' => $data));

	    $this->load->view('config/footer');
	} else {
	    echo show_404();
	}
    }

    public function deleteShip() {
	$id = (int) $this->encrypt->decode($this->uri->segment(3));
	if ($id > 0) {
	    $data = $this->vendor->deleteCity($id);
	    return redirect('Vendor/ViewShipping');
	} else {
	    echo show_404();
	}
    }

    public function deletePin() {
	$id = (int) $this->encrypt->decode($this->uri->segment(3));
	if ($id > 0) {
	    $data = $this->vendor->deletePin($id);
	    $this->session->set_flashdata('msg', '<div class="alert alert-success">Deleted Succesfully</div>');
	    return redirect('Vendor/ViewShipping');
	} else {
	    echo show_404();
	}
    }

    public function ViewShipping() {
	$this->load->helper('destination');
	$this->load->view('config/header', array('title' => 'View delivery area'));
	$this->load->view('config/sidebar', array('active' => 'shipping', 'action' => ''));
	$vendor = $this->vendor->loadShip($this->userid);


	$this->load->view('viewShip', array('ship' => $vendor));

	$this->load->view('config/footer');
    }

    public function file_check_one($str) {
	$allowed_mime_type_arr = array('jpeg', 'jpg', 'pjpeg', 'png', 'x-png', 'JPG', 'JPEG', 'PNG');

	$mime = explode(".", $_FILES['pro_image1']['name']);
	$mime_count = count($mime);

	if (isset($_FILES['pro_image1']['name']) && $_FILES['pro_image1']['name'] != "") {
	    if (in_array($mime[$mime_count - 1], $allowed_mime_type_arr)) {
		return true;
	    } else {
		return false;
	    }
	} else {
	    return false;
	}
    }

    public function file_check_two($str) {
	$allowed_mime_type_arr = array('jpeg', 'jpg', 'pjpeg', 'png', 'x-png');

	$mime = explode(".", $_FILES['pro_image2']['name']);
	$mime_count = count($mime);

	if (isset($_FILES['pro_image2']['name']) && $_FILES['pro_image2']['name'] != "") {
	    if (in_array(strtolower($mime[$mime_count - 1]), $allowed_mime_type_arr)) {
		return true;
	    } else {
		return false;
	    }
	} else {
	    return false;
	}
    }

    public function file_check_three($str) {
	$allowed_mime_type_arr = array('jpeg', 'jpg', 'pjpeg', 'png', 'x-png');

	$mime = explode(".", $_FILES['pro_image3']['name']);
	$mime_count = count($mime);

	if (isset($_FILES['pro_image3']['name']) && $_FILES['pro_image3']['name'] != "") {
	    if (in_array(strtolower($mime[$mime_count - 1]), $allowed_mime_type_arr)) {
		return true;
	    } else {
		return false;
	    }
	} else {
	    return false;
	}
    }

    public function file_check_four($str) {
	$allowed_mime_type_arr = array('jpeg', 'jpg', 'pjpeg', 'png', 'x-png');

	$mime = explode(".", $_FILES['pro_image4']['name']);
	$mime_count = count($mime);

	if (isset($_FILES['pro_image4']['name']) && $_FILES['pro_image4']['name'] != "") {
	    if (in_array(strtolower($mime[$mime_count - 1]), $allowed_mime_type_arr)) {
		return true;
	    } else {
		return false;
	    }
	} else {
	    return false;
	}
    }

    public function file_check_five($str) {
	$allowed_mime_type_arr = array('jpeg', 'jpg', 'pjpeg', 'png', 'x-png');

	$mime = explode(".", $_FILES['pro_image5']['name']);
	$mime_count = count($mime);

	if (isset($_FILES['pro_image5']['name']) && $_FILES['pro_image5']['name'] != "") {
	    if (in_array(strtolower($mime[$mime_count - 1]), $allowed_mime_type_arr)) {
		return true;
	    } else {
		return false;
	    }
	} else {
	    return false;
	}
    }

    public function file_check_six($str) {

	$allowed_mime_type_arr = array('jpg', 'png', 'pdf', 'jpeg');
	$mime = explode(".", $_FILES['pro_image6']['name']);

	$mime_count = count($mime);
	if (isset($_FILES['pro_image6']['name']) && $_FILES['pro_image6']['name'] != "") {
	    if (in_array(strtolower($mime[$mime_count - 1]), $allowed_mime_type_arr)) {
		return true;
	    } else {
		return false;
	    }
	} else {
	    return false;
	}
    }

    public function file_check_seven($str) {

	$allowed_mime_type_arr = array('jpg', 'png', 'pdf', 'jpeg');
	$mime = explode(".", $_FILES['pro_image7']['name']);
	$mime_count = count($mime);

	if (isset($_FILES['pro_image7']['name']) && $_FILES['pro_image7']['name'] != "") {
	    if (in_array(strtolower($mime[$mime_count - 1]), $allowed_mime_type_arr)) {

		return true;
	    } else {
		return false;
	    }
	} else {
	    return false;
	}
    }

    public function uploadImages() {
	$this->load->library('form_validation');

	$this->form_validation->set_rules('pro_image1', '', 'callback_file_check_one');
	$this->form_validation->set_rules('pro_image2', '', 'callback_file_check_two');
	if (isset($_FILES['pro_image3'])) {
	    $this->form_validation->set_rules('pro_image3', '', 'callback_file_check_three');
	}
	if (isset($_FILES['pro_image4'])) {
	    $this->form_validation->set_rules('pro_image4', '', 'callback_file_check_four');
	}
	if (isset($_FILES['pro_image5'])) {
	    $this->form_validation->set_rules('pro_image5', '', 'callback_file_check_five');
	}
//        if (isset($_FILES['pro_image6'])) {
//            $this->form_validation->set_rules('pro_image6', '', 'callback_file_check_six');
//        } elseif (isset($_FILES['pro_image7'])) {
//            $this->form_validation->set_rules('pro_image7', '', 'callback_file_check_seven');
//        }
	$config['upload_path'] = 'uploads/original/';
	$config['allowed_types'] = 'jpg|png|pdf|jpeg|JPG|JPEG';
	$config['encrypt_name'] = TRUE;

	$productId = $this->encrypt->decode($this->security->xss_clean($this->input->post('pro')));

	$this->load->library('upload', $config);

	if ($this->form_validation->run() == true) {
	    $this->vendor->removeProImage($productId);
	    if ($this->upload->do_upload('pro_image1')) {
		$uploadData = $this->upload->data();
		$uploadedFile = $uploadData['file_name'];
		$this->vendor->addMoreImages($uploadedFile, $productId);
		$this->session->set_flashdata('pro1_msg', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">Product Image One Uploaded Succesfully</a></div></div>');
	    } else {
		$this->session->set_flashdata('pro1_msg', '<div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Product Image One Can not be uploaded </strong>
                                  <a href="#" class="alert-link link-underline">' . $this->upload->display_errors() . '</a></div></div>');
		return redirect('Vendor/addProductImages/' . $this->input->post('pro'));
	    }
	    if ($this->upload->do_upload('pro_image2')) {
		$uploadData = $this->upload->data();
		$uploadedFile = $uploadData['file_name'];
		$this->vendor->addMoreImages($uploadedFile, $productId);
		$this->session->set_flashdata('pro2_msg', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">Product Image two Uploaded Succesfully</a></div></div>');
	    } else {
		$this->session->set_flashdata('pro2_msg', '<div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! Product Image Two Can not be uploaded  </strong>
                                  <a href="#" class="alert-link link-underline">' . $this->upload->display_errors() . '</a></div></div>');
		return redirect('Vendor/addProductImages/' . $this->input->post('pro'));
	    }
	    if ($this->upload->do_upload('pro_image3')) {
		$uploadData = $this->upload->data();
		$this->vendor->addMoreImages($uploadedFile, $productId);

		$this->session->set_flashdata('pro3_msg', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">Product Image three Uploaded Succesfully</a></div></div>');
	    } else {
		$this->session->set_flashdata('pro3_msg', '<div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!  Product Image Two Can not be uploaded</strong>
                                  <a href="#" class="alert-link link-underline">' . $this->upload->display_errors() . '</a></div></div>');
		return redirect('Vendor/addProductImages/' . $this->input->post('pro'));
	    }
	    if ($this->upload->do_upload('pro_image4')) {
		$uploadData = $this->upload->data();
		$uploadedFile = $uploadData['file_name'];
		$this->vendor->addMoreImages($uploadedFile, $productId);
		$this->session->set_flashdata('pro4_msg', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">Product Image four Uploaded Succesfully</a></div></div>');
	    } else {
		$this->session->set_flashdata('pro4_msg', '<div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! Product Image four Can not be uploaded</strong>
                                  <a href="#" class="alert-link link-underline">' . $this->upload->display_errors() . '</a></div></div>');
		return redirect('Vendor/addProductImages/' . $this->input->post('pro'));
	    }
	    if ($this->upload->do_upload('pro_image5')) {
		$uploadData = $this->upload->data();
		$uploadedFile = $uploadData['file_name'];
		$this->vendor->addMoreImages($uploadedFile, $productId);
		$this->session->set_flashdata('pro5_msg', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">Product Image five Uploaded Succesfully</a></div></div>');
	    } else {
		$this->session->set_flashdata('pro5_msg', '<div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! Product Image five Can not be uploaded </strong>
                                  <a href="#" class="alert-link link-underline">' . $this->upload->display_errors() . '</a></div></div>');
		return redirect('Vendor/addProductImages/' . $this->input->post('pro'));
	    }
//            if (isset($_FILES['pro_image6'])) {
//                if ($this->upload->do_upload('pro_image6')) {
//                    $uploadData = $this->upload->data();
//                    $uploadedFile = $uploadData['file_name'];
//
//                    $this->vendor->addMoreImages($uploadedFile, $productId, $sta = 1);
//
//                    $this->session->set_flashdata('pro6_msg', '<div class="alert alert-success mb" role="alert">
//                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
//                            <div class="alert-body">
//                                <strong>Heads up! </strong>
//                                This <a href="#" class="alert-link link-underline">Brand Doc Uploaded Succesfully</a></div></div>');
//                } else {
//                    $this->session->set_flashdata('pro6_msg', '<div class="alert alert-danger mb" role="alert">
//                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
//                            <div class="alert-body">
//                                <strong>Brand Doc Can not be uploaded </strong>
//                                  <a href="#" class="alert-link link-underline">' . $this->upload->display_errors() . '</a></div></div>');
//                    return redirect('Vendor/addProductImages/' . $this->input->post('pro'));
//                }
//            }
//            if (isset($_FILES['pro_image7'])) {
//                if ($this->upload->do_upload('pro_image7')) {
//                    $uploadData = $this->upload->data();
//
//                    $uploadedFile = $uploadData['file_name'];
//
//                    $this->vendor->addMoreImages($uploadedFile, $productId, $sta = 1);
//                    $this->session->set_flashdata('pro7_msg', '<div class="alert alert-success mb" role="alert">
//                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
//                            <div class="alert-body">
//                                <strong>Heads up! </strong>
//                                This <a href="#" class="alert-link link-underline">Reciept Uploaded Succesfully</a></div></div>');
//                } else {
//                    $this->session->set_flashdata('pro7_msg', '<div class="alert alert-danger mb" role="alert">
//                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
//                            <div class="alert-body">
//                                <strong>Reciept  Can not be uploaded </strong>
//                                  <a href="#" class="alert-link link-underline">' . $this->upload->display_errors() . '</a></div></div>');
//                    return redirect('Vendor/addProductImages/' . $this->input->post('pro'));
//                }
//            }
	} else {
	    $this->session->set_flashdata('msg', '<div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! Please upload valid extension file</strong>
                                 </div></div>');
	    return redirect('Vendor/addProductImages/' . $this->input->post('pro'));
	}
	return redirect('Vendor/vendor_products');
    }

    public function zeya_vendor_order() {
	$data = json_decode($this->input->post('vendor'));
	$post = [];
	foreach ($data as $val) {
	    if ($val->name == "category" || $val->name == "sub_category") {
		$post[$val->name] = $this->encrypt->decode($this->security->xss_clean($val->value));
	    } elseif (strpos($val->name, '[]')) {
		$multi[$val->name][] = $this->security->xss_clean($val->value);
	    } else {
		$post[$val->name] = $this->security->xss_clean($val->value);
	    }
	}
	$prod_id = $this->encrypt->decode($post['prod_name']);
	$ven_id = $this->encrypt->decode($post['product_id']);
	$res = $this->vendor->zeyaVendorProduct($prod_id, $ven_id, $post);
	if ($res) {

	    $this->session->set_flashdata('msg', '<div class="p-3 mb-2 bg-success text-white"><h5>Product Assigned Successful.</h5></div>');
	} else {
	    $this->session->set_flashdata('msg', '<div class="p-3 mb-2 bg-danger text-white"><h5>Product Assigned Faild ! Try again</h5></div>');
	}
    }

    public function getVendorData() {
	$data = json_decode($this->input->post('vendor'));

	$post = [];

//        foreach ($data as $val) {
//            $post[] = array($val->name => $val->value);
//        }

	$multi = [];
	foreach ($data as $val) {
	    if ($val->name == "category" || $val->name == "sub_category") {
		$post[$val->name] = $this->encrypt->decode($this->security->xss_clean($val->value));
	    } elseif (strpos($val->name, '[]')) {
		$multi[$val->name][] = $this->security->xss_clean($val->value);
	    } else {
		$post[$val->name] = $this->security->xss_clean($val->value);
	    }
	}
	$attr = [];

	if ($multi != NULL) {
	    foreach ($multi["quantity[]"] as $qt_key => $qty) {
		$inerr = [];
		for ($i = 0; $i < $multi["total[]"][$qt_key]; $i++) {

		    $var = explode("|", $multi["propName{$qt_key}[]"][$i]);
		    $inerr[] = array("$var[0]" => $var[1]);
		}
		$attr["response"][] = array("attribute" => $inerr, "qty" => $qty, "changedPrice" => $multi["changePrice[]"][$qt_key]);
	    }
	}

	$desc = $this->security->xss_clean($this->input->post('pro_desc'));
	$config['upload_path'] = 'uploads/brand_doc/';
	$config['allowed_types'] = 'jpg|png';
	$config['encrypt_name'] = TRUE;
	$this->load->library('upload', $config);

	if ($attr != NULL) {
	    $id = $this->vendor->addProduct($post, $desc, $this->userid, json_encode($attr));
	} else {
	    $id = $this->vendor->addProduct($post, $desc, $this->userid, NULL);
	}


	$base = base_url() . 'Vendor/addProductImages/';
	echo <<<EOD
                
	 <div class="modal_back">
		<div class="modalbox success col-sm-8 col-md-6 col-lg-5 center animate">
			<div class="icon">
				<span class="glyphicon glyphicon-ok"></span>
			</div>
			<!--/.icon-->
			<h1>Success!</h1>
			<p>Your product has been listed in our database
				<br>for verification.</p>
                        <button type="button" onclick="window.location.href='$base{$this->encrypt->encode($id)}'" class="redo btn">Upload Images</button>
			 
		 
	 
	</div> 
</div>
EOD;
    }

    public function getAllProp() {

	$category = $this->encrypt->decode($this->input->post('category'));
	$sub_category = $this->encrypt->decode($this->input->post('sub_category'));
	$rs = $this->vendor->getProductCategories($category, $sub_category);
	echo json_encode($rs);
    }

//    public function addVendorProducts() {
//        $this->load->library('form_validation');
//        $this->form_validation->set_rules('pro_image', '', 'callback_file_check');
//
//        if ($this->form_validation->run() == true) {
//            $config['upload_path'] = 'uploads/original/';
//            $config['allowed_types'] = 'jpg|png';
//            $config['encrypt_name'] = TRUE;
//            $this->load->library('upload', $config);
//
//            if ($this->upload->do_upload('pro_image')) {
//                $uploadData = $this->upload->data();
//                $uploadedFile = $uploadData['file_name'];
//                $this->resize($uploadedFile);
//                $this->thumbnail($uploadedFile);
//
//
//                $data = $this->security->xss_clean($this->input->post());
//
//                $return = $this->admin->addVendorProducts($data, $uploadedFile, $this->userid);
//                if ($return) {
//                    $this->session->set_flashdata('insert', '<div class="alert alert-success mb" role="alert">
//                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
//                            <div class="alert-body">
//                                <strong>Heads up! </strong>
//                                This <a href="#" class="alert-link link-underline">Data inserted successfully.</a></div></div>');
//                } else {
//                    $this->session->set_flashdata('insert', '<div class="alert alert-danger mb" role="alert">
//                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
//                            <div class="alert-body">
//                                <strong>Heads up! </strong>
//                                This <a href="#" class="alert-link link-underline">Insertion failed</a></div></div>');
//                }
//                $this->session->set_flashdata('msg', '<div class="alert alert-success mb" role="alert">
//                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
//                            <div class="alert-body">
//                                <strong>Heads up! </strong>
//                                This <a href="#" class="alert-link link-underline">Image has been uploaded successfully.</a></div></div>');
//            } else {
//                $this->session->set_flashdata('msg', '<div class="alert alert-success mb" role="alert">
//                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
//                            <div class="alert-body">
//                                <strong>Heads up! </strong>
//                                This <a href="#" class="alert-link link-underline">' . $this->upload->display_errors() . '</a></div></div>');
//            }
//
//
//            return redirect('Vendor/addProducts');
//        } else {
//            return redirect('Vendor/addProducts');
//        }
//    }

    private function resize($image) {
	$this->load->library('image_lib');
	$config['width'] = '300';
	$config['height'] = '300';
	$config['source_image'] = './uploads/original/' . $image;
	$config['new_image'] = './uploads/resized/resized_' . $image;
	$this->image_lib->initialize($config);
	if ($this->image_lib->resize()) {
	    $this->thumbnail($image);
	} else {
	    echo $this->image_lib->display_errors();
	}
    }

    private function thumbnail($image) {
	$this->load->library('image_lib');
	$config['width'] = '100';
	$config['height'] = '100';
	$config['maintain_ratio'] = TRUE;
	$config['create_thumb'] = TRUE;
	$config['source_image'] = './uploads/original/' . $image;
	$config['new_image'] = './uploads/thumbs/thumb_' . $image;
	$this->image_lib->initialize($config);
	if (!$this->image_lib->resize()) {
	    echo $this->image_lib->display_errors();
	}
    }

    public function file_check($str) {
	$allowed_mime_type_arr = array('jpeg', 'jpg', 'pjpeg', 'png', 'x-png');

	$mime = explode(".", $_FILES['pro_image']['name']);
	$mime_count = count($mime);

	if (isset($_FILES['pro_image']['name']) && $_FILES['pro_image']['name'] != "") {
	    if (in_array($mime[$mime_count - 1], $allowed_mime_type_arr)) {
		return true;
	    } else {
		$this->session->set_flashdata('msg', '<div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                This <a href="#" class="alert-link link-underline">Please select only   jpg/png file.</a></div></div>');
		return false;
	    }
	} else {
	    $this->session->set_flashdata('msg', '<div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                This <a href="#" class="alert-link link-underline">Please choose a file to upload.</a></div></div>');
	    return false;
	}
    }

    public function files_check($str) {
	$allowed_mime_type_arr = array('jpeg', 'jpg', 'pjpeg', 'png', 'x-png');
	$mime = explode(".", $_FILES['file']['name']);
	$mime_count = count($mime);

	if (isset($_FILES['pro_image']['name']) && $_FILES['pro_image']['name'] != "") {
	    if (in_array($mime[$mime_count - 1], $allowed_mime_type_arr)) {
		return true;
	    } else {
		$this->session->set_flashdata('msg', '<div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                This <a href="#" class="alert-link link-underline">Please select only jpg/png file.</a></div></div>');
		return false;
	    }
	} else {
	    $this->session->set_flashdata('msg', '<div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                This <a href="#" class="alert-link link-underline">Please choose a file to upload.</a></div></div>');
	    return false;
	}
    }

    // is service or product
    public function getCategoryInfo() {
	$id = $this->encrypt->decode($this->input->post('category'));
	$data = $this->admin->load_categories_id($id);
	if ($data->type == "service") {
	    echo "1";
	} else {
	    echo "0";
	}
    }

    public function getSub() {
	$id = $this->encrypt->decode($this->input->post('category'));
	$sub = $this->admin->load_subcategories($id);

	$subcategories = '';
	if (count($sub) > 0) {
	     $subcategories = "<option value=''>Select sub-category</option>";
	    foreach ($sub as $subc) {
		$subcategories .= '<option value="' . $this->encrypt->encode($subc->id) . '">' . $subc->sub_name . '</option>';
	    }
	} else {
	    $subcategories = "<option value=''>No sub-category</option>";
	}
	echo $subcategories;
    }

    public function zeya_getSub() {
	$id = $this->encrypt->decode($this->input->post('subcategory'));
	$prod = $this->admin->load_subcategories_prod($id);


	$subcategories = '';
	if (count($prod) > 0) {
	        $subcategories = "<option value=''>Select Products</option>";
	    foreach ($prod as $subc) {
		$subcategories .= '<option value="' . $this->encrypt->encode($subc->id) . '">' . $subc->pro_name . '</option>';
	    }
	} else {
	    $subcategories = "<option value=''>No Products</option>";
	}
	echo $subcategories;
    }

    public function vendor_products() {
	$this->load->view('config/header', array('title' => 'Your products'));
	$this->load->view('config/sidebar', array('active' => 'addproducts', 'action' => 'viewproducts'));
	$getProduct = $this->admin->loadVendorProduct($this->userid, $this->role);
	$this->load->view('requested_pro', array('product' => $getProduct));
	$this->load->view('config/footer');
    }
    public function zeya_vendor_products_view() {
	$this->load->view('config/header', array('title' => 'Your products'));
	$this->load->view('config/sidebar', array('active' => 'addproducts', 'action' => 'viewproducts'));
	$getProduct = $this->admin->zeyaLoadVendorProduct($this->userid,$this->role);	
	$this->load->view('zeyaVendorRequested_pro', array('product' => $getProduct));
	$this->load->view('config/footer');
    }

    public function BundleView() {
	$this->load->view('config/header', array('title' => 'Your products'));
	$this->load->view('config/sidebar', array('active' => 'addproducts', 'action' => 'viewproducts'));
	$getProduct = $this->admin->loadVendorProduct($this->userid, $this->role);
	$this->load->view('view_bundle', array('product' => $getProduct));
	$this->load->view('config/footer');
    }

    public function addBundles() {
	$this->load->view('config/header', array('title' => 'Please add products'));
	$this->load->view('config/sidebar', array('active' => 'addproducts', 'action' => 'addproducts'));
	$this->load->library('ckeditor');
	$ck = $this->ckeditor->loadCk(TRUE, 'pro_desc');
	$categories = $this->admin->load_categories();
	$max_id = $this->admin->getProductMaxid()->ID;
	$this->load->view('addBundles', array('categories' => $categories, 'ckeditor' => $ck, 'unique' => $max_id));
	$this->load->view('config/footer');
    }

    public function deleteRequestedProduct() {
	$data = $this->encrypt->decode($this->uri->segment(3));
	$dt = $this->vendor->deleteRequestedProduct($data);
	if ($dt) {
	    $this->session->set_flashdata("msg", "<div class='alert alert-success'>Deleted Successfully</div>");
	} else {
	    $this->session->set_flashdata("msg", "<div class='alert alert-danger'>Something Went Wrong</div>");
	}
	return redirect("Vendor/vendor_products");
    }
    public function zeya_vendor_deleteAssignedProduct() {
	$data = $this->encrypt->decode($this->uri->segment(3));
	
	$dt = $this->vendor->zeya_deleteRequestedProduct($data);
	if ($dt) {
	    $this->session->set_flashdata("msg", "<div class='alert alert-success'>Deleted Successfully</div>");
	} else {
	    $this->session->set_flashdata("msg", "<div class='alert alert-danger'>Something Went Wrong</div>");
	}
	return redirect("Vendor/zeya_vendor_products_view");
    }

    public function onlineQuery() {
	$this->load->view('config/header', array('title' => 'Online query'));
	$this->load->view('config/sidebar', array('active' => 'onlinequery', 'action' => 'onlinequery'));
	$guest_booking = $this->vendor->getOnlineBookings();

	$this->load->view('OnlineBooking', array('booking' => $guest_booking));
	$this->load->view('config/footer');
    }

    public function onlineQueryDetails() {
	$this->load->view('config/header', array('title' => 'Online query'));
	$this->load->view('config/sidebar', array('active' => 'onlinequery', 'action' => 'onlinequery'));
	$guest_booking = $this->vendor->getOnlineBookingsByID($this->uri->segment(3));

	$this->load->view('OnlineBookingDetails', array('booking' => $guest_booking));
	$this->load->view('config/footer');
    }

    public function report_datewise() 
    {
    	$this->load->view('config/header', array('title' => 'Datewise Reports'));
		$this->load->view('config/sidebar', array('active' => 'orders', 'action' => ''));

    	if($this->input->post('submit')){
    		$from = $this->input->post('from');
			$to = $this->input->post('to');
			$results = $this->vendor->data_search($from,$to);
			$this->load->view('datewise', array('results' => $results));

    	}else{
    		$this->load->view('datewise');
    	}

	$this->load->view('config/footer');
    }

 	//  public function datewise()
	// {
	// 	$post = $this->input->post();

	// 	unset($post['login']);

	// 	if($this->vendor->data_search($post))
	// 	{
	// 		return redirect('test/contact');
	// 	}
	// 	else
	// 	{
	// 		echo "Error Occured!!!";
	// 	}
	// }

}