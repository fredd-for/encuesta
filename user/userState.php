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
$usr_state = OPERATOR::toSql(safeHTML(OPERATOR::getParam("state")),'Text');

if( !empty($usr_uid)  && !empty($usr_state)  ) {
    
               
    if( $usr_state == 'ACTIVE' ) {        
        $sql = " UPDATE sys_users SET usr_status = 'INACTIVE' WHERE usr_uid = '".$usr_uid."'";
        echo '<a onclick="changeState('.$usr_uid.', \'INACTIVE\' );return false;" href="" class="btn2" >inactivo</a>';
    } else {
        $sql = " UPDATE sys_users SET usr_status = 'ACTIVE' WHERE usr_uid = '".$usr_uid."'";
        echo '<a onclick="changeState('.$usr_uid.', \'ACTIVE\' );return false;" href="" class="btn2" >activo</a>';        
    }    
    
    $db->query($sql);   
}

?>