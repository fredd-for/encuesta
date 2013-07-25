<?php session_start(); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php'); ?>
<?php include("header.php") ?>
<script type="text/javascript" src="js/dcap1a2.js"></script>
<?php 
/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];
?>
<!-- begin body -->
<div class="content">
    <span id="statusACAP1"></span>
    <table class="dInf">
    <thead>
    <tr>
        <th>Cap&iacute;tulo 1</th>
        <th>FORMACI&Oacute;N  Y  CAPACITACI&Oacute;N</th>
    </tr>
    </thead>
    <tbody>
        <tr>                        
            <td colspan="2"><?php echo OPERATOR::getDescTitles(2,'D',1,1); ?></td>
        </tr>
    </tbody>
    </table>        
    
    <form class="formA validable" action="dcap1a2Add.php" method="post" autocomplete="off" >
      <fieldset>          
          <!-- table 1 -->           
          <p> <span class="subT">2. EVENTOS DE CAPACITACI&Oacute;N ESPECIALIZADA Y TRANSFERENCIA DE TECNOLOG&Iacute;A DENTRO DE LA EMPRESA</span> </p>
          <table width="100%" class="fOpt" id="table_a" >
                <thead>
                <tr>
                  <th align="center" >&nbsp;</th>
                  <th align="center" >VALOR (Bs.)</th>
                  <th align="center" >NOMBRE DE LAS INSTITUCIONES QUE BRINDARON CAPACITACI&Oacute;N</th>
                  <th align="center" >&nbsp;</th>
                </tr>
                </thead>                    
                <tbody>
                <?php
                $posmax = OPERATOR::getDbValue("SELECT MAX(capa_position) + 1 as pos FROM frm2_dcap1a_capacitacion WHERE capa_regi_uid = '".$regisroUID."' AND capa_defi_uid = '291' AND capa_position <> 0");                
                if( empty($posmax) ) { $posmax = 1; }
                $sql3 = "SELECT * FROM frm2_dcap1a_capacitacion WHERE capa_defi_uid = '291' AND capa_regi_uid = '".$regisroUID."' AND capa_delete = 0 AND capa_position <> 0 ORDER BY capa_position ASC ";
                
                $sum = 0;
                $db3->query( $sql3 );
                if( $db3->numrows() > 0 ) {
                while( $aDat = $db3->next_record() ) {
                    $pos = $aDat["capa_position"];
                    $sum = $sum + $aDat["capa_valor"];
                ?>
                <tr id="rowa_<?php echo $pos; ?>" >
                    <td width="13%"><input type="text" name="A_<?php echo $pos ?>" id="A_<?php echo $pos ?>" value="<?php echo $aDat["capa_descripcion"] ?>"   size="40" class="inpC2" /></td>
                    <td width="12%"><input type="text" name="B_<?php echo $pos ?>" id="B_<?php echo $pos ?>" value="<?php echo number_format($aDat["capa_valor"]) ?>"   onblur="sumcol('B');"  size="10" class="inpB2 numeric" /></td>
                    <td width="6%" ><input type="text" name="C_<?php echo $pos ?>" id="C_<?php echo $pos ?>" value="<?php echo $aDat["capa_institucion"] ?>"  size="40" onblur="saveUPD(1);" class="inpC2" /></td>
                    <td width="5%" ><a href="#" class="lnkCls" id="delplan_<?php echo $aDat["capa_position"] ?>" onclick="delRow('<?php echo $pos ?>',1,'a'); return false;" >eliminar</a></td>                    
                </tr>
                <?php }
                } else {
                ?>
                <tr id="rowa_<?php echo $posmax; ?>" >
                    <td width="13%"><input type="text" name="A_<?php echo $posmax; ?>" id="A_<?php echo $posmax; ?>" size="40" class="inpC2" /></td>
                    <td width="12%"><input type="text" name="B_<?php echo $posmax; ?>" id="B_<?php echo $posmax; ?>" size="10" class="inpB2 numeric" onblur="sumcol('B');"  /></td>
                    <td width="6%" ><input type="text" name="C_<?php echo $posmax; ?>" id="C_<?php echo $posmax; ?>" size="40" class="inpC2" onblur="saveUPD(1);" /></td>
                    <td width="5%" >&nbsp;</td>                    
                </tr>
                <?php 
                $posmax = $posmax + 1;
                } ?>
                </tbody>
                <tfoot>
                <tr>
                    <td width="13%">&nbsp;</td>
                    <td width="12%"><label id="total" class="labB"><?php echo number_format($sum); ?></label></td>
                    <td width="6%" >&nbsp;</td>
                    <td width="5%" >&nbsp;</td>
                </tr>
                </tfoot>
            </table>
            <input type="hidden" name="maxrow_a" id="maxrow_a" value="<?php echo $posmax ?>">
            <a href="#" id="addrow_a" class="btnAdd">Agregar campos</a>
            
            <span class="bxBt">
            <input type="submit" value="SIGUIENTE" id="sendData" name="continuarregistro" class="button" >
            <a href="dcap1a1.php" class="btnS">ANTERIOR</a>                
            </span>

        </fieldset>
  </form>
    <div class="clear"></div>      

</div>
<!-- end body -->

<?php include("footer.php") ?>