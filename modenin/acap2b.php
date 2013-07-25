<?php session_start(); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php'); ?>
<?php include("header.php") ?>
<script type="text/javascript" src="js/acap2b.js"></script>
<?php 
/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

//crear registros para sueldos
$sql = "SELECT * FROM cap2_otros_pagos WHERE otpa_regi_uid = '".$regisroUID."' ";
$db->query( $sql );
if( $db->numrows() == 0 ) {
    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    $sql2 = "SELECT * FROM adm_definiciones WHERE defi_form_uid = '".$uidFormulario."'  AND defi_modulo = 'a' AND  defi_capitulo = '2' AND defi_subcapitulo = '2' AND defi_swactive = 'ACTIVE'";
    $db2->query( $sql2 );
    while( $aDefinicion =  $db2->next_record() ) {        
        $sql = "INSERT INTO cap2_otros_pagos SET ";
        $sql .= "otpa_regi_uid  = '".$regisroUID."', ";
        $sql .= "otpa_defi_uid 	 = '".$aDefinicion["defi_uid"]."', ";
        $sql .= "otpa_valor = 0, ";
        $sql .= "otpa_descripcion = '', ";
        $sql .= "otpa_suv_uid = '".$uid_token."', "; 
        $sql .= "otpa_date_create = NOW(), "; 
        $sql .= "otpa_date_update = NOW() ";                          	 	
        $db3->query( $sql );
    }
}

$sql = " SELECT cap2_otros_pagos.*, adm_definiciones.defi_indent as indent "
      ." FROM cap2_otros_pagos LEFT JOIN  adm_definiciones ON ( otpa_defi_uid	 = defi_uid ) "
      ." WHERE otpa_regi_uid = '".$regisroUID."' ORDER BY adm_definiciones.defi_indent ASC ";
$db->query( $sql );
//echo $sql;
?>

<!-- begin body -->
<div class="content">
    <span id="statusACAP1"></span>    
    
    <table class="dInf">
    <thead>
    <tr>
        <th>Cap&iacute;tulo 2</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
        <tr>                        
            <td colspan="2"><?php echo OPERATOR::getDescTitles(2,'A',2,2); ?></td>
        </tr>
    </tbody>
    </table>        
    
    <form class="formA validable" action="acap2bAdd.php" method="post" autocomplete="off" >
      <fieldset>
            <span class="subT">2.2 Otros pagos al personal (no incluye aportes patronales)</span>
            <table width="100%" class="fOpt" >
                <thead>
                <tr>
                    <th align="center">&nbsp;</th>
                    <th align="center">valor (Bs/Anual)</th>                    
                  </tr>                
                </thead>
                                                
                <tbody>
                <?php 
                while( $aSueldos = $db->next_record() ) {
                ?>
                
                <?php if( $aSueldos["indent"] == '1' ) { ?>
                <tr>
                    <td width="71%" class="titR" >1. Aguinaldo</td>
                    <td width="29%" align="right" ><input type="text" name="A1" id="A1" value="<?php echo number_format($aSueldos["otpa_valor"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                  </tr>                
                <?php } ?>
                
                <?php if( $aSueldos["indent"] == '2'  ) { ?>
                <tr>
                  <td class="titR" >2. Pagos en especie</td>
                  <td align="right"><input type="text" name="A2" id="A2" value="<?php echo number_format($aSueldos["otpa_valor"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aSueldos["indent"] == '3' ) { ?>
                <tr>
                  <td class="titR" >3. Indemnizaciones o beneficios sociales de la gesti&oacute;n</td>
                  <td align="right"><input type="text" name="A3" id="A3" value="<?php echo number_format($aSueldos["otpa_valor"]) ?>" size="20" maxlength="15" class="inpB2 numeric" onblur="javascript:saveUPD(1); return false;" /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aSueldos["indent"] == '4' ) { ?>
                <tr>
                  <td class="titR" >4. Bono de producci&oacute;n</td>
                  <td align="right"><input type="text" name="A4" id="A4" value="<?php echo number_format($aSueldos["otpa_valor"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aSueldos["indent"] == '5') { ?>
                <tr>
                  <td class="titR" >5. Horas Extras</td>
                  <td align="right"><input type="text" name="A5" id="A5" value="<?php echo number_format($aSueldos["otpa_valor"]) ?>" maxlength="15" size="20" class="inpB2 numeric" /></td>
                </tr>                
                <?php } ?>
                
                <?php if( $aSueldos["indent"] == '6') { ?>
                <tr>
                    <td class="titR" >6.  Otros pagos al personal</td>
                    <td align="right"><span id="div_peventualH" class="bxEr" style="display:none" >requerido</span>
                    <span id="div_peventualH_2" class="bxEr" style="display:none" >inválido</span>
                    <input type="text" name="A6" id="A6" value="<?php echo number_format($aSueldos["otpa_valor"]) ?>" maxlength="15" size="20" class="inpB2 numeric" onblur="javascript:saveUPD(2); return false;" /></td>
                </tr>
                <?php
                $show1 = "style=\"display: none;\"";
                if( $aSueldos["otpa_valor"] > 0 ) {
                    $show1 = "style=\"display: table-row\"";
                }
                ?>
                <tr id="otrosdetalle" <?php echo $show1 ?> >
                    <td class="titR" ><input type="text" name="A7" id="A7" value="<?php echo $aSueldos["otpa_descripcion"]; ?>" size="60" class="inpC2" /></td>
                    <td align="right"></td>
                </tr>
                <?php } ?>
                
                <?php if( $aSueldos["indent"] == '7') { ?>
                <tr>
                    <td class="titR" >7. TOTAL</td>
                    <td align="right"><label class="labB" id="perH"><?php echo number_format($aSueldos["otpa_valor"]) ?></label></td>
                </tr>
                <?php } ?>
                                              
                <?php } ?>
                </tbody>
            </table>
            <p>                
                <span id="txtotros" style="display:none" class="bxEr" >Debe especificar el detalle para otros pagos al personal</span>
                <span id="msg"  style="display: none;" class="bxEr" >Debe especificar el valor para aguinaldo</span>
                <span id="msg2" style="display: none;" class="bxEr" >Debe registrar valor(es) en este formulario</span>
            </p>                                      
            
            <span class="bxBt">
            <input type="submit" value="SIGUIENTE" id="sendData" name="continuarregistro" class="button" >
            <a href="acap2.php" class="btnS">ANTERIOR</a>                
            </span>

        </fieldset>
  </form>
    <div class="clear"></div>      

</div>
<!-- end body -->

<?php include("footer.php") ?>