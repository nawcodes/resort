<div class="row mt-4">
     <div class="col-lg-7">
        <div class="card">
            <div class="card-body">
                <div>
                    <h5 class="float-left">
                        Mau tambah tipe kamar?
                    </h5>
                                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary btn-small float-right" data-toggle="modal" data-target="#exampleModal">
                    Tambah
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                            
                            <form action="<?= base_url('booking/addMoreBooking') ?>" method="post">
                                <input type="hidden" name="id_costumers" value="<?= $costumers->id ?>">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Example select</label>
                                            <?= form_dropdown('id_rooms', dropdownCond('type_rooms', ['id' , 'name'], 'total_rooms > 0', ''  ), '' , ['class' => 'form-control']) ?>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="">Dari Kapan ?</label>
                                                    <input type="date" class="form-control" name="date_from" id="" value="">
                                                </div>
                                            </div>

                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="">Sampai Kapan ?</label>
                                                    <input type="date" class="form-control" name="date_to" id="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1"></label>
                                                    <?= form_dropdown('extra', dropdownCond('extra', ['id' , 'name'], 'type =' . '"bed"' , 0  ), '' , ['class' => 'form-control']) ?>
                                                </div>
                                            </div>
                                        </div>

                                        
                                    

                                        
                                        <table class="table mt-5">
                                                <thead>
                                                    <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Tipe</th>
                                                    <th scope="col">Harga / Permalam</th>
                                                    <th scope="col">Maksimal</th>
                                                    <th scope="col">Ex_bed</th>
                                                    <th scope="col">Twin_bed</th>
                                                    <th scope="col">Ketersediaan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php $rooms = $this->db->get('type_rooms')->result();
                                                    $numb = 0;
                                                    foreach($rooms as $row) :
                                                    $numb++
                                                ?>

                                                    
                                                    <tr>
                                                    <th scope="row"><?= $numb ?></th>
                                                    <td><?= $row->name ?></td>
                                                    <td><?= price($row->price_pernight) ?></td>
                                                    <td><?= $row->max_person ?></td>
                                                    <td>Optional / Rp.180.000,-</td>
                                                    <td><?= $row->twin_bed == 1 ? 'include' : 'no'; ?></ td>
                                                    <td><?= $row->total_rooms > 0 ? 'Tersedia' : 'Penuh' ?></td>
                                                    </tr>

                                                    <?php endforeach; ?>
                                                </tbody>
                                                </table>
                                    </div>
                                </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                            </form>
                            </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
     </div>
    </div>
    <?php if($booking) : ?>
    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-success text-white text-center">
                    <h4>Konfirmasi Kembali Pemesanan Kamar </h4>
                    
                </div>

                

                <div class="card-body">
                    <?php $numb=0; foreach($booking as $id => $row )  : $numb++   ?>
                    <form action="<?= base_url('booking/confirmBooking')?>" method="post">
                    
                    <input type="hidden" name="id_booking" value="<?= $row->bookId ?>">
                    <h4># <?= $numb ?> </h4>
                    <div class="row mt-2">
                        <div class="col">
                            Class Rooms 
                        </div>
                        
                        <div class="col">
                            : <?= $row->nameType ?>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col">
                            Harga / Malam : 
                        </div>
                        <div class="col">
                        <?= price($row->price_pernight); ?>                 
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col">
                            Maksimal Orang: 
                        </div>
                        <div class="col">
                        <?= $row->max_person . ' Orang' ?>                 
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col">
                            Tanggal Kedatangan  
                        </div>
                        
                        <div class="col">
                            <div class="form-group">                   
                             <input type="date" class="form-control" name="date_from" id="" value="<?= $row->date_from ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col">
                            Sampai Tanggal : 
                        </div>
                        
                        <div class="col">
                            <div class="form-group">                   
                             <input type="date" class="form-control" name="date_to" id="" value="<?= $row->date_to ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col">
                            Jumlah Malam  
                        </div>
                        
                        <div class="col">
                            : <?= calculateDiffDate($row->date_from, $row->date_to)  ?> Malam 
                        </div>
                    </div>

                    <hr>
                    <div class="row mt-2">
                        <div class="col">
                            Mau Tambah Kasur ? / Extra Bed
                            <small> <i>Di Wajibkan Menambah Extra bed jika Melebihi Kapasitas Orang</i> </small>  
                        </div>
                        
                        <div class="col">
                        <div class="form-group">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Ukuran</label>
                                        <?= form_dropdown('extra', dropdownCond('extra', ['id' , 'name'], 'type =' . '"bed"' , 0  ), $row->extraId , ['class' => 'form-control']) ?>
                                    </div>
                        </div>
                    </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col">
                            <small> <i>Note : Abaikan jika tidak di rubah</i>   </small>
                            <div>
                            
                            <button type="submit" class="btn btn-primary float-right ml-3" name="add-more">Konfirmasi kembali</button>
                        
                            <?php  if(count($booking) > 1) : ?>
                            <a href="<?= base_url('booking/delete/' . $row->bookId) ?>" name="btn-delete" class="btn btn-danger float-right" onclick="return confirm('Yakin mau dihapus?')" >Hapus</a>
                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    </form>
                    <?php endforeach; ?>
                    
                    

                </div>

                
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4>Checkout</h4>
                </div>

                <div class="card-body">

                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#id</th>
                        <th scope="col">Tipe</th>
                        <th scope ="col">Jumlah Malam</th>
                        <th scope ="col">Ex Bed </th>
                        <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($booking as $row) : ?>
                        <tr>
                        <th scope="row">1</th>
                        <td><?= $row->nameType ?></td>
                        <td><?= calculateDiffDate($row->date_from , $row->date_to) ?> x <?= price($row->price_pernight) ?></td>
                        <td><?= $row->extraName ?  $row->extraName : 'X' ?> / <?= $row->extraPrice ? price($row->extraPrice)  : price(0) ?></td>
                        <td><?= price($row->subtotal)?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <hr>
                <h5>Subtotal : <?= allSubtotaL($booking, 'subtotal'); ?></h5>
                <hr>
                </div>
                <div class="card-footer">
                <form action="<?= base_url('checkout/create') ?>" method="post">
                    <input type="hidden" name="id_costumers" value="<?= $costumers->id ?>">
                    <button type="submit" class="btn btn-success float-right" onclick="return confirm('Setelah kamu mengklik (OK), kamu akan di bawa ke metode pembayaran . . . ')">
                        Pembayaran 
                    </button>
                </form>
            </div>
            </div>
            
        </div>
    
    </div>
    <?php endif; ?>