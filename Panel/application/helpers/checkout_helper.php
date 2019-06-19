<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
if (!function_exists('getProductImage')) {

    function getProductImage($id) {
        $CI = &get_instance();
        return $CI->db->get_where('tbl_pro_img', array('pro_id' => $id))->result()[0]->pro_images;
    }

}
if (!function_exists('getProduct')) {

    function getProduct($id) {
        $CI = &get_instance();
        return $CI->db->get_where('tbl_product', array('id' => $id))->result()[0];
    }

}
if (!function_exists('getAttrName')) {

    function getAttrName($id) {
        $CI = &get_instance();
        $res = $CI->db->select('*')->from('tbl_set_property')->join('tbl_prod_prop', 'tbl_prod_prop.id=tbl_set_property.attr_id')->where(array('tbl_set_property.id' => $id))->get()->result();
        return $res[0]->attr_name;
    }

}