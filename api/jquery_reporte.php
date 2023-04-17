<?
if ($MODPOST == 'env_mail' and $_SESSION["CVE_SYSUSUARIO"] >= 1) {

	$qry = @mysqli_query($link, "
		SELECT 
			a.cve_blog,
			a.cve_statuscat,
			a.descripcion
		FROM  blog a
		WHERE a.cve_blog='" . $IDPOST . "'
		AND a.cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "'");
	$row = @mysqli_fetch_array($qry);

	$qryStatucat = @mysqli_query($link, "SELECT * FROM syscrmstatusc a ");

	while ($rowStatucat = @mysqli_fetch_array($qryStatucat)) {

		if ($row["cve_statuscat"] == $rowStatucat["cve_statuscat"]) {
			$selected = "selected";
			$mdlcomp = '
				<div class="text-center rounded p-5 ' . $rowStatucat["color"] . '" id="icon_status">
					<i class="' . $rowStatucat["icono"] . ' text-white" style="font-size:100px !important;"></i>
				</div>';
		} else {
			$selected = "";
		}
		$status_options .= '<option ' . $selected . ' title="' . $rowStatucat["icono"] . '" dir="100px" value="' . $rowStatucat["cve_statuscat"] . '" data-color="' . $rowStatucat["color"] . '" >' . $rowStatucat["descripcion" . $_SESSION["LANG"]] . '</option>';
	}

	$MDlFORM = '<form class="modal-content" id="form_save" name="form_save" action="#middle">
					<input type="hidden" id="IDPOST"  		name="IDPOST" value="' . $IDPOST . '" />
					<input type="hidden" id="IDPOST2" 		name="IDPOST2" value="' . $IDPOST2 . '" />
					<input type="hidden" id="MODPOST" 		name="MODPOST" value="' . $MODPOST . '_save" />
					<input type="hidden" id="form_file" 	name="form_file" value="' . $fileaction . '" alt="Nombre de archivo PHP donde se guarda(solo nombre .php)" />
					<input type="hidden" id="form_redirect" name="form_redirect" value="' . $form_redirect . '" alt="Nombre PHP donde estan todos los datos" />
					<input type="hidden" id="form_act" 		name="form_act" value="1" alt="0=redirect al contenido, 1= se hace un load al contenido, 2=Llamada a funcion" />
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle">' . ((strlen($_SESSION["LANG"]) > 2) ? 'Actualizar Estado:' : 'Update status:') . ' ' . $row["descripcion"] . '</h5>
						<button type="button" class="close" data-dismiss="modal" aria-p="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-6 mx-auto ">
							' . $mdlcomp . '
							</div>
							<div class="py-2 col-10 mx-auto">
								<select class="form-control" id="IDSTATUS" name="IDSTATUS">
									' . $status_options . '
								</select>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger " data-dismiss="modal">' . ((strlen($_SESSION["LANG"]) > 2) ? 'Cancelar' : 'Cancel') . '</button>
						<button type="submit" class="btn btn-success" id="btn_form" >' . ((strlen($_SESSION["LANG"]) > 2) ? 'Actualizar' : 'Update') . ' </button><span id="form_load"></span>
					</div>
				</form>';

	$MOdalRet =  modalreturn($MDSIZE, $MDlFORM);
	echo json_encode($MOdalRet);
	exit;
}


if ($MODPOST == 'blog_sts_save' and $_SESSION["CVE_SYSUSUARIO"] >= 1) {
	$IDPOST 	= $_POST["IDPOST"];
	$xd1 	= $_POST["IDSTATUS"];

	$qryblog = @mysqli_query($link, "
		SELECT 
			a.cve_blog,
			a.cve_statuscat,
			a.descripcion
		FROM  blog a
		WHERE a.cve_blog='" . $IDPOST . "'
		AND a.cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "'");

	if (@mysqli_num_rows($qryblog)  > 0) {
		$qryString = "
			UPDATE blog SET
				cve_statuscat = '" . $xd1 . "'
			where cve_blog		= '" . $IDPOST . "'
			AND cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "'";
	}

	echo response_json($link, $qryString, $IDPOST);
	exit;
}
###########################################################################################################################
###########################################################################################################################

