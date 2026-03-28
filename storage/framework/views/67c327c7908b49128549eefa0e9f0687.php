

<?php $__env->startSection('title', 'Validasi Pemeriksaan'); ?>
<?php $__env->startSection('page-name', 'Riwayat & Validasi'); ?>

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
        <i class="fas fa-stethoscope text-cyan-500 text-2xl animate-pulse"></i>
    </div>
    <p class="text-cyan-800 font-black font-poppins tracking-widest text-[11px] animate-pulse uppercase">Memuat Antrian...</p>
</div>

<div class="max-w-7xl mx-auto animate-slide-up">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-5 mb-8">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-cyan-400 to-sky-500 text-white flex items-center justify-center text-2xl shadow-[0_8px_15px_rgba(6,182,212,0.3)]">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-800 tracking-tight font-poppins">Validasi Medis</h1>
                <p class="text-slate-500 mt-1 font-medium text-[13px]">Periksa data ukur dari Kader dan berikan diagnosa klinis.</p>
            </div>
        </div>
        <a href="<?php echo e(route('bidan.pemeriksaan.create')); ?>" class="smooth-route inline-flex items-center justify-center gap-2 px-6 py-3 bg-white border border-slate-200 text-slate-700 font-bold text-[13px] rounded-xl hover:bg-slate-50 transition-all shadow-sm hover:shadow">
            <i class="fas fa-plus text-cyan-500"></i> Input Manual
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
        <div class="bg-white p-5 rounded-[24px] border border-slate-200/80 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex items-center justify-between relative overflow-hidden">
            <div class="absolute right-0 top-0 w-24 h-24 bg-amber-500/10 rounded-bl-[100px] pointer-events-none"></div>
            <div>
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1">Antrian Validasi</p>
                <h3 class="text-3xl font-black text-amber-500 font-poppins"><?php echo e($stats['pending'] ?? 0); ?> <span class="text-xs font-bold text-slate-500 ml-1">Pasien</span></h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center text-xl relative z-10"><i class="fas fa-hourglass-half"></i></div>
        </div>
        <div class="bg-white p-5 rounded-[24px] border border-slate-200/80 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex items-center justify-between relative overflow-hidden">
            <div class="absolute right-0 top-0 w-24 h-24 bg-emerald-500/10 rounded-bl-[100px] pointer-events-none"></div>
            <div>
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1">Telah Diverifikasi</p>
                <h3 class="text-3xl font-black text-emerald-500 font-poppins"><?php echo e($stats['verified'] ?? 0); ?> <span class="text-xs font-bold text-slate-500 ml-1">Data</span></h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl relative z-10"><i class="fas fa-check-double"></i></div>
        </div>
        <div class="bg-white p-5 rounded-[24px] border border-slate-200/80 shadow-[0_4px_20px_rgba(0,0,0,0.02)] flex items-center justify-between relative overflow-hidden">
            <div class="absolute right-0 top-0 w-24 h-24 bg-cyan-500/10 rounded-bl-[100px] pointer-events-none"></div>
            <div>
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Pemeriksaan</p>
                <h3 class="text-3xl font-black text-cyan-600 font-poppins"><?php echo e($stats['total'] ?? 0); ?> <span class="text-xs font-bold text-slate-500 ml-1">Data</span></h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-cyan-50 text-cyan-500 flex items-center justify-center text-xl relative z-10"><i class="fas fa-notes-medical"></i></div>
        </div>
    </div>

    <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.03)] overflow-hidden">
        
        <div class="p-5 border-b border-slate-100 bg-slate-50/50">
            <form id="filterForm" action="<?php echo e(route('bidan.pemeriksaan.index')); ?>" method="GET" class="flex flex-wrap md:flex-nowrap gap-3">
                <div class="w-full md:w-2/5 relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nama pasien (Tekan Enter)..." class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-[13px] font-medium focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-500 outline-none transition-all shadow-sm">
                </div>
                <div class="w-full md:w-1/4">
                    <select name="kategori" class="auto-submit w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-[13px] font-bold text-slate-600 focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-500 outline-none cursor-pointer shadow-sm">
                        <option value="">Semua Kategori</option>
                        <option value="balita" <?php echo e(request('kategori') == 'balita' ? 'selected' : ''); ?>>👶 Balita</option>
                        <option value="remaja" <?php echo e(request('kategori') == 'remaja' ? 'selected' : ''); ?>>🧑‍🎓 Remaja</option>
                        <option value="lansia" <?php echo e(request('kategori') == 'lansia' ? 'selected' : ''); ?>>🧓 Lansia</option>
                    </select>
                </div>
                <div class="w-full md:w-1/4">
                    <select name="status" class="auto-submit w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-[13px] font-bold text-slate-600 focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-500 outline-none cursor-pointer shadow-sm">
                        <option value="">Semua Status</option>
                        <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>⏳ Menunggu Validasi</option>
                        <option value="verified" <?php echo e(request('status') == 'verified' ? 'selected' : ''); ?>>✅ Diverifikasi</option>
                        <option value="rejected" <?php echo e(request('status') == 'rejected' ? 'selected' : ''); ?>>❌ Ditolak</option>
                    </select>
                </div>
                <div class="w-full md:w-auto flex justify-end">
                    <?php if(request()->anyFilled(['search', 'kategori', 'status', 'bulan'])): ?>
                        <a href="<?php echo e(route('bidan.pemeriksaan.index')); ?>" class="smooth-route flex items-center justify-center px-4 py-3 bg-rose-50 text-rose-600 font-bold text-[13px] rounded-xl hover:bg-rose-100 transition-colors" title="Reset Filter">
                            <i class="fas fa-undo mr-1.5"></i> Reset
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse min-w-[1000px]">
                <thead>
                    <tr class="bg-white border-b border-slate-100">
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Waktu</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Identitas Pasien</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Hasil Ukur (Kader)</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php $__empty_1 = true; $__currentLoopData = $riwayat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        
                        <td class="px-6 py-4 align-middle">
                            <p class="font-bold text-slate-800 text-[13px]"><?php echo e(\Carbon\Carbon::parse($item->tanggal_periksa)->format('d M Y')); ?></p>
                            <p class="text-[11px] font-bold text-slate-400 mt-0.5"><i class="fas fa-clock mr-1"></i> <?php echo e($item->created_at->format('H:i')); ?> WIB</p>
                        </td>

                        <td class="px-6 py-4 align-middle">
                            <div class="flex items-center gap-3">
                                <?php
                                    $iconKat = $item->kategori_pasien == 'balita' ? 'baby' : ($item->kategori_pasien == 'remaja' ? 'user-graduate' : 'wheelchair');
                                    $colKat = $item->kategori_pasien == 'balita' ? 'rose' : ($item->kategori_pasien == 'remaja' ? 'indigo' : 'emerald');
                                ?>
                                <div class="w-10 h-10 rounded-full bg-<?php echo e($colKat); ?>-50 text-<?php echo e($colKat); ?>-500 flex items-center justify-center shrink-0 border border-<?php echo e($colKat); ?>-100">
                                    <i class="fas fa-<?php echo e($iconKat); ?>"></i>
                                </div>
                                <div>
                                    <p class="font-extrabold text-slate-700 text-[14px] mb-0.5 truncate max-w-[200px]">
                                        <?php echo e($item->nama_pasien ?? ($item->balita->nama_lengkap ?? ($item->remaja->nama_lengkap ?? ($item->lansia->nama_lengkap ?? '-')))); ?>

                                    </p>
                                    <span class="text-[10px] font-black text-<?php echo e($colKat); ?>-500 uppercase tracking-wider"><?php echo e($item->kategori_pasien); ?></span>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 align-middle">
                            <div class="flex flex-wrap gap-2 text-[11px] font-semibold">
                                <span class="px-2.5 py-1 bg-white text-slate-600 rounded-lg border border-slate-200 shadow-sm">BB: <span class="font-black text-slate-800"><?php echo e($item->berat_badan ?? '-'); ?> kg</span></span>
                                <span class="px-2.5 py-1 bg-white text-slate-600 rounded-lg border border-slate-200 shadow-sm">TB: <span class="font-black text-slate-800"><?php echo e($item->tinggi_badan ?? '-'); ?> cm</span></span>
                                <?php if($item->tekanan_darah): ?>
                                    <span class="px-2.5 py-1 <?php echo e(intval(explode('/', $item->tekanan_darah)[0]) >= 140 ? 'bg-rose-50 text-rose-700 border-rose-200' : 'bg-white text-slate-600 border-slate-200'); ?> rounded-lg border shadow-sm">
                                        TD: <span class="font-black"><?php echo e($item->tekanan_darah); ?></span>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </td>

                        <td class="px-6 py-4 text-center align-middle">
                            <div class="flex items-center justify-center gap-2 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity">
                                
                                

                                <form action="<?php echo e(route('bidan.pemeriksaan.destroy', $item->id)); ?>" method="POST" class="m-0" onsubmit="return confirm('Yakin ingin menghapus data pemeriksaan ini secara permanen?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="flex items-center justify-center w-9 h-9 bg-white border border-slate-200 text-slate-400 rounded-xl hover:text-rose-600 hover:border-rose-300 hover:bg-rose-50 shadow-sm transition-colors" title="Hapus Data">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                              

                        <td class="px-6 py-4 text-center align-middle">
                            <?php if($item->status_verifikasi == 'pending'): ?>
                                <a href="<?php echo e(route('bidan.pemeriksaan.show', $item->id)); ?>" class="smooth-route inline-flex items-center gap-2 px-4 py-2 bg-cyan-500 text-white text-[11px] font-bold rounded-xl hover:bg-cyan-600 shadow-[0_4px_10px_rgba(6,182,212,0.3)] transition-all transform hover:-translate-y-0.5">
                                    <i class="fas fa-stethoscope"></i> Validasi
                                </a>
                            <?php else: ?>
                                <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="<?php echo e(route('bidan.pemeriksaan.show', $item->id)); ?>" class="smooth-route inline-flex items-center gap-2 w-9 h-9 justify-center bg-white border border-slate-200 text-slate-400 text-xs font-bold rounded-xl hover:text-cyan-600 hover:border-cyan-300 hover:bg-cyan-50 transition-colors shadow-sm" title="Lihat Detail">
                                        <i class="fas fa-file-medical"></i>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </td>

                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center py-20">
                            <div class="w-20 h-20 bg-slate-50 rounded-[20px] flex items-center justify-center text-slate-300 mx-auto mb-4 text-4xl shadow-inner border border-slate-100"><i class="fas fa-inbox"></i></div>
                            <h4 class="font-black text-slate-700 text-[15px] font-poppins">Antrian Kosong</h4>
                            <p class="text-[13px] font-medium text-slate-500 mt-1">Belum ada data pemeriksaan yang menunggu validasi.</p>
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
            showLoader();
            document.getElementById('filterForm').submit();
        });
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
<?php echo $__env->make('layouts.bidan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\POSYANDU\posyandu-management-system\resources\views/bidan/pemeriksaan/index.blade.php ENDPATH**/ ?>