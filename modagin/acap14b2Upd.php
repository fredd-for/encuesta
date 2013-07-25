<?php session_start(); 
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php');

$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];


$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');
$c = 0;
$d = 0;
$e = 0;
$f = 0;
$g = 0;
$h = 0;
$ci = 0;
$j = 0;

$mapr_tima_uid = 2;

if( !empty($regisroUID) && !empty($uidFormulario) ) {
    
    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    //actualizar existentes
    $sql = "SELECT * FROM frm3_cap14b_materiasprimas WHERE mapr_regi_uid = '".$regisroUID."' AND mapr_tima_uid = '".$mapr_tima_uid."' AND mapr_position <> 0 ";          
    $db2->query($sql);
    $aPosition = array();
    
    //echo $sql;
    if( $db2->numrows() >  0 ) {
        $pos = 0;        
        $i = 0;
        while( $aCert = $db2->next_record()  ) {
            
            $pos = $aCert["mapr_position"];            
            $aPosition[$i] = $pos;
            
            // solo modificar aquellos que estan habilitados
            if( $aCert["mapr_delete"] != 1 ) {
                $desc = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A_".$pos)),'Text');                
                $unidadmedida = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B_".$pos)),'Text');
                $colC = OPERATOR::toSql(safeHTML(OPERATOR::getParam("C_".$pos)),'Text'); $colC = preg_replace('/,/', '', $colC);
                $colD = OPERATOR::toSql(safeHTML(OPERATOR::getParam("D_".$pos)),'Text'); $colD = preg_replace('/,/', '', $colD);
                $colE = OPERATOR::toSql(safeHTML(OPERATOR::getParam("E_".$pos)),'Text'); $colE = preg_replace('/,/', '', $colE);
                $colF = OPERATOR::toSql(safeHTML(OPERATOR::getParam("F_".$pos)),'Text'); $colF = preg_replace('/,/', '', $colF);
                $colG = OPERATOR::toSql(safeHTML(OPERATOR::getParam("G_".$pos)),'Text'); $colG = preg_replace('/,/', '', $colG);
                $colH = OPERATOR::toSql(safeHTML(OPERATOR::getParam("H_".$pos)),'Text'); $colH = preg_replace('/,/', '', $colH);
                $colI = $colC + $colE - $colG;
                $colJ = $colD + $colF - $colH;
                
                
                if( !empty($desc) ) {
                $sql  = "UPDATE frm3_cap14b_materiasprimas SET ";
                $sql .= "mapr_materiadesc = UPPER('".utf8_decode($desc)."'), ";                 
                $sql .= "mapr_unidadmedida = UPPER('".utf8_decode($unidadmedida)."'), "; 
                $sql .= "mapr_invini_cantidad	 = '".$colC."', "; 
                $sql .= "mapr_invini_valor     = '".$colD."', "; 
                $sql .= "mapr_compra_cantidad	 = '".$colE."', ";      
                $sql .= "mapr_compra_valor	    = '".$colF."', ";                
                $sql .= "mapr_util_cantidad	   = '".$colG."', ";
                $sql .= "mapr_util_valor	      = '".$colH."', ";
                $sql .= "mapr_invfin_cantidad  = '".$colI."', ";
                $sql .= "mapr_invfin_valor	    = '".$colJ."', ";                                     
                $sql .= "mapr_suv_uid = '".$uid_token."', ";
                $sql .= "mapr_updatedate = NOW() ";
                $sql .= " WHERE mapr_regi_uid = '".$regisroUID."' AND  mapr_position = '".$pos."' AND mapr_tima_uid = '".$mapr_tima_uid."' ";         
                $db3->query($sql);
                
                $c = $c + $colC;
                $d = $d + $colD;
                $e = $e + $colE;
                $f = $f + $colF;
                $g = $g + $colG;
                $h = $h + $colH;
                $ci = $ci + $colI;
                $j = $j + $colJ;
                
                } else {
                    $sql  = "UPDATE frm3_cap14b_materiasprimas SET ";
                    $sql .= "mapr_materiadesc     = '', ";                    
                    $sql .= "mapr_unidadmedida    = '', "; 
                    $sql .= "mapr_invini_cantidad = '0', "; 
                    $sql .= "mapr_invini_valor    = '0', "; 
                    $sql .= "mapr_compra_cantidad = '0', ";      
                    $sql .= "mapr_compra_valor	   = '0', ";                
                    $sql .= "mapr_util_cantidad	  = '0', ";
                    $sql .= "mapr_util_valor	     = '0', ";
                    $sql .= "mapr_invfin_cantidad = '0', ";
                    $sql .= "mapr_invfin_valor    = '0', ";                    
                    $sql .= "mapr_suv_uid         = '".$uid_token."', ";
                    $sql .= "mapr_updatedate = NOW() ";
                    $sql .= " WHERE mapr_regi_uid = '".$regisroUID."' AND  mapr_position = '".$pos."' AND mapr_tima_uid = '".$mapr_tima_uid."' ";         
                    $db3->query($sql);
                }
                //echo $sql;
            }
            $i = $i + 1;
        }
    }
    
    //registrar nuevos
    $maxrow = OPERATOR::toSql(safeHTML(OPERATOR::getParam("maxrow")),'Number');
    //echo $maxrow;
    for( $pos = 1; $pos<=$maxrow; $pos++ ) {
        // si no existe registrar        
        if( !in_array($pos, $aPosition) ) {                        
            
            $desc = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A_".$pos)),'Text');            
            $unidadmedida = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B_".$pos)),'Text');
            $colC = OPERATOR::toSql(safeHTML(OPERATOR::getParam("C_".$pos)),'Text'); $colC = preg_replace('/,/', '', $colC);
            $colD = OPERATOR::toSql(safeHTML(OPERATOR::getParam("D_".$pos)),'Text'); $colD = preg_replace('/,/', '', $colD);
            $colE = OPERATOR::toSql(safeHTML(OPERATOR::getParam("E_".$pos)),'Text'); $colE = preg_replace('/,/', '', $colE);
            $colF = OPERATOR::toSql(safeHTML(OPERATOR::getParam("F_".$pos)),'Text'); $colF = preg_replace('/,/', '', $colF);
            $colG = OPERATOR::toSql(safeHTML(OPERATOR::getParam("G_".$pos)),'Text'); $colG = preg_replace('/,/', '', $colG);
            $colH = OPERATOR::toSql(safeHTML(OPERATOR::getParam("H_".$pos)),'Text'); $colH = preg_replace('/,/', '', $colH);
            $colI = $colC + $colE - $colG;
            $colJ = $colD + $colF - $colH;
                
            if( !empty($desc) ) {                            
                $sql  = "INSERT frm3_cap14b_materiasprimas SET ";
                $sql .= "mapr_regi_uid = '".$regisroUID."', ";
                $sql .= "mapr_position = '".$pos."', ";
                $sql .= "mapr_tima_uid = '".$mapr_tima_uid."', ";                
                $sql .= "mapr_materiadesc = UPPER('".utf8_decode($desc)."'), ";                 
                $sql .= "mapr_unidadmedida = UPPER('".utf8_decode($unidadmedida)."'), "; 
                $sql .= "mapr_invini_cantidad	 = '".$colC."', "; 
                $sql .= "mapr_invini_valor     = '".$colD."', "; 
                $sql .= "mapr_compra_cantidad	 = '".$colE."', ";      
                $sql .= "mapr_compra_valor	    = '".$colF."', ";                
                $sql .= "mapr_util_cantidad	   = '".$colG."', ";
                $sql .= "mapr_util_valor	      = '".$colH."', ";
                $sql .= "mapr_invfin_cantidad  = '".$colI."', ";
                $sql .= "mapr_invfin_valor	    = '".$colJ."', ";                    
                $sql .= "mapr_suv_uid = '".$uid_token."', ";
                $sql .= "mapr_createdate = NOW(), ";
                $sql .= "mapr_updatedate = NOW(), ";
                $sql .= "mapr_delete = 0 ";                         
                $db3->query($sql);
                
                $c = $c + $colC;
                $d = $d + $colD;
                $e = $e + $colE;
                $f = $f + $colF;
                $g = $g + $colG;
                $h = $h + $colH;
                $ci = $ci + $colI;
                $j = $j + $colJ;
            } 
        }
    }
    
    
    // totales
    $uidtotalmateria = 5;
    $sql = "SELECT mapr_uid FROM frm3_cap14b_materiasprimas WHERE mapr_position = '0' AND mapr_tima_uid = '".$uidtotalmateria."' AND mapr_regi_uid = '".$regisroUID."' ";
    $db->query( $sql );
    
    //echo $sql."<br />";
    if( $db->numrows() > 0 ) {
        $sql  = "UPDATE frm3_cap14b_materiasprimas SET ";        
        $sql .= "mapr_materiadesc = '', "; 
        $sql .= "mapr_unidadmedida = '', "; 
        $sql .= "mapr_invini_cantidad	 = '".$c."', "; 
        $sql .= "mapr_invini_valor     = '".$d."', "; 
        $sql .= "mapr_compra_cantidad	 = '".$e."', ";      
        $sql .= "mapr_compra_valor	    = '".$f."', ";                
        $sql .= "mapr_util_cantidad	   = '".$g."', ";
        $sql .= "mapr_util_valor	      = '".$h."', ";
        $sql .= "mapr_invfin_cantidad  = '".$ci."', ";
        $sql .= "mapr_invfin_valor	    = '".$j."', ";                       
        $sql .= "mapr_suv_uid = '".$uid_token."', ";
        $sql .= "mapr_updatedate = NOW() ";
        $sql .= " WHERE mapr_regi_uid = '".$regisroUID."' AND  mapr_position = '0' AND mapr_tima_uid = '".$uidtotalmateria."' "; 
        $db3->query($sql);
    } else {
        $sql  = "INSERT frm3_cap14b_materiasprimas SET ";
        $sql .= "mapr_regi_uid = '".$regisroUID."', ";
        $sql .= "mapr_position = '0', ";
        $sql .= "mapr_tima_uid = '".$uidtotalmateria."', ";
        $sql .= "mapr_materiadesc = '', "; 
        $sql .= "mapr_unidadmedida = '', "; 
        $sql .= "mapr_invini_cantidad	 = '".$c."', "; 
        $sql .= "mapr_invini_valor     = '".$d."', "; 
        $sql .= "mapr_compra_cantidad	 = '".$e."', ";      
        $sql .= "mapr_compra_valor	    = '".$f."', ";                
        $sql .= "mapr_util_cantidad	   = '".$g."', ";
        $sql .= "mapr_util_valor	      = '".$h."', ";
        $sql .= "mapr_invfin_cantidad  = '".$ci."', ";
        $sql .= "mapr_invfin_valor	    = '".$j."', ";                      
        $sql .= "mapr_suv_uid = '".$uid_token."', ";
        $sql .= "mapr_createdate = NOW(), ";
        $sql .= "mapr_updatedate = NOW(), ";
        $sql .= "mapr_delete = 0 ";                         
        $db3->query($sql);
    }    
    //echo $sql;    
}
?>