<?php     
    @session_start();
    //include_once("database/connection.php");  
    //include_once("core/simple99.php");
    //$sql = "update sys_users_verify set suv_status=1 where suv_cli_uid='" . $_SESSION["usr_uid"] . "' and suv_token='".SIMPLE99::getParam("token")."'";
    //$db->query($sql);
    session_unset();
    session_destroy(); 
    header('Location: index.php');
?>
