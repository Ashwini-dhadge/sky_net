<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>RHCSA Certificate</title>
    <style>
    @page {
        size: 297mm 210mm;
        margin: 10mm 10mm 10mm 10mm;
    }

    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background: white;
    }
    </style>
</head>

<body>

    <!-- BADGE: top-right black box (absolute, page-relative) -->
    <div style="position: absolute; top: 10mm; right: 10mm; background: #000000; padding: 10px; width: 55mm;">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td>
                    <img src="<?= FCPATH ?>assets/certificate_image/rh_white_logo.png" style="height: 25px;">
                </td>
                <td align="right">
                    <img src="<?= FCPATH ?>assets/certificate_image/certificate_icon.png" style="height: 25px;">
                </td>
            </tr>
        </table>
        <div style="margin-top: 35px;">
            <p style="color: #ffffff; font-size: 15px; font-weight: bold; margin: 0; padding: 0;">
                <?= htmlspecialchars($course_name) ?></p>
            <p style="color: #ffffff; font-size: 14px; margin: 0; padding: 4px 0 0 0;">System Administrator</p>
        </div>
    </div>

    <!-- MAIN CONTENT: flows normally with right padding to avoid badge overlap -->
    <div style="padding: 5mm 70mm 0 5mm;">

        <p style="font-size: 22px; font-weight: bold; margin: 0; padding-top: 5mm;">
            Red Hat, Inc. hereby certifies that
        </p>

        <p style="font-size: 52px; color: #e33b2f; font-weight: bold; margin: 6mm 0 0 0; line-height: 1.1;">
            <?= htmlspecialchars($name) ?>
        </p>

        <p style="font-size: 20px; margin: 8mm 0 0 0;">
            has successfully completed all program requirements and is certified as a
        </p>

        <p style="font-size: 42px; color: #e33b2f; font-weight: bold; margin: 6mm 0 0 0; line-height: 1.2;">
            Red Hat Certified System<br>Administrator (RHCSA)
        </p>

    </div>

    <!-- FOOTER: QR code + details (absolute bottom-left) -->
    <div style="position: absolute; bottom: 22mm; left: 10mm;">
        <table cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td style="border-right: 1px solid #888888; padding-right: 14px; vertical-align: middle;">
                    <img src="<?= FCPATH ?>assets/certificate_image/dummy_qr.png" style="width: 80px; height: 80px;">
                </td>
                <td style="padding-left: 14px; font-size: 11px; line-height: 22px; vertical-align: middle;">
                    <div><?= htmlspecialchars($issue_date) ?></div>
                    <div>Issued by: Red Hat</div>
                    <div>Verify: <?= htmlspecialchars($verify_url) ?></div>
                    <div>Certification ID: <?= htmlspecialchars($certification_id) ?></div>
                </td>
            </tr>
        </table>
    </div>

    <!-- RED HAT LOGO: absolute bottom-right -->
    <div style="position: absolute; bottom: 22mm; right: 10mm;">
        <img src="<?= FCPATH ?>assets/certificate_image/rh_black_logo.png" style="width: 200px;">
    </div>

    <!-- COPYRIGHT: absolute bottom -->
    <div style="position: absolute; bottom: 8mm; left: 10mm; font-size: 9px; font-weight: bold;">
        Copyright (c) 2022 Red Hat, Inc. All rights reserved. Red Hat is a trademark of Red Hat, Inc.
    </div>

</body>

</html>