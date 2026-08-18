$(".on_date").hide();

$("#on_date").on("change", function () {
	var on_date = $("#on_date").val();
	if (on_date != 6) {
		filter_order();
	} else {
		$(".on_date").show();
	}
});

var isResetting = false;

function filter_order() {
	if (isResetting) return;
	var batch_id = $("#batch_id").val();
	var course_id = $("#course_id").val();
	var section_id = $("#section_id").val();
	var lesson_id = $("#lesson_id").val();
	var user_id = $("#user_id").val();
	var on_date = $("#on_date").val();
	var from_date = $("#from_date").val();
	var to_date = $("#to_date").val();

	var data = {
		batch_id: batch_id,
		course_id: course_id,
		section_id: section_id,
		lesson_id: lesson_id,
		user_id: user_id,
		on_date: on_date,
		from_date: from_date,
		to_date: to_date,
	};

	listOrders(data);
}

function resetFilters() {
	isResetting = true;
	$("#batch_id").val(null).trigger("change");
	$("#course_id").val(null).trigger("change");
	$("#section_id").val(null).trigger("change");
	$("#lesson_id").val(null).trigger("change");
	$("#user_id").val(null).trigger("change");
	isResetting = false;

	listOrders({});
}
var report_sales = "";
function listOrders(data = "") {
	report_sales = $("#report_sales").DataTable({
		dom: 'fl<"topbutton">tip',
		oLanguage: {
			sProcessing: '<div class="dt-loader"></div',
		},
		processing: true,
		serverSide: true,
		destroy: true,
		pageLength: 25,
		order: [[3, "desc"]],
		ajax: {
			url:
				base_url + _admin + "LearnerProgressReport/listLearnerProgressReport",
			type: "POST",
			dataSrc: "data",
			data: data,
			function(d) {
				return JSON.stringify(d);
			},
		},
		columnDefs: [{ responsivePriority: 1, targets: 2 }],

		columns: [
			{ orderable: false, width: "50px", title: "Sr._No." },
			// { width: "120px", title: "Type" },
			{ width: "120px", title: "Student Name" },
			{ width: "10px", title: "Course Name" },
			{ width: "10px", title: "Section Name" },
			{ width: "10px", title: "Lesson Name" },
			{ width: "10px", title: "Total Questions" },
			{ width: "10px", title: "Correct Question" },
			{ width: "10px", title: "Wrong Question" },
			// { width: "10px", title: "Progress" },
			// { width: "10px", title: "Action", orderable: false },
		],
		drawCallback: function (settings) {
			// Here the response
			var response = settings.json;
			console.log(response);
		},
	});
}
$(document).ready(function () {
	filter_order();
});

$("#course_id").select2({
	placeholder: "Search Course",
	allowClear: true,
	width: "100%",
	ajax: {
		url: base_url + "admin/UserCourseProgressReport/list_course",
		type: "get",
		dataType: "json",
		delay: 250,

		data: function (params) {
			return {
				searchTerm: params.term, // user typing text
			};
		},

		processResults: function (response) {
			return {
				results: response,
			};
		},

		cache: true,
	},
});
$("#course_id").on("change", function () {
	$("#section_id").val(null).trigger("change");
});
$("#section_id").select2({
	placeholder: "Select section first choose course",
	allowClear: true,
	width: "100%",
	ajax: {
		url: base_url + "admin/UserCourseProgressReport/list_section",
		type: "get",
		dataType: "json",
		delay: 250,

		data: function (params) {
			return {
				searchTerm: params.term,
				course_id: $("#course_id").val(),
			};
		},

		processResults: function (response) {
			return {
				results: response,
			};
		},

		cache: true,
	},
});
$("#section_id").on("change", function () {
	$("#lesson_id").val(null).trigger("change");
});
$("#lesson_id").select2({
	placeholder: "Select lesson first choose section",
	allowClear: true,
	width: "100%",
	ajax: {
		url: base_url + "admin/UserCourseProgressReport/list_lesson",
		type: "get",
		dataType: "json",
		delay: 250,

		data: function (params) {
			return {
				searchTerm: params.term,
				course_id: $("#course_id").val(),
				section_id: $("#section_id").val(),
			};
		},

		processResults: function (response) {
			return {
				results: response,
			};
		},

		cache: true,
	},
});

