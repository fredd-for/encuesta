<?php session_start(); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php'); ?>
<?php include("header.php") ?>
<script type="text/javascript" src="js/acap2.js"></script>
<?php 
/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

//crear registros para sueldos
$sql = "SELECT * FROM cap2_personalsueldos WHERE pesu_regi_uid = '".$regisroUID."' ";
$db->query( $sql );
if( $db->numrows() == 0 ) {
    // obtener el uid del token
    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    $sql2 = "SELECT * FROM adm_definiciones WHERE defi_form_uid = '".$uidFormulario."'  AND defi_modulo = 'a' AND  defi_capitulo = '2' AND defi_subcapitulo = '1' AND defi_swactive = 'ACTIVE'";
    $db2->query( $sql2 );
    while( $aDefinicion =  $db2->next_record() ) {        
        $sql = "INSERT INTO cap2_personalsueldos SET ";
        $sql .= "pesu_regi_uid  = '".$regisroUID."', ";
        $sql .= "pesu_defi_uid 	 = '".$aDefinicion["defi_uid"]."', ";
        $sql .= "pesu_numero_hombres = 0, ";
        $sql .= "pesu_numero_mujeres = 0, ";
        $sql .= "pesu_sueldos_salarios = 0, "; 
        $sql .= "pesu_suv_uid = '".$uid_token."', "; 
        $sql .= "pesu_date_create = NOW(), "; 
        $sql .= "pesu_date_update = NOW() ";                          	 	
        $db3->query( $sql );
    }
}

$sql = " SELECT cap2_personalsueldos.*, adm_definiciones.defi_indent as indent, adm_definiciones.defi_vinieta		 as vinieta "
      ." FROM cap2_personalsueldos LEFT JOIN  adm_definiciones ON ( pesu_defi_uid	 = defi_uid ) "
      ." WHERE pesu_regi_uid = '".$regisroUID."' ORDER BY adm_definiciones.defi_indent ASC,  adm_definiciones.defi_vinieta	 ASC ";
$db->query( $sql );

//echo $sql;
?>

