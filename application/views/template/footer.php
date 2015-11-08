<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<?=script_tag('https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js')?>
<?=script_tag('https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js')?>
<?php if(isset($page) && $page=='login') :?>
<?=script_tag('assets/js/sweetalert2/sweetalert2.min.js')?>
<script>
    
function showProgressBar(){
    
    var event = $(document).click(function(e) {
    e.stopPropagation();
    e.preventDefault();
    e.stopImmediatePropagation();
    return false;
    });
    
    swal({   
         title: "Sending the OTP code to emails", 
         html: "<img src='<?=base_url('assets/images/login-preloader/download.svg')?>'>", 
         showConfirmButton: false
        });
    login();
    return false;
}
    
function login(){
    var username=$('#username').val();
    var otpsec_token=$("input[name='otpsec_token']").val();
    $.post("/OTPSec/authen/login",
    {
      username:username,
      otpsec_token:otpsec_token
    },
    function(data, status){
        $(location).attr('href', '/OTPSec/authen/otp_input');
    });
}
</script>
<?php endif;?>
</body>
</html>