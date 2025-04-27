<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<style>
    .saldo-card {
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

    #toggle-saldo:hover {
        cursor: pointer;
    }
</style>
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-6 text-start">
            <img src="<?= base_url('assets'); ?>/images/Profile Photo.png" alt="avatar" width="80" height="80">
            <h6 class="mt-1" style="font-weight: 400">Selamat datang,</h6>
            <h5 class="fw-bold"><?= $name; ?></h5>
        </div>
        <div class="col-md-6">
            <div class="saldo-card mb-5">
                <h6>Saldo anda</h6>
                <h3 id="saldo">Rp <?= number_format($balance, 0, ',', '.'); ?></h3>
                <span id="toggle-saldo" style="color:white; font-size: 10px; margin-left: -.1rem">
                    Tutup Saldo
                </span>
            </div>
        </div>
    </div>
    <div class="text-start mb-3">
        <small style="color: grey;">PemBayaran</small>
    </div>
    <div class="d-flex align-items-center mb-3">
        <img src="<?= $service['service_icon']; ?>" alt="<?= esc($service['service_name']); ?>" style="width: 24px; height: 24px; margin-right: 8px;">
        <strong><?= esc($service['service_name']); ?></strong>
    </div>

    <div class="mb-3">
        <div class="input-group">
            <span class="input-group-text bg-white">
                <i class="bi bi-wallet2"></i>
            </span>
            <input type="text" class="form-control" id="nominal-bayar" value="<?= number_format($service['service_tariff'], 0, ',', '.'); ?>" readonly>
        </div>
    </div>

    <div class="d-grid">
        <button class="btn btn-danger" id="btn-bayar" type="submit">Bayar</button>
    </div>
</div>
<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script>
    $(document).ready(function() {
        var saldoVisible = true;

        $('#toggle-saldo').click(function(e) {
            e.preventDefault();
            saldoVisible = !saldoVisible;
            if (saldoVisible) {
                $('#saldo').text('Rp 0');
                $(this).html('Tutup Saldo <i class="fa fa-eye"></i>');
            } else {
                $('#saldo').text('Rp •••••••');
                $(this).html('Lihat Saldo <i class="fa fa-eye-slash"></i>');
            }
        });

        $('#btn-bayar').click(function() {
            var nominal = '<?= $service['service_tariff']; ?>';
            var service_name = '<?= $service['service_name']; ?>';
            var service_code = '<?= $service['service_code']; ?>';

            Swal.fire({
                title: `Bayar ${service_name} senilai`,
                imageUrl: "<?= base_url('assets'); ?>/images/Logo.png",
                imageWidth: 50,
                imageHeight: 50,
                html: `<strong>Rp ${nominal}</strong> ?`,
                showCancelButton: true,
                confirmButtonText: "Ya, lanjutkan Bayar",
                cancelButtonText: "Batalkan",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // User pilih "Ya", baru kirim AJAX
                    $.ajax({
                        url: `<?= base_url('home/transaction-pay') ?>`, // pastikan URL ini benar
                        method: 'POST',
                        data: {
                            service_code
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status == 0) {
                                Swal.fire({
                                    title: `Pembayaran ${service_name} sebesar`,
                                    html: `<strong> Rp ${nominal}</strong> berhasil`,
                                    footer: '<a href="/home" style="color: red; text-decoration:none">Kembali ke beranda</a>',
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    icon: "success"
                                });
                            } else {
                                Swal.fire({
                                    title: `Pembayaran ${service_name} sebesar`,
                                    html: `<strong> Rp ${nominal} </strong> gagal`,
                                    footer: '<a href="/home" style="color: red; text-decoration:none">Kembali ke beranda</a>',
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    icon: "error"
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: "Top Up Gagal",
                                text: "Server error, coba lagi nanti.",
                                icon: "error",
                                confirmButtonText: 'Tutup'
                            });
                        }
                    });
                }
                // Kalau cancel, tidak lakukan apa-apa
            });
        });
    });
</script>
<?= $this->endSection(); ?>