@extends('layouts.kader')

@section('title', 'Detail Remaja')

@section('content')
<div class="card border-0 shadow-md mb-4 rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="bg-primary p-4 text-white position-relative overflow-hidden" style="min-height: 150px;">
            <div class="position-absolute top-0 end-0 opacity-10" style="transform: translate(30%, -30%);">
                <i class="fas fa-user-graduate" style="font-size: 200px;"></i>
            </div>
            <div class="d-flex align-items-center position-relative z-index-1">
                <div class="avatar-xl bg-white text-primary rounded-circle shadow d-flex align-items-center justify-content-center me-4" style="width: 100px; height: 100px; font-size: 40px;">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div>
                    <h2 class="fw-bold mb-1">{{ $remaja->nama_lengkap }}</h2>
                    <div class="d-flex gap-2 mb-2">
                        <span class="badge bg-white text-primary"><i class="fas fa-id-card me-1"></i> {{ $remaja->nik }}</span>
                        <span class="badge bg-{{ $remaja->jenis_kelamin == 'L' ? 'info' : 'danger' }} text-white">
                            <i class="fas fa-venus-mars me-1"></i> {{ $remaja->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </span>
                        <span class="badge bg-white text-dark"><i class="fas fa-hashtag me-1"></i> {{ $remaja->kode_remaja }}</span>
                    </div>
                </div>
                <div class="ms-auto d-none d-md-block text-end">
                    <a href="{{ route('kader.data.remaja.edit', $remaja->id) }}" class="btn btn-light text-primary fw-bold rounded-pill px-4 shadow-sm">
                        <i class="fas fa-edit me-2"></i>Edit Data
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4 rounded-4">
            <div class="card-body p-4">
                <h6 class="fw-bold text-muted text-uppercase mb-3 small">Data Pendidikan</h6>
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar-sm bg-info-subtle text-info rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-school"></i>
                    </div>
                    <div>
                        <div class="small text-muted">Sekolah</div>
                        <div class="fw-bold text-dark">{{ $remaja->sekolah }}</div>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="avatar-sm bg-info-subtle text-info rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div>
                        <div class="small text-muted">Kelas</div>
                        <div class="fw-bold text-dark">{{ $remaja->kelas }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4 rounded-4">
            <div class="card-body p-4">
                <h6 class="fw-bold text-muted text-uppercase mb-3 small">Informasi Keluarga & Kontak</h6>
                
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar-sm bg-primary-subtle text-primary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <div>
                        <div class="small text-muted">Nama Orang Tua</div>
                        <div class="fw-bold text-dark">{{ $remaja->nama_ortu ?? '-' }}</div>
                    </div>
                </div>
                
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar-sm bg-success-subtle text-success rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div>
                        <div class="small text-muted">Telepon</div>
                        <div class="fw-bold text-dark">{{ $remaja->telepon_ortu ?? '-' }}</div>
                    </div>
                </div>

                <hr class="border-light my-3">
                
                <div class="d-flex mb-3">
                    <div class="avatar-sm bg-light text-muted rounded-circle me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px;">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <div class="small text-muted">Alamat</div>
                        <div class="text-dark">{{ $remaja->alamat }}</div>
                    </div>
                </div>
                
                <div class="d-flex">
                    <div class="avatar-sm bg-light text-muted rounded-circle me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px;">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div>
                        <div class="small text-muted">Tempat, Tanggal Lahir</div>
                        <div class="text-dark">{{ $remaja->tempat_lahir }}, {{ $remaja->tanggal_lahir->format('d M Y') }}</div>
                        <small class="text-primary fw-bold">
                            {{ $remaja->tanggal_lahir->diffInYears(now()) }} Tahun
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold text-dark mb-0"><i class="fas fa-history me-2 text-primary"></i>Riwayat Kunjungan</h5>
                <a href="{{ route('kader.pemeriksaan.create') }}?pasien_id={{ $remaja->id }}&pasien_type=remaja" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
                    <i class="fas fa-plus me-1"></i> Kunjungan Baru
                </a>
            </div>
            <div class="card-body p-4">
                @if($remaja->kunjungans && $remaja->kunjungans->count() > 0)
                    <div class="timeline">
                        @foreach($remaja->kunjungans as $kunjungan)
                        <div class="timeline-item d-flex gap-3 mb-4">
                            <div class="timeline-icon flex-shrink-0">
                                <div class="bg-{{ $kunjungan->jenis_kunjungan == 'imunisasi' ? 'success' : ($kunjungan->jenis_kunjungan == 'pemeriksaan' ? 'primary' : 'warning') }}-subtle text-{{ $kunjungan->jenis_kunjungan == 'imunisasi' ? 'success' : ($kunjungan->jenis_kunjungan == 'pemeriksaan' ? 'primary' : 'warning') }} rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    @if($kunjungan->jenis_kunjungan == 'imunisasi')
                                        <i class="fas fa-syringe"></i>
                                    @elseif($kunjungan->jenis_kunjungan == 'pemeriksaan')
                                        <i class="fas fa-stethoscope"></i>
                                    @else
                                        <i class="fas fa-user-md"></i>
                                    @endif
                                </div>
                                <div class="vr h-100 mx-auto d-block bg-light my-2" style="width: 2px;"></div>
                            </div>
                            <div class="timeline-content flex-grow-1">
                                <div class="card border-0 bg-light rounded-3">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="badge bg-white text-dark border">{{ $kunjungan->tanggal_kunjungan->format('d M Y') }}</span>
                                            <a href="{{ route('kader.kunjungan.show', $kunjungan->id) }}" class="btn btn-sm btn-link text-decoration-none">Detail <i class="fas fa-chevron-right small"></i></a>
                                        </div>
                                        <h6 class="fw-bold text-dark text-capitalize mb-1">{{ $kunjungan->jenis_kunjungan }}</h6>
                                        <p class="small text-muted mb-0">Petugas: {{ $kunjungan->petugas->profile->full_name ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" alt="Empty" style="width: 80px; opacity: 0.5;" class="mb-3">
                        <h6 class="text-muted">Belum ada riwayat kunjungan</h6>
                        <p class="small text-muted">Data pemeriksaan dan konsultasi akan muncul di sini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection