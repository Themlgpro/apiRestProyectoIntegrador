<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//obtener todos los usuarios

$app->get('/api/clientes', function(Request $request, Response $response){

	$consulta = 'SELECT * FROM cliente';

	try{

		$db = new db();

		$db = $db->conectar();
		$ejecutar = $db->query($consulta);
		$clientes = $ejecutar->fetchAll(PDO::FETCH_OBJ);
		$db = null;

		echo json_encode($clientes);

	}catch(PDOExcepetion $e){
		//echo '{"error": {"text: '.$e->getMessage().'}';
	}

}); 

$app->get('/api/clientes/{id}', function(Request $request, Response $response){

	$id = $request -> getAttribute('id');

	$consulta = "SELECT * FROM cliente WHERE cedula='$id'";


	try{

		$db = new db();

		$db = $db->conectar();
		$ejecutar = $db->query($consulta);
		$cliente = $ejecutar->fetchAll(PDO::FETCH_OBJ);
		$db = null;

		echo json_encode($cliente);

	}catch(PDOExcepetion $e){
		//echo '{"error": {"text: '.$e->getMessage().'}';
	}

}); 

$app->post('/api/clientes/agregar', function(Request $request, Response $response){

	$cedula = $request -> getParam('cedula');
	$nombres = $request -> getParam('nombres');
	$apellidos = $request -> getParam('apellidos');
	$direccion = $request -> getParam('direccion');
	$telefono = $request -> getParam('telefono');

	$consulta = "INSERT INTO cliente (cedula, nombres, apellidos, direccion, telefono) VALUES (:cedula,:nombres,:apellidos, :direccion,:telefono)";


	try{

		$db = new db();

		$db = $db->conectar();
		$stmt = $db->prepare($consulta);
		$stmt -> bindParam(':cedula',$cedula);
		$stmt -> bindParam(':nombres',$nombres);
		$stmt -> bindParam(':apellidos',$apellidos);
		$stmt -> bindParam(':direccion',$direccion);
		$stmt -> bindParam(':telefono',$telefono);
		$stmt -> execute();
		echo '{"notice": {"text:"  "cliente Registrado"'; 

	}catch(PDOExcepetion $e){
		//echo '{"error": {"text: '.$e->getMessage().'}';
	}

});

$app->put('/api/clientes/actualizar/{id}', function(Request $request, Response $response){

	$id = $request->getAttribute('id');
	$nombres = $request -> getParam('nombres');
	$apellidos = $request -> getParam('apellidos');
	$direccion = $request -> getParam('direccion');
	$telefono = $request -> getParam('telefono');

	$consulta = "UPDATE cliente SET
						nombres           =:nombres,
					 	apellidos         =:apellidos,
					 	direccion         =:direccion,
					 	telefono          =:telefono, 

					WHERE cedula = $id";

	try{

		$db = new db();

		$db = $db->conectar();
		$stmt = $db->prepare($consulta);
		$stmt -> bindParam(':nombres',$nombres);
		$stmt -> bindParam(':apellidos',$apellidos);
		$stmt -> bindParam(':direccion',$direccion);
		$stmt -> bindParam(':telefono',$telefono);
		$stmt -> execute();
		echo '{"notice": {"text:"  "cliente actualizado"'; 

	}catch(PDOExcepetion $e){
		//echo '{"error": {"text: '.$e->getMessage().'}';
	}

});

$app->delete('/api/clientes/borrar/{id}', function(Request $request, Response $response){

	$id = $request -> getAttribute('id');

	$consulta = "DELETE FROM cliente WHERE cedula='$id'";


	try{

		$db = new db();

		$db = $db->conectar();
		$stmt = $db->prepare($consulta);
		$stmt -> execute();
		$db = null;

		echo '{"notice": {"text":"cliente eliminado"}';

	}catch(PDOExcepetion $e){
		//echo '{"error": {"text: '.$e->getMessage().'}';
	}

});