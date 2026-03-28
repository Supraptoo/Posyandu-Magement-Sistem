

<?php $__env->startSection('title', 'Data Pasien Balita'); ?>
<?php $__env->startSection('page-name', 'Pantau Data Balita'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .animate-slide-up { opacity: 0; animation: slideUpFade 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
    .custom-scrollbar::-webkit-scrollbar { height: 6px; width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div id="smoothLoader" class="fixed inset-0 bg-slate-50/90 backdrop-blur-md z-[9999] flex flex-col items-center justify-center transition-all duration-300 opacity-0 pointer-events-none">
    <div class="relative w-20 h-20 flex items-center justify-center mb-4">
        <div class="absolute inset-0 border-4 border-rose-100 rounded-full"></div>
        <div class="absolute inset-0 border-4 border-rose-500 rounded-full border-t-transparent animate-spin"></div>
        <i class="fas fa-baby text-rose-500 text-2xl animate-pulse"></i>
    </div>
    <p class="text-rose-800 font-extrabold tracking-widest text-[11px] uppercase animate-pulse">Memuat Data...</p>
</div>

<div class="max-w-7xl mx-auto animate-slide-up">

    <div class="bg-gradient-to-br from-rose-400 to-pink-500 rounded-[32px] p-8 md:p-10 mb-8 relative overflow-hidden shadow-lg border border-rose-400 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="absolute inset-0 opacity-20 pointer-events-none" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 24px 24px;"></div>
        <div class="absolute -right-10 -bottom-10 opacity-10 text-[120px] pointer-events-none"><i class="fas fa-baby"></i></div>
        
        <div class="relative z-10 w-full md:w-auto text-center md:text-left flex items-center gap-6">
            <div class="w-20 h-20 rounded-[24px] bg-white/20 backdrop-blur border border-white/30 text-white flex items-center justify-center text-4xl shrink-0 shadow-sm transform -rotate-3 hover:rotate-0 transition-transform">
                <i class="fas fa-baby"></i>
            </div>
            <div>
                <h2 class="text-2xl md:text-3xl font-black text-white font-poppins tracking-tight mb-1">Database Balita</h2>
                <p class="text-rose-50 text-sm font-medium max-w-md mx-auto md:mx-0">Pantau riwayat gizi, status *stunting*, dan perkembangan fisik anak secara berkala.</p>
            </div>
        </div>
        
        <a href="<?php echo e(route('bidan.laporan.cetak', ['jenis' => 'balita'])); ?>" target="_blank" class="relative z-10 inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-white text-rose-600 font-extrabold text-[13px] rounded-xl hover:bg-rose-50 shadow-[0_8px_20px_rgba(225,29,72,0.3)] transition-all hover:-translate-y-0.5">
            <i class="fas fa-print"></i> Cetak Laporan
        </a>
    </div>

    <div class="bg-white rounded-[32px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.03)] overflow-hidden">
        
        <div class="p-6 border-b border-slate-100 bg-slate-50/50">
            <form id="filterForm" action="<?php echo e(route('bidan.pasien.balita')); ?>" method="GET" class="flex flex-col md:flex-row gap-3">
                <div class="w-full relative flex-1">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nama balita, NIK, atau nama ibu (Tekan Enter)..." class="w-full pl-12 pr-4 py-3.5 bg-white border border-slate-200 rounded-2xl text-[13px] font-medium focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 outline-none transition-all shadow-sm">
                </div>
                <?php if(request('search')): ?>
                    <a href="<?php echo e(route('bidan.pasien.balita')); ?>" class="smooth-route flex items-center justify-center px-6 py-3.5 bg-slate-100 text-slate-600 rounded-2xl hover:bg-slate-200 transition-colors font-bold text-[13px]">
                        <i class="fas fa-times mr-2"></i> Reset
                    </a>
                <?php endif; ?>
            </form>
        </div>

        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse min-w-[900px]">
                <thead>
                    <tr class="bg-white border-b border-slate-100">
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Identitas Balita</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Orang Tua</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pemeriksaan Terakhir</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status Gizi</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php $__empty_1 = true; $__currentLoopData = $balitas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $balita): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-rose-50/30 transition-colors group">
                        
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-rose-100 text-rose-500 flex items-center justify-center border border-rose-200 shrink-0"><i class="fas fa-baby"></i></div>
                                <div>
                                    <p class="font-black text-slate-800 text-[14px] mb-0.5"><?php echo e($balita->nama_lengkap); ?></p>
                                    <p class="text-[11px] font-bold text-slate-400">Usia: <span class="text-rose-500"><?php echo e(\Carbon\Carbon::parse($balita->tanggal_lahir)->age); ?> Thn</span></p>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-700 text-[12px] mb-0.5"><i class="fas fa-female text-slate-300 mr-1"></i> <?php echo e($balita->nama_ibu ?? '-'); ?></p>
                            <p class="font-bold text-slate-700 text-[12px]"><i class="fas fa-male text-slate-300 mr-1"></i> <?php echo e($balita->nama_ayah ?? '-'); ?></p>
                        </td>

                        <td class="px-6 py-4">
                            <?php if($balita->pemeriksaan_terakhir): ?>
                                <p class="font-bold text-slate-800 text-[12px] mb-1.5"><?php echo e(\Carbon\Carbon::parse($balita->pemeriksaan_terakhir->tanggal_periksa)->format('d M Y')); ?></p>
                                <div class="flex flex-wrap gap-2 text-[10px] font-black text-rose-700">
                                    <span class="bg-rose-50 px-2.5 py-1 rounded-md border border-rose-100 shadow-sm">BB: <?php echo e($balita->pemeriksaan_terakhir->berat_badan); ?>kg</span>
                                    <span class="bg-rose-50 px-2.5 py-1 rounded-md border border-rose-100 shadow-sm">TB: <?php echo e($balita->pemeriksaan_terakhir->tinggi_badan); ?>cm</span>
                                </div>
                            <?php else: ?>
                                <span class="text-[11px] text-slate-400 font-bold italic border border-slate-200 px-3 py-1 rounded-lg bg-slate-50">Belum ada riwayat</span>
                            <?php endif; ?>
                        </td>

                        <td class="px-6 py-4 text-center">
                            <?php if($balita->pemeriksaan_terakhir && $balita->pemeriksaan_terakhir->status_gizi): ?>
                                <?php
                                    $gizi = strtolower($balita->pemeriksaan_terakhir->status_gizi);
                                    $badge = match(true) {
                                        str_contains($gizi, 'baik') || str_contains($gizi, 'normal') => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                        str_contains($gizi, 'kurang') => 'bg-amber-50 text-amber-600 border-amber-200',
                                        str_contains($gizi, 'buruk') || str_contains($gizi, 'stunting') => 'bg-rose-50 text-rose-600 border-rose-200',
                                        default => 'bg-slate-50 text-slate-600 border-slate-200'
                                    };
                                ?>
                                <span class="px-3 py-1.5 rounded-lg text-[10px] font-black border uppercase tracking-wider <?php echo e($badge); ?> shadow-sm">
                                    <?php echo e($balita->pemeriksaan_terakhir->status_gizi); ?>

                                </span>
                            <?php else: ?>
                                <span class="text-xs text-slate-400">-</span>
                            <?php endif; ?>
                        </td>

                        <td class="px-6 py-4 text-right">
                            <a href="<?php echo e(route('bidan.rekam-medis.show', ['pasien_type' => 'balita', 'pasien_id' => $balita->id])); ?>" class="smooth-route inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-600 text-[12px] font-bold rounded-xl hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 transition-all shadow-sm">
                                <i class="fas fa-folder-open"></i> Buku Medis
                            </a>
                        </td>

                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center py-20">
                            <div class="w-20 h-20 bg-slate-50 rounded-[24px] flex items-center justify-center text-slate-300 mx-auto mb-4 text-4xl shadow-inner border border-slate-100"><i class="fas fa-search"></i></div>
                            <h4 class="font-black text-slate-700 text-[15px] font-poppins">Data Tidak Ditemukan</h4>
                            <p class="text-[13px] text-slate-500 mt-1 font-medium">Pastikan ejaan nama atau NIK yang Anda cari sudah benar.</p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <?php if($balitas->hasPages()): ?>
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 pagination-wrapper">
            <?php echo e($balitas->links()); ?>

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
            if(!this.classList.contains('target-blank') && this.target !== '_blank' && !e.ctrlKey) showLoader();
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.bidan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\POSYANDU\posyandu-management-system\resources\views/bidan/pasien/balita.blade.php ENDPATH**/ ?>