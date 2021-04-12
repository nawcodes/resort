<div class="container my-1 py-3 ">
    <?php $this->load->view('layouts/_alert'); ?>
    <a href="<?= base_url('booking/reservation/' . $this->session->userdata('id_type_rooms')) ?>" class="btn btn-sm btn-primary">Kembali</a>

    <!-- informasi kamar -->
    <div class="card mt-2">
        <div class="card-header">
            <h3>Informasi Kamar</h3>
        </div>
        <div class="card-body">
            <div class="row">


                <div class="col-lg-2 col-md-4 col-sm-4">
                    <label for="">Kelas Kamar</label>
                    <div class="form-group">
                        <span class="bg-primary text-white rounded form-control"><?= $rooms->name ?></span>
                    </div>
                </div>

                <div class="col-lg-2 col-md-4 col-sm-4">
                    <label for="">Harga Permalam</label>
                    <div class="form-group">
                        <span class="bg-primary text-white rounded form-control"><?= price($rooms->price_pernight) ?></span>
                    </div>
                </div>

                <div class="col-lg-2 col-md-4 col-sm-4">
                    <label for="">Maksimal Orang</label>
                    <div class="form-group">
                        <span class="bg-primary text-white rounded form-control"><?= $rooms->max_person ?> Orang</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- informasi pemesanan -->
    <div class="card mt-2">
        <div class="card-header">
            <h4>Informasi Pemesanan</h4>
        </div>
        <div class="card-body">
            <div class="row">

                <div class="col-lg-2 col-md-4 col-sm-4">
                    <label for="">Pemesanan Kamar</label>
                    <div class="form-group">
                        <input type="text" name="rooms" class="form-control" min="1" value="<?= $this->session->userdata('rooms') ?>">
                    </div>
                </div>

                <div class="col-lg-2 col-md-4 col-sm-4">
                    <label for="">Dewasa</label>
                    <div class="form-group">
                        <span class="bg-primary text-white rounded form-control"><?= $this->session->userdata('adult'); ?> Orang</span>
                    </div>
                </div>

                <div class="col-lg-2 col-md-4 col-sm-4">
                    <label for="">Anak</label>
                    <div class="form-group">
                        <span class="bg-primary text-white rounded form-control"><?= $this->session->userdata('child'); ?> anak</span>
                    </div>
                </div>

                <div class="col-lg-2 col-md-4 col-sm-4">
                    <label for="">Umur anak</label>
                    <div class="form-group">
                        <span class="bg-primary text-white rounded form-control"><?= $this->session->userdata('age'); ?> tahun</span>
                    </div>
                </div>
            </div>
            <hr>
            <form action="<?= base_url('booking/create/' . $this->session->userdata('id_type_rooms')) ?>">

                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Check In</label>
                            <input type="date" class="form-control" name="date_from" id="" value="<?= $this->session->userdata('date_from') ?>">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Check Out</label>
                            <input type="date" class="form-control" name="date_to" value="<?= $this->session->userdata('date_to') ?>">
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Estimasi Menginap</label>
                            <input type="text" class="form-control" name="estimation" value="<?= $this->session->userdata('estimation'); ?> Malam" disabled>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for=""></label>
                            <button type="submit" class="btn btn-success form-control mt-2" name="btn-reservation">Ubah</button>
                        </div>
                    </div>
                </div>

            </form>

        </div>
        <div class="card-footer">
            Subtotal : <h2 class="text-center"> <?php
                                                $type_rooms = $this->db->select('price_pernight')->from('type_rooms')->where('id', $this->session->userdata('id_type_rooms'))->get()->row();


                                                echo (price($this->session->userdata('estimation') * ($this->session->userdata('rooms') * $type_rooms->price_pernight)));

                                                ?></h2>
        </div>
    </div>

    <!-- formulir data costumers -->
    <div class="card mt-2">
        <div class="card-header text-white bg-info">
            <h4>Formulir Pemesanan Booking</h4>
        </div>
        <div class="card-body">

            <?= form_open_multipart(base_url('booking/create/' . $rooms->id), ['method' => 'post']) ?>

            <input type="hidden" name="id_rooms" value="<?= $rooms->id ?>">
            <input type="hidden" name="account_id" value="">
            <input type="hidden" name="date_from" value="<?= $this->session->userdata('date_from') ?>">
            <input type="hidden" name="date_to" value="<?= $this->session->userdata('date_to') ?>">

            <input type="hidden" name="rooms" value="<?= $this->session->userdata('rooms') ?>">
            <input type="hidden" name="adult" value="<?= $this->session->userdata('adult') ?>">
            <input type="hidden" name="person" value="<?= $this->session->userdata('person') ?>">
            <input type="hidden" name="child" value="<?= $this->session->userdata('child') ?>">
            <input type="hidden" name="age_child" value="<?= $this->session->userdata('age') ?>">


            <?= form_error('date_from', '<p class="text-danger">', '</p>') ?>
            <?= form_error('date_to', '<p class="text-danger">', '</p>') ?>


            <strong class="bg-danger rounded text-white">Formulir wajib di isi</strong>
            <hr>

            <div class="row">

                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="">Nama Lengkap KTP <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" placeholder="Samantha Rasyid" value="<?= $input->name ?>">
                    </div>

                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="">Email Aktif <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" placeholder="ex:samantha@gmail.com" value="<?= $input->email ?>">
                    </div>
                    <?= form_error('email', '<p class="text-danger">', '</p>') ?>

                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="">No Telp / Whatsapp aktif <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="phone" placeholder="085650776622" value="<?= $input->phone ?>">
                    </div>
                    <?= form_error('phone', '<p class="text-danger">', '</p>') ?>

                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Alamat</label>
                        <textarea class="form-control" name="address" id="" rows="1" placeholder="Jakarta"></textarea>
                        <?= form_error('address', '<p class="text-danger">', '</p>') ?>
                    </div>
                </div>
            </div>

            <!-- <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">No KTP <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="account_id" value="<?= $input->account_id ?>">
                    </div>
                    <?= form_error('account_id', '<p class="text-danger">', '</p>') ?>

                </div>

            </div> -->


            <div class="row">

                <div class="col-lg-4">
                    <label for="">Foto KTP <span class="text-danger">*</span></label>
                    <?= form_upload('account_image') ?>
                </div>

                <div class="col-lg-4">
                    <label for="">Foto KTP dengan pengguna <span class="text-danger">*</span></label>
                    <?= form_upload('account_image_user') ?>
                </div>

            </div>

            <hr>
            <p>Pemesan dari luar negri wajib upload passport</p>

            <div class="row">
                <div class="col-lg-4">
                    <label for="">Passport <small>(Optional)</small></label>
                    <?= form_upload('passport') ?>
                </div>

                <div class="col-lg-4">
                    <label for="">Visa <small>(Optional)</small></label>
                    <?= form_upload('visa', '', ['class' => 'form-control-file']) ?>
                </div>

            </div>



            <!-- <div class="row">
                <div class="col-lg">
                    <div class="form-group">
                        <label for="">Alamat <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="" name="address" rows="1"><?= $input->address ?></textarea>
                    </div>
                    <?= form_error('address', '<p class="text-danger">', '</p>') ?>


                </div>
            </div> -->


            <div class="row mt-4">
                <div class="col-lg">
                    <div class="form-group">
                        <label class="bmd-label-floating">Mau Tambah Kasur ? <br>
                            <small><i class="bg-light p-1"> <span class="text-danger"> Catatan: </span> Jika Kapasitas Orang Melebihi Kapasitas kamar maka wajib memakai <strong>EXTRA BED </strong></i></small>
                            <br>
                        </label>
                        <br>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Ukuran Extra Bed <small>(Optional)</small></label>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Extra Bed</label>
                                <select class="form-control" name="extra" id="exampleFormControlSelect1">
                                    <option value="">--select--</option>
                                    <?php foreach ($extra as $row) : ?>
                                        <option value="<?= $row->id ?>"><?= $row->name ?> / <?= price($row->price) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <!-- <div class="row">
                <div class="col-lg">
                    <div class="form-group">
                        <label class="bmd-label-floating">Apakah kamu di nyatakan sehat? <span class="text-danger">*</span></label>
                        <br>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" name="is_healthy" type="checkbox" value="1"> Iya
                                <span class="form-check-sign">
                                    <span class="check"></span>
                                </span>
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" name="is_healthy" type="checkbox" id="inlineCheckbox2" value="0"> Tidak
                                <span class="form-check-sign">
                                    <span class="check"></span>
                                </span>
                            </label>
                        </div>
                    </div>
                    <?= form_error('is_healthy', '<p class="text-danger">', '</p>') ?>
                </div>
            </div> -->
        </div>
        <div class="card-footer ">
            <a href="<?= base_url('booking') ?>" class="btn btn-primary">Kembali</a>
            <button class="btn btn-success float-right" type="submit">
                Selanjutnya
            </button>
        </div>

        <?= form_close(); ?>


    </div>




</div>