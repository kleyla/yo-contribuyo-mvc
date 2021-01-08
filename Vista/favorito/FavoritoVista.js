class FavoritoVista {
  initTable() {
    tableFavoritos = $("#tableFavoritos").dataTable({
      aProcessing: true,
      aServerSide: true,
      language: {
        url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
      },
      ajax: {
        url: " " + base_url + "favorito/getFavoritos",
        dataSrc: "",
      },
      columns: [
        { data: "id_proyecto" },
        { data: "nombre" },
        { data: "nick" },
        { data: "repositorio" },
        { data: "fecha" },
        { data: "opciones" },
      ],
      resonsieve: "true",
      bDestroy: true,
      iDisplayLength: 10,
      order: [[0, "desc"]],
    });
  }
}
var tableFavoritos;
var favoritoVista = new FavoritoVista();

document.addEventListener("DOMContentLoaded", function () {
  favoritoVista.initTable();
});
