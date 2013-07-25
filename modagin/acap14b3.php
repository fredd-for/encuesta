<?php session_start(); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php'); ?>
<?php include("header.php") ?>
<script type="text/javascript" src="js/acap14b_3.js"></script>
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
        <th>Cap&iacute;tulo <br />14-b</th>
        <th>MATERIAS PRIMAS, MATERIALES AUXILIARES, ENVASES Y EMBALAJES - FABRICADOS FUERA DEL PA&Iacute;S</th>
    </tr>
    </thead>
    <tbody>
        <tr>                        
            <td colspan="2"><?php echo OPERATOR::getDescTitles(3,'A',14,'b1'); ?></td>
        </tr>
    </tbody>
    </table>        
    
    <form class="formA validable" action="acap14b3Add.php" method="post" autocomplete="off" >
      <fieldset>                          
          <p><span class="subT" >MATERIALES ENVASES Y EMBALAJES</span></p>
          <table width="100%" class="fOpt" id="tablecertificacion" >
                <thead>
                <tr>
                  <td rowspan="2" align="center" >Descripci&oacute;n de envases y embalajes</td>
                  <td rowspan="2" align="center" >Unidad de medida</td>
                  <td colspan="2" align="center" >INVENTARIO INICIAL</td>
                  <td colspan="2" align="center" >COMPRAS</td>
                  <td colspan="2" align="center" >UTILIZACI&Oacute;N</td>
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
                  </tr>
                </thead>
                    
                <tbody>
                <?php
                $posmax = OPERATOR::getDbValue("SELECT MAX(mapr_position) + 1 as pos FROM frm3_cap14b_materiasprimas WHERE mapr_regi_uid = '".$regisroUID."' AND  mapr_tima_uid = '3' AND mapr_position <> 0");
                if( empty($posmax) ) { $posmax = 1; }
                
                $sql3 = "SELECT * FROM frm3_cap14b_materiasprimas WHERE mapr_regi_uid = '".$regisroUID."' AND mapr_delete = 0 AND mapr_position <> 0 AND mapr_tima_uid = '3' ORDER BY mapr_position ASC  ";
                //echo $sql3;
                $d = 0; $e = 0; $f = 0; $g = 0; $h = 0; $i = 0; $j = 0; $k = 0; $l = 0; $m = 0;
                $db3->query( $sql3 );
                if( $db3->numrows() > 0 ) {
                while( $aDat = $db3->next_record() ) {
                    $pos = $aDat["mapr_position"];
                    
                    $c = $c + $aDat["mapr_invini_cantidad"]; 
                    $d = $d + $aDat["mapr_invini_valor"];                    
                    $e = $e + $aDat["mapr_compra_cantidad"]; 
                    $f = $f + $aDat["mapr_compra_valor"]; 
                    $g = $g + $aDat["mapr_util_cantidad"]; 
                    $h = $h + $aDat["mapr_util_valor"]; 
                    $i = $i + $aDat["mapr_invfin_cantidad"]; 
                    $j = $j + $aDat["mapr_invfin_valor"];
                    
                ?>
                <tr id="row_<?php echo $pos; ?>" >
                    <td width="13%"><input type="text" name="A_<?php echo $pos ?>" id="A_<?php echo $pos ?>" value="<?php echo $aDat["mapr_materiadesc"] ?>" size="30" class="inpC2" /></td>
                    <td width="6%" ><input type="text" name="B_<?php echo $pos ?>" id="B_<?php echo $pos ?>" value="<?php echo $aDat["mapr_unidadmedida"] ?>" size="8" class="inpC2" /></td>
                    <td width="8%" ><input type="text" name="C_<?php echo $pos ?>" id="C_<?php echo $pos ?>" value="<?php echo number_format($aDat["mapr_invini_cantidad"]) ?>" size="8" class="inpB2 numeric" onblur="sumcol('C',<?php echo $pos ?>);" /></td>
                    <td width="8%" ><input type="text" name="D_<?php echo $pos ?>" id="D_<?php echo $pos ?>" value="<?php echo number_format($aDat["mapr_invini_valor"]) ?>"    size="8" class="inpB2 numeric" onblur="sumcol('D',<?php echo $pos ?>);" /></td>
                    <td width="8%" ><input type="text" name="E_<?php echo $pos ?>" id="E_<?php echo $pos ?>" value="<?php echo number_format($aDat["mapr_compra_cantidad"]) ?>" size="8" class="inpB2 numeric" onblur="sumcol('E',<?php echo $pos ?>);" /></td>
                    <td width="8%" ><input type="text" name="F_<?php echo $pos ?>" id="F_<?php echo $pos ?>" value="<?php echo number_format($aDat["mapr_compra_valor"]) ?>"    size="8" class="inpB2 numeric" onblur="sumcol('F',<?php echo $pos ?>);" /></td>
                    <td width="8%" ><input type="text" name="G_<?php echo $pos ?>" id="G_<?php echo $pos ?>" value="<?php echo number_format($aDat["mapr_util_cantidad"]) ?>"   size="8" class="inpB2 numeric" onblur="sumcol('G',<?php echo $pos ?>);" /></td>
                    <td width="8%" ><input type="text" name="H_<?php echo $pos ?>" id="H_<?php echo $pos ?>" value="<?php echo number_format($aDat["mapr_util_valor"]) ?>"      size="8" class="inpB2 numeric" onblur="sumcol('H',<?php echo $pos ?>); saveUPD(1); return false;" /></td>
                    <td width="8%" ><label class="labB" id="totI_<?php echo $pos ?>"><?php echo number_format($aDat["mapr_invfin_cantidad"]) ?></label></td>
                    <td width="8%" ><label class="labB" id="totJ_<?php echo $pos ?>"><?php echo number_format($aDat["mapr_invfin_valor"]) ?></label></td>
                    <td width="5%" ><a href="#" class="lnkCls" id="delplan_<?php echo $aDat["mapr_position"] ?>" onclick="delRow('<?php echo $pos ?>',1); return false;" >eliminar</a></td>                    
                </tr>
                <?php }                            
                } else {
                ?>
                <tr id="row_<?php echo $posmax; ?>" >
                    <td width="13%"><input type="text" name="A_<?php echo $posmax; ?>" id="A_<?php echo $posmax; ?>" size="30" class="inpC2" /></td>
                    <td width="6%" ><input type="text" name="B_<?php echo $posmax; ?>" id="B_<?php echo $posmax; ?>" size="8" class="inpC2" /></td>
                    <td width="8%" ><input type="text" name="C_<?php echo $posmax; ?>" id="C_<?php echo $posmax; ?>" size="8" class="inpB2 numeric" onblur="sumcol('C',<?php echo $posmax; ?>);" /></td>
                    <td width="8%" ><input type="text" name="D_<?php echo $posmax; ?>" id="D_<?php echo $posmax; ?>" size="8" class="inpB2 numeric" onblur="sumcol('D',<?php echo $posmax; ?>);" /></td>
                    <td width="8%" ><input type="text" name="E_<?php echo $posmax; ?>" id="E_<?php echo $posmax; ?>" size="8" class="inpB2 numeric" onblur="sumcol('E',<?php echo $posmax; ?>);" /></td>
                    <td width="8%" ><input type="text" name="F_<?php echo $posmax; ?>" id="F_<?php echo $posmax; ?>" size="8" class="inpB2 numeric" onblur="sumcol('F',<?php echo $posmax; ?>);" /></td>
                    <td width="8%" ><input type="text" name="G_<?php echo $posmax; ?>" id="G_<?php echo $posmax; ?>" size="8" class="inpB2 numeric" onblur="sumcol('G',<?php echo $posmax; ?>);" /></td>
                    <td width="8%" ><input type="text" name="H_<?php echo $posmax; ?>" id="H_<?php echo $posmax; ?>" size="8" class="inpB2 numeric" onblur="sumcol('H',<?php echo $posmax; ?>); saveUPD(1); return false;" /></td>
                    <td width="8%" ><label class="labB" id="totI_<?php echo $posmax ?>">0</label></td>
                    <td width="8%" ><label class="labB" id="totJ_<?php echo $posmax ?>">0</label></td>
                    <td width="5%" >&nbsp;</td>                    
                </tr>
                <?php 
                $posmax = $posmax + 1;
                }                 
                ?>
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
                  <td align="right"  >&nbsp;</td>                  
                </tr>
                
                <?php             
                $sql = "SELECT
                         SUM(mapr_invini_cantidad) as invini_cantidad, 
                         SUM(mapr_invini_valor) as invini_valor,  
                         SUM(mapr_compra_cantidad) as compra_cantidad,  
                         SUM(mapr_compra_valor) as compra_valor,  
                         SUM(mapr_util_cantidad) as util_cantidad,  
                         SUM(mapr_util_valor) as util_valor,  
                         SUM(mapr_invfin_cantidad) as invfin_cantidad,  
                         SUM(mapr_invfin_valor) as invfin_valor
                        FROM frm3_cap14b_materiasprimas WHERE mapr_regi_uid = '".$regisroUID."' AND mapr_delete = 0 AND  mapr_tima_uid IN (1,2,3) AND mapr_position <> 0 GROUP BY mapr_regi_uid";
                $db3->query( $sql );                
                $aTot = $db3->next_record();
                ?>
                <tr>
                  <td align="center" colspan="2" ><label class="labB">TOTAL</label></td>                  
                  <td align="right"  ><label class="labB" id="totTC"><?php echo number_format($aTot["invini_cantidad"]) ?></label></td>
                  <td align="right"  ><label class="labB" id="totTD"><?php echo number_format($aTot["invini_valor"]) ?></label></td>
                  <td align="right"  ><label class="labB" id="totTE"><?php echo number_format($aTot["compra_cantidad"]) ?></label></td>
                  <td align="right"  ><label class="labB" id="totTF"><?php echo number_format($aTot["compra_valor"]) ?></label></td>
                  <td align="right"  ><label class="labB" id="totTG"><?php echo number_format($aTot["util_cantidad"]) ?></label></td>
                  <td align="right"  ><label class="labB" id="totTH"><?php echo number_format($aTot["util_valor"]) ?></label></td>
                  <td align="right"  ><label class="labB" id="totTI"><?php echo number_format($aTot["invfin_cantidad"]) ?></label></td>
                  <td align="right"  ><label class="labB" id="totTJ"><?php echo number_format($aTot["invfin_valor"]) ?></label></td>
                  <td align="right"  >&nbsp;</td>
                </tr>
                
                </tfoot>
                
            </table>
            <input type="hidden" name="maxrow" id="maxrow" value="<?php echo $posmax ?>">
            <a href="#" id="addcertificacion" class="btnAdd">Agregar campos</a>
            <?php 
            $sql = "SELECT mapi_valor FROM  frm3_cap5_materiaprima WHERE mapi_regi_uid = '".$regisroUID."' AND mapi_defi_uid	 = 364 ";
            $db2->query( $sql );
            $aTotCap5 = $db2->next_record();
            ?>
            
            <p>
                <span id="msg" style="display: none;" class="bxEr" >Debe introducir movimiento para invetarios</span>
                <span id="msg2" style="display: none;" class="bxEr"  >Debe introducir el detalle para otros inventarios</span>
                <span id="msg3" style="display: none;" class="bxEr"  >El valor total de la columna de "inventario final" debe ser igual a Bs. <span id="Tt"><?php echo number_format($aTotCap5["mapi_valor"]);  ?></span></span>
            </p>
            
            
            <p>
                El <b>valor</b> total de la columna de "inventario final" debe ser igual a Bs. <b><?php echo number_format($aTotCap5["mapi_valor"]);  ?></b> 
                que corresponde al total de Compra de materias primas, materiales auxiliares, envases y embalajes, fabricados fuera del pa&iacute;s.
            </p>
            
            <p><?php echo OPERATOR::getDescTitles(3,'A',14,'b2'); ?></p>
            <span class="bxBt">
            <input type="submit" value="SIGUIENTE" id="sendData" name="continuarregistro" class="button" >
            <a href="acap14b2.php" class="btnS">ANTERIOR</a>                
            </span>

        </fieldset>
  </form>
    <div class="clear"></div>      

</div>
<!-- end body -->

<?php include("footer.php") ?>