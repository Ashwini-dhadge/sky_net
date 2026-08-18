var isResetting = false;

function filter_order() {
	if (isResetting) return;
	var course_id = $("#course_id").val();
	var user_id = $("#user_id").val();
	var course_type = $("#course_type").val();
	var batch_id = $("#batch_id").val();
	var data = {
		course_id: course_id,
		user_id: user_id,
		course_type: course_type,
		batch_id: batch_id,
	};

	listOrders(data);
}

function resetFilter() {
	isResetting = true;
	$("#course_type").val(null).trigger("change");
	$("#course_id").val(null).trigger("change");
	$("#user_id").val(null).trigger("change");
	$("#batch_id").val(null).trigger("change");
	$("#batch_wrapper").hide();
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
			url: base_url + _admin + "FinalExamReport/listFinalExamReport",
			type: "POST",
			dataSrc: "data",
			data: data,
			function(d) {
				return JSON.stringify(d);
			},
		},
		columnDefs: [{ responsivePriority: 1, targets: 2 }],

		columns: [
			{ orderable: false, width: "50px", title: "Sr.No." },
			// { width: "120px", title: "Type" },
			{ width: "120px", title: "Student" },
			{ width: "10px", title: "Course" },
			{ width: "10px", title: "Total Question" },
			{ width: "10px", title: "Correct" },
			{ width: "10px", title: "Wrong" },
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
	placeholder: "Search Course...",
	allowClear: true,
	width: "100%",
	ajax: {
		url: base_url + "admin/FinalExamReport/list_course",
		type: "get",
		dataType: "json",
		delay: 250,

		data: function (params) {
			return {
				searchTerm: params.term,
				course_type: $("#course_type").val(),
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
		url: base_url + "admin/FinalExamReport/list_user",
		type: "get",
		dataType: "json",
		delay: 250,

		data: function (params) {
			return {
				searchTerm: params.term,
				user_type: $("#course_type").val(),
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
				url: base_url + "admin/FinalExamReport/list_batch",
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

$("#course_type").select2({
	placeholder: "Search Course Type",
	allowClear: true,
	width: "100%",
});
$("#course_type").on("change", function () {
	if (!isResetting) {
		// clear selected values
		$("#course_id").val(null).trigger("change");
		$("#user_id").val(null).trigger("change");
		$("#batch_id").val(null).trigger("change");
	}

	var courseType = $(this).val();
	if (courseType === "0") {
		$("#batch_wrapper").show();
		initBatchSelect2();
	} else {
		$("#batch_wrapper").hide();
	}
});
