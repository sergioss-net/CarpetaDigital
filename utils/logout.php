<?php
require('../conexion/bd.php');
session_start();
$user = $_POST['username'];
$query_desconect = "SELECT * FROM [dbo].[Conexion_Usuario] WHERE Usuario = :usuario AND Estatus = 1";
$desconect = $conn_bd->prepare($query_desconect);
$desconect->bindParam(':usuario',$user,PDO::PARAM_STR);
$desconect->execute();

$result_Desc = $desconect->fetch(PDO::FETCH_ASSOC);
if(!empty($result_Desc)){
    $FechConect = date('Y-m-d');
    $HoraConect = date('H:i:s');
    $id_conexion= $result_Desc['id_conexion'];
    $query_cerrar = "UPDATE [dbo].[Conexion_Usuario] SET Estatus = 0, Fecha_Fin_Conexion = :fecha_conexion,Hora_Fin_Conexion =:hora_conexion WHERE Usuario = :usuario AND id_conexion = :conexion";
    $cerrar = $conn_bd->prepare($query_cerrar);
    $cerrar->bindParam(':fecha_conexion', $FechConect);
    $cerrar->bindParam(':hora_conexion', $HoraConect);
    $cerrar->bindParam(':usuario',$user,PDO::PARAM_STR);
    $cerrar->bindParam(':conexion',$id_conexion);
    if($cerrar->execute()){
        
        session_unset();
        session_destroy();//destruye la sesion
        $FechConect = date('Y-m-d');
        $HoraConect = date('H:i:s');
        $Estatus = 1;
        $insert_query_conexion = "INSERT INTO [dbo].[Conexion_Usuario] (Usuario, Fecha_Conexion, Hora_Conexion, Estatus) VALUES(:usuario, :fecha_conexion, :hora_conexion, :estatus)";

        $stmt = $conn_bd->prepare($insert_query_conexion);
        $stmt->bindParam(':usuario', $user);
        $stmt->bindParam(':fecha_conexion', $FechConect);
        $stmt->bindParam(':hora_conexion', $HoraConect);
        $stmt->bindParam(':estatus', $Estatus);
        if($stmt->execute()){
            $user_data = "SELECT * FROM [dbo].[Usuarios_Login] L INNER JOIN [dbo].[Conexion_Usuario] C ON L.Usuario = C.Usuario WHERE L.Usuario = :usuario AND C.Estatus = 1";
            $vla_user = $conn_bd->prepare($user_data);
            $vla_user->bindParam(':usuario',$user,PDO::PARAM_STR);
            $vla_user->execute();
            $result_user = $vla_user->fetch(PDO::FETCH_ASSOC);
            $select_exis_sesion = "SELECT * FROM [dbo].[Conexion_Usuario] C  INNER JOIN [dbo].[Usuarios_Login] U ON C.Usuario = U.Usuario INNER JOIN [dbo].[Usuarios] D ON D.Usuario = U.Usuario  WHERE U.Usuario = :usuario AND C.Estatus = 1";
            $select_sesion = $conn_bd->prepare($select_exis_sesion);
            $select_sesion->bindParam(':usuario',$user,PDO::PARAM_STR);
            $select_sesion->execute();
            $result_exist = $select_sesion->fetch(PDO::FETCH_ASSOC);
            session_start();
            $_SESSION['userData']= $result_exist;
            $_SESSION['usuario'] = $result_user;
            $_SESSION['login'] = true;
            $arrData = array('status' =>true, 'msg'=>'INICIANDO');
            echo json_encode($arrData);
        }else{
            $arrData = array('status' =>false, 'msg'=>'PROBLEMAS AL INICIAR SESION.');
            echo json_encode($arrData);
        }
    } 
}

?>