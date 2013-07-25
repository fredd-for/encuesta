<?php session_start(); header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php');

$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];
$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');
 

if( !empty($regisroUID) && !empty($uidFormulario) ) {
    //actualizar existentes
    $sql = "SELECT * FROM frm1_plantas WHERE plan_regi_uid = '".$regisroUID."' ";          
    $db2->query($sql);
    $aPosition = array();
    
    if( $db2->numrows() >  0 ) {
        $pos = 0;        
        $i = 0;
        while( $aCert = $db2->next_record()  ) {
            
            $pos = $aCert["plan_position"];            
            $aPosition[$i] = $pos;
            
            // solo modificar aquellos que estan habilitados
            if( $aCert["plan_delete"] != 1 ) {
                $certA = OPERATOR::toSql(safeHTML(OPERATOR::getParam("inputA_".$pos)),'Text');
                $certB = OPERATOR::toSql(safeHTML(OPERATOR::getParam("inputB_".$pos)),'Text');
                

                $sql3 = " UPDATE frm1_plantas SET plan_direccion = UPPER('".utf8_decode($certA)."') , plan_municipio = UPPER('".utf8_decode($certB)."') "
                       ." WHERE plan_regi_uid = '".$regisroUID."' AND  plan_position = '".$pos."' ";                        
                $db3->query($sql3);
            }
            $i = $i + 1;
        }
    }
    
    //registrar nuevos
    $maxrow = OPERATOR::toSql(safeHTML(OPERATOR::getParam("maxrow")),'Number');
    
    for( $j = 1; $j<=$maxrow; $j++ ) {
        // si no existe registrar
        if( !in_array($j, $aPosition) ) {         
            $certA = OPERATOR::toSql(safeHTML(OPERATOR::getParam("inputA_".$j."")),'Text');
            $certB = OPERATOR::toSql(safeHTML(OPERATOR::getParam("inputB_".$j."")),'Text');                        
            if( !empty($certA) && !empty($certB)  ) {
                $sql3 = " INSERT INTO frm1_plantas( plan_regi_uid, plan_direccion, plan_municipio, plan_position, plan_delete ) "
                       ." VALUES ( '".$regisroUID."', UPPER('".utf8_decode($certA)."'), UPPER('".utf8_decode($certB)."'), '".$j."', 0 ) ";
                $db3->query($sql3);                                
            }
        }
    }
}
?>