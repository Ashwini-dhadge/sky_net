
  function filter_report(){

    var user_id = $('#user_id').val();
  
    var data = {
          'user_id':user_id,
            'on_date':$('#on_date').val(),
            'from_date':$('#from_date').val(),
            'to_date':$('#to_date').val()

        
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
    
     report_sales = $('#report_user_sales').DataTable({
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
          url: base_url + _admin+'UserSalesReport/listSaleOrders',
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
          { "width": "50px", title: "Date" },
          { "width": "120px", title: "Name" },  
          { "width": "80px", title: "Mobile" },  
          { "width": "80px", title: "Email" },  
          { "width": "120px", title: "Type" },
          { "width": "50px", title: "Is Free" }, 
          { "width": "120px", title: "Courses/package Name" }, 
          { "width": "120px", title: "Durations" }, 
          { "width": "120px", title: "Order id" },
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


