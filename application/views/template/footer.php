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
<?php elseif(isset($page) && $page=='member') :?>
<script language="javascript" type="text/javascript">
    
<?php if($numberOfEmails==4) :?>
var noEmail=5;
<?php elseif($numberOfEmails==5) :?>
var noEmail=6;
<?php else :?>
var noEmail=4;
<?php endif;?>
    
$(function() {
   $('#edit_btn').click(function(event){
       
       $('#username').removeAttr('readonly');
       $('#username').attr('required','true');
       
       $( "input[name^='email']" ).removeAttr('readonly');
       $( "input[name^='email']" ).attr('required','true');
       
       $('#uniqKey').removeAttr('readonly');
       $('#uniqKey').attr('required','true');
       
       $('#edit_btn').addClass('disabled');
       $('#edit_btn').attr('disabled','true');
       $('#save_btn').removeClass('disabled');
       
   });
    
   $('#username').change(function(event){
        var username=$('#username').val();
        $.post("/OTPSec/member/hasUsername",
        {
          username:username
        },
        function(data, status){
            if(data!=="0"){
              $('#personalHeader').append('<font style="color:red; font-weight:normal; font-size:15px;" id="err-name"><br>The username is not available.</font>');
              $('#username').focus();
              $('#personalGroup').addClass('has-error');
            }
            else{
              $('#err-name').remove();
              $('#personalGroup').removeClass('has-error');
            }
        });
   });
    
   $('#uniqKey').change(function(event){
        var uniqKey=$('#uniqKey');
        var uniqKeyVal=uniqKey.val();
        $.post("/OTPSec/member/hasKey",
        {
          uniqKey:uniqKeyVal
        },
        function(data, status){
            if(data!=="0"){
              $('#'+uniqKey.attr('id')+'-error').css('display','initial');
              $('#'+uniqKey.attr('id')).focus();
              $('#'+uniqKey.attr('id')+'-form').addClass('has-error');
            }
            else{
              $('#'+uniqKey.attr('id')+'-error').css('display','none');
              $('#'+uniqKey.attr('id')+'-form').removeClass('has-error');
            }
        });
   });
    
   $('#member-form').submit(function(event){
         if(!($('#personalGroup').hasClass('has-error') || $('#email1-form').hasClass('has-error')||$('#email2-form').hasClass('has-error')||                 $('#email3-form').hasClass('has-error')|| $('#email4-form').hasClass('has-error') || $('#email5-form').hasClass('has-error') || $('#uniqKey-form').hasClass('has-error'))){
              if($('#email1').val()!==$('#email2').val() && $('#email1')!==$('#email3').val() && $('#email2').val()!==$('#email3').val()){
                  if(typeof ($('#email4').val())!=="undefined"){
                      if(typeof ($('#email5').val())!=="undefined"){
                          if($('#email1').val() !== $('#email4').val() && $('#email2').val() !== $('#email4').val() 
                             && $('#email3').val() !== $('#email4').val() && $('#email4').val() !== $('#email5').val()
                             && $('#email5').val() !== $('#email1').val() && $('#email5').val() !== $('#email2').val()
                             && $('#email5').val() !== $('#email3').val()){
                              $('#member-form').submit();
                              return true;
                          }
                          else{
                              $('#form-status').css('display','initial');
                              $('#form-status').html('Email Duplicate!, could not update the information.');
                              $("html, body").animate({ scrollTop: 0 }, "slow");
                              return false;
                          }
                      }
                      else{
                          if($('#email1').val() !== $('#email4').val() && $('#email2').val() !== $('#email4').val() 
                             && $('#email3').val() !== $('#email4').val()){
                              $('#member-form').submit();
                              return true;
                          } 
                          else{
                              $('#form-status').css('display','initial');
                              $('#form-status').html('Email Duplicate!, could not update the information.');
                              $("html, body").animate({ scrollTop: 0 }, "slow");
                              return false;
                          }
                      }
                  }
                  else{
                     $('#member-form').submit();
                     return true; 
                  }
             }
             else{
                 $('#form-status').css('display','initial');
                 $('#form-status').html('Email Duplicate!, could not update the information.');
                 $("html, body").animate({ scrollTop: 0 }, "slow");
                 return false;
             }     
          }
          else{
             $('#form-status').css('display','initial');
             $('#form-status').html('There are some errors in the form, please correct them before update.');
             $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;
          }
   });    
});
    
    
function hasEmail(email){
        var emailVal=email.value;
        $.post("/OTPSec/member/hasEmail",
        {
          email:emailVal
        },
        function(data, status){
            if(data!=="0"){
              $('#'+email.getAttribute('id')+'-error').css('display','initial');
              $('#'+email.getAttribute('id')).focus();
              $('#'+email.getAttribute('id')+'-form').addClass('has-error');
            }
            else{
              $('#'+email.getAttribute('id')+'-error').css('display','none');
              $('#'+email.getAttribute('id')+'-form').removeClass('has-error');
            }
        });
}
    
