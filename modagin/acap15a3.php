<?php session_start(); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php'); ?>
<?php include("header.php") ?>
<script type="text/javascript" src="js/acap15a_3.js"></script>
<?php 
/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];
?>
<!-- begin body -->
<style type="text/css">
    table.fOpt td { padding: 10px 1px !important; text-align: center !important; }
</style>
<div class="content">
    <span id="statusACAP1"></span>    
    
    <table class="dInf">
    <thead>
    <tr>
        <th>Cap&iacute;tulo 15</th>
        <th>PRODUCTOS TERMINADOS, SUBPRODUCTOS Y PRODUCTOS EN PROCESO</th>
    </tr>
    </thead>
    <tbody>
        <tr>                        
            <td colspan="2"><?php echo OPERATOR::getDescTitles(3,'A',15,0); ?></td>
        </tr>
    </tbody>
    </table>        
    
    <form class="formA validable" action="acap15a3Add.php" method="post" autocomplete="off" >
      <fieldset>                          
          <p> <span class="subT">PRODUCTOS EN PROCESO</span></p>
          <table width="100%" class="fOpt" id="tablecertificacion" >
                <thead>
                <tr>
                  <td rowspan="2" align="center" >DESCRIPCI&Oacute;N DE PRODUCTOS EN PROCESO</td>
                  <td rowspan="2" align="center" >Unidad de medida</td>
                  <td colspan="2" align="center" >INVENTARIO INICIAL</td>
                  <td colspan="2" align="center" >VENTAS AL MERCADO NACIONAL</td>
                  <td colspan="2" align="center" >VENTAS AL MERCADO EXTERNO </td>
                  <td colspan="2" align="center" >PRODUCCI&Oacute;N</td>
                  <td colspan="2" align="center" >INVENTARIO FINAL</td>
                  <td rowspan="2" align="center"  >&nbsp;</td>
                </tr>
                <tr>
                  <td align="center"  >Cantidad</td>
                  <td align="center"  >Valor (Bs.)</td>
                  <td align="center"  >Cantidad</td>
                  <td align="center"  >Valor (Bs.)</td>
                  <td align="center"  >Cantidad</td>
                  <td align="center"  >Valor (Bs)</td>
                  <td align="center"  >Cantidad</td>
                  <td align="center"  >Valor (Bs)</td>
                  <td align="center"  >Cantidad</td>
                  <td align="center"  >Valor (Bs)</td>
                  </tr>
                </thead>
                    
                <tbody>
                <?php
                $posmax = OPERATOR::getDbValue("SELECT MAX(prod_position) + 1 as pos FROM frm3_cap15_productosterminados WHERE prod_regi_uid = '".$regisroUID."' AND  prod_tima_uid = '9' AND prod_position <> 0");
                if( empty($posmax) ) { $posmax = 1; }
                
                $sql3 = "SELECT * FROM frm3_cap15_productosterminados WHERE prod_regi_uid = '".$regisroUID."' AND prod_delete = 0 AND prod_position <> 0 AND prod_tima_uid = '9' ORDER BY prod_position ASC  ";
                //echo $sql3;
                $d = 0; $e = 0; $f = 0; $g = 0; $h = 0; $i = 0; $j = 0; $k = 0; $l = 0; $m = 0;
                $db3->query( $sql3 );
                if( $db3->numrows() > 0 ) {
                while( $aCert2 = $db3->next_record() ) {
                    $pos = $aCert2["prod_position"];
                    $d = $d + $aCert2["prod_invini_cantidad"]; 
                    $e = $e + $aCert2["prod_invini_valor"]; 
                    $f = $f + $aCert2["prod_ventas_cantidad"]; 
                    $g = $g + $aCert2["prod_ventas_valor"]; 
                    $h = $h + $aCert2["prod_me_cantidad"]; 
                    $i = $i + $aCert2["prod_me_valor"]; 
                    $j = $j + $aCert2["prod_produccion_cantidad"]; 
                    $k = $k + $aCert2["prod_produccion_valor"];
                    $l = $l + $aCert2["prod_invfin_cantidad"];
                    $m = $m + $aCert2["prod_invfin_valor"];
                ?>
                <tr id="row_<?php echo $pos; ?>" >
                    <td width="13%"><input type="text" name="A_<?php echo $pos ?>" id="A_<?php echo $pos ?>" value="<?php echo $aCert2["prod_descproducto"] ?>"   size="30" class="inpC2" /></td>
                    <td width="6%" ><input type="text" name="C_<?php echo $pos ?>" id="C_<?php echo $pos ?>" value="<?php echo $aCert2["prod_unidadmedida"] ?>"  size="8" class="inpC2" /></td>
                    <td width="8%" ><input type="text" name="D_<?php echo $pos ?>" id="D_<?php echo $pos ?>" value="<?php echo number_format($aCert2["prod_invini_cantidad"]) ?>" size="8" class="inpB2 numeric" onblur="sumcol('D',<?php echo $pos ?>);" /></td>
                    <td width="8%" ><input type="text" name="E_<?php echo $pos ?>" id="E_<?php echo $pos ?>" value="<?php echo number_format($aCert2["prod_invini_valor"]) ?>"    size="8" class="inpB2 numeric" onblur="sumcol('E',<?php echo $pos ?>);" /></td>
                    <td width="8%" ><input type="text" name="F_<?php echo $pos ?>" id="F_<?php echo $pos ?>" value="<?php echo number_format($aCert2["prod_ventas_cantidad"]) ?>" size="8" class="inpB2 numeric" onblur="sumcol('F',<?php echo $pos ?>);" /></td>
                    <td width="8%" ><input type="text" name="G_<?php echo $pos ?>" id="G_<?php echo $pos ?>" value="<?php echo number_format($aCert2["prod_ventas_valor"]) ?>"    size="8" class="inpB2 numeric" onblur="sumcol('G',<?php echo $pos ?>);" /></td>
                    <td width="8%" ><input type="text" name="H_<?php echo $pos ?>" id="H_<?php echo $pos ?>" value="<?php echo number_format($aCert2["prod_me_cantidad"]) ?>"   size="8" class="inpB2 numeric" onblur="sumcol('H',<?php echo $pos ?>);" /></td>
                    <td width="8%" ><input type="text" name="I_<?php echo $pos ?>" id="I_<?php echo $pos ?>" value="<?php echo number_format($aCert2["prod_me_valor"]) ?>"      size="8" class="inpB2 numeric" onblur="sumcol('I',<?php echo $pos ?>);" /></td>
                    <td width="8%" ><input type="text" name="J_<?php echo $pos ?>" id="J_<?php echo $pos ?>" value="<?php echo number_format($aCert2["prod_produccion_cantidad"]) ?>" size="8" class="inpB2 numeric" onblur="sumcol('J',<?php echo $pos ?>);" /></td>
                    <td width="8%" ><input type="text" name="K_<?php echo $pos ?>" id="K_<?php echo $pos ?>" value="<?php echo number_format($aCert2["prod_produccion_valor"]) ?>"    size="8" class="inpB2 numeric" onblur="sumcol('K',<?php echo $pos ?>); saveUPD(1); return false; " /></td>
                    <td width="8%" ><label class="labB" id="totL_<?php echo $pos ?>"><?php echo number_format($aCert2["prod_invfin_cantidad"]) ?></label></td>
                    <td width="8%" ><label class="labB" id="totM_<?php echo $pos ?>"><?php echo number_format($aCert2["prod_invfin_valor"]) ?></label></td>
                    <td width="5%" ><a href="#" class="lnkCls" id="delplan_<?php echo $aCert2["prod_position"] ?>" onclick="delRow('<?php echo $pos ?>',1); return false;" >eliminar</a></td>                    
                </tr>
                <?php }                            
                } else {
                ?>
                <tr id="row_<?php echo $posmax; ?>" >
                    <td width="13%"><input type="text" name="A_<?php echo $posmax; ?>" id="A_<?php echo $posmax; ?>" size="30" class="inpC2" /></td>
                    <td width="6%" ><input type="text" name="C_<?php echo $posmax; ?>" id="C_<?php echo $posmax; ?>" size="8" class="inpC2" /></td>
                    <td width="8%" ><input type="text" name="D_<?php echo $posmax; ?>" id="D_<?php echo $posmax; ?>" size="8" class="inpB2 numeric" onblur="sumcol('D',<?php echo $posmax; ?>);" /></td>
                    <td width="8%" ><input type="text" name="E_<?php echo $posmax; ?>" id="E_<?php echo $posmax; ?>" size="8" class="inpB2 numeric" onblur="sumcol('E',<?php echo $posmax; ?>);" /></td>
                    <td width="8%" ><input type="text" name="F_<?php echo $posmax; ?>" id="F_<?php echo $posmax; ?>" size="8" class="inpB2 numeric" onblur="sumcol('F',<?php echo $posmax; ?>);" /></td>
                    <td width="8%" ><input type="text" name="G_<?php echo $posmax; ?>" id="G_<?php echo $posmax; ?>" size="8" class="inpB2 numeric" onblur="sumcol('G',<?php echo $posmax; ?>);" /></td>
                    <td width="8%" ><input type="text" name="H_<?php echo $posmax; ?>" id="H_<?php echo $posmax; ?>" size="8" class="inpB2 numeric" onblur="sumcol('H',<?php echo $posmax; ?>);" /></td>
                    <td width="8%" ><input type="text" name="I_<?php echo $posmax; ?>" id="I_<?php echo $posmax; ?>" size="8" class="inpB2 numeric" onblur="sumcol('I',<?php echo $posmax; ?>);" /></td>
                    <td width="8%" ><input type="text" name="J_<?php echo $posmax; ?>" id="J_<?php echo $posmax; ?>" size="8" class="inpB2 numeric" onblur="sumcol('J',<?php echo $posmax; ?>);" /></td>
                    <td width="8%" ><input type="text" name="K_<?php echo $posmax; ?>" id="K_<?php echo $posmax; ?>" size="8" class="inpB2 numeric" onblur="sumcol('K',<?php echo $posmax; ?>); saveUPD(1); return false;" /></td>
                    <td width="8%" ><label class="labB" id="totL_<?php echo $posmax ?>">0</label></td>
                    <td width="8%" ><label class="labB" id="totM_<?php echo $posmax ?>">0</label></td>
                    <td width="5%" >&nbsp;</td>                    
                </tr>
                <?php 
                $posmax = $posmax + 1;
                }                 
                ?>
                </tbody>
                <tfoot>
                <tr>
                  <td align="center" colspan="2" >SUB TOTAL</td>                 
                  <td align="right"  ><label class="labB" id="totD"><?php echo number_format($d) ?></label></td>
                  <td align="right"  ><label class="labB" id="totE"><?php echo number_format($e) ?></label></td>
                  <td align="right"  ><label class="labB" id="totF"><?php echo number_format($f) ?></label></td>
                  <td align="right"  ><label class="labB" id="totG"><?php echo number_format($g) ?></label></td>
                  <td align="right"  ><label class="labB" id="totH"><?php echo number_format($h) ?></label></td>
                  <td align="right"  ><label class="labB" id="totI"><?php echo number_format($i) ?></label></td>
                  <td align="right"  ><label class="labB" id="totJ"><?php echo number_format($j) ?></label></td>
                  <td align="right"  ><label class="labB" id="totK"><?php echo number_format($k) ?></label></td>
                  <td align="right"  ><label class="labB" id="totL"><?php echo number_format($l) ?></label></td>
                  <td align="right"  ><label class="labB" id="totM"><?php echo number_format($m) ?></label></td>
                  <td align="right"  >&nbsp;</td>
                </tr>                                
                <?php             
                $sql = "SELECT
                         SUM(prod_invini_cantidad) as invini_cantidad, 
                         SUM(prod_invini_valor) as invini_valor,
                         SUM(prod_ventas_cantidad) as ventas_cantidad,  
                         SUM(prod_ventas_valor) as ventas_valor,
                         SUM(prod_me_cantidad) as me_cantidad,  
                         SUM(prod_me_valor) as me_valor,  
                         SUM(prod_produccion_cantidad) as produccion_cantidad,  
                         SUM(prod_produccion_valor) as produccion_valor,
                         SUM(prod_invfin_cantidad) as invfin_cantidad,
                         SUM(prod_invfin_valor) as invfin_valor
                        FROM frm3_cap15_productosterminados WHERE prod_regi_uid = '".$regisroUID."' AND prod_delete = 0 AND  prod_tima_uid IN (7,8,9) AND prod_position <> 0 GROUP BY prod_regi_uid";
                $db3->query( $sql );                
                $aTot = $db3->next_record();
                ?>
                <tr>
                  <td align="center" colspan="2" ><label class="labB">TOTAL</label></td>                  
                  <td align="right"  ><label class="labB" id="totTD"><?php echo number_format($aTot["invini_cantidad"]) ?></label></td>
                  <td align="right"  ><label class="labB" id="totTE"><?php echo number_format($aTot["invini_valor"]) ?></label></td>
                  <td align="right"  ><label class="labB" id="totTF"><?php echo number_format($aTot["ventas_cantidad"]) ?></label></td>
                  <td align="right"  ><label class="labB" id="totTG"><?php echo number_format($aTot["ventas_valor"]) ?></label></td>
                  <td align="right"  ><label class="labB" id="totTH"><?php echo number_format($aTot["me_cantidad"]) ?></label></td>
                  <td align="right"  ><label class="labB" id="totTI"><?php echo number_format($aTot["me_valor"]) ?></label></td>
                  <td align="right"  ><label class="labB" id="totTJ"><?php echo number_format($aTot["produccion_cantidad"]) ?></label></td>
                  <td align="right"  ><label class="labB" id="totTK"><?php echo number_format($aTot["produccion_valor"]) ?></label></td>
                  <td align="right"  ><label class="labB" id="totTL"><?php echo number_format($aTot["invfin_cantidad"]) ?></label></td>
                  <td align="right"  ><label class="labB" id="totTM"><?php echo number_format($aTot["invfin_valor"]) ?></label></td>
                  <td align="right"  >&nbsp;</td>
                </tr>
                
                </tfoot>
                
            </table>
            <input type="hidden" name="maxrow" id="maxrow" value="<?php echo $posmax ?>">
            <a href="#" id="addcertificacion" class="btnAdd">Agregar campos</a>
            <p>                
                <span id="msg3" style="display: none;" class="bxEr"  >Debe registrar cantidades y valores en los formularios de productos</span>
            </p>
            <p><?php echo OPERATOR::getDescTitles(3,'A',15,1); ?></p>
            <span class="bxBt">
            <input type="submit" value="SIGUIENTE" id="sendData" name="continuarregistro" class="button" >
            <a href="acap15a2.php" class="btnS">ANTERIOR</a>                
            </span>

        </fieldset>
  </form>
    <div class="clear"></div>      

</div>
<!-- end body -->

<?php include("footer.php") ?>