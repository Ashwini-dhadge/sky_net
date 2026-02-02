  $('.on_date').hide();

  $('#on_date').on('change', function() {
    var on_date = $('#on_date').val();
    if (on_date != 6) {
      filter_lead();
    }else{
      $('.on_date').show();
    }
  });

  function filter_lead(){

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
    
     report_sales = $('#report_lead').DataTable({
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

          url: base_url + _admin+'WebsiteLeadReport/listLeadReport',
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
          { "width": "100px", title: "Mobile" },  
          { "width": "100px", title: "Email" }, 
          { "width": "100px", title: "Message" }, 
           
          
      ],
       "drawCallback": function (settings) { 
        // Here the response
        var response = settings.json;
        
    },
    });
     
   
  }
$(document).ready(function() {

  filter_lead();

});


