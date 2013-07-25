<?php session_start(); header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");

include_once('../verifyLogin.php');

$dato = array();
$desc = array();

//Ventas a Instituciones Públicas (Valor aproximado)
$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-1")),'Text');
$dato[383] = preg_replace('/,/', '', $in1);

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-21")),'Text');
$dato[368] = preg_replace('/,/', '', $in1);

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-22")),'Text');
$dato[369] = preg_replace('/,/', '', $in1);

$in1 = OPERATOR::toSql(safeHTML(OPERATOR  ::getParam("input-23")),'Text');
$dato[370] = preg_replace('/,/', '', $in1);

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-24")),'Text');
$dato[371] = preg_replace('/,/', '', $in1);


//Ventas a Empresas Privadas (Valor aproximado)

$in2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-2")),'Text');
$dato[384] = preg_replace('/,/', '', $in2);

$in2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-25")),'Text');
$dato[373] = preg_replace('/,/', '', $in2);

$in2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-26")),'Text');
$dato[374] = preg_replace('/,/', '', $in2);

$in2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-27")),'Text');
$dato[375] = preg_replace('/,/', '', $in2);

$in2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-28")),'Text');
$dato[376] = preg_replace('/,/', '', $in2);

$in2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-29")),'Text');
$dato[377] = preg_replace('/,/', '', $in2);

$in2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-30")),'Text');
$dato[378] = preg_replace('/,/', '', $in2);

$in2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-31")),'Text');
$dato[379] = preg_replace('/,/', '', $in2);

// Ventas a Personas Particulares (Valor aproximado)

$in3 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-3")),'Text');
$dato[380] = preg_replace('/,/', '', $in3);

$in3 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-32")),'Text');
$dato[381] = preg_replace('/,/', '', $in3);

$in3 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-33")),'Text');
$dato[382] = preg_replace('/,/', '', $in3);


// Total Ventas al Mercado Nacional (Valor aproximado) (a + b + c)
$dato[367] = $dato[383] + $dato[384] + $dato[380];

// Total Ventas al Mercado Externo (Valor aproximado)
$in3 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("totexterno")),'Text');
$dato[372] = preg_replace('/,/', '', $in3);

// TOTAL VENTAS
$dato[366] = $dato[367] + $dato[372];


/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

// obtener el uid del token
$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
if( !empty($regisroUID)  ) {

    $sql = "SELECT * FROM frm3_cap6_ventaproductos WHERE vepr_regi_uid = '".$regisroUID."' ";
    $db->query($sql);

    while ( $aVenta = $db->next_record() ) {
        $sql  = "UPDATE frm3_cap6_ventaproductos SET ";        
        $sql .= "vepr_valor = '".$dato[$aVenta["vepr_defi_uid"]]."', ";               
        $sql .= "vepr_suv_uid = '".$uid_token."', ";
        $sql .= "vepr_updatedate = NOW() ";
        $sql .= "WHERE vepr_regi_uid = '".$regisroUID."'  AND vepr_defi_uid = '".$aVenta["vepr_defi_uid"]."' ";         
        $db2->query($sql);
    }        
}

?>