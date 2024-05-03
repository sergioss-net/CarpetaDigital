<?php
session_start();
require_once('../conexion/bd.php');
require_once('../utils/validacion.php');
require_once('Header.php');
require_once('../view/Modals/Modal_General.php');
require_once('../utils/CarpetasEmpresa.php'); 
require_once('../view/Modals/modalCarpeta.php');


if (isset($_GET['id_carpeta']) && isset($_GET['nivel']) && isset($_GET['id_empresa'])) {
    $id_carpeta_value = intval($_GET['id_carpeta']);
    $nivel = intval($_GET['nivel']);
    $id_empresa = intval($_GET['id_empresa']);

} 

$query = "SELECT id_carpeta,Direccion,Nombre_Carpeta FROM [dbo].[Carpetas] WHERE id_carpeta = :id_carperta_value";
$consulta_carpeta = $conn_bd->prepare($query);
$consulta_carpeta->bindParam(':id_carperta_value',$id_carpeta_value);
$consulta_carpeta->execute();
$result_consulta_carpeta = $consulta_carpeta->fetch(PDO::FETCH_ASSOC);

$nombre_carpeta = $result_consulta_carpeta['Nombre_Carpeta'];


$id_carpeta_recuperada = $result_consulta_carpeta['id_carpeta'];
$Ruta_valida = $result_consulta_carpeta['Direccion'];

$carpeta = subcarpetas($id_carpeta_value,$nivel,$id_empresa,$conn_bd);


$rutaSinParte = str_replace("../Carpetas/", "", $Ruta_valida);


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
                                <div>
                                    <h5><?= $rutaSinParte ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-sm-6">
                            <div class="mt-4 mt-sm-0 d-flex align-items-center justify-content-sm-end">
                                <button class="btn btn-retrocede" id="botonRetroceso"><i
                                        class="bi bi-skip-backward-fill"></i> Regresar</button>
                                <div class="mb-2 me-2 md">
                                    <div class="mt-4 mt-sm-0 d-flex align-items-center justify-content-sm-end">
                                        <?php if($rol_user != '3' ){ ?>

                                        <?php if($nivel >= 3 ){ ?>
                                        <button class="btn btn-primary" type="button"
                                            onclick="subirArchivo(<?php echo $id_carpeta_value?>,<?php echo $nivel?>,<?php echo $id_empresa?>,'<?php echo $nombre_carpeta?>')"><i
                                                class="bi bi-arrow-up-square-fill"></i> Subir Archivo</button>
                                        <?php } ?>
                                        <?php } ?>
                                    </div>

                                </div>
                                <div class="mb-2 me-2" style="margin-left:12px;">
                                    <div class="mt-4 mt-sm-0 d-flex align-items-center justify-content-sm-end">
                                        <?php if ($_SESSION['usuario']['nombre_usuario'] === 'ADMIN') {?>
                                        <button class="btn btn-primary"
                                            onclick="crearSub(<?php echo $id_carpeta_value?>,<?php echo $nivel?>,<?php echo $id_empresa?>)"><i
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
                                                <a class="text-muted  font-size-16" href="#" role="button"
                                                    data-bs-toggle="dropdown" aria-haspopup="true">
                                                    <i class="bi bi-caret-down-fill"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <button class="dropdown-item"
                                                        onclick="Actualizar(<?php echo $id_carpeta?>)">EDITAR
                                                        CARPETA</button>
                                                    <button class="dropdown-item" onclick="Eliminar()">ELIMINAR
                                                        CARPETA</button>
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
                </div>

                <div class="card-body" id="archivostabla">
                    <?php if($nivel >= 3){?>
                    <div class="col-md-12">
                        <h1>ARCHIVOS <?php echo $nombre_carpeta ?></h1>
                        <table id="tablaArchivos" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Archivo</th>
                                    <th>Observacion</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <?php }?>
                    <?php if($id_carpeta_recuperada == 445){?>
                        <div class="col-md-12">
                        <h1>ARCHIVOS <?php echo $nombre_carpeta ?></h1>
                        <table id="tablaArchivos" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Archivo</th>
                                    <th>Observacion</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <?php }?>
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
<script>
const id_carpeta_value = "<?= $id_carpeta_value?>";
</script>
<script src="../Assets/js/functions_admin.js"></script>
<script src="../Assets/js/functions_carpetas.js"></script>

<?php require_once('footer.php')?>