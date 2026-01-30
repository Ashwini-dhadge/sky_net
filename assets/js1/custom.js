$(document).ready(function() {
 $('form').parsley();
 });

// Generate float alert
function alert_float(type, message) {
    console.log("Asdda");
    var aId, el;
    aId = $('body').find('float-alert').length;
    aId++;
    aId = 'alert_float_' + aId;
    el = $('<div id="' + aId + '" class="float-alert animated fadeInRight col-xs-11 col-sm-4 alert alert-' + type + '"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><span class="fa fa-bell-o" data-notify="icon"></span><span class="alert-title">' + message + '</span></div>');
    $('body').prepend(el);

   setTimeout(function() {
        $('#' + aId).hide('fast', function() {
            $('#' + aId).remove();
        });
    }, 4500); 
}

/*
  Alert Auto hide
*/
 setInterval(function(){
     $('.alert').fadeOut("slow");
}, 3000);


$(document).on('click', '.right-bar-toggle', function() {
       var module_name = $(this).attr('data-module_name');
       $("#right_bar_title").html(module_name)
       if(module_name=="Role Mangement"){
            $('.role_div').show();
            $('.master_div').hide();
       }else{
             $('.role_div').hide();
            $('.master_div').show();
       }
});

$('#country_id').on('change', function() {
  var country_id =  $('#country_id').val();
 
  $.ajax({
      url:base_url+'getState',
      type:'get',
      data:{"country_id":country_id},
      dataType:'json',
      success: function(response) {
         $('#state_id').empty();
        if (response.result == true) {
          $('#state_id').append('<option  value="" >Select State</option>');
          $.each(response.state, function(index,state){
          if(state != '') {
            $('#state_id').append('<option  value="'+state['id']+'" >'+ state['state_name_english']+'</option>');
          }
        })
        $('#state_id').select2('refresh');
        }else{
          alert_float('error',response.reason);
        }
      }
    });

});


$('#state_id').on('change', function() {
  var state_id =  $('#state_id').val();

  $.ajax({
      url:base_url+'getCity',
      type:'get',
      data:{"state_id":state_id},
      dataType:'json',
      success: function(response) {
          $('#city_id').empty();
        if (response.result == true) {
          $('#city_id').append('<option  value="" >Select City</option>');
          $.each(response.districts, function(index,districts){
          if(districts != '') {
            $('#city_id').append('<option  value="'+districts['id']+'" >'+ districts['district_name_english']+'</option>');
          }
        })
        $('#city_id').select2('refresh');
        }else{
          alert_float('error',response.reason);
        }
      }
    });

});

