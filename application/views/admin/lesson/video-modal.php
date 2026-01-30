<!-- <div class="modal fade bs-example-modal-xl" id="SModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-scrollable" role="document">
        <div class="modal-content"> -->
<div class="modal-header">
    <h5 class="modal-title">Add Video</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form class="custom-validation repeater " action="<?= base_url('admin/Lesson/addVideoMapping'); ?>" method="post"
        id="formProduct" enctype="multipart/form-data">
        <div class="row p-3 mb-0">
            <div class="form-group col-md-6">
                <label for="example-text-input" class=" col-form-label">Select Sub
                    Section</label>
                <div>
                    <select class="form-control form-control-md select2" id="sub_section" multiple name="sub_section[]"
                        required>
                    </select>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="example-text-input" class=" col-form-label">Select Type Video</label>
                <div>
                    <select class="form-control form-control-md select2 video_type" id="video_type" name="video_type"
                        required>
                        <option>Select Type Video</option>
                        <option value="1">Theoratical</option>
                        <option value="2">Practical</option>
                        <option value="3">Both</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row p-3 repeater">
            <div data-repeater-list="video_list">
                <div data-repeater-item class="video-item border border-secondary rounded p-4 mb-2  bg-light">
                    <div class="row">
                        <div class="col-md-6 ">
                            <label class="form-label"><strong>Video Title</strong></label>
                            <input type="text" class="form-control form-control-md video_title mb-2" name="video_title"
                                placeholder="Enter Video Title" required>
                        </div>
                        <div class="col-md-6 ">
                            <label class="form-label"><strong>Video Type</strong></label>
                            <input type="text" class="form-control form-control-md  video_type_field mb-2"
                                name="video_type_field" placeholder="Auto" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><strong>Duration</strong></label>
                            <input type="text" class="form-control form-control-md  duration mb-2" name="duration"
                                placeholder="Enter Duration (e.g. 10:25)" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><strong>Vimeo Code</strong></label>
                            <input type="text" class="form-control form-control-md  vimeo_code mb-2" name="vimeo_code"
                                placeholder="Enter Vimeo Code" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label"><strong>Video Thumbnail</strong></label>
                            <input type="file" class="form-control form-control-md  thumbnail mb-2" name="thumbnail"
                                accept="image/*">
                        </div>
                    </div>
                </div>
            </div>
            <button data-repeater-create type="button" style="display:none;"></button>
        </div>

        <div class="row">
            <div class="form-group mb-0 col-md-12">
                <div class="col-md-6  mb-3" style="float: right;">
                    <button type="submit" id="submit" class="btn btn-primary waves-effect waves-light mr-1">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- <script src="<?= base_url(); ?>assets/pages/form-repeater.int.js"></script> -->
<!-- <script src="<?= base_url(); ?>assets/libs/select2/js/select2.min.js"></script> -->
<script>
$(document).ready(function() {
    var section_id = $("#section_id").val();
    $('#sub_section').select2({
        dropdownParent: $('#videosModal'),
        placeholder: "Select Sub Section",
        allowClear: true,
        width: '100%',
        ajax: {
            url: base_url + _admin + "Lesson/getSubSections",
            type: "POST",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term,
                    section_id: section_id
                };
            },
            processResults: function(data) {
                // data should be an array of objects: [{id:1,text:'Sub Section 1'}, ...]
                return {
                    results: data
                };
            },
            cache: true
        },

    });

});
$('#video_type').select2({
    dropdownParent: $('#videosModal'),
    placeholder: "Select Type",
    allowClear: true,
    width: '100%',
});
$('.repeater').repeater({
    initEmpty: true
});

$(document).on("change", ".video_type", function() {
    let val = $(this).val();

    // Remove all repeater items
    $('.repeater [data-repeater-item]').remove();

    // Function to add item
    function addItem() {

        $('[data-repeater-create]').click();
        console.log("Adding item");
    }

    if (val == "1" || val == "2") {
        // Add ONE repeater item
        addItem();
    }

    if (val == "3") {
        // Add TWO repeater items
        addItem();
        addItem();
    }
});
</script>
<!-- </div>
    </div>
</div> -->