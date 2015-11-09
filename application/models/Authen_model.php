<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Authen_model extends CI_Model{
    
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
    }
    
    public function checkOTPCodeMatchOnSameTime($otpCode,$current_timestamp){
        
        $this->db->trans_begin();
        
        $authenData=array('OTP_Code_Seg'=>$otpCode,'OTP_Login_Time'=>$current_timestamp);
        
        $this->db->insert('otp_authen',$authenData);
        
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }
        else{
            
            $this->db->trans_commit();
            
            $this->db->distinct();
            $this->db->select('OTP_Code_Seg')->from('otp_authen');
            $this->db->where('abs(OTP_Login_Time-\''.$current_timestamp.'\')<=15',null,false);
            $authenResult=$this->db->get()->result();
            
            $this->db->select('OTP_UID, OTP_Username, OTP_Code')->from('otp_users');
            $userResult=$this->db->get()->result();
            
            $match=0;
            $uid=0;
            $userName=null;
            
            foreach($authenResult as $authen){ 
                foreach($userResult as $user){
                    if (strpos($user->OTP_Code,$authen->OTP_Code_Seg) !== false) {
                       if($uid==0 || $user->OTP_UID==$uid){
                          $match++;
                          $uid=$user->OTP_UID;
                          $userName=$user->OTP_Username;
                       }
                    }
                }
            }
            
            if($match>=2){
                $this->session->set_userdata(array('user_id'=>$uid,'username'=>$userName));
                return true;
            }
            else{
                return false;
            }
            
        }
        
    }
}