if ($MODPOST == 'blog_add' and $_SESSION["CVE_SYSUSUARIO"] >= 1) {
	$qryblog = @mysqli_query($link, "
			SELECT 
				a.*
			FROM  blog a
			WHERE a.cve_blog='" . $IDPOST . "'
			AND a.cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "'");
	$rowblog = @mysqli_fetch_array($qryblog);
	$btn = (strlen($_SESSION["LANG"]) > 2) ? 'Agregar' : 'Add';
	if (@mysqli_num_rows($qryblog) > 0) {
		$btn = (strlen($_SESSION["LANG"]) > 2) ? 'Actualizar' : 'Update';
	}

	$MDlFORM = '<form class="modal-content" id="form_save" name="form_save" action="#middle"  enctype="multipart/form-data">
					<input type="hidden" id="IDPOST"  		name="IDPOST" value="' . $IDPOST . '" />
					<input type="hidden" id="IDPOST2" 		name="IDPOST2" value="' . $IDPOST2 . '" />
					<input type="hidden" id="MODPOST" 		name="MODPOST" value="' . $MODPOST . '_save" />
					<input type="hidden" id="form_file" 	name="form_file" value="' . $fileaction . '" alt="Nombre de archivo PHP donde se guarda(solo nombre .php)" />
					<input type="hidden" id="form_redirect" name="form_redirect" value="' . $form_redirect . '" alt="Nombre PHP donde estan todos los datos" />
					<input type="hidden" id="form_act" 		name="form_act" value="1" alt="0=redirect al contenido, 1= se hace un load al contenido, 2=Llamada a funcion" />
					<div class="modal-header">
						<h5 class="modal-title">' . $btn . ' ' . ((strlen($_SESSION["LANG"]) > 2) ? 'blog' : 'blog')  . ': ' . $rowblog["descripcion"] . '</h5>
						<button type="button" class="close" data-dismiss="modal" aria-p="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<div class="row">
								<div class="col-sm-12">
									<div class="form-inline">
										<div class="col-sm-12 my-1">
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text">' . ((strlen($_SESSION["LANG"]) > 2) ? 'Nombre de blog' : 'Blog name') . ':*</div>
												</div>
												<input type="text" class="form-control" value="' . $rowblog["descripcion"] . '" maxlength="60" name="descripcion" required >
											</div>
										</div>
										<div class="col-sm-12 my-1">
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text">' . ((strlen($_SESSION["LANG"]) > 2) ? 'Titúlo SEO' : 'Title SEO') . ': *</div>
												</div>
												<input type="text" class="form-control" value="' . $rowblog["seotitulo"] . '" maxlength="60" name="seotitulo" required >
											</div>
										</div>
										<div class="col-sm-12 my-1">
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text">' . ((strlen($_SESSION["LANG"]) > 2) ? 'Descripción SEO' : 'Description SEO') . ': *</div>
												</div>
												<input type="text" class="form-control" value="' . $rowblog["seodescripcion"] . '" maxlength="60" name="seodescripcion" required >										
											</div>
										</div>
										<div class="col-sm-12 my-1">
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text">' . ((strlen($_SESSION["LANG"]) > 2) ? 'Fecha de publicación' : 'Publication date') . ': *:</div>
												</div>
												<input type="date" class="form-control" value="' . $rowblog["fecha_pub"] . '" maxlength="60" name="fecha_pub" required >																					
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger " data-dismiss="modal">' . ((strlen($_SESSION["LANG"]) > 2) ? 'Cancelar' : 'Cancel') . '</button>
						<button type="submit" class="btn btn-success" id="btn_form" >' . $btn . ' </button><span id="form_load"></span>
					</div>
					<script>initSample();</script>
				</form>';
	echo json_encode(modalreturn($MDSIZE, $MDlFORM));
	exit;
}

