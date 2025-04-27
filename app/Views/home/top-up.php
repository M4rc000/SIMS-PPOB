<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<style>
    body {
        background: #fff;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .nav-link.active {
        color: red !important;
        font-weight: bold;
    }

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

    .input-group-text {
        background: transparent;
        border-right: 0;
    }

    .form-control {
        border-left: 0;
    }

    #toggle-saldo:hover {
        cursor: pointer;
    }
</style>

<div class="container mt-5">

    <div class="row mb-4">
        <div class="col-md-6 text-start">
            <img src="<?= base_url('assets'); ?>/images/Profile Photo.png" alt="avatar" width="100">
            <h5 class="mt-2" style="font-weight: 400">Selamat datang,</h5>
            <h3 class="fw-bold"><?=$name;?></h3>
        </div>
        <div class="col-md-6">
            <div class="saldo-card mb-5">
                <h6>Saldo anda</h6>
                <h3 id="saldo">Rp <?= number_format($balance, 0, ',', '.');?></h3>
                <span id="toggle-saldo" style="color:white; font-size: 10px; margin-left: -.1rem">
                    Tutup Saldo
                </span>
            </div>
        </div>
    </div>


    <div class="mb-3">
        <h5>Silahkan masukan</h5>
        <h2 class="fw-bold">Nominal Top Up</h2>
    </div>

    <div class="row g-2 mb-4">
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-calculator"></i></span>
                <input type="number" id="input-nominal" class="form-control" placeholder="masukan nominal Top Up">
                <button id="topup-button" class="btn btn-secondary w-100 mt-3" disabled>Top Up</button>
            </div>
        </div>
        <div class="col-md-6 d-flex flex-wrap gap-2">
            <div class="row">
                <div class="col-md-12 d-flex flex-wrap gap-3 mb-2">
                    <button class="btn btn-outline-secondary nominal-button" data-nominal="10000">Rp10.000</button>
                    <button class="btn btn-outline-secondary nominal-button" data-nominal="20000">Rp20.000</button>
                    <button class="btn btn-outline-secondary nominal-button" data-nominal="50000">Rp50.000</button>
                </div>
                <div class="col-md-12 d-flex flex-wrap gap-3">
                    <button class="btn btn-outline-secondary nominal-button" data-nominal="100000">Rp100.000</button>
                    <button class="btn btn-outline-secondary nominal-button" data-nominal="250000">Rp250.000</button>
                    <button class="btn btn-outline-secondary nominal-button" data-nominal="500000">Rp500.000</button>
                </div>
            </div>
        </div>
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

        function checkNominal() {
            var value = parseInt($('#input-nominal').val());
            if (!isNaN(value) && value >= 10000 && value <= 1000000) {
                $('#topup-button').prop('disabled', false).removeClass('btn-secondary').addClass('btn-danger');
            } else {
                $('#topup-button').prop('disabled', true).removeClass('btn-danger').addClass('btn-secondary');
            }
        }

        $('#input-nominal').on('input', function() {
            checkNominal();
        });

        $('.nominal-button').click(function() {
            var nominal = $(this).data('nominal');
            $('#input-nominal').val(nominal);
            checkNominal();
        });

        $('#topup-button').click(function() {
            var nominal = parseInt($('#input-nominal').val());

            if (isNaN(nominal) || nominal < 10000 || nominal > 1000000) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Nominal salah',
                    text: 'Nominal harus antara 10.000 dan 1.000.000'
                });
                return;
            }

            Swal.fire({
                title: "Anda yakin untuk Top Up sebesar",
                imageUrl: "<?= base_url('assets'); ?>/images/Logo.png",
                imageWidth: 50,
                imageHeight: 50,
                html: `<strong>Rp ${nominal.toLocaleString('id-ID')}</strong> ?`,
                showCancelButton: true,
                confirmButtonText: "Ya, lanjutkan",
                cancelButtonText: "Batalkan",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // User pilih "Ya", baru kirim AJAX
                    $.ajax({
                        url: `<?= base_url('home/top-up') ?>`, // pastikan URL ini benar
                        method: 'POST',
                        data: {
                            nominal: nominal
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status == 0) {
                                Swal.fire({
                                    title: "Top Up sebesar",
                                    html: `<strong> Rp ${nominal}</strong> berhasil`,
                                    footer: '<a href="/home" style="color: red; text-decoration:none">Kembali ke beranda</a>',
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    icon: "success"
                                });
                            } else {
                                Swal.fire({
                                    title: "Top Up sebesar",
                                    title: "Error",
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