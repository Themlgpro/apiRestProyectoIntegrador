<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//obtener todos los usuarios

$app->get('/api/ventas', function(Request $request, Response $response){

	$consulta = 'SELECT * FROM venta';

	try{

		$db = new db();

		$db = $db->conectar();
		$ejecutar = $db->query($consulta);
		$ventas = $ejecutar->fetchAll(PDO::FETCH_OBJ);
		$db = null;

		echo json_encode($ventas);

	}catch(PDOExcepetion $e){
		//echo '{"error": {"text: '.$e->getMessage().'}';
	}

}); 

$app->get('/api/ventas/{id}', function(Request $request, Response $response){

	$id = $request -> getAttribute('id');

	$consulta = "SELECT * FROM venta WHERE id='$id'";


	try{

		$db = new db();

		$db = $db->conectar();
		$ejecutar = $db->query($consulta);
		$venta = $ejecutar->fetchAll(PDO::FETCH_OBJ);
		$db = null;

		echo json_encode($venta);

	}catch(PDOExcepetion $e){
		//echo '{"error": {"text: '.$e->getMessage().'}';
	}

}); 

$app->post('/api/ventas/agregar', function(Request $request, Response $response){

	$cedCliente = $request -> getParam('cedCliente');
	$userId = $request -> getParam('userId');
	$fecha = $request -> getParam('fecha');
	$valor = $request -> getParam('valor');

	$consulta = "INSERT INTO venta (cedCliente, userId, fecha, valor) VALUES (:cedCliente,:userId,:fecha, :valor)";


	try{

		$db = new db();

		$db = $db->conectar();
		$stmt = $db->prepare($consulta);
		$stmt -> bindParam(':cedCliente',$cedCliente);
		$stmt -> bindParam(':userId',$userId);
		$stmt -> bindParam(':fecha',$fecha);
		$stmt -> bindParam(':valor',$valor);
		$stmt -> execute();
		echo '{"notice": {"text:"  "Venta Registrada"'; 

	}catch(PDOExcepetion $e){
		//echo '{"error": {"text: '.$e->getMessage().'}';
	}

});

$app->put('/api/ventas/actualizar/{id}', function(Request $request, Response $response){

	$id = $request->getAttribute('id');
	$cedCliente = $request -> getParam('cedCliente');
	$userId = $request -> getParam('userId');
	$fecha = $request -> getParam('fecha');
	$valor = $request -> getParam('valor');

	$consulta = "UPDATE venta SET
						cedCliente           =:cedCliente,
						userId           =:userId,
					 	fecha         =:fecha,
					 	valor         =:valor, 

					WHERE id = $id";




	try{

		$db = new db();

		$db = $db->conectar();
		$stmt = $db->prepare($consulta);
		$stmt -> bindParam(':cedCliente',$cedCliente);
		$stmt -> bindParam(':userId',$userId);
		$stmt -> bindParam(':fecha',$fecha);
		$stmt -> bindParam(':valor',$valor);
		$stmt -> execute();
		echo '{"notice": {"text:"  "Venta actualizada"'; 

	}catch(PDOExcepetion $e){
		//echo '{"error": {"text: '.$e->getMessage().'}';
	}

});

$app->delete('/api/ventas/borrar/{id}', function(Request $request, Response $response){

	$id = $request -> getAttribute('id');

	$consulta = "DELETE FROM venta WHERE id='$id'";


	try{

		$db = new db();

		$db = $db->conectar();
		$stmt = $db->prepare($consulta);
		$stmt -> execute();
		$db = null;

		echo '{"notice": {"text":"venta eliminada"}';

	}catch(PDOExcepetion $e){
		//echo '{"error": {"text: '.$e->getMessage().'}';
	}

});