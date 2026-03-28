
<?php $__env->startSection('title', 'Register Imunisasi'); ?>
<?php $__env->startSection('page-name', 'Riwayat Imunisasi'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .animate-slide-up { opacity: 0; animation: slideUpFade 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
    .custom-scrollbar::-webkit-scrollbar { height: 6px; width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div id="smoothLoader" class="fixed inset-0 bg-slate-50/90 backdrop-blur-md z-[9999] flex flex-col items-center justify-center transition-all duration-300 opacity-100">
    <div class="relative w-20 h-20 flex items-center justify-center mb-4">
        <div class="absolute inset-0 border-4 border-cyan-100 rounded-full"></div>
        <div class="absolute inset-0 border-4 border-cyan-500 rounded-full border-t-transparent animate-spin"></div>
        <i class="fas fa-shield-virus text-cyan-500 text-2xl animate-pulse"></i>
    </div>
    <p class="text-cyan-800 font-black font-poppins tracking-widest text-[11px] animate-pulse uppercase">Memuat Register...</p>
</div>

<div class="max-w-7xl mx-auto animate-slide-up">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-5 mb-8">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-cyan-400 to-sky-500 text-white flex items-center justify-center text-2xl shadow-[0_8px_15px_rgba(6,182,212,0.3)]">
                <i class="fas fa-syringe"></i>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-800 tracking-tight font-poppins">Register Imunisasi</h1>
                <p class="text-slate-500 mt-1 font-medium text-[13px]">Buku log riwayat pemberian vaksin. Data otomatis sinkron dengan akun Warga.</p>
            </div>
        </div>
        <a href="<?php echo e(route('bidan.imunisasi.create')); ?>" class="smooth-route inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-cyan-600 text-white font-bold text-[13px] rounded-xl hover:bg-cyan-700 transition-all shadow-[0_4px_15px_rgba(6,182,212,0.3)] hover:-translate-y-0.5">
            <i class="fas fa-plus"></i> Tambah Vaksinasi
        </a>
    </div>

    <?php $__currentLoopData = ['success' => ['bg-emerald-50', 'text-emerald-600', 'fa-check-circle', 'border-emerald-200'], 'error' => ['bg-rose-50', 'text-rose-600', 'fa-exclamation-circle', 'border-rose-200']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg => $cls): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(session($msg)): ?>
            <div class="mb-6 px-5 py-4 <?php echo e($cls[0]); ?> border <?php echo e($cls[3]); ?> rounded-xl flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <i class="fas <?php echo e($cls[2]); ?> <?php echo e($cls[1]); ?> text-xl"></i>
                    <span class="<?php echo e($cls[1]); ?> text-sm font-bold"><?php echo e(session($msg)); ?></span>
                </div>
                <button onclick="this.parentElement.style.display='none'" class="<?php echo e($cls[1]); ?> hover:opacity-70 p-1"><i class="fas fa-times"></i></button>
            </div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.03)] overflow-hidden">
        
        <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <a href="<?php echo e(route('bidan.imunisasi.index')); ?>" class="smooth-route px-5 py-2.5 bg-white border border-slate-200 text-slate-700 text-[13px] font-bold rounded-xl shadow-sm hover:bg-slate-50 transition-colors">Semua Data</a>
            </div>
            
            <form id="filterForm" method="GET" action="<?php echo e(route('bidan.imunisasi.index')); ?>" class="relative w-full md:w-80">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari pasien atau nama vaksin..." class="w-full bg-white border border-slate-200 rounded-xl pl-11 pr-4 py-2.5 text-[13px] font-medium focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 outline-none shadow-sm transition-all">
            </form>
        </div>

        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse min-w-[900px]">
                <thead>
                    <tr class="bg-white border-b border-slate-100">
                        <th class="py-4 px-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tgl Pemberian</th>
                        <th class="py-4 px-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Identitas Pasien</th>
                        <th class="py-4 px-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Detail Vaksin</th>
                        <th class="py-4 px-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Petugas</th>
                        <th class="py-4 px-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php $__empty_1 = true; $__currentLoopData = $imunisasis ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imun): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        
                        <td class="py-4 px-6 align-middle">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-full bg-cyan-50 flex flex-col items-center justify-center text-cyan-700 border border-cyan-100 shadow-sm shrink-0">
                                    <span class="text-[15px] font-black leading-none"><?php echo e(\Carbon\Carbon::parse($imun->tanggal_imunisasi)->format('d')); ?></span>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 text-[13px]"><?php echo e(\Carbon\Carbon::parse($imun->tanggal_imunisasi)->translatedFormat('F Y')); ?></p>
                                    <p class="text-[11px] font-bold text-slate-400 mt-0.5"><i class="fas fa-clock mr-1"></i> <?php echo e($imun->created_at->format('H:i')); ?> WIB</p>
                                </div>
                            </div>
                        </td>

                        <td class="py-4 px-6 align-middle">
                            <?php
                                $namaPasien = $imun->kunjungan?->pasien?->nama_lengkap ?? 'Tidak Diketahui';
                                $tipePasien = class_basename($imun->kunjungan?->pasien_type);
                                
                                if($tipePasien == 'Balita') { $bCol = 'rose'; $bIcon = 'baby'; }
                                elseif($tipePasien == 'Remaja') { $bCol = 'indigo'; $bIcon = 'user-graduate'; }
                                else { $bCol = 'slate'; $bIcon = 'user'; }
                            ?>
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-<?php echo e($bCol); ?>-50 text-<?php echo e($bCol); ?>-500 flex items-center justify-center shrink-0 border border-<?php echo e($bCol); ?>-100">
                                    <i class="fas fa-<?php echo e($bIcon); ?> text-xs"></i>
                                </div>
                                <div>
                                    <p class="font-extrabold text-slate-700 text-[14px] mb-0.5 truncate max-w-[200px]"><?php echo e($namaPasien); ?></p>
                                    <span class="text-[10px] font-black text-<?php echo e($bCol); ?>-500 uppercase tracking-wider"><?php echo e($tipePasien); ?></span>
                                </div>
                            </div>
                        </td>

                        <td class="py-4 px-6 align-middle">
                            <p class="text-[14px] font-black text-slate-800 mb-1"><i class="fas fa-prescription-bottle-alt text-cyan-500 mr-1.5"></i> <?php echo e($imun->vaksin); ?></p>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-white border border-slate-200 text-slate-500 text-[10px] font-bold rounded-lg shadow-sm">
                                Dosis: <strong class="text-cyan-600"><?php echo e($imun->dosis); ?></strong> &middot; <?php echo e($imun->jenis_imunisasi); ?>

                            </span>
                        </td>

                        <td class="py-4 px-6 align-middle">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-full bg-slate-800 text-white flex items-center justify-center text-[10px] font-bold shadow-sm shrink-0">
                                    <?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?>

                                </div>
                                <span class="text-[12px] font-bold text-slate-600"><?php echo e(Auth::user()->name); ?></span>
                            </div>
                        </td>

                        <td class="py-4 px-6 text-center align-middle">
                            <div class="flex items-center justify-center gap-2 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity">
                                <a href="<?php echo e(route('bidan.imunisasi.show', $imun->id)); ?>" class="smooth-route w-9 h-9 rounded-xl bg-white border border-slate-200 text-slate-400 flex items-center justify-center hover:text-cyan-600 hover:border-cyan-300 hover:bg-cyan-50 shadow-sm transition-all" title="Detail Imunisasi">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo e(route('bidan.imunisasi.edit', $imun->id)); ?>" class="smooth-route w-9 h-9 rounded-xl bg-white border border-slate-200 text-slate-400 flex items-center justify-center hover:text-amber-500 hover:border-amber-300 hover:bg-amber-50 shadow-sm transition-all" title="Edit Data">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="<?php echo e(route('bidan.imunisasi.destroy', $imun->id)); ?>" method="POST" class="m-0" onsubmit="return confirm('Hapus permanen data imunisasi ini? Data tidak dapat dikembalikan.')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-slate-400 flex items-center justify-center hover:text-rose-500 hover:border-rose-300 hover:bg-rose-50 shadow-sm transition-all" title="Hapus Data">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="py-20 text-center">
                            <div class="inline-flex items-center justify-center w-20 h-20 rounded-[24px] bg-slate-50 border border-slate-100 text-slate-300 mb-4 shadow-inner">
                                <i class="fas fa-shield-virus text-4xl"></i>
                            </div>
                            <h3 class="text-[15px] font-black text-slate-700 font-poppins tracking-wide mb-1">Log Imunisasi Kosong</h3>
                            <p class="text-[13px] font-medium text-slate-400 max-w-sm mx-auto">Klik tombol "Tambah Vaksinasi" di atas untuk mencatat pemberian vaksin hari ini.</p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <?php if(isset($imunisasis) && $imunisasis->hasPages()): ?>
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 pagination-wrapper">
            <?php echo e($imunisasis->withQueryString()->links()); ?>

        </div>
        <?php endif; ?>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    const showLoader = () => {
        const loader = document.getElementById('smoothLoader');
        if(loader) {
            loader.style.display = 'flex';
            loader.offsetHeight; 
            loader.classList.remove('opacity-0', 'pointer-events-none');
            loader.classList.add('opacity-100');
        }
    };

    window.addEventListener('pageshow', () => {
        const loader = document.getElementById('smoothLoader');
        if(loader) {
            loader.classList.remove('opacity-100');
            loader.classList.add('opacity-0', 'pointer-events-none');
            setTimeout(() => loader.style.display = 'none', 300);
        }
    });

    document.getElementById('filterForm').addEventListener('submit', showLoader);

    document.querySelectorAll('.smooth-route, .pagination-wrapper a').forEach(link => {
        link.addEventListener('click', function(e) {
            if(this.target !== '_blank' && !e.ctrlKey && !e.metaKey) {
                showLoader();
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.bidan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\POSYANDU\posyandu-management-system\resources\views/bidan/imunisasi/index.blade.php ENDPATH**/ ?>