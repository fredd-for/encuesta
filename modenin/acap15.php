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
        
    
    <h1>Cap&iacute;tulo 15</h1>
    <p>
      <label>PRODUCTOS TERMINADOS, SUBPRODUCTOS Y PRODUCTOS EN PROCESO</label>
    </p>

    <form class="formA validable" action="patientAdd.php" method="post" autocomplete="off" >
        <fieldset>         
          <table width="100%">
                <tr>
                  <td rowspan="2" align="center" >DESCRIPCI&Oacute;N GEN&Eacute;RICA DE PRODUCTOS Y SUBPRODUCTOS</td>
                  <td rowspan="2" align="center"  >UNIDAD DE MEDIDA</td>
                  <td colspan="2" align="center"  >INVENTARIO INICIAL</td>
                  <td colspan="2" align="center"  >INVENTARIO FINAL</td>
                  <td colspan="2" align="center"  >VENTAS AL MERCADO NACIONAL</td>
                  <td colspan="2" align="center"  >VENTAS AL MERCADO EXTERNO</td>
                  <td colspan="2" align="center"  >PRODUCCI&Oacute;N</td>
                </tr>
                <tr>
                  <td align="center"  >CANTIDAD</td>
                  <td align="center"  >VALOR (Bs.)</td>
                  <td align="center"  >CANTIDAD</td>
                  <td align="center"  >VALOR (Bs.)</td>
                  <td align="center"  >CANTIDAD</td>
                  <td align="center"  >VALOR (Bs/Anual)</td>
                  <td align="center"  >CANTIDAD</td>
                  <td align="center"  >VALOR (Bs/Anual)</td>
                  <td align="center"  >CANTIDAD</td>
                  <td align="center"  >VALOR (Bs/Anual)</td>
                </tr>
                <tr>
                    <td width="15%" ><input type="text" name="prima-11" id="prima-11" size="30" class="inpBX" /><span id="div_prima-11" class="bxEr" style="display:none" >requerido</span></td>
                    <td width="7%" align="right"  ><input type="text" name="prima-21" id="prima-21" size="8" class="inpBX" /><span id="div_prima-21" class="bxEr" style="display:none" >requerido</span></td>
                    <td width="6%" align="right"  ><input type="text" name="prima-31" id="prima-31" size="8" class="inpBX" /><span id="div_prima-31" class="bxEr" style="display:none" >requerido</span></td>
                    <td width="8%" align="right"  ><input type="text" name="prima-41" id="prima-41" size="8" class="inpBX" /><span id="div_prima-41" class="bxEr" style="display:none" >requerido</span></td>
                    <td width="8%" align="right"  ><input type="text" name="prima-111" id="prima-111" size="8" class="inpBX" />
                      <span id="div_prima-111" class="bxEr" style="display:none" >requerido</span></td>
                    <td width="8%" align="right"  ><input type="text" name="prima-121" id="prima-121" size="8" class="inpBX" />
                      <span id="div_prima-121" class="bxEr" style="display:none" >requerido</span></td>
                    <td width="8%" align="right"  ><input type="text" name="prima-71" id="prima-71" size="8" class="inpBX" />
                      <span id="div_prima-71" class="bxEr" style="display:none" >requerido</span></td>
                    <td width="8%" align="right"  ><input type="text" name="prima-81" id="prima-81" size="8" class="inpBX" />
                      <span id="div_prima-81" class="bxEr" style="display:none" >requerido</span></td>
                    <td width="8%" align="right"  ><input type="text" name="prima-91" id="prima-91" size="8" class="inpBX" />
                      <span id="div_prima-91" class="bxEr" style="display:none" >requerido</span></td>
                    <td width="8%" align="right"  ><input type="text" name="prima-101" id="prima-101" size="8" class="inpBX" />
                      <span id="div_prima-101" class="bxEr" style="display:none" >requerido</span></td>
                    <td width="8%" align="right"  ><input type="text" name="prima-51" id="prima-51" size="8" class="inpBX" /><span id="div_prima-51" class="bxEr" style="display:none" >requerido</span></td>
                    <td width="8%" align="right"  ><input type="text" name="prima-61" id="prima-61" size="8" class="inpBX" /><span id="div_prima-61" class="bxEr" style="display:none" >requerido</span></td>
                </tr>
                <tr>
                  <td >Productos en proceso<span id="div_aux-11" class="bxEr" style="display:none" >requerido</span></td>
                  <td align="right"  ><input type="text" name="aux-21" id="aux-21" size="8" class="inpBX" /><span id="div_aux-21" class="bxEr" style="display:none" >requerido</span></td>
                  <td align="right"  ><input type="text" name="aux-31" id="aux-31" size="8" class="inpBX" /><span id="div_aux-31" class="bxEr" style="display:none" >requerido</span></td>
                  <td align="right"  ><input type="text" name="aux-41" id="aux-41" size="8" class="inpBX" /><span id="div_aux-41" class="bxEr" style="display:none" >requerido</span></td>
                  <td align="right"  ><input type="text" name="aux-111" id="aux-111" size="8" class="inpBX" />
                    <span id="div_aux-111" class="bxEr" style="display:none" >requerido</span></td>
                  <td align="right"  ><input type="text" name="aux-121" id="aux-121" size="8" class="inpBX" />
                    <span id="div_aux-121" class="bxEr" style="display:none" >requerido</span></td>
                  <td align="right"  ><input type="text" name="aux-71" id="aux-71" size="8" class="inpBX" />
                    <span id="div_aux-71" class="bxEr" style="display:none" >requerido</span></td>
                  <td align="right"  ><input type="text" name="aux-81" id="aux-81" size="8" class="inpBX" />
                    <span id="div_aux-81" class="bxEr" style="display:none" >requerido</span></td>
                  <td align="right"  ><input type="text" name="aux-91" id="aux-91" size="8" class="inpBX" />
                    <span id="div_aux-91" class="bxEr" style="display:none" >requerido</span></td>
                  <td align="right"  ><input type="text" name="aux-101" id="aux-101" size="8" class="inpBX" />
                    <span id="div_aux-101" class="bxEr" style="display:none" >requerido</span></td>
                  <td align="right"  ><input type="text" name="aux-51" id="aux-51" size="8" class="inpBX" /><span id="div_aux-51" class="bxEr" style="display:none" >requerido</span></td>
                  <td align="right"  ><input type="text" name="aux-61" id="aux-61" size="8" class="inpBX" /><span id="div_aux-61" class="bxEr" style="display:none" >requerido</span></td>
                </tr>
                <tr>
                  <td align="center" >TOTAL</td>
                  <td align="right"  >&nbsp;</td>
                  <td align="right"  >&nbsp;</td>
                  <td align="right"  ><span id="tot1">0,00</span></td>
                  <td align="right"  >&nbsp;</td>
                  <td align="right"  ><span id="tot4">0,00</span></td>
                  <td align="right"  >&nbsp;</td>
                  <td align="right"  ><span id="tot2">0,00</span></td>
                  <td align="right"  >&nbsp;</td>
                  <td align="right"  ><span id="tot3">0,00</span></td>
                  <td align="right"  >&nbsp;</td>
                  <td align="right"  ><span id="tot5">0,00</span></td>
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
