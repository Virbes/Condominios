<? include($_SERVER['DOCUMENT_ROOT'] . "/home/include/BDquery.php");

if ($_SESSION["CONDOMINIO"]) {
  $WHERE_CONDO = " AND cve_condominio='" . $_SESSION["CONDOMINIO"]["cve_condominio"] . "'";
}


$qry_condominios = @mysqli_query($link, "SELECT * FROM condominio WHERE cve_statuscat='1' " . $WHERE_CONDO);
$qry_usuario = @mysqli_query($link, "SELECT * FROM usuario WHERE cve_statuscat='1' " . $WHERE_CONDO);
$qry_inquilino = @mysqli_query($link, "SELECT * FROM inquilino WHERE cve_statuscat='1' " . $WHERE_CONDO);
$qry_departamento = @mysqli_query($link, "SELECT * FROM departamento WHERE cve_statuscat='1' " . $WHERE_CONDO);
$qry_ticket = @mysqli_query($link, "SELECT * FROM ticket WHERE cve_statuscat='1' AND MONTH(NOW())=MONTH(fecha_sys) " . $WHERE_CONDO);
$dashboard = true;

switch ($_SESSION["_CVE_ROL_"]) {
  case '1':
?>
    <div class="container-fluid">
      <!-- Content Row -->
      <div class="row py-4">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                    Departamentos</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><? echo @mysqli_num_rows($qry_condominios) ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-check fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                    Administradores</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><? echo @mysqli_num_rows($qry_usuario) ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-info fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>


        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                    Inquilino activos</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><? echo @mysqli_num_rows($qry_inquilino) ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-mouse fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Incidencias del mes
                  </div>
                  <div class="row no-gutters align-items-center">
                    <div class="col-auto">
                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><? echo @mysqli_num_rows($qry_ticket) ?></div>
                    </div>
                    <div class="col">
                      <div class="progress progress-sm mr-2">
                        <div class="progress-bar bg-info" role="progressbar" style="width: <? echo @mysqli_num_rows($qry_ticket) ?>" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Content Row -->

      <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
          <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">Ingresos del último mes</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
              <div class="chart-area">
                <div class="chartjs-size-monitor">
                  <div class="chartjs-size-monitor-expand">
                    <div class=""></div>
                  </div>
                  <div class="chartjs-size-monitor-shrink">
                    <div class=""></div>
                  </div>
                </div>
                <canvas id="myAreaChart" style="display: block; width: 1041px; height: 320px;" class="chartjs-render-monitor" width="1041" height="320"></canvas>
              </div>
            </div>
          </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
          <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">Capacidad de los Condominios</h6>
              <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
              </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
              <div class="chart-pie pt-4 pb-2">
                <div class="chartjs-size-monitor">
                  <div class="chartjs-size-monitor-expand">
                    <div class=""></div>
                  </div>
                  <div class="chartjs-size-monitor-shrink">
                    <div class=""></div>
                  </div>
                </div>
                <canvas id="myPieChart" style="display: block; width: 487px; height: 245px;" class="chartjs-render-monitor" width="487" height="245"></canvas>
              </div>
              <div class="mt-4 text-center small">
                <span class="mr-2">
                  <i class="fas fa-circle text-success"></i> Todos
                </span>
                <span class="mr-2">
                  <i class="fas fa-circle text-info"></i> Partes
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  <?
    break;
  case '2':
  ?>
    <div class="container-fluid">
      <!-- Content Row -->
      <div class="row py-4">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                    Departamentos</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><? echo @mysqli_num_rows($qry_condominios) ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-check fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                    Administradores</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><? echo @mysqli_num_rows($qry_usuario) ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-info fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>


        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                    Inquilino activos</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><? echo @mysqli_num_rows($qry_inquilino) ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-mouse fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Incidencias del mes
                  </div>
                  <div class="row no-gutters align-items-center">
                    <div class="col-auto">
                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><? echo @mysqli_num_rows($qry_ticket) ?></div>
                    </div>
                    <div class="col">
                      <div class="progress progress-sm mr-2">
                        <div class="progress-bar bg-info" role="progressbar" style="width: <? echo @mysqli_num_rows($qry_ticket) ?>" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Content Row -->

      <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
          <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">Ingresos del último mes</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
              <div class="chart-area">
                <div class="chartjs-size-monitor">
                  <div class="chartjs-size-monitor-expand">
                    <div class=""></div>
                  </div>
                  <div class="chartjs-size-monitor-shrink">
                    <div class=""></div>
                  </div>
                </div>
                <canvas id="myAreaChart" style="display: block; width: 1041px; height: 320px;" class="chartjs-render-monitor" width="1041" height="320"></canvas>
              </div>
            </div>
          </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
          <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">Capacidad de los Condominios</h6>
              <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
              </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
              <div class="chart-pie pt-4 pb-2">
                <div class="chartjs-size-monitor">
                  <div class="chartjs-size-monitor-expand">
                    <div class=""></div>
                  </div>
                  <div class="chartjs-size-monitor-shrink">
                    <div class=""></div>
                  </div>
                </div>
                <canvas id="myPieChart" style="display: block; width: 487px; height: 245px;" class="chartjs-render-monitor" width="487" height="245"></canvas>
              </div>
              <div class="mt-4 text-center small">
                <span class="mr-2">
                  <i class="fas fa-circle text-success"></i> Todos
                </span>
                <span class="mr-2">
                  <i class="fas fa-circle text-info"></i> Partes
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  <?
    break;
  case '3':

    $qry_inquilino = @mysqli_query($link, "	SELECT a.*
                                            FROM inquilino a
                                            WHERE a.cve_departamento	=	'" . $_SESSION["CVE_DEPARTAMENTO"] . "'
                                            AND   a.cve_statuscat=1");
    $row_inquilino = @mysqli_fetch_array($qry_inquilino);

    $qry_departamento = @mysqli_query($link, "	SELECT a.*
                                                FROM departamento a
                                                WHERE a.cve_departamento	=	'" . $_SESSION["CVE_DEPARTAMENTO"] . "'
                                                AND   a.cve_statuscat=1");
    $row_departamento = @mysqli_fetch_array($qry_departamento);


  ?>
    <div class="container-fluid">
      <!-- Content Row -->
      <div class="row py-4">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-md-6 mb-4">
          <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                    Departamento</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><? echo 'Piso: ' . $row_departamento["num_piso"] . ' - Núm:' . $row_departamento["num"] ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-check fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-md-6 mb-4">
          <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                    Administrador</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-info fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>


        <!-- Earnings (Monthly) Card Example -->
        <div class="col-md-6 mb-4">
          <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                    Inquilino</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><? echo ucwords(mb_strtolower($row_inquilino["nombre"] . ' ' . $row_inquilino["apellidopat"] . ' ' . $row_inquilino["apellidomat"])) ?></div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-mouse fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-md-6 mb-4">
          <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Incidencias del mes
                  </div>
                  <div class="row no-gutters align-items-center">
                    <div class="col-auto">
                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><? echo @mysqli_num_rows($qry_ticket) ?></div>
                    </div>
                    <div class="col">
                      <div class="progress progress-sm mr-2">
                        <div class="progress-bar bg-info" role="progressbar" style="width: <? echo @mysqli_num_rows($qry_ticket) ?>" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
<?
    break;
  default:
    break;
}
?>