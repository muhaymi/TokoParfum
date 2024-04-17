<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<form action="/admin/users/update-password" method="post">
    <input type="hidden" name="user_id" value="<?= $userId ?>">
    <div class="form-group row">
        <div class="col-6">
            <input type="password" name="password" class="form-control form-control-user <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>" autocomplete="off">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-6">
            <input type="password" name="pass_confirm" class="form-control form-control-user <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.repeatPassword') ?>" autocomplete="off">
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>

</form>
<?= $this->endSection(); ?>