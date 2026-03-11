

<?php $__env->startSection('title', 'Dashboard Admin'); ?>

<?php $__env->startPush('styles'); ?>
<style>
/* ── Dashboard Admin ─────────────────────────── */
.pg-hero {
    background: linear-gradient(135deg, #0f172a 0%, #0d9488 60%, #0ea5e9 100%);
    border-radius: 18px; padding: 2rem 2rem 1.75rem;
    position: relative; overflow: hidden; margin-bottom: 1.75rem;
    color: #fff;
}
.pg-hero::before {
    content: ''; position: absolute; top: -60px; right: -60px;
    width: 220px; height: 220px; border-radius: 50%;
    background: rgba(255,255,255,.05);
}
.pg-hero::after {
    content: ''; position: absolute; bottom: -80px; right: 60px;
    width: 160px; height: 160px; border-radius: 50%;
    background: rgba(255,255,255,.04);
}
.hero-date {
    font-size: .72rem; font-weight: 700; letter-spacing: .06em;
    text-transform: uppercase; background: rgba(255,255,255,.15);
    padding: .28rem .75rem; border-radius: 20px; display: inline-block;
    margin-bottom: .75rem;
}
.hero-title { font-size: 1.55rem; font-weight: 800; margin-bottom: .3rem; line-height: 1.2; }
.hero-sub { font-size: .87rem; opacity: .75; }

/* Stat cards */
.stat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.5rem; }
.stat-card {
    background: #fff; border: 1px solid #e2e8f0;
    border-radius: 14px; padding: 1.1rem 1.15rem;
    box-shadow: 0 1px 4px rgba(0,0,0,.05);
    display: flex; align-items: flex-start; gap: .85rem;
    transition: transform .15s, box-shadow .15s;
}
.stat-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,.08); }
.stat-ic {
    width: 42px; height: 42px; border-radius: 12px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.05rem; color: #fff;
}
.stat-val { font-size: 1.55rem; font-weight: 800; line-height: 1; color: #0f172a; }
.stat-lbl { font-size: .72rem; font-weight: 600; color: #64748b; margin-top: .15rem; }
.stat-sub { font-size: .68rem; color: #94a3b8; margin-top: .2rem; }

/* Chart & jadwal panel */
.panel {
    background: #fff; border: 1px solid #e2e8f0;
    border-radius: 14px; overflow: hidden;
    box-shadow: 0 1px 4px rgba(0,0,0,.05); margin-bottom: 1.25rem;
}
.panel-head {
    padding: .9rem 1.15rem .65rem;
    border-bottom: 1px solid #f1f5f9;
    display: flex; align-items: center; justify-content: space-between;
    gap: .5rem;
}
.panel-title { font-size: .88rem; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: .45rem; }
.panel-title i { color: #0d9488; }
.panel-body { padding: 1rem 1.15rem; }

/* Login activity */
.act-row {
    display: flex; align-items: center; gap: .75rem;
    padding: .6rem .5rem; border-radius: 10px;
    transition: background .1s;
}
.act-row:hover { background: #f8fafc; }
.act-av {
    width: 34px; height: 34px; border-radius: 50%; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: .75rem; font-weight: 800; color: #fff;
}
.act-name { font-size: .82rem; font-weight: 600; color: #0f172a; }
.act-meta { font-size: .7rem; color: #94a3b8; }
.act-badge {
    font-size: .6rem; font-weight: 800; padding: .1rem .45rem;
    border-radius: 20px; text-transform: uppercase; letter-spacing: .04em;
}
.act-ok  { background: #dcfce7; color: #166534; }
.act-fail{ background: #fee2e2; color: #991b1b; }

/* Jadwal item */
.jdwl-row {
    display: flex; align-items: center; gap: .75rem;
    padding: .6rem .5rem; border-radius: 10px; transition: background .1s;
}
.jdwl-row:hover { background: #f8fafc; }
.jdwl-date {
    width: 38px; height: 38px; border-radius: 10px; flex-shrink: 0;
    background: linear-gradient(135deg, #0d9488, #0ea5e9);
    display: flex; flex-direction: column; align-items: center;
    justify-content: center; color: #fff; line-height: 1;
}
.jdwl-date .dd { font-size: .95rem; font-weight: 800; }
.jdwl-date .mm { font-size: .55rem; font-weight: 700; text-transform: uppercase; }
.jdwl-name { font-size: .82rem; font-weight: 600; color: #0f172a; }
.jdwl-meta { font-size: .7rem; color: #94a3b8; }
.jdwl-chip {
    margin-left: auto; font-size: .6rem; font-weight: 800;
    padding: .1rem .45rem; border-radius: 20px;
    text-transform: capitalize; flex-shrink: 0;
}
.chip-balita  { background: #cffafe; color: #0e7490; }
.chip-remaja  { background: #ede9fe; color: #5b21b6; }
.chip-lansia  { background: #fef9c3; color: #92400e; }
.chip-semua   { background: #dcfce7; color: #166534; }

/* Role colors */
.role-admin  { background: linear-gradient(135deg,#0d9488,#0ea5e9); }
.role-bidan  { background: linear-gradient(135deg,#10b981,#34d399); }
.role-kader  { background: linear-gradient(135deg,#d97706,#f59e0b); }
.role-user   { background: linear-gradient(135deg,#7c3aed,#a78bfa); }

/* Quick action */
.qa-btn {
    display: flex; align-items: center; gap: .6rem;
    padding: .75rem .9rem; border-radius: 12px;
    text-decoration: none; font-size: .82rem; font-weight: 600;
    margin-bottom: .5rem; transition: all .15s;
}
.qa-btn:hover { transform: translateX(3px); }
.qa-ic {
    width: 34px; height: 34px; border-radius: 9px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center; color: #fff; font-size: .85rem;
}

/* Responsive */
@media (max-width: 1200px) { .stat-grid { grid-template-columns: repeat(4, 1fr); } }
@media (max-width: 900px)  { .stat-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 576px)  {
    .stat-grid { grid-template-columns: 1fr 1fr; gap: .65rem; }
    .stat-val { font-size: 1.25rem; }
    .pg-hero { padding: 1.25rem; }
    .hero-title { font-size: 1.2rem; }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>


<div class="pg-hero">
    <div class="hero-date"><i class="fas fa-calendar me-1"></i><?php echo e(now()->translatedFormat('l, d F Y')); ?></div>
    <div class="hero-title">Selamat Datang, <?php echo e(auth()->user()->name); ?> 👋</div>
    <div class="hero-sub">Panel Administrasi SIPOSYANDU — ringkasan sistem hari ini</div>
</div>


<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-ic role-user"><i class="fas fa-users"></i></div>
        <div>
            <div class="stat-val"><?php echo e($stats['total_user']); ?></div>
            <div class="stat-lbl">Total Warga</div>
            <div class="stat-sub"><?php echo e($stats['user_aktif']); ?> aktif · <?php echo e($stats['user_nonaktif']); ?> nonaktif</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-ic role-kader"><i class="fas fa-user-nurse"></i></div>
        <div>
            <div class="stat-val"><?php echo e($stats['total_kader']); ?></div>
            <div class="stat-lbl">Total Kader</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-ic role-bidan"><i class="fas fa-user-md"></i></div>
        <div>
            <div class="stat-val"><?php echo e($stats['total_bidan']); ?></div>
            <div class="stat-lbl">Total Bidan</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-ic" style="background:linear-gradient(135deg,#be185d,#ec4899)">
            <i class="fas fa-baby"></i>
        </div>
        <div>
            <div class="stat-val"><?php echo e($stats['total_balita']); ?></div>
            <div class="stat-lbl">Data Balita</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-ic" style="background:linear-gradient(135deg,#7c3aed,#a78bfa)">
            <i class="fas fa-user-graduate"></i>
        </div>
        <div>
            <div class="stat-val"><?php echo e($stats['total_remaja']); ?></div>
            <div class="stat-lbl">Data Remaja</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-ic" style="background:linear-gradient(135deg,#b45309,#f59e0b)">
            <i class="fas fa-user-clock"></i>
        </div>
        <div>
            <div class="stat-val"><?php echo e($stats['total_lansia']); ?></div>
            <div class="stat-lbl">Data Lansia</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-ic" style="background:linear-gradient(135deg,#0d9488,#0ea5e9)">
            <i class="fas fa-user-plus"></i>
        </div>
        <div>
            <div class="stat-val"><?php echo e($userBaruBulanIni); ?></div>
            <div class="stat-lbl">Warga Baru</div>
            <div class="stat-sub">Bulan <?php echo e(now()->translatedFormat('F Y')); ?></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-ic" style="background:linear-gradient(135deg,#0284c7,#38bdf8)">
            <i class="fas fa-calendar-check"></i>
        </div>
        <div>
            <div class="stat-val"><?php echo e($jadwalHariIni->count()); ?></div>
            <div class="stat-lbl">Jadwal Hari Ini</div>
        </div>
    </div>
</div>


<div class="row g-3 mb-3">
    
    <div class="col-lg-7">
        <div class="panel">
            <div class="panel-head">
                <div class="panel-title"><i class="fas fa-chart-line"></i> Registrasi Warga 7 Bulan</div>
            </div>
            <div class="panel-body">
                <canvas id="regChart" height="80"></canvas>
            </div>
        </div>
    </div>

    
    <div class="col-lg-5">
        <div class="panel h-100">
            <div class="panel-head">
                <div class="panel-title"><i class="fas fa-calendar-alt"></i> Jadwal Mendatang</div>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-muted" style="font-size:.75rem">Semua</a>
            </div>
            <div class="panel-body">
                <?php $__empty_1 = true; $__currentLoopData = $jadwalMendatang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="jdwl-row">
                    <div class="jdwl-date">
                        <div class="dd"><?php echo e(\Carbon\Carbon::parse($j->tanggal)->format('d')); ?></div>
                        <div class="mm"><?php echo e(\Carbon\Carbon::parse($j->tanggal)->translatedFormat('M')); ?></div>
                    </div>
                    <div>
                        <div class="jdwl-name"><?php echo e($j->nama_kegiatan ?? $j->judul ?? 'Posyandu'); ?></div>
                        <div class="jdwl-meta"><?php echo e($j->lokasi ?? '-'); ?></div>
                    </div>
                    <span class="jdwl-chip chip-<?php echo e($j->target_peserta ?? 'semua'); ?>">
                        <?php echo e($j->target_peserta ?? 'Semua'); ?>

                    </span>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center py-4" style="color:#94a3b8;font-size:.82rem">
                    <i class="fas fa-calendar-times mb-2 d-block" style="font-size:1.5rem"></i>
                    Tidak ada jadwal mendatang
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<div class="row g-3">
    
    <div class="col-lg-8">
        <div class="panel">
            <div class="panel-head">
                <div class="panel-title"><i class="fas fa-shield-alt"></i> Aktivitas Login Terbaru</div>
            </div>
            <div class="panel-body p-0">
                <?php $__empty_1 = true; $__currentLoopData = $loginTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="act-row mx-2 mb-1">
                    <div class="act-av role-<?php echo e($l->role ?? 'user'); ?>">
                        <?php echo e(strtoupper(substr($l->display_name ?? 'U', 0, 1))); ?>

                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="act-name text-truncate"><?php echo e($l->display_name ?? '-'); ?></div>
                        <div class="act-meta"><?php echo e($l->ip_address); ?> · <?php echo e(\Carbon\Carbon::parse($l->login_at)->diffForHumans()); ?></div>
                    </div>
                    <div class="text-end flex-shrink-0">
                        <div class="act-badge act-<?php echo e($l->status === 'success' ? 'ok' : 'fail'); ?>">
                            <?php echo e($l->status === 'success' ? 'Berhasil' : 'Gagal'); ?>

                        </div>
                        <div style="font-size:.65rem;color:#94a3b8;margin-top:.15rem;text-transform:capitalize">
                            <?php echo e($l->role); ?>

                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center py-4" style="color:#94a3b8;font-size:.82rem">
                    <i class="fas fa-history d-block mb-2" style="font-size:1.5rem"></i>
                    Belum ada aktivitas login
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div class="col-lg-4">
        <div class="panel">
            <div class="panel-head">
                <div class="panel-title"><i class="fas fa-bolt"></i> Aksi Cepat</div>
            </div>
            <div class="panel-body">
                <a href="<?php echo e(route('admin.users.create')); ?>" class="qa-btn" style="background:#f0fdfa;color:#0d9488">
                    <div class="qa-ic" style="background:linear-gradient(135deg,#0d9488,#0ea5e9)"><i class="fas fa-user-plus"></i></div>
                    Tambah Warga Baru
                </a>
                <a href="<?php echo e(route('admin.kaders.create')); ?>" class="qa-btn" style="background:#fffbeb;color:#b45309">
                    <div class="qa-ic" style="background:linear-gradient(135deg,#d97706,#f59e0b)"><i class="fas fa-user-nurse"></i></div>
                    Tambah Kader
                </a>
                <a href="<?php echo e(route('admin.bidans.create')); ?>" class="qa-btn" style="background:#f0fdf4;color:#166534">
                    <div class="qa-ic" style="background:linear-gradient(135deg,#10b981,#34d399)"><i class="fas fa-user-md"></i></div>
                    Tambah Bidan
                </a>
                <a href="<?php echo e(route('admin.settings.index')); ?>" class="qa-btn" style="background:#f8fafc;color:#475569">
                    <div class="qa-ic" style="background:linear-gradient(135deg,#475569,#94a3b8)"><i class="fas fa-cog"></i></div>
                    Pengaturan Sistem
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const ctx = document.getElementById('regChart');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($chartData['labels']); ?>,
        datasets: [{
            label: 'Warga Baru',
            data: <?php echo json_encode($chartData['userData']); ?>,
            borderColor: '#0d9488',
            backgroundColor: (ctx) => {
                const g = ctx.chart.ctx.createLinearGradient(0,0,0,220);
                g.addColorStop(0,'rgba(13,148,136,.25)');
                g.addColorStop(1,'rgba(13,148,136,.01)');
                return g;
            },
            borderWidth: 2.5, fill: true,
            tension: .4, pointRadius: 4,
            pointBackgroundColor: '#0d9488',
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1, font: { family:'Inter', size:11 } }, grid: { color:'#f1f5f9' } },
            x: { ticks: { font: { family:'Inter', size:11 } }, grid: { display: false } }
        }
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\POSYANDU\posyandu-management-system\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>