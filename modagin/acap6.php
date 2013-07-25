<?php session_start(); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
?>
<?php include_once('../verifyLogin.php'); ?>
<?php include("header.php") ?>
<script type="text/javascript" src="js/acap6.js"></script>
<?php
/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];


$sql = "SELECT * FROM frm3_cap6_ventaproductos WHERE vepr_regi_uid = '".$regisroUID."' ";
$db->query( $sql );

if( $db->numrows() == 0 ) {

    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    $sql2 = "SELECT * FROM adm_definiciones WHERE defi_form_uid = '".$uidFormulario."' AND defi_modulo = 'a' AND  defi_capitulo = '6' ";       
    $db2->query( $sql2 );
    while( $aDefinicion =  $db2->next_record() ) {
        $sql = "INSERT INTO frm3_cap6_ventaproductos SET ";
        $sql .= "vepr_regi_uid = '".$regisroUID."', ";
        $sql .= "vepr_defi_uid = '".$aDefinicion["defi_uid"]."', ";
        $sql .= "vepr_valor = 0, ";         
        $sql .= "vepr_suv_uid = '".$uid_token."', "; 
        $sql .= "vepr_createdate = NOW(), "; 
        $sql .= "vepr_updatedate = NOW() ";                          	 	
        $db3->query( $sql );                
    }        
}

