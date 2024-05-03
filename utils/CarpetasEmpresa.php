<?php 

    function getCarpetas(int $id_empresa,$nivel,$conn_bd){
       
        $query = "SELECT * FROM  [dbo].[Carpetas] WHERE id_empresa = $id_empresa AND Nivel = $nivel";
        $consulta = $conn_bd->prepare($query);
        $consulta->execute();
        $result_consulta = $consulta->fetchAll(PDO::FETCH_ASSOC); 
        return $result_consulta;
    }
    function subcarpetas(int $id_carpeta,$nivel,$id_empresa,$conn_bd){
       
        $query = "SELECT * FROM  [dbo].[Carpetas] WHERE id_subcarpeta = $id_carpeta AND Nivel = $nivel AND id_empresa = $id_empresa";
        $consulta = $conn_bd->prepare($query);
        $consulta->execute();
        $result_consulta = $consulta->fetchAll(PDO::FETCH_ASSOC); 
        return $result_consulta;
    }
    
?>