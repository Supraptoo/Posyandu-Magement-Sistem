@extends('layouts.kader')

@section('title', 'Detail Pemeriksaan')
@section('page-name', 'Detail Pemeriksaan')

@push('styles')
<style>
    .animate-slide-up { opacity: 0; animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endpush

@section('content')
<div class="max-w-5xl mx-auto animate-slide-up">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('kader.pemeriksaan.index') }}" class="w-10 h-10 bg-white border border-slate-200 text-slate-500 rounded-xl flex items-center justify-center hover:bg-slate-50 transition-colors shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Laporan Pemeriksaan</h1>
        </div>
        
        @if($pemeriksaan->status_verifikasi == 'pending')
        <a href="{{ route('kader.pemeriksaan.edit', $pemeriksaan->id) }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-amber-500 text-white font-extrabold text-sm rounded-xl hover:bg-amber-600 shadow-sm transition-all hover:-translate-y-0.5">
            <i class="fas fa-edit"></i> Edit Data
        </a>
        @endif
    </div>

    @if($pemeriksaan->status_verifikasi == 'pending')
    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 mb-6 flex items-center gap-4 shadow-sm">
        <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center text-xl shrink-0 animate-pulse"><i class="fas fa-hourglass-half"></i></div>
        <div>
            <h4 class="font-extrabold text-amber-900 text-base">Menunggu Verifikasi Bidan</h4>
            <p class="text-sm font-medium text-amber-700 mt-0.5">Data fisik telah tersimpan. Bidan akan menambahkan diagnosa dan tindakan medis.</p>
        </div>
    </div>
    @elseif($pemeriksaan->status_verifikasi == 'verified')
    <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-5 mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-xl shrink-0"><i class="fas fa-check-double"></i></div>
            <div>
                <h4 class="font-extrabold text-emerald-900 text-base">Telah Diverifikasi Bidan</h4>
                <p class="text-sm font-medium text-emerald-700 mt-0.5">Hasil pemeriksaan medis sudah final dan notifikasi telah dikirim ke Warga.</p>
            </div>
        </div>
        <div class="text-left sm:text-right">
            <p class="text-[10px] font-extrabold text-emerald-600 uppercase tracking-widest">Diverifikasi Oleh</p>
            <p class="text-sm font-bold text-emerald-900">{{ $pemeriksaan->bidan->name ?? 'Bidan Posyandu' }}</p>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-1">
            <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-sm overflow-hidden h-full">
                <div class="p-6 text-center border-b border-slate-100 bg-slate-50/50">
                    <div class="w-20 h-20 bg-indigo-100 text-indigo-600 rounded-[20px] mx-auto flex items-center justify-center text-3xl font-black mb-4 shadow-inner border border-indigo-200/50">
                        {{ strtoupper(substr($pemeriksaan->nama_pasien, 0, 1)) }}
                    </div>
                    <h3 class="font-extrabold text-slate-800 text-lg">{{ $pemeriksaan->nama_pasien }}</h3>
                    <span class="inline-block px-3 py-1 bg-slate-200 text-slate-600 text-[10px] font-black uppercase rounded-lg mt-2 tracking-wider">{{ $pemeriksaan->kategori_pasien }}</span>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Tanggal Kunjungan</p>
                        <p class="text-sm font-bold text-slate-800"><i class="fas fa-calendar text-indigo-400 mr-2"></i> {{ \Carbon\Carbon::parse($pemeriksaan->tanggal_periksa)->format('l, d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Keluhan Awal</p>
                        <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl">
                            <p class="text-sm font-medium text-slate-700 italic">"{{ $pemeriksaan->keluhan ?? 'Tidak ada keluhan yang disampaikan.' }}"</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 flex flex-col gap-6">
            
            <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center"><i class="fas fa-ruler-combined"></i></div>
                    <h3 class="text-base font-extrabold text-slate-800">Hasil Pengukuran Fisik (Oleh Kader)</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 text-center">
                            <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Berat Badan</p>
                            <p class="text-xl font-black text-slate-800">{{ $pemeriksaan->berat_badan ?? '-' }}<span class="text-xs text-slate-500 font-medium ml-1">kg</span></p>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 text-center">
                            <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Tinggi Badan</p>
                            <p class="text-xl font-black text-slate-800">{{ $pemeriksaan->tinggi_badan ?? '-' }}<span class="text-xs text-slate-500 font-medium ml-1">cm</span></p>
                        </div>
                        
                        @if(in_array($pemeriksaan->kategori_pasien, ['remaja', 'lansia']))
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 text-center col-span-2">
                            <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Tensi Darah</p>
                            <p class="text-xl font-black text-slate-800">{{ $pemeriksaan->tekanan_darah ?? '-' }}<span class="text-xs text-slate-500 font-medium ml-1">mmHg</span></p>
                        </div>
                        @endif

                        @if($pemeriksaan->kategori_pasien == 'balita')
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 text-center">
                            <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">L. Kepala</p>
                            <p class="text-xl font-black text-slate-800">{{ $pemeriksaan->lingkar_kepala ?? '-' }}<span class="text-xs text-slate-500 font-medium ml-1">cm</span></p>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 text-center">
                            <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">L. Lengan</p>
                            <p class="text-xl font-black text-slate-800">{{ $pemeriksaan->lingkar_lengan ?? '-' }}<span class="text-xs text-slate-500 font-medium ml-1">cm</span></p>
                        </div>
                        @endif
                    </div>

                    @if($pemeriksaan->kategori_pasien == 'lansia')
                    <div class="grid grid-cols-3 gap-4 mt-4">
                        <div class="p-3 bg-white border border-slate-200 rounded-xl text-center shadow-sm">
                            <p class="text-[9px] font-bold text-slate-400 uppercase">Gula Darah</p>
                            <p class="text-sm font-black text-slate-700">{{ $pemeriksaan->gula_darah ?? '-' }}</p>
                        </div>
                        <div class="p-3 bg-white border border-slate-200 rounded-xl text-center shadow-sm">
                            <p class="text-[9px] font-bold text-slate-400 uppercase">Asam Urat</p>
                            <p class="text-sm font-black text-slate-700">{{ $pemeriksaan->asam_urat ?? '-' }}</p>
                        </div>
                        <div class="p-3 bg-white border border-slate-200 rounded-xl text-center shadow-sm">
                            <p class="text-[9px] font-bold text-slate-400 uppercase">Kolesterol</p>
                            <p class="text-sm font-black text-slate-700">{{ $pemeriksaan->kolesterol ?? '-' }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="bg-indigo-50/30 rounded-[24px] border border-indigo-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-indigo-100 flex items-center gap-3 bg-white">
                    <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center"><i class="fas fa-user-md"></i></div>
                    <h3 class="text-base font-extrabold text-indigo-900">Catatan Medis (Oleh Bidan)</h3>
                </div>
                
                @if($pemeriksaan->status_verifikasi == 'verified')
                <div class="p-6 space-y-5">
                    <div class="flex items-center justify-between p-4 bg-white border border-indigo-100 rounded-2xl shadow-sm">
                        <span class="text-xs font-extrabold text-slate-500 uppercase tracking-widest">Status Gizi</span>
                        <span class="px-4 py-1.5 bg-indigo-100 text-indigo-700 font-black rounded-lg uppercase tracking-wide border border-indigo-200">{{ $pemeriksaan->status_gizi ?? 'Normal' }}</span>
                    </div>

                    <div>
                        <p class="text-[11px] font-extrabold text-indigo-400 uppercase tracking-widest mb-2">Diagnosa Bidan</p>
                        <div class="p-4 bg-white border border-indigo-100 rounded-2xl shadow-sm">
                            <p class="text-sm font-semibold text-slate-800 leading-relaxed">{{ $pemeriksaan->diagnosa ?? 'Belum ada catatan diagnosa.' }}</p>
                        </div>
                    </div>

                    <div>
                        <p class="text-[11px] font-extrabold text-indigo-400 uppercase tracking-widest mb-2">Tindakan / Resep Edukasi</p>
                        <div class="p-4 bg-white border border-indigo-100 rounded-2xl shadow-sm">
                            <p class="text-sm font-semibold text-slate-800 leading-relaxed">{{ $pemeriksaan->tindakan ?? 'Belum ada tindakan atau resep.' }}</p>
                        </div>
                    </div>
                </div>
                @else
                <div class="p-10 text-center">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-indigo-200 mx-auto mb-3 shadow-sm border border-indigo-50"><i class="fas fa-lock text-2xl"></i></div>
                    <p class="text-sm font-bold text-slate-500">Menunggu Bidan</p>
                    <p class="text-xs text-slate-400 mt-1 max-w-xs mx-auto">Kolom ini akan terisi otomatis setelah Bidan Posyandu memberikan diagnosa dan tindakannya.</p>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection