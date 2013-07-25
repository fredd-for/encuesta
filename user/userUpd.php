<?php 
session_start();
if( $_SESSION["authenticated"] && $_SESSION["usr_rol"] == 1 ) {
    //echo
} else {
   header("Location: ../logout.php");
   
}
?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");

$usr_login = OPERATOR::toSql(safeHTML(OPERATOR::getParam("usr_login")),'Text');
$usr_pass = OPERATOR::toSql(safeHTML(OPERATOR::getParam("usr_pass")),'Text');
$usr_firstname = OPERATOR::toSql(safeHTML(OPERATOR::getParam("usr_firstname")),'Text');
$usr_lastname = OPERATOR::toSql(safeHTML(OPERATOR::getParam("usr_lastname")),'Text');
$usr_email = OPERATOR::toSql(safeHTML(OPERATOR::getParam("usr_email")),'Text');
$usr_roll = OPERATOR::toSql(safeHTML(OPERATOR::getParam("usr_rol")),'Number');
$usr_status = OPERATOR::toSql(safeHTML(OPERATOR::getParam("usr_status")),'Text');

$usr_uid = OPERATOR::toSql(safeHTML(OPERATOR::getParam("usr_uid")),'Number');
?>
<?php
if( !empty($usr_login) && !empty($usr_firstname) && !empty($usr_uid)  ) {
    
    $sql = " UPDATE sys_users SET usr_rol_uid = '".$usr_roll."',	usr_login = '".$usr_login."', "
          ."	usr_firstname = '".$usr_firstname."',	usr_lastname = '".$usr_lastname."',	usr_email='".$usr_email."',	usr_status='".$usr_status."' "
          ." WHERE usr_uid = '".$usr_uid."'";
    $db->query($sql);
    
    if( !empty($usr_pass) ) {
        $usr_pass = md5($usr_pass);
        $sql = " UPDATE sys_users SET 	usr_pass = '".$usr_pass."' WHERE usr_uid = '".$usr_uid."'";
        $db->query($sql);
    }    
    //echo $sql;
}

header("Location: userList.php");
?>