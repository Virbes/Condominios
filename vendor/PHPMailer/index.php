<?



#SendPropuesta($link, 'e.morales@podermail.com', 'mail.podermail.com', 'e.morales@podermail.com', 'e.morales@podermail.com', 'Prueba', 'Prueba', $idenviomail, 8851);
function SendPropuesta($link, $send, $sendName, $responder, $destinatario, $subjet, $contenido, $idenviomail, $idusuario)
{

	$txt = $contenido;


	error_reporting(E_STRICT);
	date_default_timezone_set('America/Toronto');
	require_once('class.phpmailer.php');
	include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

	$mail             = new PHPMailer();
	$body             = $txt;

	$mail->IsSMTP();
	$mail->Host       = "mail.podermail.com";
	$mail->SMTPDebug  = 2;

	$mail->SMTPAuth   = true;
	$mail->Port       = 26;
	$mail->Username   = "contacto@podermail.com";
	$mail->Password   = "@KAROL132006";

	$mail->SetFrom($send, $sendName);
	$mail->AddReplyTo($responder, '');

	$mail->Subject = $subjet;
	$mail->MsgHTML($txt);

	$mail->AddAddress($destinatario, $sendName);

	/*$qryadj = @mysqli_query($link, "
	SELECT * FROM 
		mmaenviomailadj a
	WHERE a.cve_statuscat='1'
	and   a.CVE_SYSUSUARIO='" . $idusuario . "'
	and   a.cve_mmaenviomail = '" . $idenviomail . "'");
	//echo @mysql_num_rows($qryadj).'<<<';
	while ($rowadj = @mysqli_fetch_array($qryadj)) {
		$mail->AddAttachment('../adjuntos/' . $rowadj["nombre"] . '');
	}*/

	if (!$mail->Send()) {
		echo "<span style='font-family:arial; font-size:14px;'>**<strong>Error al enviar prueba:</strong>" . $mail->ErrorInfo . '</span>';
	} else {
		echo "<span style='font-family:arial; font-size:14px;'><strong>Mensaje Enviado!!</strong></span>";
	}
}
