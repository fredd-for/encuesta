<?php session_start(); header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php');
require_once('mnzxbcvlaksjdhfgpqowieuryt.php');

$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');
$chkconforme = OPERATOR::toSql(safeHTML(OPERATOR::getParam("chkconforme")),'Text');
    
if( !empty($regisroUID) && $chkconforme == 'on' && !empty($btnsubmit) ) {   
    $sql = "SELECT * FROM sys_registros WHERE regi_uid	 = '".$regisroUID."' AND  regi_swmodifica_uid = 1 ";
    $db->query($sql);
    
    $sql  = "UPDATE sys_registros SET ";
    $sql .= "regi_swmodifica_uid = '0', ";        
    $sql .= "regi_updatedate = NOW() ";
    $sql .= "WHERE regi_uid = '".$regisroUID."' AND regi_form_uid	 = '".$uidFormulario."' AND regi_user_uid = '".$usuario_uid."'  ";  
    $db2->query($sql);

    $numxboleta = OPERATOR::getDbValue( "SELECT bole_codigo FROM par_boleta WHERE bole_regi_uid = '".$regisroUID."'" );
    $numxmatricula = OPERATOR::getDbValue( "SELECT usr_login FROM sys_users WHERE usr_uid = '".$usuario_uid."'" );
    $resultado = wsSms($numxmatricula,'http://200.105.134.19:10080/wsInfoBoletas/servdata.asmx?WSDL',$numxboleta);

	if($resultado['RegistraBoletaResult']['regBoleta']['CtrResult']=='OK'){
		$sql2="update  par_boleta set bole_swestado=1 where bole_regi_uid=".$regisroUID;
		$db2->query($sql2);
	}

    $_SESSION[SITE]["val_regi_swmodifica_uid"] = 0;
}
  
if( !empty( $btnsubmit ) ) {
    
    header("Location: bol.php");
}
?>