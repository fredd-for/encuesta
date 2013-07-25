<?php session_start(); header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php');
$dat = array();
$desc = array();

$dat[68] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("rbtn_inversion")),'Text'); //gastos o inversión

$dat[69] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("chk_1")),'Text');
$dat[70] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("chk_2")),'Text');
$dat[71] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("chk_3")),'Text'); //otros
// descripcion
$desc[71] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("inversionotros")),'Text');

if( $dat[68] == 1 ) {
    $dat[69] = 0;
    $dat[70] = 0;
    $dat[71] = 0;
    $desc[71] = "";
}

if( !empty( $dat[69] ) ) { $dat[69] = 1; } // si los checks son seleccionados su estado sera 1 sino cero.
if( !empty( $dat[70] ) ) { $dat[70] = 1; }
if( !empty( $dat[71] ) ) { $dat[71] = 1; } else { $desc[71] = ""; }


$dat[72] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("rbtn_certi")),'Text'); //certificaciones
// descripcion
$desc[72] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("certiambiental")),'Text');

if ( $dat[72] == 0 ){  $desc[72] = ""; }

/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];


$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

// obtener el uid del token
$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
if( !empty($regisroUID)  ) {   

    $sql = "SELECT * FROM frm1_bcap2_gestioncertificados WHERE gece_regi_uid = '".$regisroUID."' ";
    $db->query($sql);

    //echo $sql;
    while ( $aGesAmb = $db->next_record() ) {         
        $sql  = "UPDATE frm1_bcap2_gestioncertificados SET ";
        $sql .= "gece_valor = '".$dat[$aGesAmb["gece_defi_uid"]]."', ";
        $sql .= "gece_description = UPPER('".$desc[$aGesAmb["gece_defi_uid"]]."'), ";
        $sql .= "gece_suv_uid	 = '".$uid_token."', ";
        $sql .= "gece_updatedate = NOW() ";
        $sql .= "WHERE gece_regi_uid = '".$regisroUID."' AND gece_defi_uid	 = '".$aGesAmb["gece_defi_uid"]."' ";  
        $db2->query($sql);
        //echo $sql."<br />";
    }      
    //echo $sql."<br />"; 
    
    
    $sql  = "UPDATE frm1_bcap2_gestioncertificados SET ";
    $sql .= "gece_valor = '".$dat[$aGesAmb["gece_defi_uid"]]."', ";
    $sql .= "gece_description = UPPER('".$desc[$aGesAmb["gece_defi_uid"]]."'), ";
    $sql .= "gece_suv_uid	 = '".$uid_token."', ";
    $sql .= "gece_updatedate = NOW() ";
    $sql .= "WHERE gece_regi_uid = '".$regisroUID."' AND gece_defi_uid	 = '".$aGesAmb["gece_defi_uid"]."' ";  
    $db2->query($sql);        
    
    //actualizar existentes
    $sql = "SELECT * FROM frm1_bcap2_2certificados WHERE cert_regi_uid = '".$regisroUID."' ";  
    
    //echo $sql."<br />";
    $db2->query($sql);
    $aPosition = array();
    
    if( $db2->numrows() >  0 ) {
        $pos = 0;        
        $i = 0;
        while( $aCert = $db2->next_record()  ) {
            
            $pos = $aCert["certi_position"];            
            $aPosition[$i] = $pos;
            
            // solo modificar aquellos que estan habilitados
            if( $aCert["cert_delete"] != 1 ) {
                $certA = OPERATOR::toSql(safeHTML(OPERATOR::getParam("inputA_".$pos)),'Text');
                $certB = OPERATOR::toSql(safeHTML(OPERATOR::getParam("inputB_".$pos)),'Text');
                $certC = OPERATOR::toSql(safeHTML(OPERATOR::getParam("inputC_".$pos)),'Text');

                $sql3 = " UPDATE frm1_bcap2_2certificados SET cert_certificacion = UPPER('".$certA."') , cert_ultimoanioobtencion = '".$certB."', cert_organismocertificacion = UPPER('".$certC."') "
                       ." WHERE cert_regi_uid = '".$regisroUID."' AND  certi_position = '".$pos."' ";                        
                $db3->query($sql3);
            }
            $i = $i + 1;
        }
    }
    
    //registrar nuevos
    $maxrow = OPERATOR::toSql(safeHTML(OPERATOR::getParam("maxrow")),'Number');
    for( $j = 1; $j<=$maxrow; $j++ ) {
        // si no existe registrar
        if( ! in_array($j, $aPosition) ) {
            
            $certA = OPERATOR::toSql(safeHTML(OPERATOR::getParam("inputA_".$j."")),'Text');
            $certB = OPERATOR::toSql(safeHTML(OPERATOR::getParam("inputB_".$j."")),'Text');
            $certC = OPERATOR::toSql(safeHTML(OPERATOR::getParam("inputC_".$j."")),'Text');
            
            if( !empty($certA) && !empty($certB) && !empty($certC)  ) {
                $sql3 = " INSERT INTO frm1_bcap2_2certificados( cert_regi_uid, cert_certificacion, 	cert_ultimoanioobtencion, cert_organismocertificacion, certi_position, cert_delete ) "
                       ." VALUES ( '".$regisroUID."', UPPER('".$certA."'), '".$certB."', UPPER('".$certC."'), '".$j."', 0 ) ";
                $db3->query($sql3);
            }
        }
    }                
    
}
  
if( !empty( $btnsubmit ) ) {
   header("Location: bcap3.php");
}
?>