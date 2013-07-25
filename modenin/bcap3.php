<?php session_start(); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
?>
<?php include_once('../verifyLogin.php'); ?>
<?php include("header.php") ?>
<script type="text/javascript" src="js/bcap3.js"></script>

<?php
/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$sql = "SELECT * FROM  frm2_bcap3_responsocial WHERE reso_regi_uid = '".$regisroUID."' ";
$db->query( $sql );

if( $db->numrows() == 0 ) {

    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    $sql2 = "SELECT * FROM adm_definiciones WHERE defi_form_uid = '2' AND defi_modulo = 'b' AND defi_capitulo = '3' AND defi_swactive = 'ACTIVE' ";       
    $db2->query( $sql2 );
    while( $aDefinicion =  $db2->next_record() ) {
        $sql = "INSERT INTO  frm2_bcap3_responsocial SET ";
        $sql .= "reso_regi_uid = '".$regisroUID."', ";
        $sql .= "reso_defi_uid = '".$aDefinicion["defi_uid"]."', ";         
        $sql .= "reso_valor = '0', ";
        $sql .= "reso_description = '0', "; 
        $sql .= "reso_suv_uid = '".$uid_token."', "; 
        $sql .= "reso_createdate = NOW(), "; 
        $sql .= "reso_updatedate = NOW() ";                          	 	
        $db3->query( $sql );               
    }       
}

?>

<?php            
                
    $sql = " SELECT  frm2_bcap3_responsocial.*, adm_definiciones.defi_subcapitulo as subcap, adm_definiciones.defi_indent as indent, adm_definiciones.defi_vinieta as vinieta  "
          ." FROM  frm2_bcap3_responsocial LEFT JOIN adm_definiciones ON ( reso_defi_uid = defi_uid ) "
          ." WHERE reso_regi_uid = '".$regisroUID."' AND reso_defi_uid NOT IN (234, 235, 236 ) "
          ." ORDER BY CAST( adm_definiciones.defi_subcapitulo AS UNSIGNED ) ASC,	CAST( adm_definiciones.defi_indent AS UNSIGNED ) ASC,	CAST( adm_definiciones.defi_vinieta AS UNSIGNED ) ASC ";
    $db->query( $sql );
       
    // echo $sql;
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
        <th>CAP&Iacute;TULO 3</th>
        <th>RESPONSABILIDAD SOCIAL EMPRESARIAL</th>
    </tr>    
    </thead>    
    <tbody>
        <tr><td colspan="2"><?php echo OPERATOR::getDescTitles(2,'B',3,'0'); ?></td></tr>
    </tbody>
    </table>
    <form class="formA validable" action="bcap3Add.php" method="post" autocomplete="off" >
        <fieldset>
            
            <?php           
            while( $aAmb = $db->next_record() ) {
            ?>
            <?php  if( $aAmb["subcap"] == "1"  ) { ?>            
            <p>
                <span class="subT">1. ¿La empresa cuenta con una Pol&iacute;tica de Responsabilidad Social Empresarial?</span>
                <span class="clear"></span>
            </p>   
                                                                      
            <p>
                <input class="chk" type="checkbox" name="chk_1" id="chk_1" <?php if( $aAmb["reso_valor"] == 1 ) { echo "checked=\"checked\""; } ?> />
                <label class="labChk" >Si</label>
                <span class="clear"></span>

                <input class="chk" type="checkbox" name="chk_2" id="chk_2" <?php if( !checkEmpty($aAmb["reso_valor"]) && $aAmb["reso_valor"] == 0 ) { echo "checked=\"checked\""; } ?> />
                <label class="labChk" >No</label>
                <span class="clear"></span>
                
                <input class="chk" type="checkbox" name="chk_3" id="chk_3" <?php if( $aAmb["reso_valor"] == 2 ) { echo "checked=\"checked\""; } ?> />
                <label class="labChk" >En fase de desarrollo</label>
                                
            </p>            
            <span id="msg1" style="display: none;" class="bxEr">Debe seleccionar alguno de los &iacute;tems</span>                                                
            
            <?php } ?>
                            
                    
            <?php  if( $aAmb["subcap"] == "2"  ) { ?>                                               
            <p>
                <span class="subT">2. ¿Cuenta con personal permanente destinado al &aacute;rea de Responsabilidad Social Empresarial?</span>
                <span class="clear"></span>
            </p>            
            <p>
                <input class="chk" type="radio" name="rbtn_gastos" id="rbtn_inversion1" value="1" <?php if( $aAmb["reso_valor"] == 1 ) { echo "checked=\"checked\""; } ?>  />            
                <label class="labChk" >Si</label>
                <span class="clear"></span>

                <input class="chk" type="radio" name="rbtn_gastos" id="rbtn_inversion2" value="0" <?php if( !checkEmpty($aAmb["reso_valor"]) && $aAmb["reso_valor"] == 0  ) { echo "checked=\"checked\""; $mostrar1 = "style=\"display: none;\"";  } else { $mostrar1 = "style=\"display: block;\""; } ?> />                        
                <label class="labChk" >No</label>
            </p>
            
            <p id="areanumpersonas" <?php echo $mostrar1 ?> >
                <label class="labChk" >N&uacute;mero de personas</label>
                <input id="numpersonas" class="inpC numeric" maxlength="5" name="numpersonas" value="<?php echo number_format($aAmb["reso_description"]); ?>" size="30" type="text">
            </p>
            <span id="msg2" style="display: none;" class="bxEr">Debe introducir el numero de personas</span> 
            <?php } ?>
            
            
            <?php  if( $aAmb["subcap"] == "3"  ) { ?>                                               
            <p>
                <span class="subT">3. ¿Cu&aacute;nto asign&oacute; en la &uacute;ltima Gesti&oacute;n a Responsabilidad Social Empresarial?</span>
                <span class="clear"></span>
            </p>
            
            <p>
                <label class="labChk" >Bs/Anual</label>
                <input style="display: block;" id="txtasignacion" class="inpC numeric" name="txtasignacion" value="<?php echo number_format($aAmb["reso_description"]); ?>" size="30" type="text">
                
            </p>
            
            <?php } ?>
            
            <?php } ?>
                                              
            <span class="bxBt">
                <input type="submit" value="SIGUIENTE" id="sendData" name="continuarregistro" class="button" >
                <a href="bcap2.php" class="btnS">ANTERIOR</a>                
            </span>
                
        </fieldset>
    </form>
    <div class="clear"></div>      

</div>
<!-- end body -->

<?php include("footer.php") ?>