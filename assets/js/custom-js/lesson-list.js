var lessonTable = null;

function listLesson() {

    var course_id = $('#course_id').val();

    lessonTable = $("#Lesson_datatable").DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 10,
        order: [[0, "desc"]],

        ajax: {
            url: base_url + _admin + "Course/lesson_list",
            type: "POST",
            data: function (d) {
                d.course_id = course_id;   
            }
        },

        columns: [
            { title: "#", orderable: false },
            { title: "Title" },
            { title: "Section" },
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




function openLessonModel(course_id, section_id, lesson_id) {
    $('#course_id').val(course_id);
    $('#section_id').val(section_id);
    $('#lesson_id').val(lesson_id);

    $('[data-repeater-list="videos"]').empty();

    $('#videoModal').modal('show');

    $.post(
        base_url + _admin + 'Lesson/get_lesson_videos',
        { lesson_id: lesson_id },
        function (res) {
            let videos = JSON.parse(res);

            if (videos.length === 0) {
                $('[data-repeater-create]').click();
                return;
            }

            videos.forEach((v, i) => {

                let item = $(`
                <div data-repeater-item class="video-card mb-3 p-3">

                    <input type="hidden" name="videos[${i}][id]" value="${v.id}">
                    <input type="hidden" name="videos[${i}][old_thumbnail]" value="${v.video_thumbnail}">

                    <div class="d-flex justify-content-between mb-2">
                        <h6 class="mb-0">Video Details</h6>
                        <button data-repeater-delete type="button"
                            class="btn btn-sm btn-outline-danger">✕</button>
                    </div>

                    <div class="row">
                        <div class="col-md-3 text-center">
                            <div class="thumb-box border p-2">
                                <img src="${base_url}assets/uploads/thumbnails/video_thumbnails/${v.video_thumbnail}"
                                     class="video-thumb-preview w-100"
                                     style="height:150px; object-fit:contain;">
                            </div>

                            <input type="file" name="videos[${i}][video_thumbnail]"
                                   class="video-thumb-input form-control mt-2">
                        </div>

                        <div class="col-md-9">
                            <div class="form-group">
                                <label>Video Title</label>
                                <input type="text" name="videos[${i}][video_title]"
                                       class="form-control"
                                       value="${v.video_title}">
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-7">
                                    <label>Vimeo Code</label>
                                    <input type="text" name="videos[${i}][vimo_code]"
                                           class="form-control"
                                           value="${v.vimo_code}">
                                </div>

                                <div class="form-group col-md-5">
                                    <label>Type</label>
                                    <select name="videos[${i}][video_type]"
                                            class="form-control">

                                        <option value="thoratical"
                                          ${v.video_type == 'THORATICAL' ? 'selected' : ''}>
                                          Theoretical
                                        </option>

                                        <option value="practical"
                                          ${v.video_type == 'PRACTICAL' ? 'selected' : ''}>
                                          Practical
                                        </option>

                                        <option value="both"
                                          ${v.video_type == 'BOTH' ? 'selected' : ''}>
                                          Both
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`);
                $('[data-repeater-list="videos"]').append(item);
            });
        }
    );
}



$('#section').select2({
    dropdownParent: $('#videoModal'),
    width: '100%',
    placeholder: "Select Section",
    allowClear: true,
});

$('#lessonForm').on('submit', function (e) {

    e.preventDefault();
    let formData = new FormData(this);

    $.ajax({
        url: base_url + _admin + 'Lesson/save_videos',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (res) {
            alert('Saved Successfully');
            $('#videoModal').modal('hide');
        }
    });
});

