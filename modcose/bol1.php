<?php session_start(); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
?>
<?php include_once('../verifyLogin.php'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="es" />    
    <title>Formulario de Encuesta Comercio y Servicios</title>
    <meta name="description" content="Inicio" />
    <meta name="keywords" content="Inicio" />    
    <link href="../css/layout.css" rel="stylesheet" type="text/css" />    
    <link rel="shortcut icon" href="lib/favicon.ico"   type="image/x-icon"/>    
    <script type="text/javascript" src="../js/jquery.min.js"></script>    
    <script type="text/javascript" src="js/bol1.js"></script>    

</head>
<body>
<?php


/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$sql = "SELECT inge_razonsocial FROM cap1_informacion_general WHERE inge_regi_uid = '".$regisroUID."' AND inge_formulario = '".$uidFormulario."' ";
$rzsocial = OPERATOR::getDbValue($sql);

$sql = "SELECT * FROM par_boleta WHERE bole_regi_uid = '".$regisroUID."' ";
$db->query( $sql );

if( $db->numrows() == 0 ) {
    
        $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
       
                                      
        $codigovalido = true;
        do {
            $codigo = rand(10000, 99999);
            $sql = "SELECT * FROM par_boleta WHERE bole_codigo = '".$codigo."' AND bole_codigo <> '' AND bole_codigo <> 0 ";
            $db2->query( $sql );
            if( $db2->numrows() == 0 ) {
                $codigovalido = false;
            }
        } while ($codigovalido);
                                       
        $sql = "INSERT INTO par_boleta SET ";
        $sql .= "bole_regi_uid = '".$regisroUID."', ";              
        $sql .= "bole_codigo = '".$codigo."', "; 
        $sql .= "bole_suv_uid = '".$uid_token."', "; 
        $sql .= "bole_createdate = NOW(), "; 
        $sql .= "bole_updatedate = NOW() ";                          	 	
        $db3->query( $sql );                  
}

$codigo = OPERATOR::getDbValue("SELECT bole_codigo FROM par_boleta WHERE bole_regi_uid = '".$regisroUID."'");


$sql = "SELECT inge_razonsocial, inge_ciiu, inge_nit, inge_matriculadecomercio FROM cap1_informacion_general WHERE inge_regi_uid = '".$regisroUID."' AND inge_formulario = '".$uidFormulario."' ";
$db->query($sql);
$aBoleta = $db->next_record();

?>
<!-- begin body -->
<div id="wrpB">
<div id="areaprint">

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


<form class="formA" action="cofirmrecord.php" method="post" style="text-align: center;" onSubmit="if(!confirm('Esta seguro de finalizar la encuesta?.\nLuego de aceptar no podra modificar ningun campo mas.')){return false;}">
<fieldset>
    <p>
        Concluido de mi parte el llenado del cuestionario de la presente encuesta, me ratifico en todo su contenido. 
        <input type="checkbox" name="chkconforme" id="chkconforme" />
        
    </p>
        
    <span class="bxBt">                    	                        					                        
    <input type="submit" value="  FINALIZAR  " id="sendData" name="continuarregistro" class="buttonB" />       
    <a href="ccap1.php" class="btnS">ANTERIOR</a>
    </span>

</fieldset>
</form>

<div class="clear"></div>



</div>


</div>
    
    
</div>

</body>
</html>
