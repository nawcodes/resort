<h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
<p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
    For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p>

<?php $this->load->view('layouts/_alert') ?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?= $title ?>
            <a href="<?= base_url('admin/user/create') ?>" class="btn btn-sm btn-primary">Tambah</a>
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>E-Mail</th>
                        <th>Role</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>E-Mail</th>
                        <th>Role</th>
                        <th class="text-center">Status</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php $no = 0;
                    foreach ($content as $row) : $no++ ?>
                        <tr>
                            <form action="<?= base_url('admin/user/delete/' . $row->id) ?>" method="post">
                                <td><?= $no ?></td>
                                <td>
                                    <img src="<?= base_url('assets/images/user/' . $row->image) ?>" alt="No Image" class="img-thumbnail border border-primary rounded-circle" width="100">
                                    <span class="ml-2"><?= $row->name ?></span>
                                </td>
                                <td><?= $row->email ?></td>
                                <td><?= $row->role ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('admin/user/edit/' . $row->id) ?>" class="btn btn-primary btn-circle btn-sm">
                                        <i class="fas fa-edit px-3"></i>
                                    </a>
                                    <input type="hidden" name="id" value="<?= $row->id ?>">
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




<!-- Modal -->