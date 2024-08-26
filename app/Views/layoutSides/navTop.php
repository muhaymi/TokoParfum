<div class="user-panel  pb-3 mb-3 d-flex">
    <div class="image">
        <img src="<?= base_url('/pengguna/' . user()->foto_profile) ?>" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;" alt="User Image">
    </div>
    <div class="d-flex ">
        <div class="info mr-1">
            <a href="<?= base_url('penggunaa') ?>" class="d-block"><i class="ct"><?= user()->username ?></i></a>

        </div>

        <a href="<?= base_url('absen') ?>" class="badge badge-warning navbar-badge bt">
            <i class="fas fa-fingerprint ct"></i>
            <sup class="ct"><?= user()->presensi ?></sup>
        </a>
    </div>
</div>

<div class="form-inline">
    <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
            <button class="btn btn-warning bt">
                <i class="fas fa-search fa-fw ct"></i>
            </button>
        </div>
    </div>
</div>