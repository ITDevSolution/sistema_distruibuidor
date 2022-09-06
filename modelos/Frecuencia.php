<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Frecuencia
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	
	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM frecuencia ORDER BY idfrecuencia ASC";
		return ejecutarConsulta($sql);		
	}

}

?>