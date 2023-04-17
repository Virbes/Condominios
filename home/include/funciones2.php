<?php 
function generat_url($cadena)
{


		$text = htmlentities($cadena, ENT_QUOTES, 'UTF-8');
		
		$text = strtolower($text);
		$text = trim($text); #elimino espacios
				
		#$numero = array('1', '2', '3', '4', '5', '6', '7','8','9','0');
		#$text = str_replace($numero,'',$text);
		$text = str_replace("'","",$text);
		
	
		
		
		$text = str_replace(
			array("\\", "¨", "º", "~",
				 "#", "@", "|", "!", "\"",
				 "·", "$", "%", "/",
				 "(", ")", "?", "'", "¡",
				 "¿", "[", "^", "`", "]",
				 "+", "}", "{", "¨", "´",
				 ">", "<", ",", ":",
				 ".","*",";"),
			'',
			$text
    	);
		
		$text = chop($text);
		$text = str_replace(' ','-',$text);
		$text = str_replace(',','',$text);
		
		$patron = array (
			// Espacios, puntos y comas por guion
 
			// Vocales
			'/&agrave;/' => 'a','/agrave/' => 'a',
			'/&egrave;/' => 'e','/egrave/' => 'e',
			'/&igrave;/' => 'i','/igrave/' => 'i',
			'/&ograve;/' => 'o','/ograve/' => 'o',
			'/&ugrave;/' => 'u','/ugrave/' => 'u',
 
			'/&aacute;/' => 'a','/aacute/' => 'a',
			'/&eacute;/' => 'e','/eacute/' => 'e',
			'/&iacute;/' => 'i','/iacute/' => 'i',
			'/&oacute;/' => 'o','/oacute/' => 'o',
			'/&uacute;/' => 'u','/uacute/' => 'u',
 
			'/&acirc;/' => 'a',
			'/&ecirc;/' => 'e',
			'/&icirc;/' => 'i',
			'/&ocirc;/' => 'o',
			'/&ucirc;/' => 'u',
 
			'/&atilde;/' => 'a','/atilde/' => 'a',
			'/&etilde;/' => 'e','/etilde/' => 'e',
			'/&itilde;/' => 'i','/itilde/' => 'i',
			'/&otilde;/' => 'o','/otilde/' => 'o',
			'/&utilde;/' => 'u','/utilde/' => 'u',
 
			'/&auml;/' => 'a',
			'/&euml;/' => 'e',
			'/&iuml;/' => 'i',
			'/&ouml;/' => 'o',
			'/&uuml;/' => 'u',
 
			'/&auml;/' => 'a',
			'/&euml;/' => 'e',
			'/&iuml;/' => 'i',
			'/&ouml;/' => 'o',
			'/&uuml;/' => 'u',
 			
			// Otras letras y caracteres especiales
			'/&aring;/' => 'a',
			'/&ntilde;/' => 'n',
			'/&iquest;/' => '',
			'/&copy;/' => '',
			'/amp;/' => '',
			'/&amp;/' => '',
			'/quot;/' => '',
			'/&iquest;/' => '',
			'/iquest/' => '',
			'/&ldquo;/' => '',
			'/ldquo/' => '',
			'/&rdquo;/' => '',
			'/rdquo/' => '',
			'/&iexcla;/' => '',
			'/iexcla/' => '',
			'/&quot;/' => '',
			'/quot/' => '',
			'/&/' => ''
		
 
 
 
			// Agregar aqui mas caracteres si es necesario
		);
 
		$text = preg_replace(array_keys($patron),array_values($patron),$text);
		$text = str_replace('--','-',$text);
		return $text;

}

?>