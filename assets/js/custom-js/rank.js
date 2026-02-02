var rank = '';
  function listRank(data='') {
    var data = {


          // 'designation':$('#designation').val(),
          // 'police_station':$('#police_station').val(),
        };

      category = $('#rank_datatable').DataTable({
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
                  url: base_url + _admin+'RankMaster/rank_list',
                  type: 'POST',
                  dataSrc: "data",
                  data:data
              },
      columnDefs: [{responsivePriority: 1 ,targets: 2}],

      columns: [        
          { "width": "10px",  title: "Sr.No.", orderable:false },         
          { "width": "100px", title: "Rank" }, 
          { "width": "60px", title: "From-To" },
          { "width": "60px", title: "comment" },
          { "width": "60px", title: "Image" },
          { "width": "60px", title: "Action", orderable:false, "className": "text-right" }

      ],
     
    });
     
  }

  $(document).ready(function() {

  listRank();
  listRankVideo();

});
  $('.rankModal').on('click', function() {
    rankModal();
  });

  function rankModal(id='') {

    $.ajax({
          url: base_url + _admin+'RankMaster/rankModal',
          type: 'POST',
          data: {'id':id},
          dataType:'json',
          success: function(res) {
            if (res.result == true) {
              $('#_rank').html(res.html);
              $('#rankModal').modal('show');
            }else{
              alert_float('error',response.reason);
            }
          }
      })
  }
   function rankVideoModal(id='') {

    $.ajax({
          url: base_url + _admin+'RankVideoMCQMaster/rankModal',
          type: 'POST',
          data: {'id':id},
          dataType:'json',
          success: function(res) {
            if (res.result == true) {
              $('#_rank').html(res.html);
              $('#rankModal').modal('show');
            }else{
              alert_float('error',response.reason);
            }
          }
      })
  }
  
  function listRankVideo(data='') {
    var data = {


          // 'designation':$('#designation').val(),
          // 'police_station':$('#police_station').val(),
        };

      category = $('#rank_video_datatable').DataTable({
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
                  url: base_url + _admin+'RankVideoMCQMaster/rank_list',
                  type: 'POST',
                  dataSrc: "data",
                  data:data
              },
      columnDefs: [{responsivePriority: 1 ,targets: 2}],

      columns: [        
          { "width": "10px",  title: "Sr.No.", orderable:false },
          { "width": "60px", title: "From-To" },
          { "width": "60px", title: "Message" },
          { "width": "60px", title: "Image" },
          { "width": "60px", title: "Action", orderable:false, "className": "text-right" }

      ],
     
    });
     
  }