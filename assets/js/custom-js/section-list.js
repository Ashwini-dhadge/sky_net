var sectionsDT = "";

function listSections() {

    var data = {
        course_id: $("#section_course_id").val(),
        course_view_type: $("#section_view_type").val(),
    };

    sectionsDT = $("#Sections_datatable").DataTable({
        dom: 'fl<"topbutton">tip',
        oLanguage: {
            sProcessing: '<div class="dt-loader"></div>',
        },
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 25,
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
            { width: "150px", title: "Section Title" },
            { width: "250px", title: "Description" },
            {
                width: "80px",
                title: "Action",
                orderable: false,
                className: "text-right",
            },
        ],
    });
}

$(document).ready(function () {
    listSections();
});
