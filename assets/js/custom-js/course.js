var course = '';
  function listCourse(data='') {
    var data = {


          // 'designation':$('#designation').val(),
          // 'police_station':$('#police_station').val(),
        };

      course = $('#Course_datatable').DataTable({
          "dom": 'fl<"topbutton">tip',
              oLanguage: {
                sProcessing: '<div class="dt-loader"></div'
              },
              processing : true,
              serverSide: true,
              destroy: true,
              pageLength: 25,
              order: [[2, "asc"]],
              ajax: {
                  url: base_url + _admin+'Course/Course_list',
                  type: 'POST',
                  dataSrc: "data",
                  data:data
              },
      columnDefs: [{responsivePriority: 1 ,targets: 3}],

      columns: [        
          { "width": "10px",  title: "Sr.No.", orderable:false },         
          { "width": "60px", title: "Course Title " },
          { "width": "10px", title: "Display Prioritize" },
          { "width": "200px", title:  "Category Name" }, 
          // { "width": "60px", title: "Price" },
          // { "width": "60px", title: "Discount Price" },
         { "width": "60px", title: "Status" },
          { "width": "60px", title: "Action", orderable:false, "className": "text-right" }

      ],
     
    });
     
  }

  $(document).ready(function() {

  listCourse();
  listDurationlist();

});

function listDurationlist(data='') {
    var data = {
// 'police_station':$('#police_station').val(),

         
        };

      user = $('#duration_dataTable').DataTable({
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
                  url: base_url + _admin+'Course/listDurationlist',
                  type: 'POST',
                  data: function (d) {
                    d.d_id = $('#d_id').val();
                   
                },
              },
      columnDefs: [{responsivePriority: 1 ,targets: 1}],

      columns: [        
           { "width": "10px",  title: "Sr.No.", orderable:false },         
          { "width": "60px", title: "Duration" },
          { "width": "60px", title: "Language" },
          { "width": "60px", title: "Offer Type" },
          { "width": "80px", title: "Offer Amount" },
          { "width": "100px", title: "Original Price" },
          { "width": "60px", title: "Status" },
         // { "width": "40px", title: "Action" },

      ],
     
    });
     
  }

  function changeDurationStatus(id,status) {
    $.ajax({
          url: base_url + _admin+'Course/changeDurationStatus',
          type: 'get',
          data: {'id':id,'status':status},
          dataType:'json',
          success: function(res) {
            if (res.result == true) {
              if (status == 1) {
                $('#status_'+id).removeClass('badge-danger').addClass('badge-success').attr({'onclick':'changeDurationStatus('+id+',0)','title':'Click for In-Active'}).text('Active');
                }else{
                $('#status_'+id).removeClass('badge-success').addClass('badge-danger').attr({'onclick':'changeDurationStatus('+id+',1)','title':'Click for Active'}).text('In-Active');
                }
              alert_float('success',res.reason);
            }else{
              alert_float('error',res.reason);
            }
          }
      });
  }

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