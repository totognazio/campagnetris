<?php
include_once ('db_config.php');
#include_once($_SERVER['DOCUMENT_ROOT'] . APPLICATION_PATH . "classes/accesse_user/access_user_class.php");
include_once("./classes/access_user/access_user_class.php");

class Admin_user extends Access_user {

    var $user_found = false;
    var $user_id;
    var $user_name;
    var $old_user_email;
    var $user_access_level;
    var $activation;

    function get_userdata($for_user, $type = "login") {
        if ($type == "login") {
            $sql = sprintf("SELECT id, login, email, access_level, active FROM %s WHERE login = '%s'", $this->table_name, trim($for_user));
        } else {
            $sql = sprintf("SELECT id, login, email, access_level, active FROM %s WHERE id = %d", $this->table_name, intval($for_user));
        }
        $result = mysql_query($sql);
        if (mysql_num_rows($result) == 1) {
            $obj = mysql_fetch_object($result);
            $this->user_id = $obj->id;
            $this->user_name = $obj->login;
            $this->old_user_email = $obj->email;
            $this->user_access_level = $obj->access_level;
            $this->activation = $obj->active;
            if ($this->user_name != $_SESSION['user']) {
                $this->user_found = true;
            } else {
                $this->user_found = false;
                $this->the_msg = "It's not allowed to change your own data!";
            }
            mysql_free_result($result);
        } else {
            $this->the_msg = "Sorry, no data for this loginname!";
        }
    }

    function update_user_by_admin($new_level, $user_id, $new_email, $active) {
        $this->user_found = true;
        $this->user_access_level = $new_level;

        if ($this->check_email($new_email)) {
            $sql = "UPDATE %s SET access_level = %d, email = '%s', active = '%s'";
            $sql .= " WHERE id = %d";
            $sql_compl = sprintf($sql, $this->table_name, $new_level, $new_email, $active, $user_id);
            if (mysql_query($sql_compl)) {
                $this->the_msg = "Data is modified for user with id#<b>" . $user_id . "</b>";
                
            } else {
                $this->the_msg = "Database error, please try again!";
            }
        } else {
            $this->the_msg = "The e-mail address is invalid!";
        }
    }

    function access_level_menu($curr_level, $element_name = "level") {
        $menu = "<select name=\"" . $element_name . "\">\n";
        for ($i = MIN_ACCESS_LEVEL; $i <= MAX_ACCESS_LEVEL; $i++) {
            $menu .= "  <option value=\"" . $i . "\"";
            $menu .= ( $curr_level == $i) ? " selected>" : ">";
            $menu .= $i . "</option>\n";
        }
        $menu .= "</select>\n";
        return $menu;
    }

    // modified in version 1.97
    function activation_switch($formelement = "activation") {
        $radio_group = "<label for=\"" . $formelement . "\">Active?</label>\n";
        $labels = array("y" => "yes", "n" => "no", "b" => "blocked");
        foreach ($labels as $key => $val) {
            $radio_group .= " <input name=\"" . $formelement . "\" type=\"radio\" value=\"" . $key . "\" ";
            $radio_group .= ( $this->activation == $key) ? "checked=\"checked\" />\n" : "/>\n";
            $radio_group .= $val;
        }
        return $radio_group;
    }

}

$admin_update = new Admin_user;
$admin_update->access_page($_SERVER['PHP_SELF'], $_SERVER['QUERY_STRING'], DEFAULT_ADMIN_LEVEL); // check the level inside the config file

if (isset($_POST['Submit'])) {
    if ($_POST['Submit'] == "Update") {
        $admin_update->update_user_by_admin($_POST['level'], $_POST['user_id'], $_POST['email'], $_POST['activation']);
        $admin_update->get_userdata($_POST['login_name']); // this is needed to get the modified data after update
    } elseif ($_POST['Submit'] == "Search") {
        $admin_update->get_userdata($_POST['login_name']);
    }
} elseif (isset($_GET['login_id']) && intval($_GET['login_id']) > 0) {
    $admin_update->get_userdata($_GET['login_id'], "is_id");
}
$error = $admin_update->the_msg; // error message
?>


<h2>Admin page (user data)</h2>
<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <?php if ($admin_update->user_found) { ?>
        <p>Use this form to change the access level or replace the user's email and/or password.</p>
        <label for="login">User name :</label>
        <b><?php echo $admin_update->user_name; ?></b><br>
        <label for="level">(new) Access level</label>
        <?php echo $admin_update->access_level_menu($admin_update->user_access_level); ?>
        <br>
        <label for="email">E-mail:</label>
        <input type="text" name="email" size="25" value="<?php echo (isset($_POST['email'])) ? $_POST['email'] : $admin_update->old_user_email; ?>">
        <br>
        <?php echo $admin_update->activation_switch(); ?><br>
        <input type="hidden" name="user_id" value="<?php echo (isset($_POST['user_id'])) ? $_POST['user_id'] : $admin_update->user_id; ?>">
        <input type="hidden" name="login_name" value="<?php echo $admin_update->user_name; ?>">
        <input type="submit" name="Submit" value="Update">
        <p style="margin-top:50px;"><a href="<?php echo $_SERVER['PHP_SELF']; ?>">search next user...</a></p>
    <?php } else { ?>
        <p>Enter the login name from the user where the modifications has to be done:</p>
        <?php // the next element name (login_name) is used inside the class don't use a different name  ?>
        <input type="text" name="login_name" value="<?php echo (isset($_POST['login_name'])) ? $_POST['login_name'] : ""; ?>">
        <input type="submit" name="Submit" value="Search">
    <?php } // end if / else show update search form   ?>
</form>
<p><b><?php echo (isset($error)) ? $error : "&nbsp;"; ?></b></p>
<p>&nbsp;</p>

