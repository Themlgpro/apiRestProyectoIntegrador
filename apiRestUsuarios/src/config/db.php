<?php

class db{
	private $host = 'localhost';
	private $user = 'root';
	private $password = '';
	private $db = 'petroleosss';



	//conexion a la base de datos
	public function conectar(){
		$conexion_mysql = "mysql:host = $this->host; dbname=$this->db";
		$conexionDB = new PDO($conexion_mysql, $this->user,$this->password);
		$conexionDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//Para error de codificacion
		$conexionDB -> exec("set names utf8");
		return $conexionDB;
	}
}
