

<?php $__env->startSection('title', 'Buku Rekam Medis'); ?>
<?php $__env->startSection('page-name', 'Buku Rekam Medis'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .animate-slide-up { opacity: 0; animation: slideUpFade 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
    
    /* Custom Scrollbar */
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
        <i class="fas fa-book-medical text-cyan-500 text-2xl animate-pulse"></i>
    </div>
    <p class="text-cyan-800 font-black font-poppins tracking-widest text-[11px] animate-pulse uppercase" id="loaderText">MEMUAT REKAM MEDIS...</p>
</div>

<div class="max-w-6xl mx-auto animate-slide-up">

    <div class="bg-gradient-to-br from-cyan-500 to-sky-600 rounded-[32px] p-8 md:p-10 mb-8 relative overflow-hidden shadow-lg border border-cyan-500 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="absolute inset-0 opacity-20 pointer-events-none" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 24px 24px;"></div>
        <div class="relative z-10 w-full text-center md:text-left">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/20 backdrop-blur border border-white/30 text-white text-3xl mb-4 shadow-sm">
                <i class="fas fa-book-medical"></i>
            </div>
            <h2 class="text-2xl md:text-3xl font-black text-white font-poppins tracking-tight mb-2">Buku Rekam Medis Warga</h2>
            <p class="text-cyan-50 text-sm font-medium max-w-xl mx-auto md:mx-0">Cari pasien berdasarkan nama atau NIK untuk melihat riwayat kesehatan, grafik pertumbuhan, dan rekam jejak imunisasi mereka dari waktu ke waktu.</p>
        </div>
    </div>

    <div class="bg-white rounded-[32px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden mb-10">
        
        <div class="p-6 border-b border-slate-100 bg-slate-50/50">
            <form action="<?php echo e(route('bidan.rekam-medis.index')); ?>" method="GET" id="searchForm" class="flex flex-col md:flex-row gap-4">
                
                <div class="flex bg-white p-1.5 rounded-2xl border border-slate-200 shadow-sm w-full md:w-max shrink-0">
                    <a href="?type=balita&search=<?php echo e(request('search')); ?>" class="smooth-route flex-1 md:flex-none text-center px-6 py-3 rounded-xl text-[13px] font-extrabold transition-all <?php echo e($type == 'balita' ? 'bg-cyan-600 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50'); ?>">
                        <i class="fas fa-baby mr-1"></i> Balita
                    </a>
                    <a href="?type=remaja&search=<?php echo e(request('search')); ?>" class="smooth-route flex-1 md:flex-none text-center px-6 py-3 rounded-xl text-[13px] font-extrabold transition-all <?php echo e($type == 'remaja' ? 'bg-indigo-500 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50'); ?>">
                        <i class="fas fa-user-graduate mr-1"></i> Remaja
                    </a>
                    <a href="?type=lansia&search=<?php echo e(request('search')); ?>" class="smooth-route flex-1 md:flex-none text-center px-6 py-3 rounded-xl text-[13px] font-extrabold transition-all <?php echo e($type == 'lansia' ? 'bg-emerald-500 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50'); ?>">
                        <i class="fas fa-wheelchair mr-1"></i> Lansia
                    </a>
                </div>

                <input type="hidden" name="type" value="<?php echo e($type); ?>">

                <div class="relative w-full flex gap-3">
                    <div class="relative w-full">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nama atau NIK pasien (Tekan Enter)..." class="w-full pl-12 pr-4 py-3.5 bg-white border border-slate-200 rounded-2xl text-[13px] font-medium focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 outline-none transition-all shadow-sm">
                    </div>
                    <button type="submit" class="hidden md:flex px-6 py-3.5 bg-slate-800 text-white font-bold text-[13px] rounded-2xl hover:bg-slate-900 transition-colors shadow-md items-center gap-2">
                        Cari
                    </button>
                </div>
            </form>
        </div>

        <div class="divide-y divide-slate-100">
            <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pasien): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-5 hover:bg-slate-50/80 transition-colors group">
                <div class="flex items-center gap-5">
                    <?php
                        if($type == 'balita') { $bgC = 'bg-rose-100'; $txC = 'text-rose-500'; $icn = 'fa-baby'; $bdC = 'border-rose-200'; }
                        elseif($type == 'remaja') { $bgC = 'bg-indigo-100'; $txC = 'text-indigo-500'; $icn = 'fa-user-graduate'; $bdC = 'border-indigo-200'; }
                        else { $bgC = 'bg-emerald-100'; $txC = 'text-emerald-600'; $icn = 'fa-wheelchair'; $bdC = 'border-emerald-200'; }
                    ?>
                    
                    <div class="w-14 h-14 rounded-[20px] flex items-center justify-center text-2xl shrink-0 <?php echo e($bgC); ?> <?php echo e($txC); ?> border <?php echo e($bdC); ?> shadow-sm group-hover:scale-105 transition-transform">
                        <i class="fas <?php echo e($icn); ?>"></i>
                    </div>
                    
                    <div>
                        <h4 class="font-black text-slate-800 text-[16px] mb-1 group-hover:text-cyan-600 transition-colors"><?php echo e($pasien->nama_lengkap); ?></h4>
                        <div class="flex flex-wrap items-center gap-3 text-[11px] font-bold text-slate-500">
                            <span class="bg-white border border-slate-200 px-2.5 py-1 rounded-md shadow-sm"><i class="fas fa-id-card text-slate-400 mr-1"></i> NIK: <?php echo e($pasien->nik ?? '-'); ?></span>
                            <span class="bg-white border border-slate-200 px-2.5 py-1 rounded-md shadow-sm"><i class="fas fa-birthday-cake text-slate-400 mr-1"></i> <?php echo e(\Carbon\Carbon::parse($pasien->tanggal_lahir)->age); ?> Tahun</span>
                        </div>
                    </div>
                </div>

                <a href="<?php echo e(route('bidan.rekam-medis.show', ['pasien_type' => $type, 'pasien_id' => $pasien->id])); ?>" class="smooth-route inline-flex items-center justify-center gap-2 px-6 py-3 bg-white border-2 border-slate-200 text-slate-600 font-bold text-[13px] rounded-xl group-hover:bg-cyan-50 group-hover:text-cyan-600 group-hover:border-cyan-300 transition-all shadow-sm">
                    Buka Buku Medis <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center py-24">
                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mx-auto mb-5 text-4xl shadow-inner border border-slate-100">
                    <i class="fas fa-users-slash"></i>
                </div>
                <h4 class="font-black text-slate-800 text-lg font-poppins mb-1">Pasien Tidak Ditemukan</h4>
                <p class="text-[13px] font-medium text-slate-500 max-w-sm mx-auto">Coba gunakan nama, NIK lain, atau pastikan Anda berada di Tab kategori usia yang benar.</p>
            </div>
            <?php endif; ?>
        </div>
        
        <?php if($data->hasPages()): ?>
        <div class="px-6 py-5 border-t border-slate-100 bg-slate-50/50 pagination-wrapper">
            <?php echo e($data->appends(request()->query())->links()); ?>

        </div>
        <?php endif; ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    const showLoader = (text = 'MEMUAT DATA...') => {
        const loader = document.getElementById('smoothLoader');
        if(loader) {
            document.getElementById('loaderText').innerText = text;
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

    document.getElementById('searchForm').addEventListener('submit', () => showLoader('MENCARI PASIEN...'));

    document.querySelectorAll('.smooth-route, .pagination-wrapper a').forEach(link => {
        link.addEventListener('click', function(e) {
            if(!this.classList.contains('target-blank') && this.target !== '_blank' && !e.ctrlKey) {
                showLoader('MEMUAT REKAM MEDIS...');
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.bidan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\POSYANDU\posyandu-management-system\resources\views/bidan/rekam-medis/index.blade.php ENDPATH**/ ?>