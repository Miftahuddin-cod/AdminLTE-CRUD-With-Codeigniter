<div class="col-md-offset-1 col-md-10 col-md-offset-1 well">
    <div class="form-msg"></div>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h3 style="display:block; text-align:center;">Tambah Data Mahasiswa</h3>

    <form id="form-tambah-mahasiswa" method="POST">
        <div class="input-group form-group">
            <span class="input-group-addon" id="sizing-addon2">
                <i class="glyphicon glyphicon-tag"></i>
            </span>
            <input type="text" class="form-control" placeholder="NIM" name="nim" aria-describedby="sizing-addon2">
        </div>
        <div class="input-group form-group">
            <span class="input-group-addon" id="sizing-addon2">
                <i class="glyphicon glyphicon-user"></i>
            </span>
            <input type="text" class="form-control" placeholder="Nama" name="nama" aria-describedby="sizing-addon2">
        </div>
        <div class="input-group form-group" style="display: inline-block;">
            <span class="input-group-addon" id="sizing-addon2">
                Gender
            </span>
            <span class="input-group-addon">
                <input type="radio" name="jk" value="1" id="laki" class="minimal">
                <label for="laki">Laki-laki</label>
            </span>
            <span class="input-group-addon">
                <input type="radio" name="jk" value="2" id="perempuan" class="minimal">
                <label for="perempuan">Perempuan</label>
            </span>
        </div>
        <div class="input-group form-group">
            <span class="input-group-addon" id="sizing-addon2">
                <i class="glyphicon glyphicon-home"></i>
            </span>
            <select name="kota" class="form-control select2" aria-describedby="sizing-addon2" style="width: 100%;">
                <option disabled selected>
                    Pilih Kota
                </option>
                <?php
                foreach ($dataKota as $kota) {
                ?>
                    <option value="<?php echo $kota->id; ?>">
                        <?php echo $kota->nama; ?>
                    </option>
                <?php
                }
                ?>
            </select>
        </div>
        <div class="input-group form-group">
            <span class="input-group-addon" id="sizing-addon2">
                <i class="glyphicon glyphicon-briefcase"></i>
            </span>
            <select name="jurusan" class="form-control select2" aria-describedby="sizing-addon2" style="width: 100%">
                <option disabled selected>
                    Pilih Jurusan
                </option>
                <?php
                foreach ($dataJurusan as $jurusan) {
                ?>
                    <option value="<?php echo $jurusan->id; ?>">
                        <?php echo $jurusan->nama; ?>
                    </option>
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
                <input type="radio" name="status" value="1" id="lulus" class="minimal">
                <label for="lulus">Lulus</label>
            </span>
            <span class="input-group-addon">
                <input type="radio" name="status" value="0" id="belumLulus" class="minimal">
                <label for="belumLulus">Belum Lulus</label>
            </span>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <button type="submit" class="form-control btn btn-primary"> <i class="glyphicon glyphicon-ok"></i> Tambah Data</button>
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