<?php $this->load->view('layouts/_alert'); ?>
<?= validation_errors(); ?>
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
            </div>

            <div class="card-body">
                <?= form_open_multipart(base_url('admin/costumers/edit/' . $input->id), ['method' => 'post']) ?>
                <input type="hidden" name="id" value="<?= $input->id  ?>">
                <div class="row">
                    <div class="col-lg">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Nama</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Username" name="name" aria-describedby="basic-addon1" value="<?= $input->name ?>">
                        </div>
                    </div>
                    <div class="col-lg">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">E-mail</span>
                            </div>
                            <input type="text" class="form-control" placeholder="E-mail" name="email" aria-describedby="basic-addon1" value="<?= $input->email ?>">
                        </div>
                    </div>
                    <div class="col-lg">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">No.Tlp</span>
                            </div>
                            <input type="text" class="form-control" placeholder="No. Tlp" name="phone" value="<?= $input->phone ?>" aria-describedby="basic-addon1">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">No KTP</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Nomor Ktp" aria-label="" name="account_id" aria-describedby="basic-addon1" value="<?= $input->account_id ?>">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <small class="text-danger">Catatan : Hati Hati Jikalau Merubah No KTP</small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Alamat</span>
                            </div>
                            <textarea class="form-control" name="address" aria-label="With textarea"><?= $input->address ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg">
                        <label for="" class="mt-3">Status</label>
                        <br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_approved" value="verified" <?= $input->is_approved == 'verified' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="inlineRadio1">Terverifikasi</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_approved" value="unverified" <?= $input->is_approved == 'unverified' ? 'checked' : '' ?>">
                            <label class="form-check-label" for="inlineRadio1">Belum Terverifikasi</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_approved" value="failed" <?= $input->is_approved == 'failed' ? 'checked' : '' ?>">
                            <label class="form-check-label" for="inlineRadio1">Foto Tidak Jelas</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_approved" value="" <?= $input->is_approved == '' ? 'checked' : '' ?>">
                            <label class="form-check-label" for="inlineRadio1">Belum Upload Photo</label>
                        </div>
                        <p class="text-danger mt-2">Jika belum terverifikasi costumers ini akan di pindahkan ke <a href="<?= base_url('admin/verify') ?>">Booking->Registered Booking</a></p>
                    </div>

                </div>

                <div class="row">
                    <div class="col-lg">
                        <img src="<?= $costumers->account_image ? base_url('assets/images/account/' . $costumers->account_image) : '' ?>" alt="" class="img-thumbnail" width="500">
                        <div class="mt-2">
                            <label for="">Foto KTP</label>
                            <?= form_upload('account_image', $input->account_image, ['class' => 'form-control-file']) ?>
                        </div>
                    </div>
                    <div class="col-lg">
                        <img src="<?= $costumers->account_image ? base_url('assets/images/account/' . $costumers->account_image_user) : '' ?>" alt="" class="img-thumbnail" width="500">
                        <div class="mt-2">
                            <label for="">Foto Pengguna dengan KTP</label>
                            <?= form_upload('account_image_user', $input->account_image_user, ['class' => 'form-control-file']) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="float-left">
                    <a href="<?= base_url('admin/costumers') ?>" type="submit" class="btn btn-primary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-arrow-left"></i>
                        </span>
                        <span class="text">Kembali</span>
                    </a>
                </div>
                <div class="float-right">
                    <button type="submit" class="btn btn-danger btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-info-circle"></i>
                        </span>
                        <span class="text">Ubah</span>
                    </button>
                </div>
                </form>
            </div>

        </div>
    </div>
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Histori Pemesanan</h6>
            </div>
            <div class="card-body">
                <?php foreach ($bo_orders as $row) : ?>
                    <div class="row">
                        <div class="col">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                                    <h6 class="m-0 font-weight-bold text-primary">#<?= $row->invoice ?></h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseCardExample">
                                    <div class="card-body">
                                        <ul>
                                            <li>Tanggal Bayar : <?= $row->datePaid ?></li>
                                            <li>Status : <?= $row->status ?></li>
                                            <li>Subtotal : <?= price($row->amount) ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- key  -->
        <!-- <?php if ($rooms_key) : ?>
        <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Kunci Kamar Terakhir</h6>
                                </div>
                                <div class="card-body d-flex justify-content-center">
                                    <?php foreach ($rooms_key as $row) : ?>
                                    <div class="row">
                                       <div class="col text-center">
                                           <img src="<?= $row->qrcode_key ? base_url('assets/images/qrcodes/'  . $row->qrcode_key) :
                                                            '' ?>" alt=""> 
                                           <hr style="border: 1px solid #333;">
                                           <span>Waktu Habis : <?= $row->time_expired ?></span>
                                           <?php if ($row->is_active == 1) : ?>
                                            <span class="badge badge-pill badge-primary">Masih Aktif</span>
                                           <?php else : ?>
                                            <span class="badge badge-pill badge-danger"></span>
                                           <?php endif; ?>
                                       </div>                          
                                    </div>
                                    <?php endforeach; ?>
                                </div>       
        </div>
        <?php endif; ?> -->
        <!-- end key  -->
    </div>

</div>