<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Import_model extends CI_Model {

    private $_batchImport;

    public function __construct() {
        parent::__construct();
        
    }

    public function setBatchImport($batchImport) {
        $this->_batchImport = $batchImport;
    }

    // save data
    public function importData() {

        $data = $this->_batchImport;
        $this->db->insert_batch('vendor_invoice', $data);
    }

}

?>