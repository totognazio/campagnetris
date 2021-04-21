  <?php 

ob_start(); 
include_once ('db_config.php');
//include($_SERVER['DOCUMENT_ROOT'] . APPLICATION_PATH . "access_user_class.php");
include_once("./classes/access_user/access_user_class.php");
date_default_timezone_set('Europe/Rome');
//include_once 'socmanager_class.php';

//session_start();
// set timeout period in seconds (600 = 10 minutes in seconds)
$inactive = 2400;
// check to see if $_SESSION['timeout'] is set

if (isset($_SESSION['timeout'])) {
    $session_life = time() - $_SESSION['timeout'];
    if ($session_life > $inactive) {
        session_destroy();
        header("Location: logout.php");
    }
}
$_SESSION['timeout'] = time();

if (isset($_GET['page']) && $_GET['page'] == "grafici" && isset($_GET['update_lsoc']) && isset($_GET['nome_tel']) && $_GET['nome_tel'] != " ") {
    $next_page = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $_SESSION['next_page'] = $next_page;
}

if (isset($_GET['page']) && $_GET['page'] == "statistiche") {
    if (isset($_GET['device_per_ff'])){
    $next_page = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $_SESSION['next_page'] = $next_page;
    #print_r($_GET);
}}


$page_protect = new Access_user(TRUE);
$page_protect->access_page($_SERVER['PHP_SELF'], "", 1);

#$page_protect->login_page; // change this only if your login is on another page
$page_protect->access_page(); // only set this this method to protect your page
$page_protect->get_user_info();
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;




if (isset($_GET['action']) && $_GET['action'] == "log_out") {
    $page_protect->log_out(); // the method to log off
}


if (isset($_GET['function']))
    if ($_GET['function'] == "logout")
        session_destroy();

    
  
    if (isset($_POST['username']) & isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        if ($username == $nome_utente & $password == $pass_utente) {
            $_SESSION['login_effettuato'] = true;

            #}
        } else {
            echo 'Accesso non consentito.<br>Bisogna effettuare nuovamente il login';
        }
    }
	
	  include "head.php"; 
  ?>
  
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">

			<div class="navbar nav_title" style="border: 0;">                                  
				<a href="index.php" class="site_title"><i class="fa fa-group"></i><img title="Tool Campaign" src="images/logo-campaign.gif" style="margin-left:5px; margin-top:1px; height:20px;"/></a>
			</div>

            <div class="clearfix"></div>

            <!-- menu profile quick info 
            <div class="profile">
              <div class="profile_pic">
                <img src="images/img.jpg" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2>John Doe</h2>
              </div>
            </div>
             /menu profile quick info -->

            <br/><br/><br/><br/>
			
			<?php include "menu.php"; ?>
			<?php include "top_navigation.php"; ?>
			                <?php
                if (isset($_GET['page'])) {
                    if ($_GET['page'] != "") {
                        include $_GET['page'] . ".php";
                        #include "serverbusy.html";
                    }
                }
                elseif (isset($_GET['sec']) and ($_GET['sec'] != "") ) {
                    if (isset($_GET['pg']) and ($_GET['pg'] != "") ) {

                            include "./".$_GET['sec']."/".$_GET['pg'] . ".php";
                            #include "serverbusy.html";
                        }
                }
                else {
					include "pianificazione2.php";
                    //include "pianificazione.php";
                    // include "gestioneCampagne.php";
                    #include "serverbusy.html";
                    #include "./".gestioneLSoc&pg=admin_lsoc
                }
print_r($_SESSION);                
			
include "footer.php"; 

			
			