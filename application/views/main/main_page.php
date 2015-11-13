<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<div class="container">
  <div class="row">
    <div id="keepLeft">
        <?=form_open('',array('class'=>'form-horizontal','role'=>'form'))?>
        <div class="col-md-7" id="personalInfo">
              <div class="form-group">
                <p class='topicHeader'>Personal Information</p>
                <label class="control-label col-md-4" for="username">Username:</label>
                <div class="col-md-8">
                <input type="text" class="form-control" id="username" name="username" autocomplete="off" placeholder="Username" readonly> 
                </div>
              </div>
              <div class="form-group">
                <p class='subTopic'>User Emails (Max : 5 Emails)</p>
                <label class="control-label col-md-4" for="email1">1st Email:</label>
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="email" class="form-control" id="email1" name="email1" autocomplete="off" placeholder="1st Email" readonly>
                    </div>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-4" for="email2">2nd Email:</label>
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="email" class="form-control" id="email2" name="email2" autocomplete="off" placeholder="2nd Email" readonly>
                    </div>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-4" for="email3">3rd Email:</label>
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="email" class="form-control" id="email3" name="email3" autocomplete="off"  placeholder="3rd Email" readonly>
                        <span class="input-group-btn">
                        <button class="btn btn-default addBtn" type="button" onclick="addEmails()"><span class='fui-plus'></span></button>
                        </span>
                    </div>
                </div>
              </div>
        </div>
        <div class="col-md-7">
              <div class="form-group">
                <p class='topicHeader'>Security</p>
                <label class="control-label col-md-4" for="uniqKey">Unique key:</label>
                <div class="col-md-8">
                <input type="password" class="form-control" id="uniqKey" name="uniqKey" placeholder="Unique Key" autocomplete="off" readonly>
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