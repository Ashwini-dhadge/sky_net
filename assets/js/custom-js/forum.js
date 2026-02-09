$(document).ready(function () {

    if ($('#pendingTable').length) {
        var table = $('#pendingTable').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: base_url + _admin + 'Forum/pending_list',
                type: 'POST'
            },
            columns: [
                { title: "#", orderable: false },
                { title: "Title" },
                { title: "Asked By" },
                { title: "Status" },
                { title: "Action", orderable: false }
            ]
        });


        $(document).on('click', '.approve', function () {
            let id = $(this).data('id');
            if (!confirm('Approve this question?')) return;
            $.post(base_url + _admin + 'Forum/approve',
                { id: id },
                () => table.ajax.reload(null, false)
            );
        });


        $(document).on('click', '.reject', function () {
            let id = $(this).data('id');
            if (!confirm('Reject this question?')) return;
            $.post(base_url + _admin + 'Forum/reject',
                { id: id },
                () => table.ajax.reload(null, false)
            );
        });

    }




    if ($('#questionBody').length) {

        const perPage = 10;
        let currentPage = 1;

        function renderRows(data) {

            let html = '';

            data.forEach(row => {

                let id = row[0];
                let title = row[1];
                let user = row[2];
                let description = row[3];
                let tags = row[4];
                let asked_at = row[5];
                let answers = row[6];

                let tagsHTML = '';

                if (tags) {
                    tags.split(',').forEach(t => {
                        tagsHTML += `<span class="so-tag">${t.trim()}</span>`;
                    });
                }

                html += `
                <tr class="so-row">

                    <td class="so-stats">
                        <div class="so-stat answer">
                        <strong>${answers}</strong> replies
                        </div>
                    </td>

                    <td>
                        <div class="so-summary">

                            <div style="display:flex;justify-content:space-between;">
                                <div class="so-title">${title}</div>
                            <div>
                                <a class="btn btn-secondary btn-sm openAnswers editbtn"
                                data-id="${id}" data-title="${title}" data-user="${user}">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <a href="${base_url}admin/Forum/detail_view/${id}"
                                    class="btn btn-secondary btn-sm viewbtn">
                                    <i class="fa fa-eye"></i>
                                </a>

                                <button class="btn btn-secondary btn-sm deletebtn">
                                    <i class="fa fa-trash deleteQuestion" data-id="${id}"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mt-1 text-muted" style="text-align:justify;">
                        ${description}
                        </div>

                        <div class="so-tags mt-2">${tagsHTML}</div>

                        <div class="so-meta mt-2"
                        style="display:flex;justify-content:space-between;">
                        <span>asked by <b>${user}</b></span>
                        <span>asked <b>${asked_at}</b></span>
                        </div>

                        </div>
                    </td>

                </tr>`;
            });

            $('#questionBody').html(html);
        }

        function renderPager(totalRecords) {

            let totalPages = Math.ceil(totalRecords / perPage);
            let pager = '';

            for (let i = 1; i <= totalPages; i++) {
                pager += `
                <button class="btn btn-sm ${i == currentPage ? 'btn-primary' : 'btn-light'} pageBtn mr-1" style="padding-right:10px;padding-left:10px;"
                    data-page="${i}">
                    ${i}
                </button>`;
            }

            $('#forumPager').html(pager);
        }

        function loadPage(page) {

            currentPage = page;

            $.ajax({
                url: base_url + _admin + 'Forum/approved_list',
                type: 'POST',
                dataType: 'json',
                data: {
                    draw: page,
                    start: (page - 1) * perPage,
                    length: perPage
                },
                success: function (res) {

                    renderRows(res.data);
                    renderPager(res.recordsTotal);

                }
            });
        }

        // Initial Load
        loadPage(1);

        // Page Click
        $(document).on('click', '.pageBtn', function () {
            loadPage($(this).data('page'));
        });

    }

    let currentQuestion = 0;

    $(document).on('click', '.openAnswers', function () {

        currentQuestion = $(this).data('id');

        $('#modalQuestionText').text($(this).data('title'));
        $('#askedByName').text($(this).data('user'));
        $('#answerModal').modal('show');

    });

    $('#answerModal').on('shown.bs.modal', function () {
        loadAnswers();
    });




    function loadAnswers() {

        if ($.fn.DataTable.isDataTable('#answersTable')) {
            $('#answersTable').DataTable().destroy();
        }
        $('#answersTable').DataTable({
            ajax: {
                url: base_url + _admin + 'Forum/answers_json/' + currentQuestion,
                dataSrc: 'data'
            },
            columns: [
                { data: 'id', title: 'ID' },
                { data: 'answer', title: 'Answer', width: '90%' },
                {
                    data: null,
                    title: 'Action',
                    render: d => `
                    <button class="btn btn-danger btn-sm delAns"
                        data-id="${d.id}">
                        Delete
                    </button>`
                }
            ]
        });
    }






    $('#submitAnswerBtn').click(function () {
        let answerHtml = CKEDITOR.instances['newAnswer'].getData();
        if (answerHtml.trim() === '') {
            alert('Answer cannot be empty');
            return;
        }
        $.post(base_url + _admin + 'Forum/addAnswer', {
            forum_id: currentQuestion,
            answer: answerHtml
        }, function () {
            $('#answerEditorModal').modal('hide');
            loadAnswers();
        });

    });



    $(document).on('click', '.delAns', function () {
        $.post(base_url + _admin + 'Forum/deleteAnswer',
            { id: $(this).data('id') },
            loadAnswers);
    });
    $('#openAnswerEditor').click(function () {
        $('#answerEditorModal').modal('show');
    });


    $('#submitQuestion').click(function () {

        let tags = $('#tags_input').val();
        $.post(base_url + _admin + 'Forum/addQuestion', {
            title: $('#questionText').val(),
            description: $('#description').val(),
            tags: tags
        },
            function () {
                $('#addQuestion').modal('hide');
                location.reload();
            });

    });

    $(document).on('click', '.deleteQuestion', function () {

        let id = $(this).data('id');
        if (!confirm('Delete this question and all answers?'))
            return;

        $.post(
            base_url + _admin + 'Forum/deleteQuestion',
            { id: id },
            function (res) {
                location.reload();
            },
            'json'
        );
    });



});
