<?php 

require_once "DatabasePDO.php"; 
require_once "Model.php";

class EmpleadoModel extends Model {

	
	public static function getEmployeeId($idmovil)
	{	
		parent::connect();
		parent::utf8();
				
		try {
			$statement = parent::$dbConn->prepare(
		    "SELECT idempleado FROM empleado WHERE idmovil = :id");
			$statement->bindValue(":id", $idmovil, PDO::PARAM_INT);
			$statement->execute();
		    $id = $statement->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
		    echo "Error!: " . $e->getMessage();
		    die();
		}
		return $id;
	}
}