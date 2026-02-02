var mcq = '';
  function listMcq(data='') {
    var data = {


          // 'designation':$('#designation').val(),
          // 'police_station':$('#police_station').val(),
        };

      mcq = $('#mcq_datatable').DataTable({
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
                  url: base_url + _admin+'Mcq/Mcq_list',
                  type: 'POST',
                  dataSrc: "data",
                  data:data
              },
      columnDefs: [{responsivePriority: 1 ,targets: 2}],

      columns: [        
          { "width": "10px",  title: "Sr.No.", orderable:false },         
          { "width": "100px", title: "MCQ Name" }, 
          { "width": "200px", title: "Description" },
          { "width": "60px", title: "Duration" },
          { "width": "60px", title: "MCQ Type" },
          { "width": "60px", title: "Status" },
         { "width": "60px", title: "Action", orderable:false, "className": "text-right" }

      ],
     
    });
     
  }

  $(document).ready(function() {

  listMcq();

});