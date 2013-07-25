<?php 
session_start();
if( $_SESSION["authenticated"] && $_SESSION["usr_rol"] == 1 ) {
    $_SESSION["menuactiveparent"]  = 'user';
    $_SESSION["menuactive"]  = 'user-list';
} else {
    header("Location: ../logout.php");
}
?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
$prod_med=OPERATOR::toSql(safeHTML(OPERATOR::getParam("pr_med")),'Text');  //filtrado de item
?>
<?php include("header.php") ?>
<?php 
$nameMod = "../user";
?>
<!-- begin body -->
<div id="container">
    <div class="contC">
        <?php include("../menu.php"); ?>
        
        <!-- begin body -->
<div class="content">        
    <h1>Listado de usuarios</h1>            
    <div class="conTab w2">
        <div class="conTClos">                
            <div class="headTab w2">
                <div class="rWB">Usuario</div>
                <div class="rWS">Rol</div>
                <div class="rWB">&nbsp;</div>
                
            </div>
            <div class="clear"></div>
            <?php
            $sql = "SELECT * FROM sys_users LEFT JOIN mdl_roles ON ( usr_rol_uid = rol_uid ) WHERE usr_delete <> 1 AND  rol_uid IN (1,2) ORDER BY usr_lastname";    
            //echo $sql;
            $db->query($sql);    

            if( $db->numrows() > 0 ) {
            ?>
            <?php while( $aUsers = $db->next_record() ) { ?>
            <div class="rowA" id="item_<?=$aUsers["usr_uid"]?>">
                <div class="rWB"><?php echo $aUsers["usr_login"]; ?></div>
                <div class="rWS"><?php echo $aUsers["rol_description"] ?></div>
                <div class="rWB">
                    <a href="<?=$nameMod?>/userEdit.php?uid=<?=$aUsers["usr_uid"]?>" class="btn1" >editar</a>
                    
                    <span id="state_<?=$aUsers["usr_uid"]?>">
                        <a href="" onclick="changeState(<?=$aUsers["usr_uid"]?>, '<?=$aUsers["usr_status"]?>' );return false;" class="btn2" ><?php ($aUsers["usr_status"]=='ACTIVE')?print("activo"):print("inactivo"); ?></a>
                    </span>
                    <a href="" onclick="removeItem(<?=$aUsers["usr_uid"]?>);return false;" class="btn3">eliminar</a><span id="process_<?=$aUsers["usr_uid"]?>"></span>
                </div>
            </div>
            <div class="clear"></div> 
            <?php } ?>                
            <?php } else { ?>                
            <div class="clear"></div>                    
            <div class="rowA">
                No hay registros para mostrar.
            </div>
            <?php } ?>                                                             
            <div class="clear"></div> 
        </div>
    </div>
    
    </div>
    </div>
</div>

<!-- end body -->
<?php include("footer.php") ?>