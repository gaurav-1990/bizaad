<?php

class Navigation {

    private $con;

    public function __construct($pdo) {
        $this->con = $pdo;
    }

    public function getCategory() {
        $prepare = $this->con->prepare("select * from tbl_categories where cat_sta=?");
        $prepare->execute(array(1));
        return $prepare->fetchAll();
    }

    public function getUserDataByID($id) {
        $prepare = $this->con->prepare("select * from tbl_user_reg where id=?");
        $prepare->execute(array($id));
        return $prepare->fetch();
    }

    public function encrypt_decrypt($action, $string) {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'Hello@123#';
        $secret_iv = 'JGHFFDG@HELLLO@!#$';
        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }

    public function returnTitle($sub, $id) {

        $id = $this->encrypt_decrypt("decrypt", $id);
        $query = $this->con->prepare("select * from tbl_subcategory  where  id=?");
        if ($sub == false) {
            $query = $this->con->prepare("select *,cat_title as sub_title,cat_meta_desc as sub_meta_desc,cat_keywords as sub_meta_key from tbl_categories where id=?");
        }
        $rs = $query->execute(array($id));
        return $query->fetch();
    }

    public function cleanString($string) {
        $string = str_replace([' ', '&', '\'', ',', '.', ')', '(', '[', ']', '{', '}'], '-', $string); // Replaces all spaces with hyphens.
        preg_replace('/[^A-Za-z0-9\-]/', '-', $string); // Removes special chars.
        return preg_replace('/-+/', '-', $string);
    }

    public function getSubCategory($id) {
        $prepare = $this->con->prepare("select *,tbl_subcategory.id as ID from tbl_subcategory JOIN tbl_categories on tbl_categories.id=tbl_subcategory.cid where cid=?");
        $prepare->execute(array($id));
        return $prepare->fetchAll();
    }

}
