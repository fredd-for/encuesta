<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
$dni = OPERATOR::toSql(safeHTML(OPERATOR::getParam("dni")),'Text');
?>
<?php include("header.php") ?>

<div id="container">
    <div class="contC">
    <?php include("../menu.php"); ?>

<!-- begin body -->
<div class="content">
        
    
    <h1>M&oacute;dulo D - Cap&iacute;tulo 1</h1>
    <p>
      <label>SERVICIOS TECNOL&Oacute;GICOS Y CAPACITACI&Oacute;N GESTI&Oacute;N 2011</label>
    </p>
    <p>FORMACI&Oacute;N Y CAPACITACI&Oacute;N </p>
    <p>Anote el monto invertido en la formaci&oacute;n y capacitaci&oacute;n del personal de la empresa, adem&aacute;s de los nombres de las instituciones que brindaron el servicio durante la gesti&oacute;n 2011.</p>

    <form class="formA validable" action="patientAdd.php" method="post" autocomplete="off" >
      <fieldset>    
      1.1 TIPO DE INVERSI&Oacute;N
      <table width="100%" border="0">
  <tr>
              <td align="left">&nbsp;</td>
              <td align="center">VALOR (Bs/Anual)</td>
              <td align="center">NOMBRE DE LAS INSTITUCIONES</td>
            </tr>
            <tr>
              <td width="508">1. Capacitaci&oacute;n</td>
              <td width="315" align="right"><span id="total">0,00</span></td>
              <td width="315" align="right">&nbsp;</td>
              </tr>
            <tr>
              <td>1.1 Formaci&oacute;n t&eacute;cnica (procesos de producci&oacute;n, manejo de maquinaria, etc.)</td>
              <td align="right"><span id="totA">0,00</span></td>
              <td align="right">&nbsp;</td>
              </tr>
            <tr>
              <td><input name="inputA-11" type="text" id="inputA-11" size="60" /><span id="div_inputA-11" style="display:none" class="bxEr" >requerido</span></td>
              <td align="right"><input name="inputA-21" type="text" id="input-13" size="10" /><span id="div_inputA-21" style="display:none" class="bxEr" >requerido</span></td>
              <td align="right"><input name="inputA-31" type="text" id="inputA-31" size="40" /><span id="div_inputA-31" style="display:none" class="bxEr" >requerido</span></td>
            </tr>
            <tr>
              <td><input name="inputA-12" type="text" id="inputA-12" size="60" /><span id="div_inputA-12" style="display:none" class="bxEr" >requerido</span></td>
              <td align="right"><input name="inputA-22" type="text" id="inputA-22" size="10" /><span id="div_inputA-22" style="display:none" class="bxEr" >requerido</span></td>
              <td align="right"><input name="inputA-32" type="text" id="inputA-32" size="40" /><span id="div_inputA-32" style="display:none" class="bxEr" >requerido</span></td>
              </tr>
            <tr>
              <td>1.2 Formaci&oacute;n en gesti&oacute;n empresarial (contabilidad, administraci&oacute;n, etc.)</td>
              <td align="right"><span id="totB">0,00</span></td>
              <td align="right">&nbsp;</td>
            </tr>
            <tr>
              <td><input name="inputB-11" type="text" id="inputB-11" size="60" /><span id="div_inputB-11" style="display:none" class="bxEr" >requerido</span></td>
              <td align="right"><input name="inputB-21" type="text" id="inputB-21" size="10" /><span id="div_inputB-21" style="display:none" class="bxEr" >requerido</span></td>
              <td align="right"><input name="inputB-31" type="text" id="inputB-31" size="40" /><span id="div_inputB-31" style="display:none" class="bxEr" >requerido</span></td>
            </tr>
            <tr>
              <td><input name="inputB-12" type="text" id="inputB-12" size="60" /><span id="div_inputB-12" style="display:none" class="bxEr" >requerido</span></td>
              <td align="right"><input name="inputB-22" type="text" id="inputB-22" size="10" /><span id="div_inputB-22" style="display:none" class="bxEr" >requerido</span></td>
              <td align="right"><input name="inputB-32" type="text" id="inputB-32" size="40" /><span id="div_inputB-32" style="display:none" class="bxEr" >requerido</span></td>
            </tr>
            <tr>
              <td>1.3 Formaci&oacute;n en capacidades personales (liderazgo, &eacute;tica, etc.)</td>
              <td align="right"><span id="totC">0,00</span></td>
              <td align="right">&nbsp;</td>
            </tr>
            <tr>
              <td><input name="inputC-11" type="text" id="inputC-11" size="60" /><span id="div_inputC-11" style="display:none" class="bxEr" >requerido</span></td>
              <td align="right"><input name="inputC-21" type="text" id="inputC-21" size="10" /><span id="div_inputC-21" style="display:none" class="bxEr" >requerido</span></td>
              <td align="right"><input name="inputC-31" type="text" id="inputC-31" size="40" /><span id="div_inputC-31" style="display:none" class="bxEr" >requerido</span></td>
            </tr>
            <tr>
              <td><input name="inputC-12" type="text" id="inputC-12" size="60" /><span id="div_inputC-12" style="display:none" class="bxEr" >requerido</span></td>
              <td align="right"><input name="inputC-22" type="text" id="inputC-22" size="10" /><span id="div_inputC-22" style="display:none" class="bxEr" >requerido</span></td>
              <td align="right"><input name="inputC-32" type="text" id="inputC-32" size="40" /><span id="div_inputC-32" style="display:none" class="bxEr" >requerido</span></td>
            </tr>
            <tr>
              <td><p>2. Asistencia t&eacute;cnica</p></td>
              <td align="right"><span id="totD">0,00</span></td>
              <td align="right">&nbsp;</td>
            </tr>
            <tr>
              <td><input name="inputD-11" type="text" id="inputD-11" size="60" /><span id="div_inputD-11" style="display:none" class="bxEr" >requerido</span></td>
              <td align="right"><input name="inputD-21" type="text" id="inputD-21" size="10" /><span id="div_inputD-21" style="display:none" class="bxEr" >requerido</span></td>
              <td align="right"><input name="inputD-31" type="text" id="inputD-31" size="40" /><span id="div_inputD-31" style="display:none" class="bxEr" >requerido</span></td>
            </tr>
            <tr>
              <td><input name="inputD-12" type="text" id="inputD-12" size="60" /><span id="div_inputD-12" style="display:none" class="bxEr" >requerido</span></td>
              <td align="right"><input name="inputD-22" type="text" id="inputD-22" size="10" /><span id="div_inputD-22" style="display:none" class="bxEr" >requerido</span></td>
              <td align="right"><input name="inputD-32" type="text" id="inputD-32" size="40" /><span id="div_inputD-32" style="display:none" class="bxEr" >requerido</span></td>
            </tr>
            <tr>
              <td><input name="inputD-13" type="text" id="inputD-13" size="60" /><span id="div_inputD-13" style="display:none" class="bxEr" >requerido</span></td>
              <td align="right"><input name="inputD-23" type="text" id="inputD-23" size="10" /><span id="div_inputD-23" style="display:none" class="bxEr" >requerido</span></td>
              <td align="right"><input name="inputD-33" type="text" id="inputD-33" size="40" /><span id="div_inputD-33" style="display:none" class="bxEr" >requerido</span></td>
            </tr>
            <tr>
              <td><input name="inputF-13" type="text" id="inputF-13" size="60" /><span id="div_inputF-13" style="display:none" class="bxEr" >requerido</span></td>
              <td align="right"><input name="inputF-23" type="text" id="inputF-23" size="10" /><span id="div_inputF-23" style="display:none" class="bxEr" >requerido</span></td>
              <td align="right"><input name="inputF-33" type="text" id="inputF-33" size="40" /><span id="div_inputF-33" style="display:none" class="bxEr" >requerido</span></td>
            </tr>
            <tr>
              <td>3.TOTAL</td>
              <td align="right"><span id="total2">0,00</span></td>
              <td align="right">&nbsp;</td>
              </tr>
      </table>
          <br />
          <p>1.2 TIPO DE CAPACITACI&Oacute;N</p>
          <p>Anote el porcentaje del valor declarado en el anterior cuadro, seg&uacute;n el tipo de personal de la empresa que fue beneficiado con la capacitaci&oacute;n en la gesti&oacute;n 2011.          </p>
          <table width="100%" border="0">
            <tr>
              <td width="50%">&nbsp;</td>
              <td width="10%">Obreros (%)</td>
              <td width="10%">Supervisores, jefes de planta y/o producci&oacute;n (%)</td>
              <td width="10%">Personal administrativo y de ventas (%)</td>
              <td width="10%">Gerentes y/o personal directivo (%)</td>
              </tr>
            <tr>
              <td>1. Formaci&oacute;n t&eacute;cnica (procesos de producci&oacute;n, manejo de maquinarias, etc.)</td>
              <td align="center"><input name="inputG-11" type="text" id="inputG-11" size="10" /><span id="div_inputG-11" style="display:none" class="bxEr" >requerido</span></td>
              <td align="center"><input name="inputG-21" type="text" id="inputG-21" size="10" /><span id="div_inputG-21" style="display:none" class="bxEr" >requerido</span></td>
              <td align="center"><input name="inputG-31" type="text" id="inputG-31" size="10" /><span id="div_inputG-31" style="display:none" class="bxEr" >requerido</span></td>
              <td align="center"><input name="inputG-41" type="text" id="inputG-41" size="10" /><span id="div_inputG-41" style="display:none" class="bxEr" >requerido</span></td>
              </tr>
            <tr>
              <td>2. Formaci&oacute;n en gesti&oacute;n empresarial (contabilidad, administraci&oacute;n, etc.)</td>
              <td align="center"><input name="inputG-12" type="text" id="inputG-12" size="10" /><span id="div_inputG-12" style="display:none" class="bxEr" >requerido</span></td>
              <td align="center"><input name="inputG-22" type="text" id="inputG-22" size="10" /><span id="div_inputG-22" style="display:none" class="bxEr" >requerido</span></td>
              <td align="center"><input name="inputG-32" type="text" id="inputG-32" size="10" /><span id="div_inputG-32" style="display:none" class="bxEr" >requerido</span></td>
              <td align="center"><input name="inputG-42" type="text" id="inputG-42" size="10" /><span id="div_inputG-42" style="display:none" class="bxEr" >requerido</span></td>
              </tr>
            <tr>
              <td>3. Formaci&oacute;n en capacidades personales (liderazgo, &eacute;tica, etc.)</td>
              <td align="center"><input name="inputG-13" type="text" id="inputG-13" size="10" /><span id="div_inputG-13" style="display:none" class="bxEr" >requerido</span></td>
              <td align="center"><input name="inputG-23" type="text" id="inputG-23" size="10" /><span id="div_inputG-23" style="display:none" class="bxEr" >requerido</span></td>
              <td align="center"><input name="inputG-33" type="text" id="inputG-33" size="10" /><span id="div_inputG-33" style="display:none" class="bxEr" >requerido</span></td>
              <td align="center"><input name="inputG-43" type="text" id="inputG-43" size="10" /><span id="div_inputG-43" style="display:none" class="bxEr" >requerido</span></td>
            </tr>
        </table>
          <p>&nbsp;</p>
          <p><br />
            <br />
          </p>
          <p>
            <label>&nbsp;</label>
    <input type="submit" value="Aceptar" id="sendData" class="button" >
    <span class="morOpt">
    o <a class="lnk2" href="patientLogin.php">Cancelar</a>
    </span>
</p>

        </fieldset>
  </form>
    <div class="clear"></div>      

</div>
<!-- end body -->        
        
     </div>
</div>

<?php include("footer.php") ?>
