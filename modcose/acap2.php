<?php session_start(); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
?>
<?php include_once('../verifyLogin.php'); ?>
<?php include("header.php") ?>
<script type="text/javascript" src="js/acap2.js"></script>
<?php 

/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

//crear registros para sueldos
$sql = "SELECT * FROM cap2_personalsueldos WHERE pesu_regi_uid = '".$regisroUID."' ";
$db->query( $sql );
if( $db->numrows() == 0 ) {
    // obtener el uid del token
    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    $sql2 = "SELECT * FROM adm_definiciones WHERE defi_form_uid = '".$uidFormulario."'  AND defi_modulo = 'a' AND  defi_capitulo = '2' AND defi_vinieta BETWEEN '1' AND '5' ";
    $db2->query( $sql2 );
    while( $aDefinicion =  $db2->next_record() ) {        
        $sql = "INSERT INTO cap2_personalsueldos SET ";
        $sql .= "pesu_regi_uid  = '".$regisroUID."', ";
        $sql .= "pesu_defi_uid 	 = '".$aDefinicion["defi_uid"]."', ";
        $sql .= "pesu_numero_hombres = 0, ";
        $sql .= "pesu_numero_mujeres = 0, ";
        $sql .= "pesu_sueldos_salarios = 0, "; 
        $sql .= "pesu_suv_uid = '".$uid_token."', "; 
        $sql .= "pesu_date_create = NOW(), "; 
        $sql .= "pesu_date_update = NOW() ";                          	 	
        $db3->query( $sql );
    }
}

//Tipo de personal
$db->query( "SELECT * FROM cap2_personalsueldos WHERE pesu_regi_uid = '".$regisroUID."' AND pesu_defi_uid = '1' " );
$aPermanente = $db->next_record();

$db->query("SELECT * FROM cap2_personalsueldos WHERE pesu_regi_uid = '".$regisroUID."' AND pesu_defi_uid = '2' ");
$aEventual = $db->next_record();

$db->query( "SELECT * FROM cap2_personalsueldos WHERE pesu_regi_uid = '".$regisroUID."' AND pesu_defi_uid = '3' ");
$aPTotal = $db->next_record();

$db->query( "SELECT * FROM cap2_personalsueldos WHERE pesu_regi_uid = '".$regisroUID."' AND pesu_defi_uid = '4' ");
$aApoyo = $db->next_record();

$db->query( "SELECT * FROM cap2_personalsueldos WHERE pesu_regi_uid = '".$regisroUID."' AND pesu_defi_uid = '5' ");
$aTotalGen = $db->next_record();
?>

