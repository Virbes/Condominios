<?
#CONSULTA PRINCIPAL PARA TODOS LOS METODOS
$qry = @mysqli_query($link, "   SELECT a.* FROM usuario a 
								WHERE a.cve_statuscat IN(1,2) 
								AND a.cve_usuario='" . $IDPOST . "'
								AND cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "'");

#CANTIDAD DE ELEMENTOS ENCONTRADOS
$num = @mysqli_num_rows($qry);

#TODO ARREGLO DE LA INFORMACION
$row = @mysqli_fetch_array($qry);

###########################################################################################################################

if ($MODPOST == $idpm . '_estado') {


	$qry_status = @mysqli_query($link, "SELECT a.* FROM status a");
	while ($row_status = @mysqli_fetch_array($qry_status)) {
		$option_options .= '<option value="' . $row_status["cve_status"] . '" ' . ($row_status["cve_status"] == $row["cve_statuscat"] ? 'selected' : '') . '>' . $row_status["descripcion"] . '</option>';
	}

	$MDlFORM = '<div class="mb-3 row">
					<label class="col-sm-12 col-form-label">Estado del condomnio:*</label>
					<div class="col-sm-12">
						<select class="form-control" name="status"  required="">
							' . $option_options . '
						</select>
					</div>
				</div>';

	echo response_modal($MDSIZE, $MDlFORM, $IDPOST, $IDPOST2, $MODPOST, $fileaction, $NPOPUP, $row["descripcion"], 'Actualizar');
	exit;
}


if ($MODPOST ==  $idpm . '_estado_save') {

	$status    = strip_tags($_POST["status"]);
	if ($num > 0) {

		$qryString =     " 	UPDATE  usuario SET 
								cve_statuscat		=	'" . addslashes($status) . "'
							WHERE  	cve_usuario	=	'" . $IDPOST . "'
							AND 	cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "' ";
	}

	echo response_json($link, $qryString, $IDPOST);
	exit;
}
###########################################################################################################################

if ($MODPOST == $idpm . '_agregar') {

	$qry_condominios = @mysqli_query($link, "	SELECT a.* FROM condominio a 
	WHERE a.cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "'");

	while ($row_condominios = @mysqli_fetch_array($qry_condominios)) {

		$option_condominio .= '<option value="' . $row_condominios["cve_condominio"] . '" ' . ($row_condominios["cve_condominio"] == $row["cve_condominio"] ? 'selected' : '') . ' >' . $row_condominios["descripcion"] . '</option>';
	}

	$MDlFORM = '<div class="mb-3 row">
					<label class="col-sm-12 col-form-label">Nombre:*</label>
					<div class="col-sm-12">
						<input type="text" class="form-control" name="nombre" value="' . $row["nombre"] . '" required="" minlength="5" maxlength="64">
					</div>
					<label class="col-sm-12 col-form-label">Correo:*</label>
					<div class="col-sm-12">
						<input type="text" class="form-control" name="email" value="' . $row["email"] . '" required="" minlength="5" maxlength="64">
					</div>
					<label class="col-sm-12 col-form-label">Teléfono:*</label>
					<div class="col-sm-12">
						<input type="tel" class="form-control" name="telefono" value="' . $row["telefono"] . '" required="" minlength="10" maxlength="10">
					</div>

					<label class="col-sm-12 col-form-label">Nombre de usuario:*</label>
					<div class="col-sm-12">
						<input type="text" class="form-control" name="usuario" value="' . $row["usuario"] . '" required="" minlength="5" maxlength="64">
					</div>
					<label class="col-sm-12 col-form-label">Contraseña:*</label>
					<div class="col-sm-12">
						<input type="text" class="form-control" name="passw" value="' . $row["passw"] . '" required="" minlength="5" maxlength="64">
					</div>
					<label class="col-sm-12 col-form-label">Condominio asiginado:*</label>
					<div class="col-sm-12">
						<select class="form-control" name="condominio" required>
							<option value="" selected disabled >Seleccionar condominio</option>
							' . $option_condominio . '
						</select>
					</div>
				</div>';

	echo response_modal($MDSIZE, $MDlFORM, $IDPOST, $IDPOST2, $MODPOST, $fileaction, $NPOPUP, $row["nombre"], ($num > 0 ? 'Actualizar' : 'Agregar'));
	exit;
}


