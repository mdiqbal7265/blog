"use strict";


$("#table-1").dataTable({
  "columnDefs": [
    { "sortable": false, "targets": [2, 3] }
  ]
});
$('#save-stage').DataTable({
  "scrollX": true,
  stateSave: true
});