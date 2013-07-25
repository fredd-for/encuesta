<?php 
session_start();
if( $_SESSION["authenticated"] && ( $_SESSION["usr_rol"] == 1 || $_SESSION["usr_rol"] == 2 ) ) {
    //echo
} else {
   header("Location: ../logout.php");
   
}
?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");

$usr_login = OPERATOR::toSql(safeHTML(OPERATOR::getParam("nu")),'Text');
$user_pati_uid = OPERATOR::toSql(safeHTML(OPERATOR::getParam("pt")),'Number');
?>
<?php
$noexist = -1;
if( !empty($usr_login) ) {
    
    $sql = "SELECT * FROM sys_users WHERE usr_login = '".$usr_login."' AND user_pati_uid <> '".$user_pati_uid."' ";    
    $db->query($sql);        
    if( $db->numrows()>0 ) {
        $noexist = 1;
    }        
} else {
    $noexist = 2;
}
echo $noexist;
?>