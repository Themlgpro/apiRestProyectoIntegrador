<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app= new \Slim\App;


//obtener todos los productos

$app->get('/api/productos',function(Request $request, Response $response){
	$consulta = 'SELECT * FROM producto';

	try{

		$db = new db();
		$db = $db->conectar();
		$ejecutar = $db->query($consulta);
		$productos = $ejecutar->fetchAll(PDO::FETCH_OBJ);
		$db = null;

		//data to json
		$response = json_encode($productos); 
		return $response;

	}catch(PDOException $e){
		echo 'Error';
	}
});


//obtener solo un producto
$app->get('/api/productosAg', function(Request $request, Response $response){


	$consulta = "SELECT * FROM producto WHERE cantidad <= 0";


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

//adicionar un producto
$app->post('/api/productos/add',function(Request $request, Response $response){

	$codigo = $request->getParam('codigo');
	$nitProveedor = $request->getParam('nitProveedor');
	$nombre = $request->getParam('nombre');
	$descripcion = $request->getParam('descripcion');
	$cantidad = $request->getParam('cantidad');
	$precio = floatval($request->getParam('precio'));	
	$costoCompra = floatval($request->getParam('costoCompra'));


	$consulta = "INSERT INTO producto (codigo, nitProveedor, nombre, descripcion, cantidad, precio,costoCompra) VALUES (:codigo, :nitProveedor, :nombre, :descripcion, :cantidad, :precio, :costoCompra)";

	try{

		$db = new db();
		$db = $db->conectar();
		//preparar la data para ser almacenada
		$stmt = $db->prepare($consulta);
		
		$stmt->bindParam(':codigo',$codigo);
		$stmt->bindParam(':nitProveedor',$nitProveedor);
		$stmt->bindParam(':nombre',$nombre);
		$stmt->bindParam(':descripcion',$descripcion);
		$stmt->bindParam(':cantidad',$cantidad);
		$stmt->bindParam(':precio',$precio);
		$stmt->bindParam(':costoCompra',$costoCompra);
		$stmt->execute();
		
		


		echo 'Efectuado';
		http_response_code(200);

	}catch(PDOException $e){
		echo 'Errorsote'+ $e.errorInfo();
		http_response_code(400);
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
		echo 'Error';
	}
});

$app->put('/api/productos/actualizar/{id}', function(Request $request, Response $response){

	$codigo = $request->getParam('codigo');
	$nitProveedor = $request->getParam('nitProveedor');
	$nombre = $request->getParam('nombre');
	$descripcion = $request->getParam('descripcion');
	$cantidad = $request->getParam('cantidad');
	$precio = floatval($request->getParam('precio'));	
	$costoCompra = floatval($request->getParam('costoCompra'));

	$consulta = "UPDATE producto SET
						codigo           =:codigo,
						nitProveedor           =:nitProveedor,
					 	descripcion         =:descripcion,
					 	cantidad         =:cantidad,
					 	precio         =:precio,
					 	costoCompra         =:costoCompra,
					 	nombre         =:nombre,
					 	
					WHERE codigo = $codigo";

	try{

		$db = new db();

		$db = $db->conectar();
		$stmt = $db->prepare($consulta);
		$stmt -> bindParam(':nombre',$nombre);
		$stmt -> bindParam(':codigo',$codigo);
		$stmt -> bindParam(':nitProveedor',$nitProveedor);
		$stmt -> bindParam(':descripcion',$descripcion);
		$stmt -> bindParam(':cantidad',$cantidad);
		$stmt -> bindParam(':precio',$precio);
		$stmt -> bindParam(':costoCompra',$costoCompra);
		$stmt -> execute();
		echo '{"notice": {"text:"  "Producto Modificado agregado"'; 

	}catch(PDOExcepetion $e){
		//echo '{"error": {"text: '.$e->getMessage().'}';
	}

});