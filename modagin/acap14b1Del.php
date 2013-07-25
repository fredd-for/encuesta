<?php session_start(); header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php');

$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$uid = OPERATOR::toSql(safeHTML(OPERATOR::getParam("uid")),'Text');

// productos terminados
$mapr_tima_uid = 1;

$sql = " UPDATE frm3_cap14b_materiasprimas SET mapr_delete = 1 "
      ." WHERE mapr_position = '".$uid."' AND mapr_regi_uid = '".$regisroUID."' AND mapr_tima_uid = ".$mapr_tima_uid." ";
$db->query( $sql );

$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );


$sql = "SELECT * FROM frm3_cap14b_materiasprimas WHERE mapr_position = '".$uid."' AND mapr_tima_uid = '".$mapr_tima_uid."' AND mapr_regi_uid = '".$regisroUID."' ";
$db->query( $sql );
$aDat = $db->next_record();

// total productos terminados
$uidtotalmateria = 4;
$sql = "SELECT * FROM frm3_cap14b_materiasprimas WHERE mapr_position = '0' AND mapr_tima_uid = '".$uidtotalmateria."' AND mapr_regi_uid = '".$regisroUID."' ";
$db->query( $sql );

if( $db->numrows() > 0 ) {
    $aTot = $db->next_record();
    $c = $aTot["mapr_invini_cantidad"] - $aDat["mapr_invini_cantidad"];
    $d = $aTot["mapr_invini_valor"] - $aDat["mapr_invini_valor"];
    $e = $aTot["mapr_compra_cantidad"] - $aDat["mapr_compra_cantidad"];
    $f = $aTot["mapr_compra_valor"] - $aDat["mapr_compra_valor"];
    $g = $aTot["mapr_util_cantidad"] - $aDat["mapr_util_cantidad"];
    $h = $aTot["mapr_util_valor"] - $aDat["mapr_util_valor"];
        
    $ci = $c + $e - $g;
    $j = $d + $f - $h;                    
        
    $sql  = "UPDATE frm3_cap14b_materiasprimas SET ";
    $sql .= "mapr_materiadesc      = '', ";     
    $sql .= "mapr_unidadmedida     = '', "; 
    $sql .= "mapr_invini_cantidad  = '".$c."', "; 
    $sql .= "mapr_invini_valor     = '".$d."', "; 
    $sql .= "mapr_compra_cantidad  = '".$e."', ";      
    $sql .= "mapr_compra_valor	    = '".$f."', ";                
    $sql .= "mapr_util_cantidad    = '".$g."', ";
    $sql .= "mapr_util_valor       = '".$h."', ";
    $sql .= "mapr_invfin_cantidad  = '".$ci."', ";      
    $sql .= "mapr_invfin_valor     = '".$j."', ";    
    $sql .= "mapr_suv_uid = '".$uid_token."', ";
    $sql .= "mapr_updatedate = NOW() ";
    $sql .= " WHERE mapr_regi_uid = '".$regisroUID."' AND  mapr_position = '0' AND mapr_tima_uid = '".$uidtotalmateria."' "; 
    $db3->query($sql);
}
?>