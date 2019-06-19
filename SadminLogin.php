<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SadminLogin extends CI_Controller {

    public $role, $userid;

    public function __construct() {
	parent::__construct();
	$this->load->model('Admin_model', 'admin');
	$this->load->model('Vendor_model', 'vendor');
	$this->load->library('encrypt');
	if (!$this->session->userdata('signupSession')) {
	    return redirect('Loginvendor');
	} else {
	    $this->role = $this->session->userdata('signupSession')['role'];
	    $this->userid = $this->session->userdata('signupSession')['id'];
	    $this->load->helper('getinfo');
	}
    }

    public function editProductImage() {
	$id = (int) $this->encrypt->decode($this->input->post('name'));
	if ($id > 0) {
	    $config['upload_path'] = 'uploads/original';
	    $config['allowed_types'] = 'jpg|png|pdf';
	    $config['encrypt_name'] = TRUE;
	    $this->load->library('upload', $config);
	    if ($this->upload->do_upload('file')) {
		$uploadData = $this->upload->data();
		$query = $this->admin->updateImage($id, $uploadData['file_name']);
		echo $query;
	    } else {
		echo $this->upload->display_errors();
	    }
	} else {
	    echo show_404();
	}
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

    public function vendoraddproperties() {

	$selectProp = "";

	$results = $this->vendor->getProperties($this->encrypt->decode($this->input->post('category')), $this->encrypt->decode($this->input->post('subcategory')));
	$count = $this->input->post("co");
	$varCo = 0;
	foreach ($results as $key => $result) {
	    $prop_name = str_replace(" ", "_", $result->pop_name);
	    $selectProp .= <<<EOD
                    <td>
                         <select name="property{$count}[]" id="pd_attr">
                          <option value="">Select $result->pop_name</option>
                          {$this->get_innerAttribute($result->pid)}
                         </select>      
                    </td>
EOD;

	    $varCo++;
	}
	echo "<tr id='qtyval'>" . $selectProp . "<td> <input type='text' id='quantity' name='quantity[]' value=''/></td><td><button class='btn btn-xs btn-danger' onclick='deleteThis(this)'>Delete</button></td></tr>";
    }

    public function getCity() {
	$data = $this->security->xss_clean($this->input->post('state', TRUE));
	$state = ucfirst(strtolower($data));
	$stateArray = ($this->admin->getCity($state));
	if ($stateArray != NULL) {
	    $city = "";
	    foreach ($stateArray as $cities) {
		$city .= "<option value='$cities->city_name'>$cities->city_name</option>";
	    }
	    echo $city;
	} else {
	    echo "<option value=''>Select City</option>";
	}
    }

    public function rejectRequest() {




	if ($this->role == 1) {
	    $id = $this->encrypt->decode($this->input->post('ui_ig'));
	    $reject_reason = $this->security->xss_clean($this->input->post('reject_reason'));
	    $count = $this->admin->loadProductId($id);
	    if (count($count) > 0) {
		$this->admin->rejectRequest($id, $reject_reason);
		$this->session->set_flashdata('msg', ' <div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                This <a href="#" class="alert-link link-underline">Product has been rejected</a>
                            </div>
                        </div>');
	    } else {
		$this->session->set_flashdata('msg', ' <div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                This <a href="#" class="alert-link link-underline">No record to reject</a>
                            </div>
                        </div>');
	    }
	    return redirect('SadminLogin/requested_product');
	} else {
	    echo show_404();
	}
    }

    public function rejectRequestJq() {
	$string = base_url() . "SadminLogin/rejectRequest";
	$id = $this->input->post('id');
	echo form_open($string, array('method' => 'POST'));

	echo $html = <<<EOD
        <div style="position:fixed;margin:4% auto;left: 0;right: 0;z-index:99" class = "modal-dialog" role = "document">
        <div class = "modal-content">
        <div class = "modal-header">
        <button  onclick="$('#rejectPop').html('');" type = "button" class = "close" data-dismiss = "modal" aria-label = "Close"></button>
        <h4 class = "modal-title">Are you sure?</h4>
        </div>
        <div class = "modal-body">
              <div class="form-group">
                    <div class="custom-checkbox custom-checkbox-success">
                      <label>Reject Reason</label>
                      <textarea name="reject_reason" required="" class="form-control" id="" cols="10" rows="5"></textarea>
               </div>
            </div>   
        <input type='hidden' name="ui_ig" value='$id'>
        </div>
        <div class = "modal-footer">
        <button type = "button" onclick="$('#rejectPop').html('');"  class = "btn btn-default btn-tc btn-sm btn-waves" data-dismiss = "modal">Close</button>
        <button type = "submit" class = "btn btn-sm">Save changes</button>
        </div>
        </div>
        </div>
     </form>
EOD;
    }

    public function acceptRequest() {
	if ($this->role == 1) {
	    $id = $this->encrypt->decode($this->uri->segment('3'));
	    $count = $this->admin->loadProductId($id);
	    if (count($count) > 0) {
		$this->admin->acceptRequest($id);
		$this->session->set_flashdata('msg', ' <div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                This <a href="#" class="alert-link link-underline">Product has been accepted</a>
                            </div>
                        </div>');
	    } else {
		$this->session->set_flashdata('msg', ' <div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                This <a href="#" class="alert-link link-underline">No record to accept</a>
                            </div>
                        </div>');
	    }
	    return redirect('SadminLogin/requested_product');
	} else {
	    echo show_404();
	}
    }

    public function dashboard() {
	$this->load->view('config/header', array('title' => 'Welcome to dashboard'));
	$this->load->view('config/sidebar', array('active' => 'dashboard', 'action' => ''));
	$this->load->view('index');
	$this->load->view('config/footer');
    }

    public function uploadDocs() {
	$vendor_id = $this->input->post('hd_im');   //getting vendor   id

	$this->load->model('Vendor_model', 'vendor');
	switch ($this->input->post('type')) {
	    case "addProof":
		if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {
		    $config['upload_path'] = 'uploads/addressProof/';
		    $config['allowed_types'] = 'jpg|png|pdf';
		    $config['encrypt_name'] = TRUE;
		    $this->load->library('upload', $config);
		    if ($this->upload->do_upload('file')) {
			$uploadData = $this->upload->data();
			$query = $this->vendor->setUploadDoc("addProof", $uploadData['file_name'], $this->encrypt->decode($vendor_id));
			echo $query;
		    } else {
			echo $this->upload->display_errors();
		    }
		}

		break;
	    case "panCard":
		if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {
		    $config['upload_path'] = 'uploads/panCard/';
		    $config['allowed_types'] = 'jpg|png|pdf';
		    $config['encrypt_name'] = TRUE;
		    $this->load->library('upload', $config);
		    if ($this->upload->do_upload('file')) {
			$uploadData = $this->upload->data();
			$query = $this->vendor->setUploadDoc("panCard", $uploadData['file_name'], $this->encrypt->decode($vendor_id));
			echo $query;
		    } else {
			echo $this->upload->display_errors();
		    }
		}

		break;
	    case "profilePic":
		if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {
		    $config['upload_path'] = 'uploads/profilePic/';
		    $config['allowed_types'] = 'jpg|png|pdf';
		    $config['encrypt_name'] = TRUE;
		    $this->load->library('upload', $config);
		    if ($this->upload->do_upload('file')) {
			$uploadData = $this->upload->data();
			$query = $this->vendor->setUploadDoc("profilePic", $uploadData['file_name'], $this->encrypt->decode($vendor_id));
			echo $query;
		    } else {
			echo $this->upload->display_errors();
		    }
		}

		break;
	    case "gstDoc":
		if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {
		    $config['upload_path'] = 'uploads/gstDoc/';
		    $config['allowed_types'] = 'jpg|png|pdf';
		    $config['encrypt_name'] = TRUE;
		    $this->load->library('upload', $config);
		    if ($this->upload->do_upload('file')) {
			$uploadData = $this->upload->data();
			$query = $this->vendor->setUploadDoc("gstDoc", $uploadData['file_name'], $this->encrypt->decode($vendor_id));
			echo $query;
		    } else {
			echo $this->upload->display_errors();
		    }
		}

		break;
	    case "signature":
		if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {
		    $config['upload_path'] = 'uploads/signature/';
		    $config['allowed_types'] = 'jpg|png|pdf';
		    $config['encrypt_name'] = TRUE;
		    $this->load->library('upload', $config);
		    if ($this->upload->do_upload('file')) {
			$uploadData = $this->upload->data();
			$query = $this->vendor->setUploadDoc("signature", $uploadData['file_name'], $this->encrypt->decode($vendor_id));
			echo $query;
		    } else {
			echo $this->upload->display_errors();
		    }
		}

		break;
	    case "cancelCheck":
		if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {
		    $config['upload_path'] = 'uploads/cancelCheck/';
		    $config['allowed_types'] = 'jpg|png|pdf';
		    $config['encrypt_name'] = TRUE;
		    $this->load->library('upload', $config);
		    if ($this->upload->do_upload('file')) {
			$uploadData = $this->upload->data();
			$query = $this->vendor->setUploadDoc("cancelCheck", $uploadData['file_name'], $this->encrypt->decode($vendor_id));
			echo $query;
		    } else {
			echo $this->upload->display_errors();
		    }
		}

		break;
	}
    }

    public function updateVendor() {
	$post_data = $this->input->post();
	$post_data = $this->security->xss_clean($post_data);
	$update = $this->admin->update_profile($post_data);
	if ($update) {
	    $msg = <<<EOD
                    <div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                This <a href="#" class="alert-link link-underline">Data Has Been Updated</a>
                            </div>
                        </div>
EOD;
	    $this->session->set_flashdata('msg', $msg);
	} else {
	    $msg = <<<EOD
                    <div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                This <a href="#" class="alert-link link-underline">Unable To Update</a>
                            </div>
                        </div>
EOD;
	    $this->session->set_flashdata('msg', $msg);
	}
	if ($this->role == 1) {
	    return redirect('SadminLogin/editVendor/' . $this->encrypt->decode($post_data['hidden_id']));
	} else {
	    return redirect('SadminLogin/editProfile');
	}
    }

    public function editVendor() {
	if ($this->role == 1) {
	    $this->load->helper('destination');
	    $id = (int) $this->security->xss_clean($this->uri->segment(3));
	    $data = ($this->admin->getInfoUser($id));
	    $this->load->view('config/header', array('title' => 'Please update vendor information'));
	    $this->load->view('config/sidebar', array('active' => 'profiles', 'action' => 'profilesview'));
	    $this->load->view('editVendor', array('vendor' => $data));
	    $this->load->view('config/footer');
	} else {
	    echo show_404();
	}
    }

    public function addAgents() {
	if ($this->role == 1) {
	    $this->load->helper('destination');
	    $this->load->view('config/header', array('title' => 'Please update vendor information'));
	    $this->load->view('config/sidebar', array('active' => 'profiles', 'action' => 'profilesview'));
	    $this->load->view('addVendor');
	    $this->load->view('config/footer');
	} else {
	    echo show_404();
	}
    }

    public function vendorCreation() {
	if ($this->role == 1) {
	    $post = $this->security->xss_clean($this->input->post());
	    $addressProof = "";
	    $pan_number = "";
	    $profile_pic = "";
	    $gst_doc = "";
	    $signature = "";
	    $can_cheque = "";
	    $is = 0;


	    if (isset($_FILES['add_proof']['name']) && $_FILES['add_proof']['name'] != "") {
		$config['upload_path'] = 'uploads/addressProof/';
		$config['allowed_types'] = 'jpg|png|jpeg|pdf';
		$config['encrypt_name'] = TRUE;
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('add_proof')) {
		    $uploadData = $this->upload->data();
		    $addressProof = $uploadData['file_name'];
		    $is++;
		} else {
		    $this->session->set_flashdata('insert1', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">' . $this->upload->display_errors() . '</a></div></div>');
		}
	    }
	    if (isset($_FILES['pan_number']['name']) && $_FILES['pan_number']['name'] != "") {
		$config['upload_path'] = 'uploads/panCard/';
		$config['allowed_types'] = 'jpg||jpeg|png';
		$config['encrypt_name'] = TRUE;
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('pan_number')) {
		    $uploadData = $this->upload->data();
		    $pan_number = $uploadData['file_name'];
		    $is++;
		} else {
		    $this->session->set_flashdata('insert2', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong> Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">' . $this->upload->display_errors() . '</a></div></div>');
		}
	    }
	    if (isset($_FILES['profile_pic']['name']) && $_FILES['profile_pic']['name'] != "") {
		$config['upload_path'] = 'uploads/profilePic/';
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['encrypt_name'] = TRUE;
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('profile_pic')) {
		    $uploadData = $this->upload->data();
		    $profile_pic = $uploadData['file_name'];
		    $is++;
		} else {
		    $this->session->set_flashdata('insert3', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">' . $this->upload->display_errors() . '</a></div></div>');
		}
	    }
	    if (isset($_FILES['gst_doc']['name']) && $_FILES['gst_doc']['name'] != "") {
		$config['upload_path'] = 'uploads/gstDoc/';
		$config['allowed_types'] = 'jpg|jpeg|png|pdf';
		$config['encrypt_name'] = TRUE;
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('gst_doc')) {
		    $uploadData = $this->upload->data();
		    $gst_doc = $uploadData['file_name'];
		    $is++;
		} else {
		    $this->session->set_flashdata('insert4', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">' . $this->upload->display_errors() . '</a></div></div>');
		}
	    }
	    if (isset($_FILES['signature']['name']) && $_FILES['signature']['name'] != "") {
		$config['upload_path'] = 'uploads/signature/';
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['encrypt_name'] = TRUE;
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('signature')) {
		    $uploadData = $this->upload->data();
		    $signature = $uploadData['file_name'];
		    $is++;
		} else {
		    $this->session->set_flashdata('insert5', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">' . $this->upload->display_errors() . '</a></div></div>');
		}
	    }
	    if (isset($_FILES['can_cheque']['name']) && $_FILES['can_cheque']['name'] != "") {
		$config['upload_path'] = 'uploads/cheque/';
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['encrypt_name'] = TRUE;
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('can_cheque')) {
		    $uploadData = $this->upload->data();
		    $can_cheque = $uploadData['file_name'];
		    $is++;
		} else {
		    $this->session->set_flashdata('insert6', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">' . $this->upload->display_errors() . '</a></div></div>');
		}
	    }


	    if ($is == 6) {
		$post["addressProof"] = $addressProof;
		$post["pan_number"] = $pan_number;
		$post["profile_pic"] = $profile_pic;
		$post["gst_doc"] = $gst_doc;
		$post["signature"] = $signature;
		$post["can_cheque"] = $can_cheque;

		$data = $this->admin->addUserInfo($post);
	    }
	    if ($data) {
		//  $this->sendPasswordToUser($data, $post['new_password']);
		$msg = <<<EOD
                    <div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                This <a href="#" class="alert-link link-underline">Vendor entered successfully</a>
                            </div>
                        </div>
EOD;
		$this->session->set_flashdata('msg', $msg);
	    } else {
		$msg = <<<EOD
                    <div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                This <a href="#" class="alert-link link-underline">Please upload all the docs </a>
                            </div>
                        </div>
EOD;
		$this->session->set_flashdata('msg', $msg);
	    }
	    return redirect('SadminLogin/addAgents');
	} else {
	    echo show_404();
	}
    }

    public function deleteVendor() {
	if ($this->role == 1) {
	    $id = (int) $this->security->xss_clean($this->uri->segment(3));
	    if ($this->admin->deleteVendor($id)) {
		$msg = <<<EOD
                    <div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                This <a href="#" class="alert-link link-underline">Agent deleted successfully</a>
                            </div>
                        </div>
EOD;
		$this->session->set_flashdata('msg', $msg);
		return redirect('SadminLogin/profiles');
	    } else {
		echo show_404();
	    }
	} else {
	    echo show_404();
	}
    }

    public function profiles() {
	if ($this->role == 1) {
	    $this->load->view('config/header', array('title' => 'View vendor signup details'));
	    $this->load->view('config/sidebar', array('active' => 'profiles', 'action' => 'profilesview'));
	    $data = $this->admin->getVendorInfo($this->userid, $this->role);

	    $html = '';
	    $count = 1;
	    foreach ($data as $vendorData) {
		$editUrl = site_url("SadminLogin/editVendor/" . $vendorData->id);
		$deleteUrl = site_url("SadminLogin/deleteVendor/" . $vendorData->id);
		$passwordSet = $vendorData->allow_login == 0 ? " <a href='#' onclick=setFirstTimeAccess('$vendorData->id') class='btn btn-xs btn-warning'><i class='fa fa-check-circle-o'></i> Allow for login</a> " : "";
		$loginSet = ($vendorData->allow_login == 1 && $vendorData->allow_product == 0) ? " <a href='#' onclick=allowProduct('$vendorData->id') class='btn btn-xs btn-warning'><i class='fa fa-check-circle-o'></i> Allow for product</a> " : "";
		$customStyle = $vendorData->is_admin == 1 ? "style='background-color:green;color:#fff'" : '';
		$html .= <<<EOD
		       <tr>
			    <td>$count</td>
			    <td><a href="$editUrl" class=" btn btn-xs btn-success"> <i class="icon fa fa-edit"></i> Edit</a> <a href="$deleteUrl" onclick="return confirm('Are you sure!! you wanna delete this vendor')" class="btn btn-xs btn-danger"><i class=" fa fa-trash"></i> Delete</a>$passwordSet  $loginSet</td>
			    <td $customStyle> SHP-VEN-00$vendorData->id</td>                                           
			    <td $customStyle>$vendorData->fname $vendorData->lname</td>
			    <td $customStyle>$vendorData->emailadd</td>
			    <td $customStyle>$vendorData->contactno</td>
			    <td>$vendorData->state</td>
			    <td>$vendorData->city</td>
			    <td>$vendorData->zip</td>
			    <td>$vendorData->pan</td>
			</tr>
EOD;
		$count++;
	    }

	    $this->load->view('viewSignup', array('vendors' => $html));
	    $this->load->view('config/footer');
	} else {
	    echo show_404();
	}
    }

    public function addProperty() {


	$data = $this->admin->addProperty($this->input->post());
	if ($data == 1) {
	    $this->session->set_flashdata('msg', "<div class='alert alert-success'> Successfully entered </div>");
	} else {
	    $this->session->set_flashdata('msg', "<div class='alert alert-danger'>  Already in database </div>");
	}
	return redirect('SadminLogin/addProp');
    }

    public function getSubcategory() {
	$id = $this->input->post('cat_id');
	$result = $this->admin->load_subcategories($id);
	$html = "<option value=''>Select Sub</option>";
	foreach ($result as $rs) {
	    $html .= "<option value=" . $rs->id . ">$rs->sub_name</option>";
	}
	echo $html;
    }

    public function submitFirst() {

	if ($this->role == 1) {
	    $data = $this->admin->setFirstPassword($this->input->post(NULL, TRUE));
	    if ($data) {
		$msg = <<<EOD
                    <div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                This <a href="#" class="alert-link link-underline">Agent password has been set</a>
                            </div>
                        </div>
EOD;


		$mail = $this->sendPasswordToUser($this->input->post('ui_ig', TRUE), $this->input->post('vendor_pass', TRUE));
		$this->session->set_flashdata('msg', $msg);
		return redirect('SadminLogin/profiles');
	    }
	    $msg = <<<EOD
                    <div class="alert alert-danger mb" role="alert">
                   <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                  <a href="#" class="alert-link link-underline">Error! In Allow  process</a>
                            </div>
                        </div>
EOD;

	    $this->session->set_flashdata('msg', $msg);
	    return redirect('SadminLogin/profiles');
	} else {
	    echo show_404();
	}
	//   print_r(password_hash($this->input->post('vendor_pass'), PASSWORD_DEFAULT));
    }

    private function sendPasswordToUser($id) {
	if ($this->role == 1) {
	    $query = $this->admin->getInfoUser($id);
	    $to_email = $query->emailadd;
	    $subject = "Login Credentials For shoptrendy.in " . date("Y-m-d H:i");
	    $message = "Dear " . $query->fname . ",";
	    $message .= "<br><p>Thanks again to join us,Please find your login credentials";
	    $message .= "<br> Username : $query->contactno  ";
	    $message .= "<br><p>You need to enter these credentials on following page :(https://www.shoptrendy.in/Loginvendor)</p>";


	    if ($query) {
		$config = Array(
		    'mailtype' => 'html',
		    'charset' => 'utf-8'
		);
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->reply_to('vendors@shoptrendy.in', 'Vendors');
		$this->email->from('vendors@shoptrendy.in', 'Shoptrendy');
		$this->email->to($to_email);
		$this->email->bcc(array("shantanu@nibblesoftware.com"));
		$this->email->subject($subject);
		$this->email->message($message);

		$result = $this->email->send();
		if ($result) {
		    $msg = <<<EOD
                    <div class="alert alert-success mb" role="alert">
                           <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                  <a href="#" class="alert-link link-underline">Mail has been sent successfully </a>
                            </div>
                        </div>
EOD;

		    $this->session->set_flashdata('emailmsg', $msg);
		    return TRUE;
		}
		$msg = <<<EOD
                    <div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                  <a href="#" class="alert-link link-underline">Error! in mail</a>
                            </div>
                        </div>
EOD;

		$this->session->set_flashdata('emailmsg', $msg);
		return FALSE;
//            echo $this->email->print_debugger();
	    }
	} else {
	    echo show_404();
	}
    }

    public function editProfile() {

	$this->load->helper('destination');
	$id = (int) $this->security->xss_clean($this->session->userdata('signupSession')['id']);
	$data = ($this->admin->getInfoUser($id));
	$this->load->view('config/header', array('title' => 'Please update you profile'));
	$this->load->view('config/sidebar', array('active' => '', 'action' => ''));
	$this->load->view('editVendor', array('vendor' => $data));
	$this->load->view('config/footer');
    }

    public function allowForProduct() {
	if ($this->role == 1) {
	    $post = $this->input->post('data', TRUE);
	    $data = $this->admin->allowForProductUpload($post);
	    if ($data) {
		$this->session->set_flashdata('insert', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline"> Vendor allowed for prouct upload Process </a></div></div>');
	    } else {
		$this->session->set_flashdata('insert', '<div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline"> Something went wrong  </a></div></div>');
	    }
	} else {
	    echo show_404();
	}
    }

    public function setFirstTime() {
	if ($this->role == 1) {
	    $post = $this->input->post('data', TRUE);
	    $string = base_url() . "SadminLogin/submitFirst";
	    echo form_open($string, array('method' => 'POST'));
	    echo $html = <<<EOD
        <div class = "modal-dialog" role = "document">
        <div class = "modal-content">
        <div class = "modal-header">
        <button  onclick="$('#setMe').html('');" type = "button" class = "close" data-dismiss = "modal" aria-label = "Close"></button>
        <h4 class = "modal-title">Are you sure?</h4>
        </div>
        <div class = "modal-body">
       
              <div class="form-group">
                    <div class="custom-checkbox custom-checkbox-success">
                       <input checked type="checkbox" value="1" name="allow_ven">
                      <label>Allow this vendor to login</label>
               </div>
            </div>   
        <input type='hidden' name="ui_ig" value='$post'>
        </div>
        <div class = "modal-footer">
        <button type = "button" onclick="$('#setMe').html('');"  class = "btn btn-default btn-tc btn-sm btn-waves" data-dismiss = "modal">Close</button>
        <button type = "submit" class = "btn btn-sm">Save changes</button>
        </div>
        </div>
        </div>
     </form>
EOD;
	} else {
	    echo show_404();
	}
    }

    public function categories() {
	if ($this->role == 1) {
	    $this->load->view('config/header', array('title' => 'Categories Detail'));
	    $this->load->view('config/sidebar', array('active' => 'categories', 'action' => ''));
	    $data = $this->admin->load_categories();
	    $this->load->view('categories', array('data' => $data));
	    $this->load->view('config/footer');
	} else {
	    echo show_404();
	}
    }

    public function addCategory() {
	if ($this->role == 1) {
	    $post = $this->security->xss_clean($this->input->post());

	    $config['upload_path'] = 'uploads/category/original/';
	    $config['allowed_types'] = 'jpg|png';
	    $config['encrypt_name'] = TRUE;
	    $this->load->library('upload', $config);
	    if ($this->upload->do_upload('cat_image')) {
		$uploadData = $this->upload->data();
		$uploadedFile = $uploadData['file_name'];
		$this->resize($uploadedFile);
		$this->thumbnail($uploadedFile);
	    } else {
		$this->session->set_flashdata('insert', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">' . $this->upload->display_errors() . '</a></div></div>');
	    }
	    if ($this->admin->addCategory($post, $uploadedFile)) {
		$msg = <<<EOD
                    <div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                  <a href="#" class="alert-link link-underline">Category Inserted Successfully</a>
                            </div>
                        </div>
EOD;

		$this->session->set_flashdata('msg', $msg);
	    } else {
		$msg = <<<EOD
                    <div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                  <a href="#" class="alert-link link-underline">Error! in insertion</a>
                            </div>
                        </div>
EOD;

		$this->session->set_flashdata('msg', $msg);
	    }
	    return redirect('SadminLogin/categories');
	} else {
	    echo show_404();
	}
    }

    private function resize($image) {
	$this->load->library('image_lib');
	$config['image_library'] = 'gd2';
	$config['width'] = '1920';
	$config['height'] = '239';
	$config['source_image'] = './uploads/category/original/' . $image;
	$config['new_image'] = './uploads/category/resize/resized_' . $image;
	$this->image_lib->initialize($config);
	if ($this->image_lib->resize()) {
	    $this->thumbnail($image);
	} else {
	    echo $this->image_lib->display_errors();
	}
    }

    private function thumbnail($image) {
	$this->load->library('image_lib');
	$config['image_library'] = 'gd2';
	$config['width'] = '80';
	$config['height'] = '80';
	$config['maintain_ratio'] = TRUE;
	$config['create_thumb'] = TRUE;
	$config['source_image'] = './uploads/category/original/' . $image;
	$config['new_image'] = './uploads/category/thumbnail/thumb_' . $image;
	$this->image_lib->initialize($config);
	if (!$this->image_lib->resize()) {
	    echo $this->image_lib->display_errors();
	}
    }

    public function addsub() {
	if ($this->role == 1) {
	    $this->load->view('config/header', array('title' => 'Add Sub-Categories Detail'));
	    $categories = $this->admin->load_categories();
	    $this->load->view('config/sidebar', array('active' => 'addsubcategories', 'action' => ''));
	    $this->load->view('addSubCat', array('categories' => $categories));
	    $this->load->view('config/footer');
	} else {
	    echo show_404();
	}
    }

    public function addSubCategory() {
	$this->load->library('form_validation');
	$error = $this->form_validation->set_rules('sub_image', '', 'callback_file_check');
	if ($this->form_validation->run() == true) {
	    //upload configuration
	    $config['upload_path'] = 'uploads/subcategory/';
	    $config['allowed_types'] = 'jpg|png';
	    $config['encrypt_name'] = TRUE;
	    $this->load->library('upload', $config);
	    //upload file to directory
	    if ($this->upload->do_upload('sub_image')) {
		$uploadData = $this->upload->data();
		$uploadedFile = $uploadData['file_name'];
		$data = $this->security->xss_clean($this->input->post());
		$return = $this->admin->addSubcategory($data, $uploadedFile);
		if ($return) {
		    $this->session->set_flashdata('insert', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">Data inserted successfully.</a></div></div>');
		} else {
		    $this->session->set_flashdata('insert', '<div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">Insertion failed</a></div></div>');
		}
		$this->session->set_flashdata('msg', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">File has been uploaded successfully.</a></div></div>');
	    } else {
		$this->session->set_flashdata('msg', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">' . $this->upload->display_errors() . '</a></div></div>');
	    }
	    return redirect('SadminLogin/addsub');
	} else {
	    return redirect('SadminLogin/addsub');
	}
    }

    public function editCategory() {
	$catid = (int) $this->encrypt->decode($this->uri->segment(3), 'Test@123#');
	if ($catid != 0) {
	    $categories = $this->admin->load_categories_id($catid);
	} else {
	    echo show_404();
	}
	if (count($categories) > 0) {
	    $this->load->view('config/header', array('title' => 'Update Categories Detail'));
	    $this->load->view('config/sidebar', array('active' => 'categories', 'action' => ''));
	    $this->load->view('editcategory', array('data' => $categories));
	    $this->load->view('config/footer');
	} else {
	    echo show_404();
	}
    }

    public function updateCategory() {
	$image_name = "";
	$post = $this->security->xss_clean($this->input->post());
	if (isset($_FILES['cat_image']['name']) && $_FILES['cat_image']['name'] != "") {
	    $config['upload_path'] = 'uploads/category/original/';
	    $config['allowed_types'] = 'jpg|png';
	    $config['encrypt_name'] = TRUE;
	    $this->load->library('upload', $config);
	    if ($this->upload->do_upload('cat_image')) {
		$uploadData = $this->upload->data();
		$image_name = $uploadData['file_name'];
		$this->resize($image_name);
		$this->thumbnail($image_name);
	    }
	}
	$data = $this->admin->updateCategory($post, $image_name);
	if ($data) {
	    $this->session->set_flashdata('msg', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">Data updated successfully.</a></div></div>');
	} else {
	    $this->session->set_flashdata('msg', '<div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">Something went wrong.</a></div></div>');
	}
	return redirect('SadminLogin/categories');
    }

    public function file_check($str) {
	$allowed_mime_type_arr = array('jpeg', 'jpg', 'pjpeg', 'png', 'x-png');

	$mime = explode(".", $_FILES['sub_image']['name']);
	$mime_count = count($mime);

	if (isset($_FILES['sub_image']['name']) && $_FILES['sub_image']['name'] != "") {
	    if (in_array(strtolower($mime[$mime_count - 1]), $allowed_mime_type_arr)) {
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

    public function subCategory() {
	if ($this->role == 1) {
	    $uri = $this->encrypt->decode($this->uri->segment('3'), 'Test@123#');

	    if ($uri) {
		$this->load->view('config/header', array('title' => 'Sub-Categories Detail'));
		$this->load->view('config/sidebar', array('active' => 'subcategories', 'action' => ''));
		$data = $this->admin->load_subcategories($uri);
		$this->load->view('subcategories', array('data' => $data));
		$this->load->view('config/footer');
	    } else {
		echo show_404();
	    }
	} else {
	    echo show_404();
	}
    }

    public function editSubCategory() {
	if ($this->role == 1) {

	    $id = $this->encrypt->decode($this->uri->segment(3));

	    $categories = $this->admin->load_categories();
	    $this->load->view('config/header', array('title' => 'Sub-Categories Detail'));
	    $this->load->view('config/sidebar', array('active' => 'subcategories', 'action' => ''));
	    $data = $this->admin->loadedit_subcat($id);

	    $this->load->view('edit_sub', array('data' => $data, 'categories' => $categories, 'url' => $this->uri->segment(3)));
	    $this->load->view('config/footer');
	} else {
	    echo show_404();
	}
    }

    public function update_category() {
	$this->load->library('form_validation');
	$error = $this->form_validation->set_rules('sub_image', '', 'callback_file_check');
	if ($_FILES['sub_image']['name'] != '') {
	    if ($this->form_validation->run() == true) {
		$config['upload_path'] = 'uploads/subcategory/';
		$config['allowed_types'] = 'jpg|png';
		$config['encrypt_name'] = TRUE;
		$this->load->library('upload', $config);
		//upload file to directory
		if ($this->upload->do_upload('sub_image')) {
		    $uploadData = $this->upload->data();
		    $uploadedFile = $uploadData['file_name'];
		    $this->admin->update_category($this->security->xss_clean($this->input->post()), $uploadedFile);
		    $this->session->set_flashdata('insert', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">Data inserted successfully.</a></div></div>');
		} else {
		    $this->session->set_flashdata('msg', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">' . $this->upload->display_errors() . '</a></div></div>');
		}
	    }
	} else {
	    $this->admin->update_category($this->security->xss_clean($this->input->post()), $this->input->post('sub_image_two'));
	    $this->session->set_flashdata('insert', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline">Data inserted successfully.</a></div></div>');
	}
	return redirect('SadminLogin/editSubCategory/' . $this->input->post('hidden_id'));
    }

    public function deleteSubCategory() {
	if ($this->role == 1) {
	    $id = $this->encrypt->decode($this->uri->segment(3));
	    $data = $this->admin->deletesub($id);
	    if ($data) {
		$this->session->set_flashdata('msg', '<div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                This <a href="#" class="alert-link link-underline"></a>Record deleted successfully</div></div>');
	    } else {
		$this->session->set_flashdata('msg', '<div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up! </strong>
                                 <a href="#" class="alert-link link-underline"></a>Somethng went wrong</div></div>');
	    }
	} else {
	    echo show_404();
	}
	redirect("SadminLogin/subCategory/" . $this->uri->segment(3));
    }

    public function view_sub() {
	if ($this->role == 1) {
	    $this->load->view('config/header', array('title' => 'Sub-Categories Detail'));
	    $this->load->view('config/sidebar', array('active' => 'subcategories', 'action' => ''));
	    $data = $this->admin->load_subcategories($uri);
	    $this->load->view('subcategories', array('data' => $data));
	    $this->load->view('config/footer');
	} else {
	    echo show_404();
	}
    }

    public function deleteCategory() {
	if ($this->role == 1) {
	    $uri = $this->encrypt->decode($this->uri->segment('3'), 'Test@123$');

	    if ($this->admin->deleteCategory($uri)) {

		$msg = <<<EOD
                    <div class="alert alert-success mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                  <a href="#" class="alert-link link-underline">Deleted</a>
                            </div>
                        </div>
EOD;


		$this->session->set_flashdata('msg', $msg);
		return redirect('SadminLogin/categories');
	    } else {

		$msg = <<<EOD
                    <div class="alert alert-danger mb" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-body">
                                <strong>Heads up!</strong>
                                  <a href="#" class="alert-link link-underline">Error! in deletion</a>
                            </div>
                        </div>
EOD;

		$this->session->set_flashdata('msg', $msg);
		return redirect('SadminLogin/categories');
	    }
	} else {
	    echo show_404();
	}
    }

    public function requested_product() {
	if ($this->role == 1) {
	    $this->load->view('config/header', array('title' => 'Requested Products'));
	    $this->load->view('config/sidebar', array('active' => 'request_pro', 'action' => ''));
	    $data = $this->admin->loadVendorProductRequest();
	    $this->load->view('product_request', array('product' => $data));
	    $this->load->view('config/footer');
	} else {
	    echo show_404();
	}
    }

    public function viewProductRequest() {
	$this->load->view('config/header', array('title' => 'Requested Products'));
	$this->load->view('config/sidebar', array('active' => 'request_pro', 'action' => ''));
	$id = $this->encrypt->decode($this->uri->segment(3));
	$data = $this->admin->loadVendorProductRequestById($id);
	$this->load->view('viewProductRequest', array('product' => $data));
	$this->load->view('config/footer');
    }

    public function getImages() {
	$image = $this->encrypt->decode($this->uri->segment(3));

	$this->load->view('config/header', array('title' => 'All Images'));
	$this->load->view('config/sidebar', array('active' => 'request_pro', 'action' => ''));
	$images = $this->admin->getImages($image);
	$this->load->view('allImage', array('images' => $images));
	$this->load->view('config/footer');
    }

    public function deletename() {
	$id = (int) $this->encrypt->decode($this->uri->segment(3));
	if ($id > 0) {
	    $this->admin->deletePropName($id);
	    $this->session->set_flashdata('msg', "<div class='alert alert-danger'> Deleted Successfully</div>");
	    return redirect('SadminLogin/propName');
	} else {
	    echo show_404();
	}
    }

    public function propname() {
	$this->load->library('form_validation');
	$properties = $this->admin->getPropertiesName();
	$this->form_validation->set_rules('propname', 'Property Name', 'required');
	if ($this->form_validation->run() == FALSE) {
	    if ($this->role == 1) {
		$this->load->view('config/header', array('title' => 'Set Properties Name'));
		$this->load->view('config/sidebar', array('active' => 'propname', 'action' => ''));

		$this->load->view('allProp', array('properties' => $properties));
		$this->load->view('config/footer');
	    } else {
		echo show_404();
	    }
	} else {
	    $propname = $this->security->xss_clean($this->input->post('propname'));
	    $query = $this->admin->setPropertiesName($propname);
	    $this->session->set_flashdata('msg', "<div class='alert alert-success'> Inserted Successfully</div>");
	    return redirect('SadminLogin/propName');
	}
    }

    public function deleteProp() {

	$id = (int) $this->encrypt->decode($this->uri->segment(3));
	if ($id > 0) {
	    $this->admin->deleteProp($id);
	    $this->session->set_flashdata('msg', '<div class="alert alert-success"> Deleted Successfully</div>');
	    return redirect('SadminLogin/addProp');
	} else {
	    echo show_404();
	}
    }

    public function deleteAttr() {

	$id = (int) $this->encrypt->decode($this->uri->segment(3));
	if ($id > 0) {
	    $this->admin->deleteAttr($id);
	    $this->session->set_flashdata('msg', '<div class="alert alert-success"> Deleted Successfully</div>');
	    return redirect('SadminLogin/addSubProp');
	} else {
	    echo show_404();
	}
    }

    public function addProp() {
	$this->load->library('form_validation');
	$this->load->view('config/header', array('title' => 'Set Properties Name'));
	$this->load->view('config/sidebar', array('active' => 'addproperties', 'action' => ''));
	$properties = $this->admin->getPropertiesName();
	$category = $this->admin->load_categories();
	$allProp = $this->admin->getAllProperties();
	$this->load->view('addProperties', array('properties' => $properties, 'categories' => $category, 'allProp' => $allProp));
	$this->load->view('config/footer');
    }

    public function addSubProp() {
	$this->load->library('form_validation');
	$this->load->view('config/header', array('title' => 'Set Attribute Name'));
	$this->load->view('config/sidebar', array('active' => 'attrname', 'action' => ''));
	$properties = $this->admin->getPropertiesName();
	$attr = $this->admin->getAttrName();

	$this->load->view('subprop', array('properties' => $properties, 'attr' => $attr));
	$this->load->view('config/footer');
    }

    public function addAttr() {
	$data = ($this->input->post());

	$this->admin->addAttr($data);
	return redirect('SadminLogin/addSubProp');
    }

    public function getProductProperties() {
	$prop = $this->encrypt->decode($this->uri->segment(3));
	$this->load->view('config/header', array('title' => 'All Images'));
	$this->load->view('config/sidebar', array('active' => 'request_pro', 'action' => ''));
	$properties = $this->admin->getProperties($prop);
	$this->load->view('allProductProp', array('properties' => $properties));
	$this->load->view('config/footer');
    }

    public function editPropAttrName() {
	$decodeId = $this->encrypt->decode($this->uri->segment(3));
	$data = $this->vendor->getProduct($decodeId)->product_attr;
	$productData = $this->vendor->getProduct($decodeId);
	$this->load->library('form_validation');
	$this->load->view('config/header', array('title' => 'Set Attribute Name'));
	$this->load->view('config/sidebar', array('active' => 'attrname', 'action' => ''));
	$this->load->view('editAttribute', array('properties' => $data, 'proid' => $this->uri->segment(3), "prodata" => $productData));
	$this->load->view('config/footer');
    }

    public function updatePropAttr() {

	$attr = [];
	$proid = $this->encrypt->decode($this->input->post("proid"));


	foreach ($this->input->post("quantity") as $qt_key => $qty) {
	    $inerr = [];
	    foreach ($this->input->post("property$qt_key") as $attributes) {
		$var = explode("|", $attributes);
		$inerr[] = array("$var[0]" => $var[1]);
	    }
	    $attr["response"][] = array("attribute" => $inerr, "qty" => $qty, "changedPrice" => "0");
	}

	$attributejson = json_encode($attr);

	$result = $this->vendor->updateAttr($proid, $attributejson);
	if ($result) {
	    $this->session->set_flashdata('msg', '<div class="alert alert-success"> Updated Successfully</div>');
	    return redirect('SadminLogin/editPropAttrName/' . $this->input->post("proid"));
	}
    }

    public function updatePropAttrName() {


	$pro_id = $this->encrypt->decode($this->input->post('proid'));
	$data = $this->vendor->getProduct($pro_id)->product_attr;

	$decode = (json_decode($data));
	foreach ($decode->response as $key => $response) {
	    $response->qty = $this->input->post('qty')[$key];
	}
	$qtychange = json_encode($decode);
	$this->vendor->updateProAttribute($pro_id, $qtychange);
	return redirect("Vendor/vendor_products");
    }

    public function deletePropAttrName() {
	$id = (int) $this->encrypt->decode($this->uri->segment(3));
	$index = (int) $this->encrypt->decode($this->uri->segment(4));
	$this->admin->deletePropAttrName($id, $index);
	$this->session->set_flashdata('msg', '<div class="alert alert-success"> Deleted Successfully</div>');
	return redirect('SadminLogin/requested_product');
    }

    public function logout() {
	session_destroy();
	return redirect('Loginvendor');
    }

}
