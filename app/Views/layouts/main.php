<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?> SIMS PPOB - Marco Antonio Senni Koten</title>
    <link rel="shortcut icon" href="<?= base_url('assets/'); ?>/images/Logo.png" type="image/x-icon">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .nav-link {
            color: black !important;
            font-weight: 500 !important;
        }

        .active {
            color: red !important;
        }

        .btn-danger {
            background-color: red !important;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-white" style="border-bottom: 1px solid #e0e0e0">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('home'); ?>">
                <div class="d-flex align-items-center justify-content-center">
                    <img src="<?= base_url('assets/'); ?>images/Logo.png" alt="Logo SIMS PPOB" class="img-fluid" style="max-width: 150px;">
                    <strong class="mx-2 fs-5">SIMS PPOB</strong>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarScroll">
                <!-- Push everything to the right -->
                <ul class="navbar-nav ms-auto d-flex align-items-center gap-3">
                    <li class="nav-item">
                        <a class="nav-link <?= $title == 'Top Up' ? 'active' : ''; ?>" aria-current="page" href="<?= base_url('home/top-up'); ?>">Top up</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $title == 'Transaction' ? 'active' : ''; ?>" href="<?= base_url('home/transaction'); ?>">Transaction</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $title == 'Akun' ? 'active' : ''; ?>" href="<?= base_url('home/akun'); ?>">Akun</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <section>
        <?= $this->renderSection('content'); ?>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?= $this->renderSection('script'); ?>
</body>

</html>