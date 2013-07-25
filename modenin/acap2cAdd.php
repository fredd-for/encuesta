<?php session_start(); 
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");

include_once('../verifyLogin.php');

$data = array();
$desc = array();

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A1")),'Text');
$data[105] = preg_replace('/,/', '', $a1);

$a2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A2")),'Text');
$data[106] = preg_replace('/,/', '', $a2);

$a3 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A3")),'Text');
$data[107] = preg_replace('/,/', '', $a3);

$desc[107] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A7")),'Text');

$data[108] = $data[105] + $data[106] + $data[107];

if( empty( $data[107] ) ) {
    $desc[107] = "";
}

/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');
    
if( !empty($regisroUID)  ) {

    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );

    $sql = "SELECT * FROM cap2_presta_sociales WHERE prso_regi_uid = '".$regisroUID."' ";
    $db->query($sql);
    
    //echo $sql;
    while ( $aSueldo = $db->next_record() ) {   
        $sql  = "UPDATE cap2_presta_sociales SET ";        
        $sql .= "prso_valor = '".$data[$aSueldo["prso_defi_uid"]]."', ";
        $sql .= "prso_descripcion = UPPER('".$desc[$aSueldo["prso_defi_uid"]]."'), ";
        $sql .= "prso_suv_uid = '".$uid_token."', ";
        $sql .= "prso_date_update = NOW() ";
        $sql .= "WHERE prso_regi_uid = '".$regisroUID."'  AND prso_defi_uid = '".$aSueldo["prso_defi_uid"]."' ";         
        $db2->query($sql);
    }
}

if( !empty( $btnsubmit ) ) {
    header("Location: acap3.php");
}
?>