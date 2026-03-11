@extends('layouts.kader')

@section('title', 'Laporan Lansia')
@section('page-name', 'Laporan Posyandu')

@push('styles')
<style>
    .animate-slide-up { opacity: 0; animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @media print {
        body { background-color: white !important; }
        #sidebar, header, .print\:hidden, .flash-message { display: none !important; }
        .lg\:ml-\[280px\] { margin-left: 0 !important; }
        main { padding: 0 !important; margin: 0 !important; max-width: 100% !important; }
        .paper-preview { border: none !important; box-shadow: none !important; margin: 0 !important; padding: 0 !important; max-width: 100% !important; }
    }
</style>
@endpush

@section('content')
<div class="max-w-6xl mx-auto animate-slide-up">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-[18px] bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl shadow-inner border border-emerald-200/50">
                <i class="fas fa-user-clock"></i>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Laporan Lansia</h1>
                <p class="text-slate-500 mt-1 font-medium text-sm">Rekapitulasi skrining lansia (PTM & Lab Sederhana).</p>
            </div>
        </div>
        
        <a href="{{ route('kader.laporan.generate', ['type' => 'lansia', 'bulan' => $bulan, 'tahun' => $tahun]) }}" class="inline-flex items-center justify-center gap-2 px-7 py-3.5 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white font-black text-sm rounded-xl hover:from-emerald-600 hover:to-emerald-700 shadow-[0_8px_20px_rgba(16,185,129,0.25)] hover:shadow-[0_10px_25px_rgba(16,185,129,0.35)] hover:-translate-y-0.5 transition-all duration-300">
            <i class="fas fa-download text-lg mr-1"></i> Unduh PDF Resmi
        </a>
    </div>

    <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-6 mb-6">
        <form action="{{ route('kader.laporan.lansia') }}" method="GET" class="flex flex-col sm:flex-row items-end gap-4">
            <div class="w-full sm:w-1/3">
                <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Pilih Bulan</label>
                <select name="bulan" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl px-4 py-3 outline-none font-medium focus:border-emerald-500 focus:bg-white transition-colors shadow-inner">
                    @foreach(range(1, 12) as $m)
                        <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}" {{ $bulan == str_pad($m, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month((int)$m)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="w-full sm:w-1/3">
                <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Pilih Tahun</label>
                <select name="tahun" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl px-4 py-3 outline-none font-medium focus:border-emerald-500 focus:bg-white transition-colors shadow-inner">
                    @foreach(range(date('Y')-2, date('Y')) as $y)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="w-full sm:w-1/3">
                <button type="submit" class="w-full py-3 bg-emerald-100 text-emerald-700 font-extrabold text-sm rounded-xl hover:bg-emerald-200 hover:text-emerald-800 transition-colors flex items-center justify-center gap-2 shadow-sm">
                    <i class="fas fa-filter"></i> Tampilkan Laporan
                </button>
            </div>
        </form>
    </div>

    <div class="bg-slate-100/50 p-4 sm:p-8 rounded-[24px] border border-slate-200/80 shadow-inner overflow-x-auto print:bg-white print:p-0 print:border-none print:shadow-none">
        
        <div class="mb-6 p-4 bg-white border border-slate-200 rounded-2xl flex items-center gap-3 shadow-sm print:hidden">
            <div class="w-10 h-10 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center shrink-0">
                <i class="fas fa-eye"></i>
            </div>
            <p class="text-xs font-bold text-slate-600 leading-relaxed">
                <span class="text-slate-800">Mode Pratinjau (Preview).</span> Tampilan di bawah adalah simulasi kertas A4 Landscape. Kop surat asli dan ukuran akan disesuaikan otomatis saat Anda mengunduh PDF.
            </p>
        </div>

        <div class="paper-preview bg-white mx-auto p-10 sm:p-12 shadow-xl border border-slate-200" style="min-width: 1000px; max-width: 1122px; border-radius: 4px;">
            @include('kader.laporan.templates.table-lansia')
        </div>
    </div>

</div>
@endsection