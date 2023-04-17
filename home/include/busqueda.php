<table class="table table-striped  mb-0">
    <thead>
        <tr>
            <td scope="col" class="pr-0">
                <div class="row">
                    <div class="col-md-4 col-sm-12 form-control border-0 Modbtns">
                        <? echo ModBtn($link, $_SESSION["_SYS_0011"], $b_idmod); ?>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <form action="#middle" method="POST" id="form_buscar" class="form_buscar mb-0" name="form_buscar">
                            <input type="hidden" id="b_idmod" name="b_idmod" class="form_search" value="<? echo $b_idmod ?>" />
                            <input type="hidden" id="b_url_dest" name="b_url_dest" class="form_search" value="<? echo $b_url_dest ?>" />
                            <input type="hidden" id="b_mostrar" name="b_mostrar" class="form_search" value="<? echo $b_mostrar ?>" />
                            <? echo ($b_mods) ? '<input type="hidden" id="b_mods" name="b_mods" class="form_search" value="' . $b_mods . '" />' : ''; ?>
                            <? echo ($b_LAN) ? '<input type="hidden" id="b_LAN" name="b_LAN" class="form_search" value="' . $b_LAN . '" />' : ''; ?>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-search"></i></div>
                                </div>
                                <input type="text" class="form-control change-select" name="<? echo $name ?>" value="<? echo $varsearch ?>">
                                <div class="input-group-append">
                                    <select id="select_search" class="btn  dropdown-toggle  bg-crm-black" required>
                                        <? echo SearchOpt($searchOPtions, $idselected); ?>
                                    </select>
                                    <button type="submit" class="btn bg-crm-black" id="sumit_search"><? echo (strlen($_SESSION["LANG"]) > 1) ? 'Buscar' : 'Search' ?></button>
                                </div>
                                <select id="select_limit" name="limit" class="ml-1 btn btn-dark dropdown-toggle dropdown-toggle-dark" required>
                                    <? for ($i = 1; $i < 7; $i++) {
                                        if ($limit == ($i * 50)) {
                                            $selected = 'selected';
                                        } else {
                                            $selected = '';
                                        }
                                        echo '<option ' . $selected . ' value="' . ($i * 50) . '">' . ((strlen($_SESSION["LANG"]) > 1) ? 'Mostrar' : 'View') . ' ' . ($i * 50) . '  ' . ((strlen($_SESSION["LANG"]) > 1) ? 'registros' : 'records') . '</option>';
                                    } ?>
                                </select>

                            </div>
                        </form>
                    </div>
                </div>
            </td>
        </tr>
    </thead>
</table>