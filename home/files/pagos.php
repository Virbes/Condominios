<?
include($_SERVER['DOCUMENT_ROOT'] . "/home/include/conn.php");
include($_SERVER['DOCUMENT_ROOT'] . "/api/funciones.php");
?>

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Condominio: <? echo ucwords(mb_strtolower($_SESSION["CONDOMINIO"]["descripcion"])) ?></h1>
    <p class="mb-4">Listado del Pagos. </p>
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
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">First</th>
                                    <th scope="col">Last</th>
                                    <th scope="col">Handle</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Jacob</td>
                                    <td>Thornton</td>
                                    <td>@fat</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Larry</td>
                                    <td>the Bird</td>
                                    <td>@twitter</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?
            break;

        default:
            $idpm = str_replace('.php', '', basename(__FILE__));
            $fileaction = '/' . $idpm . '/';
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
                                        <th>Regla.</th>
                                        <th>Herramientas</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th width="10">Id</th>
                                        <th>Regla.</th>
                                        <th width="10">Herramientas</th>
                                        <th width="10">Estado</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
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
            </script><?
                        break;
                } ?>