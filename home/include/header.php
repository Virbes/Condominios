<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <h5 class="h5 mb-2 text-gray-800"> <strong> Condominio: <? echo ucwords(mb_strtolower($_SESSION["CONDOMINIO"]["descripcion"])) ?></strong></h5>

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1" id="cron-alertas">
            <a class="nav-link">
                <div class="spinner-border spinner-border-sm" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </a>
        </li>

        <!-- Nav Item - Messages -->
        <li class="nav-item dropdown no-arrow mx-1" id="cron-mensajes">
            <a class="nav-link">
                <div class="spinner-border spinner-border-sm" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </a>
        </li>
        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><? echo $_SESSION["_USER_"] ?> (<? echo $_SESSION["_ROL_"] ?>)</span>
                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item Menu1" name="perfil.php">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Perfil
                </a>
                <? if ($_SESSION["_CVE_ROL_"] == "1") { ?>
                    <a class="dropdown-item Menu1" name="log.php">
                        <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                        Actividad Log
                    </a>

                    <? if ($_SESSION["CVE_CONDOMINIO"] > 0) { ?>
                        <a class="dropdown-item" href="/home/include/exit_condominio.php">
                            <i class="fas fa-window-close fa-sm fa-fw mr-2 text-gray-400"></i>
                            Salir de condominio
                        </a>
                    <? } ?>
                <? } ?>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Salir
                </a>
            </div>
        </li>

    </ul>

</nav>


<?/*<header class="sticky-top">
    <nav class="navbar  navbar-expand-lg navbar-light bg-crm-dark">
        <div class="col-md-12 row">
            <div class="col-md-4 mr-auto pt-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pt-2" id="pathdir">
                        <li class="breadcrumb-item "><? echo (strlen($_SESSION["LANG"]) > 1) ? 'Inicio' : 'Home' ?></li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-6 ml-auto">
                <ul class="nav justify-content-end">
                    <li class="nav-item pt-1 pr-3"></li>
                    <li class="nav-item">
                        <div class="dropdown" id="msj_group">
                            <? echo  notifications($link) ?>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <a class="btn text-white pt-2" href="<? echo $GLOBALS['conf_urltienda'] ?>" target="_blank">
                                <i class="fas  fa-globe-americas  rounded-circle p-2 bg-white text-dark"></i>
                            </a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle text-white pt-3" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <? echo $_SESSION["_USUARIOVALIDP_"] . ' (' . $_SESSION["ALIAS"] . ') '; ?>
                                <i class="fas fa-cogs"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <?
                                $qryMod = @mysqli_query($link, "  SELECT a.* FROM syscrmmod a 
                                                                    WHERE a.cve_statuscat='1'
                                                                    AND a.order !=0 
                                                                    AND a.cve_syscrmview ='2'
                                                                    ORDER BY a.order ASC");

                                while ($rowMod = @mysqli_fetch_array($qryMod)) {
                                    echo   '<a class="dropdown-item Menu1" href="#' . $rowMod["descripcion"] . '" id="heading_' . $rowMod["cve_syscrmmod"] . '"   dir="' . $rowMod["descripcion" . $_SESSION["LANG"]] . '" name="' . $rowMod["url"] . '"><i class="' . $rowMod["icono"] . '"></i> ' . $rowMod["descripcion" . $_SESSION["LANG"]] . '</a>';
                                }
                                ?>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item mt-1">
                        <a class="btn text-white pt-1" href="/change/<? echo ((strlen($_SESSION["LANG"]) > 1) ? 'en' : 'es') ?>/">
                            <i class="text-white rounded-circle p-2 mt-1 bg-white text-dark"><strong class="text-uppercase"><? echo ((strlen($_SESSION["LANG"]) > 1) ? 'en' : 'es') ?></strong></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href=" /home/include/exit.php"><i class="fas fa-sign-out-alt text-white" style="font-size: 20px !important;"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
*/ ?>