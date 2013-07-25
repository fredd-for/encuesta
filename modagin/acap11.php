<?php session_start(); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php'); ?>
<?php include("header.php") ?>
<script type="text/javascript" src="js/acap11.js"></script>
<?php 
/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$sql = "SELECT * FROM  frm3_cap11_formacionactivos WHERE foac_regi_uid = '".$regisroUID."' ";
$db->query( $sql );
if( $db->numrows() == 0 ) {
    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    $sql2 = "SELECT * FROM adm_definiciones WHERE defi_form_uid = '".$uidFormulario."'  AND defi_modulo = 'a' AND  defi_capitulo = '11' AND defi_swactive = 'ACTIVE'";
    $db2->query( $sql2 );
    while( $aDefinicion =  $db2->next_record() ) {
        $sql = "INSERT INTO frm3_cap11_formacionactivos SET ";
        $sql .= "foac_regi_uid = '".$regisroUID."', ";
        $sql .= "foac_defi_uid = '".$aDefinicion["defi_uid"]."', ";
        $sql .= "foac_saldoneto= 0, ";
        $sql .= "foac_fabpropia= 0, "; 
        $sql .= "foac_compras= 0, "; 
        $sql .= "foac_ventaretiro= 0, "; 
        $sql .= "foac_ajustes= 0, "; 
        $sql .= "foac_activofijo= 0, "; 
        $sql .= "foac_depreciacion= 0, ";
        $sql .= "foac_otrosdescripcion= '', "; 
        $sql .= "foac_suv_uid = '".$uid_token."', ";
        $sql .= "foac_createdate = NOW(), ";
        $sql .= "foac_updatedate = NOW() ";
        $db3->query( $sql );
    }
}

$sql = " SELECT  frm3_cap11_formacionactivos.*, adm_definiciones.defi_subcapitulo as subcap "
      ." FROM  frm3_cap11_formacionactivos LEFT JOIN  adm_definiciones ON ( foac_defi_uid	 = defi_uid ) "
      ." WHERE foac_regi_uid = '".$regisroUID."' ORDER BY CAST( adm_definiciones.defi_subcapitulo AS UNSIGNED ) ASC ";
