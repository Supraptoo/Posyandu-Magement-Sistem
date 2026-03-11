@extends('layouts.bidan')

@section('title', 'Laporan Bulanan')
@section('page-name', 'Laporan & Rekapitulasi')

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
        <i class="fas fa-file-invoice text-cyan-600 text-2xl animate-pulse"></i>
    </div>
    <p class="text-cyan-800 font-extrabold tracking-widest text-sm animate-pulse" id="loaderText">MEMPROSES DATA...</p>
</div>

<div class="max-w-7xl mx-auto animate-slide-up">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-[18px] bg-cyan-100 text-cyan-600 flex items-center justify-center text-2xl shadow-inner border border-cyan-200">
                <i class="fas fa-chart-bar"></i>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Laporan Bulanan</h1>
                <p class="text-slate-500 mt-1 font-medium text-sm">Generate, filter, dan cetak laporan resmi hasil pemeriksaan posyandu.</p>
            </div>
        </div>
        
        <form action="{{ route('bidan.laporan.cetak') }}" method="GET" class="m-0 p-0" onsubmit="handleDownload(this)">
            <input type="hidden" name="bulan" value="{{ $bulan ?? date('n') }}">
            <input type="hidden" name="tahun" value="{{ $tahun ?? date('Y') }}">
            <input type="hidden" name="jenis" value="{{ $jenis ?? 'semua' }}">
            
            <button type="submit" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-gradient-to-r from-cyan-500 to-cyan-600 text-white font-black text-sm rounded-xl hover:from-cyan-600 hover:to-cyan-700 shadow-[0_8px_20px_rgba(8,145,178,0.25)] hover:-translate-y-0.5 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed" {{ isset($data) && $data->count() == 0 ? 'disabled' : '' }}>
                <i class="fas fa-file-pdf"></i> Unduh File PDF
            </button>
        </form>
    </div>

    <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] mb-6 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50 flex items-center gap-3">
            <i class="fas fa-filter text-cyan-600"></i>
            <h3 class="font-extrabold text-slate-800">Filter Parameter Laporan</h3>
        </div>
        <div class="p-6">
            <form method="GET" action="{{ route('bidan.laporan.index') }}" id="formFilter" class="flex flex-col md:flex-row gap-4 items-end">
                <div class="w-full md:w-1/4">
                    <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Periode Bulan</label>
                    <select name="bulan" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl px-4 py-3 outline-none font-semibold focus:border-cyan-500 transition-colors shadow-inner cursor-pointer">
                        @foreach(range(1,12) as $b)
                            <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>{{ Carbon\Carbon::create()->month($b)->translatedFormat('F') }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full md:w-1/4">
                    <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Tahun</label>
                    <input type="number" name="tahun" value="{{ $tahun }}" min="2020" max="2030" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl px-4 py-3 outline-none font-semibold focus:border-cyan-500 transition-colors shadow-inner">
                </div>
                <div class="w-full md:w-1/3">
                    <label class="block text-[11px] font-extrabold text-cyan-600 uppercase tracking-widest mb-2">Kategori Laporan</label>
                    <select name="jenis" class="w-full bg-cyan-50 border border-cyan-200 text-cyan-800 text-sm rounded-xl px-4 py-3 outline-none font-bold focus:border-cyan-500 transition-colors shadow-inner cursor-pointer">
                        <option value="semua" {{ $jenis == 'semua' ? 'selected' : '' }}>Semua Kategori (Rekap Total)</option>
                        <option value="balita" {{ $jenis == 'balita' ? 'selected' : '' }}>Khusus Laporan Balita</option>
                        <option value="remaja" {{ $jenis == 'remaja' ? 'selected' : '' }}>Khusus Laporan Remaja</option>
                        <option value="lansia" {{ $jenis == 'lansia' ? 'selected' : '' }}>Khusus Laporan Lansia</option>
                    </select>
                </div>
                <div class="w-full md:w-auto">
                    <button type="submit" class="w-full md:w-auto px-8 py-3 bg-slate-800 text-white font-bold text-sm rounded-xl hover:bg-slate-900 transition-colors shadow-md">
                        Tampilkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] mb-8 overflow-hidden border-l-4 border-l-emerald-500">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <i class="fas fa-signature text-emerald-600"></i>
                <h3 class="font-extrabold text-slate-800">Pengaturan Tanda Tangan Cetak</h3>
            </div>
            <span class="text-[10px] font-bold bg-emerald-100 text-emerald-700 px-2 py-1 rounded-md uppercase tracking-wider">Otomatis Tersemat</span>
        </div>
        <div class="p-6">
            <p class="text-sm text-slate-500 mb-3">Unggah gambar tanda tangan (berlatar putih/transparan) agar otomatis tersemat di bagian bawah file PDF cetak laporan resmi.</p>
            
            <div class="flex gap-4 mb-5">
                @if(file_exists(public_path('uploads/ttd/ttd_bidan.png')))
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-lg border border-emerald-200"><i class="fas fa-check-circle"></i> TTD Bidan: Tersedia</span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-50 text-slate-500 text-xs font-bold rounded-lg border border-slate-200"><i class="fas fa-times-circle"></i> TTD Bidan: Kosong</span>
                @endif

                @if(file_exists(public_path('uploads/ttd/ttd_kades.png')))
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-lg border border-emerald-200"><i class="fas fa-check-circle"></i> TTD Kades: Tersedia</span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-50 text-slate-500 text-xs font-bold rounded-lg border border-slate-200"><i class="fas fa-times-circle"></i> TTD Kades: Kosong</span>
                @endif
            </div>
            
            <form action="{{ route('bidan.laporan.upload-ttd') }}" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row gap-4 items-end">
                @csrf
                <div class="w-full md:w-1/3">
                    <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Pilih Posisi Tanda Tangan</label>
                    <select name="ttd_type" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl px-4 py-3 outline-none font-bold focus:border-emerald-500 transition-colors shadow-inner cursor-pointer" required>
                        <option value="bidan">Bidan / Validator Medis (Kanan)</option>
                        <option value="kades">Kepala Desa (Kiri)</option>
                    </select>
                </div>
                <div class="w-full md:w-1/3">
                    <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Upload File Gambar</label>
                    <input type="file" name="ttd_image" accept="image/png, image/jpeg, image/jpg" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl px-4 py-2.5 outline-none font-semibold focus:border-emerald-500 transition-colors file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-emerald-100 file:text-emerald-700 hover:file:bg-emerald-200 cursor-pointer shadow-inner" required>
                </div>
                <div class="w-full md:w-auto">
                    <button type="submit" onclick="showLoader('MENGUNGGAH TTD...')" class="w-full md:w-auto px-6 py-3 bg-emerald-600 text-white font-bold text-sm rounded-xl hover:bg-emerald-700 transition-colors shadow-md flex items-center justify-center gap-2">
                        <i class="fas fa-upload"></i> Simpan TTD
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="mb-8">
        <h3 class="text-sm font-black text-slate-800 mb-4 flex items-center gap-2">
            <i class="fas fa-chart-pie text-cyan-500"></i> Ringkasan Eksekutif 
            <span class="px-2 py-0.5 bg-cyan-100 text-cyan-700 rounded-md text-[10px] uppercase tracking-wider ml-2">{{ Carbon\Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y') }}</span>
        </h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @php
                $allCards = [
                    ['Total Kunjungan',    $ringkasan['total'] ?? 0,      'cyan',    'list-ol', 'semua'],
                    ['Balita',             $ringkasan['balita'] ?? 0,     'rose',    'baby', 'balita'],
                    ['Remaja',             $ringkasan['remaja'] ?? 0,     'indigo',  'user-graduate', 'remaja'],
                    ['Lansia',             $ringkasan['lansia'] ?? 0,     'emerald', 'wheelchair', 'lansia'],
                    ['Sudah Diverifikasi', $ringkasan['verified'] ?? 0,   'emerald', 'check-circle', 'semua'],
                    ['Belum Diverifikasi', $ringkasan['pending'] ?? 0,    'amber',   'clock', 'semua'],
                    ['Risiko Stunting',    $ringkasan['stunting'] ?? 0,   'rose',    'exclamation-triangle', 'balita'],
                    ['Kasus Hipertensi',   $ringkasan['hipertensi'] ?? 0, 'rose',    'heartbeat', 'lansia'],
                ];
                $displayCards = array_filter($allCards, function($card) use ($jenis) {
                    return $jenis == 'semua' || $card[4] == 'semua' || $card[4] == $jenis;
                });
            @endphp
            @foreach($displayCards as [$label, $nilai, $color, $icon, $target])
            <div class="bg-white p-5 rounded-[20px] border border-slate-100 shadow-sm relative overflow-hidden group hover:shadow-md transition-all duration-300">
                <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-{{ $color }}-50 opacity-50 transition-transform duration-500 group-hover:scale-150"></div>
                <div class="relative z-10 flex justify-between items-start">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">{{ $label }}</p>
                        <h3 class="text-2xl font-black text-slate-800">{{ $nilai }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-{{ $color }}-100 text-{{ $color }}-600 flex items-center justify-center text-lg shadow-sm">
                        <i class="fas fa-{{ $icon }}"></i>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center gap-3">
            <i class="fas fa-table text-cyan-600"></i>
            <h3 class="font-extrabold text-slate-800">Preview Data Cetak ({{ $data->count() }} Baris)</h3>
        </div>
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse min-w-[900px]">
                <thead>
                    <tr class="bg-white border-b border-slate-100">
                        <th class="px-6 py-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest w-16">No</th>
                        <th class="px-6 py-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Pasien & Tanggal</th>
                        <th class="px-6 py-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Kategori</th>
                        <th class="px-6 py-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Hasil Fisik</th>
                        <th class="px-6 py-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest text-center">Status Gizi</th>
                        <th class="px-6 py-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Diagnosa Bidan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($data as $i => $item)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="px-6 py-4 text-xs font-bold text-slate-400">{{ $i + 1 }}</td>
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-800 text-sm">{{ $item->nama_pasien }}</p>
                            <p class="text-[10px] font-bold text-slate-400 mt-0.5"><i class="fas fa-calendar-day mr-1"></i> {{ \Carbon\Carbon::parse($item->tanggal_periksa)->format('d/m/Y') }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $badgeColor = match($item->kategori_pasien) {
                                    'balita' => 'bg-rose-50 text-rose-600 border-rose-200',
                                    'remaja' => 'bg-indigo-50 text-indigo-600 border-indigo-200',
                                    'lansia' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                    default  => 'bg-slate-50 text-slate-600 border-slate-200'
                                };
                            @endphp
                            <span class="px-2 py-1 rounded border text-[10px] font-extrabold uppercase {{ $badgeColor }}">{{ $item->kategori_pasien }}</span>
                        </td>
                        <td class="px-6 py-4 text-xs font-semibold text-slate-600">
                            BB: <span class="font-black text-slate-800">{{ $item->berat_badan ?? '-' }} kg</span> <br>
                            TB: <span class="font-black text-slate-800">{{ $item->tinggi_badan ?? '-' }} cm</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $gizi = strtolower($item->status_gizi ?? '');
                                $gClass = match(true) {
                                    in_array($gizi, ['baik', 'normal', 'sehat']) => 'bg-emerald-100 text-emerald-700',
                                    in_array($gizi, ['kurang', 'risiko', 'lebih', 'obesitas']) => 'bg-amber-100 text-amber-700',
                                    in_array($gizi, ['buruk', 'stunting', 'bahaya']) => 'bg-rose-100 text-rose-700',
                                    default => 'bg-slate-100 text-slate-600'
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-lg text-[10px] font-bold uppercase {{ $gClass }}">{{ $item->status_gizi ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4 max-w-[200px]">
                            @if($item->diagnosa)
                                <p class="text-xs font-semibold text-slate-700 line-clamp-2" title="{{ $item->diagnosa }}">{{ $item->diagnosa }}</p>
                            @else
                                <span class="text-[10px] font-bold text-amber-500 bg-amber-50 px-2 py-1 rounded border border-amber-200"><i class="fas fa-exclamation-circle mr-1"></i> Belum Divalidasi</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-16">
                            <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-300 mx-auto mb-4 text-3xl shadow-inner"><i class="fas fa-file-excel"></i></div>
                            <h4 class="font-black text-slate-700 text-sm">Laporan Kosong</h4>
                            <p class="text-xs text-slate-500 mt-1">Tidak ada data pemeriksaan pada periode ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const showLoader = (text = 'MENYIAPKAN LAPORAN...') => {
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
    document.getElementById('formFilter').addEventListener('submit', () => showLoader('MENGAMBIL DATA...'));
    function handleDownload(form) {
        const btn = form.querySelector('button[type="submit"]');
        const originalText = btn.innerHTML;
        
        // Ubah teks sementara saat PDF sedang di-generate oleh server (biasanya butuh 2-3 detik)
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyusun PDF...';
        btn.classList.add('opacity-75', 'cursor-wait');
        
        // Kembalikan tombol seperti semula setelah 3.5 detik (asumsi PDF sudah terdownload)
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.classList.remove('opacity-75', 'cursor-wait');
        }, 3500);
    }
</script>
@endpush