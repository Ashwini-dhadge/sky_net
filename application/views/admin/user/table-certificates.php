<?php
$CI = &get_instance();
?>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Certificate</th>
            <th>Course</th>
            <th>Score</th>
            <th>Grade</th>
            <th>Issue Date</th>
            <th>File</th>
        </tr>
    </thead>

    <tbody>
        <?php if (!empty($certificates)) { ?>
            <?php $i = 1;
            foreach ($certificates as $row) { ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $row['certificate_title'] ?></td>
                    <td>
                        <?php
                        if (!empty($row['external_course'])) {
                            echo $row['external_course'];
                        } else {
                            $course = $CI->CommonModel->getData(
                                'tbl_courses',
                                ['id' => $row['course_id']],
                                'title',
                                '',
                                'row_array'
                            );
                            echo !empty($course['title']) ? $course['title'] : '-';
                        }
                        ?>
                    </td>
                    <td><?= !empty($row['score']) ? $row['score'] : '-' ?></td>
                    <td><?= !empty($row['grade']) ? $row['grade'] : '-' ?></td>
                    <td><?= !empty($row['issued_date']) ? date('d M Y', strtotime($row['issued_date'])) : '-' ?></td>
                    <td>
                        <?php if (!empty($row['certificate_file'])) { ?>
                            <a href="<?= base_url('assets/uploads/certificates/' . $row['certificate_file']) ?>"
                                target="_blank"
                                class="btn btn-sm btn-primary">
                                <i class="fa fa-download"></i> Download
                            </a>
                        <?php } else { ?>
                            <span class="text-muted">No File</span>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="7" class="text-center text-muted">
                    No certificates found
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>