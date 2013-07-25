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
    $sql = "SELECT * FROM frm3_cap14a_materiasprimas WHERE mapr_regi_uid = '".$regisroUID."' AND mapr_tima_uid = '".$mapr_tima_uid."' AND mapr_position <> 0 ";          
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
                $unidadmedida = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B_".$pos)),'Text'); //unidad de medida                
                $colC = OPERATOR::toSql(safeHTML(OPERATOR::getParam("C_".$pos)),'Text'); $colC = preg_replace('/,/', '', $colC);
                $colD = OPERATOR::toSql(safeHTML(OPERATOR::getParam("D_".$pos)),'Text'); $colD = preg_replace('/,/', '', $colD);
                $colE = OPERATOR::toSql(safeHTML(OPERATOR::getParam("E_".$pos)),'Text'); $colE = preg_replace('/,/', '', $colE);
                $colF = OPERATOR::toSql(safeHTML(OPERATOR::getParam("F_".$pos)),'Text'); $colF = preg_replace('/,/', '', $colF);                
                $colG = $colE + $colF;                                
                $colH = OPERATOR::toSql(safeHTML(OPERATOR::getParam("H_".$pos)),'Text'); $colH = preg_replace('/,/', '', $colH);
                $colI = OPERATOR::toSql(safeHTML(OPERATOR::getParam("I_".$pos)),'Text'); $colI = preg_replace('/,/', '', $colI);
                $colJ = OPERATOR::toSql(safeHTML(OPERATOR::getParam("J_".$pos)),'Text'); $colJ = preg_replace('/,/', '', $colJ);
                $colK = $colC + $colG - $colI;
                $colL = $colD + $colH - $colJ;
                
                if( !empty($desc) ) {
                $sql  = "UPDATE frm3_cap14a_materiasprimas SET ";
                $sql .= "mapr_materiadesc = UPPER('".utf8_decode($desc)."'), ";            
                $sql .= "mapr_unidadmedida = UPPER('".utf8_decode($unidadmedida)."'), "; 
                $sql .= "mapr_invini_cantidad	 = '".$colC."', "; 
                $sql .= "mapr_invini_valor       = '".$colD."', ";                 
                $sql .= "mapr_compra_productores	 = '".$colE."', ";      
                $sql .= "mapr_compra_intermediarios	 = '".$colF."', ";
                $sql .= "mapr_compra_total	 = '".$colG."', ";
                $sql .= "mapr_compra_valor	 = '".$colH."', ";
                $sql .= "mapr_util_cantidad	 = '".$colI."', ";
                $sql .= "mapr_util_valor	 = '".$colJ."', ";
                $sql .= "mapr_invfin_cantidad	 = '".$colK."', ";
                $sql .= "mapr_invfin_valor	 = '".$colL."', ";                                                
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
                $k = $k + $colK;
                $l = $l + $colL;
                } else {
                    $sql  = "UPDATE frm3_cap14a_materiasprimas SET ";
                    $sql .= "mapr_materiadesc = '', "; 
                    $sql .= "mapr_unidadmedida = '', "; 
                    $sql .= "mapr_invini_cantidad	 = '0', "; 
                    $sql .= "mapr_invini_valor       = '0', ";                 
                    $sql .= "mapr_compra_productores	 = '0', ";      
                    $sql .= "mapr_compra_intermediarios	 = '0', ";
                    $sql .= "mapr_compra_total	 = '0', ";
                    $sql .= "mapr_compra_valor	 = '0', ";
                    $sql .= "mapr_util_cantidad	 = '0', ";
                    $sql .= "mapr_util_valor	 = '0', ";
                    $sql .= "mapr_invfin_cantidad	 = '0', ";
                    $sql .= "mapr_invfin_valor	 = '0', ";                      
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
            $unidadmedida = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B_".$pos)),'Text');
            $colC = OPERATOR::toSql(safeHTML(OPERATOR::getParam("C_".$pos)),'Text'); $colC = preg_replace('/,/', '', $colC);
            $colD = OPERATOR::toSql(safeHTML(OPERATOR::getParam("D_".$pos)),'Text'); $colD = preg_replace('/,/', '', $colD);
            $colE = OPERATOR::toSql(safeHTML(OPERATOR::getParam("E_".$pos)),'Text'); $colE = preg_replace('/,/', '', $colE);
            $colF = OPERATOR::toSql(safeHTML(OPERATOR::getParam("F_".$pos)),'Text'); $colF = preg_replace('/,/', '', $colF);
            $colG = $colE + $colF;
            $colH = OPERATOR::toSql(safeHTML(OPERATOR::getParam("H_".$pos)),'Text'); $colH = preg_replace('/,/', '', $colH);
            $colI = OPERATOR::toSql(safeHTML(OPERATOR::getParam("I_".$pos)),'Text'); $colI = preg_replace('/,/', '', $colI);
            $colJ = OPERATOR::toSql(safeHTML(OPERATOR::getParam("J_".$pos)),'Text'); $colJ = preg_replace('/,/', '', $colJ);
            $colK = $colC + $colG - $colI;
            $colL = $colD + $colH - $colJ;
                
            if( !empty($desc) && !empty($unidadmedida)  ) {                                
                $sql  = "INSERT frm3_cap14a_materiasprimas SET ";
                $sql .= "mapr_regi_uid = '".$regisroUID."', ";
                $sql .= "mapr_position = '".$pos."', ";
                $sql .= "mapr_tima_uid = '".$mapr_tima_uid."', ";
                $sql .= "mapr_materiadesc = UPPER('".utf8_decode($desc)."'), ";                 
                $sql .= "mapr_unidadmedida = UPPER('".utf8_decode($unidadmedida)."'), "; 
                $sql .= "mapr_invini_cantidad	 = '".$colC."', "; 
                $sql .= "mapr_invini_valor       = '".$colD."', ";                 
                $sql .= "mapr_compra_productores	 = '".$colE."', ";      
                $sql .= "mapr_compra_intermediarios	 = '".$colF."', ";
                $sql .= "mapr_compra_total	 = '".$colG."', ";
                $sql .= "mapr_compra_valor	 = '".$colH."', ";
                $sql .= "mapr_util_cantidad	 = '".$colI."', ";
                $sql .= "mapr_util_valor	 = '".$colJ."', ";
                $sql .= "mapr_invfin_cantidad	 = '".$colK."', ";
                $sql .= "mapr_invfin_valor	 = '".$colL."', ";                      
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
                $k = $k + $colK;
                $l = $l + $colL;
            } 
        }
    }
    
    
    // totales
    $uidtotalmateria = 6;
    $sql = "SELECT mapr_uid FROM frm3_cap14a_materiasprimas WHERE mapr_position = '0' AND mapr_tima_uid = '".$uidtotalmateria."' AND mapr_regi_uid = '".$regisroUID."' ";
    $db->query( $sql );
    
    //echo $sql."<br />";
    if( $db->numrows() > 0 ) {
        $sql  = "UPDATE frm3_cap14a_materiasprimas SET ";
        $sql .= "mapr_materiadesc = '', ";         
        $sql .= "mapr_unidadmedida = '', ";
        $sql .= "mapr_invini_cantidad	 = '".$c."', "; 
        $sql .= "mapr_invini_valor       = '".$d."', ";                 
        $sql .= "mapr_compra_productores	 = '".$e."', ";      
        $sql .= "mapr_compra_intermediarios	 = '".$f."', ";
        $sql .= "mapr_compra_total	 = '".$g."', ";
        $sql .= "mapr_compra_valor	 = '".$h."', ";
        $sql .= "mapr_util_cantidad	 = '".$ci."', ";
        $sql .= "mapr_util_valor	 = '".$j."', ";
        $sql .= "mapr_invfin_cantidad	 = '".$k."', ";
        $sql .= "mapr_invfin_valor	 = '".$l."', ";                                             
        $sql .= "mapr_suv_uid = '".$uid_token."', ";
        $sql .= "mapr_updatedate = NOW() ";
        $sql .= " WHERE mapr_regi_uid = '".$regisroUID."' AND  mapr_position = '0' AND mapr_tima_uid = '".$uidtotalmateria."' "; 
        $db3->query($sql);
    } else {
        $sql  = "INSERT frm3_cap14a_materiasprimas SET ";
        $sql .= "mapr_regi_uid = '".$regisroUID."', ";
        $sql .= "mapr_position = '0', ";
        $sql .= "mapr_tima_uid = '".$uidtotalmateria."', ";
        $sql .= "mapr_materiadesc = '', ";         
        $sql .= "mapr_unidadmedida = '', "; 
        $sql .= "mapr_invini_cantidad	 = '".$c."', "; 
        $sql .= "mapr_invini_valor       = '".$d."', ";                 
        $sql .= "mapr_compra_productores	 = '".$e."', ";      
        $sql .= "mapr_compra_intermediarios	 = '".$f."', ";
        $sql .= "mapr_compra_total	 = '".$g."', ";
        $sql .= "mapr_compra_valor	 = '".$h."', ";
        $sql .= "mapr_util_cantidad	 = '".$ci."', ";
        $sql .= "mapr_util_valor	 = '".$j."', ";
        $sql .= "mapr_invfin_cantidad	 = '".$k."', ";
        $sql .= "mapr_invfin_valor	 = '".$l."', ";                     
        $sql .= "mapr_suv_uid = '".$uid_token."', ";
        $sql .= "mapr_createdate = NOW(), ";
        $sql .= "mapr_updatedate = NOW(), ";
        $sql .= "mapr_delete = 0 ";                         
        $db3->query($sql);                
    }
    
    //echo $sql;
    
}
?>