var rank = '';
  function listBanner(data='') {
    var data = {


          // 'designation':$('#designation').val(),
          // 'police_station':$('#police_station').val(),
        };

      category = $('#banner_datatable').DataTable({
          "dom": 'fl<"topbutton">tip',
              oLanguage: {
                sProcessing: '<div class="dt-loader"></div'
              },
              processing : true,
              serverSide: true,
              destroy: true,
              pageLength: 25,
              order: [[0, "desc"]],
              ajax: {
                  url: base_url + _admin+'Banner/Banner_list',
                  type: 'POST',
                  dataSrc: "data",
                  data:data
              },
      columnDefs: [{responsivePriority: 1 ,targets: 2}],

      columns: [        
          { "width": "10px",  title: "Sr.No.", orderable:false },         
          { "width": "100px", title: "Name" }, 
          { "width": "60px", title: "Image" },
           { "width": "60px", title: "Status" },
          { "width": "60px", title: "Action", orderable:false, "className": "text-right" }

      ],
     
    });
     
  }

  $(document).ready(function() {

  listBanner();
  // listRankVideo();

});
  $('.bannerModal').on('click', function() {
    bannerModal();
  });

  function bannerModal(id='') {

    $.ajax({
          url: base_url + _admin+'Banner/bannerModal',
          type: 'POST',
          data: {'id':id},
          dataType:'json',
          success: function(res) {
              $('#_banner').html();
            if (res.result == true) {
              $('#_banner').html(res.html);
              $('#bannerModal').modal('show');
            }else{
              alert_float('error',response.reason);
            }
          }
      })
  }
  

   function bannerstatusModal(id='') {

    $.ajax({
          url: base_url + _admin+'Banner/changestatus',
          type: 'POST',
          data: {'id':id},
          dataType:'json',
          success: function(res) {
            if (res.result == true) {
              $('#_banner').html(res.html);
              $('#bannerModal').modal('show');
            }else{
              alert_float('error',response.reason);
            }
          }
      })
  }
  


  
 function changeStatus(id,status='') {
  $.ajax({
    url:base_url+_admin+'Banner/changeStatus',
    type:'get',
    data:{'id':id, 'status': status},
    dataType:'json',
    success: function(response) {
      if (response.result == true) {
        if (status == 1) {
        $('#status_'+id).removeClass('badge-danger').addClass('badge-success').attr({'onclick':'changeStatus('+id+',0)','title':'In-Active'}).text('Active');
        }else{
        $('#status_'+id).removeClass('badge-success').addClass('badge-danger').attr({'onclick':'changeStatus('+id+',1)','title':'Active'}).text('In-Active');
        }
      $('#banner_datatable').DataTable().ajax.reload();
        alert_float('success',response.statuss);
      }else{
        alert_float('error',response.statuss);
      }
       //location.reload();
    }
  });
}
$('#something').click(function() {
   
});
