<div class="offset-lg-4 col-lg-4 offset-md-1 col-md-10">
    <?= validation_errors('<li class="list-group-item list-group-item-danger mb-2">', '</li>') ?>
    <div class="card shadow mb-3 ">
        <div class="card-header">
            <p><?= $title ?></p>
        </div>
        <div class="card-body text-center">
            <img src="<?= base_url('assets/images/qrcodes/' . $content->qrcode_key) ?>" alt="" class="img-thumbnail" width="500">
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
        </div>
    </div>
</div>