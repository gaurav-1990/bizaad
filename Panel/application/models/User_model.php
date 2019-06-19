<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function load_subcategories($id) {
        return $this->db->select('*,tbl_subcategory.id as subid')->from('tbl_subcategory')->join('tbl_categories', 'tbl_categories.id=tbl_subcategory.cid')->where('tbl_categories.id', $id)->get()->result();
    }

    public function getProList($pr) {
        return $this->db->select('*,tbl_product.id as id')->from("tbl_product")->join('tbl_categories', 'tbl_product.cat_id=tbl_categories.id')->join('tbl_subcategory', 'tbl_product.sub_id=tbl_subcategory.id')->like('pro_name', $pr, 'both')->where('pro_sta', '1')->or_like("cat_name", $pr, 'both')->or_like("sub_name", $pr, 'both')->where('pro_stock>=', '1')->get()->result();

//       
    }

    public function getAwb($id) {
        return $this->db->get_where('tbl_order', array('id' => $id))->result();
    }

    public function getZip($zip) {
        $data = $this->db->get_where('tbl_ecom_zip', array('zip_address' => $zip))->result();
        echo count($data);
    }

    public function products($category, $subcategory) {
        return $this->db->select('*,tbl_product.id as ID')->from('tbl_product')->where(array('cat_id' => $category, 'sub_id' => $subcategory))->join('tbl_categories', 'tbl_product.cat_id=tbl_categories.id')->join('tbl_signups', 'tbl_signups.id=tbl_product.vendor_id')->where(array('tbl_product.pro_sta' => 1))->group_by('tbl_product.pro_name')->get()->result();
    }

    public function getOneProducts($id) {
        return $this->db->select('*,tbl_product.id as ID')->from('tbl_product')->where(array('tbl_product.id' => $id))->join('tbl_categories', 'tbl_product.cat_id=tbl_categories.id')->join('tbl_subcategory', 'tbl_product.sub_id=tbl_subcategory.id')->join('tbl_signups', 'tbl_signups.id=tbl_product.vendor_id')->where(array('tbl_product.pro_sta' => 1))->get()->result();
    }

    public function insertAwb($awb) {
        $this->db->insert("tbl_awb", array("awb_no" => $awb, "datentime" => date('Y-m-d H:i:s')));
    }

    public function getProduct($id) {
        return $this->db->get_where('tbl_product', array('id' => $id))->result()[0];
    }

    public function getfeaturedProdduct() {
        return $this->db->select('*')->from("tbl_feature_product")->join("tbl_product", 'tbl_feature_product.pro_id=tbl_product.id')->join('tbl_categories', 'tbl_product.cat_id=tbl_categories.id')->join('tbl_subcategory', 'tbl_product.sub_id=tbl_subcategory.id')->join('tbl_signups', 'tbl_signups.id=tbl_product.vendor_id')->get()->result();
    }

    public function getnewProdduct() {
        return $this->db->select('*')->from("tbl_new_products")->join("tbl_product", 'tbl_new_products.pro_id=tbl_product.id')->join('tbl_categories', 'tbl_product.cat_id=tbl_categories.id')->join('tbl_subcategory', 'tbl_product.sub_id=tbl_subcategory.id')->join('tbl_signups', 'tbl_signups.id=tbl_product.vendor_id')->get()->result();
    }

    public function getTopSeller() {
        return $this->db->select('*')->from("tbl_top_seller")->join("tbl_product", 'tbl_top_seller.pro_id=tbl_product.id')->join('tbl_categories', 'tbl_product.cat_id=tbl_categories.id')->join('tbl_subcategory', 'tbl_product.sub_id=tbl_subcategory.id')->join('tbl_signups', 'tbl_signups.id=tbl_product.vendor_id')->get()->result();
    }

    public function getProductImage($id) {
        $images = $this->db->get_where('tbl_pro_img', array('pro_id' => $id))->result();
        if (count($images) > 0) {
            return $images[0]->pro_images;
        } else {
            return "no-image.png";
        }
    }

    public function productPrice($id) {
        $result = $this->db->get_where('tbl_product', array('id' => $id))->result()[0];
        $price = ($result->dis_price != '' || $result->dis_price != 0) ? floatval($result->dis_price) : floatval($result->act_price);
        return $price;
    }

    public function getChangePrice($id) {
        $res = $this->db->get_where('tbl_set_property', array('id' => $id))->result();
        if (count($res) > 0) {
            return $res[0]->change_price != '' ? $res[0]->change_price : 0;
        } else {
            return 0;
        }
    }

    public function registration($post) {
        return $this->db->insert('tbl_user_reg', array('user_name' => $post['fullname'], 'user_email' => $post['username'], 'user_contact' => $post['contact'], 'user_password' => $post['cpassword'], 'user_dob' => $post['dob']));
    }

    public function get_profile($user) {
        return $this->db->get_where('tbl_user_reg', array('user_email' => $user))->result()[0];
    }

    public function get_profile_id($id) {
        return $this->db->get_where('tbl_user_reg', array('id' => $id))->result()[0];
    }

    public function update_password($id, $password) {
        return $this->db->update('tbl_user_reg', array('user_password' => $password), array('id' => $id));
    }

    public function allOrders($email) {
        return $this->db->select('*,tbl_order.id as or_id')->from('tbl_order')->join('tbl_customer_order', 'tbl_customer_order.id=tbl_order.order_id')->join('tbl_product', 'tbl_product.id=tbl_order.pro_id')->join('tbl_signups', 'tbl_signups.id=tbl_product.vendor_id')->where(array('registered_user' => $email, 'order_sta' => 0, "tbl_customer_order.pay_sta" => 1))->order_by("tbl_order.id ", "desc")->get()->result();
    }

    public function allOrdersOrderId($orderId) {
        return $this->db->select('*,tbl_order.id as or_id,tbl_user_invoice.id as invoiceid,tbl_product.gst as gst_per,tbl_signups.state as ven_state,,tbl_customer_order.state as cus_state')->from('tbl_order')->join('tbl_customer_order', 'tbl_customer_order.id=tbl_order.order_id')->join("tbl_user_invoice", "tbl_user_invoice.order_id=tbl_customer_order.id")->join('tbl_product', 'tbl_product.id=tbl_order.pro_id')->join('tbl_signups', 'tbl_signups.id=tbl_product.vendor_id')->join('tbl_subcategory', 'tbl_subcategory.id=tbl_product.sub_id')->where(array('tbl_order.id' => $orderId, 'tbl_customer_order.pay_sta' => 1))->get()->result();
    }
    public function zeya_allOrdersOrderId($orderId) {
	
     return $this->db->select('*,tbl_order.id as or_id,tbl_user_invoice.id as invoiceid,tbl_product.gst as gst_per,tbl_signups.state as ven_state,tbl_customer_order.state as cus_state,tbl_order.vendor_id as ven_id')->from('tbl_order')->join('tbl_customer_order', 'tbl_customer_order.id=tbl_order.order_id')->join("tbl_user_invoice", "tbl_user_invoice.order_id=tbl_customer_order.id")->join('tbl_product', 'tbl_product.id=tbl_order.pro_id')->join('tbl_signups', 'tbl_signups.id=tbl_product.vendor_id')->join('tbl_subcategory', 'tbl_subcategory.id=tbl_product.sub_id')->where(array('tbl_order.id' => $orderId, 'tbl_customer_order.pay_sta' => 1))->get()->result();

    }

    public function vendorInvoice($id, $from, $to) {
        return $this->db->select('*,tbl_order.id as or_id,tbl_product.gst as gst_per,tbl_signups.state as ven_state,,tbl_customer_order.state as cus_state')->from('tbl_order')->join('tbl_customer_order', 'tbl_customer_order.id=tbl_order.order_id')->join('tbl_product', 'tbl_product.id=tbl_order.pro_id')->join('tbl_signups', 'tbl_signups.id=tbl_product.vendor_id')->join('tbl_subcategory', 'tbl_subcategory.id=tbl_product.sub_id')->where('tbl_signups.id', $id)->where('tbl_customer_order.pay_sta', 1)->where('tbl_customer_order.pay_date >= ', $from)->where('is_invoiced', 0)->where('tbl_customer_order.pay_date <= ', $to)->get()->result();
    }

    public function getCancellationDetails($orderId) {
        return $this->db->select('*,tbl_order.id as or_id,tbl_product.gst as gst_per,tbl_signups.state as ven_state,,tbl_customer_order.state as cus_state')->from('tbl_order')->join('tbl_customer_order', 'tbl_customer_order.id=tbl_order.order_id')->join('tbl_product', 'tbl_product.id=tbl_order.pro_id')->join('tbl_signups', 'tbl_signups.id=tbl_product.vendor_id')->join('tbl_subcategory', 'tbl_subcategory.id=tbl_product.sub_id')->where(array('tbl_order.id' => $orderId))->get()->result();
    }

    public function cancelPayment($id) {
        return $this->db->update('tbl_customer_order', array('pay_sta' => 2), array('id' => $id));
    }

    public function getAllInnerOrder($id) {
        return $this->db->get_where('tbl_order', array('order_id' => $id))->result();
    }

    public function OrderTable($id) {
        return $this->db->get_where('tbl_order', array('id' => $id))->result()[0];
    }

    public function successPayment($id) {
        return $this->db->update('tbl_customer_order', array('pay_sta' => 1), array('id' => $id));
    }

    public function addInvoice($id) {
        return $this->db->insert('tbl_user_invoice', array('order_id' => $id, "invoice_date" => date("Y-m-d H:i:s")));
    }

    public function getsuccessPayment($id) {
        return $this->db->get_where('tbl_customer_order', array('id' => $id, 'pay_sta' => 1))->result()[0];
    }

    public function userorder($rg_email, $post, $order) {

        $this->db->insert('tbl_customer_order', array('registered_user' => $rg_email, 'user_email' => $post['user_email'], 'first_name' => $post['first_name'], 'last_name' => $post['last_name'], 'user_address' => $post['user_address'], "state" => $post['state'], "country" => $post['country'], 'user_city' => $post['user_city'], 'user_pin_code' => $post['user_pin_code'], 'pay_date' => date('Y-m-d H:i:s'), 'user_contact' => $post['user_contact']));
        $order_id = $this->db->insert_id();
        foreach ($order as $or) {
            $query = $this->db->insert('tbl_order', array('order_id' => $order_id, 'pro_id' => $or['product'], 'pro_qty' => $or['qty'], 'pro_price' => $or['total'], "order_prop" => $or['prop'], 'pay_date' => date('Y-m-d H:i:s')));
        }
        if ($query) {
            return $order_id;
        } else {
            return false;
        }
    }

    public function cancelThis($id, $data) {
//        $this->db->update('tbl_order', array('deliver' => 3), array('id' => $id));
        $this->db->update('tbl_order', array('deliver' => 3, 'cancel_comments' => $data), array('id' => $id));
    }

    public function deductFromInventory($order, $customerOrderId) {


        foreach ($order as $or) {
            $product = $or["product"];
            $pro = $this->db->get_where("tbl_product", array("id" => $product))->result()[0];
            $property = json_decode($pro->product_attr);
            $assa = json_decode($or["prop"])->attribute;
            $subtract = intval($or["qty"]);
            if ($assa != NULL) {
                foreach ($property->response as $as => $response) {
                    $var = 1;
                    foreach ($response->attribute as $key => $value) {
                        $objectKey = key((array) $value);
                        $asasKey = key((array) $assa[$key]);
                        if ($value->$objectKey == $assa[$key]->$asasKey) {
                            if ($var == count($assa)) {
                                $attr["attribute"] = $response->attribute;

                                $attr["qty"] = (string) (intval($response->qty) - $subtract);
                                $attr["changedPrice"] = $response->changedPrice != '' ? $response->changedPrice : 0;
                                unset($property->response[$as]);
                                $property->response[$as] = (object) $attr;
                                $res["response"] = array_values($property->response);
                                $update = json_encode($res);


                                $this->db->set('pro_stock', 'pro_stock-' . $subtract . '', false)
                                        ->where('id', $product)
                                        ->update('tbl_product');
                                break;
                            }
                            $var++;
                        }
                    }
                }
            } else {

                $this->db->set('pro_stock', 'pro_stock-' . $subtract . '', false)
                        ->where('id', $product)
                        ->update('tbl_product');
            }
        }
    }
    
    

}
