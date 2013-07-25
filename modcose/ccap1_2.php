<?php session_start(); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
?>
<?php include_once('../verifyLogin.php'); ?>
<?php include("header.php") ?>
<script type="text/javascript" src="js/ccap1.js"></script>
<?php
/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$sql = "SELECT * FROM frm1_ccap1_usoaccesotic WHERE usac_regi_uid = '".$regisroUID."' ";
$db->query( $sql );

if( $db->numrows() == 0 ) {

    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    $sql2 = "SELECT * FROM adm_definiciones WHERE defi_form_uid = '".$uidFormulario."' AND defi_modulo = 'c' AND  defi_capitulo = '1' AND defi_swactive = 'ACTIVE' ";       
    $db2->query( $sql2 );
    while( $aDefinicion =  $db2->next_record() ) {
        $sql = "INSERT INTO frm1_ccap1_usoaccesotic SET ";
        $sql .= "usac_regi_uid = '".$regisroUID."', ";
        $sql .= "usac_defi_uid = '".$aDefinicion["defi_uid"]."', ";         
        $sql .= "usac_description = '', "; 
        $sql .= "usac_suv_uid = '".$uid_token."', "; 
        $sql .= "usac_createdate = NOW(), "; 
        $sql .= "usac_updatedate = NOW() ";                          	 	
        $db3->query( $sql );              
    }        
}
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

    $sql = " SELECT frm1_ccap1_usoaccesotic.*, adm_definiciones.defi_vinieta as vinieta, adm_definiciones.defi_indent as indent "
          ." FROM frm1_ccap1_usoaccesotic LEFT JOIN  adm_definiciones ON ( usac_defi_uid = defi_uid ) "
          ." WHERE usac_regi_uid = '".$regisroUID."' ";
    $db->query( $sql );
    
    //echo $sql;
    $a_valor = "";
    $b_valor = "";
    $c_valor = "";
    
    $chk_inter = 0;
    $chk_intra = 0;
    
    while( $aTIC = $db->next_record() ) {
                
        if( $aTIC["indent"] == 1 && $aTIC["vinieta"] == "a" ) {
            $chk_inter = $aTIC["usac_valor"];                
        }
        
        if( $aTIC["indent"] == 1 && $aTIC["vinieta"] == "b" ) {
            $chk_intra = $aTIC["usac_valor"];                
        }
        
        if( $aTIC["indent"] == 1 && $aTIC["vinieta"] == "c" ) {
            $chk_nocuenta = $aTIC["usac_valor"];                
        }
        
        if( $aTIC["indent"] == 2 && $aTIC["vinieta"] == "1" ) {
            $txt_usapc = $aTIC["usac_description"];                
        }
        
        //utiliza internet
        if( $aTIC["indent"] == 3 && $aTIC["vinieta"] == "1" ) {
            $chk_usainter = $aTIC["usac_valor"];                        
        }
                        
        if( $aTIC["indent"] == 4 ) {               
            switch( $aTIC["vinieta"] ){
                case "a": $chk_4a = $aTIC["usac_valor"]; break;
                case "b": $chk_4b = $aTIC["usac_valor"]; break;
                case "c": $chk_4c = $aTIC["usac_valor"]; break;
                case "d": $chk_4d = $aTIC["usac_valor"]; break;
                case "e": $chk_4e = $aTIC["usac_valor"]; break;
                case "f": $chk_4f = $aTIC["usac_valor"]; break;
                case "g": $chk_4g = $aTIC["usac_valor"]; break;
            }
        }
        
        if( $aTIC["indent"] == 5 ) {               
            switch( $aTIC["vinieta"] ){
                case "a": $chk_5a = $aTIC["usac_valor"]; break;
                case "b": $chk_5b = $aTIC["usac_valor"]; break;
                case "c": $chk_5c = $aTIC["usac_valor"]; break;
                case "d": $chk_5d = $aTIC["usac_valor"]; break;
                case "e": $chk_5e = $aTIC["usac_valor"]; $txt_5e = $aTIC["usac_description"]; break;                
            }
        }                       
    }     
    
    $sql = " SELECT * FROM frm1_ccap1_2aplicaciones WHERE apli_regi_uid = '".$regisroUID."' ";
    $db2->query( $sql );
    
    while( $aAplic = $db2->next_record() ) {
        switch ( $aAplic["apli_position"] ) {
            case 1: 
            $chkA_1 = $aAplic["apli_valor"]; $nomapli_1 = $aAplic["apli_nombre"];
            $cantNal_1 = $aAplic["apli_cantidadnacional"]; $cantImport_1 = $aAplic["apli_cantidadimportado"];
            $canttot_1 = $aAplic["apli_total"];            	
            break;
            case 2: 
            $chkA_2 = $aAplic["apli_valor"]; $nomapli_2 = $aAplic["apli_nombre"];
            $cantNal_2 = $aAplic["apli_cantidadnacional"]; $cantImport_2 = $aAplic["apli_cantidadimportado"];
            $canttot_2 = $aAplic["apli_total"];            	
            break;
            case 3: 
            $chkA_3 = $aAplic["apli_valor"]; $nomapli_3 = $aAplic["apli_nombre"];
            $cantNal_3 = $aAplic["apli_cantidadnacional"]; $cantImport_3 = $aAplic["apli_cantidadimportado"];
            $canttot_3 = $aAplic["apli_total"];            	
            break;
            case 4: 
            $chkA_4 = $aAplic["apli_valor"]; $nomapli_4 = $aAplic["apli_nombre"];
            $cantNal_4 = $aAplic["apli_cantidadnacional"]; $cantImport_4 = $aAplic["apli_cantidadimportado"];
            $canttot_4 = $aAplic["apli_total"];            	
            break;
            case 5: 
            $chkA_5 = $aAplic["apli_valor"]; $nomapli_5 = $aAplic["apli_nombre"];
            $cantNal_5 = $aAplic["apli_cantidadnacional"]; $cantImport_5 = $aAplic["apli_cantidadimportado"];
            $canttot_5 = $aAplic["apli_total"];            	
            break;            
        }
    }
    
    
    
