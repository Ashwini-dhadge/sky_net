var lesson = '';
  function listPackage(data='') {
    var data = {


          // 'designation':$('#designation').val(),
          // 'police_station':$('#police_station').val(),
        };

      lesson = $('#Package_datatable').DataTable({
          "dom": 'fl<"topbutton">tip',
              oLanguage: {
                sProcessing: '<div class="dt-loader"></div'
              },
              processing : true,
              serverSide: true,
              destroy: true,
              pageLength: 25,
              order: [[3, "asc"]],
              ajax: {
                  url: base_url + _admin+'Package/package_list',
                  type: 'POST',
                  dataSrc: "data",
                  data:data
              },
      columnDefs: [{responsivePriority: 1 ,targets: 3}],

      columns: [        
          { "width": "10px",  title: "Sr.No.", orderable:false },
          { "width": "150px", title: "Image" },         
          { "width": "150px", title: "Package Title" },
           { "width": "10px", title: "Display Prioritize" },
          { "width": "60px", title: "Status" },
          { "width": "100px", title: "Action", orderable:false, "className": "text-right" }

      ],
     
    });
     
  }

  $(document).ready(function() {

  listPackage();

});


$(document).on('blur', '.updateDataTableCourse', function(){
   var id = $(this).data("id");  
   var column = $(this).data("column");  
  var value = $(this).text();
  
   $.ajax({
    url:base_url+'admin/Course/CourseTypeUpdate',  
    method:"POST",
      dataType: 'json',
    data:{id:id, value:value,column:column},   
    success: function(response) {
      if(response.result == true){
     
        alert_float('success',response.reason);
       lesson.ajax.reload();
      }else{
        //alert_float('danger',response.reason);
      }
    }
    })
  });