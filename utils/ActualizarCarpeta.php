<?php
session_start();
require_once('../conexion/bd.php');



$nombre_Carpeta = trim($_POST['NombreCarpetaActualizar']);
$color = $_POST['color_actualizar'];
$Empresa = $_POST['empresa'];
$Nivel = $_POST['nivel'];
$id_carpeta = $_POST['id_carpeta'];


if($Nivel === '1'){

    $consulta = "SELECT Nombre_Carpeta, id_carpeta FROM [dbo].[Carpetas] WHERE id_carpeta = :id_carpeta";
    $consulta_ex = $conn_bd->prepare($consulta);
    $consulta_ex->bindParam(':id_carpeta', $id_carpeta);
    $consulta_ex->execute();
    $result_consulta = $consulta_ex->fetch(PDO::FETCH_ASSOC);
    $nombre_Carpeta_padre = $result_consulta['Nombre_Carpeta'];
    
    $consulta_empresa = "SELECT Empresa FROM [dbo].[Empresas] WHERE Id_Empresa = :id_empresa";
    $consulta_Empresa = $conn_bd->prepare($consulta_empresa);
    $consulta_Empresa->bindParam(':id_empresa', $Empresa);
    $consulta_Empresa->execute();
    $result_consulta_empresa = $consulta_Empresa->fetch(PDO::FETCH_ASSOC);
    $nombre_empresa = $result_consulta_empresa['Empresa'];
    
    $empresa_ex = "SELECT id_carpeta, Direccion, Nombre_Carpeta FROM [dbo].[Carpetas] WHERE id_empresa = :id_empresa AND Nombre_Carpeta = :nombre";
    $Empresa_con = $conn_bd->prepare($empresa_ex);
    $Empresa_con->bindParam(':id_empresa', $Empresa);
    $Empresa_con->bindParam(':nombre', $nombre_Carpeta_padre);
 
    
    $Empresa_con->execute();
    $result_Empresa_con = $Empresa_con->fetchAll(PDO::FETCH_ASSOC);
    $status = true; // Variable para mantener el estado

    foreach ($result_Empresa_con as $elemento) {
        $id_carpeta = $elemento['id_carpeta'];
        $Direccion = $elemento['Direccion'];
        $Nombre = $elemento['Nombre_Carpeta'];
        $ruta = '../Carpetas/' . $nombre_empresa;

        if (is_dir($ruta . '/' . $nombre_Carpeta_padre)) {
            $ruta_nueva = '../Carpetas/' . $nombre_empresa . '/' . $nombre_Carpeta;
            rename($ruta . '/' . $nombre_Carpeta_padre, $ruta_nueva);

            $update_query = "UPDATE [dbo].[Carpetas] SET Nombre_Carpeta = :nombre,color = :color WHERE id_carpeta = :id_carpeta";
            $update_statement = $conn_bd->prepare($update_query);
            $update_statement->bindParam(':nombre', $nombre_Carpeta);
            $update_statement->bindParam(':id_carpeta', $id_carpeta);
            $update_statement->bindParam(':color', $color);

            if ($update_statement->execute()) {
                $ruta_consulta = '../Carpetas/' . $nombre_empresa . '/' . $nombre_Carpeta_padre . '%';
                $empresa_dir = "SELECT id_carpeta, Direccion, Nombre_Carpeta FROM [dbo].[Carpetas] WHERE id_empresa = :id_empresa AND Direccion LIKE :ruta";
                $Empresa_dir = $conn_bd->prepare($empresa_dir);
                $Empresa_dir->bindParam(':id_empresa', $Empresa);
                $Empresa_dir->bindParam(':ruta', $ruta_consulta);
                $Empresa_dir->execute();
                $result_Empresa = $Empresa_dir->fetchAll(PDO::FETCH_ASSOC);

                foreach ($result_Empresa as &$elemento) {
                    $id_carpeta_original = $elemento['id_carpeta'];
                    $direccion_original = $elemento['Direccion'];
                    $direccion_modificada = !empty($elemento['Direccion']) ? str_replace($nombre_Carpeta_padre, $nombre_Carpeta, $elemento['Direccion']) : $elemento['Direccion'];

                    $sql = "UPDATE [dbo].[Carpetas] SET Direccion = :direccion_modificada WHERE id_carpeta = :id_carpeta_original";

                    $stmt = $conn_bd->prepare($sql);
                    $stmt->bindParam(':direccion_modificada', $direccion_modificada);
                    $stmt->bindParam(':id_carpeta_original', $id_carpeta_original);

                    if ($stmt->execute()) {
                        $elemento['Direccion'] = $direccion_modificada;
                    } else {
                        $status = false; // Si hay un error, actualiza el estado a false
                    }
                }
            } else {
                $status = false; // Si hay un error, actualiza el estado a false
            }
        }
    }

    if ($status) {
        $arrData = array('status' => true, 'msg' => 'TODAS LAS CARPETAS ACTUALIZADAS CORRECTAMENTE');
    } else {
        $arrData = array('status' => false, 'msg' => 'AL MENOS UNA CARPETA NO SE PUDO ACTUALIZAR');
    }

    echo json_encode($arrData);
   
}else{
    
    $consulta = "SELECT Nombre_Carpeta, id_carpeta,Direccion FROM [dbo].[Carpetas] WHERE id_carpeta = :id_carpeta";
    $consulta_ex = $conn_bd->prepare($consulta);
    $consulta_ex->bindParam(':id_carpeta', $id_carpeta);
    $consulta_ex->execute();
    $result_consulta = $consulta_ex->fetch(PDO::FETCH_ASSOC);
    $nombre_carpeta_sub = $result_consulta['Nombre_Carpeta'];
    $ruta = $result_consulta['Direccion'];

    $status = true;
    $msg = '';

    if (is_dir($ruta)) {      
        $update_query = "UPDATE [dbo].[Carpetas] SET Nombre_Carpeta = :nombre,color = :color WHERE id_carpeta = :id_carpeta";
        $update_statement = $conn_bd->prepare($update_query);
        $update_statement->bindParam(':nombre', $nombre_Carpeta);
        $update_statement->bindParam(':id_carpeta', $id_carpeta);
        $update_statement->bindParam(':color', $color);
        if ($update_statement->execute()) {
           
            $ruta_nueva = $ruta.'%';
            $empresa_dir = "SELECT id_carpeta, Direccion, Nombre_Carpeta FROM [dbo].[Carpetas] WHERE id_empresa = :id_empresa AND Direccion LIKE :ruta";
            $Empresa_dir = $conn_bd->prepare($empresa_dir);
            $Empresa_dir->bindParam(':id_empresa', $Empresa);
            $Empresa_dir->bindParam(':ruta', $ruta_nueva);
            $Empresa_dir->execute();
            $result_Empresa = $Empresa_dir->fetchAll(PDO::FETCH_ASSOC);
            $renombrado_realizado = false;

            foreach ($result_Empresa as &$elemento) {
                $id_carpeta_original = $elemento['id_carpeta'];
                $direccion_original = $elemento['Direccion'];
                $direccion_modificada = !empty($elemento['Direccion']) ? str_replace($nombre_carpeta_sub, $nombre_Carpeta, $elemento['Direccion']) : $elemento['Direccion'];

                $sql = "UPDATE [dbo].[Carpetas] SET Direccion = :direccion_modificada WHERE id_carpeta = :id_carpeta_original";

                $stmt = $conn_bd->prepare($sql);
                $stmt->bindParam(':direccion_modificada', $direccion_modificada);
                $stmt->bindParam(':id_carpeta_original', $id_carpeta_original);
                if (!$renombrado_realizado) {
                    if ($stmt->execute()) {
                        $elemento['Direccion'] = $direccion_modificada;
                        // Aquí añadimos la función rename para cambiar el nombre de la carpeta
                        $ruta_original = dirname($direccion_original);
                        $ruta_modificada = dirname($direccion_modificada);
                        $nuevo_nombre_carpeta = basename($direccion_modificada);
                        $viejo_nombre_carpeta = basename($direccion_original);

                        $ruta_completa_original = $ruta_original . DIRECTORY_SEPARATOR . $viejo_nombre_carpeta;
                        $ruta_completa_modificada = $ruta_modificada . DIRECTORY_SEPARATOR . $nuevo_nombre_carpeta;

                        if (rename($ruta_completa_original, $ruta_completa_modificada)) {
                            $renombrado_realizado = true;
                        } else {
                            $status = false;
                            $msg = 'NO SE ACTUALIZO CORRECTAMENTE LA CARPETA ';
                            break;
                        }
                    } else {
                        $status = false;
                        $msg = 'NO SE ACTUALIZO CORRECTAMENTE LA CARPETA ';
                        break; // Si hay un error, actualiza el estado a false
                    }
                }
            }
        }else {
            $status = false;
            $msg = 'NO SE ACTUALIZO CORRECTAMENTE LA CARPETA ';
        }
 
    }else{
        $status = false;
        $msg = 'NO SE ACTUALIZO CORRECTAMENTE LA CARPETA 1';
       
    }
    $response = array('status' => $status, 'msg' => $msg);
    echo json_encode($response);

}




?>