<?php session_start(); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php'); ?>
<?php include("header.php") ?>
<script type="text/javascript" src="js/acap14a_1.js"></script>
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
        <th>Cap&iacute;tulo <br />14-a</th>
        <th>MATERIAS PRIMAS, MATERIALES AUXILIARES, ENVASES Y EMBALAJES - FABRICADOS EN EL PA&Iacute;S</th>
    </tr>
    </thead>
    <tbody>
        <tr>                        
            <td colspan="2"><?php echo OPERATOR::getDescTitles(3,'A',14,0); ?></td>
        </tr>
    </tbody>
    </table>        
    
    <form class="formA validable" action="acap14a1Add.php" method="post" autocomplete="off" >
      <fieldset>                          
          <p> <span class="subT">MATERIAS PRIMAS </span> </p>
          <table width="100%" class="fOpt" id="tablecertificacion" >
                <thead>
                <tr >
                  <td rowspan="3" align="center" >Descripci&oacute;n gen&eacute;rica de materias primas</td>
                  <td rowspan="3" align="center" >Unidad de Medida</td>
                  <td colspan="2" rowspan="2" align="center" >INVENTARIO INICIAL</td>
                  <td colspan="4" align="center" >COMPRAS</td>
                  <td colspan="2" rowspan="2" align="center" >UTILIZACI&Oacute;N</td>
                  <td colspan="2" rowspan="2" align="center" >INVENTARIO FINAL</td>
                  <td rowspan="3" align="center"  >&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="3" align="center"  >Cantidad</td>
                  <td align="center"  >&nbsp;</td>
                  </tr>
                <tr>
                  <td align="center"  >Cantidad</td>
                  <td align="center"  >Valor (Bs.)</td>
                  <td align="center"  >Compras a productores (1)</td>
                  <td align="center"  >Compras a Intermediarios (2)</td>
                  <td align="center"  >Total (1) + (2)</td>
                  <td align="center"  >Valor (Bs.)</td>
                  <td align="center"  >Cantidad</td>
                  <td align="center"  >Valor (Bs)</td>
                  <td align="center"  >Cantidad</td>
                  <td align="center"  >Valor (Bs)</td>
                  </tr>
                </thead>
                    
                <tbody>
                <?php
                $posmax = OPERATOR::getDbValue("SELECT MAX(mapr_position) + 1 as pos FROM frm3_cap14a_materiasprimas WHERE mapr_regi_uid = '".$regisroUID."' AND  mapr_tima_uid = '1' AND mapr_position <> 0");
                if( empty($posmax) ) { $posmax = 1; }
                
                $sql3 = "SELECT * FROM frm3_cap14a_materiasprimas WHERE mapr_regi_uid = '".$regisroUID."' AND mapr_delete = 0 AND mapr_position <> 0 AND mapr_tima_uid = '1' ORDER BY mapr_position ASC  ";
                //echo $sql3;
                $c = 0; $d = 0; $e = 0; $f = 0; $g = 0; $h = 0; $i = 0; $j = 0; $k = 0;
                $db3->query( $sql3 );
                if( $db3->numrows() > 0 ) {
                while( $aCert2 = $db3->next_record() ) {
                    $pos = $aCert2["mapr_position"];
                    $c = $c + $aCert2["mapr_invini_cantidad"];
                    $d = $d + $aCert2["mapr_invini_valor"]; 
                    $e = $e + $aCert2["mapr_compra_productores"]; 
                    $f = $f + $aCert2["mapr_compra_intermediarios"]; 
                    $g = $g + $aCert2["mapr_compra_total"]; 
                    $h = $h + $aCert2["mapr_compra_valor"]; 
                    $i = $i + $aCert2["mapr_util_cantidad"]; 
                    $j = $j + $aCert2["mapr_util_valor"]; 
                    $k = $k + $aCert2["mapr_invfin_cantidad"];
                    $l = $l + $aCert2["mapr_invfin_valor"];
                ?>
                <tr id="row_<?php echo $pos; ?>" >
                    <td width="11%"><input type="text" name="A_<?php echo $pos ?>" id="A_<?php echo $pos ?>" value="<?php echo $aCert2["mapr_materiadesc"] ?>"   size="30" class="inpC2" /></td>
                    <td width="6%" ><input type="text" name="B_<?php echo $pos ?>" id="B_<?php echo $pos ?>" value="<?php echo $aCert2["mapr_unidadmedida"] ?>"  size="8" class="inpC2" /></td>
                    <td width="6%" ><input type="text" name="C_<?php echo $pos ?>" id="C_<?php echo $pos ?>" value="<?php echo number_format($aCert2["mapr_invini_cantidad"]) ?>" size="8" class="inpB2 numeric" onblur="sumcol('C',<?php echo $pos ?>); " /></td>
                    <td width="8%" ><input type="text" name="D_<?php echo $pos ?>" id="D_<?php echo $pos ?>" value="<?php echo number_format($aCert2["mapr_invini_valor"]) ?>"    size="8" class="inpB2 numeric" onblur="sumcol('D',<?php echo $pos ?>); " /></td>
                    <td width="8%" ><input type="text" name="E_<?php echo $pos ?>" id="E_<?php echo $pos ?>" value="<?php echo number_format($aCert2["mapr_compra_productores"]) ?>" size="8" class="inpB2 numeric" onblur="sumcol('E',<?php echo $pos ?>); " /></td>
                    <td width="8%" ><input type="text" name="F_<?php echo $pos ?>" id="F_<?php echo $pos ?>" value="<?php echo number_format($aCert2["mapr_compra_intermediarios"]) ?>"    size="8" class="inpB2 numeric" onblur="sumcol('F',<?php echo $pos ?>); " /></td>
                    <td width="8%" ><label class="labB" id="G_<?php echo $pos ?>"><?php echo number_format($aCert2["mapr_compra_total"]) ?></label></td>
                    <td width="8%" ><input type="text" name="H_<?php echo $pos ?>" id="H_<?php echo $pos ?>" value="<?php echo number_format($aCert2["mapr_compra_valor"]) ?>"    size="8" class="inpB2 numeric" onblur="sumcol('H',<?php echo $pos ?>); " /></td>
                    <td width="8%" ><input type="text" name="I_<?php echo $pos ?>" id="I_<?php echo $pos ?>" value="<?php echo number_format($aCert2["mapr_util_cantidad"]) ?>"   size="8" class="inpB2 numeric" onblur="sumcol('I',<?php echo $pos ?>); " /></td>
                    <td width="8%" ><input type="text" name="J_<?php echo $pos ?>" id="J_<?php echo $pos ?>" value="<?php echo number_format($aCert2["mapr_util_valor"]) ?>"      size="8" class="inpB2 numeric" onblur="sumcol('J',<?php echo $pos ?>); saveUPD(1); return false;" /></td>
                    <td width="8%" ><label class="labB" id="totK_<?php echo $pos ?>"><?php echo number_format($aCert2["mapr_invfin_cantidad"]) ?></label></td>
                    <td width="8%" ><label class="labB" id="totL_<?php echo $pos ?>"><?php echo number_format($aCert2["mapr_invfin_valor"]) ?></label></td>
                    <td width="5%" ><a href="#" class="lnkCls" id="delplan_<?php echo $aCert2["mapr_position"] ?>" onclick="delRow('<?php echo $pos ?>',1); return false;" >eliminar</a></td>                    
                </tr>
                <?php }                            
                } else {                    
                ?>
                <tr id="row_<?php echo $posmax; ?>" >
                    <td width="11%"><input type="text" name="A_<?php echo $posmax; ?>" id="A_<?php echo $posmax; ?>" size="30" class="inpC2" /></td>
                    <td width="6%" ><input type="text" name="B_<?php echo $posmax; ?>" id="B_<?php echo $posmax; ?>" size="8" class="inpC2" /></td>
                    <td width="6%" ><input type="text" name="C_<?php echo $posmax; ?>" id="C_<?php echo $posmax; ?>" size="8" class="inpB2 numeric" onblur="sumcol('C',<?php echo $posmax; ?>); " /></td>
                    <td width="8%" ><input type="text" name="D_<?php echo $posmax; ?>" id="D_<?php echo $posmax; ?>" size="8" class="inpB2 numeric" onblur="sumcol('D',<?php echo $posmax; ?>); " /></td>
                    <td width="8%" ><input type="text" name="E_<?php echo $posmax; ?>" id="E_<?php echo $posmax; ?>" size="8" class="inpB2 numeric" onblur="sumcol('E',<?php echo $posmax; ?>); " /></td>
                    <td width="8%" ><input type="text" name="F_<?php echo $posmax; ?>" id="F_<?php echo $posmax; ?>" size="8" class="inpB2 numeric" onblur="sumcol('F',<?php echo $posmax; ?>); " /></td>
                    <td width="8%" ><label class="labB" id="G_<?php echo $posmax ?>">0</label></td>
                    <td width="8%" ><input type="text" name="H_<?php echo $posmax; ?>" id="H_<?php echo $posmax; ?>" size="8" class="inpB2 numeric" onblur="sumcol('H',<?php echo $posmax; ?>); " /></td>
                    <td width="8%" ><input type="text" name="I_<?php echo $posmax; ?>" id="I_<?php echo $posmax; ?>" size="8" class="inpB2 numeric" onblur="sumcol('I',<?php echo $posmax; ?>); " /></td>
                    <td width="8%" ><input type="text" name="J_<?php echo $posmax; ?>" id="J_<?php echo $posmax; ?>" size="8" class="inpB2 numeric" onblur="sumcol('J',<?php echo $posmax; ?>); saveUPD(1); return false;" /></td>
                    <td width="8%" ><label class="labB" id="totK_<?php echo $posmax ?>">0</label></td>
                    <td width="8%" ><label class="labB" id="totL_<?php echo $posmax ?>">0</label></td>
                    <td width="5%" >&nbsp;</td>                    
                </tr>
                <?php 
                $posmax = $posmax + 1;
                } ?>
                </tbody>
                <tfoot>
                <tr>
                  <td align="center" >SUB TOTAL</td>
                  <td align="right"  >&nbsp;</td>
                  <td align="right"  ><label class="labB" id="totC"><?php echo number_format($c) ?></label></td>
                  <td align="right"  ><label class="labB" id="totD"><?php echo number_format($d) ?></label></td>
                  <td align="right"  ><label class="labB" id="totE"><?php echo number_format($e) ?></label></td>
                  <td align="right"  ><label class="labB" id="totF"><?php echo number_format($f) ?></label></td>
                  <td align="right"  ><label class="labB" id="totG"><?php echo number_format($g) ?></label></td>
                  <td align="right"  ><label class="labB" id="totH"><?php echo number_format($h) ?></label></td>
                  <td align="right"  ><label class="labB" id="totI"><?php echo number_format($i) ?></label></td>
                  <td align="right"  ><label class="labB" id="totJ"><?php echo number_format($j) ?></label></td>
                  <td align="right"  ><label class="labB" id="totK"><?php echo number_format($k) ?></label></td>
                  <td align="right"  ><label class="labB" id="totL"><?php echo number_format($l) ?></label></td>
                  <td align="right"  >&nbsp;</td>
                </tr>
                </tfoot>
                
            </table>
            <input type="hidden" name="maxrow" id="maxrow" value="<?php echo $posmax ?>">
            <a href="#" id="addcertificacion" class="btnAdd">Agregar campos</a>
            <p>
                <span id="msg" style="display: none;" class="bxEr" >Debe introducir movimiento para invetarios</span>
                <span id="msg2" style="display: none;" class="bxEr"  >Debe introducir el detalle para otros inventarios</span>               
            </p>                                      
            <p><?php echo OPERATOR::getDescTitles(3,'A',14,1); ?></p>
            <span class="bxBt">
            <input type="submit" value="SIGUIENTE" id="sendData" name="continuarregistro" class="button" >
            <a href="acap13.php" class="btnS">ANTERIOR</a>                
            </span>

        </fieldset>
  </form>
    <div class="clear"></div>      

</div>
<!-- end body -->

<?php include("footer.php") ?>