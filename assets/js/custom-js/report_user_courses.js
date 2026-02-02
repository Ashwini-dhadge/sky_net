
  function filter_report(){

    var user_id = $('#user_id').val();
  
    var data = {
          'user_id':user_id,
        
        };

    listOrders(data);
  }

  function resetFilter(){
    $('#user_id').val('');
   
    var data = {};

    listOrders(data);
  }
  var report_sales = '';
  function listOrders(data='') {
    
     report_sales = $('#report_users_courses').DataTable({
          "dom": 'fl<"topbutton">tip',
              oLanguage: {
                sProcessing: '<div class="dt-loader"></div'
              },
              processing : true,
              serverSide: true,
              destroy: true,
              pageLength: 25,
              order: [[6, "desc"]],
      ajax: {
          url: base_url + _admin+'UserWiseCoursesReport/listUsers',
          type: 'POST',
          dataSrc: "data",
          data:data,
          function ( d ) {
      return JSON.stringify( d );
    }
      },
      columnDefs: [{responsivePriority: 1 ,targets: 2}],

      columns: [        
          {  orderable: false, "width": "50px", title: "Sr._No." },
            { "width": "120px", title: "Name" },  
          { "width": "120px", title: "Type" },  
          { "width": "120px", title: "Courses/package Name" }, 
          { "width": "120px", title: "Durations" }, 
          { "width": "120px", title: "Order id" }, 
          { "width": "120px", title: "Payment Name" }, 
          { orderable: false, "width": "100px", title: "Total Amt.", "className": "text-right"},  
          
      ],
       "drawCallback": function (settings) { 
        // Here the response
        var response = settings.json;
        console.log(response);
    },
    });
     
   
  }
$(document).ready(function() {

  filter_report();

});


