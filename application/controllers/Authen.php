<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Authen extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('html');
        $this->load->helper('url');
        $this->load->library('email');
        $this->load->library('session');
        $this->load->model('Authen_model');
        $this->load->model('Users_model');
    }
    
    public function login(){
        if(!$this->session->userdata('username')){
            if(($username=$this->input->post('username'))){
                 if($this->Users_model->hasUserName($username)){
                        $this->generateOTPCode();
                        if($this->generateOTPCodeSegments()){
                            echo "OK";
                        }
                        else{
                            echo "NOK";
                        }
                 }
            }
            else{
                 $page=array('page'=>'login');
                 $this->loadView('authen/login_page',null,$page,$page);
                 return;
            }
        }
        else{
           redirect('main','refresh');
        }
    }
    
    public function otp_input(){
       if($this->session->userdata('username')){
            redirect('main','refresh');
       }
       else{
            $this->loadView('authen/otp_input');
       }
    }
    
    public function checkOTPCode(){
        
        $current_timestamp_obj = new DateTime();   
        $current_timestamp=$current_timestamp_obj->format('Y-m-d h:i:s');
        
        if(($otpCode=$this->input->post('otp_code'))){
              
            if($this->Authen_model->checkOTPCodeMatchOnSameTime($otpCode,$current_timestamp)){
                redirect('main','refresh');
            }
            else{
                $error=array('error'=>'The OTP code is wrong or login is not properly.');
                $this->loadView('authen/otp_input',$error); 
            }
               
        }
        else{
              
            $this->loadView('authen/otp_input');  
            
        }
        
    }
    
     private function generateOTPCodeSegments(){
         $emails=$this->Users_model->getUserEmail();
         $numOfEmails=count($emails);
         $otpCode=$this->Users_model->getOtpCode();
         $userName=$this->Users_model->getUserName();
         $segmentPerEmail=(strlen($otpCode)/$numOfEmails);
         $otpCode_segments=array();
         $i=0;
         $sentCount=0;
         for($i;$i<$numOfEmails;$i++){     
             $start=($i*$segmentPerEmail); 
             $otpCode_segments[$i]=substr($otpCode,$start,$segmentPerEmail);
             if($numOfEmails==3 && $i==2){
                $otpCode_segments[$i].=substr($otpCode,-1); 
             }
             else if($numOfEmails=5 && $i==4){
                $otpCode_segments[$i].=substr($otpCode,-4);  
             }
             $result=$this->email->from('admin@mail.onidev.me','OTPSec Support')
                                ->to($emails[$i])
                                ->subject('OTP Code for '.$userName.' access')
                                ->message('The OTP code is '.$otpCode_segments[$i])
                                ->send();
             if($result){
                 $sentCount++;
             }
         }
         if($sentCount==$numOfEmails){
             return true;
         }
         else{
             return false;
         }
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
    
    private function loadView($viewPath,$arg=null,$headerArg=null,$footerArg=null){
        $this->load->view('template/header',$headerArg);
        $this->load->view($viewPath,$arg);
        $this->load->view('template/footer',$footerArg);
    }
}