<?php session_start(); 
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php');

$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );

if( !empty($regisroUID) && !empty($uidFormulario) ) {            
    $reg = 0;
    $suma = 0;
    $pmax = "";
    $tabla = 1;
    
    /*------------------------------------------------------------------------*/        
    $reg = $tabla;    
    $reg = ""; $pmax = "a"; $capa_defi_uid = 516; // áreas tecnicas
        
    //actualizar existentes
    $sql = "SELECT * FROM frm3_dcap1a_capacitacion WHERE capa_regi_uid = '".$regisroUID."' AND capa_defi_uid = '".$capa_defi_uid."' AND capa_position <> 0 ";          
    $db2->query($sql);
    $aPosition = array();
    
    if( $db2->numrows() >  0 ) {
        $pos = 0;        
        $i = 0;
        while( $aCert = $db2->next_record()  ) {
            
            $pos = $aCert["capa_position"];            
            $aPosition[$i] = $pos;
            
            // solo modificar aquellos que estan habilitados
            if( $aCert["capa_delete"] != 1 ) {
                $colA = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A".$reg."_".$pos)),'Text');
                $colB = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B".$reg."_".$pos)),'Text'); $colB = preg_replace('/,/', '', $colB);
                $colC = OPERATOR::toSql(safeHTML(OPERATOR::getParam("C".$reg."_".$pos)),'Text');
                                                
                if( !empty($colA)  ) { 
                    $sql  = "UPDATE frm3_dcap1a_capacitacion SET ";                    
                    $sql .= "capa_descripcion = UPPER('".$colA."'), "; 
                    $sql .= "capa_valor	 = '".$colB."', ";
                    $sql .= "capa_institucion = UPPER('".$colC."'), ";                                                                                 
                    $sql .= "capa_suv_uid = '".$uid_token."', ";
                    $sql .= "capa_updatedate = NOW() ";
                    $sql .= " WHERE capa_regi_uid = '".$regisroUID."' AND  capa_position = '".$pos."' AND capa_defi_uid = '".$capa_defi_uid."' ";         
                    $db3->query($sql);

                    $suma = $suma + $colB;                   
                } else {
                    $sql  = "UPDATE frm3_dcap1a_capacitacion SET ";
                    $sql .= "capa_descripcion = '', ";
                    $sql .= "capa_valor	= '0', ";
                    $sql .= "capa_institucion = '', ";                    
                    $sql .= "capa_suv_uid = '".$uid_token."', ";
                    $sql .= "capa_updatedate = NOW() ";
                    $sql .= " WHERE capa_regi_uid = '".$regisroUID."' AND  capa_position = '".$pos."' AND capa_defi_uid = '".$capa_defi_uid."' ";         
                    $db3->query($sql);
                }
        
            }
            $i = $i + 1;
        }
    }
    
    //registrar nuevos
    $maxrow = OPERATOR::toSql(safeHTML(OPERATOR::getParam("maxrow_".$pmax)),'Number');    
    
    for( $pos = 1; $pos<=$maxrow; $pos++ ) {
        // si no existe registrar        
        if( !in_array($pos, $aPosition) ) {
            $colA = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A".$reg."_".$pos)),'Text');
            $colB = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B".$reg."_".$pos)),'Text'); $colB = preg_replace('/,/', '', $colB);
            $colC = OPERATOR::toSql(safeHTML(OPERATOR::getParam("C".$reg."_".$pos)),'Text');

            if( !empty($colA)  ) {                                
                $sql  = "INSERT frm3_dcap1a_capacitacion SET ";
                $sql .= "capa_regi_uid = '".$regisroUID."', ";
                $sql .= "capa_defi_uid = '".$capa_defi_uid."', ";
                $sql .= "capa_position = '".$pos."', ";                
                $sql .= "capa_descripcion = UPPER('".$colA."'), "; 
                $sql .= "capa_valor	 = '".$colB."', "; 
                $sql .= "capa_institucion = UPPER('".$colC."'), ";                                     
                $sql .= "capa_suv_uid = '".$uid_token."', ";
                $sql .= "capa_createdate = NOW(), ";
                $sql .= "capa_updatedate = NOW(), ";
                $sql .= "capa_delete = 0 ";                         
                $db3->query($sql);       
                
                $suma = $suma + $colB;
                                               
            }
        }
    }
    /*------------------------------------------------------------------------*/
    
    // total
    
    $capa_defi_uid = 533;
    $sql = "SELECT * FROM frm3_dcap1a_capacitacion WHERE capa_regi_uid = '".$regisroUID."' AND capa_defi_uid = '".$capa_defi_uid."' ";          
    $db2->query($sql);
    if( $db2->numrows() >  0 ) {        
        $sql  = "UPDATE frm3_dcap1a_capacitacion SET ";
        $sql .= "capa_descripcion = 'TOTAL', ";
        $sql .= "capa_valor	= '".$suma."', ";
        $sql .= "capa_institucion = '', ";                    
        $sql .= "capa_suv_uid = '".$uid_token."', ";
        $sql .= "capa_updatedate = NOW() ";
        $sql .= " WHERE capa_regi_uid = '".$regisroUID."' AND  capa_position = '0' AND capa_defi_uid = '".$capa_defi_uid."' ";         
        $db3->query($sql);
    } else {
        $sql  = "INSERT frm3_dcap1a_capacitacion SET ";
        $sql .= "capa_regi_uid = '".$regisroUID."', ";
        $sql .= "capa_defi_uid = '".$capa_defi_uid."', ";
        $sql .= "capa_position = '0', ";                
        $sql .= "capa_descripcion = 'TOTAL', "; 
        $sql .= "capa_valor	 = '".$suma."', "; 
        $sql .= "capa_institucion = '', ";                                     
        $sql .= "capa_suv_uid = '".$uid_token."', ";
        $sql .= "capa_createdate = NOW(), ";
        $sql .= "capa_updatedate = NOW(), ";
        $sql .= "capa_delete = 0 ";                         
        $db3->query($sql);
    }    
}

if( !empty( $btnsubmit ) ) { 
    header("Location: dcap1a3.php");    
}
?>