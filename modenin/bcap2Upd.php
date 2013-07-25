<?php session_start(); header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php');
$dat = array();
$desc = array();


$dat[233] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("rbtn_inv")),'Number');

$chk_1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("chk_1")),'Text'); 
$chk_2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("chk_2")),'Text'); 
$chk_3 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("chk_3")),'Text'); 

if( $chk_1 == 'on' ) { $chk_1 = 1; } else { $chk_1 = 0; }
if( $chk_2 == 'on' ) { $chk_2 = 1; } else { $chk_2 = 0; }
if( $chk_3 == 'on' ) { $chk_3 = 1; } else { $chk_3 = 0; }

$dat[234] =  $chk_1;
$dat[235] =  $chk_2;
$dat[236] =  $chk_3;

$desc[236] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("inversionotros")),'Text');
if( $chk_3 == 0 ) {
    $desc[236] = "";
}



$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A1")),'Text');  // 1
$a2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A2")),'Text');  // 2
$a3 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A3")),'Text');  // 3
$a4 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A4")),'Text');  // 4
$a5 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A5")),'Text');  // 5
$a6 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A6")),'Text');  // 6
$a7 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A7")),'Text');  // 7

if( $dat[233] == 0  ) {
    $a1 = "";
    $a2 = "";
    $a3 = "";
    $a4 = "";
    $a5 = "";
    $a6 = "";
    $a7 = "";
} else {
    $dat[234] =  0;
    $dat[235] =  0;
    $dat[236] =  0;
}

$desc[237] = $a1;
$desc[238] = $a2;
$desc[239] = $a3;
$desc[240] = $a4;
$desc[241] = $a5;
$desc[242] = $a6;
$desc[243] = $a7;

$dat[244] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("rbtn_gastos")),'Number');  // 1

/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];


$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

// obtener el uid del token
$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
if( !empty($regisroUID)  ) { 

    $sql = "SELECT * FROM frm2_bcap2_sistemagestion WHERE sige_regi_uid = '".$regisroUID."' ";
    $db->query($sql);

    //echo $sql;
    while ( $aGesAmb = $db->next_record() ) {         
        $sql  = "UPDATE frm2_bcap2_sistemagestion SET ";
        $sql .= "sige_valor = '".$dat[$aGesAmb["sige_defi_uid"]]."', ";
        $sql .= "sige_description = UPPER('".utf8_decode($desc[$aGesAmb["sige_defi_uid"]])."'), ";
        $sql .= "sige_suv_uid	 = '".$uid_token."', ";
        $sql .= "sige_updatedate = NOW() ";
        $sql .= "WHERE sige_regi_uid = '".$regisroUID."' AND sige_defi_uid	 = '".$aGesAmb["sige_defi_uid"]."' ";  
        $db2->query($sql);        
    }
    
    
    
    if( !empty($regisroUID) && !empty($uidFormulario) && $dat[244] == 1 ) {        
    
    //actualizar existentes
    $sql = "SELECT * FROM frm2_bcap2_productos WHERE prod_regi_uid = '".$regisroUID."' AND prod_position <> 0 ";          
    $db2->query($sql);
    $aPosition = array();
    
    if( $db2->numrows() >  0 ) {
        $pos = 0;        
        $i = 0;
        while( $aCert = $db2->next_record()  ) {
            
            $pos = $aCert["prod_position"];            
            $aPosition[$i] = $pos;
            
            // solo modificar aquellos que estan habilitados
            if( $aCert["prod_delete"] != 1 ) {
                $desc = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B1_".$pos)),'Text');                                
                if( !empty($desc) ) {
                $sql  = "UPDATE frm2_bcap2_productos SET ";                     
                $sql .= "prod_description	 = UPPER('".utf8_decode($desc)."'), ";                      
                $sql .= "prod_suv_uid = '".$uid_token."', ";
                $sql .= "prod_updatedate = NOW() ";
                $sql .= " WHERE prod_regi_uid = '".$regisroUID."' AND  prod_position = '".$pos."' ";         
                $db3->query($sql);
                               
                } else {
                    $sql  = "UPDATE frm2_bcap2_productos SET ";
                    $sql .= "prod_description = '', ";                                  
                    $sql .= "prod_suv_uid = '".$uid_token."', ";
                    $sql .= "prod_updatedate = NOW() ";
                    $sql .= " WHERE prod_regi_uid = '".$regisroUID."' AND  prod_position = '".$pos."' ";         
                    $db3->query($sql);
                }
        
            }
            $i = $i + 1;
        }
    }
    
    //registrar nuevos
    $maxrow = OPERATOR::toSql(safeHTML(OPERATOR::getParam("maxrow")),'Number');
    
    for( $pos = 1; $pos<=$maxrow; $pos++ ) {
        // si no existe registrar        
        if( !in_array($pos, $aPosition) ) {                      
            
            $desc = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B1_".$pos)),'Text');       
                
            if( !empty($desc) ) {                           
                $sql  = "INSERT frm2_bcap2_productos SET ";
                $sql .= "prod_regi_uid = '".$regisroUID."', ";
                $sql .= "prod_position = '".$pos."', ";
                $sql .= "prod_description = UPPER('".utf8_decode($desc)."'), ";                                      
                $sql .= "prod_suv_uid = '".$uid_token."', ";
                $sql .= "prod_createdate = NOW(), ";
                $sql .= "prod_updatedate = NOW(), ";
                $sql .= "prod_delete = 0 ";                         
                $db3->query($sql);
            } 
        }
    }              
    //echo $sql;    
    } else {
        
        $sql  = "UPDATE frm2_bcap2_productos SET ";
        $sql .= "prod_description = '', ";                                  
        $sql .= "prod_suv_uid = '".$uid_token."', ";
        $sql .= "prod_updatedate = NOW(), ";
        $sql .= "prod_delete = 1 ";
        $sql .= " WHERE prod_regi_uid = '".$regisroUID."' ";         
        $db3->query($sql);
    }
    
}
?>