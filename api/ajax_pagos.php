<?
#CONSULTA PRINCIPAL PARA TODOS LOS METODOS
$qry = @mysqli_query($link, "   SELECT a.* FROM pago a 
								WHERE a.cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "'
								AND a.cve_pago='" . $IDPOST . "'" . $WHERE_SELECT);

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

		$qryString =     " 	UPDATE pago a SET 
								cve_statuscat		=	'" . addslashes($status) . "'
							WHERE  	cve_pago	=	'" . $IDPOST . "'
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
		$qryString =     " 	UPDATE pago a SET 
								descripcion		=	'" . addslashes($descripcion) . "'
							WHERE  	cve_pago	=	'" . $IDPOST . "'
							AND 	cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "' ";
	} elseif (isset($descripcion)) {
		$qryString =     " 	INSERT INTO pago(
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


if ($MODPOST == $idpm . '_ver') {

	$MDlFORM = '<div class="mb-3 row">
					<label class="col-sm-12 col-form-label">Reglamento:</label>
					<div class="col-sm-12">
						<textarea name="descripcion" class="form-control" rows="3"  minlength="5" maxlength="128">' . $row["descripcion"] . '</textarea>
					</div>
				</div>';
	$MDlFORM = '<div class="d-flex flex-column justify-content-center align-items-center" id="order-heading">
						<div class="text-uppercase">
							<p>Detalles del pago</p>
						</div>
						<div class="h4">' . $fecha_sys . '</div>
						<div class="pt-1">
							<p>Order #' . $row[0] . ' <b class="text-dark"> Procesado</b></p>
						</div>
						<div class="btn close text-white">
							&times;
						</div>
					</div>
					<div class="wrapper bg-white">
						<div class="table-responsive">
							<table class="table table-borderless">
								<thead>
									<tr class="text-uppercase text-muted">
										<th scope="col">Servicios</th>
										<th scope="col" class="text-right">total</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th scope="row">Alquiler</th>
										<td class="text-right"><b>$69.86</b></td>
									</tr>
									<tr>
										<th scope="row">Gas</th>
										<td class="text-right"><b>$69.86</b></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="pt-2 border-bottom mb-3"></div>
						<div class="d-flex justify-content-start align-items-center pl-3">
							<div class="text-muted">Metodo de pago</div>
							<div class="ml-auto">
								<img src="https://www.freepnglogos.com/uploads/mastercard-png/mastercard-logo-logok-15.png" alt=""
									width="30" height="30">
								<label>Pago en efectivo</label>
							</div>
						</div>
						<!--<div class="d-flex justify-content-start align-items-center py-1 pl-3">
							<div class="text-muted">Shipping</div>
							<div class="ml-auto">
								<label>Free</label>
							</div>
						</div>-->
						<!--<div class="d-flex justify-content-start align-items-center pb-4 pl-3 border-bottom">
							<div class="text-muted">
								<button class="text-white btn">50% Discount</button>
							</div>
							<div class="ml-auto price">
								-$34.94
							</div>
						</div>-->
						<div class="d-flex justify-content-start align-items-center pl-3 py-3 mb-4 border-bottom">
							<div class="text-muted">
								Pago Total
							</div>
							<div class="ml-auto h5">
								$34.94
							</div>
						</div>
						<div class="row border rounded p-1 my-3">
							<div class="col-md-6 py-3">
								<div class="d-flex flex-column align-items start">
									<b>Billing Address</b>
									<p class="text-justify pt-2">James Thompson, 356 Jonathon Apt.220,</p>
									<p class="text-justify">New York</p>
								</div>
							</div>
							<div class="col-md-6 py-3">
								<div class="d-flex flex-column align-items start">
									<b>Shipping Address</b>
									<p class="text-justify pt-2">James Thompson, 356 Jonathon Apt.220,</p>
									<p class="text-justify">New York</p>
								</div>
							</div>
						</div>
						<div class="pl-3 font-weight-bold">Estado de los servicios</div>
						<div class="d-sm-flex justify-content-between rounded my-3 subscriptions">
							<div>
								<b>#' . $row[0] . '</b>
							</div>
							<div>' . $fecha_sys . '</div>
							<div>Status: Procesando</div>
							<div>
								Total: <b> $68.8 En servicios</b>
							</div>
						</div>
					</div>';

	echo response_modal($MDSIZE, $MDlFORM, $IDPOST, $IDPOST2, $MODPOST, $fileaction, $NPOPUP, $row["descripcion"], ($num > 0 ? 'Actualizar' : 'Agregar'));
	exit;
}

###########################################################################################################################

if ($_POST["draw"]) {

	" AND (
						UPPER(a.cve_pago) LIKE UPPER('%" . $_POST["search"]["value"] . "%') 
						OR 	UPPER(a.descripcion) LIKE UPPER('%" . $_POST["search"]["value"] . "%')
					)";

	$qrystring = "	SELECT 
						a.*
					FROM pago a
					WHERE a.cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "' AND a.cve_condominio='" . $_SESSION["CONDOMINIO"]["cve_condominio"] . "'"  . $where;


	$qrytotal = @mysqli_query($link, $qrystring);
	$num_rows_total = @mysqli_num_rows($qrytotal);


	//$where .= isset($_POST["order"]) ? " ORDER BY " . $_POST["order"]["0"]["column"] . ' ' . $_POST["order"]["0"]["dir"] : " ORDER BY a.cve_pago DESC";

	$where .= ' ORDER BY a.cve_pago DESC ' . ($_POST["length"] != -1 ? ' LIMIT ' . $_POST["start"] . ',' . $_POST["length"] : '');

	$qry = @mysqli_query($link, $qrystring . $where);
	$data;
	$num_rows = @mysqli_num_rows($qry);
	if ($num_rows > 0) {
		while ($row = @mysqli_fetch_array($qry)) {

			$id = $row[0];

			$array_buttons = [];


			array_push($array_buttons, ["info", "Ver pago", "far fa-money-bill-alt", "", "Ver pago", "2", $idpm . "_ver", $fileaction]); //<i class=""></i>
			array_push($array_buttons, ["info", "Editar", "fas fa-edit", "", "Editar pago", "2", $idpm . "_editar", $fileaction]);
			array_push($array_buttons, ["info", "Estado", "fas fa-check-circle pr-1", "", "Cambiar el status", "0", $idpm . "_estado", $fileaction]);

			$data[] = [
				'<div>
					<strong>Id: </strong>' . $id . '
				</div>',
				'<div class="py-5">
					<strong>' . $row["descripcion"] . '</strong>
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