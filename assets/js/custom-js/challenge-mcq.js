var mcq = '';
     function listMCQlist(data='') {
    var data = {
// 'police_station':$('#police_station').val(),

         
        };

      user = $('#mcq_datatable').DataTable({
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
                  url: base_url + _admin+'ChallengeMcq/exam_list',
                  type: 'POST',
                  data: function (d) {
                   
                   
                },
              },
      columnDefs: [{responsivePriority: 1 ,targets: 1}],
      columns: [        
           { "width": "10px",  title: "Sr.No.", orderable:false },         
          { "width": "60px", title: "Exam Title" },         
          { "width": "60px", title: "Description" },
          { "width": "80px", title: "Exam Duration" },
          { "width": "80px", title: "Question type" },
          { "width": "80px", title: "Status" },
          { "width": "80px", title: "No of Question" },
          { "width": "80px", title: "Total Marks" },
          
             { "width": "60px", title: "Action" }

      ],
     
    });
     
  }

  $(document).ready(function() {

  listMCQlist();
  getlessonName();
  listMCQVideolist();
});
function markCaluate(){
  
    var question_type=document.querySelector('input[name="is_negative"]:checked').value;
    var no_of_question=$('#no_of_question').val();
    var total_marks=$('#total_marks').val();
    var total_marks=$('#total_marks').val();

    if((question_type==0 || question_type==1) && total_marks && no_of_question ){
        if(question_type==0){
          var postive_mark= total_marks/no_of_question;
            $('#is_postive_marks').val(postive_mark);
            $("#is_negative_marks").attr("max", postive_mark);
            $('#postive_mark_div').show();
            $('#negative_mark_div').hide();
        }else{
            var postive_mark= total_marks/no_of_question;
            $("#is_negative_marks").attr("max",postive_mark);
            $('#is_postive_marks').val(postive_mark);
           $('#postive_mark_div').show();
           $('#negative_mark_div').show();
        }
    }else{
           $('#is_postive_marks').val(0);
    }
}
 

function getlessonName() {

      var dataList = [];
      $('#lesson_id').select2({
            placeholder: 'Select Lesson',
            ajax: {
                url: base_url + _admin+'ChallengeMcq/listLesson',
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
function listMCQVideolist(data='') {
    var data = {
// 'police_station':$('#police_station').val(),

         
        };

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
                  url: base_url + _admin+'ChallengeMcq/listMCQVideolist',
                  type: 'POST',
                  data: function (d) {
                    d.Challenge_id = $('#Challenge_id').val();
                 
                },
              },
      columnDefs: [{responsivePriority: 1 ,targets: 1}],

      columns: [        
           { "width": "10px",  title: "Sr.No.", orderable:false },         
          { "width": "60px", title: "Skill" },         
          { "width": "60px", title: "Question" },
          { "width": "80px", title: "Answer" },
          { "width": "80px", title: "explantion" },
          { "width": "80px", title: "Option 1" },
          { "width": "80px", title: "Option 2" },
          { "width": "80px", title: "Option 3" },
          { "width": "80px", title: "Option 4" },
          { "width": "80px", title: "Option 5" },
           { "width": "60px", title: "Is Challenge" },
             { "width": "60px", title: "Action" }

      ],
     
    });
     
  }

  $(document).ready(function() {

  listMCQVideolist();

});