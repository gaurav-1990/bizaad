<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function cke_initialize($data = array()) {

    $return = '';

    if (!defined('CI_CKEDITOR_HELPER_LOADED')) {

        define('CI_CKEDITOR_HELPER_LOADED', TRUE);
        $return = '<script type="text/javascript" src="' . base_url() . $data['path'] . '/ckeditor.js"></script>';
       // $return .= "<script type=\"text/javascript\">CKEDITOR_BASEPATH = '" . base_url() . $data['path'] . "/';</script>";
    }

    return $return;
}

/**
 * This function create JavaScript instances of CKEditor
 * @author Samuel Sanchez 
 * @access private
 * @param array $data (default: array())
 * @return string
 */
function cke_create_instance($data = array()) {

    $return = "<script type=\"text/javascript\">
     	CKEDITOR.replace('" . $data['id'] . "', {";

    //Adding config values
    if (isset($data['config'])) {
        foreach ($data['config'] as $k => $v) {

            // Support for extra config parameters
            if (is_array($v)) {
                $return .= $k . " : [";
                $return .= config_data($v);
                $return .= "]";
            } else {
                $return .= $k . " : '" . $v . "'";
            }
            $var = array_keys($data['config']);
            if ($k !== end($var)) {
                $return .= ",";
            }
        }
    }

    $return .= '});</script>';

    return $return;
}

/**
 * This function displays an instance of CKEditor inside a view
 * @author Samuel Sanchez 
 * @access public
 * @param array $data (default: array())
 * @return string
 */
function display_ckeditor($data = array()) {
    // Initialization
    $return = cke_initialize($data);

    // Creating a Ckeditor instance
    $return .= cke_create_instance($data);


    // Adding styles values
    if (isset($data['styles'])) {

        $return .= "<script type=\"text/javascript\">CKEDITOR.addStylesSet( 'my_styles_" . $data['id'] . "', [";


        foreach ($data['styles'] as $k => $v) {

            $return .= "{ name : '" . $k . "', element : '" . $v['element'] . "', styles : { ";

            if (isset($v['styles'])) {
                foreach ($v['styles'] as $k2 => $v2) {

                    $return .= "'" . $k2 . "' : '" . $v2 . "'";
                    $stylevar = array_keys($v['styles']);
                    if ($k2 !== end($stylevar)) {
                        $return .= ",";
                    }
                }
            }

            $return .= '} }';
            $stylevar2 = array_keys($data['styles']);
            if ($k !== end($stylevar2)) {
                $return .= ',';
            }
        }

        $return .= ']);';

        $return .= "CKEDITOR.instances['" . $data['id'] . "'].config.stylesCombo_stylesSet = 'my_styles_" . $data['id'] . "';
		</script>";
    }

    return $return;
}

/**
 * config_data function.
 * This function look for extra config data
 *
 * @author ronan
 * @link http://kromack.com/developpement-php/codeigniter/ckeditor-helper-for-codeigniter/comment-page-5/#comment-545
 * @access public
 * @param array $data. (default: array())
 * @return String
 */
function config_data($data = array()) {
    $return = '';
    foreach ($data as $key) {
        if (is_array($key)) {
            $return .= "[";
            foreach ($key as $string) {
                $return .= "'" . $string . "'";
                $var = array_values($key);
                if ($string != end($var))
                    $return .= ",";
            }
            $return .= "]";
        }
        else {
            $return .= "'" . $key . "'";
        }
        $var2 = array_values($data);
        if ($key != end($var2))
            $return .= ",";
    }
    return $return;
}
