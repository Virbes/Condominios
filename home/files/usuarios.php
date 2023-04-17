<?
include($_SERVER['DOCUMENT_ROOT'] . "/home/include/conn.php");
include($_SERVER['DOCUMENT_ROOT'] . "/api/funciones.php");
$idpm = str_replace('.php', '', basename(__FILE__));
$fileaction = '/' . $idpm . '/';
?>
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-1 text-gray-800">Usuarios</h1>
    <p class="mb-4">Administración de usuarios.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <?
                $array_buttons = [];
                array_push($array_buttons, ["info", "Agregar usuario", "fas fa-plus", "", "Agregar Usuario", "0", $idpm . "_agregar", $fileaction]);
                echo Btns($array_buttons);
                ?>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id.</th>
                            <th>Información.</th>
                            <th>Accesos.</th>
                            <th>Herramientas.</th>
                            <th>Estado.</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Id.</th>
                            <th>Información.</th>
                            <th>Accesos.</th>
                            <th>Herramientas.</th>
                            <th>Estado.</th>
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
                "url": "/api/ajax/repositorio<? echo $fileaction ?>",
                "type": "POST"
            }
        });
    });
</script>