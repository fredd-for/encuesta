<?php session_start();
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");

include_once('../verifyLogin.php');

$hom = array();
//ocupados
$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A1")),'Text');
$hom[91] = preg_replace('/,/', '', $a1);

$a2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A2")),'Text');
$hom[92] = preg_replace('/,/', '', $a2);

$a3 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A3")),'Text');
$hom[93] = preg_replace('/,/', '', $a3);

$a4 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A4")),'Text');
$hom[94] = preg_replace('/,/', '', $a4);

//permanente
$hom[90] = $hom[91] + $hom[92] + $hom[93] + $hom[94];

//eventual
$a5 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A5")),'Text');
$hom[95] = preg_replace('/,/', '', $a5);

//total hombres
$hom[96] = $hom[95] + $hom[90];

//apoyo
$a6 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A6")),'Text');
$hom[97] = preg_replace('/,/', '', $a6);


/*---------------*/
$muj = array();
//ocupados
$b1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B1")),'Text');
$muj[91] = preg_replace('/,/', '', $b1);

$b2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B2")),'Text');
$muj[92] = preg_replace('/,/', '', $b2);

$b3 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B3")),'Text');
$muj[93] = preg_replace('/,/', '', $b3);

$b4 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B4")),'Text');
$muj[94] = preg_replace('/,/', '', $b4);

//permanente
$muj[90] = $muj[91] + $muj[92] + $muj[93] + $muj[94];

//eventual
$b5 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B5")),'Text');
$muj[95] = preg_replace('/,/', '', $b5);

//total mujeres
$muj[96] = $muj[95] + $muj[90];

//apoyo
$b6 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B6")),'Text');
$muj[97] = preg_replace('/,/', '', $b6);

/*---------------*/
// salarios
$sala = array();
//ocupados
$c1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("C1")),'Text');
$sala[91] = preg_replace('/,/', '', $c1);

$c2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("C2")),'Text');
$sala[92] = preg_replace('/,/', '', $c2);

$c3 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("C3")),'Text');
$sala[93] = preg_replace('/,/', '', $c3);

$c4 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("C4")),'Text');
$sala[94] = preg_replace('/,/', '', $c4);

//permanente
$sala[90] = $sala[91] + $sala[92] + $sala[93] + $sala[94];

//eventual
$c5 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("C5")),'Text');
$sala[95] = preg_replace('/,/', '', $c5);

//total mujeres
$sala[96] = $sala[95] + $sala[90];

//total general
$hom[536] = $hom[96] + $hom[97];
$muj[536] = $muj[96] + $muj[97];
$sala[536] = $sala[96] + $sala[97];

/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');
    
if( !empty($regisroUID)  ) {

    // obtener el uid del token
    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );

    $sql = "SELECT * FROM cap2_personalsueldos WHERE pesu_regi_uid = '".$regisroUID."' ";
    $db->query($sql);
    
    //echo $sql;
    while ( $aSueldo = $db->next_record() ) {   
        $sql  = "UPDATE cap2_personalsueldos SET ";        
        $sql .= "pesu_numero_hombres = '".$hom[$aSueldo["pesu_defi_uid"]]."', ";
        $sql .= "pesu_numero_mujeres = '".$muj[$aSueldo["pesu_defi_uid"]]."', ";
        $sql .= "pesu_sueldos_salarios = '".$sala[$aSueldo["pesu_defi_uid"]]."', ";
        $sql .= "pesu_suv_uid = '".$uid_token."', ";
        $sql .= "pesu_date_update = NOW() ";
        $sql .= "WHERE pesu_regi_uid = '".$regisroUID."'  AND pesu_defi_uid = '".$aSueldo["pesu_defi_uid"]."' ";         
        $db2->query($sql);
    }
}
?>