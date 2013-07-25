<?php 
function get_route($cual_uid){
	global $db4;
	global $lang;
	$breadroute="";
	while($cual_uid!=0){
		$breadlvl=OPERATOR::getDBvalue("select con_level from mdl_contents	left join mdl_contents_languages on (con_uid=col_con_uid)
	where con_delete<>1 and col_status='ACTIVE' and col_language='".$lang."' and con_uid= '".$cual_uid."'");
		$breadruta=OPERATOR::getDBvalue("select col_url from mdl_contents	left join mdl_contents_languages on (con_uid=col_con_uid)
	where con_delete<>1 and col_status='ACTIVE' and col_language='".$lang."' and con_uid= '".$cual_uid."'");
		if($breadlvl==1){
			$haschild=OPERATOR::getDBvalue("select col_url from mdl_contents left join mdl_contents_languages on (con_uid=col_con_uid)
	where con_delete<>1 and col_status='ACTIVE' and col_language='".$lang."' and con_parent= '".$cual_uid."' order by con_position limit 1");
			if($haschild){
				$breadroute=$breadruta."/".$breadroute.$haschild."/";
			}
			else {
				$breadroute=$breadruta."/".$breadroute;		
			}
			} else {
		if($breadlvl==2){
			$haschild=OPERATOR::getDBvalue("select col_url from mdl_contents left join mdl_contents_languages on (con_uid=col_con_uid)
	where con_delete<>1 and col_status='ACTIVE' and col_language='".$lang."' and con_parent= '".$cual_uid."' order by con_position limit 1");
			if($haschild){
				$breadroute=$breadruta."/".$breadroute.$haschild."/";
			}
			else {
				$breadroute=$breadruta."/".$breadroute;		
			}  
		} else {
			$breadroute=$breadruta."/".$breadroute;		
		}
			}
		$cual_uid=OPERATOR::getDBvalue("select con_parent from mdl_contents	left join mdl_contents_languages on (con_uid=col_con_uid)
	where con_delete<>1 and col_status='ACTIVE' and col_language='".$lang."' and con_uid= '".$cual_uid."'");
	}
	return $breadroute;
}
$contentx=$con_uid;
$breadc="";
while($contentx!=0){
	if(strlen($breadc)==0){
	$breadc=OPERATOR::getDBvalue("select col_title from mdl_contents	left join mdl_contents_languages on (con_uid=col_con_uid)
	where con_delete<>1 and col_status='ACTIVE' and col_language='".$lang."' and con_uid= '".$contentx."'").$breadc;
	} else {
	$breadcaux=OPERATOR::getDBvalue("select col_title from mdl_contents	left join mdl_contents_languages on (con_uid=col_con_uid)
	where con_delete<>1 and col_status='ACTIVE' and col_language='".$lang."' and con_uid= '".$contentx."'");
	$conlink='<a href="'. $domain.'/'.get_route($contentx).'" class="lnk1">'.$breadcaux.'</a>';
	$breadc= $conlink." > ".$breadc;	
	}
	$contentx=OPERATOR::getDBvalue("select con_parent from mdl_contents	left join mdl_contents_languages on (con_uid=col_con_uid)
	where con_delete<>1 and col_status='ACTIVE' and col_language='".$lang."' and con_uid= '".$contentx."'");
}

?>
<div class="clear"></div>
<div class="breadcrumb">
<?='<a href="'.$domain.'/inicio/" class="lnk1">Inicio</a> > '.$breadc;?>
</div>