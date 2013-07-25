<?php session_start(); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
?>
<?php include_once('../verifyLogin.php'); ?>
<?php include("header.php") ?>
<script type="text/javascript" src="js/acap9.js"></script>
<?php
/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$sql = "SELECT * FROM frm1_cap9_formacionactivosfijos WHERE foaf_regi_uid = '".$regisroUID."' ";
$db->query( $sql );

if( $db->numrows() == 0 ) {

    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    $sql2 = "SELECT * FROM adm_definiciones WHERE defi_form_uid = '".$uidFormulario."' AND defi_modulo = 'a' AND  defi_capitulo = '9' ";       
    $db2->query( $sql2 );
    while( $aDefinicion =  $db2->next_record() ) {
        $sql = "INSERT INTO frm1_cap9_formacionactivosfijos SET ";
        $sql .= "foaf_regi_uid = '".$regisroUID."', ";
        $sql .= "foaf_defi_uid = '".$aDefinicion["defi_uid"]."', ";
        $sql .= "foaf_valor = 0, ";  
        $sql .= "foaf_description = '', ";          
        $sql .= "foaf_suv_uid = '".$uid_token."', "; 
        $sql .= "foaf_createdate = NOW(), "; 
        $sql .= "foaf_updatedate = NOW() ";                          	 	
        $db3->query( $sql );               
    }        
}
?>

