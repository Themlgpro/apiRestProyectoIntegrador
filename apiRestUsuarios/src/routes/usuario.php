<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//obtener todos los usuarios

$app->get('/api/usuario', function(Request $request, Response $response){

	$consulta = 'SELECT * FROM usuario';

	try{

		$db = new db();

		$db = $db->conectar();
		$ejecutar = $db->query($consulta);
		$usuarios = $ejecutar->fetchAll(PDO::FETCH_OBJ);
		$db = null;

		echo json_encode($usuarios);

	}catch(PDOExcepetion $e){
		//echo '{"error": {"text: '.$e->getMessage().'}';
	}

}); 

$app->get('/api/usuario/{id}', function(Request $request, Response $response){

	$id = $request -> getAttribute('id');

	$consulta = "SELECT * FROM usuario WHERE id='$id'";


	try{

		$db = new db();

		$db = $db->conectar();
		$ejecutar = $db->query($consulta);
		$usuario = $ejecutar->fetchAll(PDO::FETCH_OBJ);
		$db = null;

		echo json_encode(usuario);

	}catch(PDOExcepetion $e){
		//echo '{"error": {"text: '.$e->getMessage().'}';
	}

}); 

$app->post('/api/usuario/agregar', function(Request $request, Response $response){

	$id = $request -> getParam('id');
	$nombre = $request -> getParam('nombre');
	$pass = $request -> getParam('pass');
	$area = $request -> getParam('area');

	$consulta = "INSERT INTO usuario (id, pass, area, nombre) VALUES (:id, :pass,:area,:nombre)";


	try{

		$db = new db();

		$db = $db->conectar();
		$stmt = $db->prepare($consulta);
		$stmt -> bindParam(':id',$id);
		$stmt -> bindParam(':pass',$pass);
		$stmt -> bindParam(':area',$area);
		$stmt -> bindParam(':nombre',$nombre);
		$stmt -> execute();
		

	}catch(PDOExcepetion $e){
		
	}

});

$app->put('/api/usuario/actualizar/{id}', function(Request $request, Response $response){

	$id = $request->getAttribute('id');
	$nombre = $request -> getParam('nombre');
	$pass = $request -> getParam('pass');
	$area = $request -> getParam('area');

	$consulta = "UPDATE usuario SET
						pass           =:pass,
						area           =:area,
					 	nombre         =:nombre,

					WHERE id = $id";

	try{

		$db = new db();

		$db = $db->conectar();
		$stmt = $db->prepare($consulta);
		$stmt -> bindParam(':pass',$pass);
		$stmt -> bindParam(':area',$area);
		$stmt -> bindParam(':nombre',$nombre);
		$stmt -> execute();
		echo '{"notice": {"text:"  "Cliente agregado"'; 

	}catch(PDOExcepetion $e){
		//echo '{"error": {"text: '.$e->getMessage().'}';
	}

});

$app->delete('/api/usuario/borrar/{id}', function(Request $request, Response $response){

	$id = $request -> getAttribute('id');

	$consulta = "DELETE FROM usuario WHERE id='$id'";


	try{

		$db = new db();

		$db = $db->conectar();
		$stmt = $db->prepare($consulta);
		$stmt -> execute();
		$db = null;

		echo '{"notice": {"text":"Cliente eliminado"}';

	}catch(PDOExcepetion $e){
		//echo '{"error": {"text: '.$e->getMessage().'}';
	}

}); 