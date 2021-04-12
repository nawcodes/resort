<div class="offset-lg-4 col-lg-4 offset-md-1 col-md-10">
    <?= validation_errors('<li class="list-group-item list-group-item-danger mb-2">', '</li>') ?>
    <div class="card shadow mb-3 ">
        <div class="card-header">
            <p>Edit Master Key</p>
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/keys/edit/' . $input->id_maskey) ?>" method="post">
                <input type="hidden" name="id_maskey" value="<?= $input->id_maskey ?>">
                <input type="hidden" name="id_rekey" value="<?= $input->id_rekey ?>">
                <div class="form-group">
                    <label for="">Nama</label>
                    <input type="text" name="name" class="form-control" value="<?= $input->name ?>">
                    <small class="text-danger">Catatan: Jika nama dirubah maka pembuat nama yang lama akan di timpa dengan nama pembuat yang baru.</small>
                </div>
        </div>
        <div class="card-footer">
            <div class="float-left">
                <a href="<?= base_url('admin/keys') ?>" type="submit" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-arrow-left"></i>
                    </span>
                    <span class="text">Kembali</span>
                </a>
            </div>
            <div class="float-right">
                <button type="submit" class="btn btn-success btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Simpan</span>
                </button>
                </form>
            </div>
        </div>
    </div>
</div>