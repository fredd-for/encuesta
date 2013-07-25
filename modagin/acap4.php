<?php session_start(); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php'); ?>
<?php include("header.php") ?>
<script type="text/javascript" src="js/acap4.js"></script>
<?php 
/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$sql = "SELECT * FROM  frm3_cap4_otrosgastosoperativos WHERE otga_regi_uid = '".$regisroUID."' ";
$db->query( $sql );
if( $db->numrows() == 0 ) {
    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    $sql2 = "SELECT * FROM adm_definiciones WHERE defi_form_uid = '".$uidFormulario."'  AND defi_modulo = 'a' AND  defi_capitulo = '4' AND defi_swactive = 'ACTIVE'";
    $db2->query( $sql2 );
    while( $aDefinicion =  $db2->next_record() ) {
        $sql = "INSERT INTO frm3_cap4_otrosgastosoperativos SET ";
        $sql .= "otga_regi_uid = '".$regisroUID."', ";
        $sql .= "otga_defi_uid = '".$aDefinicion["defi_uid"]."', ";
        $sql .= "otga_valor = 0, ";
        $sql .= "otga_description = '', ";
        $sql .= "otga_suv_uid = '".$uid_token."', ";
        $sql .= "otga_createdate = NOW(), ";
        $sql .= "otga_updatedate = NOW() ";
        $db3->query( $sql );
    }
}

$sql = " SELECT  frm3_cap4_otrosgastosoperativos.*, adm_definiciones.defi_indent as indent "
      ." FROM  frm3_cap4_otrosgastosoperativos LEFT JOIN  adm_definiciones ON ( otga_defi_uid	 = defi_uid ) "
      ." WHERE otga_regi_uid = '".$regisroUID."' ORDER BY CAST( adm_definiciones.defi_indent AS UNSIGNED ) ASC ";
$db->query( $sql );
//echo $sql;
?>

