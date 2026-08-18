<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>AWS Certificate of Completion</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Helvetica', 'Arial', sans-serif;
            background-color: #ffffff;
            color: #232f3e;
        }

        /* Outer Frame with AWS Slate & Orange Theme */
        .cert-outer-frame {
            position: absolute;
            top: 8mm;
            left: 10mm;
            width: 277mm;
            height: 194mm;
            border: 3.5px solid #ff9900;
            box-sizing: border-box;
            background-color: #fafbfc;
        }

        /* Absolutely positioned blocks inside 297x210 landscape */
        .pos-header {
            position: absolute;
            top: 16mm;
            left: 20mm;
            width: 257mm;
        }

        .pos-titles {
            position: absolute;
            top: 39mm;
            left: 20mm;
            width: 257mm;
            text-align: center;
        }

        .pos-award {
            position: absolute;
            top: 70mm;
            left: 20mm;
            width: 257mm;
            text-align: center;
        }

        .pos-name {
            position: absolute;
            top: 80mm;
            left: 20mm;
            width: 257mm;
            text-align: center;
        }

        .pos-course {
            position: absolute;
            top: 106mm;
            left: 20mm;
            width: 257mm;
            text-align: center;
        }

        .pos-footer {
            position: absolute;
            top: 148mm;
            left: 20mm;
            width: 257mm;
        }

        .pos-copyright {
            position: absolute;
            top: 191mm;
            left: 20mm;
            width: 257mm;
        }

        /* Typography */
        .brand-title {
            font-size: 14px;
            font-weight: 900;
            letter-spacing: 1.5px;
            color: #232f3e;
            text-transform: uppercase;
        }

        .brand-sub {
            font-size: 9px;
            color: #555555;
            letter-spacing: 0.6px;
            margin-top: 3px;
        }

        .brand-line {
            width: 300px;
            height: 2.5px;
            background-color: #ff9900;
            margin-top: 4px;
        }

        .cert-heading-main {
            font-size: 46px;
            font-weight: 900;
            letter-spacing: 12px;
            color: #232f3e;
            text-transform: uppercase;
            line-height: 1;
        }

        .cert-heading-sub {
            font-size: 19px;
            font-weight: 800;
            letter-spacing: 7px;
            color: #ff9900;
            text-transform: uppercase;
            margin-top: 6px;
        }

        .gold-stars {
            font-size: 14px;
            color: #ff9900;
            letter-spacing: 12px;
            margin-top: 5px;
        }

        .award-label {
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: 4px;
            color: #555555;
            text-transform: uppercase;
        }

        .candidate-name {
            font-family: 'Georgia', 'Times New Roman', serif;
            font-size: 36px;
            font-weight: 900;
            letter-spacing: 2px;
            color: #ff9900;
            text-transform: uppercase;
        }

        .name-accent-line {
            width: 580px;
            height: 2px;
            background-color: #232f3e;
            margin: 8px auto 0 auto;
        }

        .desc-text {
            font-size: 14px;
            font-style: italic;
            color: #444444;
        }

        .course-highlight {
            font-size: 25px;
            font-weight: 900;
            color: #232f3e;
            letter-spacing: 0.5px;
            margin-top: 8px;
        }

        .institute-tag {
            font-size: 14.5px;
            font-weight: 700;
            color: #ff9900;
            margin-top: 6px;
        }

        /* Footer Metadata */
        .meta-line {
            width: 160px;
            height: 1.5px;
            background-color: #ff9900;
            margin: 0 auto 5px auto;
        }

        .meta-title {
            font-size: 10.5px;
            font-weight: 800;
            color: #555555;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .meta-value {
            font-size: 13.5px;
            font-weight: 800;
            color: #232f3e;
            margin-top: 3px;
        }

        .meta-subtext {
            font-size: 10px;
            color: #666666;
            margin-top: 2px;
        }

        .bottom-divider {
            border-top: 1px solid #e2e5e9;
            padding-top: 6px;
            font-size: 9px;
            color: #666666;
        }
        .pos-watermark {
            position: absolute;
            top: 72mm;
            left: 88mm;
            width: 120mm;
            text-align: center;
            opacity: 0.07;
        }
    </style>
