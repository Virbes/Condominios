<?
include($_SERVER['DOCUMENT_ROOT'] . "/home/include/conn.php");
include($_SERVER['DOCUMENT_ROOT'] . "/api/funciones.php");
$idpm = str_replace('.php', '', basename(__FILE__));
$fileaction = '/' . $idpm . '/';
?>

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Condominio: <? echo ucwords(mb_strtolower($_SESSION["CONDOMINIO"]["descripcion"])) ?></h1>
    <p class="mb-4">Listado del Liquidaciones. </p>
    <?
    switch ($_SESSION["_CVE_ROL_"]) {
        case '3':
    ?>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="##dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Mes</th>
                                    <th>Detalles</th>
                                    <th>Pago previsto</th>
                                    <th>Pago Real</th>
                                    <th>&nbsp;</th>
                                    <th width="15%">Estado</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Mes</th>
                                    <th>Detalles</th>
                                    <th>Pagos</th>
                                    <th>&nbsp;</th>
                                    <th width="15%">Estado</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Marzo 2023</td>
                                    <td>* Alquiler <br> * Gas </td>
                                    <td>* Alquiler $0,000.MXN<br>* GAS $0,000.MXN</td>
                                    <td>* Alquiler $0,000.MXN<br>* GAS $0,000.MXN</td>
                                    <td></td>
                                    <td>Pendiente</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Febrero 2023</td>
                                    <td>* Alquiler <br> * Gas </td>
                                    <td>* Alquiler $0,000.MXN<br>* GAS $0,000.MXN</td>
                                    <td>* Alquiler $0,000.MXN<br>* GAS $0,000.MXN</td>
                                    <td>
                                        <button href="#" class="btn btn-info btn-icon-split mb-1  btn-sm" data-target="#staticBackdrop" data-toggle="modal" id="" rel="1" dir="<? echo $idpm ?>_ver_mas" title="Agregar nueva regla" media="" name="<? echo $fileaction ?>">
                                            <span class="icon text-white-50  text-left">
                                                <i class="fas fa-plus"></i>
                                            </span>
                                            <span class="text text-left">Ver mas</span>
                                        </button>
                                    </td>
                                    <td>Pagado</td>

                                </tr>
                                <th scope="row">2</th>
                                <td>Enero 2023</td>
                                <td>* Alquiler <br> * Gas </td>
                                <td>* Alquiler $0,000.MXN<br>* GAS $0,000.MXN</td>
                                <td>* Alquiler $0,000.MXN<br>* GAS $0,000.MXN</td>
                                <td>
                                    <button href="#" class="btn btn-info btn-icon-split mb-1  btn-sm" data-target="#staticBackdrop" data-toggle="modal" id="" rel="3" dir="<? echo $idpm ?>_ver_mas" title="Ver mas detalles" media="" name="<? echo $fileaction ?>">
                                        <span class="icon text-white-50  text-left">
                                            <i class="fas fa-plus"></i>
                                        </span>
                                        <span class="text text-left">Ver mas</span>
                                    </button>
                                </td>
                                <td>Pagado</td>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?
            break;

        default:

        ?>

            <div class="container-fluid">
                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">Condominio: <? echo ucwords(mb_strtolower($_SESSION["CONDOMINIO"]["descripcion"])) ?></h1>
                <p class="mb-4">Listado del Liquidaciones. </p>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <!--<button href="#" class="btn btn-info btn-icon-split mb-1  btn-sm AbreModal" data-target="#staticBackdrop" data-toggle="modal" id="" rel="2" dir="<? echo $idpm ?>_editar" title="Agregar nueva regla" media="" name="<? echo $fileaction ?>">
                        <span class="icon text-white-50  text-left">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text text-left" style="width:10em;">Agregar</span>
                    </button>-->
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Inquilino.</th>
                                        <th>Departamento.</th>
                                        <th>Liquidacion.</th>
                                        <th>Herramientas</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Id</th>
                                        <th>Liquidacion.</th>
                                        <th>Departamento.</th>
                                        <th>Liquidacion.</th>
                                        <th>Herramientas</th>
                                        <th>Estado</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
    <? break;
    } ?>
    <!-- Page level custom scripts -->
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                language: {
                    url: "/vendor/datatables/dataTables.spanish-mx.json",
                },
                order: [
                    [0, "desc"]
                ],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "/api/ajax/repositorio/<? echo str_replace('.php', '', basename(__FILE__)) ?>/",
                    "type": "POST"
                }
            });
        });
    </script>