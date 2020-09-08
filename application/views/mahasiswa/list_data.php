<?php
foreach ($dataMahasiswa as $mahasiswa) {
?>
    <tr>
        <td><?php echo $mahasiswa->id; ?></td>
        <td style="min-width:170px;"><?php echo $mahasiswa->mahasiswa; ?></td>
        <td><?php echo $mahasiswa->kelamin; ?></td>
        <td><?php echo $mahasiswa->kota; ?></td>
        <td><?php echo $mahasiswa->jurusan; ?></td>
        <td><?php if ($mahasiswa->statusMahasiswa == 1) {
                echo "Lulus";
            } else echo "Belum Lulus"; ?></td>
        <td class="text-center" style="min-width:230px;">
            <button class="btn btn-warning update-dataMahasiswa" data-id="<?php echo $mahasiswa->id; ?>"><i class="glyphicon glyphicon-repeat"></i> Update</button>
            <button class="btn btn-danger konfirmasiHapus-mahasiswa" data-id="<?php echo $mahasiswa->id; ?>" data-toggle="modal" data-target="#konfirmasiHapus"><i class="glyphicon glyphicon-remove-sign"></i> Delete</button>
        </td>
    </tr>
<?php
}
?>