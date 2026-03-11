@extends('layouts.kader')

@section('title', 'Upload Data Import')
@section('page-name', 'Upload Import')

@push('styles')
<style>
    .animate-slide-up { opacity: 0; animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    
    .form-group { margin-bottom: 1.5rem; }
    .form-label { display: block; font-size: 0.70rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; }
    .form-input {
        width: 100%; background-color: #f8fafc; border: 2px dashed #cbd5e1; color: #0f172a;
        font-size: 0.875rem; border-radius: 1rem; padding: 1rem; outline: none; transition: all 0.3s ease; font-weight: 600; text-align: center;
    }
    .form-input:focus, .form-input:hover { background-color: #f0fdf4; border-color: #10b981; border-style: solid; }
    .form-error { border-color: #f43f5e !important; background-color: #fff1f2 !important; border-style: solid !important; }
</style>
@endpush

@section('content')
<div class="max-w-3xl mx-auto animate-slide-up">
    
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-indigo-100 text-indigo-600 mb-4 shadow-inner">
            <i class="fas fa-cloud-upload-alt text-3xl"></i>
        </div>
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Upload Berkas Excel</h1>
        <p class="text-slate-500 mt-2 font-medium text-sm max-w-md mx-auto">Pilih jenis data dan unggah file yang telah Anda isi menggunakan template resmi.</p>
    </div>

    <form action="{{ route('kader.import.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden flex flex-col mb-8">
            
            <div class="p-6 sm:p-10">
                <div class="form-group">
                    <label class="form-label">1. Kategori Data</label>
                    <select name="jenis_data" id="jenis_data" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl px-4 py-3.5 outline-none font-bold shadow-inner focus:bg-white focus:border-indigo-500 transition-colors @error('jenis_data') form-error @enderror">
                        <option value="">-- Pilih Jenis Data --</option>
                        <option value="balita" {{ old('jenis_data', $type ?? '') == 'balita' ? 'selected' : '' }}>🍼 Data Balita</option>
                        <option value="remaja" {{ old('jenis_data', $type ?? '') == 'remaja' ? 'selected' : '' }}>🎓 Data Remaja</option>
                        <option value="lansia" {{ old('jenis_data', $type ?? '') == 'lansia' ? 'selected' : '' }}>👴 Data Lansia</option>
                    </select>
                    @error('jenis_data') <p class="text-rose-500 text-xs font-bold mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div class="form-group mb-0">
                    <label class="form-label">2. Pilih File Excel / CSV</label>
                    <div class="relative">
                        <input type="file" name="file" id="file" accept=".xlsx,.xls,.csv" required class="form-input @error('file') form-error @enderror">
                    </div>
                    @error('file') <p class="text-rose-500 text-xs font-bold mt-1.5 text-center">{{ $message }}</p> @enderror
                    <p class="text-center text-xs font-bold text-slate-400 mt-2">Maks. 5 MB (.xlsx, .csv)</p>
                </div>
            </div>
            
            <div class="p-6 sm:px-10 sm:py-6 bg-slate-50 border-t border-slate-100 flex flex-col-reverse sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <a href="{{ route('kader.import.index') }}" class="w-full sm:w-auto px-6 py-3.5 bg-white border border-slate-200 text-slate-600 font-bold text-sm rounded-xl hover:bg-slate-100 transition-colors flex items-center justify-center gap-2">
                        Batal
                    </a>
                    <button type="button" onclick="downloadTemplate()" class="w-full sm:w-auto px-6 py-3.5 bg-white border border-slate-200 text-indigo-600 font-bold text-sm rounded-xl hover:bg-indigo-50 transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-download"></i> Template
                    </button>
                </div>

                <button type="submit" class="w-full sm:w-auto px-8 py-3.5 bg-indigo-600 text-white font-black text-sm rounded-xl hover:bg-indigo-700 shadow-[0_4px_12px_rgba(79,70,229,0.3)] hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                    <i class="fas fa-paper-plane"></i> Proses Data
                </button>
            </div>
            
        </div>
    </form>
</div>

@push('scripts')
<script>
function downloadTemplate() {
    const jenisData = document.getElementById('jenis_data').value;
    if (!jenisData) {
        alert('Silakan pilih kategori data terlebih dahulu pada dropdown di atas.');
        return;
    }
    window.location.href = "{{ route('kader.import.download-template', '') }}/" + jenisData;
}
</script>
@endpush
@endsection