function montharray( $month ){
    $arr = Array();
    $n = strlen($month);
    for($i=0; $i<$n; $i++){
        $arr[$i] = substr($month,$i,1);
    }
    //[0] => 0 [1] => 0 [2] => 0 ... [11] => 0
    return $arr;
}
// print_r($month);
?>
    <!-- begin body -->
    <div class="content">    <span id="statusACAP1"></span>
    <table class="dInf">
    <thead>
    <tr>
        <th>Cap&iacute;tulo 6</th>
        <th>INGRESOS POR VENTA DE PRODUCTOS FABRICADOS</th>
    </tr>
    </thead>
    <tbody>
        <tr>                        
            <td colspan="2"><?php echo OPERATOR::getDescTitles(3,'A',6,0); ?></td>
        </tr>
    </tbody>
    </table>
    
    <form class="formA validable" action="acap6Add.php" method="post" autocomplete="off" >
        <fieldset>
          
          <table width="100%" class="fOpt"  >
                <thead>
                <tr>
                    <th align="center">DETALLE</th>
                    <th width="20%" align="center" >VALOR (Bs/Anual)</th>
                    <th width="20%" align="center" >SECTOR O ACTIVIDAD DE LOS CLIENTES</th>
                    <th width="20%" align="center" >PORCENTAJE (%)</th>                    
                </tr>
                </thead>
                <tbody>
                <?php                
                //Tipo de personal
                                
                $sql = " SELECT vepr_defi_uid, vepr_valor "
                      ." FROM frm3_cap6_ventaproductos "
                      ." WHERE vepr_regi_uid = '".$regisroUID."' AND vepr_defi_uid IN (383,384,380,367,372,366) ";                
                $db->query( $sql );                
                
                $tot1 = 0;                
                $tot2 = 0;
                $tot3 = 0;
                $tot4 = 0;
                $tot5 = 0;
                $tot6 = 0;
                while( $aVP = $db->next_record() ) {
                    if( $aVP["vepr_defi_uid"]==383 ) { $tot1 = $aVP["vepr_valor"]; } //Ventas a Instituciones Públicas
                    if( $aVP["vepr_defi_uid"]==384 ) { $tot2 = $aVP["vepr_valor"]; } //Ventas a Empresas privadas
                    if( $aVP["vepr_defi_uid"]==380 ) { $tot3 = $aVP["vepr_valor"]; } //Ventas a Personas particulares
                    if( $aVP["vepr_defi_uid"]==367 ) { $tot4 = $aVP["vepr_valor"]; } //Total Ventas al Mercado Nacional
                    if( $aVP["vepr_defi_uid"]==372 ) { $tot5 = $aVP["vepr_valor"]; } //Total Ventas al Mercado Externo
                    if( $aVP["vepr_defi_uid"]==366 ) { $tot6 = $aVP["vepr_valor"]; } //TOTAL VENTAS
                    
                }
                
                $sql = " SELECT frm3_cap6_ventaproductos.*, adm_definiciones.defi_vinieta as vinieta, adm_definiciones.defi_indent	 as indent "
                      ." FROM frm3_cap6_ventaproductos LEFT JOIN  adm_definiciones ON ( vepr_defi_uid	 = defi_uid ) "
                      ." WHERE vepr_regi_uid = '".$regisroUID."' AND vepr_defi_uid IN (368,369,370,371,373,374,375,376,377,378,379,381,382) "
                      ." ORDER BY adm_definiciones.defi_indent ASC,  adm_definiciones.defi_vinieta ASC ";
                $db->query( $sql );
                
                $percent1 = "";
                $percent2 = "";
                ?>
                <?php  
                while( $aVP = $db->next_record() ) {                                            
                ?>
                
                <?php if( $aVP["indent"] == '11' && $aVP["vinieta"] == "a" ) { ?>
                <tr>
                    <td width="40%" rowspan="5" class="titR" >a.  Ventas a Instituciones P&uacute;blicas (Valor aproximado)</td>
                    <td rowspan="5" align="right"  >
                    <input  type="text" name="input-1" id="input-1" value="<?php echo number_format($tot1); ?>" size="20" class="inpB2 numeric" />
                    <span id="div_input-1" class="bxEr" style="display:none" >requerido</span>
                    </td>
                    <td align="left" class="titR"  >a) Ministerios e Instituciones P&uacute;blicas del Gobierno Central</td>
                      <td align="center"  >
                        <input  type="text" name="input-21" id="input-21" value="<?php echo $aVP["vepr_valor"]; ?>" size="20" maxlength="3" class="inpB2 numeric" />
                        <span id="div_input-21" class="bxEr" style="display:none" >requerido</span>
                      </td>
                </tr>
                <?php 
                    $percent1 = $percent1 + $aVP["vepr_valor"];
                
                }                    
                ?>
                
                <?php if( $aVP["indent"] == '11' && $aVP["vinieta"] == "b" ) { ?>
                <tr>
                  <td align="left" class="titR"  >b)  Gobernaciones</td>
                  <td align="center"  >
                  <input   type="text" name="input-22" id="input-22" value="<?php echo $aVP["vepr_valor"]; ?>" size="20" maxlength="3" class="inpB2 numeric" />
                  <span id="div_input-22" class="bxEr" style="display:none" >requerido</span>
                  </td>
                </tr>
                <?php 
                    $percent1 = $percent1 + $aVP["vepr_valor"];
                }                     
                ?>
                
                <?php if( $aVP["indent"] == '11' && $aVP["vinieta"] == "c" ) { ?>
                <tr>
                  <td align="left" class="titR"  >c)  Alcald&iacute;as</td>
                  <td align="center"  >
                  <input   type="text" name="input-23" id="input-23" value="<?php echo $aVP["vepr_valor"]; ?>" size="20" maxlength="3" class="inpB2 numeric" />
                  <span id="div_input-23" class="bxEr" style="display:none" >requerido</span>
                  </td>
                </tr>
                <?php 
                    $percent1 = $percent1 + $aVP["vepr_valor"];
                }                    
                ?>
                
                <?php if( $aVP["indent"] == '11' && $aVP["vinieta"] == "d" ) { ?>
                <tr>
                  <td align="left" class="titR"  >d)  Otras entidades p&uacute;blicas</td>
                  <td align="center"  >
                  <input   type="text" name="input-24" id="input-24" onblur="javascript:saveUPD(1); return false;" value="<?php echo $aVP["vepr_valor"]; ?>" size="20" maxlength="3" class="inpB2 numeric" />
                  <span id="div_input-24" class="bxEr" style="display:none" >requerido</span>
                  </td>
                </tr>
                <tr>
                  <td align="left" class="titR"  >Total %</td>
                  <td align="center"  >
                      <?php $percent1 = $percent1 + $aVP["vepr_valor"]; ?>
                      <span id="percent1" class="labB" ><?php echo $percent1; ?></span>
                  </td>
                </tr>
                <?php }                    
                ?>
                
                <?php if( $aVP["indent"] == '12' && $aVP["vinieta"] == "a" ) { ?>
                <tr>
                    <td width="40%" rowspan="8" class="titR" >b.  Ventas a Empresas Privadas (Valor aproximado)</td>
                    <td rowspan="8" align="right"  >
                    <input   type="text" name="input-2" id="input-2" value="<?php echo number_format($tot2); ?>" size="20" class="inpB2 numeric">
                    <span id="div_input-2" class="bxEr" style="display:none" >requerido</span>
                    </td>
                    <td align="left" class="titR"  >a)  Agricultura, ganader&iacute;a y pesca</td>
                  <td align="center"  >
                    <input   type="text" name="input-25" id="input-25" value="<?php echo $aVP["vepr_valor"]; ?>" size="20" maxlength="3" class="inpB2 numeric" />
                    <span id="div_input-25" class="bxEr" style="display:none" >requerido</span>
                  </td>
                </tr>
                <?php 
                    $percent2 = $percent2 + $aVP["vepr_valor"];
                } ?>
                
                <?php if( $aVP["indent"] == '12' && $aVP["vinieta"] == "b" ) { ?>
                <tr>
                  <td align="left" class="titR" >b)   Mineria, Hidrocarburos y Forestal</td>
                  <td align="center"  >
                  <input   type="text" name="input-26" id="input-26" value="<?php echo $aVP["vepr_valor"]; ?>" size="20" maxlength="3" class="inpB2 numeric" />
                  <span id="div_input-26" class="bxEr" style="display:none" >requerido</span>
                  </td>
                </tr>
                <?php 
                    $percent2 = $percent2 + $aVP["vepr_valor"];
                } ?>
                
                <?php if( $aVP["indent"] == '12' && $aVP["vinieta"] == "c" ) { ?>
                <tr>
                  <td align="left" class="titR" >c)   Agroindustria e Industria de Alimentos</td>
                  <td align="center"  >
                  <input   type="text" name="input-27" id="input-27" value="<?php echo $aVP["vepr_valor"]; ?>" size="20" maxlength="3" class="inpB2 numeric" />
                  <span id="div_input-27" class="bxEr" style="display:none" >requerido</span>
                  </td>
                </tr>
                <?php 
                    $percent2 = $percent2 + $aVP["vepr_valor"];
                } ?>
                
                <?php if( $aVP["indent"] == '12' && $aVP["vinieta"] == "d" ) { ?>
                <tr>
                  <td align="left" class="titR" >d)  Otras industrias manufactureras</td>
                  <td align="center"  >
                  <input   type="text" name="input-28" id="input-28" onblur="javascript:saveUPD(1); return false;" value="<?php echo $aVP["vepr_valor"]; ?>" size="20" maxlength="3" class="inpB2 numeric" />
                  <span id="div_input-28" class="bxEr" style="display:none" >requerido</span>
                  </td>
                </tr>
                <?php 
                    $percent2 = $percent2 + $aVP["vepr_valor"];
                } ?>
                
                <?php if( $aVP["indent"] == '12' && $aVP["vinieta"] == "e" ) { ?>
                <tr>
                  <td align="left" class="titR" >e) Comercio</td>
                  <td align="center"  ><input type="text" name="input-29" id="input-29" onblur="javascript:saveUPD(2); return false;" value="<?php echo $aVP["vepr_valor"]; ?>" size="20" maxlength="3" class="inpB2 numeric" /></td>
                </tr>
                <?php 
                    $percent2 = $percent2 + $aVP["vepr_valor"];
                } ?>
                
                <?php if( $aVP["indent"] == '12' && $aVP["vinieta"] == "f" ) { ?>
                <tr>
                  <td align="left" class="titR" >f) Servicios</td>
                  <td align="center"  ><input   type="text" name="input-30" id="input-30" value="<?php echo $aVP["vepr_valor"]; ?>" size="20" maxlength="3" class="inpB2 numeric" /></td>
                </tr>
                <?php 
                    $percent2 = $percent2 + $aVP["vepr_valor"];
                } ?>
                
                <?php if( $aVP["indent"] == '12' && $aVP["vinieta"] == "g" ) { ?>
                <tr>
                  <td align="left" class="titR" >g) Otras actividades</td>
                  <td align="center"  ><input   type="text" name="input-31" id="input-31" onblur="javascript:saveUPD(1); return false;" value="<?php echo $aVP["vepr_valor"]; ?>" size="20" maxlength="3" class="inpB2 numeric" /></td>
                </tr>
                <tr>
                  <td align="left" class="titR" >Total %</td>
                  <td align="center"  >
                      <?php $percent2 = $percent2 + $aVP["vepr_valor"]; ?>
                      <span id="percent2" class="labB" ><?php echo $percent2 ?></span>
                  </td>
                </tr>
                <?php 
                    $percent2 = $percent2 + $aVP["vepr_valor"];
                } ?>
                                                                                                
                <?php if( $aVP["indent"] == '13' && $aVP["vinieta"] == "a" ) { ?>
                <tr>
                  <td rowspan="3" class="titR" >c.  Ventas a Personas Particulares (Valor aproximado)</td>
                  <td rowspan="3" align="right"  >
                  <input type="text" name="input-3" id="input-3" value="<?php echo number_format($tot3); ?>" size="20" class="inpB2 numeric" />
                  <span id="div_input-3" class="bxEr" style="display:none" >requerido</span>                  </td>
                  <td align="left" class="titR"  > a) Comerciantes</td>
                  <td align="right"  ><input   type="text" name="input-32" id="input-32" value="<?php echo $aVP["vepr_valor"]; ?>" size="20" maxlength="3" class="inpB2 numeric" /></td>
                </tr>
                <?php 
                    $percent3 = $percent3 + $aVP["vepr_valor"];
                } ?>
                
                <?php if( $aVP["indent"] == '13' && $aVP["vinieta"] == "b" ) { ?>
                <tr>
                  <td align="left" class="titR"  > b) Consumidores</td>
                  <td align="right"  ><input   type="text" name="input-33" id="input-33" onblur="javascript:saveUPD(3); return false;" value="<?php echo $aVP["vepr_valor"]; ?>" size="20" maxlength="3" class="inpB2 numeric" /></td>
                </tr>
                                                
                <tr>
                  <td align="left" class="titR"  >Total %</td>
                  <td align="right"  ><?php $percent3 = $percent3 + $aVP["vepr_valor"]; ?>
                  <span id="percent3" class="labB" ><?php echo $percent3 ?></span></td>
                </tr>
                <?php 
                    
                } ?>
                
                <?php 
                    
                } ?>
                <tr>
                  <td class="titR" >1.1 Total Ventas al Mercado Nacional (Valor aproximado) (a + b + c)</td>
                  <td align="right"  ><span class="labB" id="totventanal" ><?php echo number_format($tot4); ?></span></td>
                  <td align="left"  >&nbsp;</td>
                  <td align="right"  >&nbsp;</td>
                </tr>
                <tr>
                  <td class="titR" >1.2 Total Ventas al Mercado Externo (Valor aproximado)</td>
                  <td align="right"  ><input type="text" name="totexterno" id="totexterno" value="<?php echo number_format($tot5); ?>" size="20"  class="inpB2 numeric" /></td>
                  <td align="left"  >&nbsp;</td>
                  <td align="right"  >&nbsp;</td>
                </tr>
                <tr>
                  <td class="titR" > 1. TOTAL VENTAS: (Valor del Estado de Resultados) </td>
                  <td align="right"  ><span class="labB" id="totventa" ><?php echo number_format($tot6); ?></span></td>
                  <td align="left"  >&nbsp;</td>
                  <td align="right"  >&nbsp;</td>
                </tr>
                </tbody>
            </table>
            
            <p>
                <span id="msg" style="display:none;" class="bxEr" >Introducir el porcentaje para el valor especificado que debe sumar 100%</span>
                <span id="msg1" style="display:none;" class="bxEr" >Debe introducir el valor para el porcentaje especificado</span>
                <span id="msg2" style="display:none;" class="bxEr" >Debe registrar movimiento en ventas</span>
            </p>
          
            
          <span class="bxBt">
                <input type="submit" value="SIGUIENTE" id="sendData" name="continuarregistro" class="button" >
                <a href="acap5.php" class="btnS">ANTERIOR</a>                
          </span>


        </fieldset>
    </form>
    <div class="clear"></div>      

</div>
<!-- end body -->        

<?php include("footer.php") ?>
