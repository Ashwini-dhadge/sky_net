$(document).ready(function () {

    $('#resourceTable').DataTable({
        processing: true,
        serverSide: false, // 🔥 FIX
        destroy: true,

        ajax: {
            url: base_url + _admin + 'Course/CourseResource',
            type: 'POST',
            dataSrc: 'data', // 🔥 REQUIRED
            data: function (d) {
                d.course_id = $('#course_id').val();
            }
        },

        columns: [
            { title: "Sr No" },
            { title: "Notes" },
            { title: "File" },
            { title: "Created By" },
            { title: "Created At" },
            { title: "Action", orderable: false }
        ]
    });

});


$(document).on('click', '.deleteResource', function () {

    if (!confirm('Delete resource?')) return;

    let id = $(this).data('id');

    $.post(
        base_url + _admin + 'Course/deleteCourseResource',
        { id: id },
        function () {
            $('#resourceTable').DataTable().ajax.reload(null, false);
        }
    );
});
