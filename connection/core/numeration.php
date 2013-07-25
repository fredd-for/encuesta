<?php
// NUEVO FORMATO DE PAGINADOR
 if(empty($_pagi_sql)){
	//Si no se defini $_pagi_sql... error!
	//Este error se muestra s o s (ya que no es un error de mysql)
	die("<b>Error Paginator: </b>No se ha definido la variable \$_pagi_sql");
 }
 
 if(empty($_pagi_cuantos)){
	//Si no se ha especificado la cantidad de registros por pgina
	//$_pagi_cuantos ser por defecto 20
	$_pagi_cuantos = 20;
 }
 
 if(!isset($_pagi_mostrar_errores)){
	//Si no se ha elegido si se mostrar o no errores
	//$_pagi_errores ser por defecto true. (se muestran los errores)
	$_pagi_mostrar_errores = true;
 }
//------------------------------------------------------------------------


/*
 * Establecimiento de la pgina actual.
 *------------------------------------------------------------------------
 */
 if (empty($_GET['_pagi_pg'])){
	//Si no se ha hecho click a ninguna pgina especfica
	//O sea si es la primera vez que se ejecuta el script
    //$_pagi_actual es la pagina actual-->ser por defecto la primera.
	$_pagi_actual = 1;
 }else{
	//Si se "pidi" una pgina especfica:
	//La pgina actual ser la que se pidi.
    $_pagi_actual = $_GET['_pagi_pg'];
 }
//------------------------------------------------------------------------


/*
 * Establecimiento del nmero de pginas y del total de registros.
 *------------------------------------------------------------------------
 */
 //Contamos el total de registros en la BD (para saber cuntas pginas sern)
 
 //$query=$pagDb->query($_pagi_sql);
// $_pagi_sqlConta = eregi_replace("select (.*) from", "SELECT COUNT(*) FROM" );

 $_pagi_totalReg = $nroReg;
 //Si ocurri error y mostrar errores est activado
 if($_pagi_totalReg == false && $_pagi_mostrar_errores == true){
	//die (" Error en la consulta de conteo de registros. Mysql dijo: <b>".mysql_error()."</b>");
	die ("<font face=arial>NO SE ENCONTRARON RESULTADOS</font>");
 }
 //$_pagi_totalReg = mysql_result($_pagi_result2,0,0);//total de registros
 
 //Calculamos el nmero de pginas (saldr un decimal)
 //con ceil() redondeamos y $_pagi_totyalPags ser el nmero total (entero) de pginas que tendremos
 $_pagi_totalPags = ceil($_pagi_totalReg / $_pagi_cuantos);

//------------------------------------------------------------------------


/*
 * Propagacin de variables por el URL.
 *------------------------------------------------------------------------
 */
 //La idea es pasar tambin en los enlaces las variables hayan llegado por url.

        $link = substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'],'/'));
		$link = substr($link, strlen('/'));
		if (strrpos($link,'?'))
		$link = substr($link, 0 , strrpos($link,'?'));

 $_pagi_enlace = $link;
 $_pagi_query_string = "?";
 
 if(isset($_pagi_propagar)){
 	//Si se defini el array para elegir qu variables propagar
	
	if(!is_array($_pagi_propagar)){
		//si $_pagi_propagar no es un array... error!
		die("<b>Error Paginator: </b>La variable \$_pagi_propagar debe ser un array");
	}else{	 
		//Este foreach est tomado de la Clase Paginado de webstudio
		//(http://www.forosdelweb.com/showthread.php?t=65528)
		foreach($_pagi_propagar as $var){
			$_pagi_query_string.= $var."=".$GLOBALS[$var]."&";
		}
	}
	
 }else{
 	//Si no se defini qu variables propagar, se propagan todas las que vienen por URL
	 if(isset($_GET)){
		//Si ya se han pasado variables por url, escribimos el query string concatenando
		//los elementos del array $_GET excepto la variable $_GET['pg'] si es que existe.
		$_pagi_variables = $_GET;
		foreach($_pagi_variables as $_pagi_clave => $_pagi_valor){
			if($_pagi_clave != '_pagi_pg'){
				$_pagi_query_string .= $_pagi_clave."=".$_pagi_valor."&";
			}
		}
	 }
 }

 //Aadimos el query string a la url.
 $_pagi_enlace .= $_pagi_query_string;

 //La variable $_pagi_navegacion contendr los enlaces a las pginas.
 $_pagi_navegacion = '';
 if ($_pagi_actual != 1){
	//Si no estamos en la pgina 1. Ponemos el enlace "anterior"
	$_pagi_url = $_pagi_actual - 1;//ser el nmero de pgina al que enlazamos
	$_pagi_navegacion .= "<li><a href='".$_pagi_enlace."_pagi_pg=".$_pagi_url."' class='txt'>Anterior</a></li>";
 }
 
 //La variable $_pagi_nav_num_enlaces sirve para definir cuntos enlaces con 
 //nmeros de pgina se mostrarn como mximo.
 //Ojo: siempre se mostrar un nmero impar de enlaces. Ms info en la documentacin.
 
 if(!isset($_pagi_nav_num_enlaces)){
	//Si no se defini la variable $_pagi_nav_num_enlaces
	//Se asume que se mostrarn todos los nmeros de pgina en los enlaces.
	$_pagi_nav_desde = 1;//Desde la primera
	$_pagi_nav_hasta = $_pagi_totalPags;//hasta la ltima
 }else{
	//Si se defini la variable $_pagi_nav_num_enlaces
	//Calculamos el intervalo para restar y sumar a partir de la pgina actual
	$_pagi_nav_intervalo = ceil($_pagi_nav_num_enlaces/2) - 1;
	
	//Calculamos desde qu nmero de pgina se mostrar
	$_pagi_nav_desde = $_pagi_actual - $_pagi_nav_intervalo;
	//Calculamos hasta qu nmero de pgina se mostrar
	$_pagi_nav_hasta = $_pagi_actual + $_pagi_nav_intervalo;
	
	//Ajustamos los valores anteriores en caso sean resultados no vlidos
	
	//Si $_pagi_nav_desde es un nmero negativo
	if($_pagi_nav_desde < 1){
		//Le sumamos la cantidad sobrante al final para mantener el nmero de enlaces que se quiere mostrar. 
		$_pagi_nav_hasta -= ($_pagi_nav_desde - 1);
		//Establecemos $_pagi_nav_desde como 1.
		$_pagi_nav_desde = 1;
	}
	//Si $_pagi_nav_hasta es un nmero mayor que el total de pginas
	if($_pagi_nav_hasta > $_pagi_totalPags){
		//Le restamos la cantidad excedida al comienzo para mantener el nmero de enlaces que se quiere mostrar.
		$_pagi_nav_desde -= ($_pagi_nav_hasta - $_pagi_totalPags);
		//Establecemos $_pagi_nav_hasta como el total de pginas.
		$_pagi_nav_hasta = $_pagi_totalPags;
		//Hacemos el ltimo ajuste verificando que al cambiar $_pagi_nav_desde no haya quedado con un valor no vlido.
		if($_pagi_nav_desde < 1){
			$_pagi_nav_desde = 1;
		}
	}
 }

 for ($_pagi_i = $_pagi_nav_desde; $_pagi_i<=$_pagi_nav_hasta; $_pagi_i++){//Desde pgina 1 hasta ltima pgina ($_pagi_totalPags)
    if ($_pagi_i == $_pagi_actual) {
		//Si el nmero de pgina es la actual ($_pagi_actual). Se escribe el nmero, pero sin enlace y en negrita.
		if ($_pagi_nav_hasta!=1)
			{
	        $_pagi_navegacion .= "<li><a href='#' class='pagAct'>" . $_pagi_i . "</a></li>";
			}
    }else{
		//Si es cualquier otro. Se escibe el enlace a dicho nmero de pgina.
        $_pagi_navegacion .= "<li><a href='".$_pagi_enlace."_pagi_pg=".$_pagi_i."'>".$_pagi_i."</a></li>";
    }
 }

 if ($_pagi_actual < $_pagi_totalPags){
	//Si no estamos en la ltima pgina. Ponemos el enlace "Siguiente"
    $_pagi_url = $_pagi_actual + 1;//ser el nmero de pgina al que enlazamos
//    $_pagi_navegacion .= "<li>&nbsp;de&nbsp;$_pagi_totalPags&nbsp;<a href='".$_pagi_enlace."_pagi_pg=".$_pagi_url."' class='txt' >Siguiente</a></li>";
    $_pagi_navegacion .= "<li><a href='".$_pagi_enlace."_pagi_pg=".$_pagi_url."' class='txt' >Siguiente</a></li>";
 }

//------------------------------------------------------------------------
/*
 * Obtencin de los registros que se mostrarn en la pgina actual.
 *------------------------------------------------------------------------
 */
 //Calculamos desde qu registro se mostrar en esta pgina
 //Recordemos que el conteo empieza desde CERO.
 $_pagi_inicial = ($_pagi_actual-1) * $_pagi_cuantos;
 
 //Consulta SQL. Devuelve $cantidad registros empezando desde $_pagi_inicial
 $_pagi_sqlLim = $_pagi_sql." LIMIT $_pagi_inicial,$_pagi_cuantos";
 $_pagi_result = $pagDb->query($_pagi_sqlLim);
 //Si ocurri error y mostrar errores est activado
 if($_pagi_result == false && $_pagi_mostrar_errores == true){
 	//die ("Error en la consulta limitada. Mysql dijo: <b>".mysql_error()."</b>");
 }

//------------------------------------------------------------------------


/*
 * Generacin de la informacin sobre los registros mostrados.
 *------------------------------------------------------------------------
 */
 //Nmero del primer registro de la pgina actual
 $desde = $_pagi_inicial + 1;
 
 //Nmero del ltimo registro de la pgina actual
 $hasta = $_pagi_inicial + $_pagi_cuantos;
 if($hasta > $_pagi_totalReg){
 	//Si estamos en la ltima pgina
	//El ultimo registro de la pgina actual ser igual al nmero de registros.
 	$hasta = $_pagi_totalReg;
 }
 
 //$_pagi_info = "desde el $desde hasta el $hasta de un total de $_pagi_totalReg";

//------------------------------------------------------------------------


/**
 * Variables que quedan disponibles despus de incluir el script va include():
 * ------------------------------------------------------------------------
 
 * $_pagi_result			Identificador del resultado de la consulta a la BD para los registros de la pgina actual. 
 							Listo para ser "pasado" por una funcin como mysql_fetch_row(), mysql_fetch_array(), 
							mysql_fetch_assoc(), etc.
							
 * $_pagi_navegacion		Cadena que contiene la barra de navegacin con los enlaces a las diferentes pginas.
 							Ejemplo: "<<anterior 1 2 3 4 siguiente>>".
							
 * $_pagi_info				Cadena que contiene informacin sobre los registros de la pgina actual.
 							Ejemplo: "desde el 16 hasta el 30 de un total de 123";				

*/
?>