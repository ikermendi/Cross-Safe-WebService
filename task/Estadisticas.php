<?php 

require_once "./pdo/EstadisticasModel.php"; 

/**
 * @uri /idnodo/{id_nodo}/numpasos/{num}/sensores/{sensores}
 */

class Estadisticas extends Resource {

 	public static function get($request, $id_nodo, $num, $sensores){

				$response = new Response($request);
				$response->addHeader('Content-type', 'application/json');
				
				//$result = IncidenciaModel::getAllIncidenciasEmployee($id_emp);
				
				$response->code = Response::OK;
				$response->body = var_dump($sensores);
				error_log(print_r($sensores, true));
				return $response;	
	}
}