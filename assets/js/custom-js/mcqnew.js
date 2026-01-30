
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