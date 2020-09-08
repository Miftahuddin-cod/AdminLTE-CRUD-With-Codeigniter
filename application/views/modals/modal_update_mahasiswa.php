<div class="col-md-offset-1 col-md-10 col-md-offset-1 well">
    <div class="form-msg"></div>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h3 style="display:block; text-align:center;">Update Data Mahasiswa</h3>
    <form method="POST" id="form-update-mahasiswa">
        <div class="input-group form-group">
            <span class="input-group-addon" id="sizing-addon2">
                <i class="glyphicon glyphicon-tag"></i>
            </span>
            <input type="hidden" name="nim" value="<?php echo $dataMahasiswa->nim; ?>">
            <input type="text" class="form-control" disabled placeholder="NIM" name="nim" value="<?php echo $dataMahasiswa->nim; ?>" aria-describedby="sizing-addon2">
        </div>
        <div class="input-group form-group">
            <span class="input-group-addon" id="sizing-addon2">
                <i class="glyphicon glyphicon-user"></i>
            </span>
            <input type="text" class="form-control" placeholder="Nama" name="nama" aria-describedby="sizing-addon2" value="<?php echo $dataMahasiswa->nama_mahasiswa; ?>">
        </div>
        <div class="input-group form-group" style="display: inline-block;">
            <span class="input-group-addon" id="sizing-addon2">
                Gender
            </span>
            <span class="input-group-addon">
                <input type="radio" name="jk" value="1" id="laki" class="minimal" <?php if ($dataMahasiswa->id_kelamin == 1) {
                                                                                        echo "checked='checked'";
                                                                                    } ?>>
                <label for="laki">Laki-laki</label>
            </span>
            <span class="input-group-addon">
                <input type="radio" name="jk" value="2" id="perempuan" class="minimal" <?php if ($dataMahasiswa->id_kelamin == 2) {
                                                                                            echo "checked='checked'";
                                                                                        } ?>>
                <label for="perempuan">Perempuan</label>
            </span>
        </div>
        <div class="input-group form-group">
            <span class="input-group-addon" id="sizing-addon2">
                <i class="glyphicon glyphicon-home"></i>
            </span>
            <select name="kota" class="form-control select2" aria-describedby="sizing-addon2" style="width: 100%;">
                <?php
                foreach ($dataKota as $kota) {
                ?>
                    <option value="<?php echo $kota->id; ?>" <?php if ($kota->id == $dataMahasiswa->id_kota) {
                                                                    echo "selected='selected'";
                                                                } ?>><?php echo $kota->nama; ?></option>
                <?php
                }
                ?>
            </select>
        </div>
        <div class="input-group form-group">
            <span class="input-group-addon" id="sizing-addon2">
                <i class="glyphicon glyphicon-briefcase"></i>
            </span>
            <select name="jurusan" class="form-control select2" aria-describedby="sizing-addon2" style="width: 100%;">
                <?php
                foreach ($dataJurusan as $jurusan) {
                ?>
                    <option value="<?php echo $jurusan->id; ?>" <?php if ($jurusan->id == $dataMahasiswa->id_jurusan) {
                                                                    echo "selected='selected'";
                                                                } ?>><?php echo $jurusan->nama; ?></option>
                <?php
                }
                ?>
            </select>
        </div>
        <div class="input-group form-group" style="display: inline-block;">
            <span class="input-group-addon font-weight-bold" id="sizing-addon2">
                Status
            </span>
            <span class="input-group-addon">
                <input type="radio" name="status" value="1" id="lulus" class="minimal" <?php if ($dataMahasiswa->statusMahasiswa == 1) {
                                                                                            echo "checked='checked'";
                                                                                        } ?>>
                <label for="lulus">Lulus</label>
            </span>
            <span class="input-group-addon">
                <input type="radio" name="status" value="0" id="belumLulus" class="minimal" <?php if ($dataMahasiswa->statusMahasiswa == 0) {
                                                                                                echo "checked='checked'";
                                                                                            } ?>>>
                <label for="belumLulus">Belum Lulus</label>
            </span>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <button type="submit" class="form-control btn btn-primary"> <i class="glyphicon glyphicon-ok"></i> Update Data</button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(function() {
        $(".select2").select2();

        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue'
        });
    });
</script>