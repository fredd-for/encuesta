<?php session_start(); header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php'); 

$dato = array();

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A_1")),'Text'); $dato[522] = preg_replace('/,/', '', $in1);
$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A_2")),'Text'); $dato[523] = preg_replace('/,/', '', $in1);
$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A_3")),'Text'); $dato[524] = preg_replace('/,/', '', $in1);
$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A_4")),'Text'); $dato[525] = preg_replace('/,/', '', $in1);
$dato[526] = $dato[522] + $dato[523] + $dato[524] + $dato[525];


$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("pa_empresa")),'Text');     $dato[527] = preg_replace('/,/', '', $in1);
$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("pa_universidad")),'Text'); $dato[528] = preg_replace('/,/', '', $in1);
$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("pa_nacional")),'Text');    $dato[529] = preg_replace('/,/', '', $in1);
$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("pa_importado")),'Text');   $dato[530] = preg_replace('/,/', '', $in1);

$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

// obtener el uid del token
$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );

if( !empty($regisroUID)  ) {

    $sql = "SELECT * FROM frm3_dcap2_inversion WHERE inve_regi_uid = '".$regisroUID."' ";
    $db->query($sql);

    while ( $aTic = $db->next_record() ) {
        $sql  = "UPDATE frm3_dcap2_inversion SET ";
        $sql .= "inve_valor = '".$dato[$aTic["inve_defi_uid"]]."', ";        
        $sql .= "inve_suv_uid = '".$uid_token."', ";
        $sql .= "inve_updatedate = NOW() ";
        $sql .= "WHERE inve_regi_uid = '".$regisroUID."' AND inve_defi_uid = '".$aTic["inve_defi_uid"]."' ";         
        $db2->query($sql);
    }            
}
?>