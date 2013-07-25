<?php session_start(); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
?>
<?php include_once('../verifyLogin.php'); ?>
<?php include("header.php") ?>
<script type="text/javascript" src="js/bcap2.js"></script>

<?php
/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$sql = "SELECT * FROM  frm3_bcap2_sistemagestion WHERE sige_regi_uid = '".$regisroUID."' ";
$db->query( $sql );

if( $db->numrows() == 0 ) {

    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    $sql2 = "SELECT * FROM adm_definiciones WHERE defi_form_uid = '3' AND defi_modulo = 'b' AND defi_capitulo = '2' AND defi_swactive = 'ACTIVE' ";       
    $db2->query( $sql2 );
    while( $aDefinicion =  $db2->next_record() ) {
        $sql = "INSERT INTO  frm3_bcap2_sistemagestion SET ";
        $sql .= "sige_regi_uid = '".$regisroUID."', ";
        $sql .= "sige_defi_uid = '".$aDefinicion["defi_uid"]."', ";         
        $sql .= "sige_description = '', "; 
        $sql .= "sige_suv_uid = '".$uid_token."', "; 
        $sql .= "sige_createdate = NOW(), "; 
        $sql .= "sige_updatedate = NOW() ";                          	 	
        $db3->query( $sql );               
    }       
}

?>

<?php            

    $sql = " SELECT  frm3_bcap2_sistemagestion.*, adm_definiciones.defi_subcapitulo as subcap, adm_definiciones.defi_indent as indent, adm_definiciones.defi_vinieta as vinieta "
          ." FROM  frm3_bcap2_sistemagestion LEFT JOIN  adm_definiciones ON ( sige_defi_uid = defi_uid ) "
          ." WHERE sige_regi_uid = '".$regisroUID."' AND sige_defi_uid IN (459, 460, 461 )  "
          ." ORDER BY adm_definiciones.defi_indent ASC,  adm_definiciones.defi_vinieta ASC ";
    $db->query( $sql );
    
    //echo $sql;
    $a1 = ""; $b1 = ""; $c1 = ""; $c1_desc = '';
    $a2 = ""; $b2 = ""; $c2 = ""; $c2_desc = '';
    while( $aAmb = $db->next_record() ) {
        if( $aAmb["subcap"] == "1" && $aAmb["vinieta"] == "a" ) {
            $a1 = $aAmb["sige_valor"];                
        }

        if( $aAmb["subcap"] == "1" && $aAmb["vinieta"] == "b" ) {
            $b1 = $aAmb["sige_valor"];
        }

        if( $aAmb["subcap"] == "1" && $aAmb["vinieta"] == "c" ) {
            $c1 = $aAmb["sige_valor"];
            $c1_desc = $aAmb["sige_description"];
        }               
    }
            
    $sql = " SELECT  frm3_bcap2_sistemagestion.*, adm_definiciones.defi_subcapitulo as subcap, adm_definiciones.defi_indent as indent, adm_definiciones.defi_vinieta as vinieta  "
          ." FROM  frm3_bcap2_sistemagestion LEFT JOIN adm_definiciones ON ( sige_defi_uid = defi_uid ) "
          ." WHERE sige_regi_uid = '".$regisroUID."' AND sige_defi_uid NOT IN (459, 460, 461 ) "
          ." ORDER BY CAST( adm_definiciones.defi_subcapitulo AS UNSIGNED ) ASC,	CAST( adm_definiciones.defi_indent AS UNSIGNED ) ASC,	CAST( adm_definiciones.defi_vinieta AS UNSIGNED ) ASC ";
    $db->query( $sql );
       
    //echo $sql;
    // verificar si esta vacia
    function checkEmpty($var) {
        if (strlen($var) >= 1) {
            return false; // No esta vacia
        } else {
            return true; // Esta Vacia
        }
    }
