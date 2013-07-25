<?PHP
set_time_limit (0);
ini_set("memory_limit","1999M");
require_once('test2.php');
$cadenauno="1190";
echo "iniciando:".$cadenauno;
$resultado = wsSms($cadenauno,'http://200.105.134.19:10080/wsInfoBoletas/servdata.asmx?WSDL');
print_r($resultado);
echo "y:".$resultado['SrvMatriculaResult']['DtMatriculados']['CtrResult'];
echo "<br/>...";

if($resultado['SrvMatriculaResult']['DtMatriculados']['CtrResult']!='D-EXIST'){
	echo "Lo sentimos no existe un número de matricula válido registrado";  //mandar mail a email
} else {
	echo "form valid";
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
	
	echo "valores: typeencuesta:$typeencuesta razonsoc:$razonsoc tiposocie:$tiposocie";
$elquery="UPDATE encuestas.cap1_informacion_general SET inge_razonsocial = '".$razonsoc."', 
`inge_nombrecomercial` = 'NOMBRE COMERCIAL a',
`inge_nit` = '2001',
`inge_matriculadecomercio` = '0081',
`inge_muni_uid` = '1',
`inge_ciudad` = 'TARABUCOs',
`inge_zona` = 'ZONA BARRIOs',
`inge_calle` = 'CALLE AVENIDAs',
`inge_referenciacalle` = 'REFERENCIAs',
`inge_telefono` = '255-22321451',
`inge_celular` = '7055221221',
`inge_fax` = '231',
`inge_email` = 'testx@gmail.com',
`inge_actividad_principal` = 'PRINCIPALz',
`inge_actividad_secundaria1` = 'SECUNDARIA 1z',
`inge_actividad_secundaria2` = 'SECUNDARIA 2z' WHERE `cap1_informacion_general`.`inge_uid` =2;";
	
}

?>