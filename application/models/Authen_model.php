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
            
            $this->db->select('OTP_Code_Seg')->from('otp_authen');
            $this->db->where('OTP_Login_Time',$current_timestamp)->order_by('OTP_AID','asc');
            $result=$this->db->get()->result();
            
            $otpCode="";
            
            foreach($result as $e){
                $otpCode.=$e->OTP_Code_Seg;
            }
            
            $otpCode=hash('sha256',$otpCode);
            
            $this->db->select('OTP_UID, OTP_Username')->from('otp_users')->where('OTP_Code',$otpCode);
            $query=$this->db->get();
            
            if($query->num_rows()==1){
                
                $result=$query->result()[0];
                $userID=$result->OTP_UID;
                $userName=$result->OTP_Username;
                
                $this->session->set_userdata(array('user_id'=>$userID,'username'=>$userName));
                
                return true;
            }
            else{
                return false;
            }
            
        }
        
    }
}