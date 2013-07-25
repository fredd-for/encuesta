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
?>
<?php include("header.php") ?>

<?php 
$user_uid = OPERATOR::toSql(safeHTML(OPERATOR::getParam("uid")),'Number');

$sql = "SELECT * FROM sys_users LEFT JOIN mdl_roles ON ( usr_rol_uid = rol_uid ) WHERE usr_delete <> 1 AND  rol_uid IN (1,2) AND usr_uid = '".$user_uid."' ORDER BY usr_lastname";    
//echo $sql;
$db->query($sql);
$aUser = $db->next_record();

//print_r($_SESSION);
//echo "<br />";
//echo $_SESSION["usr_rol"] ;
?>
<!-- begin body -->

<div id="container">
<div class="contC">
    <?php include("../menu.php"); ?>
    <!-- begin body -->
    <div class="content">
<h1>Editar de usuario</h1>
<form id="formUser" class="formA" method="post" action="userUpd.php" autocomplete="Off" enctype="multipart/form-data">
<fieldset>    
        <p><legend>Datos</legend></p>
        <p>
        <span class="sp"></span>
        </p>
        <p>
            <label>Usuario:</label>
            <input type="text" id="usr_login" name="usr_login" value="<?=$aUser["usr_login"]?>" class="inpB" >
            <input type="hidden" id="usr_uid" name="usr_uid" value="<?=$user_uid?>" >
        </p>
        <p>
            <label>Password:</label>
            <input type="password" id="usr_pass" name="usr_pass" value="" class="inpB" >
        </p>
        
        <p>
            <label>Nombre(s):</label>
            <input type="text" id="usr_firstname" name="usr_firstname" value="<?=$aUser["usr_firstname"]?>" class="inpB" >
        </p>
        <p>
            <label>Apellido(s):</label>
            <input type="text" id="usr_lastname" name="usr_lastname" value="<?=$aUser["usr_lastname"]?>" class="inpB" >
        </p> 
        <p>
            <label>Email:</label>
            <input type="text" id="usr_email" name="usr_email" value="<?=$aUser["usr_email"]?>" class="inpB" >
        </p>         
        <p>
            <label>Rol:</label>
            <select id="usr_rol" name="usr_rol">
                <option value="1"  <?php ($aUser["usr_rol_uid"] == 1)?print('selected="selected"'):print(''); ?>  >ADMIN</option>
                <option value="2"  <?php ($aUser["usr_rol_uid"] == 2)?print('selected="selected"'):print(''); ?>  >REGISTER</option>
            </select>
        </p>
        <p>
            <label>Estado:</label>
            <select id="usr_status" name="usr_status" >
                <option value="ACTIVE" <?php ($aUser["usr_status"] == 'ACTIVE')?print('selected="selected"'):print(''); ?>  >Activo</option>
              	 <option value="INACTIVE" <?php ($aUser["usr_status"] == 'INACTIVE')?print('selected="selected"'):print(''); ?>  >Inactivo</option>
            </select>
        </p>
        <p>&nbsp;</p>
        <p>
            <label>&nbsp;</label>
            <input type="submit" value="Aceptar" id="sendData" class="button">            
        </p>
</fieldset>
</form>
</div>
</div>
</div> 
<!-- end body -->
<?php include("footer.php") ?>
