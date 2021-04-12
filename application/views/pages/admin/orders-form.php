<div class="container">
    <div class="row">
        <div class="offset-lg-3  col-lg-6">
            <?php $this->load->view('layouts/_alert'); ?>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/orders/edit/' . $content->id) ?>" method="post">
                        <input type="hidden" value="<?= $content->id_re_key ?>" name="id_key">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="">No Kamar</label>
                                <div class="form-group">
                                    <input type="text" class="form-control" value="<?= $rooms->number_rooms ?>" disabled>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="">Kelas Kamar</label>

                                <div class="form-group">
                                    <input type="text" class="form-control" value="<?= ucfirst($type_rooms->name) ?>" disabled>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="">No Kamar Yang Tersedia</label>
                                    <?= form_dropdown('rooms_number', dropdownCond('rooms', ['id', 'number_rooms'], 'id_type_rooms = ' . '"' . $content->typeId . '"' . 'AND  status =' . '"0"', ''), '', ['class' => 'form-control']) ?>
                                    <?= form_error('rooms_number', '<small class="text-dark bg-warning">', '</small>') ?>

                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col">

                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Apakah Aktif?</label>
                                    <select class="form-control" id="exampleFormControlSelect1" name="is_active">
                                        <option value="1" <?= $input->is_active == 1 ? 'selected' : '' ?>>Aktif</option>
                                        <option value="0" <?= $input->is_active == 0 ? 'selected' : '' ?>>Tidak Aktif</option>
                                    </select>
                                </div>

                            </div>
                        </div>

                </div>
                <div class="card-footer">
                    <div class="float-left">
                        <a href="<?= base_url('admin/orders/orders_detail/' . $inv->invoice) ?>" class="btn btn-primary btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-arrow-left"></i>
                            </span>
                            <span class="text">Kembali</span>
                        </a>
                    </div>
                    <div class="float-right">
                        <button type="submit" class="btn btn-success btn-icon-split" onclick="return confirm('Peringatan!, jika kunci dirubah maka kunci sebelumnya akan terhapus dan tergantikan dengan QR CODE yang baru.')">
                            <span class="icon text-white-50">
                                <i class="fas fa-check"></i>
                            </span>
                            <span class="text">Ubah</span>
                        </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>