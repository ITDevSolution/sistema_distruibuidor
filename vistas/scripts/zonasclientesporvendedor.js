var tabla

//Función que se ejecuta al inicio
function init() {
  listar()
  //Cargamos los items al select vendedor
  $.post("../ajax/usuario.php?op=selectVendedor", function (r) {
    $("#idvendedor").html(r)
    $("#idvendedor").selectpicker("refresh")
  })
}

//Función Listar
function listar() {
  var idvendedor = $("#idvendedor").val()

  tabla = $("#tbllistado")
    .dataTable({
      lengthMenu: [5, 10, 25, 75, 100], //mostramos el menú de registros a revisar
      aProcessing: true, //Activamos el procesamiento del datatables
      aServerSide: true, //Paginación y filtrado realizados por el servidor
      dom: "<Bl<f>rtip>", //Definimos los elementos del control de tabla
      buttons: ["copyHtml5", "excelHtml5", "csvHtml5", "pdf"],
      ajax: {
        url: "../ajax/consultas.php?op=zonasclientesporVendedor",
        data: {
          idvendedor: idvendedor,
        },
        type: "get",
        dataType: "json",
        error: function (e) {
          console.log(e.responseText)
        },
      },
      language: {
        lengthMenu: "Mostrar : _MENU_ registros",
        buttons: {
          copyTitle: "Tabla Copiada",
          copySuccess: {
            _: "%d líneas copiadas",
            1: "1 línea copiada",
          },
        },
      },
      bDestroy: true,
      iDisplayLength: 10, //Paginación
      order: [[0, "desc"]], //Ordenar (columna,orden)
    })
    .DataTable()
}

init()
