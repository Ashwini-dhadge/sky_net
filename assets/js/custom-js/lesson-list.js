var lessonTable = null;

function listLesson() {

    var course_id = $('#course_id').val();

    lessonTable = $("#Lesson_datatable").DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 25,
        order: [[0, "desc"]],

        ajax: {
            url: base_url + _admin + "Course/lesson_list",
            type: "POST",
            data: function (d) {
                d.course_id = course_id;   // 🔥 PASS COURSE ID
            }
        },

        columns: [
            { title: "#", orderable: false },
            { title: "Title" },
            { title: "Duration" },
            { title: "Section" },
            { title: "Lesson Type" },
            { title: "Action", orderable: false, className: "text-right" }
        ]
    });
}

/* ===== LOAD DATATABLE WHEN TAB OPENS ===== */
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

    var target = $(e.target).attr("href");

    if (target === '#lessonTab') {

        if (!$.fn.DataTable.isDataTable('#Lesson_datatable')) {
            listLesson();
        } else {
            lessonTable.ajax.reload(null, false);
        }
    }
});
