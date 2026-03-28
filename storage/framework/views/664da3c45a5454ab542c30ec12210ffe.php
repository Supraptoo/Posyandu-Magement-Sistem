

<?php $__env->startSection('title', 'Data Balita'); ?>
<?php $__env->startSection('page-name', 'Database Balita'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .animate-slide-up { opacity: 0; animation: slideUpFade 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    
    .search-glass { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(12px); }
    .fast-spin { animation: spin 0.6s linear infinite; }
    @keyframes spin { 100% { transform: rotate(360deg); } }

    .custom-scrollbar::-webkit-scrollbar { height: 6px; width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-[1400px] mx-auto animate-slide-up">

    <div class="bg-gradient-to-br from-indigo-500 to-violet-600 rounded-[32px] p-8 md:p-10 mb-8 relative overflow-hidden shadow-[0_12px_30px_rgba(79,70,229,0.2)] flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="absolute inset-0 opacity-20 pointer-events-none" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 24px 24px;"></div>
        <div class="absolute -right-10 -bottom-10 opacity-10 text-[120px] pointer-events-none"><i class="fas fa-baby"></i></div>
        
        <div class="relative z-10 flex items-center gap-6 w-full md:w-auto">
            <div class="w-20 h-20 rounded-[24px] bg-white/20 backdrop-blur border border-white/30 text-white flex items-center justify-center text-4xl shrink-0 shadow-sm transform -rotate-3 hover:rotate-0 transition-transform">
                <i class="fas fa-baby"></i>
            </div>
            <div>
                <h1 class="text-2xl md:text-3xl font-black text-white tracking-tight font-poppins">Database Balita</h1>
                <p class="text-indigo-100 mt-1 font-medium text-[13px] max-w-md">Kelola profil balita, riwayat gizi, dan sinkronisasi NIK untuk integrasi otomatis ke akun Warga Posyandu.</p>
            </div>
        </div>
        <a href="<?php echo e(route('kader.data.balita.create')); ?>" class="smooth-route relative z-10 inline-flex items-center justify-center gap-2 px-7 py-4 bg-white text-indigo-600 font-black text-[13px] rounded-2xl hover:bg-indigo-50 shadow-[0_8px_20px_rgba(0,0,0,0.1)] hover:-translate-y-1 transition-all uppercase tracking-wide w-full md:w-auto">
            <i class="fas fa-plus"></i> Daftar Baru
        </a>
    </div>

    <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_4px_20px_rgba(0,0,0,0.02)] p-4 mb-6 flex flex-col sm:flex-row gap-4 items-center justify-between relative z-20">
        <div class="relative w-full sm:w-[400px] group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i class="fas fa-search text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
            </div>
            <input type="text" id="liveSearch" value="<?php echo e($search ?? ''); ?>" placeholder="Ketik nama anak, NIK, atau ibu..." autocomplete="off"
                   class="w-full search-glass border-2 border-slate-100 text-slate-800 text-[13px] rounded-xl pl-11 pr-12 py-3.5 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-bold placeholder:font-medium placeholder:text-slate-400 shadow-sm">
            
            <div id="searchSpinner" class="absolute inset-y-0 right-0 pr-4 flex items-center opacity-0 transition-opacity duration-200">
                <i class="fas fa-circle-notch fast-spin text-indigo-500 text-lg"></i>
            </div>
        </div>
        
        <div class="flex items-center gap-2 text-[11px] font-black text-slate-400 bg-slate-50 px-4 py-2 rounded-xl border border-slate-100 uppercase tracking-widest">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Live Search Aktif
        </div>
    </div>

    <div id="ajaxTableContainer" class="relative bg-white rounded-[32px] border border-slate-200/80 shadow-[0_8px_30px_rgba(0,0,0,0.03)] overflow-hidden">
        
        <div id="tableLoader" class="absolute inset-0 bg-white/60 backdrop-blur-[2px] z-10 hidden flex-col items-center justify-center transition-all duration-200">
            <div class="px-6 py-4 bg-white border border-slate-200 shadow-2xl rounded-2xl flex items-center gap-3 transform scale-110">
                <i class="fas fa-circle-notch fast-spin text-indigo-600 text-2xl"></i>
                <span class="font-black text-slate-800 text-[13px] uppercase tracking-widest">Menyinkronkan...</span>
            </div>
        </div>

        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse min-w-[900px]">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100">
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Profil Balita</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Usia & Tgl Lahir</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Data Orang Tua</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status Akun</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php $__empty_1 = true; $__currentLoopData = $balitas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $balita): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-indigo-50/40 transition-colors group">
                        
                        <td class="px-6 py-5 align-middle">
                            <div class="flex items-center gap-4">
                                <?php $isLaki = $balita->jenis_kelamin == 'L'; ?>
                                <div class="w-12 h-12 rounded-2xl flex items-center justify-center font-black text-lg border <?php echo e($isLaki ? 'bg-sky-50 text-sky-500 border-sky-100' : 'bg-rose-50 text-rose-500 border-rose-100'); ?> shadow-sm group-hover:scale-110 transition-transform">
                                    <?php echo e(strtoupper(substr($balita->nama_lengkap, 0, 1))); ?>

                                </div>
                                <div>
                                    <p class="font-extrabold text-slate-800 text-[14px] mb-1 group-hover:text-indigo-600 transition-colors"><?php echo e($balita->nama_lengkap); ?></p>
                                    <p class="text-[10px] font-bold text-slate-400 flex items-center gap-1.5 uppercase tracking-wider">
                                        <i class="fas fa-barcode"></i> <?php echo e($balita->nik ?? 'NIK KOSONG'); ?>

                                    </p>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-5 align-middle">
                            <?php
                                $diff = \Carbon\Carbon::parse($balita->tanggal_lahir)->diff(\Carbon\Carbon::now());
                                $usia = $diff->y > 0 ? $diff->y . ' Thn ' . $diff->m . ' Bln' : $diff->m . ' Bln';
                            ?>
                            <div class="inline-flex items-center px-3 py-1 bg-slate-100 text-slate-700 text-[11px] font-black rounded-lg mb-1.5 border border-slate-200 shadow-sm">
                                <i class="fas fa-birthday-cake text-amber-500 mr-1.5"></i> <?php echo e($usia); ?>

                            </div>
                            <p class="text-[11px] font-bold text-slate-500 pl-1"><?php echo e(\Carbon\Carbon::parse($balita->tanggal_lahir)->translatedFormat('d M Y')); ?></p>
                        </td>

                        <td class="px-6 py-5 align-middle">
                            <p class="font-extrabold text-slate-700 text-[13px] mb-1 flex items-center gap-2">
                                <i class="fas fa-female text-rose-400"></i> <?php echo e($balita->nama_ibu); ?>

                            </p>
                            <p class="text-[10px] font-black text-slate-400 pl-5 uppercase tracking-wider">NIK: <?php echo e($balita->nik_ibu); ?></p>
                        </td>

                        <td class="px-6 py-5 text-center align-middle">
                            <?php if($balita->user_id): ?>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-600 text-[11px] font-black border border-emerald-100 shadow-sm">
                                    <i class="fas fa-link"></i> Terhubung
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-50 text-slate-500 text-[11px] font-black border border-slate-200 shadow-sm" title="Ibu belum membuat akun Web Warga">
                                    <i class="fas fa-unlink"></i> Putus
                                </span>
                            <?php endif; ?>
                        </td>

                        <td class="px-6 py-5 text-center align-middle">
                            <div class="flex items-center justify-center gap-2 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity">
                                <a href="<?php echo e(route('kader.data.balita.show', $balita->id)); ?>" class="flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-indigo-600 hover:border-indigo-300 hover:bg-indigo-50 shadow-sm transition-all" title="Buku Medis">
                                    <i class="fas fa-stethoscope"></i>
                                </a>
                                <a href="<?php echo e(route('kader.data.balita.edit', $balita->id)); ?>" class="smooth-route flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-amber-500 hover:border-amber-300 hover:bg-amber-50 shadow-sm transition-all" title="Edit Profil">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="<?php echo e(route('kader.data.balita.destroy', $balita->id)); ?>" method="POST" onsubmit="return confirm('Yakin hapus profil balita ini?');" class="inline-block m-0">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-rose-600 hover:border-rose-300 hover:bg-rose-50 shadow-sm transition-all" title="Hapus Data">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-24 text-center">
                            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mx-auto mb-5 text-4xl shadow-inner border border-slate-100">
                                <i class="fas fa-search"></i>
                            </div>
                            <h3 class="font-black text-slate-800 text-lg font-poppins">Data Tidak Ditemukan</h3>
                            <p class="text-[13px] font-medium text-slate-500 mt-2 max-w-sm mx-auto">Cobalah menggunakan variasi kata kunci atau periksa kembali NIK yang Anda masukkan.</p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div id="paginationArea" class="px-6 py-5 border-t border-slate-100 bg-slate-50/50">
            <?php if(isset($balitas) && $balitas->hasPages()): ?>
                <?php echo e($balitas->links()); ?>

            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('liveSearch');
        const container = document.getElementById('ajaxTableContainer');
        const spinner = document.getElementById('searchSpinner');
        const overlayLoader = document.getElementById('tableLoader');
        let debounceTimer;

        function fetchResults(url, isSearch = false) {
            // Tampilkan loader (Spinner kecil untuk ngetik, Overlay untuk pindah halaman)
            if (isSearch) spinner.classList.remove('opacity-0');
            else { overlayLoader.classList.remove('hidden'); overlayLoader.classList.add('flex'); }

            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(res => res.text())
            .then(html => {
                const doc = new DOMParser().parseFromString(html, 'text/html');
                const newTable = doc.querySelector('.custom-scrollbar');
                const newPagination = doc.getElementById('paginationArea');

                // Update isi tabel dan pagination secara instan
                if(newTable) document.querySelector('.custom-scrollbar').innerHTML = newTable.innerHTML;
                if(newPagination) document.getElementById('paginationArea').innerHTML = newPagination.innerHTML;
                
                window.history.pushState({path: url}, '', url);
                bindPagination();
            })
            .catch(error => console.error('Gagal mengambil data:', error))
            .finally(() => {
                spinner.classList.add('opacity-0');
                overlayLoader.classList.add('hidden');
                overlayLoader.classList.remove('flex');
            });
        }

        if(searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                // Cukup 300ms agar terasa secepat kilat
                debounceTimer = setTimeout(() => {
                    const url = new URL(window.location.href);
                    url.searchParams.set('search', this.value);
                    url.searchParams.delete('page');
                    fetchResults(url.toString(), true);
                }, 300); 
            });
        }

        function bindPagination() {
            document.querySelectorAll('#paginationArea a').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault(); e.stopPropagation();
                    fetchResults(this.href, false);
                });
            });
        }

        window.addEventListener('popstate', function() {
            fetchResults(window.location.href, false);
            const urlParams = new URLSearchParams(window.location.search);
            if(searchInput) searchInput.value = urlParams.get('search') || '';
        });

        bindPagination();
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.kader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\POSYANDU\posyandu-management-system\resources\views/kader/data/balita/index.blade.php ENDPATH**/ ?>