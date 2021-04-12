<?php 



if($type == 'standart') {
    $btn = 'primary';
}

if($type == 'deluxe') {
    $btn = 'warning';
}

if($type == 'superior') {
    $btn = 'success';
}

if($type == 'family') {
    $btn = 'info';
}

if($type == 'royal') {
    $btn = 'danger';
}

if($type == 'suite') {
    $btn = 'light';
}







?>

<?php if($type) : ?>

    <button class="btn btn-<?= $btn ?>"><?= $data ?></button>



<?php endif; ?>

