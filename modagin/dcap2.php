<?php session_start(); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
?>
<?php include_once('../verifyLogin.php'); ?>
<?php include("header.php") ?>
<script type="text/javascript" src="js/dcap2.js"></script>
<?php
/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$sql = "SELECT * FROM frm3_dcap2_inversion WHERE inve_regi_uid = '".$regisroUID."' ";
$db->query( $sql );

if( $db->numrows() == 0 ) {

    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    $sql2 = "SELECT * FROM adm_definiciones WHERE defi_form_uid = '3' AND defi_modulo = 'd' AND  defi_capitulo = '2' AND defi_swactive = 'ACTIVE' ";       
    $db2->query( $sql2 );
    while( $aDefinicion =  $db2->next_record() ) {
        $sql = "INSERT INTO frm3_dcap2_inversion SET ";
        $sql .= "inve_regi_uid = '".$regisroUID."', ";
        $sql .= "inve_defi_uid = '".$aDefinicion["defi_uid"]."', ";         
        $sql .= "inve_valor = '0', "; 
        $sql .= "inve_suv_uid = '".$uid_token."', ";        
        $sql .= "inve_createdate = NOW(), "; 
        $sql .= "inve_updatedate = NOW() ";                          	 	
        $db3->query( $sql );              
    }        
}

$sql = " SELECT  frm3_dcap2_inversion.*, adm_definiciones.defi_subcapitulo as subcap "
      ." FROM  frm3_dcap2_inversion LEFT JOIN  adm_definiciones ON ( inve_defi_uid	 = defi_uid ) "
      ." WHERE inve_regi_uid = '".$regisroUID."' ORDER BY CAST( adm_definiciones.defi_subcapitulo AS UNSIGNED ) ASC ";
$db->query( $sql );
?>

<?php      
    // verificar si esta vacia
    function checkEmpty($var) {
        if (strlen($var) >= 1) {
            return false; // No esta vacia
        } else {
            return true; // Esta Vacia
        }
    }
           
?>
<!-- begin body -->
<div class="content">
    <span id="statusACAP1"></span>            
    <table class="dInf">
    <thead>
    <tr>
        <th>Cap&iacute;tulo 2</th>
        <th>INVERSI&Oacute;N EN ACTIVIDADES DE INNOVACI&Oacute;N</th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" ><?php echo OPERATOR::getDescTitles(3,'D',2,0); ?></td>
        </tr>
    </tbody>
    </table>
    
<form class="formA validable" action="dcap2Add.php" method="post" autocomplete="off" >
<fieldset>
    <p class="subT" >Inversi&oacute;n seg&uacute;n tipo de actividad</p>                
    <?php 
    while ( $aDat = $db->next_record() ) {
    ?>

    <?php if( $aDat["subcap"] == 1 ) { ?>    
    <table width="100%"  class="fOpt" >
    <thead>
    <tr>
        <th width="69%">&nbsp;</th>
        <th width="16%" align="center">Valor (Bs/Anual)</th>
    </tr>
    </thead>
    <tbody>
    <tr>             
        <td class="titR" >1. Investigaci&oacute;n y Desarrollo I+D</td>          
        <td align="center"><input name="A_1" type="text" id="A_1" size="30" value="<?php echo number_format($aDat["inve_valor"]); ?>" class="numeric inpB2" /><span id="div_inputA-1" class="bxEr" style="display:none" >requerido</span></td>
        </tr>
    <?php } ?>

    <?php if( $aDat["subcap"] == 2 ) { ?> 
    <tr>
        <td class="titR">2. Adquisici&oacute;n de tecnolog&iacute;a</td>        
        <td align="center"><input name="A_2" type="text" id="A_2" size="30" value="<?php echo number_format($aDat["inve_valor"]); ?>" class="numeric inpB2" /><span id="div_inputA-2" class="bxEr" style="display:none" >requerido</span></td>
        </tr>
    <?php } ?>

    <?php if( $aDat["subcap"] == 3 ) { ?> 
    <tr>
      <td class="titR">3. Pago por registro de propiedad intelectual (excepto uso de marcas)</td>
      <td align="center"><input name="A_3" type="text" id="A_3" size="30" value="<?php echo number_format($aDat["inve_valor"]); ?>" class="numeric inpB2" /></td>
    </tr>
    <?php } ?>

    <?php if( $aDat["subcap"] == 4 ) { ?> 
    <tr>
      <td class="titR">4. Capacitaci&oacute;n tecnol&oacute;gica de innovaci&oacute;n</td>
      <td align="center"><input name="A_4" type="text" id="A_4" size="30" value="<?php echo number_format($aDat["inve_valor"]); ?>" onblur="saveUPD(1);" class="numeric inpB2" /></td>
    </tr>
    <?php } ?>

    <?php if( $aDat["subcap"] == 5 ) { ?>
    <tr>
        <td class="titR">5. Total</td>        
        <td align="center"><label id="total" class="labB"><?php echo number_format($aDat["inve_valor"]); ?></label></td>
    </tr>    
    </tbody>
    </table>
    <p>&nbsp;</p>
    <?php } ?>
    
    <?php if( $aDat["subcap"] == 6 ) { ?>
    
    <p>
        <span class="subT">Participaci&oacute;n</span>
        <span class="clear"></span>
     
        <label class="labChk" >% Empresa</label>
        <input type="text" name="pa_empresa" id="pa_empresa" maxlength="3" class="inpC numeric" value="<?php echo number_format($aDat["inve_valor"]); ?>" >        
        <span class="clear"></span>
    <?php } ?>

    <?php if( $aDat["subcap"] == 7 ) { ?>        
        <label class="labChk" >% Universidad</label>
        <input type="text" name="pa_universidad" id="pa_universidad" maxlength="3" class="inpC numeric" value="<?php echo number_format($aDat["inve_valor"]); ?>" >        
        <span class="clear"></span>
    <?php } ?>

    <?php if( $aDat["subcap"] == 8 ) { ?>
        <label class="labChk" >% Nacional</label>
        <input type="text" name="pa_nacional" id="pa_nacional" maxlength="3" class="inpC numeric" value="<?php echo number_format($aDat["inve_valor"]); ?>" >        
        <span class="clear"></span>
    <?php } ?>

    <?php if( $aDat["subcap"] == 9  ) { ?>
        <label class="labChk" >% Importado</label>
        <input type="text" name="pa_importado" id="pa_importado" maxlength="3" class="inpC numeric" value="<?php echo number_format($aDat["inve_valor"]); ?>" >        
        <span class="clear"></span>
    </p>
    <?php } ?>
    
    <?php } ?>
            
    <span id="msg2" class="bxEr" style="display: none;" >Debe introducir el porcentaje correcto que debe estar entre 0 al 100 %</span>    

    <span class="bxBt">
        <input type="submit" value="SIGUIENTE" id="sendData" name="continuarregistro" class="button" >
        <a href="dcap1e.php" class="btnS">ANTERIOR</a>                
    </span>

  </fieldset>
  </form>
  <div class="clear"></div>      

</div>
<!-- end body -->
<?php include("footer.php") ?>