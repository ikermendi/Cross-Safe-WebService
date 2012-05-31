<?php 

require_once "./pdo/IncidenciaModel.php"; 


/**
 * @uri /incidencias/{id_emp}
 */

class IncidenciaVer extends Resource {

 	public static function get($request, $id_emp){

				$response = new Response($request);
				$response->addHeader('Content-type', 'application/json');
				
				$result = IncidenciaModel::getAllIncidenciasEmployee($id_emp);
				
				$response->code = Response::OK;
				$response->body = json_encode($result);
				return $response;	
	}
}

/**
 * @uri /incidencia/{id_inci}/estado/{estado}/disp/{id_disp}/id/{id_android}
 */

class IncidenciaInsertar extends Resource {

 	public static function get($request, $id_inci, $estado, $id_disp, $id_android){

				$response = new Response($request);
				$response->addHeader('Content-type', 'application/json');
				
				$result = IncidenciaModel::actualizarEstadoIncidencia($id_inci, $estado, $id_disp, $id_android);
				
				$response->code = Response::OK;
				$response->body = $id_inci . " " . $estado;

				return $response;	
	}
}

/**
 * @uri /incidencia/{id_disp}/aviso/{aviso}
 */

class IncidenciaNotificacion extends Resource {

 	public static function get($request, $id_disp, $aviso) {
		
		$response = new Response($request);
		$response->addHeader('Content-type', 'application/json');
		$result = IncidenciaModel::insertIncidencia($id_disp, $aviso);
		
		$response->code = Response::OK;
	
		return $response;
	}
}