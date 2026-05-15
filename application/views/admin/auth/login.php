<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?= PROJECTNAME ?? ''; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/tabicon.png">

    <link href="<?= base_url(); ?>assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        :root {
            --brand: #CA151C;
            --brand-soft: rgba(202, 21, 28, 0.12);
            --text: #0f172a;
            --muted: #64748b;
            --border: #e5e7eb;
            --card: #ffffff;
            --bg1: #f8fafc;
            --bg2: #eef2ff;
        }

        body {
            min-height: 100vh;
            background:
                radial-gradient(1200px 600px at 10% 10%, var(--bg2), transparent 60%),
                radial-gradient(1000px 500px at 90% 20%, #ffe4e6, transparent 55%),
                linear-gradient(180deg, var(--bg1), #ffffff);
        }

        .auth-wrap {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 48px 12px;
        }

        .auth-card {
            border: 1px solid var(--border);
            border-radius: 18px;
            background: var(--card);
            box-shadow: 0 18px 50px rgba(2, 6, 23, 0.10);
            overflow: hidden;
        }

        .auth-left {
            position: relative;
            background: linear-gradient(135deg, rgb(202 21 21 / 54%), rgb(21 175 202 / 77%));
            color: #fff;
            padding: 28px;
        }

        .auth-left::after {
            content: "";
            position: absolute;
            inset: -40px -60px auto auto;
            width: 180px;
            height: 180px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
            filter: blur(0px);
        }

        .brand-badge {
            gap: 10px;
            padding: 10px 12px;
            border-radius: 12px;
            background: #ffffff30;
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 18px 50px rgba(2, 6, 23, 0.3);
        }

        .brand-badge img {
            height: 42px;
            width: auto;
        }

        .auth-left h4 {
            margin: 18px 0 6px;
            font-weight: 700;
            letter-spacing: 0.2px;
        }

        .auth-left p {
            margin: 0;
            opacity: 0.92;
            font-size: 14px;
        }

        .auth-right {
            padding: 28px;
        }

        .auth-title {
            color: var(--text);
            font-weight: 700;
            margin-bottom: 2px;
        }

        .auth-subtitle {
            color: var(--muted);
            font-size: 14px;
            margin-bottom: 18px;
        }

        .form-label {
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
        }

        .input-group-text {
            background: #fff;
            border: 1px solid var(--border);
            border-right: 0;
            border-radius: 12px 0 0 12px;
            color: #94a3b8;
        }

        .form-control {
            border: 1px solid var(--border);
            border-left: 0;
            border-radius: 0 12px 12px 0;
            height: 44px;
            box-shadow: none !important;
        }

        .form-control:focus {
            border-color: var(--brand);
        }

        .input-group:focus-within .input-group-text {
            border-color: var(--brand);
            color: var(--brand);
        }

        .btn-brand {
            color: #fff;
            background: var(--brand);
            border-color: var(--brand);
            height: 44px;
            border-radius: 12px;
            font-weight: 700;
            letter-spacing: 0.2px;
            box-shadow: 0 10px 20px var(--brand-soft);
        }

        .btn-brand:hover {
            color: #ffa9a9;
            background: #b51218;
            border-color: #b51218;
        }

        .helper-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 6px;
            margin-bottom: 16px;
            font-size: 13px;
            color: var(--muted);
        }

        .footer-note {
            text-align: center;
            color: var(--muted);
            font-size: 13px;
            margin-top: 18px;
        }

        /* alerts nicer */
        .alert {
            border-radius: 12px;
        }

        /* responsive: hide left panel on small screens */
        @media (max-width: 991.98px) {
            .auth-left {
                display: none;
            }

            .auth-right {
                padding: 24px;
            }
        }
    </style>
</head>

<body>

    <div class="auth-wrap">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-8 col-xl-8 animate__animated animate__backInDown">
                    <div class="auth-card">
                        <div class="row g-0">
                            <div class="col-lg-5 auth-left">
                                <div class="brand-badge">
                                    <img src="<?= base_url(); ?>assets/images/icon1.png" alt="logo">
                                    <div>
                                        <!-- <div style="font-weight:800; line-height:1;">SKYNET</div> -->
                                        <div style="font-size:12px; opacity:.9;margin-top:10px;">Credentials Login</div>
                                    </div>
                                </div>

                                <h4>Welcome back</h4>
                                <p>Sign in to manage your dashboard, users and settings securely.</p>

                                <div style="margin-top:18px; font-size:12px; opacity:.9;">
                                    <i class="mdi mdi-shield-check-outline"></i> Secure login •
                                    <i class="mdi mdi-lock-outline"></i> Encrypted session
                                </div>
                            </div>

                            <div class="col-lg-7 auth-right">

                                <?php if ($msg = $this->session->flashdata('success')): ?>
                                    <div class="alert alert-success" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <?= $msg ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($msg = $this->session->flashdata('error')): ?>
                                    <div class="alert alert-danger" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <?= $msg ?>
                                    </div>
                                <?php endif; ?>

                                <h4 class="auth-title">Sign in</h4>
                                <div class="auth-subtitle">Enter your credentials to continue</div>

                                <form method="post" action="<?= base_url('admin') ?>" enctype="multipart/form-data" autocomplete="off">

                                    <div class="mb-3">
                                        <label class="form-label" for="username">Username</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="mdi mdi-account-outline"></i></span>
                                            <input type="text"
                                                class="form-control"
                                                id="username"
                                                name="email"
                                                required
                                                placeholder="Enter username">
                                        </div>
                                    </div>

                                    <div class="mb-2">
                                        <label class="form-label" for="password">Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="mdi mdi-lock-outline"></i></span>
                                            <input type="password"
                                                class="form-control"
                                                id="password"
                                                name="password"
                                                required
                                                placeholder="Enter password">
                                        </div>
                                    </div>

                                    <div class="helper-row">
                                        <div>
                                            <label class="mb-0" style="cursor:pointer;">
                                                <input type="checkbox" id="showPass" style="transform: translateY(1px);">
                                                Show password
                                            </label>
                                        </div>
                                        <!-- If you have reset password route, replace # -->
                                        <!-- <a href="#" style="color: var(--brand); font-weight:600; text-decoration:none;">
                                            Forgot password?
                                        </a> -->
                                    </div>

                                    <button class="btn btn-brand w-100" type="submit">
                                        Log In <i class="mdi mdi-arrow-right"></i>
                                    </button>

                                    <div class="footer-note">
                                        © <script>
                                            document.write(new Date().getFullYear())
                                        </script> <?= PROJECTNAME; ?>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url(); ?>assets/libs/jquery/jquery.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/node-waves/waves.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/app.js"></script>

    <script>
        setTimeout(function() {
            $('.alert').fadeOut("slow");
        }, 3000);

        $('#showPass').on('change', function() {
            const el = document.getElementById('password');
            el.type = this.checked ? 'text' : 'password';
        });
    </script>
</body>

</html>