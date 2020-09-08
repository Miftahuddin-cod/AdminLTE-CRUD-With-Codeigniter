<div class="col-md-offset-1 col-md-10 col-md-offset-1 well">
    <div class="form-msg"></div>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h3 style="display:block; text-align:center;">Update Data Jurusan</h3>

    <form id="form-update-jurusan" method="POST">
        <input type="hidden" name="id" value="<?php echo $dataJurusan->id; ?>">
        <div class="input-group form-group">
            <span class="input-group-addon" id="sizing-addon2">
                <i class="fa fa-briefcase"></i>
            </span>
            <input type="text" class="form-control" placeholder="Nama Jurusan" name="jurusan" aria-describedby="sizing-addon2" value="<?php echo $dataJurusan->nama; ?>">
        </div>
        <div class="input-group form-group">
            <span class="input-group-addon" id="sizing-addon2">
                <i class="fa fa-university"></i>
            </span>
            <select name="fakultas" class="form-control select2" aria-describedby="sizing-addon2" style="width: 100%">
                <option disabled selected>Pilih Fakultas</option>
                <?php
                foreach ($dataFakultas as $fakultas) {
                ?>
                    <option value="<?php echo $fakultas->id; ?>" <?php if ($fakultas->id == $dataJurusan->id_fakultas) {
                                                                        echo "selected='selected'";
                                                                    } ?>>
                        <?php echo $fakultas->nama; ?>
                    </option>
                <?php
                }
                ?>
            </select>
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
    });
</script>