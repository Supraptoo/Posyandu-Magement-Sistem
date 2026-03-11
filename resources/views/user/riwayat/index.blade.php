@extends('layouts.user')

@section('title', 'Buku Rekam Medis')

@push('styles')
<style>
    .animate-slide-up { opacity: 0; animation: slideUpFade 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .timeline-line { position: absolute; left: 16px; top: 20px; bottom: 0; width: 2px; background: #e2e8f0; z-index: 0; }
</style>
@endpush

@section('content')
<div class="animate-slide-up space-y-6 pb-6">

    <div class="bg-gradient-to-r from-teal-500 to-sky-500 rounded-[24px] p-6 text-white shadow-lg relative overflow-hidden">
        <i class="fas fa-book-medical absolute -right-4 -bottom-4 text-7xl opacity-20"></i>
        <div class="relative z-10">
            <h2 class="text-2xl font-black font-poppins mb-1 tracking-tight">Buku Rekam Medis</h2>
            <p class="text-teal-50 text-xs font-medium">Jejak histori kesehatan seluruh anggota keluarga Anda yang telah diverifikasi Bidan.</p>
        </div>
    </div>

    <div class="relative pt-4 pl-2 sm:pl-4">
        <div class="timeline-line hidden sm:block"></div>

        @forelse($riwayat as $item)
            @php
                $isBalita = $item->kategori_pasien == 'balita';
                $isRemaja = $item->kategori_pasien == 'remaja';
                $isLansia = $item->kategori_pasien == 'lansia';
                
                $dotColor = $isBalita ? 'border-rose-500' : ($isRemaja ? 'border-indigo-500' : 'border-amber-500');
                $badgeColor = $isBalita ? 'bg-rose-100 text-rose-700' : ($isRemaja ? 'bg-indigo-100 text-indigo-700' : 'bg-amber-100 text-amber-700');
                $icon = $isBalita ? 'fa-baby' : ($isRemaja ? 'fa-user-graduate' : 'fa-wheelchair');
            @endphp

            <div class="relative pl-0 sm:pl-10 mb-6 last:mb-0 group">
                
                <div class="hidden sm:block absolute left-[-6px] top-4 w-4 h-4 rounded-full bg-white border-[4px] {{ $dotColor }} shadow-sm z-10"></div>

                <div class="bg-white border border-slate-100 rounded-[20px] p-5 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-md transition-shadow">
                    
                    <div class="flex items-center justify-between mb-3 border-b border-slate-100 pb-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-[10px] font-black uppercase tracking-wider {{ $badgeColor }}">
                                <i class="fas {{ $icon }}"></i> {{ ucfirst($item->kategori_pasien) }}
                            </span>
                            <span class="text-[10px] font-bold text-slate-400"><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($item->tanggal_periksa)->format('d M Y') }}</span>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 text-xs font-bold shrink-0">
                            {{ strtoupper(substr($item->pasien_nama, 0, 1)) }}
                        </div>
                    </div>

                    <h4 class="text-sm font-black text-slate-800 font-poppins mb-2">{{ $item->pasien_nama }}</h4>
                    
                    <div class="flex flex-wrap gap-2 text-xs font-semibold text-slate-600 mb-3">
                        <span class="bg-slate-50 px-2.5 py-1 rounded border border-slate-100">BB: <span class="font-bold">{{ $item->berat_badan ?? '-' }} kg</span></span>
                        <span class="bg-slate-50 px-2.5 py-1 rounded border border-slate-100">TB: <span class="font-bold">{{ $item->tinggi_badan ?? '-' }} cm</span></span>
                        @if($item->tekanan_darah)
                            <span class="bg-slate-50 px-2.5 py-1 rounded border border-slate-100">TD: <span class="font-bold">{{ $item->tekanan_darah }}</span></span>
                        @endif
                    </div>

                    <div class="bg-teal-50 border border-teal-100 p-3 rounded-xl">
                        <p class="text-[10px] font-black text-teal-600 uppercase tracking-widest mb-1">Diagnosa Bidan</p>
                        <p class="text-xs font-bold text-teal-900 leading-relaxed">{{ $item->diagnosa ?? 'Kondisi sehat/normal terpantau.' }}</p>
                        
                        @if($item->tindakan)
                            <p class="text-[11px] font-semibold text-teal-700 mt-2 border-t border-teal-200/50 pt-2"><span class="font-bold uppercase mr-1 text-[9px]">Tindakan:</span> {{ $item->tindakan }}</p>
                        @endif
                    </div>

                </div>
            </div>
        @empty
            <div class="text-center py-16 px-4">
                <div class="w-16 h-16 bg-white border border-slate-100 shadow-sm rounded-full flex items-center justify-center mx-auto mb-4 text-3xl text-slate-300">
                    <i class="fas fa-folder-open"></i>
                </div>
                <h4 class="text-sm font-black text-slate-700 font-poppins mb-1">Buku Medis Kosong</h4>
                <p class="text-xs font-medium text-slate-500 max-w-xs mx-auto">Belum ada riwayat pemeriksaan terverifikasi untuk keluarga Anda.</p>
            </div>
        @endforelse
        
        @if($riwayat->hasPages())
        <div class="mt-6">
            {{ $riwayat->links() }}
        </div>
        @endif

    </div>

</div>
@endsection