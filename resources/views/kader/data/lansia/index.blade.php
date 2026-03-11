@extends('layouts.kader')

@section('title', 'Data Lansia')
@section('page-name', 'Database Lansia')

@push('styles')
<style>
    .animate-slide-up { opacity: 0; animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    
    .search-input {
        width: 100%; background-color: #f8fafc; border: 2px solid #e2e8f0; color: #0f172a;
        font-size: 0.875rem; border-radius: 1rem; padding: 0.75rem 1rem 0.75rem 2.75rem;
        outline: none; transition: all 0.3s ease; font-weight: 600;
        box-shadow: inset 0 2px 4px 0 rgb(0 0 0 / 0.02);
    }
    .search-input:focus {
        background-color: #ffffff; border-color: #10b981; /* Emerald */
        box-shadow: 0 4px 12px -3px rgba(16, 185, 129, 0.15);
    }
    .search-input::placeholder { color: #94a3b8; font-weight: 500; }
    
    .custom-scrollbar::-webkit-scrollbar { height: 8px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto animate-slide-up">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-[18px] bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl shadow-inner border border-emerald-200/50 transform -rotate-3 hover:rotate-0 transition-transform">
                <i class="fas fa-user-clock"></i>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Database Lansia</h1>
                <p class="text-slate-500 mt-1 font-medium text-sm">Kelola data warga lanjut usia & pra-lansia.</p>
            </div>
        </div>
        <a href="{{ route('kader.data.lansia.create') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-emerald-500 text-white font-extrabold text-sm rounded-xl hover:bg-emerald-600 shadow-[0_4px_12px_rgba(16,185,129,0.3)] hover:-translate-y-0.5 transition-all">
            <i class="fas fa-plus"></i> Tambah Lansia Baru
        </a>
    </div>

    <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-4 mb-6">
        <form action="{{ route('kader.data.lansia.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama lansia, NIK, atau kode..." class="search-input">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-6 py-3 bg-slate-800 text-white font-extrabold text-sm rounded-xl hover:bg-slate-900 shadow-sm transition-colors">
                    Cari Data
                </button>
                @if($search)
                    <a href="{{ route('kader.data.lansia.index') }}" class="px-6 py-3 bg-rose-50 text-rose-600 font-extrabold text-sm rounded-xl hover:bg-rose-100 transition-colors border border-rose-100 flex items-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse min-w-[850px]">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100">
                        <th class="px-6 py-5 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Profil Lansia</th>
                        <th class="px-6 py-5 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Usia & TTL</th>
                        <th class="px-6 py-5 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Riwayat Penyakit</th>
                        <th class="px-6 py-5 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest text-center">Status Akun</th>
                        <th class="px-6 py-5 text-[10px] font-extrabold text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($lansias as $lansia)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl flex items-center justify-center font-black text-lg shadow-sm border border-white {{ $lansia->jenis_kelamin == 'L' ? 'bg-sky-100 text-sky-600' : 'bg-rose-100 text-rose-600' }}">
                                    {{ strtoupper(substr($lansia->nama_lengkap, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-extrabold text-slate-800 text-sm mb-0.5">{{ $lansia->nama_lengkap }}</p>
                                    <p class="text-[11px] font-bold text-slate-400 flex items-center gap-1.5">
                                        <i class="fas fa-barcode"></i> {{ $lansia->nik }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-slate-100 text-slate-700 text-xs font-bold rounded-lg mb-1 border border-slate-200">
                                <i class="fas fa-hourglass-half text-emerald-500"></i> 
                                {{ \Carbon\Carbon::parse($lansia->tanggal_lahir)->age }} Tahun
                            </div>
                            <p class="text-[11px] font-bold text-slate-500 pl-1">{{ $lansia->tempat_lahir }}, {{ $lansia->tanggal_lahir->format('d M Y') }}</p>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1.5 max-w-[200px]">
                                @if($lansia->penyakit_bawaan)
                                    @foreach(explode(',', $lansia->penyakit_bawaan) as $sakit)
                                        <span class="px-2 py-1 bg-rose-50 text-rose-600 border border-rose-100 rounded-md text-[10px] font-bold uppercase tracking-wider">{{ trim($sakit) }}</span>
                                    @endforeach
                                @else
                                    <span class="inline-flex items-center gap-1 text-emerald-600 font-bold text-xs"><i class="fas fa-check-circle"></i> Sehat / Normal</span>
                                @endif
                            </div>
                        </td>

                        <td class="px-6 py-4 text-center">
                            @if($lansia->user_id)
                                <div class="inline-flex flex-col items-center justify-center">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[11px] font-extrabold border border-emerald-200">
                                        <i class="fas fa-check-circle text-emerald-500"></i> Terhubung
                                    </span>
                                </div>
                            @else
                                <div class="inline-flex flex-col items-center justify-center" title="Belum ada akun warga dengan NIK ini">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-[11px] font-extrabold border border-amber-200">
                                        <i class="fas fa-exclamation-circle text-amber-500"></i> Belum
                                    </span>
                                </div>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('kader.data.lansia.show', $lansia->id) }}" class="w-9 h-9 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:text-emerald-600 hover:border-emerald-300 hover:bg-emerald-50 shadow-sm transition-all" title="Detail Profil">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('kader.data.lansia.edit', $lansia->id) }}" class="w-9 h-9 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:text-amber-600 hover:border-amber-300 hover:bg-amber-50 shadow-sm transition-all" title="Edit Data">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('kader.data.lansia.destroy', $lansia->id) }}" method="POST" onsubmit="return confirm('Tindakan ini tidak dapat dibatalkan. Yakin hapus data lansia ini?');" class="inline-block">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-9 h-9 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:text-rose-600 hover:border-rose-300 hover:bg-rose-50 shadow-sm transition-all" title="Hapus Data">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="w-20 h-20 bg-slate-50 rounded-[20px] flex items-center justify-center text-slate-300 mx-auto mb-4 text-3xl shadow-inner border border-slate-100">
                                <i class="fas fa-user-slash"></i>
                            </div>
                            <h3 class="font-black text-slate-800 text-lg">Belum Ada Data Lansia</h3>
                            <p class="text-sm text-slate-500 mt-1 max-w-md mx-auto">Anda belum menambahkan data lansia atau pencarian tidak ditemukan.</p>
                            <a href="{{ route('kader.data.lansia.create') }}" class="inline-flex items-center gap-2 mt-4 text-emerald-600 font-bold hover:text-emerald-700">
                                <i class="fas fa-plus"></i> Tambah Data Sekarang
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($lansias->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $lansias->links() }}
        </div>
        @endif
    </div>
</div>
@endsection