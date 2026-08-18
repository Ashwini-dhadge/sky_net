var batchTable = '';

function listBatch() {
  batchTable = $('#batch_datatable').DataTable({
    dom: 'fl<"topbutton">tip',
    processing: true,
    serverSide: true,
    destroy: true,
    pageLength: 25,
    order: [[0, "desc"]],

    oLanguage: {
      sProcessing: '<div class="dt-loader"></div>'
    },

    ajax: {
      url: base_url + _admin + 'Batch/batch_list',
      type: 'POST',
      dataSrc: 'data'
    },

    columnDefs: [{
      responsivePriority: 1,
      targets: 2
    }],

    columns: [
      {
        width: "10px",
        title: "Sr.No.",
        orderable: false
      },
      {
        width: "150px",
        title: "Batch Name"
      },
      {
        title: "Batch Description"
      },
      {
        width: "80px",
        title: "Action",
        orderable: false,
        className: "text-right"
      }
    ]
  });
}

$(document).ready(function () {
  listBatch();
});

$(document).off('click', '.batchModal');

$(document).on('click', '.batchModal', function (e) {
  e.preventDefault();
  let id = $(this).data('id') || '';
  batchModal(id);
});

function batchModal(id = '') {
  $('#batchModal').remove();

  $.ajax({
    url: base_url + _admin + 'Batch/batchModal',
    type: 'POST',
    data: {
      id: id
    },
    dataType: 'json',

    success: function (res) {
      if (res.result === true) {
        $('#_batch').html('');
        $('#_batch').html(res.html);

        $('#batchModal').modal({
          backdrop: 'static',
          keyboard: false
        });
      } else {
        if (typeof alert_float === 'function') {
          alert_float('error', res.reason);
        } else {
          alert(res.reason);
        }
      }
    },

    error: function () {
      if (typeof alert_float === 'function') {
        alert_float('error', 'Something went wrong');
      } else {
        alert('Something went wrong');
      }
    }
  });
}