<!-- begin body -->
<div class="content">
    <span id="statusACAP1"></span>
    <span class="subT" >
    A partir de este cap&iacute;tulo llene la informaci&oacute;n correspondiente a la gesti&oacute;n 2012. (Coloque los valores sin centavos)    
    </span>
    
    <table class="dInf">
    <thead>
    <tr>
        <th>Cap&iacute;tulo 2</th>
        <th>PERSONAL OCUPADO, SUELDOS Y SALARIOS</th>
    </tr>
    </thead>
    <tbody>
        <tr>                        
            <td colspan="2"><?php echo OPERATOR::getDescTitles(1,'A',2,0); ?></td>
        </tr>
    </tbody>
    </table>        
    
                         
    <form class="formA validable" action="acap2Add.php" method="post" autocomplete="off" >
      <fieldset>                                                            
            <table width="100%" class="fOpt" >
                <thead>
                <tr>
                    <th align="center">Personal Ocupado</th>
                    <th colspan="2" align="center" >N&uacute;mero de personas (Anual)</th>                    
                    <th align="center">Sueldos y salarios de la gesti&oacute;n (Bs/Anual)</th>
                </tr>                
                </thead>
                                                
                <tbody>
                <tr>
                    <td align="center" class="titR" >&nbsp;</td>
                    <td align="center" class="titR">Hombres</td>
                    <td align="center" class="titR">Mujeres</td>
                    <td align="center" class="titR">&nbsp;</td>
                </tr>
                <tr>
                    <td width="40%" class="titR" >1. Personal permanente</td>
                    <td width="20%" align="right" >
                        <input type="text" name="pepermanenteH" id="pepermanenteH" value="<?php echo $aPermanente["pesu_numero_hombres"] ?>" size="20" maxlength="5" class="inpB2 numeric required" />
                        <span id="div_pepermanenteH" class="bxEr" style="display:none" >requerido</span>
                        <span id="div_pepermanenteH_2" class="bxEr" style="display:none" >inválido</span>
                    </td>
                    <td width="20%" align="right" >
                      <input type="text" name="pepermanenteM" id="pepermanenteM" value="<?php echo $aPermanente["pesu_numero_mujeres"] ?>" size="20" maxlength="5" class="inpB2 numeric required" />
                      <span id="div_pepermanenteM" class="bxEr" style="display:none" >requerido</span>
                      <span id="div_pepermanenteM_2" class="bxEr" style="display:none" >inválido</span>
                    </td>
                    <td width="20%" align="right" >
                      <input type="text" name="pepermanente" onblur="javascript:saveUPD(1); return false;" id="pepermanente" value="<?php echo $aPermanente["pesu_sueldos_salarios"] ?>" size="20" class="inpB2 numeric required" />
                      <span id="div_pepermanente" class="bxEr" style="display:none" >requerido</span>
                      <span id="div_pepermanente_2" class="bxEr" style="display:none" >inválido</span>
                    </td>
                </tr>
                <tr>
                    <td class="titR" >2. Personal eventual</td>
                    <td align="right"><input type="text" name="peventualH" id="peventualH" value="<?php echo $aEventual["pesu_numero_hombres"] ?>" maxlength="5" size="20" class="inpB2 numeric required">
                        <span id="div_peventualH" class="bxEr" style="display:none" >requerido</span>
                        <span id="div_peventualH_2" class="bxEr" style="display:none" >inválido</span>
                    </td>
                    <td align="right"><input type="text" name="peventualM" id="peventualM" value="<?php echo $aEventual["pesu_numero_mujeres"] ?>" maxlength="5" size="20" class="inpB2 numeric required">
                        <span id="div_peventualM" class="bxEr" style="display:none" >requerido</span>
                        <span id="div_peventualM_2" class="bxEr" style="display:none" >inválido</span>
                    </td>
                    <td align="right"><input type="text" name="peventual" id="peventual" onblur="javascript:saveUPD(2); return false;" value="<?php echo $aEventual["pesu_sueldos_salarios"] ?>" size="20" class="inpB2 numeric required">
                        <span id="div_peventual" class="bxEr" style="display:none" >requerido</span>
                        <span id="div_peventual_2" class="bxEr" style="display:none" >inválido</span>
                    </td>
                </tr>
                <tr>
                    <td class="titR" >3. TOTAL</td>
                    <td align="right"><label class="labB" id="perH"><?php echo number_format($aPTotal["pesu_numero_hombres"]) ?></label><input type="hidden" name="totperH" id="totperH" value="<?php echo $aPTotal["pesu_numero_hombres"] ?>"  ></td>
                    <td align="right"><label class="labB" id="perM"><?php echo number_format($aPTotal["pesu_numero_mujeres"]) ?></label><input type="hidden" name="totperM" id="totperM" value="<?php echo $aPTotal["pesu_numero_mujeres"] ?>"   ></td>
                    <td align="right"><label class="labB" id="perHM"><?php echo number_format($aPTotal["pesu_sueldos_salarios"]) ?></label><input type="hidden" name="totperHM" id="totperHM" value="<?php echo $aPTotal["pesu_sueldos_salarios"] ?>"  ></td>
                </tr>
                <tr>
                    <td class="titR" >4. Personas de apoyo (Propietarios, familiares y miembros del directorio)</td>
                    <td align="right"><input type="text" name="nopagH" id="nopagH" value="<?php echo $aApoyo["pesu_numero_hombres"] ?>" size="20" class="inpB2 numeric required" >
                                    <span id="div_nopagH" class="bxEr" style="display:none" >requerido</span>
                                    <span id="div_nopagH_2" class="bxEr" style="display:none" >inválido</span>
                    </td>
                    <td align="right"><input type="text" name="nopagM" id="nopagM" value="<?php echo $aApoyo["pesu_numero_mujeres"] ?>" size="20" class="inpB2 numeric required">
                                    <span id="div_nopagM" class="bxEr" style="display:none" >requerido</span>
                                    <span id="div_nopagM_2" class="bxEr" style="display:none" >inválido</span>
                    </td>
                    <td align="right"></td>
                </tr>       
                </tbody>
            </table>
            <p>
                <span id="msg" style="display: none;" class="bxEr" >Para que exista una empresa, debe haber por lo menos una persona</span>
                <span id="msg2" style="display: none;" class="bxEr" >El personal permanente sumado al personal eventual no debe sobrepasar los 5.000 personas</span>
                <span id="msg3" style="display: none;" class="bxEr" >Debe introducir el salario para el personal</span>
                <span id="msg4" style="display: none;" class="bxEr" >Debe introducir el numero de personas para el salario especificado.</span>
            </p>                                      
            
            <span class="bxBt">
            <input type="submit" value="SIGUIENTE" id="sendData" name="continuarregistro" class="button" >
            <a href="acap1.php" class="btnS">ANTERIOR</a>                
            </span>

        </fieldset>
  </form>
    <div class="clear"></div>      

</div>
<!-- end body -->

<?php include("footer.php") ?>