if ($MODPOST ==  $idpm . '_agregar_save') {

	$nombre    	= strip_tags($_POST["nombre"]);
	$email   	= strip_tags($_POST["email"]);
	$telefono  	= strip_tags($_POST["telefono"]);
	$usuario    = strip_tags($_POST["usuario"]);
	$passw   	= strip_tags($_POST["passw"]);
	$condominio = strip_tags($_POST["condominio"]);


	$qry = @mysqli_query($link, "   SELECT a.* FROM usuario a 
									WHERE 	a.cve_statuscat IN(1,2) 
									AND 	a.usuario='" . $nombre . "'
									AND cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "'");

	#CANTIDAD DE ELEMENTOS ENCONTRADOS
	$num = @mysqli_num_rows($qry);


	if ($num == 0) {

		$qryString =     " 	INSERT INTO usuario(
												fecha_sys, 
												cve_statuscat,
												cve_sysusuario,
												cve_rol,
												nombre, 
												email, 
												telefono,
												usuario,
												passw,
												cve_condominio
											) VALUES(
													'" . $fecha_sys . "',
													'1',
													'" . $_SESSION["CVE_SYSUSUARIO"] . "',
													'3',
													'" . addslashes($nombre) . "',
													'" . addslashes($email) . "',
													'" . addslashes($telefono) . "',
													'" . addslashes($usuario) . "',
													'" . addslashes($passw) . "',
													'" . addslashes($condominio) . "'
										)";
	}


	echo response_json($link, $qryString, $IDPOST);
	exit;
}

###########################################################################################################################

if ($MODPOST == $idpm . '_editar') {

	$MDlFORM = '<div class="mb-3 row">
					<label class="col-sm-12 col-form-label">Nombre:*</label>
					<div class="col-sm-12">
						<input type="text" class="form-control" name="nombre" value="' . $row["nombre"] . '" required="" minlength="5" maxlength="64">
					</div>
					<label class="col-sm-12 col-form-label">Correo:*</label>
					<div class="col-sm-12">
						<input type="text" class="form-control" name="email" value="' . $row["email"] . '" required="" minlength="5" maxlength="64">
					</div>
					<label class="col-sm-12 col-form-label">Teléfono:*</label>
					<div class="col-sm-12">
						<input type="tel" class="form-control" name="telefono" value="' . $row["telefono"] . '" required="" minlength="10" maxlength="10">
					</div>
				</div>';

	echo response_modal($MDSIZE, $MDlFORM, $IDPOST, $IDPOST2, $MODPOST, $fileaction, $NPOPUP, $row["nombre"], ($num > 0 ? 'Actualizar' : 'Agregar'));
	exit;
}


if ($MODPOST ==  $idpm . '_editar_save') {

	$nombre    	= strip_tags($_POST["nombre"]);
	$email   	= strip_tags($_POST["email"]);
	$telefono  	= strip_tags($_POST["telefono"]);



	if ($num > 0) {
		$qryString =     " 	UPDATE usuario a SET 
								nombre		=	'" . addslashes($nombre) . "',
								email		=	'" . addslashes($email) . "',
								telefono	=	'" . addslashes($telefono) . "'
							WHERE cve_usuario	=	'" . $IDPOST . "'
							AND cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "'";
		#}
		# elseif (isset($descripcion)) {
		/*$qryString =     " 	INSERT INTO usuario(
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
												)";*/
	}


	echo response_json($link, $qryString, $IDPOST);
	exit;
}


###########################################################################################################################
if ($MODPOST == $idpm . '_accesos') {

	$qry_condominios = @mysqli_query($link, "	SELECT a.* FROM condominio a 
												WHERE a.cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "'");

	while ($row_condominios = @mysqli_fetch_array($qry_condominios)) {

		$option_condominio .= '<option value="' . $row_condominios["cve_condominio"] . '" ' . ($row_condominios["cve_condominio"] == $row["cve_condominio"] ? 'selected' : '') . ' >' . $row_condominios["descripcion"] . '</option>';
	}


	$MDlFORM = '<div class="mb-3 row">
					<label class="col-sm-12 col-form-label">Nombre de usuario:*</label>
					<div class="col-sm-12">
						<input type="text" class="form-control" name="usuario" value="' . $row["usuario"] . '" required="" minlength="5" maxlength="64">
					</div>
					<label class="col-sm-12 col-form-label">Contraseña:*</label>
					<div class="col-sm-12">
						<input type="text" class="form-control" name="passw" value="' . $row["passw"] . '" required="" minlength="5" maxlength="64">
					</div>
					<label class="col-sm-12 col-form-label">Condominio asiginado:*</label>
					<div class="col-sm-12">
						<select class="form-control" name="condominio" required>
							<option value="" selected disabled >Seleccionar condominio</option>
							' . $option_condominio . '
						</select>
					</div>
				</div>';

	echo response_modal($MDSIZE, $MDlFORM, $IDPOST, $IDPOST2, $MODPOST, $fileaction, $NPOPUP, $row["nombre"], ($num > 0 ? 'Actualizar' : 'Agregar'));
	exit;
}