?>
<!-- begin body -->
<div class="content">
                
    <table class="dInf">

    <thead>
    <tr>
        <th>M&Oacute;DULO C</th>
        <th>USO Y ACCESO DE LAS TECNOLOG&Iacute;AS DE LA INFORMACI&Oacute;N Y COMUNICACI&Oacute;N (TIC)</th>
    </tr>
    </thead>   

    </table>
    
<form class="formA validable" action="ccap1Add.php" method="post" autocomplete="off" >
<fieldset>
    <p>
        <span class="subT">1. La empresa cuenta con:&nbsp;&nbsp;&nbsp;</span>
        <span class="clear"></span>
        <input class="chk" type="checkbox" name="internet" id="internet" <?php if( $chk_inter == 1 ) { echo "checked=\"checked\""; } ?> />        
        <label class="labChk" >Internet</label>
        <span class="clear"></span>
        
        <input class="chk" type="checkbox" name="intranet" id="intranet" <?php if( $chk_intra == 1 ) { echo "checked=\"checked\""; } ?> />
        <label class="labChk" >Intranet</label>
        <span class="clear"></span>
               
    </p>
    
    <p>
        <span class="subT">2. &iquest;Cu&aacute;ntas personas utilizan un computador en su rutina de trabajo?</span>
        <span class="clear"></span>
        <input type="text" name="uso_pc" id="uso_pc" value="<?php echo $txt_usapc; ?>" class="numeric inpC" />
    </p>
    
    <p>
        <span class="subT">3. &iquest;La empresa utiliza internet para el desarrollo de sus actividades comerciales?</span>
        <span class="clear"></span>
        
        <input class="chk"  type="radio" name="rbtn_usointer" id="rbtn_usointer1" value="1" <?php if( $chk_usainter == 1 ) { echo "checked=\"checked\""; } ?> />
        <label class="labChk" >Si</label>
        <span class="clear"></span>
        
        <input class="chk"  type="radio" name="rbtn_usointer" id="rbtn_usointer2" value="0" <?php if( !checkEmpty($chk_usainter) && $chk_usainter == 0  ) { echo "checked=\"checked\""; $mostrar1 = "style=\"display: none;\"";  } else { $mostrar1 = "style=\"display: block;\""; } ?> />
        <label class="labChk" >No</label>
    </p>

    <span id="opcionesinter" <?php echo $mostrar1;  ?> >
    <span class="subT"></span>
    
    
    <p>
        <span class="subT">4. &iquest;Para cu&aacute;l de las siguientes actividades?</span>
        <span class="clear"></span>
        
        <input class="chk" type="checkbox" name="activity_1" id="activity_1" <?php if( $chk_4a == 1 ) { echo "checked=\"checked\""; } ?> />
        <label class="labChkB" >a)   Realizar operaciones bancarias o acceder a otros servicios financieros</label>
        <span class="clear"></span>
        
        <input class="chk" type="checkbox" name="activity_2" id="activity_2" <?php if( $chk_4b == 1 ) { echo "checked=\"checked\""; } ?> />
        <label class="labChkB" >b)   Recibir &oacute; realizar pedidos de bienes o servicios</label>
        <span class="clear"></span>
                    
        <input class="chk" type="checkbox" name="activity_3" id="activity_3" <?php if( $chk_4c == 1 ) { echo "checked=\"checked\""; } ?> />
        <label class="labChkB" >c)   Realizar compra/venta de bienes o servicios (niveles transaccionales de comercio electr&oacute;nico)</label>
        <span class="clear"></span>
   
        <input class="chk" type="checkbox" name="activity_4" id="activity_4" <?php if( $chk_4d == 1 ) { echo "checked=\"checked\""; } ?> />
        <label class="labChkB" >d)   Realizar publicidad de bienes o servicios</label>
        <span class="clear"></span>
    
        <input class="chk" type="checkbox" name="activity_5" id="activity_5" <?php if( $chk_4e == 1 ) { echo "checked=\"checked\""; } ?> />
        <label class="labChkB" >e)   Proporcionar otros servicios a los clientes</label>
        <span class="clear"></span>
        
        <input class="chk" type="checkbox" name="activity_6" id="activity_6" <?php if( $chk_4f == 1 ) { echo "checked=\"checked\""; } ?> />
        <label class="labChkB" >f)    Enviar o recibir correo electr&oacute;nico</label>
        <span class="clear"></span>
        
        <input class="chk" type="checkbox" name="activity_7" id="activity_7" <?php if( $chk_4g == 1 ) { echo "checked=\"checked\""; } ?> />
        <label class="labChkB" >g)   Otras b&uacute;squedas de informaci&oacute;n</label>
        <span class="clear"></span>    
    </p>
    <span id="msgacti" class="bxEr" style="display:none" >Debe seleccionar un item para el punto 4</span>
    <p>
        <span class="subT">5. &iquest;Cu&aacute;l es el tipo de conexi&oacute;n a Internet utilizado?</span>
        <span class="clear"></span>
        
        <input class="chk" type="checkbox" name="coninter_1" id="coninter_1" <?php if( $chk_5a == 1 ) { echo "checked=\"checked\""; } ?>  />
        <label class="labChkB" >a)  Modem empresas telefonicas</label>
        <span class="clear"></span>
        
        <input class="chk"  type="checkbox" name="coninter_2" id="coninter_2" <?php if( $chk_5b == 1 ) { echo "checked=\"checked\""; } ?>  />
        <label class="labChkB" >b)  Conexi&oacute;n ADSL, RDSI (ISDN)</label>
        <span class="clear"></span>
        
        <input class="chk"  type="checkbox" name="coninter_3" id="coninter_3" <?php if( $chk_5c == 1 ) { echo "checked=\"checked\""; } ?>  />
        <label class="labChkB" >c)  L&iacute;nea dedicada (Cable/fibra &oacute;ptica)</label>
        <span class="clear"></span>
        
        <input class="chk" type="checkbox" name="coninter_4" id="coninter_4" <?php if( $chk_5d == 1 ) { echo "checked=\"checked\""; } ?>  />
        <label class="labChkB" >d) Redes inalambricas WiFi, WiMax, etc.</label>
        <span class="clear"></span>
        
        <input class="chk" type="checkbox" name="coninter_5" id="coninter_5" <?php if( $chk_5e == 1 ) { echo "checked=\"checked\""; } ?>  />
        <label class="labChkB" >e) Otros (especificar)</label>        
        
        <?php if( $chk_5e == 1 ) { $mostrar2 = "style=\"display:block;\"";  } else { $mostrar2 = "style=\"display:none;\""; }?>
        <input class="inpC" name="coninter_otro" type="text" id="coninter_otro" size="60" <?php echo $mostrar2; ?> value="<?php echo $txt_5e; ?>"  />              
    </p>
    <span id="msgcon" class="bxEr" style="display:none" >Debe seleccionar un item para el punto 5</span>
    <span id="msgotro" class="bxEr" style="display: none;">Debe introducir el dato para el &iacute;tem seleccionado </span>   

