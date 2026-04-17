var courseTable = "";

$(document).ready(function () {
    courseTable = $("#Certificate_datatable").DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 10,
        autoWidth: false,

        ajax: {
            url: base_url + _admin + "Certificate/certificate_list",
            type: "POST",
            dataSrc: "data",
            data: function (d) {
            },
        },

        order: [[0, "desc"]],

        columns: [
            { title: "ID" },
            { title: "Certificate Title" },
            { title: "Certificate Number" },
            { title: "User" },
            { title: "Course" },
            { title: "Score" },
            { title: "Grade" },
            { title: "Issued Date" },
            { title: "Status" },
            { title: "Action", width: "10%", orderable: false }
        ]
    });

    $("#filter_student").on("change", function () {
        courseTable.ajax.reload();
    });
});


$(document).on('click', '#openCertificateModal', function () {

    let user_id = $('#filter_student').val();

    if (!user_id) {
        alert('Please select student first');
        return;
    }

    $('#certificateModal').modal('show');

    $('#certificateModalBody').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</div>');

    $.ajax({
        url: base_url + _admin + 'Certificate/make_certificate_modal',
        type: 'POST',
        data: { user_id: user_id },
        success: function (res) {
            $('#certificateModalBody').html(res);
        }
    });

});


$(document).on("submit", "#certificateForm", function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        url: base_url + _admin + "Certificate/save_certificate",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,

        success: function (res) {
            let data = JSON.parse(res);
            if (data.status) {
                alert(data.message);
                $("#certificateModal").modal("hide");
                location.reload();
            }
        }
    });
});

$(document).on('click', '.editCertificate', function () {

    let id = $(this).data('id');
    let user_id = $(this).data('user');

    $('#certificateModal').modal('show');

    $('#certificateModalBody').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</div>');

    $.ajax({
        url: base_url + _admin + 'Certificate/make_certificate_modal',
        type: 'POST',
        data: { user_id: user_id, id: id },
        success: function (res) {
            $('#certificateModalBody').html(res);
        }
    });

});

