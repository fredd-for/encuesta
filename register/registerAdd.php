<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");

$matricula = OPERATOR::toSql(safeHTML(OPERATOR::getParam("matricula")),'Text');
$sEmail = OPERATOR::toSql(safeHTML(OPERATOR::getParam("email")),'Text');
$passwd = OPERATOR::toSql(safeHTML(OPERATOR::getParam("passwd")),'Text');

$sql = "SELECT * FROM sys_users WHERE usr_login = '".$matricula."' AND usr_delete = 0 ";
$db->query( $sql );
if( $db->numrows() > 0 ) {
	$msg = 3;	//user exist
} else {
	if(  !empty($matricula) && !empty($sEmail)  && !empty($passwd) ) {
		$sql = " INSERT INTO sys_users ( usr_login, usr_pass, usr_email, usr_status, usr_delete, usr_datecreate, usr_dateupdate ) "
			  ." VALUES ( '".$matricula."', md5('".$passwd."'), '".$sEmail."', 'INACTIVE', '0', NOW(), NOW() )";
		$db->query($sql);
		
		$db->query( "SELECT LAST_INSERT_ID() as id" );
		$aUser = $db->next_record();
		
		$new_usruid =	$aUser["id"];		
		$sToken = md5($new_usruid."-".$matricula."-".$sEmail."-tok");
		
		$sValUrl = $domain."/register.php?act=".$sToken;
		$msg = 1;
	} else {
		$msg = 2;
	}
}

if(  !empty($matricula) && !empty($sEmail)  && !empty($passwd) &&  ( $msg == 1 ) ) {
    $body  = '
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Validaci&oacute;n de cuenta</title>
    </head>

    <body>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color: #f7f7f7; padding: 40px 0;">
    <tr>
    <td align="center" valign="middle">
    <table width="700" border="0" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-bottom: 2px solid #d6d5d4;">
    <tr>
     <td align="left" valign="middle" style="padding: 20px 25px;">&nbsp;</td>
    </tr>
    <tr>
      <td style="color: #26221c; font-family: Arial, Helvetica, sans-serif; font-size:14px; line-height: 20px; text-align:justify; padding: 22px 20px;">
      <span style="color: #a00014; font-size: 20px;">Validaci&oacute;n de cuenta de usuario</span>
      <br />
      <p>Por favor valida tu cuenta haciendo click en el siguiente enlace:</p>
       <p><span style="font-weight: 700;"><a href="'.$sValUrl.'" target="_blank">'.$sValUrl.'</a></span></p>
       <p>Si no puedes hacer click, copia  el enlace en la barra de direcci&oacute;n de tu navegador.</p>
     <p>Una vez realizado el paso anterior, tu cuenta ya estar&aacute; habilitada.
      <br />
      <br />
     </p></td>
    </tr>  
    </table>
    </td>
    </tr>
    </table>

    </body>
    </html>
    ';

    //echo $body;
    // Plain text body (for mail clients that cannot read HTML)
    $text_body = "Por favor valida tu cuenta haciendo click en el siguiente enlace: "
              ."Si no puedes hacer click, copia  el enlace en la barra de dirección de tu navegador. ".$sValUrl." "
              ."Una vez realizado el paso anterior, tu cuenta ya estará habilitada. ";
  
    //SMTP needs accurate times, and the PHP time zone MUST be set
    //This should be done in your php.ini, but this is how to do it if you don't have access to that
    date_default_timezone_set('Etc/UTC');

    require '../phpmailer/class.phpmailer.php';

    //Create a new PHPMailer instance
    $mail = new PHPMailer();
    //Tell PHPMailer to use SMTP
    $mail->IsSMTP();
    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug  = 0;
    //Ask for HTML-friendly debug output
    $mail->Debugoutput = 'html';
    //Set the hostname of the mail server
    $mail->Host  = 'correo.produccion.gob.bo';

    //$mail->Port       = 465;
    $mail->Port  = 587;
    $mail->SMTPSecure = 'tls';


    //Whether to use SMTP authentication
    $mail->SMTPAuth   = true;
    //Username to use for SMTP authentication - use full email address for gmail
    $mail->Username   = "encuesta.produccion@produccion.gob.bo";
    //Password to use for SMTP authentication
    $mail->Password   = "sistemas";
    //Set who the message is to be sent from
    $mail->SetFrom('encuesta.produccion@produccion.gob.bo', 'Encuesta');
        //Set an alternative reply-to address
        //$mail->AddReplyTo('replyto@example.com','First Last');
    //Set who the message is to be sent to
    $mail->AddAddress( $sEmail , 'Usuario');
    //Set the subject line
    $mail->Subject = 'Validacion de cuenta';
    //Read an HTML message body from an external file, convert referenced images to embedded, convert HTML into a basic plain-text alternative body
    //$mail->MsgHTML(file_get_contents('contents.html'), dirname(__FILE__));
    $mail->MsgHTML($body);
    //Replace the plain text body with one created manually
    //$mail->AltBody = 'This is a plain-text message body'; $text_body
    
    $mail->AltBody = $text_body;
    //Attach an image file
    //$mail->AddAttachment('images/phpmailer_mini.gif');

    //Send the message, check for errors
    if (!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
        $msg = "Error sending the message.";
        $msg = 5;
    } else {
        //echo "Message sent!";
        $msg = "Mensaje enviado correctamente.";
        $msg = 4;
    }
/*--------------------------------------------------------------------------------------------------*/
  
} else {
    $msg = "Todos los datos son requeridos.";
    $msg = 2;
}
unset($_POST);	
header("Location: registerNew.php?msg=".$msg);
?>