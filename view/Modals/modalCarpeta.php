<!-- Modal -->
<div class="modal fade" id="modalCarpeta" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div id="divLoadingNuevo">
            <div>
                <img src="../Assets/img/loading.svg" alt="Loading">
            </div>
        </div>
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Crear Carpeta</h5>
                <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <fieldset class="form-group border p-3">
                    <form id="formCarpeta">
                        <input type="hidden" id="id_empresa" value="">
                        <input type="hidden" id="id_carpeta" value="">
                        <input type="hidden" id="nivel" value="">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="nombre" for="carpeta">Nombre de la Carpeta</label>
                                <input type="text" id="NombreCarpeta" oninput="quitarAcentosYComillas(this)"
                                    name="NombreCarpeta" class="form-control  valid validTextNumber"
                                    placeholder="Nombre">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="color" class="form-label nombre">Color</label>
                            <input class="form-control valid" id="color" type="color" name="color">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" id="btnCarpeta" class="btn btn-primary"><span id="btnText">Crear
                                </span></button>
                        </div>
                    </form>
                </fieldset>
            </div>
        </div>
    </div>
</div>