var tableUsuarios;
document.addEventListener("DOMContentLoaded", function () {
  tableUsuarios = $("#tableUsuarios").dataTable({
    aProcessing: true,
    aServerSide: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
    },
    ajax: {
      url: " " + base_url + "usuarios/getUsuarios",
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "nick" },
      { data: "email" },
      { data: "fecha" },
      { data: "rol" },
      { data: "estado" },
      { data: "opciones" },
    ],
    resonsieve: "true",
    bDestroy: true,
    iDisplayLength: 10,
    order: [[0, "desc"]],
  });
  // NUEVO USUARIO
  var formUsuario = document.querySelector("#formUsuario");
  formUsuario.onsubmit = function (e) {
    // console.log("IN...");
    e.preventDefault();
    var intIdUsuario = document.querySelector("#idUsuario").value;
    var strNick = document.querySelector("#txtNick").value;
    var strEmail = document.querySelector("#txtEmail").value;
    var intEstado = document.querySelector("#listaEstado").value;
    var strRol = document.querySelector('#listaRol').value;
    if (strNick == "" || strEmail == "" || intEstado == "" || strRol == "") {
      swal("Atencion", "Todos los campos son obligatorios", "error");
      // alert("daji");
      return false;
    }
    var request = window.XMLHttpRequest
      ? new XMLHttpRequest()
      : new ActiveXObject("Microsoft.XMLHTTP");
    var ajaxUrl = base_url + "usuarios/setUsuario";
    var formData = new FormData(formUsuario);
    console.log(formData);
    request.open("POST", ajaxUrl, true);
    request.send(formData);
    // console.log(request);
    request.onreadystatechange = function () {
      if (request.readyState == 4 && request.status == 200) {
        // console.log(request.responseText);
        var objData = JSON.parse(request.responseText);
        if (objData.status) {
          $("#modalFormUsuario").modal("hide");
          formUsuario.reset();
          swal("Usuario", objData.msg, "success");
          tableUsuarios.api().ajax.reload(function () {
            // fntEditRol();
            // fntDelRol();
            // ftnPermisos();
          });
        } else {
          swal("Error", objData.msg, "error");
        }
      }
    };
  };
});

$("#tableUsuarios").DataTable();

function openModalUsuario() {
  console.log("open Modal Usuario");
  stylesFromUpdateToRegister();
  document.querySelector("#formUsuario").reset();
  $("#modalFormUsuario").modal("show");
}
function stylesFromUpdateToRegister() {
  document.querySelector("#idUsuario").value = "";
  document
    .querySelector(".modal-header")
    .classList.replace("headerUpdate", "headerRegister");
  document
    .querySelector("#btnActionForm")
    .classList.replace("btn-info", "btn-primary");
  document.querySelector("#titleModalUsuario").innerHTML = "Nuevo Usuario";
  document.querySelector("#btnText").innerHTML = "Guardar";
}
