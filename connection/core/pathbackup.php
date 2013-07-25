<?php
$langDefault='es';

$basedatos = "nombredb";
$host = "localhost";
$user = "usuario";
$pass = "contrasena";

define("DATABASE",	$basedatos);
define("DBHOST",	$host);
define("DBUSER",	$user);
define("DBPASSWORD",	$pass);

// **************** bd en postgres *************************************
$_SESSION["usr_site"]=1;

//for localhost

	$xpath = "/encuestas";
	$urlLanguage=1;
	$urlPositionTitle	=	1;
	$urlPositionSubtitle=	2;
	$urlPositionSubtitle2=	3;
	$urlPositionSubtitle3=	4;
	$urlPositionSubtitle4=	5; 
	$urlPositionSubtitle5=	6;  

$domain = "http://" . $_SERVER['HTTP_HOST'] . $xpath;
$rootsystem = $_SERVER['DOCUMENT_ROOT'] . $xpath;

define("SITE"  ,	'MCTA');
define("PATH_DOMAIN"  ,	$domain);
define("PATH_ROOT"    ,	$rootsystem);					// PAGINA PRINCIPAL DEL SITIO
define("PATH_ADMIN"   ,	PATH_ROOT . "/OPERATOR"); 		// RUTA DEL ADMINISTRADOR
define("PATH_GALLERY" , PATH_ROOT . "/img/gallery");		// GALERIA DE IMAGENES

define("PATH_LOG"	, 	PATH_ROOT . "/docs");		// ARCHIVO DE ERRORES
define("DEBUG"		,	true);
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
