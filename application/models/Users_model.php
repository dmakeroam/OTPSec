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
    
    /* ------------------------ Registration --------------------------- */
    
    public function hasRUsername($username){
        $query=$this->db->select('OTP_Username')->from('otp_users')
                                     ->where('OTP_Username',$username)->get();
        if(($num_row=$query->num_rows())>=1){
            return true;
        }
        else{
           return false; 
        }
    }
    
    public function hasUniqueKey($uniqKey){
        $query=$this->db->select('OTP_Key')->from('otp_users')
                                     ->where('OTP_Key',$uniqKey)->get();
        if(($num_row=$query->num_rows())>=1){
            return true;
        }
        else{
           return false; 
        }
    }
    
    public function hasEmail($email){
        $query=$this->db->select('OTP_Emails')
                        ->from('otp_emails')
                        ->where('OTP_Emails',$email)->get();
        if(($num_row=$query->num_rows())>=1){
            return true;
        }
        else{
           return false; 
        }
    }
    
    /* -------------------------- Registration --------------------------------------*/
    
    public function hasUserName($username){
        $query=$this->db->select('*')->from('otp_users')
                                     ->join('otp_emails','otp_users.OTP_UID=otp_emails.OTP_UID')
                                     ->where('OTP_Username',$username)->order_by('OTP_Emails_No asc')->get();
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
    
    public function canAddMember($username,$email1,$email2,$email3,$uniqKey){
        
        $current_timestamp_obj = new DateTime();   
        $current_timestamp=$current_timestamp_obj->format('Y-m-d h:i:s');
        
        $userData=array(
            'OTP_Username'=>$username,
            'OTP_Key'=>$uniqKey,
            'OTP_Expired'=>$current_timestamp
        );
        
        $this->db->insert('otp_users',$userData);
        
        if ($this->db->trans_status() === FALSE){
            
            $this->db->trans_rollback();
            return false;
            
        }
        else{
            
            $this->db->trans_commit();
            
            $OTP_UID=$this->db->select('OTP_UID')->from('otp_users')->where('OTP_Username',$username)->get()
                     ->result()[0]->OTP_UID;   
            
            $emailData=array(            
               array(
                  'OTP_UID'=>$OTP_UID,
                  'OTP_Emails_No'=>1,
                  'OTP_Emails'=>$email1
               ),
               array(
                  'OTP_UID'=>$OTP_UID,
                  'OTP_Emails_No'=>2,
                  'OTP_Emails'=>$email2
               ),
               array(
                  'OTP_UID'=>$OTP_UID,
                  'OTP_Emails_No'=>3,
                  'OTP_Emails'=>$email3
               )   
            );
            
            $this->db->insert_batch('otp_emails',$emailData);
            
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
        
    
    
    public function canUpdate($username,$email1,$email2,$email3,$email4,$email5,$uniqKey){
        
        $currentId=$this->session->userdata('user_id');
        
        $finished=0;
        
        $userData=array(
          'OTP_Username'=>$username,
          'OTP_Key'=>$uniqKey       
        );
        
        $this->db->where('OTP_UID',$currentId);
        $this->db->update('otp_users',$userData);
        
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            $finished++;
            
            if($email4!=null){
                
                $where_clause=array('OTP_UID'=>$currentId,'OTP_Emails_No'=>4);
                
                $query=$this->db->select('OTP_Emails_No')->from('otp_emails')
                                                         ->where($where_clause)
                                                         ->get();
                if($query->num_rows()==1){
                    
                    $email4Data=array('OTP_Emails'=>$email4);
                    
                    $this->db->where(array('OTP_UID'=>$currentId,'OTP_Emails_No'=>4));
                    $this->db->update('otp_emails',$email4Data);
                    
                     if ($this->db->trans_status() === FALSE){
                        $this->db->trans_rollback();
                        return false;
                     }
                     else{
                        $finished++;
                     }      
                }
                else{
                    
                    $email4Data=array('OTP_UID'=>$currentId,'OTP_Emails_No'=>4,'OTP_Emails'=>$email4);
                    $this->db->insert('otp_emails',$email4Data);
                    
                     if($this->db->trans_status() === FALSE){
                        $this->db->trans_rollback();
                        return false;
                     }
                     else{
                        $finished++;
                     }                  
                }     
        }
        else{
            
            $this->db->where(array('OTP_UID'=>$currentId,'OTP_Emails_No'=>4));
            $this->db->delete('otp_emails');
            
            if($this->db->trans_status() === FALSE){
                        $this->db->trans_rollback();
                        return false;
            }
            else{
              $finished++;
            }
            
        }
            
        if($email5!=null){
                
                $where_clause=array('OTP_UID'=>$currentId,'OTP_Emails_No'=>5);
                
                $query=$this->db->select('OTP_Emails_No')->from('otp_emails')
                                                         ->where($where_clause)
                                                         ->get();
                if($query->num_rows()==1){
                    
                    $email5Data=array('OTP_Emails'=>$email5);
                    
                    $this->db->where(array('OTP_UID'=>$currentId,'OTP_Emails_No'=>5));
                    $this->db->update('otp_emails',$email5Data);
                    
                     if ($this->db->trans_status() === FALSE){
                        $this->db->trans_rollback();
                        return false;
                     }
                     else{
                        $finished++;
                     }      
                }
                else{
                    
                    $email5Data=array('OTP_UID'=>$currentId,'OTP_Emails_No'=>5,'OTP_Emails'=>$email5);
                    $this->db->insert('otp_emails',$email5Data);
                    
                     if($this->db->trans_status() === FALSE){
                        $this->db->trans_rollback();
                        return false;
                     }
                     else{
                        $finished++;
                     }                  
                }     
        }
        else{
            
            $this->db->where(array('OTP_UID'=>$currentId,'OTP_Emails_No'=>5));
            $this->db->delete('otp_emails');
            
            if($this->db->trans_status() === FALSE){
                        $this->db->trans_rollback();
                        return false;
            }
            else{
              $finished++;
            }
            
        }
            
        $email1Data=array('OTP_Emails'=>$email1);
                    
        $this->db->where(array('OTP_UID'=>$currentId,'OTP_Emails_No'=>1));
        $this->db->update('otp_emails',$email1Data);
                    
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $finished++;
        }  
            
        $email2Data=array('OTP_Emails'=>$email2);
                    
        $this->db->where(array('OTP_UID'=>$currentId,'OTP_Emails_No'=>2));
        $this->db->update('otp_emails',$email2Data);
                    
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $finished++;
        }    
            
        $email3Data=array('OTP_Emails'=>$email3);
                    
        $this->db->where(array('OTP_UID'=>$currentId,'OTP_Emails_No'=>3));
        $this->db->update('otp_emails',$email3Data);
                    
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $finished++;
        }    
            
        if($finished>=4){
            return true;
        }
        else{
            return false;
        } 
      }
    }
    
}