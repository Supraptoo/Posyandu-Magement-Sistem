@extends('layouts.kader')

@section('title', 'Detail Lansia')

@section('content')
<div class="card border-0 shadow-md mb-4 rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="bg-primary p-4 text-white position-relative overflow-hidden" style="min-height: 150px;">
            <div class="position-absolute top-0 end-0 opacity-10" style="transform: translate(30%, -30%);">
                <i class="fas fa-user-clock" style="font-size: 200px;"></i>
            </div>
            <div class="d-flex align-items-center position-relative z-index-1">
                <div class="avatar-xl bg-white text-primary rounded-circle shadow d-flex align-items-center justify-content-center me-4" style="width: 100px; height: 100px; font-size: 40px;">
                    <i class="fas fa-user-clock"></i>
                </div>
                <div>
                    <h2 class="fw-bold mb-1">{{ $lansia->nama_lengkap }}</h2>
                    <div class="d-flex gap-2 mb-2">
                        <span class="badge bg-white text-primary"><i class="fas fa-id-card me-1"></i> {{ $lansia->nik }}</span>
                        <span class="badge bg-{{ $lansia->jenis_kelamin == 'L' ? 'info' : 'danger' }} text-white">
                            <i class="fas fa-venus-mars me-1"></i> {{ $lansia->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </span>
                        <span class="badge bg-white text-dark"><i class="fas fa-hashtag me-1"></i> {{ $lansia->kode_lansia }}</span>
                    </div>
                </div>
                <div class="ms-auto d-none d-md-block text-end">
                    <a href="{{ route('kader.data.lansia.edit', $lansia->id) }}" class="btn btn-light text-primary fw-bold rounded-pill px-4 shadow-sm">
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
                <h6 class="fw-bold text-muted text-uppercase mb-3 small">Status Kesehatan</h6>
                
                @if($lansia->penyakit_bawaan)
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        @foreach(explode(',', $lansia->penyakit_bawaan) as $penyakit)
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle py-2 px-3 rounded-pill">
                                <i class="fas fa-heartbeat me-1"></i> {{ trim($penyakit) }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-success border-0 bg-success-subtle text-success d-flex align-items-center">
                        <i class="fas fa-check-circle me-2"></i> Tidak ada riwayat penyakit serius
                    </div>
                @endif

                <div class="mt-4 pt-3 border-top">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-sm bg-primary-subtle text-primary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fas fa-birthday-cake"></i>
                        </div>
                        <div>
                            <div class="small text-muted">Usia</div>
                            <div class="fw-bold text-dark">{{ $lansia->tanggal_lahir->diffInYears(now()) }} Tahun</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm bg-primary-subtle text-primary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <div class="small text-muted">Alamat</div>
                            <div class="text-dark small">{{ $lansia->alamat }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4 rounded-4">
            <div class="card-body p-4">
                <h6 class="fw-bold text-muted text-uppercase mb-3 small">Kontak Darurat</h6>
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar-sm bg-light text-muted rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div>
                        <div class="small text-muted">Telepon Keluarga</div>
                        <div class="fw-bold text-dark">{{ $lansia->telepon_keluarga ?? '-' }}</div>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="avatar-sm bg-light text-muted rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div>
                        <div class="small text-muted">Didaftarkan Oleh</div>
                        <div class="fw-bold text-dark">{{ $lansia->creator->profile->full_name ?? 'Sistem' }}</div>
                        <small class="text-muted">{{ $lansia->created_at->format('d M Y') }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold text-dark mb-0"><i class="fas fa-history me-2 text-primary"></i>Riwayat Kunjungan</h5>
                <a href="{{ route('kader.pemeriksaan.create') }}?pasien_id={{ $lansia->id }}&pasien_type=lansia" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
                    <i class="fas fa-plus me-1"></i> Kunjungan Baru
                </a>
            </div>
            <div class="card-body p-4">
                @if($lansia->kunjungans && $lansia->kunjungans->count() > 0)
                    <div class="timeline">
                        @foreach($lansia->kunjungans as $kunjungan)
                        <div class="timeline-item d-flex gap-3 mb-4">
                            <div class="timeline-icon flex-shrink-0">
                                <div class="bg-{{ $kunjungan->jenis_kunjungan == 'pemeriksaan' ? 'primary' : 'warning' }}-subtle text-{{ $kunjungan->jenis_kunjungan == 'pemeriksaan' ? 'primary' : 'warning' }} rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    @if($kunjungan->jenis_kunjungan == 'pemeriksaan')
                                        <i class="fas fa-stethoscope"></i>
                                    @else
                                        <i class="fas fa-comments"></i>
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
                                        
                                        @if($kunjungan->pemeriksaan)
                                            <div class="row g-2 mt-2 small">
                                                <div class="col-6 col-md-3">
                                                    <div class="p-2 bg-white rounded border">
                                                        <div class="text-muted" style="font-size: 10px;">Tensi</div>
                                                        <div class="fw-bold">{{ $kunjungan->pemeriksaan->tekanan_darah ?? '-' }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <div class="p-2 bg-white rounded border">
                                                        <div class="text-muted" style="font-size: 10px;">Gula Darah</div>
                                                        <div class="fw-bold text-{{ ($kunjungan->pemeriksaan->gula_darah > 200) ? 'danger' : 'dark' }}">
                                                            {{ $kunjungan->pemeriksaan->gula_darah ?? '-' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <div class="p-2 bg-white rounded border">
                                                        <div class="text-muted" style="font-size: 10px;">Kolesterol</div>
                                                        <div class="fw-bold">{{ $kunjungan->pemeriksaan->kolesterol ?? '-' }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <div class="p-2 bg-white rounded border">
                                                        <div class="text-muted" style="font-size: 10px;">Asam Urat</div>
                                                        <div class="fw-bold">{{ $kunjungan->pemeriksaan->asam_urat ?? '-' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <p class="small text-muted mt-2 mb-0">Petugas: {{ $kunjungan->petugas->profile->full_name ?? '-' }}</p>
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
                        <p class="small text-muted">Data pemeriksaan kesehatan akan muncul di sini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection