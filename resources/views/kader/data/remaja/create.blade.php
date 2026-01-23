@extends('layouts.kader')

@section('title', 'Tambah Data Remaja')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Tambah Remaja</h1>
        <p class="text-muted mb-0">Isi formulir untuk mendaftarkan remaja baru</p>
    </div>
    <a href="{{ route('kader.data.remaja.index') }}" class="btn btn-light text-primary fw-bold shadow-sm rounded-pill px-4">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<form action="{{ route('kader.data.remaja.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-md mb-4 rounded-4">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold text-primary"><i class="fas fa-user me-2"></i>Informasi Pribadi</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold small text-uppercase text-muted">Nama Lengkap</label>
                            <input type="text" class="form-control form-control-lg bg-light border-0" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required placeholder="Nama lengkap remaja">
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
                            <label class="form-label fw-bold small text-uppercase text-muted">Alamat Lengkap</label>
                            <textarea class="form-control bg-light border-0" name="alamat" rows="3" required placeholder="Jalan, RT/RW, Dusun...">{{ old('alamat') }}</textarea>
                            @error('alamat')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-md mb-4 rounded-4">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold text-info"><i class="fas fa-school me-2"></i>Data Pendidikan</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Nama Sekolah</label>
                        <input type="text" class="form-control bg-light border-0" name="sekolah" value="{{ old('sekolah') }}" required placeholder="Nama Sekolah">
                        @error('sekolah')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Kelas</label>
                        <input type="text" class="form-control bg-light border-0" name="kelas" value="{{ old('kelas') }}" required placeholder="Contoh: X IPA 1">
                        @error('kelas')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-md mb-4 rounded-4">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold text-secondary"><i class="fas fa-user-friends me-2"></i>Data Orang Tua</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Nama Orang Tua</label>
                        <input type="text" class="form-control bg-light border-0" name="nama_ortu" value="{{ old('nama_ortu') }}" placeholder="Nama Ayah/Ibu">
                        @error('nama_ortu')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Telepon Orang Tua</label>
                        <input type="text" class="form-control bg-light border-0" name="telepon_ortu" value="{{ old('telepon_ortu') }}" placeholder="08xxxxxxxxxx">
                        @error('telepon_ortu')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    @if($orangtua && $orangtua->count() > 0)
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Akun Pendaftar (Opsional)</label>
                        <select class="form-select bg-light border-0" name="created_by">
                            <option value="">-- Pilih Akun Orang Tua --</option>
                            @foreach($orangtua as $ortu)
                            <option value="{{ $ortu['id'] }}" {{ old('created_by') == $ortu['id'] ? 'selected' : '' }}>
                                {{ $ortu['nama'] }} ({{ $ortu['nik'] }})
                            </option>
                            @endforeach
                        </select>
                        <div class="form-text small">Jika orang tua sudah memiliki akun warga.</div>
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
    document.getElementById('tanggal_lahir').max = new Date().toISOString().split('T')[0];
</script>
@endpush
@endsection