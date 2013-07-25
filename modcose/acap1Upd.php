<?php session_start();
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php');
$ai_rs = OPERATOR::toSql(safeHTML(OPERATOR::getParam("ai_rs")),'Text');
$ai_societario = OPERATOR::toSql(safeHTML(OPERATOR::getParam("ai_societario")),'Text');
$ai_tradename = OPERATOR::toSql(safeHTML(OPERATOR::getParam("ai_tradename")),'Text');
$ai_nit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("ai_nit")),'Text');
$ai_traderegis = OPERATOR::toSql(safeHTML(OPERATOR::getParam("ai_traderegis")),'Text');
$ai_depto = OPERATOR::toSql(safeHTML(OPERATOR::getParam("ai_depto")),'Text');
$ai_municipio = OPERATOR::toSql(safeHTML(OPERATOR::getParam("ai_municipio")),'Text');
$ai_city = OPERATOR::toSql(safeHTML(OPERATOR::getParam("ai_city")),'Text');
$ai_zona = OPERATOR::toSql(safeHTML(OPERATOR::getParam("ai_zona")),'Text');
$ai_address = OPERATOR::toSql(safeHTML(OPERATOR::getParam("ai_address")),'Text');
$ai_reference = OPERATOR::toSql(safeHTML(OPERATOR::getParam("ai_reference")),'Text');
$ai_phone1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("ai_phone1")),'Text');
$ai_phone2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("ai_phone2")),'Text');
$ai_fax = OPERATOR::toSql(safeHTML(OPERATOR::getParam("ai_fax")),'Text');
$ai_pagweb = OPERATOR::toSql(safeHTML(OPERATOR::getParam("ai_pagweb")),'Text');
$ai_email = OPERATOR::toSql(safeHTML(OPERATOR::getParam("ai_email")),'Text');


/* afiliacion de la empresa */

$afil_1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("afil_1")),'Text'); // chk activo on
$afil_camara = "";
if( $afil_1 == 'on' ) {
    $afil_camara = OPERATOR::toSql(safeHTML(OPERATOR::getParam("afil_camara")),'Text');
}

$afil_2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("afil_2")),'Text');
$afil_federacion = "";
if( $afil_2 == 'on' ) {
    $afil_federacion = OPERATOR::toSql(safeHTML(OPERATOR::getParam("afil_federacion")),'Text');
}

$afil_3 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("afil_3")),'Text');
$afil_asociacion = "";
if( $afil_3 == 'on' ) {
    $afil_asociacion = OPERATOR::toSql(safeHTML(OPERATOR::getParam("afil_asociacion")),'Text');
}

$afil_4 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("afil_4")),'Text');
$afil_otros = "";
if( $afil_4 == 'on' ) {    
    $afil_otros = OPERATOR::toSql(safeHTML(OPERATOR::getParam("afil_otros")),'Text');
}

/* actividad principal*/
$ai_actprin = OPERATOR::toSql(safeHTML(OPERATOR::getParam("ai_actprin")),'Text');
$ai_actsec1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("ai_actsec1")),'Text');
$ai_actsec2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("ai_actsec2")),'Text');

$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
if( !empty($regisroUID) && !empty($uidFormulario) ) {
if (OPERATOR::toSql(safeHTML(OPERATOR::getParam("pack")),'Number')==1) {
	 $sql = "UPDATE cap1_informacion_general SET ";        
        $sql .= "inge_razonsocial = UPPER('".$ai_rs."'), ";
        $sql .= "inge_tiso_uid = '".$ai_societario."', ";
        $sql .= "inge_nombrecomercial = UPPER('".$ai_tradename."'), ";
        $sql .= "inge_dateupdate = NOW(), ";        
        $sql .= "inge_suv_uid = '".$uid_token."' WHERE inge_regi_uid = '".$regisroUID."' AND inge_formulario = '".$uidFormulario."' ";
        
       // echo $sql;
        $db->query($sql);     
};
if (OPERATOR::toSql(safeHTML(OPERATOR::getParam("pack")),'Number')==2) {

        $sql = "UPDATE cap1_informacion_general SET ";        

        $sql .= "inge_nit = UPPER('".$ai_nit."'), ";
        $sql .= "inge_matriculadecomercio = '".$ai_traderegis."', ";
        $sql .= "inge_depa_uid = '".$ai_depto."', ";
        $sql .= "inge_muni_uid = '".$ai_municipio."', ";
        $sql .= "inge_ciudad = UPPER('".$ai_city."'), ";
        $sql .= "inge_zona = UPPER('".$ai_zona."'), ";
        $sql .= "inge_calle = UPPER('".$ai_address."'), ";
        $sql .= "inge_referenciacalle = UPPER('".$ai_reference."'), ";
        $sql .= "inge_dateupdate = NOW(), ";        
        $sql .= "inge_suv_uid = '".$uid_token."' WHERE inge_regi_uid = '".$regisroUID."' AND inge_formulario = '".$uidFormulario."' ";
        
        //echo $sql;
        $db->query($sql);     
};
if (OPERATOR::toSql(safeHTML(OPERATOR::getParam("pack")),'Number')==3) {
        $sql = "UPDATE cap1_informacion_general SET ";        
        $sql .= "inge_telefono = UPPER('".$ai_phone1."'), ";
        $sql .= "inge_celular = UPPER('".$ai_phone2."'), ";
        $sql .= "inge_fax = UPPER('".$ai_fax."'), ";
        $sql .= "inge_pagweb = '".$ai_pagweb."', ";
        $sql .= "inge_dateupdate = NOW(), ";        
        $sql .= "inge_suv_uid = '".$uid_token."' WHERE inge_regi_uid = '".$regisroUID."' AND inge_formulario = '".$uidFormulario."' ";
        
        //echo $sql;
        $db->query($sql);     
};
if (OPERATOR::toSql(safeHTML(OPERATOR::getParam("pack")),'Number')==4) {
        $sql = "UPDATE cap1_informacion_general SET ";        
        $sql .= "inge_email = '".$ai_email."', ";
        $sql .= "inge_dateupdate = NOW(), ";        
        $sql .= "inge_suv_uid = '".$uid_token."' WHERE inge_regi_uid = '".$regisroUID."' AND inge_formulario = '".$uidFormulario."' ";
        
        //echo $sql;
        $db->query($sql);     
};
if (OPERATOR::toSql(safeHTML(OPERATOR::getParam("pack")),'Number')==5) {
        $sql = "UPDATE cap1_informacion_general SET ";        
        $sql .= "inge_actividad_principal = UPPER('".$ai_actprin."'), ";
        $sql .= "inge_actividad_secundaria1 = UPPER('".$ai_actsec1."'), ";
        $sql .= "inge_actividad_secundaria2 = UPPER('".$ai_actsec2."'), ";
        $sql .= "inge_dateupdate = NOW(), ";        
        $sql .= "inge_suv_uid = '".$uid_token."' WHERE inge_regi_uid = '".$regisroUID."' AND inge_formulario = '".$uidFormulario."' ";
        
        //echo $sql;
        $db->query($sql);     
};
};
?>