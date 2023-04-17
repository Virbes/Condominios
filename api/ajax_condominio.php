<?
#CONSULTA PRINCIPAL PARA TODOS LOS METODOS
$qry = @mysqli_query($link, "   SELECT a.* FROM condominio a 
								WHERE a.cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "'
								AND a.cve_condominio='" . $IDPOST . "'" . $WHERE_SELECT);

#CANTIDAD DE ELEMENTOS ENCONTRADOS
$num = @mysqli_num_rows($qry);

#TODO ARREGLO DE LA INFORMACION
$row = @mysqli_fetch_array($qry);

###########################################################################################################################

if ($MODPOST == $idpm . '_estado') {


	$qry_status = @mysqli_query($link, "SELECT a.* FROM condominiostatus a WHERE a.cve_statuscat='1'");
	while ($row_status = @mysqli_fetch_array($qry_status)) {
		$option_options .= '<option value="' . $row_status["cve_condominiostatus"] . ' ' . ($row_status["cve_condominiostatus"] == $row["cve_statuscat"] ? 'selected' : '') . '">' . $row_status["descripcion"] . '</option>';
	}

	$MDlFORM = '<div class="mb-3 row">
					<label class="col-sm-12 col-form-label">Estado del condomnio:*</label>
					<div class="col-sm-12">
						<select class="form-control" name="status"  required="">
							' . $option_options . '
						</select>
					</div>
				</div>';

	echo response_modal($MDSIZE, $MDlFORM, $IDPOST, $IDPOST2, $MODPOST, $fileaction, $NPOPUP, $row["descripcion"], ($num > 0 ? 'Actualizar' : 'Agregar'));
	exit;
}


if ($MODPOST ==  $idpm . '_estado_save') {

	$status    = strip_tags($_POST["status"]);
	if ($num > 0) {

		$qryString =     " 	UPDATE condominio a SET 
								cve_statuscat		=	'" . addslashes($status) . "'
							WHERE  	cve_condominio	=	'" . $IDPOST . "'
							AND 	cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "' ";
	}

	echo response_json($link, $qryString, $IDPOST);
	exit;
}

###########################################################################################################################

if ($MODPOST == $idpm . '_administrar') {

	$MDlFORM = '<div class="mb-3 row">
					<h3 class="col-sm-12  py-5 text-center"> Acceder al panel del condominio</h3>
				</div>';
	echo response_modal($MDSIZE, $MDlFORM, $IDPOST, $IDPOST2, $MODPOST, $fileaction, $NPOPUP, $row["descripcion"], "Acceder");
	exit;
}

if ($MODPOST == $idpm . '_administrar_save') {

	if ($num > 0) {
		$_SESSION["CVE_CONDOMINIO"] = $IDPOST;
		$_SESSION["CONDOMINIO"] 	= $row;
	}

	$json["r_"] = $num > 0 ? array(
		'OutVal' => 'Listo',
		'Icon' => 'fas fa-check',
		'Val' => $val,
		'html' => '<script>window.location.reload();</script>'
	) : array(
		'OutVal' => 'Error',
		'Icon' => 'fas fa-exclamation-triangle',
		'Val' => $val,
		'Id' => $IDPOST
	);

	echo  json_encode($json);
	exit;
}

###########################################################################################################################

if ($MODPOST == $idpm . '_editar') {

	$MDlFORM = '<div class="mb-3 row">
					<div class="col-12 col-md-6">
						<label class="col-sm-12 col-form-label">Nombre:*</label>
						<div class="col-sm-12">
							<input type="text" class="form-control" name="descripcion" value="' . $row["descripcion"] . '" required="" minlength="5" maxlength="64">
						</div>
						<label class="col-sm-12 col-form-label">Ubicación:*</label>
						<div class="col-sm-12">
							<textarea name="ubicacion" class="form-control" rows="3" required=""  minlength="5" maxlength="128">' . $row["ubicacion"] . '</textarea>
						</div>
						<label class="col-sm-12 col-form-label">Observaciones:</label>
						<div class="col-sm-12">
							<textarea name="observaciones" class="form-control" rows="3"  minlength="5" maxlength="128">' . $row["observaciones"] . '</textarea>
						</div>
					</div>
					<div class="col-12 col-md-6">
						 ' . ($row["imagen"] ? '<img src="' . $row["imagenruta"] . '' . $row["imagen"] . '" class="img-thumbnail  pt-2" alt="' . $row["descripcion"] . '">' : '') . '
						<div class="input-group ">
							<label class="col-sm-12 col-form-label">Imagen:</label>
							<div class="custom-file">
								<input type="file" class="custom-file-input form-control" id="inputGroupFile02" name="imagenfile" ' . ($num == 0 ? 'required' : '') . '>
								<label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Archivo</label>
							</div>
						</div>
					</div>
				</div>';

	echo response_modal($MDSIZE, $MDlFORM, $IDPOST, $IDPOST2, $MODPOST, $fileaction, $NPOPUP, $row["descripcion"], ($num > 0 ? 'Actualizar' : 'Agregar'));
	exit;
}


if ($MODPOST ==  $idpm . '_editar_save') {

	$descripcion    = strip_tags($_POST["descripcion"]);
	$ubicacion   	= strip_tags($_POST["ubicacion"]);
	$observaciones  = strip_tags($_POST["observaciones"]);



	if ($num > 0) {
		$qryString =     " 	UPDATE condominio a SET 
								descripcion		=	'" . addslashes($descripcion) . "',
								observaciones	=	'" . addslashes($observaciones) . "'
							WHERE  	cve_condominio	=	'" . $IDPOST . "'
							AND 	cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "' ";
	} elseif (isset($descripcion)) {
		$qryString =     " 	INSERT INTO condominio(
												fecha_sys, 
												cve_statuscat,
												cve_sysusuario, 
												descripcion, 
												ubicacion, 
												observaciones
												) VALUES(
													'" . $fecha_sys . "',
													'1',
													'" . $_SESSION["CVE_SYSUSUARIO"] . "',
													'" . addslashes($descripcion) . "',
													'" . addslashes($ubicaciones) . "',
													'" . addslashes($observaciones) . "'
												)";
	}

	$ruta                 = './../img-condominios/';
	$rutaimg_local         = '/img-condominios/';
	echo response_json_imagen($link, $qryString, $IDPOST, 1200, 800, $ruta, $rutaimg_local, 'condominio');
	exit;
}
###########################################################################################################################

