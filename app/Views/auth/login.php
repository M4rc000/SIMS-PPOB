<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?> SIMS PPOB - Marco Antonio Senni Koten</title>
    <link rel="shortcut icon" href="<?= base_url('assets/'); ?>/images/Logo.png" type="image/x-icon">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        /* Pastikan body dan html memenuhi tinggi layar */
        html,
        body {
            height: 100%;
            margin: 0;
        }

        /* Container penuh untuk layout login */
        .login-container {
            height: 100vh;
        }

        /* Styling untuk bagian form login */
        .login-section {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-form {
            max-width: 400px;
            width: 100%;
        }

        .is-invalid {
            border: 1px solid red;
        }

        .error {
            font-size: 12px;
        }

        .input-group-text {
            background-color: white !important;
        }

        /* Pada layar kecil, sembunyikan kolom background */
        @media (max-width: 768px) {
            .bg-section {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid login-container">
        <div class="row">
            <div class="col-md-6 login-section">
                <div class="login-form px-4">
                    <!-- Logo merah; pastikan src diarahkan ke gambar logo yang Anda miliki -->
                    <div class="d-flex align-items-center justify-content-center mb-4">
                        <img src="<?= base_url('assets/'); ?>images/Logo.png" alt="Logo SIMS PPOB" class="img-fluid" style="max-width: 150px;">
                        <strong class="mx-2 fs-5">SIMS PPOB</strong>
                    </div>

                    <!-- Judul Halaman Login -->
                    <h4 class="text-center mb-4">Masuk atau buat akun<br>untuk memulai</h4>

                    <!-- Form Login -->
                    <?= form_open_multipart('auth/login'); ?>
                    <?= csrf_field() ?>
                    <!-- Input Email -->
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text" id="email-addon">
                                @
                            </span>
                            <input
                                type="email"
                                name="email"
                                class="form-control <?= (isset($validation) && $validation->hasError('email')) ? 'is-invalid' : '' ?>"
                                placeholder="Masukan email anda"
                                aria-label="Email"
                                aria-describedby="email-addon"
                                required
                                value="<?= set_value('email') ?>">
                            <?php if (isset($validation) && $validation->hasError('email')): ?>
                                <small class="error text-danger"><?= $validation->getError('email') ?></small>
                            <?php endif; ?>

                        </div>
                    </div>
                    <!-- Input Buat Password -->
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text" id="password-addon">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input
                                type="password"
                                name="password"
                                id="password-input"
                                class="form-control <?= (isset($validation) && $validation->hasError('password')) ? 'is-invalid' : '' ?>"
                                placeholder="Buat Password"
                                aria-label="Buat Password"
                                aria-describedby="password-addon"
                                required>
                            <span class="input-group-text" style="cursor: pointer;" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </span>
                        </div>
                        <?php if (isset($validation) && $validation->hasError('password')): ?>
                            <div class="invalid-feedback d-block">
                                <?= $validation->getError('password') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn text-white" style="background-color: red; border-radius: 2px !important">Masuk</button>
                    </div>
                    </form>
                    <p class="mt-3 text-center">
                        belum punya akun? registrasi <a href="auth/register" class="fw-bold" style="color: red; text-decoration: none">disini</a>
                    </p>
                </div>
            </div>
            <!-- Kolom kanan: Area background ilustrasi -->
            <div class="col-md-6 p-0 bg-section d-none d-md-block">
                <img src="<?= base_url('assets/'); ?>images/Illustrasi Login.png" alt="" class="img-fluid mx-auto d-block" style="max-height: 100vh; width: 100%">
            </div>
        </div>
    </div>
    <!-- Bootstrap Bundle JS (dengan Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Toggle visibilitas untuk "buat password"
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password-input');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.innerHTML = type === 'password' ?
                '<i class="bi bi-eye"></i>' :
                '<i class="bi bi-eye-slash"></i>';
        });

        <?php if (session()->getFlashdata('error')): ?>
            Swal.fire({
                title: "Error",
                text: `<?= session()->getFlashdata('error'); ?>`,
                icon: "error"
            });
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')): ?>
            Swal.fire({
                title: "Success",
                text: `<?= session()->getFlashdata('success'); ?>`,
                icon: "success"
            });
        <?php endif; ?>
    </script>
</body>

</html>