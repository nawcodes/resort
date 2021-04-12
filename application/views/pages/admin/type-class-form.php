<div class="row">

    <div class="offset-lg-2 col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
            </div>
            <div class="card-body">
                <?= form_open_multipart($form, ['method' => 'post'])   ?>
                <input type="hidden" name="id_type_rooms" value="<?= isset($content->id) ? $content->id : '' ?>">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Nama Kelas</span>
                            </div>
                            <input type="text" class="form-control" name="name" value="<?= $input->name ?>">
                            <?= form_error('name', '<small class="text-danger">', '</small>') ?>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" class="form-control" name="price_pernight" value="<?= $input->price_pernight ?>" aria-label="Amount (to the nearest dollar)">
                            <div class="input-group-append">
                                <span class="input-group-text"> / Malam</span>
                            </div>
                            <?= form_error('price_pernight', '<small class="text-danger">', '</small>') ?>

                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Maksimal</span>
                            </div>
                            <input type="number" name="max_person" class="form-control" aria-label="Amount (to the nearest dollar)" value="<?= $input->max_person ?>">
                            <div class="input-group-append">
                                <span class="input-group-text"> / Orang</span>
                            </div>
                            <?= form_error('max_person', '<small class="text-danger">', '</small>') ?>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="">Fasilitas</label>
                            <textarea class="form-control" name="facilities" id="exampleFormControlTextarea1" rows="3"><?= $input->facilities ?></textarea>
                        </div>
                        <?= form_error('facilities', '<small class="text-danger">', '</small>') ?>

                    </div>
                </div>

                <div class="row">
                    <div class="col-lg">
                        <label for="">Photo</label>
                        <?= form_upload('image', '', ['class' => 'form-control-file']) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg">
                        <label for="" class="mt-3">Twin Bed</label>
                        <br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="twin_bed" id="inlineRadio1" <?= $input->twin_bed == 1 ? 'checked' : '' ?> value="1">
                            <label class="form-check-label" for="inlineRadio1">Ya</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="twin_bed" id="inlineRadio1" value="0" <?= $input->twin_bed == 0 ? 'checked' : '' ?>>
                            <label class="form-check-label" for="inlineRadio1">Tidak</label>
                        </div>
                    </div>
                    <?= form_error('twin_bed', '<small class="text-danger">', '</small>') ?>

                </div>
            </div>

            <div class="card-footer">
                <div class="float-left">
                    <a href="<?= base_url('admin/type_rooms') ?>" class="btn btn-primary btn-icon-split">
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

</div>