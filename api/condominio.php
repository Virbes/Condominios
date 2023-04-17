<?
if ($_GET) {
    include($_SERVER['DOCUMENT_ROOT'] . "/home/include/conn.php");
    $_SESSION["_FILTRO_"] = $filtro = strip_tags($_GET["filtro"]);
    switch ($filtro) {
        case 1:
            $_SESSION["_WHERE_"] = ' AND a.fllegada >= NOW()  ';
            break;
        case 2:
            $_SESSION["_WHERE_"] = ' AND a.fllegada >= NOW() AND a.statuspago IN (1,2,4) ';
            break;
        case 3:
            $_SESSION["_WHERE_"] = ' AND a.statuspago ="5" ';
            break;
        case 4:
            $_SESSION["_WHERE_"] = ' AND a.statuspago ="6" ';
            break;
        default:
            $_SESSION["_WHERE_"] = '';
            break;
    }
    ($_SESSION["_FILTRO_"] > -1 ? " AND a.statuspago='" . $_SESSION["_FILTRO_"] . "'" : '');
} else {
    $_SESSION["_WHERE_"] = '';
    $_SESSION["_FILTRO_"] = $filtro = 5;
}

$array_filtro = [
    ["Nuevas Reservaciones", "fas fa-check", 2, "info"],
    ["LLegadas", "fas fa-exchange-alt", 1, "success"],
    ["Realizados", "fas fa-eye-slash", 3, "primary"],
    ["No Show", "fas fa-times-circle", 4, "danger"],
    ["Todo", "fas fa-circle-notch", 5, "secondary"]
];
for ($i = 0; $i < count($array_filtro); $i++) {
    $active = '';
    if ($filtro == $array_filtro[$i][2]) {
        $titulo = '(' . ($array_filtro[$i][0]) . ')';
        $active = 'disabled';
    }

    $btns .= '  <button href="#" class="btn btn-' . $array_filtro[$i][3] . ' btn-icon-split mb-1  btn-sm Menu1 ' . $active . ' " name="reportes.php?filtro=' . $array_filtro[$i][2] . '">
                    <span class="icon text-white-50  text-left">
                        <i class="' . $array_filtro[$i][1] . '"></i>
                    </span>
                    <span class="text text-left" style="width:12em;">' . $array_filtro[$i][0] . '</span>
                </button>';
}


?>

<div class="container-fluid">
    <!-- Page Heading -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Reporte de itinerarios <? echo $titulo ?> &nbsp;
                <? echo $btns ?>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Confirmación</th>
                            <th>Cliente</th>
                            <th>Servicio</th>
                            <th>Origen</th>
                            <th>Costos</th>
                            <th>Herramientas</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Confirmación</th>
                            <th>Cliente</th>
                            <th>Servicio</th>
                            <th>Origen</th>
                            <th>Costos</th>
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