<?php session_start(); 
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");

include_once('../verifyLogin.php');

$dataH1 = array();
$dataM1 = array();
$dataV1 = array();

$dataH2 = array();
$dataM2 = array();
$dataV2 = array();

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A1")),'Text'); $dataH1[332] = preg_replace('/,/', '', $a1);
$a2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B1")),'Text'); $dataM1[332] = preg_replace('/,/', '', $a2);
$a3 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("C1")),'Text'); $dataV1[332] = preg_replace('/,/', '', $a3);
$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("D1")),'Text'); $dataH2[332] = preg_replace('/,/', '', $a1);
$a2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("E1")),'Text'); $dataM2[332] = preg_replace('/,/', '', $a2);
$a3 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("F1")),'Text'); $dataV2[332] = preg_replace('/,/', '', $a3);

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A2")),'Text'); $dataH1[333] = preg_replace('/,/', '', $a1);
$a2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B2")),'Text'); $dataM1[333] = preg_replace('/,/', '', $a2);
$a3 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("C2")),'Text'); $dataV1[333] = preg_replace('/,/', '', $a3);
$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("D2")),'Text'); $dataH2[333] = preg_replace('/,/', '', $a1);
$a2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("E2")),'Text'); $dataM2[333] = preg_replace('/,/', '', $a2);
$a3 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("F2")),'Text'); $dataV2[333] = preg_replace('/,/', '', $a3);

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A3")),'Text'); $dataH1[334] = preg_replace('/,/', '', $a1);
$a2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B3")),'Text'); $dataM1[334] = preg_replace('/,/', '', $a2);
$a3 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("C3")),'Text'); $dataV1[334] = preg_replace('/,/', '', $a3);
$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("D3")),'Text'); $dataH2[334] = preg_replace('/,/', '', $a1);
$a2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("E3")),'Text'); $dataM2[334] = preg_replace('/,/', '', $a2);
$a3 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("F3")),'Text'); $dataV2[334] = preg_replace('/,/', '', $a3);


$dataH1[331] = $dataH1[332] + $dataH1[333] + $dataH1[334];
$dataM1[331] = $dataM1[332] + $dataM1[333] + $dataM1[334];
$dataV1[331] = $dataV1[332] + $dataV1[333] + $dataV1[334];
$dataH2[331] = $dataH2[332] + $dataH2[333] + $dataH2[334];
$dataM2[331] = $dataM2[332] + $dataM2[333] + $dataM2[334];
$dataV2[331] = $dataV2[332] + $dataV2[333] + $dataV2[334];

$mes_menor = OPERATOR::toSql(safeHTML(OPERATOR::getParam("mes_menor")),'Number');
$mes_mayor = OPERATOR::toSql(safeHTML(OPERATOR::getParam("mes_mayor")),'Number');

/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');
    
if( !empty($regisroUID)  ) {

    $uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );

    $sql = "SELECT * FROM frm3_acap2_personal_jornal WHERE pejo_regi_uid = '".$regisroUID."' ";
    $db->query($sql);
    
    //echo $sql;
    while ( $aPJ = $db->next_record() ) {   
        $sql  = "UPDATE frm3_acap2_personal_jornal SET ";        
        $sql .= "pejo_mes_menoractividad = '".$mes_menor."', ";
        $sql .= "pejo_menoract_hombres = '".$dataH1[$aPJ["pejo_defi_uid"]]."', ";        
        $sql .= "pejo_menoract_mujeres = '".$dataM1[$aPJ["pejo_defi_uid"]]."', ";
        $sql .= "pejo_menoract_valor = '".$dataV1[$aPJ["pejo_defi_uid"]]."', ";
        $sql .= "pejo_mes_mayoractividad = '".$mes_mayor."', ";
        $sql .= "pejo_mayoract_hombres = '".$dataH2[$aPJ["pejo_defi_uid"]]."', ";
        $sql .= "pejo_mayoract_mujeres = '".$dataM2[$aPJ["pejo_defi_uid"]]."', ";
        $sql .= "pejo_mayoract_valor = '".$dataV2[$aPJ["pejo_defi_uid"]]."', ";
        $sql .= "pejo_suv_uid = '".$uid_token."', ";
        $sql .= "pejo_updatedate = NOW() ";
        $sql .= "WHERE pejo_regi_uid = '".$regisroUID."'  AND pejo_defi_uid = '".$aPJ["pejo_defi_uid"]."' ";         
        $db2->query($sql);
    }
}

if( !empty( $btnsubmit ) ) {
    //header("Location: acap3.php");
    header("Location: acap3.php");
}
?>