if ($MODPOST == $idpm . '_editar_maps') {

	$MDlFORM = '<div class="mb-3 row">
					<label class="col-sm-12 col-form-label">Codígo del mapa en google:*</label>
					<div class="col-sm-12">
						<textarea name="maps_code" class="form-control" rows="3" required=""  minlength="5" maxlength="500">' . $row["maps_code"] . '</textarea>
					</div>
				</div>';

	echo response_modal($MDSIZE, $MDlFORM, $IDPOST, $IDPOST2, $MODPOST, $fileaction, $NPOPUP, $row["descripcion"], ($num > 0 ? 'Actualizar' : 'Agregar'));
	exit;
}


if ($MODPOST ==  $idpm . '_editar_maps_save') {

	$maps_code    = ($_POST["maps_code"]);

	if ($num > 0) {
		$qryString =     " 	UPDATE condominio a SET 
								maps_code		=	'" . addslashes($maps_code) . "'
							WHERE  	cve_condominio	=	'" . $IDPOST . "'
							AND 	cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "' ";
	}
	echo response_json($link, $qryString, $IDPOST);
	exit;
}

###########################################################################################################################

if ($_POST["draw"]) {

	/*	$where .= " AND (
						UPPER(a.nombre) LIKE UPPER('%" . $_POST["search"]["value"] . "%') 
						OR 	UPPER(a.cve_condominio) LIKE UPPER('%" . $_POST["search"]["value"] . "%')
						OR 	UPPER(a.telefono) LIKE UPPER('%" . $_POST["search"]["value"] . "%')
						OR 	UPPER(a.email) LIKE UPPER('%" . $_POST["search"]["value"] . "%')
					)";*/

	$qrystring = "	SELECT 
						a.*
					FROM condominio a
					WHERE a.cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "' "  . $where;


	$qrytotal = @mysqli_query($link, $qrystring);
	$num_rows_total = @mysqli_num_rows($qrytotal);


	#$where .= isset($_POST["order"]) ? " ORDER BY " . $_POST["order"]["0"]["column"] . ' ' . $_POST["order"]["0"]["dir"] : " ORDER BY cve_mmaenviomail DESC";
	$where .= $_POST["length"] != -1 ? ' LIMIT ' . $_POST["start"] . ',' . $_POST["length"] : '';

	$qry = @mysqli_query($link, $qrystring . $where);
	$data;
	$num_rows = @mysqli_num_rows($qry);
	if ($num_rows > 0) {
		while ($row = @mysqli_fetch_array($qry)) {
			$cliente = $servicio = $fechas = $paxs = $costos = $btns = $confirmacion = $notas = '';


			$id = $row[0];

			$array_buttons = [];

			/** INDICE DE PAGOS
			 * 0 SIN PAGAR <i class="e"></i>
			 */
			array_push($array_buttons, ["info", "Editar", "fas fa-edit", "", "Editar condominio", "2", $idpm . "_editar", $fileaction]);
			array_push($array_buttons, ["info", "Actualizar maps", "fas fa-map-marked", "", "Agregar notas a la reservación", "0",  $idpm . "_editar_maps", $fileaction]);
			array_push($array_buttons, ["info", "Administrar", "fas fa-users-cog", "", "Acceder en condominio", "0", $idpm . "_administrar", $fileaction]);
			array_push($array_buttons, ["info", "Estado", "fas fa-check-circle pr-1", "", "Cambiar el status", "0", $idpm . "_estado", $fileaction]);

			$qry_inquilon = @mysqli_query($link, " SELECT a.* FROM inquilino WHERE a.cve_statuscat='1' AND a.cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "' AND a.cve_con");

			$data[] = [
				'<div>
					<strong>Id: </strong>' . $id . '
				</div>',
				'<div class="py-5">
					<img src="' . $row["imagenruta"] . '' . $row["imagen"] . '"	 class="img-fluid m-auto  rounded mx-auto">
				</div>',
				'<div>
					<strong>Nombre: </strong>' . $row["descripcion"] . '
				</div>
				<div>
					<strong>Observaciones: </strong>' . $row["descripcion"] . '
				</div>
				<hr>
				<div>
					<strong>Inquilos:</strong> ' . $row[""] . '
				</div>
				<div>
					<strong>Departamento:</strong> ' . $row[""] . '
				</div>
				',
				'<div class="d-flex mx-auto" style="overflow: auto;max-height: 25vh; width:500px;">' . $row["maps_code"] . '</div>',
				ModBtns($id, $array_buttons),
				Modstatus($row["cve_statuscat"], 'condominio', $link)
			];
		}
	} else {
		$data[] = ["", '', '', '', '', '', ''];
	}

	$array_data = array("draw" => intval($_POST["draw"]), "recordsTotal", $num_rows, "recordsFiltered" => $num_rows_total, "data" => $data);
	echo  json_encode($array_data);
	exit;
}
###########################################################################################################################