<?php session_start();  header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php'); 

// valor de la tarifa
$input1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-11")),'Text'); //fila 1
$input1 = preg_replace('/,/', '', $input1);

$input2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-12")),'Text');
$input2 = preg_replace('/,/', '', $input2);

$input3 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-21")),'Text'); //fila 1
$input3 = preg_replace('/,/', '', $input3);

$input4 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-22")),'Text');
$input4 = preg_replace('/,/', '', $input4);

$input5 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-31")),'Text'); //fila 1
$input5 = preg_replace('/,/', '', $input5);

$input6 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("input-32")),'Text');
$input6 = preg_replace('/,/', '', $input6);


/* tot */
$totalA = $input1 + $input2;
$totalB = $input3 + $input4; 
$totalC = $input5 + $input6;


/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];


$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

// obtener el uid del token
$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
    if( !empty($regisroUID)  ) {
        $defi_uid = 14;        
        $sql  = "UPDATE frm1_cap4_inventariomateriales SET ";        
        $sql .= "inma_inventario_inicial	 = '".$input1."', ";
        $sql .= "inma_inventario_final = '".$input3."', ";
        $sql .= "inma_total_compras = '".$input5."', ";        
        $sql .= "inma_suv_uid = '".$uid_token."', ";
        $sql .= "inma_updatedate = NOW() ";
        $sql .= "WHERE inma_regi_uid = '".$regisroUID."' AND inma_defi_uid = '".$defi_uid."' ";         
        $db->query($sql);        
        
        $defi_uid = 15;        
        $sql  = "UPDATE frm1_cap4_inventariomateriales SET ";        
        $sql .= "inma_inventario_inicial	 = '".$input2."', ";
        $sql .= "inma_inventario_final = '".$input4."', ";
        $sql .= "inma_total_compras = '".$input6."', ";        
        $sql .= "inma_suv_uid = '".$uid_token."', ";
        $sql .= "inma_updatedate = NOW() ";
        $sql .= "WHERE inma_regi_uid = '".$regisroUID."' AND inma_defi_uid = '".$defi_uid."' ";         
        $db->query($sql); 
        
        $defi_uid = 16;        
        $sql  = "UPDATE frm1_cap4_inventariomateriales SET ";        
        $sql .= "inma_inventario_inicial	 = '".$totalA."', ";
        $sql .= "inma_inventario_final = '".$totalB."', ";
        $sql .= "inma_total_compras = '".$totalC."', ";        
        $sql .= "inma_suv_uid = '".$uid_token."', ";
        $sql .= "inma_updatedate = NOW() ";
        $sql .= "WHERE inma_regi_uid = '".$regisroUID."' AND inma_defi_uid = '".$defi_uid."' ";         
        $db->query($sql); 
    }
  
if( !empty( $btnsubmit ) ) {
    header("Location: acap5.php");
}
?>