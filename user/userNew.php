<?php 
session_start();

if( $_SESSION["authenticated"] && $_SESSION["usr_rol"] == 1 ) {  
    $_SESSION["menuactiveparent"]  = 'user';
    $_SESSION["menuactive"]  = 'user-new';
} else {
    header("Location: ../logout.php");
}
?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
?>
<?php include("header.php") ?>
<!-- begin body -->


<div id="container">
<div class="contC">
<?php include("../menu.php"); ?>
    
<!-- begin body -->
<div class="content">
<h1>Crear usuario</h1>
            
<form id="formUser" class="formA" method="post" action="userAdd.php" autocomplete="Off" enctype="multipart/form-data">
<fieldset>
    <p><legend>Datos</legend></p>
    <p>
    <span class="sp"></span>
    </p>
    <p>
        <label>Usuario:</label>
        <input type="text" id="usr_login" size="40" name="usr_login" class="inpB" >                 
    </p>
    
    <p>
        <label>Password:</label>
        <input type="password" id="usr_pass" name="usr_pass" class="inpB" >
    </p>
    
    <p>
        <label>Nombre(s):</label>
        <input type="text" id="usr_firstname" name="usr_firstname" class="inpB" >
    </p>
    
    <p>  
        <label>Apellido(s):</label>
        <input type="text" id="usr_lastname" name="usr_lastname" class="inpB" >        
    </p>
    
    <p>
        <label>Email:</label>
        <input type="text" id="usr_email" name="usr_email" class="inpB" >
    </p>
    
    <p>
        <label>Rol:</label>
        <select id="usr_rol" name="usr_rol">
            <option value="1" selected="selected">ADMIN</option>
            <option value="2" selected="selected">REGISTER</option>
        </select>
    </p>
    
    <p>
        <label>Estado:</label>
        <select id="usr_status" name="usr_status" >
            <option value="ACTIVE" selected="">Activo</option>
            <option value="INACTIVE">Inactivo</option>
        </select>
    </p>
    <p>
        &nbsp;
    </p>
    <p>
        <label>&nbsp;</label>
        <input type="submit" value="Aceptar" id="sendData" class="button" >
        
    </p>
</fieldset>
</form>
<div class="clear"></div>

</div>
</div>
</div>    

<!-- end body -->
<?php include("footer.php") ?>
