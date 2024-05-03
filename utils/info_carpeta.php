<?php 
require_once('../conexion/bd.php');

if(isset($_GET)){
    $id_carpeta = $_GET['id_carpeta'];
    $query = "SELECT * FROM [dbo].[Carpetas] WHERE id_carpeta = :id_carpeta";
    $valida = $conn_bd->prepare($query);
    $valida->bindParam(':id_carpeta',$id_carpeta);
    $valida->execute();
    
    $result_valida = $valida->fetch(PDO::FETCH_ASSOC);

    echo  json_encode($result_valida);

}
?>