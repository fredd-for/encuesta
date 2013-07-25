<?php session_start(); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php'); ?>
<?php include("header.php") ?>
<script type="text/javascript" src="js/acap2c.js"></script>
<?php 
/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

//crear registros para sueldos
$sql = "SELECT * FROM cap2_presta_sociales WHERE prso_regi_uid = '".$regisroUID."' ";
$db->query( $sql );
if( $db->numrows() == 0 ) {
    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    $sql2 = "SELECT * FROM adm_definiciones WHERE defi_form_uid = '".$uidFormulario."'  AND defi_modulo = 'a' AND  defi_capitulo = '2' AND defi_subcapitulo = '3' AND defi_swactive = 'ACTIVE'";
    $db2->query( $sql2 );
    while( $aDefinicion =  $db2->next_record() ) {        
        $sql = "INSERT INTO cap2_presta_sociales SET ";
        $sql .= "prso_regi_uid  = '".$regisroUID."', ";
        $sql .= "prso_defi_uid 	 = '".$aDefinicion["defi_uid"]."', ";
        $sql .= "prso_valor = 0, ";
        $sql .= "prso_descripcion = '', "; 
        $sql .= "prso_suv_uid = '".$uid_token."', "; 
        $sql .= "prso_date_create = NOW(), "; 
        $sql .= "prso_date_update = NOW() ";                          	 	
        $db3->query( $sql );
    }
}
$sql = " SELECT cap2_presta_sociales.*, adm_definiciones.defi_indent as indent "
      ." FROM cap2_presta_sociales LEFT JOIN  adm_definiciones ON ( prso_defi_uid	 = defi_uid ) "
      ." WHERE prso_regi_uid = '".$regisroUID."' ORDER BY adm_definiciones.defi_indent ASC ";
$db->query( $sql );
//echo $sql;
?>

<!-- begin body -->
<div class="content">
    <span id="statusACAP1"></span>    
    
    <table class="dInf">
    <thead>
    <tr>
        <th>Cap&iacute;tulo 2</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
        <tr>                        
            <td colspan="2"><?php echo OPERATOR::getDescTitles(3,'A',2,3); ?></td>
        </tr>
    </tbody>
    </table>        
    
    <form class="formA validable" action="acap2cAdd.php" method="post" autocomplete="off" >
      <fieldset>
            <span class="subT">2.3 Prestaciones sociales</span>
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
                
                <?php if( $aSueldos["indent"] == '1' ) { ?>
                <tr>
                    <td width="71%" class="titR" >1. Aporte Patronal al Seguro de Salud (público o privado)</td>
                    <td width="29%" align="right" ><input type="text" name="A1" id="A1" value="<?php echo number_format($aSueldos["prso_valor"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                  </tr>                
                <?php } ?>
                
                <?php if( $aSueldos["indent"] == '2'  ) { ?>
                <tr>
                  <td class="titR" >2. Aporte Patronal a las AFP's</td>
                  <td align="right"><input type="text" name="A2" id="A2" value="<?php echo number_format($aSueldos["prso_valor"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                </tr>
                <?php } ?>
                
                <?php if( $aSueldos["indent"] == '3' ) { ?>
                <tr>
                  <td class="titR" >3. Otros aportes  patronales (especificar)</td>
                  <td align="right"><input type="text" name="A3" id="A3" value="<?php echo number_format($aSueldos["prso_valor"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                </tr>
                <?php
                $show1 = "style=\"display: none;\"";
                if( $aSueldos["prso_valor"] > 0 ) {
                    $show1 = "style=\"display: table-row\"";
                }
                ?>
                <tr id="otrosdetalle" <?php echo $show1 ?> >
                    <td class="titR" ><input type="text" name="A7" id="A7" value="<?php echo $aSueldos["prso_descripcion"]; ?>" size="60" class="inpC2" /></td>
                    <td align="right"></td>
                </tr>
                <?php } ?>
                
                <?php if( $aSueldos["indent"] == '4') { ?>
                <tr>
                    <td class="titR" >4. TOTAL</td>
                    <td align="right"><label class="labB" id="perH"><?php echo number_format($aSueldos["prso_valor"]) ?></label></td>
                </tr>
                <?php } ?>
                                              
                <?php } ?>
                </tbody>
            </table>
            <p>
                <span id="msg" style="display: none;" class="bxEr" >Debe registrar valor(es) en este formulario</span>
                <span id="txtotros" style="display:none" class="bxEr" >Debe especificar el detalle para otros aportes patronales</span>
            </p>                                      
            
            <span class="bxBt">
            <input type="submit" value="SIGUIENTE" id="sendData" name="continuarregistro" class="button" >
            <a href="acap2b.php" class="btnS">ANTERIOR</a>                
            </span>

        </fieldset>
  </form>
    <div class="clear"></div>      

</div>
<!-- end body -->

<?php include("footer.php") ?>