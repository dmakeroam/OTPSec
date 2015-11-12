<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<!doctype html>
<html lang='en'>
<head>
<title>
<?php if(isset($page) && $page==='member') :?>OTPSec Member<?php else:?>OTPSec Authentication<?php endif;?>
</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8"/>
<?=link_tag('https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css')?>
<?php if(isset($page) && $page==='login') :?>
<?=link_tag('assets/css/sweetalert2/sweetalert2.css')?>
<?php endif;?>
<?=link_tag('assets/css/main/style.css')?>
<?=link_tag('https://cdnjs.cloudflare.com/ajax/libs/flat-ui/2.2.2/css/flat-ui.min.css')?>
</head>
<body>
<div class="navbar navbar-fixed-top navbar-default">
    <div class="navbar-inner">
        <div class="container">
        <nav class='navbar-brand'>
            <a href='<?=base_url('')?>' class='a_link'><?php if(isset($page) && $page==='member') :?>OTPSec Member<?php else:?>OTPSec Authentication<?php endif;?></a>
        </nav>
        <?php if(isset($page) && $page==='member') :?>
        <nav class='navbar-brand-right'>
        Hi, <?=$username?>!
        </nav>
        <?php endif;?>
        </div>
    </div>
</div> 