<!-- begin body -->
<div class="content">
    <span id="statusACAP1"></span>
    <span class="subT" >
    A partir de este cap&iacute;tulo llene la informaci&oacute;n correspondiente a la gesti&oacute;n 2012. (Coloque los valores en bolivianos sin centavos)    
    </span>
    
    <table class="dInf">
    <thead>
    <tr>
        <th>Cap&iacute;tulo 2</th>
        <th>PERSONAL OCUPADO, SUELDOS Y SALARIOS</th>
    </tr>
    </thead>
    <tbody>
        <tr>                        
            <td colspan="2"><?php echo OPERATOR::getDescTitles(2,'A',2,0); ?></td>
        </tr>
    </tbody>
    </table>        
    
                         
    <form class="formA validable" action="acap2Add.php" method="post" autocomplete="off" >
      <fieldset> 
            <span class="subT">2.1 Personal Ocupado</span>
            <table width="100%" class="fOpt" >
                <thead>
                <tr>
                    <th align="center">&nbsp;</th>
                    <th colspan="2" align="center" >N&uacute;mero de personas de la gesti&oacute;n</th>                    
                    <th align="center">Sueldos y salarios de la gesti&oacute;n (Bs/Anual)</th>
                </tr>                
                </thead>
                                                
                <tbody>
                <tr>
                    <td align="center" class="titR" >&nbsp;</td>
                    <td align="center" class="titR">Hombres</td>
                    <td align="center" class="titR">Mujeres</td>
                    <td align="center" class="titR">&nbsp;</td>
                </tr>
                <?php 
                while( $aSueldos = $db->next_record() ) {
                ?>
                
                <?php if( $aSueldos["indent"] == '0' && $aSueldos["vinieta"] == "0" ) { ?>
                <tr>
                    <td width="40%" class="titR" >1. Personal permanente (fijo)</td>
                    <td width="20%" align="right" ><label class="labB" id="perTH"><?php echo number_format($aSueldos["pesu_numero_hombres"]) ?></label></td>
                    <td width="20%" align="right" ><label class="labB" id="perTM"><?php echo number_format($aSueldos["pesu_numero_mujeres"]) ?></label></td>
                    <td width="20%" align="right" ><label class="labB" id="perTS"><?php echo number_format($aSueldos["pesu_sueldos_salarios"]) ?></label></td>
                </tr>                
                <?php } ?>
                
                <?php if( $aSueldos["indent"] == '1' && $aSueldos["vinieta"] == "1" ) { ?>
                <tr>
                  <td class="titR" >1.1 Obreros</td>
                  <td align="right"><input type="text" name="A1" id="A1" value="<?php echo $aSueldos["pesu_numero_hombres"] ?>" size="20" maxlength="5" class="inpB2 numeric" /></td>
                  <td align="right"><input type="text" name="B1" id="B1" value="<?php echo $aSueldos["pesu_numero_mujeres"] ?>" size="20" maxlength="5" class="inpB2 numeric " /></td>
                  <td align="right"><input type="text" name="C1" onblur="javascript:saveUPD(1); return false;" id="C1" value="<?php echo $aSueldos["pesu_sueldos_salarios"] ?>" size="20" class="inpB2 numeric" /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aSueldos["indent"] == '1' && $aSueldos["vinieta"] == "2" ) { ?>
                <tr>
                  <td class="titR" >1.2 Supervisores,  jefes de planta y/o producci&oacute;n</td>
                  <td align="right"><input type="text" name="A2" id="A2" value="<?php echo $aSueldos["pesu_numero_hombres"] ?>" size="20" maxlength="5" class="inpB2 numeric" /></td>
                  <td align="right"><strong>
                  <input type="text" name="B2" id="B2" value="<?php echo $aSueldos["pesu_numero_mujeres"] ?>" size="20" maxlength="5" class="inpB2 numeric" />
                  </strong></td>
                  <td align="right"><input type="text" name="C2" onblur="javascript:saveUPD(2); return false;" id="C2" value="<?php echo $aSueldos["pesu_sueldos_salarios"] ?>" size="20" class="inpB2 numeric" /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aSueldos["indent"] == '1' && $aSueldos["vinieta"] == "3" ) { ?>
                <tr>
                  <td class="titR" >1.3 Personal administrativo y de ventas (empleados)</td>
                  <td align="right"><input type="text" name="A3" id="A3" value="<?php echo $aSueldos["pesu_numero_hombres"] ?>" size="20" maxlength="5" class="inpB2 numeric" /></td>
                  <td align="right"><input type="text" name="B3" id="B3" value="<?php echo $aSueldos["pesu_numero_mujeres"] ?>" size="20" maxlength="5" class="inpB2 numeric" /></td>
                  <td align="right"><input type="text" name="C3" onblur="javascript:saveUPD(3); return false;" id="C3" value="<?php echo $aSueldos["pesu_sueldos_salarios"] ?>" size="20" class="inpB2 numeric" /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aSueldos["indent"] == '1' && $aSueldos["vinieta"] == "4" ) { ?>
                <tr>
                  <td class="titR" >1.4 Gerentes y/o personal directivo</td>
                  <td align="right"><input type="text" name="A4" id="A4" value="<?php echo $aSueldos["pesu_numero_hombres"] ?>" size="20" maxlength="5" class="inpB2 numeric" /></td>
                  <td align="right"><input type="text" name="B4" id="B4" value="<?php echo $aSueldos["pesu_numero_mujeres"] ?>" size="20" maxlength="5" class="inpB2 numeric" /></td>
                  <td align="right"><input type="text" name="C4" onblur="javascript:saveUPD(4); return false;" id="C4" value="<?php echo $aSueldos["pesu_sueldos_salarios"] ?>" size="20" class="inpB2 numeric" /></td>
                </tr>                
                <?php } ?>
                
                <?php if( $aSueldos["indent"] == '2' && $aSueldos["vinieta"] == "0" ) { ?>
                <tr>
                    <td class="titR" >2. Personal eventual</td>
                    <td align="right"><input type="text" name="A5" id="A5" value="<?php echo $aSueldos["pesu_numero_hombres"] ?>" maxlength="5" size="20" class="inpB2 numeric">
                        <span id="div_peventualH" class="bxEr" style="display:none" >requerido</span>
                        <span id="div_peventualH_2" class="bxEr" style="display:none" >inválido</span>
                    </td>
                    <td align="right"><input type="text" name="B5" id="B5" value="<?php echo $aSueldos["pesu_numero_mujeres"] ?>" maxlength="5" size="20" class="inpB2 numeric">
                        <span id="div_peventualM" class="bxEr" style="display:none" >requerido</span>
                        <span id="div_peventualM_2" class="bxEr" style="display:none" >inválido</span>
                    </td>
                    <td align="right"><input type="text" name="C5" id="C5" onblur="javascript:saveUPD(5); return false;" value="<?php echo $aSueldos["pesu_sueldos_salarios"] ?>" size="20" class="inpB2 numeric">
                        <span id="div_peventual" class="bxEr" style="display:none" >requerido</span>
                        <span id="div_peventual_2" class="bxEr" style="display:none" >inválido</span>
                    </td>
                </tr>
                <?php } ?>
                
                <?php if( $aSueldos["indent"] == '3' && $aSueldos["vinieta"] == "0" ) { ?>
                <tr>
                    <td class="titR" >3. TOTAL</td>
                    <td align="right"><label class="labB" id="perH"><?php echo number_format($aSueldos["pesu_numero_hombres"]) ?></label></td>
                    <td align="right"><label class="labB" id="perM"><?php echo number_format($aSueldos["pesu_numero_mujeres"]) ?></label></td>
                    <td align="right"><label class="labB" id="perS"><?php echo number_format($aSueldos["pesu_sueldos_salarios"]) ?></label></td>
                </tr>
                <?php } ?>
                
                <?php if( $aSueldos["indent"] == '4' && $aSueldos["vinieta"] == "0" ) { ?>
                <tr>
                    <td class="titR" >4. Personas de apoyo (Propietarios, familiares y miembros del directorio)</td>
                    <td align="right"><input type="text" name="A6" id="A6" value="<?php echo $aSueldos["pesu_numero_hombres"] ?>" size="20" class="inpB2 numeric" >
                    <span id="div_nopagH" class="bxEr" style="display:none" >requerido</span>
                    <span id="div_nopagH_2" class="bxEr" style="display:none" >inválido</span>
                    </td>
                    <td align="right"><input type="text" name="B6" id="B6" value="<?php echo $aSueldos["pesu_numero_mujeres"] ?>" size="20" class="inpB2 numeric">
                    <span id="div_nopagM" class="bxEr" style="display:none" >requerido</span>
                    <span id="div_nopagM_2" class="bxEr" style="display:none" >inválido</span>
                    </td>
                    <td align="right"></td>
                </tr>
                <?php } ?>
                
                <?php if( $aSueldos["indent"] == '5' && $aSueldos["vinieta"] == "0" ) { ?>
                <tr>
                    <td class="titR" >5. TOTAL GENERAL</td>
                    <td align="right"><label class="labB" id="perGH"><?php echo number_format($aSueldos["pesu_numero_hombres"]) ?></label></td>
                    <td align="right"><label class="labB" id="perGM"><?php echo number_format($aSueldos["pesu_numero_mujeres"]) ?></label></td>
                    <td align="right"><label class="labB" id="perGS"><?php echo number_format($aSueldos["pesu_sueldos_salarios"]) ?></label></td>
                </tr>
                <?php } ?>
                
                <?php } ?>
                </tbody>
            </table>
            <p>
                <span id="msg" style="display: none;" class="bxEr" >Debe registrar el numero de personas que trabajan en la empresa</span>
                <span id="msg2" style="display: none;" class="bxEr" >El personal permanente sumado al personal eventual no debe sobrepasar los 5.000 personas</span>
                <span id="msg3" style="display: none;" class="bxEr" >Debe introducir el salario para el personal</span>
                <span id="msg4" style="display: none;" class="bxEr" >Debe introducir el numero de personas para el salario especificado.</span>
                <span id="msg5" style="display: none;" class="bxEr" >Debe introducir el numero de personas del tipo APOYO.</span>
            </p>                                      
            
            <span class="bxBt">
            <input type="submit" value="SIGUIENTE" id="sendData" name="continuarregistro" class="button" >
            <a href="acap1.php" class="btnS">ANTERIOR</a>                
            </span>

        </fieldset>
  </form>
    <div class="clear"></div>      

</div>
<!-- end body -->

<?php include("footer.php") ?>