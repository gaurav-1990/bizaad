<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists("loadnavigation")) {

    function loadnavigation() {
        $CI = &get_instance();
        $CI->load->library('encrypt');
        $categories = $CI->db->get_where('tbl_categories', array('cat_sta' => 1))->result();
        $cat_contain = '';
        $base_url = base_url() . "Dashboard/getSearchCategory/";
        foreach ($categories as $cat_details) {
            $catid = $CI->encrypt->encode($cat_details->id, 'Shantanu@123#');
            $category_name = urlencode($cat_details->cat_name);
            $subcat = load_subcat($cat_details->id);
            $cat_contain .= <<<EOD
                    
             <li><a  href="$base_url$category_name/$catid">$cat_details->cat_name</a> 
              $subcat 
             </li>
EOD;
        }
        $container = <<<EOD
            <ul>$cat_contain</ul>    
EOD;
        return $container;
    }

}

if (!function_exists("load_subcat")) {


    function load_subcat($cat_id) {
        $CI = &get_instance();
        $CI->load->library('encrypt');
        $sub_cat = $CI->db->get_where('tbl_subcategory', array('cid' => $cat_id))->result();
        $subcat = '';
        $count = 0;
        if (count($sub_cat) % 4 == 0) {
            foreach ($sub_cat as $subcategory) {
                $subname = urlencode($subcategory->sub_name);
                $url = base_url() . "Dashboard/p_/$subname/" . $CI->encrypt->encode($cat_id) . "/" . $CI->encrypt->encode($subcategory->id, 'Shantanu@123#');
                if ($count == 0) {
                    $subcat .= "<ul>";
                }
                $count++;
                $subcat .= <<<EOD
                   <li> <a href="$url">$subcategory->sub_name</a> </li>
EOD;
                if ($count == 4) {
                    $subcat .= "</ul>";
                    $count = 0;
                }
            }
        } else {

            foreach ($sub_cat as $subcategory) {
                $subname = urlencode($subcategory->sub_name);
                $url = base_url() . "Dashboard/p_/$subname/" . $CI->encrypt->encode($cat_id) . "/" . $CI->encrypt->encode($subcategory->id, 'Shantanu@123#');
                if ($count == 0) {
                    $subcat .= "<ul>";
                }
                $count++;
                $subcat .= <<<EOD
                   <li> <a href="$url">$subcategory->sub_name</a> </li>
EOD;
                if ($count == 4) {
                    $subcat .= "</ul>";
                    $count = 0;
                }
            }
            $subcat .= "</ul>";
        }
        if (trim($subcat) != '') {
            return $sub = <<<EOD
         <ul> <li>  $subcat  </li>     </ul>
EOD;
        }
    }

}


if (!function_exists("load_images")) {

    function load_images($pro_id) {
        $CI = &get_instance();
       
        $sub_cat = $CI->db->get_where('tbl_pro_img', array('pro_id' => $pro_id))->result();

        if (count($sub_cat) > 0) {
            return $sub_cat[0]->pro_images;
        } else {
            return "no-image-404.jpg";
        }
    }

}
if (!function_exists("load_All_images")) {

    function load_All_images($pro_id) {
        $CI = &get_instance();
        $CI->load->library('encrypt');
        $sub_cat = $CI->db->get_where('tbl_pro_img', array('pro_id' => $pro_id, 'img_sta' => 0))->result();
        if (count($sub_cat) > 0) {
            return $sub_cat;
        } else {
            return "no-image-404.jpg";
        }
    }

}

if (!function_exists("load_all_related")) {

    function load_all_related($pro_id, $cat_name, $sub_cat, $pro_name) {
        $CI = &get_instance();
        $sub_cat = $CI->db->get_where('tbl_product', array('cat_id' => $cat_name, 'pro_sta=' => '1', "pro_stock!=" => 0, 'sub_id' => $sub_cat, 'id!=' => $pro_id))->result();
        if (count($sub_cat) > 0) {
            return $sub_cat;
        } else {
            return "no-image-404.jpg";
        }
    }

}

if (!function_exists("order_property")) {

    function order_property($pro_id, $order_id, $o_id) {
        $CI = &get_instance();
        $rs = $CI->db->select('*')->from('tbl_order_prop')->join('tbl_set_property', 'tbl_set_property.id=tbl_order_prop.tbl_set_prop_name')->join('tbl_prod_prop', 'tbl_set_property.attr_id=tbl_prod_prop.id')->where(array('o_id' => $o_id, 'pro_id' => $pro_id, 'order_id' => $order_id))->get();
        if (count($rs->result()) > 0) {
            return $rs->result()[0];
        }
    }

}

if (!function_exists("load_property")) {

    function load_property($pro_id) {
        $CI = &get_instance();
        $rs = $CI->db->select()->from('tbl_set_property')->where(array('prod_id' => $pro_id))->join('tbl_properties', 'tbl_properties.id=tbl_set_property.prop_id')->join('tbl_prop_name', 'tbl_properties.prop_name=tbl_prop_name.id')->group_by('pop_name')->get()->result();
        $inner = "";
        foreach ($rs as $re) {
            $val = $CI->encrypt->encode($re->prop_id);
            $innerHtml = load_sub_category($pro_id, $re->prop_id);

            $inner .= <<<EOD
                <div class="flex-m flex-w p-b-10">
                    <div class="s-text15 w-size15 t-center">
                       $re->pop_name
                    </div>
                     $innerHtml
                   
                </div>
EOD;
        }
        if (count($rs) > 0) {
            return $inner;
        }
    }

}

if (!function_exists("load_sub_category")) {

    function load_sub_category($pro_id, $prop_id) {
        $CI = &get_instance();

        $rs = $CI->db->select('*,tbl_set_property.id as ID')->from('tbl_set_property')->join('tbl_prod_prop', 'tbl_prod_prop.id=tbl_set_property.attr_id')->where(array('tbl_set_property.prod_id' => $pro_id, 'tbl_set_property.prop_id' => $prop_id))->get()->result();
        $option = "";
        foreach ($rs as $re) {
            $attr_id = $CI->encrypt->encode($re->ID);
            $option .= "<option value='{$attr_id}'>{$re->attr_name}</option>";
        }
        $html = "";
        $prop = $CI->encrypt->encode($prop_id);
        $html .= <<<EOD
         <div data-prop="$prop" class="rs2-select2 rs3-select2 bo4 of-hidden w-size16">
                        <select class="selection-2" name="size">
                            <option value="">Choose an option</option>
                            $option
                        </select>
                    </div>
EOD;
        return $html;
    }

}
 