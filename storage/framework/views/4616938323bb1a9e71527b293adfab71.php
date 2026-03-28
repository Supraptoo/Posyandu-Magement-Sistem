
<?php $__env->startSection('title', 'Edit Imunisasi'); ?>
<?php $__env->startSection('page-name', 'Edit Imunisasi'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .animate-slide-up { opacity: 0; animation: slideUpFade 0.4s ease-out forwards; }
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div id="smoothLoader" class="fixed inset-0 bg-slate-50/90 backdrop-blur-md z-[9999] flex flex-col items-center justify-center transition-all duration-300 opacity-100">
    <div class="relative w-20 h-20 flex items-center justify-center mb-4">
        <div class="absolute inset-0 border-4 border-amber-100 rounded-full"></div>
        <div class="absolute inset-0 border-4 border-amber-500 rounded-full border-t-transparent animate-spin"></div>
        <i class="fas fa-edit text-amber-500 text-2xl animate-pulse"></i>
    </div>
    <p class="text-amber-800 font-black font-poppins tracking-widest text-[11px] animate-pulse uppercase" id="loaderText">MEMUAT FORMULIR...</p>
</div>

<div class="max-w-4xl mx-auto animate-slide-up">

    <div class="mb-6">
        <a href="<?php echo e(route('bidan.imunisasi.index')); ?>" class="smooth-route inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-600 font-bold text-[13px] rounded-xl hover:bg-slate-50 transition-colors shadow-sm">
            <i class="fas fa-arrow-left"></i> Kembali ke Register
        </a>
    </div>

    <div class="bg-gradient-to-br from-amber-400 to-orange-500 rounded-[32px] p-8 md:p-10 mb-8 relative overflow-hidden shadow-lg border border-amber-300 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="absolute inset-0 opacity-20 pointer-events-none" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 24px 24px;"></div>
        <div class="relative z-10 w-full md:w-auto text-center md:text-left">
            <h2 class="text-2xl md:text-3xl font-black text-white font-poppins tracking-tight mb-2">Edit Data Vaksin</h2>
            <p class="text-amber-50 text-sm font-medium max-w-md mx-auto md:mx-0">Lakukan koreksi jika terdapat kesalahan ketik pada data sebelumnya. Perubahan otomatis tersinkronisasi.</p>
        </div>
        <div class="w-20 h-20 rounded-3xl bg-white/20 backdrop-blur border border-white/30 text-white flex items-center justify-center text-4xl shrink-0 shadow-sm relative z-10">
            <i class="fas fa-pen"></i>
        </div>
    </div>

    <form action="<?php echo e(route('bidan.imunisasi.update', $imunisasi->id)); ?>" method="POST" id="imunisasiForm">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        
        <div class="bg-white rounded-[32px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.03)] overflow-hidden mb-8">
            <div class="px-8 py-5 border-b border-slate-100 bg-slate-50/50 flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center"><i class="fas fa-file-medical-alt"></i></div>
                <h3 class="font-black text-slate-800 text-[15px]">Koreksi Detail Imunisasi</h3>
            </div>
            
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-2">Pasien Terkait <span class="text-rose-500">*</span></label>
                        <select name="kunjungan_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 text-[13px] font-bold text-slate-700 focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 outline-none transition-all cursor-pointer">
                            <?php $__currentLoopData = $kunjungans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($k->id); ?>" <?php echo e($imunisasi->kunjungan_id == $k->id ? 'selected' : ''); ?>>
                                    <?php echo e(\Carbon\Carbon::parse($k->tanggal_kunjungan)->format('d M Y')); ?> — <?php echo e($k->pasien->nama_lengkap ?? 'Unknown'); ?> (<?php echo e(class_basename($k->pasien_type)); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-2">Nama Vaksin <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <i class="fas fa-vial absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" name="vaksin" value="<?php echo e($imunisasi->vaksin); ?>" required class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-11 pr-4 py-3.5 text-[13px] font-medium text-slate-800 focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 outline-none transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-2">Kategori Imunisasi <span class="text-rose-500">*</span></label>
                        <select name="jenis_imunisasi" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 text-[13px] font-bold text-slate-700 focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 outline-none transition-all cursor-pointer">
                            <option value="Dasar" <?php echo e($imunisasi->jenis_imunisasi == 'Dasar' ? 'selected' : ''); ?>>🟢 Imunisasi Dasar</option>
                            <option value="Lanjutan" <?php echo e($imunisasi->jenis_imunisasi == 'Lanjutan' ? 'selected' : ''); ?>>🔵 Imunisasi Lanjutan</option>
                            <option value="Tambahan" <?php echo e($imunisasi->jenis_imunisasi == 'Tambahan' ? 'selected' : ''); ?>>🟣 Tambahan (Booster)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-2">Dosis Vaksin <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <i class="fas fa-eye-dropper absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" name="dosis" value="<?php echo e($imunisasi->dosis); ?>" required class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-11 pr-4 py-3.5 text-[13px] font-medium text-slate-800 focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 outline-none transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-2">Tanggal Eksekusi <span class="text-rose-500">*</span></label>
                        <input type="date" name="tanggal_imunisasi" value="<?php echo e(\Carbon\Carbon::parse($imunisasi->tanggal_imunisasi)->format('Y-m-d')); ?>" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 text-[13px] font-bold text-slate-800 focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 outline-none transition-all cursor-pointer">
                    </div>

                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pb-10">
            <button type="submit" id="btnSubmit" class="w-full sm:w-auto px-8 py-4 rounded-xl font-black text-white bg-amber-500 hover:bg-amber-600 shadow-[0_8px_20px_rgba(245,158,11,0.3)] hover:-translate-y-0.5 transition-all duration-300 uppercase tracking-wide flex items-center justify-center gap-2">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    const showLoader = (text = 'MEMUAT SISTEM...') => {
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
        const btn = document.getElementById('btnSubmit');
        if(btn) {
            btn.innerHTML = '<i class="fas fa-save"></i> Simpan Perubahan';
            btn.classList.remove('opacity-75', 'cursor-wait');
        }
    });

    document.querySelectorAll('.smooth-route').forEach(link => {
        link.addEventListener('click', function(e) {
            if(this.target !== '_blank' && !e.ctrlKey) showLoader('MEMUAT HALAMAN...');
        });
    });

    document.getElementById('imunisasiForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmit');
        btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Menyimpan...';
        btn.classList.add('opacity-75', 'cursor-wait');
        showLoader('MENYIMPAN KOREKSI DATA...');
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.bidan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\POSYANDU\posyandu-management-system\resources\views/bidan/imunisasi/edit.blade.php ENDPATH**/ ?>