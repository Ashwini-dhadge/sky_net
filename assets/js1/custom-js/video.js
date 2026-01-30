var video = '';
  function listVideo(data='') {
    var data = {


          // 'designation':$('#designation').val(),
          // 'police_station':$('#police_station').val(),
        };

      video = $('#video_datatable').DataTable({
          "dom": 'fl<"topbutton">tip',
              oLanguage: {
                sProcessing: '<div class="dt-loader"></div'
              },
              processing : true,
              serverSide: true,
              destroy: true,
              pageLength: 5,
              order: [[0, "desc"]],
              ajax: {
                  url: base_url + _admin+'Video/video_list',
                  type: 'POST',
                  dataSrc: "data",
                  data:data
              },
      columnDefs: [{responsivePriority: 1 ,targets: 2}],

      columns: [        
          { "width": "10px",  title: "Sr.No.", orderable:false },         
          { "width": "100px", title: "Video Title" }, 
          { "width": "60px", title: "Video Type" },
          { "width": "60px", title: "Duration" },
         { "width": "60px", title: "Action", orderable:false, "className": "text-right" }

      ],
     
    });
     
  }

  $(document).ready(function() {

  listVideo();
  listVideolist();

});

 function listVideolist(data='') {
    var data = {
// 'police_station':$('#police_station').val(),

         
        };

      user = $('#video_csvtable').DataTable({
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
                  url: base_url + _admin+'Lesson/listVideolist',
                  type: 'POST',
                  data: function (d) {
                    d.v_id = $('#v_id').val();
                   
                },
              },
      columnDefs: [{responsivePriority: 1 ,targets: 1}],

      columns: [        
           { "width": "10px",  title: "Sr.No.", orderable:false },         
          { "width": "60px", title: "Title" },
          { "width": "60px", title: "Language" },
          { "width": "60px", title: "Duration" },
          { "width": "80px", title: "CSV File" },

      ],
     
    });
     
  }