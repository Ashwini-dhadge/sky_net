var lesson = '';

function listLesson() {

  lesson = $('#lesson_datatable').DataTable({
    dom: 'fl<"topbutton">tip',
    processing: true,
    serverSide: true,
    destroy: true,
    pageLength: 25,
    order: [[0, "desc"]],
    ajax: {
      url: base_url + _admin + 'Lesson/lesson_list',
      type: 'POST',
      dataSrc: 'data'
    },
    columnDefs: [
      { responsivePriority: 1, targets: 3 }
    ],
    columns: [
      { title: "Sr.No.", orderable: false },
      { title: "Course Title" },
      { title: "Lesson Title" },
      { title: "Price" },
      { title: "Duration" },
      { title: "Status" },
      { title: "Action", orderable: false, className: "text-right" }
    ]
  });
}

$(document).ready(function () {
  listLesson();
});

function deleteLesson(id) {

  if (!id) return;

  if (confirm("Are you sure you want to delete this lesson?")) {
    $.ajax({
      url: base_url + _admin + 'Lesson/deleteLesson',
      type: 'POST',
      data: { id: id },
      dataType: 'json',
      success: function (res) {
        if (res.status === true) {
          alert_float('success', res.message);
          lesson.ajax.reload(null, false);
        } else {
          alert_float('danger', res.message);
        }
      },
      error: function () {
        alert_float('danger', 'Something went wrong');
      }
    });
  }
}
