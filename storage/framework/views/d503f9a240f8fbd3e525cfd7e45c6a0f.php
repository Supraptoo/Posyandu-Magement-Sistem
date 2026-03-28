

<?php $__env->startSection('title', 'Riwayat Import'); ?>
<?php $__env->startSection('page-name', 'Log & History'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .animate-slide-up { opacity: 0; animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .custom-scrollbar::-webkit-scrollbar { height: 8px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-[1400px] mx-auto animate-slide-up">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-8">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 rounded-[20px] bg-gradient-to-br from-indigo-500 to-violet-600 text-white flex items-center justify-center text-2xl shadow-[0_8px_20px_rgba(79,70,229,0.3)] shrink-0">
                <i class="fas fa-history"></i>
            </div>
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight font-poppins">Log Aktivitas Import</h1>
                <p class="text-slate-500 mt-1 font-medium text-[14px]">Pantau riwayat migrasi data Excel ke dalam server. Secara default menampilkan data hari ini.</p>
            </div>
        </div>
        <a href="<?php echo e(route('kader.import.create')); ?>" class="smooth-route inline-flex items-center justify-center gap-2 px-8 py-4 bg-indigo-600 text-white font-black text-[13px] rounded-2xl hover:bg-indigo-700 shadow-[0_4px_15px_rgba(79,70,229,0.3)] hover:-translate-y-1 transition-all uppercase tracking-widest w-full sm:w-auto shrink-0">
            <i class="fas fa-plus"></i> Import Baru
        </a>
    </div>

    <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_4px_20px_rgba(0,0,0,0.02)] p-4 sm:p-5 mb-8 flex flex-col sm:flex-row items-center gap-4">
        <form action="<?php echo e(route('kader.import.history')); ?>" method="GET" class="w-full flex flex-col sm:flex-row items-center gap-4">
            <div class="w-full sm:w-1/2 relative">
                <i class="fas fa-calendar-alt absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                <input type="date" name="tanggal" value="<?php echo e($tanggal ?? date('Y-m-d')); ?>" class="w-full bg-slate-50 border-2 border-slate-100 text-slate-800 text-[14px] rounded-xl pl-12 pr-4 py-3.5 outline-none font-bold focus:border-indigo-500 focus:bg-white transition-colors cursor-pointer shadow-sm">
            </div>
            
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto px-8 py-3.5 bg-slate-800 text-white font-black text-[13px] rounded-xl hover:bg-slate-900 transition-colors flex items-center justify-center gap-2 shadow-sm uppercase tracking-widest">
                    <i class="fas fa-filter"></i> Terapkan
                </button>
                <a href="<?php echo e(route('kader.import.history')); ?>" class="w-full sm:w-auto px-6 py-3.5 bg-slate-100 text-slate-600 border border-slate-200 font-black text-[13px] rounded-xl hover:bg-slate-200 hover:text-slate-800 transition-colors flex items-center justify-center gap-2 shadow-sm text-center uppercase tracking-widest smooth-route">
                    <i class="fas fa-sync-alt"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-[32px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.03)] overflow-hidden">
        
        <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/80">
            <h3 class="text-lg font-black text-slate-800 font-poppins">
                <i class="fas fa-list-ul text-indigo-500 mr-2"></i> Hasil Pencarian: <span class="text-indigo-600 border-b-2 border-indigo-200"><?php echo e(\Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y')); ?></span>
            </h3>
        </div>

        <?php if($imports->count() > 0): ?>
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse min-w-[1000px]">
                <thead>
                    <tr class="bg-white border-b border-slate-100">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Waktu Proses</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama File & Modul</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Visualisasi Hasil</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php $__currentLoopData = $imports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $import): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-indigo-50/40 transition-colors group">
                        
                        <td class="px-8 py-5 align-middle">
                            <p class="font-black text-slate-800 text-[14px]"><?php echo e($import->created_at->format('d M Y')); ?></p>
                            <p class="text-[11px] font-bold text-slate-400 mt-1 flex items-center gap-1.5"><i class="fas fa-clock"></i> <?php echo e($import->created_at->format('H:i:s')); ?></p>
                        </td>

                        <td class="px-8 py-5 align-middle">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl shrink-0 border border-emerald-100"><i class="fas fa-file-excel"></i></div>
                                <div>
                                    <p class="font-bold text-slate-700 text-[13px] mb-1.5 truncate max-w-[250px]" title="<?php echo e($import->nama_file); ?>"><?php echo e($import->nama_file); ?></p>
                                    <?php if($import->jenis_data == 'balita'): ?> <span class="px-2.5 py-1 bg-rose-100 text-rose-700 text-[9px] font-black rounded-md uppercase tracking-widest border border-rose-200 shadow-sm">Modul Balita</span>
                                    <?php elseif($import->jenis_data == 'remaja'): ?> <span class="px-2.5 py-1 bg-sky-100 text-sky-700 text-[9px] font-black rounded-md uppercase tracking-widest border border-sky-200 shadow-sm">Modul Remaja</span>
                                    <?php else: ?> <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 text-[9px] font-black rounded-md uppercase tracking-widest border border-emerald-200 shadow-sm">Modul Lansia</span> <?php endif; ?>
                                </div>
                            </div>
                        </td>

                        <td class="px-8 py-5 text-center align-middle">
                            <?php if($import->status == 'completed'): ?>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-600 text-[11px] font-black border border-emerald-100 shadow-sm"><i class="fas fa-check-circle"></i> Selesai</span>
                            <?php elseif($import->status == 'processing'): ?>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-50 text-amber-600 text-[11px] font-black border border-amber-100 shadow-sm animate-pulse"><i class="fas fa-sync fa-spin"></i> Proses</span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-rose-50 text-rose-600 text-[11px] font-black border border-rose-100 shadow-sm"><i class="fas fa-times-circle"></i> Gagal</span>
                            <?php endif; ?>
                        </td>

                        <td class="px-8 py-5 align-middle w-[250px]">
                            <?php
                                $total = $import->total_data > 0 ? $import->total_data : 1; // avoid div by zero
                                $berhasil = $import->data_berhasil ?? 0;
                                $gagal = $import->data_gagal ?? 0;
                                $pBerhasil = ($berhasil / $total) * 100;
                                $pGagal = ($gagal / $total) * 100;
                            ?>
                            
                            <div class="flex items-center justify-between text-[10px] font-black uppercase tracking-widest mb-1.5">
                                <span class="text-emerald-600"><i class="fas fa-check"></i> <?php echo e($berhasil); ?></span>
                                <span class="text-slate-400">TOTAL: <?php echo e($import->total_data ?? '-'); ?></span>
                                <span class="text-rose-500"><?php echo e($gagal); ?> <i class="fas fa-times"></i></span>
                            </div>
                            
                            <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden flex">
                                <?php if($import->status == 'completed' || $import->status == 'failed'): ?>
                                    <div class="h-full bg-emerald-500" style="width: <?php echo e($pBerhasil); ?>%"></div>
                                    <div class="h-full bg-rose-500" style="width: <?php echo e($pGagal); ?>%"></div>
                                <?php else: ?>
                                    <div class="h-full w-full bg-slate-300 animate-pulse"></div>
                                <?php endif; ?>
                            </div>
                        </td>

                        <td class="px-8 py-5 text-right align-middle">
                            <div class="flex items-center justify-end gap-3">
                                <a href="<?php echo e(route('kader.import.show', $import->id)); ?>" title="Laporan Detail" class="smooth-route inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-white border border-slate-200 text-indigo-600 font-bold text-[11px] hover:bg-indigo-50 hover:border-indigo-200 shadow-sm transition-all uppercase tracking-widest">
                                    <i class="fas fa-search"></i> Detail
                                </a>
                                
                                <form action="<?php echo e(route('kader.import.destroy', $import->id)); ?>" method="POST" class="m-0" onsubmit="return confirm('PERINGATAN: Menghapus log ini akan menghapus file fisik Excel Anda dari server selamanya. Anda yakin?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" title="Hapus Berkas" class="inline-flex w-9 h-9 rounded-xl bg-white border border-slate-200 items-center justify-center text-slate-400 hover:text-white hover:bg-rose-500 hover:border-rose-500 shadow-sm transition-all">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        
        <div class="px-8 py-5 border-t border-slate-100 bg-slate-50/50">
            <?php echo e($imports->links()); ?>

        </div>

        <?php else: ?>
        <div class="text-center py-24 relative overflow-hidden">
            <div class="absolute inset-0 flex items-center justify-center opacity-[0.03] text-[250px] pointer-events-none"><i class="fas fa-box-open"></i></div>
            <div class="w-24 h-24 bg-white rounded-3xl flex items-center justify-center text-slate-300 mx-auto mb-6 text-4xl shadow-sm border border-slate-100 relative z-10"><i class="fas fa-calendar-times"></i></div>
            <h4 class="text-xl font-black text-slate-800 font-poppins relative z-10">Buku Log Kosong</h4>
            <p class="text-[14px] text-slate-500 mt-2 font-medium max-w-sm mx-auto relative z-10">Tidak ada riwayat upload yang tercatat pada tanggal yang Anda pilih.</p>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.kader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\POSYANDU\posyandu-management-system\resources\views/kader/import/history.blade.php ENDPATH**/ ?>