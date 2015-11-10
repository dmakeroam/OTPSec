<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<?=script_tag('https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js')?>
<?=script_tag('https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js')?>
<?=script_tag('https://cdnjs.cloudflare.com/ajax/libs/flat-ui/2.2.2/js/flat-ui.min.js')?>
<?php if(isset($page) && $page=='login') :?>
<?=script_tag('assets/js/sweetalert2/sweetalert2.min.js')?>
<script language="javascript" type="text/javascript">
    
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
<?php if(isset($page) && $page=='member') :?>
<script language="javascript" type="text/javascript">
$(function() {
   $('#edit_btn').click(function(event){
       
       $('#username').removeAttr('readonly');
       $('#username').attr('required','true');
       
       $('#email1').removeAttr('readonly');
       $('#email1').attr('required','true');
       
       $('#email2').removeAttr('readonly');
       $('#email2').attr('required','true');
       
       $('#email3').removeAttr('readonly');
       $('#email3').attr('required','true');
       
       $('#encKey').removeAttr('readonly');
       $('#encKey').attr('required','true');
       
       $('#edit_btn').addClass('disabled');
       $('#save_btn').removeClass('disabled');
       
   });
});
</script>
<?php endif;?>
</body>
</html>