@extends('layouts.kader')

@section('title', 'Detail Import')
@section('page-name', 'Log Analisis Sistem')

@push('styles')
<style>
    .animate-slide-up { opacity: 0; animation: slideUpFade 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    
    .terminal-window {
        background: #0f172a; border-radius: 20px; color: #10b981; font-family: 'Courier New', monospace;
        padding: 1.5rem; overflow-x: auto; box-shadow: inset 0 4px 20px rgba(0,0,0,0.5);
    }
</style>
@endpush

@section('content')
<div class="max-w-5xl mx-auto animate-slide-up">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('kader.import.history') }}" class="smooth-route w-12 h-12 bg-white border border-slate-200 text-slate-500 rounded-2xl flex items-center justify-center hover:bg-slate-50 hover:text-indigo-600 transition-all shadow-sm">
                <i class="fas fa-arrow-left text-lg"></i>
            </a>
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight font-poppins">Laporan Eksekusi Data</h1>
                <p class="text-[13px] font-bold text-slate-400 mt-0.5">Analisis hasil pemrosesan file ke dalam sistem database.</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[32px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.03)] overflow-hidden mb-8">
        
        <div class="p-8 md:p-10 border-b border-slate-100 bg-gradient-to-br from-slate-50 to-indigo-50/30 flex flex-col sm:flex-row items-center sm:items-start gap-6">
            <div class="w-24 h-24 rounded-[24px] bg-emerald-100 text-emerald-600 flex items-center justify-center text-4xl shadow-inner border border-emerald-200 shrink-0 transform -rotate-6">
                <i class="fas fa-file-excel"></i>
            </div>
            <div class="text-center sm:text-left flex-1 mt-2">
                <h2 class="text-2xl font-black text-slate-800 break-all mb-3 font-poppins">{{ $import->nama_file }}</h2>
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-3">
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-white text-indigo-600 text-[11px] font-black uppercase rounded-xl border border-indigo-100 shadow-sm tracking-widest">
                        <i class="fas fa-database"></i> Tujuan: {{ $import->jenis_data }}
                    </span>
                    
                    @if($import->status == 'completed')
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 text-emerald-700 bg-emerald-50 border border-emerald-200 text-[11px] font-black uppercase rounded-xl shadow-sm tracking-widest">
                            <i class="fas fa-check-circle"></i> Selesai Sempurna
                        </span>
                    @elseif($import->status == 'failed')
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 text-rose-700 bg-rose-50 border border-rose-200 text-[11px] font-black uppercase rounded-xl shadow-sm tracking-widest">
                            <i class="fas fa-times-circle"></i> Eksekusi Gagal
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 text-amber-700 bg-amber-50 border border-amber-200 text-[11px] font-black uppercase rounded-xl shadow-sm tracking-widest">
                            <i class="fas fa-spinner fa-spin"></i> Proses Menunggu
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="p-8 md:p-10">
            <h3 class="text-[12px] font-black text-slate-400 uppercase tracking-widest mb-6 flex items-center gap-2"><i class="fas fa-chart-pie"></i> Metrik Data Terbaca</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
                <div class="p-6 bg-slate-50 border border-slate-100 rounded-[24px] text-center shadow-sm relative overflow-hidden">
                    <i class="fas fa-list-ol absolute -right-4 -bottom-4 text-6xl text-slate-200/50"></i>
                    <p class="text-[11px] font-black text-slate-500 uppercase tracking-widest mb-2 relative z-10">Kapasitas Baris</p>
                    <p class="text-4xl font-black text-slate-800 font-poppins relative z-10">{{ $import->total_data ?? '0' }}</p>
                </div>
                <div class="p-6 bg-emerald-50 border border-emerald-100 rounded-[24px] text-center shadow-sm relative overflow-hidden">
                    <i class="fas fa-check absolute -right-4 -bottom-4 text-6xl text-emerald-200/50"></i>
                    <p class="text-[11px] font-black text-emerald-600 uppercase tracking-widest mb-2 relative z-10">Sukses Disimpan</p>
                    <p class="text-4xl font-black text-emerald-600 font-poppins relative z-10">{{ $import->data_berhasil ?? '0' }}</p>
                </div>
                <div class="p-6 bg-rose-50 border border-rose-100 rounded-[24px] text-center shadow-sm relative overflow-hidden">
                    <i class="fas fa-times absolute -right-4 -bottom-4 text-6xl text-rose-200/50"></i>
                    <p class="text-[11px] font-black text-rose-600 uppercase tracking-widest mb-2 relative z-10">Gagal / Ditolak</p>
                    <p class="text-4xl font-black text-rose-600 font-poppins relative z-10">{{ $import->data_gagal ?? '0' }}</p>
                </div>
            </div>

            <h3 class="text-[12px] font-black text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2"><i class="fas fa-terminal"></i> Log Mesin Server</h3>
            
            <div class="terminal-window">
                <div class="flex items-center gap-2 mb-3 pb-3 border-b border-emerald-900/50">
                    <div class="w-3 h-3 rounded-full bg-rose-500"></div>
                    <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                    <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                    <span class="text-slate-400 text-[10px] ml-2 font-sans tracking-widest uppercase">System_Console_Log</span>
                </div>
                <p class="text-[13px] leading-loose break-words whitespace-pre-wrap">
> Memulai proses analisis berkas...
> Membaca struktur kolom Excel...
> Eksekusi query database...

<span class="{{ $import->status == 'failed' ? 'text-rose-400 font-bold' : 'text-emerald-400' }}">[RESPONSE] : {{ $import->catatan ?? 'Sistem tidak memberikan log balasan.' }}</span>

> Proses ditutup pada: {{ $import->updated_at->format('Y-m-d H:i:s') }}
                </p>
            </div>

        </div>

    </div>
</div>
@endsection