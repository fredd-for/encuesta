<?php
include_once("../OPERATOR/database/connection.php");
include_once("../OPERATOR/core/OPERATOR.php");
?>
<?php
$itemSearch =  OPERATOR::toSql(OPERATOR::getParam("itemSearch"), "String");
// LIKE '%San Pedro%'
$condicion = ( !empty($itemSearch) )?" AND (ofl_title LIKE '%".$itemSearch."%' OR ofl_address LIKE '%".$itemSearch."%' ) ":"";
$sqlOffices = "
        SELECT cty_description, ofl_type, ofl_title, ofl_address, ofl_phone1, ofl_phone2, ofl_fax
        FROM mdl_offices
            LEFT JOIN mdl_offices_languages ON ( off_uid = ofl_off_uid )
            LEFT JOIN mdl_cities ON ( off_cty_cod = cty_cod )
            WHERE ofl_type
            IN ( 'Agencia', 'Oficina Externa'  )
            AND off_delete <> 1 AND ofl_language = 'es'
            AND ofl_status = 'ACTIVE' $condicion
        ORDER BY cty_description, ofl_title";
$db2->query( $sqlOffices );

//echo $sqlOffices;
$cont = 0;


while( $offices = $db2->next_record() ) {
    $cont = $cont + 1;
    if( $cont == 1 ) {
        echo '<h3>'.$offices['cty_description'].'</h3>';
        echo '<ul class="liAg">';        
        $cityActual = $offices['cty_description'];
    }
    
    if( $cityActual != $offices['cty_description'] ){
        echo "</ul>";
        
        echo "<div class=\"clear\"></div>";
        echo '<h3>'.$offices['cty_description'].'</h3>';
        echo '<ul class="liAg">';         
        $cityActual = $offices['cty_description'];
    }
    
    $sFax = ( !empty($offices['ofl_fax']) )?'<span class="color2">Fax: </span>'.$offices['ofl_fax']:"";
    $fono1 = ( !empty($offices['ofl_phone1']) )?$offices['ofl_phone1']:"";
    $fono2 = ( !empty($offices['ofl_phone2']) )?" - ".$offices['ofl_phone2']:"";
    echo '<li>
            <span class="smallV">'.$offices['ofl_type'].'</span><br>
            <span class="bold3">'.utf8_encode($offices['ofl_title']).'</span><br>'.utf8_encode($offices['ofl_address']).'<br>
            <span class="color2">Tel&eacute;fonos:</span> '.$fono1.$fono2.'<br>'.$sFax.'</li>';    
}
if( $cont >= 1 ) {
    echo "</ul>";
}
?>