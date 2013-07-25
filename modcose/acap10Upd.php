<?php session_start(); ?>
<?php header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
?>
<?php include_once('../verifyLogin.php'); ?>
<?php 

$dat = array();
$v1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-11")),'Text');
$dat[55] = preg_replace('/,/', '', $v1);  

$v2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-12")),'Text');
$dat[56] = preg_replace('/,/', '', $v2); 

$v3 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-13")),'Text');
$dat[57] = preg_replace('/,/', '', $v3);

$v5 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-15")),'Text');
$dat[58] = preg_replace('/,/', '', $v5);



$dat[54] = $dat[55] + $dat[56] + $dat[57];

/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];


$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

// obtener el uid del token
$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
if( !empty($regisroUID)  ) {   

    $sql = "SELECT * FROM frm1_cap10_capitalpatrimonio WHERE capa_regi_uid = '".$regisroUID."' ";
    $db->query($sql);

    //echo $sql;
    while ( $aPatrimonio = $db->next_record() ) {         
        $sql  = "UPDATE frm1_cap10_capitalpatrimonio SET ";
        $sql .= "capa_valor = '".$dat[$aPatrimonio["capa_defi_uid"]]."', ";
        $sql .= "capa_suv_uid	 = '".$uid_token."', ";
        $sql .= "capa_updatedate = NOW() ";
        $sql .= "WHERE capa_regi_uid = '".$regisroUID."' AND capa_defi_uid	 = '".$aPatrimonio["capa_defi_uid"]."' ";  
        $db2->query($sql);
        //echo $sql."<br />";
    }      
    //echo $sql."<br />";
}
?>
