  

  function filter_order(){

    
    var data = {
          
        };

    listUsers(data);
  }

  function resetFilter(){
  
    var data = {};

    listUsers(data);
  }
  function filter_users_paid(){

    
    var data = {
          'user_id':$('#user_id').val()
        };

    listUsersPaidCommsion(data);
  }

  var report_sales = '';
  function listUsers(data='') {
    
     report_sales = $('#users_commsion').DataTable({
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
          url: base_url + _admin+'CommsionPayUsers/listUsers',
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
          { "width": "50px", title: "user reference No" },
          { "width": "50px", title: "Wallet Balance" },
          { "width": "50px", title: "Paid Amount" },
          { "width": "50px", title: "Action" }, 
          
      ],
       "drawCallback": function (settings) { 
        // Here the response
        var response = settings.json;
        console.log(response);
    },
    });
     
   
  }
  function listUsersPaidCommsion(data='') {
    
     report_sales = $('#paidCommsion_datatable').DataTable({
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
          url: base_url + _admin+'CommsionPayUsers/listPaidCommsion',
          type: 'POST',
          dataSrc: "data",
          data:data,
          function ( d ) {
      return JSON.stringify( d );
    }
      },
      columnDefs: [{responsivePriority: 1 ,targets: 2}],

      columns: [        
          { "width": "80px", title: "Sr. No" },
           { "width": "80px", title: "Payment Mode" },
          { "width": "80px", title: "Transaction ID" },
          { "width": "150px", title: "Transaction Date" },            
          { "width": "50px", title: "Payment Amount" },
          { "width": "50px", title: "Description" }
      
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

