<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>RHCSA Certificate</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    body {
        background: #f2f2f2;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }

    .certificate {
        width: 297mm;
        height: 200mm;
        background: white;
        margin: auto;
        padding: 10mm 25mm;
        position: relative;
    }

    .cert-top {
        font-size: 28px;
        font-weight: 700;
    }

    /* NAME */
    .cert-name {
        font-size: 62px;
        color: #e33b2f;
        font-weight: 700;
        margin-top: 25px;
    }

    /* DESCRIPTION */
    .cert-desc {
        font-size: 24px;
        margin-top: 40px;
    }

    /* TITLE */
    .cert-title {
        font-size: 50px;
        color: #e33b2f;
        font-weight: 700;
        margin-top: 30px;
        line-height: 1.2;
    }

    /* FOOTER */
    .cert-footer {
        position: absolute;
        bottom: 40mm;
        left: 25mm;
        display: flex;
        align-items: center;
        gap: 25px;
    }

    .qr-section {
        border-right: 1px solid gray;
        padding-right: 20px;
    }

    .qr-section img {
        width: 100px;
    }

    .cert-details {
        line-height: 28px;
        font-size: smaller;
    }

    /* LOGO RIGHT */
    .cert-logo {
        position: absolute;
        bottom: 40mm;
        right: 25mm;
    }

    .cert-logo img {
        width: 260px;
    }

    /* BADGE */
    .cert-badge {
        padding: 10px;
        background: #000;
        position: absolute;
        top: 60px;
        right: 70px;
        border-radius: 5px;
    }

    .cert-bottom_text {
        font-weight: 700;
        position: absolute;
        bottom: 100px;
        left: 100px;
        display: flex;
        align-items: center;
        gap: 25px;
        font-size: 11px;
    }

    @media print {

        html,
        body {
            width: 297mm;
            height: 200mm;
            margin: 0;
            padding: 0;
            background: white;
        }

        .cert-badge {
            background: #000 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .certificate {
            width: 297mm;
            height: 200mm;
            margin: 0;
            padding: 20mm 25mm;
            page-break-after: avoid;
        }

        @page {
            size: A4 landscape;
            margin: 0;
        }

    }
    </style>

</head>

<body>

    <div class="certificate">

        <div class="cert-top">
            Red Hat, Inc. hereby certifies that
        </div>

        <div class="cert-name">
            <?= $name ?>
        </div>

        <div class="cert-desc">
            has successfully completed all program requirements and is certified as a
        </div>

        <div class="cert-title">
            Red Hat Certified System<br>
            Administrator (RHCSA)
        </div>



        <div class="cert-badge">
            <div style="display: flex; align-items: center; gap: 10px; ">
                <img src="<?= FCPATH ?>assets/certificate_image/rh_white_logo.png"
                    style="height: 30px; margin-right: 20px;">
                <div style="color: white;">
                    <img src="<?= FCPATH ?>assets/certificate_image/certificate_icon.png" style="height: 30px;">
                </div>
            </div>
            <div style="margin-top: 40px;">
                <p style="color: white; font-size: 17px; font-weight: 700; margin: 0;padding: 0;"><?= $course_name ?>
                </p>
                <p style="color: white; font-size: 17px; margin: 0;padding: 0;">System Administrator</p>
            </div>

        </div>



        <div class="cert-footer">

            <div class="qr-section">
                <img src="<?= FCPATH ?>assets/certificate_image/dummy_qr.png" alt="">
            </div>

            <div class="cert-details">
                <div>December 08, 2025</div>
                <div>Issued by: Red Hat</div>
                <div>Verify: https://www.credly.com/badges/d898ed2a-8d6a-49de-8600-bce8d3fb41d8</div>
                <div>Certification ID: 190-236-588</div>
            </div>

        </div>



        <div class="cert-logo">
            <img src="<?= FCPATH ?>assets/certificate_image/rh_black_logo.png">
        </div>
        <div class="cert-bottom_text">
            <span>Copyright (c) 2022 Red Hat, Inc. All rights reserved. Red Hat is a trademark of Red Hat, Inc.</span>
        </div>
    </div>

</body>

</html>