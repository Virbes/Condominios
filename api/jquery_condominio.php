<?

$WHERE_SELECT = ($_SESSION["CVE_TIENDAPROVEEDOR"] > 0) ? " AND a.cve_tiendaprovedor='" . $_SESSION["CVE_TIENDAPROVEEDOR"] . "'" : "";

$WHERE_UPDATE = " 	AND cve_statuscat='1'  
					AND cve_sysusuario='1060'" .
    #	($_SESSION["CVE_TIENDAPROVEEDOR"] > 0) ? " AND cve_tiendaprovedor='" . $_SESSION["CVE_TIENDAPROVEEDOR"] . "'" : " ";
    " ";


#CONSULTA PRINCIPAL PARA TODOS LOS METODOS
$qry = @mysqli_query($link, "   SELECT a.* FROM trvreserva a 
								WHERE a.cve_statuscat='1' 
								AND a.cve_sysusuario='1060'
								AND a.cve_trvreserva='" . $IDPOST . "'" . $WHERE_SELECT);

#CANTIDAD DE ELEMENTOS ENCONTRADOS
$num = @mysqli_num_rows($qry);

#TODO ARREGLO DE LA INFORMACION
$row = @mysqli_fetch_array($qry);


###########################################################################################################################

if ($MODPOST == 'servicio_confirmacion_pago') {

    $MDlFORM = '<div class="mb-3 row">
					<label class="col-sm-12 col-form-label">Fecha de pago:</label>
					<div class="col-sm-12">
						<input type="date" class="form-control" name="pagofecha" value="" required="">
					</div>
					<label class="col-sm-12 col-form-label">Forma de pago:</label>
					<div class="col-sm-12">
						<select class="form-control" name="pagoforma"  required="" >
							<option value="PAYPAL">PAYPAL</option>
						</select>
					</div>
					<label class="col-sm-12 col-form-label">Referencia des pago:</label>
					<div class="col-sm-12">
						<input type="text" class="form-control" name="pagoref" value="" required=""  maxlength="100">
					</div>
					<label class="col-sm-12 col-form-label"> Escriba la notas finales:</label>
					<div class="col-sm-12">
						<textarea name="pagonotas" class="form-control" rows="3" required=""></textarea>
					</div>
				</div>';

    echo response_modal($MDSIZE, $MDlFORM, $IDPOST, $IDPOST2, $MODPOST, $fileaction, $form_redirect, $NPOPUP, '#' . $row["confirmacion"] . ' ' . $row["nombre"], true);
    exit;
}


if ($MODPOST == 'servicio_confirmacion_pago_save') {

    $pagofecha     = $_POST["pagofecha"];
    $pagoforma     = $_POST["pagoforma"];
    $pagoref     = $_POST["pagoref"];
    $pagonotas     = $_POST["pagonotas"];


    if ($num > 0) {
        $qryString =     " 	UPDATE trvreserva a SET 
								statuspago	=	'1',
								pagofecha	=	'" . addslashes($pagofecha) . "',
								pagoforma	=	'" . addslashes($pagoforma) . "',							
								pagoref		=	'" . addslashes($pagoref) . "',
								pagonotas	=	'" . addslashes($pagonotas) . "'
							WHERE  cve_trvreserva	=	'" . $IDPOST . "'
							" . $WHERE_UPDATE;
    }
    echo response_json($link, $qryString, $IDPOST, false);
    exit;
}
###########################################################################################################################

if ($MODPOST == 'servicio_editar') {

    $array_servicio = ["Compartido",     "Privado"];
    $array_viaje     = ["Sencillo",         "Redondo"];

    for ($i = 0; $i < 2; $i++) {
        $option_servicio     = 'Servicio ' . $array_servicio[$i];
        $option_viaje         = 'Viaje ' . $array_viaje[$i];
        $options_servicio     .= '<option value="' . $option_servicio . '" ' . ($option_servicio == $row["servicio"] ? 'selected' : '') . '>' . $option_servicio . '</option>';
        $options_viaje         .= '<option value="' . $option_viaje . '" ' . ($option_viaje == $row["tipo"] ? 'selected' : '') . ' >' . $option_viaje . '</option>';
    }


    $MDlFORM = '<div class="mb-3 row">
					<!---->
					<label class="col-sm-12 col-form-label pb-0"><strong>Datos cliente</strong></label>
					<label class="col-sm-12 col-form-label">Nombre:</label>
					<div class="col-sm-12">
						<input type="text" class="form-control" name="nombre" value="' . $row["nombre"] . '" required="" maxlength="32">
					</div>
					<label class="col-sm-6 col-form-label">Teléfono:</label>
					<label class="col-sm-6 col-form-label">Correo:</label>
					<div class="col-sm-6">
						<input type="tel" class="form-control" name="telefono" value="' . $row["telefono"] . '" required="" maxlength="10">
					</div>
					<div class="col-sm-6">
						<input type="email" class="form-control" name="email" value="' . $row["email"] . '" required="" maxlength="32">
					</div>

					<!---->
					<label class="col-sm-12 col-form-label pb-0"><strong>Datos servicio</strong></label>
					<div class="col-sm-6">
						<select class="form-control" name="servicio"  required="" >
							' . $options_servicio . '
						</select>
					</div>
					<div class="col-sm-6">
						<select class="form-control" name="tipo"  required="" >
							' . $options_viaje . '
						</select>
					</div>

					<!---->
					<label class="col-sm-12 col-form-label pb-0"><strong>Datos personas</strong></label>
					<label class="col-sm-6 col-form-label">Pasajeros:</label>
					<label class="col-sm-6 col-form-label">Total:</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" name="pasajeros" value="' . $row["pasajeros"] . '" required=""  maxlength="100">
					</div>					
					<div class="col-sm-6">
						<input type="text" class="form-control" name="total" value="' . $row["total"] . '" required=""  maxlength="100">
					</div>

					<!---->
					<label class="col-sm-12 col-form-label pb-0"><strong>Datos origen</strong></label>
					<label class="col-sm-4 col-form-label">Lugar:</label>
					<label class="col-sm-4 col-form-label">Fecha:</label>
					<label class="col-sm-4 col-form-label">Hora:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="origen" value="' . $row["origen"] . '" required=""  maxlength="100">
					</div>					
					<div class="col-sm-4">
						<input type="date" class="form-control" name="fllegada" value="' . $row["fllegada"] . '" required=""  maxlength="100">
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="horallegada" value="' . $row["horallegada"] . '" required=""  maxlength="100">
					</div>
					<label class="col-sm-4 col-form-label">Aerolinea:</label>
					<label class="col-sm-4 col-form-label">Vuelo:</label>
					<label class="col-sm-4 col-form-label">Hora:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="aero1" value="' . $row["aero1"] . '" required=""  maxlength="100">
					</div>					
					<div class="col-sm-4">
						<input type="text" class="form-control" name="vuelo1" value="' . $row["vuelo1"] . '" required=""  maxlength="100">
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="hora1" value="' . $row["hora1"] . '" required=""  maxlength="100">
					</div>

					<!---->
					<label class="col-sm-12 col-form-label pb-0"><strong>Datos Destino</strong></label>
					<label class="col-sm-4 col-form-label">Lugar:</label>
					<label class="col-sm-4 col-form-label">Fecha:</label>
					<label class="col-sm-4 col-form-label">Hora:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="destino" value="' . $row["destino"] . '" required=""  maxlength="100">
					</div>					
					<div class="col-sm-4">
						<input type="date" class="form-control" name="fregreso" value="' . $row["fregreso"] . '" required=""  maxlength="100">
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="horaregreso" value="' . $row["horaregreso"] . '" required="" maxlength="100">
					</div>
					<label class="col-sm-4 col-form-label">Aerolinea:</label>
					<label class="col-sm-4 col-form-label">Vuelo:</label>
					<label class="col-sm-4 col-form-label">Hora:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="aero2" value="' . $row["aero2"] . '" required=""  maxlength="100">
					</div>					
					<div class="col-sm-4">
						<input type="text" class="form-control" name="vuelo2" value="' . $row["vuelo2"] . '" required=""  maxlength="100">
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="hora2" value="' . $row["hora2"] . '" required=""  maxlength="100">
					</div>
					
					<label class="col-sm-12 col-form-label">Observaciones:</label>
					<div class="col-sm-12">
						<textarea name="observaciones" class="form-control" rows="3">' . $row["observaciones"] . '</textarea>
					</div>
				</div>';

    echo response_modal($MDSIZE, $MDlFORM, $IDPOST, $IDPOST2, $MODPOST, $fileaction, $form_redirect, $NPOPUP, '#' . $row["confirmacion"] . ' ' . $row["nombre"], true);
    exit;
}


if ($MODPOST == 'servicio_editar_save') {

    $nombre         = $_POST["nombre"];
    $telefono         = $_POST["telefono"];
    $email             = $_POST["email"];
    $servicio         = $_POST["servicio"];
    $tipo             = $_POST["tipo"];
    $pasajeros         = $_POST["pasajeros"];
    $total             = $_POST["total"];
    $origen         = $_POST["origen"];
    $fllegada         = $_POST["fllegada"];
    $horallegada     = $_POST["horallegada"];
    $aero1             = $_POST["aero1"];
    $vuelo1         = $_POST["vuelo1"];
    $hora1             = $_POST["hora1"];
    $destino         = $_POST["destino"];
    $fregreso         = $_POST["fregreso"];
    $horaregreso     = $_POST["horaregreso"];
    $aero2             = $_POST["aero2"];
    $vuelo2         = $_POST["vuelo2"];
    $hora2             = $_POST["hora2"];
    $observaciones     = $_POST["observaciones"];


    if ($num > 0) {
        $qryString =     " 	UPDATE trvreserva a SET 
								nombre		=	'" . addslashes($nombre) . "',
								telefono	=	'" . addslashes($telefono) . "',
								email		=	'" . addslashes($email) . "',
								servicio	=	'" . addslashes($servicio) . "',
								tipo		=	'" . addslashes($tipo) . "',
								pasajeros	=	'" . addslashes($pasajeros) . "',
								total		=	'" . addslashes($total) . "',
								origen		=	'" . addslashes($origen) . "',
								fllegada	=	'" . addslashes($fllegada) . "',
								horallegada	=	'" . addslashes($horallegada) . "',
								aero1		=	'" . addslashes($aero1) . "',
								vuelo1		=	'" . addslashes($vuelo1) . "',
								hora1		=	'" . addslashes($hora1) . "',
								destino		=	'" . addslashes($destino) . "',
								fregreso	=	'" . addslashes($fregreso) . "',
								horaregreso	=	'" . addslashes($horaregreso) . "',
								aero2		=	'" . addslashes($aero2) . "',
								vuelo2		=	'" . addslashes($vuelo2) . "',
								hora2		=	'" . addslashes($hora2) . "',
								observaciones	='" . addslashes($observaciones) . "'
							WHERE  cve_trvreserva='" . $IDPOST . "' " . $WHERE_UPDATE;
    }
    echo response_json($link, $qryString, $IDPOST, false);
    exit;
}


###########################################################################################################################

if ($MODPOST == 'servicio_eliminar') {

    $MDlFORM = '<div class="mb-3 row">
					<label class="col-sm-12 col-form-label">Motivo de la cancelación:</label>
					<div class="col-sm-12">
						<textarea name="notaeliminar" id="" class="form-control" rows="3" required="" maxlenght="60"></textarea>
					</div>
				</div>';

    echo response_modal($MDSIZE, $MDlFORM, $IDPOST, $IDPOST2, $MODPOST, $fileaction, $form_redirect, $NPOPUP, '#' . $row["confirmacion"] . ' ' . $row["nombre"], true);
    exit;
}


if ($MODPOST == 'servicio_eliminar_save') {

    $notaeliminar = $_POST["notaeliminar"];

    if ($num > 0) {
        $qryString =     " 	UPDATE trvreserva a SET 
								cve_statuscat='3',
								notaeliminar='" . addslashes($notaeliminar) . "'
							WHERE  cve_trvreserva='" . $IDPOST . "' " . $WHERE_UPDATE;
    }
    echo response_json($link, $qryString, $IDPOST, false);
    exit;
}
###########################################################################################################################

if ($MODPOST == 'servicio_confirmacion') {

    $MDlFORM = '<div class="mb-3 row">
					<label class="col-sm-12 col-form-label">Fecha de realizado:</label>
					<div class="col-sm-12">
						<input type="date" class="form-control" name="fechaservicio" value="" required="" maxlength="">
					</div>
					<label class="col-sm-12 col-form-label"> Escriba la notas finales:</label>
					<div class="col-sm-12">
						<textarea name="notarealizado" id="" class="form-control" rows="3"></textarea>
					</div>
				</div>';

    echo response_modal($MDSIZE, $MDlFORM, $IDPOST, $IDPOST2, $MODPOST, $fileaction, $form_redirect, $NPOPUP, '#' . $row["confirmacion"] . ' ' . $row["nombre"], true);
    exit;
}


if ($MODPOST == 'servicio_confirmacion_save') {

    $fechaservicio = $_POST["fechaservicio"];
    $notarealizado = $_POST["notarealizado"];


    if ($num > 0) {
        $qryString =     " 	UPDATE trvreserva SET 
								statuspago='5',
								fechaservicio='" . addslashes($fechaservicio) . "',
								notarealizado='" . addslashes($notarealizado) . "'
							WHERE cve_trvreserva='" . $IDPOST . "' " . $WHERE_UPDATE;
    }

    echo response_json($link, $qryString, $IDPOST, false);
    exit;
}
###########################################################################################################################

if ($MODPOST == 'servicio_asingacion' && $_SESSION["_SYS_0011"] > 0) {



    $qry_pro = @mysqli_query($link, "	SELECT a.* FROM tiendaprovedor a 
										WHERE a.cve_statuscat='1' 
										AND a.cve_sysusuario='" . $_SESSION["_SYS_0011"] . "' ");

    while ($row_pro = @mysqli_fetch_array($qry_pro)) {
        $options_prov .= '<option value="' . $row_pro[0] . '" ' . ($row_pro[0] == $row["cve_tiendaprovedor"] ? 'selected' : '') . '">' . $row_pro["nombre"] . '</option>';
    }

    $MDlFORM = '<div class="mb-3 row">
					<label class="col-sm-12 col-form-label">Proveedor asignado:</label>
					<div class="col-sm-12">
						<select class="form-control" name="provedor" required="" >
						' . $options_prov . '
						</select>
					</div>
				</div>';

    echo response_modal($MDSIZE, $MDlFORM, $IDPOST, $IDPOST2, $MODPOST, $fileaction, $form_redirect, $NPOPUP, '#' . $row["confirmacion"] . ' ' . $row["nombre"], true);
    exit;
}


if ($MODPOST == 'servicio_asingacion_save' && $_SESSION["_SYS_0011"] > 0) {

    $provedor = $_POST["provedor"];

    if ($num > 0) {
        $qryString =    " 	UPDATE trvreserva SET 
								cve_tiendaprovedor='" . addslashes($provedor) . "'
							WHERE cve_trvreserva='" . $IDPOST . "' " . $WHERE_UPDATE;
    }
    echo response_json($link, $qryString, $IDPOST, false);
    exit;
}
###########################################################################################################################
if ($MODPOST == 'servicio_noshow') {

    $MDlFORM = '<div class="mb-3 row">
					<label class="col-sm-12 col-form-label">Fecha:</label>
					<div class="col-sm-12">
						<input type="date" class="form-control" name="fechanoshow" value="" required="" maxlength="">
					</div>
					<label class="col-sm-12 col-form-label"> Escriba la notas finales:</label>
					<div class="col-sm-12">
						<textarea name="notanoshow" id="" class="form-control" rows="3" required></textarea>
					</div>
				</div>';

    echo response_modal($MDSIZE, $MDlFORM, $IDPOST, $IDPOST2, $MODPOST, $fileaction, $form_redirect, $NPOPUP, '#' . $row["confirmacion"] . ' ' . $row["nombre"], true);
    exit;
}


if ($MODPOST == 'servicio_noshow_save') {

    $fechanoshow     = $_POST["fechanoshow"];
    $notanoshow     = $_POST["notanoshow"];

    if ($num > 0) {
        $qryString =     " 	UPDATE trvreserva SET 
								statuspago='6',
								fechanoshow='" . $fechanoshow . "',
								notanoshow='" . addslashes($notanoshow) . "'
							WHERE cve_trvreserva='" . $IDPOST . "' " . $WHERE_UPDATE;
    }

    echo response_json($link, $qryString, $IDPOST, false);
    exit;
}

###########################################################################################################################

if ($MODPOST == 'servicio_reagendar') {

    $MDlFORM = '<div class="mb-3 row">
					<label class="col-sm-12 col-form-label">Fecha:</label>
					<div class="col-sm-12">
						<input type="date" class="form-control" name="fllegada" value="" required="" maxlength="">
					</div>
					<label class="col-sm-12 col-form-label">Hora:</label>
					<div class="col-sm-12">
						<input type="time" class="form-control" name="horallegada" value="" required="" maxlength="">
					</div>
					<label class="col-sm-12 col-form-label"> Escriba la notas:</label>
					<div class="col-sm-12">
						<textarea name="notarealizado" required class="form-control" rows="3">' . $row["notarealizado"] . '</textarea>
					</div>
				</div>';

    echo response_modal($MDSIZE, $MDlFORM, $IDPOST, $IDPOST2, $MODPOST, $fileaction, $form_redirect, $NPOPUP, '#' . $row["confirmacion"] . ' ' . $row["nombre"], true);
    exit;
}


if ($MODPOST == 'servicio_reagendar_save') {

    $fllegada         = $_POST["fllegada"];
    $horallegada     = $_POST["horallegada"];
    $notarealizado     = $_POST["notarealizado"];

    if ($num > 0) {

        $row = @mysqli_fetch_array($qry);

        $reagendado_respaldo = $row["reagendado_respaldo"] . '#' . $row["fecha_sys"] . '|' . $row["fllegada"] . '|' . $row["horallegada"];
        $qryString =     " 	UPDATE trvreserva SET 
								statuspago			=	'4',
								reagendado_respaldo	=	'" . $reagendado_respaldo . "',
								fecha_sys			=	'" . $fecha_sys . "',
								fllegada			=	'" . addslashes($fllegada) . "',
								horallegada			=	'" . addslashes($horallegada) . "',
								notarealizado		=	'" . $notarealizado . "'
							WHERE cve_trvreserva	=	'" . $IDPOST . "' " . $WHERE_UPDATE;
    }

    echo response_json($link, $qryString, $IDPOST, false);
    exit;
}
###########################################################################################################################

if ($MODPOST == 'servicio_ver') {

    if ($row["statuspago"] == 5) {
        $fecha = $row["fechaservicio"];
        $nota = $row["notaservicio"];
    } elseif ($row["statuspago"] == 6) {
        $fecha = $row["fechanoshow"];
        $nota = $row["notanoshow"];
    }

    $MDlFORM = '<div class="mb-3 row">
					<label class="col-sm-12 col-form-label">Fecha:</label>
					<div class="col-sm-12">
						<input type="date" class="form-control"  value="' . $fecha . '" disabled maxlength="">
					</div>
					<label class="col-sm-12 col-form-label">Notas:</label>
					<div class="col-sm-12">
						<textarea class="form-control" rows="3">' . $nota . '</textarea>
					</div>
				</div>';

    echo response_modal($MDSIZE, $MDlFORM, $IDPOST, $IDPOST2, $MODPOST, $fileaction, $form_redirect, $NPOPUP, '#' . $row["confirmacion"] . ' ' . $row["nombre"], false);
    exit;
}
###########################################################################################################################

if ($MODPOST == 'servicio_notas') {

    $MDlFORM = '<div class="mb-3 row">
					<label class="col-sm-12 col-form-label">Autor:</label>
					<div class="col-sm-12">
						<select class="form-control" name="nombre" required="">
						<option value="" disabled required="">Seleccione personal</option>
						<option value="Yesi">Yesi</option>
						<option value="Juan">Juan</option>
						<option value="Luis">Luis</option>
						<option value="Alejandra">Alejandra</option>
						<option value="Prueba">Prueba</option>
						</select>
					</div>
					<label class="col-sm-12 col-form-label"> Escriba la notas:</label>
					<div class="col-sm-12">
						<textarea name="notas" class="form-control" rows="3" required></textarea>
					</div>
				</div>';

    echo response_modal($MDSIZE, $MDlFORM, $IDPOST, $IDPOST2, $MODPOST, $fileaction, $form_redirect, $NPOPUP, '#' . $row["confirmacion"] . ' ' . $row["nombre"], true);
    exit;
}


if ($MODPOST == 'servicio_notas_save') {

    $nombre = $_POST["nombre"];
    $notas     = $_POST["notas"];

    if ($num > 0) {
        $qryString = " 	INSERT INTO trvreservanota(
													fecha_sys, 
													cve_sysusuario, 
													cve_statuscat, 
													cve_trvreserva, 
													nombre, 
													nota
												) VALUES (
													'" . $fecha_sys . "',
													'1060',
													'1',
													'" . $IDPOST . "',
													'" . addslashes($nombre) . "',
													'" . addslashes($notas) . "'
												)";
    }

    echo response_json($link, $qryString, $IDPOST, false);
    exit;
}

###########################################################################################################################

if ($_POST["draw"]) {

    $where .= " AND (
						UPPER(a.nombre) LIKE UPPER('%" . $_POST["search"]["value"] . "%') 
						OR 	UPPER(a.confirmacion) LIKE UPPER('%" . $_POST["search"]["value"] . "%')
						OR 	UPPER(a.cve_trvreserva) LIKE UPPER('%" . $_POST["search"]["value"] . "%')
						OR 	UPPER(a.telefono) LIKE UPPER('%" . $_POST["search"]["value"] . "%')
						OR 	UPPER(a.email) LIKE UPPER('%" . $_POST["search"]["value"] . "%')
					)";

    $qrystring = "	SELECT 
						a.*,
						DATE(a.fecha_sys) fecha
					FROM trvreserva a
					WHERE a.cve_statuscat='1'
					AND a.statuspago!='3'
					AND a.cve_sysusuario='1060'
					AND a.fllegada!='0000-00-00'
					" . $WHERE_SELECT . $_SESSION["_WHERE_"] . $where;


    $qrytotal = @mysqli_query($link, $qrystring);
    $num_rows_total = @mysqli_num_rows($qrytotal);

    if (isset($_POST["search"]["value"])) {
    }

    if ($_SESSION["_FILTRO_"] == 1 || $_SESSION["_FILTRO_"] == 2) {
        $where .=  "ORDER BY  a.fllegada  ASC ";
    } elseif ($_SESSION["_FILTRO_"] == 5 || $_SESSION["_FILTRO_"] == 4 || $_SESSION["_FILTRO_"] == 3) {
        $where .= " ORDER BY  a.cve_trvreserva DESC   ";
    } else {
    }

    #$where .= isset($_POST["order"]) ? " ORDER BY " . $_POST["order"]["0"]["column"] . ' ' . $_POST["order"]["0"]["dir"] : " ORDER BY cve_mmaenviomail DESC";
    $where .= $_POST["length"] != -1 ? ' LIMIT ' . $_POST["start"] . ',' . $_POST["length"] : '';

    $qry = @mysqli_query($link, $qrystring . $where);
    $data;
    $num_rows = @mysqli_num_rows($qry);
    if ($num_rows > 0) {
        while ($row = @mysqli_fetch_array($qry)) {
            $cliente = $servicio = $fechas = $paxs = $costos = $btns = $confirmacion = $notas = '';

            $qryscan = @mysqli_query($link, "	SELECT a.* FROM trvreservaqrscan a 
												WHERE a.cve_statuscat='1' 
												AND a.cve_trvreserva='" . $row["cve_trvreserva"] . "'");

            if ($_SESSION["_SYS_0011"] > 0) {

                $qry_pro = @mysqli_query($link, "	SELECT a.* FROM tiendaprovedor a 
													WHERE a.cve_statuscat='1' 
													AND a.cve_sysusuario='1060'
													AND a.cve_tiendaprovedor='" . $row["cve_tiendaprovedor"] . "'");
                if (@mysqli_num_rows($qry_pro) > 0) {

                    $provedor = '<div>
									<strong>Proveedor:</strong> ' . @mysqli_fetch_array($qry_pro)["nombre"] . '
								</div>';
                } else {

                    $provedor = '<div>
									<u>
										<a 
											href="#" 
											class="AbreModal" 
											data-target="#staticBackdrop" 
											data-toggle="modal" 
											id="' . $row[0] . '" 
											rel="0" 
											dir="servicio_asingacion" 
											title="Seleccionar proveedor" 
											media="" 
											name="' . $fileaction . '"> 
											<span style="font-style:italic;color:#F30; cursor:default;">
												<strong>¡Sin asignar a proveedor!</strong>
											</span>
										</a>
									</u>
								</div>';
                }
            }
            $qrynota = @mysqli_query($link, "	SELECT a.* FROM trvreservanota a 
												WHERE a.cve_statuscat='1' 
												AND a.cve_sysusuario='1060'
												AND a.cve_trvreserva='" . $row["cve_trvreserva"] . "' ORDER BY a.cve_trvreservanota DESC");
            while ($rownota = @mysqli_fetch_array($qrynota)) {
                $notas .= '<div>
							<strong>(' . $row["fecha_sys"] . ')<br> <i class="fas fa-user"></i> ' . $rownota["nombre"] . ':</strong> <i class="fas fa-arrow-right"></i> ' . $rownota["nota"] . '
						</div>';
            }

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

            if ($row["statuspago"] == 0) {
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
            }
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