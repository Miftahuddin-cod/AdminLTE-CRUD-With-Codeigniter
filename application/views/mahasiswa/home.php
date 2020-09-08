<div class="msg" style="display:none;">
    <?php echo @$this->session->flashdata('msg'); ?>
</div>

<div class="box">
    <div class="box-header">
        <div class="col-md-6" style="padding: 0;">
            <button class="form-control btn btn-primary" data-toggle="modal" data-target="#tambah-mahasiswa"><i class="glyphicon glyphicon-plus-sign"></i> Tambah Data</button>
        </div>
        <div class="col-md-3">
            <a href="<?php echo base_url('Mahasiswa/export'); ?>" class="form-control btn btn-default"><i class="glyphicon glyphicon glyphicon-floppy-save"></i> Export Data Excel</a>
        </div>
        <div class="col-md-3">
            <button class="form-control btn btn-default" data-toggle="modal" data-target="#import-mahasiswa"><i class="glyphicon glyphicon glyphicon-floppy-open"></i> Import Data Excel</button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table id="list-data" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Gender</th>
                    <th>Kota Asal</th>
                    <th>Jurusan</th>
                    <th>Status</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody id="data-mahasiswa">

            </tbody>
        </table>
    </div>
</div>

<?php echo $modal_tambah_mahasiswa; ?>

<div id="tempat-modal"></div>

<?php show_my_confirm('konfirmasiHapus', 'hapus-dataMahasiswa', 'Hapus Data Ini?', 'Ya, Hapus Data Ini'); ?>
<?php
$data['judul'] = 'Mahasiswa';
$data['url'] = 'Mahasiswa/import';
echo show_my_modal('modals/modal_import', 'import-mahasiswa', $data);
?>