$db->query( $sql );
//echo $sql;
?>
<!-- begin body -->
<div class="content">            
    <span id="statusACAP1"></span>    
    
    <table class="dInf">
    <thead>
    <tr>
        <th>Cap&iacute;tulo 11</th>
        <th>FORMACI&Oacute;N  DE  ACTIVOS  FIJOS</th>
    </tr>
    </thead>
    <tbody>
        <tr>                       
            <td colspan="2"><?php echo OPERATOR::getDescTitles(3,'A',11,0); ?></td>
        </tr>
    </tbody>
    </table>

    <form class="formA validable" action="acap11Add.php" method="post" autocomplete="off" >
        <fieldset>         
          <table width="100%" class="fOpt" >
                <thead>
                <tr>
                  <th >DETALLE</th>
                  <th rowspan="2" align="center"  >SALDO NETO INICIAL (Bs.) (1)</th>
                  <th colspan="2" align="center"  >ADICIONES (Bs.)</th>
                  <th rowspan="2" align="center"  >VENTA O RETIROS (Bs.) (4)</th>
                  <th rowspan="2" align="center"  >ACTUALIZACI&Oacute;N Y AJUSTES (Bs.) (5)</th>
                  <th rowspan="2" align="center"  >TOTAL ACTIVO FIJO (Bs) (6)=(1)+(2)+(3)+(5)-(4)</th>
                  <th rowspan="2" align="center"  >DEPRECIACI&Oacute;N DE LA GESTI&Oacute;N (Bs) (7)</th>
                </tr>
                <tr>
                  <th >&nbsp;</th>
                  <th align="center"  >FABRICACI&Oacute;N PROPIA (2)</th>
                  <th align="center"  >COMPRAS (3)</th>
                </tr>
                </thead>
                <tbody>
                
                <?php 
                while( $aDat = $db->next_record() ) {
                ?>                
                <?php if( $aDat["subcap"] == '1' ) { ?>
                <tr>
                    <td width="30%" class="titR" >1. Edificios y construcciones (incluye instalaciones t&eacute;cnicas)</td>
                    <td width="10%" align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_saldoneto"]); ?>" name="input-11" id="input-11" size="6" class="inpB2 numeric"  /></td>
                    <td width="10%" align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_fabpropia"]); ?>" name="input-21" id="input-21" size="6" class="inpB2 numeric"  /></td>
                    <td width="10%" align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_compras"]); ?>" name="input-31" id="input-31" size="6" class="inpB2 numeric"  /></td>
                    <td width="10%" align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_ventaretiro"]); ?>" name="input-41" id="input-41" size="6" class="inpB2 numeric"  /></td>
                    <td width="10%" align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_ajustes"]); ?>" name="input-51" id="input-51" size="6" class="inpB2 numeric"  /></td>
                    <td width="10%" align="right"  ><span class="labB" id="af_1"><?php echo number_format($aDat["foac_activofijo"]); ?></span></td>
                    <td width="10%" align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_depreciacion"]); ?>" onblur="javascript:saveUPD(1); return false;" name="input-71" id="input-71" size="6" class="inpB2 numeric"  /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aDat["subcap"] == '2'  ) { ?>
                <tr>
                    <td width="40%" class="titR" >2. Maquinaria y equipo</td>
                    <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_saldoneto"]); ?>" onblur="javascript:saveUPD(1); return false;" name="input-12" id="input-12" size="6" class="inpB2 numeric"  /></td>
                    <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_fabpropia"]); ?>" name="input-22" id="input-22" size="6" class="inpB2 numeric"  /></td>
                    <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_compras"]); ?>" name="input-32" id="input-32" size="6" class="inpB2 numeric"  /></td>
                    <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_ventaretiro"]); ?>" name="input-42" id="input-42" size="6" class="inpB2 numeric"  /></td>
                    <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_ajustes"]); ?>" name="input-52" id="input-52" size="6" class="inpB2 numeric"  /></td>
                    <td align="right"  ><span class="labB" id="af_2"><?php echo number_format($aDat["foac_activofijo"]); ?></span></td>
                    <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_depreciacion"]); ?>" onblur="javascript:saveUPD(1); return false;" name="input-72" id="input-72" size="6" class="inpB2 numeric"  /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aDat["subcap"] == '3'  ) { ?>
                <tr>
                  <td class="titR" >3. Veh&iacute;culos y equipo de transporte</td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_saldoneto"]); ?>" onblur="javascript:saveUPD(1); return false;" name="input-13" id="input-13" size="6" class="inpB2 numeric"  /></td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_fabpropia"]); ?>" name="input-23" id="input-23" size="6" class="inpB2 numeric"  /></td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_compras"]); ?>" name="input-33" id="input-33" size="6" class="inpB2 numeric"  /></td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_ventaretiro"]); ?>" name="input-43" id="input-43" size="6" class="inpB2 numeric"  /></td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_ajustes"]); ?>" name="input-53" id="input-53" size="6" class="inpB2 numeric"  /></td>
                  <td align="right"  ><span class="labB" id="af_3"><?php echo number_format($aDat["foac_activofijo"]); ?></span></td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_depreciacion"]); ?>" onblur="javascript:saveUPD(1); return false;" name="input-73" id="input-73" size="6" class="inpB2 numeric"  /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aDat["subcap"] == '4'  ) { ?>
                <tr>
                  <td class="titR" >4. Muebles y enseres</td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_saldoneto"]); ?>" onblur="javascript:saveUPD(1); return false;" name="input-14" id="input-14" size="6" class="inpB2 numeric"  /></td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_fabpropia"]); ?>" name="input-24" id="input-24" size="6" class="inpB2 numeric"  /></td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_compras"]); ?>" name="input-34" id="input-34" size="6" class="inpB2 numeric"  /></td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_ventaretiro"]); ?>" name="input-44" id="input-44" size="6" class="inpB2 numeric"  /></td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_ajustes"]); ?>" name="input-54" id="input-54" size="6" class="inpB2 numeric"  /></td>
                  <td align="right"  ><span class="labB" id="af_4"><?php echo number_format($aDat["foac_activofijo"]); ?></span></td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_depreciacion"]); ?>" onblur="javascript:saveUPD(1); return false;" name="input-74" id="input-74" size="6" class="inpB2 numeric"  /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aDat["subcap"] == '5'  ) { ?>
                <tr>
                  <td class="titR" >5. Herramientas</td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_saldoneto"]); ?>" onblur="javascript:saveUPD(1); return false;" name="input-15" id="input-15" size="6" class="inpB2 numeric"  /></td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_fabpropia"]); ?>" name="input-25" id="input-25" size="6" class="inpB2 numeric"  /></td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_compras"]); ?>" name="input-35" id="input-35" size="6" class="inpB2 numeric"  /></td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_ventaretiro"]); ?>" name="input-45" id="input-45" size="6" class="inpB2 numeric"  /></td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_ajustes"]); ?>" name="input-55" id="input-55" size="6" class="inpB2 numeric"  /></td>
                  <td align="right"  ><span class="labB" id="af_5"><?php echo number_format($aDat["foac_activofijo"]); ?></span></td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_depreciacion"]); ?>" onblur="javascript:saveUPD(1); return false;" name="input-75" id="input-75" size="6" class="inpB2 numeric"  /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aDat["subcap"] == '6'  ) { ?>
                <tr>
                  <td class="titR" >6. Equipo de computaci&oacute;n</td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_saldoneto"]); ?>" onblur="javascript:saveUPD(1); return false;" name="input-16" id="input-16" size="6" class="inpB2 numeric"  /></td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_fabpropia"]); ?>" name="input-26" id="input-26" size="6" class="inpB2 numeric"  /></td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_compras"]); ?>" name="input-36" id="input-36" size="6" class="inpB2 numeric"  /></td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_ventaretiro"]); ?>" name="input-46" id="input-46" size="6" class="inpB2 numeric"  /></td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_ajustes"]); ?>" name="input-56" id="input-56" size="6" class="inpB2 numeric"  /></td>
                  <td align="right"  ><span class="labB" id="af_6"><?php echo number_format($aDat["foac_activofijo"]); ?></span></td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_depreciacion"]); ?>" onblur="javascript:saveUPD(1); return false;" name="input-76" id="input-76" size="6" class="inpB2 numeric"  /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aDat["subcap"] == '7'  ) { ?>
                <tr>
                  <td class="titR" >7. Terrenos</td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_saldoneto"]); ?>" onblur="javascript:saveUPD(1); return false;" name="input-17" id="input-17" size="6" class="inpB2 numeric"  /></td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_fabpropia"]); ?>" name="input-27" id="input-27" size="6" class="inpB2 numeric"  /></td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_compras"]); ?>" name="input-37" id="input-37" size="6" class="inpB2 numeric"  /></td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_ventaretiro"]); ?>" name="input-47" id="input-47" size="6" class="inpB2 numeric"  /></td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_ajustes"]); ?>" name="input-57" id="input-57" size="6" class="inpB2 numeric"  /></td>
                  <td align="right"  ><span class="labB" id="af_7"><?php echo number_format($aDat["foac_activofijo"]); ?></span></td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_depreciacion"]); ?>" onblur="javascript:saveUPD(1); return false;" name="input-77" id="input-77" size="6" class="inpB2 numeric"  /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aDat["subcap"] == '8'  ) { ?>
                <tr>
                  <td class="titR" >8. Otros activos fijos</td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_saldoneto"]); ?>" onblur="javascript:saveUPD(1); return false;" name="input-18" id="input-18" size="6" class="inpB2 numeric"  /></td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_fabpropia"]); ?>" name="input-28" id="input-28" size="6" class="inpB2 numeric"  /></td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_compras"]); ?>" name="input-38" id="input-38" size="6" class="inpB2 numeric"  /></td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_ventaretiro"]); ?>" name="input-48" id="input-48" size="6" class="inpB2 numeric"  /></td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_ajustes"]); ?>" name="input-58" id="input-58" size="6" class="inpB2 numeric"  /></td>
                  <td align="right"  ><span class="labB" id="af_8"><?php echo number_format($aDat["foac_activofijo"]); ?></span></td>
                  <td align="right"  ><input type="text" value="<?php echo number_format($aDat["foac_depreciacion"]); ?>" onblur="javascript:saveUPD(1); return false;" name="input-78" id="input-78" size="6" class="inpB2 numeric"  /></td>
                </tr>
                <?php 
                $showrow = "style=\"display: none;\"";
                if( !empty($aDat["foac_otrosdescripcion"]) ) {
                    $showrow = "style=\"display: table-row;\"";
                }                
                ?>
                <tr id="otroactivo" <?php echo $showrow; ?> >
                  <td colspan="8" class="titR" >
                  <input type="text" value="<?php echo $aDat["foac_otrosdescripcion"]; ?>" name="input-otro" id="input-otro" size="40" class="inpC2"  />
                  </td>                  
                </tr>
                <?php } ?>
                
                <?php if( $aDat["subcap"] == '9'  ) { ?>
                <tr>
                  <td class="titR" >9. TOTAL</td>
                  <td align="right"  ><span class="labB" id="tot_1"><?php echo number_format($aDat["foac_saldoneto"]); ?></span></td>
                  <td align="right"  ><span class="labB" id="tot_2"><?php echo number_format($aDat["foac_fabpropia"]); ?></span></td>
                  <td align="right"  ><span class="labB" id="tot_3"><?php echo number_format($aDat["foac_compras"]); ?></span></td>
                  <td align="right"  ><span class="labB" id="tot_4"><?php echo number_format($aDat["foac_ventaretiro"]); ?></span></td>
                  <td align="right"  ><span class="labB" id="tot_5"><?php echo number_format($aDat["foac_ajustes"]); ?></span></td>
                  <td align="right"  ><span class="labB" id="tot_6"><?php echo number_format($aDat["foac_activofijo"]); ?></span></td>
                  <td align="right"  ><span class="labB" id="tot_7"><?php echo number_format($aDat["foac_depreciacion"]); ?></span></td>
                </tr>
                <?php } ?>
                
                <?php } ?>
                </tbody>
            </table>
          <p>
          <span id="msg" style="display:none;" class="bxEr">Debe llenar necesariamente alguno de los datos solicitados</span>
          <span id="msg2" style="display:none;" class="bxEr">Debe registrar el detalle para otros activos fijos</span>
          </p>
                      
        <span class="bxBt">
        <input type="submit" value="SIGUIENTE" id="sendData" name="continuarregistro" class="button">
        <a href="acap10.php" class="btnS">ANTERIOR</a>                
        </span>
          
        </fieldset>
    </form>
    <div class="clear"></div>      

</div>
<!-- end body -->        


<?php include("footer.php") ?>
