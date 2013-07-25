<?php
require_once("lib/nusoap.php");
class JaxWsSoapClient extends SoapClient
	{
    public function __call($method, $arguments){
    $response = parent::__call($method, $arguments);
    return $response->return;
  	}
	}
function wsSms( $user, $webservice)
{
//echo "usr:".$user;."  ebservice: $webservice";
 //echo "usr:".$user;
 ini_set('soap.wsdl_cache_enabled',0);
 ini_set('soap.wsdl_cache_ttl',0);
try {
 
 $client       = new JaxWsSoapClient($webservice);
// $arr   = array(	'codigo'=>(string)$user);
 //$result = $client->Consulta01(array("parameters" => array("codigo" => $user)));
 //$result = $client->Consulta01(array("codigo" => "'".$user."'"));
 $result = $client->SrvMatricula(array("idContrato" => '01boletas2013',"keyContrato" => 'cvok)vdh>/e6~c&', "IdMatricula" => $user));
 //$result = $client->Consulta01(array("parameters" => array("codigo" => $user)));
  //echo"<br/>Dumping request headers:<br/>".$client->__getLastRequestHeaders();
  //echo("<br/>Dumping request:<br/>".$client->__getLastRequest());
  //echo("<br/>Dumping response headers:<br/>".$client->__getLastResponseHeaders());
  //echo("<br/>Dumping response:<br/>".$client->__getLastResponse());
 // echo("<br/>Returning value of __soapCall() call: ");
  //var_dump($result->resultDataMap);
}catch(SoapFault $exception)
{
        print_r("Got issue:<br/>") ;
  print_r($exception->getMessage());
}
/*try{
	$client = new soapclient($webservice);
	$arr   = array(	'codigo'=>(string)$user,
					'pass'=>(string)$pass,
					'msisdn' =>(string)$msisdn,
					'msg' => (string)$msg);
	print_r($arr);
	$result = $client->__call('Consulta01', $arr);
}
catch(Exception $e) {
		echo "Exception: " . $e->getMessage();
}	*/
return $result; 
}
?>