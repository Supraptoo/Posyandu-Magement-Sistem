@extends('layouts.bidan')

@section('title', 'Validasi Pemeriksaan')
@section('page-name', 'Detail & Validasi Data')

@push('styles')
<style>
    .animate-slide-up { opacity: 0; animation: slideUpFade 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
    .radio-card input:checked + div { border-color: #06b6d4; background-color: #ecfeff; }
    .radio-card-reject input:checked + div { border-color: #f43f5e; background-color: #fff1f2; }
</style>
@endpush

@section('content')
<div id="smoothLoader" class="fixed inset-0 bg-slate-50/90 backdrop-blur-md z-[9999] flex flex-col items-center justify-center transition-all duration-300 opacity-100">
    <div class="relative w-20 h-20 flex items-center justify-center mb-4">
        <div class="absolute inset-0 border-4 border-cyan-100 rounded-full"></div>
        <div class="absolute inset-0 border-4 border-cyan-600 rounded-full border-t-transparent animate-spin"></div>
        <i class="fas fa-heartbeat text-cyan-600 text-2xl animate-pulse"></i>
    </div>
    <p class="text-cyan-800 font-extrabold tracking-widest text-sm animate-pulse" id="loaderText">MEMUAT DATA...</p>
</div>

<div class="max-w-7xl mx-auto animate-slide-up">

    <div class="mb-6">
        <a href="{{ route('bidan.pemeriksaan.index') }}" class="smooth-route inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-600 font-bold text-sm rounded-xl hover:bg-slate-50 transition-colors shadow-sm">
            <i class="fas fa-arrow-left"></i> Kembali ke Antrian
        </a>
    </div>

    @php
        $sv = $pemeriksaan->status_verifikasi ?? 'pending';
        $svConfig = [
            'verified' => ['emerald', 'check-circle',  'Telah Diverifikasi'],
            'rejected' => ['rose',  'times-circle',  'Data Ditolak'],
            'pending'  => ['amber', 'hourglass-half', 'Menunggu Validasi Anda'],
        ];
        [$svColor, $svIcon, $svLabel] = $svConfig[$sv] ?? $svConfig['pending'];
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-{{ $svColor }}-50 border border-{{ $svColor }}-200 p-5 rounded-[20px] flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-{{ $svColor }}-100 text-{{ $svColor }}-600 flex items-center justify-center text-2xl shrink-0">
                        <i class="fas fa-{{ $svIcon }}"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-{{ $svColor }}-700">{{ $svLabel }}</h3>
                        @if($pemeriksaan->verified_at)
                            <p class="text-sm font-semibold text-{{ $svColor }}-600/80 mt-0.5">Oleh {{ $pemeriksaan->verifikator?->name ?? 'Anda' }} pada {{ \Carbon\Carbon::parse($pemeriksaan->verified_at)->format('d M Y, H:i') }}</p>
                        @else
                            <p class="text-sm font-semibold text-{{ $svColor }}-600/80 mt-0.5">Silakan periksa data ukur di bawah dan berikan diagnosa.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_4px_20px_rgba(0,0,0,0.03)] overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center gap-3">
                    <i class="fas fa-user-circle text-cyan-600 text-lg"></i>
                    <h3 class="font-extrabold text-slate-800">Identitas Pasien</h3>
                </div>
                <div class="p-6 grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div><p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Nama Lengkap</p><p class="font-black text-slate-800">{{ $pemeriksaan->nama_pasien ?? ($pemeriksaan->balita->nama_lengkap ?? ($pemeriksaan->remaja->nama_lengkap ?? ($pemeriksaan->lansia->nama_lengkap ?? '-'))) }}</p></div>
                    <div><p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Kategori</p><span class="px-2.5 py-1 bg-slate-100 text-slate-600 text-[10px] font-extrabold rounded-md uppercase border border-slate-200">{{ $pemeriksaan->kategori_pasien }}</span></div>
                    <div><p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Tgl Periksa</p><p class="font-bold text-slate-800">{{ $pemeriksaan->tanggal_periksa?->format('d M Y') ?? '-' }}</p></div>
                    <div><p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Diinput Oleh</p><p class="font-bold text-slate-800">{{ $pemeriksaan->pemeriksa?->name ?? 'Sistem' }}</p></div>
                </div>
            </div>

            <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_4px_20px_rgba(0,0,0,0.03)] overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center gap-3">
                    <i class="fas fa-weight text-cyan-600 text-lg"></i>
                    <h3 class="font-extrabold text-slate-800">Hasil Pengukuran Fisik</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                        @php
                            $fields = [
                                'berat_badan'   => ['Berat Badan', 'kg', 'fa-weight'],
                                'tinggi_badan'  => ['Tinggi Badan', 'cm', 'fa-ruler-vertical'],
                                'suhu_tubuh'    => ['Suhu Tubuh', '°C', 'fa-thermometer-half'],
                                'tekanan_darah' => ['Tekanan Darah', 'mmHg', 'fa-heartbeat'],
                                'hemoglobin'    => ['Hemoglobin', 'g/dL', 'fa-tint'],
                                'gula_darah'    => ['Gula Darah', 'mg/dL', 'fa-cubes'],
                                'kolesterol'    => ['Kolesterol', 'mg/dL', 'fa-bacon'],
                                'asam_urat'     => ['Asam Urat', 'mg/dL', 'fa-bone'],
                                'lingkar_kepala'=> ['L. Kepala', 'cm', 'fa-child'],
                                'lingkar_lengan'=> ['L. Lengan', 'cm', 'fa-child'],
                            ];
                        @endphp
                        @foreach($fields as $col => [$label, $satuan, $icon])
                            @if(!empty($pemeriksaan->$col))
                            <div class="bg-slate-50 border border-slate-100 p-4 rounded-xl flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-white text-cyan-500 shadow-sm flex items-center justify-center shrink-0"><i class="fas {{ $icon }}"></i></div>
                                <div><p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest mb-0.5">{{ $label }}</p><p class="font-black text-slate-800 text-lg">{{ $pemeriksaan->$col }} <span class="text-xs font-bold text-slate-500">{{ $satuan }}</span></p></div>
                            </div>
                            @endif
                        @endforeach
                    </div>

                    @if($pemeriksaan->keluhan)
                    <div class="mt-6 p-4 bg-rose-50 border border-rose-100 rounded-xl">
                        <p class="text-[11px] font-extrabold text-rose-400 uppercase tracking-widest mb-1"><i class="fas fa-comment-medical mr-1"></i> Keluhan Pasien</p>
                        <p class="font-semibold text-rose-800">{{ $pemeriksaan->keluhan }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white rounded-[24px] border border-cyan-200 shadow-[0_8px_30px_rgba(8,145,178,0.1)] overflow-hidden sticky top-28">
                <div class="px-6 py-5 border-b border-slate-100 bg-cyan-600 text-white flex items-center gap-3">
                    <i class="fas fa-user-md text-xl"></i>
                    <h3 class="font-extrabold">Keputusan Medis</h3>
                </div>
                
                <div class="p-6">
                    @if($sv === 'pending')
                        <form id="formValidasi" action="{{ route('bidan.pemeriksaan.verifikasi', $pemeriksaan->id) }}" method="POST" class="space-y-5">
                            @csrf @method('PUT')
                            <div>
                                <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Diagnosa Bidan</label>
                                <textarea name="diagnosa" rows="3" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl px-4 py-3 outline-none font-semibold focus:border-cyan-500 focus:bg-white transition-colors shadow-inner placeholder:text-slate-400" placeholder="Ketik diagnosa medis..."></textarea>
                            </div>
                            <div>
                                <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Tindakan / Resep</label>
                                <textarea name="tindakan" rows="2" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl px-4 py-3 outline-none font-semibold focus:border-cyan-500 focus:bg-white transition-colors shadow-inner placeholder:text-slate-400" placeholder="(Opsional)"></textarea>
                            </div>
                            <div>
                                <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-widest mb-3">Keputusan</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <label class="radio-card cursor-pointer">
                                        <input type="radio" name="status_verifikasi" value="verified" class="hidden" required checked>
                                        <div class="border-2 border-slate-200 rounded-xl p-3 text-center transition-all hover:bg-slate-50">
                                            <i class="fas fa-check-circle text-cyan-500 text-xl mb-1"></i><p class="text-xs font-bold text-slate-700">Terima (ACC)</p>
                                        </div>
                                    </label>
                                    <label class="radio-card-reject cursor-pointer">
                                        <input type="radio" name="status_verifikasi" value="rejected" class="hidden" required>
                                        <div class="border-2 border-slate-200 rounded-xl p-3 text-center transition-all hover:bg-slate-50">
                                            <i class="fas fa-times-circle text-rose-500 text-xl mb-1"></i><p class="text-xs font-bold text-slate-700">Tolak Data</p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Catatan Penolakan</label>
                                <input type="text" name="catatan_bidan" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl px-4 py-3 outline-none focus:border-rose-500 transition-colors shadow-inner" placeholder="Alasan ditolak...">
                            </div>

                            <button type="submit" id="btnValidasi" class="w-full py-3.5 bg-gradient-to-r from-cyan-500 to-cyan-600 text-white font-black text-sm rounded-xl hover:from-cyan-600 hover:to-cyan-700 shadow-[0_8px_20px_rgba(8,145,178,0.25)] hover:-translate-y-0.5 transition-all duration-300">
                                <i class="fas fa-save mr-1"></i> Simpan Validasi
                            </button>
                        </form>
                    @else
                        <div class="space-y-5">
                            <div><p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Diagnosa Bidan</p><div class="p-3.5 bg-cyan-50 border border-cyan-100 rounded-xl text-cyan-800 font-bold text-sm">{{ $pemeriksaan->diagnosa ?? '-' }}</div></div>
                            @if($pemeriksaan->tindakan) <div><p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Tindakan</p><div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-semibold text-sm">{{ $pemeriksaan->tindakan }}</div></div> @endif
                            @if($pemeriksaan->catatan_bidan) <div><p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Catatan Bidan</p><div class="p-3.5 bg-rose-50 border border-rose-100 rounded-xl text-rose-700 font-semibold text-sm">{{ $pemeriksaan->catatan_bidan }}</div></div> @endif
                            <form id="formReset" action="{{ route('bidan.pemeriksaan.verifikasi', $pemeriksaan->id) }}" method="POST" class="mt-4 pt-4 border-t border-slate-100">
                                @csrf @method('PUT')
                                <input type="hidden" name="status_verifikasi" value="pending"><input type="hidden" name="diagnosa" value="">
                                <button type="submit" id="btnReset" class="w-full py-2.5 bg-white border-2 border-slate-200 text-slate-600 font-bold text-sm rounded-xl hover:bg-slate-50 transition-colors"><i class="fas fa-undo mr-1"></i> Batalkan Validasi</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
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
        
        // Reset button states in case user pressed back browser
        const btnV = document.getElementById('btnValidasi');
        if(btnV) { btnV.innerHTML = '<i class="fas fa-save mr-1"></i> Simpan Validasi'; btnV.classList.remove('opacity-75', 'cursor-wait'); }
        
        const btnR = document.getElementById('btnReset');
        if(btnR) { btnR.innerHTML = '<i class="fas fa-undo mr-1"></i> Batalkan Validasi'; btnR.classList.remove('opacity-75', 'cursor-wait'); }
    });

    document.querySelectorAll('.smooth-route').forEach(link => {
        link.addEventListener('click', function(e) {
            if(this.target !== '_blank' && !e.ctrlKey) showLoader('KEMBALI KE ANTRIAN...');
        });
    });

    const formV = document.getElementById('formValidasi');
    if(formV) {
        formV.addEventListener('submit', function() {
            const btn = document.getElementById('btnValidasi');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...';
            btn.classList.add('opacity-75', 'cursor-wait');
            showLoader('MENGIRIM DIAGNOSA...');
        });
    }

    const formR = document.getElementById('formReset');
    if(formR) {
        formR.addEventListener('submit', function() {
            const btn = document.getElementById('btnReset');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Mereset...';
            btn.classList.add('opacity-75', 'cursor-wait');
            showLoader('MEMBATALKAN VALIDASI...');
        });
    }
</script>
@endpush