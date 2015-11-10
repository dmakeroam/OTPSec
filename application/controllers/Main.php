<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Main extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('html');
        $this->load->helper('url');
        $this->load->library('session');
    }
    
    public function index(){
        if($username=$this->session->userdata('username')){
            $pageUsername=array('page'=>'member','username'=>$username);
            $page=array('page'=>'member');
            $this->loadView('main/main_page',null,$pageUsername,$page);
        }
        else{
            $page=array('page'=>'login');
            $this->loadView('authen/login_page',null,$page,$page);
        }
    }
    
    private function loadView($viewPath,$arg=null,$headerArg=null,$footerArg=null){
        $this->load->view('template/header',$headerArg);
        $this->load->view($viewPath,$arg);
        $this->load->view('template/footer',$footerArg);
    }
    
}