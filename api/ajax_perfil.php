<?
$qry = @mysqli_query($link, "	SELECT * FROM sysusuario a
	WHERE a.cve_statuscat=1
	AND   a.CVE_SYSUSUARIO='" . $_SESSION["CVE_SYSUSUARIO"] . "'");
$row = @mysqli_fetch_array($qry);


if ($MODPOST == 'conctacto_save' and $_SESSION["CVE_SYSUSUARIO"] >= 1) {

	$array_attr = ["nombre", "telefono", "email"];

	for ($i = 0; $i < count($array_attr); $i++) {
		$attr .= $array_attr[$i] . " = '" . addslashes(strip_tags($_POST[$array_attr[$i]])) . "',";
	}

	$qrystring = " 	UPDATE sysusuario 
					SET " . trim($attr, ",") . " 
					WHERE cve_statuscat=1
					AND   cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "'";

	echo response_json($link, $qrystring, $_SESSION["CVE_SYSUSUARIO"]);
	exit;
}
###########################################################################################################################

if ($MODPOST == 'accesos_save' and $_SESSION["CVE_SYSUSUARIO"] >= 1) {

	$array_attr = ["usuario", "pdws"];

	for ($i = 0; $i < count($array_attr); $i++) {
		$attr .= $array_attr[$i] . " = '" . addslashes(strip_tags($_POST[$array_attr[$i]])) . "',";
	}

	$qrystring = " 	UPDATE sysusuario 
					SET " . trim($attr, ",") . " 
					WHERE cve_statuscat=1
					AND   cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "'";

	echo response_json($link, $qrystring, $_SESSION["CVE_SYSUSUARIO"]);
	exit;
}
###########################################################################################################################

if ($MODPOST == 'firma_save' and $_SESSION["CVE_SYSUSUARIO"] >= 1) {

	$array_attr = ["descripcion"];

	for ($i = 0; $i < count($array_attr); $i++) {
		$attr .= $array_attr[$i] . " = '" . addslashes(strip_tags($_POST[$array_attr[$i]])) . "',";
	}

	$qrystring = " 	UPDATE mmafoot 
					SET " . trim($attr, ",") . " 
					WHERE cve_statuscat=1
					AND   cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "'";

	echo response_json($link, $qrystring, $_SESSION["CVE_SYSUSUARIO"]);

	exit;
}
###########################################################################################################################

if ($MODPOST == 'empresa_save' and $_SESSION["CVE_SYSUSUARIO"] >= 1) {

	$array_attr = ["empresa", "telefono", "email", "website", "descempresa", "observaciones"];

	for ($i = 0; $i < count($array_attr); $i++) {
		$attr .= $array_attr[$i] . " = '" . addslashes(strip_tags($_POST[$array_attr[$i]])) . "',";
	}

	$qrystring = " 	UPDATE sysusuarioperfil 
					SET " . trim($attr, ",") . " 
					WHERE cve_statuscat=1
					AND   cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "'";

	echo response_json($link, $qrystring, $_SESSION["CVE_SYSUSUARIO"]);
	exit;
}
###########################################################################################################################

if ($MODPOST == 'keyworks_save' and $_SESSION["CVE_SYSUSUARIO"] >= 1) {

	$array_attr = ["titulo", "keypagina"];

	for ($i = 0; $i < count($array_attr); $i++) {
		$attr .= $array_attr[$i] . " = '" . addslashes(strip_tags($_POST[$array_attr[$i]])) . "',";
	}

	$qrystring = " 	UPDATE sysusuarioperfil 
					SET " . trim($attr, ",") . " 
					WHERE cve_statuscat=1
					AND   cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "'";

	echo response_json($link, $qrystring, $_SESSION["CVE_SYSUSUARIO"]);
	exit;
}
###########################################################################################################################