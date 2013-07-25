<?php session_start(); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
?>
<?php include_once('../verifyLogin.php'); ?>
<?php include("header.php") ?>
<script type="text/javascript" src="js/dcap1e.js"></script>
<?php
/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$sql = "SELECT * FROM frm3_dcap1e_tipoformacion WHERE tifo_regi_uid = '".$regisroUID."' ";
$db->query( $sql );

if( $db->numrows() == 0 ) {

    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    $sql2 = "SELECT * FROM adm_definiciones WHERE defi_form_uid = '3' AND defi_modulo = 'd' AND  defi_capitulo = '1' AND defi_subcapitulo = '2' AND defi_swactive = 'ACTIVE' ";       
    $db2->query( $sql2 );
    while( $aDefinicion =  $db2->next_record() ) {
        $sql = "INSERT INTO frm3_dcap1e_tipoformacion SET ";
        $sql .= "tifo_regi_uid = '".$regisroUID."', ";
        $sql .= "tifo_defi_uid = '".$aDefinicion["defi_uid"]."', ";         
        $sql .= "tifo_obrero = '0', ";
        $sql .= "tifo_supervisor = '0', ";
        $sql .= "tifo_administrativo = '0', ";
        $sql .= "tifo_gerente = '0', ";
        $sql .= "tifo_proveedor = '0', ";
        $sql .= "tifo_suv_uid = '".$uid_token."', ";        
        $sql .= "tifo_createdate = NOW(), "; 
        $sql .= "tifo_updatedate = NOW() ";                          	 	
        $db3->query( $sql );              
    }        
}

$sql = " SELECT  frm3_dcap1e_tipoformacion.*, adm_definiciones.defi_subcapitulo as subcap, adm_definiciones.defi_indent as indent "
      ." FROM  frm3_dcap1e_tipoformacion LEFT JOIN  adm_definiciones ON ( tifo_defi_uid	 = defi_uid ) "
      ." WHERE tifo_regi_uid = '".$regisroUID."' ORDER BY CAST( adm_definiciones.defi_indent AS UNSIGNED ) ASC ";
$db->query( $sql );
?>
<!-- begin body -->
<div class="content">
    <span id="statusACAP1"></span>     
    <table class="dInf">
    <thead>
    <tr>
        <th>Cap&iacute;tulo 1</th>
        <th>FORMACI&Oacute;N  Y  CAPACITACI&Oacute;N</th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" ><?php echo OPERATOR::getDescTitles(3,'D',1,'2'); ?></td>
        </tr>
    </tbody>
    </table>
    
<form class="formA validable" action="dcap1eAdd.php" method="post" autocomplete="off" >
<fieldset>
    <p class="subT" >1.2 TIPO DE FORMACI&Oacute;N</p>
    <table width="100%"  class="fOpt" >
    <thead>
    <tr>
      <th width="69%" rowspan="2">&nbsp;</th>
      <th colspan="5" align="center">N&uacute;mero de personas beneficiadas</th>
    </tr>
    <tr>
        <th width="16%" align="center">Obreros</th>
        <th width="16%" align="center">Supervisores, jefes de planta y/o producci&oacute;n</th>
        <th width="16%" align="center">Personal adm. y de ventas</th>
        <th width="16%" align="center">Gerentes y/o personal directivo</th>
        <th width="16%" align="center">Proveedores</th>
        </tr>
    </thead>
    <tbody>
    <?php 
    while ( $aDat = $db->next_record() ) {
    ?>

    <?php if( $aDat["subcap"] == 2 && $aDat["indent"] == 1 ) { ?>    
    
    <tr>             
        <td class="titR" >1.  Formaci&oacute;n t&eacute;cnica (procesos de producci&oacute;n, manejo de maquinarias, etc.)</td>          
        <td align="center"><input name="A_1" type="text" id="A_1" size="10" value="<?php echo number_format($aDat["tifo_obrero"]); ?>" class="numeric inpB2" /><span id="div_inputA-1" class="bxEr" style="display:none" >requerido</span></td>
        <td align="center"><input name="B_1" type="text" id="B_1" size="10" value="<?php echo number_format($aDat["tifo_supervisor"]); ?>" class="numeric inpB2" /></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        </tr>
    <?php } ?>

    <?php if( $aDat["subcap"] == 2 && $aDat["indent"] == 2 ) { ?> 
    <tr>
        <td class="titR">2. Formaci&oacute;n en gesti&oacute;n empresarial (contabilidad, administraci&oacute;n, etc.)</td>        
        <td align="center"><input name="A_2" type="text" id="A_2" size="10" value="<?php echo number_format($aDat["tifo_obrero"]); ?>" class="numeric inpB2" /><span id="div_inputA-2" class="bxEr" style="display:none" >requerido</span></td>
        <td align="center"><input name="B_2" type="text" id="B_2" size="10" value="<?php echo number_format($aDat["tifo_supervisor"]); ?>" class="numeric inpB2" /></td>
        <td align="center"><input name="C_2" type="text" id="C_2" size="10" value="<?php echo number_format($aDat["tifo_administrativo"]); ?>" class="numeric inpB2" /></td>
        <td align="center"><input name="D_2" type="text" id="D_2" size="10" value="<?php echo number_format($aDat["tifo_gerente"]); ?>" class="numeric inpB2" /></td>
        <td align="center"><input name="E_2" type="text" id="E_2" size="10" value="<?php echo number_format($aDat["tifo_proveedor"]); ?>" onblur="saveUPD(1);" class="numeric inpB2" /></td>
        </tr>
    <?php } ?>

    <?php if( $aDat["subcap"] == 2 && $aDat["indent"] == 3 ) { ?> 
    <tr>
      <td class="titR">3. Formaci&oacute;n en capacidades personales (liderazgo, &eacute;tica, etc.)</td>
      <td align="center"><input name="A_3" type="text" id="A_3" size="10" value="<?php echo number_format($aDat["tifo_obrero"]); ?>" class="numeric inpB2" /></td>
      <td align="center"><input name="B_3" type="text" id="B_3" size="10" value="<?php echo number_format($aDat["tifo_supervisor"]); ?>" class="numeric inpB2" /></td>
      <td align="center"><input name="C_3" type="text" id="C_3" size="10" value="<?php echo number_format($aDat["tifo_administrativo"]); ?>" class="numeric inpB2" /></td>
      <td align="center"><input name="D_3" type="text" id="D_3" size="10" value="<?php echo number_format($aDat["tifo_gerente"]); ?>" class="numeric inpB2" /></td>
      <td align="center"><input name="E_3" type="text" id="E_3" size="10" value="<?php echo number_format($aDat["tifo_proveedor"]); ?>" class="numeric inpB2" /></td>
    </tr>    
      
    <?php } ?>        
    
    <?php } ?>
    </tbody>
    </table>
    <span id="msg2" class="bxEr" style="display: none;" >Debe introducir el porcentaje correcto que debe estar entre 0 al 100 %</span>    

    <span class="bxBt">
        <input type="submit" value="SIGUIENTE" id="sendData" name="continuarregistro" class="button" >
        <a href="dcap1a4.php" class="btnS">ANTERIOR</a>                
    </span>

  </fieldset>
  </form>
  <div class="clear"></div>      

</div>
<!-- end body -->
<?php include("footer.php") ?>