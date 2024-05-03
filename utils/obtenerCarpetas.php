<?php 
$query = "SELECT Empresa,id_Empresa,color FROM [dbo].[Empresas] WHERE Estatus = 'A'";
$consulta = $conn_bd->prepare($query);
$consulta->execute();
$result_consulta = $consulta->fetchAll(PDO::FETCH_ASSOC);

?>