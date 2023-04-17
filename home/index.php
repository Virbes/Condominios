<?
include($_SERVER['DOCUMENT_ROOT'] . "/home/include/conn.php");
if (!$_SESSION["CVE_SYSUSUARIO"]) header("location:/");

?>
<!DOCTYPE html>
<html>

<head>
    <? include($_SERVER['DOCUMENT_ROOT'] . "/home/include/head.php"); ?>
    <!--<script src="/home/editor/ckeditor4_v2/ckeditor.js"></script>
    <script src="/home/editor/ckeditor4_v2/samples/js/sample.js"></script>-->
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <? include($_SERVER['DOCUMENT_ROOT'] . "/home/include/sidebar.php"); ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <? include($_SERVER['DOCUMENT_ROOT'] . "/home/include/header.php"); ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div id="divbody">
                    
                    <? include($_SERVER['DOCUMENT_ROOT'] . "/home/files/dashboard.php"); ?>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright © Podermail <? echo date("Y") ?></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <? include($_SERVER['DOCUMENT_ROOT'] . "/home/include/footer.php"); ?>
    <? include($_SERVER['DOCUMENT_ROOT'] . "/home/include/foot.php"); ?>
</body>

</html>