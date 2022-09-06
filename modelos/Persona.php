<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Persona
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idzona,$tipo_persona,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$ubicacion,$deuda_pendiente,$anticipos)
	{
		$sql="INSERT INTO persona (idzona,tipo_persona,nombre,tipo_documento,num_documento,direccion,telefono,email,ubicacion,deuda_pendiente,anticipos)
		VALUES ('$idzona','$tipo_persona','$nombre','$tipo_documento','$num_documento','$direccion','$telefono','$email','$ubicacion','$deuda_pendiente','$anticipos')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idpersona,$idzona,$tipo_persona,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$ubicacion,$deuda_pendiente,$anticipos)
	{
		$sql="UPDATE persona SET idzona='$idzona', tipo_persona='$tipo_persona',nombre='$nombre',tipo_documento='$tipo_documento',num_documento='$num_documento',direccion='$direccion',telefono='$telefono',email='$email',ubicacion='$ubicacion', deuda_pendiente='$deuda_pendiente', anticipos='$anticipos' WHERE idpersona='$idpersona'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para eliminar categorías
	public function eliminar($idpersona)
	{
		$sql="DELETE FROM persona WHERE idpersona='$idpersona'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idpersona)
	{
		$sql="SELECT * FROM persona WHERE idpersona='$idpersona'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listarp()
	{
		$sql="SELECT * FROM persona WHERE tipo_persona='Proveedor'";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros 
	public function listarc()
	{
		$sql="SELECT p.idpersona, p.nombre as nombre, p.tipo_documento, p.num_documento, p.telefono, p.email, p.ubicacion, z.nombre as zona, p.activo FROM persona p INNER JOIN zona z ON p.idzona=z.idzona WHERE tipo_persona='Cliente' ORDER BY p.idpersona DESC";
		return ejecutarConsulta($sql);		
	}
}

?>