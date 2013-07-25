<?PHP
set_time_limit (0);
ini_set("memory_limit","1999M");
require_once('test2.php');
$cadenauno=$_GET['matricula'];
$cadenados=$_GET['ifhfrnfvcsddsrs'];
$cadenatres=$_GET['boleta'];
echo "iniciando:".$cadenauno;
if($cadenados=='r34lm3nt3qu13r35v3r3lr3sultado'){
$resultado = wsSms($cadenauno,'http://200.105.134.19:10080/wsInfoBoletas/servdata.asmx?WSDL',$cadenatres);
print_r($resultado);
echo "y:".$resultado['RegistraBoletaResult']['regBoleta']['CtrResult'];
echo "<br/>...";
}

?>