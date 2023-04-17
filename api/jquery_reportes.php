<?
if ($MODPOST == 'env_mail' and $_SESSION["CVE_SYSUSUARIO"] >= 1) {

	$qry = @mysqli_query($link, "   SELECT 
										a.*
									FROM mmaenviomail a
									WHERE  a.cve_mmaenviomail ='" . $IDPOST . "'
									AND a.CVE_SYSUSUARIO='" . $_SESSION["CVE_SYSUSUARIO"] . "'");
	$row = @mysqli_fetch_array($qry);

	$MDlFORM = '<div class="mb-3 row">
					<label for="staticEmail" class="col-sm-12 col-form-label"> Escribe correos seperado por una coma:</label>
					<div class="col-sm-12">
						<textarea name="correos" id="" class="form-control" rows="3"></textarea>
					</div>
				</div>';

	echo response_modal($SIZE, $MDlFORM, $IDPOST, $IDPOST2, $MODPOST, $fileaction, $form_redirect, $NPOPUP, $row["asunto"], true);
	exit;
}


if ($MODPOST == 'env_mail_save' and $_SESSION["CVE_SYSUSUARIO"] >= 1) {


	$qry = @mysqli_query($link, "   SELECT 
										a.*
									FROM mmaenviomail a
									WHERE  a.cve_mmaenviomail ='" . $IDPOST . "'
									AND a.CVE_SYSUSUARIO='" . $_SESSION["CVE_SYSUSUARIO"] . "'");
	$row = @mysqli_fetch_array($qry);

	$qryhtml = @mysqli_query($link, " 	SELECT a.* FROM mmaenviomailhtml a 
										WHERE  a.cve_mmaenviomail ='" . $IDPOST . "'");
	$rowhtml = @mysqli_fetch_array($qryhtml);



	$correos = strip_tags($_POST["correos"]);
	$array_correos = explode(',', $correos);
	$val = false;
	for ($i = 0; $i < count($array_correos); $i++) {
		/*if (
			!(preg_match('/(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/', $array_correos[$i])) ||
			!(preg_match('/^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/', $array_correos[$i]))
		) {*/
		$send = SendPropuesta($link, $row["mailenvia"], $row["nombre"], $row["mailresponder"], $array_correos[$i], $row["asunto"], $rowhtml["descripcion"], $row["cve_mmaenviomail"], $_SESSION["CVE_SYSUSUARIO"]);
		$val = true;
		#}
	}
	$json["r_"] = $val ? array('OutVal' => 'Listo', 'Icon' => 'fas fa-check', 'Val' => $val, 'Id' => $id, "no_redirect" => true) : array('OutVal' => $send . 'Error', 'Icon' => 'fas fa-exclamation-triangle', 'Val' => $val, 'Id' => $id, "no_redirect" => true);
	echo json_encode($json);
	exit;
}
###########################################################################################################################

if ($MODPOST == 'ver_mail' and $_SESSION["CVE_SYSUSUARIO"] >= 1) {

	$qry = @mysqli_query($link, "   SELECT 
										a.*
									FROM mmaenviomail a
									WHERE  a.cve_mmaenviomail ='" . $IDPOST . "'
									AND a.CVE_SYSUSUARIO='" . $_SESSION["CVE_SYSUSUARIO"] . "'");
	$row = @mysqli_fetch_array($qry);

	$MDlFORM = '<iframe src="https://www.email.negocio.me/api/html/index.php?id=' . $IDPOST . '" style="height: 50vh;" class="w-100 border-0 "></iframe>';

	echo $row ? response_modal($MDSIZE, $MDlFORM, $IDPOST, $IDPOST2, $MODPOST, $fileaction, $form_redirect, $NPOPUP, $row["asunto"], false) : $modalerror;

	exit;
}

###########################################################################################################################

if ($MODPOST == 'delete_mail' and $_SESSION["CVE_SYSUSUARIO"] >= 1) {

	$qry = @mysqli_query($link, "   SELECT 
										a.*
									FROM mmaenviomail a
									WHERE  a.cve_mmaenviomail ='" . $IDPOST . "'
									AND a.CVE_SYSUSUARIO='" . $_SESSION["CVE_SYSUSUARIO"] . "'");
	$row = @mysqli_fetch_array($qry);

	$MDlFORM = '<div class=" text-center">
					<div class="card-body border-0">
					<h5 class="card-title"><i class="fas fa-exclamation-triangle" style="font-size: 3em;"></i></h5>
					<p class="card-text">Una vez elimine la campaña no podra recuperarla</p>
					<button class="btn btn-secondary btn-icon-split"  id="btn_form">
						<span class="icon text-white-50">
							<i class="fas fa-arrow-right"></i>
						</span>
						<span class="text">Confirmar</span>
					</button>
					</div>
				</div>';

	echo response_modal($MDSIZE, $MDlFORM, $IDPOST, $IDPOST2, $MODPOST, $fileaction, $form_redirect, $NPOPUP, $row["asunto"], false);

	exit;
}

if ($MODPOST == 'unique_mail' and $_SESSION["CVE_SYSUSUARIO"] >= 1) {

	$qry = @mysqli_query($link, "	SELECT * FROM clickcat a
								WHERE a.cve_statuscat=1
								and   a.CVE_SYSUSUARIO='" . $_SESSION["CVE_SYSUSUARIO"] . "'
								and   a.cve_mmaenviomail='" . $IDPOST . "'
								GROUP BY a.mail
								ORDER BY a.cve_clickcat ASC");

	$count = 1;
	while ($row = @mysqli_fetch_array($qry)) {
		$tr .= '<tr>
				<th scope="row">' . $count . '</th>
				<td>' . $row["fecha_sys"] . '</td>
				<td>' . $row["ip_user"] . '</td>
				<td>' . $row["mail"] . '</td>
			</tr>';
		$count++;
	}
	$MDlFORM = '<table class="table">
					<thead>
						<tr>
						<th scope="col">#</th>
						<th scope="col">Fecha Apertura</th>
						<th scope="col">IP</th>
						<th scope="col">eMail apertura</th>
						</tr>
					</thead>
					<tbody>
						' . $tr . '
					</tbody>
				</table>
				<script>$(".modal-dialog").addClass(" modal-dialog-scrollable ")</script>';

	echo response_modal($MDSIZE, $MDlFORM, $IDPOST, $IDPOST2, $MODPOST, $fileaction, $form_redirect, $NPOPUP, $row["asunto"], false);

	exit;
}


if ($MODPOST == 'general_mail' and $_SESSION["CVE_SYSUSUARIO"] >= 1) {

	$qry = @mysqli_query($link, "	SELECT * FROM clickcat a
								WHERE a.cve_statuscat=1
								and   a.CVE_SYSUSUARIO='" . $_SESSION["CVE_SYSUSUARIO"] . "'
								and   a.cve_mmaenviomail='" . $IDPOST . "'
								ORDER BY a.cve_clickcat ASC");

	$count = 1;
	while ($row = @mysqli_fetch_array($qry)) {
		$tr .= '<tr>
				<th scope="row">' . $count . '</th>
				<td>' . $row["fecha_sys"] . '</td>
				<td>' . $row["ip_user"] . '</td>
				<td>' . $row["mail"] . '</td>
			</tr>';
		$count++;
	}
	$MDlFORM = '<table class="table">
					<thead>
						<tr>
						<th scope="col">#</th>
						<th scope="col">Fecha Apertura</th>
						<th scope="col">IP</th>
						<th scope="col">eMail apertura</th>
						</tr>
					</thead>
					<tbody>
						' . $tr . '
					</tbody>
				</table>
				
				<script>$(".modal-dialog").addClass(" modal-dialog-scrollable ")</script>';

	echo response_modal($MDSIZE, $MDlFORM, $IDPOST, $IDPOST2, $MODPOST, $fileaction, $form_redirect, $NPOPUP, $row["asunto"], false);
	exit;
}


if ($MODPOST == 'general_click' and $_SESSION["CVE_SYSUSUARIO"] >= 1) {

	$qry = @mysqli_query($link, "   SELECT 
										a.*
									FROM mmaenviomail a
									WHERE  a.cve_mmaenviomail ='" . $IDPOST . "'
									AND a.CVE_SYSUSUARIO='" . $_SESSION["CVE_SYSUSUARIO"] . "'");
	$row = @mysqli_fetch_array($qry);

	$qryClickUnique = @mysqli_query($link, "
								SELECT a.fecha_sys,email,url FROM mmaclick a
								WHERE a.CVE_SYSUSUARIO='" . $_SESSION["CVE_SYSUSUARIO"] . "'
								and   a.cve_mmaenviomail='" . $IDPOST . "'
								GROUP BY a.email");
	$tclickUnique = @mysqli_num_rows($qryClickUnique);

	$qryClickR = @mysqli_query($link, "
								SELECT a.fecha_sys,email,url FROM mmaclick a
								WHERE a.CVE_SYSUSUARIO='" . $_SESSION["CVE_SYSUSUARIO"] . "'
								and   a.cve_mmaenviomail='" . $IDPOST . "'");
	$tclickReporte = @mysqli_num_rows($qryClickR);
	$count = 1;
	while ($rowClickR = @mysqli_fetch_array($qryClickR)) {
		$pos = strpos($rowClickR["url"], '%');
		if ($pos !== false) {
			$urle = '<span style="color:#ff0000;" title="URL no existe"><strong>Error</strong></span>';
		} else {
			$urle = '';
		}
		$tr .= '<tr>
					<th scope="row">' . $count . '</th>
					<td>' . $rowClickR["fecha_sys"] . '</td>
					<td>' . substr($rowClickR["email"], 0, 30) . '</td>
					<td><a href="' . $rowClickR["url"] . '" target="UrlDestino">' . $rowClickR["url"] . '</a></td>
					<td>' . $urle  . '</td>
				</tr>';
		$count++;
	}

	$MDlFORM = '<table class="table">
					<thead>
						<tr>
						<th scope="col">#</th>
						<th scope="col">Fecha Apertura</th>
						<th scope="col">Email Apertura</th>
						<th scope="col">Url</th>
						<th scope="col">Estado</th>
						</tr>
					</thead>
					<tbody>
						' . $tr . '
					</tbody>
				</table>
				<script>$(".modal-dialog").addClass(" modal-dialog-scrollable ")</script>';

	echo response_modal($MDSIZE, $MDlFORM, $IDPOST, $IDPOST2, $MODPOST, $fileaction, $form_redirect, $NPOPUP, $row["asunto"], false);
	exit;
}


if ($_POST["draw"] and $_SESSION["CVE_SYSUSUARIO"] >= 1) {

	$qrytotal = @mysqli_query($link, "	SELECT 
											a.cve_mmaenviomail,
											a.cve_mmacategoria,
											a.cve_statuscat, 
											a.nombre,
											a.mailenvia,
											a.cve_mmatipoenvio,
											a.fecha_sys,
											a.CVE_SYSUSUARIO,
											a.mailresponder,
											a.asunto,
											a.porciento
										FROM mmaenviomail a
										INNER JOIN mmacategoria b ON  a.cve_mmacategoria=b.cve_mmacategoria
										WHERE a.cve_statuscat IN (6)
										AND b.cve_statuscat=1
										AND a.CVE_SYSUSUARIO='" . $_SESSION["CVE_SYSUSUARIO"] . "'
										ORDER BY cve_mmaenviomail DESC");

	if (isset($_POST["search"]["value"]))
		$where .= " AND UPPER(a.nombre) LIKE UPPER('%" . $_POST["search"]["value"] . "%')";


	#$where .= isset($_POST["order"]) ? " ORDER BY " . $_POST["order"]["0"]["column"] . ' ' . $_POST["order"]["0"]["dir"] : " ORDER BY cve_mmaenviomail DESC";
	$where .= " ORDER BY a.cve_mmaenviomail DESC";
	$where .= $_POST["length"] != -1 ? ' LIMIT ' . $_POST["start"] . ',' . $_POST["length"] : '';

	$qry = @mysqli_query($link, "   SELECT 
										a.cve_mmaenviomail,
										a.cve_mmacategoria,
										a.cve_statuscat, 
										a.nombre,
										a.mailenvia,
										a.cve_mmatipoenvio,
										a.fecha_sys,
										a.CVE_SYSUSUARIO,
										a.mailresponder,
										a.asunto,
										a.porciento
									FROM mmaenviomail a
									INNER JOIN mmacategoria b ON  a.cve_mmacategoria=b.cve_mmacategoria
									WHERE a.cve_statuscat IN (6)
									AND b.cve_statuscat=1
									AND a.CVE_SYSUSUARIO='" . $_SESSION["CVE_SYSUSUARIO"] . "'" . $where);
	$data;
	while ($row = @mysqli_fetch_array($qry)) {

		$qryview = @mysqli_query($link, "
		SELECT count(*)total
		FROM  clickcat a
		WHERE a.cve_statuscat=1
		and   a.CVE_SYSUSUARIO='" . $_SESSION["CVE_SYSUSUARIO"] . "'
		and   a.cve_mmaenviomail='" . $row["cve_mmaenviomail"] . "'");
		$rowview = @mysqli_fetch_array($qryview);

		if (strlen($row["porciento"]) >= 2) {
			$porciento = $row["porciento"] . " %";
		} else {
			$porciento = number_format($pociento) . " emails";
		}

		$qryviewG = @mysqli_query($link, "
		SELECT a.mail
		FROM  clickcat a
		WHERE a.cve_statuscat=1
		and   a.CVE_SYSUSUARIO='" . $_SESSION["CVE_SYSUSUARIO"] . "'
		and   a.cve_mmaenviomail='" . $row["cve_mmaenviomail"] . "'
		GROUP BY a.mail");
		$rowviewG = mysqli_num_rows($qryviewG);
		$fter = substr($rowte["fecha_sys"], 0, 10);

		$qryClick = @mysqli_query($link, "
		SELECT count(*)total FROM mmaclick a
		WHERE a.cve_statuscat=1
		and   a.CVE_SYSUSUARIO='" . $_SESSION["CVE_SYSUSUARIO"] . "'
		and   a.cve_mmaenviomail='" . $row["cve_mmaenviomail"] . "'
		ORDER BY a.cve_mmaclick asc");
		$rowClick = @mysqli_fetch_array($qryClick);



		$id = $row[0];
		$detalles = '<div>
					<span style="font-size:11px;font-style:italic;color:#F30; cursor:default;" title="Fecha de campaña">
						<strong>Fecha:</strong>' . $row["fecha_sys"] . '
					</span>
				</div>
				<div>
					<strong>Nombre:</strong>' . $row["nombre"] . '
				</div>
				<div>
					<strong>Asunto:</strong>' . $row["asunto"] . '
				</div>
				<hr>
				<div>
					<strong>ID Categoría: </strong>
					' . $row["cve_mmacategoria"] . '
				</div>
				<div>
					<strong>Categoría: </strong>' . xdato($link, $row["cve_mmacategoria"], 'mmacategoria', 'descripcion', 'cve_mmacategoria') . '
				</div>';

		$porcentaje = '<div>' . $porciento . '</div>';

		$aperturas = ' <div>
							<strong title="Todas las aperturas">Total:</strong> ' . number_format($rowview["total"]) . '
						</div>
						<div>
							<strong title="Una apertura por usuario">&Uacute;nicas:</strong>' . number_format($rowviewG) . '
						</div>
						<div>
							<a href="#" class="AbreModal" data-target="#staticBackdrop" data-toggle="modal" id="' . $id . '" rel="2" dir="unique_mail" title="Aperturas únicas" media="" name="/reportes/">
								Únicas
							</a>
							|
							<a href="#" class="AbreModal" data-target="#staticBackdrop" data-toggle="modal" id="' . $id . '" rel="2" dir="general_mail" title="Aperturas Generales" media="" name="/reportes/">
								Generales
							</a>
						</div>';

		$clicks = '<div>
					<strong>' . number_format($rowClick["total"]) . ' Clicks</strong><br />
					<a href="#" class="AbreModal" data-target="#staticBackdrop" data-toggle="modal" id="' . $id . '" rel="2" dir="general_click" title="Reporte de clicks" media="" name="/reportes/">Ver Reporte</a></div>';

		$array_buttons = [
			["pruebas",         "Enviar prueba",    "fas fa-envelope",      "", "Enviar Pruebas",   "0", "env_mail",    "/reportes/"],
			["vista",           "Vista previa",     "fas fa-eye",           "", "Vista previa",     "2", "ver_mail",    "/reportes/"],
			["editar",          "Editar y Reenviar ", "fas fa-redo",         "1", "",                "0", "",            "nueva-campania.php?idnew=" . $id]
		];

		$btns = ' 	<div class="mt-2">
						' . ModBtns($id, $array_buttons) . '
						<ul class="list-group list-group-flush">
							<li class="list-group-item p-0 border-0">
								<a target="_blank" href="/api/reportes/?IdCamp=' . $id . '" class="btn btn-autorizar btn-icon-split mb-1  btn-sm  ">
									<span class="icon text-white-50  text-left">
										<i class="fas fa-file"></i>
									</span>
									<span class="text text-left" style="width:10em;">Ver reporte</span>
								</a>
							</li>
						</ul>
					</div>';

		$data[] = [$id, $detalles, $porcentaje, $aperturas, $clicks, $btns, Modstatus($row["cve_statuscat"])];
	}

	$array_data = array("draw" => intval($_POST["draw"]), "recordsTotal", @mysqli_num_rows($qry), "recordsFiltered" => @mysqli_num_rows($qrytotal), "data" => $data);

	echo  json_encode($array_data);
	exit;
}
