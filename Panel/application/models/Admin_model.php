<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getVendorInfo($id, $role) {
        if ($role == 1) {
            return $this->db->get_where('tbl_signups', array('otp_verify' => 3))->result();
        }
    }

    public function allowForProductUpload($id) {
        return $this->db->update('tbl_signups', array('allow_product' => 1), array('id' => $id));
    }

    public function checkEmail($str) {
        $count = $this->db->get_where('tbl_signups', array('emailadd' => $str))->result();

        if (count($count) > 0) {
            return TRUE;
        }
        return FALSE;
    }

    public function getByEmail($str) {
        $rs = $this->db->get_where('tbl_signups', array('emailadd' => $str))->result();

        return $rs;
    }

    public function deletePropName($id) {
        $this->db->delete('tbl_prop_name', array('id' => $id));
    }

    public function getPropertiesName() {
        return $this->db->get('tbl_prop_name')->result();
    }

    public function setPropertiesName($propname) {
        return $this->db->insert('tbl_prop_name', array('pop_name' => $propname));
    }

    public function updateImage($id, $image) {
        $query = $this->db->update('tbl_pro_img', array('pro_images' => $image, 'insertTime' => date('Y-m-d H:i:s')), array('id' => $id));
        if ($query) {
            return 1;
        }return 0;
    }

    public function deletePropAttrName($id, $index) {
        $pro = $this->db->get_where('tbl_product', array('id' => $id))->result()[0];
        $attr = json_decode($pro->product_attr);
        unset($attr->response[$index]);
        $al = json_encode($attr);
        $this->db->update("tbl_product", array("product_attr" => $al), array("id" => $id));
    }

    public function getProperties($prod_id) {
        return $this->db->get_where('tbl_product', array('id' => $prod_id))->result()[0];
    }

    public function getProductMaxid() {
        return $this->db->query("select Max(id) as ID from tbl_product")->result()[0];
    }

    public function deleteProp($id) {
        $this->db->delete('tbl_properties', array('id' => $id));
    }

    public function deleteAttr($id) {
        $this->db->delete('tbl_prod_prop', array('id' => $id));
    }

    public function getAttrName() {
        return $this->db->select('*,tbl_prod_prop.id as attr_id')->from('tbl_prod_prop')->join('tbl_prop_name', 'tbl_prop_name.id=tbl_prod_prop.prop_id')->get()->result();
    }

    public function getAllProperties() {
        return $this->db->select('*,tbl_properties.id as propId')->from('tbl_properties')->join('tbl_prop_name', 'tbl_prop_name.id=tbl_properties.prop_name')->join('tbl_categories', 'tbl_categories.id=tbl_properties.prop_cat')->join('tbl_subcategory', 'tbl_subcategory.id=tbl_properties.sub_cat')->get()->result();
    }

    public function addAttr($data) {
        $this->db->insert('tbl_prod_prop', array('prop_id' => $data['prop_id'], 'attr_name' => $data['attr_name']));
    }

    public function addProperty($data) {
        $res = $this->db->get_where('tbl_properties', array('prop_name' => $data['prop_name'], 'prop_cat' => $data['prop_cat'], 'sub_cat' => $data['sub_cat']))->result();
        if (count($res) == 0) {
            $this->db->insert('tbl_properties', array('prop_name' => $data['prop_name'], 'prop_cat' => $data['prop_cat'], 'is_man' => isset($data['is_man']) ? 1 : 0, 'sub_cat' => $data['sub_cat']));
            return 1;
        } return 0;
    }

    public function addSubcategory($data, $image) {
        return $this->db->insert('tbl_subcategory', array('cid' => $data['cat_sub'], "cod" => $data["cod"], 'sub_name' => $data['sub_category'], "percentage" => $data["percentage"], 'sub_desc' => $data['sub_cat_desc'], 'sub_img' => $image, 'sub_title' => $data['sub_title'], 'sub_meta_desc' => $data['sub_meta_desc'], 'sub_meta_key' => $data['sub_meta_key']));
    }

    public function load_subcategories($id) {

        return $this->db->get_where('tbl_subcategory', array('cid' => $id))->result();
    }
    
    public function load_subcategories_prod($id) {

        return $this->db->get_where('tbl_product', array('sub_id' => $id))->result();
    }

    public function loadedit_subcat($id) {
        return $this->db->get_where('tbl_subcategory', array('id' => $id))->result()[0];
    }

    public function update_profile($data) {

        $password = trim($data['new_password']);
        if ($password != NULL) {
            $query = $this->db->update('tbl_signups', array('fname' => $data['first_name'], 'lname' => $data['last_name'], "company" => $data['company'], "state" => $data['state'], "city" => $data['city'], "zip" => $data['zip'], "address" => $data['address'], "ship_address" => $data['ship_address'], "nature_business" => $data['nature_business'], "bankadd" => $data['bankadd'], "passw" => password_hash($data['new_password'], PASSWORD_DEFAULT), "gst" => $data['gst_no'], "nature_business" => $data['nature_business'], "bankname" => $data['bankname'], "holdername" => $data['holdername'], "accountnum" => $data['accountnum'], 'ifsc' => $data['ifsc'],'aboutUs' => $data['aboutUs']), array('id' => $this->encrypt->decode($data['hidden_id'])));
        } else {
            $query = $this->db->update('tbl_signups', array('fname' => $data['first_name'], 'lname' => $data['last_name'], "company" => $data['company'], "state" => $data['state'], "city" => $data['city'], "zip" => $data['zip'], "address" => $data['address'], "ship_address" => $data['ship_address'], "nature_business" => $data['nature_business'], "bankadd" => $data['bankadd'], "passw" => $data['dummy'], "gst" => $data['gst_no'], "bankname" => $data['bankname'], "nature_business" => $data['nature_business'], "holdername" => $data['holdername'], "accountnum" => $data['accountnum'], 'ifsc' => $data['ifsc'],'aboutUs' => $data['aboutUs']), array('id' => $this->encrypt->decode($data['hidden_id'])));
        }

        if ($query) {
            return TRUE;
        }
        return FALSE;
    }

    public function deletesub($id) {
        return $this->db->delete('tbl_subcategory', array('id' => $id));
    }

    public function loadVendorProductRequest() {
        return $this->db->select('*,tbl_product.id as pro_id')->from('tbl_product')->join('tbl_signups', 'tbl_signups.id=tbl_product.vendor_id')->order_by("tbl_product.id", "desc")->get()->result();
    }

    public function loadVendorProductRequestById($id) {
        return $this->db->select('*,tbl_product.id as pro_id,tbl_product.gst as GST')->from('tbl_product')->join('tbl_signups', 'tbl_signups.id=tbl_product.vendor_id')->join('tbl_categories', 'tbl_categories.id=tbl_product.cat_id')->join('tbl_subcategory', 'tbl_subcategory.id=tbl_product.sub_id')->where('tbl_product.id', $id)->get()->result()[0];
    }

    public function getImages($image) {
        return $this->db->get_where('tbl_pro_img', array('pro_id' => $image))->result();
    }

    public function rejectRequest($id, $rejectReason) {
        $this->db->update('tbl_product', array('pro_sta' => 2, 'reject_reason' => $rejectReason, 'reject_time' => date('Y-m-d H:i')), array('id' => $id));
    }

    public function acceptRequest($id) {
        $this->db->update('tbl_product', array('pro_sta' => 1), array('id' => $id));
    }

    public function getCity($state) {
        return $this->db->select('*')->from('cities')->where('city_state LIKE "%' . $state . '%" ')->order_by('city_name', 'asc')->get()->result();
    }

    public function loadProductId($id) {
        return $this->db->get_where('tbl_product', array('id' => $id))->result();
    }

    public function update_category($data, $image) {
        $id = $this->encrypt->decode($data['hidden_id']);

        $this->db->update('tbl_subcategory', array('cid' => $data['cat_sub'], 'sub_name' => $data['sub_category'], 'sub_desc' => $data['sub_cat_desc'], "percentage" => $data["percentage"], 'sub_img' => $image, 'sub_title' => $data['sub_title'], "cod" => $data["cod"], 'sub_meta_desc' => $data['sub_meta_desc'], 'sub_meta_key' => $data['sub_meta_key']), array('id' => $id));
    }

    public function loadVendorProduct($id, $role) {
        if ($role == 1) {

            return $this->db->select('*,tbl_product.id as ID')->from('tbl_product')->join('tbl_subcategory', 'tbl_subcategory.id=tbl_product.sub_id')->join('tbl_categories', 'tbl_product.cat_id=tbl_categories.id')->get()->result();
        } else {
            return $this->db->select('*,tbl_product.id as ID')->from('tbl_product')->join('tbl_subcategory', 'tbl_subcategory.id=tbl_product.sub_id')->join('tbl_categories', 'tbl_product.cat_id=tbl_categories.id')->where('vendor_id', $id)->get()->result();
        }
    }
    public function zeyaLoadVendorProduct($id,$role) {
	
         if ($role != 1) {	
         return $this->db->select('*,tbl_vendor_order.act_price as a_price,tbl_vendor_order.dis_price as d_price,tbl_vendor_order.gst as GST,tbl_vendor_order.pro_stock as p_stock,tbl_vendor_order.in_stock as avail,tbl_vendor_order.id as ID,')->from('tbl_vendor_order')->join('tbl_categories','tbl_vendor_order.cat_id=tbl_categories.id')->join('tbl_subcategory','tbl_vendor_order.sub_id=tbl_subcategory.id')->join('tbl_product','tbl_vendor_order.prod_id=tbl_product.id')->where('tbl_vendor_order.vendor_id',$id)->get()->result();
    }else{
	 return $this->db->select('*,tbl_vendor_order.act_price as a_price,tbl_vendor_order.dis_price as d_price,tbl_vendor_order.gst as GST,tbl_vendor_order.pro_stock as p_stock,tbl_vendor_order.in_stock as avail,tbl_vendor_order.id as ID,')->from('tbl_vendor_order')->join('tbl_categories','tbl_vendor_order.cat_id=tbl_categories.id')->join('tbl_subcategory','tbl_vendor_order.sub_id=tbl_subcategory.id')->join('tbl_product','tbl_vendor_order.prod_id=tbl_product.id')->join('tbl_signups','tbl_signups.id=tbl_vendor_order.vendor_id')->get()->result();
    }
    }
