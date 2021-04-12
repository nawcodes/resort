<?php $this->load->view('layouts/_alert'); ?>

<!-- DataTales Example -->
<div class="offset-lg-2 col-lg-8">
    <h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="float-left">
                <h6 class="m-0 font-weight-bold text-primary"><?= $title ?>

                </h6>
            </div>
            <?php if (isset($re_key) && $this->uri->segment(2) == 'guest' && $this->uri->segment(3) == 'edit') : ?>
                <div class="float-right">
                    <form action="<?= base_url('admin/guest/delete/' . $re_key->reId) ?>" method="post">

                        <input type="hidden" name="re_id" value="<?= $re_key->reId ?>">

                        <div>
                            <button type="submit" class="btn btn-danger btn-sm btn-icon-split" onclick="return confirm('Setelah Klik (OK) , Kunci kamar & Ruangan ini akan di bersihkan dan di set menjadi kosong. apakah yakin?')">
                                <span class="icon text-white-50">
                                    <i class="fas fa-trash"></i>
                                </span>
                                <span class="text">Hapus Kunci & Bersihkan Kamar Ini</span>
                            </button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <?= isset($re_key->role_key) ? '<p>Ruangan ini di isi oleh <span class="text-primary">' . ucfirst($re_key->role_key) . '</p>' : '' ?>
            <form action="<?= $form ?>" method="post">
                <input type="hidden" name="id_rooms" value="<?= $content->id_rooms ?>">
                <div class="row">

                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <div class="input-group ">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">No</span>
                            </div>
                            <input type="text" class="form-control" name="" placeholder="No Ruangan" value="<?= $content->number_rooms ?>" disabled>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Kelas</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Kelas Kamar" name="type_rooms" value="<?= $content->className ?>" disabled>

                        </div>

                    </div>

                </div>

                <div class="row mt-3">

                    <div class="col-lg">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Nama</span>
                            </div>
                            <input type="text" class="form-control" name="title" placeholder="Atas Nama / Judul" value="<?= $input->title ?>">
                        </div>
                        <?= form_error('title', '<small class="text-danger">', '</small>') ?>

                    </div>

                </div>

                <div class="row mt-3">

                    <div class="col-lg-6 col-md-6 ">

                        <div class="input-group">

                            <div class="input-group-prepend">
                                <span class="input-group-text">Check in</span>
                            </div>
                            <input type="date" class="form-control" name="date_from" value="<?= $input->date_from ?>">

                        </div>
                        <?= form_error('date_from', '<small class="text-danger">', '</small>') ?>


                    </div>

                    <div class="col-lg-6 col-md-6">

                        <div class="input-group mb-3">

                            <div class="input-group-prepend">
                                <span class="input-group-text">Check out</span>
                            </div>
                            <input type="date" class="form-control" name="date_to" value="<?= $input->date_to ?>">



                        </div>
                        <?= form_error('date_to', '<small class="text-danger">', '</small>') ?>




                    </div>

                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Apakah Aktif</label>
                            </div>
                            <select class="custom-select" name="is_active" id="inputGroupSelect01">
                                <option value="1" <?= $input->is_active == '1' ? 'selected' : '';  ?>>Aktif</option>
                                <option value="0" <?= $input->is_active == '0' ? 'selected' : '';  ?>>Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>

                <?php if (isset($re_key) && $this->uri->segment(2) == 'guest' && $this->uri->segment(3) == 'edit') : ?>
                    <hr>
                    <?php  ?>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 text-center py-2">
                            <img src="<?= base_url('assets/images/qrcodes/' . $re_key->qrcode_key) ?>" alt="" class="img-thumbnail">
                        </div>

                        <div class="offset-lg-2 col-lg-4 col-md-6 py-2">
                            <ul style="list-style: none;">
                                <li>Judul : <?= $input->title ?></li>
                                <li>Dari tanggal : <?= $input->date_from ?></li>
                                <li>Sampai tanggal : <?= $input->date_to ?></li>
                                <li>Waktu habis : <?= $re_key->time_expired ?></li>
                                <li>Apakah Aktif? :
                                    <?php if ($input->is_active == '1') : ?>
                                        <span class="badge badge-primary">Aktif</span>
                                    <?php else : ?>
                                        <span class="badge badge-warning">Tidak Aktif</span>
                                    <?php endif; ?>
                                </li>
                                <hr>
                                <li class="text-center">
                                    Dibuat Pada Tanggal :
                                    <br>
                                    <span class="bg-info text-white p-1"><?= $re_key->date_registered ?></span>
                                </li>

                            </ul>
                        </div>
                    </div>
                <?php endif; ?>



        </div>
        <div class="card-footer">
            <div class="float-left">
                <a href="<?= base_url('admin/guest') ?>" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-arrow-left"></i>
                    </span>
                    <span class="text">Kembali</span>
                </a>
            </div>
            <div class="float-right">
                <?php if (isset($re_key)) : ?>
                    <a href="#" class="btn btn-info btn-icon-split" data-toggle="modal" data-target="#staticBackdrop">
                        <span class="icon text-white-50">
                            <i class="fas fa-key"></i>
                        </span>
                        <span class="text">Kirim Kunci</span>
                    </a>
                <?php endif; ?>
                <button type="submit" class="btn btn-success btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Simpan & Buat</span>
                </button>
            </div>

            </form>
        </div>
    </div>
</div>


<!-- Button trigger modal -->

<!-- Modal -->
<?php if (isset($re_key)) : ?>
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Di Kirim Ke Email?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('admin/guest/send') ?>" method="post">
                        <input type="hidden" name="re_id" value="<?= $re_key->reId ?>">
                        <div class="form-group">
                            <label for="">E-mail</label>
                            <input type="email" name="email" class="form-control" placeholder="samantha@gmail.com">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>