<?php session_start(); header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");

include_once('../verifyLogin.php');

$dato = array();
$dato2 = array();
$desc = array();

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A1")),'Text'); $dato[193] = preg_replace('/,/', '', $in1);
$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B1")),'Text'); $dato2[193] = preg_replace('/,/', '', $in1);

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A2")),'Text'); $dato[194] = preg_replace('/,/', '', $in1);
$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B2")),'Text'); $dato2[194] = preg_replace('/,/', '', $in1);


$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A3")),'Text'); $dato[195] = preg_replace('/,/', '', $in1);
$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B3")),'Text'); $dato2[195] = preg_replace('/,/', '', $in1);


$desc[195] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A5")),'Text');

$dato[196] = $dato[193] + $dato[194] + $dato[195];
$dato2[196] = $dato2[193] + $dato2[194] + $dato2[195];


/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

// obtener el uid del token
$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
if( !empty($regisroUID)  ) {

    $sql = "SELECT * FROM frm2_cap13_otrosinventarios WHERE otin_regi_uid = '".$regisroUID."' ";
    $db->query($sql);

    while ( $aIngreso = $db->next_record() ) {
        $sql  = "UPDATE frm2_cap13_otrosinventarios SET ";        
        $sql .= "otin_inventarioinicial = '".$dato[$aIngreso["otin_defi_uid"]]."', ";        
        $sql .= "otin_inventariofinal = '".$dato2[$aIngreso["otin_defi_uid"]]."', ";        
        $sql .= "otin_description = UPPER('".$desc[$aIngreso["otin_defi_uid"]]."'), ";        
        $sql .= "otin_suv_uid = '".$uid_token."', ";
        $sql .= "otin_updatedate = NOW() ";
        $sql .= "WHERE otin_regi_uid = '".$regisroUID."'  AND otin_defi_uid = '".$aIngreso["otin_defi_uid"]."' ";         
        $db2->query($sql);
    }        
}
if( !empty( $btnsubmit ) ) {
    header("Location: acap14a.php");
}
?>