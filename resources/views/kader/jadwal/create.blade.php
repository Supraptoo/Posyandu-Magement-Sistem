@extends('layouts.kader')

@section('title', 'Buat Jadwal')
@section('page-name', 'Buat Jadwal Posyandu')

@push('styles')
<style>
    .animate-slide-up { opacity: 0; animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    
    .form-group { margin-bottom: 1.25rem; }
    .form-label { display: block; font-size: 0.70rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; }
    .form-input {
        width: 100%; background-color: #f8fafc; border: 2px solid #e2e8f0; color: #0f172a;
        font-size: 0.875rem; border-radius: 0.75rem; padding: 0.75rem 1rem;
        outline: none; transition: all 0.3s ease; font-weight: 600; box-shadow: inset 0 2px 4px 0 rgb(0 0 0 / 0.02);
    }
    .form-input:focus { background-color: #ffffff; border-color: #8b5cf6; box-shadow: 0 4px 12px -3px rgba(139, 92, 246, 0.15); transform: translateY(-1px); }
    .form-error { border-color: #f43f5e !important; background-color: #fff1f2 !important; }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto animate-slide-up">
    
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-violet-100 text-violet-600 mb-4 shadow-inner">
            <i class="fas fa-calendar-plus text-3xl"></i>
        </div>
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Buat Jadwal Baru</h1>
        <p class="text-slate-500 mt-2 font-medium text-sm max-w-lg mx-auto">Atur kegiatan posyandu. Setelah disimpan, Anda bisa mem-broadcast info ini ke warga.</p>
    </div>

    <form action="{{ route('kader.jadwal.store') }}" method="POST">
        @csrf
        
        <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden flex flex-col mb-8">
            
            <div class="p-6 sm:p-10 border-b border-slate-100">
                
                <div class="form-group">
                    <label class="form-label">Nama / Judul Kegiatan <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul') }}" required placeholder="Contoh: Posyandu Balita Rutin Bulan April" class="form-input @error('judul') form-error @enderror">
                    @error('judul') <p class="text-rose-500 text-xs font-bold mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6">
                    <div class="form-group">
                        <label class="form-label">Target Peserta <span class="text-rose-500">*</span></label>
                        <select name="target_peserta" required class="form-input">
                            <option value="semua" {{ old('target_peserta') == 'semua' ? 'selected' : '' }}>Semua Warga</option>
                            <option value="balita" {{ old('target_peserta') == 'balita' ? 'selected' : '' }}>Khusus Balita & Ibu</option>
                            <option value="remaja" {{ old('target_peserta') == 'remaja' ? 'selected' : '' }}>Khusus Remaja</option>
                            <option value="lansia" {{ old('target_peserta') == 'lansia' ? 'selected' : '' }}>Khusus Lansia</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kategori / Jenis Acara <span class="text-rose-500">*</span></label>
                        <select name="kategori" required class="form-input">
                            <option value="posyandu" {{ old('kategori') == 'posyandu' ? 'selected' : '' }}>Posyandu Rutin</option>
                            <option value="imunisasi" {{ old('kategori') == 'imunisasi' ? 'selected' : '' }}>Imunisasi Massal</option>
                            <option value="pemeriksaan" {{ old('kategori') == 'pemeriksaan' ? 'selected' : '' }}>Pemeriksaan Khusus (Lab)</option>
                            <option value="konseling" {{ old('kategori') == 'konseling' ? 'selected' : '' }}>Penyuluhan / Konseling</option>
                        </select>
                    </div>
                </div>

            </div>

            <div class="p-6 sm:p-10 bg-slate-50/50">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-x-6">
                    <div class="form-group">
                        <label class="form-label">Tanggal Acara <span class="text-rose-500">*</span></label>
                        <input type="date" name="tanggal" value="{{ old('tanggal') }}" required min="{{ date('Y-m-d') }}" class="form-input bg-white">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Waktu Mulai <span class="text-rose-500">*</span></label>
                        <input type="time" name="waktu_mulai" value="{{ old('waktu_mulai', '08:00') }}" required class="form-input bg-white">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Waktu Selesai <span class="text-rose-500">*</span></label>
                        <input type="time" name="waktu_selesai" value="{{ old('waktu_selesai', '12:00') }}" required class="form-input bg-white">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Lokasi <span class="text-rose-500">*</span></label>
                    <input type="text" name="lokasi" value="{{ old('lokasi', 'Balai Desa') }}" required class="form-input bg-white">
                </div>

                <div class="form-group mb-0">
                    <label class="form-label">Deskripsi / Persyaratan (Opsional)</label>
                    <textarea name="deskripsi" rows="3" placeholder="Contoh: Harap membawa buku KIA dan fotokopi KK..." class="form-input bg-white resize-none">{{ old('deskripsi') }}</textarea>
                </div>
            </div>
            
            <div class="p-6 sm:px-10 sm:py-6 bg-white border-t border-slate-100">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-2xl mx-auto">
                    <a href="{{ route('kader.jadwal.index') }}" class="w-full py-3.5 bg-slate-100 border border-slate-200 text-slate-600 font-bold text-sm rounded-xl hover:bg-slate-200 hover:text-slate-800 transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="w-full py-3.5 bg-violet-600 text-white font-extrabold text-sm rounded-xl hover:bg-violet-700 shadow-[0_4px_12px_rgba(139,92,246,0.3)] hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i> Simpan Jadwal
                    </button>
                </div>
            </div>
            
        </div>
    </form>
</div>
@endsection