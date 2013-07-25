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

$sql = "SELECT * FROM frm2_bcap1_gestionambiental WHERE geam_regi_uid = '".$regisroUID."' ";
$db->query( $sql );

if( $db->numrows() == 0 ) {

    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    $sql2 = "SELECT * FROM adm_definiciones WHERE defi_form_uid = '2' AND defi_modulo = 'b' AND defi_capitulo = '1' AND defi_swactive = 'ACTIVE' ";       
    $db2->query( $sql2 );
    while( $aDefinicion =  $db2->next_record() ) {
        $sql = "INSERT INTO frm2_bcap1_gestionambiental SET ";
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

    $sql = " SELECT frm2_bcap1_gestionambiental.*, adm_definiciones.defi_subcapitulo as subcap, adm_definiciones.defi_indent as indent, adm_definiciones.defi_vinieta as vinieta "
          ." FROM frm2_bcap1_gestionambiental LEFT JOIN  adm_definiciones ON ( geam_defi_uid = defi_uid ) "
          ." WHERE geam_regi_uid = '".$regisroUID."' AND geam_defi_uid IN (198, 199, 200, 210, 211, 212 )  "
          ." ORDER BY adm_definiciones.defi_indent ASC,  adm_definiciones.defi_vinieta ASC ";
    $db->query( $sql );
    
    //echo $sql;
    $a1 = ""; $b1 = ""; $c1 = ""; $c1_desc = '';
    $a2 = ""; $b2 = ""; $c2 = ""; $c2_desc = '';
    while( $aAmb = $db->next_record() ) {
        if( $aAmb["subcap"] == "1" && $aAmb["vinieta"] == "a" ) {
            $a1 = $aAmb["geam_valor"];                
        }

        if( $aAmb["subcap"] == "1" && $aAmb["vinieta"] == "b" ) {
            $b1 = $aAmb["geam_valor"];
        }

        if( $aAmb["subcap"] == "1" && $aAmb["vinieta"] == "c" ) {
            $c1 = $aAmb["geam_valor"];
            $c1_desc = $aAmb["geam_description"];
        }
        
        if( $aAmb["subcap"] == "2" && $aAmb["vinieta"] == "a" ) {
            $a2 = $aAmb["geam_valor"];                
        }

        if( $aAmb["subcap"] == "2" && $aAmb["vinieta"] == "b" ) {
            $b2 = $aAmb["geam_valor"];
        }

        if( $aAmb["subcap"] == "2" && $aAmb["vinieta"] == "c" ) {
            $c2 = $aAmb["geam_valor"];
            $c2_desc = $aAmb["geam_description"];
        }
    }
            
    $sql = " SELECT frm2_bcap1_gestionambiental.*, adm_definiciones.defi_subcapitulo as subcap, adm_definiciones.defi_indent as indent, adm_definiciones.defi_vinieta as vinieta  "
          ." FROM frm2_bcap1_gestionambiental LEFT JOIN adm_definiciones ON ( geam_defi_uid = defi_uid ) "
          ." WHERE geam_regi_uid = '".$regisroUID."' AND geam_defi_uid NOT IN (198, 199, 200, 210, 211, 212 ) "
          ." ORDER BY CAST( adm_definiciones.defi_subcapitulo AS UNSIGNED ) ASC,	CAST( adm_definiciones.defi_indent AS UNSIGNED ) ASC, CAST( adm_definiciones.defi_vinieta AS UNSIGNED ) DESC ";
    $db->query( $sql );
       
    //echo $sql;
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
        <th> M&oacute;dulo B</th>
        <th> Encuesta de gesti&oacute;n integrada gesti&oacute;n 2012</th>
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
            while( $aAmb = $db->next_record() ) {
            ?>
            <?php  if( $aAmb["subcap"] == "1" && $aAmb["indent"] == "1"  && $aAmb["vinieta"] == "1"  ) { ?>            
            <p>
                <span class="subT">1. &iquest;Realiz&oacute; inversiones en gesti&oacute;n Ambiental en el &uacute;ltimo a&ntilde;o?&nbsp;</span>
                <span class="clear"></span>
            </p>   
            <p>
            <?php echo OPERATOR::getDescTitles(2,'B',1,'1.1'); ?>
            <?php echo OPERATOR::getDescTitles(2,'B',1,'1.2'); ?>
            </p>
            <p>
                <input class="chk" type="radio" name="rbtn_inv" id="rbtn_inv1" value="1" <?php if( $aAmb["geam_valor"] == 1 ) { echo "checked=\"checked\""; } ?>  />            
                <label class="labChk" >Si</label>
                <span class="clear"></span>

                <input class="chk" type="radio" name="rbtn_inv" id="rbtn_inv2" value="0" <?php if( !checkEmpty($aAmb["geam_valor"]) && $aAmb["geam_valor"] == 0  ) { echo "checked=\"checked\""; $mostrar1 = "style=\"display: block;\"";  } else { $mostrar1 = "style=\"display: none;\""; } ?> />                        
                <label class="labChk" >No</label>
            </p>            
            
            <div id="noopcioninv" <?php echo $mostrar1; ?> >
            <p>Marque los incisos que correspondan y pase a la siguiente pregunta </p>
            <p>
                <input class="chk" type="checkbox" name="chk_1" id="chk_1" <?php if( $a1 == 1 ) { echo "checked=\"checked\""; } ?> />
                <label class="labChk" >a) Falta de presupuesto</label>
                <span class="clear"></span>

                <input class="chk" type="checkbox" name="chk_2" id="chk_2" <?php if( $b1 == 1 ) { echo "checked=\"checked\""; } ?> />
                <label class="labChk" >b) Falta de conocimiento</label>
                <span class="clear"></span>
                
                <input class="chk" type="checkbox" name="chk_3" id="chk_3" <?php if( $c1 == 1 ) { echo "checked=\"checked\""; } ?> />
                <label class="labChk" >c) Otros (especificar)</label>
                
                <?php $mostrar2 = "style=\"display: none;\"";  if( $c1 == 1 ) { $mostrar2 = "style=\"display: block;\"";  } ?>
                <input name="inversionotros" class="inpC" type="text" id="inversionotros" value="<?php echo $c1_desc; ?>" size="60" <?php echo $mostrar2;  ?>  />
            </p>            
            <span id="msg1" style="display: none;" class="bxEr">Debe especificar el detalle para otros</span>            
            </div> 
            
            <p id="siopcioninv" <?php if( $aAmb["geam_valor"] == 1 ) { echo "style=\"display: block\""; } else { echo "style=\"display: none\""; } ?>  ><!-- opcion si (inicio) -->
            
            <?php } ?>
            
            
            <?php  if( $aAmb["subcap"] == "1" && $aAmb["indent"] == "1"  && $aAmb["vinieta"] == "0"  ) { ?>
            
            <input class="chk" type="checkbox" name="activity_1" id="activity_1" <?php if( $aAmb["geam_valor"] == 1 ) { echo "checked=\"checked\""; } ?> >
            <label class="labChkB">1. Proyectos y programas de prevenci&oacute;n, preservaci&oacute;n y protecci&oacute;n ambiental</label>
            <span class="clear"></span>
            <?php } ?>

            <?php  if( $aAmb["subcap"] == "1" && $aAmb["indent"] == "2"  && $aAmb["vinieta"] == "0"  ) { ?>  
            <input class="chk" type="checkbox" name="activity_2" id="activity_2" <?php if( $aAmb["geam_valor"] == 1 ) { echo "checked=\"checked\""; } ?> >
            <label class="labChkB">2. Equipos e instalaciones para reducir las emisiones de contaminantes atmosf&eacute;ricos</label>
            <span class="clear"></span>
            <?php } ?>

            <?php  if( $aAmb["subcap"] == "1" && $aAmb["indent"] == "3"  && $aAmb["vinieta"] == "0"  ) { ?>
            <input class="chk" type="checkbox" name="activity_3" id="activity_3" <?php if( $aAmb["geam_valor"] == 1 ) { echo "checked=\"checked\""; } ?> >
            <label class="labChkB">3. Equipos e instalaciones para la manejo de las aguas residuales, como tambi&eacute;n el ahorro y reutilizaci&oacute;n del agua</label>
            <span class="clear"></span>
            <?php } ?>

            <?php  if( $aAmb["subcap"] == "1" && $aAmb["indent"] == "4"  && $aAmb["vinieta"] == "0"  ) { ?>
            <input class="chk" type="checkbox" name="activity_4" id="activity_4" <?php if( $aAmb["geam_valor"] == 1 ) { echo "checked=\"checked\""; } ?> >
            <label class="labChkB">4. Equipos e instalaciones que reducen la generaci&oacute;n de residuos s&oacute;lidos</label>
            <span class="clear"></span>
            <?php } ?>

            <?php  if( $aAmb["subcap"] == "1" && $aAmb["indent"] == "5"  && $aAmb["vinieta"] == "0"  ) { ?>
            <input class="chk" type="checkbox" name="activity_5" id="activity_5" <?php if( $aAmb["geam_valor"] == 1 ) { echo "checked=\"checked\""; } ?> >
            <label class="labChkB">5. Equipos e instalaciones para prevenir o mitigar la contaminaci&oacute;n de suelos y aguas</label>
            <span class="clear"></span>
            <?php } ?>

            <?php  if( $aAmb["subcap"] == "1" && $aAmb["indent"] == "6"  && $aAmb["vinieta"] == "0"  ) { ?>
            <input class="chk" type="checkbox" name="activity_6" id="activity_6" <?php if( $aAmb["geam_valor"] == 1 ) { echo "checked=\"checked\""; } ?> >
            <label class="labChkB">6. Equipos e instalaciones para reducir ruidos y vibraciones</label>
            <span class="clear"></span>
            <?php } ?>

            <?php  if( $aAmb["subcap"] == "1" && $aAmb["indent"] == "7"  && $aAmb["vinieta"] == "0"  ) { ?>
            <input class="chk" type="checkbox" name="activity_7" id="activity_7" <?php if( $aAmb["geam_valor"] == 1 ) { echo "checked=\"checked\""; } ?> >
            <label class="labChkB">7. Otros equipos e instalaciones (por ejemplo, para uso de materias primas contaminantes)</label>
            <span class="clear"></span>
            <?php } ?>

            <?php  if( $aAmb["subcap"] == "1" && $aAmb["indent"] == "8"  && $aAmb["vinieta"] == "0"  ) { ?>
            <input class="chk" type="checkbox" name="activity_8" id="activity_8" <?php if( $aAmb["geam_valor"] == 1 ) { echo "checked=\"checked\""; } ?> >
            <label class="labChkB">8. Otros (especifique)</label>
            <span class="clear"></span>
            <?php $show0 = "style=\"display: none;\"";  if( $aAmb["geam_valor"] == 1 ) { $show0 = "style=\"display: block;\""; $otrosgestion = $aAmb["geam_description"]; } else { $otrosgestion = ''; } ?>
            <input name="otrosgestion" class="inpC" type="text" id="otrosgestion" value="<?php echo $otrosgestion; ?>" size="60" <?php echo $show0;  ?>  />
            <span id="msg2" class="bxEr" style="display: none;" >Debe especificar el detalle para otros</span>
            <?php } ?>
            
                                
            <?php  if( $aAmb["subcap"] == "2" && $aAmb["indent"] == "1"  && $aAmb["vinieta"] == "1"  ) { ?>                        
            </p><!-- opcion si (final) -->
            <p>
                <span class="subT">2. &iquest;Realiz&oacute; gastos (corrientes) en gesti&oacute;n Ambiental en el &uacute;ltimo a&ntilde;o?</span>
                <span class="clear"></span>
            </p>
            <p>
                <?php echo OPERATOR::getDescTitles(2,'B',1,'2'); ?>                
            </p>
            <p>
                <input class="chk" type="radio" name="rbtn_gastos" id="rbtn_inversion1" onclick="saveUPD(1);" value="1" <?php if( $aAmb["geam_valor"] == 1 ) { echo "checked=\"checked\""; } ?>  />            
                <label class="labChk" >Si</label>
                <span class="clear"></span>

                <input class="chk" type="radio" name="rbtn_gastos" id="rbtn_inversion2" onclick="saveUPD(1);" value="0" <?php if( !checkEmpty($aAmb["geam_valor"]) && $aAmb["geam_valor"] == 0  ) { echo "checked=\"checked\""; $mostrar1 = "style=\"display: block;\"";  } else { $mostrar1 = "style=\"display: none;\""; } ?> />                        
                <label class="labChk" >No</label>
            </p>
                           
            <div id="noopciongastos" <?php if( $aAmb["geam_valor"] == 1 ) { echo "style=\"display: none\""; } else { echo "style=\"display: block\""; } ?> >
            <p>Marque los incisos que correspondan y pase a la siguiente pregunta </p>
            <p>
                <input class="chk" type="checkbox" name="chk_g1" id="chk_g1" <?php if( $a2 == 1 ) { echo "checked=\"checked\""; } ?> />
                <label class="labChk" >a) Falta de presupuesto</label>
                <span class="clear"></span>

                <input class="chk" type="checkbox" name="chk_g2" id="chk_g2" <?php if( $b2 == 1 ) { echo "checked=\"checked\""; } ?> />
                <label class="labChk" >b) Falta de conocimiento</label>
                <span class="clear"></span>
                
                <input class="chk" type="checkbox" name="chk_g3" id="chk_g3" <?php if( $c2 == 1 ) { echo "checked=\"checked\""; } ?> />
                <label class="labChk" >c) Otros (especificar)</label>
                
                <?php $show1 = "style=\"display: none;\"";  if( $c2 == 1 ) { $show1 = "style=\"display: block;\""; } ?>
                <input name="txt_gastos" class="inpC" type="text" id="txt_gastos" value="<?php echo $c2_desc; ?>" size="60" <?php echo $show1;  ?>  />
                <span id="msg3" class="bxEr" style="display: none;" >Debe especificar el detalle para otros</span>
            </p>
            </div>
            
            <p id="siopciongastos" <?php if( $aAmb["geam_valor"] == 1 ) { echo "style=\"display: block\""; } else { echo "style=\"display: none\""; } ?>  ><!-- opcion gastos si (inicio) -->            
            <?php } ?>
                              
                <?php  if( $aAmb["subcap"] == "2" && $aAmb["indent"] == "1"  && $aAmb["vinieta"] == "0"  ) { ?>
                <input class="chk" type="checkbox" name="gastos_1" id="gastos_1" <?php if( $aAmb["geam_valor"] == 1 ) { echo "checked=\"checked\""; } ?> >
                <label class="labChkB">1. Tasas o cuotas de alcantarillado industrial (no incluye el alcantarillado dom&eacute;stico)</label>
                <span class="clear"></span>
                <?php } ?>
                
                <?php  if( $aAmb["subcap"] == "2" && $aAmb["indent"] == "2"  && $aAmb["vinieta"] == "0"  ) { ?>
                <input class="chk" type="checkbox" name="gastos_2" id="gastos_2" <?php if( $aAmb["geam_valor"] == 1 ) { echo "checked=\"checked\""; } ?> >
                <label class="labChkB">2. Recojo y tratamiento de residuos por gestores autorizados (no incluye recojo de basura)</label>
                <span class="clear"></span>
                <?php } ?>
                
                <?php  if( $aAmb["subcap"] == "2" && $aAmb["indent"] == "3"  && $aAmb["vinieta"] == "0"  ) { ?>
                <input class="chk" type="checkbox" name="gastos_3" id="gastos_3" <?php if( $aAmb["geam_valor"] == 1 ) { echo "checked=\"checked\""; } ?> >
                <label class="labChkB">3. Limpieza de fosas s&eacute;pticas</label>
                <span class="clear"></span>
                <?php } ?>
                
                <?php  if( $aAmb["subcap"] == "2" && $aAmb["indent"] == "4"  && $aAmb["vinieta"] == "0"  ) { ?>
                <input class="chk" type="checkbox" name="gastos_4" id="gastos_4" <?php if( $aAmb["geam_valor"] == 1 ) { echo "checked=\"checked\""; } ?> >
                <label class="labChkB">4. Tratamiento de aguas residuales</label>
                <span class="clear"></span>
                <?php } ?>
                
                <?php  if( $aAmb["subcap"] == "2" && $aAmb["indent"] == "5"  && $aAmb["vinieta"] == "0"  ) { ?>
                <input class="chk" type="checkbox" name="gastos_5" id="gastos_5" <?php if( $aAmb["geam_valor"] == 1 ) { echo "checked=\"checked\""; } ?> >
                <label class="labChkB">5. Mediciones y tratamientos de emisiones de contaminantes atmosf&eacute;ricos</label>
                <span class="clear"></span>
                <?php } ?>
                
                <?php  if( $aAmb["subcap"] == "2" && $aAmb["indent"] == "6"  && $aAmb["vinieta"] == "0"  ) { ?>
                <input class="chk" type="checkbox" name="gastos_6" id="gastos_6" <?php if( $aAmb["geam_valor"] == 1 ) { echo "checked=\"checked\""; } ?> >
                <label class="labChkB">6. Mediciones de ruidos y vibraciones (incluye mediciones industriales y perimetrales)</label>
                <span class="clear"></span>
                <?php } ?>
                
                <?php  if( $aAmb["subcap"] == "2" && $aAmb["indent"] == "7"  && $aAmb["vinieta"] == "0"  ) { ?>
                <input class="chk" type="checkbox" name="gastos_7" id="gastos_7" <?php if( $aAmb["geam_valor"] == 1 ) { echo "checked=\"checked\""; } ?> >
                <label class="labChkB">7. Tratamiento de suelos</label>
                <span class="clear"></span>
                <?php } ?>
                
                <?php  if( $aAmb["subcap"] == "2" && $aAmb["indent"] == "8"  && $aAmb["vinieta"] == "0"  ) { ?>
                <input class="chk" type="checkbox" name="gastos_8" id="gastos_8" <?php if( $aAmb["geam_valor"] == 1 ) { echo "checked=\"checked\""; } ?> >
                <label class="labChkB">8. Laboratorios Ambientales</label>
                <span class="clear"></span>
                <?php } ?>
                
                <?php  if( $aAmb["subcap"] == "2" && $aAmb["indent"] == "9"  && $aAmb["vinieta"] == "0"  ) { ?>
                <input class="chk" type="checkbox" name="gastos_9" id="gastos_9" <?php if( $aAmb["geam_valor"] == 1 ) { echo "checked=\"checked\""; } ?> >
                <label class="labChkB">9. Asesoramiento ambiental t&eacute;cnico o jur&iacute;dico, certificaciones ambientales</label>
                <span class="clear"></span>
                <?php } ?>
                
                <?php  if( $aAmb["subcap"] == "2" && $aAmb["indent"] == "10"  && $aAmb["vinieta"] == "0"  ) { ?>
                <input class="chk" type="checkbox" name="gastos_10" id="gastos_10" <?php if( $aAmb["geam_valor"] == 1 ) { echo "checked=\"checked\""; } ?> >
                <label class="labChkB">10. Reparaci&oacute;n y mantenimiento de equipos de protecci&oacute;n ambiental</label>
                <span class="clear"></span>
                <?php } ?>
                
                <?php  if( $aAmb["subcap"] == "2" && $aAmb["indent"] == "11"  && $aAmb["vinieta"] == "0"  ) { ?>
                <input class="chk" type="checkbox" name="gastos_11" id="gastos_11" <?php if( $aAmb["geam_valor"] == 1 ) { echo "checked=\"checked\""; } ?> >
                <label class="labChkB">11. Consumo de materias primas en equipos de protecci&oacute;n ambiental</label>
                <span class="clear"></span>
                <?php } ?>
                
                <?php  if( $aAmb["subcap"] == "2" && $aAmb["indent"] == "12"  && $aAmb["vinieta"] == "0"  ) { ?>
                <input class="chk" type="checkbox" name="gastos_12" id="gastos_12" <?php if( $aAmb["geam_valor"] == 1 ) { echo "checked=\"checked\""; } ?> >
                <label class="labChkB">12. Gastos de personal ocupado en actividades de protecci&oacute;n ambiental (incluye sueldos y salarios)</label>
                <span class="clear"></span>
                <?php } ?>
                
                <?php  if( $aAmb["subcap"] == "2" && $aAmb["indent"] == "13"  && $aAmb["vinieta"] == "0"  ) { ?>
                <input class="chk" type="checkbox" name="gastos_13" id="gastos_13" <?php if( $aAmb["geam_valor"] == 1 ) { echo "checked=\"checked\""; } ?> >
                <label class="labChkB">13. Gesti&oacute;n y capacitaci&oacute;n ambiental</label>
                <span class="clear"></span>
                <?php } ?>
                
                <?php  if( $aAmb["subcap"] == "2" && $aAmb["indent"] == "14"  && $aAmb["vinieta"] == "0"  ) { ?>
                <input class="chk" type="checkbox" name="gastos_14" id="gastos_14" <?php if( $aAmb["geam_valor"] == 1 ) { echo "checked=\"checked\""; } ?> >
                <label class="labChkB">14. Gastos en productos que protegen el medio ambiente (contenedores de residuos, doble acristalamiento, bolsas de basura y otros)</label>
                <span class="clear"></span>
                <?php } ?>
                
                <?php  if( $aAmb["subcap"] == "2" && $aAmb["indent"] == "15"  && $aAmb["vinieta"] == "0"  ) { ?>
                <input class="chk" type="checkbox" name="gastos_15" id="gastos_15" <?php if( $aAmb["geam_valor"] == 1 ) { echo "checked=\"checked\""; } ?> >
                <label class="labChkB">15. Gastos extras por la implementaci&oacute;n de la producci&oacute;n m&aacute;s limpia</label>
                <span class="clear"></span>
                <?php } ?>
                
                <?php  if( $aAmb["subcap"] == "2" && $aAmb["indent"] == "16"  && $aAmb["vinieta"] == "0"  ) { ?>
                <input class="chk" type="checkbox" name="gastos_16" id="gastos_16" <?php if( $aAmb["geam_valor"] == 1 ) { echo "checked=\"checked\""; } ?> >
                <label class="labChkB">16. Otros gastos corrientes (especifique)</label>
                <span class="clear"></span>
                <?php $show2 = "style=\"display: none;\"";  if( $aAmb["geam_valor"] == 1 ) { $show2 = "style=\"display: block;\""; $txt_otrosgastos = $aAmb["geam_description"];  } else { $txt_otrosgastos = ''; } ?>
                <input name="txt_otrosgastos" class="inpC" type="text" id="txt_otrosgastos" value="<?php echo $txt_otrosgastos; ?>" size="60" <?php echo $show2;  ?>  />
                <span id="msg4" class="bxEr" style="display: none;" >Debe especificar el detalle para otros gastos corrientes</span>
                <?php } ?>
                                            
            <?php  if( $aAmb["subcap"] == "3") { ?>
            </p><!-- opcion gastos si (final) -->
                
            <span class="subT">3. &iquest;Su empresa realiz&oacute; el aprovechamiento de sus residuos s&oacute;lidos?</span>
            <p><?php echo OPERATOR::getDescTitles(2,'B',1,3); ?></p>
            <p> 
                <input class="chk" type="radio" name="rbtn_rs" id="rbtn_agua1" onclick="saveUPD(1);" value="1" <?php if( $aAmb["geam_valor"] == 1 ) { echo "checked=\"checked\""; } ?> />
                <label class="labChk" >Si</label>
                <span class="clear"></span>
                
                <input class="chk" type="radio" name="rbtn_rs" id="rbtn_agua2" onclick="saveUPD(1);" value="0" <?php if( !checkEmpty($aAmb["geam_valor"]) && $aAmb["geam_valor"] == 0  ) { echo "checked=\"checked\""; } ?> />
                <label class="labChk" >No</label>
            </p>
            <?php } ?>
                                      
            <?php if( $aAmb["subcap"] == "4" ) { ?>
            <span class="subT">4. &iquest;Su empresa vendi&oacute; a otras empresas sus residuos s&oacute;lidos?</span>            
            <p> 
                <input class="chk" type="radio" name="rbtn_vr" id="rbtn_certi1" value="1" <?php if( $aAmb["geam_valor"] == 1 ) { echo "checked=\"checked\""; } ?>   />
                <label class="labChk" >Si</label>
                <span class="clear"></span>
                
                <input class="chk" type="radio" name="rbtn_vr" id="rbtn_certi2" value="0" <?php if( !checkEmpty($aAmb["geam_valor"]) && $aAmb["geam_valor"] == 0  ) { echo "checked=\"checked\""; } ?> />
                <label class="labChk" >No</label>
            </p>                                                
            <?php } ?>
                
            <?php if( $aAmb["subcap"] == "5" ) { ?>
            <span class="subT">5. &iquest;Su empresa realiz&oacute; tratamiento de aguas residuales?</span>
            <p><?php echo OPERATOR::getDescTitles(2,'B',1,'5'); ?></p>
            <p> 
                <input class="chk"  type="radio" name="rbtn_ta" id="rbtn_ars1" value="1" <?php if( $aAmb["geam_valor"] == 1 ) { echo "checked=\"checked\""; } ?>  />            
                <label class="labChk" >Si</label>
                <span class="clear"></span>
                <input class="chk"  type="radio" name="rbtn_ta" id="rbtn_ars2" value="0" <?php if( !checkEmpty($aAmb["geam_valor"]) && $aAmb["geam_valor"] == 0  ) { echo "checked=\"checked\""; } ?> />
                <label class="labChk" >No</label>
            </p>
            <?php } ?>
                
            <?php if( $aAmb["subcap"] == "6" ) { ?>
            <span class="subT">6. &iquest;Su empresa realiz&oacute; extracci&oacute;n de aguas subterr&aacute;neas? </span>
            <p><?php echo OPERATOR::getDescTitles(2,'B',1,'6'); ?></p>
            <p> 
                <input class="chk"  type="radio" name="rbtn_eas" id="rbtn_cap1" value="1" <?php if( $aAmb["geam_valor"] == 1 ) { echo "checked=\"checked\""; } ?>  />
                <label class="labChk" >Si</label>
                <span class="clear"></span>
                <input class="chk"  type="radio" name="rbtn_eas" id="rbtn_cap2" value="0" <?php if( !checkEmpty($aAmb["geam_valor"]) && $aAmb["geam_valor"] == 0  ) { echo "checked=\"checked\""; } ?> />
                <label class="labChk" >No</label>
            </p>
            <?php } ?>                           
            <?php } ?>
          
            <span class="bxBt">
                <input type="submit" value="SIGUIENTE" id="sendData" name="continuarregistro" class="button" >
                <a href="acap15a3.php" class="btnS">ANTERIOR</a>                
            </span>
                
        </fieldset>
    </form>
    <div class="clear"></div>      

</div>
<!-- end body -->

<?php include("footer.php") ?>