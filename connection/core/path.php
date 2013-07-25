<?php
$langDefault='es';


$basedatos = "bd_encuesta";
$host = "localhost";
$user = "root";
$pass = "mdp123";

define("DATABASE",	$basedatos);
define("DBHOST",	$host);
define("DBUSER",	$user);
define("DBPASSWORD",	$pass);

// **************** bd en postgres *************************************
$_SESSION["usr_site"]=1;

 $xpath = "/encuesta";
	$urlLanguage=1;
	$urlPositionTitle	=	0;
	$urlPositionSubtitle=	1;
	$urlPositionSubtitle2=	2;
	$urlPositionSubtitle3=	3;

 
$domain = "http://" . $_SERVER['HTTP_HOST'] . $xpath;
$rootsystem = $_SERVER['DOCUMENT_ROOT'] . $xpath;

define("SITE"  ,	'MCTA');
define("PATH_DOMAIN"  ,	$domain);
define("PATH_ROOT"    ,	$rootsystem);					// PAGINA PRINCIPAL DEL SITIO
define("PATH_ADMIN"   ,	PATH_ROOT . "/OPERATOR"); 		// RUTA DEL ADMINISTRADOR


define("PATH_LOG"	, 	PATH_ROOT . "/docs");		// ARCHIVO DE ERRORES
define("DEBUG"		,	false);
define("SAVELOG"	,	false);

define("MULTIPLE_INSTANCES"	,	true);


$db =new DBmysql;
$db2=new DBmysql;
$db3=new DBmysql;
$db4=new DBmysql;
$db5=new DBmysql;
$db6=new DBmysql;
$pagDb=new DBmysql;

$msg="";
?>
