<h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
<?php $this->load->view('layouts/_alert'); ?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?= $title ?>
            <a href="<?= base_url('admin/rooms/create') ?>" class="btn btn-sm btn-primary">Tambah</a>
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nomor Ruangan</th>
                        <th>status</th>
                        <th>Kelas</th>
                        <th class="text-center">Options</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Nomor Ruangan</th>
                        <th>Status</th>
                        <th>Kelas</th>
                        <th class="text-center">Options</th>
                    </tr>
                </tfoot>
                <tbody>

                    <?php $no = 0;
                    foreach ($content as $row) : $no++ ?>
                        <tr>
                            <td> <?= $no ?></td>
                            <td> <span class="btn btn-outline-warning px-5 py-3 text-primary"><?= $row->number_rooms ?></span> </td>
                            <td>
                                <?php if ($row->status == 0) :  ?>
                                    <span class="badge badge-primary">Tersedia</span>
                                <?php else :  ?>
                                    <span class="badge badge-danger">Kotor</span>
                                <?php endif;  ?>
                            </td>
                            <td>
                                <?= $row->className ?>
                            </td>
                            <form action="<?= base_url('admin/rooms/delete/' . $row->roomsId) ?>" method="post">
                                <input type="hidden" name="id_rooms" value="<?= $row->roomsId ?>">
                                <td class="text-center">
                                    <a href="<?= base_url('admin/rooms/edit/' . $row->roomsId) ?>" class="btn btn-primary btn-circle btn-sm">
                                        <i class="fas fa-edit px-3"></i>
                                    </a>
                                    <button type="submit" class="btn btn-danger btn-circle btn-sm" onclick="return confirm('Yakin Mau menghapus ruangan ini?')">
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