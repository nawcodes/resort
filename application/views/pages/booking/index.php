<div class="container">
    <?php $this->load->view('layouts/_alert'); ?>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <form action="">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Kamar</label>
                                    <input type="number" name="rooms" class="form-control" min="1" value="<?= $this->session->userdata('rooms') ? $this->session->userdata('rooms') : '1'  ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Dewasa</label>
                                    <input type="number" name="adult" id="" min="1" class="form-control" value="<?= $this->session->userdata('adult') ? $this->session->userdata('adult') : '1'  ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Anak</label>
                                    <input type="number" name="child" id="" min="0" class="form-control" value="<?= $this->session->userdata('child') ? $this->session->userdata('child') : '0'  ?>">
                                </div>
                            </div>
                            <div class=" col-md-3">
                                <div class="form-group">
                                    <label for="">Umur Anak</label>
                                    <input type="number" name="age" id="" min="0" class="form-control" value="<?= $this->session->userdata('age') ? $this->session->userdata('age') : '0'  ?>">
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="card-footer">
                <div class="float-right">
                    <button type="submit" name="search" class="btn btn-primary">Cari</button>
                </div>
            </div>
            </form>
        </div>
    </div>
    <?php if (isset($class)) : ?>

        <div class="row my-5 justify-content-center">
            <?php foreach ($class as $row) : ?>
                <div class="col-md-6">
                    <div class="card mb-3" style="max-width: 540px;">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <img src="<?= $row->image != '' ? base_url('assets/images/classrooms/' . $row->image) : 'https://source.unsplash.com/random/160x160'  ?>" class="img-fluid" width="200">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <h4><?= ucfirst($row->name) ?></h4>
                                    </h5>
                                    <p class="card-text"><?= $row->facilities ?></p>
                                    <p class="card-text"><small class="text-muted">Maksimal : <?= $row->max_person ?> Dewasa</small></p>
                                    <p class="card-text"><small class="text-muted">Harga : <?= price($row->price_pernight) ?> / Malam</small></p>
                                    <p>
                                        <?php $count = $this->db->select('*')->from('rooms')->where(['id_type_rooms' => $row->id])->where(['status' => 0])->count_all_results();

                                        ?>
                                        Teredia : <?= $count ?> Kamar
                                    </p>
                                </div>
                                <div class="card-footer">
                                    <div class="float-left">

                                    </div>
                                    <div class="float-right">
                                        <a href="<?= base_url('booking/reservation/' . $row->id) ?>" class="btn btn-primary ">Reservasi</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>