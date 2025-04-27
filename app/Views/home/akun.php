<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<style>
    input.form-control {
        border-radius: 1px !important;
    }

    input>.form-control {
        width: 150px !important;
    }

    .input-group-text {
        border-radius: 1px !important;
        background-color: white !important;
    }

    .profile-image {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto 15px auto;
    }

    .profile-image img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .edit-icon {
        position: absolute;
        bottom: 0;
        right: 0;
        background: #f1f1f1;
        border-radius: 50%;
        padding: 5px;
        border: 1px solid #ccc;
        cursor: pointer;
    }

    .form-control {
        border-radius: 10px;
    }

    .btn-edit {
        background-color: #ff2e2e;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px;
        font-weight: bold;
    }

    .btn-logout {
        border: 1px solid #ff2e2e;
        color: #ff2e2e;
        background: transparent;
        border-radius: 8px;
        padding: 10px;
        font-weight: bold;
    }
</style>
<div class="container mt-3">
    <div class="text-center">
        <div class="profile-image" style="position: relative; display: inline-block;">
            <img id="profile-picture" src="<?= base_url('assets/'); ?>images/Profile Photo.png" alt="Profile Picture" style="width:120px; height:120px; object-fit:cover; border-radius:50%; border:2px solid #eee;">

            <!-- Icon edit -->
            <div class="edit-icon" id="edit-icon" style="
            position: absolute;
            bottom: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 50%;
            padding: 5px;
            cursor: pointer;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        ">
                <i class="bi bi-pencil-fill" style="font-size: 12px;"></i>
            </div>

            <!-- Hidden input -->
            <input type="file" id="file-input" accept="image/*" style="display: none;">
        </div>

        <h4 class="mb-4 mt-2"><?= $first_name . ' ' . $last_name ?></h4>
    </div>

    <form class="mx-auto" style="max-width: 700px;">
        <div class="mb-3">
            <label class="form-label">Email</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-envelope-fill"></i>
                </span>
                <input type="email" class="form-control" value="<?=$email;?>" readonly>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Depan</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-person-fill"></i>
                </span>
                <input type="text" class="form-control" name="first_name" id="first_name" value="<?= $first_name; ?>" autocomplete="off">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Belakang</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-person-fill"></i>
                </span>
                <input type="text" class="form-control" name="last_name" id="last_name" value="<?= $last_name; ?>" autocomplete="off">
            </div>
        </div>

        <div class="d-grid mb-3">
            <button type="button" class="btn btn-outline-danger" id="btn-edit-profile">Edit Profil</button>
        </div>
        <div class="d-grid">
            <a href="<?= base_url('logout'); ?>" class="btn btn-danger">Logout</a>
        </div>
    </form>
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
        $('#btn-edit-profile').on('click', function() {
            var first_name = $('#first_name').val();
            var last_name = $('#last_name').val();
            $.ajax({
                url: '<?= base_url('home/update-akun'); ?>',
                type: 'post',
                dataType: 'json',
                data: {
                    first_name,
                    last_name
                },
                success: function(res) {
                    if (res.status == 0) {
                        Swal.fire({
                            title: "Success",
                            text: `Update profile berhasil`,
                            icon: "success"
                        });
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: `Update profile gagal`,
                            icon: "error"
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.error(xhr.statusText);
                }
            });
        });

        $('#edit-icon').click(function() {
            $('#file-input').click(); // Klik icon, buka file input
        });

        $('#file-input').change(function(event) {
            var file = event.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#profile-picture').attr('src', e.target.result); // Preview foto baru
                }
                reader.readAsDataURL(file);

                // Upload ke server
                var formData = new FormData();
                formData.append('file', file);

                $.ajax({
                    url: '<?= base_url('home/update-profile-image'); ?>',
                    type: 'POST', // harus POST karena kirim FormData
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(res) {
                        if (res.status == 0) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Update Photo Profile Berhasil',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Update Photo Profile Gagal',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.error(xhr.statusText);
                    }
                });
            }
        });
    });
</script>
<?= $this->endSection(); ?>