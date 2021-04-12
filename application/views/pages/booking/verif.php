<div class="container pb-5">
    <?php $this->load->view('layouts/_alert') ?>

    <?php if ($costumers->is_approved !== 'verified') : ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Akun kamu belum terverifikasi.</strong> .
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>


    <?= form_open_multipart(base_url('booking/verification'), ['method' => 'post']) ?>
    <div class="row">
        <div class="col-lg-6 mt-2">
            <div class="card">
                <img class="card-img-top" src="<?= isset($costumers->account_image) ? base_url('assets/images/account/' .  $costumers->account_image) : base_url('assets/images/account/default/default.png'); ?>" alt="Foto Ktp" width="200">
                <div class="card-body">
                    <h5 class="card-title">Foto KTP</h5>


                    <input type="hidden" name="account_id" value="<?= $costumers->account_id ?>">


                    <div class="form-group">
                        <?= form_error('account_image', '<label for="error" class="text-danger">', '</label>') ?>
                        <?= form_upload('account_image', $input->account_image, ['class' => 'form-control-file']) ?>

                    </div>
                    <!-- <?php if ($costumers->is_approved) : ?> -->
                    <?php $this->load->view('layouts/_status', ['status' => $costumers->is_approved]) ?>
                    <!-- <?php endif; ?> -->

                </div>

            </div>
        </div>
        <div class="col-lg-6 mt-2">
            <div class="card">
                <img class="card-img-top" src="<?= isset($costumers->account_image_user) ? base_url('assets/images/account/' .  $costumers->account_image_user) : base_url('assets/images/complete/default/default.jpg'); ?>" alt="Foto Ktp">
                <div class="card-body">
                    <h5 class="card-title">Foto Diri Dengan KTP</h5>
                    <div class="form-group">
                        <?= form_error('account_image_user', '<label for="error" class="text-danger">', '</label>') ?>
                        <?= form_upload('account_image_user', $input->account_image_user, ['class' => 'form-control-file']) ?>
                    </div>

                    <?php if (isset($costumers->is_approved)) : ?>
                        <?php $this->load->view('layouts/_status', ['status' => $costumers->is_approved]) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php if ($costumers->is_approved !== 'verified') :  ?>
        <div class="row mt-3">
            <div class="col">
                <button type="submit" class="btn btn-primary btn-lg btn-block"> Konfirmasi</button>
            </div>
        </div>
    <?php endif; ?>
    </form>
    <!-- <?php//php if($orders) : ?>
    <?php //$this->load->view('pages/my-bokorder/index'); 
    ?>
    <?php //endif; 
    ?>

    <?php //if($costumers->is_approved === 'verified') : 
    ?>
        
        <?php //$this->load->view('pages/booking/verified-section'); 
        ?>

    <?php //endif; 
    ?> -->


</div>