<?php session_start(); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
?>
<?php include_once('../verifyLogin.php'); ?>
<?php include("header.php") ?>
<script type="text/javascript" src="js/acap1.js"></script>
<?php
/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$sql = "SELECT * FROM cap1_informacion_general WHERE inge_regi_uid = '".$regisroUID."' AND inge_formulario = '".$uidFormulario."' AND inge_delete <> 1 ";
$db->query( $sql );
$aInfoGen = $db->next_record();
?>
<?php include("../menu.php"); ?>
<!-- begin body -->
<div class="content">           
<span id="statusACAP1"></span>
    <table class="dInf">

        <thead>
            <tr>
                <th>CAP&Iacute;TULO 1</th>
                <th>IDENTIFICACI&Oacute;N Y UBICACI&Oacute;N DE LA EMPRESA</th>
            </tr>
        </thead>

    </table>

    <form class="formA validable" action="acap1Add.php" method="post" autocomplete="off" >
        <fieldset>
            <p>
              <span class="subT">1. Raz&oacute;n social:</span>
              <span class="clear"></span>            
              <input type="text" name="ai_rs" id="ai_rs" onblur="javascript:saveUPD(1); return false;" value="<?php echo $aInfoGen["inge_razonsocial"] ?>"  size="40" class="inpC alphanum required">
              <span id="div_ai_rs" class="bxEr" style="display:none" >requerido</span>
              <span id="div_ai_rs_2" class="bxEr" style="display:none" >inválido</span>
              <span id="msg_ai_rs"><?php echo OPERATOR::getDescTitles(2,'A',1,1); ?></span>
            </p>                        
            
            <p>
                <span class="subT">2. Tipo Societario:</span>
                <span class="clear"></span>             
                <select name="ai_societario" id="ai_societario" class="required" >
                    <option value="" >Seleccionar</option>
                    <?php
                    $sql = "SELECT tiso_uid, tiso_description FROM par_tipos_societarios WHERE tiso_sw_active = 'ACTIVE' AND tiso_delete = 0 ORDER BY tiso_description ASC";
                    $db->query($sql);
                    while ($aSocietario = $db->next_record()) {
                        ?>
                        <option value="<?php echo $aSocietario["tiso_uid"] ?>"  <?php if ($aInfoGen["inge_tiso_uid"] == $aSocietario["tiso_uid"]) {
                        print("selected=\"selected\"");
                    } ?>  ><?php echo $aSocietario["tiso_description"] ?></option>                
                    <?php } ?>
                </select>
                <span id="div_ai_societario" class="bxEr" style="display:none" >requerido</span>                
            </p>

            <p>
              <span class="subT">3. Nombre Comercial:</span>
              <span class="clear"></span>               
              <input type="text" name="ai_tradename" id="ai_tradename" value="<?php echo $aInfoGen["inge_nombrecomercial"] ?>" size="40" class="inpC required alphanum">
              <span id="div_ai_tradename" class="bxEr" style="display:none" >requerido</span>
              <span id="div_ai_tradename_2" class="bxEr" style="display:none" >inválido</span>
              <span id="msg_ai_tradename"><?php echo OPERATOR::getDescTitles(2,'A',1,3); ?></span>
            </p>

            <p>
                <span class="subT">4. NIT:</span>
                <span class="clear"></span>                
                <input type="text" name="ai_nit" id="ai_nit" value="<?php echo $aInfoGen["inge_nit"] ?>" size="40" class="inpC required integer" maxlength="12" >
                <span id="div_ai_nit" class="bxEr" style="display:none" >requerido</span>
                <span id="div_ai_nit_2" class="bxEr" style="display:none" >inválido</span>
            </p>
            
            <p>
                <span class="subT">5. N&uacute;mero de Matr&iacute;cula de Comercio:</span>
                <span class="clear"></span>                
                <input type="text" name="ai_traderegis" id="ai_traderegis" value="<?php echo $aInfoGen["inge_matriculadecomercio"] ?>" size="40" class="inpC required integer" maxlength="8" >
                <span id="div_ai_traderegis" class="bxEr" style="display:none" >requerido</span>
                <span id="div_ai_traderegis_2" class="bxEr" style="display:none" >inválido</span>
            </p>           
            
            <p>
                <span class="subT">6. RAI - Registro Ambiental Industrial:</span>
                <span class="clear"></span>                
                <input type="text" name="ai_rai" id="ai_rai" onblur="javascript:saveUPD(1); return false;" value="<?php echo $aInfoGen["inge_rai"] ?>" size="40" class="inpC required" maxlength="50" >
                <span id="div_ai_rai" class="bxEr" style="display:none" >requerido</span>                
            </p>

            <p>
                <span class="subT">7. Localizaci&oacute;n y Direcci&oacute;n de la Empresa:</span>
                <span class="clear"></span> 
            </p>

            <p>
                <span class="subT">Departamento:</span>
                <span class="clear"></span>                 
                
                <select name="ai_depto" id="ai_depto" onchange="showMunicipios();" class="required" >
              	<option value="" >Seleccionar</option>
                <?php 
                $sql = "SELECT dept_uid, dept_description FROM  par_departamentos WHERE delete_status = 'ACTIVE' AND dept_delete = 0 ORDER BY dept_description ASC" ;
                $db->query( $sql );
                while( $aDepto = $db->next_record() ) {
                ?>
                <option value="<?php echo $aDepto["dept_uid"] ?>" <?php if($aInfoGen["inge_depa_uid"] == $aDepto["dept_uid"] ){print("selected=\"selected\"");} ?> ><?php echo $aDepto["dept_description"] ?></option>                
                <?php } ?>
                </select>
                <span id="div_ai_depto" class="bxEr" style="display:none" >requerido</span>
            </p>
                        
            <p>
                <span class="subT">Municipio:</span>
                <span class="clear"></span>                 
                <span id="areamunicipio" >
                <?php 
                $sql = "SELECT * FROM par_municipios WHERE muni_dept_uid = '".$aInfoGen["inge_depa_uid"]."' AND muni_swactive = 'ACTIVE' AND	muni_delete = 0 ORDER BY muni_description ASC" ;
                $db->query( $sql );                
                ?>
                    <select name="ai_municipio" id="ai_municipio" class="required" >
                    <option value="" >Seleccionar</option>                
                    
                    <?php while( $aMun = $db->next_record($sql) ){ ?>
                    <option value="<?php echo $aMun["muni_uid"] ?>" <?php if($aInfoGen["inge_muni_uid"] == $aMun["muni_uid"] ){print("selected=\"selected\"");} ?> ><?php echo $aMun["muni_description"] ?></option>
                    <?php } ?>
                    </select>
                </span>
                
                <span id="div_ai_municipio" class="bxEr" style="display:none" >requerido</span>
            </p>
            
            <p>
                <span class="subT">Ciudad:</span>
                <span class="clear"></span>                
                <input type="text" name="ai_city" id="ai_city" value="<?php echo $aInfoGen["inge_ciudad"] ?>" size="40" class="inpC required alphanum">
                <span id="div_ai_city" class="bxEr" style="display:none" >requerido</span>
                <span id="div_ai_city_2" class="bxEr" style="display:none" >inválido</span>
            </p>
            
            <p>
                <span class="subT">Zona / Barrio:</span>
                <span class="clear"></span>                 
                <input type="text" name="ai_zona" id="ai_zona"  value="<?php echo $aInfoGen["inge_zona"] ?>" size="40" class="inpC required alphanum">
                <span id="div_ai_zona" class="bxEr" style="display:none" >requerido</span>
                <span id="div_ai_zona_2" class="bxEr" style="display:none" >inválido</span>
            </p>

            <p>
                <span class="subT">Calle / Avenida y N&deg;:</span>
                <span class="clear"></span>                 
                <input type="text" name="ai_address" onblur="javascript:saveUPD(1); return false;" value="<?php echo $aInfoGen["inge_calle"] ?>" size="40" class="inpC required alphanum" id="ai_address">
                <span id="div_ai_address" class="bxEr" style="display:none" >requerido</span>
                <span id="div_ai_address_2" class="bxEr" style="display:none" >inválido</span>
            </p>

            <p>
                <span class="subT">Referencia (entre qu&eacute; calles):</span>
                <span class="clear"></span>               
              <textarea name="ai_reference" cols="60" rows="3" style="height:80px;" class="inpC required" id="ai_reference"><?php echo $aInfoGen["inge_referenciacalle"] ?></textarea>
                <span id="div_ai_reference" class="bxEr" style="display:none" >requerido</span>
                <span id="div_ai_reference_2" class="bxEr" style="display:none" >inválido</span>
            </p>

            <p>
                <span class="subT">8. Tel&eacute;fono:</span>
                <span class="clear"></span>                  
                <input type="text" name="ai_phone1" id="ai_phone1"  value="<?php echo $aInfoGen["inge_telefono"] ?>" size="40" class="inpC integer">
                <span id="div_ai_phone1" class="bxEr" style="display:none" >requerido</span>
                <span id="div_ai_phone1_2" class="bxEr" style="display:none" >inválido</span>
            </p>

            <p>
                <span class="subT">9. Celular:</span>
                <span class="clear"></span>                 
                <input type="text" name="ai_phone2" id="ai_phone2" value="<?php echo $aInfoGen["inge_celular"] ?>" size="40" class="inpC integer">
                <span id="div_ai_phone2" class="bxEr" style="display:none" >requerido</span>
                <span id="div_ai_phone2_2" class="bxEr" style="display:none" >inválido</span>
            </p>
            
            <p>
                <span class="subT">10. Fax:</span>
                <span class="clear"></span>                  
                <input type="text" name="ai_fax" id="ai_fax"  value="<?php echo $aInfoGen["inge_fax"] ?>" size="40" class="inpC integer">
                <span id="div_ai_fax" class="bxEr" style="display:none" >requerido</span>
                <span id="div_ai_fax_2" class="bxEr" style="display:none" >inválido</span>
            </p>
            
            <p>
                <span class="subT">11. P&aacute;gina Web:</span>
                <span class="clear"></span>                  
                <input type="text" name="ai_pagweb" id="ai_pagweb"  value="<?php echo $aInfoGen["inge_pagweb"] ?>" size="40" class="inpC alphanum">
                <span id="div_ai_pagweb" class="bxEr" style="display:none" >requerido</span>
                <span id="div_ai_pagweb_2" class="bxEr" style="display:none" >inválido</span>
            </p>
            
            <p>
                <span class="subT">12. Correo electr&oacute;nico alternativo:</span>
                <span class="clear"></span>                 
                <input type="text" name="ai_email" id="ai_email" onblur="javascript:saveUPD(1); return false;" value="<?php echo $aInfoGen["inge_email"] ?>" size="40" class="inpC email">
                <span id="div_ai_email" class="bxEr" style="display:none" >requerido</span>
                <span id="div_ai_email_2" class="bxEr" style="display:none" >inválido</span>
            </p>
            
            
            <!-- add -->
            <span class="subT">13. Direcciones de las Plantas o F&aacute;bricas (se refiere a las plantas productivas que se sit&aacute;an en direcciones diferentes a la ubicaci&oacute;n de la oficina central):</span>
            <table width="100%" border="0" id="tablecertificacion" class="fOpt">
            <thead>
              <tr>
              <th width="50%" align="center">Direcci&oacute;n</th>
              <th width="40%" align="center">Municipio</th>              
              <th width="10%" align="center">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
            <?php
            $posmax = OPERATOR::getDbValue("SELECT MAX(plan_position) + 1 as pos FROM frm1_plantas WHERE plan_regi_uid = '".$regisroUID."' AND plan_position <> 0");
            if( empty($posmax) ) { $posmax = 1; }
                
            $sql3 = "SELECT * FROM frm1_plantas WHERE plan_regi_uid = '".$regisroUID."' AND plan_delete = 0 ORDER BY plan_position ASC  ";
            //echo $sql3;
            $db3->query( $sql3 );
            if( $db3->numrows() > 0 ) {
            while( $aCert2 = $db3->next_record() ) {
                $pos = $aCert2["plan_position"];
            ?>
            <tr id="row_<?php echo $pos; ?>" >
              <td align="center"><input name="inputA_<?php echo $pos ?>" type="text" id="inputA_<?php echo $pos ?>" size="50" value="<?php echo $aCert2["plan_direccion"] ?>" class="inpC2" /></td>
              <td align="center"><input name="inputB_<?php echo $pos ?>" type="text" id="inputB_<?php echo $pos ?>" size="40" value="<?php echo $aCert2["plan_municipio"] ?>" onblur="saveUPD(6);" class="inpC2" /></td>              
              <td align="center"><a href="#" class="lnkCls" id="delplan_<?php echo $aCert2["plan_position"] ?>" onclick="delRow('<?php echo $pos ?>'); return false;" >eliminar</a></td>
            </tr>            
            <?php }                            
            } else {                
            ?>
            <tr id="row_<?php echo $posmax; ?>" >
              <td align="center"><input name="inputA_<?php echo $posmax; ?>" type="text" id="inputA_<?php echo $posmax; ?>" size="50" class="inpC2"  /></td>
              <td align="center"><input name="inputB_<?php echo $posmax; ?>" type="text" id="inputB_<?php echo $posmax; ?>" size="40" class="inpC2" onblur="saveUPD(6);"  /></td>              
              <td align="center">&nbsp;</td>
            </tr>    
            <?php 
            $posmax = $posmax + 1;
            } ?>

            </tbody>            

            </table>
            <input type="hidden" name="maxrow" id="maxrow" value="<?php echo $posmax; ?>" />
            <a href="#" id="addcertificacion" class="btnAdd"  >Agregar campos</a>
            <!-- end add -->
            
            <p>
                <span class="subT">14. Afiliaci&oacute;n de la empresa:</span>
                <span class="clear"></span>   
                <input type="checkbox" class="chk" name="afil_1" id="afil_1"  onclick="showAfilCamara();" <?php $show1 = "style=\"display: none\""; if( !empty($aInfoGen["inge_afiliacion_camara"] ) ) { print("checked=\"checked\""); $show1 = "style=\"display: block\"";  } ?> />
                <label class="labChk">a) C&aacute;mara</label>
                <input type="text" class="inpC" size="40"  name="afil_camara" id="afil_camara"  value="<?php echo $aInfoGen["inge_afiliacion_camara"] ?>"  <?php echo $show1;  ?>   />
                <span class="clear"></span>

                <input type="checkbox" class="chk" name="afil_2" id="afil_2"  onclick="showAfilFederacion();" <?php $show2 = "style=\"display: none\"";  if( !empty($aInfoGen["inge_afiliacion_federacion"] ) ) { print("checked=\"checked\""); $show2 = "style=\"display: block\""; } ?> />
                <label class="labChk">b) Federaci&oacute;n</label>
                <input type="text" class="inpC" size="40" name="afil_federacion" id="afil_federacion"  value="<?php echo $aInfoGen["inge_afiliacion_federacion"] ?>"  <?php echo $show2;  ?>  />
                <span class="clear"></span>

                <input type="checkbox" class="chk" name="afil_3" id="afil_3"  onclick="showAfilAsociacion();" <?php $show2 = "style=\"display: none\"";  if( !empty($aInfoGen["inge_afiliacion_asociacion"] ) ) { print("checked=\"checked\""); $show2 = "style=\"display: block\""; } ?> />
                <label class="labChk">c) Asociaci&oacute;n</label>
                <input type="text" class="inpC" size="40" name="afil_asociacion"  id="afil_asociacion" value="<?php echo $aInfoGen["inge_afiliacion_asociacion"] ?>"  <?php echo $show2;  ?>  />
                <span class="clear"></span>

                <input type="checkbox" class="chk" name="afil_6" id="afil_6" onclick="showSindicato();" <?php $show4 = "style=\"display: none\""; if( !empty($aInfoGen["inge_afiliacion_sindicato"] ) ) { print("checked=\"checked\""); $show4 = "style=\"display: block\""; }  ?> />
                <label class="labChk">d) Sindicato</label>
                <input type="text" class="inpC" size="40" name="afil_sindicato" id="afil_sindicato" value="<?php echo $aInfoGen["inge_afiliacion_sindicato"] ?>" <?php echo $show4;  ?>  >
                <span class="clear"></span>
                
                <input type="checkbox" class="chk" name="afil_4" id="afil_4" onclick="showAfilOtros();" <?php $show3 = "style=\"display: none\""; if( !empty($aInfoGen["inge_afiliacion_otros"] ) ) { print("checked=\"checked\""); $show3 = "style=\"display: block\""; }  ?> />
                <label class="labChk">e) Otros</label>
                <input type="text" class="inpC" size="40" name="afil_otros" id="afil_otros"  value="<?php echo $aInfoGen["inge_afiliacion_otros"] ?>"  <?php echo $show3;  ?>  >
                <span class="clear"></span>

                <input type="checkbox" class="chk" name="afil_5" id="afil_5" onclick="showAfilNinguno();" <?php if( !empty($aInfoGen["inge_afilia_ninguno"] ) ) { print("checked=\"checked\""); } ?> />
                <label class="labChk">f) Ninguno</label>
                <span style="display:none;" class="bxEr" id="div_ai_afil1" >Debe selecionar un &iacute;tem</span>
            </p>

                    

            <p>
                <span class="subT">15. Actividad Principal y Secundaria de la empresa (especificar):</span>
                <span class="clear"></span>              
            </p>
            <p>
            <span id="msg_actividades"><?php echo OPERATOR::getDescTitles(2,'A',1,13); ?></span>
            </p>
                              
            <p>
                <span class="subT">a) Actividad Principal:</span>
                <span class="clear"></span>               
                <input type="text" name="ai_actprin" onblur="javascript:saveUPD(1); return false;" id="ai_actprin" value="<?php echo $aInfoGen["inge_actividad_principal"] ?>" size="40" class="inpC alphanum required">
                <span id="div_ai_actprin" class="bxEr" style="display:none" >requerido</span>
                
            </p>
            
            <p>
                <span class="subT">b) Actividad Secundaria 1:</span>
                <span class="clear"></span>                  
                <input type="text" name="ai_actsec1" id="ai_actsec1" value="<?php echo $aInfoGen["inge_actividad_secundaria1"] ?>" size="40" class="inpC alphanum">
                <span id="div_ai_actprin" class="bxEr" style="display:none" >requerido</span>
                
            </p>
            
            <p>
                <span class="subT">c) Actividad Secundaria 2:</span>
                <span class="clear"></span>                 
                <input type="text" name="ai_actsec2" id="ai_actsec2" value="<?php echo $aInfoGen["inge_actividad_secundaria2"] ?>" size="40" class="inpC alphanum">
                <span id="div_ai_actsec2" class="bxEr" style="display:none" >requerido</span>
            </p>
            
            <p>&nbsp;</p>
                        
            <span class="bxBt">
            <input type="submit" value="SIGUIENTE" id="sendData" name="continuarregistro" class="button" >
            <a href="../option.php" class="btnS">ANTERIOR</a>                
            </span>

        </fieldset>
    </form>
    <div class="clear"></div>      

</div>
<!-- end body -->        
<?php include("footer.php") ?>