var video = "";
function listVideo(data = "") {
	var data = {
		// 'designation':$('#designation').val(),
		// 'police_station':$('#police_station').val(),
	};

	video = $("#sub_section_tbl").DataTable({
		dom: 'fl<"topbutton">tip',
		oLanguage: {
			sProcessing: '<div class="dt-loader"></div',
		},
		processing: true,
		serverSide: true,
		destroy: true,
		pageLength: 5,
		order: [[0, "desc"]],
		ajax: {
			url: base_url + _admin + "Lesson/subsection_list",
			type: "POST",
			dataSrc: "data",
			data: data,
		},
		columnDefs: [{ responsivePriority: 1, targets: 2 }],

		columns: [
			{ width: "10px", title: "Sr.No.", orderable: false },
			{ width: "100px", title: "Video Title" },
			{ width: "60px", title: "Video Type" },
			{ width: "60px", title: "Duration" },
			{
				width: "60px",
				title: "Action",
				orderable: false,
				className: "text-right",
			},
		],
	});
}

$(document).ready(function () {
	// listVideo();
	// listVideolist();
	// listMCQVideolist();
});

function listVideolist(data = "") {
	var data = {
		// 'police_station':$('#police_station').val(),
	};

	user = $("#video_csvtable").DataTable({
		dom: 'fl<"topbutton">tip',
		oLanguage: {
			sProcessing: '<div class="dt-loader"></div',
		},
		processing: true,
		serverSide: true,
		destroy: true,
		pageLength: 25,
		order: [[0, "desc"]],
		ajax: {
			url: base_url + _admin + "Lesson/listVideolist",
			type: "POST",
			data: function (d) {
				d.v_id = $("#v_id").val();
			},
		},
		columnDefs: [{ responsivePriority: 1, targets: 1 }],

		columns: [
			{ width: "10px", title: "Sr.No.", orderable: false },
			{ width: "60px", title: "Title" },
			{ width: "60px", title: "Language" },
			{ width: "60px", title: "Duration" },
			{ width: "60px", title: "Question MCQ" },
			{ width: "80px", title: "CSV File" },
		],
	});
}

$(".MCQCSVModal").on("click", function () {
	var lesson_video_id = $(this).attr("lesson_video_id");
	var lesson_id = $(this).attr("lesson_id");

	// mcqModal(lesson_video_id,lesson_id);
});

function mcqModal(lesson_video_id = "", lesson_id = "") {
	$.ajax({
		url: base_url + _admin + "Lesson/csvMCQModal",
		type: "POST",
		data: { lesson_video_id: lesson_video_id, lesson_id: lesson_id },
		dataType: "json",
		success: function (res) {
			if (res.result == true) {
				$("#_mcq").html(res.html);
				$("#mcqModal").modal("show");
			} else {
				alert_float("error", response.reason);
			}
		},
	});
}
function videoModal(id = "") {
	$.ajax({
		url: base_url + _admin + "Lesson/addVideoModal",
		type: "POST",
		data: { id: id },
		dataType: "json",
		success: function (res) {
			if (res.result == true) {
				$("#video_banner").html(res.html);
				$("#videosModal").modal("show");
			} else {
				alert_float("error", response.reason);
			}
		},
	});
}
