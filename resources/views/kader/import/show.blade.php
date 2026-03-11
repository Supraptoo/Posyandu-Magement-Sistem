@extends('layouts.kader')

@section('title', 'Detail Import')
@section('page-name', 'Log Detail')

@push('styles')
<style>
    .animate-slide-up { opacity: 0; animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto animate-slide-up">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('kader.import.history') }}" class="w-10 h-10 bg-white border border-slate-200 text-slate-500 rounded-xl flex items-center justify-center hover:bg-slate-50 transition-colors shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Status Import</h1>
        </div>
    </div>

    <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
        
        <div class="p-8 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row items-center sm:items-start gap-6">
            <div class="w-20 h-20 rounded-3xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-3xl shadow-inner border border-indigo-200/50 shrink-0 transform -rotate-3">
                <i class="fas fa-file-excel"></i>
            </div>
            <div class="text-center sm:text-left flex-1 mt-1">
                <h2 class="text-xl font-extrabold text-slate-800 break-all">{{ $import->nama_file }}</h2>
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mt-2">
                    <span class="inline-block px-3 py-1 bg-white text-slate-600 text-[10px] font-black uppercase rounded-lg border border-slate-200 tracking-widest">
                        Target: {{ $import->jenis_data }}
                    </span>
                    <span class="inline-block px-3 py-1 text-white text-[10px] font-black uppercase rounded-lg tracking-widest 
                        {{ $import->status == 'completed' ? 'bg-emerald-500' : ($import->status == 'failed' ? 'bg-rose-500' : 'bg-amber-500') }}">
                        Status: {{ $import->status }}
                    </span>
                </div>
            </div>
        </div>

        <div class="p-8">
            <h3 class="text-xs font-extrabold text-slate-400 uppercase tracking-widest mb-4">Statistik Proses Data</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                <div class="p-5 bg-slate-50 border border-slate-100 rounded-2xl text-center">
                    <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Total Baris File</p>
                    <p class="text-3xl font-black text-slate-800">{{ $import->total_data ?? '0' }}</p>
                </div>
                <div class="p-5 bg-emerald-50 border border-emerald-100 rounded-2xl text-center">
                    <p class="text-[10px] font-extrabold text-emerald-600 uppercase tracking-widest mb-1">Berhasil Disimpan</p>
                    <p class="text-3xl font-black text-emerald-600">{{ $import->data_berhasil ?? '0' }}</p>
                </div>
                <div class="p-5 bg-rose-50 border border-rose-100 rounded-2xl text-center">
                    <p class="text-[10px] font-extrabold text-rose-600 uppercase tracking-widest mb-1">Ditolak / Gagal</p>
                    <p class="text-3xl font-black text-rose-600">{{ $import->data_gagal ?? '0' }}</p>
                </div>
            </div>

            @if($import->catatan)
            <div class="p-5 rounded-2xl border 
                {{ $import->status == 'completed' ? 'bg-emerald-50 border-emerald-200 text-emerald-800' : 
                  ($import->status == 'failed' ? 'bg-rose-50 border-rose-200 text-rose-800' : 'bg-slate-50 border-slate-200 text-slate-800') }}">
                <div class="flex gap-3">
                    <i class="fas fa-terminal mt-1"></i>
                    <div>
                        <p class="text-[11px] font-black uppercase tracking-widest opacity-60 mb-1">Log Sistem</p>
                        <p class="text-sm font-medium leading-relaxed">{{ $import->catatan }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

    </div>
</div>
@endsection