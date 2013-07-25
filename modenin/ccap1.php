<?php session_start(); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
?>
<?php include_once('../verifyLogin.php'); ?>
<?php include("header.php") ?>
<script type="text/javascript" src="js/ccap1.js"></script>
<?php
/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$sql = "SELECT * FROM frm2_ccap1_usoaccesotic WHERE usac_regi_uid = '".$regisroUID."' ";
$db->query( $sql );

if( $db->numrows() == 0 ) {

    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    $sql2 = "SELECT * FROM adm_definiciones WHERE defi_form_uid = '2' AND defi_modulo = 'c' AND  defi_capitulo = '1' AND defi_swactive = 'ACTIVE' ";       
    $db2->query( $sql2 );
    while( $aDefinicion =  $db2->next_record() ) {
        $sql = "INSERT INTO frm2_ccap1_usoaccesotic SET ";
        $sql .= "usac_regi_uid = '".$regisroUID."', ";
        $sql .= "usac_defi_uid = '".$aDefinicion["defi_uid"]."', ";         
        $sql .= "usac_description = '', "; 
        $sql .= "usac_suv_uid = '".$uid_token."', ";
        $sql .= "usac_cantidad1 = '0', "; 
        $sql .= "usac_cantidad2 = '0', "; 
        $sql .= "usac_createdate = NOW(), "; 
        $sql .= "usac_updatedate = NOW() ";                          	 	
        $db3->query( $sql );              
    }        
}
?>

<?php      
    // verificar si esta vacia
    function checkEmpty($var) {
        if (strlen($var) >= 1) {
            return false; // No esta vacia
        } else {
            return true; // Esta Vacia
        }
    }
    
    $sql = " SELECT * FROM frm2_ccap1_2aplicaciones WHERE apli_regi_uid = '".$regisroUID."' ";
    $db2->query( $sql );
    
    while( $aAplic = $db2->next_record() ) {
        switch ( $aAplic["apli_position"] ) {
            case 1: 
            $chkA_1 = $aAplic["apli_valor"]; $nomapli_1 = $aAplic["apli_nombre"];
            $cantNal_1 = $aAplic["apli_cantidadnacional"]; $cantImport_1 = $aAplic["apli_cantidadimportado"];
            $canttot_1 = $aAplic["apli_total"];            	
            break;
            case 2: 
            $chkA_2 = $aAplic["apli_valor"]; $nomapli_2 = $aAplic["apli_nombre"];
            $cantNal_2 = $aAplic["apli_cantidadnacional"]; $cantImport_2 = $aAplic["apli_cantidadimportado"];
            $canttot_2 = $aAplic["apli_total"];            	
            break;
            case 3: 
            $chkA_3 = $aAplic["apli_valor"]; $nomapli_3 = $aAplic["apli_nombre"];
            $cantNal_3 = $aAplic["apli_cantidadnacional"]; $cantImport_3 = $aAplic["apli_cantidadimportado"];
            $canttot_3 = $aAplic["apli_total"];            	
            break;
            case 4: 
            $chkA_4 = $aAplic["apli_valor"]; $nomapli_4 = $aAplic["apli_nombre"];
            $cantNal_4 = $aAplic["apli_cantidadnacional"]; $cantImport_4 = $aAplic["apli_cantidadimportado"];
            $canttot_4 = $aAplic["apli_total"];            	
            break;
            case 5: 
            $chkA_5 = $aAplic["apli_valor"]; $nomapli_5 = $aAplic["apli_nombre"];
            $cantNal_5 = $aAplic["apli_cantidadnacional"]; $cantImport_5 = $aAplic["apli_cantidadimportado"];
            $canttot_5 = $aAplic["apli_total"];            	
            break;    
            case 6: 
            $chkA_6 = $aAplic["apli_valor"]; $nomapli_6 = $aAplic["apli_nombre"];
            $cantNal_6 = $aAplic["apli_cantidadnacional"]; $cantImport_6 = $aAplic["apli_cantidadimportado"];
            $canttot_6 = $aAplic["apli_total"];            	
            break; 
        }
    }
    
