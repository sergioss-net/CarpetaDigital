<?php
    require_once('../conexion/bd.php');

    $id_carpeta_value = $_GET['id_carpeta'];

    $query = "SELECT id_archivo,Estado,Nombre_documento,Razon_Social,Observaciones, CONCAT(Nombres, ' ', Ape_paterno, ' ', Ape_materno) AS Nombre_Completo FROM  [dbo].[Detalle_Archivos] WHERE id_carpeta = :id_carpeta_value AND Estado != 0";
    $consulta = $conn_bd->prepare($query);
    $consulta->bindParam(':id_carpeta_value',$id_carpeta_value);
    $consulta->execute();

    $result_consulta = $consulta->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result_consulta as &$elemento) {
        $nombreDocumento = $elemento['Nombre_documento'];
        $posicionPrimeraLetra = strcspn($nombreDocumento, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
        $nombreDocumentoSinNumeros = substr($nombreDocumento, $posicionPrimeraLetra);

        $elemento['Nombre_documento'] = $nombreDocumentoSinNumeros;
    }

    foreach ($result_consulta as &$elemento) {
        $btnView = '';
        $btnDownload = '';

        if ($elemento['Estado'] == '1') {
            $btnDownload = '<button class="btn btn-success btn-sm " onClick="fntDownload(' . $elemento['id_archivo'] . ')"  title="Descargar Archivo"><i class="bi bi-download"></i></button>';
            $btnView = '<button class="btn btn-primary btn-sm " onClick="fntView(' . $elemento['id_archivo'] . ')"  title="Visualizar Archivo"><i class="bi bi-eye"></i></button>';
        }

        $elemento['opciones'] = '<div class="text-center">' . $btnDownload . '       ' . $btnView . ' </div>';
    }

    echo json_encode($result_consulta, JSON_UNESCAPED_UNICODE);
    die;

?>