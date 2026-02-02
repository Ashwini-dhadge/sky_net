$("select").select2();
$(".datepicker").datepicker();

function filter_users() {
	var status = $("#status").val();
	var data = {
		status: status,
	};

	listUsers(data);
}

function resetFilter() {
	var data = {};

	listUsers(data);
}

function listUsers(data = "") {
	categories = $("#user_datatable").DataTable({
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
			url: base_url + _admin + "User/listUsers",
			type: "POST",
			//dataSrc: "data",
			data: function (d) {
				d.role = $("#role").val();
			},
		},
		columnDefs: [{ responsivePriority: 1, targets: 2 }],

		columns: [
			{ width: "50px", title: "Sr. No.", orderable: false },
			{ width: "80px", title: "Image" },
			{ width: "150px", title: "Name" },
			{ width: "150px", title: "Email" },
			{ width: "50px", title: "Mobile" },
			{ width: "50px", title: "Password" },
			{ width: "50px", title: "Commission Percentage" },
			{ width: "50px", title: "Status" },
			{
				width: "100px",
				title: "Action",
				orderable: false,
				className: "text-right",
			},
		],
	});
}

$(document).ready(function () {
	action = $("#action").val();

	if (action == 2) {
		filter_users_courses();
		filter_users_packages();
	} else {
		filter_users();
	}

	filter_users_video_mcq();
	filter_users_challenge_mcq();
});

$(function () {
	$("#mobile_no").parsley();

	window.Parsley.addAsyncValidator(
		"uniqueMobile",
		function (xhr) {
			let response = xhr.responseJSON;
			return response && response.valid === true;
		},
		function (value, instance) {
			let userId = instance.$element.data("parsley-unique-mobile-id");

			return {
				url: base_url + _admin + "User/checkMobile",
				method: "POST",
				dataType: "json",
				data: {
					mobile_no: value,
					id: userId,
				},
			};
		}
	);
});

function actionUsers(action) {
	var data = $("#imeno_form").serializeArray();
	data.push({ name: "action", value: action });

	$.ajax({
		url: base_url + _admin + "User/updateIMEINO",
		type: "post",
		data: data,
		dataType: "json",
		success: function (response) {
			if (response.result == true) {
				if (action == 2) {
					$("#imei_no").val("");
				}
				alert_float("success", response.reason);
			} else {
				alert_float("error", response.reason);
			}
		},
	});
}
function filter_users_courses() {
	var id = $("#id").val();
	var data = {
		user_id: id,
		type: 1,
	};

	listUsersCourses(data);
}
function listUsersCourses(data = "") {
	categories = $("#userCourse_datatable").DataTable({
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
			url: base_url + _admin + "User/listUsersMyCourses",
			type: "POST",
			dataSrc: "data",
			data: data,
		},
		columnDefs: [{ responsivePriority: 1, targets: 2 }],

		columns: [
			{ width: "50px", title: "Sr. No.", orderable: false },
			{ width: "80px", title: "Courses name" },
			{ width: "80px", title: "Order No" },
			{ width: "50px", title: "Status" },
			{ width: "150px", title: "Purchased Date" },
			{ width: "150px", title: "Expired Date" },
			{ width: "50px", title: "Is Expired" },
		],
	});
}

function filter_users_packages() {
	var id = $("#id").val();

	var data = {
		user_id: id,
		type: 3,
	};

	listUsersPackages(data);
}
function listUsersPackages(data = "") {
	categories = $("#userPackage_datatable").DataTable({
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
			url: base_url + _admin + "User/listUsersMyCourses",
			type: "POST",
			dataSrc: "data",
			data: data,
		},
		columnDefs: [{ responsivePriority: 1, targets: 2 }],

		columns: [
			{ width: "50px", title: "Sr. No.", orderable: false },
			{ width: "80px", title: "Package name" },
			{ width: "80px", title: "Order No" },
			{ width: "50px", title: "Status" },
			{ width: "150px", title: "Purchaed Date" },
			{ width: "150px", title: "Expired Date" },
			{ width: "50px", title: "Is Expired" },
		],
	});
	categories.columns([4, 5, 6]).visible(false);
}

function filter_users_packages() {
	var id = $("#id").val();

	var data = {
		user_id: id,
		type: 3,
	};

	listUsersPackages(data);
}
function listUsersPackages(data = "") {
	categories = $("#userPackage_datatable").DataTable({
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
			url: base_url + _admin + "User/listUsersMyCourses",
			type: "POST",
			dataSrc: "data",
			data: data,
		},
		columnDefs: [{ responsivePriority: 1, targets: 2 }],

		columns: [
			{ width: "50px", title: "Sr. No.", orderable: false },
			{ width: "80px", title: "Package name" },
			{ width: "80px", title: "Order No" },
			{ width: "50px", title: "Status" },
			{ width: "150px", title: "Purchaed Date" },
			{ width: "150px", title: "Expired Date" },
			{ width: "50px", title: "Is Expired" },
		],
	});
	categories.columns([4, 5, 6]).visible(false);
}

function filter_users_video_mcq() {
	var id = $("#id").val();

	var data = {
		user_id: id,
	};

	listUsersMCQVIDEO(data);
}
function listUsersMCQVIDEO(data = "") {
	mcq = $("#user_video_mcq_datatable").DataTable({
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
			url: base_url + _admin + "User/listUsersMyVideoMCQ",
			type: "POST",
			dataSrc: "data",
			data: data,
		},
		columnDefs: [{ responsivePriority: 1, targets: 2 }],

		columns: [
			{ width: "50px", title: "Sr. No.", orderable: false },
			{ width: "80px", title: "MCQ VIDEO Name", orderable: false },
			{ width: "50px", title: "Marks", orderable: false },
			{ width: "150px", title: "Date", orderable: false },
		],
	});
}
function filter_users_challenge_mcq() {
	var id = $("#id").val();

	var data = {
		user_id: id,
	};

	listUsersMCQChallenge(data);
}
function listUsersMCQChallenge(data = "") {
	console.log("Sfsf");
	mcq = $("#user_challenge_datatable").DataTable({
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
			url: base_url + _admin + "User/listUsersMyChallenge",
			type: "POST",
			dataSrc: "data",
			data: data,
		},
		columnDefs: [{ responsivePriority: 1, targets: 2 }],
		columns: [
			{ width: "50px", title: "Sr. No.", orderable: false },
			{ width: "80px", title: "Challenge Name", orderable: false },
			{ width: "50px", title: "Duration", orderable: false },
			{ width: "50px", title: "Solved Duration", orderable: false },
			{ width: "50px", title: "Marks", orderable: false },
			{ width: "150px", title: "Date", orderable: false },
			{ width: "150px", title: "Rank", orderable: false },
			{ width: "150px", title: "image", orderable: false },
		],
	});
}
function filter_users_wallet() {
	var id = $("#id").val();
	var data = {
		user_id: id,
	};
	listUsersWallet(data);
}
function listUsersWallet(data = "") {
	categories = $("#userWallet_datatable").DataTable({
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
			url: base_url + _admin + "User/listUsersMyWallet",
			type: "POST",
			dataSrc: "data",
			data: data,
		},
		columnDefs: [{ responsivePriority: 1, targets: 2 }],

		columns: [
			{ width: "50px", title: "Sr. No.", orderable: false },
			{ width: "80px", title: "Details" },
			{ width: "80px", title: "Amount" },
			{ width: "50px", title: "Type" },
			{ width: "150px", title: "OrderNo" },
			{ width: "150px", title: "created_at" },
		],
	});
}
