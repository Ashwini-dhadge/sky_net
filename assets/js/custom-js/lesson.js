var lesson = "";

function listLesson() {
	lesson = $("#Lesson_datatable").DataTable({
		processing: true,
		serverSide: true,
		destroy: true,
		pageLength: 25,
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
			{ data: 1 },
			{ data: 2 },
			{ data: 3 },
			{ data: 4 },
			{ data: 5 },
			{ data: 6, orderable: false, className: "text-right" },
		],
	});
}

$(document).ready(function () {
	listLesson();

	/* ===== COURSE CHANGE ===== */
	$("#filter_course").on("change", function () {
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

	/* ===== SECTION CHANGE ===== */
	$("#filter_section").on("change", function () {
		lesson.ajax.reload();
	});
});

/* ===== DELETE LESSON ===== */
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
