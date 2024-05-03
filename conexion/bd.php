<?php
// Conexion Productiva
// Conexion Productiva
$rutaServidor = "158.69.113.62\Nexen_2022"; //serverName\instanceName
$user="sa";
$pass="#Nexen_2023*10/21.#";
$nombreBaseDeDatos="Carpetas_Digitales";

$conn_bd = new PDO("sqlsrv:server=$rutaServidor;database=$nombreBaseDeDatos",$user, $pass);
$conn_bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>


