var lesson = "";
function listLesson(data = "") {
	var data = {
		course_id: $("#filter_course").val(),   // 🔥 use dropdown
		course_view_type: 1                    // 🔥 static because list page
	};
	if ($("#course_view_type").val() == 1) {
		var title_lbl = "sort by";
	} else {
		var title_lbl = "Course Title";
	}

	lesson = $("#Sections_datatable").DataTable({
		dom: 'fl<"topbutton">tip',
		oLanguage: {
			sProcessing: '<div class="dt-loader"></div',
		},
		processing: true,
		serverSide: true,
		destroy: true,
		pageLength: 10,
		order: [[0, "desc"]],
		ajax: {
			url: base_url + _admin + "Section/sectionList",
			type: "POST",
			dataSrc: "data",
			data: data,
		},
		columnDefs: [{ responsivePriority: 1, targets: 3 }],

		columns: [
			{ width: "10px", title: "Sr.No.", orderable: false },
			{ width: "150px", title: "Course Name" },
			{ width: "60px", title: "Section Title" },
			{ width: "250px", title: "Description" },
			// { width: "60px", title: "Price" },
			// { width: "60px", title: "Status" },
			{
				width: "50px",
				title: "Action",
				orderable: false,
				className: "text-right",
			},
		],
	});
}

$(document).ready(function () {
	listLesson();
	// alert("call");
});

// ⭐ REAL FILTER EVENT ⭐
$(document).on("change", "#filter_course", function () {
	lesson.destroy();
	listLesson();
});

$(document).on("blur", ".updateDataTable", function () {
	var id = $(this).data("id");
	var column = $(this).data("column");
	var value = $(this).text();

	$.ajax({
		url: base_url + "admin/Section/sectionTypeUpdate",
		method: "POST",
		dataType: "json",
		data: { id: id, value: value, column: column },
		success: function (response) {
			if (response.result == true) {
				alert_float("success", response.reason);
				lesson.ajax.reload();
			} else {
				alert_float("danger", response.reason);
			}
		},
	});
});
