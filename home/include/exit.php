<?
session_start();
session_destroy();
header("Location:/" . ($_SESSION["_ROL_"] == "Administrador" ? "admin" : ''));
