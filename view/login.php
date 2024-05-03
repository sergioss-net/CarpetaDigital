<?php
session_start();
if(isset($_SESSION['login'])){
   header('Location: Dashboard.php');
   die;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Buscar Operaciones</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../Assets/img/favicon.ico">
    <link rel="stylesheet" href="../Assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card my-5">
                    <div id="divLoading">
                        <div>
                            <img src="../Assets/img/loading.svg" alt="Loading">
                        </div>
                    </div>
                    <form class="card-body cardbody-color p-lg-4" id="formlogin">
                        <div class="text-center">
                            <img src="../Assets/img/gruponexen.png" class="img-fluid my-3" alt="profile">
                        </div>
                        <div class="text-center my-4">
							<h2>Documentos</h2>
						</div>
                        <div class="text-center my-4">
                            <h5>Ingresa tus Credenciales</h5>
                        </div>
                        <div class="form-group mb-3">
                            <input type="text" class="form-control" id="username" name="username"
                                aria-describedby="emailHelp" placeholder="Usuario">
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="txtPassword" name="password"
                                placeholder="Contraseña">
                            <div class="input-group-append">
                                <button id="show_password" class="btn btn-success" type="button"
                                    onclick="mostrarPassword()">
                                    <i class="bi bi-eye-slash icon" id="icono"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="form-control btn btn-success rounded submit px-5">Iniciar
                                Sesión</button>
                        </div>
                        <div class="mb-3 my-4 text-center">
                            <p>¿Olvidaste tu contraseña?</p>
                            <a href="#">Recuperar Contraseña</a>
                            <p>¿No tienes cuenta?</p>
                            <a href="#">Crear cuenta</a>
                        </div>
                        <div class="text-center pt-1 text-muted">
                            Copyrights All Rights Reserved <br>Nexen E-logistics &copy; 2022
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../Assets/js/login.js"></script>
</body>

</html>