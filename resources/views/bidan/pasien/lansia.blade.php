@extends('layouts.bidan')

@section('title', 'Data Pasien Lansia')
@section('page-name', 'Pantau Data Lansia')

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
        <i class="fas fa-wheelchair text-cyan-600 text-2xl animate-pulse"></i>
    </div>
    <p class="text-cyan-800 font-extrabold tracking-widest text-sm animate-pulse">MEMUAT DATA...</p>
</div>

<div class="max-w-7xl mx-auto animate-slide-up">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-[18px] bg-cyan-100 text-cyan-600 flex items-center justify-center text-2xl shadow-inner border border-cyan-200">
                <i class="fas fa-wheelchair"></i>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Pantau Lansia</h1>
                <p class="text-slate-500 mt-1 font-medium text-sm">Database warga lanjut usia dan pemantauan riwayat hipertensi.</p>
            </div>
        </div>
        <a href="{{ route('bidan.laporan.cetak', ['jenis' => 'lansia']) }}" class="smooth-route target-blank inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-white border border-slate-200 text-slate-700 font-extrabold text-sm rounded-xl hover:bg-slate-50 shadow-sm transition-all" target="_blank">
            <i class="fas fa-print text-cyan-600"></i> Cetak Laporan
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-5 rounded-[20px] border border-slate-200/80 shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl shrink-0"><i class="fas fa-smile"></i></div>
            <div>
                <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest mb-0.5">Tensi Normal</p>
                <h3 class="text-xl font-black text-slate-800">{{ $statistik->normal ?? 0 }} <span class="text-xs font-bold text-slate-500">Pasien</span></h3>
            </div>
        </div>
        <div class="bg-white p-5 rounded-[20px] border border-slate-200/80 shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center text-xl shrink-0"><i class="fas fa-heartbeat"></i></div>
            <div>
                <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest mb-0.5">Hipertensi</p>
                <h3 class="text-xl font-black text-slate-800">{{ $statistik->hipertensi ?? 0 }} <span class="text-xs font-bold text-slate-500">Pasien</span></h3>
            </div>
        </div>
        <div class="bg-white p-5 rounded-[20px] border-b-4 border-rose-500 shadow-[0_4px_20px_rgba(0,0,0,0.03)] flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-rose-50 text-rose-500 flex items-center justify-center text-xl shrink-0"><i class="fas fa-exclamation-triangle"></i></div>
            <div>
                <p class="text-[11px] font-extrabold text-rose-500 uppercase tracking-widest mb-0.5">Tensi Kritis (>180)</p>
                <h3 class="text-xl font-black text-rose-600">{{ $statistik->kritis ?? 0 }} <span class="text-xs font-bold text-rose-500">Pasien</span></h3>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
        
        <div class="p-5 border-b border-slate-100 bg-slate-50/50">
            <form id="filterForm" action="{{ route('bidan.pasien.lansia') }}" method="GET" class="flex flex-wrap md:flex-nowrap gap-3">
                
                <div class="w-full md:w-1/2 relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIK, atau diagnosa penyakit..." class="w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-cyan-100 focus:border-cyan-500 outline-none transition-all shadow-sm">
                </div>

                <div class="w-full md:w-1/4">
                    <select name="status" class="auto-submit w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-cyan-100 outline-none cursor-pointer shadow-sm">
                        <option value="">Semua Kondisi</option>
                        <option value="normal" {{ request('status') == 'normal' ? 'selected' : '' }}>Tensi Normal</option>
                        <option value="hipertensi" {{ request('status') == 'hipertensi' ? 'selected' : '' }}>Hipertensi</option>
                        <option value="diabetes" {{ request('status') == 'diabetes' ? 'selected' : '' }}>Diabetes / Gula</option>
                    </select>
                </div>

                @if(request()->anyFilled(['search', 'status']))
                    <div class="w-full md:w-auto">
                        <a href="{{ route('bidan.pasien.lansia') }}" class="smooth-route flex items-center justify-center h-full px-5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-100 transition-colors font-bold text-sm">
                            Reset Filter
                        </a>
                    </div>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse min-w-[900px]">
                <thead>
                    <tr class="bg-white border-b border-slate-100">
                        <th class="px-6 py-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Identitas Lansia</th>
                        <th class="px-6 py-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Pemeriksaan Terakhir</th>
                        <th class="px-6 py-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Hasil Diagnosa</th>
                        <th class="px-6 py-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($lansias as $lansia)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-800 text-sm mb-1">{{ $lansia->nama_lengkap }}</p>
                            <p class="text-[11px] font-semibold text-slate-500"><i class="fas fa-id-card mr-1 text-slate-400"></i> {{ $lansia->nik }}</p>
                            <p class="text-[11px] font-semibold text-slate-500 mt-0.5"><i class="fas fa-birthday-cake mr-1 text-slate-400"></i> {{ \Carbon\Carbon::parse($lansia->tanggal_lahir)->format('d M Y') }} ({{ \Carbon\Carbon::parse($lansia->tanggal_lahir)->age }} thn)</p>
                        </td>

                        <td class="px-6 py-4 align-top">
                            @if($lansia->pemeriksaan_terakhir)
                                <p class="font-bold text-slate-700 text-xs mb-1">{{ \Carbon\Carbon::parse($lansia->pemeriksaan_terakhir->tanggal_periksa)->format('d M Y') }}</p>
                                <div class="flex flex-wrap gap-1.5 text-[10px] font-bold">
                                    <span class="bg-slate-100 text-slate-600 px-2 py-0.5 rounded border border-slate-200">BB: {{ $lansia->pemeriksaan_terakhir->berat_badan ?? '-' }}kg</span>
                                    @if($lansia->pemeriksaan_terakhir->tekanan_darah)
                                        @php
                                            $td = intval(explode('/', $lansia->pemeriksaan_terakhir->tekanan_darah)[0] ?? 0);
                                            $tdClass = $td >= 140 ? 'bg-rose-50 text-rose-700 border-rose-200' : 'bg-cyan-50 text-cyan-700 border-cyan-200';
                                        @endphp
                                        <span class="px-2 py-0.5 rounded border {{ $tdClass }}">TD: {{ $lansia->pemeriksaan_terakhir->tekanan_darah }}</span>
                                    @endif
                                </div>
                            @else
                                <span class="text-xs text-slate-400 italic">Belum ada riwayat</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 align-top max-w-[250px]">
                            @if($lansia->pemeriksaan_terakhir && $lansia->pemeriksaan_terakhir->diagnosa)
                                <p class="text-xs font-semibold text-slate-700 line-clamp-2" title="{{ $lansia->pemeriksaan_terakhir->diagnosa }}">
                                    {{ $lansia->pemeriksaan_terakhir->diagnosa }}
                                </p>
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
                        <td colspan="4" class="text-center py-16">
                            <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-300 mx-auto mb-4 text-3xl shadow-inner"><i class="fas fa-search"></i></div>
                            <h4 class="font-black text-slate-700 text-sm">Data tidak ditemukan</h4>
                            <p class="text-xs text-slate-500 mt-1">Tidak ada lansia yang cocok dengan filter yang dipilih.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($lansias->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 pagination-wrapper">
            {{ $lansias->links() }}
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

    // Auto submit dropdown status
    document.querySelectorAll('.auto-submit').forEach(select => {
        select.addEventListener('change', function() {
            showLoader();
            document.getElementById('filterForm').submit();
        });
    });

    document.getElementById('filterForm').addEventListener('submit', showLoader);

    document.querySelectorAll('.smooth-route, .pagination-wrapper a').forEach(link => {
        link.addEventListener('click', function(e) {
            if(!this.classList.contains('target-blank') && this.target !== '_blank' && !e.ctrlKey) {
                showLoader();
            }
        });
    });
</script>
@endpush