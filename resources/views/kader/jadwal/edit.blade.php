@extends('layouts.kader')

@section('title', 'Edit Jadwal')
@section('page-name', 'Edit Jadwal')

@push('styles')
<style>
    .animate-slide-up { opacity: 0; animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    
    .form-group { margin-bottom: 1.25rem; }
    .form-label { display: block; font-size: 0.70rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; }
    .form-input {
        width: 100%; background-color: #f8fafc; border: 2px solid #e2e8f0; color: #0f172a;
        font-size: 0.875rem; border-radius: 0.75rem; padding: 0.75rem 1rem; outline: none; transition: all 0.3s ease; font-weight: 600; box-shadow: inset 0 2px 4px 0 rgb(0 0 0 / 0.02);
    }
    .form-input:focus { background-color: #ffffff; border-color: #f59e0b; box-shadow: 0 4px 12px -3px rgba(245, 158, 11, 0.15); transform: translateY(-1px); }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto animate-slide-up">
    
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-amber-100 text-amber-600 mb-4 shadow-inner">
            <i class="fas fa-edit text-3xl"></i>
        </div>
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Edit Jadwal</h1>
        <p class="text-slate-500 mt-2 font-medium text-sm max-w-lg mx-auto">Anda dapat memperbarui waktu, lokasi, atau menandai acara ini sebagai Selesai / Batal.</p>
    </div>

    <form action="{{ route('kader.jadwal.update', $jadwal->id) }}" method="POST">
        @csrf @method('PUT')
        
        <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden flex flex-col mb-8">
            
            <div class="p-6 sm:p-10 border-b border-slate-100">
                <div class="form-group">
                    <label class="form-label">Nama / Judul Kegiatan <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul', $jadwal->judul) }}" required class="form-input">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-x-6">
                    <div class="form-group">
                        <label class="form-label">Target Peserta <span class="text-rose-500">*</span></label>
                        <select name="target_peserta" required class="form-input">
                            <option value="semua" {{ $jadwal->target_peserta == 'semua' ? 'selected' : '' }}>Semua Warga</option>
                            <option value="balita" {{ $jadwal->target_peserta == 'balita' ? 'selected' : '' }}>Balita</option>
                            <option value="remaja" {{ $jadwal->target_peserta == 'remaja' ? 'selected' : '' }}>Remaja</option>
                            <option value="lansia" {{ $jadwal->target_peserta == 'lansia' ? 'selected' : '' }}>Lansia</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kategori <span class="text-rose-500">*</span></label>
                        <select name="kategori" required class="form-input">
                            <option value="posyandu" {{ $jadwal->kategori == 'posyandu' ? 'selected' : '' }}>Posyandu Rutin</option>
                            <option value="imunisasi" {{ $jadwal->kategori == 'imunisasi' ? 'selected' : '' }}>Imunisasi</option>
                            <option value="pemeriksaan" {{ $jadwal->kategori == 'pemeriksaan' ? 'selected' : '' }}>Pemeriksaan Lab</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label text-amber-600">Status Acara <span class="text-rose-500">*</span></label>
                        <select name="status" required class="form-input border-amber-200 bg-amber-50/30">
                            <option value="aktif" {{ $jadwal->status == 'aktif' ? 'selected' : '' }}>Aktif / Berjalan</option>
                            <option value="selesai" {{ $jadwal->status == 'selesai' ? 'selected' : '' }}>Sudah Selesai</option>
                            <option value="dibatalkan" {{ $jadwal->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="p-6 sm:p-10 bg-amber-50/20">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-x-6">
                    <div class="form-group">
                        <label class="form-label">Tanggal Acara <span class="text-rose-500">*</span></label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', $jadwal->tanggal) }}" required class="form-input bg-white">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Waktu Mulai <span class="text-rose-500">*</span></label>
                        <input type="time" name="waktu_mulai" value="{{ old('waktu_mulai', $jadwal->waktu_mulai) }}" required class="form-input bg-white">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Waktu Selesai <span class="text-rose-500">*</span></label>
                        <input type="time" name="waktu_selesai" value="{{ old('waktu_selesai', $jadwal->waktu_selesai) }}" required class="form-input bg-white">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Lokasi <span class="text-rose-500">*</span></label>
                    <input type="text" name="lokasi" value="{{ old('lokasi', $jadwal->lokasi) }}" required class="form-input bg-white">
                </div>

                <div class="form-group mb-0">
                    <label class="form-label">Deskripsi / Catatan</label>
                    <textarea name="deskripsi" rows="3" class="form-input bg-white resize-none">{{ old('deskripsi', $jadwal->deskripsi) }}</textarea>
                </div>
            </div>
            
            <div class="p-6 sm:px-10 sm:py-6 bg-white border-t border-slate-100">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-2xl mx-auto">
                    <a href="{{ route('kader.jadwal.index') }}" class="w-full py-3.5 bg-slate-100 border border-slate-200 text-slate-600 font-bold text-sm rounded-xl hover:bg-slate-200 transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="w-full py-3.5 bg-amber-500 text-white font-extrabold text-sm rounded-xl hover:bg-amber-600 shadow-[0_4px_12px_rgba(245,158,11,0.3)] hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
            
        </div>
    </form>
</div>
@endsection