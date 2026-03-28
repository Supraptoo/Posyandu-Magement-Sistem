

<?php $__env->startSection('title', 'Detail Rekam Medis'); ?>
<?php $__env->startSection('page-name', 'Buku Jejak Medis'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .animate-slide-up { opacity: 0; animation: slideUpFade 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
    
    /* Timeline Line yang elegan */
    .timeline-line { position: absolute; left: 35px; top: 20px; bottom: 0; width: 3px; background: #e2e8f0; z-index: 0; border-radius: 5px; }
    @media (max-width: 640px) { .timeline-line { left: 24px; } }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div id="smoothLoader" class="fixed inset-0 bg-slate-50/90 backdrop-blur-md z-[9999] flex flex-col items-center justify-center transition-all duration-300 opacity-100">
    <div class="relative w-20 h-20 flex items-center justify-center mb-4">
        <div class="absolute inset-0 border-4 border-cyan-100 rounded-full"></div>
        <div class="absolute inset-0 border-4 border-cyan-500 rounded-full border-t-transparent animate-spin"></div>
        <i class="fas fa-file-medical text-cyan-500 text-2xl animate-pulse"></i>
    </div>
    <p class="text-cyan-800 font-black font-poppins tracking-widest text-[11px] animate-pulse uppercase" id="loaderText">MEMPROSES DATA...</p>
</div>

<div class="max-w-5xl mx-auto animate-slide-up">

    <div class="mb-6">
        <a href="<?php echo e(route('bidan.rekam-medis.index')); ?>" class="smooth-route inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-600 font-bold text-[13px] rounded-xl hover:bg-slate-50 transition-colors shadow-sm">
            <i class="fas fa-arrow-left"></i> Kembali ke Pencarian
        </a>
    </div>

    <?php
        // Tema warna berdasarkan kategori pasien
        if($pasien_type == 'balita') { $bCol='rose'; $bBg='from-rose-400 to-pink-500'; $icn='fa-baby'; }
        elseif($pasien_type == 'remaja') { $bCol='indigo'; $bBg='from-indigo-400 to-violet-500'; $icn='fa-user-graduate'; }
        else { $bCol='emerald'; $bBg='from-emerald-400 to-teal-500'; $icn='fa-wheelchair'; }
    ?>

    <div class="bg-gradient-to-br <?php echo e($bBg); ?> rounded-[32px] border border-<?php echo e($bCol); ?>-500 shadow-[0_12px_30px_rgba(0,0,0,0.1)] mb-10 overflow-hidden relative p-8 md:p-10">
        <div class="absolute inset-0 opacity-20 pointer-events-none" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 20px 20px;"></div>
        <div class="absolute -right-10 -bottom-10 opacity-10 text-[150px] pointer-events-none"><i class="fas fa-book-medical"></i></div>

        <div class="relative z-10 flex flex-col md:flex-row items-center md:items-start gap-6 text-white text-center md:text-left">
            <div class="w-28 h-28 rounded-[28px] bg-white text-<?php echo e($bCol); ?>-500 flex items-center justify-center text-5xl font-black shadow-xl shrink-0 transform -rotate-3 hover:rotate-0 transition-transform">
                <i class="fas <?php echo e($icn); ?>"></i>
            </div>
            
            <div class="flex-1 w-full">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/20 backdrop-blur-md rounded-lg text-[10px] font-extrabold uppercase tracking-widest mb-3 border border-white/30 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                    Kategori <?php echo e(ucfirst($pasien_type)); ?>

                </div>
                
                <h2 class="text-3xl md:text-4xl font-black tracking-tight mb-4 font-poppins drop-shadow-md"><?php echo e($pasien->nama_lengkap); ?></h2>
                
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 bg-black/10 p-5 rounded-2xl backdrop-blur-sm border border-white/10">
                    <div><p class="text-white/70 text-[10px] font-black uppercase tracking-widest mb-1">Identitas (NIK)</p><p class="font-bold text-[13px] tracking-wider"><?php echo e($pasien->nik ?? '-'); ?></p></div>
                    <div><p class="text-white/70 text-[10px] font-black uppercase tracking-widest mb-1">Usia Saat Ini</p><p class="font-bold text-[13px]"><?php echo e(\Carbon\Carbon::parse($pasien->tanggal_lahir)->age); ?> Tahun</p></div>
                    <div><p class="text-white/70 text-[10px] font-black uppercase tracking-widest mb-1">Tanggal Lahir</p><p class="font-bold text-[13px]"><?php echo e(\Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d M Y')); ?></p></div>
                    <div><p class="text-white/70 text-[10px] font-black uppercase tracking-widest mb-1">Total Kunjungan</p><p class="font-bold text-[13px]"><?php echo e(count($kunjungans)); ?> Kali Periksa</p></div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-3 mb-8 px-2">
        <div class="w-10 h-10 bg-slate-800 text-white rounded-xl flex items-center justify-center shadow-md"><i class="fas fa-history text-lg"></i></div>
        <h3 class="text-xl font-black text-slate-800 tracking-tight">Timeline Kesehatan</h3>
    </div>

    <div class="relative bg-white rounded-[32px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.03)] p-6 sm:p-10 mb-10 overflow-hidden">
        
        <?php if(count($kunjungans) > 0): ?>
            <div class="timeline-line"></div>
        <?php endif; ?>

        <?php $__empty_1 = true; $__currentLoopData = $kunjungans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kunjungan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="relative pl-14 sm:pl-20 mb-10 last:mb-0 group">
                
                <div class="absolute left-[17px] sm:left-[17px] top-0 w-10 h-10 rounded-full bg-white border-[3px] border-cyan-500 shadow-md flex items-center justify-center text-cyan-600 z-10 transition-transform duration-300 group-hover:scale-110 group-hover:bg-cyan-50">
                    <i class="fas fa-stethoscope text-[13px]"></i>
                </div>

                <div class="bg-slate-50/50 border border-slate-200 rounded-[24px] p-6 transition-all duration-300 hover:bg-white hover:shadow-[0_10px_40px_rgba(0,0,0,0.05)] hover:border-cyan-300">
                    
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 pb-5 border-b border-slate-200/80">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white border border-slate-200 rounded-xl flex flex-col items-center justify-center shadow-sm shrink-0">
                                <span class="text-[10px] font-black text-slate-400 uppercase leading-none"><?php echo e(\Carbon\Carbon::parse($kunjungan->tanggal)->translatedFormat('M')); ?></span>
                                <span class="text-lg font-black text-slate-800 leading-none mt-0.5"><?php echo e(\Carbon\Carbon::parse($kunjungan->tanggal)->format('d')); ?></span>
                            </div>
                            <div>
                                <h4 class="font-black text-slate-800 text-[15px]"><?php echo e(\Carbon\Carbon::parse($kunjungan->tanggal)->translatedFormat('l, Y')); ?></h4>
                                <span class="text-[11px] font-bold text-slate-400 mt-0.5 flex items-center gap-1.5"><i class="far fa-clock"></i> <?php echo e(\Carbon\Carbon::parse($kunjungan->tanggal)->diffForHumans()); ?></span>
                            </div>
                        </div>

                        <?php if($kunjungan->pemeriksaan?->keluhan): ?>
                        <div class="inline-flex items-start gap-2 bg-rose-50 border border-rose-100 px-4 py-2.5 rounded-xl max-w-sm">
                            <i class="fas fa-comment-medical text-rose-500 mt-0.5"></i>
                            <div>
                                <span class="text-[9px] font-black text-rose-400 uppercase tracking-widest block mb-0.5">Keluhan Awal:</span>
                                <span class="text-[12px] font-bold text-rose-700 leading-tight">"<?php echo e($kunjungan->pemeriksaan->keluhan); ?>"</span>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="bg-white border border-slate-200 rounded-[20px] p-5 shadow-sm">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 border-b border-slate-100 pb-2 flex items-center gap-2"><i class="fas fa-ruler-vertical text-slate-300"></i> Hasil Ukur (Kader)</p>
                            
                            <?php if($kunjungan->pemeriksaan): ?>
                                <div class="grid grid-cols-2 gap-y-4 gap-x-3 text-[12px]">
                                    <div><span class="block text-slate-400 font-bold text-[10px] mb-0.5">Berat Badan</span><strong class="text-slate-800 text-[14px]"><?php echo e($kunjungan->pemeriksaan->berat_badan ?? '-'); ?> kg</strong></div>
                                    <div><span class="block text-slate-400 font-bold text-[10px] mb-0.5">Tinggi Badan</span><strong class="text-slate-800 text-[14px]"><?php echo e($kunjungan->pemeriksaan->tinggi_badan ?? '-'); ?> cm</strong></div>
                                    
                                    <?php if($kunjungan->pemeriksaan->lingkar_kepala): ?>
                                        <div><span class="block text-slate-400 font-bold text-[10px] mb-0.5">Lingkar Kepala</span><strong class="text-slate-800 text-[14px]"><?php echo e($kunjungan->pemeriksaan->lingkar_kepala); ?> cm</strong></div>
                                    <?php endif; ?>
                                    
                                    <?php if($kunjungan->pemeriksaan->tekanan_darah): ?>
                                        <div><span class="block text-slate-400 font-bold text-[10px] mb-0.5">Tensi Darah</span><strong class="text-rose-600 text-[14px]"><?php echo e($kunjungan->pemeriksaan->tekanan_darah); ?></strong></div>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <div class="flex items-center gap-2 text-slate-400 text-xs italic py-2"><i class="fas fa-info-circle"></i> Tidak ada data antropometri.</div>
                            <?php endif; ?>
                        </div>

                        <div class="bg-cyan-50 border border-cyan-100 rounded-[20px] p-5 shadow-sm relative overflow-hidden">
                            <i class="fas fa-user-md absolute right-[-10px] top-[-10px] text-5xl text-cyan-500/10"></i>
                            <p class="text-[10px] font-black text-cyan-600 uppercase tracking-widest mb-4 border-b border-cyan-200/50 pb-2 relative z-10 flex items-center gap-2"><i class="fas fa-stethoscope"></i> Keputusan Medis</p>
                            
                            <?php if($kunjungan->pemeriksaan && $kunjungan->pemeriksaan->diagnosa): ?>
                                <div class="relative z-10">
                                    <p class="text-[13px] font-bold text-cyan-900 leading-relaxed mb-3">"<?php echo e($kunjungan->pemeriksaan->diagnosa); ?>"</p>
                                    
                                    <?php if($kunjungan->pemeriksaan->tindakan): ?>
                                        <div class="bg-white/60 p-3 rounded-xl border border-cyan-200/50">
                                            <span class="text-[9px] font-black text-cyan-600 uppercase tracking-widest block mb-1"><i class="fas fa-pills mr-1"></i> Tindakan / Resep:</span> 
                                            <p class="text-[12px] font-bold text-cyan-800"><?php echo e($kunjungan->pemeriksaan->tindakan); ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <div class="flex items-center gap-2 text-amber-600 bg-amber-100/50 p-3 rounded-xl text-xs font-bold border border-amber-200 relative z-10">
                                    <i class="fas fa-exclamation-triangle"></i> Belum ada validasi dari Bidan.
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>

            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center py-16 relative z-10">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mx-auto mb-4 text-4xl shadow-inner border border-slate-100"><i class="fas fa-folder-open"></i></div>
                <h4 class="font-black text-slate-700 text-lg font-poppins">Belum Ada Rekam Medis</h4>
                <p class="text-[13px] font-medium text-slate-500 mt-1 max-w-sm mx-auto">Pasien ini belum memiliki riwayat kunjungan dan pemeriksaan di Posyandu.</p>
            </div>
        <?php endif; ?>
    </div>

</div>

<?php $__env->startPush('scripts'); ?>
<script>
    window.addEventListener('pageshow', () => {
        const loader = document.getElementById('smoothLoader');
        if(loader) {
            loader.classList.remove('opacity-100');
            loader.classList.add('opacity-0', 'pointer-events-none');
            setTimeout(() => loader.style.display = 'none', 300);
        }
    });

    document.querySelectorAll('.smooth-route').forEach(link => {
        link.addEventListener('click', function(e) {
            if(this.target !== '_blank' && !e.ctrlKey) {
                const loader = document.getElementById('smoothLoader');
                if(loader) {
                    document.getElementById('loaderText').innerText = 'KEMBALI KE PENCARIAN...';
                    loader.style.display = 'flex';
                    loader.offsetHeight; 
                    loader.classList.remove('opacity-0', 'pointer-events-none');
                    loader.classList.add('opacity-100');
                }
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.bidan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\POSYANDU\posyandu-management-system\resources\views/bidan/rekam-medis/show.blade.php ENDPATH**/ ?>