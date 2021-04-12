<div class="container">
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>Invoice</h4>
                    <small class="badge badge-warning"><?= $content->invoice ?></small>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-12">
                            <ul>
                                <li>Kelas Kamar : <span class="badge badge-primary"> <?= ucfirst($content->className)  ?> </span></li>
                                <li>Subtotal : <span class="badge badge-primary"> <?= price($content->amount) ?> </span></li>
                                <li>Extra Bed <span class="badge badge-primary"> <?= $content->extraName ?> </span> / <?= price($content->extraPrice) ?></li>
                            </ul>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <ul>
                                <li>Estimasi Hari Menginap : <span class="badge badge-primary"> <?= $content->date_created ?> </span></li>
                                <li>Tanggal Kedatangan : <span class="badge badge-primary"> <?= indoDate($content->date_from) ?> </span></li>
                                <li>Tanggal Selesai : <span class="badge badge-primary"> <?= indoDate($content->date_to) ?> </span></li>
                            </ul>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <ul>
                                <li>Tanggal Pemesanan : <span class="badge badge-primary"> <?= $content->date_created ?> </span></li>
                                <li>Status : <?php $this->load->view('layouts/_status', ['status' => $content->status]); ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="float-left">
                        <a href="<?= base_url('myorders') ?>" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                            </svg> Kembali
                        </a>
                    </div>
                    <div class="float-right">
                        <a href="<?= base_url('checkout/confirm/' . $content->invoice) ?>" class="btn btn-success">
                            Konfirmasi <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-up-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M6.364 13.5a.5.5 0 0 0 .5.5H13.5a1.5 1.5 0 0 0 1.5-1.5v-10A1.5 1.5 0 0 0 13.5 1h-10A1.5 1.5 0 0 0 2 2.5v6.636a.5.5 0 1 0 1 0V2.5a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v10a.5.5 0 0 1-.5.5H6.864a.5.5 0 0 0-.5.5z" />
                                <path fill-rule="evenodd" d="M11 5.5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793l-8.147 8.146a.5.5 0 0 0 .708.708L10 6.707V10.5a.5.5 0 0 0 1 0v-5z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>