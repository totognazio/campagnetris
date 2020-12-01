<?php 
#include("./classes/access_user/access_user_class.php"); 

class Users_profile extends Access_user {
	
	var $profile_tbl_name =  PROFILE_TABLE;
	var $profile_upd_page = UPDATE_PROFILE;
	
	var $avail_lang = array("it", "nl", "de", "en", "fr");
        var $the_msg;

	var $profile_id;
	var $address;
	var $postcode;
	var $city;
	var $country;
	var $phone;
	var $fax;
	var $homepage;
	var $notes;
	var $field_one;
	var $field_two;
	var $field_three;
	var $field_four;
        var $mysqli;
	
	function __construct($check_profile = true, $redirect = true) {
                $mysqli = $this->connect_dbli();
		if (empty($_SESSION['logged_in'])) {
			$this->login_reader();
			if ($this->is_cookie) {
				$this->set_user($redirect);
			}
		}
		if (isset($_SESSION['user'], $_SESSION['pw'])) {
			$this->user = $_SESSION['user'];
			$this->user_pw = $_SESSION['pw'];
			$get_profile = $this->get_profile_data();
			if ($check_profile && !$get_profile) {
				header("Location: ".$this->profile_upd_page);
				exit;
			} else {
				if (empty($_SESSION['user_id'])) $_SESSION['user_id'] = $this->id;
			}
		}
	}
        
        
	
	function extra_text($msg_num) {
		switch ($this->language) {
			case "nl":
			$extra_msg[1] = "Op het moment is geen profiel data aanwezig.";
			$extra_msg[2] = "De profiel data is gewijzigd.";
			$extra_msg[3] = "Er is een fout ontstaam tijdens het update, probeer het opnieuw.";
			break;
			case "de":
			$extra_msg[1] = "Zur Zeit verf&uuml;gt dieses Konto �ber keine weiteren Profildaten.";
			$extra_msg[2] = "Die Profildaten wurden ge&auml;ndert.";
			$extra_msg[3] = "Es ist ein Fehler entstanden, bitte probieren Sie es erneut.";
			break;
			case "fr":
			$extra_msg[1] = "Le profil ne contient actuellement aucune information.";
			$extra_msg[2] = "Les information de votre profil sont � jour.";
			$extra_msg[3] = "Il y a eu un probl�me pendant la mise � jour de votre profil. Veuillez r�essayer.";
			break;
                        case "it":
			$extra_msg[1] = "Nessun profilo utente è attualmente presente.";
			$extra_msg[2] = "Il profilo utente è stato aggiornato.";
			$extra_msg[3] = "Errore durante l'aggiornamento, riprovare.";
			break;
			default:
			$extra_msg[1] = "There is no profile data at the moment.";
			$extra_msg[2] = "Your profile data is up2date.";
			$extra_msg[3] = "There was an error during update, try it again.";
		}
		return $extra_msg[$msg_num];
	}
	// use this method to get the messages in the language of the user (if exist)
	function login_local($user, $password) {
		$this->get_language($user, $password);
		$this->login_user($user, $password);
	}
	function get_language($user, $pw) {
		$sql = sprintf("SELECT up.language AS lang FROM %s AS u, %s AS up WHERE u.login = %s AND u.pw = '%s' AND u.id = up.users_id ", $this->table_name, $this->profile_tbl_name, $this->ins_string($user), md5($pw));
		$result = mysqli_query($this->mysqli,$sql);
		if (mysql_num_rows($result) == 0) {
			return;
		} else {
			$lang = mysql_result($result, 0, "lang");
			if ($lang != "") {
				$this->language = $lang;
			} else {
				return;
			}
		}
	}
	function save_profile_date($ident = "", $lang = "", $address = "", $pc = "", $city = "", $country = "", $phone = "", $fax = "", $hp = "", $notes = "", $field1 = "", $field2 = "", $field3 = "", $field4 = "") {
		if (!empty($ident)) {
			$sql = sprintf("UPDATE %s SET language=%s, address=%s, postcode=%s, city=%s, country=%s, phone=%s, fax=%s, homepage=%s, notes=%s, %s=%s, %s=%s, %s=%s, %s=%s, last_change=NOW() WHERE id = %s AND users_id = %d", 
				PROFILE_TABLE, $this->ins_string($lang), $this->ins_string($address), $this->ins_string($pc),
				$this->ins_string($city), $this->ins_string($country), $this->ins_string($phone), $this->ins_string($fax),
				$this->ins_string($hp), $this->ins_string($notes), TBL_USERFIELD_1, $this->ins_string($field1),
				TBL_USERFIELD_2, $this->ins_string($field2), TBL_USERFIELD_3, $this->ins_string($field3),
				TBL_USERFIELD_4, $this->ins_string($field4), $this->ins_string($ident, "int"), $_SESSION['user_id']);
		} else {
			$sql = sprintf("INSERT INTO %s (id, users_id, language, address, postcode, city, country, phone, fax, homepage, notes, %s, %s, %s, %s, last_change) VALUES (NULL, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, NOW())",
				PROFILE_TABLE, TBL_USERFIELD_1, TBL_USERFIELD_2, TBL_USERFIELD_3, 
				TBL_USERFIELD_4, $_SESSION['user_id'], $this->ins_string($lang), $this->ins_string($address), 
				$this->ins_string($pc), $this->ins_string($city), $this->ins_string($country), $this->ins_string($phone), 
				$this->ins_string($fax), $this->ins_string($hp), $this->ins_string($notes), $this->ins_string($field1),
				$this->ins_string($field2), $this->ins_string($field3), $this->ins_string($field4));
		}	
		if (mysqli_query($this->mysqli,$sql) or die (mysqli_error($this->mysqli))) {
			$this->profile_id = (empty($_SESSION['is_rec'])) ? mysql_insert_id() : $ident;
			$this->the_msg = $this->extra_text(2);
		} else {
			$this->the_msg = $this->extra_text(3);
		}
	}
	function get_profile_data() {
		$this->get_user_info();
		$sql = sprintf("SELECT id, language, address, postcode, city, country, phone, fax, homepage, notes, %s AS field_one, %s AS field_two, %s AS field_three, %s AS field_four FROM %s WHERE users_id = %d", TBL_USERFIELD_1, TBL_USERFIELD_2, TBL_USERFIELD_3, TBL_USERFIELD_4, PROFILE_TABLE, $this->id);
		$result = mysqli_query($this->mysqli,$sql) or die (mysqli_error($this->mysqli));
		if (mysqli_num_rows($result) == 0) {
			$this->the_msg = $this->extra_text(1);
			return false;
		} else {
			$_SESSION['is_rec'] = true;
			while ($obj = mysqli_fetch_object($result)) {
				$this->profile_id = $obj->id;
				$this->language = $obj->language;
				$this->address = $obj->address;
				$this->postcode = $obj->postcode;
				$this->city = $obj->city;
				$this->country = $obj->country;
				$this->phone = $obj->phone;
				$this->fax = $obj->fax;
				$this->homepage = $obj->homepage;
				$this->notes = $obj->notes;
				// remember the constants in the db_config file
				$this->field_one = $obj->field_one; 
				$this->field_two = $obj->field_two;
				$this->field_three = $obj->field_three;
				$this->field_four = $obj->field_four;
			}
			return true;
		}
	}
	