if ($MODPOST ==  $idpm . '_accesos_save') {

	$usuario    = strip_tags($_POST["usuario"]);
	$passw   	= strip_tags($_POST["passw"]);
	$condominio	= strip_tags($_POST["condominio"]);



	if ($num > 0) {
		$qryString =     " 	UPDATE usuario a SET 
								usuario		=	'" . addslashes($usuario) . "',
								passw		=	'" . addslashes($passw) . "',
								cve_condominio	=	'" . addslashes($condominio) . "'
							WHERE cve_usuario	=	'" . $IDPOST . "'
							AND cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "'";
	}

	echo response_json($link, $qryString, $IDPOST);
	exit;
}


###########################################################################################################################
if ($_POST["draw"]) {
	/*
	$where .= " AND (
						UPPER(a.nombre) LIKE UPPER('%" . $_POST["search"]["value"] . "%') 
						OR 	UPPER(a.confirmacion) LIKE UPPER('%" . $_POST["search"]["value"] . "%')
						OR 	UPPER(a.cve_usuario) LIKE UPPER('%" . $_POST["search"]["value"] . "%')
						OR 	UPPER(a.telefono) LIKE UPPER('%" . $_POST["search"]["value"] . "%')
						OR 	UPPER(a.email) LIKE UPPER('%" . $_POST["search"]["value"] . "%')
					)";
*/
	$qrystring = "	SELECT 
						a.*,
						b.descripcion rol
					FROM usuario a
					INNER JOIN rol b ON a.cve_rol=b.cve_rol
					WHERE a.cve_statuscat IN(1,2)
					AND a.cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "' "  . $where;


	$qrytotal = @mysqli_query($link, $qrystring);
	$num_rows_total = @mysqli_num_rows($qrytotal);


	#$where .= isset($_POST["order"]) ? " ORDER BY " . $_POST["order"]["0"]["column"] . ' ' . $_POST["order"]["0"]["dir"] : " ORDER BY cve_usuario DESC";
	$where .= $_POST["length"] != -1 ? ' LIMIT ' . $_POST["start"] . ',' . $_POST["length"] : '';

	$qry = @mysqli_query($link, $qrystring . $where);
	$data;
	$num_rows = @mysqli_num_rows($qry);
	if ($num_rows > 0) {
		while ($row = @mysqli_fetch_array($qry)) {

			$array_buttons = [];

			$qry_condominio = @mysqli_query($link, 'SELECT a.* FROM condominio a WHERE a.cve_condominio ="' . $row["cve_condominio"] . '"');
			$row_condominio = @mysqli_fetch_array($qry_condominio);

			/** INDICE DE ESTATUS
			 * 0 
			 */
			$id = $row[0];

			array_push($array_buttons, ["info",    "Editar información", "fas fa-edit ",  "", "Datos para editar", 	"0", $idpm . "_editar", $fileaction]);
			array_push($array_buttons, ["info",    "Editar Accesos", "fas fa-user pr-1", "", "Ediar accesos", 		"0", $idpm . "_accesos", $fileaction]);
			array_push($array_buttons, ["info",    "Estado", "fas fa-check-circle pr-1", "", "Cambiar el status", 	"0", $idpm . "_estado", $fileaction]);

			$data[] = [
				'<div>
					<strong>Id: </strong>' . $id . '
				</div>',
				'<div>
					<strong>Nombre:</strong> ' . $row["nombre"] . '
				</div>
				<div>
					<strong>Correo:</strong> ' . $row["email"] . '
				</div>',
				'<div>
					<strong>Usuario:</strong> ' . $row["usuario"] . '
				</div>
				<div>
					<strong>Contraseña:</strong> ' . $row["passw"] . '
				</div>
				<div>
					<strong>Rol:</strong> ' . $row["rol"] . '
				</div>
				<div>
					<strong>Condominio:</strong> ' . $row_condominio["descripcion"] . '
				</div>',
				'<div class="mt-2">' . ModBtns($id, $array_buttons) . '</div>',
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