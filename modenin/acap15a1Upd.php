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
$l = 0;
$m = 0;
$prod_tima_uid = 7;

if( !empty($regisroUID) && !empty($uidFormulario) ) {
    
    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    //actualizar existentes
    $sql = "SELECT * FROM frm2_cap15_productosterminados WHERE prod_regi_uid = '".$regisroUID."' AND prod_tima_uid = '".$prod_tima_uid."' AND prod_position <> 0 ";          
    $db2->query($sql);
    $aPosition = array();
    
    //echo $sql;
    if( $db2->numrows() >  0 ) {
        $pos = 0;        
        $i = 0;
        while( $aCert = $db2->next_record()  ) {
            
            $pos = $aCert["prod_position"];            
            $aPosition[$i] = $pos;
            
            // solo modificar aquellos que estan habilitados
            if( $aCert["prod_delete"] != 1 ) {
                $desc = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A_".$pos)),'Text');                
                $unidadmedida = OPERATOR::toSql(safeHTML(OPERATOR::getParam("C_".$pos)),'Text');
                $colD = OPERATOR::toSql(safeHTML(OPERATOR::getParam("D_".$pos)),'Text'); $colD = preg_replace('/,/', '', $colD);
                $colE = OPERATOR::toSql(safeHTML(OPERATOR::getParam("E_".$pos)),'Text'); $colE = preg_replace('/,/', '', $colE);
                $colF = OPERATOR::toSql(safeHTML(OPERATOR::getParam("F_".$pos)),'Text'); $colF = preg_replace('/,/', '', $colF);
                $colG = OPERATOR::toSql(safeHTML(OPERATOR::getParam("G_".$pos)),'Text'); $colG = preg_replace('/,/', '', $colG);
                $colH = OPERATOR::toSql(safeHTML(OPERATOR::getParam("H_".$pos)),'Text'); $colH = preg_replace('/,/', '', $colH);
                $colI = OPERATOR::toSql(safeHTML(OPERATOR::getParam("I_".$pos)),'Text'); $colI = preg_replace('/,/', '', $colI);
                $colJ = OPERATOR::toSql(safeHTML(OPERATOR::getParam("J_".$pos)),'Text'); $colJ = preg_replace('/,/', '', $colJ);
                $colK = OPERATOR::toSql(safeHTML(OPERATOR::getParam("K_".$pos)),'Text'); $colK = preg_replace('/,/', '', $colK);
                                
                $colL = $colD - $colF - $colH + $colJ; //cantidad
                $colM = $colE - $colG - $colI + $colK;
    
                
                if( !empty($desc) ) {
                $sql  = "UPDATE frm2_cap15_productosterminados SET ";
                $sql .= "prod_descproducto = UPPER('".utf8_decode($desc)."'), ";                 
                $sql .= "prod_unidadmedida = UPPER('".utf8_decode($unidadmedida)."'), "; 
                $sql .= "prod_invini_cantidad	 = '".$colD."', "; 
                $sql .= "prod_invini_valor       = '".$colE."', "; 
                $sql .= "prod_ventas_cantidad	 = '".$colF."', ";      
                $sql .= "prod_ventas_valor	 = '".$colG."', ";                
                $sql .= "prod_me_cantidad	 = '".$colH."', ";
                $sql .= "prod_me_valor	         = '".$colI."', ";
                $sql .= "prod_produccion_cantidad = '".$colJ."', ";
                $sql .= "prod_produccion_valor	 = '".$colK."', ";
                $sql .= "prod_invfin_cantidad	 = '".$colL."', ";      
                $sql .= "prod_invfin_valor	 = '".$colM."', ";                     
                $sql .= "prod_suv_uid = '".$uid_token."', ";
                $sql .= "prod_updatedate = NOW() ";
                $sql .= " WHERE prod_regi_uid = '".$regisroUID."' AND  prod_position = '".$pos."' AND prod_tima_uid = '".$prod_tima_uid."' ";         
                $db3->query($sql);
                
                $d = $d + $colD;
                $e = $e + $colE;
                $f = $f + $colF;
                $g = $g + $colG;
                $h = $h + $colH;
                $ci = $ci + $colI;
                $j = $j + $colJ;
                $k = $k + $colK;
                $l = $l + $colL;
                $m = $m + $colM;
                } else {
                    $sql  = "UPDATE frm2_cap15_productosterminados SET ";
                    $sql .= "prod_descproducto = '', ";                    
                    $sql .= "prod_unidadmedida = '', "; 
                    $sql .= "prod_invini_cantidad = '0', "; 
                    $sql .= "prod_invini_valor    = '0', "; 
                    $sql .= "prod_ventas_cantidad = '0', ";      
                    $sql .= "prod_ventas_valor	  = '0', ";                
                    $sql .= "prod_me_cantidad	  = '0', ";
                    $sql .= "prod_me_valor	      = '0', ";
                    $sql .= "prod_produccion_cantidad = '0', ";
                    $sql .= "prod_produccion_valor    = '0', ";
                    $sql .= "prod_invfin_cantidad     = '0', ";      
                    $sql .= "prod_invfin_valor	 = '0', ";                      
                    $sql .= "prod_suv_uid = '".$uid_token."', ";
                    $sql .= "prod_updatedate = NOW() ";
                    $sql .= " WHERE prod_regi_uid = '".$regisroUID."' AND  prod_position = '".$pos."' AND prod_tima_uid = '".$prod_tima_uid."' ";         
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
            $unidadmedida = OPERATOR::toSql(safeHTML(OPERATOR::getParam("C_".$pos)),'Text');
            $colD = OPERATOR::toSql(safeHTML(OPERATOR::getParam("D_".$pos)),'Text'); $colD = preg_replace('/,/', '', $colD);
            $colE = OPERATOR::toSql(safeHTML(OPERATOR::getParam("E_".$pos)),'Text'); $colE = preg_replace('/,/', '', $colE);
            $colF = OPERATOR::toSql(safeHTML(OPERATOR::getParam("F_".$pos)),'Text'); $colF = preg_replace('/,/', '', $colF);
            $colG = OPERATOR::toSql(safeHTML(OPERATOR::getParam("G_".$pos)),'Text'); $colG = preg_replace('/,/', '', $colG);
            $colH = OPERATOR::toSql(safeHTML(OPERATOR::getParam("H_".$pos)),'Text'); $colH = preg_replace('/,/', '', $colH);
            $colI = OPERATOR::toSql(safeHTML(OPERATOR::getParam("I_".$pos)),'Text'); $colI = preg_replace('/,/', '', $colI);
            $colJ = OPERATOR::toSql(safeHTML(OPERATOR::getParam("J_".$pos)),'Text'); $colJ = preg_replace('/,/', '', $colJ);
            $colK = OPERATOR::toSql(safeHTML(OPERATOR::getParam("K_".$pos)),'Text'); $colK = preg_replace('/,/', '', $colK);
            $colL = $colD - $colF - $colH + $colJ; //cantidad
            $colM = $colE - $colG - $colI + $colK;
                
            if( !empty($desc) ) {                                
                $sql  = "INSERT frm2_cap15_productosterminados SET ";
                $sql .= "prod_regi_uid = '".$regisroUID."', ";
                $sql .= "prod_position = '".$pos."', ";
                $sql .= "prod_tima_uid = '".$prod_tima_uid."', ";                
                $sql .= "prod_descproducto = UPPER('".utf8_decode($desc)."'), ";                 
                $sql .= "prod_unidadmedida = UPPER('".utf8_decode($unidadmedida)."'), "; 
                $sql .= "prod_invini_cantidad	 = '".$colD."', "; 
                $sql .= "prod_invini_valor       = '".$colE."', "; 
                $sql .= "prod_ventas_cantidad	 = '".$colF."', ";      
                $sql .= "prod_ventas_valor	 = '".$colG."', ";                
                $sql .= "prod_me_cantidad	 = '".$colH."', ";
                $sql .= "prod_me_valor	         = '".$colI."', ";
                $sql .= "prod_produccion_cantidad = '".$colJ."', ";
                $sql .= "prod_produccion_valor	 = '".$colK."', ";
                $sql .= "prod_invfin_cantidad	 = '".$colL."', ";      
                $sql .= "prod_invfin_valor	 = '".$colM."', ";                    
                $sql .= "prod_suv_uid = '".$uid_token."', ";
                $sql .= "prod_createdate = NOW(), ";
                $sql .= "prod_updatedate = NOW(), ";
                $sql .= "prod_delete = 0 ";                         
                $db3->query($sql);
                
                $d = $d + $colD;
                $e = $e + $colE;
                $f = $f + $colF;
                $g = $g + $colG;
                $h = $h + $colH;
                $ci = $ci + $colI;
                $j = $j + $colJ;
                $k = $k + $colK;
                $l = $l + $colL;
                $m = $m + $colM;
            } 
        }
    }
    
    
    // totales
    $uidtotalmateria = 10;
    $sql = "SELECT prod_uid FROM frm2_cap15_productosterminados WHERE prod_position = '0' AND prod_tima_uid = '".$uidtotalmateria."' AND prod_regi_uid = '".$regisroUID."' ";
    $db->query( $sql );
    
    //echo $sql."<br />";
    if( $db->numrows() > 0 ) {
        $sql  = "UPDATE frm2_cap15_productosterminados SET ";        
        $sql .= "prod_descproducto = '', "; 
        $sql .= "prod_unidadmedida = '', "; 
        $sql .= "prod_invini_cantidad	 = '".$d."', "; 
        $sql .= "prod_invini_valor       = '".$e."', "; 
        $sql .= "prod_ventas_cantidad	 = '".$f."', ";      
        $sql .= "prod_ventas_valor	 = '".$g."', ";                
        $sql .= "prod_me_cantidad	 = '".$h."', ";
        $sql .= "prod_me_valor	         = '".$ci."', ";
        $sql .= "prod_produccion_cantidad = '".$j."', ";
        $sql .= "prod_produccion_valor	 = '".$k."', ";
        $sql .= "prod_invfin_cantidad	 = '".$l."', ";      
        $sql .= "prod_invfin_valor	 = '".$m."', ";                       
        $sql .= "prod_suv_uid = '".$uid_token."', ";
        $sql .= "prod_updatedate = NOW() ";
        $sql .= " WHERE prod_regi_uid = '".$regisroUID."' AND  prod_position = '0' AND prod_tima_uid = '".$uidtotalmateria."' "; 
        $db3->query($sql);
    } else {
        $sql  = "INSERT frm2_cap15_productosterminados SET ";
        $sql .= "prod_regi_uid = '".$regisroUID."', ";
        $sql .= "prod_position = '0', ";
        $sql .= "prod_tima_uid = '".$uidtotalmateria."', ";
        $sql .= "prod_descproducto = '', "; 
        $sql .= "prod_unidadmedida = '', "; 
        $sql .= "prod_invini_cantidad	 = '".$d."', "; 
        $sql .= "prod_invini_valor       = '".$e."', "; 
        $sql .= "prod_ventas_cantidad	 = '".$f."', ";      
        $sql .= "prod_ventas_valor	 = '".$g."', ";                
        $sql .= "prod_me_cantidad	 = '".$h."', ";
        $sql .= "prod_me_valor	         = '".$ci."', ";
        $sql .= "prod_produccion_cantidad = '".$j."', ";
        $sql .= "prod_produccion_valor	 = '".$k."', ";
        $sql .= "prod_invfin_cantidad	 = '".$l."', ";      
        $sql .= "prod_invfin_valor	 = '".$m."', ";                      
        $sql .= "prod_suv_uid = '".$uid_token."', ";
        $sql .= "prod_createdate = NOW(), ";
        $sql .= "prod_updatedate = NOW(), ";
        $sql .= "prod_delete = 0 ";                         
        $db3->query($sql);                
    }    
    //echo $sql;    
}
?>