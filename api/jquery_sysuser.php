<?
if ($MODPOST == 'sysuser_sts' and $_SESSION["_SYS_0011"] >= 1 ) {

	$qry = @mysqli_query($link, "
		SELECT 
			a.cve_sysusuario,
			a.cve_statuscat,
			a.descripcion
		FROM  sysuser a
		WHERE a.cve_sysusuario='" . $IDPOST . "'
		");
	$row = @mysqli_fetch_array($qry);
	$IDPOST2 = $row["cve_sysusuario"];

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
		$status_options .= '<option ' . $selected . ' title="' . $rowStatucat["icono"] . '" dir="100px" value="' . $rowStatucat["cve_statuscat"] . '" data-color="' . $rowStatucat["color"] . '" >' . $rowStatucat["descripcion"] . '</option>';
	}

	$MDlFORM = '<form class="modal-content" id="form_save" name="form_save" action="#middle">
					<input type="hidden" id="IDPOST"  		name="IDPOST" value="' . $IDPOST . '" />
					<input type="hidden" id="IDPOST2" 		name="IDPOST2" value="' . $IDPOST2 . '" />
					<input type="hidden" id="MODPOST" 		name="MODPOST" value="' . $MODPOST . '_save" />
					<input type="hidden" id="form_file" 	name="form_file" value="' . $fileaction . '" alt="Nombre de archivo PHP donde se guarda(solo nombre .php)" />
					<input type="hidden" id="form_redirect" name="form_redirect" value="' . $form_redirect . '" alt="Nombre PHP donde estan todos los datos" />
					<input type="hidden" id="form_act" 		name="form_act" value="1" alt="0=redirect al contenido, 1= se hace un load al contenido, 2=Llamada a funcion" />
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle">Actualizar Status: ' . $row["descripcion"] . '</h5>
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
						<button type="submit" class="btn btn-success" id="btn_form" >Actualizar </button><span id="form_load"></span>
					</div>
				</form>';

	$MOdalRet =  modalreturn($MDSIZE, $MDlFORM);
	echo json_encode($MOdalRet);
	exit;
}