$("#user_id").select2({
	placeholder: "Search User",
	allowClear: true,
	width: "100%",
	ajax: {
		url: base_url + "admin/UserCourseProgressReport/list_user",
		type: "get",
		dataType: "json",
		delay: 250,

		data: function (params) {
			return {
				searchTerm: params.term,
			};
		},

		processResults: function (response) {
			return {
				results: response,
			};
		},

		cache: true,
	},
});

function initBatchSelect2() {
	if ($.fn.select2) {
		$("#batch_id").select2({
			placeholder: "Search Batch...",
			allowClear: true,
			width: "100%",
			ajax: {
				url: base_url + "admin/LearnerProgressReport/list_batch",
				type: "get",
				dataType: "json",
				delay: 250,

				data: function (params) {
					return {
						searchTerm: params.term,
					};
				},

				processResults: function (response) {
					return {
						results: response,
					};
				},

				cache: true,
			},
		});
	}
}

initBatchSelect2();

function viewSectionResult(courseId, sectionId, userId) {
	console.log("Course:", courseId);
	console.log("Section:", sectionId);
	console.log("userId:", userId);

	$.ajax({
		url: base_url + "admin/LearnerProgressReport/getSectionResult",
		type: "POST",
		data: {
			course_id: courseId,
			section_id: sectionId,
			user_id: userId,
		},
		success: function (res) {
			let data = JSON.parse(res);
			renderSectionResultCard(data);

			// scroll smoothly to result section
			$("html, body").animate(
				{
					scrollTop: $("#resultDashboard").offset().top - 80,
				},
				600
			);
		},
	});
}
function renderSectionResultCard(apiData) {
	// <div class="info-row"><span>Date:</span><span>N/A</span></div>
	// <div class="info-row"><span>Duration:</span><span>00:00:00</span></div>
	let item = apiData[0];
	let result = JSON.parse(item.result);

	let totalQ = parseInt(item.no_of_question);
	let correct = parseInt(result.correct_question);
	let wrong = parseInt(result.wrong_question);
	let attempted = correct + wrong;
	let score = Math.round((correct / totalQ) * 100);
	let marksText = correct + "/" + totalQ + " marks";
	let initial = item.student_name.charAt(0);

	let html = `
    <div class="exam-card">

        <div class="exam-header">
            <div class="student-box">
                <div class="student-avatar">${initial}</div>
                <div>
                    <div class="exam-title">${item.student_name}</div>
                    <div class="exam-sub">${item.section_name}</div>
                </div>
            </div>

            <div class="score-box">
                <span>Score</span>
                <div class="score-big">${score}%</div>
            </div>
        </div>

        <div class="exam-body">

            <div class="info-row"><span>Exam:</span><span>${item.lesson_name}</span></div>
           

            <div class="exam-stats">
                <div class="stat stat-blue">
                    <div class="stat-number">${totalQ}</div>
                    <div>Total</div>
                </div>

                <div class="stat stat-green">
                    <div class="stat-number">${correct}</div>
                    <div>Correct</div>
                </div>

                <div class="stat stat-red">
                    <div class="stat-number">${wrong}</div>
                    <div>Wrong</div>
                </div>
            </div>

            <div class="progress-label">${marksText}</div>
            <div class="progress-bar-custom">
                <div class="progress-fill-custom" style="width:${score}%"></div>
            </div>

           

        </div>
    </div>
    `;

	$("#resultDashboard").show();
	$("#resultCardContainer").html(html);
}
