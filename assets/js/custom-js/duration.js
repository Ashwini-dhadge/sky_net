var rank = '';
function listDuration(data = '') {
  var data = {


    // 'designation':$('#designation').val(),
    // 'police_station':$('#police_station').val(),
  };

  category = $('#duration_datatable').DataTable({
    "dom": 'fl<"topbutton">tip',
    oLanguage: {
      sProcessing: '<div class="dt-loader"></div'
    },
    processing: true,
    serverSide: true,
    destroy: true,
    pageLength: 25,
    order: [[0, "desc"]],
    ajax: {
      url: base_url + _admin + 'DurationMaster/Durtation_list',
      type: 'POST',
      dataSrc: "data",
      data: data
    },
    columnDefs: [{ responsivePriority: 1, targets: 2 }],

    columns: [
      { "width": "10px", title: "Sr.No.", orderable: false },
      { "width": "100px", title: "Name" },
      { "width": "60px", title: "No of Day" },
      { "width": "60px", title: "Action", orderable: false, "className": "text-right" }

    ],

  });

}

$(document).ready(function () {

  listDuration();
  // listRankVideo();

});
$('.durationModal').on('click', function () {
  durationModal();
});

function durationModal(id = '') {

  $.ajax({
    url: base_url + _admin + 'DurationMaster/durationModal',
    type: 'POST',
    data: { 'id': id },
    dataType: 'json',
    success: function (res) {
      if (res.result == true) {
        $('#_duration').html(res.html);
        $('#durationModal').modal('show');
      } else {
        alert_float('error', response.reason);
      }
    }
  })
}

