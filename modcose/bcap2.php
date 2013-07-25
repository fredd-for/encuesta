<?php session_start(); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
?>
<?php include_once('../verifyLogin.php'); ?>
<?php include("header.php") ?>
<script type="text/javascript" src="js/bcap2.js"></script>
<?php
/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$sql = "SELECT * FROM frm1_bcap2_gestioncertificados WHERE gece_regi_uid = '".$regisroUID."' ";
$db->query( $sql );

if( $db->numrows() == 0 ) {

    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    $sql2 = "SELECT * FROM adm_definiciones WHERE defi_form_uid = '".$uidFormulario."' AND defi_modulo = 'b' AND  defi_capitulo = '2' AND defi_swactive = 'ACTIVE' ";       
    $db2->query( $sql2 );
    while( $aDefinicion =  $db2->next_record() ) {
        $sql = "INSERT INTO frm1_bcap2_gestioncertificados SET ";
        $sql .= "gece_regi_uid = '".$regisroUID."', ";
        $sql .= "gece_defi_uid = '".$aDefinicion["defi_uid"]."', ";         
        $sql .= "gece_description = '', "; 
        $sql .= "gece_suv_uid = '".$uid_token."', "; 
        $sql .= "gece_createdate = NOW(), "; 
        $sql .= "gece_updatedate = NOW() ";                          	 	
        $db3->query( $sql );               
    }        
}
?>
<?php
    $sql = " SELECT frm1_bcap2_gestioncertificados.*, adm_definiciones.defi_vinieta as vinieta, adm_definiciones.defi_indent as indent "
          ." FROM frm1_bcap2_gestioncertificados LEFT JOIN  adm_definiciones ON ( gece_defi_uid = defi_uid ) "
          ." WHERE gece_regi_uid = '".$regisroUID."' AND gece_defi_uid IN (69, 70, 71)  "
          ." ORDER BY adm_definiciones.defi_indent ASC,  adm_definiciones.defi_vinieta ASC ";
    $db->query( $sql );
    
    //echo $sql;
    $a_valor = "";
    $b_valor = "";
    $c_valor = "";
    while( $aCert = $db->next_record() ) { 
        if( $aCert["vinieta"] == "a" ) {
            $a_valor = $aCert["gece_valor"];                
        }

        if( $aCert["vinieta"] == "b" ) {
            $b_valor = $aCert["gece_valor"];
        }

        if( $aCert["vinieta"] == "c" ) {
            $c_valor = $aCert["gece_valor"];
            $c_descrip = $aCert["gece_description"];
        }
    }
    
    $sql = " SELECT frm1_bcap2_gestioncertificados.*, adm_definiciones.defi_vinieta as vinieta, adm_definiciones.defi_indent as indent "
          ." FROM frm1_bcap2_gestioncertificados LEFT JOIN  adm_definiciones ON ( gece_defi_uid = defi_uid ) "
          ." WHERE gece_regi_uid = '".$regisroUID."' AND gece_defi_uid IN (68, 72)  "
          ." ORDER BY adm_definiciones.defi_indent ASC,  adm_definiciones.defi_vinieta ASC ";
    $db->query( $sql );
    while( $aCert = $db->next_record() ) {
        if( $aCert["vinieta"] == "1" ) {
            $d_valor = $aCert["gece_valor"];
            $d_descrip = $aCert["gece_description"]; 
        }
        if( $aCert["vinieta"] == "3" ) {
            $e_valor = $aCert["gece_valor"];
            $e_descrip = $aCert["gece_description"];
        }
    }
    
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
    <table class="dInf">
    <thead>
    <tr>
        <th>Cap&iacute;tulo 2</th>
        <th>SISTEMAS DE GESTI&Oacute;N CERTIFICADOS</th>
    </tr>
    </thead>
    <tbody>
        <tr>                        
            <td colspan="2"><?php echo OPERATOR::getDescTitles(1,'B',2,0); ?></td>
        </tr>
    </tbody>
    </table>
 
    <form class="formA validable" action="bcap2Add.php" method="post" autocomplete="off" >
      <fieldset>
          <p>       
                <span class="subT">1. ¿La empresa tiene actualmente un Sistema de Gestión Certificado?</span>
                <span class="clear"></span>
                
                <input class="chk" type="radio" name="rbtn_inversion" id="rbtn_inversion1" value="1" <?php if( $d_valor == 1 ) { echo "checked=\"checked\""; } ?> />            
                <label class="labChk" >Si</label>
                <span class="clear"></span>
                
                <input class="chk" type="radio" name="rbtn_inversion" id="rbtn_inversion2" value="0" <?php if( !checkEmpty($d_valor) && $d_valor == 0  ) { echo "checked=\"checked\""; $mostrar1 = "style=\"display: block;\"";  } else { $mostrar1 = "style=\"display: none;\""; } ?> />
                <label class="labChk" >No</label>
          </p>
          <span id="noopcion" <?php echo $mostrar1; ?> >
          <p>Marque una de las opciones y pase a la pregunta 2</p>
          <p>
              <input class="chk" type="checkbox" name="chk_1" id="chk_1" <?php if( $a_valor == 1 ) { echo "checked=\"checked\""; } ?> />
              <label class="labChk" > a) Falta de conocimiento</label>
              <span class="clear"></span>
              
              <input class="chk" type="checkbox" name="chk_2" id="chk_2" <?php if( $b_valor == 1 ) { echo "checked=\"checked\""; } ?> />
              <label class="labChk" >b) Falta de presupuesto</label>
              <span class="clear"></span>
              
              <input class="chk" type="checkbox" name="chk_3" id="chk_3" <?php if( $c_valor == 1 ) { echo "checked=\"checked\""; } ?> />
              <label class="labChk" > c) Otros (especificar)</label>
              <?php $mostrar2 = "style=\"display: none;\"";  if( $c_valor == 1 ) { $mostrar2 = "style=\"display: block;\"";  } ?>                  
              <input name="inversionotros" type="text" class="inpC" id="inversionotros" value="<?php echo $c_descrip; ?>" size="40" <?php echo $mostrar2;  ?> />                
          </p>          
          </span>
          <span id="msg1" style="display:none" class="bxEr" >Debe registrar una de las opciones</span>
          
          <span class="subT">2. Indique el nombre de la certificacion, el a&ntilde;o de obtenci&oacute;n y su vigencia:</span>
          <table width="100%" border="0" id="tablecertificacion" class="fOpt">
            <thead>
              <tr>
              <th width="40%" align="center">Certificaci&oacute;n</th>
              <th width="10%" align="center">&Uacute;ltimo a&ntilde;o de obtenci&oacute;n</th>
              <th width="40%" align="center">Organismo de certificaci&oacute;n</th>
              <th width="10%" align="center">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
            
            <?php 
            $sql3 = "SELECT * FROM frm1_bcap2_2certificados WHERE cert_regi_uid = '".$regisroUID."' AND cert_delete = 0 ORDER BY certi_position ASC  ";
            //echo $sql3;
            $db3->query( $sql3 );
            if( $db3->numrows() > 0 ) {
            while( $aCert2 = $db3->next_record() ) {
                $pos = $aCert2["certi_position"];
            ?>
            <tr id="row_<?php echo $pos; ?>" >
              <td align="center"><input name="inputA_<?php echo $pos ?>" type="text" id="inputA_<?php echo $pos ?>" size="30" value="<?php echo $aCert2["cert_certificacion"] ?>" class="inpC2" /></td>
              <td align="center"><input name="inputB_<?php echo $pos ?>" type="text" id="inputB_<?php echo $pos ?>" size="10" value="<?php echo $aCert2["cert_ultimoanioobtencion"] ?>" class="integer inpC2" maxlength="4"  /></td>
              <td align="center"><input name="inputC_<?php echo $pos ?>" type="text" id="inputC_<?php echo $pos ?>" size="30" value="<?php echo $aCert2["cert_organismocertificacion"] ?>" class="inpC2" /></td>
              <td align="center"><a href="#" class="lnkCls" id="delcerti_<?php echo $aCert2["certi_position"] ?>" onclick="delRow('<?php echo $pos ?>'); return false;" >eliminar</a></td>
            </tr>            
            <?php }                            
            } else { 
                $pos = 1;
            ?>
            <tr id="row_1" >
              <td align="center"><input name="inputA_1" type="text" id="inputA_1" size="30" class="inpC2"  /></td>
              <td align="center"><input name="inputB_1" type="text" id="inputB_1" size="10" class="integer inpC2" maxlength="4"  /></td>
              <td align="center"><input name="inputC_1" type="text" id="inputC_1" size="30" class="inpC2" /></td>
              <td align="center">&nbsp;</td>
            </tr>    
            <?php } ?>
            
            </tbody>            
            
          </table>
          <input type="hidden" name="maxrow" id="maxrow" value="<?php echo $pos; ?>" />
          <a href="#" id="addcertificacion" class="btnAdd"  >Agregar campos</a>
          
          <p>
              <span class="subT">3. &iquest;Sus productos y/o servicios cuentan con alg&uacute;n tipo de certificaci&oacute;n?</span>              
          </p>
          <p><?php echo OPERATOR::getDescTitles(1,'B',2,3); ?></p>
          
          
          <p>          
              <input class="chk"  type="radio" name="rbtn_certi" id="rbtn_certi1" value="1" <?php $mostrar4 = "style=\"display: none\""; if( $e_valor == 1 ) { echo "checked=\"checked\""; $mostrar4 = "style=\"display: block\""; } ?> />
              <label class="labChk" >Si</label>
              <span class="clear"></span>

              <input class="chk" type="radio" name="rbtn_certi" id="rbtn_certi2" value="0" <?php if( !checkEmpty($e_valor) && $e_valor == 0  ) { echo "checked=\"checked\""; } ?> />
              <label class="labChk" >No</label>
              <span class="clear"></span>
              
              <span id="siotrasambiental" <?php echo $mostrar4 ?> >
                  <label class="labChk" >¿Cu&aacute;les? </label>
                  <input name="certiambiental" type="text" id="certiambiental" size="60" value="<?php echo $e_descrip ?>" class="inpC" />
              </span>          
          </p>
          
          <span id="msg2" style="display:none" class="bxEr" >Debe registrar la descripci&oacute;n</span>
                              
          <span class="bxBt">
                <input type="submit" value="SIGUIENTE" id="sendData" name="continuarregistro" class="button" >
                <a href="bcap1.php" class="btnS">ANTERIOR</a>                
          </span>

        </fieldset>
  </form>
    <div class="clear"></div>      

</div>
<!-- end body -->                  

<?php include("footer.php") ?>
