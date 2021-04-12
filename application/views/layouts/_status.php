<?php

if ($status == 'unverified') {
    $badge = 'warning';
    $status = 'Belum di verifikasi';
}

if ($status == 'verified') {
    $badge = 'primary';
    $status = 'Terverifikasi';
}

if ($status == 'failed') {
    $badge = 'danger';
    $status = 'Maaf, Foto Mu Tidak Jelas Silahkan Upload Kembali.';
}


if ($status == 'waiting') {
    $badge = 'warning';
    $status = 'Menunggu Pembayaran';
}

if ($status == 'canceled') {
    $badge = 'danger';
    $status = 'Dibatalkan';
}

if ($status == 'unconfirmed') {
    $badge = 'info';
    $status = 'Belum Di Konfirmasi';
}

if ($status == 'paid') {
    $badge = 'primary';
    $status = 'Dibayar';
}



?>
<?php if ($status) : ?>
    <span class="badge badge-pill badge-<?= $badge ?>"><?= $status ?></span>
<?php endif; ?>