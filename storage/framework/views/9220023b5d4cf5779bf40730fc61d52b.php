

<div class="sb-brand-area">
    <div class="sb-brand-ic"><i class="fas fa-user-shield"></i></div>
    <div>
        <div class="sb-brand-name">Panel Admin</div>
        <div class="sb-brand-sub">
            <?php echo e(Str::limit(auth()->user()->profile?->full_name ?? auth()->user()->name, 20)); ?>

        </div>
    </div>
</div>


<a class="sb-link <?php echo e(request()->routeIs('admin.dashboard*') ? 'active' : ''); ?>"
   href="<?php echo e(route('admin.dashboard')); ?>">
    <i class="fas fa-tachometer-alt"></i>
    <span>Dashboard</span>
</a>

<div class="sb-divider"></div>
<div class="sb-section">Manajemen Akun</div>

<a class="sb-link <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>"
   href="<?php echo e(route('admin.users.index')); ?>">
    <i class="fas fa-users"></i>
    <span>User Warga</span>
    <span class="sb-badge nik">NIK</span>
</a>

<a class="sb-link <?php echo e(request()->routeIs('admin.kaders.*') ? 'active' : ''); ?>"
   href="<?php echo e(route('admin.kaders.index')); ?>">
    <i class="fas fa-user-nurse"></i>
    <span>Kader</span>
    <span class="sb-badge email">Email</span>
</a>

<a class="sb-link <?php echo e(request()->routeIs('admin.bidans.*') ? 'active' : ''); ?>"
   href="<?php echo e(route('admin.bidans.index')); ?>">
    <i class="fas fa-user-md"></i>
    <span>Bidan</span>
    <span class="sb-badge email">Email</span>
</a>

<div class="sb-divider"></div>
<div class="sb-section">Sistem</div>

<a class="sb-link <?php echo e(request()->routeIs('admin.settings.*') ? 'active' : ''); ?>"
   href="<?php echo e(route('admin.settings.index')); ?>">
    <i class="fas fa-cog"></i>
    <span>Pengaturan</span>
</a>

<div class="sb-divider"></div>

<form action="<?php echo e(route('logout')); ?>" method="POST" style="margin: .1rem .55rem;">
    <?php echo csrf_field(); ?>
    <button type="submit" class="sb-link sb-logout"
        style="width: 100%; background: none; border: none; text-align: left; cursor: pointer; padding: .62rem 1rem;">
        <i class="fas fa-sign-out-alt"></i>
        <span>Keluar</span>
    </button>
</form><?php /**PATH C:\xampp\htdocs\POSYANDU\posyandu-management-system\resources\views/partials/sidebar/admin.blade.php ENDPATH**/ ?>