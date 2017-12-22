<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app= new \Slim\App;


//obtener todos los proveedores

$app->get('/api/proveedores',function(Request $request, Response $response){
	$consulta = 'SELECT * FROM proveedor';

	try{

		$db = new db();
		$db = $db->conectar();
		$ejecutar = $db->query($consulta);
		$proveedores = $ejecutar->fetchAll(PDO::FETCH_OBJ);
		$db = null;

		//data to json
		$response = json_encode($proveedores);
		return $response;
	}catch(PDOException $e){
		echo 'Error' + $e.errorInfo();
	}
});

//adicionar un producto
$app->post('/api/proveedor/add',function(Request $request, Response $response){

	$nit = $request->getParam('nit');
	$nombre = $request->getParam('nombre');
	$direccion = $request->getParam('direccion');
	$telefono = $request->getParam('telefono');


	$consulta = "INSERT INTO proveedor (nit, nombre, direccion, telefono) VALUES (:nit, :nombre, :direccion, :telefono)";

	try{

		$db = new db();
		$db = $db->conectar();
		//preparar la data para ser almacenada
		$stmt = $db->prepare($consulta);
		
		$stmt->bindParam(':nit',$nit);
		$stmt->bindParam(':nombre',$nombre);
		$stmt->bindParam(':direccion',$direccion);
		$stmt->bindParam(':telefono',$telefono);
		$stmt->execute();
		
		return $response;

	}catch(PDOException $e){
		echo 'Error' + $e.errorInfo();
	}
});

$app->put('/api/proveedor/actualizar/{id}', function(Request $request, Response $response){

	$nit = $request->getParam('nit');
	$nombre = $request->getParam('nombre');
	$direccion = $request->getParam('direccion');
	$telefono = $request->getParam('telefono');

	$consulta = "UPDATE proveedoor SET
						nit           =:nit,
						nombre           =:nombre,
					 	direccion         =:direccion,
					 	telefono         =:telefono,

					WHERE nit = $nit";

	try{

		$db = new db();

		$db = $db->conectar();
		$stmt = $db->prepare($consulta);
		$stmt -> bindParam(':nit',$nit);
		$stmt -> bindParam(':nombre',$nombre);
		$stmt -> bindParam(':direccion',$direccion);
		$stmt -> bindParam(':telefono',$telefono);
		$stmt -> execute();
		echo '{"notice": {"text:"  "Proveedor modificado"'; 

	}catch(PDOExcepetion $e){
		//echo '{"error": {"text: '.$e->getMessage().'}';
	}

});
//Borrar todos los productos

$app->delete('/api/productos/destroy/{codigo}',function(Request $request, Response $response){

	$codigo = $request->getAttribute('codigo');

	$consulta = "DELETE FROM producto WHERE codigo = $codigo";

	try{

		$db = new db();
		$db = $db->conectar();
		$stmt = $db->prepare($consulta);
		$stmt->execute();
		$db = null;

		
		echo 'Efectuado';

	}catch(PDOException $e){
		echo 'Error' + $e.errorInfo();
	}
});