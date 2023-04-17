<?
include($_SERVER['DOCUMENT_ROOT'] . "/home/include/funciones.php");
$uid = strip_tags($_GET["id"]);
$idnew = strip_tags($_GET["idnew"]);


$qry = @mysqli_query($link, "   SELECT a.* FROM  mmaenviomail a
                                WHERE a.cve_mmaenviomail='" . ($idnew ?: $uid) . "'");
$row = @mysqli_fetch_array($qry);
$ctenvio = '131312'; #ID del tipo envio HTML
$t = 'mmaenviomailhtml';

?>
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-1 text-gray-800">Configurar Campaña en HTML. <? echo $uid ? 'ID: ' . $uid . ', Campaña:' . $row["asunto"] : '' ?></h1>
    <p class="mb-4">Es muy sencillo, si ya tienes tu HTML solo COPIA Y PEGA en el EDITOR. Fecha: <? echo $fecha_sys ?></p>
    <!-- Content Row -->
    <div class="row">
        <!-- First Column -->
        <div class="col-lg-12">
            <!-- Custom Text Color Utilities -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"> <? echo $uid  ? 'Editar campaña' : ($idnew ? 'Editar y reenviar' : 'Nueva campaña') ?></h6>
                </div>
                <form class="card-body" id="form_save" action="#MIDDLE">
                    <input type="hidden" id="MODPOST" name="MODPOST" value="campania_mail_save" />
                    <input type="hidden" id="IDPOST" name="IDPOST" value="<? echo $uid ?>" />
                    <input type="hidden" id="form_file" name="form_file" value="/nueva-campania/" alt="Nombre de archivo PHP donde se guarda(solo nombre .php)" />
                    <input type="hidden" id="form_redirect" name="form_redirect" value="nueva-campania.php<? echo $uid ? '?id=' . $uid : '' ?>" alt="Nombre PHP donde estan todos los datos" />
                    <input type="hidden" id="form_act" name="form_act" value="1" alt="0=redirect al contenido, 1= se hace un load al contenido, 2=Llamada a funcion" />
                    <input type="hidden" name="cve_mmatipoenvio" value="<? echo $ctenvio ?>" required>
                    <input type="hidden" name="t" value="<? echo $t ?>">
                    <div>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Nombre:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="nombre" value="<? echo  $row["nombre"] ?>" required maxlength="64">
                            </div>
                            <label for="inputPassword" class="col-sm-2 col-form-label">Email de quien envía :</label>
                            <div class="col-sm-4">
                                <input type="email" class="form-control" name="mailenvia" value="<? echo $row["mailenvia"] ?>" required maxlength="64">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Indique el Asunto:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="asunto" value="<? echo $row["asunto"] ?>" required maxlength="128">
                            </div>
                            <label for="inputPassword" class="col-sm-2 col-form-label">Email de respuesta:</label>
                            <div class="col-sm-4">
                                <input type="email" class="form-control" name="mailresponder" value="<? echo $row["mailresponder"] ?>" required maxlength="64">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Selecciones una categorías</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="cve_mmacategoria" required>
                                    <option value="" selected disabled> Seleccione la categoría</option>
                                    <?
                                    $qrycat = @mysqli_query($link, "    SELECT 
                                                                            a.cve_mmacategoria,
                                                                            lower(a.descripcion)descripcion
                                                                        FROM 
                                                                            mmacategoria a
                                                                        WHERE a.cve_statuscat='1'
                                                                        and   a.CVE_SYSUSUARIO='" . $_SESSION["CVE_SYSUSUARIO"] . "'
                                                                        ORDER BY a.cve_mmacategoria desc");
                                    while ($rowcat = @mysqli_fetch_array($qrycat)) {
                                        $selected = $rowcat[0] == $row["cve_mmacategoria"] ? 'selected' : '';
                                    ?>
                                        <option <? echo $selected ?> value="<? echo $rowcat[0] ?>">(ID: <? echo $rowcat[0] ?>) <? echo ucwords($rowcat["descripcion"])  ?></option>
                                    <? } ?>
                                </select>
                            </div>
                            <? if (@mysqli_num_rows($qry) > 0) { ?>
                                <div class="col row">
                                    <div class="col">
                                        <button type="button" class="btn btn-pruebas btn-icon-split mb-1  btn-sm AbreModal" data-target="#staticBackdrop" data-toggle="modal" id="<? echo $uid ?>" rel="0" dir="new_env_mail" title="Enviar Pruebas" media="" name="/nueva-campania/">
                                            <span class="icon text-white-50  text-left">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                            <span class="text text-left" style="width:10em;">Enviar prueba</span>
                                        </button>
                                    </div>
                                    <div class="col">
                                        <? if ($row["cve_statuscat"] != 4) { ?>
                                            <button type="button" class="btn btn-autorizar btn-icon-split mb-1  btn-sm AbreModal" data-target="#staticBackdrop" data-toggle="modal" id="<? echo $uid ?>" rel="0" dir="new_aut_mail" title="Autorizar Campaña" media="" name="/nueva-campania/">
                                                <span class="icon text-white-50  text-left">
                                                    <i class="fas fa-mail-bulk"></i>
                                                </span>
                                                <span class="text text-left" style="width:10em;">Autorizar</span>
                                            </button>
                                        <? } ?>
                                    </div>
                                </div>
                            <?  }  ?>
                        </div>
                    </div>
                    <textarea id="editor" name="contenido">
                    <?
                    $qryHtml = @mysqli_query($link, "   SELECT a.descripcion
                                                        FROM mmaenviomailhtml a
                                                        WHERE a.cve_mmaenviomail='" . ($idnew ?: $uid)  . "'");
                    $rowHtml = @mysqli_fetch_array($qryHtml);
                    $id = $uid;
                    $u = $_SESSION["CVE_SYSUSUARIO"];
                    $htmlModify = $rowHtml["descripcion"];

                    $htmlModify = str_replace('https://www.email.negocio.me/imgHTML/' . $_SESSION["CVE_SYSUSUARIO"] . '/', '/imgHTML/' . $_SESSION["CVE_SYSUSUARIO"] . '/' , $rowHtml["descripcion"]);
                    $htmlModify = str_replace('"https://www.email.negocio.me/Click/?e={$xmail}&service=' . $id . '&us=' . $u . '&url="', '', $htmlModify);
                    $htmlModify = str_replace('https://emailmarketing.podermail.com/Click/?e={$xmail}&amp;service=' . $id . '&amp;us=' . $u . '&amp;url=', '', $htmlModify);

                    echo strip_tags($_GET["plantilla"]) == '7413' ? $plat_7413 : $htmlModify;
                    ?>
                    
                    </textarea>
                    <button class="btn btn-editar btn-icon-split my-4" id="btn_form">
                        <span class="icon text-white-50">
                            <i class="fas fa-arrow-right"></i>
                        </span>
                        <span class="text"><? echo $uid ? 'Actualizar' : 'Guardar' ?> Campaña</span>
                    </button>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    initSample();
</script>