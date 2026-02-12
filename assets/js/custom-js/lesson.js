var lesson = "";

function listLesson() {
	lesson = $("#Lesson_datatable").DataTable({
		processing: true,
		serverSide: true,
		destroy: true,
		pageLength: 10,
		order: [[0, "desc"]],

		ajax: {
			url: base_url + _admin + "Lesson/lesson_List",
			type: "POST",
			data: function (d) {
				d.course_id = $("#filter_course").val();
				d.section_id = $("#filter_section").val();
			},
			dataSrc: "data",
		},

		columns: [
			{ data: 0, orderable: false },
			{ title: "Sequence" },
			{ title: "Course" },
			{ title: "Section" },
			{ title: "Lesson" },

			{
				title: "Action",
				orderable: false,
				render: function (data) {

					return `
                <a href="javascript:void(0);"
                    class="btn btn-sm btn-outline-secondary text-warning mr-1"
                    onclick="openLessonModel(${data.course_id},${data.section_id},${data.lesson_id})">
                    <i class="fa fa-book"></i>
                </a>

                <a href="${base_url + _admin}Lesson/mcq/${data.lesson_id}"
                    class="btn btn-sm btn-outline-secondary text-primary mr-1">
                    <i class="fa fa-list"></i>
                </a>

                <a href="${base_url + _admin}Lesson/edit/${data.lesson_id}"
                    class="btn btn-sm btn-success mr-1">
                    <i class="fa fa-edit"></i>
                </a>

                <a href="javascript:void(0);"
                    class="btn btn-sm btn-danger"
                    onclick="deleteLesson(${data.lesson_id})">
                    <i class="fa fa-trash"></i>
                </a>
            `;
				}
			}
		]

	});
}

$(document).ready(function () {
	listLesson();

	$('#filter_course').on('change', function () {

		let courseId = $(this).val();
		$("#filter_section").html('<option value="">All Sections</option>');

		if (courseId) {
			
			$.ajax({
				url: base_url + _admin + "Lesson/getSectionsByCourse",
				type: "POST",
				data: { course_id: courseId },
				dataType: "json",
				success: function (res) {
					if (res.status) {
						$.each(res.data, function (i, item) {
							$("#filter_section").append(
								`<option value="${item.id}">${item.title}</option>`
							);
						});
					}
				},
			});
		}

		lesson.ajax.reload();
	});

	$('#filter_section').on('change', function () {
		lesson.ajax.reload();
	});
});

function deleteLesson(id) {
	if (!id) return;

	if (confirm("Are you sure you want to delete this lesson?")) {
		$.ajax({
			url: base_url + _admin + "Lesson/deleteLesson",
			type: "POST",
			data: { id: id },
			dataType: "json",
			success: function (res) {
				if (res.status === true) {
					alert_float("success", res.message);
					lesson.ajax.reload(null, false);
				} else {
					alert_float("danger", res.message);
				}
			},
			error: function () {
				alert_float("danger", "Something went wrong");
			},
		});
	}
}


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
                <div data-repeater-item class="video-card mb-3 p-3" style="border-bottom: 1px dashed #c0c0c0;">

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

