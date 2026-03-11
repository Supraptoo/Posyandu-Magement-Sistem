@extends('layouts.kader')

@section('title', 'Profil Saya')
@section('page-name', 'Pengaturan Akun')

@push('styles')
<style>
    .animate-slide-up { opacity: 0; animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto animate-slide-up">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-[18px] bg-indigo-100 text-indigo-600 flex items-center justify-center text-2xl shadow-inner border border-indigo-200/50">
                <i class="fas fa-id-badge"></i>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Profil Kader</h1>
                <p class="text-slate-500 mt-1 font-medium text-sm">Kelola informasi data diri dan kontak Anda di sini.</p>
            </div>
        </div>
        <a href="{{ route('kader.profile.password') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-rose-50 text-rose-600 border border-rose-200 font-extrabold text-sm rounded-xl hover:bg-rose-100 transition-colors shadow-sm">
            <i class="fas fa-lock"></i> Ganti Password
        </a>
    </div>

    <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center gap-3 bg-slate-50/50">
            <h3 class="text-base font-extrabold text-slate-800">Informasi Pribadi</h3>
        </div>

        <form action="{{ route('kader.profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="p-6 sm:p-8 space-y-6">
                <div>
                    <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Nama Lengkap</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-user text-slate-400"></i>
                        </div>
                        <input type="text" name="name" value="{{ $user->profile->full_name ?? '' }}" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl pl-11 pr-4 py-3.5 outline-none font-semibold focus:border-indigo-500 focus:bg-white transition-colors shadow-inner">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">Alamat Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-slate-400"></i>
                            </div>
                            <input type="email" name="email" value="{{ $user->email }}" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl pl-11 pr-4 py-3.5 outline-none font-semibold focus:border-indigo-500 focus:bg-white transition-colors shadow-inner">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-widest mb-2">No. HP / WhatsApp</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-phone-alt text-slate-400"></i>
                            </div>
                            <input type="text" name="no_hp" value="{{ $user->profile->phone_number ?? '' }}" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl pl-11 pr-4 py-3.5 outline-none font-semibold focus:border-indigo-500 focus:bg-white transition-colors shadow-inner">
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 py-5 border-t border-slate-100 bg-slate-50/50 flex justify-end">
                <button type="submit" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-indigo-600 text-white font-black text-sm rounded-xl hover:bg-indigo-700 shadow-[0_4px_12px_rgba(79,70,229,0.3)] hover:-translate-y-0.5 transition-all">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection