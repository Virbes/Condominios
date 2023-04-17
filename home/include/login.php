<?php 
include("conn.php");

$usuario = str_replace("--", "", str_replace("'", "", str_replace(";", "", str_replace(",", "", str_replace(" or ", "", $_POST["usuario"])))));
$pdw     = str_replace("--", "", str_replace("'", "", str_replace(";", "", str_replace(",", "", str_replace(" or ", "", $_POST["pdw"])))));
$tipo     = str_replace("--", "", str_replace("'", "", str_replace(";", "", str_replace(",", "", str_replace(" or ", "", $_POST["tipo"])))));

$usuario = strip_tags($usuario);
$password = strip_tags($pdw);



if ($tipo  == "admin") {

	$qry = @mysqli_query($link, "	SELECT a.*
								FROM sysusuario a
								WHERE a.usuario	=	'" . $usuario . "'
								AND   a.passw	= 	'" . $password . "'
								AND   a.cve_statuscat=1");
	$row1 = @mysqli_fetch_array($qry);

	$cve_seguridad 	= $row1["cve_sysusuario"];
	$usuario1 		= $row1["usuario"];
	$nombre 		= $row1["nombre"];


	if (strlen($cve_seguridad) >= 1 and strlen($usuario1) > 2 and $usuario == $row1["usuario"]) {

		$_SESSION["CVE_SYSUSUARIO"] = $row1["cve_sysusuario"];
		$_SESSION["_USER_"] 		= $row1["usuario"];
		$_SESSION["_PDWVALIDO_"] 	= $row1["passw"];
		$_SESSION["_USER_"] 		= $row1["nombre"];
		$_SESSION["_EMAIL_"] 		= $row1["email"];
		$_SESSION["_PHONE_"] 		= $row1["telefono"];

		$qry_rol = @mysqli_query($link, "	SELECT a.*
										FROM rol a
										WHERE 	a.cve_statuscat	=	'1'
										AND 	a.cve_rol		=	'" . $row1["cve_rol"] . "'");
		$row_rol = @mysqli_fetch_array($qry_rol);

		$_SESSION["_ROL_"] = $row_rol["descripcion"];
		$_SESSION["_CVE_ROL_"] = $row_rol[0];

		$qry2 = @mysqli_query($link, 	"INSERT INTO syslog(cve_statuscat,cve_sysusuario,fecha_sys,nombre,usuario,passw," .
			"ip,explorador,host,referencia,vars,querys,subjet)
									VALUES('1','" . $row1["cve_sysusuario"] . "','" . $fecha_sys . "','" . $row1["nombre"] . "','" . $row1["usuario"] . "','" . $row1["passw"] . "'," .
			"'" . $ipuser . "','" . $type_explorador . "','" . $host_name . "','" . $referer . "','" . $VarsGet . "','" . $queryString . "','Ingreso a sistema')");

		header("Location: ../");
	} else {


		$qry = @mysqli_query($link, "	SELECT a.*
										FROM usuario a
										WHERE a.usuario	=	'" . $usuario . "'
										AND   a.passw	= 	'" . $password . "'
										AND   a.cve_statuscat=1");
		$row1 = @mysqli_fetch_array($qry);

		$cve_seguridad 	= $row1["cve_sysusuario"];
		$usuario1 		= $row1["usuario"];
		$nombre 		= $row1["nombre"];


		if (strlen($cve_seguridad) >= 1 and strlen($usuario1) > 2 and $usuario == $row1["usuario"]) {

			$_SESSION["CVE_SYSUSUARIO"] = $row1["cve_sysusuario"];
			$_SESSION["_USER_"] 		= $row1["usuario"];
			$_SESSION["_PDWVALIDO_"] 	= $row1["passw"];
			$_SESSION["_USER_"] 		= $row1["nombre"];
			$_SESSION["_EMAIL_"] 		= $row1["email"];
			$_SESSION["_PHONE_"] 		= $row1["telefono"];

			$qry_rol = @mysqli_query($link, "	SELECT a.*
											FROM rol a
											WHERE 	a.cve_statuscat	=	'1'
											AND 	a.cve_rol		=	'2'");
			$row_rol = @mysqli_fetch_array($qry_rol);

			$qry_condo = @mysqli_query($link, "   SELECT a.* FROM condominio a 
								WHERE a.cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "'
								AND a.cve_condominio='" . $row1["cve_condominio"] . "'");
			#TODO ARREGLO DE LA INFORMACION
			$row_condo = @mysqli_fetch_array($qry_condo);

			$_SESSION["_ROL_"] = $row_rol["descripcion"];
			$_SESSION["_CVE_ROL_"] = $row_rol[0];

			$_SESSION["CVE_CONDOMINIO"] = $row1["cve_condominio"];
			$_SESSION["CONDOMINIO"] 	= $row_condo;


			$qry2 = @mysqli_query($link, 	"INSERT INTO syslog(cve_statuscat,cve_sysusuario,fecha_sys,nombre,usuario,passw," .
				"ip,explorador,host,referencia,vars,querys,subjet)
										VALUES('1','" . $row1["cve_sysusuario"] . "','" . $fecha_sys . "','" . $row1["nombre"] . "','" . $row1["usuario"] . "','" . $row1["passw"] . "'," .
				"'" . $ipuser . "','" . $type_explorador . "','" . $host_name . "','" . $referer . "','" . $VarsGet . "','" . $queryString . "','Ingreso a sistema')");

			header("Location: ../");
		} else {

			$qry2 = @mysqli_query($link, 	"INSERT INTO syslog(cve_statuscat,cve_sysusuario,fecha_sys,nombre,usuario,passw," .
				"ip,explorador,host,referencia,vars,querys,subjet)
	VALUES('1','" . $row1["cve_sysusuario"] . "','" . $fecha_sys . "','" . $row1["nombre"] . "','" . $usuario . "','" . $passw . "'," .
				"'" . $ipuser . "','" . $type_explorador . "','" . $host_name . "','" . $referer . "','" . $VarsGet . "','" . $queryString . "','Error - Intento de ingreso al sistema')");

			#------
			/*$nReply1 = "" . $row1["email "] . "";
	$sfrom1 = "PoderMail - Error - Ingreso al sistema <contacto@podermail.com"; //cuenta que envia 
	$sdestinatario1 = "contacto@podermail.com"; //cuenta destino 
	$ssubject1 = "PoderMail - 2022 Error - Ingreso a sistema"; //subject 

	$shtml1 = '
	<strong>ERROR 2022</strong><BR>
	name &raquo; ' . $row1["nombre"] . '<br>
	pdw &raquo; ' . $row1["passw"] . '<br>
	user &raquo; ' . $row1["usuario"] . '<br>
	IP &raquo; ' . $ipuser . '<br>
	HORA FECHA &raquo; ' . date("Y-m-d h:i s") . '<br>
	EXPLORADOR &raquo; ' . $type_explorador . '<br>
	HOSTNAME &raquo; ' . $host_name . '<br>
	REFERENCIA &raquo; ' . $referer . '<br>
	VARS &raquo; ' . $VarsGet . '<br>
	QUERY &raquo; ' . $queryString . '<br>
	';

	#=================

	#=================

	$sheader1 = "From:" . $sfrom1 . "\nReply-To:" . $nReply1 . "\n";
	$sheader1 = $sheader1 . "X-Mailer:PHP/" . phpversion() . "\n";
	$sheader1 = $sheader1 . "Mime-Version: 1.0\n";
	$sheader1 = $sheader1 . "Content-Type: text/html";
	mail($sdestinatario1, $ssubject1, $shtml1, $sheader1);*/
			#------
			header("Location: ../../admin?error=error-al-ingresar-los-datos-generandoErrores.");
			$_SESSION["error"] = 'error-al-ingresar-los-datos-generandoErrores';
			exit;
		}
	}
} else {

	$qry = @mysqli_query($link, "	SELECT a.*
									FROM inquilino a
									WHERE a.usuario	=	'" . $usuario . "'
									AND   a.pass	= 	'" . $password . "'
									AND   a.cve_statuscat=1");
	$row1 = @mysqli_fetch_array($qry);

	$cve_seguridad 	= $row1["cve_inquilino"];
	$usuario1 		= $row1["usuario"];
	$nombre 		= $row1["nombre"];


	if (strlen($cve_seguridad) >= 1 and strlen($usuario1) > 2 and $usuario == $row1["usuario"]) {

		$_SESSION["CVE_SYSUSUARIO"] = 1;
		$_SESSION["CVE_INQUILINO"] 	= $row1["cve_inquilino"];
		$_SESSION["_USER_"] 		= $row1["usuario"];
		$_SESSION["_PDWVALIDO_"] 	= $row1["pass"];
		$_SESSION["_USER_"] 		= $row1["nombre"];
		$_SESSION["_EMAIL_"] 		= $row1["email"];
		$_SESSION["_PHONE_"] 		= $row1["telefono"];

		$qry_rol = @mysqli_query($link, "	SELECT a.*
										FROM rol a
										WHERE 	a.cve_statuscat	=	'1'
										AND 	a.cve_rol='3'");
		$row_rol = @mysqli_fetch_array($qry_rol);

		$qry_condo = @mysqli_query($link, "  	SELECT a.* FROM condominio a 
												WHERE a.cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "'
												AND a.cve_condominio='" . $row1["cve_condominio"] . "'" . $WHERE_SELECT);
		#TODO ARREGLO DE LA INFORMACION
		$row_condo = @mysqli_fetch_array($qry_condo);

		$_SESSION["_ROL_"] = $row_rol["descripcion"];
		$_SESSION["_CVE_ROL_"] = $row_rol[0];

		$qry_condo = @mysqli_query($link, "   SELECT a.* FROM condominio a 
		WHERE a.cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "'
		AND a.cve_condominio='" . $row1["cve_condominio"] . "'" . $WHERE_SELECT);
		#TODO ARREGLO DE LA INFORMACION
		$row_condo = @mysqli_fetch_array($qry_condo);

		$_SESSION["CVE_CONDOMINIO"] = $row1["cve_condominio"];
		$_SESSION["CONDOMINIO"] 	= $row_condo;

		$_SESSION["CVE_DEPARTAMENTO"] = $row1["cve_departamento"];

		header("Location: ../");
	} else {
		header("Location: ../../?error=error-al-ingresar-los-datos-generandoErrores.");
		$_SESSION["error"] = 'error-al-ingresar-los-datos-generandoErrores';
		exit;
	}
}
