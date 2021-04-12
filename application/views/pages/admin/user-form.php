<div class="container">
    <?= validation_errors(); ?>
    <?php $this->load->view('layouts/_alert') ?>
    <div class="col-lg">
        <div class="card">
            <div class="card-header">
                <h2><?= $title ?></h2>
            </div>
            <div class="card-body">
                <?= form_open_multipart($form, ['method' => 'post']) ?>
                <div class="col">
                    <input type="hidden" name="id" value="<?= isset($content->id) ? $content->id : '' ?>">
                    <div class="form-group">
                        <label for="">Nama</label>
                        <input type="text" name="name" class="form-control" value="<?= $input->name ?>">
                        <?= form_error('name', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= $input->email ?>">
                        <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="">Password</label>
                        <small class="bg-light text-info">Password untuk aplikasi ini.</small>
                        <input type="password" name="password" class="form-control">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="">Photo</label>
                        <?= form_upload('image', '', ['class' => 'form-control-file']); ?>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Role</label>
                        <select class="form-control" name="id_role" id="">
                            <?php foreach ($role as $row) : ?>
                                <option value="<?= $row->id ?>" <?= isset($content->id_role) == $row->id ? 'selected' : '' ?>><?= $row->role ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?= form_error('id_role', '<small class="text-danger">', '</small>'); ?>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Apakah Aktif</label>
                        <select class="form-control" name="is_active">
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>
                    <?= form_error('is_active', '<small class="text-danger">', '</small>'); ?>
                </div>
            </div>
            <div class="card-footer">
                <div class="float-left">
                    <a href="<?= base_url('admin/user') ?>" class="btn btn-primary">Kembali</a>
                </div>
                <div class="float-right">
                    <button type="submit" class="btn btn-success">Buat</button>
                </div>
                </form>
            </div>
        </div>

    </div>


</div>