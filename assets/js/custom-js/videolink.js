var video = '';
  function listvideo(data='') {
    var data = {


        };

      category = $('#link_datatable').DataTable({
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
                  url: base_url + _admin+'VideoLink/video_list',
                  type: 'POST',
                  dataSrc: "data",
                  data:data
              },
      columnDefs: [{responsivePriority: 1 ,targets: 2}],

      columns: [        
          { "width": "10px",  title: "Sr.No.", orderable:false },         
          { "width": "100px", title: "Vimeo Code" }, 
          { "width": "60px", title: "Image" },
            { "width": "60px", title: "Status" },
          { "width": "60px", title: "Action", orderable:false, "className": "text-right" }

      ],
     
    });
     
  }

  $(document).ready(function() {

  listvideo();
  // listvideoVideo();

});
  $('.videoModal').on('click', function() {
    videoModal();
  });

  function videoModal(id='') {

    $.ajax({
          url: base_url + _admin+'VideoLink/videoModal',
          type: 'POST',
          data: {'id':id},
          dataType:'json',
          success: function(res) {
              $('#_video').html();
            if (res.result == true) {
              $('#_video').html(res.html);
              $('#videoModal').modal('show');
            }else{
              alert_float('error',response.reason);
            }
          }
      })
  }
  

   
  


  
 