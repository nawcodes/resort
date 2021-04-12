<h1 class="h3 mb-2 text-gray-800"></h1>
<!-- DataTales Example -->

<?php $this->load->view('layouts/_alert'); ?>

<div class="row">
    <div class="offset-lg-3 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
            </div>

            <div class="card-body">
                <form action="<?= $form ?>" method="post">
                    <input type="hidden" name="id_rooms" value="<?= isset($content->id) ? $content->id : '' ?>">
                    <div class="table-responsive">
                        <div class="row">
                            <div class="col-lg-8 col-md-6 col-sm-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">No Kamar</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="No Kamar" name="number_rooms" value="<?= $input->number_rooms ?>">

                                    <?= form_error('number_rooms', '<small class="text-danger mt-2 pl-2">', '</small>') ?>


                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-10 col-md-12 col-sm-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">Tipe Kamar</label>
                                    </div>
                                    <?= form_dropdown('id_type_rooms', dropdown('type_rooms', ['id', 'name']), $input->id_type_rooms, ['class' => 'custom-select'])  ?>
                                    <br>

                                    <?= form_error('id_type_rooms', '<small class="text-danger mt-2 pl-2">', '</small>') ?>

                                </div>


                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md col-sm">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">Keadaan</label>
                                    </div>
                                    <select class="custom-select" name="status">
                                        <option value="0" <?= $input->status == '0' ? 'selected' : '' ?>>Bersih</option>
                                        <option value="1" <?= $input->status == '1' ? 'selected' : '' ?>>Kotor</option>
                                    </select>
                                </div>
                                <?= form_error('status', '<small class="text-danger mt-2 pl-2">', '</small>') ?>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="card-footer">
                <div class="float-left">
                    <a href="<?= base_url('admin/rooms') ?>" class="btn btn-primary btn-icon-split">
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