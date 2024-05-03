<!-- Modal -->
<div class="modal fade" id="modalActualizar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div id="divLoading">
            <div>
                <img src="../Assets/img/loading.svg" alt="Loading">
            </div>
        </div>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Actualizar Carpeta</h5>
                <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <fieldset class="form-group border p-3">
                    <form id="formCarpetaActualizar">
                        <input type="hidden" id="id_empresa_actualizar" value="">
                        <input type="hidden" id="id_carpeta_actualizar" value="">
                        <input type="hidden" id="nivel_actualizar" value="">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="nombre" for="carpeta">Nombre de la Carpeta</label>
                                <input type="text" id="NombreCarpetaActualizar" oninput="quitarAcentosYComillas(this)"
                                    name="NombreCarpetaActualizar" class="form-control  valid validTextNumber"
                                    placeholder="Nombre">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="color" class="form-label nombre">Color</label>
                            <input class="form-control valid" id="color_actualizar" type="color"
                                name="color_actualizar">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-info"><span id="btnText">Actualizar </span></button>
                        </div>
                    </form>
                </fieldset>
            </div>
        </div>
    </div>
</div>