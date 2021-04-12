<div class="container">

    <?php $this->load->view('layouts/_alert'); ?>

    <div class="row">
     <div class="col-md-6 offset-md-3">
        <div class="card">
            <form action="<?= base_url('auth')?>" method="post">
            <div class="card-body">
                <div class="form-group">
                    
                    <label for="">Masukan No Ktp</label>
                    <input type="" class="form-control" name="account_id" value="<?= $input->account_id ?>">
                    <?= form_error('account_id', '<p class="text-danger">' , '</p>') ?>
                </div>

                <div class="form-group">
                    
                    <label for="">Masukan No Hp</label>
                    <input type="" class="form-control" name="phone" value="<?= $input->account_id ?>">

                    <?= form_error('phone', '<p class="text-danger">' , '</p>') ?>
                
                </div>

                <button type="submit" class="btn btn-primary btn-block">Check
                </button>
            </div>
            </form>
        </div>

     </div>
    </div>


</div>