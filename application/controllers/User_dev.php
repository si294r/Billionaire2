<?php

defined('BASEPATH') OR exit('No direct script access allowed');

include 'User.php';

class User_dev extends User {

    public function __construct() {
        parent::__construct();
        $this->user->table = str_replace("_prod", "_dev", $this->db->database) . "." . $this->user->table;
    }
    
}