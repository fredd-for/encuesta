<?php session_start(); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php'); ?>
<?php include("header.php") ?>
<script type="text/javascript" src="js/acap13.js"></script>
<?php 
/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$sql = "SELECT * FROM  frm3_cap13_otrosinventarios WHERE otin_regi_uid = '".$regisroUID."' ";
$db->query( $sql );
if( $db->numrows() == 0 ) {
    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    $sql2 = "SELECT * FROM adm_definiciones WHERE defi_form_uid = '".$uidFormulario."'  AND defi_modulo = 'a' AND  defi_capitulo = '13' AND defi_swactive = 'ACTIVE'";
    $db2->query( $sql2 );
    while( $aDefinicion =  $db2->next_record() ) {
        $sql = "INSERT INTO frm3_cap13_otrosinventarios SET ";
        $sql .= "otin_regi_uid = '".$regisroUID."', ";
        $sql .= "otin_defi_uid = '".$aDefinicion["defi_uid"]."', ";
        $sql .= "otin_inventarioinicial = 0, ";
        $sql .= "otin_inventariofinal = 0, ";
        $sql .= "otin_description = '', ";
        $sql .= "otin_suv_uid = '".$uid_token."', ";
        $sql .= "otin_createdate = NOW(), ";
        $sql .= "otin_updatedate = NOW() ";
        $db3->query( $sql );
    }
}

$sql = " SELECT frm3_cap13_otrosinventarios.*, adm_definiciones.defi_subcapitulo as subcap "
      ." FROM  frm3_cap13_otrosinventarios LEFT JOIN  adm_definiciones ON ( otin_defi_uid	 = defi_uid ) "
      ." WHERE otin_regi_uid = '".$regisroUID."' ORDER BY CAST( adm_definiciones.defi_subcapitulo AS UNSIGNED ) ASC ";
$db->query( $sql );
//echo $sql;
?>

<!-- begin body -->
<div class="content">
    <span id="statusACAP1"></span>    
    
    <table class="dInf">
    <thead>
    <tr>
        <th>Cap&iacute;tulo 13</th>
        <th>OTROS  INVENTARIOS</th>
    </tr>
    </thead>
    <tbody>
        <tr>                        
            <td colspan="2"><?php echo OPERATOR::getDescTitles(3,'A',13,0); ?></td>
        </tr>
    </tbody>
    </table>        
    
    <form class="formA validable" action="acap13Add.php" method="post" autocomplete="off" >
      <fieldset>
        
        <table width="100%" class="fOpt" >
            <thead>
                <tr>
                    <th rowspan="2" align="center">DETALLE</th>
                    <th colspan="2" align="center">valor (Bs/Anual)</th>
                  </tr>
                <tr>
                  <th align="center">INVENTARIO INICIAL</th>
                  <th align="center">INVENTARIO FINAL</th>
                </tr>                
                </thead>
                                                
                <tbody>
                <?php 
                while( $aDat = $db->next_record() ) {
                ?>
                
                <?php if( $aDat["subcap"] == '1' ) { ?>
                <tr>
                    <td width="71%" class="titR" >1. Combustibles y lubricantes</td>
                    <td width="29%" align="right" ><input type="text" name="A1" id="A1" value="<?php echo number_format($aDat["otin_inventarioinicial"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                    <td width="29%" align="right" ><input type="text" name="B1" id="B1" value="<?php echo number_format($aDat["otin_inventariofinal"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                  </tr>                
                <?php } ?>
                
                <?php if( $aDat["subcap"] == '2'  ) { ?>
                <tr>
                  <td class="titR" >2. Repuestos y accesorios</td>
                  <td align="right"><input type="text" name="A2" id="A2" value="<?php echo number_format($aDat["otin_inventarioinicial"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                  <td align="right"><input type="text" name="B2" id="B2" value="<?php echo number_format($aDat["otin_inventariofinal"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aDat["subcap"] == '3' ) { ?>
                <tr>
                  <td class="titR" >3. Otros inventarios no considerados en otro cap&iacute;tulo</td>
                  <td align="right"><input type="text" name="A3" id="A3" value="<?php echo number_format($aDat["otin_inventarioinicial"]) ?>" onblur="javascript:saveUPD(1); return false;" size="20" maxlength="15" class="inpB2 numeric" /></td>
                  <td align="right"><input type="text" name="B3" id="B3" value="<?php echo number_format($aDat["otin_inventariofinal"]) ?>" onblur="javascript:saveUPD(1); return false;" size="20" maxlength="15" class="inpB2 numeric" /></td>
                </tr>                
                <?php 
                $showrow = "style=\"display: none;\"";
                if( $aDat["otin_inventarioinicial"] > 0 || $aDat["otin_inventariofinal"] > 0  ) {
                    $showrow = "style=\"display: table-row;\"";
                }                
                ?>
                <tr id="otrosingresos" <?php echo $showrow; ?>  >
                  <td class="titR" ><input type="text" name="A5" id="A5" value="<?php echo $aDat["otin_description"] ?>" size="50" class="inpC2" /></td>
                  <td align="right" colspan="2">&nbsp;</td>
                  
                </tr>                
                <?php } ?>
                
                <?php if( $aDat["subcap"] == '4') { ?>
                <tr>
                    <td class="titR" >4. TOTAL </td>
                    <td align="right">                    
                    <span id="tot1" class="labB"><?php echo number_format($aDat["otin_inventarioinicial"]) ?></span>
                    </td>
                    <td align="right"><span id="tot2" class="labB"><?php echo number_format($aDat["otin_inventariofinal"]) ?></span></td>
                </tr>
                <?php } ?>                                                                                                                
                                              
                <?php } ?>
                </tbody>
            </table>
            <p>
                <span id="msg" style="display: none;" class="bxEr" >Debe introducir movimiento para invetarios</span>
                <span id="msg2" style="display: none;" class="bxEr"  >Debe introducir el detalle para otros inventarios</span>               
            </p>                                      
            
            <span class="bxBt">
            <input type="submit" value="SIGUIENTE" id="sendData" name="continuarregistro" class="button" >
            <a href="acap12.php" class="btnS">ANTERIOR</a>                
            </span>

        </fieldset>
  </form>
    <div class="clear"></div>      

</div>
<!-- end body -->

<?php include("footer.php") ?>