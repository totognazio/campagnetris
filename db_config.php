<?php

//include_once($_SERVER['DOCUMENT_ROOT'].'/classes/db.php');
// use this pathes and/or define the pathes for the "standard" pages
define("CLASS_PATH", dirname($_SERVER['PHP_SELF']) . "/classes/"); // the location where the class is executed

$sec_path = "/campagne_dev/"; // a second location where the scripts should be 
//$sec_path = "/"; // a second location where the scripts should be 
define("APPLICATION_PATH", $sec_path);

//define("DB_SERVER", "127.0.0.1");
define("DB_SERVER", "127.0.0.1");  //usare localhost
//define("DB_SERVER", "10.194.25.2");
define("DB_NAME", "newcampaigns2");
define("DB_USER", "root");
define("DB_PASSWORD", "H3g2013");

// Important! use this setting to store the session data in your Mysql database
// disable this feature if your host doesn't support this session handler.
define("USE_MYSQL_SESSIONS", TRUE); // "false" to disable this setting
// these are the names for the standard table names
// !!! Important
// It's possible that your server doesn't allow the database name inside a query
// if this forms a problem don't use them here and unescape the mysql_select_db() function
// inside the connect_db() method.
define("USER_TABLE", DB_NAME . ".users");
define("PROFILE_TABLE", DB_NAME . ".users_profile");
define("COUNTRY_TABLE", DB_NAME . ".countries"); // an optional table with countruy names and codes
define("SESSION_TABLE", DB_NAME . ".sessions");
define("LOG_TABLE", DB_NAME . ".log");

// variables (locations) standard pages (combine the pathes from the top or use your own)
define("LOGIN_PAGE", APPLICATION_PATH . "login.php");
define("START_PAGE", APPLICATION_PATH . "index.php");
define("ACTIVE_PASS_PAGE", APPLICATION_PATH . "activate_password.php");
define("DENY_ACCESS_PAGE", APPLICATION_PATH . "login.php");
define("ADMIN_PAGE", APPLICATION_PATH . "admin_user.php");
define("LOGOUT_PAGE", APPLICATION_PATH . "logout.php"); // if you use the setting "USE_MYSQL_SESSIONS" you need a logout page without class object to clear the old session data from the database
define("UPDATE_PROFILE", APPLICATION_PATH . "update_user_profile.php"); // if the update profile extension is used and the profile record doesn't exists a required redirect to this page is possible
// your path must be related to the site root.
// change this constants to the right mail settings
define("WEBMASTER_MAIL", "marco.rattini@h3g.it");
define("WEBMASTER_NAME", "amministratore Tool Campaign");
define("ADMIN_MAIL", "contact@domain.com");
define("ADMIN_NAME", "The site admin");

// change this vars if you need...
define("PW_LENGTH", 4);
define("LOGIN_LENGTH", 6);
define("SECRET_STRING", "tellme"); // since version 1.98

define("COOKIE_NAME", "user");
define("COOKIE_PATH", APPLICATION_PATH);
define("MIN_ACCESS_LEVEL", 1);
define("MAX_ACCESS_LEVEL", 10);
define("DEFAULT_ACCESS_LEVEL", 1);
define("DEFAULT_ADMIN_LEVEL", 10);

// change these settings to use phpmailer in place of the PHP mail() function
define("USE_PHP_MAILER", true); // true = use phpmailer
define("PHP_MAILER_SMTP", true); // true send by SMTP, false = sendmail
// if you enable these features you need to install the phpmailer class!
if (USE_PHP_MAILER){
    include_once("./classes/PHPMailer/PHPMailerAutoload.php");
}
if (PHP_MAILER_SMTP) {
    define("SMTP_SERVER", "smtp.gmail.com");
    define("SMTP_LOGIN", "toolcampain@gmail.com");
    define("SMTP_PASSWD", "toolcampain2015");
}

//////////////////////////////////////////////////
// constants and field names user profile table //
/////////////////////////////////////////////// //
// stamdard fields are: address, postcode, city, country, phone, fax, homepage, textfield
// variables must match your user profile table design
// use this four user defined fields (type varchar(100) too
// change the value of a constant but change them in the mysql table too
// otherwise you wil get some ERROR'S !!!
define("TBL_USERFIELD_1", "user_1");
define("TBL_USERFIELD_2", "user_2");
define("TBL_USERFIELD_3", "user_3");
define("TBL_USERFIELD_4", "user_4");
define("TBL_USERFIELD_5", "user_5");
define("TBL_USERFIELD_6", "user_6");
?>
