@extends('layouts.kader')

@section('title', 'Edit Pemeriksaan')
@section('page-name', 'Edit Pemeriksaan')

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
    .form-input:focus { background-color: #ffffff; border-color: #f59e0b; box-shadow: 0 4px 12px -3px rgba(245, 158, 11, 0.15); transform: translateY(-1px); }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto animate-slide-up">
    
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-amber-100 text-amber-600 mb-4 shadow-inner">
            <i class="fas fa-edit text-3xl"></i>
        </div>
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Edit Pengukuran</h1>
        <p class="text-slate-500 mt-2 font-medium text-sm max-w-lg mx-auto">Memperbaiki data antropometri milik <span class="font-bold text-amber-600">{{ $pemeriksaan->nama_pasien }}</span>.</p>
    </div>

    <form action="{{ route('kader.pemeriksaan.update', $pemeriksaan->id) }}" method="POST">
        @csrf @method('PUT')
        
        <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden flex flex-col mb-8">
            
            <div class="p-6 sm:p-8 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center text-lg"><i class="fas fa-user-injured"></i></div>
                    <div>
                        <h4 class="font-bold text-slate-800">{{ $pemeriksaan->nama_pasien }}</h4>
                        <p class="text-xs font-semibold text-slate-500 mt-0.5">Tanggal Periksa: {{ \Carbon\Carbon::parse($pemeriksaan->tanggal_periksa)->format('d M Y') }}</p>
                    </div>
                </div>
                <div class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-center shadow-sm">
                    <span class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-0.5">Kategori</span>
                    <span class="text-sm font-black text-slate-800 uppercase">{{ $pemeriksaan->kategori_pasien }}</span>
                </div>
            </div>

            <div class="p-6 sm:p-10">
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-4">
                    <div class="form-group mb-0">
                        <label class="form-label">Berat B. (kg) <span class="text-rose-500">*</span></label>
                        <input type="number" step="0.01" name="berat_badan" value="{{ old('berat_badan', $pemeriksaan->berat_badan) }}" required class="form-input text-center">
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Tinggi B. (cm) <span class="text-rose-500">*</span></label>
                        <input type="number" step="0.01" name="tinggi_badan" value="{{ old('tinggi_badan', $pemeriksaan->tinggi_badan) }}" required class="form-input text-center">
                    </div>

                    @if(in_array($pemeriksaan->kategori_pasien, ['balita', 'remaja']))
                    <div class="form-group mb-0">
                        <label class="form-label">L. Lengan (cm)</label>
                        <input type="number" step="0.1" name="lingkar_lengan" value="{{ old('lingkar_lengan', $pemeriksaan->lingkar_lengan) }}" class="form-input text-center">
                    </div>
                    @endif

                    @if($pemeriksaan->kategori_pasien == 'balita')
                    <div class="form-group mb-0">
                        <label class="form-label">L. Kepala (cm)</label>
                        <input type="number" step="0.1" name="lingkar_kepala" value="{{ old('lingkar_kepala', $pemeriksaan->lingkar_kepala) }}" class="form-input text-center">
                    </div>
                    @endif

                    @if(in_array($pemeriksaan->kategori_pasien, ['remaja', 'lansia']))
                    <div class="form-group mb-0 col-span-2 sm:col-span-2">
                        <label class="form-label">Tensi Darah</label>
                        <input type="text" name="tekanan_darah" value="{{ old('tekanan_darah', $pemeriksaan->tekanan_darah) }}" placeholder="120/80" class="form-input text-center">
                    </div>
                    @endif

                    @if($pemeriksaan->kategori_pasien == 'lansia')
                    <div class="form-group mb-0">
                        <label class="form-label">Gula Darah</label>
                        <input type="text" name="gula_darah" value="{{ old('gula_darah', $pemeriksaan->gula_darah) }}" class="form-input text-center">
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Asam Urat</label>
                        <input type="number" step="0.1" name="asam_urat" value="{{ old('asam_urat', $pemeriksaan->asam_urat) }}" class="form-input text-center">
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Kolesterol</label>
                        <input type="number" name="kolesterol" value="{{ old('kolesterol', $pemeriksaan->kolesterol) }}" class="form-input text-center">
                    </div>
                    @endif
                </div>

                <hr class="border-slate-100 my-6">

                <div class="form-group mb-0">
                    <label class="form-label">Keluhan Pasien</label>
                    <textarea name="keluhan" rows="3" class="form-input resize-none">{{ old('keluhan', $pemeriksaan->keluhan) }}</textarea>
                </div>
            </div>
            
            <div class="p-6 sm:px-10 sm:py-6 bg-white border-t border-slate-100">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-2xl mx-auto">
                    <a href="{{ route('kader.pemeriksaan.index') }}" class="w-full py-3.5 bg-slate-100 border border-slate-200 text-slate-600 font-bold text-sm rounded-xl hover:bg-slate-200 transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-times"></i> Batal & Kembali
                    </a>
                    <button type="submit" class="w-full py-3.5 bg-amber-500 text-white font-extrabold text-sm rounded-xl hover:bg-amber-600 shadow-[0_4px_12px_rgba(245,158,11,0.3)] hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i> Update & Kirim Bidan
                    </button>
                </div>
            </div>
            
        </div>
    </form>
</div>
@endsection