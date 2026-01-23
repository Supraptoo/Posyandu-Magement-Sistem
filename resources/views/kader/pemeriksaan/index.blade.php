@extends('layouts.kader')

@section('title', 'Daftar Pemeriksaan')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-notes-medical me-2"></i>Daftar Pemeriksaan</h1>
        <a href="{{ route('kader.pemeriksaan.create') }}" class="btn btn-primary shadow-sm"><i class="fas fa-plus me-2"></i>Pemeriksaan Baru</a>
    </div>

    <div class="card shadow mb-4 border-0">
        <div class="card-body">
            <form action="{{ route('kader.pemeriksaan.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <select class="form-select" name="type" onchange="this.form.submit()">
                        <option value="all" {{ $type == 'all' ? 'selected' : '' }}>Semua Kategori</option>
                        <option value="balita" {{ $type == 'balita' ? 'selected' : '' }}>Balita</option>
                        <option value="remaja" {{ $type == 'remaja' ? 'selected' : '' }}>Remaja</option>
                        <option value="lansia" {{ $type == 'lansia' ? 'selected' : '' }}>Lansia</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama pasien..." value="{{ $search }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Tanggal</th>
                            <th>Nama Pasien</th>
                            <th>Kategori</th>
                            <th>Hasil Dasar</th>
                            <th>Diagnosa</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pemeriksaans as $cek)
                        <tr>
                            <td class="ps-4">{{ $cek->created_at->format('d/m/Y') }}</td>
                            <td class="fw-bold">{{ $cek->kunjungan->pasien->nama_lengkap }}</td>
                            <td>
                                @php
                                    $class = get_class($cek->kunjungan->pasien);
                                    $label = str_contains($class, 'Balita') ? 'Balita' : (str_contains($class, 'Remaja') ? 'Remaja' : 'Lansia');
                                    $badge = $label == 'Balita' ? 'success' : ($label == 'Remaja' ? 'info' : 'warning');
                                @endphp
                                <span class="badge bg-{{ $badge }}">{{ $label }}</span>
                            </td>
                            <td>
                                <small>
                                    BB: {{ $cek->berat_badan }} kg<br>
                                    TB: {{ $cek->tinggi_badan }} cm
                                </small>
                            </td>
                            <td>{{ Str::limit($cek->diagnosa, 30) ?? '-' }}</td>
                            <td class="text-end pe-4">
                                <a href="{{ route('kader.pemeriksaan.show', $cek->id) }}" class="btn btn-sm btn-info text-white"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('kader.pemeriksaan.edit', $cek->id) }}" class="btn btn-sm btn-warning text-white"><i class="fas fa-edit"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">Belum ada data pemeriksaan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-3">
                {{ $pemeriksaans->links() }}
            </div>
        </div>
    </div>
</div>
@endsection