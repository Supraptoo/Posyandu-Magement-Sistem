@extends('layouts.kader')

@section('title', 'Edit Jadwal Posyandu')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit me-2"></i>Edit Jadwal Posyandu
        </h1>
        <div>
            <a href="{{ route('kader.jadwal.show', $jadwal->id) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="card shadow">
        <div class="card-header bg-warning text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-calendar-edit me-2"></i>Form Edit Jadwal
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('kader.jadwal.update', $jadwal->id) }}" method="POST" id="editJadwalForm">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Jadwal *</label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                                   id="judul" name="judul" 
                                   value="{{ old('judul', $jadwal->judul) }}" required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori *</label>
                            <select class="form-select @error('kategori') is-invalid @enderror" 
                                    id="kategori" name="kategori" required>
                                <option value="">Pilih Kategori</option>
                                <option value="imunisasi" {{ old('kategori', $jadwal->kategori) == 'imunisasi' ? 'selected' : '' }}>Imunisasi</option>
                                <option value="pemeriksaan" {{ old('kategori', $jadwal->kategori) == 'pemeriksaan' ? 'selected' : '' }}>Pemeriksaan</option>
                                <option value="konseling" {{ old('kategori', $jadwal->kategori) == 'konseling' ? 'selected' : '' }}>Konseling</option>
                                <option value="posyandu" {{ old('kategori', $jadwal->kategori) == 'posyandu' ? 'selected' : '' }}>Posyandu Rutin</option>
                                <option value="lainnya" {{ old('kategori', $jadwal->kategori) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi *</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                              id="deskripsi" name="deskripsi" rows="3" required>{{ old('deskripsi', $jadwal->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal *</label>
                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" 
                                   id="tanggal" name="tanggal" 
                                   value="{{ old('tanggal', $jadwal->tanggal) }}" required>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="waktu_mulai" class="form-label">Waktu Mulai *</label>
                            <input type="time" class="form-control @error('waktu_mulai') is-invalid @enderror" 
                                   id="waktu_mulai" name="waktu_mulai" 
                                   value="{{ old('waktu_mulai', $jadwal->waktu_mulai) }}" required>
                            @error('waktu_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="waktu_selesai" class="form-label">Waktu Selesai *</label>
                            <input type="time" class="form-control @error('waktu_selesai') is-invalid @enderror" 
                                   id="waktu_selesai" name="waktu_selesai" 
                                   value="{{ old('waktu_selesai', $jadwal->waktu_selesai) }}" required>
                            @error('waktu_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi *</label>
                            <input type="text" class="form-control @error('lokasi') is-invalid @enderror" 
                                   id="lokasi" name="lokasi" 
                                   value="{{ old('lokasi', $jadwal->lokasi) }}" required>
                            @error('lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="target_peserta" class="form-label">Target Peserta *</label>
                            <select class="form-select @error('target_peserta') is-invalid @enderror" 
                                    id="target_peserta" name="target_peserta" required>
                                <option value="">Pilih Target</option>
                                <option value="semua" {{ old('target_peserta', $jadwal->target_peserta) == 'semua' ? 'selected' : '' }}>Semua</option>
                                <option value="balita" {{ old('target_peserta', $jadwal->target_peserta) == 'balita' ? 'selected' : '' }}>Balita</option>
                                <option value="remaja" {{ old('target_peserta', $jadwal->target_peserta) == 'remaja' ? 'selected' : '' }}>Remaja</option>
                                <option value="lansia" {{ old('target_peserta', $jadwal->target_peserta) == 'lansia' ? 'selected' : '' }}>Lansia</option>
                                <option value="ibu_hamil" {{ old('target_peserta', $jadwal->target_peserta) == 'ibu_hamil' ? 'selected' : '' }}>Ibu Hamil</option>
                            </select>
                            @error('target_peserta')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status *</label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="aktif" {{ old('status', $jadwal->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="selesai" {{ old('status', $jadwal->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="dibatalkan" {{ old('status', $jadwal->status) == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <hr>
                <div class="text-end">
                    <a href="{{ route('kader.jadwal.show', $jadwal->id) }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-warning" id="updateBtn">
                        <i class="fas fa-save me-2"></i>Perbarui Jadwal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('editJadwalForm');
    const updateBtn = document.getElementById('updateBtn');
    
    // Set min date to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('tanggal').min = today;
    
    // Validate time
    form.addEventListener('submit', function(e) {
        const waktuMulai = document.getElementById('waktu_mulai').value;
        const waktuSelesai = document.getElementById('waktu_selesai').value;
        
        if (waktuMulai && waktuSelesai) {
            if (waktuMulai >= waktuSelesai) {
                e.preventDefault();
                alert('Waktu selesai harus setelah waktu mulai');
                return false;
            }
        }
        
        // Disable submit button to prevent double submission
        updateBtn.disabled = true;
        updateBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memperbarui...';
        
        return true;
    });
});
</script>
@endpush
@endsection