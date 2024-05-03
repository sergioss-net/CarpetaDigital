<?php
session_start();
require_once('../conexion/bd.php');
require_once('../utils/validacion.php');
require_once('Header.php');
require_once('../utils/obtenerCarpetas.php');
$nivel = 1;
?>
<div class="content">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="font-size-16 me-3 mb-0">Carpetas</h5>
                    <div class="row mt-4">
                        <?php foreach($result_consulta as $carpetas){
                                $id_Empresa = $carpetas['id_Empresa'];
                                $nombre = $carpetas['Empresa'];
                                $colorHexadecimal = $carpetas['color']; 
                                $colorRGB = sscanf($colorHexadecimal, "#%02x%02x%02x");    
                            ?>
                        <div class="col-xl-4 col-sm-6">
                            <div class="card shadow-none border">
                                <div class="card-body p-3">
                                    <div class="">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar align-self-center me-3">
                                                <div class="avatar-title rounded  text-info font-size-24"
                                                    style="background-color: rgba(<?php echo $colorRGB[0] . ', ' . $colorRGB[1] . ', ' . $colorRGB[2]; ?>)">
                                                    <i class="bi bi-folder-fill"></i>
                                                </div>
                                            </div>

                                            <div class="flex-1">
                                                <h5 class="font-size-15 mb-1"><?php echo $nombre ?></h5>
                                                <button
                                                    onclick="ver(<?php echo $id_Empresa ?>,<?php echo $nivel ?>)"
                                                    class="font-size-13 btn-verDetalle " ><u>Ver Folder</u></button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>


                    <!-- <h5 class="font-size-16 me-3 mb-0">Folders</h5>
                        <div class="row mt-4">
                            <div class="col-xl-4 col-sm-6">
                                <div class="card shadow-none border">
                                    <div class="card-body p-3">
                                        <div class="">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="bx bxs-folder h1 mb-0 text-warning"></i>
                                                </div>
                                                <div class="avatar-group">
                                                    <div class="avatar-group-item">
                                                        <a href="javascript: void(0);" class="d-inline-block">
                                                            <img src="https://bootdey.com/img/Content/avatar/avatar1.png"
                                                                alt="" class="rounded-circle avatar-sm">
                                                        </a>
                                                    </div>
                                                    <div class="avatar-group-item">
                                                        <a href="javascript: void(0);" class="d-inline-block">
                                                            <img src="https://bootdey.com/img/Content/avatar/avatar2.png"
                                                                alt="" class="rounded-circle avatar-sm">
                                                        </a>
                                                    </div>
                                                    <div class="avatar-group-item">
                                                        <a href="javascript: void(0);" class="d-inline-block">
                                                            <div class="avatar-sm">
                                                                <span
                                                                    class="avatar-title rounded-circle bg-success text-white font-size-16">
                                                                    A
                                                                </span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex mt-3">
                                                <div class="overflow-hidden me-auto">
                                                    <h5 class="font-size-15 text-truncate mb-1"><a
                                                            href="javascript: void(0);" class="text-body">Analytics</a>
                                                    </h5>
                                                    <p class="text-muted text-truncate mb-0">12 Files</p>
                                                </div>
                                                <div class="align-self-end ms-2">
                                                    <p class="text-muted mb-0 font-size-13"><i
                                                            class="mdi mdi-clock"></i> 15
                                                        min ago</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          

                            <div class="col-xl-4 col-sm-6">
                                <div class="card shadow-none border">
                                    <div class="card-body p-3">
                                        <div class="">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="bx bxs-folder h1 mb-0 text-warning"></i>
                                                </div>
                                                <div class="avatar-group">
                                                    <div class="avatar-group-item">
                                                        <a href="javascript: void(0);" class="d-inline-block">
                                                            <img src="https://bootdey.com/img/Content/avatar/avatar3.png"
                                                                alt="" class="rounded-circle avatar-sm">
                                                        </a>
                                                    </div>
                                                    <div class="avatar-group-item">
                                                        <a href="javascript: void(0);" class="d-inline-block">
                                                            <img src="https://bootdey.com/img/Content/avatar/avatar4.png"
                                                                alt="" class="rounded-circle avatar-sm">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex mt-3">
                                                <div class="overflow-hidden me-auto">
                                                    <h5 class="font-size-15 text-truncate mb-1"><a
                                                            href="javascript: void(0);" class="text-body">Sketch
                                                            Design</a>
                                                    </h5>
                                                    <p class="text-muted text-truncate mb-0">235 Files</p>
                                                </div>
                                                <div class="align-self-end ms-2">
                                                    <p class="text-muted mb-0 font-size-13"><i
                                                            class="mdi mdi-clock"></i> 23
                                                        min ago</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                  

                            <div class="col-xl-4 col-sm-6">
                                <div class="card shadow-none border">
                                    <div class="card-body p-3">
                                        <div class="">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="bx bxs-folder h1 mb-0 text-warning"></i>
                                                </div>
                                                <div class="avatar-group">
                                                    <div class="avatar-group-item">
                                                        <a href="javascript: void(0);" class="d-inline-block">
                                                            <div class="avatar-sm">
                                                                <span
                                                                    class="avatar-title rounded-circle bg-info text-white font-size-16">
                                                                    K
                                                                </span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="avatar-group-item">
                                                        <a href="javascript: void(0);" class="d-inline-block">
                                                            <img src="https://bootdey.com/img/Content/avatar/avatar5.png"
                                                                alt="" class="rounded-circle avatar-sm">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex mt-3">
                                                <div class="overflow-hidden me-auto">
                                                    <h5 class="font-size-15 text-truncate mb-1"><a
                                                            href="javascript: void(0);"
                                                            class="text-body">Applications</a>
                                                    </h5>
                                                    <p class="text-muted text-truncate mb-0">20 Files</p>
                                                </div>
                                                <div class="align-self-end ms-2">
                                                    <p class="text-muted mb-0 font-size-13"><i
                                                            class="mdi mdi-clock"></i> 45
                                                        min ago</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        

                        </div> -->


                </div>
            </div>

        </div>
    </div>
</div>
</div>
<script src="../Assets/js/functions_dashboard.js"></script>
<?php require_once('footer.php')?>