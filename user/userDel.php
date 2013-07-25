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

$usr_uid = OPERATOR::toSql(safeHTML(OPERATOR::getParam("uid")),'Number');


if( !empty($usr_uid)  ) {
    
    $sql = " UPDATE sys_users SET usr_delete = '1' "
          ." WHERE usr_uid = '".$usr_uid."'";
    $db->query($sql);    
    
    echo 1;
}

?>