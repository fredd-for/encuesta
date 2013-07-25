<?php session_start(); 
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");

include_once('../verifyLogin.php');

$data = array();
$desc = array();

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A1")),'Text');
$data[98] = preg_replace('/,/', '', $a1);

$a2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A2")),'Text');
$data[99] = preg_replace('/,/', '', $a2);

$a3 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A3")),'Text');
$data[100] = preg_replace('/,/', '', $a3);

$a4 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A4")),'Text');
$data[101] = preg_replace('/,/', '', $a4);

$a5 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A5")),'Text');
$data[102] = preg_replace('/,/', '', $a5);

$a6 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A6")),'Text');
$data[103] = preg_replace('/,/', '', $a6);

$desc[103] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A7")),'Text');

$data[104] = $data[98] + $data[99] + $data[100] + $data[101] + $data[102] + $data[103];

if( empty($data[103]) ) {
    $desc[103] = "";
}

/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');
    
if( !empty($regisroUID)  ) {

    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );

    $sql = "SELECT * FROM cap2_otros_pagos WHERE otpa_regi_uid = '".$regisroUID."' ";
    $db->query($sql);
    
    //echo $sql;
    while ( $aSueldo = $db->next_record() ) {   
        $sql  = "UPDATE cap2_otros_pagos SET ";        
        $sql .= "otpa_valor = '".$data[$aSueldo["otpa_defi_uid"]]."', ";
        $sql .= "otpa_descripcion = UPPER('".$desc[$aSueldo["otpa_defi_uid"]]."'), ";
        $sql .= "otpa_suv_uid = '".$uid_token."', ";
        $sql .= "otpa_date_update = NOW() ";
        $sql .= "WHERE otpa_regi_uid = '".$regisroUID."'  AND otpa_defi_uid = '".$aSueldo["otpa_defi_uid"]."' ";         
        $db2->query($sql);
    }

}

if( !empty( $btnsubmit ) ) {
    header("Location: acap2c.php");
}
?>