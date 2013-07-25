<?php session_start(); 
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");

if( $_SESSION[SITE]["authenticated"] ) {    
    $_SESSION["menuactiveparent"]  = 'user';    
} else {
    header("Location: logout.php");
}

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

$nopagH = OPERATOR::toSql(safeHTML(OPERATOR::getParam("nopagH")),'Text');
$nopagH = preg_replace('/,/', '', $nopagH);
$nopagM = OPERATOR::toSql(safeHTML(OPERATOR::getParam("nopagM")),'Text');
$nopagM = preg_replace('/,/', '', $nopagM);

/* tot */
$totperH = OPERATOR::toSql(safeHTML(OPERATOR::getParam("totperH")),'Text');
$totperH = preg_replace('/,/', '', $totperH);
$totperM = OPERATOR::toSql(safeHTML(OPERATOR::getParam("totperM")),'Text');
$totperM = preg_replace('/,/', '', $totperM);
$totperHM = OPERATOR::toSql(safeHTML(OPERATOR::getParam("totperHM")),'Text');
$totperHM = preg_replace('/,/', '', $totperHM);


/* totgen */
/*
$totgenH = OPERATOR::toSql(safeHTML(OPERATOR::getParam("totgenH")),'Number');
$totgenM = OPERATOR::toSql(safeHTML(OPERATOR::getParam("totgenM")),'Number');
$totgenHM = OPERATOR::toSql(safeHTML(OPERATOR::getParam("totgenHM")),'Number');
 * 
 */

$totgenH = $pepermanenteH + $peventualH + $nopagH;
$totgenM = $pepermanenteM + $peventualM + $nopagM;
$totgenHM = $pepermanente + $peventual;

/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];


$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

// obtener el uid del token
$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    if( !empty($regisroUID)  ) {
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
        
        //echo $sql;
        
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
        
        $defi_uid = 3;
        // Personal subtot personal
        $sql  = "UPDATE cap2_personalsueldos SET ";        
        $sql .= "pesu_numero_hombres = '".$totperH."', ";
        $sql .= "pesu_numero_mujeres = '".$totperM."', ";
        $sql .= "pesu_sueldos_salarios = '".$totperHM."', ";
        $sql .= "pesu_suv_uid = '".$uid_token."', ";
        $sql .= "pesu_date_update = NOW() ";
        $sql .= "WHERE pesu_regi_uid = '".$regisroUID."' AND pesu_defi_uid 	 = '".$defi_uid."' ";        
        $db->query($sql); 
                
        $defi_uid = 4;
        // Personal nopagados
        $sql  = "UPDATE cap2_personalsueldos SET ";       
        $sql .= "pesu_numero_hombres = '".$nopagH."', ";
        $sql .= "pesu_numero_mujeres = '".$nopagM."', ";
        $sql .= "pesu_sueldos_salarios = '0', ";
        $sql .= "pesu_suv_uid = '".$uid_token."', ";
        $sql .= "pesu_date_update = NOW() ";
        $sql .= "WHERE pesu_regi_uid = '".$regisroUID."' AND pesu_defi_uid 	 = '".$defi_uid."' ";        
        $db->query($sql); 
        
        $defi_uid = 5;
        // Personal tot general
        $sql  = "UPDATE cap2_personalsueldos SET ";        
        $sql .= "pesu_numero_hombres = '".$totgenH."', ";
        $sql .= "pesu_numero_mujeres = '".$totgenM."', ";
        $sql .= "pesu_sueldos_salarios = '".$totgenHM."', ";
        $sql .= "pesu_suv_uid = '".$uid_token."', ";
        $sql .= "pesu_date_update = NOW() ";
        
        $sql .= "WHERE pesu_regi_uid = '".$regisroUID."' AND pesu_defi_uid 	 = '".$defi_uid."' ";        
        $db->query($sql);
    }
  
if( !empty( $btnsubmit ) ) {
    header("Location: acap3.php");
}
?>