function addEmails(){
     if($('#edit_btn').attr('disabled')==="disabled"){
         if(noEmail!=6){
              var inputEmail='<font style="color:red; font-weight:normal; font-size:15px; display:none;" id="email'+noEmail+'-error">The email is not available</font>';
              inputEmail+='<div class="form-group" id="email'+noEmail+'-form">';
              inputEmail+='<label class="control-label col-md-4" for="email'+noEmail+'" id="label-email'+noEmail+'">'+noEmail+'th Email:</label>';
              inputEmail+='<div class="col-md-8">';
              inputEmail+='<div class="input-group">';
              inputEmail+='<input type="email" class="form-control" id="email'+noEmail+'" name="email'+noEmail+'" placeholder="'+noEmail+'th Email" onchange="hasEmail(this)" autocomplete="off" required>';
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
}
    
function deleteEmails(noOfEmail){
    if($('#edit_btn').attr('disabled')==="disabled"){
        $('div').remove('#email'+noOfEmail+'-form');
        $('#email'+noOfEmail+'-error').remove();
        if(noEmail==6 && noOfEmail==4){
          $('#email5-error').attr('id','email4-error');
          $('#email5-form').attr('id','email4-form');
          $('#label-email5').attr('for','email4');
          $('#label-email5').html('4th Email:');
          $('#label-email5').attr('id','label-email4');
          $('#email5').attr('placeholder','4th Email');
          $('#email5').attr('name','email4');
          $('#email5').attr('id','email4');
          $('#delete-email5').attr('onclick','deleteEmails(4)');
          $('#delete-email5').attr('id','delete-email4');
        }
        noEmail--;
        if(noEmail==5){
            $('.input-group-btn').prepend('<button class="btn btn-default addBtn" type="button" onclick="addEmails()"><span class="fui-plus"></span></button>');
        }
    }
}
</script>
<?php elseif (isset($page) && $page=='regis') :?>
<script language="javascript" type="text/javascript">
$(function() {
    
   $('#username').change(function(event){
        var username=$('#username').val();
        $.post("/OTPSec/member/hasRUsername",
        {
          username:username
        },
        function(data, status){
            if(data!=="0"){
              $('#personalHeader').append('<font style="color:red; font-weight:normal; font-size:15px;" id="err-name"><br>The username is not available.</font>');
              $('#username').focus();
              $('#personalGroup').addClass('has-error');
            }
            else{
              $('#err-name').remove();
              $('#personalGroup').removeClass('has-error');
            }
        });
   });
    
   $('#uniqKey').change(function(event){
        var uniqKey=$('#uniqKey');
        var uniqKeyVal=uniqKey.val();
        $.post("/OTPSec/member/hasRKey",
        {
          uniqKey:uniqKeyVal
        },
        function(data, status){
            if(data!=="0"){
              $('#'+uniqKey.attr('id')+'-error').css('display','initial');
              $('#'+uniqKey.attr('id')).focus();
              $('#'+uniqKey.attr('id')+'-form').addClass('has-error');
            }
            else{
              $('#'+uniqKey.attr('id')+'-error').css('display','none');
              $('#'+uniqKey.attr('id')+'-form').removeClass('has-error');
            }
        });
   });
    
   $('#member-form').submit(function(event){
         if(!($('#personalGroup').hasClass('has-error') || $('#email1-form').hasClass('has-error')||$('#email2-form').hasClass('has-error')||                 $('#email3-form').hasClass('has-error') || $('#uniqKey-form').hasClass('has-error'))){
              if($('#email1').val()!==$('#email2').val() && $('#email1')!==$('#email3').val() && $('#email2').val()!==$('#email3').val()){
                 $('#member-form').submit();
                 return true; 
             }
             else{
                 $('#form-status').css('display','initial');
                 $('#form-status').html('Email Duplicate!, could not apply the form.');
                 $("html, body").animate({ scrollTop: 0 }, "slow");
                 return false;
             }     
          }
          else{
             $('#form-status').css('display','initial');
             $('#form-status').html('There are some errors in the form, please correct them before apply.');
             $("html, body").animate({ scrollTop: 0 }, "slow");
             return false;
          }
   });    
});  
    
function hasEmail(email){
        var emailVal=email.value;
        $.post("/OTPSec/member/hasREmail",
        {
          email:emailVal
        },
        function(data, status){
            if(data!=="0"){
              $('#'+email.getAttribute('id')+'-error').css('display','initial');
              $('#'+email.getAttribute('id')).focus();
              $('#'+email.getAttribute('id')+'-form').addClass('has-error');
            }
            else{
              $('#'+email.getAttribute('id')+'-error').css('display','none');
              $('#'+email.getAttribute('id')+'-form').removeClass('has-error');
            }
        });
}
    
</script>
<?php endif;?>
</body>
</html>