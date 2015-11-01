<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users_model extends CI_Model{
    
    private $userID;
    private $userName;
    private $otpKey;
    private $otpCode;
    private $otpExpired;
    
    public function __construct(){
        parent::__construct();
    }
    
    public function hasUserName($username){
        $query=$this->db->select('*')->from('OTP_Users')->where('OTP_Username',$username)->get();
        if($query->num_rows()==1){
            $result=$query->result();
            $this->setUserID($result[0]->OTP_UID);
            $this->setUserName($result[0]->OTP_Username);
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
    
    public function setOtpKey($otpKey){
        $this->otpKey=$otpKey;
    }
    
    public function setOtpCode($otpCode){
        $this->otpCode=$otpCode;
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
    
    public function getOtpKey(){
        return $this->otpKey;
    }
    
    public function getOtpCode(){
        return $this->otpCode;
    }
    
    public function getOtpExpired(){
        return $this->otpExpired;
    }
    
    
}