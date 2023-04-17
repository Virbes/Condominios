<? $idpm = strip_tags($_GET["idpm"]);

include("./../home/include/conn.php");
include("funciones.php");
$form_redirect = str_replace('nia', 'ña', $idpm) . '.php';
$fileaction = '/' . $idpm . '/';
$MODPOST    = strip_tags($_POST["MODPOST"]);   /* ID ELEMENTO/OBTJETO/REGISTRO DE QUERY USADO PARA EL COMPONENTE PARA MODIFICAR O INSERTAR DATOS*/
$IDPOST     = strip_tags($_POST["IDPOST"]);  /* ES EL ID DEL DETALLE*/
$IDPOST2    = strip_tags($_POST["IDPOST2"]); /* ES EL ID DEL DETALLE*/
$MDSIZE     = trim($_POST["nrel"]); #TAMAÑO DEL MODAL
$NPOPUP     = strip_tags($_POST["npopup"]); #DESCRIPCION DEL MODAL

header("Content-Type: application/json;charset=utf-8");
if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) and strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
	echo "error... acceso no valido";
	header('location: /');
	exit;
}

$OPTIONS_HIDDEN = ' <input type="hidden" id="IDPOST"  		name="IDPOST" value="' . $IDPOST . '" />
					<input type="hidden" id="IDPOST2" 		name="IDPOST2" value="' . $IDPOST2 . '" />
					<input type="hidden" id="MODPOST" 		name="MODPOST" value="' . $MODPOST . '_save" />
					<input type="hidden" id="form_file" 	name="form_file" value="' . $fileaction . '" alt="Nombre de archivo PHP donde se guarda(solo nombre .php)" />
					<input type="hidden" id="form_redirect" name="form_redirect" value="' . $form_redirect . '" alt="Nombre PHP donde estan todos los datos" />
					<input type="hidden" id="form_act" 		name="form_act" value="1" alt="0=redirect al contenido, 1= se hace un load al contenido, 2=Llamada a funcion" />';

//if ($_SESSION["CVE_SYSUSUARIO"] > 0) {
	include("ajax_" . $idpm . ".php");
//}
#SE ACTIVA EN CASO DE NO ENTAR ALGUN ARCHIVO O QUE LA SESSION HAYA CADUCADO
echo $modalerror;
