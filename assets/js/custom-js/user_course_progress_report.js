$(".on_date").hide();

$("#on_date").on("change", function () {
	var on_date = $("#on_date").val();
	if (on_date != 6) {
		filter_order();
	} else {
		$(".on_date").show();
	}
});
function resetFilters() {
	// Clear all select2 dropdowns
	$("#course_id").val(null).trigger("change.select2");
	$("#user_id").val(null).trigger("change.select2");

	// Call main listing function again
	listOrders();
}
function filter_order() {
	var course_id = $("#course_id").val();
	var user_id = $("#user_id").val();
	var on_date = $("#on_date").val();
	var on_date = $("#on_date").val();
	var from_date = $("#from_date").val();
	var to_date = $("#to_date").val();

	var data = {
		course_id: course_id,
		user_id: user_id,
		on_date: on_date,
		from_date: from_date,
		to_date: to_date,
	};

	listOrders(data);
}

function resetFilter() {
	$("#on_date").val("");
	$("#from_date").val("");
	$("#to_date").val("");

	var data = {};

	listOrders(data);
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
				base_url +
				_admin +
				"UserCourseProgressReport/listUserCourseProgressReport",
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
			{ width: "120px", title: "Student" },
			{ width: "10px", title: "Course" },
			{ width: "10px", title: "Category" },
			{ width: "10px", title: "Progress" },
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
