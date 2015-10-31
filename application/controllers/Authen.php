<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Authen extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
    }
    
    public function login($username=""){
        if($username==""){
            show_404();
        }
        else{
            
        }
    }
}