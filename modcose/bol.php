<?php session_start();

include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");

$clieUid = OPERATOR::getDbValue("select suv_cli_uid from sys_users_verify left join sys_users on usr_uid= suv_cli_uid  where suv_status=0 and suv_ip='".$_SERVER['REMOTE_ADDR']."' and suv_token='".$_SESSION[SITE]["TOKEN_FRONT"]."' and usr_delete=0 and usr_status='ACTIVE' ");

function checkEmpty($var) {
    if (strlen($var) >= 1) {
        return false; // !empty
    } else {
        return true; // empty
    }
}

if( $_SESSION[SITE]["authenticated"]===true && $clieUid === $_SESSION[SITE]["usr_uid"] && !checkEmpty($_SESSION[SITE]["val_regi_swmodifica_uid"]) &&  $_SESSION[SITE]["val_regi_swmodifica_uid"] == 0 ) {

	   $newToken = sha1(PREFIX.uniqid( rand(), TRUE ));
       $sqlDat ="update sys_users_verify set suv_token = '".$newToken."' where suv_token='".$_SESSION[SITE]["TOKEN_FRONT"]."' and suv_ip='".$_SERVER['REMOTE_ADDR']."'";
       //echo $_SERVER['REMOTE_ADDR'];
       $db->query($sqlDat);
	   $_SESSION[SITE]["TOKEN_FRONT"] = $newToken;        
	     
} else { 
    header("Location: logout.php");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="es" />    
    <title>Formulario de Encuesta Comercio y Servicios</title>
    <meta name="description" content="Inicio" />
    <meta name="keywords" content="Inicio" />    
    <link href="../css/layoutb.css" rel="stylesheet" type="text/css" />    
    <link rel="shortcut icon" href="lib/favicon.ico"   type="image/x-icon"/>    
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/jquery.printarea.js"></script>
    <script type="text/javascript" src="js/bol.js"></script>
</head>
<body>
<?php

/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$sql = "SELECT inge_razonsocial FROM cap1_informacion_general WHERE inge_regi_uid = '".$regisroUID."' AND inge_formulario = '".$uidFormulario."' ";
$rzsocial = OPERATOR::getDbValue($sql);

$codigo = OPERATOR::getDbValue("SELECT bole_codigo FROM par_boleta WHERE bole_regi_uid = '".$regisroUID."'");


$sql = "SELECT inge_razonsocial, inge_ciiu, inge_nit, inge_matriculadecomercio FROM cap1_informacion_general WHERE inge_regi_uid = '".$regisroUID."' AND inge_formulario = '".$uidFormulario."' ";
$db->query($sql);
$aBoleta = $db->next_record();

?>
<!-- begin body -->
<div id="wrpB">
    
<div class="contCl">
    <a href="../logout.php" class="btnCls">Cerrar sesi&oacute;n</a>
    <a href="#" class="btnPrint" id="sendData" >Imprimir</a>
</div>
    
<div id="areaprint" class="print" >

<div class="headerB">

<a href="#" class="logo"><img src="<?php echo $domain; ?>/lib/logo_b.jpg" alt="Ministerio" width="298" height="97" /></a>    </div>
<div class="contentB">

    <p>BOLETA DE CONSTANCIA DE PRESENTACI&Oacute;N DE LA ENCUESTA ANUAL DE UNIDADES PRODUCTIVAS, COMERCIO Y SERVICIOS DEL MINISTERIO DE DESARROLLO PRODUCTIVO Y ECONOM&Iacute;A PLURAL</p>

    <table class="fOpt">

    <thead>
        <tr>
            <th colspan="2">DATOS GENERALES DE LA EMPRESA</th>
        </tr>
    </thead>

    <tbody>
        <tr>                        
            <td colspan="2"><span class="bold">Raz&oacute;n social o denominaci&oacute;n:</span> 
                <label class="labB"><?php echo $aBoleta["inge_razonsocial"]; ?></label></td>
        </tr>

        <tr>                        
            <td><span class="bold">N&ordm; de Matr&iacute;cula de Comercio:</span> 
                <label class="labB"><?php echo $aBoleta["inge_matriculadecomercio"]; ?></label></td>
            <td><span class="bold">CIIU:</span>
                <label class="labB"><?php echo $aBoleta["inge_ciiu"]; ?></label></td>
        </tr>

        <tr>                        
            <td><span class="bold">NIT:</span>
                <label class="labB"><?php echo $aBoleta["inge_nit"]; ?></label></td>
            <td><span class="bold">C&oacute;digo:</span>
                <label class="labB"><?php echo $codigo; ?></label></td>
        </tr>
        
    </tbody>
</table>

<p class="bold">ENTREGADO POR</p>

<table class="fOpt">


        <tbody>

        <tr>                        
            <td class="tabB"><span class="bold">Nombre y apellido:</span> 
                <label class="labB">________________________</label></td>
            <td class="tabB"><span class="bold">Firma:</span>
                <label class="labB">_______________</label></td>
        </tr>

        <tr>                        
            <td class="tabB"></td>
            <td class="tabB"><span class="bold">C. I.:</span>
                <label class="labB">____________</label></td>
        </tr>
    </tbody>
</table>

<p class="small">
    <br />    
    <br />    
    <br />    
    <br />    
    SELLO RECEPCI&Oacute;N
</p>

<p class="small">..................................</p>


<div class="clear"></div>

</div>


</div>
    
    
</div>

</body>
</html>
