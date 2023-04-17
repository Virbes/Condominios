<?
session_start();
$session_id = session_id();
$_SESSION["_session_id_"] = $session_id;
$ipuser = getenv("REMOTE_ADDR");
$_SESSION["_ipuser_"] = $ipuser;
$_SESSION["REFERER"] = $_SERVER['HTTP_REFERER'];
$_SESSION["STRING"] = $_SERVER['QUERY_STRING'];
$_SESSION["URI"] = $_SERVER['REQUEST_URI'];

include("BDquery.php");
include("funciones2.php");

function response_modal($MDSIZE, $MDlFORM, $IDPOST, $IDPOST2, $MODPOST, $fileaction, $NPOPUP, $descripcion, $save)
{
	$MDLSIZE = ["", "modal-sm", "modal-lg"];
	return json_encode(
		'<div class="modal-dialog modal-dialog-centered ' . $MDLSIZE[$MDSIZE] . ' " role="document">
				<form class="modal-content" id="form_save" name="form_save" action="#middle">
					<input type="hidden" id="IDPOST"  		name="IDPOST" value="' . $IDPOST . '" />
					<input type="hidden" id="IDPOST2" 		name="IDPOST2" value="' . $IDPOST2 . '" />
					<input type="hidden" id="MODPOST" 		name="MODPOST" value="' . $MODPOST . '_save" />
					<input type="hidden" id="form_file" 	name="form_file" value="' . $fileaction . '" alt="Nombre de archivo PHP donde se guarda(solo nombre .php)" />
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle">' . $NPOPUP . ': ' . $descripcion . '</h5>
						<button type="button" class="close" data-dismiss="modal" aria-p="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						' . $MDlFORM . '
					</div>
					<div class="modal-footer">
						<button class="btn btn-warning btn-icon-split" data-dismiss="modal" >
							<span class="icon text-white-50">
								<i class="fas fa-times"></i>
							</span>
							<span class="text">Cerrar</span>
						</button>
						' . ($save  ? '
						<button class="btn btn-info btn-icon-split"  id="btn_form">
							<span class="icon text-white-50">
								<i class="fas fa-arrow-right"></i>
							</span>
							<span class="text">' . $save . '</span>
						</button>' : '') . '
					</div>
				</form>			
			</div>'
	);
}

$modalerror =  response_modal(0, $MDlFORM, '', '', '', '', '', '', 'Error', false);


function classtable($val)
{
	$class_table = ($val) ? 'class=""' : 'class="table-active"';

	return $class_table;
}
