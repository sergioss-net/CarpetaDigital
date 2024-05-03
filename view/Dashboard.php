<?php
session_start();
require_once('Header.php');

?>
<div class="content d-flex align-items-center justify-content-center mt-4">
    <div class="col-md-12 form">
        <div class="row align-items-center justify-content-center mt-4 my-4">
            <div class="col-lg-7">
                <h5 class="path"><i class="bi bi-tv"></i> > Dispositivo <h5 id="path"></h5></h5>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Buscar..." aria-label="Buscar" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon2"><i class="bi bi-search"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content d-flex align-items-center justify-content-center">
    <div class="col-md-12 formfolder" id="newFolders">
        <div class="folderDesign mt-4">
        </div>
    </div>
</div>

<script src="../Assets/js/showFolders.js"></script>