if ($MODPOST == 'blog_add_save' and $_SESSION["CVE_SYSUSUARIO"] >= 1) {

	$descripcion 	= $_POST["descripcion"];
	$seotitulo 		= $_POST["seotitulo"];
	$seodescripcion = $_POST["seodescripcion"];
	$fecha_pub 		= $_POST["fecha_pub"];
	$url 		= generat_url($descripcion);



	$qryblog = @mysqli_query($link, " 	SELECT 
											a.*
										FROM  blog a
										WHERE a.cve_blog='" . $IDPOST . "'
										AND a.cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "'");
	$rowblogd = @mysqli_fetch_array($qryblog);

	if (@mysqli_num_rows($qryblog)  > 0) {
		$qryString = " 	UPDATE blog SET
							descripcion 	= '" . addslashes($descripcion) . "',
							seotitulo 		= '" . addslashes($seotitulo) . "',
							seodescripcion 	= '" . addslashes($seodescripcion) . "',
							fecha_pub 		= '" . addslashes($fecha_pub) . "',
							url 			= '" . addslashes($url) . "'
						WHERE cve_blog	= '" . $IDPOST . "'
						AND cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "'";
	} else {
		$qryString = "	INSERT INTO blog (cve_statuscat,cve_sysusuario,fecha_sys,descripcion,seotitulo,seodescripcion,fecha_pub,url) 
						VALUES('1','" . $_SESSION["CVE_SYSUSUARIO"] . "','" . $fecha_sys . "','" . addslashes($descripcion) . "','" .  addslashes($seotitulo) . "','" .  addslashes($seodescripcion) . "','" .  addslashes($fecha_pub) . "','" .  addslashes($url)  . "')";
	}

	echo response_json($link, $qryString, $IDPOST);
	exit;
}
#fin del componente
###########################################################################################################################
###########################################################################################################################
if ($MODPOST == 'blogdet_add' and $_SESSION["CVE_SYSUSUARIO"] >= 1) {
	$qryblog = @mysqli_query($link, " 	SELECT 
											a.*
										FROM  blogdet a
										WHERE a.cve_blog='" . $IDPOST . "'
										AND a.cve_blogdet='" . $IDPOST2 . "'
										AND a.cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "'");
	$rowblog = @mysqli_fetch_array($qryblog);
	$btn = (strlen($_SESSION["LANG"]) > 2) ? 'Agregar' : 'Add';
	if (@mysqli_num_rows($qryblog) > 0) {
		$btn = (strlen($_SESSION["LANG"]) > 2) ? 'Actualizar' : 'Update';
	}

	$arraybottom = [
		((strlen($_SESSION["LANG"]) > 2) ? 'No mostrar en menú inferior' : "Do not show in lower menu"),
		((strlen($_SESSION["LANG"]) > 2) ? "Mostrar en menú inferior" : "Show in lower menu")
	];

	for ($i = 0; $i < count($arraybottom); $i++) {

		$selected =  ($rowmenu["mostrarpp"] == $i) ? "selected" : '';
		$bottom_options .= '<option ' . $selected . ' value="' . $i  . '" >' . $arraybottom[$i] . '</option>';
	}


	$qryStatucat = @mysqli_query($link, "SELECT * FROM syscrmstatusc a ");

	while ($rowStatucat = @mysqli_fetch_array($qryStatucat)) {

		$selected =  ($rowblog["cve_statuscat"] == $rowStatucat["cve_statuscat"]) ? "selected" : "";
		$status_options .= '<option ' . $selected . ' value="' . $rowStatucat["cve_statuscat"] . '">' . $rowStatucat["descripcion" . $_SESSION["LANG"]] . '</option>';
	}

	$MDlFORM = '<form class="modal-content" id="form_save" name="form_save" action="#middle"  enctype="multipart/form-data">
					<input type="hidden" id="IDPOST"  		name="IDPOST" value="' . $IDPOST . '" />
					<input type="hidden" id="IDPOST2" 		name="IDPOST2" value="' . $IDPOST2 . '" />
					<input type="hidden" id="MODPOST" 		name="MODPOST" value="' . $MODPOST . '_save" />
					<input type="hidden" id="form_file" 	name="form_file" value="' . $fileaction . '" alt="Nombre de archivo PHP donde se guarda(solo nombre .php)" />
					<input type="hidden" id="form_redirect" name="form_redirect" value="' . $form_redirect . '" alt="Nombre PHP donde estan todos los datos" />
					<input type="hidden" id="form_act" 		name="form_act" value="1" alt="0=redirect al contenido, 1= se hace un load al contenido, 2=Llamada a funcion" />
					<div class="modal-header">
						<h5 class="modal-title">' . $btn . ' ' . ((strlen($_SESSION["LANG"]) > 2) ? 'tema' : 'theme')  . ': ' . $rowblog["titulo"] . '</h5>
						<button type="button" class="close" data-dismiss="modal" aria-p="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<div class="row">
								<div class="col-sm-12">
									<div class="form-inline">
										<div class="col-sm-12 col-md-6 my-1 pr-0">
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text">' . ((strlen($_SESSION["LANG"]) > 2) ? 'Titúlo' : 'Title') . ':*</div>
												</div>
												<input type="text" class="form-control" value="' . $rowblog["titulo"] . '" maxlength="60" name="titulo" required >
											</div>
										</div>
										<div class="col-sm-12 col-md-6 my-1">
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text">' . ((strlen($_SESSION["LANG"]) > 2) ? 'Fecha publicación' : 'Publication date') . ': *</div>
												</div>
												<input type="date" class="form-control" value="' . $rowblog["fecha_pub"] . '" maxlength="60" name="fecha_pub" required >
												<input type="time" class="form-control" value="' . $rowblog["hora"] . '" maxlength="60" name="hora" required >
											</div>
										</div>
										<!--<div class="col-sm-12 col-md-6 my-1">
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text">' . ((strlen($_SESSION["LANG"]) > 2) ? 'Autor' : 'Author') . ': *</div>
												</div>
												<select class="form-control" name="autor" >
												' . $tipo_options . '
												</select>												
											</div>
										</div>-->
										<div class="col-sm-12 col-md-6 my-1 pr-0">
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text">' . ((strlen($_SESSION["LANG"]) > 2) ? 'Imagen' : 'Imagen') . '  ' . ($rowblog["imagen"] ? '( <a href="' . $rowblog["imagenruta"] . $rowblog["imagen"] . '" target="_blank">' . ((strlen($_SESSION["LANG"]) > 2) ? ' Ver img' : ' View img') . '</a> ) ' : '') . ' :</div>
												</div>
												<input type="file" name="imagenfile" class="form-control"  >																					
											</div>
										</div>
										<div class="col-sm-12 col-md-6 my-1">
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text">' . ((strlen($_SESSION["LANG"]) > 2) ? 'Archivo' : 'File') . '   ' . ($rowblog["archivo"] ? '( <a href="' . $rowblog["archivoruta"] . $rowblog["archivo"] . '" target="_blank">' . ((strlen($_SESSION["LANG"]) > 2) ? ' Ver archivo' : ' View file') . '</a> ) ' : '') . ' :</div>
												</div>
												<input type="file" name="docfile" class="form-control"  >																					
											</div>
										</div>
										<div class="col-sm-12 col-md-6 my-1 pr-0">
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text">' . ((strlen($_SESSION["LANG"]) > 2) ? 'Url externo' : 'External url') . ' :</div>
												</div>
												<input type="text" class="form-control" value="' . $rowblog["urlext"] . '" maxlength="60" name="urlext"  >																					
											</div>
										</div>
										<div class="col-sm-6 my-1">
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text">' . ((strlen($_SESSION["LANG"]) > 2) ? 'Url vídeo' : 'Url video') . ' :</div>
												</div>
												<input type="text" class="form-control" value="' . $rowblog["video"] . '" maxlength="250" name="video"  >																					
											</div>
										</div>
										<div class="col-sm-6 my-1 pr-0">
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text">' . ((strlen($_SESSION["LANG"]) > 2) ? 'Estado' : 'Status') . ' *:</div>
												</div>
												<select class="form-control" name="status" >
												' . $status_options . '
												</select>												
											</div>
										</div>
										<div class="col-sm-12 my-1">
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text">' . ((strlen($_SESSION["LANG"]) > 2) ? 'Descripción corta' : 'Short description') . ': *:</div>
												</div>
												<textarea class="form-control" maxlength="250" name="descripcion" required  rows="3">' . $rowblog["descripcion"] . '</textarea>
											</div>
										</div>
										<div class="col-sm-12 my-1">
											<textarea id="editor" name="contenido">' . $rowblog["contenido"] . '</textarea>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger " data-dismiss="modal">' . ((strlen($_SESSION["LANG"]) > 2) ? 'Cancelar' : 'Cancel') . '</button>
						<button type="submit" class="btn btn-success" id="btn_form" >' . $btn . ' </button><span id="form_load"></span>
					</div>
					<script>initSample();</script>
				</form>';
	echo json_encode(modalreturn($MDSIZE, $MDlFORM));
	exit;
}

