<?php session_start(); header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php');
$dat = array();
$desc = array();

$dat[59] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("rbtn_inversion")),'Text'); //gastos o inversión

$dat[60] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("chk_1")),'Text');
$dat[61] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("chk_2")),'Text');
$dat[62] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("chk_3")),'Text'); //otros
// descripcion
$desc[62] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("inversionotros")),'Text');

if( $dat[59] == 1 ) {
    $dat[60] = 0;
    $dat[61] = 0;
    $dat[62] = 0;
    $desc[62] = "";
}

if( !empty( $dat[60] ) ) { $dat[60] = 1; }
if( !empty( $dat[61] ) ) { $dat[61] = 1; }
if( !empty( $dat[62] ) ) { $dat[62] = 1; }

$dat[63] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("rbtn_agua")),'Text');
$dat[64] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("rbtn_certi")),'Text'); //certificaciones
$dat[65] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("rbtn_ars")),'Text');   //residuos solidos
$dat[66] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("rbtn_cap")),'Text');  // capacitacion
$dat[67] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("rbtn_aga")),'Text');  // otras acciones de gestión ambiental

// descripcion
$desc[64] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("certiambiental")),'Text');
$desc[67] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("otrasambiental")),'Text');


if( $dat[64] == 0 ) {
    $desc[64] = "";
}

if( $dat[67] == 0 ) {
    $desc[67] = "";
}

/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];


$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

// obtener el uid del token
$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
if( !empty($regisroUID)  ) {   

    $sql = "SELECT * FROM frm1_bcap1_gestionambiental WHERE geam_regi_uid = '".$regisroUID."' ";
    $db->query($sql);

    //echo $sql;
    while ( $aGesAmb = $db->next_record() ) {         
        $sql  = "UPDATE frm1_bcap1_gestionambiental SET ";
        $sql .= "geam_valor = '".$dat[$aGesAmb["geam_defi_uid"]]."', ";
        $sql .= "geam_description = UPPER('".$desc[$aGesAmb["geam_defi_uid"]]."'), ";
        $sql .= "geam_suv_uid	 = '".$uid_token."', ";
        $sql .= "geam_updatedate = NOW() ";
        $sql .= "WHERE geam_regi_uid = '".$regisroUID."' AND geam_defi_uid	 = '".$aGesAmb["geam_defi_uid"]."' ";  
        $db2->query($sql);
        //echo $sql."<br />";
    }      
    //echo $sql."<br />"; 
}
  
if( !empty( $btnsubmit ) ) {
    header("Location: bcap2.php");
}
?>