<?
#CONSULTA PRINCIPAL PARA TODOS LOS METODOS
$qry = @mysqli_query($link, "   SELECT a.* FROM condominio a 
								WHERE a.cve_statuscat='1' 
								AND a.cve_sysusuario='1060'
								AND a.cve_condominio='" . $IDPOST . "'" . $WHERE_SELECT);

#CANTIDAD DE ELEMENTOS ENCONTRADOS
$num = @mysqli_num_rows($qry);

#TODO ARREGLO DE LA INFORMACION
$row = @mysqli_fetch_array($qry);

###########################################################################################################################

if ($_POST["draw"]) {

	$where .= " AND (
						UPPER(a.nombre) LIKE UPPER('%" . $_POST["search"]["value"] . "%') 
						OR 	UPPER(a.confirmacion) LIKE UPPER('%" . $_POST["search"]["value"] . "%')
						OR 	UPPER(a.cve_condominio) LIKE UPPER('%" . $_POST["search"]["value"] . "%')
						OR 	UPPER(a.telefono) LIKE UPPER('%" . $_POST["search"]["value"] . "%')
						OR 	UPPER(a.email) LIKE UPPER('%" . $_POST["search"]["value"] . "%')
					)";

	$qrystring = "	SELECT 
						a.*
					FROM condominio a
					WHERE a.cve_statuscat='1'
					AND a.cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "' "  . $where;


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

			$confirmacion = '	
							<div>
								' . $row["confirmacion"] . '
							</div>
							<div>
								<strong>Id: </strong>' . $row[0] . '
							</div>
							<div>
								<strong>Scan QR: </strong>' . @mysqli_num_rows($qryscan) . '
							</div>
							<div>
								<strong>Fecha:</strong>' . $row["fecha"] . '
							</div>';

			$cliente = '	<div>
								<strong>Nombre:</strong>' . $row["nombre"] . '
							</div>
							<div>
								<strong>Teléfono:</strong>' . $row["telefono"] . '
							</div>
							<div>
								<strong>Email: </strong>' . $row["email"] . '
							</div>' . (strlen($notas) > 5 ? '<hr>Notas<br>' . $notas : '');

			$servicio     = '
							<div>
								<strong>Servicio:</strong> ' . $row["servicio"] . '
							</div>
							<div>
								<strong>Tipo: </strong> ' . $row["tipo"] . '
							</div>
							<div>
								<strong>Pax:</strong> ' . $row["pasajeros"] . '
							</div>' . $provedor;

			$fechas = '  	<div>
								<span style="font-style:italic;color:#F30; cursor:default;" > 
									<strong><b>Origen:</b></strong> ' . $row["origen"] . '
								</span>
							</div>
							<div>
								<span style="font-style:italic;color:#F30; cursor:default;" > 
									<strong>Fecha:</strong> ' . $row["fllegada"] . ' / <strong>Hora:</strong> ' . $row["horallegada"] . '
								</span>
							</div>
							<hr>
							<div>
								<strong><b>Destino:</b></strong> ' . $row["destino"] . '
							</div>' . ($row["fllegada"] == $fecha_sys_ ? '
							<div>
								<span style="font-style:italic;color:#F30; cursor:default;">
									<strong>¡Hoy se realiza el servicio!</strong>
								</span>
							</div>
							' : '');

			$paxs =  '	';

			$costos = ' <div>
							<strong>Sub total:</strong> $' . number_format($row["subtotal"], 2) . ' ' . $row["moneda"] . '
						</div>
						<div>
							<strong>IVA:</strong> $0.00 ' . $row["moneda"] . '
						</div>
						<div>
							<strong><b>Total:</b></strong> $' . number_format($row["total"], 2) . ' ' . $row["moneda"] . '
						</div>' . (($row["statuspago"] > 0 && $row["statuspago"] != 6 && $row["statuspago"] != 3) ? '
						<hr>
						<div>
							<strong>Fecha pago:</strong> ' . $row["pagofecha"] . '
						</div>
						<div>
							<strong>Forma pago:</strong> ' . $row["pagoforma"] . '
						</div>
						<div>
							<strong>Ref. pago:</strong> ' . $row["pagoref"] . '
						</div>' : '');

			$array_buttons = [];

			/** INDICE DE PAGOS
			 * 0 SIN PAGAR
			 * 1 PAGADO
			 * 2 NO HAY
			 * 3 CANCELADO
			 * 4 REAGENDADO
			 * 5 REALIZADO
			 * 6 NO SHOW
			 */

			/*if ($row["statuspago"] == 0) {
				if ($_SESSION["_SYS_0011"] > 0) { #APLICA SOLO PARA PANEL DE ADMIN
					array_push($array_buttons, ["pruebas",    "Confirmar Pago",     "fas fa-money-check-alt",    "", "Confirmar pago",            "0", "servicio_confirmacion_pago",    $fileaction]);
					array_push($array_buttons, ["pruebas",    "Eliminar",         "fas fa-trash-alt",            "", "Eliminar la reservación",     "0", "servicio_eliminar",            $fileaction]);
				}
			}
			if ($row["statuspago"] > 0 && $row["statuspago"] != 5  && $row["statuspago"] != 6) {

				array_push($array_buttons, ["pruebas",    "Confirmación",         "fas fa-thumbs-up",        "", "Realizar Confirmación", "0", "servicio_confirmacion",    $fileaction]);

				if ($_SESSION["_SYS_0011"] > 0) { #APLICA SOLO PARA PANEL DE ADMIN
					array_push($array_buttons, ["pruebas",    "Asingar a Proveedor",     "fas fa-bus",            "", "Seleccionar proveedor", "0", "servicio_asingacion",    $fileaction]);
					array_push($array_buttons, ["pruebas",    "Reagendar",            "fas fa-redo",          "", "Reagendar",             "2", "servicio_reagendar",        $fileaction]);
				}

				array_push($array_buttons, ["pruebas",    "No Show", "fas fa-eye-slash",     "", "Confirmar No Show",    "2", "servicio_noshow",            $fileaction]);
			}
			if ($row["statuspago"] < 4 || $row["statuspago"] == 6) {
				if ($_SESSION["_SYS_0011"] > 0) { #APLICA SOLO PARA PANEL DE ADMIN
					array_push($array_buttons, ["pruebas",    "Editar ", "fas fa-pencil-alt",    "", "Editar la reservación", "2", "servicio_editar",    $fileaction]);
				}
			}
			if ($row["statuspago"] == 5 || $row["statuspago"] == 6) {
				array_push($array_buttons, ["pruebas",    "Ver detelles", "fas fa-eye", "", "Detelles de realizado", "0", "servicio_ver", $fileaction]);
			}*/
			array_push($array_buttons, ["pruebas",    "Agregar nota", "fas fa-sticky-note", "", "Agregar notas a la reservación", "0", "servicio_notas", $fileaction]);


			$btns = '<div class="mt-2">' . ModBtns($id, $array_buttons) . '</div>';

			$data[] = [$confirmacion, $cliente, $servicio, $fechas, $costos, $btns, Modstatus($row["statuspago"])];
		}
	} else {
		$data[] = ["", '', '', '', '', '', ''];
	}

	$array_data = array("draw" => intval($_POST["draw"]), "recordsTotal", $num_rows, "recordsFiltered" => $num_rows_total, "data" => $data);
	echo  json_encode($array_data);
	exit;
}
###########################################################################################################################