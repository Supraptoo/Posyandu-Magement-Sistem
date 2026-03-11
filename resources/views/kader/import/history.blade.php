@extends('layouts.kader')

@section('title', 'Riwayat Import')
@section('page-name', 'Log Import Data')

@push('styles')
<style>
    .animate-slide-up { opacity: 0; animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .custom-scrollbar::-webkit-scrollbar { height: 8px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto animate-slide-up">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-[18px] bg-slate-100 text-slate-600 flex items-center justify-center text-2xl shadow-inner border border-slate-200">
                <i class="fas fa-history"></i>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Riwayat Import</h1>
                <p class="text-slate-500 mt-1 font-medium text-sm">Secara default hanya menampilkan log aktivitas hari ini.</p>
            </div>
        </div>
        <a href="{{ route('kader.import.create') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-indigo-600 text-white font-extrabold text-sm rounded-xl hover:bg-indigo-700 shadow-[0_4px_12px_rgba(79,70,229,0.3)] hover:-translate-y-0.5 transition-all">
            <i class="fas fa-plus"></i> Import Baru
        </a>
    </div>

    <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-6 mb-6">
        <form action="{{ route('kader.import.history') }}" method="GET" class="flex flex-col sm:flex-row items-end gap-4">
            <div class="w-full sm:w-1/2">
                <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Filter Berdasarkan Tanggal</label>
                <div class="relative">
                    <i class="fas fa-calendar-alt absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="date" name="tanggal" value="{{ $tanggal ?? date('Y-m-d') }}" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl pl-11 pr-4 py-3 outline-none font-medium focus:border-indigo-500 focus:bg-white transition-colors shadow-inner">
                </div>
            </div>
            
            <div class="w-full sm:w-1/4">
                <button type="submit" class="w-full py-3 bg-indigo-100 text-indigo-700 font-extrabold text-sm rounded-xl hover:bg-indigo-200 hover:text-indigo-800 transition-colors flex items-center justify-center gap-2 shadow-sm">
                    <i class="fas fa-filter"></i> Cari Riwayat
                </button>
            </div>
            <div class="w-full sm:w-1/4">
                <a href="{{ route('kader.import.history') }}" class="w-full py-3 bg-slate-100 text-slate-600 border border-slate-200 font-extrabold text-sm rounded-xl hover:bg-slate-200 hover:text-slate-800 transition-colors flex items-center justify-center gap-2 shadow-sm text-center">
                    <i class="fas fa-sync-alt"></i> Reset (Hari Ini)
                </a>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
        
        <div class="px-6 py-5 border-b border-slate-100 flex items-center gap-3 bg-slate-50/50">
            <h3 class="text-base font-extrabold text-slate-800">Daftar Transaksi: {{ \Carbon\Carbon::parse($tanggal)->format('d F Y') }}</h3>
        </div>

        @if($imports->count() > 0)
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse min-w-[900px]">
                <thead>
                    <tr class="bg-white border-b border-slate-100">
                        <th class="px-6 py-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Waktu Upload</th>
                        <th class="px-6 py-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">File & Target</th>
                        <th class="px-6 py-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-6 py-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest text-center">Hasil Data</th>
                        <th class="px-6 py-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($imports as $import)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-800 text-sm">{{ $import->created_at->format('d M Y') }}</p>
                            <p class="text-[11px] font-bold text-slate-400 mt-0.5"><i class="fas fa-clock mr-1"></i> {{ $import->created_at->format('H:i') }} WIB</p>
                        </td>

                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-700 text-xs mb-1 truncate max-w-[200px]" title="{{ $import->nama_file }}"><i class="fas fa-file-excel text-emerald-500 mr-1"></i> {{ $import->nama_file }}</p>
                            @if($import->jenis_data == 'balita') <span class="px-2 py-0.5 bg-rose-100 text-rose-700 text-[10px] font-extrabold rounded-md uppercase">Data Balita</span>
                            @elseif($import->jenis_data == 'remaja') <span class="px-2 py-0.5 bg-sky-100 text-sky-700 text-[10px] font-extrabold rounded-md uppercase">Data Remaja</span>
                            @else <span class="px-2 py-0.5 bg-emerald-100 text-emerald-700 text-[10px] font-extrabold rounded-md uppercase">Data Lansia</span> @endif
                        </td>

                        <td class="px-6 py-4 text-center">
                            @if($import->status == 'completed')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-emerald-50 text-emerald-600 text-[10px] font-bold border border-emerald-100"><i class="fas fa-check-circle"></i> Selesai</span>
                            @elseif($import->status == 'processing')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-amber-50 text-amber-600 text-[10px] font-bold border border-amber-100" title="Sedang diproses sistem atau terhenti karena format file salah"><i class="fas fa-hourglass-half"></i> Tertunda</span>
                            @elseif($import->status == 'pending')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 text-[10px] font-bold border border-slate-200"><i class="fas fa-clock"></i> Antre</span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-rose-50 text-rose-600 text-[10px] font-bold border border-rose-100"><i class="fas fa-times-circle"></i> Gagal</span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2 text-xs">
                                <div class="px-2 py-1 bg-slate-50 border border-slate-200 rounded-lg text-center" title="Total Baris">
                                    <span class="font-black text-slate-700">{{ $import->total_data ?? '-' }}</span>
                                </div>
                                <div class="px-2 py-1 bg-emerald-50 border border-emerald-100 rounded-lg text-center text-emerald-700" title="Berhasil Masuk">
                                    <span class="font-black"><i class="fas fa-check text-[9px]"></i> {{ $import->data_berhasil ?? '-' }}</span>
                                </div>
                                <div class="px-2 py-1 bg-rose-50 border border-rose-100 rounded-lg text-center text-rose-700" title="Gagal/Ditolak">
                                    <span class="font-black"><i class="fas fa-times text-[9px]"></i> {{ $import->data_gagal ?? '-' }}</span>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('kader.import.show', $import->id) }}" title="Lihat Detail" class="inline-flex w-8 h-8 rounded-xl bg-white border border-slate-200 items-center justify-center text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 shadow-sm transition-all">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                <form action="{{ route('kader.import.destroy', $import->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus log riwayat ini secara permanen?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus Riwayat" class="inline-flex w-8 h-8 rounded-xl bg-white border border-slate-200 items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-rose-50 shadow-sm transition-all">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $imports->links() }}
        </div>

        @else
        <div class="text-center py-16">
            <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-300 mx-auto mb-4 text-2xl shadow-inner"><i class="fas fa-calendar-times"></i></div>
            <h4 class="font-black text-slate-700">Tidak Ada Data Import</h4>
            <p class="text-sm text-slate-500 mt-1">Anda belum melakukan import data pada tanggal ini.</p>
        </div>
        @endif
    </div>
</div>
@endsection