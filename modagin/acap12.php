<?php session_start(); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php'); ?>
<?php include("header.php") ?>
<script type="text/javascript" src="js/acap12.js"></script>
<?php 
/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$sql = "SELECT * FROM frm3_cap12_capitalsocial WHERE caso_regi_uid = '".$regisroUID."' ";
$db->query( $sql );
if( $db->numrows() == 0 ) {
    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    $sql2 = "SELECT * FROM adm_definiciones WHERE defi_form_uid = '".$uidFormulario."'  AND defi_modulo = 'a' AND  defi_capitulo = '12' AND defi_swactive = 'ACTIVE'";
    $db2->query( $sql2 );
    while( $aDefinicion =  $db2->next_record() ) {
        $sql = "INSERT INTO frm3_cap12_capitalsocial SET ";
        $sql .= "caso_regi_uid = '".$regisroUID."', ";
        $sql .= "caso_defi_uid = '".$aDefinicion["defi_uid"]."', ";
        $sql .= "caso_valor = 0, ";
        $sql .= "caso_suv_uid = '".$uid_token."', ";
        $sql .= "caso_createdate = NOW(), ";
        $sql .= "caso_updatedate = NOW() ";
        $db3->query( $sql );
    }
}

$sql = " SELECT frm3_cap12_capitalsocial.*, adm_definiciones.defi_subcapitulo as subcap, adm_definiciones.defi_indent  as indent  "
      ." FROM frm3_cap12_capitalsocial LEFT JOIN  adm_definiciones ON ( caso_defi_uid	 = defi_uid ) "
      ." WHERE caso_regi_uid = '".$regisroUID."' AND  defi_indent IN (1,2,3) "
      ." ORDER BY CAST( adm_definiciones.defi_subcapitulo AS UNSIGNED ) ASC, CAST( adm_definiciones.defi_indent AS UNSIGNED ) ASC ";
$db->query( $sql );
?>

<!-- begin body -->
<div class="content">
    <span id="statusACAP1"></span>    
    
    <table class="dInf">
    <thead>
    <tr>
        <th>Cap&iacute;tulo 12</th>
        <th>CAPITAL  SOCIAL Y  PATRIMONIO</th>
    </tr>
    </thead>
    <tbody>
        <tr>                        
            <td colspan="2"><?php echo OPERATOR::getDescTitles(3,'A',12,0); ?></td>
        </tr>
    </tbody>
    </table>        
    
    <form class="formA validable" action="acap12Add.php" method="post" autocomplete="off" >
      <fieldset>
        
        <table width="100%" class="fOpt" >
            <thead>
                <tr>
                    <th align="center">&nbsp;</th>
                    <th align="center">Valor Total (Bs/Anual)</th>                    
                  </tr>                
                </thead>
                                                
                <tbody>
                <?php 
                while( $aDat = $db->next_record() ) {
                ?>
                
                <?php if( $aDat["subcap"] == '1' && $aDat["indent"] == '1' ) { ?>
                <tr>
                    <td width="71%" class="titR" >1.1 Capital de Or&iacute;gen Nacional</td>
                    <td width="29%" align="right" ><input type="text" name="A1" id="A1" value="<?php echo number_format($aDat["caso_valor"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                  </tr>                
                <?php } ?>
                
                <?php if( $aDat["subcap"] == '1' && $aDat["indent"] == '2' ) { ?>
                <tr>
                  <td class="titR" >1.2 Capital de or&iacute;gen Extranjero</td>
                  <td align="right"><input type="text" name="A2" id="A2" value="<?php echo number_format($aDat["caso_valor"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aDat["subcap"] == '1' && $aDat["indent"] == '3' ) { ?>
                <tr>
                  <td class="titR" >1.3 Capital Estatal</td>
                  <td align="right"><input type="text" name="A3" id="A3" value="<?php echo number_format($aDat["caso_valor"]) ?>" onblur="javascript:saveUPD(1); return false;" size="20" maxlength="15" class="inpB2 numeric" /></td>
                </tr>
                <?php } ?>
                
                <?php } ?>   

                <?php
                $sql = " SELECT frm3_cap12_capitalsocial.*, adm_definiciones.defi_subcapitulo as subcap  "
                ." FROM frm3_cap12_capitalsocial LEFT JOIN  adm_definiciones ON ( caso_defi_uid	 = defi_uid ) "
                ." WHERE caso_regi_uid = '".$regisroUID."' AND  defi_uid IN (416,417) "
                ." ORDER BY CAST( adm_definiciones.defi_subcapitulo AS UNSIGNED ) ASC ";
                $db->query( $sql );
                while( $aDat = $db->next_record() ) {
                ?>
                <?php if( $aDat["subcap"] == '1' ) { ?>
                <tr>
                  <td class="titR" >1. Total Capital Social (1.1 + 1.2 + 1.3)</td>
                  <td align="right"><span id="costo1" class="labB"><?php echo number_format($aDat["caso_valor"]) ?></span></td>
                </tr>               
                <?php } ?>
                
                <?php if( $aDat["subcap"] == '2'  ) { ?>                           
                <tr>
                    <td class="titR" >2. Patrimonio</td>
                    <td align="right">                    
                    <input type="text" name="A4" id="A4" value="<?php echo number_format($aDat["caso_valor"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /> 
                    </td>
                </tr>
                <?php } ?>                
                <?php } ?>  
                
                </tbody>
            </table>
            <p>
                <span id="msg" style="display: none;" class="bxEr" >Debe introducir un valor para capital</span>
                <span id="msg2" style="display: none;" class="bxEr" >Debe registrar un valor para patrimonio</span>
            </p>                                      
            
            <span class="bxBt">
            <input type="submit" value="SIGUIENTE" id="sendData" name="continuarregistro" class="button" >
            <a href="acap11.php" class="btnS">ANTERIOR</a>                
            </span>

        </fieldset>
  </form>
    <div class="clear"></div>      

</div>
<!-- end body -->

<?php include("footer.php") ?>