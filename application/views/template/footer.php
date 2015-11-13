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
var noEmail=4;
$(function() {
   $('#edit_btn').click(function(event){
       
       $('#username').removeAttr('readonly');
       $('#username').attr('required','true');
       
       $( "input[name^='email']" ).removeAttr('readonly');
       $( "input[name^='email']" ).attr('required','true');
       
       $('#uniqKey').removeAttr('readonly');
       $('#uniqKey').attr('required','true');
       
       $('#edit_btn').addClass('disabled');
       $('#save_btn').removeClass('disabled');
       
   });
    
   
});
    
 function addEmails(){
     if(noEmail!=6){
          var inputEmail='<div class="form-group" id="email'+noEmail+'-form">';
          inputEmail+='<label class="control-label col-md-4" for="email'+noEmail+'" id="label-email'+noEmail+'">'+noEmail+'th Email:</label>';
          inputEmail+='<div class="col-md-8">';
          inputEmail+='<div class="input-group">';
          inputEmail+='<input type="email" class="form-control" id="email'+noEmail+'" name="email'+noEmail+'" placeholder="'+noEmail+'th Email" readonly>';
          inputEmail+='<span class="input-group-btn">';
          inputEmail+='<button class="btn btn-default addBtn" type="button" onclick="addEmails()"><span class="fui-plus"></span></button>';
          inputEmail+='<button class="btn btn-default" type="button" onclick="deleteEmails('+noEmail+')" id="delete-email'+noEmail+'"><span class="fui-cross"></span></button>'
          inputEmail+='</span>';
          inputEmail+='</div>';
          inputEmail+='</div>';
          inputEmail+='</div>';
          $('#personalInfo').append(inputEmail);
          if(noEmail==5){
            $('button').remove('.addBtn');
          }
          noEmail++;
     }
  }
function deleteEmails(noOfEmail){
    $('div').remove('#email'+noOfEmail+'-form');
    if(noEmail==6 && noOfEmail==4){
      $('#email5-form').attr('id','email4-form');
      $('#label-email5').attr('for','email4');
      $('#label-email5').html('4th Email:');
      $('#label-email5').attr('id','label-email4');
      $('#email5').attr('placeholder','4th Email');
      $('#email5').attr('id','email4');
      $('#delete-email5').attr('onclick','deleteEmails(4)');
      $('#delete-email5').attr('id','delete-email4');
    }
    noEmail--;
    if(noEmail==5){
        $('.input-group-btn').prepend('<button class="btn btn-default addBtn" type="button" onclick="addEmails()"><span class="fui-plus"></span></button>');
    }
}
</script>
<?php endif;?>
</body>
</html>