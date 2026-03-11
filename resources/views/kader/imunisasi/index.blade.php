@extends('layouts.kader')

@section('title', 'Register Imunisasi')
@section('page-name', 'Riwayat Imunisasi')

@push('styles')
<style>
    .animate-slide-up { opacity: 0; animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    
    .search-input {
        width: 100%; background-color: #f8fafc; border: 2px solid #e2e8f0; color: #0f172a;
        font-size: 0.875rem; border-radius: 1rem; padding: 0.85rem 1rem 0.85rem 2.75rem;
        outline: none; transition: all 0.3s ease; font-weight: 600;
        box-shadow: inset 0 2px 4px 0 rgb(0 0 0 / 0.02);
    }
    .search-input:focus {
        background-color: #ffffff; border-color: #0d9488; /* Teal 600 */
        box-shadow: 0 4px 12px -3px rgba(13, 148, 136, 0.15);
    }
    .search-input::placeholder { color: #94a3b8; font-weight: 500; }
    .custom-scrollbar::-webkit-scrollbar { height: 8px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .table-loading { opacity: 0.4; pointer-events: none; filter: grayscale(50%); transition: all 0.3s ease; }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto animate-slide-up">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-[18px] bg-teal-100 text-teal-600 flex items-center justify-center text-2xl shadow-inner border border-teal-200/50 transform -rotate-3 hover:rotate-0 transition-transform">
                <i class="fas fa-shield-virus"></i>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Register Imunisasi</h1>
                <p class="text-slate-500 mt-1 font-medium text-sm">Buku log riwayat pemberian vaksin oleh Bidan.</p>
            </div>
        </div>
        
        <div class="px-4 py-2.5 bg-teal-50 border border-teal-200 rounded-xl flex items-center gap-2">
            <i class="fas fa-info-circle text-teal-500"></i>
            <span class="text-xs font-bold text-teal-800">Input Imunisasi dilakukan oleh Bidan</span>
        </div>
    </div>

    <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-4 mb-6 flex flex-col lg:flex-row items-center justify-between gap-4">
        
        <div class="flex gap-2 w-full lg:w-auto overflow-x-auto custom-scrollbar pb-1 sm:pb-0">
            @php $currentCat = request('kategori', 'semua'); @endphp
            @foreach(['semua'=>'Semua Data', 'balita'=>'🍼 Balita', 'remaja'=>'🎓 Remaja (HPV/TT)'] as $k => $l)
                <a href="{{ request()->fullUrlWithQuery(['kategori'=>$k, 'page'=>1]) }}" 
                   data-kategori="{{ $k }}"
                   class="kategori-btn px-5 py-2.5 rounded-xl font-bold text-sm whitespace-nowrap transition-all duration-300 border 
                   {{ $currentCat == $k ? 'bg-teal-600 text-white border-teal-600 shadow-md' : 'bg-slate-50 text-slate-500 border-slate-200 hover:bg-slate-100 hover:text-slate-800' }}">
                    {{ $l }}
                </a>
            @endforeach
        </div>
        
        <div class="w-full lg:w-1/3 relative">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            <input type="text" id="searchInput" value="{{ $search ?? '' }}" placeholder="Kari nama pasien atau jenis vaksin..." class="search-input" autocomplete="off">
            <div id="searchSpinner" class="absolute right-4 top-1/2 -translate-y-1/2 hidden">
                <i class="fas fa-spinner fa-spin text-teal-500"></i>
            </div>
        </div>
    </div>

    <div id="table-container" class="transition-opacity duration-300">
        <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse min-w-[900px]">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-100">
                            <th class="px-6 py-5 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Tgl Pemberian</th>
                            <th class="px-6 py-5 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Nama Pasien</th>
                            <th class="px-6 py-5 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Detail Vaksin</th>
                            <th class="px-6 py-5 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Petugas (Bidan)</th>
                            <th class="px-6 py-5 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest text-center">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($imunisasis as $imun)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            
                            <td class="px-6 py-4">
                                <p class="font-black text-slate-800 text-sm mb-1">{{ \Carbon\Carbon::parse($imun->tanggal_imunisasi)->format('d M Y') }}</p>
                                <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-[10px] font-bold rounded-md">{{ \Carbon\Carbon::parse($imun->tanggal_imunisasi)->diffForHumans() }}</span>
                            </td>

                            <td class="px-6 py-4">
                                <p class="font-bold text-slate-800 text-sm">{{ $imun->kunjungan->pasien->nama_lengkap ?? 'Unknown' }}</p>
                                @if(class_basename($imun->kunjungan->pasien_type) == 'Balita')
                                    <span class="text-[10px] font-extrabold text-rose-500 uppercase tracking-wider">Balita</span>
                                @else
                                    <span class="text-[10px] font-extrabold text-sky-500 uppercase tracking-wider">Remaja</span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-teal-50 text-teal-600 flex items-center justify-center shadow-sm border border-teal-100">
                                        <i class="fas fa-syringe"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-800">{{ $imun->jenis_imunisasi }} <span class="text-teal-600">({{ $imun->dosis }})</span></p>
                                        <p class="text-[11px] font-bold text-slate-400">Vaksin: {{ $imun->vaksin }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <p class="font-bold text-slate-700 text-sm"><i class="fas fa-user-nurse text-slate-400 mr-1"></i> {{ $imun->kunjungan->petugas->name ?? 'Bidan' }}</p>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('kader.kunjungan.show', $imun->kunjungan_id) }}" class="inline-flex w-9 h-9 rounded-xl bg-white border border-slate-200 items-center justify-center text-slate-500 hover:text-teal-600 hover:border-teal-300 hover:bg-teal-50 shadow-sm transition-all tooltip" title="Lihat Riwayat Kunjungan Lengkap">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="w-20 h-20 bg-slate-50 rounded-[20px] flex items-center justify-center text-slate-300 mx-auto mb-4 text-3xl shadow-inner border border-slate-100">
                                    <i class="fas fa-shield-virus"></i>
                                </div>
                                <h3 class="font-black text-slate-800 text-lg">Belum Ada Riwayat Imunisasi</h3>
                                <p class="text-sm text-slate-500 mt-1">Data akan muncul di sini setelah Bidan memverifikasi dan memberikan imunisasi.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($imunisasis->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 pagination-wrapper">
                {{ $imunisasis->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Copy-paste persis script AJAX Realtime dari halaman Index Pemeriksaan sebelumnya di sini.
    // Ubah sedikit warna efek tombol dari indigo ke teal.
    document.addEventListener('DOMContentLoaded', function() {
        let typingTimer;
        const searchInput = document.getElementById('searchInput');
        const tableContainer = document.getElementById('table-container');
        const spinner = document.getElementById('searchSpinner');

        async function fetchRealTimeData(url) {
            tableContainer.classList.add('table-loading');
            spinner.classList.remove('hidden');
            try {
                const response = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' }});
                const html = await response.text();
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                tableContainer.innerHTML = doc.getElementById('table-container').innerHTML;
                window.history.pushState({}, '', url);
            } catch (error) {
                console.error('Error fetching data:', error);
            } finally {
                tableContainer.classList.remove('table-loading');
                spinner.classList.add('hidden');
            }
        }

        if(searchInput) {
            searchInput.addEventListener('input', function(e) {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(() => {
                    const url = new URL(window.location.href);
                    url.searchParams.set('search', e.target.value);
                    url.searchParams.set('page', 1);
                    fetchRealTimeData(url.toString());
                }, 400);
            });
        }

        const categoryButtons = document.querySelectorAll('.kategori-btn');
        categoryButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                categoryButtons.forEach(b => {
                    b.classList.remove('bg-teal-600', 'text-white', 'border-teal-600', 'shadow-md');
                    b.classList.add('bg-slate-50', 'text-slate-500', 'border-slate-200');
                });
                this.classList.remove('bg-slate-50', 'text-slate-500', 'border-slate-200');
                this.classList.add('bg-teal-600', 'text-white', 'border-teal-600', 'shadow-md');

                const url = new URL(this.href);
                if(searchInput && searchInput.value) url.searchParams.set('search', searchInput.value);
                fetchRealTimeData(url.toString());
            });
        });

        document.addEventListener('click', function(e) {
            const pageLink = e.target.closest('.pagination-wrapper a');
            if (pageLink) {
                e.preventDefault();
                fetchRealTimeData(pageLink.href);
            }
        });

        window.addEventListener('popstate', function() { fetchRealTimeData(window.location.href); });
    });
</script>
@endpush
@endsection