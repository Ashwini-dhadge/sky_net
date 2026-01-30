

$(document).on('blur', '.updateDataTable', function(){
   var id = $(this).data("id");  
   var column = $(this).data("column");  
  var value = $(this).text();
  
   $.ajax({
    url:base_url+'admin/About/aboutTypeUpdate',  
    method:"POST",
      dataType: 'json',
    data:{id:id, value:value,column:column},   
    success: function(response) {
      if(response.result == true){
     
        alert_float('success',response.reason);
       lesson.ajax.reload();
      }else{
        alert_float('danger',response.reason);
      }
    }
    })
  });
