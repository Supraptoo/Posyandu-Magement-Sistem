@extends('layouts.kader')

@section('title', 'Edit Data Balita')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Edit Data Balita</h1>
        <p class="text-muted mb-0">Perbarui informasi data balita</p>
    </div>
    <a href="{{ route('kader.data.balita.show', $balita->id) }}" class="btn btn-light text-primary fw-bold shadow-sm rounded-pill px-4">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<form action="{{ route('kader.data.balita.update', $balita->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-md mb-4 rounded-4">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold text-warning"><i class="fas fa-edit me-2"></i>Informasi Balita</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold small text-uppercase text-muted">Nama Lengkap</label>
                            <input type="text" class="form-control form-control-lg bg-light border-0" name="nama_lengkap" value="{{ old('nama_lengkap', $balita->nama_lengkap) }}" required>
                            @error('nama_lengkap')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">NIK</label>
                            <input type="number" class="form-control bg-light border-0" name="nik" value="{{ old('nik', $balita->nik) }}" required>
                            @error('nik')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Jenis Kelamin</label>
                            <select class="form-select bg-light border-0" name="jenis_kelamin" required>
                                <option value="L" {{ old('jenis_kelamin', $balita->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin', $balita->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Tempat Lahir</label>
                            <input type="text" class="form-control bg-light border-0" name="tempat_lahir" value="{{ old('tempat_lahir', $balita->tempat_lahir) }}" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Tanggal Lahir</label>
                            <input type="date" class="form-control bg-light border-0" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $balita->tanggal_lahir->format('Y-m-d')) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Berat Lahir (KG)</label>
                            <div class="input-group">
                                <input type="number" step="0.01" class="form-control bg-light border-0" name="berat_lahir" value="{{ old('berat_lahir', $balita->berat_lahir) }}">
                                <span class="input-group-text bg-light border-0 text-muted">kg</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Panjang Lahir (CM)</label>
                            <div class="input-group">
                                <input type="number" step="0.01" class="form-control bg-light border-0" name="panjang_lahir" value="{{ old('panjang_lahir', $balita->panjang_lahir) }}">
                                <span class="input-group-text bg-light border-0 text-muted">cm</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-md mb-4 rounded-4">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold text-secondary"><i class="fas fa-user-friends me-2"></i>Data Orang Tua</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Nama Ibu</label>
                        <input type="text" class="form-control bg-light border-0" name="nama_ibu" value="{{ old('nama_ibu', $balita->nama_ibu) }}" required>
                        @error('nama_ibu')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Nama Ayah</label>
                        <input type="text" class="form-control bg-light border-0" name="nama_ayah" value="{{ old('nama_ayah', $balita->nama_ayah) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Alamat Lengkap</label>
                        <textarea class="form-control bg-light border-0" name="alamat" rows="4" required>{{ old('alamat', $balita->alamat) }}</textarea>
                    </div>

                    @if($orangtua && $orangtua->count() > 0)
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Akun Pendaftar</label>
                        <select class="form-select bg-light border-0" name="created_by">
                            <option value="">-- Pilih Akun --</option>
                            @foreach($orangtua as $ortu)
                            <option value="{{ $ortu['id'] }}" {{ old('created_by', $balita->created_by) == $ortu['id'] ? 'selected' : '' }}>
                                {{ $ortu['nama'] }} ({{ $ortu['nik'] }})
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
    document.getElementById('tanggal_lahir').max = new Date().toISOString().split('T')[0];
</script>
@endpush
@endsection