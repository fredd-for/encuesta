<?php session_start(); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
?>
<?php include_once('../verifyLogin.php'); ?>
<?php include("header.php") ?>
<script type="text/javascript" src="js/acap7.js"></script>
<?php
/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];


$sql = "SELECT * FROM frm1_cap7_ventaservicios WHERE vese_regi_uid = '".$regisroUID."' ";
$db->query( $sql );

if( $db->numrows() == 0 ) {

    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    $sql2 = "SELECT * FROM adm_definiciones WHERE defi_form_uid = '".$uidFormulario."' AND defi_modulo = 'a' AND  defi_capitulo = '7' ";       
    $db2->query( $sql2 );
    while( $aDefinicion =  $db2->next_record() ) {        
        $sql = "INSERT INTO frm1_cap7_ventaservicios SET ";
        $sql .= "vese_regi_uid = '".$regisroUID."', ";
        $sql .= "vese_defi_uid = '".$aDefinicion["defi_uid"]."', ";
        $sql .= "vese_valor = 0, ";         
        $sql .= "vese_suv_uid = '".$uid_token."', "; 
        $sql .= "vese_createdate = NOW(), "; 
        $sql .= "vese_updatedate = NOW() ";                          	 	
        $db3->query( $sql );                
    }        
}

// meses
$sql = "SELECT * FROM frm1_cap7_2mesesmayorventa WHERE memv_regi_uid = '".$regisroUID."' ";
$db2->query( $sql );

if( $db2->numrows() == 0 ) {
    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );    
    $sql = "INSERT INTO frm1_cap7_2mesesmayorventa SET ";
    $sql .= "memv_regi_uid = '".$regisroUID."', ";   
    $sql .= "memv_meses = '000000000000', ";         
    $sql .= "memv_suv_uid = '".$uid_token."', "; 
    $sql .= "memv_createdate = NOW() ";                           	 	
    $db3->query( $sql );   
}

