$(document).ready(function () {

    $('#courseQnaTable').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 10,
        ajax: {
            url: base_url + _admin + 'Course/course_qna_list',
            type: 'POST',
            data: function (d) {
                d.course_id = $('#course_id').val();
            }
        },
        columns: [
            { title: "Sr No", orderable: false },
            { title: "Question" },
            { title: "Asked By" },
            { title: "Answered By" },
            { title: "Status" },
            { title: "Action", orderable: false }
        ]

    });

});

function openAnswerModal(id, question, answer = '') {
    $('#qna_id').val(id);
    $('#questionText').html(question);

    if (answer && answer.trim() !== '') {
        $('#answerText').val(answer);
    } else {
        $('#answerText').val('');
    }

    $('#answerModal').modal('show');
}

function saveAnswer() {

    $.ajax({

        url: base_url + _admin + 'Course/save_course_answer',

        type: 'POST',

        dataType: 'json',

        data: {
            qna_id: $('#qna_id').val(),
            answer: $('#answerText').val(),
            answer_by: $('#answer_by').val()
        },

        beforeSend: function () {
            $('#saveAnswerBtn').prop('disabled', true);
        },

        success: function (response) {

            if (response.status) {
                alert(response.message);

                $('#answerModal').modal('hide');

                $('#answerText').val('');

                $('#courseQnaTable')
                    .DataTable()
                    .ajax
                    .reload(null, false);

            } else {

                toastr.error(response.message);
            }
        },

        error: function (xhr) {

            console.log(xhr.responseText);

            toastr.error('Something went wrong');
        },

        complete: function () {

            $('#saveAnswerBtn').prop('disabled', false);
        }
    });
} function loadCourseQna() {
    $('#courseQnaTable').DataTable().ajax.reload();
}

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    if ($(e.target).attr('href') === '#qnaTab') {
        // loadQnaAnalytics();
        loadCourseQna();
    }
});

// function loadQnaAnalytics() {
//     $.get(
//         base_url + _admin + 'Course/course_qna_analytics/' + $('#course_id').val(),
//         function (res) {
//             $('#qna_total').text(res.total);
//             $('#qna_answered').text(res.answered);
//             $('#qna_pending').text(res.pending);

//             if (res.avg_hours > 0) {
//                 $('#qna_avg').text(res.avg_hours);
//                 $('#qna_avg').closest('.card').show();
//             } else {
//                 $('#qna_avg').closest('.card').hide();
//             }
//         },
//         'json'
//     );
// }
