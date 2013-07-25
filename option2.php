<?php session_start(); ?>
<?php
include_once("connection/database/connection.php");
include_once("connection/core/operator.php");
?>
<?php include_once('verifyLogin.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="language" content="es" />
    <title>Formularios</title>
    <meta name="description" content="Inicio" />
    <meta name="keywords" content="Inicio" />
    <link href="css/layout.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="lib/favicon.ico"   type="image/x-icon"/>    
    <script type="text/javascript" src="js/jquery-1.8.0.js"></script>
    <script type="text/javascript">
        $(document).ready( function(){
            $("#user").click( function() {
                $("#message").hide();
            }); 
        } );
    </script>
</head>
<body>    

<a href="logout.php" >Salir</a>

<div id="wrapper">
<div class="contOp"> 
    <?php 
	
	// gestion activa
	$db->query("SELECT gest_uid, gest_gestion FROM adm_gestion WHERE gest_sw_active = '1' ORDER BY gest_gestion DESC LIMIT 0,1 ");
	$aGes = $db->next_record();
	
	// verificar que el usuario tenga creada su registro para una gestion activa
	$uidFormulario = 1; // este se obtendrá de acuerdo WebService
 
 $_SESSION[SITE]["uidtipoformulario"] = 1;
	
	$sql = "SELECT regi_uid
			FROM adm_gestion
			LEFT JOIN sys_registros ON ( gest_uid = regi_gest_uid )
			WHERE regi_user_uid = '" . $_SESSION[SITE]["usr_uid"] . "'
			AND gest_gestion = '" . $aGes["gest_gestion"] . "' ";
$db2->query($sql);
		
	if ($db2->numrows() == 0) {
    $sql = " INSERT INTO sys_registros( regi_user_uid, regi_gest_uid, regi_form_uid, regi_swmodifica_uid, regi_createdate, regi_updatedate  ) "
        . " VALUES( '" . $_SESSION[SITE]["usr_uid"] . "', '" . $aGes["gest_uid"] . "', '" . $uidFormulario . "', '1', NOW(), NOW() ) ";
    $db->query($sql);

    $db2->query("SELECT LAST_INSERT_ID() as id");
    $aRegistro = $db2->next_record();
    $_SESSION[SITE]["registro_uid"] = $aRegistro["id"];
    $regisroUID = $aRegistro["id"]; // uid de registro para el usuario		$regisroUID  = 		
} else {
    $aRegistro = $db2->next_record();
    $_SESSION[SITE]["registro_uid"] = $aRegistro["regi_uid"];
    $regisroUID = $aRegistro["regi_uid"]; // uid de registro para el usuario
}
	
	//echo "Numero de registro ".$regisroUID;
	//echo "Tipo de formulario ".$uidFormulario."<br />";

	?>
    
    <?php if( $_SESSION[SITE]["authenticated"] ) { ?>
    <ul id="mainmenu">
        
        <li><a <?php ( $_SESSION["menuactiveparent"]  == 'patient' )?print('class="actSm"'):print(""); ?> href="<?=$domain?>/modcose/acap1.php">Encuesta Anual de Unidades Productivas Comercio y Servicios</a>
            <ul>
            <li><a <?php ( $_SESSION["menuactive"] == 'patient-list' )?print('class="actSmn2"'):print(""); ?> href="<?=$domain?>/modcose/acap1.php">Identificaci&oacute;n y ubicaci&oacute;n de la empresa </a></li>
            <li><a <?php ( $_SESSION["menuactive"] == 'patient-register-list' )?print('class="actSmn2"'):print(""); ?> href="<?=$domain?>/modcose/acap2.php">Personal ocupado, sueldos y salarios </a></li>
            <li><a  href="<?=$domain?>/modcose/acap3.php">Suministros</a></li>
            
            <li><a  href="<?=$domain?>/modcose/acap4.php">Inventario de materiales</a></li>
            
            <li><a  href="<?=$domain?>/modcose/acap5.php">Otros gastos operativos</a></li>
            
            <li><a  href="<?=$domain?>/modcose/acap6.php">Compra de mercader&iacute;as para reventa (exclusivo para la actividad de comercio)</a></li>
            
            <li><a  href="<?=$domain?>/modcose/acap7.php">Venta de mercader&iacute;as o servicios</a></li>
            
            <li><a  href="<?=$domain?>/modcose/acap8.php">Resultado de la gesti&oacute;n</a></li>
                        
            <li><a  href="<?=$domain?>/modcose/acap9.php">Formaci&oacute;n de activos fijos</a></li>
                        
            <li><a  href="<?=$domain?>/modcose/acap10.php">Capital y patrimonio </a></li>
            
            <li><a  href="<?=$domain?>/modcose/bcap1.php">Gesti&oacute;n ambiental </a></li>
            
            <li><a  href="<?=$domain?>/modcose/bcap2.php">Sistemas de gesti&oacute;n certificados</a></li>
            
            <li><a  href="<?=$domain?>/modcose/bcap3.php">Responsabilidad social empresarial </a></li>
            
            <li><a href="<?=$domain?>/modcose/ccap1.php">Uso y acceso de las tecnolog&iacute;as de la informaci&oacute;n y comunicaci&oacute;n (TIC) </a></li>
            </ul>
        </li>
        
    </ul>
    <?php } ?>  
</div>
</div>

</body>
</html>