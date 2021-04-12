<div class="container">
    <?php $this->load->view('layouts/_alert'); ?>
    <div class="row">
        <div class="col-lg">
            <div class="card border-dark">
                <div class="card-body">
                    <div class="container">
                        <div class="row  text-center">
                            <div class="offset-lg-1 col-lg-3 bg-light rounded mt-1" style="cursor:pointer">
                                <a href="<?= base_url('mykeys') ?>" style="text-decoration:none;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-key" viewBox="0 0 16 16">
                                        <path d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8zm4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5z" />
                                        <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                    </svg>
                                    <br>
                                    <label for="">Kunci Kamar mu
                                        <span class="badge badge-sm badge-warning">
                                            <?= countCond('costumers_key', ['id_costumers' => $this->session->userdata('id')]) ?></span>
                                    </label>
                                </a>
                            </div>
                            <div class="col-lg-3 bg-light rounded mx-md-1 mt-1" style="cursor:pointer">
                                <a href="<?= base_url('myorders') ?>" style="text-decoration:none;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-card-checklist" viewBox="0 0 16 16">
                                        <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                                        <path d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z" />
                                    </svg>
                                    <br>
                                    <label for="">Booking Ordermu</label>
                                    <span class="badge badge-sm badge-warning">
                                        <?= countCond('booking_orders', ['id_costumers' => $this->session->userdata('id')]) ?></span>
                                </a>
                            </div>
                            <div class="col-lg-3 bg-light rounded mt-1" style="cursor:pointer">
                                <a href="<?= base_url('myreservation') ?>" style="text-decoration:none;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="50" fill="currentColor" class="bi bi-book" viewBox="0 0 16 16">
                                        <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z" />
                                    </svg>
                                    <br>
                                    <label for="">Reservasi</label>
                                    <span class="badge badge-sm badge-warning"><?= countCond('booking', ['id_costumers' => $this->session->userdata('id')]) ?></span>
                                </a>
                            </div>

                        </div>
                        <!-- <div class="row mt-1">
                            <div class="offset-lg-1 col-lg-3 bg-light rounded text-center" style="cursor:pointer">
                                
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>