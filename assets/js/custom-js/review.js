var rank = '';
  function listReview(data='') {

    var data = {


          // 'designation':$('#designation').val(),
          // 'police_station':$('#police_station').val(),
        };

        

      category = $('#review_datatable').DataTable({

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
                  url: base_url + _admin+'Review/Review_list',
                  type: 'POST',
                  dataSrc: "data",
                  data:data
              },

      columnDefs: [{responsivePriority: 1 ,targets: 2}],

      columns: [        
          { "width": "10px",  title: "Sr.No.", orderable:false },         
           { "width": "60px", title: "OrderId" },
          { "width": "100px", title: "User" }, 
          { "width": "60px", title: "Type" },
          // { "width": "60px", title: "Duration" },
           { "width": "60px", title: "Course/Package Name" },
           { "width": "60px", title: "Ratings" },
           { "width": "60px", title: "Review" },
           { "width": "60px", title: "Status" },
          { "width": "60px", title: "Created At" },
          // { "width": "60px", title: "Updated on" },
          // { "width": "60px", title: "Updated By" },

          // { "width": "60px", title: "Action", orderable:false, "className": "text-right" }

      ],
      // console.log(retutn false);
     
    });
     
  }

  $(document).ready(function() {

  listReview();
  // listRankVideo();

});
  
 
 function changeStatus(r_id,active='') {
  $.ajax({
    url:base_url+_admin+'Review/changeStatus',
    type:'get',
    data:{'id':r_id, 'active': active},
    dataType:'json',
    success: function(response) {
      if (response.result == true) {
        if (status == 1) {
        $('#active_'+r_id).removeClass('badge-danger').addClass('badge-success').attr({'onclick':'changeStatus('+r_id+',0)','title':'Click for In-Active'}).text('Active');
        }else{
        $('#active_'+r_id).removeClass('badge-success').addClass('badge-danger').attr({'onclick':'changeStatus('+r_id+',1)','title':'Click for Active'}).text('In-Active');
        }
        alert_float('success',response.reason);
      }else{
        alert_float('error',response.reason);
      }
       location.reload();
    }
  });
}
$('#something').click(function() {
   
});
