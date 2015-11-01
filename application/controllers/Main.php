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
            $this->loadView('main/main_page',array('username'=>$username));
        }
        else{
            $this->loadView('authen/login_page');
        }
    }
    
    private function loadView($viewPath){
        $this->load->view('template/header');
        $this->load->view($viewPath);
        $this->load->view('template/footer');
    }
    
}