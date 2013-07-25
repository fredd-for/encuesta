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
$dato[118] = preg_replace('/,/', '', $a1);

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A2")),'Text');
$dato[119] = preg_replace('/,/', '', $a1);

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A3")),'Text');
$dato[120] = preg_replace('/,/', '', $a1);

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A4")),'Text');
$dato[121] = preg_replace('/,/', '', $a1);

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A5")),'Text');
$dato[122] = preg_replace('/,/', '', $a1);

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A6")),'Text');
$dato[123] = preg_replace('/,/', '', $a1);

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A7")),'Text');
$dato[124] = preg_replace('/,/', '', $a1);

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A8")),'Text');
$dato[125] = preg_replace('/,/', '', $a1);

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A9")),'Text'); //Fletes y servicios
$dato[126] = preg_replace('/,/', '', $a1);

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A10")),'Text');
$dato[127] = preg_replace('/,/', '', $a1);

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A11")),'Text');
$dato[128] = preg_replace('/,/', '', $a1);

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A12")),'Text');
$dato[129] = preg_replace('/,/', '', $a1);

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A13")),'Text');
$dato[130] = preg_replace('/,/', '', $a1);

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A14")),'Text');
$dato[131] = preg_replace('/,/', '', $a1);

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A15")),'Text');
$dato[132] = preg_replace('/,/', '', $a1);

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A16")),'Text');
$dato[133] = preg_replace('/,/', '', $a1);

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A17")),'Text');
$dato[134] = preg_replace('/,/', '', $a1);


$a18 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A18")),'Text');
$dato[135] = preg_replace('/,/', '', $a18);

if( !empty($a18) ){
    $desc[135] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("otrosdescrip")),'Text');
} else {
    $desc[135] = "";
}

/* tot */
$total = 0;
for( $i=118; $i<=135; $i++ ) {
    $total = $total + $dato[$i];
}
$dato[136] = $total;


/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

// obtener el uid del token
$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
if( !empty($regisroUID)  ) {

    $sql = "SELECT * FROM frm2_cap4_otrosgastosoperativos WHERE otga_regi_uid = '".$regisroUID."' ";
    $db->query($sql);

    while ( $aSueldo = $db->next_record() ) {
        $sql  = "UPDATE frm2_cap4_otrosgastosoperativos SET ";        
        $sql .= "otga_valor = '".$dato[$aSueldo["otga_defi_uid"]]."', ";
        $sql .= "otga_description	 = UPPER('".utf8_decode($desc[$aSueldo["otga_defi_uid"]])."'), ";        
        $sql .= "otga_suv_uid = '".$uid_token."', ";
        $sql .= "otga_updatedate = NOW() ";
        $sql .= "WHERE otga_regi_uid = '".$regisroUID."'  AND otga_defi_uid = '".$aSueldo["otga_defi_uid"]."' ";         
        $db2->query($sql);
    }        
}
  
?>