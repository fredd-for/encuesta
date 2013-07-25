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


$sql = "SELECT * FROM frm1_cap6_comprareventa WHERE core_regi_uid = '".$regisroUID."' ";

$db->query( $sql );
if( $db->numrows() == 0 ) {

    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    $sql2 = "SELECT * FROM adm_definiciones WHERE defi_form_uid = '".$uidFormulario."' AND defi_modulo = 'a' AND  defi_capitulo = '6' ";       
    $db2->query( $sql2 );
    while( $aDefinicion =  $db2->next_record() ) {        
        $sql = "INSERT INTO frm1_cap6_comprareventa SET ";
        $sql .= "core_regi_uid = '".$regisroUID."', ";
        $sql .= "core_defi_uid = '".$aDefinicion["defi_uid"]."', ";
        $sql .= "core_valor = 0, ";         
        $sql .= "core_suv_uid = '".$uid_token."', "; 
        $sql .= "core_createdate = NOW(), "; 
        $sql .= "core_updatedate = NOW() ";                          	 	
        $db3->query( $sql );                
    }
}
?>
<!-- begin body -->
<div class="content">
        <span id="statusACAP1"></span>
    <table class="dInf">
    <thead>
    <tr>
        <th>Cap&iacute;tulo 6</th>
        <th>COMPRA DE MERCADER&Iacute;AS PARA REVENTA (Exclusivo para la actividad de comercio)</th>
    </tr>
    </thead>
    <tbody>
        <tr>                        
            <td colspan="2"><?php echo OPERATOR::getDescTitles(1,'A',6,0); ?></td>
        </tr>
    </tbody>
    </table>     
    <form class="formA validable" action="acap6Add.php" method="post" autocomplete="off" >
        <fieldset>
          
          <table width="100%" class="fOpt" >
                <thead>
                <tr>
                    <th align="center">DETALLE</th>
                    <th width="20%" align="center" >VALOR (Bs.)</th>
                    <th width="20%" align="center" >SECTOR O ACTIVIDAD DE LOS PROVEEDORES</th>
                    <th width="20%" align="center" >PORCENTAJE (%)</th>                    
                </tr>
                </thead>
                <tbody>
                <?php
                
                //Tipo de personal
                // defi_vinieta a,b,c,d
                
                $sql = " SELECT core_defi_uid, core_valor "
                      ." FROM frm1_cap6_comprareventa "
                      ." WHERE core_regi_uid = '".$regisroUID."' AND core_defi_uid IN (18,23,28) ";                
                $db->query( $sql );
                
                //echo $sql;
                $tot1 = 0;                
                $tot2 = 0;
                $tot3 = 0;
                while( $aMercaderia = $db->next_record() ) { 
                    if( $aMercaderia["core_defi_uid"]==18 ) { $tot1 = $aMercaderia["core_valor"]; } 
                    if( $aMercaderia["core_defi_uid"]==23 ) { $tot2 = $aMercaderia["core_valor"]; } 
                    if( $aMercaderia["core_defi_uid"]==28 ) { $tot3 = $aMercaderia["core_valor"]; } 
                }
                
                $sql = " SELECT frm1_cap6_comprareventa.*, adm_definiciones.defi_vinieta as vinieta, adm_definiciones.defi_indent	 as indent "
                      ." FROM frm1_cap6_comprareventa LEFT JOIN  adm_definiciones ON ( core_defi_uid	 = defi_uid ) "
                      ." WHERE core_regi_uid = '".$regisroUID."' AND core_defi_uid IN (19,20,21,22, 24,25,26,27) ORDER BY adm_definiciones.defi_indent ASC,  adm_definiciones.defi_vinieta ASC ";
                $db->query( $sql );

                //echo $sql;
                
                $percent1 = 0;
                $percent2 = 0;
                ?>
                <?php  
                    while( $aMercaderia = $db->next_record() ) {   
                        $sw1 = ""; if( $tot1 > 0 ) { $sw1 = "si"; }
                        
                        /*
                        if( $aMercaderia["indent"] == '1' && $aMercaderia["core_valor"] > 0 ) {
                            $percent1 = "si";
                        }
                        
                        if( $aMercaderia["indent"] == '2' && $aMercaderia["core_valor"] > 0 ) {
                            $percent2 = "si";
                        }
                         * 
                         */
                        
                ?>
                
                <?php if( $aMercaderia["indent"] == '1' && $aMercaderia["vinieta"] == "a" ) { ?>
                <tr>
                    <td width="40%" rowspan="5" class="titR" >1.  Compra de mercader&iacute;a de fabricaci&oacute;n nacional (Valor aproximado)</td>
                    <td rowspan="5" align="right"  >
                    <input type="text" name="input-1" id="input-1" value="<?php echo number_format($tot1); ?>" size="20" class="inpB2 numeric" />                                                            
                    </td>
                    <td align="left" class="titR" >a)  Agricultura, ganader&iacute;a, caza, silvicultura y pesca</td>
                    <td align="center"  >
                    <input type="text" name="input-21" id="input-21" maxlength="3" value="<?php echo $aMercaderia["core_valor"]; ?>" size="20" class="inpB2 integer numeric" />
                                                           
                    </td>
                </tr>
                <?php 
                $percent1 = $percent1 + $aMercaderia["core_valor"];
                } ?>
                
                <?php if( $aMercaderia["indent"] == '1' && $aMercaderia["vinieta"] == "b" ) { ?>
                <tr>
                  <td align="left" class="titR"  >b)  Industria manufacturera</td>
                  <td align="center"  >
                  <input type="text" name="input-22" id="input-22" maxlength="3" value="<?php echo $aMercaderia["core_valor"]; ?>" size="20" class="inpB2 integer numeric" />
                  <span id="div_input-22" class="bxEr" style="display:none" >requerido</span>
                  <span id="div_input-22_2" class="bxEr" style="display:none" >inválido</span>
                  </td>
                </tr>
                <?php 
                $percent1 = $percent1 + $aMercaderia["core_valor"];
                } ?>
                
                <?php if( $aMercaderia["indent"] == '1' && $aMercaderia["vinieta"] == "c" ) { ?>
                <tr>
                  <td align="left" class="titR"  >c)  Comercio por mayor</td>
                  <td align="center"  >
                  <input type="text" name="input-23"  id="input-23" maxlength="3" value="<?php echo $aMercaderia["core_valor"]; ?>" size="20" class="inpB2 integer numeric" />
                  <span id="div_input-23" class="bxEr" style="display:none" >requerido</span>
                  <span id="div_input-23_2" class="bxEr" style="display:none" >inválido</span>
                  </td>
                </tr>
                <?php 
                $percent1 = $percent1 + $aMercaderia["core_valor"];
                } ?>
                
                <?php if( $aMercaderia["indent"] == '1' && $aMercaderia["vinieta"] == "d" ) { ?>
                <tr>
                  <td align="left" class="titR"  >d)  Otros</td>
                  <td align="center"  >
                  <input type="text" name="input-24" onblur="javascript:saveUPD(1); return false;" id="input-24" maxlength="3" value="<?php echo $aMercaderia["core_valor"]; ?>" size="20" class="inpB2 integer numeric" />
                  <span id="div_input-24" class="bxEr" style="display:none" >requerido</span>
                  <span id="div_input-24_2" class="bxEr" style="display:none" >inválido</span>
                  </td>
                </tr>
                <tr>
                  <td align="left" class="titR"  >Total %</td>
                  <td align="center"  >
                  <?php 
                  $percent1 = $percent1 + $aMercaderia["core_valor"];
                  ?>
                  <label class="labB" id="percent1"><?php echo $percent1 ?></label>
                  </td>
                </tr>
                <?php } ?>
        
                <?php if( $aMercaderia["indent"] == '2' && $aMercaderia["vinieta"] == "a" ) { ?>
                <tr>
                    <td width="40%" rowspan="5" class="titR" >2.  Compra de mercader&iacute;a de fabricaci&oacute;n <br />
                    extranjera (Valor aproximado)</td>
                    <td rowspan="5" align="right"  >
                    <input type="text" name="input-2" id="input-2" value="<?php echo number_format($tot2); ?>" size="20" class="inpB2 numeric ">
                    <span id="div_input-2" class="bxEr" style="display:none" >requerido</span>
                    <span id="div_input-2_2" class="bxEr" style="display:none" >inválido</span>
                    </td>
                    <td align="left" class="titR"  >a)  Agricultura, ganader&iacute;a, caza, silvicultura y pesca</td>
                    <td align="center"  >
                    <input type="text" name="input-25" id="input-25" maxlength="3" value="<?php echo $aMercaderia["core_valor"]; ?>" size="20" class="inpB2 integer numeric" />
                    
                    <!--
                    <input type="hidden" name="porcentaje2" id="porcentaje2" value="" class="required" >
                    <span id="div_porcentaje2" class="bxEr" style="display:none" >porcentaje requerido</span>
                    -->
                    </td>
                </tr>
                <?php 
                $percent2 = $percent2 + $aMercaderia["core_valor"];
                } ?>
                
                <?php if( $aMercaderia["indent"] == '2' && $aMercaderia["vinieta"] == "b" ) { ?>
                <tr>
                  <td align="left" class="titR"  >b)  Industria manufacturera</td>
                  <td align="center"  >
                  <input type="text" name="input-26" id="input-26" maxlength="3" value="<?php echo $aMercaderia["core_valor"]; ?>" size="20" class="inpB2 integer numeric" />
                  <span id="div_input-26" class="bxEr" style="display:none" >requerido</span>
                  <span id="div_input-26_2" class="bxEr" style="display:none" >inválido</span>
                  </td>
                </tr>
                <?php 
                $percent2 = $percent2 + $aMercaderia["core_valor"];
                } ?>
                
                <?php if( $aMercaderia["indent"] == '2' && $aMercaderia["vinieta"] == "c" ) { ?>
                <tr>
                  <td align="left" class="titR" >c)  Comercio por mayor</td>
                  <td align="center"  >
                  <input type="text" name="input-27" id="input-27" maxlength="3" value="<?php echo $aMercaderia["core_valor"]; ?>" size="20" class="inpB2 integer numeric" />
                  <span id="div_input-27" class="bxEr" style="display:none" >requerido</span>
                  <span id="div_input-27_2" class="bxEr" style="display:none" >inválido</span>
                  </td>
                </tr>
                <?php 
                $percent2 = $percent2 + $aMercaderia["core_valor"];
                } ?>
                
                <?php if( $aMercaderia["indent"] == '2' && $aMercaderia["vinieta"] == "d" ) { ?>
                <tr>
                  <td align="left" class="titR" >d) Otros</td>
                  <td align="center"  >
                  <input type="text" name="input-28" onblur="javascript:saveUPD(2); return false;" id="input-28" maxlength="3" value="<?php echo $aMercaderia["core_valor"]; ?>" size="20" class="inpB2 integer numeric" />
                  <span id="div_input-28" class="bxEr" style="display:none" >requerido</span>
                  <span id="div_input-28_2" class="bxEr" style="display:none" >inválido</span>
                  </td>
                </tr>
                <tr>
                  <td align="left" class="titR" >Total %</td>
                  <td align="center"  >
                      <?php $percent2 = $percent2 + $aMercaderia["core_valor"]; ?>
                      <label class="labB" id="percent2"><?php echo $percent2; ?></label>
                  </td>
                </tr>
                <?php } ?>
                <?php } //end while ?>
                
                
                <?php 
                if( $percent11 > 0 ) {
                
                echo "<script> $(\"#porcentaje1\").val(\"si\");</script>";
                
                }                
                ?>
                
                <?php 
                if( $percent21 > 0 ) {
                echo "<script> $(\"#porcentaje2\").val(\"si\");</script>";
                }                
                ?>
                <tr>
                  <td class="titR" >3.  TOTAL DE MERCADER&Iacute;AS COMPRADAS </td>
                  <td align="right"  >                                    
                  <label class="labB" id="total" ><?php echo number_format($tot3); ?></label>
                  </td>
                  <td align="left"  >&nbsp;</td>
                  <td align="right"  >&nbsp;</td>
                </tr>
                </tbody>
            </table>
          <p>
              <span id="msg" style="display: none;" class="bxEr" >Introducir el porcentaje para el valor especificado que debe sumar 100%</span>
              <span id="msg2" style="display:none;" class="bxEr" >Debe registrar movimiento en compras</span>
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
