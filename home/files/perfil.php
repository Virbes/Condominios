<? include($_SERVER['DOCUMENT_ROOT'] . "/home/include/funciones.php");

$qry = @mysqli_query($link, "
SELECT * FROM sysusuario a
WHERE a.cve_statuscat=1
and   a.cve_sysusuario='" . $_SESSION["CVE_SYSUSUARIO"] . "'");
$row = @mysqli_fetch_array($qry);



$default_form = '   <input type="hidden" id="IDPOST" name="IDPOST" value="' . $_SESSION["CVE_SYSUSUARIO"] . '" />
                    <input type="hidden" id="form_file" name="form_file" value="/perfil/" alt="Nombre de archivo PHP donde se guarda(solo nombre .php)" />
                    <input type="hidden" id="form_redirect" name="form_redirect" value="perfil.php" alt="Nombre PHP donde estan todos los datos" />
                    <input type="hidden" id="form_act" name="form_act" value="1" alt="0=redirect al contenido, 1= se hace un load al contenido, 2=Llamada a funcion" />';

?>
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-1 text-gray-800">Editar tu perfil.</h1>
    <p class="mb-4">Editar datos de contacto, firmas personalizadas.</p>
    <!-- Content Row -->
    <div class="row">
        <!-- First Column -->
        <div class="col-lg-12">
            <!-- Custom Text Color Utilities -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Editar tus datos de contacto.</h6>
                </div>
                <form class="card-body" id="form_save" action="#MIDDLE">
                    <input type="hidden" id="MODPOST" name="MODPOST" value="conctacto_save" />
                    <? echo $default_form; ?>
                    <div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Nombre</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="<? echo $row["nombre"]  ?>" name="nombre" maxlength="32" required>
                            </div>
                            <label for="inputPassword" class="col-sm-2 col-form-label">Telefono</label>
                            <div class="col-sm-4">
                                <input type="tel" class="form-control" value="<? echo $row["telefono"]  ?>" name="telefono" minlength="10" maxlength="10" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Email:</label>
                            <div class="col-sm-4">
                                <input type="email" class="form-control" value="<? echo $row["email"]  ?>" name="email" maxlength="62" required>
                            </div>
                        </div>
                        <!--<div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Direccion:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="<? echo $row["direccion"]  ?>" name="direccion" maxlength="128" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Ciudad:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="<? echo $row["ciudad"]  ?>" name="ciudad" maxlength="128" required>
                            </div>
                            <label for="inputPassword" class="col-sm-2 col-form-label">Sitio web:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="<? echo $row["website"]  ?>" name="website" maxlength="32" required>
                            </div>
                        </div>-->
                    </div>
                    <button class="btn btn-editar btn-icon-split my-4" id="btn_form">
                        <span class="icon text-white-50">
                            <i class="fas fa-arrow-right"></i>
                        </span>
                        <span class="text">Actualizar tus datos de contacto</span>
                    </button>
                </form>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Editar tus datos de acceso.</h6>
                </div>
                <form class="card-body" id="form_save" action="#MIDDLE">
                    <input type="hidden" id="MODPOST" name="MODPOST" value="accesos_save" />
                    <? echo $default_form; ?>
                    <div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Usuario</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="<? echo $row["usuario"]  ?>" name="usuario" maxlength="32" required>
                            </div>
                            <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-4">
                                <input type="password" class="form-control" value="<? echo $row["passw"]  ?>" name="passw" maxlength="5" maxlength="32" required>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-editar btn-icon-split my-4" id="btn_form">
                        <span class="icon text-white-50">
                            <i class="fas fa-arrow-right"></i>
                        </span>
                        <span class="text">Actualizar datos de acceso</span>
                    </button>
                </form>
            </div>
            <!--<div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Editar tu firma personalizada.</h6>
                </div>
                <form class="card-body" id="form_save" action="#MIDDLE">
                    <input type="hidden" id="MODPOST" name="MODPOST" value="firma_save" />
                    <? echo $default_form; ?>
                    <div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Firma personalizada</label>
                            <div class="col-sm-10">
                                <textarea name="descripcion" required class="form-control" rows="3"><? echo $rowf["descripcion"] ?></textarea>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-editar btn-icon-split my-4" id="btn_form">
                        <span class="icon text-white-50">
                            <i class="fas fa-arrow-right"></i>
                        </span>
                        <span class="text">Actualizar datos de firma</span>
                    </button>
                </form>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Editar tus datos de generales empresa.</h6>
                </div>
                <form class="card-body" id="form_save" action="#MIDDLE">
                    <input type="hidden" id="MODPOST" name="MODPOST" value="empresa_save" />
                    <? echo $default_form; ?>
                    <div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Empresa</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="<? echo $row["empresa"] ?: $row["nombre"]  ?>" name="empresa" maxlength="64" required>
                            </div>
                            <label for="inputPassword" class="col-sm-2 col-form-label">Teléfono</label>
                            <div class="col-sm-4">
                                <input type="tel" class="form-control" value="<? echo $row["telefono"]  ?>" name="telefono" maxlength="10" minlength="10" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-4">
                                <input type="eamil" class="form-control" value="<? echo $row["email"]  ?>" name="email" maxlength="32" required>
                            </div>
                            <label for="inputPassword" class="col-sm-2 col-form-label">Sitio web</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="<? echo $row["website"]  ?>" name="website" maxlength="64" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Descripción corta</label>
                            <div class="col-sm-4">
                                <textarea name="descempresa" required class="form-control" rows="3" maxlength="120"><? echo $row["descempresa"] ?></textarea>
                            </div>
                            <label for="inputPassword" class="col-sm-2 col-form-label">Descripción amplia</label>
                            <div class="col-sm-4">
                                <textarea name="observaciones" required class="form-control" rows="3" maxlength="120"><? echo $row["observaciones"] ?></textarea>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-editar btn-icon-split my-4" id="btn_form">
                        <span class="icon text-white-50">
                            <i class="fas fa-arrow-right"></i>
                        </span>
                        <span class="text">Actualizar datos de generales</span>
                    </button>
                </form>
            </div>-->
        </div>
    </div>
</div>