</span>

<span class="subT">6. La empresa utiliza alg&uacute;n(os) programa(s) o paquete(s) de software para realizar:</span>
<table width="100%"  class="fOpt" >
  <thead>
  <tr>
    <th width="23%">&nbsp;</th>
    
    <th width="23%">NOMBRE DEL SOFTWARE (PROGRAMA)</th>
    <th width="18%" align="center">Cantidad de software de origen Nacional</th>
    <th width="17%" align="center">Cantidad de software de origen Importado</th>
    <th width="9%" align="center">Total</th>
  </tr>
  </thead>
  <tbody>
  <tr>       
            
    <td class="titR" ><input type="checkbox" name="prog_1" id="prog_1" <?php if( $chkA_1 == 1 ) { echo "checked=\"checked\""; } ?> />
      a) Gesti&oacute;n contable</td>
   
    <td align="center">
      <input name="nomprog_1" type="text" id="nomprog_1" size="30" value="<?php echo $nomapli_1; ?>" class="inpC2" /><span id="div_nomprog_1" class="bxEr" style="display:none" >requerido</span></td>
    <td align="center">      <input name="inputA-1" type="text" id="inputA-1" size="8" value="<?php echo number_format($cantNal_1); ?>" class="numeric inpB2" /><span id="div_inputA-1" class="bxEr" style="display:none" >requerido</span></td>
    <td align="center"><input name="inputB-1" type="text" id="inputB-1" size="8" value="<?php echo number_format($cantImport_1); ?>" class="numeric inpB2" /><span id="div_inputB-1" class="bxEr" style="display:none" >requerido</span></td>
    <td align="right"><span id="tot_1" class="labB"><?php echo number_format($canttot_1); ?></span></td>
  </tr>
  <tr>
    <td class="titR"><input type="checkbox" name="prog_2" id="prog_2" <?php if( $chkA_2 == 1 ) { echo "checked=\"checked\""; } ?>  />
      b) Gesti&oacute;n y control de personal</td>
    
    <td align="center"><input name="nomprog_2" type="text" id="nomprog_2" size="30" value="<?php echo $nomapli_2; ?>" class="inpC2" /><span id="div_nomprog_2" class="bxEr" style="display:none" >requerido</span></td>
    <td align="center"><input name="inputA-2" type="text" id="inputA-2" size="8" value="<?php echo number_format($cantNal_2); ?>" class="numeric inpB2" /><span id="div_inputA-2" class="bxEr" style="display:none" >requerido</span></td>
    <td align="center"><input name="inputB-2" type="text" id="inputB-2" size="8" value="<?php echo number_format($cantImport_2); ?>" class="numeric inpB2" /><span id="div_inputB-2" class="bxEr" style="display:none" >requerido</span></td>
    <td align="right"><span id="tot_2" class="labB"><?php echo number_format($canttot_2); ?></span></td>
  </tr>
  <tr>
    <td class="titR"><input type="checkbox" name="prog_3" id="prog_3" <?php if( $chkA_3 == 1 ) { echo "checked=\"checked\""; } ?> />
      c) Manejo de inventarios</td>
    
    <td align="center"><input name="nomprog_3" type="text" id="nomprog_3" size="30" value="<?php echo $nomapli_3; ?>" class="inpC2" /><span id="div_nomprog_3" class="bxEr" style="display:none" >requerido</span></td>
    <td align="center"><input name="inputA-3" type="text" id="inputA-3" size="8" value="<?php echo number_format($cantNal_3); ?>" class="numeric inpB2" /><span id="div_inputA-3" class="bxEr" style="display:none" >requerido</span></td>
    <td align="center"><input name="inputB-3" type="text" id="inputB-3" size="8" value="<?php echo number_format($cantImport_3); ?>" class="numeric inpB2" /><span id="div_inputB-3" class="bxEr" style="display:none" >requerido</span></td>
    <td align="right"><span id="tot_3" class="labB"><?php echo number_format($canttot_3); ?></span></td>
  </tr>
  <tr>
    <td class="titR"><input type="checkbox" name="prog_4" id="prog_4" <?php if( $chkA_4 == 1 ) { echo "checked=\"checked\""; } ?> />
      d) Ventas</td>
    
    <td align="center"><input name="nomprog_4" type="text" id="nomprog_4" size="30" value="<?php echo $nomapli_4; ?>" class="inpC2" /><span id="div_nomprog_4" class="bxEr" style="display:none" >requerido</span></td>
    <td align="center"><input name="inputA-4" type="text" id="inputA-4" size="8" value="<?php echo number_format($cantNal_4); ?>" class="numeric inpB2" /><span id="div_inputA-4" class="bxEr" style="display:none" >requerido</span></td>
    <td align="center"><input name="inputB-4" type="text" id="inputB-4" size="8" value="<?php echo number_format($cantImport_4); ?>" class="numeric inpB2" /><span id="div_inputB-4" class="bxEr" style="display:none" >requerido</span></td>
    <td align="right"><span id="tot_4" class="labB"><?php echo number_format($canttot_4); ?></span></td>
  </tr>
  <tr>
    <td class="titR"><input type="checkbox" name="prog_5" id="prog_5" <?php if( $chkA_5 == 1 ) { echo "checked=\"checked\""; } ?> />
      e) Otros</td>
    
    <td align="center"><input name="nomprog_5" type="text" id="nomprog_5" size="30" value="<?php echo $nomapli_5; ?>" class="inpC2" /><span id="div_nomprog_5" class="bxEr" style="display:none" >requerido</span></td>
    <td align="center"><input name="inputA-5" type="text" id="inputA-5" size="8" value="<?php echo number_format($cantNal_5); ?>" class="numeric inpB2" /><span id="div_inputA-5" class="bxEr" style="display:none" >requerido</span></td>
    <td align="center"><input name="inputB-5" type="text" id="inputB-5" size="8" value="<?php echo number_format($cantImport_5); ?>" class="numeric inpB2" /><span id="div_inputB-5" class="bxEr" style="display:none" >requerido</span></td>
    <td align="right"><span id="tot_5" class="labB"><?php echo number_format($canttot_5); ?></span></td>
  </tr>
  </tbody>
  </table>

  <span id="msg3" class="bxEr" style="display: none;" >Debe registrar los datos requeridos para el item seleccionado</span>

<!--
<p>NOMBRE Y FIRMA DEL REPRESENTANTE LEGAL DE LA EMPRESA </p>
<p>Nombre Representante Legal</p>
<p>
  <label for="representante"></label>
  <input name="representante" type="text" id="representante" size="60" />
</p>
<p>FUNDEMPRESA</p>
<p>Nombre Verificador FUNDEMPRESA</p>
<p>
  <input name="verificador" type="text" id="verificador" size="60" />
</p>
-->                              
            <span class="bxBt">
                <input type="submit" value="SIGUIENTE" id="sendData" name="continuarregistro" class="button" >
                <a href="bcap3.php" class="btnS">ANTERIOR</a>                
            </span>

        </fieldset>
  </form>
    <div class="clear"></div>      

</div>
<!-- end body -->        

<?php include("footer.php") ?>
