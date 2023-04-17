// Call the dataTables jQuery plugin
$(document).ready(function () {
  $("#dataTable").DataTable({
    language: {
      url: "/vendor/datatables/dataTables.spanish-mx.json",
    },
    order: [[0, "desc"]],
  });
});
