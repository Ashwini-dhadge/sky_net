$('select').select2();
$('.datepicker').datepicker();

  function filter_users(){

    var status   = $('#status').val();
    var data = {
      'status': status, 
    };

   listUsers(data);
  }

  function resetFilter(){
  
    var data = {};

    listUsers(data);
  }

  function listUsers(data='') {
    
     categories = $('#user_datatable').DataTable({
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
          url: base_url + _admin+'User/listUsers',
          type: 'POST',
          //dataSrc: "data",
          data: function (d) {
                    d.role = $('#role').val();
                   
                },
      },
      columnDefs: [{responsivePriority: 1 ,targets: 2}],

      columns: [        
          { "width": "50px",  title: "Sr. No.", orderable:false },
          { "width": "80px", title: "Image" },
          { "width": "150px", title: "Name" },  
          { "width": "150px", title: "Email" },
          { "width": "50px", title: "Mobile" },
          { "width": "50px", title: "Status" },
          { "width": "100px", title: "Action" , orderable:false, "className": "text-right"},
      ],
     
    });
     
  }
  


  $(document).ready(function() {
    
    filter_users();
  
  });
 
  