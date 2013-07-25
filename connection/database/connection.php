<?php
class DBmysql {

private $debug;
private $row;

			var $BaseDatos;
			var $Servidor;
			var $Usuario;
			var $Clave;
			var $Conexion_ID = 0;
			var $Consulta_ID = 0;
			var $Errno = 0;
			var $Error = "";

			function __construct($db=DATABASE, $host=DBHOST, $user=DBUSER, $pass=DBPASSWORD) {
			$this->BaseDatos = $db;
			$this->Servidor = $host;
			$this->Usuario = $user;
			$this->Clave = $pass;	
			$this->connect($db,$host,$user,$pass);
	}

function connect($db="", $host="", $user="", $pass="")
	{
	if ($db != "") $this->BaseDatos = $db;
	if ($host != "") $this->Servidor = $host;
	if ($user != "") $this->Usuario = $user;
	if ($pass != "") $this->Clave = $pass;
	$this->Conexion_ID = mysql_connect($this->Servidor, $this->Usuario, $this->Clave);

if (!$this->Conexion_ID) 
		{
		$this->Error = "Ha fallado la conexion.";
		return 0;
		}	

if (!@mysql_select_db($this->BaseDatos, $this->Conexion_ID)) {
		$this->Error = "Imposible abrir ".$this->BaseDatos ;
		
		return 0;
		}
	return $this->Conexion_ID;
	}
 
/**
 * Initialize debbuger
 *
 * @param boolean $debug
 */
function debug($debug=true){
   $this->debug=$debug; 
}

function saveErrorLog($sql){
    if(count($_POST)){  
		foreach($_POST as $index=>$value ){
			if($index!='contrasena')
			$postvars .= $index.'='.substr($value,0,255).' | ';
		}
		$postvars = "
	err_postvars=".$postvars;
	}
	if(count($_GET)){  
		foreach($_GET as $index=>$value ){
			$getvars .= $index.'='.$value.' | ';
		}
		$getvars = "
	err_getvars=".$getvars;
	}
$err = "
	err nro=".mysql_errno()."
	mysql error=".mysql_error()."
	mysql=".$sql."
	err_ip=".$_SERVER['REMOTE_ADDR']."
	err_computername=".$_ENV['COMPUTERNAME']."
	err_http_referer=".$_SERVER['HTTP_REFERER']."
	err_http_user_agent=".$_SERVER['HTTP_USER_AGENT']."
	err_language=".$_SESSION[SITE]['LANG'].$postvars.$getvars;
	if(isset($_SESSION[SITE]["authenticated"])){
		$err .= ",
	err_authenticated=".$_SESSION[SITE]["authenticated"]."
	err_user_fullname=".$_SESSION[SITE]["usr_firstname"]." ".$_SESSION[SITE]["usr_lastname"];
	}

 //$log = new logging();  
	//$log->lwrite($err);
	//die;
	//header('Location: '.PATH_DOMAIN);	
}

/**
 * Show error on screen
 *
 * @param string $sql
 */

 function showError($sql){
	$error="";
   if(DEBUG===true){ 
        	$error = array('Sesiones'=>$_SESSION,'Post'=>$_POST,'Get'=>$_GET,'Error '.mysql_errno()=>mysql_error(),'query'=>$sql);
   }
   else{
   	    if($this->debug){
	    	$error = array('Sesiones'=>$_SESSION,'Error '=>mysql_errno(),'Detalle'=>mysql_error(),'query'=>$sql);
   	    }
   	    /*else{
			$this->saveErrorLog($sql);
			$error = array('Error mysql'=>mysql_errno());
		} */
		$this->debug(false);
   }
   if($error)  print_r($error);
   if(SAVELOG===true) $this->saveErrorLog($sql);
}

/* Ejecuta un consulta */
function query($sql = "",$show=0){

  
		if ($show != 0)
			echo "sql=$sql";
		if ($sql == "")
			{
			$this->Error = "No ha especificado una consulta SQL";
			echo "<bn>ERROR". $this->Error;
			return 0;
			}
		//ejecutamos la consulta
  	mysql_query("SET NAMES 'utf8'");
		$this->Consulta_ID = mysql_query($sql, $this->Conexion_ID);
		if (!$this->Consulta_ID) {
			$this->Errno = mysql_errno();
			$this->Error = mysql_error();
			// comenariuo
			$this->showError($sql);
			//$this->showError($sql);
		}
//		echo "ID=".$this->Consulta_ID."::";
		return $this->Consulta_ID;
}

/* Devuelve el numero de campos de una consulta */
function numfields() {
return mysql_num_fields($this->Consulta_ID);
}
/* Devuelve el numero de registros de una consulta */
function numrows(){
return mysql_num_rows($this->Consulta_ID);
}
/* Devuelve el nombre de un campo de una consulta */
function nombrecampo($numcampo) {
return mysql_field_name($this->Consulta_ID, $numcampo);
}
/* Muestra los datos de una consulta */
function verconsulta() {
		echo "<table border=1>\n";
		// mostramos los nombres de los campos
		for ($i = 0; $i < $this->numfields(); $i++){
		echo "<td><b>".$this->nombrecampo($i)."</b></td>\n";
		}
		echo "</tr>\n";
		// mostrarmos los registros
		while ($row = mysql_fetch_row($this->Consulta_ID)) {
		echo "<tr> \n";
		for ($i = 0; $i < $this->numfields(); $i++){
		echo "<td>".$row[$i]."</td>\n";
		}
		echo "</tr>\n";
		}
}

function next_record()
	{
	//echo "MAT".mysql_fetch_array($this->Consulta_ID);
	return mysql_fetch_array($this->Consulta_ID);
	}
function libera()
	{
	mysql_free_result ($this->Consulta_ID);
	}
/*function __destruct(){
       //mysql_free_result ($this->Consulta_ID);
	  //mysql_close($this->Consulta_ID);
    }*/ 
} //fin de la Clse DBmysql
?>