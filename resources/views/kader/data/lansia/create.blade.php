@extends('layouts.kader')

@section('title', 'Tambah Data Lansia')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Tambah Lansia</h1>
        <p class="text-muted mb-0">Registrasi data warga lansia & pra-lansia (Usia 45+)</p>
    </div>
    <a href="{{ route('kader.data.lansia.index') }}" class="btn btn-light text-primary fw-bold shadow-sm rounded-pill px-4">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<form action="{{ route('kader.data.lansia.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-lg-7">
            <div class="card border-0 shadow-md mb-4 rounded-4">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold text-primary"><i class="fas fa-user me-2"></i>Informasi Pribadi</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold small text-uppercase text-muted">Nama Lengkap</label>
                            <input type="text" class="form-control form-control-lg bg-light border-0" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required placeholder="Nama lengkap sesuai KTP">
                            @error('nama_lengkap')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">NIK (16 Digit)</label>
                            <input type="number" class="form-control bg-light border-0" name="nik" value="{{ old('nik') }}" required placeholder="Nomor Induk Kependudukan">
                            @error('nik')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Jenis Kelamin</label>
                            <select class="form-select bg-light border-0" name="jenis_kelamin" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Tempat Lahir</label>
                            <input type="text" class="form-control bg-light border-0" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required placeholder="Kota kelahiran">
                            @error('tempat_lahir')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Tanggal Lahir</label>
                            <input type="date" class="form-control bg-light border-0" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                            @error('tanggal_lahir')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="col-12">
                             <div class="alert alert-light border-0 d-flex align-items-center mb-0 p-2 text-muted small">
                                <i class="fas fa-info-circle me-2"></i> 
                                <span id="usia-info">Masukkan tanggal lahir untuk melihat usia.</span>
                            </div>
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
                        <textarea class="form-control bg-light border-0" name="penyakit_bawaan" rows="3" placeholder="Contoh: Hipertensi, Diabetes, Asam Urat (Pisahkan dengan koma)">{{ old('penyakit_bawaan') }}</textarea>
                        <div class="form-text small">Kosongkan jika tidak ada.</div>
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
                        <textarea class="form-control bg-light border-0" name="alamat" rows="3" required placeholder="Jalan, RT/RW, Dusun...">{{ old('alamat') }}</textarea>
                        @error('alamat')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="mb-3">
                         <label class="form-label fw-bold small text-uppercase text-muted">Nomor Telepon Keluarga</label>
                         <input type="text" class="form-control bg-light border-0" name="telepon_keluarga" value="{{ old('telepon_keluarga') }}" placeholder="Kontak darurat/keluarga">
                    </div>

                    @if($pendaftar && $pendaftar->count() > 0)
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Keluarga Terdaftar</label>
                        <select class="form-select bg-light border-0" name="created_by">
                            <option value="">-- Pilih Anggota Keluarga --</option>
                            @foreach($pendaftar as $p)
                            <option value="{{ $p['id'] }}" {{ old('created_by') == $p['id'] ? 'selected' : '' }}>
                                {{ $p['nama'] }} ({{ $p['nik'] }})
                            </option>
                            @endforeach
                        </select>
                        <div class="form-text small">Jika ada anggota keluarga yang terdaftar.</div>
                    </div>
                    @else
                    <input type="hidden" name="created_by" value="{{ Auth::id() }}">
                    @endif

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary rounded-pill py-2 fw-bold shadow-sm">
                            <i class="fas fa-save me-2"></i>Simpan Data
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
    const tanggalLahirInput = document.getElementById('tanggal_lahir');
    const usiaInfo = document.getElementById('usia-info');
    
    // Kita hapus batasan .max = ... agar tahun berapapun bisa dipilih
    // Tapi kita beri peringatan visual saja
    
    tanggalLahirInput.addEventListener('change', function() {
        if(this.value) {
            const birthDate = new Date(this.value);
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            
            if (age < 45) {
                usiaInfo.innerHTML = `<span class="text-danger fw-bold"><i class="fas fa-exclamation-triangle me-1"></i> Usia ${age} tahun (Di bawah 45 tahun). Pastikan data benar.</span>`;
            } else if (age >= 45 && age < 60) {
                usiaInfo.innerHTML = `<span class="text-warning fw-bold"><i class="fas fa-info-circle me-1"></i> Usia ${age} tahun (Kategori Pra-Lansia).</span>`;
            } else {
                usiaInfo.innerHTML = `<span class="text-success fw-bold"><i class="fas fa-check-circle me-1"></i> Usia ${age} tahun (Kategori Lansia).</span>`;
            }
        }
    });
});
</script>
@endpush
@endsection