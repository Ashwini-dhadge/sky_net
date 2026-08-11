var category = '';

function listMcq() {

  category = $('#category_datatable').DataTable({
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
      url: base_url + _admin + 'Category/Category_list',
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
        width: "100px",
        title: "Category Name"
      },
      {
        width: "60px",
        title: "Status"
      },
      {
        width: "60px",
        title: "Action",
        orderable: false,
        className: "text-right"
      }
    ]
  });
}

$(document).ready(function () {

  listMcq();

});

$(document).off('click', '.categoryModal');

$(document).on('click', '.categoryModal', function (e) {

  e.preventDefault();

  let id = $(this).data('id') || '';

  categoryModal(id);

});

function categoryModal(id = '') {

  // remove old modal first
  $('#categoryModal').remove();

  $.ajax({
    url: base_url + _admin + 'Category/categoryModal',
    type: 'POST',
    data: {
      id: id
    },
    dataType: 'json',

    success: function (res) {

      if (res.result === true) {

        $('#_category').html('');

        $('#_category').html(res.html);

        $('#categoryModal').modal({
          backdrop: 'static',
          keyboard: false
        });

      } else {

        alert_float('error', res.reason);
      }
    },

    error: function () {

      alert_float('error', 'Something went wrong');
    }
  });
}