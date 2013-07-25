<?php session_start(); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php'); ?>
<?php include("header.php") ?>
<script type="text/javascript" src="js/acap8.js"></script>
<?php 
/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$sql = "SELECT * FROM  frm2_cap8_ingresosopera WHERE inop_regi_uid = '".$regisroUID."' ";
$db->query( $sql );
if( $db->numrows() == 0 ) {
    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    $sql2 = "SELECT * FROM adm_definiciones WHERE defi_form_uid = '".$uidFormulario."'  AND defi_modulo = 'a' AND  defi_capitulo = '8' AND defi_swactive = 'ACTIVE'";
    $db2->query( $sql2 );
    while( $aDefinicion =  $db2->next_record() ) {
        $sql = "INSERT INTO frm2_cap8_ingresosopera SET ";
        $sql .= "inop_regi_uid = '".$regisroUID."', ";
        $sql .= "inop_defi_uid = '".$aDefinicion["defi_uid"]."', ";
        $sql .= "inop_valor = 0, ";
        $sql .= "inop_description = '', ";
        $sql .= "inop_suv_uid = '".$uid_token."', ";
        $sql .= "inop_createdate = NOW(), ";
        $sql .= "inop_updatedate = NOW() ";
        $db3->query( $sql );
    }
}

$sql = " SELECT frm2_cap8_ingresosopera.*, adm_definiciones.defi_subcapitulo as subcap "
      ." FROM  frm2_cap8_ingresosopera LEFT JOIN  adm_definiciones ON ( inop_defi_uid	 = defi_uid ) "
      ." WHERE inop_regi_uid = '".$regisroUID."' ORDER BY CAST( adm_definiciones.defi_subcapitulo AS UNSIGNED ) ASC ";
$db->query( $sql );
//echo $sql;
?>

<!-- begin body -->
<div class="content">
    <span id="statusACAP1"></span>    
    
    <table class="dInf">
    <thead>
    <tr>
        <th>Cap&iacute;tulo 8</th>
        <th>OTROS  INGRESOS  OPERATIVOS</th>
    </tr>
    </thead>
    <tbody>
        <tr>                        
            <td colspan="2"><?php echo OPERATOR::getDescTitles(2,'A',8,0); ?></td>
        </tr>
    </tbody>
    </table>        
    
    <form class="formA validable" action="acap8Add.php" method="post" autocomplete="off" >
      <fieldset>
        
        <table width="100%" class="fOpt" >
            <thead>
                <tr>
                    <th align="center">&nbsp;</th>
                    <th align="center">valor (Bs/Anual)</th>                    
                  </tr>                
                </thead>
                                                
                <tbody>
                <?php 
                while( $aSueldos = $db->next_record() ) {
                ?>
                
                <?php if( $aSueldos["subcap"] == '1' ) { ?>
                <tr>
                    <td width="71%" class="titR" >1. Ingresos por alquileres (excepto terrenos)</td>
                    <td width="29%" align="right" ><input type="text" name="A1" id="A1" value="<?php echo number_format($aSueldos["inop_valor"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                  </tr>                
                <?php } ?>
                
                <?php if( $aSueldos["subcap"] == '2'  ) { ?>
                <tr>
                  <td class="titR" >2. Ingresos por servicios de fabricaci&oacute;n</td>
                  <td align="right"><input type="text" name="A2" id="A2" value="<?php echo number_format($aSueldos["inop_valor"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aSueldos["subcap"] == '3' ) { ?>
                <tr>
                  <td class="titR" >3. Ingresos por venta de residuos</td>
                  <td align="right"><input type="text" name="A3" id="A3" onblur="javascript:saveUPD(1); return false;" value="<?php echo number_format($aSueldos["inop_valor"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aSueldos["subcap"] == '4' ) { ?>
                <tr>
                  <td class="titR" >4. Otros ingresos operativos (especificar)</td>
                  <td align="right"><input type="text" name="A4" id="A4" value="<?php echo number_format($aSueldos["inop_valor"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                </tr>
                <?php 
                $showrow = "style=\"display: none;\"";
                if( $aSueldos["inop_valor"] > 0 ) {
                    $showrow = "style=\"display: table-row;\"";
                }                
                ?>
                <tr id="otrosingresos" <?php echo $showrow; ?>  >
                  <td class="titR" ><input type="text" name="A5" id="A5" value="<?php echo $aSueldos["inop_description"] ?>" size="50" class="inpC2" /></td>
                  <td align="right">&nbsp;</td>
                </tr>                
                <?php } ?>
                
                <?php if( $aSueldos["subcap"] == '5') { ?>
                <tr>
                    <td class="titR" >5. TOTAL </td>
                    <td align="right">                    
                    <span id="costo1" class="labB"><?php echo number_format($aSueldos["inop_valor"]) ?></span>
                    </td>
                </tr>
                <?php } ?>                                                                                                                
                                              
                <?php } ?>
                </tbody>
            </table>
            <p>
                <span id="msg" style="display: none;" class="bxEr" >Debe introducir el detalle para otros ingresos</span>                
            </p>                                      
            
            <span class="bxBt">
            <input type="submit" value="SIGUIENTE" id="sendData" name="continuarregistro" class="button" >
            <a href="acap7.php" class="btnS">ANTERIOR</a>                
            </span>

        </fieldset>
  </form>
    <div class="clear"></div>      

</div>
<!-- end body -->

<?php include("footer.php") ?>