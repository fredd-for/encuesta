<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");

include_once("../phpmailer/class.phpmailer.php");
include_once("../phpmailer/config.php");
$matricula = OPERATOR::toSql(safeHTML(OPERATOR::getParam("matricula")),'Text');
$sEmail = OPERATOR::toSql(safeHTML(OPERATOR::getParam("email")),'Text');
$passwd = OPERATOR::toSql(safeHTML(OPERATOR::getParam("passwd")),'Text');

if(  !empty($matricula) && !empty($sEmail)  && !empty($passwd) ) {
	
	$mail = new PHPMailer();
	
    try {
		echo MAILSERVER;
	  $mail->Host     = MAILSERVER;
	  $mail->Mailer   = MAILTYPE;
	
	  $mail->Subject = 'PHPMailer Test Subject via mail(), advanced';
	  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
	 
	  $mail->Send();
	} catch (phpmailerException $e) {
	  echo $e->errorMessage(); //Pretty error messages from PHPMailer
	} catch (Exception $e) {
	  echo $e->getMessage(); //Boring error messages from anything else!
	}
  
} else {
    $msg = "Todos los datos son requeridos.";
	$msg = 2;
}
//unset($_POST);	



//header("Location: registerNew.php?msg=".$msg);
?>