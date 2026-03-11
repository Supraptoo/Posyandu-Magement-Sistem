@extends('layouts.user')

@section('title', 'Pesan & Notifikasi')

@push('styles')
<style>
    .animate-slide-up { opacity: 0; animation: slideUpFade 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endpush

@section('content')
<div class="animate-slide-up space-y-6 pb-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-black text-slate-800 font-poppins tracking-tight">Kotak Masuk</h2>
            <p class="text-sm font-medium text-slate-500 mt-1">Pemberitahuan jadwal dan info kesehatan.</p>
        </div>

        @if($totalBelum > 0)
        <form action="{{ route('user.notifikasi.markall') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" onclick="showUserLoader()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-lg transition-colors flex items-center gap-2">
                <i class="fas fa-check-double text-teal-600"></i> Tandai Semua Dibaca
            </button>
        </form>
        @endif
    </div>

    <div class="flex bg-white p-1.5 rounded-xl border border-slate-200 shadow-sm w-full md:w-max">
        <a href="?filter=semua" class="smooth-route flex-1 md:flex-none text-center px-6 py-2.5 rounded-lg text-xs font-extrabold transition-colors {{ $filter == 'semua' ? 'bg-teal-500 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }}">Semua ({{ $totalSemua }})</a>
        <a href="?filter=belum" class="smooth-route flex-1 md:flex-none text-center px-6 py-2.5 rounded-lg text-xs font-extrabold transition-colors relative {{ $filter == 'belum' ? 'bg-teal-500 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }}">
            Belum Dibaca
            @if($totalBelum > 0) <span class="absolute top-1 right-2 w-2 h-2 bg-rose-500 rounded-full animate-pulse"></span> @endif
        </a>
    </div>

    <div class="bg-white border border-slate-100 rounded-[24px] shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
        <div class="divide-y divide-slate-100/80">
            @forelse($notifikasi as $notif)
                <div class="p-5 transition-colors {{ !$notif->dibaca ? 'bg-sky-50/40' : 'hover:bg-slate-50' }}">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center text-xl shrink-0 {{ !$notif->dibaca ? 'bg-teal-100 text-teal-600' : 'bg-slate-100 text-slate-400' }}">
                            <i class="fas fa-{{ $notif->tipe_icon ?? 'bell' }}"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start gap-3 mb-1">
                                <h4 class="text-sm font-bold {{ !$notif->dibaca ? 'text-slate-800' : 'text-slate-600' }} font-poppins leading-tight">{{ $notif->judul }}</h4>
                                <span class="text-[10px] font-semibold text-slate-400 shrink-0 whitespace-nowrap">{{ $notif->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed mb-3">{{ $notif->pesan }}</p>
                            
                            @if(!$notif->dibaca)
                                <a href="{{ route('user.notifikasi.read', $notif->id) }}" class="smooth-route inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 text-slate-600 text-[10px] font-bold rounded-lg shadow-sm hover:border-teal-300 hover:text-teal-700 transition-all">
                                    <i class="fas fa-check"></i> Tandai Dibaca
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-16 px-4">
                    <div class="w-20 h-20 bg-slate-50 border border-slate-100 shadow-sm rounded-full flex items-center justify-center mx-auto mb-4 text-4xl text-slate-300">
                        <i class="fas fa-envelope-open-text"></i>
                    </div>
                    <h4 class="text-base font-black text-slate-700 font-poppins mb-1">Tidak Ada Pesan Baru</h4>
                    <p class="text-xs font-medium text-slate-500">Anda telah membaca semua informasi dari Bidan dan Kader.</p>
                </div>
            @endforelse
        </div>

        @if($notifikasi->hasPages())
        <div class="p-4 border-t border-slate-100 bg-slate-50">
            {{ $notifikasi->links() }}
        </div>
        @endif
    </div>

</div>
@endsection