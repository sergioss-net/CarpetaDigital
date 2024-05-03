<?php
session_start();
require_once('../conexion/bd.php');


if(isset($_POST['nivel']) && $_POST['nivel'] === '1'){
    
 
    $nivel = trim($_POST['nivel']);
    $usuario = trim($_SESSION['usuario']['Usuario']);
    $id_usuario = trim($_SESSION['usuario']['id_Usuario']);
    $nombre_carpeta = trim(strtoupper($_POST['NombreCarpeta']));
    $id_empresa = trim($_POST['empresa']);
    $color = $_POST['color'];
    $Estatus = 1;
    // valida si existe la carpeta de la empresa si no la crea
    $valida = "SELECT Empresa,Id_Empresa FROM [dbo].[Empresas] WHERE Id_Empresa = :id_empresa";
    $consulta = $conn_bd->prepare($valida);
    $consulta->bindParam(':id_empresa',$id_empresa);
    $consulta->execute();
    $result_consulta = $consulta->fetch(PDO::FETCH_ASSOC);
    $nombre_empresa = $result_consulta['Empresa'];
    $ruta = '../Carpetas/';

    
    if (file_exists($ruta . $nombre_empresa)){
        $SubRuta = $ruta.$nombre_empresa.'/';
        $query = "SELECT * FROM [dbo].[Carpetas] WHERE Nombre_Carpeta = :nombre_carpeta AND id_empresa = :id_empresa";
        $consulta_query = $conn_bd->prepare($query);
        $consulta_query->bindParam(':nombre_carpeta',$nombre_carpeta);
        $consulta_query->bindParam(':id_empresa',$id_empresa);
        $consulta_query->execute();
        $result_Consulta_carpeta = $consulta_query->fetch(PDO::FETCH_ASSOC);

        if(empty($result_Consulta_carpeta)){

            if (file_exists($SubRuta . $nombre_carpeta)) {
                echo "la carpeta ya existe".$nombre_carpeta;
            }else{
                mkdir($SubRuta . $nombre_carpeta, 0777);
                $direccion = $SubRuta . $nombre_carpeta;
                $sql_insert = "INSERT INTO [dbo].[Carpetas] (Nombre_Carpeta,Usuario,id_usuario,id_empresa,color,Nivel,id_subcarpeta,Estatus,Direccion) VALUES (:nombre_carpeta,:usuario,:id_usuario,:id_empresa,:color,:nivel,:id_subcarpeta,:estatus,:direccion)";
                $insert = $conn_bd->prepare($sql_insert);
                $insert->bindParam(':nombre_carpeta',$nombre_carpeta);
                $insert->bindParam(':usuario',$usuario);
                $insert->bindParam(':id_usuario',$id_usuario);
                $insert->bindParam(':id_empresa',$id_empresa);
                $insert->bindParam(':color',$color);
                $insert->bindParam(':nivel',$nivel);
                $insert->bindParam(':id_subcarpeta',$id_subcarpeta);
                $insert->bindParam(':estatus',$Estatus);
                $insert->bindParam(':direccion',$direccion);

                if($insert->execute()){
                    $arrData = array('status' => true,'msg' =>'LA CARPETA SE CREO CORRECTAMENTE');
                    echo json_encode($arrData);
                    die;
                }else{
                    $arrData = array('status' => false,'msg' => 'PROBLEMAS AL CREAR LA CARPETA');
                    echo json_encode($arrData);
                    die;
                }
            }

        }else{
            $arrData = array('status' => false,'msg' => 'LA CARPETA YA EXISTE');
            echo json_encode($arrData);
            die;
        }

    }else{
        $arrData = array('status' => false,'msg' => 'NO EXISTE LA CARPETA DE LA EMPRESA');
        echo json_encode($arrData);
        die;
    }
} else {

    $nivel = trim($_POST['nivel']);
    $id_usuario = trim($_SESSION['usuario']['id_Usuario']);
    $nombre_carpeta = trim(strtoupper($_POST['NombreCarpeta']));
    $id_subcarpeta = trim($_POST['id_carpeta']);
    $id_empresa = trim($_POST['empresa']);
    $color = $_POST['color'];
    $Estatus = 1;
    $usuario = trim($_SESSION['usuario']['Usuario']);

    $valida = "SELECT Empresa,Id_Empresa FROM [dbo].[Empresas] WHERE Id_Empresa = :id_empresa";
    $consulta = $conn_bd->prepare($valida);
    $consulta->bindParam(':id_empresa',$id_empresa);
    $consulta->execute();
    $result_consulta = $consulta->fetch(PDO::FETCH_ASSOC);
    $nombre_empresa = $result_consulta['Empresa'];

    $query = "SELECT * FROM [dbo].[Carpetas] WHERE id_carpeta = :id_carpeta AND Estatus != 0";
    $consutla_subcarpetas = $conn_bd->prepare($query);
    $consutla_subcarpetas->bindParam(':id_carpeta',$id_subcarpeta);
    $consutla_subcarpetas->execute();
    $result_subcarpeta = $consutla_subcarpetas->fetch(PDO::FETCH_ASSOC);

    $nombre_subCarpeta = $result_subcarpeta['Nombre_Carpeta'];
     
    $ruta = '../Carpetas/'.$nombre_empresa.'/'.$nombre_subCarpeta.'/';

    if (file_exists($ruta . $nombre_carpeta)){
        $arrData = array('status' => false,'msg' => 'LA CARPETA YA EXISTE');
        echo json_encode($arrData);
        die;
    }else{

        if($nivel >= 3){
            $consult = "SELECT * FROM [dbo].[Carpetas] WHERE id_carpeta = :id_carpeta";
            $verifica = $conn_bd->prepare($consult);
            $verifica->bindParam(':id_carpeta',$id_subcarpeta);
            $verifica->execute();
            $result_verifica = $verifica->fetch(PDO::FETCH_ASSOC);
            $ruta_completa = $result_verifica['Direccion'];

            $subrutaCompleta = $ruta_completa.'/'. $nombre_carpeta;
            if (file_exists($subrutaCompleta)){
                $arrData = array('status' => false,'msg' => 'LA CARPETA YA EXISTE');
                echo json_encode($arrData);
                die;
            }else{
                if(mkdir($subrutaCompleta, 0777)){
                    $sql_insert = "INSERT INTO [dbo].[Carpetas] (Nombre_Carpeta,Usuario,id_usuario,id_empresa,color,Nivel,id_subcarpeta,Estatus,Direccion) VALUES (:nombre_carpeta,:usuario,:id_usuario,:id_empresa,:color,:nivel,:id_subcarpeta,:estatus,:direccion)";
                    $insert = $conn_bd->prepare($sql_insert);
                    $insert->bindParam(':nombre_carpeta',$nombre_carpeta);
                    $insert->bindParam(':usuario',$usuario);
                    $insert->bindParam(':id_usuario',$id_usuario);
                    $insert->bindParam(':id_empresa',$id_empresa);
                    $insert->bindParam(':color',$color);
                    $insert->bindParam(':nivel',$nivel);
                    $insert->bindParam(':id_subcarpeta',$id_subcarpeta);
                    $insert->bindParam(':estatus',$Estatus);
                    $insert->bindParam(':direccion',$subrutaCompleta);
                    if($insert->execute()){
                        $arrData = array('status' => true,'msg' =>'LA CARPETA SE CREO CORRECTAMENTE');
                        echo json_encode($arrData);
                        die;
                    }else{
                        $arrData = array('status' => false,'msg' => 'PROBLEMAS AL CREAR LA CARPETA');
                        echo json_encode($arrData);
                        die;
                    }
                }
                // else{
                //      print_r($subrutaCompleta);
                //     echo "No ya existe";
                //     die;
                // }
               
                
            }
            
        }else{
            if(mkdir($ruta.$nombre_carpeta, 0777)){
                $rutaSub =$ruta.$nombre_carpeta;
                $sql_insert = "INSERT INTO [dbo].[Carpetas] (Nombre_Carpeta,Usuario,id_usuario,id_empresa,color,Nivel,id_subcarpeta,Estatus,Direccion) VALUES (:nombre_carpeta,:usuario,:id_usuario,:id_empresa,:color,:nivel,:id_subcarpeta,:estatus,:direccion)";
                $insert = $conn_bd->prepare($sql_insert);
                $insert->bindParam(':nombre_carpeta',$nombre_carpeta);
                $insert->bindParam(':usuario',$usuario);
                $insert->bindParam(':id_usuario',$id_usuario);
                $insert->bindParam(':id_empresa',$id_empresa);
                $insert->bindParam(':color',$color);
                $insert->bindParam(':nivel',$nivel);
                $insert->bindParam(':id_subcarpeta',$id_subcarpeta);
                $insert->bindParam(':estatus',$Estatus);
                $insert->bindParam(':direccion',$rutaSub);
                if($insert->execute()){
                    $arrData = array('status' => true,'msg' =>'LA CARPETA SE CREO CORRECTAMENTE');
                    echo json_encode($arrData);
                    die;
                }else{
                    $arrData = array('status' => false,'msg' => 'PROBLEMAS AL CREAR LA CARPETA');
                    echo json_encode($arrData);
                    die;
                }
            }
            print_r($ruta);
            die;
        }
        if(mkdir($ruta.$nombre_carpeta, 0777)){
            
            $sql_insert = "INSERT INTO [dbo].[Carpetas] (Nombre_Carpeta,Usuario,id_usuario,id_empresa,color,Nivel,id_subcarpeta,Estatus) VALUES (:nombre_carpeta,:usuario,:id_usuario,:id_empresa,:color,:nivel,:id_subcarpeta,:estatus)";
            $insert = $conn_bd->prepare($sql_insert);
            $insert->bindParam(':nombre_carpeta',$nombre_carpeta);
            $insert->bindParam(':usuario',$usuario);
            $insert->bindParam(':id_usuario',$id_usuario);
            $insert->bindParam(':id_empresa',$id_empresa);
            $insert->bindParam(':color',$color);
            $insert->bindParam(':nivel',$nivel);
            $insert->bindParam(':id_subcarpeta',$id_subcarpeta);
            $insert->bindParam(':estatus',$Estatus);
            if($insert->execute()){
                $arrData = array('status' => true,'msg' =>'LA CARPETA SE CREO CORRECTAMENTE');
                echo json_encode($arrData);
                die;
            }else{
                $arrData = array('status' => false,'msg' => 'PROBLEMAS AL CREAR LA CARPETA');
                echo json_encode($arrData);
                die;
            }

        }else{
            if (file_exists($ruta . $nombre_carpeta)){
                $arrData = array('status' => false,'msg' => 'LA CARPETA YA EXISTE');
                echo json_encode($arrData);
                die;
            }
            // else{
            //     if(mkdir($ruta.$nombre_carpeta, 0777)){
            //     print_r($ruta);
            //     die; 
            //     }
            // }
        }
        
    }
    
}


?>