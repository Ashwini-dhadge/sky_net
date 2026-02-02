$('select').select2();
$('.datepicker').datepicker();

  function filter_category(){

    var status    = $('#status').val();
      
    var data = {
          'status': status, 
        };

    listBanner(data);
  }

  function resetFilter(){
    $('#status').val('').trigger('change');
      
    var data = {};

    listBanner(data);
  }
  var categories = '';
  function listBanner(data='') {
    
     banner = $('#banner').DataTable({
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
                  url: base_url + _admin+'Banner/listBanner',
                  type: 'POST',
                  dataSrc: "data",
                  data:data,
              },
              columnDefs: [{responsivePriority: 1 ,targets: 3}],

              columns: [        
                  { "width": "50px",  title: "Sr._No.", orderable:false },
                  { "width": "150px", title: "Title" },  
                  { "width": "150px", title: "Image"  , orderable:false},
                  { "width": "50px", title: "Type" , orderable:false},  
                  { "width": "50px", title: "City" , orderable:false}, 
                  { "width": "50px", title: "status"},  
                  { "width": "60px", title: "Action" , orderable:false, "className": "text-right"},
              ],
     
    });

    if(parseInt(role_access.edit)==1  || parseInt(role_access.delete)==1){
       banner.columns(6).visible(true);
    }else{
        banner.columns(6).visible(false);
    }


     if(parseInt(userRole)==parseInt(admin_role) || parseInt(userRole)==superadmin_role){
       banner.columns(4).visible(true);
    }else{
        banner.columns(4).visible(false);
    }

     
  }
   

  $('.bannerModal').on('click', function() {
    bannerModal();
  });

  function bannerModal(id='') {

    $.ajax({
          url: base_url + _admin+'Banner/bannerModal',
          type: 'POST',
          data: {'id':id},
          dataType:'json',
          success: function(res) {
            if (res.result == true) {
              $('#_banner').html(res.html);
              $('#bannerModal').modal('show');
               $('.select2').select2();
            }else{
              alert_float('error',response.reason);
            }
          }
      })
  }
  //"className": "text-right"
$(document).ready(function() {

  filter_category();


});

  function changeStatus(id,status) {
    $.ajax({
          url: base_url + _admin+'Banner/changeStatus',
          type: 'get',
          data: {'id':id,'is_active':status},
          dataType:'json',
          success: function(res) {
            if (res.result == true) {
              if (status == 1) {
                $('#status_'+id).removeClass('badge-danger').addClass('badge-success').attr({'onclick':'changeStatus('+id+',0)','title':'Click for In-Active'}).text('Active');
                }else{
                $('#status_'+id).removeClass('badge-success').addClass('badge-danger').attr({'onclick':'changeStatus('+id+',1)','title':'Click for Active'}).text('In-Active');
                }
              alert_float('success',res.reason);
            }else{
              alert_float('error',res.reason);
            }
          }
      });
}


$('#country_id').on('change', function() {

      getStates();
});

$('#state_id').on('change', function() {

      getStates();
});

function getStates() {
    var country_id =  $('#country_id').val();
   console.log("Sdfsdf")
    $.ajax({
        url:base_url+_admin+'Banner/getState',
        type:'get',
        data:{"country_id":country_id},
        dataType:'json',
        success: function(response) {
          if (response.result == true) {
            $('#state_id').append('<option  value="" >Select State</option>');
            $.each(response.state, function(index,state){
            if(state != '') {
              $('#state_id').append('<option  value="'+state['id']+'" >'+ state['state_name_english']+'</option>');
            }
          })
          $('#state_id').select2();
          }else{
            alert_float('error',response.reason);
          }
        }
      });
}


$('#state_id').on('change', function() {
  getCity()
});

function getCity() {
  var state_id =  $('#state_id').val();

  $.ajax({
      url:base_url+_admin+'Banner/getCity',
      type:'get',
      data:{"state_id":state_id},
      dataType:'json',
      success: function(response) {
        if (response.result == true) {
          $('#city_id').append('<option  value="" >Select City</option>');
          $.each(response.districts, function(index,districts){
          if(districts != '') {
            $('#city_id').append('<option  value="'+districts['id']+'" >'+ districts['district_name_english']+'</option>');
          }
        })
        $('#city_id').select2();
        }else{
          alert_float('error',response.reason);
        }
      }
    });

}