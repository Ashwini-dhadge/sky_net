function changePaymentMethod() {
	payment_gate_way_id = $('input[name="payemt_id"]:checked').val();
	$.ajax({
		url: base_url + _admin + "Dashboard/ChangePaymentGateWay",
		type: "post",
		data: {
			payment_gate_way_id: payment_gate_way_id,
		},
		dataType: "json",
		success: function (response) {
			if (response.result == true) {
				alert_float("success", response.reason);
			} else {
				alert_float("danger", response.reason);
			}
		},
	});
}

$(document).ready(function () {
	var chart;
	var url = base_url + "admin/dashboard/getCategoryWiseSale";

	$.getJSON(url, function (response) {
		options = {
			chart: {
				height: 320,
				type: "pie",
			},
			series: response.series1,
			labels: response.labels1,
			colors: response.colors1,
			legend: {
				show: !0,
				position: "right",
				horizontalAlign: "center",
				verticalAlign: "middle",
				floating: !1,
				fontSize: "14px",
				offsetX: 0,
				offsetY: -10,
			},
			responsive: [
				{
					breakpoint: 600,
					options: {
						chart: {
							height: 240,
						},
						legend: {
							show: !1,
						},
					},
				},
			],
		};
		(chart = new ApexCharts(
			document.querySelector("#pie_chart"),
			options
		)).render();
		(chart = new ApexCharts(
			document.querySelector("#pie_chart1"),
			options
		)).render();
	});
});

// $(function () {
// 	"use strict";

// 	// ==============================================
// 	// Income of the Year (Apex Bar Chart)
// 	// ==============================================
// 	var options = {
// 		chart: {
// 			type: "bar",
// 			height: 375,
// 			toolbar: { show: false },
// 		},
// 		series: [
// 			{
// 				name: "Growth Income",
// 				data: [300, 200, 100, 300, 200, 100, 300],
// 			},
// 			{
// 				name: "Net Income",
// 				data: [230, 100, 140, 200, 180, 80, 200],
// 			},
// 		],
// 		colors: ["#24d2b5", "#20aee3"],
// 		plotOptions: {
// 			bar: {
// 				columnWidth: "40%",
// 				borderRadius: 4,
// 			},
// 		},
// 		grid: {
// 			borderColor: "#f1f1f1",
// 			xaxis: { lines: { show: false } },
// 			yaxis: { lines: { show: true } },
// 		},
// 		xaxis: {
// 			categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
// 			axisBorder: { show: false },
// 			axisTicks: { show: false },
// 		},
// 		yaxis: {
// 			tickAmount: 5,
// 		},
// 		legend: {
// 			show: true,
// 			position: "top",
// 			horizontalAlign: "right",
// 			fontSize: "12px",
// 		},
// 		dataLabels: {
// 			enabled: false,
// 		},
// 	};

// 	var chart = new ApexCharts(document.querySelector("#income-year"), options);
// 	chart.render();
// });

$(function () {
	"use strict";

	var options = {
		chart: {
			type: "area",
			height: 300,
			toolbar: { show: false },
			zoom: { enabled: false },
		},
		series: [
			{
				name: "Active Students",
				data: [120, 150, 180, 140, 200, 230, 250],
			},
		],
		colors: ["#CA151C"], // your admin theme color
		dataLabels: {
			enabled: false,
		},
		stroke: {
			curve: "smooth",
			width: 3,
		},
		fill: {
			type: "gradient",
			gradient: {
				shadeIntensity: 1,
				opacityFrom: 0.4,
				opacityTo: 0,
				stops: [0, 90, 100],
			},
		},
		grid: {
			borderColor: "#f1f1f1",
			strokeDashArray: 4,
		},
		xaxis: {
			categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
			axisBorder: { show: false },
			axisTicks: { show: false },
		},
		yaxis: {
			title: {
				text: "No. of Active Students",
				style: { fontSize: "12px" },
			},
		},
		tooltip: {
			theme: "dark",
			y: {
				formatter: (val) => `${val} Students`,
			},
		},
	};

	var chart = new ApexCharts(
		document.querySelector("#active-students"),
		options
	);
	chart.render();
});
