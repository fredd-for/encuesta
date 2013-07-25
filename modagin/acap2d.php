<?php session_start(); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php'); ?>
<?php include("header.php") ?>
<script type="text/javascript" src="js/acap2d.js"></script>
<?php 
/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

//crear registros para sueldos
$sql = "SELECT * FROM  frm3_acap2_personal_jornal WHERE pejo_regi_uid = '".$regisroUID."' ";
$db->query( $sql );
if( $db->numrows() == 0 ) {
    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    $sql2 = "SELECT * FROM adm_definiciones WHERE defi_form_uid = '".$uidFormulario."'  AND defi_modulo = 'a' AND  defi_capitulo = '2' AND defi_subcapitulo = '4' AND defi_swactive = 'ACTIVE'";
    $db2->query( $sql2 );
    while( $aDefinicion =  $db2->next_record() ) {        
        $sql = "INSERT INTO  frm3_acap2_personal_jornal SET ";
        $sql .= "pejo_regi_uid  = '".$regisroUID."', ";
        $sql .= "pejo_defi_uid 	 = '".$aDefinicion["defi_uid"]."', ";
        $sql .= "pejo_mes_menoractividad = 0, ";
        $sql .= "pejo_menoract_hombres = 0, ";
        $sql .= "pejo_menoract_mujeres = 0, ";
        $sql .= "pejo_menoract_valor = 0, ";
        $sql .= "pejo_mes_mayoractividad = 0, ";
        $sql .= "pejo_mayoract_hombres = 0, ";
        $sql .= "pejo_mayoract_mujeres = 0, ";
        $sql .= "pejo_mayoract_valor = 0, ";       
        $sql .= "pejo_suv_uid = '".$uid_token."', "; 
        $sql .= "pejo_createdate = NOW(), "; 
        $sql .= "pejo_updatedate = NOW() ";                          	 	
        $db3->query( $sql );
    }
}
$sql = " SELECT  frm3_acap2_personal_jornal.*, adm_definiciones.defi_vinieta as vinieta "
      ." FROM  frm3_acap2_personal_jornal LEFT JOIN  adm_definiciones ON ( pejo_defi_uid	 = defi_uid ) "
      ." WHERE pejo_regi_uid = '".$regisroUID."' ORDER BY CAST( adm_definiciones.defi_vinieta AS UNSIGNED) ASC ";
$db->query( $sql );
//echo $sql;
?>

<style type="text/css">
    table.fOpt td { padding: 10px 1px !important;}
