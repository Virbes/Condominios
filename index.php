<?php
include($_SERVER['DOCUMENT_ROOT'] . "/home/include/BDquery.php");

if ($_SESSION["CVE_SYSUSUARIO"]) header("location:/home/");

$idpm = strip_tags($_GET["idpm"]);
?>

<!DOCTYPE html>
<html style="height: 100%;">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/home/include/head.php"); ?>
</head>

<body class="login d-flex">
    <div class="container-fluid my-auto">
        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-lg-6 d-flex order-2 order-md-1" style="height: 100vh;">
                <div class="col-8 m-auto">
                    <img src="/img/undraw_smart_home_re_orvn.svg" class="img-fluid" width="100%" alt="">
                </div>
            </div>
            <div class="col-xl-6 mx-auto my-auto order-1 order-md-2">
                <div class="col-12 col-md-8 pt-5 pt-md-0">

                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">

                            <div class="col-4 mx-auto py-3">
                                <img src="/img/logo.png" width="100%" alt="">
                            </div>

                            <!-- Nested Row within Card Body -->

                            <div class="pb-5  px-5 pt-0">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Bienvenido <?php echo $idpm == "admin" ? 'Administrador' : '' ?></h1>
                                </div>
                                <form class="user" method="POST" action="/home/include/login.php">
                                    <input type="hidden" name="tipo" value="<? echo $idpm ?>">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" placeholder="Ingrese usuario" name="usuario" minlength="2" maxlength="32" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" placeholder="Ingrese contraseña" name="pdw" minlength="2" maxlength="32" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">Ingresar</button>
                                </form>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/home/include/footer.php");  ?>

    <!-- ERROR Modal-->
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ocurrio un error al iniciar la sessión</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Por favor, Verifique que los accesos seán los correctos</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <?php if (strlen($_SESSION["error"]) > 2 && strlen($_GET["error"]) > 2) { ?>
        <script>
            $(document).ready(function() {
                $('#errorModal').modal('show')
            });
        </script>
    <?php } ?>

    <?php  ?>

</body>

</html>