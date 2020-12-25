var tableProyectos;
document.addEventListener("DOMContentLoaded", function () {
  tableProyectos = $("#tableProyectos").dataTable({
    aProcessing: true,
    aServerSide: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
    },
    ajax: {
      url: " " + base_url + "proyectos/getProyectos",
      dataSrc: "",
    },
    columns: [
      { data: "id_proyecto" },
      { data: "nombre" },
      { data: "descripcion" },
      { data: "repositorio" },
      { data: "fecha" },
      { data: "estado" },
      { data: "opciones" },
    ],
    resonsieve: "true",
    bDestroy: true,
    iDisplayLength: 10,
    order: [[0, "desc"]],
  });
  // NUEVO LENGUAJE
  var formProyecto = document.querySelector("#formProyecto");
  formProyecto.onsubmit = function (e) {
    // console.log("IN...");
    e.preventDefault();
    var intIdProyecto = document.querySelector("#idProyecto").value;
    var strNombre = document.querySelector("#txtNombre").value;
    var strDescripcion = document.querySelector("#txtDescripcion").value;
    var strRepositorio = document.querySelector("#txtRepositorio").value;
    var intEstado = document.querySelector("#listaEstado").value;
    if (strNombre == "" || strDescripcion == "" || intEstado == "" || strRepositorio == "") {
      swal("Atencion", "Todos los campos son obligatorios", "error");
      // alert("daji");
      return false;
    }
    var request = window.XMLHttpRequest
      ? new XMLHttpRequest()
      : new ActiveXObject("Microsoft.XMLHTTP");
    var ajaxUrl = base_url + "lenguajes/setLenguaje";
    var formData = new FormData(formProyecto);
    request.open("POST", ajaxUrl, true);
    request.send(formData);
    // console.log(request);
    request.onreadystatechange = function () {
      if (request.readyState == 4 && request.status == 200) {
        // console.log(request.responseText);
        var objData = JSON.parse(request.responseText);
        if (objData.status) {
          $("#modalFormProyecto").modal("hide");
          formProyecto.reset();
          swal("Lenguaje", objData.msg, "success");
          tableProyectos.api().ajax.reload(function () {
            EditarLenguaje();
            DeleteLenguaje();
          });
        } else {
          swal("Error", objData.msg, "error");
        }
      }
    };
  };
});

$("#tableProyectos").DataTable();

function openModalProyecto() {
  console.log("open Modal Proyecto");
  stylesFromUpdateToRegisterLenguaje();
  document.querySelector("#formProyecto").reset();
  $("#modalFormProyecto").modal("show");
}

function stylesFromUpdateToRegisterLenguaje() {
  document.querySelector("#idProyecto").value = "";
  document
    .querySelector(".modal-header")
    .classList.replace("headerUpdate", "headerRegister");
  document
    .querySelector("#btnActionForm")
    .classList.replace("btn-info", "btn-primary");
  document.querySelector("#titleModalProyecto").innerHTML = "Nuevo Proyecto";
  document.querySelector("#btnText").innerHTML = "Guardar";
}
function stylesFromRegisterToUpdateLenguaje() {
  document.querySelector("#titleModalLenguaje").innerHTML =
    "Actualizar Lenguaje";
  document
    .querySelector(".modal-header")
    .classList.replace("headerRegister", "headerUpdate");
  document
    .querySelector("#btnActionForm")
    .classList.replace("btn-primary", "btn-info");
  document.querySelector("#btnText").innerHTML = "Actualizar";
}
