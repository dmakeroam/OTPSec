<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="container">
  <div class="row">
    <div id="keepLeft">
        <font style="<?php if(isset($successMessage)):?>color:green;<?php else:?>color:red;<?php endif;?> font-weight:normal; font-size:15px; <?php if(!(isset($errorMessage) || isset($successMessage))):?>display:none;"<?php endif;?> id="form-status"><?php if(isset($errorMessage)) :?>
        <?=$errorMessage?>
        <?php elseif(isset($successMessage)) :?>
        <?=$successMessage?>
        <?php endif;?></font>
        <?=form_open('member/add',array('class'=>'form-horizontal','role'=>'form','id'=>'member-form'))?>
        <div class="col-md-7" id="personalInfo">
              <div class="form-group" id="personalGroup">
                <p class='topicHeader' id="personalHeader">Personal Information</p>
                <label class="control-label col-md-4" for="username">Username:</label>
                <div class="col-md-8">
                <input type="text" class="form-control" id="username" name="username" autocomplete="off" placeholder="Username" value="<?=set_value('username');?>" required> 
                </div>
              </div>
              <div class="form-group" id="email1-form">
                <p class='subTopic'>User Emails<font style="color:red; font-weight:normal; font-size:15px; display:none;" id="email1-error"><br>The email is not available.</font></p>
                <label class="control-label col-md-4" for="email1">1st Email:</label>
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="email" class="form-control" id="email1" name="email1" autocomplete="off" placeholder="1st Email" onchange="hasEmail(this)" value="<?=set_value('email1');?>" required>
                    </div>
                </div>
              </div>
             <font style="color:red; font-weight:normal; font-size:15px; display:none;" id="email2-error">The email is not available.</font>
              <div class="form-group" id="email2-form">
                <label class="control-label col-md-4" for="email2">2nd Email:</label>
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="email" class="form-control" id="email2" name="email2" autocomplete="off" placeholder="2nd Email" onchange="hasEmail(this)" value="<?=set_value('email2');?>" required>
                    </div>
                </div>
              </div>
              <font style="color:red; font-weight:normal; font-size:15px; display:none;" id="email3-error">The email is not available.</font>
              <div class="form-group" id="email3-form">
                <label class="control-label col-md-4" for="email3">3rd Email:</label>
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="email" class="form-control" id="email3" name="email3" autocomplete="off"  placeholder="3rd Email" onchange="hasEmail(this)" value="<?=set_value('email3');?>" required>
                    </div>
                </div>
              </div>
        </div>
        <div class="col-md-7">
              <div class="form-group" id="uniqKey-form">
                <p class='topicHeader'>Security <font style="color:red; font-weight:normal; font-size:15px; display:none;" id="uniqKey-error"><br>The key is not available.</font></p>
                <label class="control-label col-md-4" for="uniqKey">Unique key:</label>
                <div class="col-md-8">
                <input type="password" class="form-control" id="uniqKey" name="uniqKey" placeholder="Unique Key" autocomplete="off" value="<?=set_value('uniqKey');?>" required>
                </div>
              </div>
        </div>
        <div class="col-md-7">
        <?=$this->recaptcha->getWidget()?>
        </div>
        <div class="col-md-6">
              <div class="form-group" id="submit-option">
                <div class="col-md-5" style='margin-top:5%;'>
                    <input type="submit" class="btn btn-block btn-lg btn-default" id="apply_btn" name="apply_btn" value='Apply'>
                </div>
              </div>
        </div>
        <?=form_close()?>
    </div> 
  </div>
</div>