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
        
    
    <h1>Cap&iacute;tulo 14-b</h1>
    <p>
      <legend>MATERIAS PRIMAS, MATERIALES AUXILIARES, ENVASES Y EMBALAJES</legend>
    </p>

    <form class="formA validable" action="patientAdd.php" method="post" autocomplete="off" >
        <fieldset>         
            <p> FABRICADOS FUERA DEL PA&Iacute;S</p>
          <table width="95%">
                <tr>
                  <td rowspan="2" align="center" >DESCRIPCI&Oacute;N GEN&Eacute;RICA DE MATERIAS PRIMAS, MATERIALES AUXILIARES, ENVASES Y EMBALAJES</td>
                  <td rowspan="2" align="center"  >UNIDAD DE MEDIDA</td>
                  <td colspan="2" align="center"  >INVENTARIO INICIAL</td>
                  <td colspan="2" align="center"  >COMPRAS</td>
                  <td colspan="2" align="center"  >UTILIZACI&Oacute;N</td>
                  <td colspan="2" align="center"  >INVENTARIO FINAL</td>
                </tr>
                <tr>
                  <td align="center"  >CANTIDAD</td>
                  <td align="center"  >VALOR (Bs.)</td>
                  <td align="center"  >CANTIDAD (1)</td>
                  <td align="center"  >VALOR (Bs) (2)</td>
                  <td align="center"  >CANTIDAD</td>
                  <td align="center"  >VALOR (Bs.)</td>
                  <td align="center"  >CANTIDAD</td>
                  <td align="center"  >VALOR (Bs.)</td>
                </tr>
                <tr>
                  <td align="center" >MATERIAS PRIMAS</td>
                  <td align="right"  >&nbsp;</td>
                  <td align="right"  >&nbsp;</td>
                  <td align="right"  ><span id="totPrima1">0,00</span></td>
                  <td align="right"  >&nbsp;</td>
                  <td align="right"  ><span id="totPrima2">0,00</span></td>
                  <td align="right"  >&nbsp;</td>
                  <td align="right"  ><span id="totPrima3">0,00</span></td>
                  <td align="right"  >&nbsp;</td>
                  <td align="right"  ><span id="totPrima4">0,00</span></td>
                </tr>
                <tr>
                    <td width="40%" ><input type="text" name="prima-11" id="prima-11" size="40" class="inpBX" /><span id="div_prima-11" class="bxEr" style="display:none" >requerido</span></td>
                    <td width="20%" align="right"  ><input type="text" name="prima-21" id="prima-21" size="10" class="inpBX" /><span id="div_prima-21" class="bxEr" style="display:none" >requerido</span></td>
                    <td width="20%" align="right"  ><input type="text" name="prima-31" id="prima-31" size="10" class="inpBX" /><span id="div_prima-31" class="bxEr" style="display:none" >requerido</span></td>
                    <td width="20%" align="right"  ><input type="text" name="prima-41" id="prima-41" size="10" class="inpBX" /><span id="div_prima-41" class="bxEr" style="display:none" >requerido</span></td>
                    <td width="20%" align="right"  ><input type="text" name="prima-51" id="prima-51" size="10" class="inpBX" /><span id="div_prima-51" class="bxEr" style="display:none" >requerido</span></td>
                    <td width="20%" align="right"  ><input type="text" name="prima-61" id="prima-61" size="10" class="inpBX" /><span id="div_prima-61" class="bxEr" style="display:none" >requerido</span></td>
                    <td width="20%" align="right"  ><input type="text" name="prima-91" id="prima-91" size="10" class="inpBX" /><span id="div_prima-91" class="bxEr" style="display:none" >requerido</span></td>
                    <td width="20%" align="right"  ><input type="text" name="prima-101" id="prima-101" size="10" class="inpBX" /><span id="div_prima-101" class="bxEr" style="display:none" >requerido</span></td>
                    <td width="20%" align="right"  ><input type="text" name="prima-111" id="prima-111" size="10" class="inpBX" /><span id="div_prima-111" class="bxEr" style="display:none" >requerido</span></td>
                    <td width="20%" align="right"  ><input type="text" name="prima-121" id="prima-121" size="10" class="inpBX" /><span id="div_prima-121" class="bxEr" style="display:none" >requerido</span></td>
                </tr>
                <tr>
                    <td width="40%" align="center" >MATERIALES AUXILIARES O INSUMOS</td>
                    <td align="right"  ><span id="div_input-12" class="bxEr" style="display:none" >requerido</span></td>
                    <td align="right"  ><span id="div_input-22" class="bxEr" style="display:none" >requerido</span></td>
                    <td align="right"  ><span id="totInsumo1">0,00</span></td>
                    <td align="right"  >&nbsp;</td>
                    <td align="right"  ><span id="totInsumo2">0,00</span></td>
                    <td align="right"  >&nbsp;</td>
                    <td align="right"  ><span id="totInsumo3">0,00</span></td>
                    <td align="right"  >&nbsp;</td>
                    <td align="right"  ><span id="totInsumo4">0,00</span></td>
                </tr>
                <tr>
                  <td ><input type="text" name="aux-11" id="aux-11" size="40" class="inpBX" /><span id="div_aux-11" class="bxEr" style="display:none" >requerido</span></td>
                  <td align="right"  ><input type="text" name="aux-21" id="aux-21" size="10" class="inpBX" /><span id="div_aux-21" class="bxEr" style="display:none" >requerido</span></td>
                  <td align="right"  ><input type="text" name="aux-31" id="aux-31" size="10" class="inpBX" /><span id="div_aux-31" class="bxEr" style="display:none" >requerido</span></td>
                  <td align="right"  ><input type="text" name="aux-41" id="aux-41" size="10" class="inpBX" /><span id="div_aux-41" class="bxEr" style="display:none" >requerido</span></td>
                  <td align="right"  ><input type="text" name="aux-51" id="aux-51" size="10" class="inpBX" /><span id="div_aux-51" class="bxEr" style="display:none" >requerido</span></td>
                  <td align="right"  ><input type="text" name="aux-61" id="aux-61" size="10" class="inpBX" /><span id="div_aux-61" class="bxEr" style="display:none" >requerido</span></td>
                  <td align="right"  ><input type="text" name="aux-91" id="aux-91" size="10" class="inpBX" /><span id="div_aux-91" class="bxEr" style="display:none" >requerido</span></td>
                  <td align="right"  ><input type="text" name="aux-101" id="aux-101" size="10" class="inpBX" /><span id="div_aux-101" class="bxEr" style="display:none" >requerido</span></td>
                  <td align="right"  ><input type="text" name="aux-111" id="aux-111" size="10" class="inpBX" /><span id="div_aux-111" class="bxEr" style="display:none" >requerido</span></td>
                  <td align="right"  ><input type="text" name="aux-121" id="aux-121" size="10" class="inpBX" /><span id="div_aux-121" class="bxEr" style="display:none" >requerido</span></td>
                </tr>
                <tr>
                  <td align="center" >ENVASES Y EMBALAJES</td>
                  <td align="right"  ><span id="div_input-13" class="bxEr" style="display:none" >requerido</span></td>
                  <td align="right"  ><span id="div_input-23" class="bxEr" style="display:none" >requerido</span></td>
                  <td align="right"  ><span id="totEnvase1">0,00</span></td>
                  <td align="right"  >&nbsp;</td>
                  <td align="right"  ><span id="totEnvase2">0,00</span></td>
                  <td align="right"  >&nbsp;</td>
                  <td align="right"  ><span id="totEnvase3">0,00</span></td>
                  <td align="right"  >&nbsp;</td>
                  <td align="right"  ><span id="totEnvase4">0,00</span></td>
                </tr>
                <tr>
                  <td ><input type="text" name="envase-11" id="envase-11" size="40" class="inpBX" /><span id="div_envase-11" class="bxEr" style="display:none" >requerido</span></td>
                  <td align="right"  ><input type="text" name="envase-21" id="envase-21" size="10" class="inpBX" /><span id="div_envase-21" class="bxEr" style="display:none" >requerido</span></td>
                  <td align="right"  ><input type="text" name="envase-31" id="envase-31" size="10" class="inpBX" /><span id="div_envase-31" class="bxEr" style="display:none" >requerido</span></td>
                  <td align="right"  ><input type="text" name="envase-41" id="envase-41" size="10" class="inpBX" /><span id="div_envase-41" class="bxEr" style="display:none" >requerido</span></td>
                  <td align="right"  ><input type="text" name="envase-51" id="envase-51" size="10" class="inpBX" /><span id="div_envase-51" class="bxEr" style="display:none" >requerido</span></td>
                  <td align="right"  ><input type="text" name="envase-61" id="envase-61" size="10" class="inpBX" /><span id="div_envase-61" class="bxEr" style="display:none" >requerido</span></td>
                  <td align="right"  ><input type="text" name="envase-91" id="envase-91" size="10" class="inpBX" /><span id="div_envase-91" class="bxEr" style="display:none" >requerido</span></td>
                  <td align="right"  ><input type="text" name="envase-101" id="envase-101" size="10" class="inpBX" /><span id="div_envase-101" class="bxEr" style="display:none" >requerido</span></td>
                  <td align="right"  ><input type="text" name="envase-111" id="envase-111" size="10" class="inpBX" /><span id="div_envase-111" class="bxEr" style="display:none" >requerido</span></td>
                  <td align="right"  ><input type="text" name="envase-121" id="envase-121" size="10" class="inpBX" /><span id="div_envase-121" class="bxEr" style="display:none" >requerido</span></td>
                </tr>
                <tr>
                  <td align="center" >SUB TOTAL</td>
                  <td align="right"  >&nbsp;</td>
                  <td align="right"  >&nbsp;</td>
                  <td align="right"  ><span id="tot1">0,00</span></td>
                  <td align="right"  >&nbsp;</td>
                  <td align="right"  ><span id="tot2">0,00</span></td>
                  <td align="right"  >&nbsp;</td>
                  <td align="right"  ><span id="tot3">0,00</span></td>
                  <td align="right"  >&nbsp;</td>
                  <td align="right"  ><span id="tot4">0,00</span></td>
                </tr>
            </table>
          <p>&nbsp;
            
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
