<div class="container">


    <div class="row">



        <div class="offset-lg-1 col-lg-10">
            <?php $this->load->view('layouts/_alert'); ?>
            <?= validation_errors('<ul class="list-group"><li class="list-group-item list-group-item-action list-group-item-danger mb-1">', '</li>'); ?>
            <a href="<?= base_url('panel') ?>" class="btn btn-primary mb-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                </svg> Kembali
            </a>
            <?php if ($checkCount <= 0) : ?>
                <button type="button" class="btn-info btn mb-1" data-toggle="modal" data-target="#exampleModal">Pesan Kamar
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-book-fill" viewBox="0 0 16 16">
                        <path d="M8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z" />
                    </svg>
                </button>
            <?php endif; ?>



            <div class="card">
                <div class="card-body">
                    <h3>Booking</h3>
                    <hr>
                    <?php $numb = 0;
                    if ($content) :

                    ?>
                        <div class="row mt-1">
                            <div class="col-lg">
                                <div class="list-group">
                                    <a href="#" class="list-group-item list-group-item-action active">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h4> # <?= $numb ?> <span class=""> </span></h4>
                                            <div>
                                                <form action="<?= base_url('myreservation/delete/' . $content->id) ?>" method="post">
                                                    <input type="hidden" name="id_booking" value="<?= $content->id ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin mau di hapus?')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                                        </svg>

                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        <hr style="background-color: white;">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1"><?= ucfirst($content->typeName) ?></h5>
                                            <small> <?= time_Ago(strtotime($content->date_created)) ?> </small>
                                        </div>
                                        <div style="list-style: none;" class="mt-1">
                                            <li>Tanggal Datang : <span class="badge badge-light"><?= indoDate($content->date_from) ?></span> </li>
                                            <li>Tanggal Sampai : <span class="badge badge-light"><?= indoDate($content->date_to) ?></span></li>
                                            <li>Estimasi Menginap :
                                                <span class="badge badge-light"><?= calculateDiffDate($content->date_from, $content->date_to) ?> Hari</span> <span class="badge badge-warning">X</span> <span class="badge badge-light"><?= price($content->price_pernight) ?></span>
                                            <li>Extra Bed :
                                                <?php if ($content->extraName) : ?>
                                                    <span class="badge badge-light">
                                                        <?= $content->extraName ?> / <?= price($content->price) ?>
                                                    </span>
                                                <?php else : ?>
                                                    <span class="badge badge-warning">
                                                        Tidak Memesan
                                                    </span>
                                                <?php endif; ?>
                                            </li>
                                            <hr style="background-color: white;">
                                            <li class="float-right">Subtotal : <?= price($content->subtotal) ?></li>
                                        </div>
                                        <small class="badge badge-warning"></small>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row mt-1">
                            <div class="col">
                                <div class="float-left">
                                    <h4> Total Pembayaran : </h4>
                                </div>
                                <div class="float-right">
                                    <h4> <?= allSubtotal($subtotal, 'subtotal'); ?> </h4>
                                </div>
                            </div>
                        </div>



                </div>
                <div class="card-footer">
                    <form action="<?= base_url('checkout') ?>" method="post">
                        <input type="hidden" name="id_costumers" value="<?= $this->session->userdata('id'); ?>">
                        <button type="submit" class="btn btn-success float-right" onclick="return confirm('Setelah kamu mengklik (OK), kamu akan di bawa ke metode pembayaran ... ')">
                            Pembayaran <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-up-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M6.364 13.5a.5.5 0 0 0 .5.5H13.5a1.5 1.5 0 0 0 1.5-1.5v-10A1.5 1.5 0 0 0 13.5 1h-10A1.5 1.5 0 0 0 2 2.5v6.636a.5.5 0 1 0 1 0V2.5a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v10a.5.5 0 0 1-.5.5H6.864a.5.5 0 0 0-.5.5z" />
                                <path fill-rule="evenodd" d="M11 5.5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793l-8.147 8.146a.5.5 0 0 0 .708.708L10 6.707V10.5a.5.5 0 0 0 1 0v-5z" />
                            </svg>
                        </button>
                    </form>
                </div>
            <?php else : ?>

                <div class="container">
                    <div class="row">
                        <div class="offset-lg-3 col-lg-6 text-center">
                            <h4>Belum melakukan pesanan kamar. Yuk Pesan 😉</h4>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('myreservation/create') ?>" method="post">
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Kelas Kamar</label>
                        <?=
                        form_dropdown('type_rooms', dropdown('type_rooms', ['id', 'name']), '', ['class' => 'form-control']);
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="">Tanggal Kedatangan:</label>
                        <input type="date" class="form-control" name="date_from" id="" value="">
                    </div>

                    <div class="form-group">
                        <label for="">Tanggal Selesai:</label>
                        <input type="date" class="form-control" name="date_to" id="" value="">
                    </div>


                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Extra Bed <small>(optional)</small></label> <?= form_dropdown('extra', dropdownCond('extra', ['id', 'name'], 'type =' . '"bed"', 0), '', ['class' => 'form-control']) ?>
                    </div>


                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th>Kelas</th>
                                <th>Harga</th>
                                <th>Fasilitas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($type_rooms as $row) : ?>
                                <tr>
                                    <td> <?= $row->name  ?></td>
                                    <td> <?= price($row->price_pernight) ?> </td>
                                    <td>
                                        <ul class="list-group">
                                            <li class="list-group-item"><?= $row->facilities ? $row->facilities : '-' ?></li>
                                            <li class="list-group-item">Twin Bed
                                                <?php if ($row->twin_bed == 1) : ?>
                                                    <span class="badge badge-primary">Termasuk</span>
                                                <?php else : ?>
                                                    <span class="badge badge-warning">Tidak Termasuk</span>
                                                <?php endif; ?>
                                            </li>
                                            <li class="list-group-item">Ketersediaan:

                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>

                <?php if ($checkCount <= 0) : ?>
                    <button type="submit" class="btn btn-primary">Pesan Kamar</button>
                <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>