@extends('layouts.bidan')

@section('title', 'Detail Rekam Medis')
@section('page-name', 'Buku Jejak Medis')

@push('styles')
<style>
    .animate-slide-up { opacity: 0; animation: slideUpFade 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
    
    /* Timeline CSS */
    .timeline-line { position: absolute; left: 24px; top: 0; bottom: 0; width: 2px; background: #e2e8f0; z-index: 0; }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto animate-slide-up">

    <div class="mb-6">
        <a href="{{ route('bidan.rekam-medis.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-600 font-bold text-sm rounded-xl hover:bg-slate-50 transition-colors shadow-sm">
            <i class="fas fa-arrow-left"></i> Kembali ke Pencarian
        </a>
    </div>

    <div class="bg-cyan-600 rounded-[24px] border border-cyan-700 shadow-[0_12px_30px_rgba(8,145,178,0.3)] mb-8 overflow-hidden relative">
        <div class="absolute -right-10 -top-10 w-48 h-48 rounded-full bg-cyan-500 opacity-50 blur-2xl"></div>
        <div class="absolute right-20 bottom-0 opacity-10 text-9xl"><i class="fas fa-book-medical"></i></div>

        <div class="p-8 relative z-10 flex flex-col sm:flex-row items-center sm:items-start gap-6 text-white">
            <div class="w-24 h-24 rounded-full bg-white text-cyan-600 flex items-center justify-center text-4xl font-black shadow-lg shrink-0">
                {{ strtoupper(substr($pasien->nama_lengkap, 0, 1)) }}
            </div>
            <div class="text-center sm:text-left flex-1">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-cyan-700 rounded-lg text-[10px] font-extrabold uppercase tracking-widest mb-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    Pasien {{ ucfirst($pasien_type) }}
                </div>
                <h2 class="text-3xl font-black tracking-tight mb-2">{{ $pasien->nama_lengkap }}</h2>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                    <div><p class="text-cyan-200 text-[10px] font-bold uppercase tracking-widest">NIK / Identitas</p><p class="font-semibold">{{ $pasien->nik }}</p></div>
                    <div><p class="text-cyan-200 text-[10px] font-bold uppercase tracking-widest">Usia Saat Ini</p><p class="font-semibold">{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->age }} Tahun</p></div>
                    <div><p class="text-cyan-200 text-[10px] font-bold uppercase tracking-widest">Tgl Lahir</p><p class="font-semibold">{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d M Y') }}</p></div>
                    <div><p class="text-cyan-200 text-[10px] font-bold uppercase tracking-widest">Total Kunjungan</p><p class="font-semibold">{{ count($kunjungans) }} Kali</p></div>
                </div>
            </div>
        </div>
    </div>

    <h3 class="text-lg font-black text-slate-800 mb-6 flex items-center gap-2">
        <i class="fas fa-history text-cyan-500"></i> Jejak Rekam Medis
    </h3>

    <div class="relative bg-white rounded-[24px] border border-slate-200/80 shadow-sm p-6 sm:p-8">
        <div class="timeline-line hidden sm:block"></div>

        @forelse($kunjungans as $kunjungan)
            <div class="relative pl-0 sm:pl-14 mb-8 last:mb-0 group">
                
                <div class="hidden sm:flex absolute left-[-6px] top-1 w-8 h-8 rounded-full bg-cyan-100 border-4 border-white shadow-sm items-center justify-center text-cyan-600 z-10 transition-transform group-hover:scale-110">
                    <i class="fas fa-calendar-check text-[11px]"></i>
                </div>

                <div class="bg-slate-50 border border-slate-100 rounded-[20px] p-5 transition-all hover:bg-white hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] hover:border-cyan-200">
                    
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-4 pb-3 border-b border-slate-200/60">
                        <div class="flex items-center gap-3">
                            <h4 class="font-black text-slate-800">{{ \Carbon\Carbon::parse($kunjungan->tanggal)->format('d F Y') }}</h4>
                            <span class="text-xs font-semibold text-slate-400">{{ \Carbon\Carbon::parse($kunjungan->tanggal)->diffForHumans() }}</span>
                        </div>
                        <div class="text-[10px] font-extrabold uppercase bg-white px-2.5 py-1 rounded border border-slate-200 text-slate-500 shadow-sm">
                            Keluhan: {{ $kunjungan->pemeriksaan?->keluhan ?? 'Tidak ada keluhan' }}
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        
                        <div>
                            <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2"><i class="fas fa-stethoscope mr-1"></i> Data Fisik</p>
                            @if($kunjungan->pemeriksaan)
                                <ul class="space-y-1.5 text-sm font-medium text-slate-700">
                                    <li><span class="text-slate-500">Berat Badan:</span> <strong>{{ $kunjungan->pemeriksaan->berat_badan ?? '-' }} kg</strong></li>
                                    <li><span class="text-slate-500">Tinggi Badan:</span> <strong>{{ $kunjungan->pemeriksaan->tinggi_badan ?? '-' }} cm</strong></li>
                                    @if($kunjungan->pemeriksaan->tekanan_darah)
                                        <li><span class="text-slate-500">Tensi Darah:</span> <strong class="text-rose-600">{{ $kunjungan->pemeriksaan->tekanan_darah }}</strong></li>
                                    @endif
                                </ul>
                            @else
                                <p class="text-xs text-slate-400 italic">Tidak ada data antropometri.</p>
                            @endif
                        </div>

                        <div>
                            <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2"><i class="fas fa-user-md mr-1"></i> Diagnosa Bidan</p>
                            @if($kunjungan->pemeriksaan && $kunjungan->pemeriksaan->diagnosa)
                                <div class="bg-cyan-50 border border-cyan-100 p-3 rounded-xl">
                                    <p class="text-sm font-bold text-cyan-800 mb-1">{{ $kunjungan->pemeriksaan->diagnosa }}</p>
                                    @if($kunjungan->pemeriksaan->tindakan)
                                        <p class="text-[11px] text-cyan-700 font-semibold border-t border-cyan-200/50 pt-1 mt-1"><span class="uppercase font-bold text-[9px] mr-1">Tindakan:</span> {{ $kunjungan->pemeriksaan->tindakan }}</p>
                                    @endif
                                </div>
                            @else
                                <div class="bg-amber-50 text-amber-600 p-3 rounded-xl text-xs font-bold border border-amber-100">
                                    <i class="fas fa-exclamation-triangle"></i> Belum ada diagnosa/validasi dari Bidan.
                                </div>
                            @endif
                        </div>

                    </div>
                </div>

            </div>
        @empty
            <div class="text-center py-10">
                <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-300 mx-auto mb-4 text-3xl shadow-inner"><i class="fas fa-folder-open"></i></div>
                <h4 class="font-black text-slate-700 text-sm">Belum Ada Rekam Medis</h4>
                <p class="text-xs text-slate-500 mt-1">Pasien ini belum pernah melakukan pemeriksaan di Posyandu.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection