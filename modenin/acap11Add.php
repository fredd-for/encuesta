<?php session_start(); header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");

include_once('../verifyLogin.php');

/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

// obtener el uid del token
$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
if( !empty($regisroUID)  ) {
            
    $activoID = array(179,180,181,182,183,184,185,186);
    
    $nro = count( $activoID );
    $s1 = 0;
    $s2 = 0;
    $s3 = 0;
    $s4 = 0;
    $s5 = 0;
    $s6 = 0;
    $s7 = 0;
    for($i=1; $i<=$nro; $i++){
        
        $in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-1".$i."")),'Text'); $dato1 = preg_replace('/,/', '', $in1);
        $in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-2".$i."")),'Text'); $dato2 = preg_replace('/,/', '', $in1);
        $in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-3".$i."")),'Text'); $dato3 = preg_replace('/,/', '', $in1);
        $in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-4".$i."")),'Text'); $dato4 = preg_replace('/,/', '', $in1);
        $in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-5".$i."")),'Text'); $dato5 = preg_replace('/,/', '', $in1);        
        $in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-7".$i."")),'Text'); $dato7 = preg_replace('/,/', '', $in1);
                
        $dato6 = $dato1 + $dato2 + $dato3 + $dato5 - $dato4;
        
        if( $i == 8 ) {
            $description = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-otro")),'Text');
            if( $dato1 == 0 && $dato2 == 0 && $dato3 == 0 && $dato4 == 0 && $dato5 == 0 && $dato7 == 0   ) {
                $description = "";
            }
        } else {
            $description = "";
        }        
        
        $s1 = $s1 + $dato1;
        $s2 = $s2 + $dato2;
        $s3 = $s3 + $dato3;
        $s4 = $s4 + $dato4;
        $s5 = $s5 + $dato5;
        $s6 = $s6 + $dato6;
        $s7 = $s7 + $dato7;
    
        $sql  = "UPDATE frm2_cap11_formacionactivos SET ";
        $sql .= "foac_saldoneto = '".$dato1."', "; 
        $sql .= "foac_fabpropia = '".$dato2."', "; 
        $sql .= "foac_compras = '".$dato3."', "; 
        $sql .= "foac_ventaretiro	 = '".$dato4."', "; 
        $sql .= "foac_ajustes = '".$dato5."', "; 
        $sql .= "foac_activofijo	 = '".$dato6."', ";        
        $sql .= "foac_depreciacion	 = '".$dato7."', ";        
        $sql .= "foac_otrosdescripcion	 = UPPER('".$description."'), ";                
        $sql .= "foac_suv_uid = '".$uid_token."', ";
        $sql .= "foac_updatedate = NOW() ";
        $sql .= "WHERE foac_regi_uid = '".$regisroUID."'  AND foac_defi_uid = '".$activoID[$i-1]."' ";         
        $db2->query($sql);
    }
    
    $sql  = "UPDATE frm2_cap11_formacionactivos SET ";
    $sql .= "foac_saldoneto = '".$s1."', "; 
    $sql .= "foac_fabpropia = '".$s2."', "; 
    $sql .= "foac_compras = '".$s3."', "; 
    $sql .= "foac_ventaretiro	 = '".$s4."', "; 
    $sql .= "foac_ajustes = '".$s5."', "; 
    $sql .= "foac_activofijo	 = '".$s6."', ";        
    $sql .= "foac_depreciacion	 = '".$s7."', ";        
    $sql .= "foac_otrosdescripcion	 = '', ";                
    $sql .= "foac_suv_uid = '".$uid_token."', ";
    $sql .= "foac_updatedate = NOW() ";
    $sql .= "WHERE foac_regi_uid = '".$regisroUID."' AND foac_defi_uid = '187' ";         
    $db2->query($sql);
    
}
if( !empty( $btnsubmit ) ) {
    header("Location: acap12.php");
}
?>