
 function resetFilter(){
    
      
    var data = {};

    listoffer(data);
  }
  function listoffer(data='') {
  var data = {
      
      'type': $('#type').val(),

    };
     articles = $('#user_datatable').DataTable({
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
                  url: base_url + _admin+'Offer/listoffer',
                  type: 'POST',
                  dataSrc: "data",
                  data:data,
              },
              columnDefs: [{responsivePriority: 1 ,targets: 3}],

             columns: [        
                  { "width": "50px",  title: "Sr.No.", orderable:false },
                  { "width": "50px", title: "Offer Image" },  
                  { "width": "50px", title: "Offer Title"}, 
                  { "width": "50px", title: "Offer Type"},
                  { "width": "50px", title: "Offer Category"}, 
                  { "width": "50px", title: "Offer Code"},  
                  { "width": "50px", title: "Min Order Value" },  
                  { "width": "50px", title: "Offer" },  
                  // { "width": "50px", title: "Terms"},
                  { "width": "50px", title: "From Date"},
                  { "width": "50px", title: "To Date"},  
                  { "width": "50px", title: "Status"},
                  { "width": "60px", title: "Action" , orderable:false, "className": "text-center"},
              ],
  
     
    });

    
  }
   
 
$(document).ready(function() {

  resetFilter();

});


