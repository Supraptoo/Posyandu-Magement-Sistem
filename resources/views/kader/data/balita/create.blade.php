@extends('layouts.kader')

@section('title', 'Tambah Data Balita')
@section('page-name', 'Pendaftaran Balita')

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
    
    /* CSS Murni untuk Form Input agar dijamin berjalan 100% tanpa error Tailwind Build */
    .form-group {
        margin-bottom: 1.25rem;
    }
    .form-label {
        display: block;
        font-size: 0.70rem;
        font-weight: 800;
        color: #64748b; /* slate-500 */
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.5rem;
    }
    .form-input {
        width: 100%;
        background-color: #f8fafc; /* slate-50 */
        border: 2px solid #e2e8f0; /* slate-200 */
        color: #0f172a; /* slate-900 */
        font-size: 0.875rem;
        border-radius: 0.75rem; /* 12px */
        padding: 0.75rem 1rem;
        outline: none;
        transition: all 0.3s ease;
        font-weight: 600;
        box-shadow: inset 0 2px 4px 0 rgb(0 0 0 / 0.02); /* Inner shadow agar tidak flat */
    }
    .form-input:focus {
        background-color: #ffffff;
        border-color: #6366f1; /* Indigo-500 */
        box-shadow: 0 4px 12px -3px rgba(99, 102, 241, 0.15); /* Shadow luar saat aktif */
        transform: translateY(-1px);
    }
    .form-input::placeholder {
        color: #94a3b8; /* slate-400 */
        font-weight: 500;
    }
    .form-error {
        border-color: #f43f5e !important; /* Rose-500 */
        background-color: #fff1f2 !important; /* Rose-50 */
    }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto animate-slide-up">
    
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-indigo-100 text-indigo-600 mb-4 shadow-inner">
            <i class="fas fa-baby text-3xl"></i>
        </div>
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Pendaftaran Balita</h1>
        <p class="text-slate-500 mt-2 font-medium text-sm max-w-lg mx-auto">Silakan lengkapi formulir di bawah ini dengan data yang valid. Pastikan NIK Ibu sesuai untuk integrasi akun.</p>
    </div>

    <form action="{{ route('kader.data.balita.store') }}" method="POST">
        @csrf
        
        <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden flex flex-col mb-8">
            
            <div class="p-6 sm:p-10 border-b border-slate-100">
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-sm">1</span>
                    <h3 class="text-lg font-extrabold text-slate-800">Identitas Anak</h3>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Nama Lengkap Anak <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required placeholder="Contoh: Muhammad Al-Fatih" class="form-input @error('nama_lengkap') form-error @enderror">
                    @error('nama_lengkap') <p class="text-rose-500 text-xs font-bold mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6">
                    <div class="form-group">
                        <label class="form-label">NIK Balita (Opsional)</label>
                        <input type="number" name="nik" value="{{ old('nik') }}" placeholder="16 Digit Angka" class="form-input @error('nik') form-error @enderror">
                        @error('nik') <p class="text-rose-500 text-xs font-bold mt-1.5">{{ $message }}</p> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jenis Kelamin <span class="text-rose-500">*</span></label>
                        <select name="jenis_kelamin" required class="form-input @error('jenis_kelamin') form-error @enderror">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6">
                    <div class="form-group">
                        <label class="form-label">Tempat Lahir <span class="text-rose-500">*</span></label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required placeholder="Kota Kelahiran" class="form-input @error('tempat_lahir') form-error @enderror">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Lahir <span class="text-rose-500">*</span></label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required class="form-input @error('tanggal_lahir') form-error @enderror">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 mb-0">
                    <div class="form-group mb-0 sm:mb-0">
                        <label class="form-label">Berat Lahir (kg)</label>
                        <input type="number" step="0.01" name="berat_lahir" value="{{ old('berat_lahir') }}" placeholder="Contoh: 3.2" class="form-input">
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Panjang Lahir (cm)</label>
                        <input type="number" step="0.01" name="panjang_lahir" value="{{ old('panjang_lahir') }}" placeholder="Contoh: 50" class="form-input">
                    </div>
                </div>
            </div>

            <div class="p-6 sm:p-10 bg-slate-50/50">
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-8 h-8 rounded-full bg-rose-500 text-white flex items-center justify-center font-bold text-sm">2</span>
                    <h3 class="text-lg font-extrabold text-slate-800">Data Orang Tua</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6">
                    <div class="form-group">
                        <label class="form-label">NIK Ibu Kandung <span class="text-rose-500">*</span></label>
                        <input type="number" name="nik_ibu" value="{{ old('nik_ibu') }}" required placeholder="16 Digit NIK Ibu" class="form-input bg-white @error('nik_ibu') form-error @enderror">
                        @error('nik_ibu') <p class="text-rose-500 text-xs font-bold mt-1.5">{{ $message }}</p> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Ibu Kandung <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_ibu" value="{{ old('nama_ibu') }}" required placeholder="Nama Lengkap Ibu" class="form-input bg-white">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6">
                    <div class="form-group">
                        <label class="form-label">NIK Ayah (Opsional)</label>
                        <input type="number" name="nik_ayah" value="{{ old('nik_ayah') }}" placeholder="16 Digit NIK Ayah" class="form-input bg-white">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Ayah (Opsional)</label>
                        <input type="text" name="nama_ayah" value="{{ old('nama_ayah') }}" placeholder="Nama Lengkap Ayah" class="form-input bg-white">
                    </div>
                </div>

                <div class="form-group mb-0">
                    <label class="form-label">Alamat Domisili <span class="text-rose-500">*</span></label>
                    <textarea name="alamat" rows="3" required placeholder="Alamat lengkap saat ini..." class="form-input bg-white resize-none">{{ old('alamat') }}</textarea>
                </div>
            </div>
            
            <div class="p-6 sm:px-10 sm:py-6 bg-white border-t border-slate-100">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-2xl mx-auto">
                    <a href="{{ route('kader.data.balita.index') }}" class="w-full py-3.5 bg-slate-100 border border-slate-200 text-slate-600 font-bold text-sm rounded-xl hover:bg-slate-200 hover:text-slate-800 transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-times"></i> Batal & Kembali
                    </a>
                    <button type="submit" class="w-full py-3.5 bg-indigo-600 text-white font-extrabold text-sm rounded-xl hover:bg-indigo-700 shadow-[0_4px_12px_rgba(79,70,229,0.3)] hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i> Simpan Data Balita
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
            if (this.value.length > 16) this.value = this.value.slice(0, 16);
        });
    });
</script>
@endsection