?>
<!-- begin body -->
<div class="content">
    <span id="statusACAP1"></span>
    <table class="dInf">
    <thead>
    <tr>
        <th>CAP&Iacute;TULO 2</th>
        <th>SISTEMAS DE GESTI&Oacute;N</th>
    </tr>
    </thead>    
    </table>
    <form class="formA validable" action="bcap2Add.php" method="post" autocomplete="off" >
        <fieldset>
            
            <?php           
            while( $aAmb = $db->next_record() ) {
            ?>
            <?php  if( $aAmb["subcap"] == "1" && $aAmb["indent"] == "1"  && $aAmb["vinieta"] == "1"  ) { ?>            
            <p>
                <span class="subT">1. &iquest;La empresa cont&oacute; con un Sistema de Gesti&oacute;n Certificado en el &uacute;ltimo a&ntilde;o?&nbsp;</span>
                <span class="clear"></span>
            </p>   
            <p>
            <?php echo OPERATOR::getDescTitles(3,'B',2,'1'); ?>
            </p>
            <p>
                <input class="chk" type="radio" name="rbtn_inv" id="rbtn_inv1" value="1" <?php if( $aAmb["sige_valor"] == 1 ) { echo "checked=\"checked\""; } ?>  />            
                <label class="labChk" >Si</label>
                <span class="clear"></span>

                <input class="chk" type="radio" name="rbtn_inv" id="rbtn_inv2" value="0" <?php if( !checkEmpty($aAmb["sige_valor"]) && $aAmb["sige_valor"] == 0  ) { echo "checked=\"checked\""; $mostrar1 = "style=\"display: block;\"";  } else { $mostrar1 = "style=\"display: none;\""; } ?> />                        
                <label class="labChk" >No</label>
            </p>            
            
            <div id="noopcioninv" <?php echo $mostrar1; ?> >
            <p>Marque los incisos que correspondan y pase a la siguiente pregunta </p>
            <p>
                <input class="chk" type="checkbox" name="chk_1" id="chk_1" <?php if( $a1 == 1 ) { echo "checked=\"checked\""; } ?> />
                <label class="labChk" >a) Falta de presupuesto</label>
                <span class="clear"></span>

                <input class="chk" type="checkbox" name="chk_2" id="chk_2" <?php if( $b1 == 1 ) { echo "checked=\"checked\""; } ?> />
                <label class="labChk" >b) Falta de conocimiento</label>
                <span class="clear"></span>
                
                <input class="chk" type="checkbox" name="chk_3" id="chk_3" <?php if( $c1 == 1 ) { echo "checked=\"checked\""; } ?> />
                <label class="labChk" >c) Otros (especificar)</label>
                
                <?php $mostrar2 = "style=\"display: none;\"";  if( $c1 == 1 ) { $mostrar2 = "style=\"display: block;\"";  } ?>
                <input name="inversionotros" class="inpC" type="text" id="inversionotros" value="<?php echo $c1_desc; ?>" size="60" <?php echo $mostrar2;  ?>  />
            </p>            
            <span id="msg1" style="display: none;" class="bxEr">Debe especificar el detalle para otros</span>            
            </div> 
            
            <div id="siopcioninv" <?php if( $aAmb["sige_valor"] == 1 ) { echo "style=\"display: block\""; } else { echo "style=\"display: none\""; } ?>  ><!-- opcion si (inicio) -->
            <table width="100%" class="fOpt">
            <thead>
                <tr>
                    <th align="center">certificaci&oacute;n</th>
                    <th width="43%" align="center">organismo de certificaci&oacute;n</th>                    
                </tr>                
            </thead>                        
            <tbody> 
            <?php } ?>
                            
            <?php  if( $aAmb["subcap"] == "1" && $aAmb["indent"] == "11"  && $aAmb["vinieta"] == "1"  ) { ?> 
            <tr>
                <td width="57%" class="titR">1. ISO 9001: Sistema de Gesti&oacute;n de la Calidad </td>
                <td align="right"><input type="text" class="inpC2"  size="40" id="A1" name="A1" value="<?php echo $aAmb["sige_description"] ?>" /></td>
            </tr>                                                                                           
            <?php } ?>
            <?php  if( $aAmb["subcap"] == "1" && $aAmb["indent"] == "11"  && $aAmb["vinieta"] == "2"  ) { ?> 
            <tr>
                <td class="titR">2. ISO 14001: Certificaci&oacute;n de Sistema de Gesti&oacute;n Ambiental </td>
                <td align="right"><input type="text" class="inpC2"  size="40" id="A2" name="A2" value="<?php echo $aAmb["sige_description"] ?>" /></td>
            </tr>
            <?php } ?>
            <?php  if( $aAmb["subcap"] == "1" && $aAmb["indent"] == "11"  && $aAmb["vinieta"] == "3"  ) { ?> 
            <tr>
                <td class="titR">3. OHSAS 18001: Certificaci&oacute;n Sistema de Gesti&oacute;n en Seguridad y Salud Ocupacional </td>
                <td align="right"><input type="text" class="inpC2"  size="40" id="A3" name="A3" value="<?php echo $aAmb["sige_description"] ?>" /></td>
            </tr>
            <?php } ?>
            <?php  if( $aAmb["subcap"] == "1" && $aAmb["indent"] == "11"  && $aAmb["vinieta"] == "4"  ) { ?> 
            <tr>
                <td class="titR">4. MYPE'S- NB 12009 &ndash;: Certificaci&oacute;n de Sistemas de Gesti&oacute;n para </td>
                <td align="right"><input type="text" class="inpC2"  size="40" id="A4" onblur="saveUPD(1);" name="A4" value="<?php echo $aAmb["sige_description"] ?>" /></td>
            </tr>
            <?php } ?>
            <?php  if( $aAmb["subcap"] == "1" && $aAmb["indent"] == "11"  && $aAmb["vinieta"] == "5"  ) { ?> 
            <tr>
                <td class="titR">5. ISO/IEC 27001 - ISO/IEC 20000-1: Certificaci&oacute;n Sistema de Gesti&oacute;n de Seguridad<br />
                    y/o Tecnolog&iacute;as de la Informaci&oacute;n </td>
                <td align="right"><input type="text" class="inpC2"  size="40" id="A5" name="A5" value="<?php echo $aAmb["sige_description"] ?>" /></td>
            </tr>
            <?php } ?>
            <?php  if( $aAmb["subcap"] == "1" && $aAmb["indent"] == "11"  && $aAmb["vinieta"] == "6"  ) { ?> 
            <tr>
                <td class="titR">6. ISO 22000: Certificaci&oacute;n Sistema de Gesti&oacute;n de Inocuidad para Alimentos </td>
                <td align="right"><input type="text" class="inpC2"  size="40" id="A6" name="A6" value="<?php echo $aAmb["sige_description"] ?>" /></td>
            </tr>
            <?php } ?>
            <?php  if( $aAmb["subcap"] == "1" && $aAmb["indent"] == "11"  && $aAmb["vinieta"] == "7"  ) { ?> 
            <tr>
                <td class="titR">7. HACCP: Certificacion del Sistema de An&aacute;lisis de Peligros y Puntos de Control Criticos</td>
                <td align="right"><input type="text" class="inpC2"  size="40" id="A7" name="A7" value="<?php echo $aAmb["sige_description"] ?>" /></td>
            </tr>                
            <?php } ?>          
            <?php  if( $aAmb["subcap"] == "2" && $aAmb["indent"] == "1"  && $aAmb["vinieta"] == "1"  ) { ?>                  
            </tbody>
            </table>
            </div><!-- opcion si (final) -->
            <?php 
                $chk_2 = $aAmb["sige_valor"];                
            ?>
            
            <?php } ?> 
            <?php } ?>
            <p>
                <span class="subT">2. &iquest;Sus productos y/o servicios tenian alg&uacute;n tipo de certificaci&oacute;n de calidad en la &uacute;ltima gesti&oacute;n (no incluya Registro Sanitario del SENASAG)?</span>
                <span class="clear"></span>
            </p>
            <p>
                <?php echo OPERATOR::getDescTitles(3,'B',2,'2'); ?>                
            </p>
            <p>
                <input class="chk" type="radio" name="rbtn_gastos" onclick="saveUPD(1);" id="rbtn_inversion1" value="1" <?php if( $chk_2 == 1 ) { echo "checked=\"checked\""; } ?>  />            
                <label class="labChk" >Si</label>
                <span class="clear"></span>

                <input class="chk" type="radio" name="rbtn_gastos" onclick="saveUPD(1);" id="rbtn_inversion2" value="0" <?php if( !checkEmpty($chk_2) && $chk_2 == 0  ) { echo "checked=\"checked\""; $mostrar1 = "style=\"display: block;\"";  } else { $mostrar1 = "style=\"display: none;\""; } ?> />                        
                <label class="labChk" >No</label>
            </p>
                                                   
            <div id="siopciongastos" <?php if( $chk_2 == 1 ) { echo "style=\"display: block\""; } else { echo "style=\"display: none\""; } ?>  ><!-- opcion gastos si (inicio) -->            
            <p>Indique los productos certificados, en la siguiente tabla:</p>
            <table width="100%" class="fOpt" id="tablecertificacion" >
            <thead>
                <tr>
                    <th width="72%" align="center">productos</th>
                    <th width="28%" align="center">&nbsp;</th>                    
                </tr>                
            </thead>
            <tbody>
                <?php
                $posmax = OPERATOR::getDbValue("SELECT MAX(prod_position) + 1 as pos FROM  frm3_bcap2_productos WHERE prod_regi_uid = '".$regisroUID."' AND prod_position <> 0");
                //echo "SELECT MAX(prod_position) + 1 as pos FROM  frm3_bcap2_productos WHERE prod_regi_uid = '".$regisroUID."' AND prod_position <> 0";
                if( empty($posmax) ) { $posmax = 1; }
                
                $sql3 = "SELECT * FROM frm3_bcap2_productos WHERE prod_regi_uid = '".$regisroUID."' AND prod_delete = 0 ORDER BY prod_position ASC  ";
                //echo $sql3;                
                $db3->query( $sql3 );
                if( $db3->numrows() > 0 ) {
                while( $aCert2 = $db3->next_record() ) {
                    $pos = $aCert2["prod_position"];                    
                ?>
                <tr id="row_<?php echo $pos; ?>" >
                    <td align="right"><input type="text" class="inpC" size="70" id="B1_<?php echo $pos ?>" name="B1_<?php echo $pos ?>" value="<?php echo $aCert2["prod_description"] ?>" /></td>
                    <td align="right"><a href="#" class="lnkCls" id="delplan_<?php echo $pos ?>" onclick="delRow('<?php echo $pos ?>',1); return false;" >eliminar</a></td>
                </tr>
                <?php }                            
                } else {                    
                ?>
                <tr id="row_<?php echo $posmax; ?>" >
                    <td align="right"><input type="text" class="inpC" size="70" id="B1_<?php echo $posmax; ?>" name="B1_<?php echo $posmax; ?>" /></td>
                    <td align="right">&nbsp;</td>
                </tr>
                <?php 
                $posmax = $posmax + 1;
                } ?>
            </tbody>
            </table>
            <input type="hidden" name="maxrow" id="maxrow" value="<?php echo $posmax ?>">
            <a href="#" id="addcertificacion" class="btnAdd">Agregar campos</a>
            </div><!-- opcion gastos si (final) -->
            
          
            <span class="bxBt">
                <input type="submit" value="SIGUIENTE" id="sendData" name="continuarregistro" class="button" >
                <a href="bcap1.php" class="btnS">ANTERIOR</a>                
            </span>
                
        </fieldset>
    </form>
    <div class="clear"></div>      

</div>
<!-- end body -->

<?php include("footer.php") ?>