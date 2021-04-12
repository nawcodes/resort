<div class="container">

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    Terimakasih sudah memesan.
                    <br>
                    Invoice : #"'$boor->invoice'"
                </div>
                <div class="card-body">
                    <li>BCA 1313123141b A.N RIFAL</li>
                    <li>total yang harus di bayarkan: </li>
                    <li>link status orders : <a href="<?= base_url('myorders/detail/' . $boor->invoice)  ?>'">disini</a></li>
                    <li>link konfirmasi orders : <a href="<?= base_url('checkout/confirm/' . $boor->invoice) ?> ">disini</a></li>
                    <li>Catatan : Kunci akan kamar akan dikirim melalui E-mail setelah melakukan pembayaran dan dinyatakan di bayar</li>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Pemesanan</h4>
                </div>
                <div class="card-body">
                    <p>Kelas</p>
                    <p>Estimasi Menginap</p>
                    <p>Tanggal Checkin</p>
                    <p>Tanggal Checkout</p>
                    <p>Tambahan Kasur:</p>
                </div>
            </div>
        </div>
    </div>

</div>


<div class="col">
    <h1>Invoice Reservation : #<?= $boor->invoice ?></h1>
    <h4>Terimakasih sudah memesan ' <?= $boor->name ?> ' , silahkan melakukan pembayaran ke:</h4>
    <ul>
        <li>BCA 1313123141b A.N RIFAL</li>
        <li>link status orders : <a href="<?= base_url('myorders/detail/' . $boor->invoice)  ?>'">disini</a></li>
        <li>link konfirmasi orders : <a href="<?= base_url('checkout/confirm/' . $boor->invoice) ?> ">disini</a></li>
        <li>Catatan : Kunci akan kamar akan dikirim melalui E-mail setelah melakukan pembayaran dan dinyatakan di bayar</li>
    </ul>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>


</body>

</html>