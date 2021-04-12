 <!-- Begin Page Content -->


 <!-- Page Heading -->
 <h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
 <?php $this->load->view('layouts/_alert') ?>


 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="card-header py-3">
         <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
     </div>
     <div class="card-body">
         <div class="table-responsive">
             <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                 <thead>
                     <tr>
                         <th>Name</th>
                         <th>Invoice</th>
                         <th>Total</th>
                         <th>Status</th>
                         <th>Options</th>
                     </tr>
                 </thead>
                 <tfoot>
                     <tr>
                         <th>Name</th>
                         <th>Invoice</th>
                         <th>Total</th>
                         <th>Status</th>
                         <th>Options</th>
                     </tr>
                 </tfoot>
                 <tbody>
                     <?php foreach ($bo_orders as $row) :   ?>
                         <tr>
                             <td>
                                 <?= $row->name ?>
                                 <div class="float-right">
                                     <a href=""><i class="far fa-eye"></i></a>
                                 </div>
                             </td>
                             <td><?= $row->invoice ?></td>
                             <td><?= price($row->amount) ?></td>
                             <td><?php $this->load->view('layouts/_status', ['status' => $row->status]); ?></td>
                             <td class="text-center">
                                 <a href="<?= base_url('admin/orders/orders_detail/' . $row->invoice) ?>"><i class="fas fa-edit px-3"></i></a>

                                 <a href="#"><i class="fas fa-trash text-danger" onclick="return confirm('Suru Want Delete This Orders?')"></i></a>
                             </td>
                         </tr>
                     <?php endforeach; ?>
                 </tbody>
             </table>
         </div>
     </div>
 </div>


 <!-- /.container-fluid -->