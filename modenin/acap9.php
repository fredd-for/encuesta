<?php session_start(); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php'); ?>
<?php include("header.php") ?>
<script type="text/javascript" src="js/acap9.js"></script>
<?php 
/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$sql = "SELECT * FROM  frm2_cap9_ingresosnoopera WHERE inno_regi_uid = '".$regisroUID."' ";
$db->query( $sql );
if( $db->numrows() == 0 ) {
    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    $sql2 = "SELECT * FROM adm_definiciones WHERE defi_form_uid = '".$uidFormulario."'  AND defi_modulo = 'a' AND  defi_capitulo = '9' AND defi_swactive = 'ACTIVE'";
    $db2->query( $sql2 );
    while( $aDefinicion =  $db2->next_record() ) {
        $sql = "INSERT INTO frm2_cap9_ingresosnoopera SET ";
        $sql .= "inno_regi_uid = '".$regisroUID."', ";
        $sql .= "inno_defi_uid = '".$aDefinicion["defi_uid"]."', ";
        $sql .= "inno_ingreso = 0, ";
        $sql .= "inno_egreso = 0, ";
        $sql .= "inno_description = '', ";
        $sql .= "inno_suv_uid = '".$uid_token."', ";
        $sql .= "inno_createdate = NOW(), ";
        $sql .= "inno_updatedate = NOW() ";
        $db3->query( $sql );
    }
}

$sql = " SELECT  frm2_cap9_ingresosnoopera.*, adm_definiciones.defi_subcapitulo as subcap "
      ." FROM  frm2_cap9_ingresosnoopera LEFT JOIN  adm_definiciones ON ( inno_defi_uid	 = defi_uid ) "
      ." WHERE inno_regi_uid = '".$regisroUID."' ORDER BY CAST( adm_definiciones.defi_subcapitulo AS UNSIGNED ) ASC ";
$db->query( $sql );
//echo $sql;
?>

<!-- begin body -->
<div class="content">
    <span id="statusACAP1"></span>    
    
    <table class="dInf">
    <thead>
    <tr>
        <th>Cap&iacute;tulo 9</th>
        <th>INGRESOS Y EGRESOS NO OPERATIVOS</th>
    </tr>
    </thead>
    <tbody>
        <tr>                        
            <td colspan="2"><?php echo OPERATOR::getDescTitles(2,'A',9,0); ?></td>
        </tr>
    </tbody>
    </table>        
    
    <form class="formA validable" action="acap9Add.php" method="post" autocomplete="off" >
      <fieldset>
        
        <table width="100%" class="fOpt" >
                <thead>
                <tr>
                    <th align="center">Detalle</th>
                    <th colspan="2"  align="center">Valor (Bs/Anual)</th>
                </tr>
                
                </thead>
                                                
                <tbody>
                <tr>
                    <td align="center" class="titR">&nbsp; </td>
                    <td align="center" class="titR" style="text-align:center;" >INGRESOS </td>
                    <td align="center" class="titR" style="text-align:center;" >GASTOS</td>                    
                </tr> 
                <?php 
                while( $aDat = $db->next_record() ) {
                ?>                
                <?php if( $aDat["subcap"] == '1' ) { ?>
                <tr>
                    <td width="71%" class="titR" >1. Intereses y comisiones</td>
                    <td width="29%" align="right" ><input type="text" name="A1" id="A1" value="<?php echo number_format($aDat["inno_ingreso"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                    <td width="29%" align="right" ><input type="text" name="B1" id="B1" value="<?php echo number_format($aDat["inno_egreso"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                  </tr>                
                <?php } ?>
                
                <?php if( $aDat["subcap"] == '2'  ) { ?>
                <tr>
                  <td class="titR" >2. Resultados por exposici&oacute;n a la inflaci&oacute;n (o Ajuste por inflaci&oacute;n y tenencia de bienes)</td>
                  <td align="right"><input type="text" name="A2" id="A2" value="<?php echo number_format($aDat["inno_ingreso"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                  <td align="right"><input type="text" name="B2" id="B2" value="<?php echo number_format($aDat["inno_egreso"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aDat["subcap"] == '3' ) { ?>
                <tr>
                  <td class="titR" >3. Indemnizaciones por seguros (excluye seguro de personas)</td>
                  <td align="right"><input type="text" name="A3" id="A3" onblur="javascript:saveUPD(1); return false;" value="<?php echo number_format($aDat["inno_ingreso"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                  <td align="right"><input type="text" name="B3" id="B3" onblur="javascript:saveUPD(1); return false;" value="<?php echo number_format($aDat["inno_egreso"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aDat["subcap"] == '4' ) { ?>
                <tr>
                  <td class="titR" >4. Dividendos (o retiros personales)</td>
                  <td align="right"><input type="text" name="A4" id="A4" value="<?php echo number_format($aDat["inno_ingreso"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                  <td align="right"><input type="text" name="B4" id="B4" value="<?php echo number_format($aDat["inno_egreso"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aDat["subcap"] == '5') { ?>
                <tr>
                  <td class="titR" >5. Otros no operativos:</td>
                  <td align="right"><input type="text" name="A5" id="A5" value="<?php echo number_format($aDat["inno_ingreso"]) ?>" maxlength="15" size="20" class="inpB2 numeric" /></td>
                  <td align="right"><input type="text" name="B5" id="B5" value="<?php echo number_format($aDat["inno_egreso"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                </tr>
                <?php 
                $showrow = "style=\"display: none;\"";
                if( $aDat["inno_ingreso"] > 0 || $aDat["inno_egreso"] > 0 ) {
                    $showrow = "style=\"display: table-row;\"";
                }                
                ?>
                <tr id="otrosnoeperativos" <?php echo $showrow; ?> >
                  <td class="titR" ><input type="text" name="otrosdescrip" id="otrosdescrip" value="<?php echo $aDat["inno_description"]; ?>" size="50" class="inpC2" /></td>
                  <td colspan="2" align="right">&nbsp;</td>                  
                </tr>                
                <?php } ?>
                
                <?php if( $aDat["subcap"] == '6') { ?>
                <tr>
                    <td class="titR" >6. TOTAL </td>
                    <td align="right"><span id="ingreso" class="labB"><?php echo number_format($aDat["inno_ingreso"]) ?></span></td>
                    <td align="right"><span id="egreso" class="labB"><?php echo number_format($aDat["inno_egreso"]) ?></span></td>
                </tr>
                <?php } ?>                                             
                                              
                <?php } ?>
                </tbody>
            </table>
            <p>
                <span id="msg" style="display: none;" class="bxEr" >Debe registrar el ingreso o egreso generado</span>
                <span id="msg1" style="display: none;" class="bxEr" >Debe registrar el detalle en el &iacute;tem otros</span>
            </p>                                      
            
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