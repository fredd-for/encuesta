<?php session_start(); header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");

include_once('../verifyLogin.php');

$ingreso = array();
$egreso = array();
$desc = array();

//ingresos
$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A1")),'Text');
$ingreso[396] = preg_replace('/,/', '', $in1);

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A2")),'Text');
$ingreso[397] = preg_replace('/,/', '', $in1);

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A3")),'Text');
$ingreso[398] = preg_replace('/,/', '', $in1);

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A4")),'Text');
$ingreso[399] = preg_replace('/,/', '', $in1);

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A5")),'Text');
$ingreso[400] = preg_replace('/,/', '', $in1);

$ingreso[401] = $ingreso[396] + $ingreso[397] + $ingreso[398] + $ingreso[399] + $ingreso[400];


//egresos


$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B1")),'Text');
$egreso[396] = preg_replace('/,/', '', $in1);

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B2")),'Text');
$egreso[397] = preg_replace('/,/', '', $in1);

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B3")),'Text');
$egreso[398] = preg_replace('/,/', '', $in1);

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B4")),'Text');
$egreso[399] = preg_replace('/,/', '', $in1);

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B5")),'Text');
$egreso[400] = preg_replace('/,/', '', $in1);


$egreso[401] = $egreso[396] + $egreso[397] + $egreso[398] + $egreso[399] + $egreso[400];


if( $ingreso[400] > 0 || $egreso[400] > 0  ){
    $desc[400] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("otrosdescrip")),'Text');
}
/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

// obtener el uid del token
$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
if( !empty($regisroUID)  ) {

    $sql = "SELECT * FROM frm3_cap9_ingresosnoopera WHERE inno_regi_uid = '".$regisroUID."' ";
    $db->query($sql);

    while ( $aIngreso = $db->next_record() ) {
        $sql  = "UPDATE frm3_cap9_ingresosnoopera SET ";        
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