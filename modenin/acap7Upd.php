<?php session_start(); header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");

include_once('../verifyLogin.php');

$dato = array();

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A1")),'Text');
$dato[160] = preg_replace('/,/', '', $in1);

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A2")),'Text');
$dato[161] = preg_replace('/,/', '', $in1);

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A3")),'Text');
$dato[162] = preg_replace('/,/', '', $in1);

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A4")),'Text');
$dato[163] = preg_replace('/,/', '', $in1);


$dato[164] = $dato[161] + $dato[163] - $dato[162];
$dato[165] = $dato[160] - $dato[164];

/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

// obtener el uid del token
$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
if( !empty($regisroUID)  ) {

    $sql = "SELECT * FROM frm2_cap7_mercaderias WHERE merc_regi_uid = '".$regisroUID."' ";
    $db->query($sql);

    while ( $aVenta = $db->next_record() ) {
        $sql  = "UPDATE frm2_cap7_mercaderias SET ";        
        $sql .= "merc_valor = '".$dato[$aVenta["merc_defi_uid"]]."', ";               
        $sql .= "merc_suv_uid = '".$uid_token."', ";
        $sql .= "merc_updatedate = NOW() ";
        $sql .= "WHERE merc_regi_uid = '".$regisroUID."'  AND merc_defi_uid = '".$aVenta["merc_defi_uid"]."' ";         
        $db2->query($sql);
    }        
}
?>