</head>
<body>

    <!-- Frame Border -->
    <div class="cert-outer-frame"></div>

    <!-- Background AWS Watermark Logo -->
    <div class="pos-watermark">
        <svg viewBox="0 0 300 180" width="130mm" height="78mm" xmlns="http://www.w3.org/2000/svg">
            <text x="150" y="105" font-family="Arial, Helvetica, sans-serif" font-size="95" font-weight="900" fill="#232f3e" fill-opacity="0.05" text-anchor="middle" letter-spacing="4">aws</text>
            <path d="M 60 120 Q 150 165 240 120 Q 150 145 60 120 Z" fill="#ff9900" fill-opacity="0.08" />
            <path d="M 235 110 L 255 122 L 232 135 Z" fill="#ff9900" fill-opacity="0.08" />
        </svg>
    </div>

    <!-- Header Block -->
    <div class="pos-header">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 60%; vertical-align: top;">
                    <div class="brand-title">SKYNET LINUX SOLUTIONS & TRAINING CENTRE</div>
                    <div class="brand-line"></div>
                    <div class="brand-sub">Cloud Architecture, AWS & DevOps Technical Education</div>
                </td>
                <td style="width: 40%; text-align: right; vertical-align: top;">
                    <?php if (!empty($logo_image)) { ?>
                        <img src="<?= $logo_image ?>" style="height: 52px;">
                    <?php } ?>
                </td>
            </tr>
        </table>
    </div>

    <!-- Titles Block -->
    <div class="pos-titles">
        <div class="cert-heading-main">CERTIFICATE</div>
        <div class="cert-heading-sub">OF PARTICIPATION</div>
        <div class="gold-stars">★ &nbsp; ★ &nbsp; ★</div>
    </div>

    <!-- Award Banner -->
    <div class="pos-award">
        <div class="award-label">THIS CERTIFICATE IS PROUDLY AWARDED TO</div>
    </div>

    <!-- Student Name Block -->
    <div class="pos-name">
        <div class="candidate-name"><?= htmlspecialchars($student_name, ENT_QUOTES, 'UTF-8') ?></div>
        <div class="name-accent-line"></div>
    </div>

    <!-- Course Info Block -->
    <div class="pos-course">
        <div class="desc-text">for successfully completing the comprehensive training course and practical curriculum in</div>
        <div class="course-highlight">“<?= htmlspecialchars($course_title, ENT_QUOTES, 'UTF-8') ?>”</div>
        <div class="institute-tag">at Skynet Linux Solutions & Training Centre</div>
    </div>

    <!-- Footer Signatures & Metadata Block -->
    <div class="pos-footer">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <!-- Date Column -->
                <td style="width: 33%; text-align: center; vertical-align: bottom;">
                    <div class="meta-line"></div>
                    <div class="meta-title">DATE OF ISSUE</div>
                    <div class="meta-value"><?= htmlspecialchars($date, ENT_QUOTES, 'UTF-8') ?></div>
                </td>

                <!-- Certificate ID Column -->
                <td style="width: 34%; text-align: center; vertical-align: bottom;">
                    <div class="meta-line" style="width: 190px;"></div>
                    <div class="meta-title">CERTIFICATE ID</div>
                    <div class="meta-value"><?= htmlspecialchars($certificate_id, ENT_QUOTES, 'UTF-8') ?></div>
                    <div class="meta-subtext">Verified Cloud Credential</div>
                </td>

                <!-- Authorized Signature Column -->
                <td style="width: 33%; text-align: center; vertical-align: bottom;">
                    <?php if (!empty($signature_image)) { ?>
                        <img src="<?= $signature_image ?>" style="height: 44px; margin-bottom: 2px;"><br>
                    <?php } ?>
                    <div class="meta-line"></div>
                    <div class="meta-title">AUTHORIZED SIGNATURE</div>
                    <div class="meta-value"><?= htmlspecialchars($director_name, ENT_QUOTES, 'UTF-8') ?></div>
                    <div class="meta-subtext">Director of Skynet</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Bottom Copyright Block -->
    <div class="pos-copyright">
        <table style="width: 100%; border-collapse: collapse;" class="bottom-divider">
            <tr>
                <td style="width: 70%; vertical-align: middle;">
                    Copyright <?= date('Y') ?> Skynet Linux Solution & Training Center, All rights reserved.
                </td>
                <td style="width: 30%; text-align: right; font-weight: 800; color: #ff9900; letter-spacing: 0.5px; vertical-align: middle;">
                    AWS CLOUD CERTIFICATION
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
