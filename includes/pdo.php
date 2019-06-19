<?php

class MyPDOStatement extends PDOStatement {

    protected $_debugValues = null;

    protected function __construct() {
        // need this empty construct()!
    }

    public function execute($values = array()) {
        $this->_debugValues = $values;
        try {
            $t = parent::execute($values);
            // maybe do some logging here?
        } catch (PDOException $e) {
            // maybe do some logging here?
            throw $e;
        }

        return $t;
    }

    public function _debugQuery($replaced = true) {
        $q = $this->queryString;

        if (!$replaced) {
            return $q;
        }

        return preg_replace_callback('/:([0-9a-z_]+)/i', array($this, '_debugReplace'), $q);
    }

    protected function _debugReplace($m) {
        $v = $this->_debugValues[$m[1]];
        if ($v === null) {
            return "NULL";
        }
        if (!is_numeric($v)) {
            $v = str_replace("'", "''", $v);
        }

        return "'" . $v . "'";
    }

}

//$host = 'localhost';
//$db = 'bizzad';
//$user = 'phpmyadmin';
//$pass = 'Hello@123#';
//$charset = 'utf8';
//
//$keyId = 'rzp_live_1iVeXVPHEwPoGd';
//$keySecret = 'ouT8Xcp9yIzhF6fhwl0OPn4D';
//$displayCurrency = 'INR';
$keyId = 'rzp_test_ZCnjyN7AkBOFsj';
$keySecret = 'jsKKfa5EErh5p75hUWvHTKtR';
$displayCurrency = 'INR';

//These should be commented out in production
// This is for error reporting
// Add it to config.php to report any errors
 

$host = 'localhost';
$db = 'bizaad';
$user = 'root';
$pass = '';
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
    \PDO::ATTR_EMULATE_PREPARES => false,
    \PDO::ATTR_STATEMENT_CLASS => array('MyPDOStatement', array()),
];
$pdo = new \PDO($dsn, $user, $pass, $opt);
?>