?>
<!-- begin body -->
<div class="content">
    <span id="statusACAP1"></span>
    <table class="dInf">

    <thead>
    <tr>
        <th>M&Oacute;DULO C</th>
        <th>USO Y ACCESO DE LAS TECNOLOG&Iacute;AS DE LA INFORMACI&Oacute;N Y COMUNICACI&Oacute;N (TIC)</th>
    </tr>
    </thead>   

    </table>
    
<form class="formA validable" action="ccap1Add.php" method="post" autocomplete="off" >
<fieldset>
    <p class="subT" >ACCESO A TECNOLOG&Iacute;AS DE INFORMACI&Oacute;N Y COMUNICACI&Oacute;N</p>
    <?php
    $sql = " SELECT frm2_ccap1_usoaccesotic.*, adm_definiciones.defi_subcapitulo as subcap, adm_definiciones.defi_indent as indent, adm_definiciones.defi_vinieta as vinieta "
          ." FROM frm2_ccap1_usoaccesotic LEFT JOIN  adm_definiciones ON ( usac_defi_uid = defi_uid ) "
          ." WHERE usac_regi_uid = '".$regisroUID."' ORDER BY CAST( adm_definiciones.defi_subcapitulo AS UNSIGNED ) ASC, adm_definiciones.defi_vinieta ASC ";
    $db->query( $sql );
    
    $showareainter = "style=\"display: none;\"";
    //echo $sql;
    while( $aDat = $db->next_record() ) {

    if( $aDat["subcap"] == 1 &&  $aDat["vinieta"] == '1' ) {    
    ?>
    <p>
        <span class="subT" >1. &iquest;Cu&aacute;ntas l&iacute;neas telef&oacute;nicas fijas tiene la empresa?</span>
        <span class="clear"></span>
        <input type="text" name="nrolineas" id="nrolineas" value="<?php echo number_format($aDat["usac_cantidad1"]); ?>" class="numeric inpC" />
    </p>
    <?php } ?>

    <?php if( $aDat["subcap"] == 2 &&  $aDat["vinieta"] == '1' ) { ?>
    <p>
        <span class="subT">2. &iquest;Cu&aacute;ntos celulares son provistos por la empresa a su personal?</span>
        <span class="clear"></span>
        <input type="text" name="nrocelular" id="nrocelular" value="<?php echo number_format($aDat["usac_cantidad1"]); ?>" class="numeric inpC" />
    </p>
    <?php } ?>

    <?php if( $aDat["subcap"] == 3 &&  $aDat["vinieta"] == '1' ) { ?>
    <p>
        <span class="subT">3. &iquest;La empresa utiliza equipo propio de comunicaciones de radioaficionado?</span>
        <span class="clear"></span>

        <input class="chk"  type="radio" name="rbtn_radioafi" id="rbtn_radioafi1" value="1" <?php if( $aDat["usac_valor"] == 1 ) { echo "checked=\"checked\""; } ?> />
        <label class="labChk" >Si</label>
        <span class="clear"></span>

        <input class="chk"  type="radio" name="rbtn_radioafi" id="rbtn_radioafi2" value="0" <?php if( !checkEmpty($aDat["usac_valor"]) && $aDat["usac_valor"] == 0  ) { echo "checked=\"checked\""; $mostrar1 = "style=\"display: none;\"";  } else { $mostrar1 = "style=\"display: block;\""; } ?> />
        <label class="labChk" >No</label>
    </p>
    <?php } ?>

    <?php if( $aDat["subcap"] == 4 &&  $aDat["vinieta"] == '1' ) { ?>
    <p>
        <span class="subT">4. &iquest;Cu&aacute;ntos computadores propios y/o alquilados tiene la empresa?</span>
        <span class="clear"></span>
        <input type="text" name="nro_pcs" id="nro_pcs" value="<?php echo number_format($aDat["usac_cantidad1"]); ?>" class="numeric inpC" />
    </p>        
    <?php } ?>

    <?php if( $aDat["subcap"] == 5 &&  $aDat["vinieta"] == '1' ) { ?>
    <p>
        <span class="subT">5. &iquest;La empresa cuenta con Internet?</span>
        <span class="clear"></span>

        <input class="chk"  type="radio" name="rbtn_usointer" id="rbtn_usointer1" value="1" <?php if( $aDat["usac_valor"] == 1 ) { echo "checked=\"checked\""; $showareainter = "style=\"display: block;\""; } ?> />
        <label class="labChk" >Si</label>
        <span class="clear"></span>

        <input class="chk"  type="radio" name="rbtn_usointer" id="rbtn_usointer2" value="0" <?php if( !checkEmpty($aDat["usac_valor"]) && $aDat["usac_valor"] == 0  ) { echo "checked=\"checked\""; $mostrar1 = "style=\"display: none;\"";  } else { $mostrar1 = "style=\"display: block;\""; } ?> />
        <label class="labChk" >No</label>
    </p>
    <?php } ?>

    <?php if( $aDat["subcap"] == 6 &&  $aDat["vinieta"] == '1' ) { ?>
    <p>
        <span class="subT">6. &iquest;La empresa cuenta con Intranet?</span>
        <span class="clear"></span>

        <input class="chk"  type="radio" name="rbtn_usointra" id="rbtn_usointra1" onclick="saveUPD(1);" value="1" <?php if( $aDat["usac_valor"] == 1 ) { echo "checked=\"checked\""; } ?> />
        <label class="labChk" >Si</label>
        <span class="clear"></span>

        <input class="chk"  type="radio" name="rbtn_usointra" id="rbtn_usointra2" onclick="saveUPD(1);" value="0" <?php if( !checkEmpty($aDat["usac_valor"]) && $aDat["usac_valor"] == 0  ) { echo "checked=\"checked\""; $mostrar1 = "style=\"display: none;\"";  } else { $mostrar1 = "style=\"display: block;\""; } ?> />
        <label class="labChk" >No</label>
    </p>
    <?php } ?>        

    <?php if( $aDat["subcap"] == 7 &&  $aDat["vinieta"] == "a" ) { ?>
    <div class="areainter" <?php echo $showareainter; ?> > <!-- ini areainter -->
    <p>
        <span class="subT">7. &iquest;Cu&aacute;l es el tipo de conexi&oacute;n a Internet utilizado?  (responda esta pregunta, s&oacute;lo si respondi&oacute; afirmativamente a la pregunta 5)</span>
        <span class="clear"></span>
    </p>
    <p>
        <input class="chk" type="checkbox" name="coninter_1" id="coninter_1" <?php if( $aDat["usac_valor"] == 1 ) { echo "checked=\"checked\""; } ?>  />
        <label class="labChkB" >a)  Modem empresas telefonicas</label>
        <span class="clear"></span>
    </p>
    <?php } ?>

    <?php if( $aDat["subcap"] == 7 &&  $aDat["vinieta"] == "b" ) { ?>
    <p>
        <input class="chk"  type="checkbox" name="coninter_2" id="coninter_2" <?php if( $aDat["usac_valor"] == 1 ) { echo "checked=\"checked\""; } ?>  />
        <label class="labChkB" >b)  Conexi&oacute;n ADSL, RDSI (ISDN)</label>
        <span class="clear"></span>
    </p>
    <?php } ?>

    <?php if( $aDat["subcap"] == 7 &&  $aDat["vinieta"] == "c" ) { ?>
    <p>
        <input class="chk"  type="checkbox" name="coninter_3" id="coninter_3" <?php if( $aDat["usac_valor"] == 1 ) { echo "checked=\"checked\""; } ?>  />
        <label class="labChkB" >c)  L&iacute;nea dedicada (Cable/fibra &oacute;ptica)</label>
        <span class="clear"></span>
    </p>
    <?php } ?>

    <?php if( $aDat["subcap"] == 7 &&  $aDat["vinieta"] == "d" ) { ?>
    <p>
        <input class="chk" type="checkbox" name="coninter_4" id="coninter_4" <?php if( $aDat["usac_valor"] == 1 ) { echo "checked=\"checked\""; } ?>  />
        <label class="labChkB" >d) Redes inalambricas WiFi, WiMax, etc.</label>
        <span class="clear"></span>
    </p>
    <?php } ?>
    
     <?php if( $aDat["subcap"] == 7 &&  $aDat["vinieta"] == "e" ) { ?>
     <p>
        <input class="chk" type="checkbox" name="coninter_5" id="coninter_5" <?php if( $aDat["usac_valor"] == 1 ) { echo "checked=\"checked\""; } ?>  />
        <label class="labChkB" >e) Otros (especificar)</label>        

        <?php if( $aDat["usac_valor"] == 1 ) { $mostrar2 = "style=\"display:block;\"";  } else { $mostrar2 = "style=\"display:none;\""; }?>
        <input class="inpC" name="coninter_otro" type="text" id="coninter_otro" onblur="saveUPD(1);" size="60" <?php echo $mostrar2; ?> value="<?php echo $aDat["usac_description"]; ?>"  />
        <span id="msg_coninterotro" class="bxEr" style="display:none" >Debe especificar el detalle para otros</span>
        
     </p>
     </div><!-- fin areainter -->
     <?php } ?>        

     <?php if( $aDat["subcap"] == 8 &&  $aDat["vinieta"] == "a" ) { ?>
     <div class="areainter" <?php echo $showareainter; ?> > <!-- ini areainter -->
     <p>
        <span class="subT">8. &iquest;Cu&aacute;l es el Ancho de Banda con el que cuenta la empresa para conectarse a internet?  (responda esta pregunta, s&oacute;lo si respondi&oacute; afirmativamente a la pregunta 5)</span>
        <span class="clear"></span>
     </p>
     <p>
        <input class="chk" type="checkbox" name="ancho_1" id="ancho_1" <?php if( $aDat["usac_valor"] == 1 ) { echo "checked=\"checked\""; } ?>  />
        <label class="labChkB" >a) Hasta 128  Kbps</label>
        <span class="clear"></span>
     </p>
     <?php } ?>

     <?php if( $aDat["subcap"] == 8 &&  $aDat["vinieta"] == "b" ) { ?>
     <p>
        <input class="chk"  type="checkbox" name="ancho_2" id="ancho_2" <?php if( $aDat["usac_valor"] == 1 ) { echo "checked=\"checked\""; } ?>  />
        <label class="labChkB" >b)  256  Kbps</label>
        <span class="clear"></span>
     </p>
     <?php } ?>

     <?php if( $aDat["subcap"] == 8 &&  $aDat["vinieta"] == "c" ) { ?>
     <p>   
        <input class="chk"  type="checkbox" name="ancho_3" id="ancho_3" <?php if( $aDat["usac_valor"] == 1 ) { echo "checked=\"checked\""; } ?>  />
        <label class="labChkB" >c)  512 Kbps</label>
        <span class="clear"></span>
     </p>
     <?php } ?>

     <?php if( $aDat["subcap"] == 8 &&  $aDat["vinieta"] == "d" ) { ?>
     <p>   
        <input class="chk" type="checkbox" name="ancho_4" id="ancho_4" <?php if( $aDat["usac_valor"] == 1 ) { echo "checked=\"checked\""; } ?>  />
        <label class="labChkB" >d) 1024 Kbps</label>
        <span class="clear"></span>
     </p>
     <?php } ?>

     <?php if( $aDat["subcap"] == 8 &&  $aDat["vinieta"] == "e" ) { ?>
     <p>   
        <input class="chk" type="checkbox" name="ancho_5" id="ancho_5" <?php if( $aDat["usac_valor"] == 1 ) { echo "checked=\"checked\""; } ?>  />
        <label class="labChkB" >e) 2048 Kbps</label>
        <span class="clear"></span>
     </p>
     <?php } ?>

     <?php if( $aDat["subcap"] == 8 &&  $aDat["vinieta"] == "f" ) { ?>
     <p>   
        <input class="chk" type="checkbox" name="ancho_6" id="ancho_6" <?php if( $aDat["usac_valor"] == 1 ) { echo "checked=\"checked\""; } ?>  />
        <label class="labChkB" >f) Otros (especificar)</label>        

        <?php if( $aDat["usac_valor"] == 1 ) { $mostrar2 = "style=\"display:block;\"";  } else { $mostrar2 = "style=\"display:none;\""; }?>
        <input class="inpC" name="ancho_otro" type="text" id="ancho_otro" onblur="saveUPD(1);" size="60" <?php echo $mostrar2; ?> value="<?php echo $aDat["usac_description"]; ?>"  />              
        <span id="msg_anchootro" class="bxEr" style="display:none" >Debe especificar el detalle para otros</span>
    </p>
    </div> <!-- fin areainter -->
    
    <table width="100%"  class="fOpt" >
    <thead>
    <tr>
        <th width="69%">&nbsp;</th>
        <th width="16%" align="center">Personal administrativo</th>
        <th width="15%" align="center">Personal de producci&oacute;n</th>
    </tr>
    </thead>
    <tbody>
    
    <?php } ?>

    <?php if( $aDat["subcap"] == 9 &&  $aDat["vinieta"] == '1' ) { ?>    
    <tr>             
        <td class="titR" >9. &iquest;Del personal de la empresa, cu&aacute;ntos utilizan computadoras en su rutina normal de trabajo?</td>          
        <td align="center"><input name="admA_1" type="text" id="admA_1" size="8" value="<?php echo number_format($aDat["usac_cantidad1"]); ?>" class="numeric inpB2" /><span id="div_inputA-1" class="bxEr" style="display:none" >requerido</span></td>
        <td align="center"><input name="admB_1" type="text" id="admB_1" size="8" value="<?php echo number_format($aDat["usac_cantidad2"]); ?>" class="numeric inpB2" /><span id="div_inputB-1" class="bxEr" style="display:none" >requerido</span></td>
    </tr>
    <?php } ?>

    <?php if( $aDat["subcap"] == 10 &&  $aDat["vinieta"] == '1' ) { ?> 
    <tr>
        <td class="titR">10.  &iquest;Del personal de la empresa, cu&aacute;ntos utilizan computadoras conectadas a Internet en su rutina normal de trabajo?</td>        
        <td align="center"><input name="admA_2" type="text" id="admA_2" size="8" value="<?php echo number_format($aDat["usac_cantidad1"]); ?>" class="numeric inpB2" /><span id="div_inputA-2" class="bxEr" style="display:none" >requerido</span></td>
        <td align="center"><input name="admB_2" type="text" id="admB_2" size="8" value="<?php echo number_format($aDat["usac_cantidad2"]); ?>" class="numeric inpB2" /><span id="div_inputB-2" class="bxEr" style="display:none" >requerido</span></td>
    </tr>
    <?php } ?>

    <?php if( $aDat["subcap"] == 11 &&  $aDat["vinieta"] == '1' ) { ?> 
    <tr>
        <td class="titR">11.  &iquest;Del personal de la empresa, cu&aacute;ntos tienen asignada una cuenta de correo electr&oacute;nico con nombre de dominio de la empresa?</td>        
        <td align="center"><input name="admA_3" type="text" id="admA_3" size="8" value="<?php echo number_format($aDat["usac_cantidad1"]); ?>" class="numeric inpB2" /><span id="div_inputA-3" class="bxEr" style="display:none" >requerido</span></td>
        <td align="center"><input name="admB_3" type="text" id="admB_3" size="8" value="<?php echo number_format($aDat["usac_cantidad2"]); ?>" class="numeric inpB2" /><span id="div_inputB-3" class="bxEr" style="display:none" >requerido</span></td>
    </tr>
    <?php } ?>

    <?php if( $aDat["subcap"] == 12 &&  $aDat["vinieta"] == '1' ) { ?>
    </tbody>
    </table>
    <p>
        <span class="subT">12. &iquest;El personal (administrativo, ejecutivo) o el propietario, utiliza internet para el desarrollo de las actividades de la empresa?</span>
        <span class="clear"></span>
        <input class="chk"  type="radio" name="rbtn_usointeradm" id="rbtn_usointeradm1" onclick="saveUPD(1);" value="1" <?php if( $aDat["usac_valor"] == 1 ) { echo "checked=\"checked\""; } ?> />
        <label class="labChk" >Si</label>
        <span class="clear"></span>
        <input class="chk"  type="radio" name="rbtn_usointeradm" id="rbtn_usointeradm2" onclick="saveUPD(1);" value="0" <?php if( !checkEmpty($aDat["usac_valor"]) && $aDat["usac_valor"] == 0  ) { echo "checked=\"checked\""; $mostrar1 = "style=\"display: none;\"";  } else { $mostrar1 = "style=\"display: block;\""; } ?> />
        <label class="labChk" >No</label>
    </p>
    <span id="opcionesinter" <?php //echo $mostrar1;  ?> >        
    <?php } ?>

    <?php if( $aDat["subcap"] == 13 &&  $aDat["vinieta"] == 'a' ) { ?>
    <p>
        <span class="subT">13.  &iquest;Para cu&aacute;l de las siguientes actividades, el personal o el propietario de la empresa, utiliza internet? (Se acepta respuesta m&uacute;ltiple)</span>
        <span class="clear"></span>
    
        <input class="chk" type="checkbox" name="activity_1" id="activity_1" <?php if( $aDat["usac_valor"] == 1 ) { echo "checked=\"checked\""; } ?> />
        <label class="labChkB" >a)   Realizar operaciones bancarias o acceder a otros servicios financieros</label>
        <span class="clear"></span>
    <?php } ?>

    <?php if( $aDat["subcap"] == 13 &&  $aDat["vinieta"] == 'b' ) { ?>
        <input class="chk" type="checkbox" name="activity_2" id="activity_2" <?php if( $aDat["usac_valor"] == 1 ) { echo "checked=\"checked\""; } ?> />
        <label class="labChkB" >b)  Recibir o realizar pedidos de bienes o servicios</label>
        <span class="clear"></span>
    <?php } ?>

    <?php if( $aDat["subcap"] == 13 &&  $aDat["vinieta"] == 'c' ) { ?>
        <input class="chk" type="checkbox" name="activity_3" id="activity_3" <?php if( $aDat["usac_valor"] == 1 ) { echo "checked=\"checked\""; } ?> />
        <label class="labChkB" >c)  Realizar ventas de bienes o servicios (niveles transaccionales de comercio electr&oacute;nico)</label>
        <span class="clear"></span>
    <?php } ?>

    <?php if( $aDat["subcap"] == 13 &&  $aDat["vinieta"] == 'd' ) { ?>
        <input class="chk" type="checkbox" name="activity_4" id="activity_4" <?php if( $aDat["usac_valor"] == 1 ) { echo "checked=\"checked\""; } ?> />
        <label class="labChkB" >d)  Realizar publicidad y promover bienes o servicios</label>
        <span class="clear"></span>
    <?php } ?>

    <?php if( $aDat["subcap"] == 13 &&  $aDat["vinieta"] == 'e' ) { ?>
        <input class="chk" type="checkbox" name="activity_5" id="activity_5" <?php if( $aDat["usac_valor"] == 1 ) { echo "checked=\"checked\""; } ?> />
        <label class="labChkB" >e)  Proporcionar otros servicios a los clientes</label>
        <span class="clear"></span>
    <?php } ?>

    <?php if( $aDat["subcap"] == 13 &&  $aDat["vinieta"] == 'f' ) { ?>
        <input class="chk" type="checkbox" name="activity_6" id="activity_6" <?php if( $aDat["usac_valor"] == 1 ) { echo "checked=\"checked\""; } ?> />
        <label class="labChkB" >f)  Enviar o recibir correo electr&oacute;nico</label>
        <span class="clear"></span>
    <?php } ?>

    <?php if( $aDat["subcap"] == 13 &&  $aDat["vinieta"] == 'g' ) { ?>
        <input class="chk" type="checkbox" name="activity_7" id="activity_7" <?php if( $aDat["usac_valor"] == 1 ) { echo "checked=\"checked\""; } ?> />
        <label class="labChkB" >g)  Otras b&uacute;squedas de informaci&oacute;n</label>
        <span class="clear"></span>    
    </p>
    <span id="msgacti" class="bxEr" style="display:none" >Debe seleccionar un item para el punto 4</span>

    </span>
    <?php } ?>

    <?php if( $aDat["subcap"] == 14 &&  $aDat["vinieta"] == '1' ) { ?>
    <p>
        <span class="subT">14. &iquest;La empresa tiene SITIO WEB?</span>
        <span class="clear"></span>

        <input class="chk"  type="radio" name="rbtn_web" id="rbtn_web1" value="1" <?php if( $aDat["usac_valor"] == 1 ) { echo "checked=\"checked\""; } ?> />
        <label class="labChk" >Si</label>
        <span class="clear"></span>

        <input class="chk"  type="radio" name="rbtn_web" id="rbtn_web2" value="0" <?php if( !checkEmpty($aDat["usac_valor"]) && $aDat["usac_valor"] == 0  ) { echo "checked=\"checked\""; $mostrar1 = "style=\"display: none;\"";  } else { $mostrar1 = "style=\"display: block;\""; } ?> />
        <label class="labChk" >No</label>
    </p>
    <?php } ?>
    <?php } ?>
    
    <span class="subT">15. La empresa utiliza alg&uacute;n(os) programa(s) o paquete(s) de software para realizar:</span>
    <table width="100%"  class="fOpt" >
    <thead>
        <tr>
            <th width="23%">&nbsp;</th>
            <th width="23%">NOMBRE DEL SOFTWARE (PROGRAMA)</th>
            <th width="18%" align="center">Cantidad de software de origen Nacional</th>
            <th width="17%" align="center">Cantidad de software de origen Importado</th>
            <th width="9%" align="center">Total</th>
        </tr>
    </thead>
    <tbody>
        <tr>       
            <td class="titR" >a) Gesti&oacute;n Contable y/o financiera</td>
            <td align="center"><input name="B_1" type="text" id="B_1" size="30" value="<?php echo $nomapli_1; ?>" class="inpC2" /><span id="div_nomprog_1" class="bxEr" style="display:none" >requerido</span></td>
            <td align="center"><input name="C_1" type="text" id="C_1" size="8" value="<?php echo number_format($cantNal_1); ?>" class="numeric inpB2" /><span id="div_inputA-1" class="bxEr" style="display:none" >requerido</span></td>
            <td align="center"><input name="D_1" type="text" id="D_1" onblur="saveUPD(1);" size="8" value="<?php echo number_format($cantImport_1); ?>" class="numeric inpB2" /><span id="div_inputB-1" class="bxEr" style="display:none" >requerido</span></td>
            <td align="right"><span id="tot_1" class="labB"><?php echo number_format($canttot_1); ?></span></td>
        </tr>
        <tr>
            <td class="titR">b) Gesti&oacute;n y control de personal</td>
            <td align="center"><input name="B_2" type="text" id="B_2" size="30" value="<?php echo $nomapli_2; ?>" class="inpC2" /><span id="div_nomprog_2" class="bxEr" style="display:none" >requerido</span></td>
            <td align="center"><input name="C_2" type="text" id="C_2" size="8" value="<?php echo number_format($cantNal_2); ?>" class="numeric inpB2" /><span id="div_inputA-2" class="bxEr" style="display:none" >requerido</span></td>
            <td align="center"><input name="D_2" type="text" id="D_2"  size="8" value="<?php echo number_format($cantImport_2); ?>" class="numeric inpB2" /><span id="div_inputB-2" class="bxEr" style="display:none" >requerido</span></td>
            <td align="right"><span id="tot_2" class="labB"><?php echo number_format($canttot_2); ?></span></td>
        </tr>
        <tr>
            <td class="titR">c) Manejo de inventarios y/o almacenes</td>
            <td align="center"><input name="B_3" type="text" id="B_3" size="30" value="<?php echo $nomapli_3; ?>" class="inpC2" /><span id="div_nomprog_3" class="bxEr" style="display:none" >requerido</span></td>
            <td align="center"><input name="C_3" type="text" id="C_3" size="8" value="<?php echo number_format($cantNal_3); ?>" class="numeric inpB2" /><span id="div_inputA-3" class="bxEr" style="display:none" >requerido</span></td>
            <td align="center"><input name="D_3" type="text" id="D_3" onblur="saveUPD(1);" size="8" value="<?php echo number_format($cantImport_3); ?>" class="numeric inpB2" /><span id="div_inputB-3" class="bxEr" style="display:none" >requerido</span></td>
            <td align="right"><span id="tot_3" class="labB"><?php echo number_format($canttot_3); ?></span></td>
        </tr>
        <tr>
            <td class="titR">d) Ventas</td>
            <td align="center"><input name="B_4" type="text" id="B_4" size="30" value="<?php echo $nomapli_4; ?>" class="inpC2" /><span id="div_nomprog_4" class="bxEr" style="display:none" >requerido</span></td>
            <td align="center"><input name="C_4" type="text" id="C_4" size="8" value="<?php echo number_format($cantNal_4); ?>" class="numeric inpB2" /><span id="div_inputA-4" class="bxEr" style="display:none" >requerido</span></td>
            <td align="center"><input name="D_4" type="text" id="D_4" size="8" value="<?php echo number_format($cantImport_4); ?>" class="numeric inpB2" /><span id="div_inputB-4" class="bxEr" style="display:none" >requerido</span></td>
            <td align="right"><span id="tot_4" class="labB"><?php echo number_format($canttot_4); ?></span></td>
        </tr>
        <tr>
            <td class="titR">e) Planificaci&oacute;n y programaci&oacute;n de la producci&oacute;n</td>
            <td align="center"><input name="B_5" type="text" id="B_5" size="30" value="<?php echo $nomapli_5; ?>" class="inpC2" /><span id="div_nomprog_5" class="bxEr" style="display:none" >requerido</span></td>
            <td align="center"><input name="C_5" type="text" id="C_5" size="8" value="<?php echo number_format($cantNal_5); ?>" class="numeric inpB2" /><span id="div_inputA-5" class="bxEr" style="display:none" >requerido</span></td>
            <td align="center"><input name="D_5" type="text" id="D_5" onblur="saveUPD(1);" size="8" value="<?php echo number_format($cantImport_5); ?>" class="numeric inpB2" /><span id="div_inputB-5" class="bxEr" style="display:none" >requerido</span></td>
            <td align="right"><span id="tot_5" class="labB"><?php echo number_format($canttot_5); ?></span></td>
        </tr>
        <tr>
            <td class="titR">f) Otros</td>
            <td align="center"><input name="B_6" type="text" id="B_6" size="30" value="<?php echo $nomapli_6; ?>" class="inpC2" /></td>
            <td align="center"><input name="C_6" type="text" id="C_6" size="8" value="<?php echo number_format($cantNal_6); ?>" class="numeric inpB2" /></td>
            <td align="center"><input name="D_6" type="text" id="D_6" size="8" value="<?php echo number_format($cantImport_6); ?>" class="numeric inpB2" /></td>
            <td align="right"><span id="tot_6" class="labB"><?php echo number_format($canttot_6); ?></span></td>
        </tr>
    </tbody>
    </table>

    <span id="msg3" class="bxEr" style="display: none;" >Debe registrar el valor para el dato introducido</span>
    <span id="msg6" class="bxEr" style="display: none;" >Debe registrar el detalle para el valor introducido</span>

    <span class="bxBt">
        <input type="submit" value="SIGUIENTE" id="sendData" name="continuarregistro" class="button" >
        <a href="bcap3.php" class="btnS">ANTERIOR</a>                
    </span>

  </fieldset>
  </form>
  <div class="clear"></div>      

</div>
<!-- end body -->
<?php include("footer.php") ?>