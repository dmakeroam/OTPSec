<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="container">
  <div class="row">
    <div class="Absolute-Center is-Responsive">
      <div class="col-sm-12 col-md-10 col-md-offset-1">
        <?php if(isset($error)):?>
        <p style='text-align:center; color:red;'><?=$error?></p>
        <?php endif;?>
         <?=form_open('',array('id'=>'login_form','onsubmit'=>'return showProgressBar()'))?>
          <div class="form-group input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input class="form-control" type="text" name='username' id="username" placeholder="Username" required="true"/>          
          </div>
          <div class="form-group">
            <button type="submit" id="login_btn" class="btn btn-def btn-block">Login</button>        
          </div>
         <?=form_close()?>    
      </div> 
    </div> 
  </div>
</div>