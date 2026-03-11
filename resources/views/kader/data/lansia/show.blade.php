@extends('layouts.kader')

@section('title', 'Detail Lansia')
@section('page-name', 'Detail Profil')

@push('styles')
<style>
    .animate-slide-up { opacity: 0; animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .custom-scrollbar::-webkit-scrollbar { height: 6px; width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto animate-slide-up">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('kader.data.lansia.index') }}" class="w-10 h-10 bg-white border border-slate-200 text-slate-500 rounded-xl flex items-center justify-center hover:bg-slate-50 transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Profil Lansia</h1>
        </div>
        <a href="{{ route('kader.data.lansia.edit', $lansia->id) }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-amber-500 text-white font-extrabold text-sm rounded-xl hover:bg-amber-600 shadow-sm transition-all hover:-translate-y-0.5">
            <i class="fas fa-edit"></i> Edit Profil
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <div class="lg:col-span-4">
            <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden sticky top-24">
                
                <div class="bg-gradient-to-b from-emerald-500 to-emerald-700 px-6 py-10 text-center relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-black/10 rounded-full blur-xl transform -translate-x-1/2 translate-y-1/2"></div>

                    <div class="w-28 h-28 mx-auto bg-white rounded-[24px] shadow-xl flex items-center justify-center text-emerald-500 text-5xl font-black relative z-10 border-4 border-emerald-200/30 transform rotate-3 hover:rotate-0 transition-transform duration-300">
                        {{ strtoupper(substr($lansia->nama_lengkap, 0, 1)) }}
                    </div>
                    
                    <h2 class="text-2xl font-extrabold text-white mt-5 relative z-10">{{ $lansia->nama_lengkap }}</h2>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-900/30 text-emerald-50 text-xs font-bold rounded-lg mt-2 relative z-10 backdrop-blur-sm border border-white/10">
                        <i class="fas fa-id-card"></i> {{ $lansia->kode_lansia }}
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4 text-center mb-6">
                        <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100">
                            <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Usia</p>
                            <p class="text-base font-black text-emerald-600">{{ $usia }} Tahun</p>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100">
                            <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Gender</p>
                            <p class="text-base font-black text-slate-800">
                                @if($lansia->jenis_kelamin == 'L') <i class="fas fa-mars text-sky-500 mr-1"></i> Laki-laki
                                @else <i class="fas fa-venus text-rose-500 mr-1"></i> Perempuan @endif
                            </p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="p-3 bg-slate-50 rounded-xl">
                            <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">NIK Kependudukan</p>
                            <p class="text-sm font-bold text-slate-800 font-mono">{{ $lansia->nik }}</p>
                        </div>

                        <div class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-500 flex items-center justify-center"><i class="fas fa-calendar-alt text-sm"></i></div>
                                <span class="text-xs font-bold text-slate-500 uppercase tracking-wide">Tanggal Lahir</span>
                            </div>
                            <span class="text-sm font-bold text-slate-800">{{ $lansia->tanggal_lahir->format('d M Y') }}</span>
                        </div>
                        
                        <div class="flex items-start gap-3 p-3 rounded-xl hover:bg-slate-50 transition-colors">
                            <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-500 flex items-center justify-center shrink-0"><i class="fas fa-map-marker-alt text-sm"></i></div>
                            <div>
                                <span class="text-xs font-bold text-slate-500 uppercase tracking-wide block mb-1">Alamat</span>
                                <span class="text-sm font-bold text-slate-800 leading-snug">{{ $lansia->alamat }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 border-t border-slate-100 pt-6">
                        <h6 class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest mb-3">Status Kesehatan / Penyakit Bawaan</h6>
                        <div class="flex flex-wrap gap-2">
                            @if($lansia->penyakit_bawaan)
                                @foreach(explode(',', $lansia->penyakit_bawaan) as $sakit)
                                    <span class="px-3 py-1.5 bg-rose-50 text-rose-600 border border-rose-100 rounded-lg text-xs font-bold shadow-sm uppercase tracking-wide">{{ trim($sakit) }}</span>
                                @endforeach
                            @else
                                <div class="w-full p-3 bg-emerald-50 border border-emerald-100 rounded-xl flex items-center gap-2">
                                    <i class="fas fa-check-circle text-emerald-500"></i>
                                    <span class="text-xs font-bold text-emerald-700">Lansia Terpantau Sehat</span>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="lg:col-span-8 space-y-6">
            <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden h-full flex flex-col">
                
                <div class="p-6 sm:p-8 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-[16px] bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl"><i class="fas fa-notes-medical"></i></div>
                        <div>
                            <h3 class="text-lg font-extrabold text-slate-800">Riwayat Kesehatan Lansia</h3>
                            <p class="text-xs font-medium text-slate-400 mt-0.5">Catatan pemeriksaan gula darah, asam urat, dll.</p>
                        </div>
                    </div>
                    <a href="{{ route('kader.pemeriksaan.create') }}?kategori=lansia&pasien_id={{ $lansia->id }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-emerald-50 text-emerald-700 font-bold text-sm rounded-xl hover:bg-emerald-100 transition-colors shrink-0 border border-emerald-100">
                        <i class="fas fa-plus"></i> Periksa Baru
                    </a>
                </div>

                <div class="p-6 sm:p-8 flex-1 overflow-y-auto custom-scrollbar">
                    @forelse($lansia->kunjungans as $kunjungan)
                        <div class="relative pl-8 sm:pl-10 mb-8 last:mb-0">
                            <div class="absolute left-[15px] sm:left-[19px] top-8 bottom-[-32px] w-[2px] bg-slate-100 last:hidden"></div>
                            
                            <div class="absolute left-0 top-1 w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-emerald-50 border-4 border-white flex items-center justify-center text-emerald-500 shadow-sm z-10">
                                <i class="fas fa-heartbeat text-[10px] sm:text-xs"></i>
                            </div>

                            <div class="bg-white border border-slate-100 rounded-2xl p-4 sm:p-5 shadow-sm hover:border-emerald-100 transition-colors group">
                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-2 mb-3">
                                    <div>
                                        <h6 class="font-bold text-slate-800 text-sm">{{ ucfirst($kunjungan->jenis_kunjungan) }}</h6>
                                        <p class="text-xs text-slate-400 mt-0.5">Keluhan: <span class="font-semibold text-slate-600">{{ $kunjungan->keluhan ?? 'Tidak ada keluhan' }}</span></p>
                                    </div>
                                    <div class="text-left sm:text-right shrink-0">
                                        <span class="inline-block px-2.5 py-1 bg-slate-50 text-slate-500 text-[10px] font-extrabold rounded-md uppercase tracking-wider">
                                            {{ $kunjungan->tanggal_kunjungan->format('d M Y') }}
                                        </span>
                                    </div>
                                </div>

                                @if($kunjungan->pemeriksaan)
                                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 mt-4">
                                        <div class="p-2 bg-slate-50 border border-slate-100 rounded-xl text-center">
                                            <p class="text-[10px] text-slate-400 font-bold mb-1 uppercase">Tensi</p>
                                            <p class="text-xs font-black text-slate-700">{{ $kunjungan->pemeriksaan->tekanan_darah ?? '-' }}</p>
                                        </div>
                                        <div class="p-2 bg-slate-50 border border-slate-100 rounded-xl text-center">
                                            <p class="text-[10px] text-slate-400 font-bold mb-1 uppercase">Gula Darah</p>
                                            <p class="text-xs font-black text-slate-700">{{ $kunjungan->pemeriksaan->gula_darah ?? '-' }}</p>
                                        </div>
                                        <div class="p-2 bg-slate-50 border border-slate-100 rounded-xl text-center">
                                            <p class="text-[10px] text-slate-400 font-bold mb-1 uppercase">Asam Urat</p>
                                            <p class="text-xs font-black text-slate-700">{{ $kunjungan->pemeriksaan->asam_urat ?? '-' }}</p>
                                        </div>
                                        <div class="p-2 bg-slate-50 border border-slate-100 rounded-xl text-center">
                                            <p class="text-[10px] text-slate-400 font-bold mb-1 uppercase">Kolesterol</p>
                                            <p class="text-xs font-black text-slate-700">{{ $kunjungan->pemeriksaan->kolesterol ?? '-' }}</p>
                                        </div>
                                    </div>

                                    <div class="mt-4 text-right border-t border-slate-50 pt-3">
                                        <a href="{{ route('kader.kunjungan.show', $kunjungan->id) }}" class="text-[11px] font-bold text-emerald-600 hover:text-emerald-700 opacity-0 group-hover:opacity-100 transition-opacity">
                                            Lihat Detail Medis &rarr;
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-12 text-center h-full">
                            <div class="w-20 h-20 bg-slate-50 rounded-[20px] flex items-center justify-center text-slate-300 mx-auto mb-4 text-3xl shadow-inner border border-slate-100">
                                <i class="fas fa-notes-medical"></i>
                            </div>
                            <h4 class="font-black text-slate-800 text-lg">Belum Ada Pemeriksaan</h4>
                            <p class="text-sm font-medium text-slate-500 mt-1 max-w-sm mx-auto">Lansia ini belum memiliki catatan riwayat kesehatan. Segera lakukan pemeriksaan.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>
@endsection