  

  function filter_order(){

    
    var data = {
          
        };

    listOrders(data);
  }

  function resetFilter(){
  
    var data = {};

    listOrders(data);
  }
  var report_sales = '';
  function listOrders(data='') {
    
     report_sales = $('#report_users_referal').DataTable({
          "dom": 'fl<"topbutton">tip',
              oLanguage: {
                sProcessing: '<div class="dt-loader"></div'
              },
              processing : true,
              serverSide: true,
              destroy: true,
              pageLength: 25,
              order: [[1, "desc"]],
      ajax: {
          url: base_url + _admin+'UserReferralReport/listUsers',
          type: 'POST',
          dataSrc: "data",
          data:data,
          function ( d ) {
      return JSON.stringify( d );
    }
      },
      columnDefs: [{responsivePriority: 1 ,targets: 2}],

      columns: [        
          { "width": "80px", title: "Image" },
          { "width": "150px", title: "Name" },            
          { "width": "50px", title: "Mobile" },
          { "width": "50px", title: "Count" },
          { "width": "50px", title: "Referral Code" }, 
          
      ],
       "drawCallback": function (settings) { 
        // Here the response
        var response = settings.json;
        console.log(response);
    },
    });
     
   
  }
$(document).ready(function() {

  filter_order();

});


