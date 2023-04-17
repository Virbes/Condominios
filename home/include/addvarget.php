<?

echo (!$_SESSION["_SYS_ACCESS_"]) ? '<script>window.location.reload();</script>' : '';

$b_idmod =  ($_GET["idmod"]) ? str_replace('heading_', '', strip_tags($_GET["idmod"])) : str_replace('heading_', '', strip_tags($_GET["b_idmod"]));

$arraymod =  explode(',', str_replace("','", ",", $_SESSION["_SYS_MODULO_"]));
array_unshift($arraymod, 0); # se agrega debido a que no encuetra el valor si esta en la posicision sero del arreglo


if (array_search($b_idmod, $arraymod)) {
    $b_url_dest =  strip_tags($_GET["b_url_dest"]);
    $b_mostrar =  (strip_tags($_GET["b_mostrar"])) ? strip_tags($_GET["b_mostrar"]) : '0';
    $limit = (strip_tags($_GET["limit"])) ? strip_tags($_GET["limit"]) : 50;
    $b_mods = (strip_tags($_GET["b_mods"])) ? strip_tags($_GET["b_mods"]) : '';
} else {
    $b_url_dest = $b_mostrar = $limit = '1';
    echo '<script>
                $("#divbody").html("");
                $(".col-xl-2").load("/secciones/nav.php");
                $("header").load("/secciones/navbar.php");
        </script>';
}

$true = false;
$idselected = -1;
for ($i = 0; $i < @count($searchOPtions); $i++) {
    $get = trim(str_replace('_', ' ', $_GET[$searchOPtions[$i][1]]));
    if ($get && !$true) {
        if ($searchOPtions[$i][3] == "0") {
            $swhere .= $swhere . " and UPPER(" . $searchOPtions[$i][2] . ") like UPPER('%" . $get . "%')";
        } elseif ($searchOPtions[$i][3] == "1") {
            $swhere .= $swhere . " and " . $searchOPtions[$i][2] . " ='" . $get . "' ";
        }
        $varsearch = $get;
        $idselected = $i;
        $true = !$true;
        $name = $searchOPtions[$i][1];
    }
}
