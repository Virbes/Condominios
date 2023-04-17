<?

if ($_POST["MODPOST"] == "header_alertas" and $_SESSION["CVE_SYSUSUARIO"] >= 1) {

	$qry_mensajes = @mysqli_query($link, "	SELECT a.* FROM alerta a 
											WHERE a.cve_statuscat='1'
											AND a.cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "'");

	$cont = 0;
	while ($row_mensajes = @mysqli_fetch_array($qry_mensajes)) {

		$qry_tipoalerta = @mysqli_query($link, "SELECT a.* FROM tipoalerta a WHERE a.cve_tipoalerta='" . $row_mensajes["cve_tipoalerta"] . "'");
		$row_tipoalerta = @mysqli_fetch_array($qry_tipoalerta);

		$mjs .= '	<a class="dropdown-item d-flex align-items-center" href="#">
						<div class="mr-3">
							<div class="icon-circle ' . $row_tipoalerta["color"] . '">
								<i class="' . $row_tipoalerta["icono"] . ' text-white"></i>
							</div>
						</div>
						<div>
							<div class="small text-gray-500">' . $row_mensajes["fecha_sys"] . '</div>
							<span class="font-weight-bold">' . $row_mensajes["aunto"] . '</span>
						</div>
					</a>';
		$cont++;
	}

	$html = '
	<a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<i class="fas fa-bell fa-fw"></i>
		<!-- Counter - Alerts -->
		<span class="badge badge-danger badge-counter">' . $cont . ($cont > 9 ? '+' : '') . '</span>
	</a>

	<!-- Dropdown - Alerts -->
	<div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
		<h6 class="dropdown-header">
			Centro de Alertas
		</h6>
		' . $mjs . '
		<a class="dropdown-item text-center small text-gray-500 Menu1" name=' . $idpm . '.php">Mostrar Todas las Alertas</a>
	</div>';


	$json["r_"] = $html ? array(
		'OutVal' => 'Listo',
		'html' => $html
	) : array(
		'OutVal' => 'Error',
		'html' => ''
	);

	echo json_encode($json);
	exit;

	/* 
	    <a class="dropdown-item d-flex align-items-center" href="#">
        <div class="mr-3">
            <div class="icon-circle bg-success">
                <i class="fas fa-donate text-white"></i>
            </div>
        </div>
        <div>
            <div class="small text-gray-500">December 7, 2019</div>
            $290.29 has been deposited into your account!
        </div>
    </a>
    <a class="dropdown-item d-flex align-items-center" href="#">
        <div class="mr-3">
            <div class="icon-circle bg-warning">
                <i class="fas fa-exclamation-triangle text-white"></i>
            </div>
        </div>
        <div>
            <div class="small text-gray-500">December 2, 2019</div>
            Spending Alert: We've noticed unusually high spending for your account.
        </div>
    </a>
	
	
	*/
}


if ($_POST["draw"] and $_SESSION["CVE_SYSUSUARIO"] >= 1) {

	$qrystring = "	SELECT a.* FROM alerta a  WHERE a.cve_statuscat=1 AND  a.cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "'";
	$qrytotal = @mysqli_query($link, $qrystring);

	if (isset($_POST["search"]["value"]))
		$where .= " AND (
						UPPER(a.nombre) LIKE UPPER('%" . $_POST["search"]["value"] . "%') OR 
						UPPER(a.ip) LIKE UPPER('%" . $_POST["search"]["value"] . "%') OR 
						UPPER(a.fecha_sys) LIKE UPPER('%" . $_POST["search"]["value"] . "%') 
						) ";


	#$where .= isset($_POST["order"]) ? " ORDER BY " . $_POST["order"]["0"]["column"] . ' ' . $_POST["order"]["0"]["dir"] : " ORDER BY cve_mmaenviomail DESC";
	$where .= " ORDER BY a.cve_alerta DESC";
	$where .= $_POST["length"] != -1 ? ' LIMIT ' . $_POST["start"] . ',' . $_POST["length"] : '';

	$qry = @mysqli_query($link, $qrystring . $where);
	$num = @mysqli_num_rows($qry);
	if ($num) {

		while ($row = @mysqli_fetch_array($qry)) {
			$id = $row[0];

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
					array_push($array_buttons, ["pruebas",	"Confirmar Pago", 	"fas fa-money-check-alt",	"", "Confirmar pago",			"0", "servicio_confirmacion_pago",	$fileaction]);
					array_push($array_buttons, ["pruebas",	"Eliminar", 		"fas fa-trash-alt",			"", "Eliminar la reservación", 	"0", "servicio_eliminar",			$fileaction]);
				}
			}
			if ($row["statuspago"] > 0 && $row["statuspago"] != 5  && $row["statuspago"] != 6) {

				array_push($array_buttons, ["pruebas",	"Confirmación", 		"fas fa-thumbs-up",		"", "Realizar Confirmación", "0", "servicio_confirmacion",	$fileaction]);

				if ($_SESSION["_SYS_0011"] > 0) { #APLICA SOLO PARA PANEL DE ADMIN
					array_push($array_buttons, ["pruebas",	"Asingar a Proveedor", 	"fas fa-bus",			"", "Seleccionar proveedor", "0", "servicio_asingacion",	$fileaction]);
					array_push($array_buttons, ["pruebas",	"Reagendar",    		"fas fa-redo",      	"", "Reagendar",     		"2", "servicio_reagendar",    	$fileaction]);
				}

				array_push($array_buttons, ["pruebas",	"No Show", "fas fa-eye-slash", 	"", "Confirmar No Show",    "2", "servicio_noshow",			$fileaction]);
			}
			if ($row["statuspago"] < 4 || $row["statuspago"] == 6) {
				if ($_SESSION["_SYS_0011"] > 0) { #APLICA SOLO PARA PANEL DE ADMIN
					array_push($array_buttons, ["pruebas",	"Editar ", "fas fa-pencil-alt",	"", "Editar la reservación", "2", "servicio_editar",	$fileaction]);
				}
			}
			if ($row["statuspago"] == 5 || $row["statuspago"] == 6) {
				array_push($array_buttons, ["pruebas",	"Ver detelles", "fas fa-eye", "", "Detelles de realizado", "0", "servicio_ver", $fileaction]);
			}*/
			array_push($array_buttons, ["pruebas",	"Responder	", "fas fa-sticky-note", "", "Responder mensaje", "0", "", $fileaction]);
			array_push($array_buttons, ["pruebas",	"Finalizar", "fas fa-sticky-note", "", "Agregar notas a la reservación", "0", "", $fileaction]);
			$data[] = [
				$id,
				'<div>
							<span class="text-danger">
								<strong>Fecha: </strong> ' . $row["fecha_sys"] . '
							</span>
						</div>',
				$condominio,
				'<div>
							<strong>Nombre: </strong>' . $row["nombre"] . '
						</div>',
				'<div>
							<strong>Asunto:</strong>' . $row["aunto"] . '
						</div>',
				'<div class="mt-2">' . ModBtns($id, $array_buttons) . '</div>'
			];
		}
	} else {
		$data[] = ['', ''];
	}

	$array_data = array("draw" => intval($_POST["draw"]), "recordsTotal", @mysqli_num_rows($qry), "recordsFiltered" => @mysqli_num_rows($qrytotal), "data" => $data);
	echo  json_encode($array_data);
	exit;
}


###########################################################################################################################