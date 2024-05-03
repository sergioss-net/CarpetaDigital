<?php 
require_once('../conexion/bd.php');
session_start();
date_default_timezone_set('America/Mexico_City');

$modal = $_POST['modal'];
if(!isset($_POST['Banco'])){
    $Banco = "";
}else{
    $Banco = $_POST['Banco'];
}
if(!isset($_POST['Nombres'])){
    $Nombres = "";
}else{
    $Nombres = $_POST['Nombres'];
}
if(!isset($_POST['Ape_paterno'])){
    $Ape_paterno= "";
}else{
    $Ape_paterno = $_POST['Ape_Paterno'];
}
if(!isset($_POST['Ape_Mat'])){
    $Ape_materno = "";
}else{
    $Ape_materno = $_POST['Ape_Mat'];
}
if(!isset($_POST['Razon_Social'])){
    $Razon_social = "";
}else{
    $Razon_social = $_POST['Razon_Social'];
}
if(!isset($_POST['Tipo_Persona'])){
    $Tipo_persona = "";
}else{
    $Tipo_persona = $_POST['Tipo_Persona'];
}

if(!isset($_POST['Mes_'.$modal])){
    $ano = "";
    $mes = "";
}else{
    $fecha = $_POST['Mes_'.$modal];
    $partes = explode("-", $fecha);
    $ano = $partes[0]; // Obtener el año
    $mes = $partes[1]; // Obtener el mes
}
if(!isset($_POST['persona'])){
    $persona = "";
}else{
    $persona = $_POST['persona'];
}

$Empresa = $_POST['empresa'];
$nivel = $_POST['nivel'];
$Observaciones = $_POST['Observaciones_'.$modal];
$id_carpeta = $_POST['id_carpeta'];
$Tipo_documento = $_POST['Tipo_documento'];
$Usuario = $_SESSION['usuario']['Usuario'];
$FechaOpe = date('Y-m-d');
$HoraOpe = date('H:i:s');
$Estado = 1;

$query = "SELECT Direccion FROM [dbo].[Carpetas] WHERE id_carpeta = :id_carpeta";
$consulta_carpeta = $conn_bd->prepare($query);
$consulta_carpeta->bindParam(':id_carpeta',$id_carpeta);
$consulta_carpeta->execute();

$result_consulta_carpeta = $consulta_carpeta->fetch(PDO::FETCH_ASSOC);
$Ruta_carpeta = $result_consulta_carpeta['Direccion'];


