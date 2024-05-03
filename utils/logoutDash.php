<?php 
require('../conexion/bd.php');
session_start();
$FechConect = date('Y-m-d');
$HoraConect = date('H:i:s');
$usuario = $_SESSION['usuario']['Usuario'];
$id_conexion = $_SESSION['usuario']['id_conexion'];
$query_cerrar = "UPDATE [dbo].[Conexion_Usuario] SET Estatus = 0, Fecha_Fin_Conexion = :fecha_conexion,Hora_Fin_Conexion =:hora_conexion WHERE Usuario = :usuario AND id_conexion = :conexion";
$cerrar = $conn_bd->prepare($query_cerrar);
$cerrar->bindParam(':fecha_conexion', $FechConect);
$cerrar->bindParam(':hora_conexion', $HoraConect);
$cerrar->bindParam(':usuario',$usuario,PDO::PARAM_STR);
$cerrar->bindParam(':conexion',$id_conexion);
$cerrar->execute(); 

session_unset();
session_destroy();//destruye la sesion
header('location:../view/login.php');//redirecciona al controlador login

?>	