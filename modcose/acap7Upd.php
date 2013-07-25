<?php session_start(); ?>
<?php header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
?>
<?php include_once('../verifyLogin.php'); ?>
<?php 

$dat = array();
$ventanacional = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-1")),'Text'); // A
$dat[30] = preg_replace('/,/', '', $ventanacional); // Ventas a Instituciones Públicas
$dat[31] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-21")),'Number'); // a
$dat[32] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-22")),'Number'); // b
$dat[33] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-23")),'Number'); // c
$dat[34] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-24")),'Number'); // d

$ventaextrajera = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-2")),'Text'); // B
$dat[35] = preg_replace('/,/', '', $ventaextrajera); // Ventas a Empresas Privadas
$dat[36] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-25")),'Number');
$dat[37] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-26")),'Number');
$dat[38] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-27")),'Number');
$dat[39] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-28")),'Number');

$ventapersonaparticular = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-3")),'Text'); // C
$dat[40] = preg_replace('/,/', '', $ventapersonaparticular); // Ventas a Empresas Privadas

$totalventaexterno = OPERATOR::toSql(safeHTML(OPERATOR::getParam("total3")),'Text');
$dat[41] = preg_replace('/,/', '', $totalventaexterno); // Total Ventas al Mercado Externo 


$dat[42] = ( $dat[30] + $dat[35] + $dat[40] ) + $dat[41] ; //TOTAL VENTAS


$dat[29] = ( $dat[30] + $dat[35] + $dat[40] ) ; //Total Ventas al Mercado Nacional

/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];


$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

// obtener el uid del token
$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
if( !empty($regisroUID)  ) {      

    $sql = "SELECT * FROM frm1_cap7_ventaservicios WHERE vese_regi_uid = '".$regisroUID."' ";
    $db->query($sql);

    //echo $sql;
    while ( $aMercaderia = $db->next_record() ) {            
        $sql  = "UPDATE frm1_cap7_ventaservicios SET ";        
        $sql .= "vese_valor = '".$dat[$aMercaderia["vese_defi_uid"]]."', ";
        $sql .= "vese_suv_uid = '".$uid_token."', ";
        $sql .= "vese_updatedate = NOW() ";
        $sql .= "WHERE vese_regi_uid = '".$regisroUID."' AND vese_defi_uid = '".$aMercaderia["vese_defi_uid"]."' ";  
        $db2->query($sql);

        //echo $sql."<br />";
    }    
    }
    ?>