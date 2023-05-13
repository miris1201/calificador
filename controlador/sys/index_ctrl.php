<?php

class Sys {
    public function account() {
        require_once('business/sys/account.php');
    }
    
    public function add_account() {
        require_once('business/sys/addAccount.php');
    }
   
    public function error() {
        require_once('business/error.php');
    }
}
?>
