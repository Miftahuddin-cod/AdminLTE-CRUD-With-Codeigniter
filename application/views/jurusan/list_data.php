<?php
$no = 1;
foreach ($dataJurusan as $jurusan) {
?>
    <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $jurusan->nama; ?></td>
        <td><?php echo $jurusan->fakultas; ?></td>
        <td class="text-center" style="min-width:230px;">
            <button class="btn btn-warning update-dataJurusan" data-id="<?php echo $jurusan->id; ?>"><i class="glyphicon glyphicon-repeat"></i> Update</button>
            <button class="btn btn-danger konfirmasiHapus-jurusan" data-id="<?php echo $jurusan->id; ?>" data-toggle="modal" data-target="#konfirmasiHapus"><i class="glyphicon glyphicon-remove-sign"></i> Delete</button>
            <button class="btn btn-info detail-dataJurusan" data-id="<?php echo $jurusan->id; ?>"><i class="glyphicon glyphicon-info-sign"></i> Detail</button>
        </td>
    </tr>
<?php
    $no++;
}
?>