<?php session_start(); header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php'); 

$dat1 = array();
$dat2 = array();
$dat3 = array();
$dat4 = array();
$dat5 = array();

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A_1")),'Text'); $dat1[519] = preg_replace('/,/', '', $in1);
$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B_1")),'Text'); $dat2[519] = preg_replace('/,/', '', $in1);


$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A_2")),'Text'); $dat1[520] = preg_replace('/,/', '', $in1);
$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B_2")),'Text'); $dat2[520] = preg_replace('/,/', '', $in1);
$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("C_2")),'Text'); $dat3[520] = preg_replace('/,/', '', $in1);
$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("D_2")),'Text'); $dat4[520] = preg_replace('/,/', '', $in1);
$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("E_2")),'Text'); $dat5[520] = preg_replace('/,/', '', $in1);

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A_3")),'Text'); $dat1[521] = preg_replace('/,/', '', $in1);
$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B_3")),'Text'); $dat2[521] = preg_replace('/,/', '', $in1);
$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("C_3")),'Text'); $dat3[521] = preg_replace('/,/', '', $in1);
$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("D_3")),'Text'); $dat4[521] = preg_replace('/,/', '', $in1);
$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("E_3")),'Text'); $dat5[521] = preg_replace('/,/', '', $in1);


$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

// obtener el uid del token
$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );

if( !empty($regisroUID)  ) {

    $sql = "SELECT * FROM frm3_dcap1e_tipoformacion WHERE tifo_regi_uid = '".$regisroUID."' ";
    $db->query($sql);

    while ( $aTic = $db->next_record() ) {
        $sql  = "UPDATE frm3_dcap1e_tipoformacion SET ";
        $sql .= "tifo_obrero = '".$dat1[$aTic["tifo_defi_uid"]]."', ";        
        $sql .= "tifo_supervisor = '".$dat2[$aTic["tifo_defi_uid"]]."', ";
        $sql .= "tifo_administrativo = '".$dat3[$aTic["tifo_defi_uid"]]."', ";
        $sql .= "tifo_gerente = '".$dat4[$aTic["tifo_defi_uid"]]."', ";
        $sql .= "tifo_proveedor = '".$dat5[$aTic["tifo_defi_uid"]]."', ";
        $sql .= "tifo_suv_uid = '".$uid_token."', ";
        $sql .= "tifo_updatedate = NOW() ";
        $sql .= "WHERE tifo_regi_uid = '".$regisroUID."' AND tifo_defi_uid = '".$aTic["tifo_defi_uid"]."' ";         
        $db2->query($sql);
    }            
}
if( !empty( $btnsubmit ) ) {
    header("Location: dcap2.php");    
}
?>