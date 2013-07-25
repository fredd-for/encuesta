<?php session_start(); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php'); ?>
<?php include("header.php") ?>
<script type="text/javascript" src="js/acap5.js"></script>
<?php 
/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$sql = "SELECT * FROM  frm3_cap5_materiaprima WHERE mapi_regi_uid = '".$regisroUID."' ";
$db->query( $sql );
if( $db->numrows() == 0 ) {
    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    $sql2 = "SELECT * FROM adm_definiciones WHERE defi_form_uid = '".$uidFormulario."'  AND defi_modulo = 'a' AND  defi_capitulo = '5' AND defi_swactive = 'ACTIVE'";
    $db2->query( $sql2 );
    while( $aDefinicion =  $db2->next_record() ) {
        $sql = "INSERT INTO frm3_cap5_materiaprima SET ";
        $sql .= "mapi_regi_uid = '".$regisroUID."', ";
        $sql .= "mapi_defi_uid = '".$aDefinicion["defi_uid"]."', ";
        $sql .= "mapi_valor = 0, ";
        $sql .= "mapi_suv_uid = '".$uid_token."', ";
        $sql .= "mapi_createdate = NOW(), ";
        $sql .= "mapi_updatedate = NOW() ";
        $db3->query( $sql );
    }
}

$sql = " SELECT  frm3_cap5_materiaprima.*, adm_definiciones.defi_vinieta as vinieta "
      ." FROM  frm3_cap5_materiaprima LEFT JOIN  adm_definiciones ON ( mapi_defi_uid	 = defi_uid ) "
      ." WHERE mapi_regi_uid = '".$regisroUID."' ORDER BY CAST( adm_definiciones.defi_vinieta AS UNSIGNED ) ASC ";
$db->query( $sql );
//echo $sql;
?>

<!-- begin body -->
<div class="content">
    <span id="statusACAP1"></span>    
    
    <table class="dInf">
    <thead>
    <tr>
        <th>Cap&iacute;tulo 5</th>
        <th>MATERIAS PRIMAS, MATERIALES AUXILIARES, ENVASES Y EMBALAJES</th>
    </tr>
    </thead>
    <tbody>
        <tr>                        
            <td colspan="2"><?php echo OPERATOR::getDescTitles(3,'A',5,0); ?></td>
        </tr>
    </tbody>
    </table>        
    
    <form class="formA validable" action="acap5Add.php" method="post" autocomplete="off" >
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
                
                <?php if( $aSueldos["vinieta"] == '0' ) { ?>
                <tr>
                    <td width="71%" class="titR" >1. Total compras de materias primas, materiales auxiliares, envases y embalajes (Valor del Estado de Resultados)</td>
                    <td align="right"><label class="labB" id="perH"><?php echo number_format($aSueldos["mapi_valor"]) ?></label></td>
                  </tr>                
                <?php } ?>
                
                <?php if( $aSueldos["vinieta"] == '1'  ) { ?>
                <tr>
                  <td class="titR" >1.1 Compra de materias primas, materiales auxiliares, envases y embalajes, fabricados en el pa&iacute;s</td>
                  <td align="right"><input type="text" name="A1" id="A1" value="<?php echo number_format($aSueldos["mapi_valor"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aSueldos["vinieta"] == '2' ) { ?>
                <tr>
                  <td class="titR" >1.2 Compra de materias primas, materiales auxiliares, envases y embalajes, fabricados fuera del pa&iacute;s</td>
                  <td align="right"><input type="text" name="A2" id="A2" value="<?php echo number_format($aSueldos["mapi_valor"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                </tr>
                <?php } ?>                                                                
                                              
                <?php } ?>
                </tbody>
            </table>
            <p>
                <span id="msg1" style="display: none;" class="bxEr" >Debe introducir el detalle para otros gastos</span>                
            </p>                                      
            
            <span class="bxBt">
            <input type="submit" value="SIGUIENTE" id="sendData" name="continuarregistro" class="button" >
            <a href="acap4.php" class="btnS">ANTERIOR</a>                
            </span>

        </fieldset>
  </form>
    <div class="clear"></div>      

</div>
<!-- end body -->

<?php include("footer.php") ?>