<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Pegawai</h1>

    <!-- Form untuk mengedit karyawan -->
    <form action="<?= base_url('admin/updateemployee') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= $employee['id'] ?>">

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <img src="<?= base_url('/uploads/' . $employee['foto']) ?>" class="card-img-top" alt="<?= $employee['nama']; ?>">
                    <div class="card-body">
                        <label for="foto">Foto</label>
                        <input type="file" class="form-control-file" id="foto" name="foto">
                        <small class="form-text text-muted">Upload gambar baru jika ingin mengganti gambar yang ada.</small>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?= $employee['nama'] ?>" required>
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" required><?= $employee['alamat'] ?></textarea>
                </div>

                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="Laki-laki" <?= ($employee['jenis_kelamin'] == 'Laki-laki') ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="Perempuan" <?= ($employee['jenis_kelamin'] == 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= $employee['tanggal_lahir'] ?>" required>
                </div>

                <div class="form-group">
                    <label for="nomor_telepon">Nomor Telepon</label>
                    <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon" value="<?= $employee['nomor_telepon'] ?>" required>
                </div>

                <div class="form-group">
                    <label for="jabatan">Jabatan</label>
                    <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?= $employee['jabatan'] ?>" required>
                </div>

                <!-- Input untuk mengedit gaji -->
                <div class="form-group">
                    <label for="gaji">Gaji</label>
                    <input type="text" class="form-control" id="gaji" name="gaji" value="<?= $employee['gaji'] ?>" required>
                </div>

                <!-- Input untuk mengedit tanggal bergabung -->
                <div class="form-group">
                    <label for="tanggal_bergabung">Tanggal Bergabung</label>
                    <input type="date" class="form-control" id="tanggal_bergabung" name="tanggal_bergabung" value="<?= $employee['tanggal_bergabung'] ?>" required>
                </div>

                <!-- Input untuk mengedit status pernikahan -->
                <div class="form-group">
                    <label for="status_pernikahan">Status Pernikahan</label>
                    <select class="form-control" id="status_pernikahan" name="status_pernikahan" required>
                        <option value="Sudah Menikah" <?= ($employee['status_pernikahan'] == 'Sudah Menikah') ? 'selected' : '' ?>>Sudah Menikah</option>
                        <option value="Lajang" <?= ($employee['status_pernikahan'] == 'Lajang') ? 'selected' : '' ?>>Lajang</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="<?= base_url('admin/detail/' . $employee['id']) ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- /.container-fluid -->
<?= $this->endSection(); ?>