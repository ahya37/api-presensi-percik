// TAMPIL DATA
$(function () {
  let table = $("#listData").DataTable({
    processing: true,
    language: {
      processing: "<i class='fa fa-spinner fa-spin fa-2x fa-fw'></i>",
    },
    serverSide: true,
    ordering: true,
    ajax: {
      url: "/kuisioner/listdata",
    },
    columns: [
      { data: "id", name: "id" },
      { data: "nama", name: "nama" },
      {
        data: "action",
        name: "action",
        orderable: false,
        searchable: false,
        width: "15%",
      },
    ],
    order: [[1, "asc"]],
    columnDefs: [
      {
        targets: [0],
        visible: false,
      },
    ],
  });
});

// delete
function onDelete(data) {
  const id = data.id;
  const name = data.value;
  const CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
  Swal.fire({
    title: `Yakin hapus kuisioner : ${name}?`,
    text: "Data yang dihapus tidak dapat dikembalikan",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Hapus",
    cancelButtonText: "Batal",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: `/kuisioner/destroy`,
        method: "POST",
        cache: false,
        data: {
          id: id,
          _token: CSRF_TOKEN,
        },
        success: function (data) {
          Swal.fire({
            position: "center",
            icon: "success",
            title: `${data.data.message}`,
            showConfirmButton: false,
            width: 500,
            timer: 900,
          });
        },
        error: function (error) {
          Swal.fire({
            position: "center",
            icon: "warning",
            title: `Gagal`,
            showConfirmButton: false,
            width: 500,
            timer: 1500,
          });
        },
      });
    }
    const table = $("#listData").DataTable();
    table.ajax.reload();
  });
}
