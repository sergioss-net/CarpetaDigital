
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a href="../index.php"  class="navbar-brand d-flex align-items-center">
            <img src="../Assets/img/gruponexen.png" alt="AdminLTE Logo" class="brand-image" style="opacity: .8">
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 navbar-nav">
                <li class="nav-item">
                    <a class="nav-link fw-bold" aria-current="page" href="../index.php">Inicio</a>
                </li>
            </ul>
            <ul class="order-1 order-md-6 navbar-nav navbar-no-expand ml-auto">
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <label class="fw-bold"><strong><?= $_SESSION['usuario']['Usuario']?></strong></label>
                        <img src="../Assets/img/usuario.png" alt="">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="../utils/logoutDash.php" class="dropdown-item"><i class="bi bi-x-circle-fill mr-2"
                                style="font-size:22px;"></i>Cerrar Sesión</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>