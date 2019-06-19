<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('getUserProfile')) {

    function getUserProfile($id) {
        $CI = &get_instance();
        if ($CI->session->userdata('signupSession')) {
            return $CI->db->get_where('tbl_signups', array('id' => $id))->result()[0];
        } else {
            return "No direct access";
        }
    }

}


if (!function_exists("getImageCount")) {

    function getImageCount($product) {
        $CI = &get_instance();
        $CI->load->model('Admin_model');
        if ($CI->Admin_model->getImages($product)) {
            return count($CI->Admin_model->getImages($product));
        } else {
            return 0;
        }
    }

}
if (!function_exists("getPropertyName")) {

    function getPropertyName($pop_name,$attr) {
        $CI = &get_instance();
        return  $CI->db->select("*")->from("tbl_prop_name")->join("tbl_prod_prop", "tbl_prop_name.id=tbl_prod_prop.prop_id")->where(array("tbl_prop_name.pop_name" => $pop_name,"tbl_prod_prop.attr_name!="=>$attr))->get()->result();
 
          }

}
if (!function_exists("getBrandCount")) {

    function getBrandCount($vendor_id, $isBranded, $brand_name) {
        $CI = &get_instance();
        $count = $CI->db->get_where('tbl_product', array('vendor_id' => $vendor_id, "isBranded" => 1, "brand_name" => $brand_name))->result();
        if (count($count) > 1) {
            return 1;
        } else {
            return 0;
        }
    }

}

if (!function_exists("numberTowords")) {

     
    function numberTowords($num) {
	
        $ones = array(
            1 => "one",
            2 => "two",
            3 => "three",
            4 => "four",
            5 => "five",
            6 => "six",
            7 => "seven",
            8 => "eight",
            9 => "nine",
            10 => "ten",
            11 => "eleven",
            12 => "twelve",
            13 => "thirteen",
            14 => "fourteen",
            15 => "fifteen",
            16 => "sixteen",
            17 => "seventeen",
            18 => "eighteen",
            19 => "nineteen"
        );
        $tens = array(
            1 => "ten",
            2 => "twenty",
            3 => "thirty",
            4 => "forty",
            5 => "fifty",
            6 => "sixty",
            7 => "seventy",
            8 => "eighty",
            9 => "ninety"
        );
        $hundreds = array(
            "hundred",
            "thousand",
            "million",
            "billion",
            "trillion",
            "quadrillion"
        ); //limit t quadrillion 
        $num = number_format($num, 2, ".", ",");
        $num_arr = explode(".", $num);
        $wholenum = $num_arr[0];
        $decnum = $num_arr[1];
        $whole_arr = array_reverse(explode(",", $wholenum));
        krsort($whole_arr);
        $rettxt = "";
	if(isset($whole_arr)){
	    foreach ($whole_arr as $key => $i) {		
            if ($i < 20) {
                $rettxt .= $ones[$i];
            } elseif ($i < 100) {
                $rettxt .= $tens[substr($i, 0, 1)];
                $rettxt .= " " . $ones[substr($i, 1, 1)];
            } else {
                $rettxt .= $ones[substr($i, 0, 1)] . " " . $hundreds[0];
                $rettxt .= " " . $tens[substr($i, 1, 1)];
                $rettxt .= " " . $ones[substr($i, 2, 1)];
            }
            if ($key > 0) {
                $rettxt .= " " . $hundreds[$key] . " ";
            }
        } 
	}
       
        if ($decnum > 0) {
            $rettxt .= " and ";
            if ($decnum < 20) {
                $rettxt .= $ones[$decnum];
            } elseif ($decnum < 100) {
                $rettxt .= $tens[substr($decnum, 0, 1)];
                $rettxt .= " " . $ones[substr($decnum, 1, 1)];
            }
        }
        return $rettxt;
    }

}


if (!function_exists("getVendorPro")) {

    function getVendorPro($vendor_id,$pro_id) {
        $CI = &get_instance();
        return $count = $CI->db->select("*,tbl_vendor_order.act_price as a_price,tbl_vendor_order.gst as gst_pro")->from('tbl_signups')->join('tbl_vendor_order','tbl_vendor_order.vendor_id=tbl_signups.id')->where(array('tbl_vendor_order.vendor_id' => $vendor_id,'tbl_vendor_order.prod_id' => $pro_id))->get()->result()[0];
       
    }

}
if (!function_exists("getVendor")) {

    function getVendor($vendor_id) {	
        $CI = &get_instance();
        return $CI->db->select('*')->from('tbl_signups')->where('id',$vendor_id)->get()->result()[0];
       
    }

}

//if (!function_exists("getVendorInfo")) {
//
//    function getVendorInfo($vendor_id,$pro_id) {
//        $CI = &get_instance();
//        return $count = $CI->db->select("*,tbl_vendor_order.act_price as a_price,tbl_vendor_order.gst as gst_pro")->from('tbl_signups')->join('tbl_vendor_order','tbl_vendor_order.vendor_id=tbl_signups.id')->where('tbl_vendor_order.vendor_id',$vendor_id)->get()->result()[0];
//       
//    }
//
//}



