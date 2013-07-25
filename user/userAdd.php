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

if( !empty($usr_login) && !empty($usr_pass) && !empty($usr_firstname)  ) {
    $usr_pass = md5($usr_pass);
    $sql = " INSERT INTO sys_users( usr_rol_uid,	usr_login,	usr_pass,	usr_firstname,	usr_lastname,	usr_email,	usr_status,	usr_delete ) "
          ." VALUES( '".$usr_roll."', '".$usr_login."', '".$usr_pass."', '".$usr_firstname."', '".$usr_lastname."', '".$usr_email."', '".$usr_status."', 0 )";
    $db->query($sql);
}

header("Location: userList.php");
?>