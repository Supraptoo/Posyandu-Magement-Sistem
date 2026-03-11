@extends('layouts.user')

@section('title', 'Kesehatan Anak & Balita')

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
            <h2 class="text-2xl font-black text-slate-800 font-poppins tracking-tight">Data Balita Anda</h2>
            <p class="text-sm font-medium text-slate-500 mt-1">Pantau tumbuh kembang si buah hati.</p>
        </div>
        <div class="w-12 h-12 rounded-full bg-rose-100 text-rose-500 flex items-center justify-center text-2xl shadow-sm">
            <i class="fas fa-baby"></i>
        </div>
    </div>

    @if(isset($pesan))
        <div class="bg-amber-50 border border-amber-200 p-5 rounded-2xl flex items-start gap-4 shadow-sm">
            <i class="fas fa-info-circle text-amber-500 text-xl shrink-0 mt-0.5"></i>
            <div>
                <h4 class="text-sm font-bold text-amber-800 font-poppins">Informasi</h4>
                <p class="text-xs font-medium text-amber-700 mt-1 leading-snug">{{ $pesan }}</p>
            </div>
        </div>
    @else
        <div class="space-y-5">
            @foreach($dataBalita as $balita)
            <div class="bg-white border border-slate-100 rounded-[24px] p-5 shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-rose-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                
                <div class="relative z-10 flex items-start gap-4 mb-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-rose-400 to-pink-500 text-white flex items-center justify-center text-xl font-bold shadow-md shrink-0">
                        {{ strtoupper(substr($balita->nama_lengkap, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-lg font-black text-slate-800 font-poppins truncate">{{ $balita->nama_lengkap }}</h3>
                        <div class="flex flex-wrap gap-2 mt-1.5">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-slate-100 text-slate-600 text-[10px] font-bold rounded-md">
                                <i class="fas fa-birthday-cake text-slate-400"></i> {{ $balita->usia_tahun }}th {{ $balita->usia_bulan }}bln
                            </span>
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-slate-100 text-slate-600 text-[10px] font-bold rounded-md">
                                <i class="fas fa-venus-mars text-slate-400"></i> {{ $balita->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </span>
                        </div>
                    </div>
                </div>

                @php $cekTerakhir = $balita->riwayatPemeriksaan->first(); @endphp
                
                <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 mb-4">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Pemeriksaan Terakhir</p>
                    @if($cekTerakhir)
                        <div class="grid grid-cols-3 gap-2">
                            <div>
                                <p class="text-xs text-slate-500">Berat</p>
                                <p class="text-sm font-black text-slate-800">{{ $cekTerakhir->berat_badan }} <span class="text-[10px] text-slate-400 font-bold">KG</span></p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Tinggi</p>
                                <p class="text-sm font-black text-slate-800">{{ $cekTerakhir->tinggi_badan }} <span class="text-[10px] text-slate-400 font-bold">CM</span></p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Gizi</p>
                                @php
                                    $gizi = strtolower($cekTerakhir->status_gizi);
                                    $gColor = in_array($gizi, ['baik', 'normal']) ? 'text-emerald-600' : 'text-amber-600';
                                @endphp
                                <p class="text-sm font-black uppercase {{ $gColor }}">{{ $cekTerakhir->status_gizi ?? '-' }}</p>
                            </div>
                        </div>
                    @else
                        <p class="text-xs font-semibold text-slate-500 italic">Belum ada catatan pemeriksaan.</p>
                    @endif
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('user.balita.show', $balita->id) }}" class="smooth-route flex items-center justify-center gap-2 w-full py-2.5 bg-rose-50 text-rose-600 hover:bg-rose-100 text-xs font-bold rounded-xl transition-colors">
                        <i class="fas fa-chart-line"></i> Grafik Tumbuh
                    </a>
                    <a href="{{ route('user.imunisasi.index') }}" class="smooth-route flex items-center justify-center gap-2 w-full py-2.5 bg-sky-50 text-sky-600 hover:bg-sky-100 text-xs font-bold rounded-xl transition-colors">
                        <i class="fas fa-syringe"></i> Riwayat Imunisasi
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    @endif

</div>
@endsection