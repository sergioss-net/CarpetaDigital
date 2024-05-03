<div class="modal fade" id="Modal_Datos" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div id="divLoading">
                <div>
                    <img src="../Assets/img/loading.svg" alt="Loading">
                </div>
            </div>
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal"></h5>
                <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="Guardar_Datos" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="id_empresa" value="">
                    <input type="hidden" id="id_carpeta" value="">
                    <input type="hidden" id="nivel" value="">
                    <input type="hidden" id="Tipo_Documento_hidden" value="">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="Tipo_Documento" class="form-label">Tipo Documento</label>
                            <input class="form-control" id="Documento" name="Documento" disabled>
                        </div>

                        <div class="col-md-8">
                            <label for="Observaciones" class="form-label">Observaciones</label>
                            <input class="form-control validTextNumber valid" type="text"
                                oninput="quitarAcentosYComillas(this)" id="Observaciones" name="Observaciones">
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-4" id="numero" style="display:none">
                            <label for="No Acta" class="form-label">No. de Acta</label>
                            <input class="form-control validTextNumber valid" type="text"
                                oninput="quitarAcentosYComillas(this)" id="No_Acta" name="No_Acta">
                        </div>
                        <div class="col-md-4">
                            <label for="Archivo" class="form-label">Archivo</label>
                            <input type="file" id="Archivo" name="Archivo">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-success btn-lg ">
                                <i class="bi bi-card-checklist"></i> Guardar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>