if(file_exists($Ruta_carpeta)){
    
    if (isset($_FILES["Archivo"]) && $_FILES["Archivo"]["error"] == 0) {
        
        $Archivo_nombre = $_FILES['Archivo']['name'];
        $ruta_temporal = $_FILES['Archivo']['tmp_name'];
        $type = $_FILES['Archivo']['type'];
        
        $ruta_destino = $Ruta_carpeta .'/'.$Archivo_nombre;
        if (file_exists($ruta_destino)) {
            $segundos = date('s');
            $nombre_secundario = $segundos.$Archivo_nombre;
            $ruta_Secundaria = $Ruta_carpeta.'/'.$segundos.$Archivo_nombre;
            if(move_uploaded_file($_FILES["Archivo"]["tmp_name"], $ruta_Secundaria)){
                $query = "INSERT INTO [dbo].[Detalle_Archivos] ([Usuario],[Nombre_documento],[Tipo_Documento],[Observaciones],[FechOpe],[HoraOpe],[id_carpeta],[nivel],[id_empresa],[Estado],[Razon_Social],[Tipo_Persona],[Nombres],[Ape_paterno],[Ape_materno],[Ruta],[Mes],[Año],[Banco],[Personal]) VALUES (:Usuario,:Nombre_archivo,:Tipo_Archivo,:Observaciones,:FechOpe,:HoraOpe,:id_carpeta,:nivel,:id_empresa,:Estado,:Razon_social,:Tipo_persona,:Nombres,:Ape_paterno,:Ape_materno,:ruta,:mes,:ano,:banco,:personal)";
                $insert_documento = $conn_bd->prepare($query);
                $insert_documento->bindParam('Usuario',$Usuario);
                $insert_documento->bindParam('Nombre_archivo',$nombre_secundario);
                $insert_documento->bindParam('Tipo_Archivo',$Tipo_documento);
                $insert_documento->bindParam('Observaciones',$Observaciones);
                $insert_documento->bindParam('FechOpe',$FechaOpe);
                $insert_documento->bindParam('HoraOpe',$HoraOpe);
                $insert_documento->bindParam('id_carpeta',$id_carpeta);
                $insert_documento->bindParam('nivel',$nivel);
                $insert_documento->bindParam('id_empresa',$Empresa);
                $insert_documento->bindParam('Estado',$Estado);
                $insert_documento->bindParam('Razon_social',$Razon_social);
                $insert_documento->bindParam('Tipo_persona',$Tipo_persona);
                $insert_documento->bindParam('Nombres',$Nombres);
                $insert_documento->bindParam('Ape_paterno',$Ape_paterno);
                $insert_documento->bindParam('Ape_materno',$Ape_materno);
                $insert_documento->bindParam('ruta',$Ruta_carpeta);
                $insert_documento->bindParam('mes',$mes);
                $insert_documento->bindParam('ano',$ano);
                $insert_documento->bindParam('banco',$Banco);
                $insert_documento->bindParam('personal',$persona);


                if($insert_documento->execute()){
                    $arrData = array('status' => true,'msg'=>'SE AGREGO CON EXITO');
                    echo json_encode($arrData);
                    die;
                }else{
                    $arrData = array('status' => false,'msg'=>'NO SE PUDO AGREGAR VERIFIQUE NUEVAMENTE LOS DATOS');
                    echo json_encode($arrData);
                    die;
                }
            }else{
                $arrData = array('status' => false,'msg'=>'NO SE PUDO ALMACENAR EL ARCHIVO, INTENTELO DE NUEVO.');
                echo json_encode($arrData);
                die;
            } 



        }else{
            if(move_uploaded_file($_FILES["Archivo"]["tmp_name"], $ruta_destino)){
                $query = "INSERT INTO [dbo].[Detalle_Archivos] ([Usuario],[Nombre_documento],[Tipo_Documento],[Observaciones],[FechOpe],[HoraOpe],[id_carpeta],[nivel],[id_empresa],[Estado],[Razon_Social],[Tipo_Persona],[Nombres],[Ape_paterno],[Ape_materno],[Ruta],[Mes],[Año],[Banco],[Personal]) VALUES (:Usuario,:Nombre_archivo,:Tipo_Archivo,:Observaciones,:FechOpe,:HoraOpe,:id_carpeta,:nivel,:id_empresa,:Estado,:Razon_social,:Tipo_persona,:Nombres,:Ape_paterno,:Ape_materno,:ruta,:mes,:ano,:banco,:personal)";

                $insert_documento = $conn_bd->prepare($query);
                $insert_documento->bindParam('Usuario',$Usuario);
                $insert_documento->bindParam('Nombre_archivo',$Archivo_nombre);
                $insert_documento->bindParam('Tipo_Archivo',$Tipo_documento);
                $insert_documento->bindParam('Observaciones',$Observaciones);
                $insert_documento->bindParam('FechOpe',$FechaOpe);
                $insert_documento->bindParam('HoraOpe',$HoraOpe);
                $insert_documento->bindParam('id_carpeta',$id_carpeta);
                $insert_documento->bindParam('nivel',$nivel);
                $insert_documento->bindParam('id_empresa',$Empresa);
                $insert_documento->bindParam('Estado',$Estado);
                $insert_documento->bindParam('Razon_social',$Razon_social);
                $insert_documento->bindParam('Tipo_persona',$Tipo_persona);
                $insert_documento->bindParam('Nombres',$Nombres);
                $insert_documento->bindParam('Ape_paterno',$Ape_paterno);
                $insert_documento->bindParam('Ape_materno',$Ape_materno);
                $insert_documento->bindParam('ruta',$Ruta_carpeta);
                $insert_documento->bindParam('mes',$mes);
                $insert_documento->bindParam('ano',$ano);
                $insert_documento->bindParam('banco',$Banco);
                $insert_documento->bindParam('personal',$peronsa);

                if($insert_documento->execute()){
                    $arrData = array('status' => true,'msg'=>'SE AGREGO CON EXITO');
                    echo json_encode($arrData);
                    die;
                }else{
                    $arrData = array('status' => false,'msg'=>'NO SE PUDO AGREGAR VERIFIQUE NUEVAMENTE LOS DATOS');
                    echo json_encode($arrData);
                    die;
                }
            }else{
                $arrData = array('status' => false,'msg'=>'NO SE PUDO ALMACENAR EL ARCHIVO, INTENTELO DE NUEVO.');
                echo json_encode($arrData);
                die;
            } 
        } 
    }else{
        $arrData = array('status' => false,'msg'=>'EL ARCHIVO ES OBLIGATORIO');
        echo json_encode($arrData);
        die;
    }
}else{
    $arrData = array('status' => false,'msg'=>'PROBLEMAS EN LA RUTA DE ALMACENAMIENTO');
    echo json_encode($arrData);
    die;
}



?>