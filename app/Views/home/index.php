<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<style>
    body {
        background-color: #fff;
    }

    .scroll-hidden {
        overflow-x: auto;
        -ms-overflow-style: none;
        /* IE and Edge */
        scrollbar-width: none;
        /* Firefox */
    }

    .scroll-hidden::-webkit-scrollbar {
        display: none;
        /* Chrome, Safari and Opera */
    }

    .service-item:hover {
        cursor: pointer;
    }

    .profile-info {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 30px;
    }

    .profile-info img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
    }

    .balance-card {
        background: url('<?= base_url('assets/'); ?>images/Background Saldo.png') no-repeat center center;
        background-size: cover;
        color: white;
        border-radius: 15px;
        padding: 15px;
        position: relative;
    }

    .nominal-button {
        min-width: 100px;
    }

    .services-icons img {
        width: 40px;
        height: 40px;
        margin-bottom: 10px;
    }

    .promo-card {
        border-radius: 10px;
        overflow: hidden;
        color: #fff;
    }

    .promo-card img {
        width: 100%;
        height: 120px;
        object-fit: cover;
    }

    .promo-card .card-body {
        padding: 10px;
        background-color: #fff;
        color: #333;
    }

    .promo-title {
        font-size: 1.1rem;
        font-weight: bold;
    }

    .service-item {
        flex: 0 0 auto;
        width: 80px;
        text-align: center;
        font-size: 0.8rem;
        margin: 10px 5px;
    }
</style>
<div class="container mt-3">
    <!-- Top Profile & Balance -->
    <div class="row mb-4">
        <div class="col-md-6 d-flex flex-column justify-content-center">
            <div class="profile-info">
                <img src="<?= base_url('assets/'); ?>images/Profile Photo.png" alt="Profile Picture"> <!-- Replace avatar here -->
                <div>
                    <div class="text-muted small" style="font-size: medium">Selamat datang,</div>
                    <div class="fw-bold fs-5"><?= $name; ?></div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="balance-card">
                <div class="mb-1">Saldo anda</div>
                <h4 class="fw-bold mb-3" style="color: white">
                    Rp <span id="saldo" class="text-white-50">•••••••</span>
                </h4>
                <span id="lihat-saldo" class="text-white small" style="color:white; font-size: 12px; margin-left: -.1rem; cursor: pointer">Lihat Saldo </span>
            </div>
        </div>
    </div>

    <!-- Services -->
    <div class="d-flex flex-wrap justify-content-center mb-4">
        <?php foreach ($services as $service): ?>
            <a href="<?= base_url('home/service/' . $service['service_code']); ?>" class="service-item text-center m-1" style="text-decoration:none; color:inherit;">
                <img src="<?= $service['service_icon']; ?>" alt="<?= esc($service['service_name']); ?>">
                <div><?= esc($service['service_name']); ?></div>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Promo Section -->
    <h5 class="mb-3 fw-bold">Temukan promo menarik</h5>
    <div class="d-flex scroll-hidden gap-3 py-3">
        <!-- Promo 1 -->
        <?php foreach ($banners as $banner): ?>
            <div class="flex-shrink-0">
                <img src="<?= $banner['banner_image']; ?>" alt="<?= $banner['banner_name']; ?>" style="height: 100px;">
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    <?php if (session()->getFlashdata('success')): ?>
        Swal.fire({
            title: "Success",
            text: `<?= session()->getFlashdata('success'); ?>`,
            icon: "success"
        });
    <?php endif; ?>

    $(document).ready(function() {
        var saldoAsli = '<?= $balance; ?>';
        var saldoFormatted = parseInt(saldoAsli).toLocaleString('id-ID');
        var isShown = false; // Status awal: saldo disembunyikan

        $('#lihat-saldo').on('click', function() {
            if (isShown) {
                // Kalau lagi kelihatan, sembunyikan
                $('#saldo').addClass('text-white-50').text('•••••••');
            } else {
                // Kalau lagi disembunyikan, tampilkan saldo
                $('#saldo').removeClass('text-white-50').text(saldoFormatted);
            }
            isShown = !isShown; // Balikkan status
        });
    });
</script>
<?= $this->endSection(); ?>