<?php session_start(); header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");

include_once('../verifyLogin.php');

$ingreso = array();
$egreso = array();
$desc = array();

//ingresos
$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A1")),'Text');
$ingreso[171] = preg_replace('/,/', '', $in1);

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A2")),'Text');
$ingreso[172] = preg_replace('/,/', '', $in1);

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A3")),'Text');
$ingreso[173] = preg_replace('/,/', '', $in1);

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A4")),'Text');
$ingreso[174] = preg_replace('/,/', '', $in1);

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A5")),'Text');
$ingreso[175] = preg_replace('/,/', '', $in1);

$ingreso[176] = $ingreso[171] + $ingreso[172] + $ingreso[173] + $ingreso[174] + $ingreso[175];


//egresos


$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B1")),'Text');
$egreso[171] = preg_replace('/,/', '', $in1);

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B2")),'Text');
$egreso[172] = preg_replace('/,/', '', $in1);

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B3")),'Text');
$egreso[173] = preg_replace('/,/', '', $in1);

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B4")),'Text');
$egreso[174] = preg_replace('/,/', '', $in1);

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B5")),'Text');
$egreso[175] = preg_replace('/,/', '', $in1);


$egreso[176] = $egreso[171] + $egreso[172] + $egreso[173] + $egreso[174] + $egreso[175];


if( $ingreso[175] > 0 || $egreso[175] > 0  ){
    $desc[175] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("otrosdescrip")),'Text');
}
/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

// obtener el uid del token
$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
if( !empty($regisroUID)  ) {

    $sql = "SELECT * FROM frm2_cap9_ingresosnoopera WHERE inno_regi_uid = '".$regisroUID."' ";
    $db->query($sql);

    while ( $aIngreso = $db->next_record() ) {
        $sql  = "UPDATE frm2_cap9_ingresosnoopera SET ";        
        $sql .= "inno_ingreso = '".$ingreso[$aIngreso["inno_defi_uid"]]."', ";               
        $sql .= "inno_egreso = '".$egreso[$aIngreso["inno_defi_uid"]]."', ";               
        $sql .= "inno_description	 = UPPER('".$desc[$aIngreso["inno_defi_uid"]]."'), ";
        $sql .= "inno_suv_uid = '".$uid_token."', ";
        $sql .= "inno_updatedate = NOW() ";
        $sql .= "WHERE inno_regi_uid = '".$regisroUID."'  AND inno_defi_uid = '".$aIngreso["inno_defi_uid"]."' ";         
        $db2->query($sql);
    }        
}
if( !empty( $btnsubmit ) ) {
    header("Location: acap10.php");
}
?>