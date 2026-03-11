

<?php $__env->startSection('title', 'Ruang Konseling'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="animate-fade-in pb-6">

    <div class="flex items-center gap-4 mb-6">
        <div class="w-12 h-12 rounded-[14px] bg-gradient-to-br from-sky-500 to-teal-500 text-white flex items-center justify-center text-xl shadow-lg shrink-0">
            <i class="fas fa-comments"></i>
        </div>
        <div>
            <h1 class="text-xl font-black text-slate-800 font-poppins leading-tight">Ruang Konseling <?php echo e($kategori ? "· $kategori" : ""); ?></h1>
            <p class="text-xs font-medium text-slate-500 mt-0.5">Konsultasi pribadi dengan Bidan & Kader.</p>
        </div>
    </div>

    <?php if($profil): ?>

    <div class="bg-white border border-teal-50 rounded-[24px] shadow-[0_8px_30px_rgba(13,148,136,0.06)] flex flex-col overflow-hidden h-[calc(100vh-220px)] min-h-[400px]">
        
        <div class="p-4 bg-gradient-to-r from-sky-500 to-teal-500 flex items-center justify-between shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white/20 border border-white/30 text-white flex items-center justify-center text-lg shrink-0">
                    <i class="fas fa-user-nurse"></i>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-white font-poppins leading-none mb-1">Tenaga Medis Posyandu</h2>
                    <div class="flex items-center gap-1.5 text-[10px] text-teal-50 font-medium">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 shadow-[0_0_6px_rgba(52,211,153,0.8)] animate-pulse"></span>
                        Siap merespons
                    </div>
                </div>
            </div>
            <span class="px-3 py-1 bg-white/20 border border-white/30 rounded-full text-white text-[10px] font-bold">
                <?php echo e($riwayatKonseling->count()); ?> Sesi
            </span>
        </div>

        <div class="flex-1 overflow-y-auto p-4 sm:p-6 bg-slate-50 flex flex-col gap-6 custom-scrollbar" id="ksChatBody">
            
            <?php $__empty_1 = true; $__currentLoopData = $riwayatKonseling; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $konsel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                
                <div class="text-center my-1">
                    <span class="px-4 py-1 bg-teal-100/50 text-teal-700 text-[10px] font-bold rounded-full border border-teal-100">
                        <?php echo e(\Carbon\Carbon::parse($konsel->tanggal_konseling)->translatedFormat('d F Y')); ?>

                    </span>
                </div>

                <div class="flex flex-col gap-3">
                    
                    <div class="flex items-end gap-3 w-full sm:w-4/5">
                        <div class="w-8 h-8 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center text-xs font-bold shrink-0 mb-1">
                            <?php echo e(strtoupper(substr(auth()->user()->name ?? 'U', 0, 1))); ?>

                        </div>
                        <div class="flex flex-col items-start w-full">
                            <span class="text-[10px] font-bold text-slate-400 mb-1 ml-1"><?php echo e(auth()->user()->name ?? 'Anda'); ?></span>
                            <div class="bg-white border border-slate-200 rounded-2xl rounded-bl-sm p-3.5 shadow-sm w-full">
                                <div class="flex items-center gap-1.5 text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">
                                    <i class="fas fa-comment-medical text-sky-500"></i> Keluhan
                                </div>
                                <p class="text-sm text-slate-700 leading-relaxed"><?php echo e($konsel->keluhan); ?></p>
                            </div>
                            <span class="text-[9px] font-medium text-slate-400 mt-1 ml-1"><?php echo e(\Carbon\Carbon::parse($konsel->tanggal_konseling)->format('H:i')); ?></span>
                        </div>
                    </div>

                    <?php if($konsel->saran): ?>
                    <div class="flex items-end gap-3 w-full sm:w-4/5 self-end flex-row-reverse">
                        <div class="w-8 h-8 rounded-full bg-teal-100 text-teal-600 flex items-center justify-center text-xs shrink-0 mb-1">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <div class="flex flex-col items-end w-full">
                            <span class="text-[10px] font-bold text-slate-400 mb-1 mr-1">Bidan / Kader</span>
                            <div class="bg-gradient-to-br from-teal-50 to-emerald-50 border border-teal-200 rounded-2xl rounded-br-sm p-3.5 shadow-sm w-full">
                                <div class="flex items-center gap-1.5 text-[9px] font-black text-teal-600 uppercase tracking-widest mb-2">
                                    <i class="fas fa-stethoscope text-teal-500"></i> Saran Medis
                                </div>
                                <p class="text-sm text-teal-900 leading-relaxed"><?php echo e($konsel->saran); ?></p>
                            </div>
                            <div class="flex items-center gap-1 mt-1 mr-1">
                                <span class="text-[9px] font-medium text-slate-400"><?php echo e(\Carbon\Carbon::parse($konsel->tanggal_konseling)->format('H:i')); ?></span>
                                <i class="fas fa-check-double text-teal-500 text-[10px]"></i>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="flex items-center gap-2 pl-12">
                        <span class="w-1.5 h-1.5 bg-amber-400 rounded-full animate-ping"></span>
                        <span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded border border-amber-100">Menunggu balasan petugas...</span>
                    </div>
                    <?php endif; ?>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="flex-1 flex flex-col items-center justify-center text-center px-4">
                    <div class="w-16 h-16 bg-teal-50 text-teal-300 rounded-full flex items-center justify-center text-3xl mb-4 border-2 border-teal-100">
                        <i class="far fa-comments"></i>
                    </div>
                    <h3 class="text-sm font-black text-slate-700 font-poppins mb-1">Mulai Konsultasi</h3>
                    <p class="text-xs text-slate-500 max-w-xs">Punya pertanyaan seputar kesehatan? Jangan ragu sampaikan keluhan Anda, Bidan siap membantu.</p>
                </div>
            <?php endif; ?>
            
        </div>

        <div class="p-4 bg-white border-t border-slate-100 shrink-0">
            <form action="<?php echo e(route('user.konseling.store')); ?>" method="POST" class="flex gap-3 items-end">
                <?php echo csrf_field(); ?>
                <div class="flex-1 relative">
                    <textarea 
                        name="keluhan" 
                        rows="2" 
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3 px-4 text-sm text-slate-800 outline-none focus:bg-white focus:border-teal-400 focus:ring-4 focus:ring-teal-400/10 transition-all resize-none custom-scrollbar" 
                        placeholder="Ketik keluhan kesehatan Anda di sini..." 
                        required
                    ><?php echo e(old('keluhan')); ?></textarea>
                </div>
                <button type="submit" class="w-12 h-12 rounded-full bg-gradient-to-tr from-sky-500 to-teal-500 text-white flex items-center justify-center shadow-md hover:shadow-lg hover:scale-105 transition-all shrink-0 mb-0.5">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>

    </div>

    <?php else: ?>
    <div class="bg-white border border-slate-100 rounded-3xl p-8 text-center shadow-sm">
        <div class="w-16 h-16 bg-amber-50 text-amber-500 rounded-full flex items-center justify-center text-3xl mb-4 mx-auto border-2 border-amber-100">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h3 class="text-base font-black text-slate-800 font-poppins mb-2">Akses Terkunci</h3>
        <p class="text-xs text-slate-500 max-w-sm mx-auto mb-4">Data profil Anda belum terhubung. Hubungi Kader untuk pendaftaran NIK agar dapat menggunakan layanan ini.</p>
        <a href="<?php echo e(route('user.profile.edit')); ?>" class="inline-block px-5 py-2.5 bg-slate-800 text-white text-xs font-bold rounded-xl hover:bg-slate-900 transition-colors">Lengkapi Profil</a>
    </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Auto scroll ke pesan paling bawah saat halaman dibuka
    const chatBody = document.getElementById('ksChatBody');
    if (chatBody) chatBody.scrollTop = chatBody.scrollHeight;
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\POSYANDU\posyandu-management-system\resources\views/user/konseling/index.blade.php ENDPATH**/ ?>