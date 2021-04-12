<div class="container mt-4">
    <?php $this->load->view('layouts/_alert'); ?>
    <?php if ($bo_orders->status != 'paid' || $bo_orders->status != 'unconfirmed') :  ?>
        <div class="card">
            <div class="card-header">
                <h3>Cara Pembayaran</h3>
            </div>
            <div class="card-body">
                <?php $bank = $this->db->get('bank')->row(); ?>
                <h4>No Pesanan #<?= $bo_orders->invoice ?></h4>
                <h5>Silahkan lakukan pembayaran untuk kami proses selanjutnya.</h5>
                <ol>
                    <li>Lakukan pembayaran pada rekening <strong><?= $bank->bank_name ?> <?= $bank->bank_id ?> A/N <?= $bank->name ?></strong></li>
                    <li>Sertakan dengan nomor invoice <strong>#<?= $bo_orders->invoice ?></strong></li>
                    <li>Total Pembayaran <strong><?= price($bo_orders->amount) ?></strong></li>
                    <li>Konfirmasi Kolom Di bawah Jika sudah Melakukan Pembayaran</li>
                    <li><strong>Wajib!</strong> Kirim bukti pembayaran setelah melakukan pembayaran.</li>
                </ol>
            </div>
        </div>

    <?php endif; ?>

    <?php if ($bo_orders->status == 'waiting') : ?>
        <div class="row mt-3 pb-5">
            <div class="col-lg-7">

                <?= form_open_multipart(base_url('checkout/confirm/' . $bo_orders->id), ['method' => 'post']) ?>

                <div class="card">
                    <div class="card-header bg-info text-white">
                        Konfirmasi pembayaran
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <label for="">Invoice</label>
                            <input type="text" class="form-control" disabled aria-disabled="" value="<?= $bo_orders->invoice ?>" name="invoice">

                        </div>

                        <div class="form-group">
                            <label for="">No Rekening Pengirim</label>
                            <input type="text" class="form-control" name="account_number" value="<?= $input->account_number ?>">
                            <?= form_error('account_number') ?>
                        </div>

                        <div class="form-group">
                            <label for="">Atas Nama</label>
                            <input type="text" class="form-control" name="account_name" placeholder="Samantha Regex" value="<?= $input->account_name ?>">
                            <?= form_error('account_name') ?>
                        </div>


                        <div class="form-group">
                            <label for="">Asal Bank</label>
                            <input type="text" class="form-control" name="from_bank" value="<?= $input->from_bank ?>" placeholder="BCA">
                            <?= form_error('from_bank') ?>
                        </div>


                        <div class="form-group">
                            <label for="">Nominal Pembayaran</label>
                            <input type="text" class="form-control" name="nominal" value="<?= $bo_orders->amount ?>">
                            <?= form_error('nominal') ?>
                        </div>


                        <div class="form-group">
                            <label for="">Bukti Pembayaran</label>
                            <br>
                            <?= form_upload('image') ?>
                        </div>



                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-right btn-block"> Konfirmasi</button>
                    </div>

                </div>

                <?= form_close(); ?>

            </div>

            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Nominal
                    </div>
                    <div class="card-body">
                        <h2 class="text-center"><?= price($bo_orders->amount) ?></h2>
                    </div>
                </div>

            </div>
        </div>
    <?php else : ?>
        <?php if ($bo_confirm) : ?>
            <div class="row mt-3 pb-5">
                <div class="col-lg-8 col-md-8">
                    <div class="card">
                        <div class="card-header">
                            Status : <?php $this->load->view('layouts/_status', ['status' => $bo_orders->status]) ?>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg mt-1">
                                    <ul class="list-group">
                                        <label for="">Atas Nama</label>
                                        <li class="list-group-item mb-1">Pengirim : <?= ucfirst($bo_confirm->account_name) ?></li>
                                        <label for="">Waktu Di Konfirmasi</label>
                                        <li class="list-group-item"><?= $bo_confirm->date_created ?></li>
                                    </ul>
                                </div>
                                <div class="col-lg text-center mt-1">
                                    <img src="<?= base_url('assets/images/payment/' . $bo_confirm->image) ?>" alt="" class="img-thumbnail" width="300">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                        </div>
                    </div>
                </div>
                <?php if ($costumers_key) : ?>
                    <div class="col-lg-4 col-md-4">
                        <div class="card">
                            <div class="card-header bg-primary"></div>
                            <div class="card-body text-center">
                                <p>Yeay!😄, Akses kunci hotel sudah di berikan.</p>
                                <p>Periksa Email mu , Kami kirim kunci melalui E-mail.</span></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>


        <?php endif; ?>
    <?php endif; ?>

</div>