</style>
<!-- begin body -->
<div class="content">
    <span id="statusACAP1"></span>    
    
    <table class="dInf">
    <thead>
    <tr>
        <th>Cap&iacute;tulo 2</th>
        <th>PERSONAL OCUPADO</th>
    </tr>
    </thead>
    <tbody>
        <tr>                        
            <td colspan="2"><?php echo OPERATOR::getDescTitles(3,'A',2,3); ?></td>
        </tr>
    </tbody>
    </table>        
    
    <form class="formA validable" action="acap2dAdd.php" method="post" autocomplete="off" >
      <fieldset>
            <span class="subT">2.4 Personal por jornal</span>
            <table width="100%" class="fOpt" >
                <thead>
                <tr>
                  <th align="center">&nbsp;</th>
                  <th colspan="3" align="center">mes de menor actividad</th>
                  <th colspan="3" align="center">mes de mayor actividad</th>
                </tr>
                </thead>
                                                                                                
                <tbody>
                <?php 
                while( $aDat = $db->next_record() ) {
                ?>
                
                <?php if( $aDat["vinieta"] == '0' ) { ?>
                <tr>
                  <td rowspan="2" align="center" class="titR">&nbsp;</td>
                  <td colspan="3" align="center" >Mes
                    <select name="mes_menor" id="mes_menor">
                      <option value="" >Seleccionar</option>
                      <option value="1" <?php if( $aDat["pejo_mes_menoractividad"] == 1 ) { echo "selected=\"selected\""; } ?>  >Enero</option>
                      <option value="2" <?php if( $aDat["pejo_mes_menoractividad"] == 2 ) { echo "selected=\"selected\""; } ?> >Febrero</option>
                      <option value="3" <?php if( $aDat["pejo_mes_menoractividad"] == 3 ) { echo "selected=\"selected\""; } ?> >Marzo</option>
                      <option value="4" <?php if( $aDat["pejo_mes_menoractividad"] == 4 ) { echo "selected=\"selected\""; } ?> >Abril</option>
                      <option value="5" <?php if( $aDat["pejo_mes_menoractividad"] == 5 ) { echo "selected=\"selected\""; } ?> >Mayo</option>
                      <option value="6" <?php if( $aDat["pejo_mes_menoractividad"] == 6 ) { echo "selected=\"selected\""; } ?> >Junio</option>
                      <option value="7" <?php if( $aDat["pejo_mes_menoractividad"] == 7 ) { echo "selected=\"selected\""; } ?> >Julio</option>
                      <option value="8" <?php if( $aDat["pejo_mes_menoractividad"] == 8 ) { echo "selected=\"selected\""; } ?> >Agosto</option>
                      <option value="9" <?php if( $aDat["pejo_mes_menoractividad"] == 9 ) { echo "selected=\"selected\""; } ?> >Septiembre</option>
                      <option value="10" <?php if( $aDat["pejo_mes_menoractividad"] == 10 ) { echo "selected=\"selected\""; } ?> >Octubre</option>
                      <option value="11" <?php if( $aDat["pejo_mes_menoractividad"] == 11 ) { echo "selected=\"selected\""; } ?> >Noviembre</option>
                      <option value="12" <?php if( $aDat["pejo_mes_menoractividad"] == 12 ) { echo "selected=\"selected\""; } ?> >Diciembre</option>
                    </select>
                  </td>
                  <td colspan="3" align="center">Mes
                    <select name="mes_mayor" id="mes_mayor">
                      <option value="" >Seleccionar</option>
                      <option value="1" <?php if( $aDat["pejo_mes_mayoractividad"] == 1 ) { echo "selected=\"selected\""; } ?> >Enero</option>
                      <option value="2" <?php if( $aDat["pejo_mes_mayoractividad"] == 2 ) { echo "selected=\"selected\""; } ?> >Febrero</option>
                      <option value="3" <?php if( $aDat["pejo_mes_mayoractividad"] == 3 ) { echo "selected=\"selected\""; } ?> >Marzo</option>
                      <option value="4" <?php if( $aDat["pejo_mes_mayoractividad"] == 4 ) { echo "selected=\"selected\""; } ?> >Abril</option>
                      <option value="5" <?php if( $aDat["pejo_mes_mayoractividad"] == 5 ) { echo "selected=\"selected\""; } ?> >Mayo</option>
                      <option value="6" <?php if( $aDat["pejo_mes_mayoractividad"] == 6 ) { echo "selected=\"selected\""; } ?> >Junio</option>
                      <option value="7" <?php if( $aDat["pejo_mes_mayoractividad"] == 7 ) { echo "selected=\"selected\""; } ?> >Julio</option>
                      <option value="8" <?php if( $aDat["pejo_mes_mayoractividad"] == 8 ) { echo "selected=\"selected\""; } ?> >Agosto</option>
                      <option value="9" <?php if( $aDat["pejo_mes_mayoractividad"] == 9 ) { echo "selected=\"selected\""; } ?> >Septiembre</option>
                      <option value="10" <?php if( $aDat["pejo_mes_mayoractividad"] == 10 ) { echo "selected=\"selected\""; } ?> >Octubre</option>
                      <option value="11" <?php if( $aDat["pejo_mes_mayoractividad"] == 11 ) { echo "selected=\"selected\""; } ?> >Noviembre</option>
                      <option value="12" <?php if( $aDat["pejo_mes_mayoractividad"] == 12 ) { echo "selected=\"selected\""; } ?> >Diciembre</option>
                    </select>
                  </td>
                  </tr>
                <tr>
                    <td align="center">Valor (Bs/Anual)</td>
                    <td align="center">Mujeres</td>
                    <td align="center">Valor de Jornales Pagados</td>
                    <td align="center">Hombres</td>
                    <td align="center">Mujeres</td>
                    <td align="center">Valor de Jornales Pagados</td>                    
                </tr>
                <tr>
                    <td width="28%" class="titR" >1. Contratos de trabajo por jornal</td>
                    <td width="12%" align="right" ><span class="labB" id="tot1" ><?php echo number_format($aDat["pejo_menoract_hombres"]) ?></span></td>
                    <td width="12%" align="right" ><span class="labB" id="tot2" ><?php echo number_format($aDat["pejo_menoract_mujeres"]) ?></span></td>
                    <td width="12%" align="right" ><span class="labB" id="tot3" ><?php echo number_format($aDat["pejo_menoract_valor"]) ?></span></td>
                    <td width="12%" align="right" ><span class="labB" id="tot4" ><?php echo number_format($aDat["pejo_mayoract_hombres"]) ?></span></td>
                    <td width="12%" align="right" ><span class="labB" id="tot5" ><?php echo number_format($aDat["pejo_mayoract_mujeres"]) ?></span></td>
                    <td width="12%" align="right" ><span class="labB" id="tot6" ><?php echo number_format($aDat["pejo_mayoract_valor"]) ?></span></td>
                  </tr>                
                <?php } ?>
                
                <?php if( $aDat["vinieta"] == '1'  ) { ?>
                <tr>
                  <td class="titR" >1.1 Jornaleros en trabajo agr&iacute;cola y pecuario</td>
                  <td align="right"><input type="text" name="A1" id="A1" value="<?php echo number_format($aDat["pejo_menoract_hombres"]) ?>" size="8" maxlength="15" class="inpB2 numeric" /></td>
                  <td align="right"><input type="text" name="B1" id="B1" value="<?php echo number_format($aDat["pejo_menoract_mujeres"]) ?>" size="8" maxlength="15" class="inpB2 numeric" /></td>
                  <td align="right"><input type="text" name="C1" id="C1" value="<?php echo number_format($aDat["pejo_menoract_valor"]) ?>" size="8" maxlength="15" class="inpB2 numeric" /></td>
                  <td align="right"><input type="text" name="D1" id="D1" value="<?php echo number_format($aDat["pejo_mayoract_hombres"]) ?>" size="8" maxlength="15" class="inpB2 numeric" /></td>
                  <td align="right"><input type="text" name="E1" id="E1" value="<?php echo number_format($aDat["pejo_mayoract_mujeres"]) ?>" size="8" maxlength="15" class="inpB2 numeric" /></td>
                  <td align="right"><input type="text" name="F1" id="F1" value="<?php echo number_format($aDat["pejo_mayoract_valor"]) ?>" size="8" maxlength="15" class="inpB2 numeric" onblur="saveUPD(1);" /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aDat["vinieta"] == '2' ) { ?>
                <tr>
                  <td height="25" class="titR" >1.2 Jornaleros en estibaje y transporte</td>
                  <td align="right"><input type="text" name="A2" id="A2" value="<?php echo number_format($aDat["pejo_menoract_hombres"]) ?>" size="8" maxlength="15" class="inpB2 numeric" /></td>
                  <td align="right"><input type="text" name="B2" id="B2" value="<?php echo number_format($aDat["pejo_menoract_mujeres"]) ?>" size="8" maxlength="15" class="inpB2 numeric" /></td>
                  <td align="right"><input type="text" name="C2" id="C2" value="<?php echo number_format($aDat["pejo_menoract_valor"]) ?>" size="8" maxlength="15" class="inpB2 numeric" /></td>
                  <td align="right"><input type="text" name="D2" id="D2" value="<?php echo number_format($aDat["pejo_mayoract_hombres"]) ?>" size="8" maxlength="15" class="inpB2 numeric" /></td>
                  <td align="right"><input type="text" name="E2" id="E2" value="<?php echo number_format($aDat["pejo_mayoract_mujeres"]) ?>" size="8" maxlength="15" class="inpB2 numeric" /></td>
                  <td align="right"><input type="text" name="F2" id="F2" value="<?php echo number_format($aDat["pejo_mayoract_valor"]) ?>" size="8" maxlength="15" class="inpB2 numeric" onblur="saveUPD(1);" /></td>
                </tr>                              
                <?php } ?>
                
                <?php if( $aDat["vinieta"] == '3') { ?>
                <tr>
                    <td class="titR" >1.3 Jornaleros en servicios mec&aacute;nicos, alba&ntilde;iler&iacute;a y otros</td>
                    <td align="right"><input type="text" name="A3" id="A3" value="<?php echo number_format($aDat["pejo_menoract_hombres"]) ?>" size="8" maxlength="15" class="inpB2 numeric" /></td>
                    <td align="right"><input type="text" name="B3" id="B3" value="<?php echo number_format($aDat["pejo_menoract_mujeres"]) ?>" size="8" maxlength="15" class="inpB2 numeric" /></td>
                    <td align="right"><input type="text" name="C3" id="C3" value="<?php echo number_format($aDat["pejo_menoract_valor"]) ?>" size="8" maxlength="15" class="inpB2 numeric" /></td>
                    <td align="right"><input type="text" name="D3" id="D3" value="<?php echo number_format($aDat["pejo_mayoract_hombres"]) ?>" size="8" maxlength="15" class="inpB2 numeric" /></td>
                    <td align="right"><input type="text" name="E3" id="E3" value="<?php echo number_format($aDat["pejo_mayoract_mujeres"]) ?>" size="8" maxlength="15" class="inpB2 numeric" /></td>
                    <td align="right"><input type="text" name="F3" id="F3" value="<?php echo number_format($aDat["pejo_mayoract_valor"]) ?>" size="8" maxlength="15" class="inpB2 numeric" onblur="saveUPD(1);" /></td>
                </tr>
                <?php } ?>
                                              
                <?php } ?>
                </tbody>
            </table>
            <p>
                <span id="msg" style="display: none;" class="bxEr" >Debe seleccionar el mes para los valores introducidos</span>                
            </p>                                      
            
            <span class="bxBt">
            <input type="submit" value="SIGUIENTE" id="sendData" name="continuarregistro" class="button" >
            <a href="acap2c.php" class="btnS">ANTERIOR</a>             
            </span>

        </fieldset>
  </form>
    <div class="clear"></div>      

</div>
<!-- end body -->

<?php include("footer.php") ?>