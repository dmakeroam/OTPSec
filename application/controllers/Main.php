<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Main extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('html');
        $this->load->helper('url');
        $this->load->model('Users_model');
        $this->load->library('form_validation');
        $this->load->library('session');
    }
    
    public function index(){
        if($username=$this->session->userdata('username')){
            
            $this->Users_model->hasUserName($username);
            
            $emails=$this->Users_model->getUserEmail();
            
            $uniqKey=$this->Users_model->getOtpKey();
            
            $main_page_arg=array('emails'=>$emails,'uniq_key'=>$uniqKey);
            $pageUsername=array('page'=>'member','username'=>$username);
            $page=array('page'=>'member','numberOfEmails'=>count($emails));
            
            $this->loadView('main/main_page',$main_page_arg,$pageUsername,$page);
        }
        else{
            $page=array('page'=>'login');
            $this->loadView('authen/login_page',null,$page,$page);
        }
    }
    
    public function registration(){
        if(!$this->session->userdata('username')){
            
            $this->form_validation->run();
            
            $page=array('page'=>'regis');
            $this->loadView('main/regis',null,$page,$page);
        }
        else{
            $this->index();
        }
    }
    
    private function loadView($viewPath,$arg=null,$headerArg=null,$footerArg=null){
        $this->load->view('template/header',$headerArg);
        $this->load->view($viewPath,$arg);
        $this->load->view('template/footer',$footerArg);
    }
    
}