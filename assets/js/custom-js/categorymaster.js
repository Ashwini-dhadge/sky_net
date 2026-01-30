var rank = '';
  function listCategory(data='') {
    var data = {


          // 'designation':$('#designation').val(),
          // 'police_station':$('#police_station').val(),
        };

      category = $('#category_datatable').DataTable({
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
                  url: base_url + _admin+'Category_master/categorymaster_list',
                  type: 'POST',
                  dataSrc: "data",
                  data:data
              },
      columnDefs: [{responsivePriority: 1 ,targets: 2}],

      columns: [        
          { "width": "30%",  title: "Sr.No.", orderable:false },         
          { "width": "40%", title: "Category Name" },  
              { "width": "40%", title: "status" },  
          { "width": "20px", title: "Action", orderable:false, "className": "text-right" }

            ],
     
    });
     
  }

  $(document).ready(function() {

  listCategory();
  // listRankVideo();

});
  $('.categoryModel').on('click', function() {
    categoryModel();
  });

  function categoryModel(id='') {

    $.ajax({
          url: base_url + _admin+'Category_master/categorymasterModal',
          type: 'POST',
          data: {'id':id},
          dataType:'json',
          success: function(res) {
              $('#_category').html();
            if (res.result == true) {
              $('#_category').html(res.html);
              $('#categoryModel').modal('show');
            }else{
              alert_float('error',response.reason);
            }
          }
      })
  }
  


  
 function changeStatus(id,status='') {
  $.ajax({
    url:base_url+_admin+'Category_master/changeStatus',
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
      $('#category_datatable').DataTable().ajax.reload();
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
