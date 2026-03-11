@extends('layouts.kader')

@section('title', 'Ganti Password')
@section('page-name', 'Keamanan Akun')

@push('styles')
<style>
    .animate-slide-up { opacity: 0; animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endpush

@section('content')
<div class="max-w-2xl mx-auto animate-slide-up">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-[18px] bg-rose-100 text-rose-600 flex items-center justify-center text-2xl shadow-inner border border-rose-200/50">
                <i class="fas fa-shield-alt"></i>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Ganti Password</h1>
                <p class="text-slate-500 mt-1 font-medium text-sm">Pastikan akun Anda tetap aman dengan password yang kuat.</p>
            </div>
        </div>
        <a href="{{ route('kader.profile.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-white border border-slate-200 text-slate-600 font-bold text-sm rounded-xl hover:bg-slate-50 transition-colors shadow-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center gap-3 bg-slate-50/50">
            <h3 class="text-base font-extrabold text-slate-800">Form Pembaruan Sandi</h3>
        </div>

        <form action="{{ route('kader.profile.update-password') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="p-6 sm:p-8 space-y-6">
                <div>
                    <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Password Saat Ini</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-unlock text-slate-400"></i>
                        </div>
                        <input type="password" name="current_password" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl pl-11 pr-4 py-3.5 outline-none font-semibold focus:border-rose-500 focus:bg-white transition-colors shadow-inner placeholder:text-slate-400" placeholder="Masukkan password lama Anda">
                    </div>
                </div>
                
                <div class="border-t border-dashed border-slate-200 my-2"></div>

                <div>
                    <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Password Baru</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-key text-slate-400"></i>
                        </div>
                        <input type="password" name="password" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl pl-11 pr-4 py-3.5 outline-none font-semibold focus:border-rose-500 focus:bg-white transition-colors shadow-inner placeholder:text-slate-400" placeholder="Buat password baru">
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Konfirmasi Password Baru</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-check-double text-slate-400"></i>
                        </div>
                        <input type="password" name="password_confirmation" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl pl-11 pr-4 py-3.5 outline-none font-semibold focus:border-rose-500 focus:bg-white transition-colors shadow-inner placeholder:text-slate-400" placeholder="Ketik ulang password baru">
                    </div>
                </div>
            </div>

            <div class="px-6 py-5 border-t border-slate-100 bg-slate-50/50 flex justify-end">
                <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-gradient-to-r from-rose-500 to-rose-600 text-white font-black text-sm rounded-xl hover:from-rose-600 hover:to-rose-700 shadow-[0_8px_20px_rgba(225,29,72,0.25)] hover:shadow-[0_10px_25px_rgba(225,29,72,0.35)] hover:-translate-y-0.5 transition-all duration-300">
                    <i class="fas fa-shield-check"></i> Ubah Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection