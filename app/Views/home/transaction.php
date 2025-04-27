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

    .transaction-item {
        background-color: #fff;
        border: 1px solid #eee;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
    }

    .transaction-amount {
        font-weight: bold;
        font-size: 18px;
    }

    .transaction-plus {
        color: #28a745;
        /* Hijau */
    }

    .transaction-minus {
        color: #dc3545;
        /* Merah */
    }

    .transaction-footer {
        text-align: right;
        font-size: 14px;
        color: grey;
        margin-top: 5px;
    }

    .show-more {
        display: block;
        text-align: center;
        color: red;
        margin-top: 20px;
        cursor: pointer;
        font-weight: 500;
        text-decoration: none;
    }
</style>
<?php
function formatTanggal($isoDate)
{
    $bulanIndonesia = [
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];

    // Buat objek DateTime dari string ISO 8601
    $date = new DateTime($isoDate);

    // Set timezone ke Asia/Jakarta (WIB)
    $date->setTimezone(new DateTimeZone('Asia/Jakarta'));

    // Ambil bagian tanggal
    $tanggal = $date->format('j');
    $bulan = $bulanIndonesia[(int)$date->format('n')];
    $tahun = $date->format('Y');
    $jam = $date->format('H');
    $menit = $date->format('i');

    return "$tanggal $bulan $tahun · $jam:$menit WIB";
}
?>
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-6 text-start">
            <img src="<?= base_url('assets'); ?>/images/Profile Photo.png" alt="avatar" width="100">
            <h5 class="mt-2" style="font-weight: 400">Selamat datang,</h5>
            <h3 class="fw-bold"><?= $name; ?></h3>
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

    <div class="row mt-4">
        <strong>
            <h6>Semua Transaksi</h6>
        </strong>
        <!-- List transaksi -->
        <?php foreach ($transactions as $transaction): ?>
            <div class="transaction-item">
                <div class="transaction-amount transaction-plus">+ Rp<?= $transaction['total_amount']; ?></div>
                <small><?= formatTanggal($transaction['created_on']); ?></small>
                <div class="transaction-footer"><?= $transaction['description']; ?></div>
            </div>
        <?php endforeach; ?>

        <!-- Show more -->
        <a href="#" class="show-more">Show more</a>
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