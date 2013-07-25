<?php session_start(); header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
 
if( $_SESSION[SITE]["authenticated"] ) {    
    $_SESSION["menuactiveparent"]  = 'user';    
} else {
    header("Location: logout.php");
}

$dat = array();
$compranacional = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-1")),'Text');
$dat[18] = preg_replace('/,/', '', $compranacional);
$dat[19] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-21")),'Number');
$dat[20] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-22")),'Number');
$dat[21] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-23")),'Number');
$dat[22] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-24")),'Number');



$compraextrajera = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-2")),'Text');
$dat[23] = preg_replace('/,/', '', $compraextrajera);
$dat[24] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-25")),'Number');
$dat[25] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-26")),'Number');
$dat[26] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-27")),'Number');
$dat[27] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-28")),'Number');

$dat[28] = $dat[18] + $dat[23];

/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];


$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

// obtener el uid del token
$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    if( !empty($regisroUID)  ) {
        $defi_uid = 1;       
        
        $sql = "SELECT * FROM frm1_cap6_comprareventa WHERE core_regi_uid = '".$regisroUID."' ORDER BY core_defi_uid ";
        $db->query($sql);
        
        //echo $sql;
        while ( $aMercaderia = $db->next_record() ) {            
            $sql  = "UPDATE frm1_cap6_comprareventa SET ";        
            $sql .= "core_valor = '".$dat[$aMercaderia["core_defi_uid"]]."', ";
            $sql .= "core_suv_uid = '".$uid_token."', ";
            $sql .= "core_updatedate = NOW() ";
            $sql .= "WHERE core_regi_uid = '".$regisroUID."' AND core_defi_uid = '".$aMercaderia["core_defi_uid"]."' ";  
            $db2->query($sql);
            
            //echo $sql."<br />";
        }                
    }
  
if( !empty( $btnsubmit ) ) {
    header("Location: acap7.php");
}
?>