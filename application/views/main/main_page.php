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
        <?=form_open('member/update',array('class'=>'form-horizontal','role'=>'form','id'=>'member-form'))?>
        <div class="col-md-7" id="personalInfo">
              <div class="form-group" id="personalGroup">
                <p class='topicHeader' id="personalHeader">Personal Information</p>
                <label class="control-label col-md-4" for="username">Username:</label>
                <div class="col-md-8">
                <input type="text" class="form-control" id="username" name="username" autocomplete="off" placeholder="Username" value="<?=$username?>" readonly> 
                </div>
              </div>
              <div class="form-group" id="email1-form">
                <p class='subTopic'>User Emails (Max : 5 Emails) <font style="color:red; font-weight:normal; font-size:15px; display:none;" id="email1-error"><br>The email is not available.</font></p>
                <label class="control-label col-md-4" for="email1">1st Email:</label>
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="email" class="form-control" id="email1" name="email1" autocomplete="off" placeholder="1st Email" onchange="hasEmail(this)" value="<?=$emails[0]?>" readonly>
                    </div>
                </div>
              </div>
             <font style="color:red; font-weight:normal; font-size:15px; display:none;" id="email2-error">The email is not available.</font>
              <div class="form-group" id="email2-form">
                <label class="control-label col-md-4" for="email2">2nd Email:</label>
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="email" class="form-control" id="email2" name="email2" autocomplete="off" placeholder="2nd Email" onchange="hasEmail(this)" value="<?=$emails[1]?>" readonly>
                    </div>
                </div>
              </div>
              <font style="color:red; font-weight:normal; font-size:15px; display:none;" id="email3-error">The email is not available.</font>
              <div class="form-group" id="email3-form">
                <label class="control-label col-md-4" for="email3">3rd Email:</label>
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="email" class="form-control" id="email3" name="email3" autocomplete="off"  placeholder="3rd Email" onchange="hasEmail(this)" value="<?=$emails[2]?>" readonly>
                        <span class="input-group-btn">
                        <?php if(count($emails)!=5) :?>
                            <button class="btn btn-default addBtn" type="button" onclick="addEmails()"><span class='fui-plus'></span></button>
                        <?php endif; ?>
                        </span>
                    </div>
                </div>
              </div>
              <?php if(count($emails)==4) :?>
                 <font style="color:red; font-weight:normal; font-size:15px; display:none;" id="email4-error">The email is not available.</font>
                 <div class="form-group" id="email4-form">
                     <label class="control-label col-md-4" for="email4" id="label-email4">4th Email:</label>
                     <div class="col-md-8">
                         <div class="input-group">
                             <input type="email" class="form-control" id="email4" name="email4" placeholder="4th Email"  value="<?=$emails[3]?>" onchange="hasEmail(this)" autocomplete="off" readonly>
                             <span class="input-group-btn">
                                 <button class="btn btn-default addBtn" type="button" onclick="addEmails()">
                                 <span class="fui-plus">
                                 </span>
                                 </button>
                                 <button class="btn btn-default" type="button" onclick="deleteEmails(4)" id="delete-email4">
                                     <span class="fui-cross"></span>
                                 </button></span>
                         </div>
                     </div>
                </div>
              <?php elseif (count($emails)==5) :?>
                  <font style="color:red; font-weight:normal; font-size:15px; display:none;" id="email4-error">The email is not available.</font>
                  <div class="form-group" id="email4-form">
                      <label class="control-label col-md-4" for="email4" id="label-email4">4th Email:</label>
                      <div class="col-md-8"><div class="input-group">
                          <input type="email" class="form-control" id="email4" name="email4" placeholder="4th Email" value="<?=$emails[3]?>" onchange="hasEmail(this)" autocomplete="off" readonly>
                          <span class="input-group-btn">
                              <button class="btn btn-default" type="button" onclick="deleteEmails(4)" id="delete-email4">
                                  <span class="fui-cross">
                                  </span>
                              </button>
                          </span>
                          </div>
                      </div>
                  </div>
                  <font style="color:red; font-weight:normal; font-size:15px; display:none;" id="email5-error">The email is not available.</font>
                  <div class="form-group" id="email5-form">
                      <label class="control-label col-md-4" for="email5" id="label-email5">5th Email:</label>
                      <div class="col-md-8">
                          <div class="input-group">
                              <input type="email" class="form-control" id="email5" name="email5" placeholder="5th Email" value="<?=$emails[4]?>" autocomplete="off" onchange="hasEmail(this)" readonly>
                              <span class="input-group-btn">
                                  <button class="btn btn-default" type="button" onclick="deleteEmails(5)" id="delete-email5">
                                      <span class="fui-cross">
                                      </span>
                                  </button>
                              </span>
                          </div>
                      </div>
                  </div>
              <?php endif;?>
        </div>
        <div class="col-md-7">
              <div class="form-group" id="uniqKey-form">
                <p class='topicHeader'>Security <font style="color:red; font-weight:normal; font-size:15px; display:none;" id="uniqKey-error"><br>The key is not available.</font></p>
                <label class="control-label col-md-4" for="uniqKey">Unique key:</label>
                <div class="col-md-8">
                <input type="password" class="form-control" id="uniqKey" name="uniqKey" placeholder="Unique Key" autocomplete="off" value="<?=$uniq_key?>" readonly>
                </div>
              </div>
        </div>
        <div class="col-md-6">
              <div class="form-group" id="submit-option">
                <div class="col-md-5">
                    <input type="submit" class="btn btn-block btn-lg btn-default disabled" id="save_btn" name="save_btn" value='Save'>
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-5">
                    <input type="button" class="btn btn-block btn-lg btn-default" id="edit_btn" name="edit_btn" value='Edit'>
                </div>
              </div>
        </div>
        <?=form_close()?>
    </div> 
  </div>
</div>