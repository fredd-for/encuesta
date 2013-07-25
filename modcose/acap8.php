<?php session_start(); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
?>
<?php include_once('../verifyLogin.php'); ?>
<?php include("header.php") ?>
<script type="text/javascript" src="js/acap8.js"></script>
<?php
/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$sql = "SELECT * FROM frm1_cap8_resultadosgestion WHERE rege_regi_uid = '".$regisroUID."' ";
$db->query( $sql );

if( $db->numrows() == 0 ) {

    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    $sql2 = "SELECT * FROM adm_definiciones WHERE defi_form_uid = '".$uidFormulario."' AND defi_modulo = 'a' AND  defi_capitulo = '8' ";       
    $db2->query( $sql2 );
    while( $aDefinicion =  $db2->next_record() ) {        
        $sql = "INSERT INTO frm1_cap8_resultadosgestion SET ";
        $sql .= "rege_regi_uid = '".$regisroUID."', ";
        $sql .= "rege_defi_uid = '".$aDefinicion["defi_uid"]."', ";
        $sql .= "rege_valor = 0, ";         
        $sql .= "rege_suv_uid = '".$uid_token."', "; 
        $sql .= "rege_createdate = NOW(), "; 
        $sql .= "rege_updatedate = NOW() ";                          	 	
        $db3->query( $sql );                
    }        
}
?>
<!-- begin body -->
<div class="content"><span id="statusACAP1"></span>
    <table class="dInf">
    <thead>
    <tr>
        <th>Cap&iacute;tulo 8</th>
        <th>RESULTADO DE LA GESTI&Oacute;N</th>
    </tr>    
    </thead>   
    <tbody>
        <tr>                        
            <td colspan="2"><?php echo OPERATOR::getDescTitles(1,'A',8,0); ?></td>
        </tr>
    </tbody>
    </table>    

    <form class="formA validable" action="acap8Add.php" method="post" autocomplete="off" >
        <fieldset>
          <table width="100%" class="fOpt" >
                <thead>
                <tr>
                    <th align="center">DETALLE</th>
                    <th width="20%" align="center" >VALOR (Bs/Anual)</th>
                </tr>
                </thead>
                <tbody>
                <?php                                                
                $sql = " SELECT frm1_cap8_resultadosgestion.*, adm_definiciones.defi_vinieta as vinieta, adm_definiciones.defi_indent as indent "
                      ." FROM frm1_cap8_resultadosgestion LEFT JOIN  adm_definiciones ON ( rege_defi_uid = defi_uid ) "
                      ." WHERE rege_regi_uid = '".$regisroUID."' AND rege_defi_uid IN (43,44) "
                      ." ORDER BY adm_definiciones.defi_indent ASC,  adm_definiciones.defi_vinieta ASC ";
                $db->query( $sql );
                //echo $sql;                             
                ?>
                <?php  while( $aGestion = $db->next_record() ) {  ?>
                <?php if( $aGestion["vinieta"] == "1" ) { ?>
                <tr>
                  <td class="titR" >1.  Utilidad neta de la gesti&oacute;n</td>
                  <td align="center"  >
                  <input type="text" name="input-1"  onblur="javascript:saveUPD(1); return false;" id="input-1" value="<?php echo number_format($aGestion["rege_valor"]); ?>" size="20" class="inpB2 numeric" />
                  <span id="div_input-1" class="bxEr" style="display:none" >requerido</span>
                  </td>
                </tr>
                
                <?php } ?>
                
                <?php if( $aGestion["vinieta"] == "2" ) { ?>
                <tr>
                    <td width="40%" class="titR" >2.   P&eacute;rdida neta de la gesti&oacute;n</td>
                    <td align="center"  >
                    <input type="text" name="input-2"  onblur="javascript:saveUPD(1); return false;" id="input-2" value="<?php echo number_format($aGestion["rege_valor"]); ?>" size="20" class="inpB2 numeric" />
                    <span id="div_input-2" class="bxEr" style="display:none" >requerido</span>
                    </td>
                </tr>
                
                <?php } ?>
                
                <?php } ?>
                </tbody>
            </table>
          
            <span id="msg" style="display: none;" class="bxEr" >Debe registrar la utilidad o p&eacute;rdida de la gesti&oacute;n</span>
                     
           
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
