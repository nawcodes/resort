<?php


$primary = $this->session->flashdata('primary');
$success = $this->session->flashdata('success');
$error   = $this->session->flashdata('error');
$warning = $this->session->flashdata('warning');



if ($success) {
    // $icon    = '<i class="fa fa-laugh-squint"></i>';
    $type    = 'alert-success';
    $status  = '';
    $message = $success;
}

if ($primary) {
    // $icon    = '<i class="fa fa-laugh-squint"></i>';
    $type    = 'alert-primary';
    $status  = '';
    $message = $success;
}



if ($error) {
    // $icon    = '<i class="fa fa-sad-cry"></i>';
    $status  = 'Opps!';
    $type    = 'alert-danger';
    $message = $error;
}

if ($warning) {
    // $icon    = '<i class="fa fa-sad-tear"></i>';
    $status  = 'Maaf';
    $type    = 'alert-warning';
    $message = $warning;
}



?>

<?php if ($success || $error || $warning) : ?>

    <div class="alert <?= $type ?> alert-dismissible fade show text-center text-md" role="alert">
        <strong><?= $status ?></strong> <?= $message ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

<?php endif; ?>