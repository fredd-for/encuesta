<?php
include_once("../simple99/database/connection.php");
include_once("../simple99/core/simple99.php");

$ct_name = SIMPLE99::toSql(safeHTML(SIMPLE99::getParam("ct_name")),'String');
$ct_mail = SIMPLE99::toSql(safeHTML(SIMPLE99::getParam("ct_mail")),'String');
$ct_city = SIMPLE99::toSql(safeHTML(SIMPLE99::getParam("ct_city")),'String');
$ct_query = safeHTML(SIMPLE99::getParam("ct_query"));
$ct_query = nl2br($ct_query);

//echo $ct_name.' '.$ct_mail.' '.ct_phone.' '.ct_query;

$ct_query = nl2br(SIMPLE99::toSql(SIMPLE99::getParam("ct_query"),'String'));
$ct_query = str_replace("\n","<br />",$ct_query);
$ct_query = str_replace('\n','<br />',$ct_query);
$ct_query = str_replace("\r","",$ct_query);
$ct_query = str_replace('\r','',$ct_query);
$ct_query = str_replace("\\","",$ct_query);
$ct_query = str_replace('\\','',$ct_query);

if ($ct_name!="" && $ct_mail!="" && $ct_query!="") {
	$ct_nameto = utf8_decode("Ministerio");
	$ct_mailto = $ct_mail;
	include_once("../phpmailer/class.phpmailer.php");
	include_once("../phpmailer/config.php");		
	$mail = new PHPMailer();
	$mail->From     = $ct_mailto;
	$mail->FromName = $ct_name;
	$mail->Host     = MAILSERVER;
	$mail->Mailer   = MAILTYPE;
	$mail->Subject  = utf8_decode("Contacto - formulario");

$body  = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Contacto - Nueva Cr&oacute;nica</title>
</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color: #f7f7f7; padding: 40px 0;">
    <tr>
        <td align="center" valign="middle">
            <table width="700" border="0" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-bottom: 2px solid #d6d5d4;">
            <tr>
                <td align="left" valign="middle" style="padding: 20px 25px;"><img src="'.$domain.'/lib/logo_s.png" alt="Nueva Cr&oacute;nica" width="261" height="46" title="Nueva Cr&oacute;nica" /></td>
            </tr>
            <tr>
                <td style="color: #26221c; font-family: Arial, Helvetica, sans-serif; font-size:14px; line-height: 20px; text-align:justify; padding: 22px 20px;">
                    <span style="color: #a00014; font-size: 20px;">Contacto Nueva Cr&oacute;nica</span>
                    <br />
                    <p><span style="font-weight: 700;">'.$ct_name.'</span>  quiere contactarse con <span style="font-weight: 700;"> Nueva Cr&oacute;nica </span> enviando la siguiente informaci&oacute;n:</p>
                    <p><span style="color: #a00014; font-weight: 700;">Nombre:</span> '.$ct_name.'</p>
                    <p><span style="color: #a00014; font-weight: 700;">Correo:</span> '.$ct_mail.'</p>
                    <p><span style="color: #a00014; font-weight: 700;">Ciudad:</span> '.$ct_city.'</p>                    
                    <p><span style="color: #a00014; font-weight: 700;">Consulta:</span>'.$ct_query.'</p>
                    <br />
                    <br />
                </td>
            </tr>  
            </table>
        </td>
    </tr>
</table>

</body>
</html>
';
	// Plain text body (for mail clients that cannot read HTML)
	$text_body  = $ct_name . ' quiere contactarse con Nueva Cr&oacute;nica enviando la siguiente informaci&oacute;n:
	Nombre		: ' . $ct_name . '
	Email		: ' . $ct_mail . '
	Ciudad	: ' . $ct_city . '
	Mensaje	: ' . $ct_query;
	
	$mail->Body    = $body;
	$mail->AltBody = $text_body; 
	
	
if (!$mail->Send())
    $msg = "Error sending the message.";
else {
    if ($lang == 'es')
        $msg = "Su mensaje se envi&oacute; correctamente.";
    else
        $msg = "Your message was successfully sent.";
}
	// Clear all addresses and attachments for next loop
	$mail->ClearAddresses();
	//$mail->ClearAttachments();	
} else {
    $msg = "Todos los datos son requeridos.";
}
unset($_POST);	

$_SESSION["MSG"]=$msg;

$urlBack = SIMPLE99::getDBValue('select col_url from mdl_contents_languages where col_status="ACTIVE" AND col_language="'.$lang.'" and col_con_uid=8');

if($lang=='en')
	header('Location: '.$domain.'/en/'.$urlBack.'/');	
else
	header('Location: '.$domain.'/'.$urlBack.'/');	

?>