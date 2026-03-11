@extends('layouts.kader')

@section('title', 'Import Data')
@section('page-name', 'Import Data Masal')

@push('styles')
<style>
    .animate-slide-up { opacity: 0; animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endpush

@section('content')
<div class="max-w-6xl mx-auto animate-slide-up">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-[18px] bg-indigo-100 text-indigo-600 flex items-center justify-center text-2xl shadow-inner border border-indigo-200/50 transform -rotate-3">
                <i class="fas fa-file-import"></i>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Import Data Masal</h1>
                <p class="text-slate-500 mt-1 font-medium text-sm">Pindahkan data Excel lama ke sistem dengan cepat.</p>
            </div>
        </div>
        <a href="{{ route('kader.import.history') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-white border border-slate-200 text-slate-700 font-extrabold text-sm rounded-xl hover:bg-slate-50 shadow-sm transition-all">
            <i class="fas fa-history text-slate-400"></i> Riwayat Import
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-6 hover:-translate-y-1 transition-transform duration-300">
            <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center text-xl mb-4 shadow-inner">
                <i class="fas fa-baby"></i>
            </div>
            <h3 class="text-lg font-extrabold text-slate-800 mb-1">Data Balita</h3>
            <p class="text-xs font-medium text-slate-500 mb-6 line-clamp-2">Format Excel khusus pendaftaran anak dan integrasi NIK Ibu.</p>
            <div class="grid grid-cols-2 gap-2">
                <a href="{{ route('kader.import.download-template', 'balita') }}" class="py-2.5 bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200 rounded-xl text-xs font-bold flex items-center justify-center gap-1.5 transition-colors">
                    <i class="fas fa-download"></i> Template
                </a>
                <a href="{{ route('kader.import.create') }}?type=balita" class="py-2.5 bg-rose-50 text-rose-600 hover:bg-rose-100 border border-rose-200 rounded-xl text-xs font-bold flex items-center justify-center gap-1.5 transition-colors">
                    <i class="fas fa-upload"></i> Upload
                </a>
            </div>
        </div>

        <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-6 hover:-translate-y-1 transition-transform duration-300">
            <div class="w-12 h-12 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center text-xl mb-4 shadow-inner">
                <i class="fas fa-child"></i>
            </div>
            <h3 class="text-lg font-extrabold text-slate-800 mb-1">Data Remaja</h3>
            <p class="text-xs font-medium text-slate-500 mb-6 line-clamp-2">Format Excel untuk skrining data diri dan pendidikan remaja.</p>
            <div class="grid grid-cols-2 gap-2">
                <a href="{{ route('kader.import.download-template', 'remaja') }}" class="py-2.5 bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200 rounded-xl text-xs font-bold flex items-center justify-center gap-1.5 transition-colors">
                    <i class="fas fa-download"></i> Template
                </a>
                <a href="{{ route('kader.import.create') }}?type=remaja" class="py-2.5 bg-sky-50 text-sky-600 hover:bg-sky-100 border border-sky-200 rounded-xl text-xs font-bold flex items-center justify-center gap-1.5 transition-colors">
                    <i class="fas fa-upload"></i> Upload
                </a>
            </div>
        </div>

        <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-6 hover:-translate-y-1 transition-transform duration-300">
            <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl mb-4 shadow-inner">
                <i class="fas fa-user-clock"></i>
            </div>
            <h3 class="text-lg font-extrabold text-slate-800 mb-1">Data Lansia</h3>
            <p class="text-xs font-medium text-slate-500 mb-6 line-clamp-2">Format Excel pendaftaran lansia beserta riwayat penyakit bawaan.</p>
            <div class="grid grid-cols-2 gap-2">
                <a href="{{ route('kader.import.download-template', 'lansia') }}" class="py-2.5 bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200 rounded-xl text-xs font-bold flex items-center justify-center gap-1.5 transition-colors">
                    <i class="fas fa-download"></i> Template
                </a>
                <a href="{{ route('kader.import.create') }}?type=lansia" class="py-2.5 bg-emerald-50 text-emerald-600 hover:bg-emerald-100 border border-emerald-200 rounded-xl text-xs font-bold flex items-center justify-center gap-1.5 transition-colors">
                    <i class="fas fa-upload"></i> Upload
                </a>
            </div>
        </div>

    </div>

    <div class="bg-indigo-50/50 border border-indigo-100 rounded-[24px] overflow-hidden">
        <div class="px-6 py-5 border-b border-indigo-100 flex items-center gap-3 bg-white">
            <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center"><i class="fas fa-info"></i></div>
            <h3 class="text-base font-extrabold text-indigo-900">Panduan & Tata Cara Import</h3>
        </div>
        <div class="p-6 sm:p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h6 class="text-xs font-black text-indigo-400 uppercase tracking-widest mb-4">Langkah Pengisian</h6>
                <ol class="space-y-3 text-sm font-medium text-slate-700">
                    <li class="flex gap-3"><span class="w-6 h-6 rounded-full bg-white border border-indigo-200 text-indigo-600 flex items-center justify-center shrink-0 font-bold text-xs">1</span> Download file template terlebih dahulu.</li>
                    <li class="flex gap-3"><span class="w-6 h-6 rounded-full bg-white border border-indigo-200 text-indigo-600 flex items-center justify-center shrink-0 font-bold text-xs">2</span> Isi baris data sesuai kolom yang diminta tanpa mengubah judul kolom (Header).</li>
                    <li class="flex gap-3"><span class="w-6 h-6 rounded-full bg-white border border-indigo-200 text-indigo-600 flex items-center justify-center shrink-0 font-bold text-xs">3</span> Pastikan format Tanggal adalah <strong>YYYY-MM-DD</strong>.</li>
                    <li class="flex gap-3"><span class="w-6 h-6 rounded-full bg-white border border-indigo-200 text-indigo-600 flex items-center justify-center shrink-0 font-bold text-xs">4</span> Simpan, lalu Upload kembali melalui sistem.</li>
                </ol>
            </div>
            <div>
                <h6 class="text-xs font-black text-indigo-400 uppercase tracking-widest mb-4">Peringatan Penting</h6>
                <ul class="space-y-3 text-sm font-medium text-slate-700">
                    <li class="flex items-center gap-2"><i class="fas fa-check-circle text-emerald-500"></i> Maksimal ukuran file adalah <strong>5MB</strong>.</li>
                    <li class="flex items-center gap-2"><i class="fas fa-check-circle text-emerald-500"></i> Ekstensi file harus berupa <strong>.xlsx, .xls, atau .csv</strong>.</li>
                    <li class="flex items-center gap-2"><i class="fas fa-exclamation-triangle text-amber-500"></i> NIK (Nomor Induk Kependudukan) harus <strong>UNIK</strong>.</li>
                    <li class="flex items-center gap-2"><i class="fas fa-exclamation-triangle text-amber-500"></i> Jika ada NIK ganda di sistem, data pada baris tersebut akan diabaikan.</li>
                </ul>
            </div>
        </div>
    </div>

</div>
@endsection