<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Zona
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre,$distrito,$referencia,$frecuencia)
	{
		$sql="INSERT INTO zona (nombre,distrito,referencia,condicion)
		VALUES ('$nombre','$distrito','$referencia','1')";
		$idzonanew = ejecutarConsulta_retornarID($sql);

		$num_elements = 0;
		$sw=true;

		while ($num_elements < count($frecuencia)){
			$sql_detalle = "INSERT INTO zona_frecuencia (idzona, idfrecuencia) VALUES('$idzonanew', '$frecuencia[$num_elements]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elements=$num_elements + 1;
		}
		return $sw;
	}

	//Implementamos un método para editar registros
	public function editar($idzona,$nombre,$distrito,$referencia,$frecuencia)
	{
		$sql="UPDATE zona SET nombre='$nombre', distrito='$distrito',referencia='$referencia' WHERE idzona='$idzona'";
		ejecutarConsulta($sql);

		//Eliminar todos las frecuencias asignadas para voler a registrar
		$sqldel="DELETE FROM zona_frecuencia WHERE idzona='$idzona'";
		ejecutarConsulta($sqldel);

		$num_elemts = 0;
		$sw = true;

		while($num_elemts < count($frecuencia))
		{
			$sql_detalle = "INSERT INTO zona_frecuencia (idzona, idfrecuencia) VALUES('$idzona', '$frecuencia[$num_elemts]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elemts=$num_elemts + 1;
		}
		return $sw;
	}

	//Implementamos un método para desactivar zona
	public function desactivar($idzona)
	{
		$sql="UPDATE zona SET condicion='0' WHERE idzona='$idzona'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar zona
	public function activar($idzona)
	{
		$sql="UPDATE zona SET condicion='1' WHERE idzona='$idzona'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idzona)
	{
		$sql="SELECT * FROM zona WHERE idzona='$idzona'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar($idzona)
	{
		"SELECT z.idzona, z.nombre, count(p.tipo_persona) as clientes, z.distrito, (SELECT group_concat(f.dia_semana) as dias FROM zona_frecuencia zf 
		INNER JOIN frecuencia f ON zf.idfrecuencia=f.idfrecuencia WHERE zf.idzona='$idzona') as dias, (SELECT u.nombre from usuario u where u.cargo='Vendedor' and u.idzona='$idzona') as vendedor, z.condicion from persona p INNER JOIN zona z ON p.idzona=z.idzona WHERE tipo_persona = 'Cliente' and z.idzona='$idzona'";		
	}

	public function listarZonas(){
		$sql="SELECT * FROM zona where condicion = 1";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar las frecuencias marcadas
	public function listarmarcados($idzona)
	{
		$sql="SELECT * FROM zona_frecuencia WHERE idzona='$idzona'";
		return ejecutarConsulta($sql);
	}
	
}

?>