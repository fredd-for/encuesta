<?php session_start(); header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");

include_once('../verifyLogin.php');

$dato = array();
$dato2 = array();
$desc = array();

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A1")),'Text'); $dato[418] = preg_replace('/,/', '', $in1);
$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B1")),'Text'); $dato2[418] = preg_replace('/,/', '', $in1);

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A2")),'Text'); $dato[419] = preg_replace('/,/', '', $in1);
$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B2")),'Text'); $dato2[419] = preg_replace('/,/', '', $in1);


$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A3")),'Text'); $dato[420] = preg_replace('/,/', '', $in1);
$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B3")),'Text'); $dato2[420] = preg_replace('/,/', '', $in1);


$desc[420] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A5")),'Text');

$dato[421] = $dato[418] + $dato[419] + $dato[420];
$dato2[421] = $dato2[418] + $dato2[419] + $dato2[420];


/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

// obtener el uid del token
$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
if( !empty($regisroUID)  ) {

    $sql = "SELECT * FROM frm3_cap13_otrosinventarios WHERE otin_regi_uid = '".$regisroUID."' ";
    $db->query($sql);

    while ( $aIngreso = $db->next_record() ) {
        $sql  = "UPDATE frm3_cap13_otrosinventarios SET ";        
        $sql .= "otin_inventarioinicial = '".$dato[$aIngreso["otin_defi_uid"]]."', ";        
        $sql .= "otin_inventariofinal = '".$dato2[$aIngreso["otin_defi_uid"]]."', ";        
        $sql .= "otin_description = UPPER('".utf8_decode($desc[$aIngreso["otin_defi_uid"]])."'), ";        
        $sql .= "otin_suv_uid = '".$uid_token."', ";
        $sql .= "otin_updatedate = NOW() ";
        $sql .= "WHERE otin_regi_uid = '".$regisroUID."'  AND otin_defi_uid = '".$aIngreso["otin_defi_uid"]."' ";         
        $db2->query($sql);
    }        
}
?>