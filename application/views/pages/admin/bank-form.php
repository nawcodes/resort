<div class="container-fluid">
    <?= validation_errors(); ?>
    <div class="card">
        <div class="card-body">
            <form action="<?= base_url('admin/dashboard/edit_bank/' . $input->id) ?>" method="post">
                <input type="hidden" name="id" value="<?= $input->id ?>">
                <div class="form-group">
                    <label for="">Atas nama</label>
                    <input type="text" name="name" class="form-control" value="<?= $input->name ?>">
                </div>
                <div class="form-group">
                    <label for="">Nama Bank</label>
                    <input type="text" name="bank_name" class="form-control" value="<?= $input->bank_name ?>">
                </div>
                <div class="form-group">
                    <label for="">Nomor Rekening Bank</label>
                    <input type="number" name="bank_id" class="form-control" value="<?= (int) $input->bank_id ?>">
                </div>
        </div>
        <div class="card-footer">
            <div class="float-left">
                <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-primary">Kembali</a>
            </div>
            <div class="float-right">
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
            </form>
        </div>
    </div>


</div>