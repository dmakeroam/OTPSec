<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Member extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->library('session');
        $this->load->helper('url');
    }
    
    public function hasUsername(){
        if($this->session->userdata('username')){
            if($username=$this->input->post('username')){
                if($this->Users_model->hasUsernameNotInclude(urldecode($username))){
                    echo "1";
                }
                else{
                    echo "0";
                }
            }
            else{
               redirect('main','refresh');
            }
        }
        else{
            redirect('authen/login','refresh');
        }
    }
    
    public function hasEmail(){
        if($this->session->userdata('username')){
            if($email=$this->input->post('email')){
                if($this->Users_model->hasEmailNotInclude(urldecode($email))){
                    echo "1";
                }
                else{
                    echo "0";
                }
            }
            else{
               redirect('main','refresh');
            }
        }
        else{
            redirect('authen/login','refresh');
        }
    }
    
    public function hasKey(){
        if($this->session->userdata('username')){
            if($uniqKey=$this->input->post('uniqKey')){
                if($this->Users_model->hasUniqueKeyNotInclude(urldecode($uniqKey))){
                    echo "1";
                }
                else{
                    echo "0";
                }
            }
            else{
               redirect('main','refresh');
            }
        }
        else{
            redirect('authen/login','refresh');
        }
    }
    
}