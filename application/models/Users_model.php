<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users_model extends CI_Model{
    
    private $userID;
    private $userName;
    private $userEmail;
    private $otpKey;
    private $otpCode;
    private $otpExpired;
    
    public function __construct(){
        parent::__construct();
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
    
    public function hasUsernameNotInclude($username){
        $current_id=$this->session->userdata('user_id');
        $query=$this->db->select('OTP_Username')->from('otp_users')
                                     ->where(array('OTP_Username'=>$username,'OTP_UID !='=>$current_id))->get();
        if(($num_row=$query->num_rows())>=1){
            return true;
        }
        else{
           return false; 
        }
    }
    
    public function hasUniqueKeyNotInclude($uniqKey){
        $current_id=$this->session->userdata('user_id');
        $query=$this->db->select('OTP_Key')->from('otp_users')
                                     ->where(array('OTP_Key'=>$uniqKey,'OTP_UID !='=>$current_id))->get();
        if(($num_row=$query->num_rows())>=1){
            return true;
        }
        else{
           return false; 
        }
    }
    
    public function hasEmailNotInclude($email){
        $current_id=$this->session->userdata('user_id');
        $query=$this->db->select('OTP_Emails')
                        ->from('otp_emails')
                        ->where(array('OTP_Emails'=>$email,'otp_emails.OTP_UID !='=>$current_id))->get();
        if(($num_row=$query->num_rows())>=1){
            return true;
        }
        else{
           return false; 
        }
    }
    
    public function hasUserName($username){
        $query=$this->db->select('*')->from('otp_users')
                                     ->join('otp_emails','otp_users.OTP_UID=otp_emails.OTP_UID')
                                     ->where('OTP_Username',$username)->get();
        if(($num_row=$query->num_rows())>=1){
            $result=$query->result();
            $this->setUserID($result[0]->OTP_UID);
            $this->setUserName($result[0]->OTP_Username);
            
            // Setting user emails
            $emails=array();
            for($i=0;$i<$num_row;$i++){
                $emails[$i]=$result[$i]->OTP_Emails;
            }
            
            $this->setUserEmail($emails);
            
            $this->setOtpKey($result[0]->OTP_Key);
            $this->setOtpCode($result[0]->OTP_Code);
            $this->setOtpExpired($result[0]->OTP_Expired);
            return true;
        }
        else{
            return false;
        }
    }
    
    public function setUserID($userID){
        $this->userID=$userID;
    }
    
    public function setUserName($userName){
        $this->userName=$userName;
    }
    
     public function setUserEmail($userEmail){
        $this->userEmail=$userEmail;
    }
    
    public function setOtpKey($otpKey){
        $this->otpKey=$otpKey;
    }
    
    public function setOtpCode($otpCode){
        $this->otpCode=$this->encryption->encrypt($otpCode);
    }
    
    public function setOtpExpired($otpExpired){
        $this->otpExpired=$otpExpired;
    }
    
    public function getUserID(){
        return $this->userID;
    }
    
    public function getUserName(){
        return $this->userName;
    }
    
    public function getUserEmail(){
        return $this->userEmail;
    }
    
    public function getOtpKey(){
        return $this->otpKey;
    }
    
    public function getOtpCode(){
        return $this->encryption->decrypt($this->otpCode);
    }
    
    public function getOtpExpired(){
        return $this->otpExpired;
    }
    
    public function save(){
        
        $this->db->trans_begin();
        
        $otpUsersData=array(
            'OTP_Username'=>$this->userName,
            'OTP_Key'=>$this->otpKey,
            'OTP_Code'=>$this->otpCode,
            'OTP_Expired'=>$this->otpExpired     
        );
        
        $this->db->where('OTP_UID',$this->userID);
        $this->db->update('otp_users',$otpUsersData);
        
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
        
    }
    
}