if ($MODPOST == 'blogdet_add_save' and $_SESSION["CVE_SYSUSUARIO"] >= 1) {

	$titulo 		= $_POST["titulo"];
	$autor 			= $_POST["autor"];
	$fecha_pub 		= $_POST["fecha_pub"];
	$urlext 		= $_POST["urlext"];
	$status 		= $_POST["status"];
	$descripcion 	= $_POST["descripcion"];
	$contenido 		= $_POST["contenido"];
	$video 			= $_POST["video"];
	$hora 			= $_POST["hora"];

	$qryblog = @mysqli_query($link, " 	SELECT 
											a.*
										FROM  blogdet a
										WHERE a.cve_blog='" . $IDPOST . "'
										AND a.cve_blogdet='" . $IDPOST2 . "'
										AND a.cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "'");

	$rowblog = @mysqli_fetch_array($qryblog);
	if (@mysqli_num_rows($qryblog) > 0) {
		$qryString = " 	UPDATE blogdet SET
							titulo 			= '" . $titulo . "',
							cve_blogautores = '" . $autor . "',
							fecha_pub 		= '" . $fecha_pub . "',
							urlext 			= '" . $urlext . "',
							cve_statuscat 	= '" . $status . "',
							descripcion 	= '" . $descripcion . "',
							url 			= '" . generat_url($descripcion) . "',
							hora 			= '" . $hora . "',
							video 			= '" . $video . "',
							contenido 		= '" . $contenido . "'
						where cve_blog		= '" . $IDPOST . "'
						AND cve_blogdet='" . $IDPOST2 . "'
						AND cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "'";
	} else {
		$qryString = "	INSERT INTO blogdet (cve_statuscat,cve_sysusuario,fecha_sys,cve_blog,titulo,cve_blogautores,fecha_pub,urlext,descripcion,contenido,video,url,hora) 
						VALUES('1','" . $_SESSION["CVE_SYSUSUARIO"] . "','" . $fecha_sys . "','" . addslashes($IDPOST) . "','" .  addslashes($titulo) . "','" .  addslashes($cve_blogautores) . "','" .  addslashes($fecha_pub) . "','" .  addslashes($urlext)  . "','" .  addslashes($descripcion)  . "','" .  addslashes($contenido) . "','" .  addslashes($video) . "','" .  generat_url($descripcion)  . "','" .  addslashes($hora)  . "')";
	}

	#echo  response_json_imagen($link, $qryString, $IDPOST2, 1500, 750, './../img-web-blog/', '/img-web-blog/', 'blogdet', 'imagenruta');
	echo response_json_doc_imagen($link, $qryString, $IDPOST2, 1500, 750, './../img-web-blog/', '/img-web-blog/', 'blogdet', 'imagenruta', './../doc-web/', '/doc-web/');

	exit;
}
###########################################################################################################################
###########################################################################################################################

