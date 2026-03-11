@extends('layouts.bidan')

@section('title', 'Buat Jadwal Baru')
@section('page-name', 'Tambah Agenda Medis')

@push('styles')
<style>
    .animate-slide-up { opacity: 0; animation: slideUpFade 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endpush

@section('content')
<div id="smoothLoader" class="fixed inset-0 bg-slate-50/90 backdrop-blur-md z-[9999] flex flex-col items-center justify-center transition-all duration-300 opacity-0 pointer-events-none">
    <div class="relative w-20 h-20 flex items-center justify-center mb-4">
        <div class="absolute inset-0 border-4 border-cyan-100 rounded-full"></div>
        <div class="absolute inset-0 border-4 border-cyan-600 rounded-full border-t-transparent animate-spin"></div>
        <i class="fas fa-paper-plane text-cyan-600 text-2xl animate-pulse"></i>
    </div>
    <p class="text-cyan-800 font-poppins font-extrabold tracking-widest text-sm animate-pulse" id="loaderText">MENYIMPAN & MENGIRIM NOTIFIKASI...</p>
</div>

<div class="max-w-4xl mx-auto animate-slide-up">

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight font-poppins">Form Jadwal Baru</h1>
            <p class="text-slate-500 mt-1 font-medium text-sm">Pembuatan jadwal akan otomatis mengirimkan notifikasi ke *Handphone* warga sasaran.</p>
        </div>
        <a href="{{ route('bidan.jadwal.index') }}" class="smooth-route inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-600 font-bold text-sm rounded-xl hover:bg-slate-50 transition-colors shadow-sm">
            <i class="fas fa-arrow-left"></i> Batal
        </a>
    </div>

    <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
        
        <div class="px-6 py-5 border-b border-slate-100 bg-cyan-50/30 flex items-center gap-3">
            <i class="fas fa-edit text-cyan-600"></i>
            <h3 class="font-extrabold text-slate-800">Detail Informasi Jadwal</h3>
        </div>

        <form id="formJadwal" action="{{ route('bidan.jadwal.store') }}" method="POST">
            @csrf
            
            <div class="p-6 sm:p-8 space-y-6">
                <div>
                    <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Judul Kegiatan <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul') }}" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl px-4 py-3 outline-none font-semibold focus:border-cyan-500 focus:bg-white transition-colors shadow-inner" placeholder="Contoh: Posyandu Balita & Pemberian Vitamin A">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Tanggal Pelaksanaan <span class="text-rose-500">*</span></label>
                        <input type="date" name="tanggal" value="{{ old('tanggal') }}" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl px-4 py-3 outline-none font-semibold focus:border-cyan-500 focus:bg-white transition-colors shadow-inner cursor-pointer">
                    </div>
                    <div>
                        <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Waktu Mulai <span class="text-rose-500">*</span></label>
                        <input type="time" name="waktu_mulai" value="{{ old('waktu_mulai') }}" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl px-4 py-3 outline-none font-semibold focus:border-cyan-500 focus:bg-white transition-colors shadow-inner cursor-pointer">
                    </div>
                    <div>
                        <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Waktu Selesai <span class="text-rose-500">*</span></label>
                        <input type="time" name="waktu_selesai" value="{{ old('waktu_selesai') }}" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl px-4 py-3 outline-none font-semibold focus:border-cyan-500 focus:bg-white transition-colors shadow-inner cursor-pointer">
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Lokasi / Tempat <span class="text-rose-500">*</span></label>
                    <input type="text" name="lokasi" value="{{ old('lokasi', 'Posyandu Desa Bantar Kulon') }}" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl px-4 py-3 outline-none font-semibold focus:border-cyan-500 focus:bg-white transition-colors shadow-inner" placeholder="Contoh: Balai Desa / Rumah Ibu RT...">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Kategori Kegiatan <span class="text-rose-500">*</span></label>
                        <select name="kategori" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl px-4 py-3 outline-none font-semibold focus:border-cyan-500 transition-colors shadow-inner cursor-pointer">
                            <option value="posyandu" {{ old('kategori') == 'posyandu' ? 'selected' : '' }}>Posyandu Rutin</option>
                            <option value="imunisasi" {{ old('kategori') == 'imunisasi' ? 'selected' : '' }}>Imunisasi Khusus</option>
                            <option value="pemeriksaan" {{ old('kategori') == 'pemeriksaan' ? 'selected' : '' }}>Pemeriksaan Khusus</option>
                            <option value="konseling" {{ old('kategori') == 'konseling' ? 'selected' : '' }}>Penyuluhan / Konseling</option>
                            <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Target Peserta Warga <span class="text-rose-500">*</span></label>
                        <select name="target_peserta" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl px-4 py-3 outline-none font-semibold focus:border-cyan-500 transition-colors shadow-inner cursor-pointer">
                            <option value="semua" {{ old('target_peserta') == 'semua' ? 'selected' : '' }}>Semua Warga (Balita, Remaja, Lansia)</option>
                            <option value="balita" {{ old('target_peserta') == 'balita' ? 'selected' : '' }}>Khusus Balita & Orang Tua</option>
                            <option value="remaja" {{ old('target_peserta') == 'remaja' ? 'selected' : '' }}>Khusus Remaja</option>
                            <option value="lansia" {{ old('target_peserta') == 'lansia' ? 'selected' : '' }}>Khusus Lansia</option>
                            <option value="ibu_hamil" {{ old('target_peserta') == 'ibu_hamil' ? 'selected' : '' }}>Khusus Ibu Hamil</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Deskripsi / Persyaratan (Opsional)</label>
                    <textarea name="deskripsi" rows="3" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl px-4 py-3 outline-none font-semibold focus:border-cyan-500 focus:bg-white transition-colors shadow-inner placeholder:text-slate-400" placeholder="Ketik informasi tambahan... (Membawa buku KMS, wajib pakai masker, dll)">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-xl flex gap-3">
                    <i class="fas fa-bell text-emerald-500 text-lg mt-0.5"></i>
                    <div>
                        <h4 class="text-sm font-bold text-emerald-800">Sistem Notifikasi Pintar Aktif</h4>
                        <p class="text-xs text-emerald-600 font-medium mt-1">Setelah disimpan, sistem akan secara otomatis mendeteksi target peserta dan mengirimkan notifikasi ke dasbor akun mereka masing-masing.</p>
                    </div>
                </div>
            </div>

            <div class="px-6 py-5 border-t border-slate-100 bg-slate-50/50 flex justify-end">
                <button type="submit" id="btnSubmit" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-gradient-to-r from-cyan-500 to-cyan-600 text-white font-black text-sm rounded-xl hover:from-cyan-600 hover:to-cyan-700 shadow-[0_8px_20px_rgba(8,145,178,0.25)] hover:-translate-y-0.5 transition-all duration-300">
                    <i class="fas fa-paper-plane"></i> Publikasikan Jadwal
                </button>
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const showLoader = (text = 'MEMPROSES...') => {
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
        const btn = document.getElementById('btnSubmit');
        if(loader) {
            loader.classList.remove('opacity-100');
            loader.classList.add('opacity-0', 'pointer-events-none');
            setTimeout(() => loader.style.display = 'none', 300);
        }
        if(btn) {
            btn.innerHTML = '<i class="fas fa-paper-plane"></i> Publikasikan Jadwal';
            btn.classList.remove('opacity-75', 'cursor-wait');
        }
    });

    document.querySelectorAll('.smooth-route').forEach(link => {
        link.addEventListener('click', function(e) {
            if(this.target !== '_blank' && !e.ctrlKey) showLoader('MEMBATALKAN...');
        });
    });

    document.getElementById('formJadwal').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmit');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim Notifikasi...';
        btn.classList.add('opacity-75', 'cursor-wait');
        showLoader('MENYIMPAN & MENGIRIM NOTIFIKASI...');
    });
</script>
@endpush