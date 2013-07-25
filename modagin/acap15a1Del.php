<?php session_start(); header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php');

$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$uid = OPERATOR::toSql(safeHTML(OPERATOR::getParam("uid")),'Text');

// productos terminados
$prod_tima_uid = 7;

$sql = " UPDATE frm3_cap15_productosterminados SET prod_delete = 1 "
      ." WHERE prod_position = '".$uid."' AND prod_regi_uid = '".$regisroUID."' AND prod_tima_uid = ".$prod_tima_uid." ";
$db->query( $sql );

$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );


$sql = "SELECT * FROM frm3_cap15_productosterminados WHERE prod_position = '".$uid."' AND prod_tima_uid = '".$prod_tima_uid."' AND prod_regi_uid = '".$regisroUID."' ";
$db->query( $sql );
$aDat = $db->next_record();

// total productos terminados
$uidtotalmateria = 10;
$sql = "SELECT * FROM frm3_cap15_productosterminados WHERE prod_position = '0' AND prod_tima_uid = '".$uidtotalmateria."' AND prod_regi_uid = '".$regisroUID."' ";
$db->query( $sql );

if( $db->numrows() > 0 ) {  
    $aTot = $db->next_record();
    $d = $aTot["prod_invini_cantidad"] - $aDat["prod_invini_cantidad"];
    $e = $aTot["prod_invini_valor"] - $aDat["prod_invini_valor"];
    $f = $aTot["prod_ventas_cantidad"] - $aDat["prod_ventas_cantidad"];
    $g = $aTot["prod_ventas_valor"] - $aDat["prod_ventas_valor"];
    $h = $aTot["prod_me_cantidad"] - $aDat["prod_me_cantidad"];
    $ci = $aTot["prod_me_valor"] - $aDat["prod_me_valor"];
    $j = $aTot["prod_produccion_cantidad"] - $aDat["prod_produccion_cantidad"];
    $k = $aTot["prod_produccion_valor"] - $aDat["prod_produccion_valor"];
    $l = $d - $f - $h + $j; //cantidad
    $m = $e - $g - $ci + $k;
    
    $sql  = "UPDATE frm3_cap15_productosterminados SET ";
    $sql .= "prod_descproducto = '', ";     
    $sql .= "prod_unidadmedida = '', "; 
    $sql .= "prod_invini_cantidad = '".$d."', "; 
    $sql .= "prod_invini_valor    = '".$e."', "; 
    $sql .= "prod_ventas_cantidad = '".$f."', ";      
    $sql .= "prod_ventas_valor	  = '".$g."', ";                
    $sql .= "prod_me_cantidad  = '".$h."', ";
    $sql .= "prod_me_valor     = '".$ci."', ";
    $sql .= "prod_produccion_cantidad  = '".$j."', ";      
    $sql .= "prod_produccion_valor     = '".$k."', ";
    $sql .= "prod_invfin_cantidad      = '".$l."', ";
    $sql .= "prod_invfin_valor	       = '".$m."', ";
    $sql .= "prod_suv_uid = '".$uid_token."', ";
    $sql .= "prod_updatedate = NOW() ";
    $sql .= " WHERE prod_regi_uid = '".$regisroUID."' AND  prod_position = '0' AND prod_tima_uid = '".$uidtotalmateria."' "; 
    $db3->query($sql);
}
?>