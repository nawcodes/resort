<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('vendors/bootstrap4/dist/css/bootstrap.min.css') ?>">
    <title><?= $title ? $title : '' ?> - Indonesian SEZ's Hotel</title>
</head>

<body>

    <!-- navbar -->
    <?php $this->load->view('layouts/navbar'); ?>
    <!-- end navbar -->



    <!-- main -->
    <div class="main mt-4">
        <?php $this->load->view($page); ?>
    </div>
    <!-- end main -->


    <!-- jquery  bootstrap -->

    <!-- <script src="<?= base_url('vendors/bootstrap4/dist/jquery/jquery-3.5.1.slim.min.js') ?>"></script>
    <script src="<?= base_url('vendors/bootstrap4/dist/jquery/bootstrap.bundle.min.js') ?>"></script> -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>


    <!-- end jquery  bootstrap -->


</body>

</html>