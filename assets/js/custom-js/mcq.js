var mcq = '';
     function listMCQVideolist(data='') {
    var data = {
// 'police_station':$('#police_station').val(),

         
        };
         $("#mcq_csvtable").empty();
  $("#mcq_csvtable").load("{% static 'newContent.txt' %}", () => MathJax.typeset(['mcq_csvtable']));
      user = $('#mcq_csvtable').DataTable({
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
                  url: base_url + _admin+'LessonVideoMcq/listMCQVideolist',
                  type: 'POST',
               
                dataType: "json",
                
                  data: function (d) {
                    d.lesson_id = $('#lesson_id').val();
                    d.lesson_video_id = $('#lesson_video_id').val();
                     d.course_id = $('#course_id').val();
                   
                }, 
               
              },
    
      columnDefs: [{responsivePriority: 1 ,targets: 1}],

      columns: [        
          { "width": "10px",  title: "Sr.No.", orderable:false },         
          { "width": "60px", title: "Skill" },         
          { "width": "160px", title: "Question" },
          { "width": "80px", title: "Answer" },
        //   { "width": "80px", title: "explantion" },
        //   { "width": "80px", title: "Option 1" },
        //   { "width": "80px", title: "Option 2" },
        //   { "width": "80px", title: "Option 3" },
        //   { "width": "80px", title: "Option 4" },
        //   { "width": "80px", title: "Option 5" },
           { "width": "60px", title: "Is Challenge" },
             { "width": "60px", title: "Action" }

      ],
     
    });
     
  }

  $(document).ready(function() {

  listMCQVideolist();

});

    $('#course_id').on('change', function() {
    var course_id = $('#course_id').val();
    $('#lesson_id').find('option').not(':first').remove();
    $.ajax({
      url: base_url+'admin/LessonVideoMcq/getLessons',
      type:'post',
      data: { 'course_id' : course_id },
      dataType:'json',
      success: function(res){
        if (res.result == true) {
                $.each(res.lesson, function(index, lesson){
                  if(lesson != '') {
                    $('#lesson_id').append('<option  value="'+lesson['id']+'" >'+ lesson['title']+' </option>');
                  }
               });
              // $('.__select2').select2('refresh');
            }else{
              alert_float('error',res.reason);
            }
      }
    });
  });


    $('#lesson_id').on('change', function() {
    var lesson_id = $('#lesson_id').val();
    $('#lesson_video_id').find('option').not(':first').remove();
    $.ajax({
      url: base_url+'admin/LessonVideoMcq/getLessonsVideo',
      type:'post',
      data: { 'lesson_id' : lesson_id },
      dataType:'json',
      success: function(res){
        if (res.result == true) {
                $.each(res.videos, function(index, videos){
                  if(videos != '') {
                    $('#lesson_video_id').append('<option  value="'+videos['id']+'" >'+ videos['title']+' </option>');
                  }
               });
              // $('.__select2').select2('refresh');
            }else{
              alert_float('error',res.reason);
            }
      }
    });
  });
   $('.editMcqModal').on('click', function() {
    editMcqModal();
  });

  function editMcqModal(id='') {

    $.ajax({
          url: base_url + _admin+'LessonVideoMcq/editMcqModal',
          type: 'POST',
          data: {'id':id},
          dataType:'json',
          success: function(res) {
            if (res.result == true) {
              $('#_edit_mcq').html(res.html);
              $('#editMcqModal').modal('show');
            }else{
              alert_float('error',response.reason);
            }
          }
      })
  }