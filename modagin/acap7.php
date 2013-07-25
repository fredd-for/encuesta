<?php session_start(); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php'); ?>
<?php include("header.php") ?>
<script type="text/javascript" src="js/acap7.js"></script>
<?php 
/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$sql = "SELECT * FROM  frm3_cap7_mercaderias WHERE merc_regi_uid = '".$regisroUID."' ";
$db->query( $sql );
if( $db->numrows() == 0 ) {
    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    $sql2 = "SELECT * FROM adm_definiciones WHERE defi_form_uid = '".$uidFormulario."'  AND defi_modulo = 'a' AND  defi_capitulo = '7' AND defi_swactive = 'ACTIVE'";
    $db2->query( $sql2 );
    while( $aDefinicion =  $db2->next_record() ) {
        $sql = "INSERT INTO frm3_cap7_mercaderias SET ";
        $sql .= "merc_regi_uid = '".$regisroUID."', ";
        $sql .= "merc_defi_uid = '".$aDefinicion["defi_uid"]."', ";
        $sql .= "merc_valor = 0, ";        
        $sql .= "merc_suv_uid = '".$uid_token."', ";
        $sql .= "merc_createdate = NOW(), ";
        $sql .= "merc_updatedate = NOW() ";
        $db3->query( $sql );
    }
}

$sql = " SELECT  frm3_cap7_mercaderias.*, adm_definiciones.defi_subcapitulo	 as subcap "
      ." FROM  frm3_cap7_mercaderias LEFT JOIN  adm_definiciones ON ( merc_defi_uid	 = defi_uid ) "
      ." WHERE merc_regi_uid = '".$regisroUID."' ORDER BY CAST( adm_definiciones.defi_subcapitulo	 AS UNSIGNED ) ASC ";
$db->query( $sql );
//echo $sql;
?>

<!-- begin body -->
<div class="content">
    <span id="statusACAP1"></span>    
    
    <table class="dInf">
    <thead>
    <tr>
        <th>Cap&iacute;tulo 7</th>
        <th>ACTIVIDAD COMERCIAL DE MERCADER&Iacute;AS SIN TRANSFORMACI&Oacute;N - REVENTA -</th>
    </tr>
    </thead>
    <tbody>
        <tr>                        
            <td colspan="2"><?php echo OPERATOR::getDescTitles(3,'A',7,0); ?></td>
        </tr>
    </tbody>
    </table>        
    
    <form class="formA validable" action="acap7Add.php" method="post" autocomplete="off" >
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
                while( $aDat = $db->next_record() ) {
                ?>
                
                <?php if( $aDat["subcap"] == '1' ) { ?>
                <tr>
                    <td width="71%" class="titR" >1. Venta de mercader&iacute;as sin transformaci&oacute;n (V)</td>
                    <td width="29%" align="right" ><input type="text" name="A1" id="A1" value="<?php echo number_format($aDat["merc_valor"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                  </tr>                
                <?php } ?>
                
                <?php if( $aDat["subcap"] == '2'  ) { ?>
                <tr>
                  <td class="titR" >2. Inventario inicial de mercader&iacute;as sin transformaci&oacute;n (II)</td>
                  <td align="right"><input type="text" name="A2" id="A2" value="<?php echo number_format($aDat["merc_valor"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aDat["subcap"] == '3' ) { ?>
                <tr>
                  <td class="titR" >3. Inventario final de mercader&iacute;as sin transformaci&oacute;n (IF)</td>
                  <td align="right"><input type="text" name="A3" id="A3" onblur="javascript:saveUPD(1); return false;" value="<?php echo number_format($aDat["merc_valor"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aDat["subcap"] == '4' ) { ?>
                <tr>
                  <td class="titR" >4. Compra de mercader&iacute;as para reventa sin transformaci&oacute;n (C)</td>
                  <td align="right"><input type="text" name="A4" id="A4" value="<?php echo number_format($aDat["merc_valor"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aDat["subcap"] == '5') { ?>
                <tr>
                  <td class="titR" >5. Costo de mercader&iacute;as sin transformaci&oacute;n (CM) = (II)+(C)-(IF)</td>
                  <td align="right">
                      <span id="costo1" class="labB"><?php echo number_format($aDat["merc_valor"]) ?></span>                      
                  </td>
                </tr>                
                <?php } ?>
                
                <?php if( $aDat["subcap"] == '6') { ?>
                <tr>
                    <td class="titR" >6. PRODUCCI&Oacute;N  COMERCIAL  (PC) = (V)-(CM)</td>
                    <td align="right">                                        
                    <span id="costo2" class="labB"><?php echo number_format($aDat["merc_valor"]) ?></span>
                    </td>
                </tr>
                <?php } ?>                                
                                              
                <?php } ?>
                </tbody>
            </table>
            <p>
                <span id="msg1" style="display: none;" class="bxEr" >Debe introducir el detalle para otros gastos</span>                
            </p>  
            <p>
                <?php echo OPERATOR::getDescTitles(3,'A',7,7); ?>
            </p>
            
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