var courseTable = "";

$(document).ready(function () {
	courseTable = $("#Question_datatable").DataTable({
		processing: true,
		serverSide: false,
		destroy: true,
		pageLength: 10,
		autoWidth: false, // 🔥 IMPORTANT

		ajax: {
			url: base_url + _admin + "QuestionAnswer/Question_list",
			type: "POST",
			dataSrc: "data",
			data: function (d) {
				d.course_id = $("#filter_course").val();
				d.unanswered = $("#filter_unanswered").is(":checked") ? 1 : 0;
			},
		},

		order: [[0, "desc"]],

		columns: [
			{ title: "ID" },
			{ title: "Course", width: "20%" },
			{ title: "Ask From", width: "12%" },
			{ title: "Question", width: "25%" },
			{
				title: "Answer",
				width: "25%",
				render: function (data, type, row) {
					if (!data) {
						return '<span class="badge badge-warning">Pending</span>';
					}

					// 🔥 Strip HTML tags
					let text = $("<div>").html(data).text();

					// 🔥 Limit length
					if (text.length > 150) {
						text = text.substring(0, 150) + "...";
					}

					return '<div style="white-space:normal;">' + text + "</div>";
				},
			},

			{ title: "Answered By", width: "12%" },
			{ title: "Action", orderable: false, width: "6%" },
		],
	});

	$("#filter_course, #filter_unanswered").on("change", function () {
		courseTable.ajax.reload();
	});
});

function openAnswerModal(id, question, askedBy, answeredBy, answer = "") {
	$("#qna_id").val(id);

	$("#askedByBox").html(askedBy);
	$("#answeredByBox").html(answeredBy);
	$("#questionText").html(question);

	// CKEditor
	CKEDITOR.instances.answerText.setData(answer || "");
	$("#qnaModal").modal("show");
}

function saveAnswer() {
	var qna_id = $("#qna_id").val();
	var answer = CKEDITOR.instances.answerText.getData().trim();

	// if (answer === '') {
	//   alert('Please enter answer');
	//   return;
	// }

	$.ajax({
		url: base_url + _admin + "QuestionAnswer/saveAnswer",
		type: "POST",
		dataType: "json",
		data: {
			id: qna_id,
			answer: answer,
		},
		success: function (res) {
			if (res.status) {
				$("#qnaModal").modal("hide");
				courseTable.ajax.reload(null, false);

				// 🔥 clear editor after save
				CKEDITOR.instances.answerText.setData("");
			} else {
				alert(res.msg || "Failed to save answer");
			}
		},
	});
}

function confirmDeleteAnswer(id) {
	if (!confirm("Are you sure you want to delete this answer?")) {
		return;
	}

	$.ajax({
		url: base_url + _admin + "QuestionAnswer/deleteAnswer",
		type: "POST",
		dataType: "json",
		data: { id: id },
		success: function (res) {
			if (res.status) {
				$("#qnaModal").modal("hide");
				courseTable.ajax.reload(null, false);
			} else {
				alert(res.msg || "Failed to delete answer");
			}
		},
	});
}
