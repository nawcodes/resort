<div class="container">
    <?php $this->load->view('layouts/_alert'); ?>
    <form action="<?= base_url('booking/verification/' . $booking->id) ?>" method="post">
        <div class="row mt-4 justify-content-center">
            <input type="hidden" name="id_costumers" value="<?= $input->id_costumers ?>">
            <div class="col-lg-8">
                <div class="form-group">
                    <label for="">NIK KTP</label>
                    <input type="number" name="account_id" id="" class="form-control" value="<?= $input->account_id == 0 ? '' : '' ?>" placeholder="16 Number">
                    <?= form_error('account_id', '<p class="text-danger">', '</p>'); ?>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </form>

</div>