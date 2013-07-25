<?php session_start(); header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php');

$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$uid = OPERATOR::toSql(safeHTML(OPERATOR::getParam("uid")),'Text');

$sql = " UPDATE frm1_plantas SET plan_delete = 1 "
      ." WHERE plan_position = '".$uid."' AND plan_regi_uid = '".$regisroUID."' ";
$db->query( $sql );
?>