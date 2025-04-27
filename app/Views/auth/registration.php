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

        /* Styling untuk kolom background ilustrasi */
        /* .bg-section {
            background: url('path-to-background-image.jpg') no-repeat center center;
            background-size: cover;
            height: 100vh;
        } */

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
            <!-- Kolom kiri: Form login dengan logo merah -->
            <div class="col-md-6 login-section">
                <div class="login-form px-4">
                    <!-- Logo merah; pastikan src diarahkan ke gambar logo yang Anda miliki -->
                    <div class="d-flex align-items-center justify-content-center mb-4">
                        <img src="<?= base_url('assets/'); ?>images/Logo.png" alt="Logo SIMS PPOB" class="img-fluid" style="max-width: 150px;">
                        <strong class="mx-2 fs-5">SIMS PPOB</strong>
                    </div>

                    <!-- Judul Halaman Login -->
                    <h4 class="text-center mb-4">Lengkapi data<br>untuk membuat akun</h4>

                    <!-- Form Login -->
                    <?= form_open_multipart('auth/register'); ?>
                    <?= csrf_field() ?>
                    <!-- Input Email -->
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text" id="email-addon">
                                @
                            </span>
                            <input type="email" name="email" class="form-control" placeholder="masukan email anda" aria-label="Email" aria-describedby="email-addon" required value="<?= set_value('email') ?>">
                            <?php if (isset($validation) && $validation->getError('email')): ?>
                                <small class="error"><?= $validation->getError('email') ?></small>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- Input Nama Depan -->
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text" id="firstname-addon">
                                <i class="bi bi-person"></i>
                            </span>
                            <input type="text" class="form-control" placeholder="nama depan" aria-label="Nama Depan" aria-describedby="firstname-addon" required id="first_name" name="first_name" value="<?= set_value('first_name'); ?>">
                            <?php if (isset($validation) && $validation->getError('first_name')): ?>
                                <small class="error"><?= $validation->getError('first_name') ?></small>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- Input Nama Belakang -->
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text" id="lastname-addon">
                                <i class="bi bi-person"></i>
                            </span>
                            <input type="text" class="form-control" placeholder="nama belakang" aria-label="Nama Belakang" aria-describedby="lastname-addon" required id="last_name" name="last_name" value="<?= set_value('last_name'); ?>">
                            <?php if (isset($validation) && $validation->getError('last_name')): ?>
                                <small class="error"><?= $validation->getError('last_name') ?></small>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- Input Buat Password -->
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text" id="password-addon">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" class="form-control" placeholder="buat Password" id="password-input" aria-label="Buat Password" aria-describedby="password-addon" required name="password">
                            <?php if (isset($validation) && $validation->getError('password')): ?>
                                <small class="error"><?= $validation->getError('password') ?></small>
                            <?php endif; ?>
                            <span class="input-group-text" style="cursor: pointer;" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </span>
                        </div>
                    </div>
                    <!-- Input Konfirmasi Password -->
                    <div class="mb-4">
                        <div class="input-group">
                            <span class="input-group-text" id="confirmPassword-addon">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" class="form-control" placeholder="konfirmasi Password" id="confirm-password-input" aria-label="Konfirmasi Password" aria-describedby="confirmPassword-addon" required name="password2">
                            <span class="input-group-text" style="cursor: pointer;" id="toggleConfirmPassword">
                                <i class="bi bi-eye"></i>
                            </span>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn text-white" style="background-color: red">Registrasi</button>
                    </div>
                    </form>
                    <p class="mt-3 text-center">
                        sudah punya akun? login <a href="/" class="fw-bold" style="color: red; text-decoration: none">disini</a>
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

        // Toggle visibilitas untuk "konfirmasi password"
        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('confirm-password-input');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.innerHTML = type === 'password' ?
                '<i class="bi bi-eye"></i>' :
                '<i class="bi bi-eye-slash"></i>';
        });

        $(document).ready(function() {
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
        });
    </script>
</body>

</html>