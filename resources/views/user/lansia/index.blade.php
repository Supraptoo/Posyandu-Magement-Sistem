@extends('layouts.user')

@section('title', 'Kesehatan Lansia')

@push('styles')
<style>
    .animate-slide-up { opacity: 0; animation: slideUpFade 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endpush

@section('content')
<div class="animate-slide-up space-y-6 pb-6">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-black text-slate-800 font-poppins tracking-tight">Kesehatan Lansia</h2>
            <p class="text-sm font-medium text-slate-500 mt-1">Cek riwayat cek up rutin orang tua.</p>
        </div>
        <div class="w-12 h-12 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center text-2xl shadow-sm">
            <i class="fas fa-wheelchair"></i>
        </div>
    </div>

    <div class="bg-white border border-slate-100 rounded-[24px] p-5 shadow-[0_8px_30px_rgb(0,0,0,0.04)] flex items-center gap-4">
        <div class="w-16 h-16 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center text-2xl font-black border border-amber-100 shrink-0">
            {{ strtoupper(substr($lansia->nama_lengkap, 0, 1)) }}
        </div>
        <div>
            <h3 class="text-lg font-black text-slate-800 font-poppins mb-0.5">{{ $lansia->nama_lengkap }}</h3>
            <p class="text-xs font-semibold text-slate-500"><i class="fas fa-id-card mr-1 text-slate-400"></i> {{ $lansia->nik }}</p>
            <p class="text-xs font-semibold text-slate-500 mt-0.5"><i class="fas fa-birthday-cake mr-1 text-slate-400"></i> Usia: {{ $stats['usia'] ?? '-' }} Tahun</p>
        </div>
    </div>

    <div>
        <div class="flex items-center justify-between mb-3">
            <h3 class="font-black text-slate-800 text-base font-poppins">Cek Medis Terakhir</h3>
            <span class="text-[10px] font-bold text-slate-400 bg-slate-100 px-2 py-1 rounded">{{ $stats['kunjungan_terakhir'] ? \Carbon\Carbon::parse($stats['kunjungan_terakhir']->tanggal_periksa)->format('d M Y') : 'Belum Ada' }}</span>
        </div>

        @if($stats['kunjungan_terakhir'])
            @php 
                $cek = $stats['kunjungan_terakhir']; 
                $tensiTinggi = intval(explode('/', $cek->tekanan_darah ?? '0/0')[0]) >= 140;
                $gulaTinggi = intval($cek->gula_darah ?? 0) >= 200;
            @endphp
            
            <div class="grid grid-cols-2 gap-4">
                <div class="p-5 rounded-[20px] shadow-sm {{ $tensiTinggi ? 'bg-rose-50 border border-rose-200' : 'bg-white border border-slate-100' }}">
                    <div class="flex items-center justify-between mb-3">
                        <i class="fas fa-heartbeat text-2xl {{ $tensiTinggi ? 'text-rose-500 animate-pulse' : 'text-emerald-500' }}"></i>
                        @if($tensiTinggi) <span class="bg-rose-500 text-white text-[9px] font-bold px-2 py-0.5 rounded">TINGGI</span> @endif
                    </div>
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-widest">Tensi Darah</p>
                    <h4 class="text-2xl font-black {{ $tensiTinggi ? 'text-rose-700' : 'text-slate-800' }} mt-1">{{ $cek->tekanan_darah ?? '-' }}</h4>
                </div>

                <div class="p-5 rounded-[20px] shadow-sm {{ $gulaTinggi ? 'bg-rose-50 border border-rose-200' : 'bg-white border border-slate-100' }}">
                    <div class="flex items-center justify-between mb-3">
                        <i class="fas fa-cubes text-2xl {{ $gulaTinggi ? 'text-rose-500 animate-pulse' : 'text-emerald-500' }}"></i>
                        @if($gulaTinggi) <span class="bg-rose-500 text-white text-[9px] font-bold px-2 py-0.5 rounded">TINGGI</span> @endif
                    </div>
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-widest">Gula Darah</p>
                    <h4 class="text-2xl font-black {{ $gulaTinggi ? 'text-rose-700' : 'text-slate-800' }} mt-1">{{ $cek->gula_darah ?? '-' }} <span class="text-xs text-slate-500 font-bold">mg/dL</span></h4>
                </div>
            </div>

            @if($cek->diagnosa || $cek->tindakan)
            <div class="mt-4 p-5 bg-gradient-to-br from-amber-50 to-orange-50 border border-amber-100 rounded-[20px] shadow-sm">
                <h4 class="text-xs font-black text-amber-800 uppercase tracking-widest mb-2"><i class="fas fa-notes-medical mr-1"></i> Resep / Diagnosa Bidan</h4>
                <p class="text-sm font-semibold text-amber-900 mb-2">{{ $cek->diagnosa ?? 'Kondisi terpantau.' }}</p>
                @if($cek->tindakan)
                    <div class="pt-3 border-t border-amber-200/50">
                        <span class="text-[10px] font-bold text-amber-600 uppercase block mb-1">Tindakan Lanjutan:</span>
                        <p class="text-sm font-bold text-amber-800">{{ $cek->tindakan }}</p>
                    </div>
                @endif
            </div>
            @endif

        @else
            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 text-center shadow-sm">
                <p class="text-sm font-semibold text-slate-500">Belum ada riwayat pemeriksaan fisik tercatat.</p>
            </div>
        @endif
    </div>

</div>
@endsection