<!-- begin body -->
<div class="content"> <span id="statusACAP1"></span>
    <table class="dInf">
    <thead>
    <tr>
        <th>Cap&iacute;tulo 9</th>
        <th>FORMACI&Oacute;N  DE  ACTIVOS  FIJOS</th>
    </tr>
    </thead>   
    </table>

    <form class="formA validable" action="acap9Add.php" method="post" autocomplete="off" >
        <fieldset>
          <table width="100%" class="fOpt" >
                <thead>
                <tr>
                    <th align="center">TIPO DE ACTIVO FIJO  (DETALLE)</th>
                    <th align="center" >VALOR TOTAL (Bs/Anual)</th>
                </tr>
                </thead>
                <tbody>
                <?php                                                
                $sql = " SELECT frm1_cap9_formacionactivosfijos.*, adm_definiciones.defi_vinieta as vinieta, adm_definiciones.defi_indent as indent "
                      ." FROM frm1_cap9_formacionactivosfijos LEFT JOIN  adm_definiciones ON ( foaf_defi_uid = defi_uid ) "
                      ." WHERE foaf_regi_uid = '".$regisroUID."' "
                      ." ORDER BY adm_definiciones.defi_indent ASC,  adm_definiciones.defi_vinieta ASC ";
                $db->query( $sql );
                //echo $sql;                             
                ?>
                <?php  while( $aActivos = $db->next_record() ) {  ?>
                <?php if( $aActivos["vinieta"] == "1" ) { ?>
                <tr>
                    <td width="70%" class="titR" >1.  Edificios y construcciones (incluye instalaciones t&eacute;cnicas)</td>
                    <td width="30%" align="right"  >
                    <input type="text" name="input-11" onblur="javascript:saveUPD(1); return false;" id="input-11" value="<?php echo number_format($aActivos["foaf_valor"]); ?>" size="20" class="inpB2 numeric" />
                    <span id="div_input-11" class="bxEr" style="display:none" >requerido</span>
                    </td>
                </tr>
                <?php } ?>
                
                <?php if( $aActivos["vinieta"] == "2" ) { ?>
                <tr>
                    <td width="70%" class="titR" >2.  Maquinaria y equipo</td>
                    <td align="right"  >
                    <input type="text" name="input-12" onblur="javascript:saveUPD(1); return false;" id="input-12" value="<?php echo number_format($aActivos["foaf_valor"]); ?>" size="20" class="inpB2 numeric" />
                    <span id="div_input-12" class="bxEr" style="display:none" >requerido</span>
                    </td>
                </tr>
                <?php } ?>
                
                <?php if( $aActivos["vinieta"] == "3" ) { ?>
                <tr>
                  <td class="titR" >3.  Veh&iacute;culos y equipo de transporte</td>
                  <td align="right"  >
                      <input type="text" name="input-13" onblur="javascript:saveUPD(1); return false;" id="input-13" value="<?php echo number_format($aActivos["foaf_valor"]); ?>" size="20" class="inpB2 numeric" /><span id="div_input-13" class="bxEr" style="display:none" >requerido</span>
                  </td>
                </tr>
                <?php } ?>
                
                <?php if( $aActivos["vinieta"] == "4" ) { ?>
                <tr>
                  <td class="titR" >4.  Muebles y enseres</td>
                  <td align="right"  >
                  <input type="text" name="input-14" onblur="javascript:saveUPD(1); return false;" id="input-14" value="<?php echo number_format($aActivos["foaf_valor"]); ?>" size="20" class="inpB2 numeric" />
                  <span id="div_input-14" class="bxEr" style="display:none" >requerido</span>
                  </td>
                </tr>
                <?php } ?>
                
                <?php if( $aActivos["vinieta"] == "5" ) { ?>
                <tr>
                  <td class="titR" >5.  Herramientas</td>
                  <td align="right"  >
                  <input type="text" name="input-15" onblur="javascript:saveUPD(1); return false;" id="input-15" value="<?php echo number_format($aActivos["foaf_valor"]); ?>" size="20" class="inpB2 numeric" />
                  <span id="div_input-15" class="bxEr" style="display:none" >requerido</span>
                  </td>
                </tr>
                <?php } ?>
                
                <?php if( $aActivos["vinieta"] == "6" ) { ?>
                <tr>
                  <td class="titR" >6.  Equipo de computaci&oacute;n</td>
                  <td align="right"  ><input type="text" onblur="javascript:saveUPD(1); return false;" name="input-16" id="input-16" value="<?php echo number_format($aActivos["foaf_valor"]); ?>" size="20" class="inpB2 numeric" /><span id="div_input-16" class="bxEr" style="display:none" >requerido</span></td>
                </tr>
                <?php } ?>
                
                <?php if( $aActivos["vinieta"] == "7" ) { ?>
                <tr>
                  <td class="titR" >7.  Terrenos</td>
                  <td align="right"  ><input type="text" onblur="javascript:saveUPD(1); return false;" name="input-17" id="input-17" value="<?php echo number_format($aActivos["foaf_valor"]); ?>" size="20" class="inpB2 numeric" /><span id="div_input-17" class="bxEr" style="display:none" >requerido</span></td>
                </tr>
                <?php } ?>
                
                <?php if( $aActivos["vinieta"] == "8" ) { ?>
                <tr>
                  <td class="titR" >8.  Otros activos fijos (especificar)</td>
                  <td align="right"  ><input type="text" onblur="javascript:saveUPD(1); return false;" name="input-18" id="input-18" value="<?php echo number_format($aActivos["foaf_valor"]); ?>" size="20" class="inpB2 numeric" /><span id="div_input-18" class="bxEr" style="display:none" >requerido</span></td>
                </tr>
                
                <?php 
                $mostrar = "style=\"display: none\"";
                if( !empty($aActivos["foaf_valor"]) && $aActivos["foaf_valor"] > 0 ) { $mostrar = "style=\"display: table-row\""; } 
                ?>
                <tr <?php echo $mostrar ?> id="rowother" >
                  <td class="titR" >
                  <input type="text" name="inputlit" onblur="javascript:saveUPD(1); return false;" id="inputlit" value="<?php echo $aActivos["foaf_description"]; ?>" size="60" class="inpC" />
                  <span id="div_inputlit" class="bxEr" style="display:none" >requerido</span>
                  </td>
                  <td align="right"  >
                      &nbsp;
                  </td>
                </tr>
                <?php } ?>
                                               
                <?php if( $aActivos["vinieta"] == "9" ) { ?>
                <tr>
                  <td class="titR" >9. TOTAL</td>
                  <td align="right"><span id="totalactivo" class="labB" ><?php echo number_format($aActivos["foaf_valor"]); ?></span></td>
                </tr>
                <?php } ?>
                <?php } ?>
                </tbody>
            </table>
          
            <span id="msg" style="display: none" class="bxEr" >Debe introducir el detalle para el item Otros activos fijos</span>
            <span id="msg2" style="display: none" class="bxEr" >Debe introducir el valor para el tipo de activo fijo</span>
                                              
           <span class="bxBt">
                <input type="submit" value="SIGUIENTE" id="sendData" name="continuarregistro" class="button" >
                <a href="acap8.php" class="btnS">ANTERIOR</a>                
           </span>

        </fieldset>
    </form>
    <div class="clear"></div>      

</div>
<!-- end body -->               

<?php include("footer.php") ?>
