@extends('layouts.bidan')

@section('title', 'Data Pasien Balita')
@section('page-name', 'Pantau Data Balita')

@push('styles')
<style>
    .animate-slide-up { opacity: 0; animation: slideUpFade 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endpush

@section('content')
<div id="smoothLoader" class="fixed inset-0 bg-slate-50/90 backdrop-blur-md z-[9999] flex flex-col items-center justify-center transition-all duration-300 opacity-0 pointer-events-none">
    <div class="relative w-20 h-20 flex items-center justify-center mb-4">
        <div class="absolute inset-0 border-4 border-cyan-100 rounded-full"></div>
        <div class="absolute inset-0 border-4 border-cyan-600 rounded-full border-t-transparent animate-spin"></div>
        <i class="fas fa-baby text-cyan-600 text-2xl animate-pulse"></i>
    </div>
    <p class="text-cyan-800 font-extrabold tracking-widest text-sm animate-pulse">MEMUAT DATA...</p>
</div>

<div class="max-w-7xl mx-auto animate-slide-up">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-[18px] bg-cyan-100 text-cyan-600 flex items-center justify-center text-2xl shadow-inner border border-cyan-200">
                <i class="fas fa-baby"></i>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Pantau Balita</h1>
                <p class="text-slate-500 mt-1 font-medium text-sm">Database lengkap balita terdaftar beserta riwayat gizi terakhir.</p>
            </div>
        </div>
        <a href="{{ route('bidan.laporan.cetak', ['jenis' => 'balita']) }}" class="smooth-route target-blank inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-white border border-slate-200 text-slate-700 font-extrabold text-sm rounded-xl hover:bg-slate-50 shadow-sm transition-all" target="_blank">
            <i class="fas fa-print text-cyan-600"></i> Cetak Laporan
        </a>
    </div>

    <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
        
        <div class="p-5 border-b border-slate-100 bg-slate-50/50">
            <form id="filterForm" action="{{ route('bidan.pasien.balita') }}" method="GET" class="flex gap-3">
                <div class="w-full md:w-1/2 relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama balita, NIK, atau nama ibu (Tekan Enter)..." class="w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-cyan-100 focus:border-cyan-500 outline-none transition-all shadow-sm">
                </div>
                @if(request('search'))
                    <a href="{{ route('bidan.pasien.balita') }}" class="smooth-route flex items-center justify-center px-4 py-3 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-100 transition-colors font-bold text-sm">
                        <i class="fas fa-times mr-2"></i> Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse min-w-[900px]">
                <thead>
                    <tr class="bg-white border-b border-slate-100">
                        <th class="px-6 py-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Identitas Balita</th>
                        <th class="px-6 py-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Orang Tua</th>
                        <th class="px-6 py-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Pemeriksaan Terakhir</th>
                        <th class="px-6 py-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest text-center">Status Gizi</th>
                        <th class="px-6 py-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($balitas as $balita)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-800 text-sm mb-1">{{ $balita->nama_lengkap }}</p>
                            <p class="text-[11px] font-semibold text-slate-500"><i class="fas fa-id-card mr-1 text-slate-400"></i> {{ $balita->nik }}</p>
                            <p class="text-[11px] font-semibold text-slate-500 mt-0.5"><i class="fas fa-birthday-cake mr-1 text-slate-400"></i> {{ \Carbon\Carbon::parse($balita->tanggal_lahir)->format('d M Y') }} ({{ \Carbon\Carbon::parse($balita->tanggal_lahir)->age }} thn)</p>
                        </td>

                        <td class="px-6 py-4">
                            <p class="font-semibold text-slate-700 text-xs mb-1"><span class="text-slate-400">Ibu:</span> {{ $balita->nama_ibu ?? '-' }}</p>
                            <p class="font-semibold text-slate-700 text-xs"><span class="text-slate-400">Ayah:</span> {{ $balita->nama_ayah ?? '-' }}</p>
                        </td>

                        <td class="px-6 py-4">
                            @if($balita->pemeriksaan_terakhir)
                                <p class="font-bold text-slate-700 text-xs mb-1">{{ \Carbon\Carbon::parse($balita->pemeriksaan_terakhir->tanggal_periksa)->format('d M Y') }}</p>
                                <div class="flex gap-2 text-[10px] font-bold text-cyan-700">
                                    <span class="bg-cyan-50 px-2 py-0.5 rounded border border-cyan-100">BB: {{ $balita->pemeriksaan_terakhir->berat_badan }}kg</span>
                                    <span class="bg-cyan-50 px-2 py-0.5 rounded border border-cyan-100">TB: {{ $balita->pemeriksaan_terakhir->tinggi_badan }}cm</span>
                                </div>
                            @else
                                <span class="text-xs text-slate-400 italic">Belum ada riwayat</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-center">
                            @if($balita->pemeriksaan_terakhir && $balita->pemeriksaan_terakhir->status_gizi)
                                @php
                                    $gizi = strtolower($balita->pemeriksaan_terakhir->status_gizi);
                                    $badge = match(true) {
                                        str_contains($gizi, 'baik') || str_contains($gizi, 'normal') => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                        str_contains($gizi, 'kurang') => 'bg-amber-50 text-amber-600 border-amber-200',
                                        str_contains($gizi, 'buruk') || str_contains($gizi, 'stunting') => 'bg-rose-50 text-rose-600 border-rose-200',
                                        default => 'bg-slate-50 text-slate-600 border-slate-200'
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-lg text-[11px] font-bold border uppercase {{ $badge }}">
                                    {{ $balita->pemeriksaan_terakhir->status_gizi }}
                                </span>
                            @else
                                <span class="text-xs text-slate-400">-</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-right">
                            <a href="#" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-cyan-600 text-xs font-bold rounded-xl hover:bg-cyan-50 hover:border-cyan-200 transition-colors shadow-sm">
                                <i class="fas fa-folder-open"></i> Rekam Medis
                            </a>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-16">
                            <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-300 mx-auto mb-4 text-3xl shadow-inner"><i class="fas fa-search"></i></div>
                            <h4 class="font-black text-slate-700 text-sm">Data tidak ditemukan</h4>
                            <p class="text-xs text-slate-500 mt-1">Coba gunakan kata kunci pencarian yang lain.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($balitas->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 pagination-wrapper">
            {{ $balitas->links() }}
        </div>
        @endif

    </div>
</div>
@endsection

@push('scripts')
<script>
    const showLoader = () => {
        const loader = document.getElementById('smoothLoader');
        if(loader) {
            loader.style.display = 'flex';
            loader.offsetHeight; 
            loader.classList.remove('opacity-0', 'pointer-events-none');
            loader.classList.add('opacity-100');
        }
    };

    window.addEventListener('pageshow', () => {
        const loader = document.getElementById('smoothLoader');
        if(loader) {
            loader.classList.remove('opacity-100');
            loader.classList.add('opacity-0', 'pointer-events-none');
            setTimeout(() => loader.style.display = 'none', 300);
        }
    });

    document.getElementById('filterForm').addEventListener('submit', showLoader);

    document.querySelectorAll('.smooth-route, .pagination-wrapper a').forEach(link => {
        link.addEventListener('click', function(e) {
            // Jangan load kalo buka tab baru (cetak PDF)
            if(!this.classList.contains('target-blank') && this.target !== '_blank' && !e.ctrlKey) {
                showLoader();
            }
        });
    });
</script>
@endpush