<?php 
$clieUid = OPERATOR::getDbValue("select suv_cli_uid from sys_users_verify left join sys_users on usr_uid= suv_cli_uid  where suv_status=0 and suv_ip='".$_SERVER['REMOTE_ADDR']."' and suv_token='".$_SESSION[SITE]["TOKEN_FRONT"]."' and usr_delete=0 and usr_status='ACTIVE' ");


if( $_SESSION[SITE]["authenticated"]===true && $clieUid === $_SESSION[SITE]["usr_uid"] && $_SESSION[SITE]["val_regi_swmodifica_uid"] == 1 ) {   

	   $newToken = sha1(PREFIX.uniqid( rand(), TRUE ));
       $sqlDat ="update sys_users_verify set suv_token = '".$newToken."' where suv_token='".$_SESSION[SITE]["TOKEN_FRONT"]."' and suv_ip='".$_SERVER['REMOTE_ADDR']."'";
       //echo $_SERVER['REMOTE_ADDR'];
       $db->query($sqlDat);
	   $_SESSION[SITE]["TOKEN_FRONT"] = $newToken;        
	     
} else { 
    header("Location: logout.php");
}
?>