<div class="col-md-12 well">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h3 style="display:block; text-align:center;"><i class="fa fa-briefcase"></i> List Mahasiswa (Fakultas: <b><?php echo $fakultas->nama; ?></b>)</h3>

    <div class="box box-body">
        <table id="tabel-detail" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Jurusan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="data-mahasiswa">
                <?php
                foreach ($dataFakultas as $mahasiswa) {
                ?>
                    <tr>
                        <td><?php echo $mahasiswa->id; ?></td>
                        <td style="min-width:230px;"><?php echo $mahasiswa->mahasiswa; ?></td>
                        <td><?php echo $mahasiswa->kelamin; ?></td>
                        <td><?php echo $mahasiswa->jurusan; ?></td>
                        <td><?php if ($mahasiswa->statusMahasiswa == 1) {
                                echo "Lulus";
                            } else echo "Belum Lulus"; ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="text-right">
        <button class="btn btn-danger" data-dismiss="modal"> Close</button>
    </div>
</div>