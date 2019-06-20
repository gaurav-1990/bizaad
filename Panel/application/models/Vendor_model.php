<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor_model extends CI_Model {

    public $role, $userid;

    public function __construct() {
	parent::__construct();
	$this->load->library('encrypt');
	if (!$this->session->userdata('signupSession')) {
	    return redirect('Loginvendor');
	} else {
	    $this->role = $this->session->userdata('signupSession')['role'];
	    $this->userid = $this->session->userdata('signupSession')['id'];
	    $this->load->helper('getinfo');
	}
    }

    public function vendorInvoice($data) {
	$vendor = $data["vendor"];
	$year = $data["year"];
	$month = sprintf("%02d", $data["month"]);
	$fromdate = $year . "-" . $month . "-" . "01";
	$todate = $year . "-" . $month . "-" . "31";

	$this->db->where('inv_date >=', $fromdate);
	$this->db->where('inv_date <=', $todate);
	$this->db->where('vendor_id =', $vendor);
	$this->db->join('tbl_signups', 'tbl_signups.id=vendor_invoice.vendor_id');
	return $data = $this->db->select('*,tbl_signups.state as ven_state')->from('vendor_invoice')->get()->result();
    }

    public function addVendorShipping($post, $pins, $vendor_id) {

	$this->db->delete('tbl_ven_ship', array('ven_id' => $vendor_id, 'state' => $post['state'], 'city' => $post['city']));
	$this->db->insert('tbl_ven_ship', array('ven_id' => $vendor_id, 'state' => $post['state'], 'city' => $post['city'], 'max_days' => $post['max_days'], 'ship_amt' => $post['ship_amt'], 'same_amt' => $post['same_amt']));
	$id = $this->db->insert_id();

	foreach ($pins as $pin) {
	    $query = $this->db->insert('tbl_ven_ship_pin', array('ship_id' => $id, 'pin_code' => $pin));
	}
	if ($query)
	    return TRUE;
	return FALSE;
    }

    public function addAwb($orderId, $awb, $deliverSta) {
	return $this->db->update('tbl_order', array('awb_no' => $awb, 'deliver' => $deliverSta, "order_sta_time" => date('Y-m-d H:i:s')), array('id' => $orderId));
    }

    public function addAwbOther($orderId, $deliverSta) {
	return $this->db->update('tbl_order', array('deliver' => $deliverSta, "order_sta_time" => date('Y-m-d H:i:s')), array('id' => $orderId));
    }

    public function loadShip($vend) {
	return $this->db->get_where('tbl_ven_ship', array('ven_id' => $vend))->result();
    }

    public function deletePin($vend) {
	return $this->db->delete('tbl_ven_ship_pin', array('id' => $vend));
    }

    public function deleteCity($vend) {
	$this->db->delete('tbl_ven_ship', array('id' => $vend));
	$this->db->delete('tbl_ven_ship_pin', array('ship_id' => $vend));
	return TRUE;
    }

    public function deleteRequestedProduct($id) {
	return $this->db->delete('tbl_product', array('id' => $id));
    }
    public function zeya_deleteRequestedProduct($id) {
	return $this->db->delete('tbl_vendor_order', array('id' => $id));
    }

    public function loadZip($id) {
	return $this->db->get_where('tbl_ven_ship_pin', array('ship_id' => $id))->result();
    }

     public function userOrderByVendor($id) {
	if ($this->role == 1) {
	    return $this->db->select('*,tbl_order.id as OID')->from('tbl_order')->join('tbl_customer_order', 'tbl_order.order_id=tbl_customer_order.id')->join('tbl_product', 'tbl_product.id=tbl_order.pro_id')->join('tbl_signups', 'tbl_signups.id=tbl_product.vendor_id')->where(array("tbl_customer_order.pay_sta" => 1))->get();
	} else {
	    return $this->db->select('*,tbl_order.id as OID')->from('tbl_order')->join('tbl_customer_order', 'tbl_order.order_id=tbl_customer_order.id')->join('tbl_product', 'tbl_product.id=tbl_order.pro_id')->where(array('tbl_product.vendor_id' => $id, "tbl_customer_order.pay_sta" => 1))->get();
	}
    }
    
    public function ZeyauserOrderByVendor($id) {	
	if ($this->role == 1) {
	    return $this->db->select('*,tbl_order.id as OID,tbl_customer_order.vendor_id as ven_id')->from('tbl_order')->join('tbl_customer_order', 'tbl_order.order_id=tbl_customer_order.id')->join('tbl_product', 'tbl_product.id=tbl_order.pro_id')->where(array("tbl_customer_order.pay_sta" => 1 ))->get()->result();
	}else{
	     return $this->db->select('*,tbl_order.id as OID,tbl_customer_order.vendor_id as ven_id')->from('tbl_order')->join('tbl_customer_order', 'tbl_order.order_id=tbl_customer_order.id')->join('tbl_product', 'tbl_product.id=tbl_order.pro_id')->where(array("tbl_customer_order.vendor_id" =>$id ,"tbl_customer_order.pay_sta" => 1))->get()->result();
	} 
    }

    public function getProductCategories($cat, $subcat) {
	return $this->db->get_where('tbl_properties', array('prop_cat' => $cat, 'sub_cat' => $subcat, "is_man" => 1))->result();
    }

    public function getAttribute($cat) {
	return $this->db->get_where('tbl_prod_prop', array('prop_id' => $cat))->result();
    }

    public function getAttributeJoin($cat) {
	return $this->db->select('*')->from('tbl_prod_prop')->join('tbl_prop_name', 'tbl_prop_name.id=tbl_prod_prop.prop_id')->where("prop_id = $cat")->get()->result();
    }

    public function getProperties($cat, $subcat) {
	return $this->db->select('*,tbl_properties.id as ID,tbl_prop_name.id as pid')->from('tbl_properties')->join('tbl_prop_name', 'tbl_prop_name.id=tbl_properties.prop_name')->where(array('prop_cat' => $cat, 'sub_cat' => $subcat))->get()->result();
    }

    public function updateAttr($pro, $attr) {
	return $this->db->update("tbl_product", array("product_attr" => $attr), array("id" => $pro));
    }

    public function setUploadDoc($docType, $docName, $vendor) {

	switch ($docType) {
	    case "addProof":
		$q = $this->db->update('tbl_signups', array('addProof' => $docName), array('id' => $vendor));
		if ($q)
		    return 1;
		else
		    return 0;
		break;
	    case "panCard":
		$q = $this->db->update('tbl_signups', array('panCard' => $docName), array('id' => $vendor));
		if ($q)
		    return 1;
		else
		    return 0;
		break;
	    case "profilePic":
		$q = $this->db->update('tbl_signups', array('profilePic' => $docName), array('id' => $vendor));
		if ($q)
		    return 1;
		else
		    return 0;
		break;
	    case "gstDoc":
		$q = $this->db->update('tbl_signups', array('gstDoc' => $docName), array('id' => $vendor));
		if ($q)
		    return 1;
		else
		    return 0;
		break;
	    case "signature":
		$q = $this->db->update('tbl_signups', array('signature' => $docName), array('id' => $vendor));
		if ($q)
		    return 1;
		else
		    return 0;
		break;
	    case "cancelCheck":
		$q = $this->db->update('tbl_signups', array('cancelCheck' => $docName), array('id' => $vendor));
		if ($q)
		    return 1;
		else
		    return 0;
		break;
	}
//	$this->db->update('tbl_signups','')
    }

    public function properties() {
	return $this->db->get('tbl_property')->result();
    }

    public function getSubProp($prop) {
	return $this->db->get_where('tbl_subprop', array('prop_id' => $prop))->result();
    }

    public function checkisvalid($id) {
	$this->db->get_where('tbl_signups', array('id' => $id));
    }

    public function addMoreImages($filename, $produt_id, $sta = 0) {
	$this->db->insert('tbl_pro_img', array('pro_id' => $produt_id, "img_sta" => $sta, 'pro_images' => $filename, 'insertTime' => date('Y-m-d H:i:s')));
    }

    public function removeProImage($produt_id) {
	$this->db->delete('tbl_pro_img', array('pro_id' => $produt_id));
    }

    public function updateProducts($post, $id) {
	return $this->db->update('tbl_product', array('cat_id' => $this->encrypt->decode($post['category']), "sub_id" => $this->encrypt->decode($post['sub_category']), 'pro_name' => $post['product_name'], 'update_time' => date('Y-m-d H:i:s'), 'pro_stock' => $post['pro_stock'], 'in_stock' => $post['in_stock'], 'act_price' => $post['act_price'], 'dis_price' => $post['dis_price'], 'pro_desc' => $post['pro_desc'], 'pro_sta' => 0), array('id' => $id));
    }
    public function zeya_updateProducts($post, $id) {	
	return $this->db->update('tbl_vendor_order', array('cat_id' => $this->encrypt->decode($post['category']), "sub_id" => $this->encrypt->decode($post['sub_category']), 'update_time' => date('Y-m-d H:i:s'), 'pro_stock' => $post['pro_stock'], 'in_stock' => $post['in_stock'], 'act_price' => $post['act_price'], 'dis_price' => $post['dis_price'], 'in_stock' => $post['in_stock']), array('id' => $id));
    }

    public function updateConfirmedProducts($post, $id) {
	return $this->db->update('tbl_product', array("cat_id" => $post["category"], "sub_id" => $post["sub_category"], "pro_name" => $post["product_name"], 'update_time' => date('Y-m-d H:i:s'), 'pro_stock' => $post['pro_stock'], 'in_stock' => $post['in_stock'], 'act_price' => $post['act_price'], 'dis_price' => $post['dis_price'], 'pro_desc' => $post['pro_desc']), array('id' => $id));
    }

    public function getProduct($id) {
	return $this->db->get_where('tbl_product', array('id' => $id))->result()[0];
    }

    public function updateProAttribute($id, $pro_attr) {
	return $this->db->update('tbl_product', array('product_attr' => $pro_attr), array('id' => $id));
    }

    public function deleteMoreImage($produt_id) {
	$this->db->delete('tbl_pro_img', array('pro_id' => $produt_id));
    }

    public function checkProductValid($id) {
	return $this->db->select('*,tbl_product.id as ID')->from('tbl_product')->join('tbl_subcategory', 'tbl_subcategory.id=tbl_product.sub_id')->where(array('tbl_product.id' => $id))->get()->result();
    }
    public function zeya_vendor_checkProductValid($id) {
	return $this->db->select('*,tbl_product.id as ID,tbl_vendor_order.act_price as a_price,tbl_vendor_order.dis_price as d_price,tbl_vendor_order.pro_stock as p_stock')->from('tbl_product')->join('tbl_categories','tbl_product.cat_id=tbl_categories.id')->join('tbl_subcategory', 'tbl_subcategory.id=tbl_product.sub_id')->join('tbl_vendor_order', 'tbl_subcategory.id=tbl_vendor_order.sub_id')->where(array('tbl_vendor_order.id' => $id))->get()->result();
    }

    public function loadMoreImages($id) {
	return $this->db->get_where('tbl_pro_img', array('pro_id' => $id))->result();
    }

    public function addProduct($post, $desc, $vendor, $attr) {
	if ($attr != NULL) {
	    $query = $this->db->insert('tbl_product', array('vendor_id' => $vendor, "imei" => $post["imei"], 'hsn_code' => $post["hsn_code"], "product_attr" => $attr, 'cat_id' => $post['category'], 'isBranded' => $post['isBranded'], 'brand_name' => $post['brand_name'], 'sub_id' => $post['sub_category'], 'pro_name' => $post['product_name'], 'pro_stock' => $post['pro_stock'], 'in_stock' => $post['in_stock'], 'act_price' => $post['act_price'], 'dis_price' => $post['dis_price'], 'pro_desc' => $desc, 'pro_sta' => 0, 'gst' => $post['gst']));
	} else {
	    $query = $this->db->insert('tbl_product', array('vendor_id' => $vendor, "imei" => $post["imei"], 'hsn_code' => $post["hsn_code"], 'cat_id' => $post['category'], 'isBranded' => $post['isBranded'], 'brand_name' => $post['brand_name'], 'sub_id' => $post['sub_category'], 'pro_name' => $post['product_name'], 'pro_stock' => $post['pro_stock'], 'in_stock' => $post['in_stock'], 'act_price' => $post['act_price'], 'dis_price' => $post['dis_price'], 'pro_desc' => $desc, 'pro_sta' => 0, 'gst' => $post['gst']));
	}

	if ($query) {
	    return $this->db->insert_id();
	}

	return 0;
    }

    public function addProductProp($post, $product) {
	foreach ($post['pd_prop[]'] as $key => $value) {
	    $query = $this->db->insert('tbl_set_property', array('prod_id' => $product, 'prop_id' => $value, 'attr_id' => $post['pd_attr[]'][$key], 'change_price' => $post['changePrice[]'][$key], 'qty' => $post['quantity[]'][$key]));
	}
	if ($query) {
	    return 1;
	}
	return 0;
    }

    public function getOnlineBookings() {
	return $this->db->select('*,tbl_guest_booking.id as OID')->from('tbl_guest_booking')->join('tbl_product', 'tbl_product.id=tbl_guest_booking.product_id')->get()->result();
    }

    public function getOnlineBookingsByID($id) {
	return $this->db->select('*,tbl_guest_booking.id as OID')->from('tbl_guest_booking')->join('tbl_product', 'tbl_product.id=tbl_guest_booking.product_id')->where(array("tbl_guest_booking.id" => $id))->get()->result()[0];
    }

    public function zeyaVendorProduct($id,$ven_id,$post) {

	return $query = $this->db->insert('tbl_vendor_order', array('vendor_id' => $ven_id, 'cat_id' => $post['category'], 'sub_id' => $post['sub_category'], 'prod_id' => $id, 'isBrand' => $post['isBranded'], 'brand_name' => $post['brand_name'], 'pro_stock' => $post['pro_stock'], 'in_stock' => $post['in_stock'], 'act_price' => $post['act_price'], 'dis_price' => $post['dis_price'], 'gst' => $post['gst']));
    }

    public function data_search($date1,$date2)
	{
		$query = $this->db->select('*,tbl_order.id as OID,tbl_customer_order.vendor_id as ven_id')				->from('tbl_order')
						  ->join('tbl_customer_order', 'tbl_order.order_id=tbl_customer_order.id')
						  ->join('tbl_product', 'tbl_product.id=tbl_order.pro_id')
						  ->where(array("tbl_customer_order.pay_sta" => 1))
						  ->where('tbl_order.pay_date BETWEEN "'. date('Y-m-d 00:00:00', strtotime($date1)). '" and "'. date('Y-m-d 00:00:00', strtotime($date2)).'"')
						  ->get();

		return	$query->result();
			 
		// $query = $this->db->where('pay_date BETWEEN "'. date('Y-m-d', strtotime($date1)). '" and "'. date('Y-m-d', strtotime($date2)).'"')
		// 		->get('tbl_order');
			
		// $query=$this->db->query("select * from tbl_order where pay_date BETWEEN". $date1. "AND" .$date2);
		// return $query->result();
		// $query = $this->db->select('* from ')where('pay_date BETWEEN'. $date1. "AND" .$date2)
		// 				  ->get('tbl_order');
		// return $query->result();
	}

	public function search_result($date1,$date2)
	{
		$query = $this->db->select('*,tbl_guest_booking.id as OID')
		                  ->from('tbl_guest_booking')
						  ->join('tbl_product', 'tbl_product.id=tbl_guest_booking.product_id')
						  ->where('tbl_guest_booking.datentime BETWEEN "'. date('Y-m-d 00:00:00', strtotime($date1)). '" and "'. date('Y-m-d 00:00:00', strtotime($date2)).'"')
						  ->get();

		return	$query->result();

		//return $this->db->select('*,tbl_guest_booking.id as OID')->from('tbl_guest_booking')->join('tbl_product', 'tbl_product.id=tbl_guest_booking.product_id')->get()->result();

		//where('datentime BETWEEN "'. date('Y-m-d 00:00:00', strtotime($date1)). '" and "'. date('Y-m-d 00:00:00', strtotime($date2)).'"')->get('tbl_guest_booking');
	}

}
