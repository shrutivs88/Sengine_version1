<?php
class Openssl {

    private $encrypt_method;
    private $secret_key;
    private $secret_iv;
    private $iv;
    private $key;
    
    public function __construct() {
        $this->encrypt_method = "AES-256-CBC";
        $this->secret_key = 'tB54GPfXgEL6UsC5lWirik65tXOwzmxG';
        $this->key = hash('sha256', $this->secret_key);
        $this->secret_iv = 'xke59Gw73LI7eFdZSMbI88FFUW7Aqh6E';
        $this->iv = substr(hash('sha256', $this->secret_iv), 0, 16);
    }

    public function encrypt($value) {
        $output = openssl_encrypt($value, $this->encrypt_method, $this->key, 0, $this->iv);
        $output = base64_encode($output);
        return $output;
    }

    public function decrypt($value) {
        $output = openssl_decrypt(base64_decode($value), $this->encrypt_method, $this->key, 0, $this->iv);
        return $output;
    }

}
?>