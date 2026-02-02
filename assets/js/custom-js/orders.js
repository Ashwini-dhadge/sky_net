
  function filter_order(){

    var from_date       = $('#from_date').val();
    var to_date       = $('#to_date').val();
    var status   = $('#status').val();
    var payment_type   = $('#payment_type').val();
      
    var data = {
          'from_date':from_date,
          'to_date':to_date,
          'status': status, 
          'payment_type': payment_type, 
        };

    listOrders(data);
  }

  function resetFilter(){
    $('#from_date').val('');
    $('#to_date').val('');
    $('#status').val('').trigger('change');
    $('#payment_type').val('').trigger('change');
      
    var data = {};

    listOrders(data);
  }
  var orders = '';
  function listOrders(data='') {
    
     orders = $('#orders').DataTable({
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
          url: base_url + _admin+'Order/listOrders',
          type: 'POST',
          dataSrc: "data",
          data:data,
      },
      columnDefs: [{responsivePriority: 1 ,targets: 5}],

      columns: [        
          {  orderable: false, "width": "50px", title: "Sr._No." },
          { "width": "120px", title: "Order No." },       
          { "width": "100px", title: "Order Created<br>Date" },  
          { "width": "180px", title: "User Name" },  
          { "width": "150px", title: "Type" },        
          { "width": "150px", title: "Courses/Package Name" },             
         
          { orderable: false, "width": "100px", title: "Total Amt.", "className": "text-right"},           
          { orderable: false, "width": "100px", title: "Payment" },
          { orderable: false, "width": "100px", title: "Status" },
      ],
     
    });
     
  }
$(document).ready(function() {

  filter_order();
  filter_ongoing_order();
  getUserName();

/* Staus Update */

$('#order_status').on('change', function() {
  var order_status =  $('#order_status').val();
  var order_id =  $('#order_id').val();
  var user_id= $('#order_user_id').val();
  var user_id= $('#order_user_id').val();
    if(order_status==2){
           $('#changeCourses').modal('show');
    }else{
              $.ajax({
              url:base_url+_admin+'Order/orderStatus',
              type:'get',
              data:{"order_id":order_id,"order_status":order_status},
              dataType:'json',
              success: function(response) {
                if (response.result == true) {
                  alert_float('success',response.reason);
                }else{
                  alert_float('error',response.reason);
                }
              }
            });
    }
 
});

});


/* On Going Orders */
  function filter_ongoing_order(){

    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    var status = $('#status').val();
    var payment_type = $('#payment_type').val();
    var delivery_option = $('#type').val();

    var data = {
          'from_date':from_date,
          'to_date':to_date,
          'status': status, 
          'payment_type': payment_type, 
          'delivery_option':delivery_option
        };

    listOnGoingOrders(data);
  }

  var ongoing_orders = '';
  function listOnGoingOrders(data='') {
    
     ongoing_orders = $('#ongoing_orders').DataTable({
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
          url: base_url + _admin+'Order/listOnGoingOrders',
          type: 'POST',
          dataSrc: "data",
          data:data,
      },
      columnDefs: [{responsivePriority: 1 ,targets: 4}],

      columns: [        
          {  orderable: false, "width": "50px", title: "Sr. No." },
          { "width": "80px", title: "Order No." },  
          { "width": "180px", title: "User Name" },  
          { orderable: false, "width": "120px", title: "Mobile" },
          { orderable: false, "width": "100px", title: "Delivery Boy" },
          { orderable: false, "width": "80px", title: "DB Status" },
          { orderable: false, "width": "80px", title: "Delivery" },
          { orderable: false, "width": "80px", title: "Order Status" },
          
      ],
     
    });
     
  }

  function getUserName() {

      var dataList = [];
      var user_id= $('#order_user_id').val();
      $('#user_id').select2({
            placeholder: 'Select Users',
            ajax: {
                url: base_url + _admin+'User/getUsersName/',
                dataType: 'json',
                delay: 250,              
                data: function (data) {
                    return {
                        searchTerm: data.term // search term
                    };

                },
                processResults: function (response) {
                    return {
                        results:response
                    };
                },
                cache: true
            }
        });

  }

  function getCoursesType() {
    var type=$('#type').val();
    if(type==1){
      getCourseName();
       $('#courses_id').empty();
      $('#course_lbl').html('Courses');
        $('#divCourse').show();
        $('#divCourseDuration').show();
    }else if(type==3){
      getPackageName();
       $('#courses_id').empty();
       $('#course_lbl').html('Packages')
         $('#divCourse').show();
         $('#divCourseDuration').hide();
    }else{
      $('#divCourse').hide();
        $('#divCourseDuration').hide();
    }

  
  }
  function getCourseName() {

      var dataList = [];
      $('#courses_id').select2({
            placeholder: 'Select Courses',
            ajax: {
                url: base_url + _admin+'Course/getCourseName',
                dataType: 'json',
                delay: 250,
                data: function (data) {
                    return {
                        searchTerm: data.term // search term
                    };

                },
                processResults: function (response) {
                    return {
                        results:response
                    };
                },
                cache: true
            }
        });
  }
  function getPackageName() {

      var dataList = [];
      $('#courses_id').select2({
            placeholder: 'Select Packages',
            ajax: {
                url: base_url + _admin+'Package/getPackagesName',
                dataType: 'json',
                delay: 250,
                data: function (data) {
                    return {
                        searchTerm: data.term // search term
                    };

                },
                processResults: function (response) {
                    return {
                        results:response
                    };
                },
                cache: true
            }
        });
  }
  function getCoursesDuration(courses_id) {
     var type=$('#type').val();
    if(type==1){
       $.ajax({
        url:base_url+_admin+'Course/getCourseDurationsName',
        type:'post',
        data:{'courses_id':courses_id},
        dataType:'json',
        success: function(response) {   
          $('#courses_duration_id').empty();

          var  city_name='';
          if(response.status == true){
            if(response.duration.length!=0){
               
              html="<option value=''>Select Duration</option>";
              for (var i = 0; i < response.duration.length; i++) {
               
                html +="<option value='"+response.duration[i].id+"' >"+response.duration[i].name+"</option>";
              }
             
              $('#courses_duration_id').append(html);
              $('#courses_duration_id').select2();
            }
            
          }else{
            alert_float('danger', response.reason);
          }
        }
      });
    }else{
      getAmount();
    }
       
}


function getAmount(){
     var type=$('#type').val();
     var courses_id=$('#courses_id').val();
      var courses_duration_id=$('#courses_duration_id').val();
   
            $.ajax({
                    url:base_url+_admin+'Course/getAmount',
                    type:'post',
                    data:{'courses_id':courses_id,'courses_duration_id':courses_duration_id,'type':type},
                    dataType:'json',
                    success: function(response) {   

                      var  city_name='';
                      if(response.status == true){
                       
                         $('#rate').val(response.amount);
                        
                      }else{
                          $('#rate').val(0);
                        alert_float('danger', response.reason);
                      }
                    }
                  });
     
}

