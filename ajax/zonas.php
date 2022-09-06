<?php
ob_start();

if(strlen(session_id()) < 1){
    session_start();
}

if(!isset($_SESSION["nombre"])){
    header("Location: ../vistas/login.html");
}else
{
    if($_SESSION["zonas"] == 1){
        require_once "../modelos/Zona.php";
    
        $zona = new Zona();
    
        $idzona = isset($_POST["idzona"]) ? limpiarCadena($_POST["idzona"]) : "";
        $nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
        $distrito = isset($_POST["distrito"]) ? limpiarCadena($_POST["distrito"]) : "";
        $referencia = isset($_POST["referencia"]) ? limpiarCadena($_POST["referencia"]) : "";
    
        switch ($_GET["op"]){
            case 'guardaryeditar':
                if (empty($idzona)){
                    $rspta=$zona->insertar($nombre,$distrito,$referencia,$_POST['frecuencia']);
                    echo $rspta ? "Zona registrado" : "No se pudieron registrar todos los datos de Zona";
                }
                else {
                    $rspta=$zona->editar($idzona,$nombre,$distrito,$referencia,$_POST['frecuencia']);
                    echo $rspta ? "Zona actualizada" : "Zona no se pudo actualizar";
                }
            break;
    
            case 'desactivar':
                $rspta = $zona->desactivar($idzona);
                echo $rspta ? "Zona Desactivada" : "Zona no se puede desactivar";
            break;
    
            case 'activar':
                $rspta = $zona->activar($idzona);
                echo $rspta ? "Zona activada" : "Zona no se puede activar";
            break;
    
            case 'mostrar':
                $rspta = $zona->mostrar($idzona);
                echo json_encode($rspta);
            break;
    
            case 'listar':
                // $rspta = $zona->listar(1);
                $rspta2 = $zona->listarZonas();
    
                $data = Array();
    
                while($reg = $rspta2->fetch_object()){
                    $data[] = array(
                        "0" => ($reg->condicion) ? '<button class="btn btn-warning" onclick="mostrar('.$reg->idzona.')"><i class="fa fa-pencil"></i></button>'.
                        '<button class="btn btn-danger" onclick="desactivar('.$reg->idzona.')"><i class="fa fa-close"></i></button>' : '<button class="btn btn-warning" onclick="mostrar('.$reg->idzona.')"><i class="fa fa-pencil"></i></button>'.'<button class="btn btn-primary" onclick="activar('.$reg->idzona.')"><i class="fa fa-check"></i></button>',
                        "1" => $reg->idzona,
                        "2" => $reg->nombre,
                        "3" => $reg->distrito,
                        "4" => $reg->referencia,
                        "5" => ($reg->condicion) ? '<span class="label bg-green">Activado</span>' : '<span class="label bg-red">Desactivado</span>'
                    );
                }
            $results = array(
                "sEcho" => 1,
                "iTotalDisplayRecords" => count($data),
                "aaData" => $data
            );
    
            echo json_encode($results);
            break;
    
            case 'frecuencias':
                require_once "../modelos/Frecuencia.php";
                $frecuencia = new Frecuencia();
                $rspta = $frecuencia->listar();
                
    
                // get days assigned to zona
                $id = $_GET['id'];
                $marcados = $zona->listarmarcados($id);
    
                $valores = array();
    
                while ($frec_row = $marcados->fetch_object()){
                    array_push($valores, $frec_row->idfrecuencia);
                }
                // print_r($valores);
    
                //show to list of frequency in the view si estan o no marcados
                while($reg = $rspta->fetch_object()){
                    $sw = in_array($reg->idfrecuencia, $valores) ? 'checked' : '';
                    echo '<li> <input type="checkbox" '.$sw.' name="frecuencia[]" value="'.$reg->idfrecuencia.'">'.$reg->dia_semana.'</li>';
                }
            break;
    
        }
    }else{
        require 'noacceso.php';
    }
}

ob_end_flush();

?>



