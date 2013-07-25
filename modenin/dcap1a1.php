<?php session_start(); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php'); ?>
<?php include("header.php") ?>
<script type="text/javascript" src="js/dcap1a1.js"></script>
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
        <th>M&oacute;dulo D</th>
        <th>SERVICIOS TECNOL&Oacute;GICOS Y CAPACITACI&Oacute;N GESTI&Oacute;N 2012</th>
    </tr>
    </thead>    
    </table>        
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
    
    <form class="formA validable" action="dcap1a1Add.php" method="post" autocomplete="off" >
      <fieldset>    
          <p> <span class="subT">1.1 TIPO DE INVERSI&Oacute;N EN FORMACI&Oacute;N Y CAPACITACI&Oacute;N</span> </p>
          <!-- table 1 --> 
          <p> <span class="subT">1. SISTEMAS DE FORMACI&Oacute;N CONT&Iacute;NUA</span> </p>
          <p> <span class="subT">1.1  Formaci&oacute;n cont&iacute;nua en &aacute;reas t&eacute;cnicas (procesos de producci&oacute;n, manejo de maquinarias, etc.)</span> </p>
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
                $posmax = OPERATOR::getDbValue("SELECT MAX(capa_position) + 1 as pos FROM frm2_dcap1a_capacitacion WHERE capa_regi_uid = '".$regisroUID."' AND capa_defi_uid = '288' AND capa_position <> 0");                
                if( empty($posmax) ) { $posmax = 1; }
                $sql3 = "SELECT * FROM frm2_dcap1a_capacitacion WHERE capa_defi_uid = '288' AND capa_regi_uid = '".$regisroUID."' AND capa_delete = 0 AND capa_position <> 0 ORDER BY capa_position ASC ";
                
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
                    <td width="6%" ><input type="text" name="C_<?php echo $pos ?>" id="C_<?php echo $pos ?>" value="<?php echo $aDat["capa_institucion"] ?>" onblur="saveUPD(1);" size="40" class="inpC2" /></td>
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
            </table>
            <input type="hidden" name="maxrow_a" id="maxrow_a" value="<?php echo $posmax ?>">
            <a href="#" id="addrow_a" class="btnAdd">Agregar campos</a>
            <p>
                <span id="msg" style="display: none;" class="bxEr" >Debe introducir movimiento para invetarios</span>
                <span id="msg2" style="display: none;" class="bxEr" >Debe introducir el detalle para otros inventarios</span>               
            </p>
            