if ($MODPOST == 'sysuser_sts_save' and $_SESSION["_SYS_0011"] >= 1 ) {
	$IDPOST 	= $_POST["IDPOST"];
	$xd1 	= $_POST["IDSTATUS"];

	$qrysysuser = @mysqli_query($link, "
		SELECT 
			a.cve_sysusuario,
			a.cve_statuscat,
			a.descripcion
		FROM  sysuser a
		WHERE a.cve_sysusuario='" . $IDPOST . "'
		");

	if (@mysqli_num_rows($qrysysuser)  > 0) {
		$qryString = "
			UPDATE sysuser SET
				cve_statuscat = '" . $xd1 . "'
			where cve_sysusuario		= '" . $IDPOST . "'
			
			";
	}
	echo response_json($link, $qryString, $IDPOST);
	exit;
}


if ($MODPOST == 'sysuser_add' and $_SESSION["_SYS_0011"] >= 1 ) {

	if ($_SESSION["_SYS_0011"] > 0) {
		$qryMod = @mysqli_query($link, "
    SELECT * FROM syscrmmoda 
    WHERE a.cve_statuscat='1'
    AND a.sub = '0'");
		while ($rowMod = @mysqli_fetch_array($qryMod)) {
			$submenus = $submenu = '';

			if ($rowMod["cve_modulosub"]) {
				$qryModsub = @mysqli_query($link, "
            SELECT * FROM syscrmmoda 
            WHERE a.cve_statuscat=1  
            AND a.sub =1 
            AND a.cve_syscrmmodIN (" .  $rowMod["cve_modulosub"] . ")");
				while ($rowModsub = @mysqli_fetch_array($qryModsub)) {

					$submenu .= '<li class="list-group-item">
								<div class="input-group">		
                                    <div class="input-group-prepend">
                                    </div>
                                    <label class="form-control border-0"><strong>' . $rowModsub["descripcion"] . '</strong></label>
									<div class="input-group-text">
									<input type="checkbox" name="mod[]" class="mod" dir="' . $rowMod["cve_sysmodulo"] . '" value="' . $rowModsub["cve_sysmodulo"] . '" >
								  </div>
                                </div>
							</li>';
				}

				$submenus .=
					'<div id="collapse' . $rowMod["cve_sysmodulo"] . '" class="collapse" aria-labelledby="heading' . $rowMod["cve_sysmodulo"] . '" data-parent="#accordion2">
                        <ul class="list-group sticky-top" style="top:3.5em;">
                        ' . $submenu . '   
                        </ul>
                </div>';
			}

			$menu .= '  <div class="card">
                        <div id="heading' . $rowMod["cve_sysmodulo"] . '" class="card-header  "  data-toggle="collapse" data-target="#collapse' . $rowMod["cve_sysmodulo"] . '"  aria-expanded="true" aria-controls="collapse' . $rowMod["cve_sysmodulo"] . '" >
                            <h5 class="mb-0">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><img src="/home/imagen/' . $rowMod["icono"] . '" class="rounded-circle" height="15" alt=""></div>
                                    </div>
                                    <label class="form-control "><strong>' . $rowMod["descripcion"] . '</strong></label>
									<div class="input-group-text">
									<input type="checkbox" name="mod[]" class="mod"  value="' . $rowMod["cve_sysmodulo"] . '">
								  </div>
                                </div>
                            </h5>
                        </div>
                        ' . $submenus . '
                    </div>';
		}

		$arrayAccesos = ["Lectura", "Insertar", "Insertar y Editar"];
		$j = '';
		for ($i = 0; $i < count($arrayAccesos); $i++) {

			$access .= ($i + 1) . ',';
			$j++;

			if (trim($access, ',')  == trim($rowsysuser["sysacceso"])) {
				$selected = "selected";
			} else {
				$selected = "";
			}
			$access_options .= '<option ' . $selected . ' value="' . trim($access, ",") . '" >' . $arrayAccesos[$i] . '</option>';
		}
	}


	$qrysysuser = @mysqli_query($link, "
			SELECT 
				a.*
			FROM  sysuser a
			WHERE a.cve_sysusuario='" . $IDPOST . "'
			");
	$rowsysuser = @mysqli_fetch_array($qrysysuser);
	$btn = 'Agregar';
	if (@mysqli_num_rows($qrysysuser) > 0) {
		$btn = 'Actualizar';
	}


	$MDlFORM = '<form class="modal-content" id="form_save" name="form_save" action="#middle"  enctype="multipart/form-data">
					<input type="hidden" id="IDPOST"  		name="IDPOST" value="' . $IDPOST . '" />
					<input type="hidden" id="IDPOST2" 		name="IDPOST2" value="' . $IDPOST2 . '" />
					<input type="hidden" id="MODPOST" 		name="MODPOST" value="' . $MODPOST . '_save" />
					<input type="hidden" id="form_file" 	name="form_file" value="' . $fileaction . '" alt="Nombre de archivo PHP donde se guarda(solo nombre .php)" />
					<input type="hidden" id="form_redirect" name="form_redirect" value="' . $form_redirect . '" alt="Nombre PHP donde estan todos los datos" />
					<input type="hidden" id="form_act" 		name="form_act" value="1" alt="0=redirect al contenido, 1= se hace un load al contenido, 2=Llamada a funcion" />
					<div class="modal-header">
						<h5 class="modal-title">' . $btn . '  Usuario:  ' . $rowsysuser["descripcion"] . '</h5>
						<button type="button" class="close" data-dismiss="modal" aria-p="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<div class="row">
								<div class="col-sm-12">
									<div class="form-inline py-1">
										<p class="col-form-p pr-5 col-sm-2">Nombre:</p>
										<input type="text" class="form-control col-sm-10"  value="' . $rowsysuser["nombre"] . '" maxlength="40" name="nombre" required>
									</div>
									<div class="form-inline py-1">
										<p  class=" text-left col-form-p  pr-5 col-sm-2">Correo:</p>
										<input type="text" class="form-control col-sm-4" value="' . $rowsysuser["email"] . '" maxlength="30" name="email" required>
									</div>
									<div class="form-inline py-1">
										<p  class=" text-left col-form-p  pr-5 col-sm-2">Teléfono:</p>
										<input type="text" class="form-control col-sm-4" value="' . $rowsysuser["telefono"] . '" maxlength="15"  name="telefono" required>
										<p  class=" text-left col-form-p  pr-5 col-sm-2">Acceso:</p>
										<select class="form-control col-sm-4" name="access" >
											' . $access_options . '
										</select>
									</div>
									<div class="form-inline py-1">
										<p  class=" text-left col-form-p pr-5 col-sm-2">pagina:</p>
										<input type="text" class="form-control  col-sm-10" value="' . $rowsysuser["pagina"] . '" maxlength="60" name="pagina" required>
									</div>
									<div class="form-inline py-1">
										<p  class=" text-left col-form-p pr-5 col-sm-2">usuario:</p>
										<input type="text" class="form-control  col-sm-4" value="' . $rowsysuser["usuario"] . '" maxlength="20" name="usuario" required>
										<p  class=" text-left col-form-p pr-5 col-sm-2">Contraseña Nueva:</p>
										<input type="text" class="form-control  col-sm-4" value="" maxlength="20" name="passw" >
									</div>	
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger " data-dismiss="modal">' . ((strlen($_SESSION["LANG"]) > 2) ? 'Cancelar' : 'Cancel') . '</button>
						<button type="submit" class="btn btn-success" id="btn_form" >' . $btn . ' </button><span id="form_load"></span>
					</div>
					<script>
						var mods="' . str_replace("'", "", $rowsysuser["sysmodulo"])  . '".split(",");
						$(".mod").each(function() {
							for(var i=0;i < mods.length;i++){
								if($(this).val()==mods[i]){
									$(this).prop("checked",true);
								}
							}
						});
					</script>
				</form>';
	echo json_encode(modalreturn($MDSIZE, $MDlFORM));
	exit;
}

if ($MODPOST == 'sysuser_add_save' and $_SESSION["_SYS_0011"] >= 1 ) {

	$IDPOST 	= $_POST["IDPOST"];
	$nombre 	= $_POST["nombre"];
	$email 		= $_POST["email"];
	$telefono 	= $_POST["telefono"];
	$pagina 	= $_POST["pagina"];
	$usuario 	= $_POST["usuario"];
	$passw 		= $_POST["passw"];
	$access 	= $_POST["access"];
	$mod 		= $_POST["mod"];

	$qrysysuser = @mysqli_query($link, "
	SELECT 
		a.*
	FROM  sysuser a
	WHERE a.cve_sysusuario='" . $IDPOST . "'");
	$rowsysuserd = @mysqli_fetch_array($qrysysuser);

	if (@mysqli_num_rows($qrysysuser)  > 0) {

		if (trim($passw)) {
			$qryString = "
			UPDATE sysuser SET
				nombre 			= '" . addslashes($nombre) . "',
				email 			= '" . addslashes($email) . "',
				telefono 		= '" . addslashes($telefono) . "',
				pagina 			= '" . addslashes($pagina) . "',
				usuario 		= '" . addslashes($usuario) . "',
				passw 			= AES_ENCRYPT('" . addslashes($passw) . "','" . $GLOBALS['conf_ky_pswds'] . "')
				sysacceso 		= '" . addslashes($access) . "',
			where cve_sysusuario	= '" . $IDPOST . "'";
		} else {
			$qryString = "
				UPDATE sysuser SET
					nombre 			= '" . addslashes($nombre) . "',
					email 			= '" . addslashes($email) . "',
					telefono 		= '" . addslashes($telefono) . "',
					pagina 			= '" . addslashes($pagina) . "',
					usuario 		= '" . addslashes($usuario) . "',
					sysacceso 		= '" . addslashes($access) . "'
				where cve_sysusuario	= '" . $IDPOST . "'";
		}
	} else {
		$qryString = "INSERT INTO sysuser (cve_statuscat,cve_sysusuario,fecha_sys,nombre,email,telefono,pagina,passw,sysacceso) 
					VALUES('1','" . $_SESSION["_SYS_0011"] . "','" . $fecha_sys . "','" . addslashes($nombre) . "','" .  addslashes($email)  . "','" .  addslashes($telefono)  . "','" .  addslashes($pagina)  . "','" .  addslashes($usuario)  . "','" . addslashes($passw)  . "','" .  addslashes($access) . "')";
	}

	echo response_json($link, $qryString, $IDPOST);
	exit;
}
#fin del componente


if ($MODPOST == 'sysuser_conf' and $_SESSION["_SYS_0011"] >= 1 ) {

	$qrysysuser = @mysqli_query($link, "
			SELECT 
				a.*
			FROM  sysuser a
			WHERE a.cve_sysusuario='" . $IDPOST . "'
			");
	$rowsysuser = @mysqli_fetch_array($qrysysuser);
	$btn = 'Error';
	if (@mysqli_num_rows($qrysysuser) > 0) {
		$btn = 'Actualizar';
	}


	$MDlFORM = '<form class="modal-content" id="form_save" name="form_save" action="#middle"  enctype="multipart/form-data">
					<input type="hidden" id="IDPOST"  		name="IDPOST" value="' . $IDPOST . '" />
					<input type="hidden" id="IDPOST2" 		name="IDPOST2" value="' . $IDPOST2 . '" />
					<input type="hidden" id="MODPOST" 		name="MODPOST" value="' . $MODPOST . '_save" />
					<input type="hidden" id="form_file" 	name="form_file" value="' . $fileaction . '" alt="Nombre de archivo PHP donde se guarda(solo nombre .php)" />
					<input type="hidden" id="form_redirect" name="form_redirect" value="inicio.php" alt="Nombre PHP donde estan todos los datos" />
					<input type="hidden" id="form_act" 		name="form_act" value="1" alt="0=redirect al contenido, 1= se hace un load al contenido, 2=Llamada a funcion" />
					<div class="modal-header">
						<h5 class="modal-title">' . $btn . ' Usuario  ' . $rowsysuser["usuario"] . '</h5>
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
													<div class="input-group-text">Nombre *:</div>
												</div>
												<input type="text" class="form-control"  value="' . $rowsysuser["nombre"] . '" maxlength="40" name="nombre" required>
											</div>
										</div>
										<div class="col-sm-12 my-1">
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text">Correo *:</div>
												</div>
												<input type="mail" class="form-control"  value="' . $rowsysuser["email"] . '" maxlength="30" name="email" required>
											</div>
										</div>
										<div class="col-sm-12 my-1">
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text">Teléfono *:</div>
												</div>
												<input type="mail" class="form-control"  value="' . $rowsysuser["telefono"] . '" maxlength="15"  name="telefono" required>
											</div>
										</div>
										<div class="col-sm-12 my-1">
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text">Página *:</div>
												</div>
												<input type="mail" class="form-control"  value="' . $rowsysuser["pagina"] . '" maxlength="60" name="pagina" required>
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

if ($MODPOST == 'sysuser_conf_save' and $_SESSION["_SYS_0011"] >= 1 ) {

	$IDPOST 	= $_POST["IDPOST"];
	$nombre 	= $_POST["nombre"];
	$email 		= $_POST["email"];
	$telefono 	= $_POST["telefono"];
	$pagina 	= $_POST["pagina"];


	$qrysysuser = @mysqli_query($link, "
	SELECT 
		a.*
	FROM  sysuser a
	WHERE a.cve_sysusuario='" . $IDPOST . "'");
	$rowsysuserd = @mysqli_fetch_array($qrysysuser);

	if (@mysqli_num_rows($qrysysuser)  > 0) {
		$qryString = "
		UPDATE sysuser SET
			nombre 			= '" . addslashes($nombre) . "',
			email 			= '" . addslashes($email) . "',
			telefono 		= '" . addslashes($telefono) . "',
			pagina 			= '" . addslashes($pagina) . "'
		where cve_sysusuario	= '" . $IDPOST . "'";
	}

	$script = '	<script>$("header").load("/secciones/navbar.php");</script>';

	echo response_json_html($link, $qryString, $IDPOST, $script);

	exit;
}
#fin del componente

if ($MODPOST == 'sysuser_mod_view' and $_SESSION["_SYS_0011"] >= 1 ) {

	$qrysysuser = @mysqli_query($link, "
	SELECT 
		a.*
	FROM  sysuser a
	WHERE a.cve_sysusuario='" . $IDPOST . "'");
	$rowsysuserd = @mysqli_fetch_array($qrysysuser);

	$menu = '';

	$qryMod = @mysqli_query($link, "
    SELECT * FROM syscrmmoda 
    WHERE a.cve_statuscat='1'
    AND a.sub = '0'
    AND a.cve_syscrmmodIN (" . $rowsysuserd["sysmodulo"] . ")");
	while ($rowMod = @mysqli_fetch_array($qryMod)) {
		$submenus = $submenu = '';

		if ($rowMod["cve_modulosub"]) {
			$MODULO =  "'" . $_SESSION["_SYS_MODULO_"] . "'";
			$modulosub = "'" . str_replace(",", "','", $rowMod["cve_modulosub"]) . "'";
			$MODULO = explode(',', $MODULO);
			$id = str_replace($MODULO, '', $modulosub);
			$id = explode(',', $id);
			$cve_modulosub = trim(str_replace($id, '', $modulosub), ',');
			$rowMod["url"] = '';
			$qryModsub = @mysqli_query($link, "
            SELECT * FROM syscrmmoda 
            WHERE a.cve_statuscat=1  
            AND a.sub =1 
            AND a.cve_syscrmmodIN (" . $cve_modulosub . ")");
			while ($rowModsub = @mysqli_fetch_array($qryModsub)) {

				$submenu .= '<li class="list-group-item"><a href="#' . $rowModsub["descripcion"] . '" id="heading_' . $rowModsub["cve_sysmodulo"] . '"   >' . $rowModsub["descripcion"] . '</a> </li>';
			}

			$submenus .=
				'<div id="collapse' . $rowMod["cve_sysmodulo"] . '" class="collapse " aria-labelledby="heading_' . $rowMod["cve_sysmodulo"] . '" data-parent="#accordionExample">
                        <ul class="list-group sticky-top" style="top:3.5em;">
                        ' . $submenu . '   
                        </ul>
                </div>';
		}

		$menu .= '  <div class="card">
                        <div id="heading_' . $rowMod["cve_sysmodulo"] . '" class="card-header  " data-toggle="collapse" data-target="#collapse' . $rowMod["cve_sysmodulo"] . '"  aria-expanded="true" aria-controls="collapse' . $rowMod["cve_sysmodulo"] . '" >
                            <h5 class="mb-0">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><img src="/home/imagen/' . $rowMod["icono"] . '" class="rounded-circle" height="20" alt=""></div>
                                    </div>
                                    <label class="form-control mt-1"><strong>' . $rowMod["descripcion"] . '</strong></label>
                                </div>
                            </h5>
                        </div>
                        ' . $submenus . '
                    </div>';
	}


	$MDlFORM = '<form class="modal-content" id="form_save" name="form_save" action="#middle"  enctype="multipart/form-data">
					<input type="hidden" id="IDPOST"  		name="IDPOST" value="' . $IDPOST . '" />
					<input type="hidden" id="IDPOST2" 		name="IDPOST2" value="' . $IDPOST2 . '" />
					<input type="hidden" id="MODPOST" 		name="MODPOST" value="" />
					<input type="hidden" id="form_file" 	name="form_file" value="' . $fileaction . '" alt="Nombre de archivo PHP donde se guarda(solo nombre .php)" />
					<input type="hidden" id="form_redirect" name="form_redirect" value="' . $form_redirect . '" alt="Nombre PHP donde estan todos los datos" />
					<input type="hidden" id="form_act" 		name="form_act" value="1" alt="0=redirect al contenido, 1= se hace un load al contenido, 2=Llamada a funcion" />
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle">Módulos activos del usuario : ' . $rowsysuserd["nombre"] . '</h5>
						<button type="button" class="close" data-dismiss="modal" aria-p="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					<div class="accordion" id="accordionExample">
					' . $menu . '
					</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger " data-dismiss="modal">' . ((strlen($_SESSION["LANG"]) > 2) ? 'Cancelar' : 'Cancel') . '</button>
					</div>
				</form>';

	echo json_encode(modalreturn($MDSIZE, $MDlFORM));
	exit;
}
