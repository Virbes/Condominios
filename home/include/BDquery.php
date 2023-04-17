<? session_start();
$link = @mysqli_connect("72.55.190.228", "datosnegocio_condominios", "F*rNETb33D2v", "datosnegocio_condominios");

if (mysqli_connect_errno()) {
    printf("Error al conectar con el sistema principal.<br>(<strong>Soporte tecnico:</strong> 01 (55) 3640 4825)" . "<br>Connect failed: %s\n", mysqli_connect_error());
    exit();
}

@mysqli_set_charset($link, "utf8");
@mysqli_query($link, "SET sql_mode = ''");

$fecha_sys = date("Y/m/d H:i:s", mktime(date('h'), date('i'), date('s'), date('m'), date('d'), date('Y')));
$fecha_sys_ = date("Y/m/d", mktime(date('h'), date('i'), date('s'), date('m'), date('d'), date('Y')));
$ipuser = getenv("REMOTE_ADDR");
$_SESSION["_ipuser_"] = $ipuser;
$_SESSION["_nsession_"] = session_id();

$session_id = session_id();
$_SESSION["_session_id_"] = $session_id;
$_SESSION["REFERER"] = $_SERVER['HTTP_REFERER'];
$_SESSION["STRING"] = $_SERVER['QUERY_STRING'];
$_SESSION["URI"] = $_SERVER['REQUEST_URI'];
