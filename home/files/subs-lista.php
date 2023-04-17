<? include($_SERVER['DOCUMENT_ROOT'] . "/home/include/funciones.php"); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Categorías o listas de correos o suscriptores.</h1>
    <p class="mb-4">Puede crear listas, agregar correos, cambiar nombre o eliminar una lista de suscriptores. </p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Suscriptores
                <button href="#" class="btn btn-editar btn-icon-split mb-1  btn-sm AbreModal " data-target="#staticBackdrop" data-toggle="modal" id="" rel="0" dir="categoria_add" title="Agregar categoría" media="" name="/subs-lista/">
                <span class="icon text-white-50  text-left">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text text-left" style="width:10em;">Agregar categoria</span>
                </button>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Categoría.</th>
                            <th>Registros.</th>
                            <th>Herramientas</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Categoría.</th>
                            <th>Registros.</th>
                            <th>Herramientas</th>
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
                "url": "/api/ajax/repositorio/subs-lista/",
                "type": "POST"
            }
        });
    });
</script>