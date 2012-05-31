<?php 

require_once "DatabasePDO.php"; 
require_once "Model.php";
require_once "DispositivoModel.php";
require_once "EmpleadoModel.php";

class IncidenciaModel extends Model {
	
	public $idincidencia;
	public $descripcion;
	public $estado;
	public $hora;
	public $dispositivo;
	
	public static function getAllIncidenciasEmployee($idmovil)
	{	
		parent::connect();
		parent::utf8();
		
		$inci = new IncidenciaModel();
		
		try {
			$empleado = EmpleadoModel::getEmployeeId($idmovil);
			$statement = parent::$dbConn->prepare(
		    "SELECT * FROM incidencia WHERE idempleado = :id");
			$statement->bindValue(":id", $empleado['idempleado'], PDO::PARAM_INT);
			$statement->execute();
		    $inci = $statement->fetchAll(PDO::FETCH_OBJ);
			for ($i=0; $i < count($inci); $i++) { 
				$inci[$i]->dispositivo = DispositivoModel::getDispositivo($inci[$i]->iddispositivo);
				$tmp = self::getEstado($inci[$i]->idestadoInci);
				$inci[$i]->estado = $tmp['estado'];
				unset($inci[$i]->iddispositivo);
				unset($inci[$i]->idestadoInci);
				unset($inci[$i]->idempleado);
			}	
		} catch (PDOException $e) {
		    echo "Error!: " . $e->getMessage();
		    die();
		}
		return $inci;
	}
	
	public static function insertIncidencia($id_disp, $aviso)
	{	
		parent::connect();
		parent::utf8();
			
		try {
			$emp = DispositivoModel::getEmpleadoDispositivo($id_disp);
			$statement = parent::$dbConn->prepare("INSERT INTO  incidencia (idincidencia, descripcion, hora, idempleado, iddispositivo, idestadoInci, aviso) VALUES ('',  '$aviso',  '',  '$emp->idempleado',  '$id_disp',  '1', 0);");
			$statement->execute();
			DispositivoModel::cambiarAveriado($id_disp);
		} catch (PDOException $e) {
		    echo "Error!: " . $e->getMessage();
		    die();
		}
	}
	
	public static function actualizarEstadoIncidencia($id_inci, $estado, $id_disp, $id_android)
	{	
		parent::connect();
		parent::utf8();
		
		try {

			$id_usu = EmpleadoModel::getEmployeeId($id_android);
			$num = DispositivoModel::getNumInciDispositivo($id_disp, $id_usu['idempleado']);
			
			if (count($num) == 1) {
				DispositivoModel::cambiarOK($id_disp);
			}
			
			$est = self::getEstadoInciId($estado);
			$statement = parent::$dbConn->prepare("UPDATE incidencia SET idestadoInci = :estado WHERE incidencia.idincidencia = :id");
			$statement->bindValue(":id", $id_inci, PDO::PARAM_INT);
			$statement->bindValue(":estado", $est['idestado'], PDO::PARAM_INT);
			$statement->execute();
		} catch (PDOException $e) {
		    echo "Error!: " . $e->getMessage();
		    die();
		}
	}
	
	public static function getEstadoInciId($estado)
	{	
		parent::connect();
		parent::utf8();
		
		try {
			$statement = parent::$dbConn->prepare("SELECT idestado FROM estadoinci WHERE estado = :estado");
			$statement->bindValue(":estado", $estado, PDO::PARAM_STR);
			$statement->execute();
		    $est = $statement->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
		    echo "Error!: " . $e->getMessage();
		    die();
		}
		return $est;		
	}
	
	private static function getEstado($id)
	{	
		parent::connect();
		parent::utf8();
		
		try {
			$statement = parent::$dbConn->prepare(
		    "SELECT * FROM estadoinci WHERE idestado = :id");
			$statement->bindValue(":id", $id, PDO::PARAM_INT);
			$statement->execute();
		    $est = $statement->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
		    echo "Error!: " . $e->getMessage();
		    die();
		}
		return $est;		
	} 
}