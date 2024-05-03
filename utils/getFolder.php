<?php
require_once '../conexion/bd.php';

class ShowFolders
{
    private $dbConnection;

    public function __construct($dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    public function consultarCarpetas()
    {
        try {
            $query = "SELECT * FROM Carpetas_Prueba";
            $statement = $this->dbConnection->prepare($query);
            $statement->execute();
            $carpetas = $statement->fetchAll(PDO::FETCH_ASSOC);

            return $carpetas;
        } catch (PDOException $e) {
            echo "Error al ejecutar la consulta: " . $e->getMessage();
            return false;
        }
    }
}

$showFolders = new ShowFolders($conn_bd);
$carpetas = $showFolders->consultarCarpetas();


echo json_encode($carpetas);
?>
