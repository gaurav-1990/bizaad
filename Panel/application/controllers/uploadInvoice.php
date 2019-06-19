<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class uploadInvoice extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Import_model', "import");
    }

    // upload xlsx|xls file
    // import excel data
    public function save() {
        $this->load->library('excel');

        if ($this->input->post('importfile')) {
            $path = './Vendor_Invoice/';

            $config['upload_path'] = $path;
            $config['allowed_types'] = 'xlsx|xls|csv';
            $config['remove_spaces'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            
            if (!$this->upload->do_upload('userfile')) {
                $data = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
            }

            $fetchData = array();

            if (!empty($data['upload_data']['file_name'])) {
                $import_xls_file = $data['upload_data']['file_name'];
            } else {
                $import_xls_file = 0;
            }
            $inputFileName = $path . $import_xls_file;

            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                        . '": ' . $e->getMessage());
            }
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $vendorid = $this->input->post('vendor');

            $arrayCount = count($allDataInSheet);



            $createArray = array('inv_date', 'order_id', 'total_transaction', 'market_percentage', 'market_value', 'shipping_fee', 'gateway_fee', 'per_transaction_fee', 'total_fees', 'gst_rate', 'igst', 'cgst', 'sgst', 'tcs');
            $makeArray = array('inv_date' => 'inv_date', 'order_id' => 'order_id', 'total_transaction' => 'total_transaction', 'market_percentage' => 'market_percentage', 'market_value' => 'market_value', 'shipping_fee' => 'shipping_fee', 'gateway_fee' => 'gateway_fee', 'per_transaction_fee' => 'per_transaction_fee', 'total_fees' => 'total_fees', 'gst_rate' => 'gst_rate', 'igst' => 'igst', 'cgst' => 'cgst', 'sgst' => 'sgst', 'tcs' => 'tcs');
            $SheetDataKey = array();
            foreach ($allDataInSheet as $dataInSheet) {
                foreach ($dataInSheet as $key => $value) {
                    if (in_array(trim($value), $createArray)) {
                        $value = preg_replace('/\s+/', '', $value);
                        $SheetDataKey[trim($value)] = $key;
                    } else {
                        
                    }
                }
            }
            $data = array_diff_key($makeArray, $SheetDataKey);

            if (empty($data)) {
                $flag = 1;
            }
            if ($flag == 1) {
                for ($i = 2; $i <= $arrayCount; $i++) {

                    $inv_date = $SheetDataKey['inv_date'];

                    $order_id = $SheetDataKey['order_id'];
                    $total_transaction = $SheetDataKey['total_transaction'];
                    $market_percentage = $SheetDataKey['market_percentage'];
                    $market_value = $SheetDataKey['market_value'];
                    $shipping_fee = $SheetDataKey['shipping_fee'];
                    $gateway_fee = $SheetDataKey['gateway_fee'];
                    $per_transaction_fee = $SheetDataKey['per_transaction_fee'];
                    $total_fees = $SheetDataKey['total_fees'];
                    $gst_rate = $SheetDataKey['gst_rate'];
                    $igst = $SheetDataKey['igst'];
                    $cgst = $SheetDataKey['cgst'];
                    $sgst = $SheetDataKey['sgst'];
                    $tcs = $SheetDataKey['tcs'];
                    $ind = explode("/", $allDataInSheet[$i][$inv_date]);
                    $inv_date2 = $ind[2] . "-" . $ind[0] . "-" . $ind[1];
                    $inv_date = addslashes($inv_date2);
                    $order_id = addslashes(ucfirst(strtolower(($allDataInSheet[$i][$order_id]))));
                    $total_transaction = addslashes(ucfirst(strtolower(($allDataInSheet[$i][$total_transaction]))));
                    $market_percentage = addslashes($allDataInSheet[$i][$market_percentage]);
                    $market_value = addslashes($allDataInSheet[$i][$market_value]);
                    $shipping_fee = addslashes(ucfirst(strtolower(($allDataInSheet[$i][$shipping_fee]))));
                    $gateway_fee = addslashes(ucfirst(strtolower(($allDataInSheet[$i][$gateway_fee]))));
                    $per_transaction_fee = addslashes(ucfirst(strtolower(($allDataInSheet[$i][$per_transaction_fee]))));
                    $total_fees = addslashes(ucfirst(strtolower(($allDataInSheet[$i][$total_fees]))));
                    $gst_rate = addslashes(ucfirst(strtolower(($allDataInSheet[$i][$gst_rate]))));
                    $igst = addslashes(ucfirst(strtolower(($allDataInSheet[$i][$igst]))));
                    $cgst = addslashes(ucfirst(strtolower(($allDataInSheet[$i][$cgst]))));
                    $sgst = addslashes(ucfirst(strtolower(($allDataInSheet[$i][$sgst]))));
                    $tcs = addslashes(ucfirst(strtolower(($allDataInSheet[$i][$tcs]))));
                    $fetchData[] = array("vendor_id" => $vendorid, 'inv_date' => $inv_date, 'order_id' => $order_id, 'total_transaction' => $total_transaction, 'market_percentage' => $market_percentage, 'market_value' => $market_value, 'shipping_fee' => $shipping_fee, 'gateway_fee' => $gateway_fee, 'per_transaction_fee' => $per_transaction_fee, 'total_fees' => $total_fees, 'gst_rate' => $gst_rate, 'igst' => $igst, 'cgst' => $cgst, "sgst" => $sgst, "tcs" => $tcs);
                }

                $data['vendorInfo'] = $fetchData;

                $this->import->setBatchImport($fetchData);
                $this->import->importData();
                $this->session->set_flashdata("msg", '<div class="  alert   alert-success    ">
                                            Imported Successfully
                                        </div>');
            } else {

                $this->session->set_flashdata("msg", '<div class="alert  alert-danger    "> ' . $this->upload->display_errors() . '</div>');
            }

            return redirect('Vendor/VendorInvoice');
        }
    }

}

?>