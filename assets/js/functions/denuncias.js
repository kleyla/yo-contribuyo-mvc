var tableDenuncias;
document.addEventListener("DOMContentLoaded", function () {
  var idArticulo = document.querySelector("#idArticulo").value;
  tableDenuncias = $("#tableDenuncias").dataTable({
    aProcessing: true,
    aServerSide: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
    },
    ajax: {
      url: " " + base_url + "denuncia/getDenuncias/" + idArticulo,
      dataSrc: "",
    },
    columns: [
      { data: "usuario_id" },
      { data: "nick" },
      { data: "razones" },
      { data: "fecha" },
      { data: "opciones" },
    ],
    resonsieve: "true",
    bDestroy: true,
    iDisplayLength: 10,
    order: [[0, "desc"]],
  });
});

function btnDeleteDenuncia(idUsuario) {
  var idArticulo = document.querySelector("#idArticulo").value;
  console.log(idUsuario);
  swal(
    {
      title: "Eliminar Denuncia",
      text: "Realmente quiere eliminar esta denuncia?",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: "Si, eliminar",
      cancelButtonText: "No, cancelar",
      closeOnConfirm: false,
      closeOnCancel: true,
    },
    function (isConfirm) {
      if (isConfirm) {
        var request = window.XMLHttpRequest
          ? new XMLHttpRequest()
          : new ActiveXObject("Microsoft.XMLHTTP");
        var ajaxUrl = base_url + "denuncia/deleteDenuncia";
        var strData = "idArticulo=" + idArticulo + "&idUsuario=" + idUsuario;
        request.open("POST", ajaxUrl, true);
        request.setRequestHeader(
          "Content-type",
          "application/x-www-form-urlencoded"
        );
        request.send(strData);
        request.onreadystatechange = function () {
          if (request.readyState == 4 && request.status == 200) {
            var objData = JSON.parse(request.responseText);
            if (objData.status) {
              swal("Eliminar!", objData.msg, "success");
              tableDenuncias.api().ajax.reload();
            } else {
              swal("Atencion!", objData.msg, "error");
            }
          }
        };
      }
    }
  );
}
