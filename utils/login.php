<?php
require('../conexion/bd.php');


if($_POST){
    $user =  trim($_POST['username']);
    $pass =  trim($_POST['password']);

    if($user === "" || $pass === ""){
        $arrData = array('status' =>false,'msg' =>'TODOS LOS CAMPOS SON OBLIGATORIOS.');
        echo json_encode($arrData);
        
    }else{

        $query_conexion = "SELECT * FROM [dbo].[Conexion_Usuario] WHERE Usuario = :usuario AND Estatus = 1";
        $conexion = $conn_bd->prepare($query_conexion);
        $conexion->bindParam(':usuario', $user, PDO::PARAM_STR);
        $conexion->execute();
        $result_conexion = $conexion->fetch(PDO::FETCH_ASSOC);

        if(!empty($result_conexion)){
            $arrData = array('status' =>false,'msg' => '<strong>¡YA EXISTE UNA SESION ACTIVA!</strong>.<br> SE CERRARAN TODAS LAS SESIONES AL INICIAR NUEVAMENTE.');
            echo json_encode($arrData);
        }else{
           $query_User_exit = "SELECT * FROM [dbo].[Usuarios] WHERE Usuario = :usuario"; 
           $valida = $conn_bd->prepare($query_User_exit);
           $valida->bindParam(':usuario', $user,PDO::PARAM_STR);
           $valida->execute();
           $result_valida= $valida->fetch(PDO::FETCH_ASSOC);
           
           if(empty($result_valida)){
                $arrData = array('status' => false,'msg' =>'EL USUARIO NO EXISTE O ES INCORRECTO.','dato'=>3);
                echo json_encode($arrData);
           }else{
                if($result_valida['Estatus'] === '0'){
                    $arrData = array('status' => false,'msg' =>'EL USUARIO ESTA INCATIVO.', 'dato' => 1);
                    echo json_encode($arrData);
                }else{
                   $val_Pass = "SELECT * FROM [dbo].[Usuarios_Login] WHERE Usuario = :usuario";
                   $com_pass = $conn_bd->prepare($val_Pass);
                   $com_pass->bindParam(':usuario',$user,PDO::PARAM_STR);
                   $com_pass->execute();
                   $result_com = $com_pass->fetch(PDO::FETCH_ASSOC);
                   if($result_com['Password'] === $pass){
                        session_start();
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
                            $_SESSION['usuario'] = $result_user;

                            $select_exis_sesion = "SELECT * FROM [dbo].[Conexion_Usuario] C  INNER JOIN [dbo].[Usuarios_Login] U ON C.Usuario = U.Usuario INNER JOIN [dbo].[Usuarios] D ON D.Usuario = U.Usuario  WHERE U.Usuario = :usuario AND C.Estatus = 1";
                            $select_sesion = $conn_bd->prepare($select_exis_sesion);
                            $select_sesion->bindParam(':usuario',$user,PDO::PARAM_STR);
                            $select_sesion->execute();
                            $result_exist = $select_sesion->fetch(PDO::FETCH_ASSOC);
                            $_SESSION['userData']= $result_exist;
                            
                            $_SESSION['login'] = true;
                            $arrData = array('status' =>true, 'msg'=>'INICIANDO');
                            echo json_encode($arrData);
                        }else{
                            $arrData = array('status' =>false, 'msg'=>'PROBLEMAS AL INICIAR SESION.');
                            echo json_encode($arrData);
                        }
                   }else{
                        $arrData = array('status' =>false, 'msg'=>'CONTRASEÑA O USUARIO INCORRECTO.','dato'=>2);
                        echo json_encode($arrData);
                   }
                }

           }
        }
    }
}else{
    $arrData = array('status' => false,'msg'=>'PROBLEMAS EN LA PETICION CONTACTAR AL DESARROLLADOR');
    echo json_encode($arrData);
}

?>