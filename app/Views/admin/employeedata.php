<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-4 text-gray-800">List Pegawai</h1>

  <!-- Tombol Tambah Pegawai -->
  <a href="<?= base_url('/createemployee'); ?>" class="btn btn-success mb-3">Tambah Pegawai</a>

  <div class="row">
    <div class="col-lg-12">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Nama</th>
            <th scope="col">Alamat</th>
            <th scope="col">Jenis Kelamin</th>
            <th scope="col">Tanggal Lahir</th>
            <th scope="col">Nomor Telepon</th>
            <th scope="col">Jabatan</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; ?>
          <?php foreach ($employees as $employee) :  ?>
            <tr>
              <th scope="row"><?= $i++; ?></th>
              <td><?= $employee['nama']; ?></td>
              <td><?= $employee['alamat']; ?></td>
              <td><?= $employee['jenis_kelamin']; ?></td>
              <td><?= $employee['tanggal_lahir']; ?></td>
              <td><?= $employee['nomor_telepon']; ?></td>
              <td><?= $employee['jabatan']; ?></td>
              <td>
                <a href="<?= base_url('admin/detail/' . $employee['id']); ?>" class="btn btn-info">Detail</a>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- /.container-fluid -->
<?= $this->endSection(); ?>