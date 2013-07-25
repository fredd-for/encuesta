<?php session_start(); ?>
<?php header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); ?>
<?php
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
?>
<?php 
if( $_SESSION[SITE]["authenticated"] ) {    
    $_SESSION["menuactiveparent"]  = 'user';    
} else {
    header("Location: logout.php");
}
?>

<?php 
$pepermanenteH = OPERATOR::toSql(safeHTML(OPERATOR::getParam("pepermanenteH")),'Text');
$pepermanenteH = preg_replace('/,/', '', $pepermanenteH);
$pepermanenteM= OPERATOR::toSql(safeHTML(OPERATOR::getParam("pepermanenteM")),'Text');
$pepermanenteM = preg_replace('/,/', '', $pepermanenteM);
$pepermanente = OPERATOR::toSql(safeHTML(OPERATOR::getParam("pepermanente")),'Text');
$pepermanente = preg_replace('/,/', '', $pepermanente);


$peventualH= OPERATOR::toSql(safeHTML(OPERATOR::getParam("peventualH")),'Text');
$peventualH = preg_replace('/,/', '', $peventualH);
$peventualM = OPERATOR::toSql(safeHTML(OPERATOR::getParam("peventualM")),'Text');
$peventualM = preg_replace('/,/', '', $peventualM);
$peventual = OPERATOR::toSql(safeHTML(OPERATOR::getParam("peventual")),'Text');
$peventual = preg_replace('/,/', '', $peventual);


/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];


$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

// obtener el uid del token
$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    if( !empty($regisroUID)  ) {
    	if (OPERATOR::toSql(safeHTML(OPERATOR::getParam("pack")),'Number')==1) {
        $defi_uid = 1;
        // Personal permanente
        $sql  = "UPDATE cap2_personalsueldos SET ";        
        $sql .= "pesu_numero_hombres = '".$pepermanenteH."', ";
        $sql .= "pesu_numero_mujeres = '".$pepermanenteM."', ";
        $sql .= "pesu_sueldos_salarios = '".$pepermanente."', ";
        $sql .= "pesu_suv_uid = '".$uid_token."', ";
        $sql .= "pesu_date_update = NOW() ";
        $sql .= "WHERE pesu_regi_uid = '".$regisroUID."' AND pesu_defi_uid = '".$defi_uid."' ";         
        $db->query($sql);
        }
        //echo $sql;
    if (OPERATOR::toSql(safeHTML(OPERATOR::getParam("pack")),'Number')==2) {
        $defi_uid = 2;
        // Personal eventual
        $sql  = "UPDATE cap2_personalsueldos SET ";       
        $sql .= "pesu_numero_hombres = '".$peventualH."', ";
        $sql .= "pesu_numero_mujeres = '".$peventualM."', ";
        $sql .= "pesu_sueldos_salarios = '".$peventual."', ";
        $sql .= "pesu_suv_uid = '".$uid_token."', ";
        $sql .= "pesu_date_update = NOW() ";
        $sql .= "WHERE pesu_regi_uid = '".$regisroUID."' AND pesu_defi_uid 	 = '".$defi_uid."' ";         
        $db->query($sql);  
    }
}
?>