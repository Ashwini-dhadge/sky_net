var rank = '';
  function listContact(data='') {

    var data = {


          // 'designation':$('#designation').val(),
          // 'police_station':$('#police_station').val(),
        };

        // alert('hi');

      category = $('#contact_datatable').DataTable({

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
                  url: base_url + _admin+'Contact/Contact_list',
                  type: 'POST',
                  dataSrc: "data",
                  data:data
              },

      columnDefs: [{responsivePriority: 1 ,targets: 2}],

      columns: [        
          { "width": "10px",  title: "Sr.No.", orderable:false },         
           { "width": "60px", title: "Name" },
          { "width": "100px", title: "Title" }, 
          { "width": "60px", title: "Description" },
          { "width": "60px", title: "Contact" },
          { "width": "60px", title: "Created At" },

          // { "width": "60px", title: "Action", orderable:false, "className": "text-right" }

      ],
      // console.log(retutn false);
     
    });
     
  }

  $(document).ready(function() {

  listContact();
  // listRankVideo();

});
  $('.contactModal').on('click', function() {
    contactModal();
  });

  function contactModal(id='') {

    $.ajax({
          url: base_url + _admin+'Contact/contactModal',
          type: 'POST',
          data: {'id':id},
          dataType:'json',
          success: function(res) {
            if (res.result == true) {
              $('#_contact').html(res.html);
              $('#contactModal').modal('show');
            }else{
              alert_float('error',response.reason);
            }
          }
      })
  }
  
 