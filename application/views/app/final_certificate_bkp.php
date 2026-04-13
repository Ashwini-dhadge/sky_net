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

<body style="padding:20px">

    <!-- TOP SECTION: left = main content, right = badge -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding-top:-80px">
        <tr>

            <td width="68%" valign="top">

                <p style="font-size: 30px; font-weight: bold; margin: 0; padding: 0;">
                    <?= htmlspecialchars($issue_by) ?>, Inc. hereby certifies that
                </p>
                <br>
                <p style="font-size: 52px; color: #e33b2f; font-weight: bold; margin: 6mm 0 0 0; line-height: 1.1;">
                    <?= htmlspecialchars($name) ?>
                </p>
                <br>
                <p style="font-size: 20px; margin: 8mm 0 0 0;">
                    has successfully completed all program requirements and is certified as a
                </p>
                <br>
                <p style="font-size: 42px; color: #e33b2f; font-weight: bold; margin: 6mm 0 0 0; line-height: 1.2;">
                    <?= htmlspecialchars($course_name) ?>
                </p>

            </td>


            <td width="32%" valign="top" align="right">
                <table cellpadding="0" cellspacing="0" border="0"
                    style="background: #000000; padding: 10px; width: 55mm;">
                    <tr>
                        <td align="left">
                            <img src="<?= FCPATH ?>assets/certificate_image/rh_white_logo.png" style="height: 25px;">
                        </td>
                        <td align="right">
                            <img src="<?= FCPATH ?>assets/certificate_image/certificate_icon.png" style="height: 25px;">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top: 20px;" align="left">
                            <p style="color: #ffffff; font-size: 15px; font-weight: bold; margin: 0; padding: 0;">
                                <?= htmlspecialchars($issue_by) ?></p>
                            <p style="color: #ffffff; font-size: 14px; margin: 0; padding: 4px 0 0 0;">System
                                Administrator</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- FOOTER: QR code + details (absolute bottom-left) -->
    <div style="position: absolute; bottom: 60mm; left: 10mm;">
        <table cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td style="border-right: 1px solid #888888; padding-right: 14px; vertical-align: middle;">
                    <img src=<?= FCPATH . $barcode_logo ?> style="width: 80px; height: 80px;">
                </td>
                <td style="padding-left: 14px; font-size: 11px; line-height: 22px; vertical-align: middle;">
                    <div><?= htmlspecialchars($issue_date) ?></div>
                    <div>Issued by: <?= htmlspecialchars($issue_by) ?></div>
                    <div>Verify: <?= htmlspecialchars($verify_url) ?></div>
                    <div>Certification ID: <?= htmlspecialchars($certification_id) ?></div>
                </td>
            </tr>
        </table>
    </div>

    <!-- RED HAT LOGO: absolute bottom-right -->
    <div style="position: absolute; bottom: 60mm; right: 10mm;">
        <img src="<?= FCPATH ?>assets/certificate_image/rh_black_logo.png" style="width: 200px;">
    </div>

    <!-- COPYRIGHT: absolute bottom -->
    <div style="position: absolute; bottom: 50mm; left: 10mm; font-size: 9px; font-weight: bold;">
        Copyright (c) 2022 <?= htmlspecialchars($issue_by) ?>, Inc. All rights reserved.
        <?= htmlspecialchars($issue_by) ?> is a trademark of <?= htmlspecialchars($issue_by) ?>, Inc.
    </div>

</body>

</html>