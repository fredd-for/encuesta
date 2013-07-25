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
    <script type="text/javascript" src="../js/jquery.price_format.1.7.min.js"></script>
    <script type="text/javascript" src="../js/jquery.scrollTo.js"></script>
    <script type="text/javascript" src="../js/validable.js"></script>
    <script type="text/javascript" src="../js/numberformat.js"></script>
    
    <script type="text/javascript">	
    $(function() {        		
        $('.numeric').priceFormat({
            prefix: '',
            thousandsSeparator: ',',
            limit: 12,
            centsSeparator: '',
            centsLimit: 0
        });	
    });			
    </script>

</head>
<body>
<?php


/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$sql = "SELECT inge_razonsocial FROM cap1_informacion_general WHERE inge_regi_uid = '".$regisroUID."' AND inge_formulario = '".$uidFormulario."' ";
$rzsocial = OPERATOR::getDbValue($sql);

    
?>
<?php 
$ruta = $_SERVER['PHP_SELF'];
$aRuta = explode("/", $ruta);
$pos_n = count($aRuta);
$namefile = $aRuta[ $pos_n - 1 ];
$pagina = "";
switch ( $namefile ) {
    case "acap1.php": $pagina=1; break;
    case "acap2.php": $pagina=2; break;
    case "acap2b.php": $pagina=3; break;
    case "acap2c.php": $pagina=4; break;
    case "acap3.php": $pagina=5; break;
    case "acap4.php": $pagina=6; break;
    case "acap5.php": $pagina=7; break;
    case "acap6.php": $pagina=8; break;
    case "acap7.php": $pagina=9; break;
    case "acap8.php": $pagina=10; break;
    case "acap9.php": $pagina=11; break;
    case "acap10.php": $pagina=12; break;
    case "acap11.php": $pagina=13; break;
    case "acap12.php": $pagina=14; break;
    case "acap13.php": $pagina=15; break;
    case "acap14a.php": $pagina=16; break;
    case "acap14a2.php": $pagina=17; break;
    case "acap14a3.php": $pagina=18; break;
    case "acap14b.php": $pagina=19; break;
    case "acap14b2.php": $pagina=20; break;
    case "acap14b3.php": $pagina=21; break;
    case "acap15a1.php": $pagina=22; break;
    case "acap15a2.php": $pagina=23; break;
    case "acap15a3.php": $pagina=24; break;      
    case "bcap1.php": $pagina=25; break;
    case "bcap2.php": $pagina=26; break;
    case "bcap3.php": $pagina=27; break;
    case "ccap1.php": $pagina=28; break;
    case "dcap1a1.php": $pagina=29; break;
    case "dcap1a2.php": $pagina=30; break;
    case "dcap1a3.php": $pagina=31; break;
    case "dcap1a4.php": $pagina=32; break;
    case "dcap1e.php": $pagina=33; break;
    case "dcap2.php": $pagina=34; break;
    default: $pagina = ""; break;
}


$title1 = "ENCUESTA ANUAL DE UNIDADES PRODUCTIVAS<br />INDUSTRIA MANUFACTURERA <br />";
$gestion1 = "gesti&oacute;n 2012";
$module = "M&oacute;dulo A";
?>
<div id="wrpB">
    
    <div class="header">
    
        <a href="<?php echo $domain ?>/option.php" class="logo">Ministerio</a>
    
        <div class="bxTit">
            <?php echo $title1;  ?>
            <span><?php echo $gestion1;  ?></span>
        </div>
    
        <div class="infUP">
            <div class="usInf">
                <a href="../logout.php" class="lnkS2">cerrar sesi&oacute;n</a>
                <?php echo $rzsocial ?> 
            </div>
            <?php if( !empty($pagina) ){ ?>
            <div class="pag">
                <span>P&aacute;gina</span><span class="color3"><?php echo $pagina; ?></span><span>de</span><span>34</span>
            </div>
            <?php } ?>
        </div>        
    
    </div>