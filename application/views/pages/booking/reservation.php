<div class="container-fluid">
    <?php $this->load->view('layouts/_alert'); ?>
    <div class="row">
        <div class="offset-lg-3 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form action="<?= base_url('booking/create/' . $this->session->userdata('id_type_rooms')) ?>">
                        <div class="form-group">
                            <label for="">Check In</label>
                            <input type="date" class="form-control" name="date_from" id="" value="<?= $this->session->userdata('date_from') ? $this->session->userdata('date_from') : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="">Check Out</label>
                            <input type="date" class="form-control" name="date_to" id="" value="<?= $this->session->userdata('date_from') ? $this->session->userdata('date_to') : '' ?>">
                        </div>
                </div>

                <button type="submit" class="btn btn-primary" name="btn-reservation">Selanjutnya</button>
                </form>
            </div>
        </div>
    </div>

</div>