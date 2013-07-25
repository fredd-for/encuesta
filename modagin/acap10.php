<?php session_start(); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php'); ?>
<?php include("header.php") ?>
<script type="text/javascript" src="js/acap10.js"></script>
<?php 
/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$sql = "SELECT * FROM  frm3_cap10_resultadogestion WHERE rege_regi_uid = '".$regisroUID."' ";
$db->query( $sql );
if( $db->numrows() == 0 ) {
    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    $sql2 = "SELECT * FROM adm_definiciones WHERE defi_form_uid = '".$uidFormulario."'  AND defi_modulo = 'a' AND  defi_capitulo = '10' AND defi_swactive = 'ACTIVE'";
    $db2->query( $sql2 );
    while( $aDefinicion =  $db2->next_record() ) {
        $sql = "INSERT INTO frm3_cap10_resultadogestion SET ";
        $sql .= "rege_regi_uid = '".$regisroUID."', ";
        $sql .= "rege_defi_uid = '".$aDefinicion["defi_uid"]."', ";
        $sql .= "rege_valor= 0, ";        
        $sql .= "rege_suv_uid = '".$uid_token."', ";
        $sql .= "rege_createdate = NOW(), ";
        $sql .= "rege_updatedate = NOW() ";
        $db3->query( $sql );
    }
}

$sql = " SELECT  frm3_cap10_resultadogestion.*, adm_definiciones.defi_subcapitulo as subcap "
      ." FROM  frm3_cap10_resultadogestion LEFT JOIN  adm_definiciones ON ( rege_defi_uid	 = defi_uid ) "
      ." WHERE rege_regi_uid = '".$regisroUID."' ORDER BY CAST( adm_definiciones.defi_subcapitulo AS UNSIGNED ) ASC ";
$db->query( $sql );
//echo $sql;
?>

<!-- begin body -->
<div class="content">
    <span id="statusACAP1"></span>    
    
    <table class="dInf">
    <thead>
    <tr>
        <th>Cap&iacute;tulo 10</th>
        <th>RESULTADO DE LA GESTI&Oacute;N</th>
    </tr>
    </thead>
    <tbody>
        <tr>                        
            <td colspan="2"><?php echo OPERATOR::getDescTitles(3,'A',10,0); ?></td>
        </tr>
    </tbody>
    </table>        
    
    <form class="formA validable" action="acap10Add.php" method="post" autocomplete="off" >
      <fieldset>
        
        <table width="100%" class="fOpt" >
                <thead>
                <tr>
                    <th align="center">Detalle</th>
                    <th  align="center">Valor (Bs/Anual)</th>
                </tr>
                
                </thead>
                                                
                <tbody>
                <?php 
                while( $aDat = $db->next_record() ) {
                ?>                
                <?php if( $aDat["subcap"] == '1' ) { ?>
                <tr>
                    <td width="71%" class="titR" >1. Utilidad neta de la gesti&oacute;n</td>
                    <td width="29%" align="right" ><input type="text" name="A1" id="A1" value="<?php echo number_format($aDat["rege_valor"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                  </tr>                
                <?php } ?>
                
                <?php if( $aDat["subcap"] == '2'  ) { ?>
                <tr>
                  <td class="titR" >2. Perdida neta de la gesti&oacute;n</td>
                  <td align="right"><input type="text" name="A2" id="A2" value="<?php echo number_format($aDat["rege_valor"]) ?>" size="20" maxlength="15" class="inpB2 numeric" /></td>
                  </tr>
                <?php } ?>                                                                             
                                              
                <?php } ?>
                </tbody>
            </table>
            <p>
                <span id="msg" style="display: none;" class="bxEr" >Debe llenar necesariamente una de las dos casillas, en la otra anote 0 (cero)</span>                
            </p>                                      
            
            <span class="bxBt">
            <input type="submit" value="SIGUIENTE" id="sendData" name="continuarregistro" class="button" >
            <a href="acap9.php" class="btnS">ANTERIOR</a>                
            </span>

        </fieldset>
  </form>
    <div class="clear"></div>      

</div>
<!-- end body -->

<?php include("footer.php") ?>