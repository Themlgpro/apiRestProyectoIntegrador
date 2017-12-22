<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
use \Slim\App;

$app = new \Slim\App;

$app->get('/listar', 'showData');
$app->post('/editar', 'addData');


function addData(Request $request, Response $response)
{
    //Taking the data
    $idProducto = $request->getParam("id");
    $cantidadFaltante = $request->getParam("cantidad");
    $nombre = $request->getParam("nombre");
// connect
    $m = new MongoDB\Client;

// select your database
    $db = $m->productos;
    $collection = $db->agotados;

    $insertOneResult = $collection->insertOne([
        'nombre'=>$nombre, 'cantidadFaltante' => $cantidadFaltante, 'idProducto' => $idProducto
    ]);

    echoResponse(200, $response);
}

function showData(Request $request, Response $response)
{
// connect
    $m = new MongoDB\Client("mongodb://localhost:27017");

// select your database
    $db = $m->productos;
    $collection = $db->agotados;

    $getAll=$collection->find();
    $response = iterator_to_array($getAll);
    echoResponse(200, $response);
}



function echoResponse($status_code, $response) {
    $api = new \Slim\App;
    // Http response code
    $api->status($status_code);
     
    // setting response content type to json
    $api->contentType('application/json');
     
    echo json_encode($response);

}
?>