<?php 
include_once 'db_config.php';
include_once 'classes/access_user/access_user_class.php'; 

$renew_password = new Access_user;

if (isset($_POST['Submit'])) {
	$renew_password->forgot_password($_POST['email']);
} 
$error = $renew_password->the_msg;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Device Engineering | </title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="./build/css/custom.min.css" rel="stylesheet">
  </head>
<title>Forgot password </title>

</head>

  <body class="login">
    <div>
      <div class="login_wrapper">
        
          <section class="login_content"> 
          <form  name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >    
           
              <h1>Forgot Login</h1>
  <!--<label class="form-control" placeholder="Email" required="" for="email">E-mail:</label>-->
  <!--<input type="text" name="email" value="<?php #echo (isset($_POST['email'])) ? $_POST['email'] : ""; ?>">-->
                <div>
                <input type="email" class="form-control" placeholder="Enter the E-mail address used during registration" required="" name="email" value="<?php echo (isset($_POST['email'])) ? $_POST['email'] : ""; ?>"/>

                </div>
  
  <!--<input type="submit" name="Submit" value="Submit">-->
  
  
                <div>
                    <p>
                        <input class="btn btn-default submit"  type="submit" name="Submit" value="Submit">
                    </p>
                    <p><b><?php echo (isset($error)) ? $error : "&nbsp;"; ?></b></p>
              </div>
  
  
  


<p>&nbsp;</p>
<!-- Notice! you have to change this links here, if the files are not in the same folder -->
<p><a class="to_register" href="<?php echo $renew_password->login_page; ?>">Start</a></p>

          
            
                          <div class="clearfix"></div>

              <div class="separator">
               <!--   
                <p class="change_link">New to site?
                  <a href="#signup" class="to_register"> Create Account </a>
                </p>
               -->
                <div class="clearfix"></div>
                <br />

                <div>
                  <h1> Device Engineering</h1>
                  <p></p>
                </div>
              </div>
            </form>              
         </section>   
      
      </div>
    </div>
  </body>
</html>

