<?php session_start(); header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php');

$dat = array();
$v1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-11")),'Text');
$dat[45] = preg_replace('/,/', '', $v1);  

$v2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-12")),'Text');
$dat[46] = preg_replace('/,/', '', $v2); 

$v3 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-13")),'Text');
$dat[47] = preg_replace('/,/', '', $v3);

$v4 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-14")),'Text');
$dat[48] = preg_replace('/,/', '', $v4);

$v5 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-15")),'Text');
$dat[49] = preg_replace('/,/', '', $v5);

$v6 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-16")),'Text');
$dat[50] = preg_replace('/,/', '', $v6);

$v7 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-17")),'Text');
$dat[51] = preg_replace('/,/', '', $v7);

$otrosactivos = OPERATOR::toSql(safeHTML(OPERATOR::getParam("inputlit")),'Text');

$dat[52] = 0;
if( !empty($otrosactivos) ) {
    $v8 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-18")),'Text');
    $dat[52] = preg_replace('/,/', '', $v8);
}

$dat[53] = $dat[45] + $dat[46] + $dat[47] + $dat[48] + $dat[49] + $dat[50] + $dat[51] + $dat[52];

/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];


$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

// obtener el uid del token
$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
if( !empty($regisroUID)  ) {      

    $sql = "SELECT * FROM frm1_cap9_formacionactivosfijos WHERE foaf_regi_uid = '".$regisroUID."' ";
    $db->query($sql);

    //echo $sql;
    while ( $aActivos = $db->next_record() ) {         
        $sql  = "UPDATE frm1_cap9_formacionactivosfijos SET ";
        $sql .= "foaf_valor = '".$dat[$aActivos["foaf_defi_uid"]]."', ";
        $sql .= "foaf_suv_uid = '".$uid_token."', ";
        $sql .= "foaf_updatedate = NOW() ";
        $sql .= "WHERE foaf_regi_uid = '".$regisroUID."' AND foaf_defi_uid = '".$aActivos["foaf_defi_uid"]."' ";  
        $db2->query($sql);
        //echo $sql."<br />";
    }
    
    $sql  = "UPDATE frm1_cap9_formacionactivosfijos SET ";
    $sql .= "foaf_description = UPPER('".$otrosactivos."') ";
    $sql .= "WHERE foaf_regi_uid = '".$regisroUID."' AND foaf_defi_uid = '52' ";  
    $db2->query($sql);
}
  
if( !empty( $btnsubmit ) ) {
    header("Location: acap10.php");
}
?>