#COMPONENTE
if ($MODPOST == 'img_add' and $_SESSION["CVE_SYSUSUARIO"] >= 1) {
	$qryblog = @mysqli_query($link, " 	SELECT 
											a.*
										FROM  blog a
										WHERE a.cve_blog='" . $IDPOST . "'
										AND a.cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "'");
	$rowblog = @mysqli_fetch_array($qryblog);

	$btn = (strlen($_SESSION["LANG"]) > 2) ? 'Agregar' : 'Add';
	if (@mysqli_num_rows($qryblog) > 0) {
		$btn = (strlen($_SESSION["LANG"]) > 2) ? 'Actualizar' : 'Update';
	}
	$MDlFORM = '<form class="modal-content" id="form_save" name="form_save" action="#middle"  enctype="multipart/form-data">
					<input type="hidden" id="IDPOST"  		name="IDPOST" value="' . $IDPOST . '" />
					<input type="hidden" id="IDPOST2" 		name="IDPOST2" value="' . $IDPOST2 . '" />
					<input type="hidden" id="MODPOST" 		name="MODPOST" value="' . $MODPOST . '_save" />
					<input type="hidden" id="form_file" 	name="form_file" value="' . $fileaction . '" alt="Nombre de archivo PHP donde se guarda(solo nombre .php)" />
					<input type="hidden" id="form_redirect" name="form_redirect" value="' . $form_redirect . '" alt="Nombre PHP donde estan todos los datos" />
					<input type="hidden" id="form_act" 		name="form_act" value="1" alt="0=redirect al contenido, 1= se hace un load al contenido, 2=Llamada a funcion" />
					<div class="modal-header">
						<h5 class="modal-title">' . $btn . ' ' . ((strlen($_SESSION["LANG"]) > 2) ? 'banner' : 'banner')  . ': ' . $rowblog["descripcion"] . '</h5>
						<button type="button" class="close" data-dismiss="modal" aria-p="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<div class="row">
								<div class="col-sm-12">
									<div class="form-inline">
										<div class="col-sm-12 my-1">
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text">' . ((strlen($_SESSION["LANG"]) > 2) ? 'Banner' : 'Banner') . ': *:</div>
												</div>
												<input type="file" class="form-control" name="imagenfile" required >
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger " data-dismiss="modal">' . ((strlen($_SESSION["LANG"]) > 2) ? 'Cancelar' : 'Cancel') . '</button>
						<button type="submit" class="btn btn-success" id="btn_form" >' . $btn . ' </button><span id="form_load"></span>
					</div>
				</form>';
	echo json_encode(modalreturn($MDSIZE, $MDlFORM));
	exit;
}

if ($MODPOST == 'img_add_save' and $_SESSION["CVE_SYSUSUARIO"] >= 1) {
	$qryblog = @mysqli_query($link, " 	SELECT 
											a.*
										FROM  blog a
										WHERE a.cve_blog='" . $IDPOST . "'
										AND a.cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "'");
	$rowblog = @mysqli_fetch_array($qryblog);

	echo  response_json_imagen($link, $qryString, $IDPOST, 1500, 750, './../img-web-blog/', '/img-web-blog/', 'blog', 'imagenruta');
	exit;
}

#fin del componente
###########################################################################################################################