<?php session_start(); header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");

if( $_SESSION[SITE]["authenticated"] ) {    
    $_SESSION["menuactiveparent"]  = 'user';    
} else {
    header("Location: logout.php");
}

// valor de la tarifa
$input1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-1")),'Text');
$input1 = preg_replace('/,/', '', $input1);

$input2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-2")),'Text');
$input2 = preg_replace('/,/', '', $input2);

$input3 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-3")),'Text');
$input3 = preg_replace('/,/', '', $input3);

$input4 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-4")),'Text');
$input4 = preg_replace('/,/', '', $input4);

$input5 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-5")),'Text');
$input5 = preg_replace('/,/', '', $input5);

$input6 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-6")),'Text');
$input6 = preg_replace('/,/', '', $input6);

$input10 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-10")),'Text');
$input10 = preg_replace('/,/', '', $input10);




$otroscombustibles = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-9")),'Text');

$input8 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-8")),'Text');
$input8 = preg_replace('/,/', '', $input8);


// tarifa
$catElectricidad = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-11")),'Text');
if( $catElectricidad == 'OTRAS') {
    $otro = OPERATOR::toSql(safeHTML(OPERATOR::getParam("otroelectricidad")),'Text');
    if( !empty( $otro ) ) {
        $catElectricidad = $otro;
    }
}

$catAgua = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-12")),'Text');
if( $catAgua == 'OTRAS') {
    $otro = OPERATOR::toSql(safeHTML(OPERATOR::getParam("otroagua")),'Text');
    if( !empty( $otro ) ) {
        $catAgua = $otro;
    }
}

$catGas = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-13")),'Text');
if( $catGas == 'OTRAS') {
    $otro = OPERATOR::toSql(safeHTML(OPERATOR::getParam("otrogas")),'Text');
    if( !empty( $otro ) ) {
        $catGas = $otro;
    }
}
/* tot */
$total = $input1 + $input2 + $input3 + $input4 + $input5 + $input6 + $input8 + $input10;


/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];


$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

// obtener el uid del token
$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    if( !empty($regisroUID)  ) {
        $defi_uid = 109;        
        $sql  = "UPDATE cap3_suministros SET ";        
        $sql .= "sumi_valor = '".$input1."', ";
        $sql .= "sumi_categoriatarifaria = UPPER('".utf8_decode($catElectricidad)."'), ";
        $sql .= "sumi_suv_uid = '".$uid_token."', ";
        $sql .= "sumi_createupdate = NOW() ";
        $sql .= "WHERE sumi_regi_uid = '".$regisroUID."' AND sumi_defi_uid = '".$defi_uid."' ";         
        $db->query($sql);
        
        $defi_uid = 110;        
        $sql  = "UPDATE cap3_suministros SET ";        
        $sql .= "sumi_valor = '".$input2."', ";
        $sql .= "sumi_categoriatarifaria = UPPER('".utf8_decode($catAgua)."'), ";
        $sql .= "sumi_suv_uid = '".$uid_token."', ";
        $sql .= "sumi_createupdate = NOW() ";
        $sql .= "WHERE sumi_regi_uid = '".$regisroUID."' AND sumi_defi_uid = '".$defi_uid."' ";         
        $db->query($sql);
        
        $defi_uid = 111;        
        $sql  = "UPDATE cap3_suministros SET ";        
        $sql .= "sumi_valor = '".$input3."', ";
        $sql .= "sumi_categoriatarifaria = UPPER('".utf8_decode($catGas)."'), ";
        $sql .= "sumi_suv_uid = '".$uid_token."', ";
        $sql .= "sumi_createupdate = NOW() ";
        $sql .= "WHERE sumi_regi_uid = '".$regisroUID."' AND sumi_defi_uid = '".$defi_uid."' ";         
        $db->query($sql);
        
        $defi_uid = 112;        
        $sql  = "UPDATE cap3_suministros SET ";        
        $sql .= "sumi_valor = '".$input4."', ";
        $sql .= "sumi_categoriatarifaria = '', ";
        $sql .= "sumi_suv_uid = '".$uid_token."', ";
        $sql .= "sumi_createupdate = NOW() ";
        $sql .= "WHERE sumi_regi_uid = '".$regisroUID."' AND sumi_defi_uid = '".$defi_uid."' ";         
        $db->query($sql);
        
        $defi_uid = 113; //gasolina   
        $sql  = "UPDATE cap3_suministros SET ";        
        $sql .= "sumi_valor = '".$input5."', ";
        $sql .= "sumi_categoriatarifaria = '', ";
        $sql .= "sumi_suv_uid = '".$uid_token."', ";
        $sql .= "sumi_createupdate = NOW() ";
        $sql .= "WHERE sumi_regi_uid = '".$regisroUID."' AND sumi_defi_uid = '".$defi_uid."' ";         
        $db->query($sql);
        
        $defi_uid = 114; //gas licuado     
        $sql  = "UPDATE cap3_suministros SET ";        
        $sql .= "sumi_valor = '".$input6."', ";
        $sql .= "sumi_categoriatarifaria = '', ";
        $sql .= "sumi_suv_uid = '".$uid_token."', ";
        $sql .= "sumi_createupdate = NOW() ";
        $sql .= "WHERE sumi_regi_uid = '".$regisroUID."' AND sumi_defi_uid = '".$defi_uid."' ";         
        $db->query($sql);
        
        $defi_uid = 115; //gnv
        $sql  = "UPDATE cap3_suministros SET ";        
        $sql .= "sumi_valor = '".$input10."', ";
        $sql .= "sumi_categoriatarifaria = '', ";
        $sql .= "sumi_suv_uid = '".$uid_token."', ";
        $sql .= "sumi_createupdate = NOW() ";
        $sql .= "WHERE sumi_regi_uid = '".$regisroUID."' AND sumi_defi_uid = '".$defi_uid."' ";         
        $db->query($sql);
        
        // Otros combustibles
        $defi_uid = 116;        
        $sql  = "UPDATE cap3_suministros SET ";        
        $sql .= "sumi_valor = '".$input8."', ";
        $sql .= "sumi_categoriatarifaria = UPPER('".utf8_decode($otroscombustibles)."'), ";
        $sql .= "sumi_suv_uid = '".$uid_token."', ";
        $sql .= "sumi_createupdate = NOW() ";
        $sql .= "WHERE sumi_regi_uid = '".$regisroUID."' AND sumi_defi_uid = '".$defi_uid."' ";         
        $db->query($sql);        
        
        // Total
        $defi_uid = 117;    
        $sql  = "UPDATE cap3_suministros SET ";        
        $sql .= "sumi_valor = '".$total."', ";
        $sql .= "sumi_categoriatarifaria = '', ";
        $sql .= "sumi_suv_uid = '".$uid_token."', ";
        $sql .= "sumi_createupdate = NOW() ";
        $sql .= "WHERE sumi_regi_uid = '".$regisroUID."' AND sumi_defi_uid = '".$defi_uid."' ";         
        
        //echo $sql;
        $db->query($sql);
    }
?>