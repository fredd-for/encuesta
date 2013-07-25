<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
include_once("connection/database/connection.php");
include_once("connection/core/operator.php");
require_once('jasgvhsbhsdflsbushdfuishadfuashdf.php');
$codigoactivacion = OPERATOR::toSql(safeHTML(OPERATOR::getParam("act")),'Text');

$sql = "SELECT * FROM sys_users LEFT JOIN ( SELECT usr_uid, md5( CONCAT( usr_uid, '-', usr_login, '-', usr_email, '-tok' ) ) AS tok FROM sys_users WHERE usr_status = 'INACTIVE' AND usr_delete =0  ) AS token
		ON ( sys_users.usr_uid = token.usr_uid ) WHERE sys_users.usr_status = 'INACTIVE' AND sys_users.usr_delete = 0 AND token.tok = '".$codigoactivacion."' "; 
$db->query( $sql );
$activate = 2;
if( $db->numrows() > 0 ) {
	$aUser = $db->next_record();	
	$sql = "UPDATE sys_users SET usr_status = 'ACTIVE' WHERE usr_uid = ".$aUser["usr_uid"]." ";
	$db2->query( $sql );
	$cadenauno=$aUser["usr_login"];
	$resultado = hdjdujerhrjhgnvbdybyrg($cadenauno,'http://200.105.134.19:10080/wsInfoBoletas/servdata.asmx?WSDL');
	if($resultado['SrvMatriculaResult']['DtMatriculados']['CtrResult']!='D-EXIST'){
		//echo "Lo sentimos no existe un número de matricula válido registrado";  //mandar mail a email
  $activate = 3; // activada
	} else {
		$typeencuesta=$resultado['SrvMatriculaResult']['DtMatriculados']['CtrEncuesta'];
		$sqlupd="update sys_users set usr_form_uid=".$typeencuesta." where usr_uid=".$aUser["usr_uid"];
		$db2->query( $sqlupd );
		$typeencuesta=$resultado['SrvMatriculaResult']['DtMatriculados']['CtrEncuesta'];
		$razonsoc=$resultado['SrvMatriculaResult']['DtMatriculados']['RazonSocial'];
		$tiposocie=$resultado['SrvMatriculaResult']['DtMatriculados']['TipoSocietario'];
		$frmnit=$resultado['SrvMatriculaResult']['DtMatriculados']['Nit'];
		$frmmatricula=$resultado['SrvMatriculaResult']['DtMatriculados']['IdMatricula'];
		$frmdepto=$resultado['SrvMatriculaResult']['DtMatriculados']['Departamento'];
		$frmmunicipio=$resultado['SrvMatriculaResult']['DtMatriculados']['Municipio'];
		$formzona=$resultado['SrvMatriculaResult']['DtMatriculados']['Zona'];
		$frmcalle=$resultado['SrvMatriculaResult']['DtMatriculados']['Calle'];
		$frmtelefono=$resultado['SrvMatriculaResult']['DtMatriculados']['Fono'];
		$frmfax=$resultado['SrvMatriculaResult']['DtMatriculados']['Fax'];
		$frmmail=$resultado['SrvMatriculaResult']['DtMatriculados']['Mail'];
		$frmciiu=$resultado['SrvMatriculaResult']['DtMatriculados']['ClaseCiiu'];
		$societarioxtype=OPERATOR::getDbValue("select tiso_uid from  par_tipos_societarios where tiso_description like '".$tiposocie."' and tiso_sw_active='ACTIVE' and tiso_delete=0");
		$frmxdepto=OPERATOR::getDbValue("select dept_uid from par_departamentos where dept_description like '".$frmdepto."' and delete_status='ACTIVE' and dept_delete=0");
		$frmxmuni=OPERATOR::getDbValue("select muni_uid from par_municipios where muni_dept_uid='".$frmxdepto."' and muni_description like '".$frmmunicipio."' and muni_delete=0");
		//echo "<br> valores: $razonsoc:$razonsoc tiposocie:$tiposocie societariotype:$societariotype frmdepto:$frmdepto frmxdepto:$frmxdepto";
		$frmxgestion=OPERATOR::getDbValue("select gest_uid from adm_gestion where gest_sw_active='1'");
		$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$aUser["usr_uid"]."' ORDER BY suv_date DESC LIMIT 0,1 " );
		$frmxregisuid=OPERATOR::getDbValue("select regi_uid from sys_registros where regi_user_uid='".$aUser["usr_uid"]."' and regi_gest_uid=".$frmxgestion." and regi_form_uid=".$typeencuesta);
		if(!$frmxregisuid){
			$ssqlupddata="INSERT INTO sys_registros (regi_uid, regi_user_uid, regi_gest_uid, regi_form_uid, regi_swmodifica_uid, regi_createdate, regi_updatedate) VALUES (NULL, '".$aUser["usr_uid"]."', '".$frmxgestion."', '".$typeencuesta."', '1', now(), now())";
			$db2->query($ssqlupddata);
			//echo "<br>".$ssqlupddata;
			$frmxregisuid=OPERATOR::getDbValue("SELECT LAST_INSERT_ID() as UID");
		} 
		$ssqlupddata="INSERT INTO cap1_informacion_general(inge_regi_uid, inge_formulario, inge_ciiu, inge_razonsocial, inge_tiso_uid, inge_nombrecomercial, inge_nit, inge_matriculadecomercio,".
		" inge_depa_uid, inge_muni_uid, inge_ciudad, inge_zona, inge_calle, inge_referenciacalle, inge_telefono, inge_celular, inge_fax, inge_pagweb, inge_email, inge_afiliacion_camara, ".
		" inge_afiliacion_federacion, inge_afiliacion_asociacion, inge_afiliacion_otros, inge_afilia_ninguno, inge_actividad_principal, inge_actividad_secundaria1, ".
		" inge_actividad_secundaria2, inge_datecreate, inge_dateupdate, inge_delete, inge_suv_uid) VALUES (".
		" '".$frmxregisuid."', '".$typeencuesta."', '".$frmciiu."', '".$razonsoc."', '".$societarioxtype."', '', '".$frmnit."', '".$frmmatricula."',".
		" '".$frmxdepto."', '".$frmxmuni."', '', '".$formzona."', '".$frmcalle."', '', '".$frmtelefono."', '', '".$frmfax."', '', '".$aUser["usr_email"]."', ''".
		" , '', '', '', '0', '', '', '', now(), now(), '0', '".$uid_token."')";
		//echo "<br>".$ssqlupddata;
		$db2->query($ssqlupddata);
  $activate = 1; // activada
	}
	
}
unset($_POST);	
header("Location: index.php?act=".$activate);
?>