<!-- table 1 --> 
          <p> <span class="subT">1.2 Formaci&oacute;n cont&iacute;nua en gesti&oacute;n empresarial (contabilidad, administraci&oacute;n, etc.)</span> </p>
          <table width="100%" class="fOpt" id="table_b" >
                <thead>
                <tr>
                  <th align="center" >&nbsp;</th>
                  <th align="center" >VALOR (Bs.)</th>
                  <th align="center"  >NOMBRE DE LAS INSTITUCIONES QUE BRINDARON CAPACITACI&Oacute;N</th>
                  <th align="center"  >&nbsp;</th>
                </tr>
            </thead>
                    
                <tbody>
                <?php
                $posmax = OPERATOR::getDbValue("SELECT MAX(capa_position) + 1 as pos FROM frm2_dcap1a_capacitacion WHERE capa_regi_uid = '".$regisroUID."' AND capa_defi_uid = '289' AND capa_position <> 0");                
                if( empty($posmax) ) { $posmax = 1; }
                $sql3 = "SELECT * FROM frm2_dcap1a_capacitacion WHERE capa_defi_uid = '289' AND capa_regi_uid = '".$regisroUID."' AND capa_delete = 0 AND capa_position <> 0 ORDER BY capa_position ASC ";
                
                $db3->query( $sql3 );
                if( $db3->numrows() > 0 ) {
                while( $aDat = $db3->next_record() ) {
                    $pos = $aDat["capa_position"];
                    $sum = $sum + $aDat["capa_valor"];
                ?>
                <tr id="rowb_<?php echo $pos; ?>" >
                    <td width="13%"><input type="text" name="A2_<?php echo $pos ?>" id="A2_<?php echo $pos ?>" value="<?php echo $aDat["capa_descripcion"] ?>"   size="40" class="inpC2" /></td>
                    <td width="12%"><input type="text" name="B2_<?php echo $pos ?>" id="B2_<?php echo $pos ?>" value="<?php echo number_format($aDat["capa_valor"]) ?>"  onblur="sumcol('B');"    size="10" class="inpB2 numeric" /></td>
                    <td width="6%" ><input type="text" name="C2_<?php echo $pos ?>" id="C2_<?php echo $pos ?>" value="<?php echo $aDat["capa_institucion"] ?>" onblur="saveUPD(2);" size="40" class="inpC2" /></td>
                    <td width="5%" ><a href="#" class="lnkCls" id="delplan_<?php echo $aDat["capa_position"] ?>" onclick="delRow('<?php echo $pos ?>',1,'b'); return false;" >eliminar</a></td>                    
                </tr>
                <?php }
                } else {
                ?>
                <tr id="rowb_<?php echo $posmax; ?>" >
                    <td width="13%"><input type="text" name="A2_<?php echo $posmax; ?>" id="A2_<?php echo $posmax; ?>" size="40" class="inpC2" /></td>
                    <td width="12%"><input type="text" name="B2_<?php echo $posmax; ?>" id="B2_<?php echo $posmax; ?>" size="10" class="inpB2 numeric" onblur="sumcol('B');"  /></td>
                    <td width="6%" ><input type="text" name="C2_<?php echo $posmax; ?>" id="C2_<?php echo $posmax; ?>" size="40" class="inpC2" onblur="saveUPD(2);" /></td>
                    <td width="5%" >&nbsp;</td>                    
                </tr>
                <?php 
                $posmax = $posmax + 1;
                } ?>
                </tbody>                               
        </table>

        <input type="hidden" name="maxrow_b" id="maxrow_b" value="<?php echo $posmax ?>">
        <a href="#" id="addrow_b" class="btnAdd">Agregar campos</a>

        <!-- table 1 --> 
        <p> <span class="subT">1.3 Formaci&oacute;n cont&iacute;nua en capacidades personales (liderazgo, &eacute;tica, etc.)</span> </p>
        <table width="100%" class="fOpt" id="table_c" >
        <thead>
            <tr>
              <th align="center" >&nbsp;</th>
              <th align="center" >VALOR (Bs.)</th>
              <th align="center"  >NOMBRE DE LAS INSTITUCIONES QUE BRINDARON CAPACITACI&Oacute;N</th>
              <th align="center"  >&nbsp;</th>
            </tr>
        </thead>                    
        <tbody>
                <?php
                $posmax = OPERATOR::getDbValue("SELECT MAX(capa_position) + 1 as pos FROM frm2_dcap1a_capacitacion WHERE capa_regi_uid = '".$regisroUID."' AND capa_defi_uid = '290' AND capa_position <> 0");                
                if( empty($posmax) ) { $posmax = 1; }
                $sql3 = "SELECT * FROM frm2_dcap1a_capacitacion WHERE capa_defi_uid = '290' AND capa_regi_uid = '".$regisroUID."' AND capa_delete = 0 AND capa_position <> 0 ORDER BY capa_position ASC ";                
                
                $db3->query( $sql3 );
                if( $db3->numrows() > 0 ) {
                while( $aDat = $db3->next_record() ) {
                    $pos = $aDat["capa_position"];
                    $sum = $sum + $aDat["capa_valor"];
                ?>
                <tr id="rowc_<?php echo $pos; ?>" >
                    <td width="13%"><input type="text" name="A3_<?php echo $pos ?>" id="A3_<?php echo $pos ?>" value="<?php echo $aDat["capa_descripcion"] ?>"   size="40" class="inpC2" /></td>
                    <td width="12%"><input type="text" name="B3_<?php echo $pos ?>" id="B3_<?php echo $pos ?>" value="<?php echo number_format($aDat["capa_valor"]) ?>"  onblur="sumcol('B');"    size="10" class="inpB2 numeric" /></td>
                    <td width="6%" ><input type="text" name="C3_<?php echo $pos ?>" id="C3_<?php echo $pos ?>" value="<?php echo $aDat["capa_institucion"] ?>" onblur="saveUPD(3);" size="40" class="inpC2" /></td>
                    <td width="5%" ><a href="#" class="lnkCls" id="delplan_<?php echo $aDat["capa_position"] ?>" onclick="delRow('<?php echo $pos ?>',1,'c'); return false;" >eliminar</a></td>                    
                </tr>
                <?php }
                } else {
                ?>
                <tr id="rowc_<?php echo $posmax; ?>" >
                    <td width="13%"><input type="text" name="A3_<?php echo $posmax; ?>" id="A3_<?php echo $posmax; ?>" size="40" class="inpC2" /></td>
                    <td width="12%"><input type="text" name="B3_<?php echo $posmax; ?>" id="B3_<?php echo $posmax; ?>" size="10" class="inpB2 numeric" onblur="sumcol('B');"  /></td>
                    <td width="6%" ><input type="text" name="C3_<?php echo $posmax; ?>" id="C3_<?php echo $posmax; ?>" size="40" class="inpC2" onblur="saveUPD(3);" /></td>
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

        <input type="hidden" name="maxrow_c" id="maxrow_c" value="<?php echo $posmax ?>">
        <a href="#" id="addrow_c" class="btnAdd">Agregar campos</a>
                                                              
            
        <span class="bxBt">
            <input type="submit" value="SIGUIENTE" id="sendData" name="continuarregistro" class="button" >
            <a href="ccap1.php" class="btnS">ANTERIOR</a>                
            </span>

        </fieldset>
  </form>
    <div class="clear"></div>      

</div>
<!-- end body -->

<?php include("footer.php") ?>