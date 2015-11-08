<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="container">
  <div class="row">
    <div class="Absolute-Center is-Responsive" style='max-width:450px;'>
      <div class="col-sm-12 col-md-10 col-md-offset-1">
         <p style='color:#777;'>Enter the OTP code we sent to your emails.</p>
         <?=form_open('',array('id'=>'otp_input_form','onsubmit'=>'return showProgressBar()'))?>
          <div class="form-group input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input class="form-control" type="text" name='otp_code' id="otp_code" placeholder="OTP Code" required="true"/>          
          </div>
          <div class="form-group">
            <button type="submit" id="next_btn" class="btn btn-def btn-block">Next</button>        
          </div>
         <?=form_close()?>    
      </div> 
    </div> 
  </div>
</div>