	// some form elements
	function language_menu($label) {
		$lang_select = "<label for=\"language\">".$label."</label>\n";
		$lang_select .= "<select name=\"language\">\n";
		foreach ($this->avail_lang as $val) {
			$lang_select .= "  <option value=\"".$val."\"";
			if (isset($_REQUEST['language'])) {
				$lang_select .= ($val == $_REQUEST['language']) ? " selected" : "";
			} else {
				$lang_select .= ($val == $this->language) ? " selected" : "";
			}
			$lang_select .= ">".$val."</option>\n";
		}
		$lang_select .= "</select><br>\n";
		return $lang_select;
	}
	// install the "countries_table.sql" first
	function create_country_menu($label) {
		$sql_countries = sprintf("SELECT iso, name FROM %s ORDER BY id", COUNTRY_TABLE);
		$res_countries = mysqli_query($this->mysqli,$sql_countries);
		$menu = "<label for=\"country\">".$label."</label>\n";
		$menu .= "<select name=\"country\">\n";
        $menu .= "  <option value=\"\"";
		$menu .= (!isset($_REQUEST['country'])) ? " selected" : "";
		$menu .= ">...\n";
    	while ($obj = mysql_fetch_object($res_countries)) {
			$menu .= "  <option value=\"".$obj->iso."\"";
			if (isset($this->country) && !isset($_REQUEST['country'])) {
				$menu .= ($obj->iso == $this->country) ? " selected" : "";
			} else {
				$menu .= (isset($_REQUEST['country']) && $obj->iso == $_REQUEST['country']) ? " selected" : "";
			}
			$menu .= ">".$obj->name."</option>\n";
    	}
		$menu .= "</select><br>\n";
		mysql_free_result($res_countries);
		return $menu;
	}
	function create_form_field($formelement, $label, $length = 25, $required = false, $disabled = false, $euro_date = false) {
		#$form_field = "<label class=\"control-label col-md-3 col-sm-3 col-xs-12\" for=\"".$formelement."\">".$label."</label>";
		
                $form_field = ($required) ? "<label class=\"control-label col-md-3 col-sm-3 col-xs-12\" for=\"".$formelement."\">".$label."<span class=\"required\">*</span></label>" : "<label class=\"control-label col-md-3 col-sm-3 col-xs-12\" for=\"".$formelement."\">".$label."</label>";
                
                $form_field .= "<div class=\"col-md-6 col-sm-6 col-xs-12\">  <input class=\"form-control col-md-7 col-xs-12\" id=\"".$formelement."\" onfocus=\"seleziona_campo('".$formelement."');\" onblur=\"deseleziona_campo('".$formelement."');\" name=\"".$formelement."\" type=\"text\" size=\"".$length."\" value=\"";
		if (isset($_REQUEST[$formelement])) {
			$form_field .= $_REQUEST[$formelement];
		} elseif (isset($this->$formelement) && !isset($_REQUEST[$formelement])) {
			$form_field .= ($euro_date && $this->$formelement != "") ? strftime("%d/%m/%Y", strtotime($this->$formelement)) : $this->$formelement;
		} else {
			$form_field .= "";
		}
		$form_field .= ($disabled) ? "\" disabled>" : "\">";
		
		return $form_field;		
	}
	function create_text_area($text_field, $label) {
		$textarea = "<label for=\"".$text_field."\">".$label."</label>\n";
		$textarea .= "  <textarea name=\"".$text_field."\">";
		if (isset($_REQUEST[$text_field])) {
			$textarea .= $_REQUEST[$text_field];
		} elseif (isset($this->$text_field)) {
			$textarea .= $this->$text_field;
		} else {
			$textarea .= "";
		}
		$textarea .= "</textarea><br>\n";
		return $textarea;		
	}
        
        
        function update_user_profile($new_password, $new_confirm, $new_lastname, $new_firstname, $new_mail) {
		if ($new_password != "") {
			if ($this->check_new_password($new_password, $new_confirm)) {
				$ins_password = md5($new_password);
				$update_pw = true;
			} else {
				return;
			}
		} else {
			$ins_password = $this->user_pw;
			$update_pw = false;
		}
                /*
		if (trim($new_mail) <> $this->user_email) {
			if  ($this->check_email($new_mail)) {
				$this->user_email = $new_mail;
				if (!$this->check_user("lost")) {
					$update_email = true;
				} else {
					$this->the_msg = $this->messages(31);
					return;
				}
			} else {
				$this->the_msg = $this->messages(16);
				return;
			}
		} else {
			$update_email = false;
			$new_mail = "";
		}
                 * 
                 */
		$upd_sql = sprintf("UPDATE %s SET pw = %s, lastname = %s,  firstname = %s, tmp_mail = %s WHERE id = %d", 
			$this->table_name,
			$this->ins_string($ins_password),
			$this->ins_string($new_lastname),
                        $this->ins_string($new_firstname),
			#$this->ins_string($new_info),
			$this->ins_string($new_mail),
			$this->id);
		$upd_res = mysqli_query($this->mysqli,$upd_sql);
		if ($upd_res) {
			if ($update_pw) {
				$_SESSION['pw'] = $this->user_pw = $ins_password;
				if (isset($_COOKIE[$this->cookie_name])) {
					$this->save_login = "yes";
					$this->login_saver();
				}
			}
			$this->the_msg = $this->messages(30);
			if ($update_email) {
				if ($this->send_mail($new_mail, 33)) {
					$this->the_msg = $this->messages(27);
				} else {
					mysqli_query($this->mysqli,sprintf("UPDATE %s SET tmp_mail = ''", $this->table_name));
					$this->the_msg = $this->messages(14);
				} 
			}
		} else {
			$this->the_msg = $this->messages(15);
		}
	}
}
?>
