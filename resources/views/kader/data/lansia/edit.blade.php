@extends('layouts.kader')

@section('title', 'Edit Data Lansia')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Edit Data Lansia</h1>
        <p class="text-muted mb-0">Perbarui informasi data lansia</p>
    </div>
    <a href="{{ route('kader.data.lansia.show', $lansia->id) }}" class="btn btn-light text-primary fw-bold shadow-sm rounded-pill px-4">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<form action="{{ route('kader.data.lansia.update', $lansia->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="row">
        <div class="col-lg-7">
            <div class="card border-0 shadow-md mb-4 rounded-4">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold text-warning"><i class="fas fa-edit me-2"></i>Informasi Pribadi</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold small text-uppercase text-muted">Nama Lengkap</label>
                            <input type="text" class="form-control form-control-lg bg-light border-0" name="nama_lengkap" value="{{ old('nama_lengkap', $lansia->nama_lengkap) }}" required>
                            @error('nama_lengkap')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">NIK</label>
                            <input type="number" class="form-control bg-light border-0" name="nik" value="{{ old('nik', $lansia->nik) }}" required>
                            @error('nik')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Jenis Kelamin</label>
                            <select class="form-select bg-light border-0" name="jenis_kelamin" required>
                                <option value="L" {{ old('jenis_kelamin', $lansia->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin', $lansia->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Tempat Lahir</label>
                            <input type="text" class="form-control bg-light border-0" name="tempat_lahir" value="{{ old('tempat_lahir', $lansia->tempat_lahir) }}" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Tanggal Lahir</label>
                            <input type="date" class="form-control bg-light border-0" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $lansia->tanggal_lahir->format('Y-m-d')) }}" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-md mb-4 rounded-4">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold text-danger"><i class="fas fa-heartbeat me-2"></i>Riwayat Kesehatan</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Penyakit Bawaan</label>
                        <textarea class="form-control bg-light border-0" name="penyakit_bawaan" rows="3">{{ old('penyakit_bawaan', $lansia->penyakit_bawaan) }}</textarea>
                        @error('penyakit_bawaan')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-md mb-4 rounded-4">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold text-secondary"><i class="fas fa-map-marker-alt me-2"></i>Domisili & Kontak</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Alamat Lengkap</label>
                        <textarea class="form-control bg-light border-0" name="alamat" rows="3" required>{{ old('alamat', $lansia->alamat) }}</textarea>
                    </div>
                    
                    <div class="mb-3">
                         <label class="form-label fw-bold small text-uppercase text-muted">Nomor Telepon Keluarga</label>
                         <input type="text" class="form-control bg-light border-0" name="telepon_keluarga" value="{{ old('telepon_keluarga', $lansia->telepon_keluarga) }}" placeholder="Kontak darurat/keluarga">
                    </div>

                    @if($pendaftar && $pendaftar->count() > 0)
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Keluarga Terdaftar</label>
                        <select class="form-select bg-light border-0" name="created_by">
                            <option value="">-- Pilih Anggota Keluarga --</option>
                            @foreach($pendaftar as $p)
                            <option value="{{ $p['id'] }}" {{ old('created_by', $lansia->created_by) == $p['id'] ? 'selected' : '' }}>
                                {{ $p['nama'] }} ({{ $p['nik'] }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @else
                    <input type="hidden" name="created_by" value="{{ Auth::id() }}">
                    @endif

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-warning text-white rounded-pill py-2 fw-bold shadow-sm">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date();
    const minDate = new Date();
    minDate.setFullYear(today.getFullYear() - 45);
    const minDateStr = minDate.toISOString().split('T')[0];
    
    document.getElementById('tanggal_lahir').max = minDateStr;
});
</script>
@endpush
@endsection