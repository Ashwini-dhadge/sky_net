$('._select2').select2({
    minimumResultsForSearch: -1
});
$('.__select2').select2({
    minimumResultsForSearch: 1,
    placeholder: "   Select one or more user...",
});

$('#send_to').on('select2:opening select2:closing', function( event ) {
      var $searchfield = $(this).parent().find('.select2-search__field');
      $searchfield.prop('disabled', true);
  });

  function filter_products(){

    var category_id = $('#category_id').val();
    var brand_id   = $('#brand_id').val();
    var status   = $('#status').val();
      
    var data = {
          'category_id': category_id, 
          'brand_id': brand_id, 
          'status': status, 
        };
    exprideProduct(data);
  }

  function resetFilter(){
    
    $('#category_id').val('').trigger('change');
    $('#brand_id').val('').trigger('change');
    $('#status').val('').trigger('change');
    var data = {};
    exprideProduct(data);
  }
  var _expride_product = '';
  function exprideProduct(data='') {
    
     _expride_product = $('#_expride_product').DataTable({
      		"dom": 'fl<"topbutton">tip',
              oLanguage: {
                sProcessing: '<div class="dt-loader"></div'
              },
              processing : true,
              serverSide: true,
              destroy: true,
              pageLength: 10,
              responsive: true,
              order: [[2, "desc"]],
      ajax: {
          url: base_url + _admin+'Dashboard/exprideProduct',
          type: 'POST',
          dataSrc: "data",
          data:data,
      },
      columnDefs: [{responsivePriority: 1 ,targets: 3}],

      "columns": [        
          { "width": "50px",  "title": "Sr. No.", orderable: false,  targets: 1},
          // { "width": "120px",  "title": "Image", orderable: false},  
          { "width": "120px", "title": "SKU" },  
          { "width": "120px", "title": "Product Name" },  
          // { "width": "120px", "title": "Category" },  
          { "width": "80px", "title": "Status" },  
          // { "width": "100px",  "title": "Action", orderable: false },
      ],
     
    });
     
  }
  
$(document).ready(function() {

  filter_products();


  $('#is_multiple').on('change', function() {
    if ($('#is_multiple').is(":checked")){
      $('._hide').css('display','block');
    }else{
      $('._hide').css('display','none');
    }
  });


$('#send_notification').on('click', function(){
  var data = $('form').serialize();
  $.ajax({
    url:base_url+_admin+'Dashboard/sendNotification',
    type:'post',
    data:data,
    dataType:'json',
    success: function(response){
      if (response.result == true) {
        alert_float('success',response.reason);
      }else{
        alert_float('error',response.reason);
      }
    }
  });
});

});

function variantValue(val, name) {
  var x = name.charAt(8);

  $.ajax({
    url:base_url+_admin+'products/getVarianValues',
    type:'get',
    data:{'variant':val},
    dataType:'json',
    success: function(response) {
      if (response.result == true) {
         $("#value_list option").remove();
        $.each(response.variants, function(i, item) {
          $("#value_list").append($("<option>").attr('value', item.value).text(item.value));
        });
      }else{
        alert_float('error',response.reason);
      }
    }
  });
}


function changeStatus(product_id,status='') {
  $.ajax({
    url:base_url+_admin+'products/changeStatus',
    type:'get',
    data:{'id':product_id, 'status': status},
    dataType:'json',
    success: function(response) {
      if (response.result == true) {
        if (status == 1) {
        $('#status_'+product_id).removeClass('badge-danger').addClass('badge-success').attr({'onclick':'changeStatus('+product_id+',0)','title':'Click for In-Active'}).text('Active');
        }else{
        $('#status_'+product_id).removeClass('badge-success').addClass('badge-danger').attr({'onclick':'changeStatus('+product_id+',1)','title':'Click for Active'}).text('In-Active');
        }
        alert_float('success',response.reason);
      }else{
        alert_float('error',response.reason);
      }
    }
  });
}
function in_stock(variant_id,status) {
  $.ajax({
    url:base_url+_admin+'products/inStock',
    type:'get',
    data:{'id':variant_id, 'in_stock': status},
    dataType:'json',
    success: function(response) {
      if (response.result == true) {
        if (status == 1) {
        $('#in_stock_'+variant_id).removeClass('badge-danger').addClass('badge-success').attr({'onclick':'in_stock('+variant_id+',0)','title':'Click for Out Of Stock'}).text('In-Stock');
        }else{
        $('#in_stock_'+variant_id).removeClass('badge-success').addClass('badge-danger').attr({'onclick':'in_stock('+variant_id+',1)','title':'Click for In-Stock'}).text('Out Of Stock');
        }
        alert_float('success',response.reason);
      }else{
        alert_float('error',response.reason);
      }
    }
  });
}
function removeImg(img_id,image) {
   $.ajax({
        url: base_url+_admin+'products/removeImg',
        type: "post",
        data: {
          'img_id': img_id,
          'image':image
        },
        dataType:'json',
        success: function (response) {
          if(response.result == true){
            alert_float('success',response.reason);
            $('#img_'+img_id).remove();
          }else{
            alert_float('danger',response.reason);
          }
        }
    });
 }

$(document).on('change', '#user_type', function(){

  $('#send_to').find('option').not(':first').remove();
  var user_role = $('#user_role').val();
  var user_type = $('#user_type').val();
  if (user_type == 2) {
    $('#user_select').css('display', 'block');

    $.ajax({
      url:base_url+_admin+'Dashboard/getUser',
      type:'get',
      data:{'user_role':user_role},
      dataType:'json',
      success: function(response){
        if (response.result == true) {
            $.each(response.users, function(index, user){
            if(user != '') {
              $('#send_to').append('<option  value="'+user['id']+'" >'+ user['first_name']+' '+user['last_name']+'</option>');
            }
          })
          $('.__select2').select2('refresh');
        }else{
          alert_float('error',response.reason);
        }
      }
    });
   }else{
     $('#user_select').css('display', 'none');
   }
});

