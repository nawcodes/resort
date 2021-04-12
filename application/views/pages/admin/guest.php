<h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
<?php $this->load->view('layouts/_alert'); ?>

<!-- DataTales Example -->

<div class="card shadow mb-4">
    <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Ruangan</h6>
    </a>
    <div class="collapse show" id="collapseCardExample">
        <div class="card-body">
            <div class="row  d-flex flex-wrap mr-1 ml-2">
                <?php foreach ($content as $row) : ?>
                    <div class="col">
                        <a href="<?= $row->status == 1 ?  base_url('admin/guest/edit/' . $row->id)  : base_url('admin/guest/create/' . $row->id)  ?>" class="room-sec card bg-<?= $row->status == 1 ? 'warning' : 'primary'  ?> text-white text-center p-4 mt-2 ">
                            <blockquote class="blockquote mb-0">
                                <?= $row->number_rooms ?>
                            </blockquote>
                            <span style="position:absolute; right: 0; top:0; margin-top:3px;margin-right:3px;" class="badge badge-light "><?= $row->name ?></span>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="float-left">
            <div class="float-left mr-3">
                <span class="btn btn-sm btn-warning btn-circle"></span>
                Sudah Di Isi
            </div>
            <div class="float-right">
                <span class="btn btn-sm btn-primary btn-circle"></span>
                Tersedia
            </div>
        </div>
    </div>
</div>