//    
//    public function zeyagetVendorDetails($id){
//	return $this->db->select('*')->from('tbl_signups')->where('id',$id)->get()->result()[0];
//    }

    public function addVendorProducts($post, $image, $vendor) {
        $category = $this->encrypt->decode($post['category']);
        $sub_category = $this->encrypt->decode($post['sub_category']);
        $query = $this->db->insert('tbl_product', array('cat_id' => $category, 'gst' => $post['gst'], 'pro_date' => date('Y-m-d H:i:s'), 'vendor_id' => $vendor, 'sub_id' => $sub_category, 'pro_img' => $image, 'pro_name' => $post['product_name'], 'pro_stock' => $post['pro_stock'], 'in_stock' => $post['in_stock'], 'act_price' => $post['act_price'], 'dis_price' => $post['dis_price'], 'pro_desc' => $post['pro_desc'], 'pro_sta' => 0));
        $last_id = $this->db->insert_id();
        if ($post['pro_prop']) {
            foreach ($post['pro_prop'] as $key => $pro_prop) {
                $subid = explode("_", $post['sub_prop'][$key]);
                $is_price = isset($post['is_price'][$key]) ? 1 : 0;
                $change_price = (isset($post['is_price'][$key]) && $post['is_price'][$key] == 1) ? (($post['prop_price'][$key] != '') ? $post['prop_price'][$key] : $post['act_price']) : $post['act_price'];
                $this->db->insert('tbl_product_prop', array('prop_id' => $pro_prop, 'sub_id' => $subid[1], 'pro_id' => $last_id, 'is_price_change' => $is_price, 'change_price' => $change_price));
            }
        }
        return $query;
    }

    public function addUserInfo($data) {

        // $query = $this->db->insert('tbl_signups', array('fname' => $data['first_name'], 'lname' => $data['last_name'], "contactno" => $data['contact_no'], "emailadd" => $data['email_id'], "company" => $data['company'], "state" => $data['state'], "city" => $data['city'], "zip" => $data['zip'], "address" => $data['address'], "passw" => password_hash($data['new_password'], PASSWORD_DEFAULT), "pan" => $data['pan_no'], "tin" => $data['tin'], "gst" => $data['gst_no']));
        $query = $this->db->insert('tbl_signups', array("passw" => password_hash($data["password"], PASSWORD_BCRYPT), 'fname' => $data['first_name'], 'lname' => $data['last_name'],"aboutUs" => $data['aboutUs'], "contactno" => $data['contact_no'], "emailadd" => $data['email_id'], "company" => $data['company'], "state" => $data['state'], "city" => $data['city'], "zip" => $data['zip'], "address" => $data['address'], "pan" => $data['pan_no'], "tin" => $data['tin'], "otp_verify" => 3, "gst" => $data['gst_no'], "addProof" => $data["addressProof"], "panCard" => $data["pan_number"], "profilePic" => $data["profile_pic"], "gstDoc" => $data["gst_doc"], "signature" => $data["signature"], "cancelCheck" => $data["can_cheque"], "allow_product" => 1, "allow_login" => 1));
        $last_id = $this->db->insert_id();
	$qry = $this->db->select('*')->from('tbl_categories')->get()->result();
	foreach ($qry as $value) {
	    $q = $this->db->insert('vendor_assigned_category', array("user_id" => $last_id, "cate_id" => $value->id));
  
	}
	
	if ($query) {
            return TRUE;
        }
        // return $this->db->insert_id();
        return FALSE;
    }

    public function setFirstPassword($data) {

        $iss_allow = $data['allow_ven'] ? $data['allow_ven'] : 0;
        $data = $this->db->update('tbl_signups', array('allow_login' => $iss_allow), array('id' => $data['ui_ig']));
        if ($data)
            return true;
        return false;
    }

    public function updatePassword($password, $id) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $data = $this->db->update('tbl_signups', array('passw' => $password), array('id' => $id));
        if ($data)
            return true;
        return false;
    }

    public function getInfoUser($id) {
        return $data = $this->db->get_where('tbl_signups', array('id' => $id))->result()[0];
    }

    public function deleteVendor($id) {
        $data = $this->db->delete('tbl_signups', array('id' => $id));
        if ($data)
            return true;
        return FALSE;
    }

    public function checkLogin($posted) {
        $username = ($posted['login']['username']);
        $password = ($posted['login']['password']);

        $query = $this->db->get_where('tbl_signups', array('contactno' => $username, 'allow_login' => '1'));
        if ($query->num_rows() > 0) {
            $data = $query->result()[0];
            if (password_verify($password, $data->passw)) {

                return array('id' => $data->id, 'email' => $data->emailadd, 'role' => $data->is_admin);
            }return FALSE;
        }return FALSE;
    }

    public function load_categories() {
        return $this->db->get('tbl_categories')->result();
    }
    public function load_vendor_cat($id) {
     return $this->db->select('*')->from('tbl_signups')->join('vendor_assigned_category', 'tbl_signups.id=vendor_assigned_category.user_id')->join('tbl_categories','vendor_assigned_category.cate_id=tbl_categories.id')->where('tbl_signups.id', $id)->get()->result();     
    }

    public function load_categories_id($id) {
        return $this->db->get_where('tbl_categories', array('id' => $id))->result()[0];
    }

    public function updateCategory($post, $image) {
        if ($image != '') {
            return $this->db->update('tbl_categories', array('cat_name' => $post['category'], 'cat_desc' => $post['cat_desc'], 'cat_image' => $image, "type" => $post["type"], 'cat_sta' => $post['cat_sta']), array('id' => $post['hid_id']));
        } else {
            return $this->db->update('tbl_categories', array('cat_name' => $post['category'], 'cat_desc' => $post['cat_desc'], "type" => $post["type"], 'cat_sta' => $post['cat_sta']), array('id' => $post['hid_id']));
        }
    }

    public function deleteCategory($id) {
        return $this->db->delete('tbl_categories', array('id' => $id));
    }

    public function addCategory($data, $image) {
        return $this->db->insert('tbl_categories', array('cat_name' => $data['category'], "type" => $data["type"], 'cat_desc' => $data['cat_desc'], 'cat_sta' => $data['cat_sta'], 'cat_image' => $image));
    }

}
