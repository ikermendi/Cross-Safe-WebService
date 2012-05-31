<?php 

require_once "DatabasePDO.php"; 
require_once "Model.php"; 

class DispositivoModel extends Model {
	
	public static function getDispositivo($id)
	{	
		parent::connect();
		parent::utf8();
		
		try {
			$statement = parent::$dbConn->prepare(
		    "SELECT * FROM dispositivo WHERE iddispositivo = :id");
			$statement->bindValue(":id", $id, PDO::PARAM_INT);
		    $statement->execute();
		    $disp = $statement->fetch(PDO::FETCH_OBJ);
			$disp->estado = self::getEstadoDispositivo($disp->idestadoDisp);
			$disp->localidad = self::getLocalidadDispositivo($disp->idlocalidad);
			unset($disp->idestadoDisp);
			unset($disp->idlocalidad);
		} catch (PDOException $e) {
		    echo "Error!: " . $e->getMessage();
		    die();
		}
		return $disp;
	}
	
	public static function cambiarAveriado($id_disp)
	{
		try {
			$statement = parent::$dbConn->prepare(
		    "UPDATE dispositivo SET idestadodisp = :estado WHERE iddispositivo = :id");
			$statement->bindValue(":estado", 2, PDO::PARAM_INT);
			$statement->bindValue(":id", $id_disp, PDO::PARAM_INT);
		    $statement->execute();
		} catch (PDOException $e) {
		    echo "Error!: " . $e->getMessage();
		    die();
		}
		return $emp[0];
	}
	
	public static function cambiarOK($id_disp)
	{
		try {
			$statement = parent::$dbConn->prepare(
		    "UPDATE dispositivo SET idestadodisp = :estado WHERE iddispositivo = :id");
			$statement->bindValue(":estado", 1, PDO::PARAM_INT);
			$statement->bindValue(":id", $id_disp, PDO::PARAM_INT);
		    $statement->execute();
		} catch (PDOException $e) {
		    echo "Error!: " . $e->getMessage();
		    die();
		}
		return $emp[0];
	}
	
	private static function getEstadoDispositivo($id_estado)
	{
		try {
			$statement = parent::$dbConn->prepare(
		    "SELECT estado FROM estadodisp WHERE idestadodisp = :id");
			$statement->bindValue(":id", $id_estado, PDO::PARAM_INT);
		    $statement->execute();
		    $estado = $statement->fetch(PDO::FETCH_OBJ);
		} catch (PDOException $e) {
		    echo "Error!: " . $e->getMessage();
		    die();
		}
		return $estado->estado;
	}
	
	private static function getLocalidadDispositivo($id_localidad)
	{
		try {
			$statement = parent::$dbConn->prepare(
		    "SELECT localidad FROM localidad WHERE idlocalidad = :id");
			$statement->bindValue(":id", $id_localidad, PDO::PARAM_INT);
		    $statement->execute();
		    $loc = $statement->fetch(PDO::FETCH_OBJ);
		} catch (PDOException $e) {
		    echo "Error!: " . $e->getMessage();
		    die();
		}
		return $loc->localidad;
	}
	
	public static function getEmpleadoDispositivo($id_disp)
	{
		try {
			$statement = parent::$dbConn->prepare(
		    "SELECT e.idempleado from empleado e inner join sede s on e.idsede = s.idsede inner join  ciudad c on c.idciudad = s.idciudad inner join localidad l on l.idciudad = c.idciudad inner join dispositivo d on d.idlocalidad = l.idlocalidad where d.iddispositivo = :id");
			$statement->bindValue(":id", $id_disp, PDO::PARAM_INT);
		    $statement->execute();
		    $emp = $statement->fetchAll(PDO::FETCH_OBJ);
		} catch (PDOException $e) {
		    echo "Error!: " . $e->getMessage();
		    die();
		}
		return $emp[0];
	}
	
	public static function getNumInciDispositivo($id_disp, $id_usu)
	{
		try {
			$statement = parent::$dbConn->prepare(
		    "select * from incidencia where (iddispositivo = :id) and (idempleado = :id_emp) and (idestadoInci = 1 or idestadoInci = 3)");
			$statement->bindValue(":id", $id_disp, PDO::PARAM_INT);
			$statement->bindValue(":id_emp", $id_usu, PDO::PARAM_INT);
		    $statement->execute();
		    $num_inci = $statement->fetchAll(PDO::FETCH_OBJ);
		} catch (PDOException $e) {
		    echo "Error!: " . $e->getMessage();
		    die();
		}
		return $num_inci;
	}
	
	
}