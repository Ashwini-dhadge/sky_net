  $('.on_date').hide();

  $('#on_date').on('change', function() {
    var on_date = $('#on_date').val();
    if (on_date != 6) {
      filter_order();
    }else{
      $('.on_date').show();
    }
  });

  function filter_order(){

    var on_date = $('#on_date').val();
    var from_date = $('#from_date').val();
    var to_date   = $('#to_date').val();
   
    var data = {
          'on_date':on_date,
          'from_date':from_date,
          'to_date':to_date,
         
        };

    listOrders(data);
  }

  function resetFilter(){
    $('#on_date').val('');
    $('#from_date').val('');
    $('#to_date').val('');
   
    var data = {};

    listOrders(data);
  }
  var report_sales = '';
  function listOrders(data='') {
    
     report_sales = $('#report_payment').DataTable({
          "dom": 'fl<"topbutton">tip',
              oLanguage: {
                sProcessing: '<div class="dt-loader"></div'
              },
              processing : true,
              serverSide: true,
              destroy: true,
              pageLength: 25,
              order: [[3, "desc"]],
      ajax: {
          url: base_url + _admin+'PaymentWiseReport/listOrders',
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
          { "width": "120px", title: "Payment Gateway" },  
          { "width": "120px", title: "No Of Orders" },  
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

  filter_order();

});


