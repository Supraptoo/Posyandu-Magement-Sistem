@extends('layouts.kader')

@section('title', 'Detail Kunjungan')
@section('page-name', 'Detail Kehadiran')

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
            <a href="{{ route('kader.kunjungan.index') }}" class="w-10 h-10 bg-white border border-slate-200 text-slate-500 rounded-xl flex items-center justify-center hover:bg-slate-50 transition-colors shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Nota Kehadiran</h1>
        </div>
        
        <span class="inline-flex items-center gap-2 px-4 py-2 bg-slate-800 text-white font-bold text-sm rounded-xl">
            <i class="fas fa-ticket-alt"></i> {{ $kunjungan->kode_kunjungan }}
        </span>
    </div>

    <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
        
        <div class="p-8 border-b-2 border-dashed border-slate-200 bg-slate-50/50 flex flex-col sm:flex-row items-center sm:items-start gap-6 relative">
            
            <div class="absolute -bottom-4 -left-4 w-8 h-8 bg-[#f8fafc] rounded-full border-t-2 border-r-2 border-dashed border-slate-200"></div>
            <div class="absolute -bottom-4 -right-4 w-8 h-8 bg-[#f8fafc] rounded-full border-t-2 border-l-2 border-dashed border-slate-200"></div>

            <div class="w-24 h-24 rounded-3xl bg-cyan-100 text-cyan-600 flex items-center justify-center text-4xl shadow-inner border border-cyan-200/50 shrink-0 transform -rotate-3">
                <i class="fas fa-user"></i>
            </div>
            <div class="text-center sm:text-left flex-1">
                @php $tipe = class_basename($kunjungan->pasien_type); @endphp
                <span class="inline-block px-3 py-1 bg-slate-200 text-slate-600 text-[10px] font-black uppercase rounded-lg tracking-widest mb-2">{{ $tipe }}</span>
                <h2 class="text-2xl font-extrabold text-slate-800">{{ $kunjungan->pasien->nama_lengkap ?? 'Pasien Tidak Diketahui' }}</h2>
                <p class="text-sm font-semibold text-slate-500 mt-1"><i class="fas fa-id-card mr-1"></i> {{ $kunjungan->pasien->nik ?? $kunjungan->pasien->kode_balita ?? '-' }}</p>
            </div>
            <div class="text-center sm:text-right shrink-0">
                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Tanggal & Waktu</p>
                <p class="text-base font-black text-cyan-600">{{ \Carbon\Carbon::parse($kunjungan->created_at)->format('d M Y') }}</p>
                <p class="text-sm font-bold text-slate-500">{{ \Carbon\Carbon::parse($kunjungan->created_at)->format('H:i') }} WIB</p>
            </div>
        </div>

        <div class="p-8">
            <h3 class="text-xs font-extrabold text-slate-400 uppercase tracking-widest mb-6 border-b border-slate-100 pb-2">Rincian Layanan Posyandu</h3>

            <div class="space-y-6">
                
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 shrink-0"><i class="fas fa-comment-medical"></i></div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-0.5">Keluhan Awal</p>
                        <p class="text-sm font-bold text-slate-800">{{ $kunjungan->keluhan ?? 'Tidak ada keluhan saat pendaftaran.' }}</p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 shrink-0"><i class="fas fa-user-edit"></i></div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-0.5">Didaftarkan Oleh</p>
                        <p class="text-sm font-bold text-slate-800">{{ $kunjungan->petugas->name ?? 'Kader Posyandu' }}</p>
                    </div>
                </div>

                @if($kunjungan->pemeriksaan)
                <div class="mt-4 p-5 bg-indigo-50 border border-indigo-100 rounded-2xl flex items-center justify-between group cursor-pointer hover:bg-indigo-100/50 transition-colors" onclick="window.location.href='{{ route('kader.pemeriksaan.show', $kunjungan->pemeriksaan->id) }}'">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-indigo-600 shadow-sm border border-indigo-100">
                            <i class="fas fa-stethoscope text-xl"></i>
                        </div>
                        <div>
                            <p class="font-extrabold text-indigo-900">Data Pemeriksaan Tersedia</p>
                            <p class="text-xs font-semibold text-indigo-600/80 mt-0.5">Lihat hasil antropometri & diagnosa bidan.</p>
                        </div>
                    </div>
                    <i class="fas fa-arrow-right text-indigo-400 group-hover:text-indigo-600 transition-colors"></i>
                </div>
                @endif

                @if($kunjungan->imunisasis && $kunjungan->imunisasis->count() > 0)
                <div class="mt-4 p-5 bg-teal-50 border border-teal-100 rounded-2xl">
                    <div class="flex items-center gap-3 mb-3">
                        <i class="fas fa-shield-virus text-teal-600"></i>
                        <p class="font-extrabold text-teal-900">Menerima Imunisasi</p>
                    </div>
                    <div class="space-y-2">
                        @foreach($kunjungan->imunisasis as $imun)
                        <div class="flex justify-between items-center bg-white p-3 rounded-xl border border-teal-50 shadow-sm">
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ $imun->jenis_imunisasi }} <span class="text-[10px] text-slate-400 font-black uppercase">({{ $imun->vaksin }})</span></p>
                            </div>
                            <span class="px-2 py-1 bg-teal-100 text-teal-700 text-xs font-black rounded-md">{{ $imun->dosis }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>
        </div>

    </div>
</div>
@endsection