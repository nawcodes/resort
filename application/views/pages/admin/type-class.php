<h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>

<?php $this->load->view('layouts/_alert'); ?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?= $title ?>
            <a href="<?= base_url('admin/type_rooms/create') ?>" class="btn btn-sm btn-primary">Tambah</a>
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Kelas</th>
                        <th>Harga / Malam</th>
                        <th>Fasilitas</th>
                        <th>Maksimal</th>
                        <th>Twin Bed</th>
                        <th>Photo</th>
                        <th class="text-center">Options</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Nama Kelas</th>
                        <th>Harga / Malam</th>
                        <th>Fasilitas</th>
                        <th>Maksimal</th>
                        <th>Twin Bed</th>
                        <th>Photo</th>
                        <th class="text-center">Options</th>
                    </tr>
                </tfoot>
                <tbody>

                    <?php $no = 0;
                    foreach ($content as $row) : $no++ ?>

                        <tr>
                            <td><?= $no ?></td>
                            <td><?= ucwords($row->name) ?></td>
                            <td><?= price($row->price_pernight) ?></td>
                            <td><?= $row->facilities  ?></td>
                            <td><?= $row->max_person ?> Orang</td>
                            <td><?= $row->twin_bed == 1 ? 'Termasuk' : 'Tidak' ?></td>
                            <td>

                                <img src="<?= base_url('assets/images/classrooms/' . $row->image) ?>" class="img-thumbnails" width="100">
                            </td>
                            <form action="<?= base_url('admin/type_rooms/delete/' . $row->id) ?>" method="post">
                                <td class="text-center">
                                    <a href="<?= base_url('admin/type_rooms/edit/' . $row->id) ?>" class="btn btn-primary btn-circle btn-sm">
                                        <i class="fas fa-edit px-3"></i>
                                    </a>
                                    <input type="hidden" name="id_type_rooms" value="<?= $row->id ?>">
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