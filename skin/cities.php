<?php
include_once("../OPERATOR/database/connection.php");
include_once("../OPERATOR/core/OPERATOR.php");
?>
<?php
$cityCod =  OPERATOR::toSql(OPERATOR::getParam("cod"), "String");

$condicion = "";
if( !empty($cityCod) ) {
    if( $cityCod == "04" ) {
        $codCiudadAlto = "10";
        $condicion = " AND ( cty_cod = '".$cityCod."' OR cty_cod = '".$codCiudadAlto."' )  ";
    }else {
        $condicion = " AND cty_cod = '".$cityCod."' ";
    }
}

$sqlOffices = "
        SELECT cty_description, ofl_type, ofl_title, ofl_address, ofl_phone1, ofl_phone2, ofl_fax, off_cty_cod 	
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
        
        
        $nameCity = ( !empty($cityCod) )?$offices['cty_description']:"Bolivia";
        
        if( $offices['off_cty_cod'] == '10' ){
            $nameCity = 'La Paz';
        }
        
        echo '<h3>'.$nameCity.'</h3>';
        echo '<ul class="liAg">';        
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