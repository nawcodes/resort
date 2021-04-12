<?= validation_errors('<li class="list-group-item list-group-item-danger mb-2">', '</li>') ?>
<?php $this->load->view('layouts/_alert'); ?>


<a href="#" class="btn btn-success btn-icon-split mb-2" data-toggle="modal" data-target="#btn-masterkey">
    <span class="icon text-white-50">
        <i class="fas fa-key"></i>
    </span>
    <span class="text">Tambah Kunci Master</span>
</a>
<?php foreach ($content as $row) : ?>
    <div class="card shadow mb-3 ">
        <form action="<?= base_url('admin/keys/delete/') ?>" method="post">
            <div class="border-primary border-left card-body">
                <?= $row->name ?>
                <div class="float-right">
                    <a href="<?= base_url('admin/keys/detail/' . $row->id_rooms_key) ?>" class="btn btn-sm ">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="<?= base_url('admin/keys/edit/' . $row->id) ?>" class="btn btn-sm">
                    </a>
                    <i class="fas fa-edit"></i>
                    <input type="hidden" name="id" value="<?= $row->id ?>">
                    <button type="submit" class="btn btn-sm" onclick="return confirm('Yakin mau di hapus!')">
                        <i class="fas fa-trash text-danger"></i>
                    </button>
                </div>
        </form>
    </div>
    <div class="card-footer">
        <form action="<?= base_url('admin/keys/send') ?>" method="post">

            <div class="float-left">
                Tanggal Di Buat : <?= $row->date_registered ?>
            </div>
            <div class="float-right">
                Di Buat Oleh : <?= $row->author ?>
                <input type="hidden" value="<?= $row->id ?>" name="id">
                <button type="submit" class="btn btn-primary ml-3" onclick="return confirm('Kunci ini akan dikirim ke email yang sedang login.')">
                    Kirim Kunci
                </button>
            </div>
        </form>

    </div>

    </div>
<?php endforeach; ?>



<!-- Modal -->
<div class="modal fade" id="btn-masterkey" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="btn-masterkeyLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="btn-masterkeyLabel">Tambah Kunci Master</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('admin/keys/create') ?>" method="post">
                    <div class="form-group">
                        <label for="">Nama</label>
                        <input type="text" name="name" class="form-control">
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>




<!-- Modal -->