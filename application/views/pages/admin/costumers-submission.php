<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Tables</h1>
<p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
    For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>No Ktp</th>
                        <th>Nama</th>
                        <th>Status</th>
                        <th>Tanggal Pembuatan</th>
                        <th class="text-center">Options</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>No Ktp</th>
                        <th>Nama</th>
                        <th>Status</th>
                        <th>Tanggal Pembuatan</th>
                        <th class="text-center">Options</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php $no = 0;
                    foreach ($content as $row) : $no++ ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td><strong><?= $row->account_id ?></strong></td>
                            <td><?= $row->name ?></td>
                            <td>
                                <?php if ($row->is_approved == '') : ?>
                                    <a href="#" class="badge badge-warning text-dark">Belum Upload Foto</a>
                                <?php else : ?>
                                    <a href="#" class="badge badge-info">Menunggu Di Konfirmasi</a>
                                <?php endif; ?>
                            </td>
                            <td><?= $row->date_created ?></td>
                            <form action="<?= base_url('admin/costumers/delete/' . $row->id) ?>" method="post">
                                <td class="text-center">
                                    <a href="<?= base_url('admin/costumers/edit/' . $row->id) ?>" class="btn btn-primary btn-circle btn-sm">
                                        <i class="fas fa-edit px-3"></i>
                                    </a>
                                    <input type="hidden" name="id" value="<?= $row->id  ?>">
                                    <button type="submit" class="btn btn-danger btn-circle btn-sm" onclick="return confirm('Suru Want Delete This Orders?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </form>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>