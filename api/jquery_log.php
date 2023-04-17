<?

if ($_POST["draw"] and $_SESSION["CVE_SYSUSUARIO"] >= 1) {

	$qrystring = "	SELECT a.* FROM syslog a  WHERE a.cve_statuscat=1 AND   a.cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "'";
	$qrytotal = @mysqli_query($link, $qrystring);

	if (isset($_POST["search"]["value"]))
		$where .= " AND (
						UPPER(a.nombre) LIKE UPPER('%" . $_POST["search"]["value"] . "%') OR 
						UPPER(a.ip) LIKE UPPER('%" . $_POST["search"]["value"] . "%') OR 
						UPPER(a.fecha_sys) LIKE UPPER('%" . $_POST["search"]["value"] . "%')
						) ";


	#$where .= isset($_POST["order"]) ? " ORDER BY " . $_POST["order"]["0"]["column"] . ' ' . $_POST["order"]["0"]["dir"] : " ORDER BY cve_mmaenviomail DESC";
	$where .= " ORDER BY a.cve_syslog DESC";
	$where .= $_POST["length"] != -1 ? ' LIMIT ' . $_POST["start"] . ',' . $_POST["length"] : '';

	$qry = @mysqli_query($link, $qrystring . $where);
	$num = @mysqli_num_rows($qry);
	if ($num) {

		while ($row = @mysqli_fetch_array($qry)) {
			$id = $row[0];
			$informacion = ' <div>
							<span class="text-success">
								<strong>Fecha: </strong> ' . $row["fecha_sys"] . '
							</span>
						</div>
						<div>
							<strong>Nombre: </strong>' . $row["nombre"] . '
						</div>
						<div>
							<strong>IP: </strong>' . $row["ip"] . '
						</div>
					</td>';
			$data[] = [$id, $informacion];
		}
		
	} else {
		$data[] = ['', ''];
	}

	$array_data = array("draw" => intval($_POST["draw"]), "recordsTotal", @mysqli_num_rows($qry), "recordsFiltered" => @mysqli_num_rows($qrytotal), "data" => $data);
	echo  json_encode($array_data);
	exit;
}


###########################################################################################################################