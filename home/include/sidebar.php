<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center p-0 bg-white" style="height: auto;" href="/home/">
        <img src="/img/logo-sidebar.png" class="" height="70">
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="/home/">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Inicio</span>
        </a>
    </li>

    <? if ($_SESSION["CVE_CONDOMINIO"] > 0) { ?>
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">Condominio</div>

        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link Menu1" name="liquidaciones.php">
                <i class="fas fa-hand-holding-usd"></i>
                <span>Liquidaciones</span>
            </a>
        </li>


        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link Menu1" name="cobros.php">
                <i class="fas fa-file-contract"></i>
                <span>Aviso de cobro</span>
            </a>
        </li>


        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link Menu1" name="pagos.php">
                <i class="fas fa-file-contract"></i>
                <span>Recibos de pago</span>
            </a>
        </li>


        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link Menu1" name="avisos.php">
                <i class="fas fa-exclamation-triangle"></i>
                <span>Avisos importantes</span>
            </a>
        </li>


        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link Menu1" name="acuerdos.php">
                <i class="fas fa-users"></i>
                <span>Acuerdos asamblea</span>
            </a>
        </li>


        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link Menu1" name="solicitudes.php">
                <i class="fas fa-ticket-alt"></i>
                <span>Solicitud de ticket</span>
            </a>
        </li>

        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link Menu1" name="reglamentos.php">
                <i class="fas fa-list"></i>
                <span>Reglamento</span>
            </a>
        </li>

        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link Menu1" name="areas.php">
                <i class="fas fa-address-book"></i>
                <span>Reserva áreas comunes.</span>
            </a>
        </li>

        <? if ($_SESSION["_CVE_ROL_"] == "") { ?>
            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link Menu1" name="departamentos.php">
                    <i class="fas fa-house-user"></i>
                    <span>Departamentos.</span>
                </a>
            </li>
    <? }
    } ?>

    <? if ($_SESSION["_ROL_"] == "Administrador") { ?>




        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Administración condominios
        </div>

        <!-- Nav Item - Tables -->
        <li class="nav-item">
            <a class="nav-link Menu1" name="condominio.php">
                <i class="fas fa-home"></i>
                <span>Condominios</span></a>
        </li>

        <!-- Nav Item - Tables -->
        <li class="nav-item">
            <a class="nav-link Menu1" name="usuarios.php">
                <i class="fas fa-users"></i>
                <span>Usuarios</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    <? } ?>
</ul>
<!-- End of Sidebar -->



<?/*
    <!--------->
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
            <i class="fas fa-users"></i>
            <span>Comunidad</span>
        </a>
        <div id="collapse1" class="collapse" aria-labelledby="heading1" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Opciones:</h6>
                <a class="collapse-item Menu1" name=".php">Mantenimiento</a>
                <a class="collapse-item Menu1" name=".php">Incidencias</a>
                <a class="collapse-item Menu1" name="alerta.php">Centro de alertas</a>
                <a class="collapse-item Menu1" name="mensaje.php">Centro de mensajes</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse2" aria-expanded="true" aria-controls="collapse2">
            <i class="fas fa-hand-holding-usd"></i>
            <span>Finanzas</span>
        </a>
        <div id="collapse2" class="collapse" aria-labelledby="heading2" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Opciones:</h6>
                <a class="collapse-item Menu1" name=".php">Consilación bancaria</a>
                <a class="collapse-item Menu1" name=".php">Fondos</a>
                <a class="collapse-item Menu1" name=".php">Flujos de caja</a>
                <a class="collapse-item Menu1" name=".php">Balance</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse3" aria-expanded="true" aria-controls="collapse3">
            <i class="fas fa-cog"></i>
            <span>Herramientas</span>
        </a>
        <div id="collapse3" class="collapse" aria-labelledby="heading3" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Opciones:</h6>
                <a class="collapse-item Menu1" name=".php">Registro de correos</a>
                <a class="collapse-item Menu1" name=".php">Configuración</a>
            </div>
        </div>
    </li>


    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link Menu1" name="reportes.php">
            <i class="fas fa-file-contract"></i>
            <span>Reportes</span>
        </a>
    </li>
    */ ?>