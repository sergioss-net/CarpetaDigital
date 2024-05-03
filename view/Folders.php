<?php
session_start();
require_once('../conexion/bd.php');
require_once('../utils/validacion.php');
require_once('Header.php');
require_once('../view/Modals/modalCarpeta.php');
require_once('../view/Modals/modalActualizar.php');
require_once('../utils/CarpetasEmpresa.php'); 
$id_empresa = isset($_GET['id_empresa']) ? intval($_GET['id_empresa']) : 0;
$nivel = intval($_GET['nivel']);
$carpeta = getCarpetas($id_empresa,$nivel,$conn_bd);
$rol_user = $_SESSION['userData']['id_rol'];

?>
<div class="content">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-lg-4 col-sm-6">
                            <div class="search-box mb-2 me-2">
                                <div class="position-relative">
                                    <input type="text" name="consulta"
                                        class="form-control bg-light border-light rounded" placeholder="Buscar..."
                                        oninput="buscar();">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24"
                                        class="eva eva-search-outline search-icon">
                                        <g data-name="Layer 2">
                                            <g data-name="  ">
                                                <rect width="24" height="24" opacity="0"></rect>
                                                <path
                                                    d="M20.71 19.29l-3.4-3.39A7.92 7.92 0 0 0 19 11a8 8 0 1 0-8 8 7.92 7.92 0 0 0 4.9-1.69l3.39 3.4a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42zM5 11a6 6 0 1 1 6 6 6 6 0 0 1-6-6z">
                                                </path>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-sm-6">
                        <div class="mt-4 mt-sm-0 d-flex align-items-center justify-content-sm-end">
                                <button class="btn btn-retrocede" id="botonRetroceso"><i
                                        class="bi bi-skip-backward-fill"></i> Regresar</button>
                                <div class="mb-2 me-2">
                                    <div class="mt-4 mt-sm-0 d-flex align-items-center justify-content-sm-end">
                                        <?php if($rol_user === 1){ ?>
                                        <button class="btn btn-primary"
                                            onclick="crear(<?php echo $id_empresa?>,<?php echo $nivel?>)"><i
                                                class="bi bi-folder-fill mb-2"></i> Carpeta</button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="font-size-16 me-3 mb-0" id="titulo_carpeta">Carpetas</h5>

                    <div class="row mt-4" id='carpetas'>
                        <?php foreach($carpeta as $carpetas){
                                    $id_carpeta = $carpetas['id_carpeta'];
                                    $nombre = $carpetas['Nombre_Carpeta'];
                                    $colorHexadecimal = $carpetas['color']; 
                                    $colorRGB = sscanf($colorHexadecimal, "#%02x%02x%02x");    
                                ?>
                        <div class="col-xl-4 col-sm-6">
                            <div class="card shadow-none border">
                                <div class="card-body p-3">
                                    <div class="">

                                        <div class="d-flex align-items-center">
                                            <!-- <div class="dropdown float-end">
                                                <a class="text-muted  font-size-16" href="#"
                                                    role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                    <i class="bi bi-caret-down-fill"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <button class="dropdown-item" onclick="Actualizar(<?php echo $id_carpeta?>)">EDITAR CARPETA</button>
                                                    <button class="dropdown-item" onclick="Eliminar(<?php echo $id_carpeta?>)">ELIMINAR CARPETA</button>
                                                </div>
                                            </div> -->
                                            <div class="avatar align-self-center me-3">
                                                <div class="avatar-title rounded  text-info font-size-24"
                                                    style="background-color: rgba(<?php echo $colorRGB[0] . ', ' . $colorRGB[1] . ', ' . $colorRGB[2]; ?>)">
                                                    <i class="bi bi-folder-fill"></i>
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <h5 class="font-size-15 mb-1"><?php echo $nombre ?></h5>
                                                <button
                                                    onclick="verSup(<?php echo $id_carpeta?>,<?php echo $nivel?>,<?php echo $id_empresa?>)"
                                                    class="font-size-13 btn-verDetalle "><u>Ver Folder</u></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="table-container">
                        <div id="tablaResultados" style="display:none;">
                            <table id="miTabla" class="display">
                                <thead>
                                    <tr>
                                        <th>Nombre de Documento</th>
                                        <th>Nombre de Usuario</th>
                                        <th>Tipo de Documento</th>
                                        <th>No. de Acta</th>
                                        <th>Observaciones</th>
                                        <th>opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Las filas se agregarán dinámicamente aquí -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

</div>

<script src="../Assets/js/functions_admin.js"></script>
<script src="../Assets/js/functions_dashboard.js"></script>
<!-- <script src="../Assets/js/functions_carpetas.js"></script> -->

<?php require_once('footer.php')?>