<?php
include_once("connection/database/connection.php");
include_once("connection/core/operator.php");

$matricula = OPERATOR::toSql( safeHTML(OPERATOR::getParam("matric")), "Number");
$email = OPERATOR::toSql( safeHTML(OPERATOR::getParam("email")), "Text" );
$passwd = OPERATOR::toSql( safeHTML(OPERATOR::getParam("passwd")), "Text" );

$path_parts = pathinfo($_SERVER['HTTP_REFERER']);
$referer = $path_parts['dirname'].'//'.$path_parts['basename'];

$dom1 = parse_url($referer) ;
$dom2 = parse_url($domain) ;

function checkEmpty($var) {
    if (strlen($var) >= 1) {
        return false; 
    } else {
        return true;
    }
}

if ( isset($matricula) && isset($email) && isset($passwd)) {
    if ( $dom1["host"] == $dom2["host"] ) {
        
        

        $validMatricula = array('options' => array('regexp' => "/^[0-9]{3,8}$/")); // matricula valida longitud entre 3 y 8 
        $validPass = array('options' => array('regexp' => "/^[a-zA-Z0-9+бйнуъAЙНУЪСслпьяв\\кофыз*.,;:)(є_@><#&їЎ!=|?%$'\-\/\"]*$/")); // Pasword valido
        
     
       $matricula= filter_var($matricula, FILTER_VALIDATE_REGEXP, $validMatricula);
       $email = filter_var($email, FILTER_SANITIZE_EMAIL);
       $passwd = filter_var($passwd, FILTER_VALIDATE_REGEXP, $validPass);
                                              
        if ( isset($matricula) && isset($email) && isset($passwd) ) {                                  
            
            $sql2 = "SELECT * FROM sys_users WHERE usr_login LIKE '" . $matricula . "' AND  usr_pass = md5('" . $passwd . "') AND usr_email = '" . $email . "' AND usr_status = 'ACTIVE' AND usr_delete = 0 ";
            $db->query( $sql2 );
            $numfiles = $db->numrows();
            
            if ($numfiles == 0) {
                header('Location: index.php?message=1');
            } else {
                $datos = $db->next_record();
                session_set_cookie_params(100 * 100);
                @session_start();
                $_SESSION[SITE]["authenticated"] = true;
                $_SESSION[SITE]["usr_uid"] = $datos["usr_uid"];
                $_SESSION[SITE]["usr_login"] = $datos["usr_login"];
                $_SESSION[SITE]["usr_email"] = $datos["usr_email"];
                $_SESSION[SITE]["uidtipoformulario"] = $datos["usr_form_uid"];
                
                $frmxgestion=OPERATOR::getDbValue("select gest_uid from adm_gestion where gest_sw_active='1'");
                
                $db2->query("select regi_uid, regi_swmodifica_uid from sys_registros where regi_user_uid='".$datos["usr_uid"]."' and regi_gest_uid=".$frmxgestion);
                $aReg = $db2->next_record();
                $frmxregisuid = $aReg["regi_uid"];
                $frmstate = $aReg["regi_swmodifica_uid"];
                $_SESSION[SITE]["val_regi_swmodifica_uid"] = $frmstate;
                
                $_SESSION[SITE]["registro_uid"]=$frmxregisuid;
								
                $tokenFront = sha1(PREFIX . uniqid(rand(), TRUE));
                $_SESSION[SITE]["TOKEN_FRONT"] = $tokenFront;

                $sSQL = "update sys_users_verify set suv_status=1 where suv_cli_uid='" . $datos["usr_uid"] . "'";
                $db->query($sSQL); 

                $sSQL = "insert into sys_users_verify values (null," . $datos["usr_uid"] . ",'" . $tokenFront . "',now(),'" . $_SERVER['REMOTE_ADDR'] . "',0,'" . $_SERVER['HTTP_USER_AGENT'] . "')";
                $db->query($sSQL);
                
                if( !checkEmpty($frmstate) && $frmstate == 0  ) {                    
                    switch( $_SESSION[SITE]["uidtipoformulario"] ) {
                        case 1: header('Location: modcose/bol.php'); break;
                        case 2: header('Location: modenin/bol.php'); break;
                        case 3: header('Location: modagin/bol.php'); break;
                    }                    
                } else {
                    header('Location: option.php');		                
                }
            }
        } else {
            $message = OPERATOR::toSql(safeHTML(OPERATOR::getParam("message")), 'Number') + 1;
            header('Location: index.php?message=1');
            
        }
    } else {
        $message = OPERATOR::toSql(safeHTML(OPERATOR::getParam("message")), 'Number') + 1;
        header('Location: index.php?message=1');
    }
} else {
    $message = OPERATOR::toSql(safeHTML(OPERATOR::getParam("message")), 'Number') + 1;
    header('Location: index.php?message=1');
}

?>