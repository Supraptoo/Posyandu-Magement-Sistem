

<?php $__env->startSection('title', 'Data Pasien Lansia'); ?>
<?php $__env->startSection('page-name', 'Pantau Data Lansia'); ?>

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
        <div class="absolute inset-0 border-4 border-emerald-100 rounded-full"></div>
        <div class="absolute inset-0 border-4 border-emerald-500 rounded-full border-t-transparent animate-spin"></div>
        <i class="fas fa-wheelchair text-emerald-500 text-2xl animate-pulse"></i>
    </div>
    <p class="text-emerald-800 font-extrabold tracking-widest text-[11px] uppercase animate-pulse">Memuat Data...</p>
</div>

<div class="max-w-7xl mx-auto animate-slide-up">

    <div class="bg-gradient-to-br from-emerald-400 to-teal-500 rounded-[32px] p-8 md:p-10 mb-8 relative overflow-hidden shadow-lg border border-emerald-400 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="absolute inset-0 opacity-20 pointer-events-none" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 24px 24px;"></div>
        <div class="absolute -right-10 -bottom-10 opacity-10 text-[120px] pointer-events-none"><i class="fas fa-wheelchair"></i></div>
        
        <div class="relative z-10 w-full md:w-auto text-center md:text-left flex items-center gap-6">
            <div class="w-20 h-20 rounded-[24px] bg-white/20 backdrop-blur border border-white/30 text-white flex items-center justify-center text-4xl shrink-0 shadow-sm transform -rotate-3 hover:rotate-0 transition-transform">
                <i class="fas fa-wheelchair"></i>
            </div>
            <div>
                <h2 class="text-2xl md:text-3xl font-black text-white font-poppins tracking-tight mb-1">Database Lansia</h2>
                <p class="text-emerald-50 text-sm font-medium max-w-md mx-auto md:mx-0">Database khusus warga lanjut usia untuk pemantauan riwayat hipertensi dan penyakit penyerta.</p>
            </div>
        </div>
        
        <a href="<?php echo e(route('bidan.laporan.cetak', ['jenis' => 'lansia'])); ?>" target="_blank" class="relative z-10 inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-white text-emerald-600 font-extrabold text-[13px] rounded-xl hover:bg-emerald-50 shadow-[0_8px_20px_rgba(16,185,129,0.3)] transition-all hover:-translate-y-0.5">
            <i class="fas fa-print"></i> Cetak Laporan
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
        <div class="bg-white p-6 rounded-[24px] border border-slate-200/80 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex items-center justify-between relative overflow-hidden">
            <div class="absolute right-0 top-0 w-24 h-24 bg-emerald-500/10 rounded-bl-[100px] pointer-events-none"></div>
            <div>
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1">Tensi Normal</p>
                <h3 class="text-3xl font-black text-emerald-500 font-poppins"><?php echo e($statistik->normal ?? 0); ?> <span class="text-xs font-bold text-slate-500 ml-1">Pasien</span></h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl relative z-10"><i class="fas fa-smile"></i></div>
        </div>
        <div class="bg-white p-6 rounded-[24px] border border-slate-200/80 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex items-center justify-between relative overflow-hidden">
            <div class="absolute right-0 top-0 w-24 h-24 bg-amber-500/10 rounded-bl-[100px] pointer-events-none"></div>
            <div>
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1">Hipertensi Level 1-2</p>
                <h3 class="text-3xl font-black text-amber-500 font-poppins"><?php echo e($statistik->hipertensi ?? 0); ?> <span class="text-xs font-bold text-slate-500 ml-1">Pasien</span></h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center text-xl relative z-10"><i class="fas fa-heartbeat"></i></div>
        </div>
        <div class="bg-white p-6 rounded-[24px] border-l-4 border-rose-500 shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex items-center justify-between relative overflow-hidden">
            <div class="absolute right-0 top-0 w-24 h-24 bg-rose-500/10 rounded-bl-[100px] pointer-events-none"></div>
            <div>
                <p class="text-[11px] font-black text-rose-500 uppercase tracking-widest mb-1">Tensi Kritis (>180)</p>
                <h3 class="text-3xl font-black text-rose-600 font-poppins"><?php echo e($statistik->kritis ?? 0); ?> <span class="text-xs font-bold text-rose-500 ml-1">Pasien</span></h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-rose-50 text-rose-500 flex items-center justify-center text-xl relative z-10 animate-pulse"><i class="fas fa-exclamation-triangle"></i></div>
        </div>
    </div>

    <div class="bg-white rounded-[32px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.03)] overflow-hidden">
        
        <div class="p-6 border-b border-slate-100 bg-slate-50/50">
            <form id="filterForm" action="<?php echo e(route('bidan.pasien.lansia')); ?>" method="GET" class="flex flex-wrap md:flex-nowrap gap-3">
                <div class="w-full md:w-3/5 relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nama lansia, NIK, atau riwayat penyakit..." class="w-full pl-12 pr-4 py-3.5 bg-white border border-slate-200 rounded-2xl text-[13px] font-medium focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all shadow-sm">
                </div>

                <div class="w-full md:w-1/4">
                    <select name="status" class="auto-submit w-full px-4 py-3.5 bg-white border border-slate-200 rounded-2xl text-[13px] font-bold text-slate-600 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none cursor-pointer shadow-sm">
                        <option value="">Semua Kondisi Tensi</option>
                        <option value="normal" <?php echo e(request('status') == 'normal' ? 'selected' : ''); ?>>🟢 Tensi Normal</option>
                        <option value="hipertensi" <?php echo e(request('status') == 'hipertensi' ? 'selected' : ''); ?>>🟠 Hipertensi</option>
                        <option value="diabetes" <?php echo e(request('status') == 'diabetes' ? 'selected' : ''); ?>>🔴 Kritis (>180)</option>
                    </select>
                </div>

                <?php if(request()->anyFilled(['search', 'status'])): ?>
                    <div class="w-full md:w-auto">
                        <a href="<?php echo e(route('bidan.pasien.lansia')); ?>" class="smooth-route flex items-center justify-center h-full px-6 bg-slate-100 text-slate-600 rounded-2xl hover:bg-slate-200 transition-colors font-bold text-[13px]">
                            Reset
                        </a>
                    </div>
                <?php endif; ?>
            </form>
        </div>

        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse min-w-[900px]">
                <thead>
                    <tr class="bg-white border-b border-slate-100">
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Identitas Lansia</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pemeriksaan Terakhir</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Hasil Diagnosa Bidan</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php $__empty_1 = true; $__currentLoopData = $lansias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lansia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-emerald-50/30 transition-colors group">
                        
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center border border-emerald-200 shrink-0"><i class="fas fa-wheelchair"></i></div>
                                <div>
                                    <p class="font-black text-slate-800 text-[14px] mb-0.5"><?php echo e($lansia->nama_lengkap); ?></p>
                                    <p class="text-[11px] font-bold text-slate-400">Usia: <span class="text-emerald-600"><?php echo e(\Carbon\Carbon::parse($lansia->tanggal_lahir)->age); ?> Thn</span></p>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 align-top">
                            <?php if($lansia->pemeriksaan_terakhir): ?>
                                <p class="font-bold text-slate-800 text-[12px] mb-1.5"><?php echo e(\Carbon\Carbon::parse($lansia->pemeriksaan_terakhir->tanggal_periksa)->format('d M Y')); ?></p>
                                <div class="flex flex-wrap gap-2 text-[10px] font-black">
                                    <span class="bg-slate-50 text-slate-600 px-2.5 py-1 rounded-md border border-slate-200 shadow-sm">BB: <?php echo e($lansia->pemeriksaan_terakhir->berat_badan ?? '-'); ?>kg</span>
                                    <?php if($lansia->pemeriksaan_terakhir->tekanan_darah): ?>
                                        <?php
                                            $td = intval(explode('/', $lansia->pemeriksaan_terakhir->tekanan_darah)[0] ?? 0);
                                            $tdClass = $td >= 140 ? 'bg-rose-50 text-rose-700 border-rose-200 shadow-sm' : 'bg-emerald-50 text-emerald-700 border-emerald-200 shadow-sm';
                                        ?>
                                        <span class="px-2.5 py-1 rounded-md border <?php echo e($tdClass); ?>">TD: <?php echo e($lansia->pemeriksaan_terakhir->tekanan_darah); ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <span class="text-[11px] text-slate-400 font-bold italic border border-slate-200 px-3 py-1 rounded-lg bg-slate-50">Belum ada riwayat</span>
                            <?php endif; ?>
                        </td>

                        <td class="px-6 py-4 align-top max-w-[280px]">
                            <?php if($lansia->pemeriksaan_terakhir && $lansia->pemeriksaan_terakhir->diagnosa): ?>
                                <p class="text-[12px] font-bold text-slate-700 line-clamp-2 leading-relaxed" title="<?php echo e($lansia->pemeriksaan_terakhir->diagnosa); ?>">
                                    <?php echo e($lansia->pemeriksaan_terakhir->diagnosa); ?>

                                </p>
                            <?php else: ?>
                                <span class="text-xs text-slate-400">-</span>
                            <?php endif; ?>
                        </td>

                        <td class="px-6 py-4 text-right">
                            <a href="<?php echo e(route('bidan.rekam-medis.show', ['pasien_type' => 'lansia', 'pasien_id' => $lansia->id])); ?>" class="smooth-route inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-600 text-[12px] font-bold rounded-xl hover:bg-emerald-50 hover:text-emerald-600 hover:border-emerald-200 transition-all shadow-sm">
                                <i class="fas fa-folder-open"></i> Buku Medis
                            </a>
                        </td>

                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="text-center py-20">
                            <div class="w-20 h-20 bg-slate-50 rounded-[24px] flex items-center justify-center text-slate-300 mx-auto mb-4 text-4xl shadow-inner border border-slate-100"><i class="fas fa-search"></i></div>
                            <h4 class="font-black text-slate-700 text-[15px] font-poppins">Data Tidak Ditemukan</h4>
                            <p class="text-[13px] text-slate-500 mt-1 font-medium">Pastikan kata kunci atau filter status tensi yang Anda pilih sudah benar.</p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <?php if($lansias->hasPages()): ?>
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 pagination-wrapper">
            <?php echo e($lansias->links()); ?>

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
    document.querySelectorAll('.auto-submit').forEach(select => {
        select.addEventListener('change', function() {
            showLoader(); document.getElementById('filterForm').submit();
        });
    });
    document.getElementById('filterForm').addEventListener('submit', showLoader);
    document.querySelectorAll('.smooth-route, .pagination-wrapper a').forEach(link => {
        link.addEventListener('click', function(e) {
            if(!this.classList.contains('target-blank') && this.target !== '_blank' && !e.ctrlKey) showLoader();
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.bidan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\POSYANDU\posyandu-management-system\resources\views/bidan/pasien/lansia.blade.php ENDPATH**/ ?>