<?php

require('../conexion/bd.php');

$user = $_SESSION['usuario']['Usuario'];
$id_conexion =$_SESSION['usuario']['id_conexion'];
$query_valida ="SELECT * FROM [dbo].[Conexion_Usuario] WHERE Usuario = :usuario AND id_conexion = :conexion";
$valida=$conn_bd->prepare($query_valida);
$valida->bindParam(':usuario',$user,PDO::PARAM_STR);
$valida->bindParam(':conexion',$id_conexion);
$valida->execute();
$result_valida = $valida->fetch(PDO::FETCH_ASSOC);

if(($result_valida['Estatus'] != $_SESSION['usuario']['Estatus']) || !$_SESSION['login']){
    $_SESSION['login'] =false;
    session_destroy();
    header('Location: login.php');
    die;
}

?>

