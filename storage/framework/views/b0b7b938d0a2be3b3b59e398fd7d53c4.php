

<?php $__env->startSection('title', 'Upload Data Import'); ?>
<?php $__env->startSection('page-name', 'Smart Import Wizard'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .animate-slide-up { opacity: 0; animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    
    .file-drop-area {
        border: 3px dashed #cbd5e1; border-radius: 24px; padding: 3rem 2rem;
        text-align: center; background-color: #f8fafc; transition: all 0.3s ease;
        position: relative; overflow: hidden; cursor: pointer;
    }
    .file-drop-area:hover, .file-drop-area.is-active {
        border-color: #6366f1; background-color: #eef2ff;
        box-shadow: inset 0 0 40px rgba(99, 102, 241, 0.1);
    }
    .file-input-hidden {
        position: absolute; inset: 0; width: 100%; height: 100%;
        opacity: 0; cursor: pointer; z-index: 10;
    }
    
    .toggle-checkbox:checked { right: 0; border-color: #4f46e5; }
    .toggle-checkbox:checked + .toggle-label { background-color: #4f46e5; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto animate-slide-up">
    
    <div class="text-center mb-10 mt-4">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-[24px] bg-gradient-to-br from-indigo-100 to-violet-100 text-indigo-600 mb-5 shadow-sm border border-indigo-200">
            <i class="fas fa-cloud-upload-alt text-4xl"></i>
        </div>
        <h1 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight font-poppins">Wizard Import Data</h1>
        <p class="text-slate-500 mt-3 font-medium text-[14px] max-w-xl mx-auto leading-relaxed">Unggah file Excel/CSV Anda. Sistem akan memproses, memetakan kolom, dan menyimpan ribuan baris data secara otomatis.</p>
    </div>

    <form action="<?php echo e(route('kader.import.store')); ?>" method="POST" enctype="multipart/form-data" id="importForm">
        <?php echo csrf_field(); ?>
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-10">
            
            <div class="lg:col-span-8 bg-white rounded-[32px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-8 md:p-10">
                <div class="flex items-center gap-4 mb-8 border-b border-slate-100 pb-5">
                    <span class="w-10 h-10 rounded-full bg-indigo-600 text-white flex items-center justify-center font-black shadow-md">1</span>
                    <h3 class="text-xl font-black text-slate-800 font-poppins">Pilih File Master</h3>
                </div>

                <div class="mb-8">
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3">Kategori Database Target <span class="text-rose-500">*</span></label>
                    <select name="jenis_data" id="jenis_data" required class="w-full bg-slate-50 border-2 border-slate-200 text-slate-800 text-[14px] rounded-2xl px-5 py-4 outline-none font-bold focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all cursor-pointer">
                        <option value="">-- Pilih Tujuan Modul --</option>
                        <option value="balita" <?php echo e(old('jenis_data', $type ?? '') == 'balita' ? 'selected' : ''); ?>>🍼 Modul Data Balita</option>
                        <option value="remaja" <?php echo e(old('jenis_data', $type ?? '') == 'remaja' ? 'selected' : ''); ?>>🎓 Modul Data Remaja</option>
                        <option value="lansia" <?php echo e(old('jenis_data', $type ?? '') == 'lansia' ? 'selected' : ''); ?>>👴 Modul Data Lansia</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3">Unggah File (Excel / CSV) <span class="text-rose-500">*</span></label>
                    
                    <div class="file-drop-area" id="dropArea">
                        <input type="file" name="file" id="file" accept=".xlsx,.xls,.csv" required class="file-input-hidden">
                        
                        <div class="w-20 h-20 rounded-full bg-white shadow-sm border border-slate-200 text-indigo-500 flex items-center justify-center text-3xl mx-auto mb-4" id="fileIcon">
                            <i class="fas fa-file-excel"></i>
                        </div>
                        
                        <h4 class="text-lg font-black text-slate-800 mb-1 font-poppins" id="fileNameDisplay">Seret & Lepas File di Sini</h4>
                        <p class="text-[13px] font-medium text-slate-500 mb-4" id="fileDescDisplay">atau klik untuk menelusuri komputer Anda</p>
                        
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-slate-200/50 text-slate-600 rounded-lg text-[10px] font-bold uppercase tracking-widest">
                            <i class="fas fa-info-circle"></i> Maks 10 MB
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-4 bg-slate-50/80 rounded-[32px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-8 md:p-10 relative overflow-hidden flex flex-col">
                <div class="absolute right-0 top-0 w-40 h-40 bg-indigo-500/10 rounded-bl-full pointer-events-none blur-2xl"></div>
                
                <div class="flex items-center gap-4 mb-8 border-b border-slate-200 pb-5 relative z-10">
                    <span class="w-10 h-10 rounded-full bg-violet-500 text-white flex items-center justify-center font-black shadow-md">2</span>
                    <h3 class="text-xl font-black text-slate-800 font-poppins">Pengaturan</h3>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm relative z-10 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-robot text-indigo-500 text-xl"></i>
                            <h4 class="font-black text-slate-800 text-[14px]">Smart Mapping</h4>
                        </div>
                        <div class="relative inline-block w-12 mr-2 align-middle select-none transition duration-200 ease-in">
                            <input type="checkbox" name="smart_import" id="smart_import" checked class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer border-indigo-500 transition-all duration-300 z-10" style="right: 0;"/>
                            <label for="smart_import" class="toggle-label block overflow-hidden h-6 rounded-full bg-indigo-500 cursor-pointer transition-colors duration-300"></label>
                        </div>
                    </div>
                    <p class="text-[12px] font-medium text-slate-500 leading-relaxed">Biarkan sistem menganalisis dan mencocokkan nama kolom Excel Anda dengan database secara otomatis (AI Detection).</p>
                </div>

                <div class="bg-amber-50 p-6 rounded-2xl border border-amber-200 shadow-sm relative z-10 mt-auto">
                    <h4 class="font-black text-amber-900 text-[13px] mb-2"><i class="fas fa-exclamation-triangle mr-1"></i> Mode Aman (Fallback)</h4>
                    <p class="text-[11px] font-medium text-amber-700 leading-relaxed mb-4">Jika Smart Mapping gagal, Anda tetap harus menggunakan template standar sistem kami.</p>
                    <button type="button" onclick="downloadTemplate()" class="w-full py-3 bg-white border border-amber-300 text-amber-700 font-bold text-[12px] rounded-xl hover:bg-amber-100 transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-download"></i> Unduh Template Resmi
                    </button>
                </div>

            </div>
        </div>
        
        <div class="sticky bottom-6 z-30 bg-white/90 backdrop-blur-xl border border-slate-200 p-5 rounded-[24px] shadow-[0_20px_40px_rgba(0,0,0,0.1)] flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4 hidden sm:flex">
                <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl shrink-0"><i class="fas fa-shield-check"></i></div>
                <div>
                    <p class="text-[13px] font-black text-slate-800">Sistem Keamanan Aktif</p>
                    <p class="text-[11px] font-bold text-slate-400">Data Anda dilindungi enkripsi SSL 256-bit.</p>
                </div>
            </div>
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <a href="<?php echo e(route('kader.import.index')); ?>" class="w-full sm:w-auto px-6 py-4 bg-slate-100 text-slate-600 font-black text-[13px] rounded-xl hover:bg-slate-200 transition-colors text-center uppercase tracking-widest smooth-route">
                    Batal
                </a>
                <button type="submit" id="btnProses" class="w-full sm:w-auto px-10 py-4 bg-indigo-600 text-white font-black text-[13px] rounded-xl hover:bg-indigo-700 shadow-[0_8px_20px_rgba(79,70,229,0.3)] hover:-translate-y-1 transition-all flex items-center justify-center gap-2 uppercase tracking-widest">
                    <i class="fas fa-cogs"></i> Mulai Impor Data
                </button>
            </div>
        </div>
        
    </form>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    // Logika Drag & Drop File UI
    const dropArea = document.getElementById('dropArea');
    const fileInput = document.getElementById('file');
    const fileNameDisplay = document.getElementById('fileNameDisplay');
    const fileDescDisplay = document.getElementById('fileDescDisplay');
    const fileIcon = document.getElementById('fileIcon');

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) { e.preventDefault(); e.stopPropagation(); }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => dropArea.classList.add('is-active'), false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => dropArea.classList.remove('is-active'), false);
    });

    dropArea.addEventListener('drop', (e) => {
        let dt = e.dataTransfer;
        let files = dt.files;
        fileInput.files = files;
        handleFiles(files);
    });

    fileInput.addEventListener('change', function() {
        handleFiles(this.files);
    });

    function handleFiles(files) {
        if(files.length > 0) {
            const fileName = files[0].name;
            const fileSize = (files[0].size / (1024*1024)).toFixed(2); // In MB
            
            fileNameDisplay.textContent = fileName;
            fileNameDisplay.classList.add('text-indigo-600');
            fileDescDisplay.textContent = `Ukuran file: ${fileSize} MB`;
            
            fileIcon.classList.remove('text-indigo-500', 'bg-white');
            fileIcon.classList.add('text-white', 'bg-emerald-500', 'border-emerald-500');
            fileIcon.innerHTML = '<i class="fas fa-check"></i>';
            dropArea.style.borderColor = '#10b981';
        }
    }

    function downloadTemplate() {
        const jenisData = document.getElementById('jenis_data').value;
        if (!jenisData) {
            alert('PILIH KATEGORI DULU: Silakan pilih tujuan modul (Balita/Remaja/Lansia) di kotak atas sebelum mengunduh template.');
            document.getElementById('jenis_data').focus();
            return;
        }
        window.location.href = "<?php echo e(route('kader.import.download-template', '')); ?>/" + jenisData;
    }

    // Loading State saat submit
    document.getElementById('importForm').addEventListener('submit', function(e) {
        if(!fileInput.files.length) {
            e.preventDefault();
            alert('Anda belum memasukkan file apapun!');
            return;
        }
        const btn = document.getElementById('btnProses');
        btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Memproses AI...';
        btn.classList.add('opacity-75', 'cursor-wait');
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.kader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\POSYANDU\posyandu-management-system\resources\views/kader/import/create.blade.php ENDPATH**/ ?>