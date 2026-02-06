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
    <!-- <input type="hidden" name="course_id" id="course_id" value="<?= $course[0]['id'] ?>"> -->
    <table id="Lesson_datatable" class="table table-striped dt-responsive"
        style="border-collapse: collapse; border-spacing: 0;width:100%">
        <thead>
            <tr>
                <th>Sr.No</th>
                <th>Sequence</th>
                <th>Course Name</th>
                <th>Section Title</th>
                <th>Lesson Title</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>

<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div id="payment"></div>

        </div>
    </div>
</div>