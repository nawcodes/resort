<div class="container">
    <a href="<?= base_url('panel') ?>" class="btn btn-primary ml-n2">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
        </svg> Kembali
    </a>

    <div class="row mt-1 d-flex justify-content-evenly">
        <?php foreach ($costumers_key as $row) : ?>
            <div class="col-lg-4 col-md-6 mt-1 ml-n2">
                <div class="card">
                    <div class="card-header bg-primary">
                        <span class="btn btn-outline-light px-5"> <?= ucfirst($row->className) ?> </span>
                    </div>
                    <div class="card-body bg-light">

                        <div class="container-fluid">

                            <div class="card">
                                <div class="card-body text-center text-light bg-primary rounded">
                                    <h3><?= $row->number_rooms ?></h3>
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-upc-scan" viewBox="0 0 16 16">
                                            <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1h-3zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5zM.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5zM3 4.5a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0v-7zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0v-7zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0v-7zm2 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-7zm3 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0v-7z" />
                                        </svg>
                                    </span>
                                    <br>
                                    <a href="<?= base_url('mykeys/detail/' . $row->keyId) ?>" class="text-white">
                                        <cite title="Source Title" class=""><i>lihat kunci</i>
                                        </cite>
                                    </a>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="card-footer">
                        <footer class="blockquote-footer">Key Expired : <cite title="Source Title" class=""> <?= $row->time_expired ?></cite></footer>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>