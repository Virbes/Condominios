<? include($_SERVER['DOCUMENT_ROOT'] . "/home/include/conn.php");


function Formatmoneda($string)
{
    return ' $ ' . number_format($string, 2) . ' MXN';
}
function Formatparrafo($string)
{
    return wordwrap((substr($string, 0, 10)), 10, "<br>\n");
}

function Formatconfirmacion($string)
{
    return wordwrap(($string), 20, "<br>\n");
}

function Formatlista($string)
{
    return '*' . wordwrap((substr($string, 0, 180)), 70, "<br>    \n");
}