<!-- begin body -->
<div class="content">
    <span id="statusACAP1"></span>    
    
    <table class="dInf">
    <thead>
    <tr>
        <th>Cap&iacute;tulo 4</th>
        <th>OTROS GASTOS OPERATIVOS</th>
    </tr>
    </thead>
    <tbody>
        <tr>                        
            <td colspan="2"><?php echo OPERATOR::getDescTitles(3,'A',4,0); ?></td>
        </tr>
    </tbody>
    </table>        
    
    <form class="formA validable" action="acap4Add.php" method="post" autocomplete="off" >
      <fieldset>
        
        <table width="100%" class="fOpt" >
            <thead>
                <tr>
                    <th align="center">&nbsp;</th>
                    <th align="center">Valor (Bs/Anual)</th>                    
                  </tr>                
                </thead>
                                                
                <tbody>
                <?php 
                while( $aSueldos = $db->next_record() ) {
                ?>
                
                <?php if( $aSueldos["indent"] == '1' ) { ?>
                <tr>
                    <td width="71%" class="titR" >1. Trabajos de Fabricaci&oacute;n realizados por terceros</td>
                    <td width="29%" align="right" ><input type="text" name="A1" id="A1" value="<?php echo number_format($aSueldos["otga_valor"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                  </tr>                
                <?php } ?>
                
                <?php if( $aSueldos["indent"] == '2'  ) { ?>
                <tr>
                  <td class="titR" >2. Reparaci&oacute;n y mantenimiento realizado por terceros</td>
                  <td align="right"><input type="text" name="A2" id="A2" value="<?php echo number_format($aSueldos["otga_valor"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aSueldos["indent"] == '3' ) { ?>
                <tr>
                  <td class="titR" >3. Alquiler de activos fijos (edificios, maquinaria, equipo, veh&iacute;culos, etc.)</td>
                  <td align="right"><input type="text" name="A3" id="A3" value="<?php echo number_format($aSueldos["otga_valor"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aSueldos["indent"] == '4' ) { ?>
                <tr>
                  <td class="titR" >4. Repuestos y accesorios (incluye material de ferreter&iacute;a)</td>
                  <td align="right"><input type="text" name="A4" id="A4" value="<?php echo number_format($aSueldos["otga_valor"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aSueldos["indent"] == '5') { ?>
                <tr>
                  <td class="titR" >5. Ropa de trabajo e indumentaria de seguridad (overoles, cascos, barbijos, etc.)</td>
                  <td align="right"><input type="text" name="A5" id="A5" onblur="javascript:saveUPD(1); return false;" value="<?php echo number_format($aSueldos["otga_valor"]) ?>" maxlength="15" size="20" class="inpB2 numeric" /></td>
                </tr>                
                <?php } ?>
                
                <?php if( $aSueldos["indent"] == '6') { ?>
                <tr>
                    <td class="titR" >6.  Honorarios a profesionales independientes</td>
                    <td align="right"><span id="div_peventualH" class="bxEr" style="display:none" >requerido</span>
                    <span id="div_peventualH_2" class="bxEr" style="display:none" >inválido</span>
                    <input type="text" name="A6" id="A6" value="<?php echo number_format($aSueldos["otga_valor"]) ?>" maxlength="15" size="20" class="inpB2 numeric" /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aSueldos["indent"] == '7') { ?>
                <tr>
                  <td class="titR" >7. Servicios de comunicaci&oacute;n (tel&eacute;fono, internet, etc.)</td>
                  <td align="right"><input type="text" name="A7" id="A7" value="<?php echo number_format($aSueldos["otga_valor"]) ?>" maxlength="15" size="20" class="inpB2 numeric" /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aSueldos["indent"] == '8') { ?>
                <tr>
                  <td class="titR" >8. Materiales de oficina (incluye materiales de escritorio)</td>
                  <td align="right"><input type="text" name="A8" id="A8" value="<?php echo number_format($aSueldos["otga_valor"]) ?>" maxlength="15" size="20" class="inpB2 numeric" /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aSueldos["indent"] == '9') { ?>
                <tr>
                  <td class="titR" >9. Fletes y servicios de transporte prestado por terceros (en el interior del pa&iacute;s)</td>
                  <td align="right"><input type="text" name="A9" id="A9" value="<?php echo number_format($aSueldos["otga_valor"]) ?>" maxlength="15" size="20" class="inpB2 numeric" /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aSueldos["indent"] == '10') { ?>
                <tr>
                  <td class="titR" >10. Gastos por representaci&oacute;n, pasajes y vi&aacute;ticos</td>
                  <td align="right"><input type="text" name="A10" id="A10" onblur="javascript:saveUPD(2); return false;" value="<?php echo number_format($aSueldos["otga_valor"]) ?>" maxlength="15" size="20" class="inpB2 numeric" /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aSueldos["indent"] == '11') { ?>
                <tr>
                  <td class="titR" >11. Gastos por operaciones de exportaci&oacute;n (incluye fletes y primas por exportaciones)</td>
                  <td align="right"><input type="text" name="A11" id="A11" value="<?php echo number_format($aSueldos["otga_valor"]) ?>" maxlength="15" size="20" class="inpB2 numeric" /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aSueldos["indent"] == '12') { ?>
                <tr>
                  <td class="titR" >12. Gastos por operaciones de importaci&oacute;n (incluye fletes y primas por importaciones)</td>
                  <td align="right"><input type="text" name="A12" id="A12" value="<?php echo number_format($aSueldos["otga_valor"]) ?>" maxlength="15" size="20" class="inpB2 numeric" /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aSueldos["indent"] == '13') { ?>
                <tr>
                  <td class="titR" >13. Publicidad, propaganda y relaciones p&uacute;blicas</td>
                  <td align="right"><input type="text" name="A13" id="A13" value="<?php echo number_format($aSueldos["otga_valor"]) ?>" maxlength="15" size="20" class="inpB2 numeric" /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aSueldos["indent"] == '14') { ?>
                <tr>
                  <td class="titR" >14. Primas por seguro (excluye seguro de personas)</td>
                  <td align="right"><input type="text" name="A14" id="A14" value="<?php echo number_format($aSueldos["otga_valor"]) ?>" maxlength="15" size="20" class="inpB2 numeric" /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aSueldos["indent"] == '15') { ?>
                <tr>
                  <td class="titR" >15. Comisiones pagadas a terceros por comercializaci&oacute;n</td>
                  <td align="right"><input type="text" name="A15" id="A15" onblur="javascript:saveUPD(3); return false;" value="<?php echo number_format($aSueldos["otga_valor"]) ?>" maxlength="15" size="20" class="inpB2 numeric" /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aSueldos["indent"] == '16') { ?>
                <tr>
                  <td class="titR" >16. Capacitaci&oacute;n al personal</td>
                  <td align="right"><input type="text" name="A16" id="A16" value="<?php echo number_format($aSueldos["otga_valor"]) ?>" maxlength="15" size="20" class="inpB2 numeric" /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aSueldos["indent"] == '17') { ?>
                <tr>
                  <td class="titR" >17. Servicio de seguridad realizado por terceros</td>
                  <td align="right"><input type="text" name="A17" id="A17" value="<?php echo number_format($aSueldos["otga_valor"]) ?>" maxlength="15" size="20" class="inpB2 numeric" /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aSueldos["indent"] == '18') { ?>
                <tr>
                  <td class="titR" >18. Otros gastos: (especificar)</td>
                  <td align="right"><input type="text" name="A18" id="A18" value="<?php echo number_format($aSueldos["otga_valor"]) ?>" maxlength="15" size="20" class="inpB2 numeric" /></td>
                </tr>                
                <?php 
                $showrow = "style=\"display: none;\"";
                if( $aSueldos["otga_valor"] > 0 ) {
                    $showrow = "style=\"display: table-row;\"";
                }                
                ?>
                <tr id="idotros" <?php echo $showrow ?>  >
                  <td class="titR" align="left" ><input type="text" name="otrosdescrip" id="otrosdescrip" value="<?php echo $aSueldos["otga_description"]; ?>" size="50" class="inpC2" /></td>
                  <td align="right">&nbsp;</td>
                </tr>
                <?php } ?>
                
                <?php if( $aSueldos["indent"] == '19') { ?>
                <tr>
                    <td class="titR" >19. TOTAL</td>
                    <td align="right"><label class="labB" id="perH"><?php echo number_format($aSueldos["otga_valor"]) ?></label></td>
                </tr>
                <?php } ?>
                                              
                <?php } ?>
                </tbody>
            </table>
            <p>
                <span id="msg1" style="display: none;" class="bxEr" >Debe introducir el detalle para otros gastos</span>
                <span id="msg2" style="display: none;" class="bxEr" >Debe introducir valor(es) en este formulario</span>
            </p>                                     
            
            <span class="bxBt">
            <input type="submit" value="SIGUIENTE" id="sendData" name="continuarregistro" class="button" >
            <a href="acap3.php" class="btnS">ANTERIOR</a>                
            </span>

        </fieldset>
  </form>
    <div class="clear"></div>      

</div>
<!-- end body -->

<?php include("footer.php") ?>