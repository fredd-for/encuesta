<?php session_start(); ?>
<?php header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
?>
<?php include_once('../verifyLogin.php'); ?>
<?php 

// valor de la tarifa
$input1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("otros_gastos")),'Text'); //fila 1
$input1 = preg_replace('/,/', '', $input1);

/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];


$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

// obtener el uid del token
$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    if( !empty($regisroUID)  ) {
    	    if (OPERATOR::toSql(safeHTML(OPERATOR::getParam("pack")),'Number')==1) {
        $defi_uid = 17;        
        $sql  = "UPDATE frm1_cap5_otrosgastosoperativos SET ";        
        $sql .= "otga_valor	 = '".$input1."', ";
        $sql .= "otga_updatedate = NOW() ";
        $sql .= "WHERE otga_regi_uid	 = '".$regisroUID."' AND otga_defi_uid = '".$defi_uid."' ";         
        $db->query($sql);  
        }              
    }
  

?>
