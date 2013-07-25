<?php session_start(); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
?>
<?php include_once('../verifyLogin.php'); ?>
<?php include("header.php") ?>
<script type="text/javascript" src="js/bcap1.js"></script>

<?php
/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$sql = "SELECT * FROM frm1_bcap1_gestionambiental WHERE geam_regi_uid = '".$regisroUID."' ";
$db->query( $sql );

if( $db->numrows() == 0 ) {

    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    $sql2 = "SELECT * FROM adm_definiciones WHERE defi_form_uid = '".$uidFormulario."' AND defi_modulo = 'b' AND  defi_capitulo = '1' AND defi_swactive = 'ACTIVE' ";       
    $db2->query( $sql2 );
    while( $aDefinicion =  $db2->next_record() ) {
        $sql = "INSERT INTO frm1_bcap1_gestionambiental SET ";
        $sql .= "geam_regi_uid = '".$regisroUID."', ";
        $sql .= "geam_defi_uid = '".$aDefinicion["defi_uid"]."', ";         
        $sql .= "geam_description = '', "; 
        $sql .= "geam_suv_uid = '".$uid_token."', "; 
        $sql .= "geam_createdate = NOW(), "; 
        $sql .= "geam_updatedate = NOW() ";                          	 	
        $db3->query( $sql );               
    }        
}

?>

