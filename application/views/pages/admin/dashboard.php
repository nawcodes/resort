<div class="container-fluid">
    <?php $this->load->view('layouts/_alert'); ?>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>


    <form action="<?= base_url('admin/dashboard/report') ?>">
        <div class="card mb-5">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="">Dari Tanggal</label>
                            <input type="date" name="date" id="" class="form-control">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Status</label>
                            <select class="form-control" name="status" id="exampleFormControlSelect1">
                                <option value="">-select-</option>
                                <option value="paid">Di Bayar</option>
                                <option value="waiting">Menunggu Pembayaran</option>
                                <option value="canceled">Di Batalkan</option>
                                <option value="unconfirmed">Belum Di Konfirmasi</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-sm btn-primary shadow-sm "><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</button>
            </div>
        </div>
    </form>

    <!-- Content Row -->
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <a href="<?= base_url('admin/orders/') ?>" class="text-xs font-weight-bold  text-warning text-uppercase mb-1">
                                Booking Unpaid</a>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $bo_unp ?></div>
                            <a href="<?= base_url('admin/orders/') ?>" class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Booking Paid</a>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $bo_unc ?></div>
                            <a href="<?= base_url('admin/orders/') ?>" class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Booking Confirmed</a>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $bo_paid ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <a href="<?= base_url('admin/verify') ?>" class="text-xs font-weight-bold  text-warning text-uppercase mb-1">
                                Costumers Unverified</a>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $cost_unv ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <a href="<?= base_url('admin/verify') ?>" class="text-xs font-weight-bold  text-primary text-uppercase mb-1">
                                Company Bank</a>
                            <div class="h4 mb-0 font-weight-bold text-gray-800"><?= $bank->bank_name ?></div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800"><?= $bank->name ?></div>
                            <div class="h5 mt-1 font-weight-bold text-gray-800"><?= $bank->bank_id ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bank fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="float-right">
                        <a href="<?= base_url('admin/dashboard/edit_bank/' . $bank->id) ?>" class="badge badge-primary badge-sm">edit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
</div>