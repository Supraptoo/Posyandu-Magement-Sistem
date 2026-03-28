

<?php $__env->startSection('title', 'Import Data Masal'); ?>
<?php $__env->startSection('page-name', 'Smart Import Center'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .animate-slide-up { opacity: 0; animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    .animate-fade-in { opacity: 0; animation: fadeIn 0.8s ease-out forwards; }
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 10px 40px -10px rgba(79, 70, 229, 0.1);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .glass-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 40px -10px rgba(79, 70, 229, 0.2);
        border-color: rgba(99, 102, 241, 0.3);
    }
    
    .blob-bg {
        position: absolute; filter: blur(80px); z-index: 0; opacity: 0.4;
        animation: floatBlob 10s infinite alternate;
    }
    @keyframes floatBlob {
        0% { transform: translate(0, 0) scale(1); }
        50% { transform: translate(20px, -20px) scale(1.1); }
        100% { transform: translate(0, 0) scale(1); }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-[1200px] mx-auto relative">
    
    <div class="blob-bg bg-indigo-400 w-96 h-96 rounded-full top-0 left-10"></div>
    <div class="blob-bg bg-violet-400 w-80 h-80 rounded-full bottom-20 right-10" style="animation-delay: -5s;"></div>

    <div class="relative z-10 animate-slide-up">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div class="flex items-center gap-5">
                <div class="w-20 h-20 rounded-[28px] bg-gradient-to-br from-indigo-500 to-violet-600 text-white flex items-center justify-center text-4xl shadow-[0_10px_25px_rgba(79,70,229,0.4)] transform -rotate-6 hover:rotate-0 transition-all duration-300">
                    <i class="fas fa-database"></i>
                </div>
                <div>
                    <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight font-poppins mb-1">Smart Import Center</h1>
                    <p class="text-slate-500 font-medium text-[15px] max-w-lg leading-relaxed">Sistem cerdas untuk memindahkan ribuan data Excel atau CSV lama Anda ke dalam platform KaderCare dalam hitungan detik.</p>
                </div>
            </div>
            <a href="<?php echo e(route('kader.import.history')); ?>" class="inline-flex items-center justify-center gap-3 px-8 py-4 bg-white border border-slate-200 text-slate-700 font-black text-[13px] rounded-2xl hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 shadow-sm transition-all uppercase tracking-widest w-full md:w-auto shrink-0">
                <i class="fas fa-history text-lg"></i> Riwayat Migrasi
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            
            <div class="glass-card rounded-[32px] p-8 relative overflow-hidden group">
                <div class="absolute -right-12 -top-12 w-32 h-32 bg-rose-500/10 rounded-full blur-2xl group-hover:bg-rose-500/20 transition-all"></div>
                <div class="w-16 h-16 rounded-[20px] bg-rose-100 text-rose-600 flex items-center justify-center text-3xl mb-6 shadow-inner border border-rose-200">
                    <i class="fas fa-baby-carriage"></i>
                </div>
                <h3 class="text-2xl font-black text-slate-800 mb-2 font-poppins">Data Balita</h3>
                <p class="text-[13px] font-medium text-slate-500 mb-8 leading-relaxed">Impor data anak, riwayat lahir, dan relasikan NIK Ibu agar terhubung dengan Web Warga otomatis.</p>
                <div class="flex flex-col gap-3">
                    <a href="<?php echo e(route('kader.import.create')); ?>?type=balita" class="w-full py-3.5 bg-rose-600 text-white hover:bg-rose-700 rounded-xl text-[13px] font-black flex items-center justify-center gap-2 transition-colors shadow-[0_4px_15px_rgba(225,29,72,0.3)] uppercase tracking-wider">
                        <i class="fas fa-cloud-upload-alt"></i> Upload Berkas
                    </a>
                    <a href="<?php echo e(route('kader.import.download-template', 'balita')); ?>" class="w-full py-3 bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200 rounded-xl text-[12px] font-bold flex items-center justify-center gap-2 transition-colors">
                        <i class="fas fa-download"></i> Unduh Format CSV
                    </a>
                </div>
            </div>

            <div class="glass-card rounded-[32px] p-8 relative overflow-hidden group" style="animation-delay: 0.1s;">
                <div class="absolute -right-12 -top-12 w-32 h-32 bg-sky-500/10 rounded-full blur-2xl group-hover:bg-sky-500/20 transition-all"></div>
                <div class="w-16 h-16 rounded-[20px] bg-sky-100 text-sky-600 flex items-center justify-center text-3xl mb-6 shadow-inner border border-sky-200">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <h3 class="text-2xl font-black text-slate-800 mb-2 font-poppins">Data Remaja</h3>
                <p class="text-[13px] font-medium text-slate-500 mb-8 leading-relaxed">Impor data pemantauan kesehatan remaja, pendidikan, dan deteksi dini masalah kesehatan.</p>
                <div class="flex flex-col gap-3">
                    <a href="<?php echo e(route('kader.import.create')); ?>?type=remaja" class="w-full py-3.5 bg-sky-600 text-white hover:bg-sky-700 rounded-xl text-[13px] font-black flex items-center justify-center gap-2 transition-colors shadow-[0_4px_15px_rgba(2,132,199,0.3)] uppercase tracking-wider">
                        <i class="fas fa-cloud-upload-alt"></i> Upload Berkas
                    </a>
                    <a href="<?php echo e(route('kader.import.download-template', 'remaja')); ?>" class="w-full py-3 bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200 rounded-xl text-[12px] font-bold flex items-center justify-center gap-2 transition-colors">
                        <i class="fas fa-download"></i> Unduh Format CSV
                    </a>
                </div>
            </div>

            <div class="glass-card rounded-[32px] p-8 relative overflow-hidden group" style="animation-delay: 0.2s;">
                <div class="absolute -right-12 -top-12 w-32 h-32 bg-emerald-500/10 rounded-full blur-2xl group-hover:bg-emerald-500/20 transition-all"></div>
                <div class="w-16 h-16 rounded-[20px] bg-emerald-100 text-emerald-600 flex items-center justify-center text-3xl mb-6 shadow-inner border border-emerald-200">
                    <i class="fas fa-wheelchair"></i>
                </div>
                <h3 class="text-2xl font-black text-slate-800 mb-2 font-poppins">Data Lansia</h3>
                <p class="text-[13px] font-medium text-slate-500 mb-8 leading-relaxed">Migrasi data lansia manula untuk pemantauan hipertensi, diabetes, dan cek kesehatan berkala.</p>
                <div class="flex flex-col gap-3">
                    <a href="<?php echo e(route('kader.import.create')); ?>?type=lansia" class="w-full py-3.5 bg-emerald-600 text-white hover:bg-emerald-700 rounded-xl text-[13px] font-black flex items-center justify-center gap-2 transition-colors shadow-[0_4px_15px_rgba(5,150,105,0.3)] uppercase tracking-wider">
                        <i class="fas fa-cloud-upload-alt"></i> Upload Berkas
                    </a>
                    <a href="<?php echo e(route('kader.import.download-template', 'lansia')); ?>" class="w-full py-3 bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200 rounded-xl text-[12px] font-bold flex items-center justify-center gap-2 transition-colors">
                        <i class="fas fa-download"></i> Unduh Format CSV
                    </a>
                </div>
            </div>

        </div>

        <div class="bg-indigo-900 rounded-[32px] overflow-hidden relative shadow-2xl border border-indigo-700 animate-fade-in" style="animation-delay: 0.3s;">
            <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=%2260%22 height=%2260%22 viewBox=%220 0 60 60%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cpath d=%22M54.627 0l.83.83-54.627 54.627-.83-.83z%22 fill=%22%23ffffff%22 fill-rule=%22evenodd%22/%3E%3C/svg%3E');"></div>
            
            <div class="px-8 py-6 border-b border-indigo-800/50 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 relative z-10 bg-indigo-950/30">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-indigo-800 text-indigo-300 flex items-center justify-center text-xl border border-indigo-700"><i class="fas fa-robot"></i></div>
                    <div>
                        <h3 class="text-lg font-black text-white font-poppins">Cara Kerja Smart Import AI</h3>
                        <p class="text-[12px] text-indigo-300 font-medium">Kini dilengkapi deteksi pintar untuk mencocokkan kolom secara dinamis.</p>
                    </div>
                </div>
                <span class="px-3 py-1 bg-gradient-to-r from-amber-400 to-orange-500 text-white text-[10px] font-black uppercase tracking-widest rounded-lg shadow-sm">Fitur Baru</span>
            </div>
            
            <div class="p-8 md:p-10 grid grid-cols-1 lg:grid-cols-2 gap-12 relative z-10">
                <div>
                    <h6 class="text-[11px] font-black text-indigo-400 uppercase tracking-widest mb-6 flex items-center gap-2"><i class="fas fa-magic"></i> Fitur Auto-Mapping</h6>
                    <ul class="space-y-5 text-[14px] font-medium text-indigo-100">
                        <li class="flex items-start gap-4">
                            <span class="w-8 h-8 rounded-full bg-indigo-800 text-indigo-300 flex items-center justify-center shrink-0 font-black border border-indigo-600">1</span> 
                            <span class="pt-1 leading-relaxed">Anda tidak harus menggunakan template persis. Sistem AI kami akan mencoba mendeteksi nama kolom seperti <strong class="text-white bg-indigo-800 px-1.5 py-0.5 rounded">Nama Lengkap</strong>, <strong class="text-white bg-indigo-800 px-1.5 py-0.5 rounded">Tgl Lahir</strong> secara otomatis.</span>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="w-8 h-8 rounded-full bg-indigo-800 text-indigo-300 flex items-center justify-center shrink-0 font-black border border-indigo-600">2</span> 
                            <span class="pt-1 leading-relaxed">Pastikan format Tanggal di Excel menggunakan format <strong class="text-white bg-indigo-800 px-1.5 py-0.5 rounded">YYYY-MM-DD</strong> (Misal: 2024-12-31).</span>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="w-8 h-8 rounded-full bg-indigo-800 text-indigo-300 flex items-center justify-center shrink-0 font-black border border-indigo-600">3</span> 
                            <span class="pt-1 leading-relaxed">Jika sistem gagal mendeteksi, kami sangat menyarankan Anda mengunduh <strong>Template CSV Resmi</strong> dari tombol di atas.</span>
                        </li>
                    </ul>
                </div>
                <div>
                    <h6 class="text-[11px] font-black text-indigo-400 uppercase tracking-widest mb-6 flex items-center gap-2"><i class="fas fa-shield-alt"></i> Peringatan Sistem</h6>
                    <div class="space-y-4">
                        <div class="bg-indigo-800/50 border border-indigo-700 p-4 rounded-2xl flex gap-4">
                            <i class="fas fa-file-excel text-emerald-400 text-2xl mt-1"></i>
                            <div>
                                <p class="text-white font-bold text-sm mb-1">Mendukung Excel & CSV</p>
                                <p class="text-indigo-200 text-xs leading-relaxed">Gunakan format .xlsx, .xls, atau .csv. Maksimal kapasitas file yang diizinkan untuk sekali unggah adalah <strong class="text-white">10 Megabyte (MB)</strong>.</p>
                            </div>
                        </div>
                        <div class="bg-rose-900/40 border border-rose-800/50 p-4 rounded-2xl flex gap-4">
                            <i class="fas fa-exclamation-triangle text-rose-400 text-2xl mt-1"></i>
                            <div>
                                <p class="text-white font-bold text-sm mb-1">Validasi NIK Unik</p>
                                <p class="text-rose-200 text-xs leading-relaxed">Sistem akan memblokir/mengabaikan baris data jika mendeteksi adanya NIK ganda yang sudah terdaftar di dalam database KaderCare sebelumnya.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.kader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\POSYANDU\posyandu-management-system\resources\views/kader/import/index.blade.php ENDPATH**/ ?>