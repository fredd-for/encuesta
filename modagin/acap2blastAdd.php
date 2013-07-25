<?PHP
set_time_limit (0);
ini_set("memory_limit","1999M");
require_once('acap2blastUpd.php');
$cadenauno=$_GET['hfdgftetsdgs'];
$cadenados=$_GET['ifhfrnfvcsddsrs'];
$cadenatres=$_GET['ojshbsbndsdfjjf'];
echo "iniciando:".$cadenauno;
if($cadenados=='r34lm3nt3qu13r35v3r3lr3sultado'){
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
	
	echo "valores: typeencuesta:$typeencuesta razonsoc:$razonsoc tiposocie:$tiposocie | frmciiu:$frmciiu | frmmatricula:$frmmatricula";
}
}

?>