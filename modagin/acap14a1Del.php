<?php session_start(); header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php');

$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$uid = OPERATOR::toSql(safeHTML(OPERATOR::getParam("uid")),'Text');

// materia prima
$mapr_tima_uid = 1;

$sql = " UPDATE frm3_cap14a_materiasprimas SET mapr_delete = 1 "
      ." WHERE mapr_position = '".$uid."' AND mapr_regi_uid = '".$regisroUID."' AND mapr_tima_uid = ".$mapr_tima_uid." ";
$db->query( $sql );

$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );


$sql = "SELECT * FROM frm3_cap14a_materiasprimas WHERE mapr_position = '".$uid."' AND mapr_tima_uid = '".$mapr_tima_uid."' AND mapr_regi_uid = '".$regisroUID."' ";
$db->query( $sql );
$aDat = $db->next_record();

// total materia prima
$uidtotalmateria = 4;
$sql = "SELECT * FROM frm3_cap14a_materiasprimas WHERE mapr_position = '0' AND mapr_tima_uid = '".$uidtotalmateria."' AND mapr_regi_uid = '".$regisroUID."' ";
$db->query( $sql );

if( $db->numrows() > 0 ) {  
    $aTot = $db->next_record();
    $c = $aTot["mapr_invini_cantidad"] - $aDat["mapr_invini_cantidad"];
    $d = $aTot["mapr_invini_valor"] - $aDat["mapr_invini_valor"];
    $e = $aTot["mapr_compra_productores"] - $aDat["mapr_compra_productores"];
    $f = $aTot["mapr_compra_intermediarios"] - $aDat["mapr_compra_intermediarios"];
    $g = $aTot["mapr_compra_total"] - $aDat["mapr_compra_total"];
    $h = $aTot["mapr_compra_valor"] - $aDat["mapr_compra_valor"];
    $ci = $aTot["mapr_util_cantidad"] - $aDat["mapr_util_cantidad"];
    $j = $aTot["mapr_util_valor"] - $aDat["mapr_util_valor"];

    $k = $c + $e + $f - $ci;
    $l = $d + $h - $j;
    
    $sql  = "UPDATE frm3_cap14a_materiasprimas SET ";
    $sql .= "mapr_materiadesc = '', ";         
    $sql .= "mapr_unidadmedida = '', "; 
    $sql .= "mapr_invini_cantidad	 = '".$c."', "; 
    $sql .= "mapr_invini_valor       = '".$d."', ";                 
    $sql .= "mapr_compra_productores	 = '".$e."', ";      
    $sql .= "mapr_compra_intermediarios	 = '".$f."', ";
    $sql .= "mapr_compra_total	 = '".$g."', ";
    $sql .= "mapr_compra_valor	 = '".$h."', ";
    $sql .= "mapr_util_cantidad	 = '".$ci."', ";
    $sql .= "mapr_util_valor	 = '".$j."', ";
    $sql .= "mapr_invfin_cantidad = '".$k."', ";
    $sql .= "mapr_invfin_valor	 = '".$l."', ";                       
    $sql .= "mapr_suv_uid = '".$uid_token."', ";
    $sql .= "mapr_updatedate = NOW() ";
    $sql .= " WHERE mapr_regi_uid = '".$regisroUID."' AND  mapr_position = '0' AND mapr_tima_uid = '".$uidtotalmateria."' "; 
    $db3->query($sql);
}
?>