<?
include("SimpleImage.class.php");
include("funciones_url.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// require './../vendor/vendor/autoload.php';

$ruta                 = './../../img-marketplace/';
$rutaimg_local         = '/img-marketplace/';

$Img     = 900;
$Imgth    = 900;

function response_json($link, $qryString, $IDPOST)
{
    $val = @mysqli_query($link, $qryString);
    $id =  @mysqli_insert_id($link) ?: $IDPOST;
    $json["r_"] = $val ? array(
        'OutVal' => 'Listo',
        'Icon' => 'fas fa-check',
        'Val' => $val,
        'Id' => $id
    ) : array(
        'OutVal' => 'Error',
        'Icon' => 'fas fa-exclamation-triangle',
        'Val' => $val,
        'Id' => $id
    );

    return json_encode($json);
}

function response_json_html($link, $qryString, $IDPOST, $html)
{
    $val = @mysqli_query($link, $qryString);
    $id =  @mysqli_insert_id($link) ?: $IDPOST;
    $json["r_"] = $val ? array(
        'OutVal' => 'Listo',
        'Icon' => 'fas fa-check',
        'Val' => $val,
        'Id' => $id,
        "html" => $html
    ) : array(
        'OutVal' => 'Error',
        'Icon' => 'fas fa-exclamation-triangle',
        'Val' => $val,
        'Id' => $id,
        "html" => $html
    );
    return json_encode($json);
}



function response_json_imagen($link, $qryString, $IDPOST, $Img, $Imgth, $ruta, $rutaimg_local, $table)
{
    $val = @mysqli_query($link, $qryString);
    $id = @mysqli_insert_id($link);
    $id = ($id) ? $id : $IDPOST;
    $nfiledImagen = 'imagenfile';
    #cargar imagen principal
    if ($_FILES['' . $nfiledImagen . '']['name'] == TRUE) {
        $archivoEnc = $_FILES['' . $nfiledImagen . '']['name'];
        #$archivo_sizeEn = $_FILES['' . $nfiledImagen . '']['size'];
        #$archivo_extencionEn = $_FILES['' . $nfiledImagen . '']['type'];
        $idmove = move_uploaded_file($_FILES['' . $nfiledImagen . '']['tmp_name'], "" . $ruta . "" . $archivoEnc);
        if ($idmove == true) { #if move

            #modifo el nombre de la imagen
            $imgold  = $archivoEnc;

            #buscamos extenciones
            if ($_FILES[$nfiledImagen]['type'] == 'image/jpeg') {
                $OUT_EX = '.jpg';
            }
            if ($_FILES[$nfiledImagen]['type'] == 'image/webp') {
                $OUT_EX = '.webp';
            } elseif ($_FILES[$nfiledImagen]['type'] == 'image/png') {
                $OUT_EX = '.png';
            } elseif ($_FILES[$nfiledImagen]['type'] == 'image/gif') {
                $OUT_EX = '.gif';
            } else {
                $OUT_EX = '.jpg';
            }
            $fech = date("hism");
            #reneme imgane ---
            $nameFile = 'MN_' . ucfirst($table) . '_2022_' . $_SESSION["_SYS_0011"] . '_' . $id . '_' . $fech . $OUT_EX;
            rename($ruta . $imgold, $ruta . $nameFile);
            $nameFile = RedFile_trv($Img, $Imgth, $ruta, $nameFile);

            $qryString1 = "     UPDATE " . $table . " SET
                                        imagen 		= '" . $nameFile . "',
                                        imagenruta	='" . $rutaimg_local . "'
                                WHERE  cve_" . $table . "='" . $id . "'";

            $val = @mysqli_query($link, $qryString1);
            #actualizao BD

        } #	#if move
    }

    $json["r_"] = $val ? array(
        'OutVal' => 'Listo',
        'Icon' => 'fas fa-check',
        'Val' => $val,
        'Id' => $id
    ) : array(
        'OutVal' => 'Error',
        'Icon' => 'fas fa-exclamation-triangle',
        'Val' => $val,
        'Id' => $id
    );

    return json_encode($json);
}




function RedFile_trv($Img, $Imgth, $ruta, $nameFile)
{
    $obj_simpleimage = new SimpleImage(); //creamos un objeto de la clase SimpleImage
    $obj_simpleimage->load($ruta . $nameFile); //leemos la imagen 
    $datos = getimagesize($ruta . $nameFile);
    $anchura = $Imgth;
    $ratio = ($datos[0] / $anchura);
    $altura = round($datos[1] / $ratio);
    $var_thumb_ancho = $anchura;
    $var_thumb_alto = $altura;
    $obj_simpleimage->resize($var_thumb_ancho, $var_thumb_alto);
    $obj_simpleimage->save($ruta  . $nameFile);


    if ($datos[0] >= $Img) {
        #  $obj_simpleimage->load($ruta . $nameFile); //leemos la imagen 
        #  $datos = getimagesize($ruta . $nameFile);
        #$anchura = $Img;
        #$ratio = ($datos[0] / $anchura);
        # $altura = round($datos[1] / $ratio);
        $var_thumb_ancho = $anchura;
        $var_thumb_alto = $altura;
        #$obj_simpleimage->resize($var_thumb_ancho, $var_thumb_alto);
        $obj_simpleimage->save($ruta . $nameFile);
    }

    #reducimos el archivo original
    return $nameFile;
}


/*function response_json($link, $qryString, $IDPOST)
{
    $val = @mysqli_query($link, $qryString);
    $id =  @mysqli_insert_id($link) ?: $IDPOST;
    $json["r_"] = $val ? array('OutVal' => 'Listo', 'Icon' => 'fas fa-check', 'Val' => $val, 'Id' => $id) : array('OutVal' => 'Error', 'Icon' => 'fas fa-exclamation-triangle', 'Val' => $val, 'Id' => $id);

    return json_encode($json);
}*/


function response_json_redirect($link, $qryString, $IDPOST, $form_redirect)
{
    $val = @mysqli_query($link, $qryString);
    $id =  @mysqli_insert_id($link) ?: $IDPOST;
    $json["r_"] = $val ? array('OutVal' => 'Listo', 'Icon' => 'fas fa-check', 'Val' => $qryString, 'Id' => $id, "redirect" => $form_redirect) : array('OutVal' => 'Error', 'Icon' => 'fas fa-exclamation-triangle', 'Val' => $qryString, 'Id' => $id, "redirect" => $form_redirect);
    return json_encode($json);
}

function response_json_error($message, $IDPOST)
{
    $json["r_"] = array('OutVal' => $message, 'Color' => 'text-danger', 'Val' => false, 'ID' => $IDPOST);

    return json_encode($json);
}





function response_json_imagen_html($link, $qryString, $IDPOST, $Img, $Imgth, $ruta, $rutaimg_local, $table, $imgname, $html)
{
    $qryUpdate = @mysqli_query($link, $qryString);
    $id = @mysqli_insert_id($link);
    $id = ($id) ? $id : $IDPOST;

    $nfiledImagen = 'imagenfile';
    #cargar imagen principal
    if ($_FILES['' . $nfiledImagen . '']['name'] == TRUE) {
        $archivoEnc = $_FILES['' . $nfiledImagen . '']['name'];
        #$archivo_sizeEn = $_FILES['' . $nfiledImagen . '']['size'];
        #$archivo_extencionEn = $_FILES['' . $nfiledImagen . '']['type'];
        $idmove = move_uploaded_file($_FILES['' . $nfiledImagen . '']['tmp_name'], "" . $ruta . "" . $archivoEnc);
        if ($idmove == true) { #if move

            #modifo el nombre de la imagen
            $imgold  = $archivoEnc;
            $imgname = str_replace("_", ".", $archivoEnc);

            #buscamos extenciones
            if ($_FILES[$nfiledImagen]['type'] == 'image/jpeg') {
                $OUT_EX = '.jpg';
            } elseif ($_FILES[$nfiledImagen]['type'] == 'image/png') {
                $OUT_EX = '.png';
            } elseif ($_FILES[$nfiledImagen]['type'] == 'image/gif') {
                $OUT_EX = '.gif';
            } else {
                $OUT_EX = '.jpg';
            }
            $fech = date("Ymdhism");
            #reneme imgane ---
            $nameFile = 'marketplace-' . $imgname . '-' . $_SESSION["_SYS_0011"] . '-' . $id . $fech . $OUT_EX;
            rename($ruta . $imgold, $ruta . $nameFile);
            $nameFile = RedFile_trv($Img, $Imgth, $ruta, $nameFile);

            $qryString = "
            UPDATE " . $table . " SET
                  imagen 		= '" . $nameFile . "',
                  imagenruta	='" . $rutaimg_local . "'
            WHERE  cve_" . $table . "='" . $id . "'";

            $qryUpdate = @mysqli_query($link, $qryString);
            #actualizao BD

        } #	#if move
    }

    if ($qryUpdate) {
        $json["r_"] = array('OutVal' => 'Ok', 'Color' => 'text-success', 'Val' => $qryUpdate, 'ID' => $id, "html" => $html);
    } else {
        $json["r_"] = array('OutVal' => 'Error', 'Color' => 'text-danger', 'Val' => $qryUpdate, 'ID' => $id, "html" => $html);
    }
    return json_encode($json);
}

function response_json_doc($link, $qryString, $IDPOST, $ruta, $rutadoc_local, $table)
{
    $qryUpdate = @mysqli_query($link, $qryString);
    $id = @mysqli_insert_id($link);
    $id = ($id) ? $id : $IDPOST;
    $nfiledoc = 'docfile';
    #cargar imagen principal
    if ($_FILES['' . $nfiledoc . '']['name'] == TRUE) {
        $archivoEnc = $_FILES['' . $nfiledoc . '']['name'];
        $idmove = move_uploaded_file($_FILES['' . $nfiledoc . '']['tmp_name'], "" . $ruta . "" . $archivoEnc);
        if ($idmove == true) { #if move

            #modifo el nombre de la imagen
            $docold  = $archivoEnc;
            //            $imgname = str_replace("_", ".", $archivoEnc);

            #buscamos extenciones
            if ($_FILES[$nfiledoc]['type'] == 'application/pdf') {
                $OUT_EX = '.pdf';
            } elseif ($_FILES[$nfiledoc]['type'] == 'application/msword') {
                $OUT_EX = '.doc';
            } elseif ($_FILES[$nfiledoc]['type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                $OUT_EX = '.docx';
            } else {
                $OUT_EX = '.pdf';
            }
            $fech = date("Ymdhism");

            $nameFile = 'church-' . $_SESSION["_SYS_0011"] . '-' . $id . $fech . $OUT_EX;
            rename($ruta . $docold, $ruta . $nameFile);

            $qryString = "
            UPDATE " . $table . " SET
                 archivo 		= '" . $nameFile . "',
                 archivoruta	='" . $rutadoc_local . "'
            WHERE  cve_" . $table . "='" . $id . "'";

            $qryUpdate = @mysqli_query($link, $qryString);
            #actualizao BD

        } #	#if move
    }

    if ($qryUpdate) {
        $json["r_"] = array('OutVal' => 'Ok', 'Color' => 'text-success', 'Val' => $qryUpdate, 'ID' => $id);
    } else {
        $json["r_"] = array('OutVal' => 'Error', 'Color' => 'text-danger', 'Val' => $qryUpdate, 'ID' => $id);
    }
    return json_encode($json);
    exit;
}


function response_json_doc_imagen($link, $qryString, $IDPOST, $Img, $Imgth, $ruta, $rutaimg_local, $table, $path, $rutadoc, $rutadoc_local)
{
    $qryUpdate = @mysqli_query($link, $qryString);
    $id = @mysqli_insert_id($link);
    $id = ($id) ? $id : $IDPOST;
    $nfiledImagen = 'imagenfile';
    #cargar imagen principal
    if ($_FILES['' . $nfiledImagen . '']['name'] == TRUE) {
        $archivoEnc = $_FILES['' . $nfiledImagen . '']['name'];
        #$archivo_sizeEn = $_FILES['' . $nfiledImagen . '']['size'];
        #$archivo_extencionEn = $_FILES['' . $nfiledImagen . '']['type'];
        $idmove = move_uploaded_file($_FILES['' . $nfiledImagen . '']['tmp_name'], "" . $ruta . "" . $archivoEnc);
        if ($idmove == true) { #if move

            #modifo el nombre de la imagen
            $imgold  = $archivoEnc;

            #buscamos extenciones
            if ($_FILES[$nfiledImagen]['type'] == 'image/jpeg') {
                $OUT_EX = '.jpg';
            }
            if ($_FILES[$nfiledImagen]['type'] == 'image/webp') {
                $OUT_EX = '.webp';
            } elseif ($_FILES[$nfiledImagen]['type'] == 'image/png') {
                $OUT_EX = '.png';
            } elseif ($_FILES[$nfiledImagen]['type'] == 'image/gif') {
                $OUT_EX = '.gif';
            } else {
                $OUT_EX = '.jpg';
            }
            $fech = date("Ymdhism");
            #reneme imgane ---
            $nameFile = 'MN_' . ucfirst($table) . '_2021_' . $_SESSION["_SYS_0011"] . '_' . $id . '_' . $fech . $OUT_EX;
            rename($ruta . $imgold, $ruta . $nameFile);
            $nameFile = RedFile_trv($Img, $Imgth, $ruta, $nameFile);

            $qryString1 = "
            UPDATE " . $table . " SET
                    imagen 		= '" . $nameFile . "',
                  " . $path . "	='" . $rutaimg_local . "'
            WHERE  cve_" . $table . "='" . $id . "'";

            $qryUpdate = @mysqli_query($link, $qryString1);
            #actualizao BD

        } #	#if move
    }
    $nfiledoc = 'docfile';
    if ($_FILES['' . $nfiledoc . '']['name'] == TRUE) {
        $archivoEnc = $_FILES['' . $nfiledoc . '']['name'];
        $idmove = move_uploaded_file($_FILES['' . $nfiledoc . '']['tmp_name'], "" . $rutadoc . "" . $archivoEnc);
        if ($idmove == true) { #if move

            #modifo el nombre de la imagen
            $docold  = $archivoEnc;
            //            $imgname = str_replace("_", ".", $archivoEnc);

            #buscamos extenciones
            if ($_FILES[$nfiledoc]['type'] == 'application/pdf') {
                $OUT_EX = '.pdf';
            } elseif ($_FILES[$nfiledoc]['type'] == 'application/msword') {
                $OUT_EX = '.doc';
            } elseif ($_FILES[$nfiledoc]['type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                $OUT_EX = '.docx';
            } else {
                $OUT_EX = '.pdf';
            }
            $fech = date("Ymdhism");

            $nameFile = 'MN_' . ucfirst($table) . '_2021_' . $_SESSION["_SYS_0011"] . '_' . $id . '_' . $fech . $OUT_EX;
            rename($rutadoc . $docold, $rutadoc . $nameFile);

            $qryString = "
            UPDATE " . $table . " SET
                 archivo 		= '" . $nameFile . "',
                 archivoruta	='" . $rutadoc_local . "'
            WHERE  cve_" . $table . "='" . $id . "'";

            $qryUpdate = @mysqli_query($link, $qryString);
            #actualizao BD

        } #	#if move
    }

    if ($qryUpdate) {
        $json["r_"] = array('OutVal' => 'Ok', 'Color' => 'text-success', 'Val' => $qryUpdate, 'ID' => $id);
    } else {
        $json["r_"] = array('OutVal' => 'Error', 'Color' => 'text-danger', 'Val' => $qryUpdate, 'ID' => $id);
    }
    return json_encode($json);
}



function response_json_correo($link, $qryString, $IDPOST, $EmailSend, $post, $titulo)
{
    $qryUpdate = @mysqli_query($link, $qryString);
    $id = @mysqli_insert_id($link);
    if ($qryUpdate) {
        $_POST["ID"] = $IDPOST;
        $mensaje = '          <br><br>
        Hola ' . $post["nombre"] . ' ,
        <br> En breve nos pondremos en contacto con usted. Gracias por escribirnos.
        Nombre: ' . $post["nombre"] . '<br>
        <hr>
        <strong>En respueta a sus dudas sobre:</strong> ' . $post["comentarios"] . ' <br>
        <hr>
        <strong>Le comentamos:</strong> ' . $post["contenido"] . ' <br>
        Esperamos le sirva la informacion.
        <hr>
        <br><br><br>';


        if (send_mail('', $EmailSend, $titulo, $mensaje, "c.felipe@podermail.com")) {
            @mysqli_query($link, "UPDATE mdmsj SET
                                    leido = '1',
                                    reply='1',
                                    cve_statuscat='2'
                                where cve_mdmsj		= '" . $IDPOST . "'
                                AND cve_sysusuario='" . $_SESSION["_SYS_0011"] . "'");

            $json["r_"] = array('OutVal' => 'Ok', 'Color' => 'text-success', 'Val' => $qryUpdate, 'ID' => $id);
        } else {
            $json["r_"] = array('OutVal' => 'Error,correo no enviado', 'Color' => 'text-danger', 'Val' => false, 'ID' => $id);
            @mysqli_query($link, "UPDATE mdmsjr SET
                                    cve_statuscat='1'
                                where cve_mdmsj		= '" . $id . "'
                                AND cve_sysusuario='" . $_SESSION["_SYS_0011"] . "'");
        }
    } else {
        $json["r_"] = array('OutVal' => 'Error', 'Color' => 'text-danger', 'Val' => $qryUpdate, 'ID' => $id);
    }
    return json_encode($json);
}

function Format_current($string, $moneda)
{
    return ' $ ' . number_format($string, 2) . ' ' . $moneda;
}

function send_mail($id, $para, $asunto, $mensaje, $copia)
{
    $cabeceras  = '';
    if (strlen($copia) > 0) {
        $para = $para . ', ' . $copia;
    }

    $remplazar["ID"] = $id;
    $remplazar["contenido"] = $mensaje;

    $mensaje = load_page('./../../_integra/mail/mail-all.php');
    $mensaje = replace($mensaje, $remplazar);

    $cabeceras     .= "From: Market <no-reply@market.com> \r\n";
    //$cabeceras	.= "Reply-To: \n";
    $cabeceras  .= "X-Mailer:PHP/" . phpversion() . "\n";
    $cabeceras  .= "MIME-Version: 1.0 \r\n";
    $cabeceras    .= "Content-type: text/html; charset=UTF-8 \r\n";


    if (mail($para, $asunto, $mensaje, $cabeceras)) {
        return ('ok');
    } else {
        return ('error');
    }
}

function replace($template, $_DICTIONARY)
{
    foreach ($_DICTIONARY as $clave => $valor) {
        $template = str_replace(':' . $clave . ':', $valor, $template);
    }
    return $template;
}
function load_page($page)
{
    return file_get_contents($page);
}
function camptxt($txt)
{
    $out = str_replace("'", "", str_replace(',', '', strip_tags($txt)));
    $out = str_replace('.', '', $out);
    return $out;
}


function EnviaEmail($contenido, $Subjet, $EmailSend, $ResponderA)
{

    if (strlen($EmailSend) >= 5) {
        $EmailSend = $EmailSend;
    } else {
        $EmailSend = 'contacto@podermail.com';
    }
    if (strlen($ResponderA) >= 5) {
        $ResponderA = $ResponderA;
    } else {
        $ResponderA = 'contacto@podermail.com';
    }


    $txt = '
<table width="662" align="center" border="0" cellspacing="10" cellpadding="10">
  <tr>
    <td width="270" valign="top" align="left"><img src="http://emailmarketing.podermail.com/mailsmasivos/2015/imagen/logo-podermail-azul.png" width="250" height="70"></td>
    <td width="310" valign="middle" style="font-size:20px;"><strong>Hola ' . $_SESSION["_USER_"] . ',<br>generamos un eMail para ti.</strong></td>
  </tr>
  <tr>
    <td colspan="2" valign="top" bgcolor="#E8E8E8">
	<img src="http://emailmarketing.podermail.com/mailsmasivos/2015/imagen/publicidad_alerta_mail.jpg" width="650" height="200"><br><br>
	' . $contenido . '
	</td>
  </tr>
  <tr>
    <td colspan="2" valign="top" bgcolor="#3a5795" style="padding:10px; color:#fff;">  	
<strong>Atentamente:</strong><br>
<strong>Equipo</strong>: PoderMail.com<br>
contacto@podermail.com<br>
Tel: 55 6117 8017<br>
................................<br>
<strong>Sistema desarrollado por:</strong> <a href="http://www.mexico-paginasweb.com?g=MPW_Foot_mail" target="PM" style="color:#fff;">Mexico Paginas Web</a><br>
    </td>
  </tr>
</table>
';

    $sfrom            =    "PoderMail <contacto@podermail.com>"; //cuenta que envia 
    $srea            =    $ResponderA; //responder a
    $sdestinatario    =    $EmailSend; //cuenta destino
    $ssubject        =    $Subjet; //subject 

    $shtml = '' . $txt . '';

    $sheader = "From:" . $sfrom . "\nReply-To:" . $srea . "\n";
    $sheader = $sheader . "X-Mailer:PHP/" . phpversion() . "\n";
    $sheader = $sheader . "Mime-Version: 1.0\n";
    $sheader = $sheader . "Content-Type: text/html";
    mail($sdestinatario, $ssubject, $shtml, $sheader);
}

function addlistasHD($link, $fecha_sys, $CVE_SYSUSUARIO, $cve_mmacategoria, $archivo, $ip_user)
{
    // $fichero_email = array($archivo);
    // $mUnique = array();
    // foreach ($fichero_email as $fichero_limpio) {
    //     $new = file_get_contents($fichero_limpio);
    //     preg_match_all("/[a-z0-9_\-\+\.]+@[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i", $new, $resultado);
    //     foreach (trim($resultado[0]) as $result) {
    //         if (!in_array($result, $mUnique)) {
    //             $mUnique[] = $result;
    //         }
    //     }
    // }
    // fwrite($archivo,"");
    // file_put_contents($archivo, implode("\n", $mUnique), FILE_APPEND);

    $qry = @mysqli_query($link, "   INSERT INTO mmalistahd(fecha_sys,cve_statuscat,CVE_SYSUSUARIO,cve_mmacategoria,descripcion,archivo,ip_user,totalcarga)
                                    VALUES('" . $fecha_sys . "','1','" . $CVE_SYSUSUARIO . "','" . $cve_mmacategoria . "','Carga de mails','" . $archivo . "','" . $ip_user . "','0')");
    $id = mysqli_insert_id($link);
    $error = mysqli_error($link);
    if ($error == true) {
        send_error_email($link, $cve_mmacategoria, $CVE_SYSUSUARIO, $error, '');
        return  0;
    }
    return  1;
}

/*CATEGORIAS */
function send_error_email($link, $idcategoria, $idusuario, $error, $infoData)
{


    #$nt = $rowTotalMails;
    $sfrom = "contacto@podermail.com"; //cuenta que envia 
    $srea = "contacto@podermail.com"; //responder a
    $sdestinatario = "contacto@podermail.com"; //cuenta destino 
    $ssubject = "Error ListasTXTsave"; //subject 

    $shtml = '
		Error ListasTXTsave.<br>
		iDCategoria: ' . $idcategoria . '<br>
		Usuario: ' . $idusuario . '<br>
		Error: ' . $error . '<br><br><br>
		Info Add: ' . $infoData . '<br><br>
		
		' . $_SESSION["validasession"] . '<br>
		' . $_SESSION["CVE_SYSUSUARIO"] . '<br>
		' . $_SESSION["_PDWVALIDO_"] . '<br>
		' . $_SESSION["_USER_"] . '<br>
		' . $_SESSION["_IDEXTERNO_"] . '<br>
		' . $_SESSION["_IDSITIO_"] . '<br>
		';

    $sheader = "From:" . $sfrom . "\nReply-To:" . $srea . "\n";
    $sheader = $sheader . "X-Mailer:PHP/" . phpversion() . "\n";
    $sheader = $sheader . "Mime-Version: 1.0\n";
    $sheader = $sheader . "Content-Type: text/html";
    mail($sdestinatario, $ssubject, $shtml, $sheader);
}



function ModBtns($id, $array_buttons)
{
    #0 NOMBRE COLOR
    #1 NOMBRE DEL BOTON
    #2 ICONO DEL BOTON
    #3 TIPO DE BOTON 

    #4 TITULO DE MODAL
    #5 TAMAÑO DEL MODAL
    #6 PETICION DEL MODAL
    #7 ARCHIVO DE PETICION

    $btns = '<ul class="list-group list-group-flush">';
    for ($i = 0; $i < count($array_buttons); $i++) {
        $btns .= '   <li class="list-group-item p-0 border-0">
                        <' . ($array_buttons[$i][3] == "1" ? 'a' : 'button') . '
                            href="#"
                            class="btn btn-' . $array_buttons[$i][0] . ' btn-icon-split mb-1  btn-sm ' . ($array_buttons[$i][3] == "1" ? 'Menu1' : 'AbreModal') . ' "
                            ' . ($array_buttons[$i][3] == "1" ? '' : '  data-target="#staticBackdrop"') . ' 
                            data-toggle="modal"
                            id="' . $id . '" 
                            rel="' . $array_buttons[$i][5] . '" 
                            dir="' . $array_buttons[$i][6] . '" 
                            title="' . $array_buttons[$i][4] . '" 
                            media="" 
                            name="' . $array_buttons[$i][7] . '">
                            <span class="icon text-white-50  text-left">
                                <i class="' . $array_buttons[$i][2] . '"></i>
                            </span>
                            <span class="text text-left" style="width:10em;">' . $array_buttons[$i][1] . '</span>
                        </' . ($array_buttons[$i][3] == "1" ? 'a' : 'button') . '>
                    </li>';
    }
    return $btns . '</ul>';
}



function Btns($array_buttons)
{
    #0 NOMBRE COLOR
    #1 NOMBRE DEL BOTON
    #2 ICONO DEL BOTON
    #3 TIPO DE BOTON 

    #4 TITULO DE MODAL
    #5 TAMAÑO DEL MODAL
    #6 PETICION DEL MODAL
    #7 ARCHIVO DE PETICION

    $btns = '';
    for ($i = 0; $i < count($array_buttons); $i++) {
        $btns .= '
        
                        <' . ($array_buttons[$i][3] == "1" ? 'a' : 'button') . '
                            href="#"
                            class="btn btn-' . $array_buttons[$i][0] . ' btn-icon-split mb-1  btn-sm ' . ($array_buttons[$i][3] == "1" ? 'Menu1' : 'AbreModal') . ' "
                            ' . ($array_buttons[$i][3] == "1" ? '' : '  data-target="#staticBackdrop"') . ' 
                            data-toggle="modal"
                            id="" 
                            rel="' . $array_buttons[$i][5] . '" 
                            dir="' . $array_buttons[$i][6] . '" 
                            title="' . $array_buttons[$i][4] . '" 
                            media="" 
                            name="' . $array_buttons[$i][7] . '">
                            <span class="icon text-white-50  text-left">
                                <i class="' . $array_buttons[$i][2] . '"></i>
                            </span>
                            <span class="text text-left" style="">' . $array_buttons[$i][1] . '</span>
                        </' . ($array_buttons[$i][3] == "1" ? 'a' : 'button') . '>
                   ';
    }
    return $btns . '';
}


function Modstatus($cve_statuscat, $tabla, $link)
{

    $qry_status = @mysqli_query($link, "SELECT a.* FROM " . $tabla . "status a WHERE a.cve_" . $tabla . "status= '" . $cve_statuscat . "'");
    $row_status = @mysqli_fetch_array($qry_status);

    $btns = '   <div class="card ' .  $row_status["color"] . '  shadow text-center">
                        <div class="card-body">
                            ' . $row_status["descripcion"] . '
                        </div>
                    </div>';







    return $btns;
}

function xdato($link, $uid, $table, $campo, $campoid)
{
    $qry = @mysqli_query($link, " SELECT " . $campo . " FROM  " . $table . " a WHERE a.cve_statuscat='1' and   a." . $campoid . "='" . $uid . "'");
    $row = @mysqli_fetch_array($qry);
    $f = nl2br($row["" . $campo . ""]);
    return  $f;
}

function xforword($link, $uid, $table, $campo, $campoid)
{
    $qry = @mysqli_query($link, "   SELECT " . $campo . "
                                    FROM  " . $table . " a
                                    WHERE a." . $campoid . "='" . $uid . "'");
    $row = @mysqli_fetch_array($qry);
    $f = nl2br($row["" . $campo . ""]);
    return  $f;
}
