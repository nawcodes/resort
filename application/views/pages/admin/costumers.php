 <!-- Begin Page Content -->


 <!-- Page Heading -->
 <h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
 <p class="mb-4"> <?php $this->load->view('layouts/_alert') ?></p>
 <?= validation_errors(); ?>

 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="card-header py-3">
         <h6 class="m-0 font-weight-bold text-primary"><?= $title ?>
             <button class="btn btn-small btn-primary" data-toggle="modal" data-target="#staticBackdrop">Tambah</button>
         </h6>
     </div>
     <div class="card-body">
         <div class="table-responsive">
             <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                 <thead>
                     <tr>
                         <th>Name</th>
                         <th>Email</th>
                         <th>Phone</th>
                         <th>Address</th>
                         <th>Options</th>
                     </tr>
                 </thead>
                 <tfoot>
                     <tr>
                         <th>Name</th>
                         <th>Email</th>
                         <th>Phone</th>
                         <th>Address</th>
                         <th>Options</th>
                     </tr>
                 </tfoot>
                 <tbody>
                     <?php foreach ($costumers as $row) : ?>
                         <tr>
                             <td>
                                 <?= $row->name ?>
                                 <div class="float-right">
                                     <a href=""><i class="far fa-eye"></i></a>
                                 </div>
                             </td>
                             <td><?= $row->email ?></td>
                             <td><?= $row->phone ?></td>
                             <td><?= substr($row->address, 0, 50)  ?>..</td>
                             <form action="<?= base_url('admin/costumers/delete/' . $row->id) ?>" method="post">
                                 <td class="text-center">
                                     <a class="btn btn-sm btn-primary" href="<?= base_url('admin/costumers/edit/' . $row->id) ?>"><i class="fas fa-edit"></i></a>
                                     <input type="hidden" name="id" value="<?= $row->id ?>">
                                     <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('HATI HATI DALAM PENGHAPUSAN! , TEKAN CANCEL UNTUK KEMBALI!')"><i class="fas fa-trash wtext-danger" onclick="return confirm('Sure Want Delete This Orders?')"></i></button>

                                 </td>
                             </form>
                         </tr>
                     <?php endforeach; ?>
                 </tbody>
             </table>
         </div>
     </div>
 </div>



 <!-- Button trigger modal -->
 <button type="button" class="btn btn-primary">
     Launch static backdrop modal
 </button>

 <!-- Modal -->
 <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="staticBackdropLabel">Tambah Costumers</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <form action="<?= base_url('admin/costumers/create') ?>" method="post">
                     <div class="form-group">
                         <label for="" class="">Nama</label>
                         <input type="text" name="name" class="form-control" value="">
                     </div>
                     <div class="form-group">
                         <label for="" class="">E-mail</label>
                         <input type="text" name="email" class="form-control" value="">
                     </div>
                     <div class="form-group">
                         <label for="" class="">Nomor KTP</label>
                         <input type="numeric" class="form-control" name="account_id" value="">
                     </div>
                     <div class="form-group">
                         <label for="" class="">No Telfon</label>
                         <input type="numeric" class="form-control" name="phone" value="">
                     </div>
                     <div class="form-group">
                         <label for="" class="">Alamat</label>
                         <textarea class="form-control" name="address" rows="3"></textarea>
                     </div>
                     <div class="form-group">
                         <label for="" class="">Apakah Sehat?</label>
                         <select class="form-control" name="is_healthy">
                             <option value="1">Ya</option>
                             <option value="0">Tidak</option>
                         </select>
                     </div>

                     <div class="form-group">
                         <small class="text-danger">Verifikasi akan disi secara default : Belum Memasukan Foto</small>
                     </div>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                 <button type="submit" class="btn btn-primary">Simpan</button>
                 </form>
             </div>
         </div>
     </div>
 </div>


 <!-- /.container-fluid -->