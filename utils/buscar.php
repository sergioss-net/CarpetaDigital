<?php
try {
    include_once '../conexion/bd.php';

    if (isset($_GET['consulta'])) {
        $consulta = $_GET['consulta'];

        $query = "SELECT D.Nombre_documento,D.Tipo_Documento,D.No_Acta,D.Observaciones,D.Estado,D.id_archivo,U.Nombre FROM Detalle_Archivos D INNER JOIN Usuarios U ON U.Usuario = D.Usuario WHERE 
                   D.Nombre_documento LIKE :consulta1 OR 
                   D.Tipo_Documento LIKE :consulta2 OR 
                   D.No_Acta LIKE :consulta3 OR 
                   D.Observaciones LIKE :consulta4";

        $consulta = "%$consulta%";

        $busca = $conn_bd->prepare($query);
        $busca->bindParam(':consulta1', $consulta);
        $busca->bindParam(':consulta2', $consulta);
        $busca->bindParam(':consulta3', $consulta);
        $busca->bindParam(':consulta4', $consulta);

        $busca->execute();
        $result = $busca->fetchAll(PDO::FETCH_ASSOC);
        // print_r($result);
        foreach ($result as &$elemento) {
            $btnView = '';
            $btnDownload = '';
    
            if ($elemento['Estado'] == '1') {
                $btnDownload = '<button class="btn btn-success btn-sm " onClick="fntDownload(' . $elemento['id_archivo'] . ')"  title="Descargar Archivo"><i class="bi bi-download"></i></button>';
                $btnView = '<button class="btn btn-primary btn-sm " onClick="fntView(' . $elemento['id_archivo'] . ')"  title="Visualizar Archivo"><i class="bi bi-eye"></i></button>';
            }
    
            $elemento['opciones'] = '<div class="text-center">' . $btnDownload . '       ' . $btnView . ' </div>';
        }
        echo json_encode($result);

    } else {
        echo "No se ha proporcionado una consulta válida.";
    }
} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
}
?>