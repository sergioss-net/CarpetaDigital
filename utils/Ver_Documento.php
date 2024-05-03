<?php

$rutaServidor = "158.69.113.62\Nexen_2022"; //serverName\instanceName
$user="sa";
$pass="#Nexen_2023*10/21.#";
$nombreBaseDeDatos="Carpetas_Digitales";

$conn_bd = new PDO("sqlsrv:server=$rutaServidor;database=$nombreBaseDeDatos", $user, $pass);
$conn_bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id_archivo = $_GET['id_documento'];

$query = "SELECT * FROM [dbo].[Detalle_Archivos] WHERE id_archivo = :id_carpeta";
$consulta = $conn_bd->prepare($query);
$consulta->bindParam(':id_carpeta', $id_archivo);
$consulta->execute();

$result = $consulta->fetch(PDO::FETCH_ASSOC);
$rutaArchivo = $result['Ruta'] . '/' . $result['Nombre_documento'];

// Verificar si el archivo existe
if (file_exists($rutaArchivo)) {
    // Obtener el tipo MIME del archivo (puedes ajustar esto según el tipo de archivo)
    $tipoContenido = mime_content_type($rutaArchivo);
    
    // Configurar las cabeceras HTTP para mostrar el archivo
    header('Content-Type: ' . $tipoContenido);
    
    // Leer y mostrar el archivo en el navegador
    readfile($rutaArchivo);
    exit;
} else {
    // El archivo no existe
    echo 'El archivo no se encuentra disponible para visualizar.';
}
?>