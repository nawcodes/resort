<div class="container">
    <div class="row">
        <div class="offset-lg-3 col-lg-6 offset-md-2 col-md-8 col-sm-12">
            <h4 class="">No Kamar</h4>
            <div class="card mb-2">
                <div class="card-body bg-light text-center">
                    <h4 class=""><?= $rooms->number_rooms ?></h4>
                </div>
            </div>
            <div class="card">
                <div class="card-header bg-primary"></div>
                <div class="card-body text-center bg-light">
                    <img src="<?= base_url('assets/images/qrcodes/' . $key->qrcode_key) ?>" alt="" class="img-fluid" width="350">
                </div>
                <div class="card-footer bg-primary">
                </div>

            </div>
            <div class="float-left mt-2">
                <a href="<?= base_url('mykeys') ?>" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                    </svg> Kembali
                </a>
            </div>
        </div>
    </div>

</div>