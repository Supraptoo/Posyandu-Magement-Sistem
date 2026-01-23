@extends('layouts.kader')

@section('title', 'Tambah Jadwal Posyandu')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus-circle me-2"></i>Tambah Jadwal Posyandu
        </h1>
        <a href="{{ route('kader.jadwal.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Form -->
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-calendar-plus me-2"></i>Form Tambah Jadwal
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('kader.jadwal.store') }}" method="POST" id="jadwalForm">
                @csrf
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Jadwal *</label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                                   id="judul" name="judul" 
                                   value="{{ old('judul') }}" 
                                   placeholder="Contoh: Posyandu Bulan November 2024" required>
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
                                <option value="imunisasi" {{ old('kategori') == 'imunisasi' ? 'selected' : '' }}>Imunisasi</option>
                                <option value="pemeriksaan" {{ old('kategori') == 'pemeriksaan' ? 'selected' : '' }}>Pemeriksaan</option>
                                <option value="konseling" {{ old('kategori') == 'konseling' ? 'selected' : '' }}>Konseling</option>
                                <option value="posyandu" {{ old('kategori') == 'posyandu' ? 'selected' : '' }}>Posyandu Rutin</option>
                                <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
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
                              id="deskripsi" name="deskripsi" rows="3" required
                              placeholder="Deskripsi lengkap kegiatan posyandu...">{{ old('deskripsi') }}</textarea>
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
                                   value="{{ old('tanggal', date('Y-m-d')) }}" required>
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
                                   value="{{ old('waktu_mulai', '08:00') }}" required>
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
                                   value="{{ old('waktu_selesai', '12:00') }}" required>
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
                                   value="{{ old('lokasi') }}" 
                                   placeholder="Contoh: Posyandu RW 05, Jl. Sejahtera No. 10" required>
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
                                <option value="semua" {{ old('target_peserta') == 'semua' ? 'selected' : '' }}>Semua</option>
                                <option value="balita" {{ old('target_peserta') == 'balita' ? 'selected' : '' }}>Balita</option>
                                <option value="remaja" {{ old('target_peserta') == 'remaja' ? 'selected' : '' }}>Remaja</option>
                                <option value="lansia" {{ old('target_peserta') == 'lansia' ? 'selected' : '' }}>Lansia</option>
                                <option value="ibu_hamil" {{ old('target_peserta') == 'ibu_hamil' ? 'selected' : '' }}>Ibu Hamil</option>
                            </select>
                            @error('target_peserta')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <hr>
                <div class="text-end">
                    <button type="reset" class="btn btn-secondary">
                        <i class="fas fa-undo me-2"></i>Reset
                    </button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fas fa-save me-2"></i>Simpan Jadwal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('jadwalForm');
    const submitBtn = document.getElementById('submitBtn');
    
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
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
        
        return true;
    });
    
    // Auto adjust waktu selesai if needed
    document.getElementById('waktu_mulai').addEventListener('change', function() {
        const waktuMulai = this.value;
        const waktuSelesai = document.getElementById('waktu_selesai');
        
        if (waktuMulai && waktuSelesai.value && waktuMulai >= waktuSelesai.value) {
            // Add 4 hours to waktu mulai
            const [hours, minutes] = waktuMulai.split(':');
            const newHours = parseInt(hours) + 4;
            const newTime = `${newHours.toString().padStart(2, '0')}:${minutes}`;
            waktuSelesai.value = newTime;
        }
    });
});
</script>
@endpush
@endsection