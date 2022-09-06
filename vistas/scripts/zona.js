var tabla

//Función que se ejecuta al inicio
function init() {
  mostrarform(false)
  listar()

  $("#formulario").on("submit", function (e) {
    guardaryeditar(e)
  })

  //show frequency
  $.post("../ajax/zonas.php?op=frecuencias&id=", function (r) {
    $("#frecuencias").html(r)
  })

  $("#mZonas").addClass("treeview active")
  $("#lZonas").addClass("active")
}

//Función limpiar
function limpiar() {
  $("#nombre").val("")
  $("#distrito").val("")
  $("#referencia").val("")
  $("#idzona").val("")
}

//Función mostrar formulario
function mostrarform(flag) {
  limpiar()
  if (flag) {
    $("#listadoregistros").hide()
    $("#formularioregistros").show()
    $("#btnGuardar").prop("disabled", false)
    $("#btnagregar").hide()
  } else {
    $("#listadoregistros").show()
    $("#formularioregistros").hide()
    $("#btnagregar").show()
  }
}

//Función cancelarform
function cancelarform() {
  limpiar()
  mostrarform(false)
}

//Función Listar
function listar() {
  tabla = $("#tbllistado")
    .dataTable({
      lengthMenu: [5, 10, 25, 75, 100], //mostramos el menú de registros a revisar
      aProcessing: true, //Activamos el procesamiento del datatables
      aServerSide: true, //Paginación y filtrado realizados por el servidor
      dom: "<Bl<f>rtip>", //Definimos los elementos del control de tabla
      buttons: ["copyHtml5", "excelHtml5", "csvHtml5", "pdf"],
      ajax: {
        url: "../ajax/zonas.php?op=listar",
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
      iDisplayLength: 25, //Paginación
      order: [[0, "desc"]], //Ordenar (columna,orden)
    })
    .DataTable()
}

//Función para guardar o editar

function guardaryeditar(e) {
  e.preventDefault() //No se activará la acción predeterminada del evento
  $("#btnGuardar").prop("disabled", true)
  var formData = new FormData($("#formulario")[0])

  $.ajax({
    url: "../ajax/zonas.php?op=guardaryeditar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function (datos) {
      bootbox.alert(datos)
      mostrarform(false)
      tabla.ajax.reload()
    },
  })
  limpiar()
}

function mostrar(idzona) {
  $.post(
    "../ajax/zonas.php?op=mostrar",
    { idzona: idzona },
    function (data, status) {
      data = JSON.parse(data)
      mostrarform(true)

      $("#nombre").val(data.nombre)
      $("#distrito").val(data.distrito)
      $("#referencia").val(data.referencia)
      $("#idzona").val(data.idzona)
    }
  )
  $.post("../ajax/zonas.php?op=frecuencias&id=" + idzona, function (r) {
    $("#frecuencias").html(r)
  })
}

//funcion para desactivar registros
function desactivar(idzona) {
  bootbox.confirm("Esta seguro de desactivar la zona?", function (result) {
    if (result) {
      $.post(
        "../ajax/zonas.php?op=desactivar",
        { idzona: idzona },
        function (e) {
          bootbox.alert(e)
          tabla.ajax.reload()
        }
      )
    }
  })
}

//Función para activar registros
function activar(idzona) {
  bootbox.confirm("¿Está Seguro de activar la Zona?", function (result) {
    if (result) {
      $.post("../ajax/zonas.php?op=activar", { idzona: idzona }, function (e) {
        bootbox.alert(e)
        tabla.ajax.reload()
      })
    }
  })
}

init()
