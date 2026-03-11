

<?php $__env->startSection('title', 'Validasi Pemeriksaan'); ?>
<?php $__env->startSection('page-name', 'Riwayat & Validasi'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .animate-slide-up { opacity: 0; animation: slideUpFade 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div id="smoothLoader" class="fixed inset-0 bg-slate-50/90 backdrop-blur-md z-[9999] flex flex-col items-center justify-center transition-all duration-300 opacity-100">
    <div class="relative w-20 h-20 flex items-center justify-center mb-4">
        <div class="absolute inset-0 border-4 border-cyan-100 rounded-full"></div>
        <div class="absolute inset-0 border-4 border-cyan-600 rounded-full border-t-transparent animate-spin"></div>
        <i class="fas fa-heartbeat text-cyan-600 text-2xl animate-pulse"></i>
    </div>
    <p class="text-cyan-800 font-extrabold tracking-widest text-sm animate-pulse">MEMUAT DATA...</p>
</div>

<div class="max-w-7xl mx-auto animate-slide-up">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-[18px] bg-cyan-100 text-cyan-600 flex items-center justify-center text-2xl shadow-inner border border-cyan-200">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Riwayat & Validasi</h1>
                <p class="text-slate-500 mt-1 font-medium text-sm">Kelola dan berikan diagnosa pada data pemeriksaan warga.</p>
            </div>
        </div>
        <a href="<?php echo e(route('bidan.pemeriksaan.create')); ?>" class="smooth-route inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-cyan-600 text-white font-extrabold text-sm rounded-xl hover:bg-cyan-700 shadow-[0_4px_12px_rgba(8,145,178,0.3)] hover:-translate-y-0.5 transition-all">
            <i class="fas fa-plus"></i> Input Manual
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-5 rounded-[20px] border border-slate-200/80 shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex items-center justify-between">
            <div>
                <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Antrian Validasi</p>
                <h3 class="text-2xl font-black text-rose-600"><?php echo e($stats['pending'] ?? 0); ?> <span class="text-sm font-bold text-slate-500">Pasien</span></h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-rose-50 text-rose-500 flex items-center justify-center text-xl"><i class="fas fa-hourglass-half"></i></div>
        </div>
        <div class="bg-white p-5 rounded-[20px] border border-slate-200/80 shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex items-center justify-between">
            <div>
                <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Selesai Diverifikasi</p>
                <h3 class="text-2xl font-black text-emerald-600"><?php echo e($stats['verified'] ?? 0); ?> <span class="text-sm font-bold text-slate-500">Data</span></h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl"><i class="fas fa-check-double"></i></div>
        </div>
        <div class="bg-white p-5 rounded-[20px] border border-slate-200/80 shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex items-center justify-between">
            <div>
                <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Total Pemeriksaan</p>
                <h3 class="text-2xl font-black text-cyan-600"><?php echo e($stats['total'] ?? 0); ?> <span class="text-sm font-bold text-slate-500">Data</span></h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-cyan-50 text-cyan-500 flex items-center justify-center text-xl"><i class="fas fa-notes-medical"></i></div>
        </div>
    </div>

    <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
        
        <div class="p-5 border-b border-slate-100 bg-slate-50/50">
            <form id="filterForm" action="<?php echo e(route('bidan.pemeriksaan.index')); ?>" method="GET" class="flex flex-wrap md:flex-nowrap gap-3">
                
                <div class="w-full md:w-2/5 relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nama pasien (Tekan Enter)..." class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-cyan-100 focus:border-cyan-500 outline-none transition-all">
                </div>

                <div class="w-full md:w-1/4">
                    <select name="kategori" class="auto-submit w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-cyan-100 outline-none cursor-pointer">
                        <option value="">Semua Kategori</option>
                        <option value="balita" <?php echo e(request('kategori') == 'balita' ? 'selected' : ''); ?>>Balita</option>
                        <option value="remaja" <?php echo e(request('kategori') == 'remaja' ? 'selected' : ''); ?>>Remaja</option>
                        <option value="lansia" <?php echo e(request('kategori') == 'lansia' ? 'selected' : ''); ?>>Lansia</option>
                    </select>
                </div>

                <div class="w-full md:w-1/4">
                    <select name="status" class="auto-submit w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-cyan-100 outline-none cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Menunggu Validasi</option>
                        <option value="verified" <?php echo e(request('status') == 'verified' ? 'selected' : ''); ?>>Telah Diverifikasi</option>
                        <option value="rejected" <?php echo e(request('status') == 'rejected' ? 'selected' : ''); ?>>Ditolak</option>
                    </select>
                </div>

                <div class="w-full md:w-auto flex justify-end">
                    <?php if(request()->anyFilled(['search', 'kategori', 'status', 'bulan'])): ?>
                        <a href="<?php echo e(route('bidan.pemeriksaan.index')); ?>" class="smooth-route flex items-center justify-center w-11 h-11 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-100 transition-colors" title="Reset Filter">
                            <i class="fas fa-undo"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse min-w-[1000px]">
                <thead>
                    <tr class="bg-white border-b border-slate-100">
                        <th class="px-6 py-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Tgl / Waktu</th>
                        <th class="px-6 py-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Data Pasien</th>
                        <th class="px-6 py-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Hasil Ukur (Kader)</th>
                        <th class="px-6 py-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest text-center">Status Verifikasi</th>
                        <th class="px-6 py-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest text-right">Tindakan Medis</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php $__empty_1 = true; $__currentLoopData = $riwayat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        
                        <td class="px-6 py-4 align-top">
                            <p class="font-bold text-slate-800 text-sm"><?php echo e(\Carbon\Carbon::parse($item->tanggal_periksa)->format('d M Y')); ?></p>
                            <p class="text-[11px] font-bold text-slate-400 mt-0.5"><i class="fas fa-clock mr-1"></i> <?php echo e($item->created_at->format('H:i')); ?> WIB</p>
                        </td>

                        <td class="px-6 py-4 align-top">
                            <p class="font-bold text-slate-700 text-sm mb-1 truncate max-w-[200px]">
                                <?php echo e($item->nama_pasien ?? ($item->balita->nama_lengkap ?? ($item->remaja->nama_lengkap ?? ($item->lansia->nama_lengkap ?? '-')))); ?>

                            </p>
                            <?php if($item->kategori_pasien == 'balita'): ?> <span class="px-2 py-0.5 bg-rose-100 text-rose-700 text-[9px] font-extrabold rounded border border-rose-200 uppercase">Balita</span>
                            <?php elseif($item->kategori_pasien == 'remaja'): ?> <span class="px-2 py-0.5 bg-indigo-100 text-indigo-700 text-[9px] font-extrabold rounded border border-indigo-200 uppercase">Remaja</span>
                            <?php else: ?> <span class="px-2 py-0.5 bg-emerald-100 text-emerald-700 text-[9px] font-extrabold rounded border border-emerald-200 uppercase">Lansia</span> <?php endif; ?>
                        </td>

                        <td class="px-6 py-4 align-top">
                            <div class="flex flex-wrap gap-1.5 text-[11px] font-semibold">
                                <span class="px-2 py-1 bg-slate-100 text-slate-600 rounded border border-slate-200">BB: <span class="font-black text-slate-800"><?php echo e($item->berat_badan ?? '-'); ?> kg</span></span>
                                <span class="px-2 py-1 bg-slate-100 text-slate-600 rounded border border-slate-200">TB: <span class="font-black text-slate-800"><?php echo e($item->tinggi_badan ?? '-'); ?> cm</span></span>
                                <?php if($item->tekanan_darah): ?>
                                    <span class="px-2 py-1 <?php echo e(intval(explode('/', $item->tekanan_darah)[0]) >= 140 ? 'bg-rose-50 text-rose-700 border-rose-200' : 'bg-slate-100 text-slate-600 border-slate-200'); ?> rounded border">
                                        TD: <span class="font-black"><?php echo e($item->tekanan_darah); ?></span>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </td>

                        <td class="px-6 py-4 text-center align-middle">
                            <?php if($item->status_verifikasi == 'verified'): ?>
                                <span class="inline-flex items-center justify-center gap-1 px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-600 text-[11px] font-bold border border-emerald-200"><i class="fas fa-check-circle"></i> Terverifikasi</span>
                            <?php elseif($item->status_verifikasi == 'pending'): ?>
                                <span class="inline-flex items-center justify-center gap-1 px-3 py-1.5 rounded-lg bg-amber-50 text-amber-600 text-[11px] font-bold border border-amber-200 animate-pulse"><i class="fas fa-hourglass-half"></i> Menunggu Bidan</span>
                            <?php else: ?>
                                <span class="inline-flex items-center justify-center gap-1 px-3 py-1.5 rounded-lg bg-rose-50 text-rose-600 text-[11px] font-bold border border-rose-200"><i class="fas fa-times-circle"></i> Ditolak</span>
                            <?php endif; ?>
                        </td>

                        <td class="px-6 py-4 text-right align-middle">
                            <?php if($item->status_verifikasi == 'pending'): ?>
                                <a href="<?php echo e(route('bidan.pemeriksaan.show', $item->id)); ?>" class="smooth-route inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-cyan-500 to-cyan-600 text-white text-xs font-bold rounded-xl hover:from-cyan-600 hover:to-cyan-700 shadow-[0_4px_10px_rgba(8,145,178,0.3)] transition-all transform hover:-translate-y-0.5">
                                    <i class="fas fa-stethoscope"></i> Validasi
                                </a>
                            <?php else: ?>
                                <a href="<?php echo e(route('bidan.pemeriksaan.show', $item->id)); ?>" class="smooth-route inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-600 text-xs font-bold rounded-xl hover:bg-slate-50 transition-colors shadow-sm">
                                    <i class="fas fa-file-medical"></i> Detail
                                </a>
                            <?php endif; ?>
                        </td>

                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center py-16">
                            <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-300 mx-auto mb-4 text-3xl shadow-inner"><i class="fas fa-folder-open"></i></div>
                            <h4 class="font-black text-slate-700 text-sm">Tidak ada data pemeriksaan</h4>
                            <p class="text-xs text-slate-500 mt-1">Belum ada data yang sesuai dengan filter Anda saat ini.</p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <?php if($riwayat->hasPages()): ?>
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 pagination-wrapper">
            <?php echo e($riwayat->links()); ?>

        </div>
        <?php endif; ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // FUNGSI TRANISI HALAMAN (SPA-FEEL)
    const showLoader = () => {
        const loader = document.getElementById('smoothLoader');
        if(loader) {
            loader.style.display = 'flex';
            loader.offsetHeight; 
            loader.classList.remove('opacity-0', 'pointer-events-none');
            loader.classList.add('opacity-100');
        }
    };

    // Hilangkan loader saat halaman selesai dimuat (juga handle tombol Back browser)
    window.addEventListener('pageshow', () => {
        const loader = document.getElementById('smoothLoader');
        if(loader) {
            loader.classList.remove('opacity-100');
            loader.classList.add('opacity-0', 'pointer-events-none');
            setTimeout(() => loader.style.display = 'none', 300);
        }
    });

    // Auto-Submit Filter Dropdown
    document.querySelectorAll('.auto-submit').forEach(select => {
        select.addEventListener('change', function() {
            showLoader();
            document.getElementById('filterForm').submit();
        });
    });

    // Cegah hard-refresh saat tekan tombol Enter di pencarian
    document.getElementById('filterForm').addEventListener('submit', showLoader);

    // Animasi untuk link route & pagination
    document.querySelectorAll('.smooth-route, .pagination-wrapper a').forEach(link => {
        link.addEventListener('click', function(e) {
            if(this.target !== '_blank' && !e.ctrlKey && !e.metaKey) {
                showLoader();
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.bidan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\POSYANDU\posyandu-management-system\resources\views/bidan/pemeriksaan/index.blade.php ENDPATH**/ ?>