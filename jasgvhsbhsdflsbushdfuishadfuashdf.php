<?php
include('nusoap/lib/nusoap.php');
function hdjdujerhrjhgnvbdybyrg( $matricula, $webservice)
{
$proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
$proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
$proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
$proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';
$client = new nusoap_client($webservice,'wsdl', $proxyhost, $proxyport, $proxyusername, $proxypassword);
//echo $cliente.$cuenta;
$err = $client->getError();
//echo $err;
$param = array(
'idContrato' => '01boletas2013',
'keyContrato' => 'cvok)vdh>/e6~c&',
'IdMatricula' => $matricula
);
//print_r($param);
$result = $client->call('SrvMatricula', $param, '', '', true, true);
return $result; 
}
?>