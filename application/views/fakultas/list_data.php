<?php
$no = 1;
foreach ($dataFakultas as $fakultas) {
?>
    <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $fakultas->nama; ?></td>
        <td class="text-center" style="min-width:230px;">
            <button class="btn btn-warning update-dataFakultas" data-id="<?php echo $fakultas->id; ?>"><i class="glyphicon glyphicon-repeat"></i> Update</button>
            <button class="btn btn-danger konfirmasiHapus-fakultas" data-id="<?php echo $fakultas->id; ?>" data-toggle="modal" data-target="#konfirmasiHapus"><i class="glyphicon glyphicon-remove-sign"></i> Delete</button>
            <button class="btn btn-info detail-dataFakultas" data-id="<?php echo $fakultas->id; ?>"><i class="glyphicon glyphicon-info-sign"></i> Detail</button>
        </td>
    </tr>
<?php
    $no++;
}
?>