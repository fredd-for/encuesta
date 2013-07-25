<?php session_start(); ?>
<?php header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
?>
<?php include_once('../verifyLogin.php'); ?>
<?php 

$dat = array();
$v1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-1")),'Text'); // A
$dat[43] = preg_replace('/,/', '', $v1); // Ventas a Instituciones Públicas

$v2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-2")),'Text'); // B
$dat[44] = preg_replace('/,/', '', $v2); // Ventas a Empresas Privadas

/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];


$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

// obtener el uid del token
$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
if( !empty($regisroUID)  ) {      

    $sql = "SELECT * FROM frm1_cap8_resultadosgestion WHERE rege_regi_uid = '".$regisroUID."' ";
    $db->query($sql);

    //echo $sql;
    while ( $aGestion = $db->next_record() ) {            
        $sql  = "UPDATE frm1_cap8_resultadosgestion SET ";        
        $sql .= "rege_valor = '".$dat[$aGestion["rege_defi_uid"]]."', ";
        $sql .= "rege_suv_uid = '".$uid_token."', ";
        $sql .= "rege_updatedate = NOW() ";
        $sql .= "WHERE rege_regi_uid = '".$regisroUID."' AND rege_defi_uid = '".$aGestion["rege_defi_uid"]."' ";  
        $db2->query($sql);
        //echo $sql."<br />";
    }           
}
?>