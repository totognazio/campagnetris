<?php
#include ('top_header.php');
include("./classes/access_user/access_user_class.php");

$my_access = new Access_user(false);


// $my_access->language = "de"; // use this selector to get messages in other languages
if (isset($_GET['activate']) && isset($_GET['ident'])) { // this two variables are required for activating/updating the account/password
    $my_access->auto_activation = true; // use this (true/false) to stop the automatic activation
    $my_access->activate_account($_GET['activate'], $_GET['ident']); // the activation method 
}
if (isset($_GET['validate']) && isset($_GET['id'])) { // this two variables are required for activating/updating the new e-mail address
    $my_access->validate_email($_GET['validate'], $_GET['id']); // the validation method 
}
if (isset($_POST['Submit'])) {
    #echo 'ezioooo';
    $my_access->save_login = (isset($_POST['remember'])) ? $_POST['remember'] : "no"; // use a cookie to remember the login
    $my_access->count_visit = false; // if this is true then the last visitdate is saved in the database (field extra info)
    $my_access->login_user($_POST['login'], $_POST['password']); // call the login method
}
$error = $my_access->the_msg;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tool Campaign | </title>

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

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                
              <h1>Login Form</h1>
              <div>
                <input type="text" class="form-control" placeholder="Username" required="" name="login"   value="<?php echo (isset($_POST['login'])) ? $_POST['login'] : $my_access->user; ?>"/>
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" required="" name="password" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>" />
              </div>
              <div>
                
                <input class="btn btn-default submit" type="submit" name="Submit" value="Login" />
                <a class="reset_pass" href="forgot_password.php">Lost your password?</a>
              </div>

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
                  <h1> Tool Campaign </h1>
                  <p></p>
                </div>
              </div>
            </form>
          </section>
        </div>

        <div id="register" class="animate form registration_form">
          <section class="login_content">
            <form>
              <h1>Create Account</h1>
              <div>
                <input type="text" class="form-control" placeholder="Username" required="" />
              </div>
              <div>
                <input type="email" class="form-control" placeholder="Email" required="" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
                    <p>
                        <input class="button"  type="submit" name="Submit" value="Login">
                    </p>
                    <p><b><?php echo (isset($error)) ? $error : "&nbsp;"; ?></b></p>
              </div>
              
              <label for="remember">Automatic login?</label>
                    <input type="checkbox" name="remember" value="yes"<?php echo ($my_access->is_cookie == true) ? " checked" : ""; ?> />
              
              
              
              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Already a member ?
                  <a href="#signin" class="to_register"> Log in </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-paw"></i> Device Engineering</h1>
                  <p></p>
                </div>
              </div>
            </form>
                              <p><b><?php echo (isset($error)) ? $error : "&nbsp;"; ?></b></p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p><a href="./forgot_password.php">Forgot your password?</a></p>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>



