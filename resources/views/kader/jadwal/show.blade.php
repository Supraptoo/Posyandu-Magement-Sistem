@extends('layouts.kader')

@section('title', 'Detail Jadwal')
@section('page-name', 'Detail Jadwal Acara')

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
            <a href="{{ route('kader.jadwal.index') }}" class="w-10 h-10 bg-white border border-slate-200 text-slate-500 rounded-xl flex items-center justify-center hover:bg-slate-50 transition-colors shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Detail Acara</h1>
        </div>
        
        <a href="{{ route('kader.jadwal.edit', $jadwal->id) }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-amber-500 text-white font-extrabold text-sm rounded-xl hover:bg-amber-600 shadow-sm transition-all hover:-translate-y-0.5">
            <i class="fas fa-edit"></i> Edit Jadwal
        </a>
    </div>

    <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
        
        <div class="bg-gradient-to-br from-violet-600 to-indigo-800 p-8 sm:p-12 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/3"></div>
            <div class="absolute bottom-0 left-0 w-40 h-40 bg-black/20 rounded-full blur-2xl transform -translate-x-1/2 translate-y-1/2"></div>
            <i class="fas fa-bullhorn absolute right-8 bottom-8 text-white/5 text-8xl transform -rotate-12"></i>

            <div class="relative z-10 flex flex-col sm:flex-row gap-6 items-center sm:items-start text-center sm:text-left">
                
                <div class="w-28 bg-white rounded-2xl overflow-hidden shadow-2xl flex-shrink-0 transform rotate-3 hover:rotate-0 transition-transform duration-300">
                    <div class="bg-rose-500 text-white text-[10px] font-black uppercase tracking-widest py-2 text-center">
                        {{ \Carbon\Carbon::parse($jadwal->tanggal)->format('F Y') }}
                    </div>
                    <div class="py-4 text-center">
                        <span class="block text-4xl font-black text-slate-800 leading-none">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d') }}</span>
                        <span class="block text-xs font-bold text-slate-500 mt-1">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('l') }}</span>
                    </div>
                </div>

                <div class="flex-1 mt-2">
                    <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-md text-white text-[10px] font-black uppercase rounded-lg tracking-widest mb-3 border border-white/30">
                        {{ str_replace('_', ' ', $jadwal->target_peserta) }}
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-black text-white leading-tight mb-2">{{ $jadwal->judul }}</h2>
                    <p class="text-violet-100 font-medium flex items-center justify-center sm:justify-start gap-2">
                        <i class="fas fa-map-marker-alt text-rose-300"></i> {{ $jadwal->lokasi }}
                    </p>
                </div>
            </div>
        </div>

        <div class="p-8">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg shrink-0"><i class="fas fa-clock"></i></div>
                    <div>
                        <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Jam Pelaksanaan</p>
                        <p class="text-sm font-bold text-slate-800">{{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }} s/d {{ \Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i') }} WIB</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-teal-50 text-teal-600 flex items-center justify-center text-lg shrink-0"><i class="fas fa-tags"></i></div>
                    <div>
                        <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Kategori Acara</p>
                        <p class="text-sm font-bold text-slate-800 capitalize">{{ $jadwal->kategori }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center text-lg shrink-0"><i class="fas fa-info-circle"></i></div>
                    <div>
                        <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Status</p>
                        @if($jadwal->status == 'aktif') <p class="text-sm font-bold text-violet-600">Akan Datang</p>
                        @elseif($jadwal->status == 'selesai') <p class="text-sm font-bold text-emerald-600">Selesai</p>
                        @else <p class="text-sm font-bold text-rose-600">Dibatalkan</p> @endif
                    </div>
                </div>
            </div>

            <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-2">Deskripsi & Catatan</p>
                <p class="text-sm font-medium text-slate-700 leading-relaxed">{{ $jadwal->deskripsi ?? 'Tidak ada catatan tambahan untuk kegiatan ini.' }}</p>
            </div>
            
            @if($jadwal->status == 'aktif')
            <div class="mt-8 border-t border-slate-100 pt-8 text-center">
                <div class="w-16 h-16 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center text-2xl mx-auto mb-4 animate-bounce">
                    <i class="fas fa-bell"></i>
                </div>
                <h4 class="text-lg font-extrabold text-slate-800 mb-2">Kirim Pengumuman ke Warga?</h4>
                <p class="text-sm text-slate-500 max-w-md mx-auto mb-6">Fitur ini akan mengirimkan notifikasi ke aplikasi warga yang terdaftar sesuai dengan Target Peserta.</p>
                
                <form action="{{ route('kader.jadwal.broadcast', $jadwal->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-blue-600 text-white font-extrabold text-sm rounded-xl hover:bg-blue-700 shadow-[0_4px_12px_rgba(37,99,235,0.3)] hover:-translate-y-0.5 transition-all w-full sm:w-auto" onclick="return confirm('Kirim notifikasi ke seluruh warga yang masuk target peserta acara ini?');">
                        <i class="fas fa-paper-plane"></i> Ya, Broadcast Notifikasi Sekarang
                    </button>
                </form>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection