<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include("header.php");
?>  
<!-- begin body -->
<div class="contH">
    
        <div class="contC">
        
            <h2>Registro de usuario</h2>
            
            <form class="formL validable" action="registerAdd.php" method="post" autocomplete="off" >
            <fieldset>
                <p>                
                    <label>N&ordm; de matr&iacute;cula:</label>
                    <input type="text" name="matricula" id="matricula" size="40" class="inpA required" title='Ingrese número de matricula (sin ceros por delante). Ej: 1452'> 
                    <span id="div_matricula" class="bxEr2" style="display: none;">campo requerido</span>
                </p>

                <p>
                    <label>Correo electr&oacute;nico:</label>
                    <input type="text" name="email" id="email" size="40" class="inpA required email" title='Ingrese correo electronico vigente'>
                    <span id="div_email" class="bxEr2" style="display: none;">campo requerido</span>
                    <span id="div_email_2" class="bxEr2" style="display: none;">correo invalido</span>
                </p>

                <p>
                    <label>Contrase&ntilde;a:</label>
                    <input type="password" name="passwd" id="passwd" size="40" class="inpA required alphanum" title='Ingrese una contraseña personal '>
                    <span id="div_passwd" class="bxEr2" style="display: none;">campo requerido</span>
                </p>

                <p>                    
                <?php
                $message = OPERATOR::toSql(safeHTML(OPERATOR::getParam("msg")), 'Number');
                switch ($message) {
                    case 1: echo "<span id=\"message\" class=\"txtC\">El registro de sus datos se realiz&oacute; con &eacute;xito. Una notificaci&oacute;n se le envio a su correo.</span>";
                        break;
                    case 2: echo "<span id=\"message\" class=\"txtR\">Surgi&oacute; un problema en su registro. Intente de nuevo.</span>";
                        break;
                    case 3: echo "<span id=\"message\" class=\"txtC\">Ya existe el registro de sus datos.</span>";
                        break;
                    case 4: echo "<span id=\"message\" class=\"txtC\">El registro de sus datos se realiz&oacute; con &eacute;xito. Verifica tu correo electr&oacute;nico para validar tu cuenta.</span>";
                        break;
                    case 5: echo "<span id=\"message\" class=\"txtR\">Ocurrio un problema al enviar respuesta a su correo electr&oacute;nico. Intente de nuevo.</span>";
                        break;
                }
                ?>
                </p>
                  

                <p>

                    <label>&nbsp;</label>
                    <input type="submit" value="Aceptar" id="sendData" class="button" >
                    <span class="txtIn">
                        o <a class="lnk3" href="../index.php">Volver a la p&aacute;gina de inicio</a>
                    </span>

                </p>

            </fieldset>
            </form>
            <div class="clear"></div>
        </div>
        
   
        
    </div>
<!-- end body -->       

<?php include("footer.php") ?>
