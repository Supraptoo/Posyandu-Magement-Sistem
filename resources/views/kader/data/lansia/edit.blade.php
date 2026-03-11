@extends('layouts.kader')

@section('title', 'Edit Data Lansia')
@section('page-name', 'Edit Lansia')

@push('styles')
<style>
    .animate-slide-up {
        opacity: 0;
        animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    @keyframes slideUpFade {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .form-group { margin-bottom: 1.25rem; }
    .form-label {
        display: block; font-size: 0.70rem; font-weight: 800; color: #64748b;
        text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;
    }
    .form-input {
        width: 100%; background-color: #f8fafc; border: 2px solid #e2e8f0; color: #0f172a;
        font-size: 0.875rem; border-radius: 0.75rem; padding: 0.75rem 1rem;
        outline: none; transition: all 0.3s ease; font-weight: 600;
        box-shadow: inset 0 2px 4px 0 rgb(0 0 0 / 0.02);
    }
    .form-input:focus {
        background-color: #ffffff; border-color: #f59e0b; /* Amber */
        box-shadow: 0 4px 12px -3px rgba(245, 158, 11, 0.15); transform: translateY(-1px);
    }
    .form-error { border-color: #f43f5e !important; background-color: #fff1f2 !important; }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto animate-slide-up">
    
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-amber-100 text-amber-600 mb-4 shadow-inner">
            <i class="fas fa-user-edit text-3xl"></i>
        </div>
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Edit Data Lansia</h1>
        <p class="text-slate-500 mt-2 font-medium text-sm max-w-lg mx-auto">Memperbarui informasi profil milik <span class="font-bold text-amber-600">{{ $lansia->nama_lengkap }}</span>.</p>
    </div>

    <form action="{{ route('kader.data.lansia.update', $lansia->id) }}" method="POST">
        @csrf @method('PUT')
        
        <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden flex flex-col mb-8">
            
            <div class="p-6 sm:p-10 border-b border-slate-100">
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-8 h-8 rounded-full bg-amber-500 text-white flex items-center justify-center font-bold text-sm">1</span>
                    <h3 class="text-lg font-extrabold text-slate-800">Identitas Pribadi</h3>
                </div>

                <div class="p-4 bg-amber-100/50 border border-amber-200 rounded-xl flex gap-3 mb-6">
                    <i class="fas fa-exclamation-triangle text-amber-600 mt-0.5 text-sm"></i>
                    <p class="text-xs font-bold text-amber-900 leading-relaxed">
                        Hati-hati jika mengubah <span class="text-amber-700 underline">NIK</span>, sistem akan mencoba memindahkan integrasi ke akun Warga yang baru.
                    </p>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $lansia->nama_lengkap) }}" required class="form-input @error('nama_lengkap') form-error @enderror">
                    @error('nama_lengkap') <p class="text-rose-500 text-xs font-bold mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6">
                    <div class="form-group">
                        <label class="form-label">NIK (Kunci Integrasi) <span class="text-rose-500">*</span></label>
                        <input type="number" name="nik" value="{{ old('nik', $lansia->nik) }}" required class="form-input @error('nik') form-error @enderror">
                        @error('nik') <p class="text-rose-500 text-xs font-bold mt-1.5">{{ $message }}</p> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jenis Kelamin <span class="text-rose-500">*</span></label>
                        <select name="jenis_kelamin" required class="form-input @error('jenis_kelamin') form-error @enderror">
                            <option value="L" {{ old('jenis_kelamin', $lansia->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin', $lansia->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6">
                    <div class="form-group">
                        <label class="form-label">Tempat Lahir <span class="text-rose-500">*</span></label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $lansia->tempat_lahir) }}" required class="form-input @error('tempat_lahir') form-error @enderror">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Lahir <span class="text-rose-500">*</span></label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $lansia->tanggal_lahir->format('Y-m-d')) }}" required class="form-input @error('tanggal_lahir') form-error @enderror">
                    </div>
                </div>

                <div class="form-group mb-0">
                    <label class="form-label">Alamat Lengkap <span class="text-rose-500">*</span></label>
                    <textarea name="alamat" rows="2" required class="form-input resize-none">{{ old('alamat', $lansia->alamat) }}</textarea>
                </div>
            </div>

            <div class="p-6 sm:p-10 bg-amber-50/20">
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-8 h-8 rounded-full bg-slate-400 text-white flex items-center justify-center font-bold text-sm">2</span>
                    <h3 class="text-lg font-extrabold text-slate-800">Riwayat Kesehatan</h3>
                </div>

                <div class="form-group mb-0">
                    <label class="form-label">Penyakit Bawaan</label>
                    <textarea name="penyakit_bawaan" rows="3" class="form-input bg-white resize-none">{{ old('penyakit_bawaan', $lansia->penyakit_bawaan) }}</textarea>
                </div>
            </div>
            
            <div class="p-6 sm:px-10 sm:py-6 bg-white border-t border-slate-100">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-2xl mx-auto">
                    <a href="{{ route('kader.data.lansia.show', $lansia->id) }}" class="w-full py-3.5 bg-slate-100 border border-slate-200 text-slate-600 font-bold text-sm rounded-xl hover:bg-slate-200 hover:text-slate-800 transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-times"></i> Batal & Kembali
                    </a>
                    <button type="submit" class="w-full py-3.5 bg-amber-500 text-white font-extrabold text-sm rounded-xl hover:bg-amber-600 shadow-[0_4px_12px_rgba(245,158,11,0.3)] hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
            
        </div>
    </form>
</div>

<script>
    document.getElementById('tanggal_lahir').max = new Date().toISOString().split('T')[0];
    document.querySelectorAll('input[type="number"]').forEach(input => {
        input.addEventListener('input', function() {
            if (this.name === 'nik' && this.value.length > 16) {
                this.value = this.value.slice(0, 16);
            }
        });
    });
</script>
@endsection