@extends('layouts.bidan')

@section('title', 'Buku Rekam Medis')
@section('page-name', 'Buku Rekam Medis')

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
        <i class="fas fa-book-medical text-cyan-600 text-2xl animate-pulse"></i>
    </div>
    <p class="text-cyan-800 font-extrabold tracking-widest text-sm animate-pulse" id="loaderText">MENCARI REKAM MEDIS...</p>
</div>

<div class="max-w-6xl mx-auto animate-slide-up">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-[18px] bg-cyan-100 text-cyan-600 flex items-center justify-center text-2xl shadow-inner border border-cyan-200">
                <i class="fas fa-book-medical"></i>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Rekam Medis Warga</h1>
                <p class="text-slate-500 mt-1 font-medium text-sm">Cari pasien untuk melihat riwayat kesehatan dari waktu ke waktu.</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
        
        <div class="p-6 border-b border-slate-100 bg-slate-50/50">
            <form action="{{ route('bidan.rekam-medis.index') }}" method="GET" id="searchForm" class="flex flex-col md:flex-row gap-4">
                
                <div class="flex bg-white p-1 rounded-xl border border-slate-200 shadow-sm w-full md:w-max shrink-0">
                    <a href="?type=balita&search={{ request('search') }}" class="smooth-route flex-1 md:flex-none text-center px-5 py-2.5 rounded-lg text-sm font-extrabold transition-colors {{ $type == 'balita' ? 'bg-cyan-600 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }}">Balita</a>
                    <a href="?type=remaja&search={{ request('search') }}" class="smooth-route flex-1 md:flex-none text-center px-5 py-2.5 rounded-lg text-sm font-extrabold transition-colors {{ $type == 'remaja' ? 'bg-cyan-600 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }}">Remaja</a>
                    <a href="?type=lansia&search={{ request('search') }}" class="smooth-route flex-1 md:flex-none text-center px-5 py-2.5 rounded-lg text-sm font-extrabold transition-colors {{ $type == 'lansia' ? 'bg-cyan-600 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }}">Lansia</a>
                </div>

                <input type="hidden" name="type" value="{{ $type }}">

                <div class="relative w-full">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIK pasien (Tekan Enter)..." class="w-full pl-11 pr-4 py-3.5 bg-white border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-cyan-100 focus:border-cyan-500 outline-none transition-all shadow-sm">
                </div>

                <button type="submit" class="hidden md:block px-6 py-3.5 bg-slate-800 text-white font-bold text-sm rounded-xl hover:bg-slate-900 transition-colors shadow-md">
                    Cari
                </button>
            </form>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($data as $pasien)
            <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50/50 transition-colors">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-xl shrink-0 {{ $type == 'balita' ? 'bg-rose-100 text-rose-500' : ($type == 'remaja' ? 'bg-indigo-100 text-indigo-500' : 'bg-emerald-100 text-emerald-500') }}">
                        <i class="fas {{ $type == 'balita' ? 'fa-baby' : ($type == 'remaja' ? 'fa-user-graduate' : 'fa-wheelchair') }}"></i>
                    </div>
                    <div>
                        <h4 class="font-black text-slate-800 text-lg mb-0.5">{{ $pasien->nama_lengkap }}</h4>
                        <div class="flex items-center gap-3 text-xs font-semibold text-slate-500">
                            <span><i class="fas fa-id-card text-slate-400 mr-1"></i> NIK: {{ $pasien->nik }}</span>
                            <span><i class="fas fa-birthday-cake text-slate-400 mr-1"></i> Usia: {{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->age }} Tahun</span>
                        </div>
                    </div>
                </div>
                <a href="{{ route('bidan.rekam-medis.show', ['pasien_type' => $type, 'pasien_id' => $pasien->id]) }}" class="smooth-route inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white border-2 border-cyan-100 text-cyan-600 font-bold text-sm rounded-xl hover:bg-cyan-50 hover:border-cyan-200 transition-all">
                    Buka Buku Medis <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            @empty
            <div class="text-center py-16">
                <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-300 mx-auto mb-4 text-3xl shadow-inner"><i class="fas fa-users-slash"></i></div>
                <h4 class="font-black text-slate-700 text-sm">Pasien tidak ditemukan</h4>
                <p class="text-xs text-slate-500 mt-1">Coba gunakan nama atau NIK lain.</p>
            </div>
            @endforelse
        </div>
        
        @if($data->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 pagination-wrapper">
            {{ $data->appends(request()->query())->links() }}
        </div>
        @endif

    </div>
</div>
@endsection

@push('scripts')
<script>
    const showLoader = (text = 'MEMUAT DATA...') => {
        const loader = document.getElementById('smoothLoader');
        if(loader) {
            document.getElementById('loaderText').innerText = text;
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

    document.getElementById('searchForm').addEventListener('submit', () => showLoader('MENCARI PASIEN...'));

    document.querySelectorAll('.smooth-route, .pagination-wrapper a').forEach(link => {
        link.addEventListener('click', function(e) {
            if(!this.classList.contains('target-blank') && this.target !== '_blank' && !e.ctrlKey) {
                showLoader('MEMUAT REKAM MEDIS...');
            }
        });
    });
</script>
@endpush