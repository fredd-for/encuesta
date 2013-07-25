<?php session_start(); header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");

if( $_SESSION[SITE]["authenticated"] ) {    
    $_SESSION["menuactiveparent"]  = 'user';    
} else {
    header("Location: logout.php");
}

$dato = array();
$desc = array();
$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A1")),'Text');
$dato[344] = preg_replace('/,/', '', $a1);

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A2")),'Text');
$dato[345] = preg_replace('/,/', '', $a1);

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A3")),'Text');
$dato[346] = preg_replace('/,/', '', $a1);

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A4")),'Text');
$dato[347] = preg_replace('/,/', '', $a1);

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A5")),'Text');
$dato[348] = preg_replace('/,/', '', $a1);

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A6")),'Text');
$dato[349] = preg_replace('/,/', '', $a1);

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A7")),'Text');
$dato[350] = preg_replace('/,/', '', $a1);

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A8")),'Text');
$dato[351] = preg_replace('/,/', '', $a1);

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A9")),'Text'); //Fletes y servicios
$dato[352] = preg_replace('/,/', '', $a1);

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A10")),'Text');
$dato[353] = preg_replace('/,/', '', $a1);

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A11")),'Text');
$dato[354] = preg_replace('/,/', '', $a1);

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A12")),'Text');
$dato[355] = preg_replace('/,/', '', $a1);

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A13")),'Text');
$dato[356] = preg_replace('/,/', '', $a1);

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A14")),'Text');
$dato[357] = preg_replace('/,/', '', $a1);

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A15")),'Text');
$dato[358] = preg_replace('/,/', '', $a1);

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A16")),'Text');
$dato[359] = preg_replace('/,/', '', $a1);

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A17")),'Text');
$dato[360] = preg_replace('/,/', '', $a1);


$a18 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A18")),'Text');
$dato[361] = preg_replace('/,/', '', $a18);

if( !empty($a18) ){
    $desc[361] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("otrosdescrip")),'Text');
} else {
    $desc[361] = "";
}

/* tot */
$total = 0;
for( $i=344; $i<=361; $i++ ) {
    $total = $total + $dato[$i];
}
$dato[362] = $total;


/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

// obtener el uid del token
$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
if( !empty($regisroUID)  ) {

    $sql = "SELECT * FROM frm3_cap4_otrosgastosoperativos WHERE otga_regi_uid = '".$regisroUID."' ";
    $db->query($sql);

    while ( $aSueldo = $db->next_record() ) {
        $sql  = "UPDATE frm3_cap4_otrosgastosoperativos SET ";        
        $sql .= "otga_valor = '".$dato[$aSueldo["otga_defi_uid"]]."', ";
        $sql .= "otga_description	 = UPPER('".$desc[$aSueldo["otga_defi_uid"]]."'), ";        
        $sql .= "otga_suv_uid = '".$uid_token."', ";
        $sql .= "otga_updatedate = NOW() ";
        $sql .= "WHERE otga_regi_uid = '".$regisroUID."'  AND otga_defi_uid = '".$aSueldo["otga_defi_uid"]."' ";         
        $db2->query($sql);
    }        
}
  
if( !empty( $btnsubmit ) ) {
    header("Location: acap5.php");
}
?>