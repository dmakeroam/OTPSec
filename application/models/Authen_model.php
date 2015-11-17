<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Authen_model extends CI_Model{
    
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        $this->load->library('encryption');
        $key='db1e74ea50f2db0c878e22bdc15e77fa77aad09d2200dc657c37d6ed5107b7d2832369b043983b70a6c4b2692b9098148155cabdc99bc7ec18dda6be4df742fa';
        $hmac_key='7b0f124fc53bdc5e3011d70ceb7b61caa1d4121a0c0b46a3d35cf609629995814ad03eaa8d4bfa49639eec86f695fed65f658a1fba53be68fa9d4a2197803832';
        $this->encryption->initialize(
            array(
                'cipher' => 'aes-256',
                'mode' => 'ctr',
                'key' => $key,
                'hmac_digest' => 'sha256',
                'hmac_key' => $hmac_key
            )
        );
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
            $this->db->where('abs(timestampdiff(second,OTP_Login_Time,\''.$current_timestamp.'\'))<=15',null,false);
            $authenResult=$this->db->get()->result();
            
            $this->db->select('OTP_UID, OTP_Username, OTP_Code')->from('otp_users');
            $userResult=$this->db->get()->result();
            
            $match=0;
            $uid=0;
            $userName=null;
            
            foreach($authenResult as $authen){ 
                foreach($userResult as $user){
                    if (strpos($this->encryption->decrypt($user->OTP_Code),$authen->OTP_Code_Seg) !== false) {
                       if($uid==0 || $user->OTP_UID==$uid){
                          $match++;
                          $uid=$user->OTP_UID;
                          $userName=$user->OTP_Username;
                       }
                    }
                }
            }
            
            if($match>=3){
                $this->session->set_userdata(array('user_id'=>$uid,'username'=>$userName));
                return true;
            }
            else{
                return false;
            }
            
        }
        
    }
}