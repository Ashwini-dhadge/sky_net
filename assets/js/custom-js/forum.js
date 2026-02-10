$(document).ready(function () {

    if ($('#pendingTable').length) {
        var table = $('#pendingTable').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: base_url + _admin + 'Forum/pending_list',
                type: 'POST',
                data: function (d) {
                    d.status = $('#statusFilter').val();
                }
            },
            columns: [
                { title: "#", orderable: false },
                { title: "Title" },
                { title: "Asked By" },
                { title: "Status" },
                { title: "Action", orderable: false }
            ]
        });

        $('#statusFilter').on('change', function () {
            table.ajax.reload();
        });
        $(document).on('click', '.returnPending', function () {

            let id = $(this).data('id');

            if (!confirm('Return this question to Pending?')) return;

            $.post(base_url + _admin + 'Forum/returnToPending',
                { id: id },
                function () {
                    table.ajax.reload(null, false);
                }
            );

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

            $('#reject_forum_id').val(id);
            $('#reject_reason').val('');

            $('#rejectModal').modal('show');
            
            $('#rejectModal').on('shown.bs.modal', function () {
                $('#reject_reason').focus();
            });


        });

        $('#confirmReject').on('click', function () {

            let id = $('#reject_forum_id').val();
            let reason = $('#reject_reason').val().trim();

            if (reason === '') {
                alert('Reason required');
                return;
            }

            $.post(base_url + _admin + 'Forum/reject',
                {
                    id: id,
                    reason: reason
                },
                function () {

                    $('#rejectModal').modal('hide');
                    table.ajax.reload(null, false);

                }
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
                        tagsHTML += `<span class="tag-pill">${t.trim()}</span>`;
                    });
                }

                html += `
                        <tr>
                            <td colspan="2">
                                <div class="q-card-pro">
                                    <div class="q-header">
                                        <div class="q-header-left">
                                            <div class="q-title">${title}</div>
                                            <div class="q-meta">
                                                <span class="q-user">${user}</span>
                                                <span class="dot"></span>
                                                ${asked_at}
                                                <span class="dot"></span>
                                                ${answers} replies
                                            </div>
                                        </div>
                                    </div>
                                    <div class="q-desc">
                                        ${description}
                                    </div>
                                    <div class="q-footer">
                                        <div class="q-tags"> ${tagsHTML} </div>
                                        <div class="q-actions">
                                            <a class="btn btn-success btn-sm openAnswers editbtn"
                                                data-id="${id}" data-title="${title}" data-user="${user}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="${base_url}admin/Forum/detail_view/${id}"
                                                class="btn btn-light btn-sm">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <button class="btn btn-danger btn-sm deletebtn deleteQuestion">
                                                <i class="fa fa-trash " data-id="${id}"></i>
                                            </button>
                                        </div>
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
