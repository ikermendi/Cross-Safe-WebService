<?php

// load Tonic library
require_once 'lib/tonic.php';
require_once 'task/Incidencia.php';
require_once 'task/Estadisticas.php';

// handle request
$request = new Request();
// handle request
$request = new Request(array('baseUri' => '/idek_cross'));
try {
    $resource = $request->loadResource();
    $response = $resource->exec($request);

} catch (ResponseException $e) {
    switch ($e->getCode()) {
    case Response::UNAUTHORIZED:
        $response = $e->response($request);
        break;
    default:
        $response = $e->response($request);
    }
}
$response->output();

