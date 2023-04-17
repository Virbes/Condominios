<?
#CONSULTA PRINCIPAL PARA TODOS LOS METODOS
$qry = @mysqli_query($link, "   SELECT a.* FROM departamento a 
								WHERE a.cve_statuscat IN (1,2)
								AND a.cve_departamento='" . $IDPOST . "'
								AND a.cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "'");

#CANTIDAD DE ELEMENTOS ENCONTRADOS
$num = @mysqli_num_rows($qry);

#TODO ARREGLO DE LA INFORMACION
$row = @mysqli_fetch_array($qry);

###########################################################################################################################

if ($MODPOST == $idpm . '_editar') {

	$MDlFORM = '<div class="mb-3 row">
					<label class="col-sm-12 col-form-label">Descripcion:*</label>
					<div class="col-sm-12">
						<input type="text" class="form-control" name="nombre" value="' . $row["descripcion"] . '" required="" minlength="5" maxlength="128">
					</div>
					<label class="col-sm-12 col-form-label">Núm:*</label>
					<div class="col-sm-12">
						<input type="text" class="form-control" name="num" value="' . $row["num"] . '" required="" minlength="5" maxlength="64">
					</div>
					<label class="col-sm-12 col-form-label">Núm. piso:*</label>
					<div class="col-sm-12">
						<input type="number" class="form-control" name="num_piso" value="' . $row["num_piso"] . '" required="" minlength="1" maxlength="10">
					</div>
				</div>';

	echo response_modal($MDSIZE, $MDlFORM, $IDPOST, $IDPOST2, $MODPOST, $fileaction, $NPOPUP, $row["nombre"], ($num > 0 ? 'Actualizar' : 'Agregar'));
	exit;
}


if ($MODPOST ==  $idpm . '_editar_save') {

	$nombre    	= strip_tags($_POST["nombre"]);
	$email   	= strip_tags($_POST["email"]);
	$telefono  	= strip_tags($_POST["telefono"]);



	/*if ($num > 0) {
		$qryString =     " 	UPDATE departamento a SET 
								nombre		=	'" . addslashes($nombre) . "',
								email		=	'" . addslashes($email) . "',
								telefono	=	'" . addslashes($telefono) . "'
							WHERE cve_departamento	=	'" . $IDPOST . "'
							AND cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "'";
	} elseif (isset($descripcion)) {
		$qryString =     " 	INSERT INTO departamento(
												fecha_sys, 
												cve_statuscat,
												cve_sysusuario,
												cve_rol,
												nombre, 
												email, 
												telefono
												) VALUES(
													'" . $fecha_sys . "',
													'1',
													'" . $_SESSION["CVE_SYSUSUARIO"] . "',
													'3',
													'" . addslashes($nombre) . "',
													'" . addslashes($email) . "',
													'" . addslashes($telefono) . "'
												)";
	}*/


	echo response_json($link, $qryString, $IDPOST);
	exit;
}

###########################################################################################################################

if ($_POST["draw"]) {
	/*
	$where .= " AND (
						UPPER(a.nombre) LIKE UPPER('%" . $_POST["search"]["value"] . "%') 
						OR 	UPPER(a.confirmacion) LIKE UPPER('%" . $_POST["search"]["value"] . "%')
						OR 	UPPER(a.cve_departamento) LIKE UPPER('%" . $_POST["search"]["value"] . "%')
						OR 	UPPER(a.telefono) LIKE UPPER('%" . $_POST["search"]["value"] . "%')
						OR 	UPPER(a.email) LIKE UPPER('%" . $_POST["search"]["value"] . "%')
					)";
*/
	$qrystring = "	SELECT 
						a.*
					FROM departamento a
					WHERE a.cve_statuscat='1'
					AND a.cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "' "  . $where;


	$qrytotal = @mysqli_query($link, $qrystring);
	$num_rows_total = @mysqli_num_rows($qrytotal);


	#$where .= isset($_POST["order"]) ? " ORDER BY " . $_POST["order"]["0"]["column"] . ' ' . $_POST["order"]["0"]["dir"] : " ORDER BY cve_departamento DESC";
	$where .= $_POST["length"] != -1 ? ' LIMIT ' . $_POST["start"] . ',' . $_POST["length"] : '';

	$qry = @mysqli_query($link, $qrystring . $where);
	$data;
	$num_rows = @mysqli_num_rows($qry);
	if ($num_rows > 0) {
		while ($row = @mysqli_fetch_array($qry)) {


			$qry_inquilino = @mysqli_query($link, "");


			$qry_condominio = @mysqli_query($link, 'SELECT a.* FROM condominio a WHERE a.cve_condominio ="' . $row["cve_condominio"] . '"');
			$row_condominio = @mysqli_fetch_array($qry_condominio);


			$qry_inquilino = @mysqli_query($link, 'SELECT a.* FROM inquilino a WHERE a.cve_departamento ="' . $row["cve_departamento"] . '"');
			$row_inquilino = @mysqli_fetch_array($qry_inquilino);

			$id = $row[0];



			$array_buttons = [];

			/** INDICE DE ESTATUS
			 * 0 SIN PAGAR
			 */
			array_push($array_buttons, ["info", "Editar", "fas fa-edit", "", "Editar condominio", "2",  $idpm . "_editar", $fileaction]);
			array_push($array_buttons, ["info", "Servicios", 			"fas fa-sticky-note", 		"", "", 				"0", $idpm . "_", $fileaction]);
			array_push($array_buttons, ["info", "Pagos", 				"fas fa-sticky-note", 		"", "", 				"0", $idpm . "_", $fileaction]);
			array_push($array_buttons, ["info", "Detalles inquilino", 	"fas fa-check-circle", "", "Cambiar el status", "0", $idpm . "_estado", $fileaction]);
			array_push($array_buttons, ["info", "Historial", 			"fas fa-check-circle", "", "Cambiar el status", "0", $idpm . "_estado", $fileaction]);



			$data[] = [
				'<div>
					<strong>Id: </strong>' . $id . '
				</div>',
				'<div>
					<strong>Núm:</strong>' . $row["num"] . ' <strong>Piso:</strong>' . $row["num_piso"] . '<br>
					<strong>Condominio:</strong>' . $row_condominio["descripcion"] . '<br>
					<strong>Descripción:</strong>' . $row["descripcion"] . '<br>
					<hr>
					<strong>Alquiler:</strong>' . Format_current($row["precio"], '') . '<br>
				</div>',
				'<div>
					<strong>Nombre(s):</strong> ' . $row_inquilino["nombre"] . '<br>
					<strong>Apellido(s):</strong> ' . $row_inquilino["apellidopat"] . ' ' . $row_inquilino["apellidomat"] . '<br>
					<strong>Teléfono:</strong> ' . $row_inquilino["telefono"] . '
				</div>',
				'',
				'<div>
					<span style="font-style:italic;color:#F30; cursor:default;" > 
						<strong><b>Pagos:</b></strong> ' . $row["origen"] . '
					</span>
				</div>',
				'<div class="mt-2">' . ModBtns($id, $array_buttons) . '</div>',
				Modstatus($row["cve_statuscat"], '', $link) . '<hr><div class="text-center"> Departamento <br>' . ($row_inquilino["nombre"] ? 'Ocupado' : 'Disponible') . '</div>'
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