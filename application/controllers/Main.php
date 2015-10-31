<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Main extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->helper('html');
        $this->load->helper('url');
        $this->load->library('session');
    }
    
    public function index(){
        if(($username=$this->session->userdata('username'))){
            $this->load->view('main/main_page',array('username'=>$username));
        }
        else{
            $this->load->view('authen/login_page');
        }
    }
    
}