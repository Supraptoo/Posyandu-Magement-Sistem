{{--
  PATH   : resources/views/admin/users/show.blade.php
  FUNGSI : Detail warga + data pasien terhubung (balita/remaja/lansia)
--}}
@extends('layouts.app')
@section('title', 'Detail Warga')

@push('styles')
<style>
.show-hero { background:linear-gradient(135deg,#0f172a,#0d9488); border-radius:16px; padding:1.5rem; color:#fff; margin-bottom:1.5rem; }
.big-av { width:64px; height:64px; border-radius:50%; background:rgba(255,255,255,.15); display:flex; align-items:center; justify-content:center; font-size:1.6rem; font-weight:800; color:#fff; flex-shrink:0; }
.info-card { background:#fff; border:1px solid #e2e8f0; border-radius:14px; overflow:hidden; margin-bottom:1.25rem; }
.info-card-head { padding:.85rem 1.15rem; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:.5rem; }
.info-card-head h6 { font-size:.85rem; font-weight:800; color:#0f172a; margin:0; }
.info-card-head i { color:#0d9488; }
.info-card-body { padding:1rem 1.15rem; }
.info-row { display:flex; justify-content:space-between; align-items:flex-start; padding:.5rem 0; border-bottom:1px solid #f8fafc; gap:1rem; }
.info-row:last-child { border-bottom:none; }
.info-lbl { font-size:.72rem; font-weight:700; color:#64748b; white-space:nowrap; }
.info-val { font-size:.84rem; font-weight:600; color:#0f172a; text-align:right; }
.patient-card { border:1.5px solid #e2e8f0; border-radius:12px; padding:.9rem 1rem; margin-bottom:.75rem; display:flex; align-items:center; gap:.75rem; }
.patient-ic { width:38px; height:38px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:.95rem; color:#fff; flex-shrink:0; }
.status-aktif { background:#dcfce7; color:#166534; font-size:.67rem; font-weight:800; padding:.15rem .55rem; border-radius:20px; }
.status-nonaktif { background:#fee2e2; color:#991b1b; font-size:.67rem; font-weight:800; padding:.15rem .55rem; border-radius:20px; }
.nik-badge { font-family:monospace; font-size:.74rem; font-weight:700; background:#f1f5f9; color:#475569; padding:.18rem .55rem; border-radius:6px; }
</style>
@endpush

@section('content')

<div class="show-hero">
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
        <div class="d-flex align-items-center gap-3">
            <div class="big-av">
                {{ strtoupper(substr($user->profile?->full_name ?? $user->name, 0, 1)) }}
            </div>
            <div>
                <div style="font-size:1.2rem;font-weight:800;line-height:1.2">
                    {{ $user->profile?->full_name ?? $user->name }}
                </div>
                <div style="font-size:.78rem;opacity:.75;margin-top:.2rem">
                    NIK: {{ $user->nik ?? $user->profile?->nik ?? '-' }} · ID #{{ $user->id }}
                </div>
                <span style="font-size:.65rem;font-weight:800;background:rgba(255,255,255,.15);padding:.15rem .55rem;border-radius:20px;margin-top:.3rem;display:inline-block">
                    {{ $user->status === 'active' ? '✅ Aktif' : '❌ Nonaktif' }}
                </span>
            </div>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-primary-app" style="font-size:.8rem">
                <i class="fas fa-pen"></i> Edit
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn-secondary-app" style="font-size:.8rem">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        {{-- Data Akun --}}
        <div class="info-card">
            <div class="info-card-head"><i class="fas fa-id-card"></i><h6>Data Identitas</h6></div>
            <div class="info-card-body">
                <div class="info-row"><span class="info-lbl">Nama Lengkap</span><span class="info-val">{{ $user->profile?->full_name ?? $user->name }}</span></div>
                <div class="info-row"><span class="info-lbl">NIK</span><span class="info-val"><span class="nik-badge">{{ $user->nik ?? $user->profile?->nik ?? '-' }}</span></span></div>
                <div class="info-row"><span class="info-lbl">Jenis Kelamin</span><span class="info-val">{{ $user->profile?->jenis_kelamin == 'L' ? 'Laki-laki' : ($user->profile?->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</span></div>
                <div class="info-row"><span class="info-lbl">Tempat, Tgl Lahir</span><span class="info-val">{{ $user->profile?->tempat_lahir ?? '-' }}, {{ $user->profile?->tanggal_lahir ? \Carbon\Carbon::parse($user->profile->tanggal_lahir)->format('d M Y') : '-' }}</span></div>
                <div class="info-row"><span class="info-lbl">Telepon</span><span class="info-val">{{ $user->profile?->telepon ?? '-' }}</span></div>
                <div class="info-row"><span class="info-lbl">Alamat</span><span class="info-val" style="text-align:right;max-width:220px">{{ $user->profile?->alamat ?? '-' }}</span></div>
            </div>
        </div>

        {{-- Info Akun --}}
        <div class="info-card">
            <div class="info-card-head"><i class="fas fa-user-cog"></i><h6>Informasi Akun</h6></div>
            <div class="info-card-body">
                <div class="info-row"><span class="info-lbl">Login (Username)</span><span class="info-val"><span class="nik-badge">{{ $user->nik ?? '-' }}</span> (NIK)</span></div>
                <div class="info-row"><span class="info-lbl">Email Sistem</span><span class="info-val" style="font-size:.75rem">{{ $user->email }}</span></div>
                <div class="info-row"><span class="info-lbl">Status</span><span class="info-val"><span class="status-{{ $user->status === 'active' ? 'aktif' : 'nonaktif' }}">{{ $user->status === 'active' ? 'Aktif' : 'Nonaktif' }}</span></span></div>
                <div class="info-row"><span class="info-lbl">Bergabung</span><span class="info-val">{{ $user->created_at?->format('d M Y') }}</span></div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        {{-- Data Pasien Terhubung --}}
        <div class="info-card">
            <div class="info-card-head"><i class="fas fa-heartbeat"></i><h6>Data Pasien Terhubung</h6></div>
            <div class="info-card-body">

                {{-- Balita --}}
                @if($linkedData['balita']->isNotEmpty())
                    <div style="font-size:.72rem;font-weight:800;text-transform:uppercase;color:#0e7490;margin-bottom:.5rem">
                        <i class="fas fa-baby me-1"></i> Balita ({{ $linkedData['balita']->count() }})
                    </div>
                    @foreach($linkedData['balita'] as $b)
                    <div class="patient-card">
                        <div class="patient-ic" style="background:linear-gradient(135deg,#0891b2,#22d3ee)">
                            <i class="fas fa-baby"></i>
                        </div>
                        <div>
                            <div style="font-size:.84rem;font-weight:700;color:#0f172a">{{ $b->nama_lengkap }}</div>
                            <div style="font-size:.7rem;color:#64748b">
                                NIK: {{ $b->nik ?? '-' }} ·
                                {{ $b->jenis_kelamin == 'L' ? 'L' : 'P' }} ·
                                {{ \Carbon\Carbon::parse($b->tanggal_lahir)->diffForHumans(null, true) }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="mb-2"></div>
                @endif

                {{-- Remaja --}}
                @if($linkedData['remaja'])
                    <div style="font-size:.72rem;font-weight:800;text-transform:uppercase;color:#5b21b6;margin-bottom:.5rem">
                        <i class="fas fa-user-graduate me-1"></i> Remaja
                    </div>
                    <div class="patient-card">
                        <div class="patient-ic" style="background:linear-gradient(135deg,#7c3aed,#a78bfa)">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div>
                            <div style="font-size:.84rem;font-weight:700;color:#0f172a">{{ $linkedData['remaja']->nama_lengkap }}</div>
                            <div style="font-size:.7rem;color:#64748b">
                                NIK: {{ $linkedData['remaja']->nik ?? '-' }} · Kelas {{ $linkedData['remaja']->kelas ?? '-' }}
                            </div>
                        </div>
                    </div>
                    <div class="mb-2"></div>
                @endif

                {{-- Lansia --}}
                @if($linkedData['lansia'])
                    <div style="font-size:.72rem;font-weight:800;text-transform:uppercase;color:#92400e;margin-bottom:.5rem">
                        <i class="fas fa-user-clock me-1"></i> Lansia
                    </div>
                    <div class="patient-card">
                        <div class="patient-ic" style="background:linear-gradient(135deg,#d97706,#fbbf24)">
                            <i class="fas fa-user-clock"></i>
                        </div>
                        <div>
                            <div style="font-size:.84rem;font-weight:700;color:#0f172a">{{ $linkedData['lansia']->nama_lengkap }}</div>
                            <div style="font-size:.7rem;color:#64748b">
                                NIK: {{ $linkedData['lansia']->nik ?? '-' }} ·
                                {{ \Carbon\Carbon::parse($linkedData['lansia']->tanggal_lahir)->age }} tahun
                            </div>
                        </div>
                    </div>
                @endif

                @if($linkedData['balita']->isEmpty() && !$linkedData['remaja'] && !$linkedData['lansia'])
                <div class="text-center py-3" style="color:#94a3b8;font-size:.82rem">
                    <i class="fas fa-unlink d-block mb-2" style="font-size:1.5rem"></i>
                    Tidak ada data pasien terhubung<br>
                    <small>NIK warga belum cocok dengan data pasien manapun</small>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection