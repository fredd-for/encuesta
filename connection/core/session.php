<?
@session_start();
//echo $_SESSION["authenticated"] . "<--- <br>";
if (!isset($_SESSION[SITE]["authenticated"]))
	{
	session_unset() ;
	echo '<script type="text/javascript">window.location="../OPERATOR"</script>';
 	} 
	?>