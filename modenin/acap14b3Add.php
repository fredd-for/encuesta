<?php session_start(); 
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php');

$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];


$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

$d = 0;
$e = 0;
$f = 0;
$g = 0;
$h = 0;
$ci = 0;
$j = 0;
$k = 0;

$mapr_tima_uid = 3;

if( !empty($regisroUID) && !empty($uidFormulario) ) {
    
    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    //actualizar existentes
    $sql = "SELECT * FROM frm2_cap14b_materiasprimas WHERE mapr_regi_uid = '".$regisroUID."' AND mapr_tima_uid = '".$mapr_tima_uid."' AND mapr_position <> 0 ";          
    $db2->query($sql);
    $aPosition = array();
    
    if( $db2->numrows() >  0 ) {
        $pos = 0;        
        $i = 0;
        while( $aCert = $db2->next_record()  ) {
            
            $pos = $aCert["mapr_position"];            
            $aPosition[$i] = $pos;
            
            // solo modificar aquellos que estan habilitados
            if( $aCert["mapr_delete"] != 1 ) {
                $desc = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A_".$pos)),'Text');
                $actividad = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B_".$pos)),'Text');
                $unidadmedida = OPERATOR::toSql(safeHTML(OPERATOR::getParam("C_".$pos)),'Text');
                $colD = OPERATOR::toSql(safeHTML(OPERATOR::getParam("D_".$pos)),'Text'); $colD = preg_replace('/,/', '', $colD);
                $colE = OPERATOR::toSql(safeHTML(OPERATOR::getParam("E_".$pos)),'Text'); $colE = preg_replace('/,/', '', $colE);
                $colF = OPERATOR::toSql(safeHTML(OPERATOR::getParam("F_".$pos)),'Text'); $colF = preg_replace('/,/', '', $colF);
                $colG = OPERATOR::toSql(safeHTML(OPERATOR::getParam("G_".$pos)),'Text'); $colG = preg_replace('/,/', '', $colG);
                $colH = OPERATOR::toSql(safeHTML(OPERATOR::getParam("H_".$pos)),'Text'); $colH = preg_replace('/,/', '', $colH);
                $colI = OPERATOR::toSql(safeHTML(OPERATOR::getParam("I_".$pos)),'Text'); $colI = preg_replace('/,/', '', $colI);
                $colJ = $colD + $colF - $colH; //cantidad
                $colK = $colE + $colG - $colI; //valor
                
                if( !empty($desc) && !empty($actividad)  ) {
                $sql  = "UPDATE frm2_cap14b_materiasprimas SET ";
                $sql .= "mapr_materiadesc = UPPER('".$desc."'), "; 
                $sql .= "mapr_proveedor = UPPER('".$actividad."'), "; 
                $sql .= "mapr_unidadmedida = UPPER('".$unidadmedida."'), "; 
                $sql .= "mapr_invini_cantidad	 = '".$colD."', "; 
                $sql .= "mapr_invini_valor       = '".$colE."', "; 
                $sql .= "mapr_compra_cantidad	 = '".$colF."', ";      
                $sql .= "mapr_compra_valor	 = '".$colG."', ";                
                $sql .= "mapr_util_cantidad	 = '".$colH."', ";
                $sql .= "mapr_util_valor	 = '".$colI."', ";
                $sql .= "mapr_invfin_cantidad	 = '".$colJ."', ";      
                $sql .= "mapr_invfin_valor	 = '".$colK."', ";                      
                $sql .= "mapr_suv_uid = '".$uid_token."', ";
                $sql .= "mapr_updatedate = NOW() ";
                $sql .= " WHERE mapr_regi_uid = '".$regisroUID."' AND  mapr_position = '".$pos."' AND mapr_tima_uid = '".$mapr_tima_uid."' ";         
                $db3->query($sql);
                
                $d = $d + $colD;
                $e = $e + $colE;
                $f = $f + $colF;
                $g = $g + $colG;
                $h = $h + $colH;
                $ci = $ci + $colI;
                $j = $j + $colJ;
                $k = $k + $colK;
                } else {
                    $sql  = "UPDATE frm2_cap14b_materiasprimas SET ";
                    $sql .= "mapr_materiadesc = '', "; 
                    $sql .= "mapr_proveedor = '', "; 
                    $sql .= "mapr_unidadmedida = '', "; 
                    $sql .= "mapr_invini_cantidad	= '0', "; 
                    $sql .= "mapr_invini_valor    = '0', "; 
                    $sql .= "mapr_compra_cantidad	= '0', ";      
                    $sql .= "mapr_compra_valor	   = '0', ";                
                    $sql .= "mapr_util_cantidad	  = '0', ";
                    $sql .= "mapr_util_valor	     = '0', ";
                    $sql .= "mapr_invfin_cantidad = '0', ";      
                    $sql .= "mapr_invfin_valor	   = '0', ";                      
                    $sql .= "mapr_suv_uid = '".$uid_token."', ";
                    $sql .= "mapr_updatedate = NOW() ";
                    $sql .= " WHERE mapr_regi_uid = '".$regisroUID."' AND  mapr_position = '".$pos."' AND mapr_tima_uid = '".$mapr_tima_uid."' ";         
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
            
            $desc = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A_".$pos)),'Text');
            $actividad = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B_".$pos)),'Text');
            $unidadmedida = OPERATOR::toSql(safeHTML(OPERATOR::getParam("C_".$pos)),'Text');
            $colD = OPERATOR::toSql(safeHTML(OPERATOR::getParam("D_".$pos)),'Text'); $colD = preg_replace('/,/', '', $colD);
            $colE = OPERATOR::toSql(safeHTML(OPERATOR::getParam("E_".$pos)),'Text'); $colE = preg_replace('/,/', '', $colE);
            $colF = OPERATOR::toSql(safeHTML(OPERATOR::getParam("F_".$pos)),'Text'); $colF = preg_replace('/,/', '', $colF);
            $colG = OPERATOR::toSql(safeHTML(OPERATOR::getParam("G_".$pos)),'Text'); $colG = preg_replace('/,/', '', $colG);
            $colH = OPERATOR::toSql(safeHTML(OPERATOR::getParam("H_".$pos)),'Text'); $colH = preg_replace('/,/', '', $colH);
            $colI = OPERATOR::toSql(safeHTML(OPERATOR::getParam("I_".$pos)),'Text'); $colI = preg_replace('/,/', '', $colI);
            $colJ = $colD + $colF - $colH; //cantidad
            $colK = $colE + $colG - $colI; //valor
                
            if( !empty($desc) && !empty($actividad)  ) {                           
                $sql  = "INSERT frm2_cap14b_materiasprimas SET ";
                $sql .= "mapr_regi_uid = '".$regisroUID."', ";
                $sql .= "mapr_position = '".$pos."', ";
                $sql .= "mapr_tima_uid = '".$mapr_tima_uid."', ";
                $sql .= "mapr_materiadesc = UPPER('".$desc."'), "; 
                $sql .= "mapr_proveedor = UPPER('".$actividad."'), "; 
                $sql .= "mapr_unidadmedida = UPPER('".$unidadmedida."'), "; 
                $sql .= "mapr_invini_cantidad	 = '".$colD."', "; 
                $sql .= "mapr_invini_valor       = '".$colE."', "; 
                $sql .= "mapr_compra_cantidad	 = '".$colF."', ";      
                $sql .= "mapr_compra_valor	 = '".$colG."', ";                
                $sql .= "mapr_util_cantidad	 = '".$colH."', ";
                $sql .= "mapr_util_valor	 = '".$colI."', ";
                $sql .= "mapr_invfin_cantidad	 = '".$colJ."', ";      
                $sql .= "mapr_invfin_valor	 = '".$colK."', ";                      
                $sql .= "mapr_suv_uid = '".$uid_token."', ";
                $sql .= "mapr_createdate = NOW(), ";
                $sql .= "mapr_updatedate = NOW(), ";
                $sql .= "mapr_delete = 0 ";                         
                $db3->query($sql);
                
                $d = $d + $colD;
                $e = $e + $colE;
                $f = $f + $colF;
                $g = $g + $colG;
                $h = $h + $colH;
                $ci = $ci + $colI;
                $j = $j + $colJ;
                $k = $k + $colK;
            } 
        }
    }
    
    
    // totales
    $uidtotalmateria = 6;
    $sql = "SELECT mapr_uid FROM frm2_cap14b_materiasprimas WHERE mapr_position = '0' AND mapr_tima_uid = '".$uidtotalmateria."' AND mapr_regi_uid = '".$regisroUID."' ";
    $db->query( $sql );
    
    //echo $sql."<br />";
    if( $db->numrows() > 0 ) {
        $sql  = "UPDATE frm2_cap14b_materiasprimas SET ";
        $sql .= "mapr_materiadesc = '', "; 
        $sql .= "mapr_proveedor = '', "; 
        $sql .= "mapr_unidadmedida = '', "; 
        $sql .= "mapr_invini_cantidad	= '".$d."', "; 
        $sql .= "mapr_invini_valor    = '".$e."', "; 
        $sql .= "mapr_compra_cantidad	= '".$f."', ";      
        $sql .= "mapr_compra_valor	   = '".$g."', ";                
        $sql .= "mapr_util_cantidad	  = '".$h."', ";
        $sql .= "mapr_util_valor	     = '".$ci."', ";
        $sql .= "mapr_invfin_cantidad	= '".$j."', ";      
        $sql .= "mapr_invfin_valor	   = '".$k."', ";                       
        $sql .= "mapr_suv_uid = '".$uid_token."', ";
        $sql .= "mapr_updatedate = NOW() ";
        $sql .= " WHERE mapr_regi_uid = '".$regisroUID."' AND  mapr_position = '0' AND mapr_tima_uid = '".$uidtotalmateria."' "; 
        $db3->query($sql);
    } else {
        $sql  = "INSERT frm2_cap14b_materiasprimas SET ";
        $sql .= "mapr_regi_uid = '".$regisroUID."', ";
        $sql .= "mapr_position = '0', ";
        $sql .= "mapr_tima_uid = '".$uidtotalmateria."', ";
        $sql .= "mapr_materiadesc = '', "; 
        $sql .= "mapr_proveedor = '', "; 
        $sql .= "mapr_unidadmedida = '', "; 
        $sql .= "mapr_invini_cantidad	= '".$d."', "; 
        $sql .= "mapr_invini_valor    = '".$e."', "; 
        $sql .= "mapr_compra_cantidad	= '".$f."', ";      
        $sql .= "mapr_compra_valor	   = '".$g."', ";                
        $sql .= "mapr_util_cantidad	  = '".$h."', ";
        $sql .= "mapr_util_valor	     = '".$ci."', ";
        $sql .= "mapr_invfin_cantidad	= '".$j."', ";      
        $sql .= "mapr_invfin_valor	   = '".$k."', ";                      
        $sql .= "mapr_suv_uid = '".$uid_token."', ";
        $sql .= "mapr_createdate = NOW(), ";
        $sql .= "mapr_updatedate = NOW(), ";
        $sql .= "mapr_delete = 0 ";                         
        $db3->query($sql);                
    }    
    //echo $sql;    
}

if( !empty( $btnsubmit ) ) { 
    header("Location: acap15a1.php");
}
?>