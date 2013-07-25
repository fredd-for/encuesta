<?php session_start(); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
?>
<?php include_once('../verifyLogin.php'); ?>
<?php include("header.php") ?>
<script type="text/javascript" src="js/acap5.js"></script>

<?php 
/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

//crear registros para sueldos
$sql = "SELECT * FROM frm1_cap5_otrosgastosoperativos WHERE otga_regi_uid = '".$regisroUID."' ";
//echo $sql;
$db->query( $sql );
if( $db->numrows() == 0 ) {
    // obtener el uid del token
    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    $sql2 = "SELECT * FROM adm_definiciones WHERE defi_form_uid = '".$uidFormulario."' AND defi_modulo = 'a' AND  defi_capitulo = '5' ";       
    $db2->query( $sql2 );
    while( $aDefinicion =  $db2->next_record() ) {        
        $sql = "INSERT INTO frm1_cap5_otrosgastosoperativos SET ";
        $sql .= "otga_regi_uid = '".$regisroUID."', ";
        $sql .= "otga_defi_uid = '".$aDefinicion["defi_uid"]."', ";
        $sql .= "otga_valor = 0, ";         
        $sql .= "otga_suv_uid = '".$uid_token."', "; 
        $sql .= "otga_createdate = NOW(), "; 
        $sql .= "otga_updatedate = NOW() ";                          	 	
        $db3->query( $sql );                
    }
}

//Tipo de personal

$sql = " SELECT frm1_cap5_otrosgastosoperativos.*, adm_definiciones.defi_vinieta as vinieta "
      ." FROM frm1_cap5_otrosgastosoperativos LEFT JOIN  adm_definiciones ON ( otga_defi_uid	 = defi_uid ) "
      ." WHERE otga_regi_uid = '".$regisroUID."' ORDER BY adm_definiciones.defi_vinieta ASC ";
$db->query( $sql );

$aOtrosgastos =  $db->next_record();
?>

<!-- begin body -->
<div class="content">        <span id="statusACAP1"></span>
    <table class="dInf">
    <thead>
    <tr>
        <th>Cap&iacute;tulo 5</th>
        <th>OTROS GASTOS OPERATIVOS</th>
    </tr>
    </thead>
    <tbody>
        <tr>                        
            <td colspan="2"><?php echo OPERATOR::getDescTitles(1,'A',5,0); ?></td>
        </tr>
    </tbody>
    </table>

    <form class="formA validable" action="acap5Add.php" method="post" autocomplete="off" >
        <fieldset>
          
          <table width="50%" class="fOpt" >
                <thead>
                <tr>
                    <th align="center">DETALLE</th>
                    <th align="center" >VALOR (Bs/Anual)</th>                    
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td width="40%" class="titR" >1. Otros gastos operativos</td>
                    <td width="20%" align="center" >
                    <input type="text" name="otros_gastos"  onblur="javascript:saveUPD(1); return false;" id="otros_gastos" value="<?php echo number_format($aOtrosgastos["otga_valor"]); ?>" class="numeric inpB2" />
                    <span id="div_otros_gastos" class="bxEr" style="display:none" >requerido</span>
                    <span id="div_otros_gastos_2" class="bxEr" style="display:none" >inválido</span>
                    </td>
                </tr>
                </tbody>
            </table>                      
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
