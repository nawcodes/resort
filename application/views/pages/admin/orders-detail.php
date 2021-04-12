<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Orders <strong class="text-dark">#<?= $bo_orders->invoice ?></strong></h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw "></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Konfirmasi Booking Orders</div>
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <form action="<?= base_url('admin/orders/change_orders') ?>" method="post">
                    <div class="row">
                        <div class="col">
                            <ul style="list-style: none;">
                                <li>Atas Nama : <?= $costumers->name ?></li>
                                <li>No. Ktp : <?= $costumers->account_id ?></li>
                                <li>No. Hp : <?= $costumers->phone ?></li>
                                <li>Email : <?= $costumers->email ?></li>
                            </ul>
                        </div>
                        <div class="col">
                            <ul style="list-style: none;">
                                <li>Tanggal Booking : <?= $bo_orders->dateBooking ?></li>
                                <li>Status : <?php $this->load->view('layouts/_status', ['status' => $bo_orders->status]) ?></li>
                            </ul>
                        </div>
                    </div>
                    <hr>
                    <input type="hidden" name="id_bo_orders" value="<?= $bo_orders->id_booking_orders ?>">
                    <input type="hidden" name="invoice" value="<?= $bo_orders->invoice ?>">
                    <div class="row mb-2">
                        <div class="col">
                            <label for="">Kelas Kamar</label>
                            <?= form_dropdown('id_type_rooms', dropdown('type_rooms', ['id', 'name']), $bo_orders->classId, ['class' => 'form-control']) ?>
                        </div>
                    </div>


                    <div class="row">

                        <div class="col">
                            <div class="form-group">
                                <label for="">Tanggal Datang</label>
                                <input type="date" name="date_from" id="extra" value="<?= $bo_orders->date_from ?>" class="form-control" disabled>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="">Tanggal Selesai </label>
                                <input type="date" name="date_to" id="" value="<?= $bo_orders->date_to ?>" class="form-control" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col">
                            <div class="form-group">

                                <label for="exampleFormControlSelect1">Extra Bed</label>
                                <?= form_dropdown('extra', dropdownCond('extra', ['id', 'name'], 'type =' . '"bed"', 0), $bo_orders->extraId, ['class' => 'form-control',]) ?>
                            </div>
                        </div>

                    </div>

                    <div class="card-footer ">
                        <!-- <small class="text-danger"><span><i>Catatan : Jangan Dirubah Jika Tidak Ada Konfirmasi Di Costumers</i></span></small>
                        <button type="submit" class="btn btn-info btn-icon-split float-right">
                            <span class="icon text-white-50">
                                <i class="fas fa-info-circle text-danger"></i>
                            </span>
                            <span class="text">Ubah</span>
                        </button> -->
                </form>
            </div>

        </div>
    </div>

    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->

        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Konfirmasi Status Orders <strong class="text-dark">#<?= $bo_orders->invoice ?></strong></h6>
        </div>



        <!-- Card Body -->

        <div class="card-body">
            <form action="<?= base_url('admin/orders/confirm') ?>" method="post">
                <input type="hidden" name="id_booking_orders" value="<?= $bo_orders->id_booking_orders ?>">
                <input type="hidden" name="id_costumers" value="<?= $bo_orders->id_costumers ?>">

                <div class="row py-3">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Pilih No Kamar Yang Tersedia : </label>
                            <?= form_dropdown('rooms_number', dropdownCond('rooms', ['id', 'number_rooms'], 'id_type_rooms = ' . '"' . $bo_orders->classId . '"' . 'AND  status =' . '"0"', ''), '', ['class' => 'form-control']) ?>
                        </div>
                    </div>
                    <div class="col">
                        <span>Ruangan yang di pesan dengan tipe yang sama : <?= $bo_orders->rooms ?></span>
                    </div>
                    <div class="col">
                        <span>Note : <i class="text-danger">Sebelum memberikan konfirmasi kamar (telah di bayar), Berikan No Kamar Terlebih Dahulu</i></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="input-group">

                            <select class="custom-select" name="confirm" id="inputGroupSelect04">
                                <option value="waiting" <?= $bo_orders->status == 'waiting' ? 'selected' : ''; ?>>Menunggu Pembayaran</option>
                                <option value="unconfirmed" <?= $bo_orders->status == 'unconfirmed' ? 'selected' : ''; ?>>Menunggu Di Konfirmasi</option>
                                <option value="paid" <?= $bo_orders->status == 'paid' ? 'selected' : ''; ?>>Dibayar</option>
                                <option value="canceled" <?= $bo_orders->status == 'canceled' ? 'selected' : ''; ?>>Dibatalkan</option>
                            </select>

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary" type="button">Konfirmasi</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <?php if ($costumer_key) : ?>
                <?php foreach ($costumer_key as $row) : ?>
                    <form action="<?= base_url('admin/orders/delete/' .  $row->id) ?>" method="post" class="mt-5">
                        <a href="<?= base_url('admin/orders/edit/' . $row->id)  ?>" class="btn btn-sm btn-outline-primary">Edit <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                            </svg>
                        </a>

                        <button type="submit" class="btn btn-sm  btn-outline-danger" onclick="return confirm('Yakin mau di hapus!?')">
                            <input type="hidden" name="id_key" value="<?= $row->id  ?>">
                            Hapus Kunci <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                            </svg>
                        </button>
                    </form>
                    <div class="text-center">
                        <h2>Kunci Kamar</h2>
                        <span>Nomor Ruangan : <?= $row->number_rooms
                                                ?></span>
                        <p><?= indoDate($row->date_from) ?> - <?= indoDate($row->date_to) ?></p>
                        <p> <?php if ($row->is_active == 1) : ?>
                                <span class="badge badge-primary">Aktif</span>
                            <?php else : ?>
                                <span class="badge badge-danger">Tidak Aktif</span>
                            <?php endif; ?>
                        </p>
                    </div>
                    <figure class="text-center mt-2">
                        <img src="<?= base_url('assets/images/qrcodes/' . $row->qrcode_key)
                                    ?>" alt="" class="img-thumbnail">
                    </figure>
                    <div class="text-center">
                        <form action="<?= base_url('admin/orders/send') ?>" method="post">
                            <input type="hidden" name="costId" value="<?= $costumers->id ?>">
                            <input type="hidden" name="id_key" value="<?= $row->id_key ?>">
                            <button type="submit" class="btn btn-primary" onclick="return confirm('Kunci ini akan di kirim ke email costumers bersangkutan')">
                                Kirim Kunci
                            </button>
                        </form>

                    </div>
                <?php endforeach; ?>
            <?php endif;
            ?>
        </div>
    </div>

    <!-- Button trigger modal --

    <!-- Modal -->
    <div class="modal fade" id="costumerSendKeys" tabindex="-1" aria-labelledby="costumerSendKeysLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="costumerSendKeysLabel">Kirim Kunci</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                    </form>

                </div>
            </div>
        </div>
    </div>





</div>
<div class="col-lg-4">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Pembayaran & Nominal</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <h2 class="text-center"> <?= price($bo_orders->subtotal) ?></h2>
        </div>

    </div>
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Bukti Pembayaran</h6>
        </div>
        <!-- Card Body -->
        <?php if ($bo_confirm) :  ?>
            <div class="card-body">

                <ul>
                    <li>Atas Nama : <?= $bo_confirm->account_name ?></li>
                    <li>No Rekening : <?= $bo_confirm->account_number ?></li>
                    <li>Pembayaran Nominal : <?= $bo_confirm->nominal ?></li>
                </ul>
                <div class="text-center">
                    <img src="<?= isset($bo_confirm) ? base_url('assets/images/payment/' . $bo_confirm->image) : '' ?>" class="img-thumbnail" width="500">
                </div>
            </div>
            <div class="card-footer">
                Tanggal pembayaran : <?= isset($bo_confirm->date_created) ?  $bo_confirm->date_created : '' ?>
            </div>
        <?php endif; ?>

    </div>
</div>
</div>