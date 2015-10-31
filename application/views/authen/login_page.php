<!doctype html>
<html lang='en'>
<head>
<title>OTPSec Authentication</title>
<meta charset="utf-8"/>
<link rel='stylesheet' type='text/css' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css'>
<?=link_tag('assets/css/main/style.css')?>
</head>
<body>
<div class="navbar navbar-fixed-top navbar-default">
    <div class="navbar-inner">
        <div class="container">
        <nav class='navbar-brand'>
        OTPSec Authentication   
        </nav>
        </div>
    </div>
</div> 

<div class="container">
  <div class="row">
    <div class="Absolute-Center is-Responsive">
      <div class="col-sm-12 col-md-10 col-md-offset-1">
        <form action="" id="loginForm" method="post">
          <div class="form-group input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input class="form-control" type="text" name='username' placeholder="Username" required="true"/>          
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-def btn-block">Login</button>
          </div>
        </form>        
      </div>  
    </div>    
  </div>
</div>    
    
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js' type='text/javascript'>
</script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js' type='text/javascript'>
</script>
</body>
</html>