$sql = "SELECT memv_meses FROM frm1_cap7_2mesesmayorventa WHERE memv_regi_uid = '".$regisroUID."' ";
$db3->query( $sql );
$aMonth = $db3->next_record();
$month = montharray($aMonth["memv_meses"]);

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
        <th>Cap&iacute;tulo 7</th>
        <th>VENTA DE MERCADER&Iacute;AS O SERVICIOS</th>
    </tr>
    </thead>
    <tbody>
        <tr>                        
            <td colspan="2"><?php echo OPERATOR::getDescTitles(1,'A',7,0); ?></td>
        </tr>
    </tbody>
    </table>
    
    <form class="formA validable" action="acap7Add.php" method="post" autocomplete="off" >
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
                // defi_vinieta a,b,c,d
                
                $sql = " SELECT vese_defi_uid, vese_valor "
                      ." FROM frm1_cap7_ventaservicios "
                      ." WHERE vese_regi_uid = '".$regisroUID."' AND vese_defi_uid IN (29,30,35,40,41,42) ";                
                $db->query( $sql );                
                //echo $sql;
                $tot1 = 0;                
                $tot2 = 0;
                $tot3 = 0;
                $tot4 = 0;
                $tot5 = 0;
                $tot6 = 0;
                while( $aMercaderia = $db->next_record() ) {
                    if( $aMercaderia["vese_defi_uid"]==29 ) { $tot1 = $aMercaderia["vese_valor"]; } //Total Ventas al Mercado Nacional
                    if( $aMercaderia["vese_defi_uid"]==30 ) { $tot2 = $aMercaderia["vese_valor"]; } //Ventas a Instituciones Públicas
                    if( $aMercaderia["vese_defi_uid"]==35 ) { $tot3 = $aMercaderia["vese_valor"]; } //Ventas a Empresas Privadas
                    if( $aMercaderia["vese_defi_uid"]==40 ) { $tot4 = $aMercaderia["vese_valor"]; } //Ventas a Personas Particulares
                    if( $aMercaderia["vese_defi_uid"]==41 ) { $tot5 = $aMercaderia["vese_valor"]; } //Total Ventas al Mercado Externo
                    if( $aMercaderia["vese_defi_uid"]==42 ) { $tot6 = $aMercaderia["vese_valor"]; } //TOTAL VENTAS
                    
                }
                
                $sql = " SELECT frm1_cap7_ventaservicios.*, adm_definiciones.defi_vinieta as vinieta, adm_definiciones.defi_indent	 as indent "
                      ." FROM frm1_cap7_ventaservicios LEFT JOIN  adm_definiciones ON ( vese_defi_uid	 = defi_uid ) "
                      ." WHERE vese_regi_uid = '".$regisroUID."' AND vese_defi_uid IN (31,32,33,34, 36,37,38,39) "
                      ." ORDER BY adm_definiciones.defi_indent ASC,  adm_definiciones.defi_vinieta ASC ";
                $db->query( $sql );

                //echo $sql;                
                $percent1 = "";
                $percent2 = "";
                ?>
                <?php  
                while( $aMercaderia = $db->next_record() ) {                                            
                ?>
                
                <?php if( $aMercaderia["indent"] == '11' && $aMercaderia["vinieta"] == "a" ) { ?>
                <tr>
                    <td width="40%" rowspan="5" class="titR" >a.  Ventas a Instituciones P&uacute;blicas (Valor aproximado)</td>
                    <td rowspan="5" align="right"  >
                    <input onblur="javascript:saveUPD(1); return false;" type="text" name="input-1" id="input-1" value="<?php echo number_format($tot2); ?>" size="20" class="inpB2 numeric" />
                    <span id="div_input-1" class="bxEr" style="display:none" >requerido</span>
                    </td>
                    <td align="left" class="titR"  >a)  Ministerios e Instituciones P&uacute;blicas del Gobierno Central</td>
                      <td align="center"  >
                        <input onblur="javascript:saveUPD(1); return false;" type="text" name="input-21" id="input-21" value="<?php echo $aMercaderia["vese_valor"]; ?>" size="20" maxlength="3" class="inpB2 numeric" />
                        <span id="div_input-21" class="bxEr" style="display:none" >requerido</span>
                      </td>
                </tr>
                <?php 
                    $percent1 = $percent1 + $aMercaderia["vese_valor"];
                
                }                    
                ?>
                
                <?php if( $aMercaderia["indent"] == '11' && $aMercaderia["vinieta"] == "b" ) { ?>
                <tr>
                  <td align="left" class="titR"  >b)  Gobernaciones</td>
                  <td align="center"  >
                  <input onblur="javascript:saveUPD(1); return false;"  type="text" name="input-22" id="input-22" value="<?php echo $aMercaderia["vese_valor"]; ?>" size="20" maxlength="3" class="inpB2 numeric" />
                  <span id="div_input-22" class="bxEr" style="display:none" >requerido</span>
                  </td>
                </tr>
                <?php 
                    $percent1 = $percent1 + $aMercaderia["vese_valor"];
                }                     
                ?>
                
                <?php if( $aMercaderia["indent"] == '11' && $aMercaderia["vinieta"] == "c" ) { ?>
                <tr>
                  <td align="left" class="titR"  >c)  Gobierno Aut&oacute;nomo Municipal</td>
                  <td align="center"  >
                  <input onblur="javascript:saveUPD(1); return false;"  type="text" name="input-23" id="input-23" value="<?php echo $aMercaderia["vese_valor"]; ?>" size="20" maxlength="3" class="inpB2 numeric" />
                  <span id="div_input-23" class="bxEr" style="display:none" >requerido</span>
                  </td>
                </tr>
                <?php 
                    $percent1 = $percent1 + $aMercaderia["vese_valor"];
                }                    
                ?>
                
                <?php if( $aMercaderia["indent"] == '11' && $aMercaderia["vinieta"] == "d" ) { ?>
                <tr>
                  <td align="left" class="titR"  >d)  Otros</td>
                  <td align="center"  >
                  <input onblur="javascript:saveUPD(1); return false;"  type="text" name="input-24" id="input-24" value="<?php echo $aMercaderia["vese_valor"]; ?>" size="20" maxlength="3" class="inpB2 numeric" />
                  <span id="div_input-24" class="bxEr" style="display:none" >requerido</span>
                  </td>
                </tr>
                <tr>
                  <td align="left" class="titR"  >Total %</td>
                  <td align="center"  >
                      <?php $percent1 = $percent1 + $aMercaderia["vese_valor"]; ?>
                      <span id="percent1" class="labB" ><?php echo $percent1; ?></span>
                  </td>
                </tr>
                <?php }                    
                ?>
                
                <?php if( $aMercaderia["indent"] == '12' && $aMercaderia["vinieta"] == "a" ) { ?>
                <tr>
                    <td width="40%" rowspan="5" class="titR" >b.  Ventas a Empresas Privadas (Valor aproximado)</td>
                    <td rowspan="5" align="right"  >
                    <input onblur="javascript:saveUPD(1); return false;"  type="text" name="input-2" id="input-2" value="<?php echo number_format($tot3); ?>" size="20" class="inpB2 numeric">
                    <span id="div_input-2" class="bxEr" style="display:none" >requerido</span>
                    </td>
                    <td align="left" class="titR"  >a)  Agricultura, ganader&iacute;a, caza, silvicultura y pesca</td>
                  <td align="center"  >
                    <input onblur="javascript:saveUPD(1); return false;"  type="text" name="input-25" id="input-25" value="<?php echo $aMercaderia["vese_valor"]; ?>" size="20" maxlength="3" class="inpB2 numeric" />
                    <span id="div_input-25" class="bxEr" style="display:none" >requerido</span>
                  </td>
                </tr>
                <?php 
                    $percent2 = $percent2 + $aMercaderia["vese_valor"];
                } ?>
                
                <?php if( $aMercaderia["indent"] == '12' && $aMercaderia["vinieta"] == "b" ) { ?>
                <tr>
                  <td align="left" class="titR" >b)  Industria manufacturera</td>
                  <td align="center"  >
                  <input onblur="javascript:saveUPD(1); return false;"  type="text" name="input-26" id="input-26" value="<?php echo $aMercaderia["vese_valor"]; ?>" size="20" maxlength="3" class="inpB2 numeric" />
                  <span id="div_input-26" class="bxEr" style="display:none" >requerido</span>
                  </td>
                </tr>
                <?php 
                    $percent2 = $percent2 + $aMercaderia["vese_valor"];
                } ?>
                
                <?php if( $aMercaderia["indent"] == '12' && $aMercaderia["vinieta"] == "c" ) { ?>
                <tr>
                  <td align="left" class="titR" >c)  Comercio por mayor</td>
                  <td align="center"  >
                  <input onblur="javascript:saveUPD(1); return false;"  type="text" name="input-27" id="input-27" value="<?php echo $aMercaderia["vese_valor"]; ?>" size="20" maxlength="3" class="inpB2 numeric" />
                  <span id="div_input-27" class="bxEr" style="display:none" >requerido</span>
                  </td>
                </tr>
                <?php 
                    $percent2 = $percent2 + $aMercaderia["vese_valor"];
                } ?>
                
                <?php if( $aMercaderia["indent"] == '12' && $aMercaderia["vinieta"] == "d" ) { ?>
                <tr>
                  <td align="left" class="titR" >d) Otros</td>
                  <td align="center"  >
                  <input onblur="javascript:saveUPD(1); return false;"  type="text" name="input-28" id="input-28" value="<?php echo $aMercaderia["vese_valor"]; ?>" size="20" maxlength="3" class="inpB2 numeric" />
                  <span id="div_input-28" class="bxEr" style="display:none" >requerido</span>
                  </td>
                </tr>
                
                <tr>
                  <td align="left" class="titR" >Total %</td>
                  <td align="center"  >
                      <?php $percent2 = $percent2 + $aMercaderia["vese_valor"]; ?>
                      <span id="percent2" class="labB" ><?php echo $percent2 ?></span>
                  </td>
                </tr>
                
                <?php } ?>
                <?php } ?>
                
                <tr>
                  <td class="titR" >c.  Ventas a Personas Particulares (Valor aproximado)</td>
                  <td align="right"  >
                  <input type="text" name="input-3" id="input-3" value="<?php echo number_format($tot4); ?>" size="20" class="inpB2 numeric" />
                  <span id="div_input-3" class="bxEr" style="display:none" >requerido</span>
                  </td>
                  <td align="left"  >&nbsp;</td>
                  <td align="right"  >&nbsp;</td>
                </tr>
                                                
                <tr>
                  <td class="titR" class="titR" >1.1 Total Ventas al Mercado Nacional (a+b+c) (Valor de los Estados Financieros)</td>
                  <td align="right"  ><span id="total2" class="labB" ><?php echo number_format($tot1); ?></span> </td>
                  <td align="left"  >&nbsp;</td>
                  <td align="right"  >&nbsp;</td>
                </tr>
                <tr>
                  <td class="titR" >1.2 Total Ventas al Mercado Externo (Valor de los Estados Financieros)</td>
                  <td align="right"  ><input   type="text" name="total3" id="total3" value="<?php echo number_format($tot5); ?>" size="20"  class="inpB2 numeric" /><span id="div_total3" class="bxEr" style="display:none" >requerido</span></td>
                  <td align="left"  >&nbsp;</td>
                  <td align="right"  >&nbsp;</td>
                </tr>
                <tr>
                  <td class="titR" >1. TOTAL VENTAS (1.1 + 1.2) (Valor de los Estados Financieros) </td>
                  <td align="right"  ><span id="total4" class="labB" ><?php echo number_format($tot6); ?></span></td>
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
            
          <span class="subT">2. SE&Ntilde;ALE LOS MESES DE MAYOR INGRESO DE LA EMPRESA </span>
          <table width="100%" border="0" class="fOpt" >
            <tbody>
            <tr>
              <td><input type="checkbox" name="mes_1" id="mes_1" <?php if( $month[0] == 1 ){ print("checked=\"checked\""); } ?>  />
                
                Enero</td>
              <td><input type="checkbox" name="mes_2" id="mes_2" <?php if( $month[1] == 1 ){ print("checked=\"checked\""); } ?>  />
                Febrero</td>
              <td><input type="checkbox" name="mes_3" id="mes_3" <?php if( $month[2] == 1 ){ print("checked=\"checked\""); } ?>  />
                Marzo</td>
              <td><input type="checkbox" name="mes_4" id="mes_4" <?php if( $month[3] == 1 ){ print("checked=\"checked\""); } ?>  />
                Abril</td>
              <td><input type="checkbox" name="mes_5" id="mes_5" <?php if( $month[4] == 1 ){ print("checked=\"checked\""); } ?>  />
                Mayo</td>
              <td><input type="checkbox" name="mes_6" id="mes_6" <?php if( $month[5] == 1 ){ print("checked=\"checked\""); } ?>  />
                Junio</td>
            </tr>
            <tr>
              <td><input type="checkbox" name="mes_7" id="mes_7" <?php if( $month[6] == 1 ){ print("checked=\"checked\""); } ?>  />
                Julio</td>
              <td><input type="checkbox" name="mes_8" id="mes_8" <?php if( $month[7] == 1 ){ print("checked=\"checked\""); } ?>  />
                Agosto</td>
              <td><input type="checkbox" name="mes_9" id="mes_9" <?php if( $month[8] == 1 ){ print("checked=\"checked\""); } ?>  />
                Septiembre</td>
              <td><input type="checkbox" name="mes_10" id="mes_10" <?php if( $month[9] == 1 ){ print("checked=\"checked\""); } ?>  />
                Octubre</td>
              <td><input type="checkbox" name="mes_11" id="mes_11" <?php if( $month[10] == 1 ){ print("checked=\"checked\""); } ?>  />
                Noviembre</td>
              <td><input type="checkbox" name="mes_12" id="mes_12" <?php if( $month[11] == 1 ){ print("checked=\"checked\""); } ?>  />
                Diciembre</td>
            </tr>
          </tbody>
          </table>
          <span id="msg3" style="display:none;" class="bxEr" >Debe seleccionar por lo menos un mes</span>
            
          <span class="bxBt">
                <input type="submit" value="SIGUIENTE" id="sendData" name="continuarregistro" class="button" >
                <a href="acap6.php" class="btnS">ANTERIOR</a>                
          </span>


        </fieldset>
    </form>
    <div class="clear"></div>      

</div>
<!-- end body -->        

<?php include("footer.php") ?>