<?php            

    $sql = " SELECT frm1_bcap1_gestionambiental.*, adm_definiciones.defi_vinieta as vinieta, adm_definiciones.defi_indent as indent "
          ." FROM frm1_bcap1_gestionambiental LEFT JOIN  adm_definiciones ON ( geam_defi_uid = defi_uid ) "
          ." WHERE geam_regi_uid = '".$regisroUID."' AND geam_defi_uid IN (60, 61, 62)  "
          ." ORDER BY adm_definiciones.defi_indent ASC,  adm_definiciones.defi_vinieta ASC ";
    $db->query( $sql );
    
    //echo $sql;
    $a_valor = "";
    $b_valor = "";
    $c_valor = "";
    while( $aAmbiental = $db->next_record() ) { 
        if( $aAmbiental["vinieta"] == "a" ) {
            $a_valor = $aAmbiental["geam_valor"];                
        }

        if( $aAmbiental["vinieta"] == "b" ) {
            $b_valor = $aAmbiental["geam_valor"];
        }

        if( $aAmbiental["vinieta"] == "c" ) {
            $c_valor = $aAmbiental["geam_valor"];
            $c_descrip = $aAmbiental["geam_description"];
        }
    }
    
    $sql = " SELECT frm1_bcap1_gestionambiental.*, adm_definiciones.defi_vinieta as vinieta, adm_definiciones.defi_indent as indent "
          ." FROM frm1_bcap1_gestionambiental LEFT JOIN  adm_definiciones ON ( geam_defi_uid = defi_uid ) "
          ." WHERE geam_regi_uid = '".$regisroUID."'  "
          ." ORDER BY adm_definiciones.defi_indent ASC,  adm_definiciones.defi_vinieta ASC ";
    $db->query( $sql );
       
    
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
        <th> M&oacute;dulo B</th>
        <th> Encuesta de gesti&oacute;n integrada </th>
    </tr>
    </thead>    
    </table>
    
    <table class="dInf">
    <thead>
    <tr>
        <th> Cap&iacute;tulo 1</th>
        <th> GESTI&Oacute;N AMBIENTAL</th>
    </tr>
    </thead>    
    </table>
    

    <form class="formA validable" action="bcap1Add.php" method="post" autocomplete="off" >
        <fieldset>       
            <?php           
            while( $aAmbiental = $db->next_record() ) { 
               
            ?>
            <?php  if( $aAmbiental["vinieta"] == "1" ) { ?>
            
            <p>
            <span class="subT">1. &iquest;La Empresa realiza gastos o inversi&oacute;n en gesti&oacute;n ambiental?&nbsp;</span>
            <span class="clear"></span>
            
            <input class="chk" type="radio" name="rbtn_inversion" id="rbtn_inversion1" value="1" <?php if( $aAmbiental["geam_valor"] == 1 ) { echo "checked=\"checked\""; } ?>  />            
            <label class="labChk" >Si</label>
            <span class="clear"></span>
            
            <input class="chk" type="radio" name="rbtn_inversion" id="rbtn_inversion2" value="0" <?php if( !checkEmpty($aAmbiental["geam_valor"]) && $aAmbiental["geam_valor"] == 0  ) { echo "checked=\"checked\""; $mostrar1 = "style=\"display: block;\"";  } else { $mostrar1 = "style=\"display: none;\""; } ?> />                        
            <label class="labChk" >No</label>
            </p>            
            <span id="noopcion" <?php echo $mostrar1; ?> >
            <p>Marque una de las opciones y pase a la pregunta 2 </p>
            <p>
                <input class="chk" type="checkbox" name="chk_1" id="chk_1" <?php if( $a_valor == 1 ) { echo "checked=\"checked\""; } ?> />
                <label class="labChk" >a) Falta de conocimiento</label>
                <span class="clear"></span>

                <input class="chk" type="checkbox" name="chk_2" id="chk_2" <?php if( $b_valor == 1 ) { echo "checked=\"checked\""; } ?> />
                <label class="labChk" >b) Falta de presupuesto</label>
                <span class="clear"></span>
                
                <input class="chk" type="checkbox" name="chk_3" id="chk_3" <?php if( $c_valor == 1 ) { echo "checked=\"checked\""; } ?> />
                <label class="labChk" >c) Otros (especificar)</label>
                

                <?php $mostrar2 = "style=\"display: none;\"";  if( $c_valor == 1 ) { $mostrar2 = "style=\"display: block;\"";  } ?>
                <input name="inversionotros" class="inpC" type="text" id="inversionotros" value="<?php echo $c_descrip; ?>" size="60" <?php echo $mostrar2;  ?>  />
            </p>
            
            <span id="msg1" style="display: none;" class="bxEr">Debe registrar el detalle para el item otros</span>
            
            </span>
            <?php } ?>
                
            <?php if( $aAmbiental["vinieta"] == "2" ) { ?>
            <span class="subT">2. &iquest;Realiza tratamiento de aguas?</span>
            <p><?php echo OPERATOR::getDescTitles(1,'B',1,2); ?></p>
            <p> 
                <input class="chk" type="radio" name="rbtn_agua" id="rbtn_agua1" value="1" <?php if( $aAmbiental["geam_valor"] == 1 ) { echo "checked=\"checked\""; } ?> />
                <label class="labChk" >Si</label>
                <span class="clear"></span>
                
                <input class="chk" type="radio" name="rbtn_agua" id="rbtn_agua2" value="0" <?php if( !checkEmpty($aAmbiental["geam_valor"]) && $aAmbiental["geam_valor"] == 0  ) { echo "checked=\"checked\""; } ?> />
                <label class="labChk" >No</label>
            </p>
            
            <?php } ?>
                
            <?php if( $aAmbiental["vinieta"] == "3" ) { ?>
            <span class="subT">3. &iquest;Cuenta con certificaciones ambientales?</span>
            <p><?php echo OPERATOR::getDescTitles(1,'B',1,3); ?></p>
            <p> 
                <input class="chk" type="radio" name="rbtn_certi" id="rbtn_certi1" value="1" <?php $mostrar3 = "style=\"display: none\""; if( $aAmbiental["geam_valor"] == 1 ) { echo "checked=\"checked\""; $mostrar3 = "style=\"display: block\""; } ?>  />
                <label class="labChk" >Si</label>
                <span class="clear"></span>
                
                <input class="chk" type="radio" name="rbtn_certi" id="rbtn_certi2" value="0" <?php if( !checkEmpty($aAmbiental["geam_valor"]) && $aAmbiental["geam_valor"] == 0  ) { echo "checked=\"checked\""; } ?> />
                <label class="labChk" >No</label>
            </p>
            
            <span id="sicertificacion" <?php echo $mostrar3 ?> >
            <p> 
                <label class="labChk" >&iquest;Cu&aacute;les? </label>
                <input name="certiambiental" type="text" id="certiambiental" value="<?php echo $aAmbiental["geam_description"]; ?>" class="inpC" size="60" />                
            </p>
            </span>
            
            <span id="msg2" style="display: none;" class="bxEr">Debe introducir el detalle para la certificaci&oacute;n</span>
            <?php } ?>
                
            <?php if( $aAmbiental["vinieta"] == "4" ) { ?>
            <span class="subT">4 &iquest;Realiza un aprovechamiento de sus residuos s&oacute;lidos?</span>
            <p><?php echo OPERATOR::getDescTitles(1,'B',1,4); ?></p>
            <p> 
                <input class="chk"  type="radio" name="rbtn_ars" id="rbtn_ars1" value="1" <?php if( $aAmbiental["geam_valor"] == 1 ) { echo "checked=\"checked\""; } ?> />            
                <label class="labChk" >Si</label>
                <span class="clear"></span>
                <input class="chk"  type="radio" name="rbtn_ars" id="rbtn_ars2" value="0" <?php if( !checkEmpty($aAmbiental["geam_valor"]) && $aAmbiental["geam_valor"] == 0  ) { echo "checked=\"checked\""; } ?> />
                <label class="labChk" >No</label>
            </p>
            <?php } ?>
                
            <?php if( $aAmbiental["vinieta"] == "5" ) { ?>
            <span class="subT">5. &iquest;Capacita a su personal en temas relacionados a gesti&oacute;n ambiental? </span>
            <p> 
                <input class="chk"  type="radio" name="rbtn_cap" id="rbtn_cap1" value="1" <?php if( $aAmbiental["geam_valor"] == 1 ) { echo "checked=\"checked\""; } ?> />
                <label class="labChk" >Si</label>
                <span class="clear"></span>
                <input class="chk"  type="radio" name="rbtn_cap" id="rbtn_cap2" value="0" <?php if( !checkEmpty($aAmbiental["geam_valor"]) && $aAmbiental["geam_valor"] == 0  ) { echo "checked=\"checked\""; } ?> />
                <label class="labChk" >No</label>
            </p>
            <?php } ?>
                
            <?php if( $aAmbiental["vinieta"] == "6" ) { ?>
            <span class="subT">6. &iquest;Realiza otras acciones de gesti&oacute;n ambiental?</span>
            <p><?php echo OPERATOR::getDescTitles(1,'B',1,6); ?></p>
            <p> 
                <input class="chk"  type="radio" name="rbtn_aga" id="rbtn_aga1" value="1" <?php $mostrar4 = "style=\"display: none\"";  if( $aAmbiental["geam_valor"] == 1 ) { echo "checked=\"checked\""; $mostrar4 = "style=\"display: block\""; } ?> />
                <label class="labChk" >Si</label>
                <span class="clear"></span>
                <input  class="chk"  type="radio" name="rbtn_aga" id="rbtn_aga2" value="0" <?php if( !checkEmpty($aAmbiental["geam_valor"]) && $aAmbiental["geam_valor"] == 0  ) { echo "checked=\"checked\""; } ?> />
                <label class="labChk" >No</label>
            </p>
            <p> <span id="siotrasambiental" <?php echo $mostrar4 ?> >
                <label class="labChk" >&iquest;Cu&aacute;les?</label>
                <input name="otrasambiental" class="inpC" type="text" id="otrasambiental" size="60" value="<?php echo $aAmbiental["geam_description"]; ?>" />
                </span>
            </p>
            <span id="msg3" style="display: none;" class="bxEr">Debe introducir el detalle</span>
            <?php } ?>
            <?php } ?>
          
          <span class="bxBt">
                <input type="submit" value="SIGUIENTE" id="sendData" name="continuarregistro" class="button" >
                <a href="acap10.php" class="btnS">ANTERIOR</a>                
          </span>
                
        </fieldset>
    </form>
    <div class="clear"></div>      

</div>
<!-- end body -->

<?php include("footer.php") ?>
