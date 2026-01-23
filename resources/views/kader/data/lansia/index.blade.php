@extends('layouts.kader')

@section('title', 'Data Lansia')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Data Lansia</h1>
        <p class="text-muted mb-0">Kelola data warga lanjut usia (Pra-Lansia & Lansia)</p>
    </div>
    <a href="{{ route('kader.data.lansia.create') }}" class="btn btn-primary shadow-sm rounded-pill px-4">
        <i class="fas fa-plus me-2"></i>Tambah Lansia
    </a>
</div>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">
                <form action="{{ route('kader.data.lansia.index') }}" method="GET">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" class="form-control border-0 bg-light" name="search" 
                               placeholder="Cari nama lansia, NIK, atau kode lansia..." 
                               value="{{ request('search') }}">
                        <button class="btn btn-primary px-4" type="submit">Cari</button>
                        @if(request('search'))
                        <a href="{{ route('kader.data.lansia.index') }}" class="btn btn-light border ms-2" title="Reset">
                            <i class="fas fa-sync-alt text-muted"></i>
                        </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-md">
    <div class="card-body p-0">
        @if($lansias->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3 border-0 text-secondary small text-uppercase fw-bold">Identitas Lansia</th>
                        <th class="py-3 border-0 text-secondary small text-uppercase fw-bold">Usia & Lahir</th>
                        <th class="py-3 border-0 text-secondary small text-uppercase fw-bold">Riwayat Kesehatan</th>
                        <th class="px-4 py-3 border-0 text-secondary small text-uppercase fw-bold text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lansias as $lansia)
                    <tr>
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-{{ $lansia->jenis_kelamin == 'L' ? 'primary' : 'danger' }}-subtle text-{{ $lansia->jenis_kelamin == 'L' ? 'primary' : 'danger' }} rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                                    <i class="fas fa-user-clock fs-5"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $lansia->nama_lengkap }}</div>
                                    <div class="small text-muted">
                                        <span class="badge bg-light text-dark border me-1">{{ $lansia->kode_lansia }}</span> 
                                        NIK: {{ $lansia->nik }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3">
                            <div class="d-flex flex-column gap-1">
                                <span class="badge bg-light text-dark border fw-normal" style="width: fit-content;">
                                    <i class="fas fa-hourglass-half me-1 text-warning"></i> 
                                    {{ $lansia->tanggal_lahir->age }} Tahun
                                </span>
                                <small class="text-muted">{{ $lansia->tanggal_lahir->format('d M Y') }}</small>
                            </div>
                        </td>
                        <td class="py-3">
                            @if($lansia->penyakit_bawaan)
                                @php $penyakits = explode(',', $lansia->penyakit_bawaan); @endphp
                                <div class="d-flex flex-wrap gap-1" style="max-width: 250px;">
                                    @foreach($penyakits as $penyakit)
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill" style="font-size: 0.7rem;">
                                            {{ trim($penyakit) }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Sehat</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-end">
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v text-muted"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg">
                                    <li><a class="dropdown-item" href="{{ route('kader.data.lansia.show', $lansia->id) }}"><i class="fas fa-eye me-2 text-info"></i>Detail</a></li>
                                    <li><a class="dropdown-item" href="{{ route('kader.data.lansia.edit', $lansia->id) }}"><i class="fas fa-edit me-2 text-warning"></i>Edit</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <button type="button" class="dropdown-item text-danger btn-delete" data-id="{{ $lansia->id }}">
                                            <i class="fas fa-trash me-2"></i>Hapus
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-top">
            {{ $lansias->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <div class="mb-3">
                <i class="fas fa-user-slash fa-3x text-muted opacity-25"></i>
            </div>
            <h5 class="text-muted">Tidak ada data lansia ditemukan</h5>
            <p class="text-muted small">Coba kata kunci lain atau tambahkan data baru</p>
        </div>
        @endif
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-body p-4 text-center">
                <div class="mb-3">
                    <div class="avatar-lg bg-danger-subtle text-danger rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="fas fa-trash-alt fs-3"></i>
                    </div>
                </div>
                <h5 class="fw-bold mb-2">Hapus Data Lansia?</h5>
                <p class="text-muted mb-4">Data yang dihapus tidak dapat dikembalikan. Riwayat pemeriksaan terkait juga akan terhapus.</p>
                <form id="deleteForm" method="POST" class="d-flex justify-content-center gap-2">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-light px-4 rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger px-4 rounded-pill">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const form = document.getElementById('deleteForm');
            form.action = `{{ url('kader/data/lansia') }}/${id}`;
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        });
    });
});
</script>
@endpush
@endsection