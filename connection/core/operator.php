<?php

if (isset($_GET['PHPSESSID'])) {
    @session_start();
    $_GET['PHPSESSID'] = false;
    @session_destroy();
}
unset($_GET['PHPSESSID']);
@session_start();

include_once ("path.php");
require_once("safeHtml.php");
$app_path = ".";


$lang_default = $langDefault;

if (!isset($_SESSION[SITE]["LANG"])) {
    $_SESSION[SITE]["LANG"] = $langDefault;
    
}
$lang = $_SESSION[SITE]["LANG"];
$langfront = $_SESSION[SITE]["LANG"];

$ar = array();
$nivel = 0;


class OPERATOR {
 static function getParam($param_name, $safe = true) {
        global $HTTP_POST_VARS;
        global $HTTP_GET_VARS;
        global $_POST;
        global $_GET;
        $param_value = "";
        if (isset($HTTP_POST_VARS[$param_name]))
            $param_value = $HTTP_POST_VARS[$param_name];
        else if (isset($HTTP_GET_VARS[$param_name]))
            $param_value = $HTTP_GET_VARS[$param_name];
        else if (isset($_POST[$param_name]))
            $param_value = $_POST[$param_name];
        else if (isset($_GET[$param_name]))
            $param_value = $_GET[$param_name];
        if ($safe) {
            if (is_array($safe))
                return safeHtml($param_value);
            else
                return $param_value;
        }
        else
            return $param_value;
    }
static function getCookie($param_name) {
        global $HTTP_COOKIE_VARS;
        global $_COOKIE;
        global ${$param_name};
        $param_value = "";
        if (isset($_COOKIE[$param_name]))
            $param_value = ${$param_name};
        if (isset($HTTP_COOKIE_VARS[$param_name]))
            $param_value = ${$param_name};
        return $param_value;
    }
  
  
    static function toSql($value, $type) {
        switch ($type) {
            case "Number":
                $valor = filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_THOUSAND);
                break;

            default:
                $valor = filter_var($value, FILTER_SANITIZE_STRING);
                break;
        }
        return ($valor);
    }

    static function getDbValue($sql) {
        global $basedatos, $host, $user, $pass;
        $db_look = new DBmysql;
        $db_look->query($sql) or die();
        if ($record = $db_look->next_record())
            return $record[0];
        else
            return "";
    }

    static function control($con_uid, $lab_uid, $lab_category = 'label') {
        $access = OPERATOR::getDBValue("select mof_delete from sys_modules_fields where mof_lab_uid='" . $lab_uid . "' and mof_lab_category='" . $lab_category . "' and mof_mod_uid='" . $con_uid . "' and mof_rol_uid='" . $_SESSION[SITE]["usr_rol"] . "'");
        return (!$access);
    }
static function getDescTitles($formulario, $modulo, $capitulo, $campo ) {
		$title = OPERATOR::getDBValue("SELECT titl_descripcion FROM adm_titles WHERE titl_formulario ='" . $formulario . "' AND titl_modulo='" . $modulo. "' AND titl_capitulo='" . $capitulo . "' AND titl_campo='".$campo."' " );
        return ($title);
	}

}

?>