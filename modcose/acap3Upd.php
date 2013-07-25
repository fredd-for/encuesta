<?php session_start(); ?>
<?php header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
?>
<?php 
if( $_SESSION[SITE]["authenticated"] ) {    
    $_SESSION["menuactiveparent"]  = 'user';    
} else {
    header("Location: logout.php");
}
?>

<?php 

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
$total = $input1 + $input2 + $input3 + $input4 + $input5 + $input6 + $input8;


/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];


$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

// obtener el uid del token
$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    if( !empty($regisroUID)  ) {
            if (OPERATOR::toSql(safeHTML(OPERATOR::getParam("pack")),'Number')==1) {
        $defi_uid = 6;        
        $sql  = "UPDATE cap3_suministros SET ";        
        $sql .= "sumi_valor = '".$input1."', ";
        $sql .= "sumi_categoriatarifaria = UPPER('".$catElectricidad."'), ";
        $sql .= "sumi_suv_uid = '".$uid_token."', ";
        $sql .= "sumi_createupdate = NOW() ";
        $sql .= "WHERE sumi_regi_uid = '".$regisroUID."' AND sumi_defi_uid = '".$defi_uid."' ";         
        $db->query($sql);
        }
            if (OPERATOR::toSql(safeHTML(OPERATOR::getParam("pack")),'Number')==2) {
        $defi_uid = 7;        
        $sql  = "UPDATE cap3_suministros SET ";        
        $sql .= "sumi_valor = '".$input2."', ";
        $sql .= "sumi_categoriatarifaria = UPPER('".$catAgua."'), ";
        $sql .= "sumi_suv_uid = '".$uid_token."', ";
        $sql .= "sumi_createupdate = NOW() ";
        $sql .= "WHERE sumi_regi_uid = '".$regisroUID."' AND sumi_defi_uid = '".$defi_uid."' ";         
        $db->query($sql);
        }
            if (OPERATOR::toSql(safeHTML(OPERATOR::getParam("pack")),'Number')==3) {
        $defi_uid = 8;        
        $sql  = "UPDATE cap3_suministros SET ";        
        $sql .= "sumi_valor = '".$input3."', ";
        $sql .= "sumi_categoriatarifaria = UPPER('".$catGas."'), ";
        $sql .= "sumi_suv_uid = '".$uid_token."', ";
        $sql .= "sumi_createupdate = NOW() ";
        $sql .= "WHERE sumi_regi_uid = '".$regisroUID."' AND sumi_defi_uid = '".$defi_uid."' ";         
        $db->query($sql);
        }
    }
        ?>