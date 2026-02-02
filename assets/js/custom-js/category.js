var category = '';
  function listMcq(data='') {
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
                  url: base_url + _admin+'Category/Category_list',
                  type: 'POST',
                  dataSrc: "data",
                  data:data
              },
      columnDefs: [{responsivePriority: 1 ,targets: 2}],

      columns: [        
          { "width": "10px",  title: "Sr.No.", orderable:false },         
          { "width": "100px", title: "Category Name" }, 
          { "width": "60px", title: "Status" },
         { "width": "60px", title: "Action", orderable:false, "className": "text-right" }

      ],
     
    });
     
  }

  $(document).ready(function() {

  listMcq();

});
  $('.categoryModal').on('click', function() {
    categoryModal();
  });

  function categoryModal(id='') {

    $.ajax({
          url: base_url + _admin+'Category/categoryModal',
          type: 'POST',
          data: {'id':id},
          dataType:'json',
          success: function(res) {
            if (res.result == true) {
              $('#_category').html(res.html);
              $('#categoryModal').modal('show');
            }else{
              alert_float('error',response.reason);
            }
          }
      })
  }