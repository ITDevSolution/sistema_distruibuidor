var tabla

//Función que se ejecuta al inicio
function init() {
  mostrarform(false)
  listar()

  $("#formulario").on("submit", function (e) {
    guardaryeditar(e)
  })
  //load items at select zona
  $.post("../ajax/persona.php?op=selectZona", function (r) {
    $("#idzona").html(r)
    $("#idzona").selectpicker("refresh")
  })
  $("#mClientes").addClass("treeview active")
  $("#lClientes").addClass("active")
}

//Función limpiar
function limpiar() {
  $("#nombre").val("")
  $("#num_documento").val("")
  $("#direccion").val("")
  $("#telefono").val("")
  $("#email").val("")
  $("#ubicacion").val("")
  $("#idzona").val("")
  $("#deuda_pendiente").val("")
  $("#anticipos").val("")
  $("#deuda-label").html("Deuda Inicial: S/. 0")
  $("#anticipo-label").html("Anticipo: S/. 0")
  $("#deuda_actual-label").html("Deuda actual: S/. 0")
  $("#idpersona").val("")
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
        url: "../ajax/persona.php?op=listarc",
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
    url: "../ajax/persona.php?op=guardaryeditar",
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

function mostrar(idpersona) {
  $.post(
    "../ajax/persona.php?op=mostrar",
    { idpersona: idpersona },
    function (data, status) {
      data = JSON.parse(data)
      mostrarform(true)

      let deuda_actual
      if (data.deuda_pendiente <= data.anticipos) {
        deuda_actual = 0
      } else {
        deuda_actual = parseFloat(data.deuda_pendiente - data.anticipos)
      }

      $("#nombre").val(data.nombre)
      $("#tipo_documento").val(data.tipo_documento)
      $("#tipo_documento").selectpicker("refresh")
      $("#num_documento").val(data.num_documento)
      $("#direccion").val(data.direccion)
      $("#telefono").val(data.telefono)
      $("#email").val(data.email)
      $("#ubicacion").val(data.ubicacion)
      $("#idzona").val(data.idzona)
      $("#idzona").selectpicker("refresh")
      $("#deuda_pendiente").val(data.deuda_pendiente)
      $("#deuda-label").html(
        data.deuda_pendiente
          ? "Deuda Inicial: S/. " + data.deuda_pendiente
          : "Deuda Inicial: S/. 0"
      )
      $("#anticipo-label").html(
        data.anticipos ? "Anticipo: S/. " + data.anticipos : "Anticipo: S/. 0"
      )
      $("#deuda_actual-label").html(
        data.deuda_pendiente == 0
          ? "Deuda actual: S/. 0"
          : "Deuda actual: S/. " + deuda_actual
      )
      $("#anticipos").val(data.anticipos)
      $("#idpersona").val(data.idpersona)
    }
  )
}

//Función para eliminar registros
function eliminar(idpersona) {
  bootbox.confirm("¿Está Seguro de eliminar el cliente?", function (result) {
    if (result) {
      $.post(
        "../ajax/persona.php?op=eliminar",
        { idpersona: idpersona },
        function (e) {
          bootbox.alert(e)
          tabla.ajax.reload()
        }
      )
    }
  })
}

init()
