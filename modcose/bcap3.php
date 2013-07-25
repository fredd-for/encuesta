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
?>
<?php
    $sql = " SELECT * FROM frm1_bcap3_responsabilidadsocial WHERE gece_regi_uid = '".$regisroUID."' ";          
    $db->query( $sql );    
    $aRespon = $db->next_record();
    
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
            <th>Cap&iacute;tulo 3</th>
            <th>RESPONSABILIDAD SOCIAL EMPRESARIAL</th>
        </tr>
    </thead>
 
    </table>

    <form class="formA validable" action="bcap3Add.php" method="post" autocomplete="off" >
      <fieldset>
          <p>
                <span class="subT" >
                1. &iquest;La empresa cuenta con una pol&iacute;tica de Responsabilidad Social Empresarial?&nbsp;
                </span>
                <span class="clear"></span>
                
                <input class="chk" type="radio" name="rbtn_rs" id="rbtn_rs1" value="1" <?php if( $aRespon["gece_valor"] == 1 ) { echo "checked=\"checked\""; } ?> />            
                <label class="labChk" >Si</label>
                <span class="clear"></span>
                
                <input class="chk" type="radio" name="rbtn_rs" id="rbtn_rs2" value="0" value="0" <?php if( !checkEmpty($aRespon["gece_valor"]) && $aRespon["gece_valor"] == 0  ) { echo "checked=\"checked\""; } ?> />
                <label class="labChk" >No</label>
          </p>
          
          <p>
                <span class="subT" >2. &iquest;Que monto asign&oacute; en la &uacute;ltima gesti&oacute;n a Responsabilidad Social Empresarial?</span>
                <span class="clear"></span>
                 
                <input name="monto" type="text" id="monto" value="<?php if( empty($aRespon["gece_monto"]) ) { echo "0"; } else { echo $aRespon["gece_monto"]; } ?>" class="numeric inpC" size="30" /><span id="div_monto" class="bxEr" style="display:none" >requerido</span>Bs.
          </p>
                    
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
