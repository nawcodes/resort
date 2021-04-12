<div class="container">
    <?= validation_errors(); ?>
    <?php $this->load->view('layouts/_alert'); ?>
    <div class="container">

        <div class="card">
            <div class="card-header">
                <h2><?= $title ?></h2>
            </div>
            <div class="card-body">
                <?= form_open_multipart(base_url('admin/reservation'), ['method' => 'post']) ?>
                <div class="row">

                    <div class="col-lg-3">
                        <label for="">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" values="<?= $input->name ?>" placeholder="Samantha Bootlop">
                    </div>

                    <div class="col-lg-3">
                        <label for="">NIK KTP</label>
                        <input type="number" name="account_id" class="form-control" values="<?= $input->account_id ?>" placeholder="16 number">
                    </div>

                    <div class="col-lg-3">
                        <label for="">Email Aktif</label>
                        <input type="email" name="email" class="form-control" values="<?= $input->email ?>" placeholder="Samantha@gmail.com">
                    </div>

                    <div class="col-lg-3">
                        <label for="">No Telepon / Whatsapp Aktif</label>
                        <input type="number" name="phone" class="form-control" values="<?= $input->phone ?>" placeholder="085465313245">
                    </div>


                </div>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Alamat</label>
                            <textarea class="form-control" name="address" id="" rows="1" placeholder="Jakarta"></textarea>
                        </div>
                    </div>
                </div>


                <div class="row">

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Foto KTP</label>
                            <?= form_upload('account_image', '', ['class' => 'form-control']) ?>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">

                            <label for=""> Foto KTP dengan Costumers</label>
                            <?= form_upload('account_image_user', '', ['class' => 'form-control']) ?>
                        </div>
                    </div>


                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">

                            <label for="">Foto Passport</label>
                            <?= form_upload('passport', '', ['class' => 'form-control']) ?>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for=""> Foto Visa</label>
                            <?= form_upload('visa', '', ['class' => 'form-control']) ?>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row ">
                    <div class="col-lg-2">
                        <label for="">Berapa Orang</label>
                        <input type="number" name="person" class="form-control" min="1" placeholder="1">
                    </div>

                    <div class="col-lg-2">
                        <label for="">Dewasa</label>
                        <input type="number" name="adult" class="form-control" min="1" placeholder="1">
                    </div>

                    <div class="col-lg-2">
                        <label for="">Berapa Kamar</label>
                        <input type="number" name="rooms" class="form-control" min="1" placeholder="1">
                    </div>

                    <div class="col-lg-2">
                        <label for="">Anak</label>
                        <input type="number" name="child" class="form-control" placeholder="0">
                    </div>

                    <div class="col-lg-2">
                        <label for="">Umur Anak</label>
                        <input type="number" name="age_child" class="form-control" placeholder="0">
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-lg-6">
                        <label for="">Check in</label>
                        <input type="date" name="date_from" class="form-control">
                    </div>

                    <div class="col-lg-6">
                        <label for="">Checkout</label>
                        <input type="date" name="date_to" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Kelas Kamar</label>
                            <select class="form-control" name="type_rooms" id="exampleFormControlSelect1">
                                <?php foreach ($type_rooms as $row) : ?>
                                    <option value="<?= $row->classId ?>"><?= $row->name ?> / <?= price($row->price) ?> </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Extra Bed</label>
                            <select class="form-control" name="extra" id="exampleFormControlSelect1">
                                <option value="">--pilih--</option>
                                <?php foreach ($extra as $row) : ?>
                                    <option value="<?= $row->id ?>"><?= $row->name ?> / <?= price($row->price) ?> </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>





                </div>
            </div>
            <div class="card-footer">
                <div class="float-right">
                    <button type="submit" class="btn btn-success">Reservasi</button>
                </div>
                </form>
            </div>

        </div>

    </div>


</div>