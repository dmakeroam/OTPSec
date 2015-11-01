<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Authen extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('html');
        $this->load->library('email');
        $this->load->helper('url');
        $this->load->model('Users_model');
    }
    
   /* public function send_mail(){
        $this->email
                ->bcc("cpfapp@gmail.com")
                ->from('wan_kik321@hotmail.com','Oam\'s Mail Sender')
                ->to('mynamecoad@gmail.com')
                ->subject('Test')
                ->message('Hello')
                ->send();

    } */
    
    public function login(){
        if(($username=$this->input->post('username'))){
             if($this->Users_model->hasUserName($username)){
                 if(!($this->generateOTPCode())){
                    $error=array('error'=>'The system could not generate an OTP code.');
                    $this->loadView('authen/login_page',$error); 
                 }
                 else{
                   $this->sendOTPCodeToEmail();
                   $this->loadView('authen/otp_input');
                 }
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
    
    
     private function sendOTPCodeToEmail(){
         
     }
    
     private function generateOTPCode(){
         $otpKey=$this->Users_model->getOtpKey();
         $otpKey_length=strlen($otpKey);
         $secret_key="";
         for($i=1;$i<$otpKey_length;$i++){
             $secret_key.=chr(rand(33,126));
         }
         $otpCode=hash('sha256',(time().$otpKey.$secret_key));
         $this->Users_model->setOtpCode($otpCode);
         $current_timestamp_obj = new DateTime();
         $current_timestamp_obj->modify('+30 minutes');    
         $current_timestamp=$current_timestamp_obj->format('Y-m-d h:i:s');
         $this->Users_model->setOtpExpired($current_timestamp);
         if($this->Users_model->save()){
             return true;
         }
         else{
             return false;
         }
     }
    
     private function loadView($viewPath,$arg=null){
        $this->load->view('template/header');
        $this->load->view($viewPath,$arg);
        $this->load->view('template/footer');
    }
}