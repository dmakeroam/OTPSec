<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Authen extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('html');
        $this->load->helper('url');
        $this->load->model('Users_model');
    }
    
    public function login(){
        if(($username=$this->input->post('username'))){
             if($this->Users_model->hasUserName($username)){
                 $this->generateOTPCode();
                 $this->loadView('authen/login_page');
             }
             else{
                 $error=array('error'=>'The username is not exist.');
                 $this->loadView('authen/login_page',$error);
             }
        }
        else{
             $this->loadView('authen/login_page');
             return;
        }
    }
    
     private function generateOTPCode(){
         $otpKey=$this->Users_model->getOtpKey();
         $otpKey_length=strlen($otpKey);
         $secret_key="";
         for($i=1;$i<$otpKey_length;$i++){
             $secret_key.=chr(rand(33,126));
         }
         $otpCode=hash('sha256',($otpKey.$secret_key));
         $this->Users_model->setOtpCode($otpCode);
         $current_timestamp = new DateTime();
         $current_timestamp->modify('+30 minutes');    
         echo $current_timestamp->format('Y-m-d h:i:s');
     }
    
     private function loadView($viewPath,$arg=null){
        $this->load->view('template/header');
        $this->load->view($viewPath,$arg);
        $this->load->view('template/footer');
    }
}