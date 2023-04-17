<?
#CONSULTA PRINCIPAL PARA TODOS LOS METODOS
$qry = @mysqli_query($link, "   SELECT a.* FROM ticket a 
								WHERE a.cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "'
								AND a.cve_ticket='" . $IDPOST . "'" . $WHERE_SELECT);

#CANTIDAD DE ELEMENTOS ENCONTRADOS
$num = @mysqli_num_rows($qry);

#TODO ARREGLO DE LA INFORMACION
$row = @mysqli_fetch_array($qry);

###########################################################################################################################

if ($MODPOST == $idpm . '_estado') {


	$qry_status = @mysqli_query($link, "SELECT a.* FROM status a ");
	while ($row_status = @mysqli_fetch_array($qry_status)) {
		$option_options .= '<option value="' . $row_status["cve_status"] . ' ' . ($row_status["cve_status"] == $row["cve_statuscat"] ? 'selected' : '') . '">' . $row_status["descripcion"] . '</option>';
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

		$qryString =     " 	UPDATE ticket a SET 
								cve_statuscat		=	'" . addslashes($status) . "'
							WHERE  	cve_ticket	=	'" . $IDPOST . "'
							AND 	cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "' ";
	}

	echo response_json($link, $qryString, $IDPOST);
	exit;
}

###########################################################################################################################


if ($MODPOST == $idpm . '_editar') {

	$MDlFORM = '<div class="mb-3 row">
					<label class="col-sm-12 col-form-label">Reglamento:</label>
					<div class="col-sm-12">
						<textarea name="descripcion" class="form-control" rows="3"  minlength="5" maxlength="128">' . $row["descripcion"] . '</textarea>
					</div>
				</div>';

	echo response_modal($MDSIZE, $MDlFORM, $IDPOST, $IDPOST2, $MODPOST, $fileaction, $NPOPUP, $row["descripcion"], ($num > 0 ? 'Actualizar' : 'Agregar'));
	exit;
}


if ($MODPOST ==  $idpm . '_editar_save') {

	$descripcion    = strip_tags($_POST["descripcion"]);


	if ($num > 0) {
		$qryString =     " 	UPDATE ticket a SET 
								descripcion		=	'" . addslashes($descripcion) . "'
							WHERE  	cve_ticket	=	'" . $IDPOST . "'
							AND 	cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "' ";
	} elseif (isset($descripcion)) {
		$qryString =     " 	INSERT INTO ticket(
												fecha_sys, 
												cve_statuscat,
												cve_sysusuario,
												cve_condominio,
												descripcion
												) VALUES(
													'" . $fecha_sys . "',
													'1',
													'" . $_SESSION["CVE_SYSUSUARIO"] . "',
													'" . $_SESSION["CONDOMINIO"]["cve_condominio"] . "',
													'" . addslashes($descripcion) . "'
												)";
	}

	echo response_json($link, $qryString, $IDPOST);
	exit;
}
###########################################################################################################################

if ($_POST["draw"]) {

	" AND (
						UPPER(a.cve_ticket) LIKE UPPER('%" . $_POST["search"]["value"] . "%') 
						OR 	UPPER(a.descripcion) LIKE UPPER('%" . $_POST["search"]["value"] . "%')
					)";

	$qrystring = "	SELECT 
						a.*
					FROM ticket a
					WHERE a.cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "' AND a.cve_condominio='" . $_SESSION["CONDOMINIO"]["cve_condominio"] . "'"  . $where;


	$qrytotal = @mysqli_query($link, $qrystring);
	$num_rows_total = @mysqli_num_rows($qrytotal);


	//$where .= isset($_POST["order"]) ? " ORDER BY " . $_POST["order"]["0"]["column"] . ' ' . $_POST["order"]["0"]["dir"] : " ORDER BY a.cve_ticket DESC";

	$where .= ' ORDER BY a.cve_ticket DESC ' . ($_POST["length"] != -1 ? ' LIMIT ' . $_POST["start"] . ',' . $_POST["length"] : '');

	$qry = @mysqli_query($link, $qrystring . $where);
	$data;
	$num_rows = @mysqli_num_rows($qry);
	if ($num_rows > 0) {
		while ($row = @mysqli_fetch_array($qry)) {

			$id = $row[0];

			$array_buttons = [];

			$qry_departamento = @mysqli_query($link, 'SELECT a.* FROM departamento a WHERE a.cve_departamento ="' . $row["cve_departamento"] . '"');
			$row_departamento = @mysqli_fetch_array($qry_departamento);

			$qry_inquilino = @mysqli_query($link, 'SELECT a.* FROM inquilino a WHERE a.cve_inquilino ="' . $row["cve_inquilino"] . '"');
			$row_inquilino = @mysqli_fetch_array($qry_inquilino);


			array_push($array_buttons, ["info", "Editar", "fas fa-edit", "", "Editar ticket", "2", $idpm . "_editar", $fileaction]);
			array_push($array_buttons, ["info", "Estado", "fas fa-check-circle pr-1", "", "Cambiar el status", "0", $idpm . "_estado", $fileaction]);

			$data[] = [
				'<div>
					<strong>Id: </strong>' . $id . '
				</div>',
				'<div class="">
					<strong>Detalle:</strong>' . $row["descripcion"] . '<br>
					<strong>Descripción:</strong>' . $row["descripcion"] . '<br>
					<strong>Notas:</strong>' . $row["descripcion"] . '
				</div>',
				'<div>
					<strong>Habitación:</strong> ' . $row_departamento["num_habitacion"] . ' <strong>Piso:</strong>' . $row_departamento["num_piso"] . '<br>
					<strong>Observaciones:</strong> ' . $row_departamento["descripcion"]  . '<br>
				</div>',
				'<div>
					<strong>Nombre(s):</strong> ' . $row_inquilino["nombre"] . '<br>
					<strong>Apellido(s):</strong> ' . $row_inquilino["apellidopat"] . ' ' . $row_inquilino["apellidomat"] . '<br>
					<strong>Teléfono:</strong> ' . $row_inquilino["telefono"] . '
				</div>',
				ModBtns($id, $array_buttons),
				Modstatus($row["cve_statuscat"], '', $link)
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