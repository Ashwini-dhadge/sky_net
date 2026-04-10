<br>
<hr>
<style>
    #Lesson_datatable td:nth-child(5) {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 220px;
    }
</style>
<div class="table-responsive">
    <input type="hidden" name="course_id" id="course_id" value="<?= $course[0]['id'] ?>">
    <table id="Lesson_datatable" class="table table-striped dt-responsive"
        style="border-collapse: collapse; border-spacing: 0;width:100%">
    </table>
</div>

<div class="modal fade" id="videoModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title">Add Video</h5>
                <button type="button" class="close" data-dismiss="modal">
                    &times;
                </button>
            </div>
            <div class="modal-body">
                <form id="lessonForm" enctype="multipart/form-data">
                    <input type="hidden" name="course_id" id="course_id" value="<?= $course[0]['id']; ?>">
                    <input type="hidden" name="section_id" id="section_id">
                    <input type="hidden" name="lesson_id" id="lesson_id">
                    <div class="row" style="display:none;">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <select class="form-control select2" id="section">
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="video-repeater">
                        <div data-repeater-list="videos">
                            <div data-repeater-item class="video-card mb-3 p-3 template"
                                style="display:none; border-bottom: 1px dashed #c0c0c0;">

                                <div class="d-flex justify-content-between mb-2">
                                    <h6 class="video-card-title mb-0">Video Details</h6>
                                    <button data-repeater-delete type="button"
                                        class="btn btn-sm btn-outline-danger">✕</button>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 text-center">
                                        <div class="thumb-box border p-2">
                                            <img class="video-thumb-preview w-100"
                                                style="height:150px; object-fit:contain; display:none;">
                                        </div>
                                        <input type="file" accept="image/*" name="video_thumbnail"
                                            class="video-thumb-input form-control mt-2">
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label>Video Title</label>
                                            <input type="text" name="video_title" class="form-control" required>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-7">
                                                <label>Vimeo Code</label>
                                                <input type="text" name="vimo_code" class="form-control">
                                            </div>
                                            <div class="form-group col-md-5">
                                                <label>Type</label>
                                                <select name="video_type" class="form-control">
                                                    <option value="thoratical">Theoretical</option>
                                                    <option value="practical">Practical</option>
                                                    <option value="both">Both</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button data-repeater-create type="button" class="btn btn-success mt-3">+ Add Video</button>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

