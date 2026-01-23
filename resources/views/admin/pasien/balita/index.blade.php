@extends('layouts.app')

@section('title', 'Data Balita')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-baby me-2"></i>Data Balita
        </h1>
        <a href="{{ route('admin.pasien.balita.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i>Tambah Balita
        </a>
    </div>

    <!-- Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Balita</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Lengkap</th>
                            <th>NIK</th>
                            <th>Usia</th>
                            <th>Jenis Kelamin</th>
                            <th>Nama Ibu</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($balitas as $balita)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><span class="badge bg-info">{{ $balita->kode_balita }}</span></td>
                            <td>{{ $balita->nama_lengkap }}</td>
                            <td>{{ $balita->nik }}</td>
                            <td>
                                @if($balita->usia_tahun > 0)
                                    {{ $balita->usia_tahun }} tahun {{ $balita->usia_bulan }} bulan
                                @else
                                    {{ $balita->usia }} bulan
                                @endif
                            </td>
                            <td>
                                @if($balita->jenis_kelamin == 'L')
                                    <span class="badge bg-primary">Laki-laki</span>
                                @else
                                    <span class="badge bg-pink">Perempuan</span>
                                @endif
                            </td>
                            <td>{{ $balita->nama_ibu }}</td>
                            <td>{{ $balita->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.pasien.balita.show', $balita->id) }}" 
                                       class="btn btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="#" class="btn btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="confirmDelete('{{ $balita->id }}')" 
                                            class="btn btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <form id="delete-form-{{ $balita->id }}" 
                                      action="{{ route('admin.pasien.balita.destroy', $balita->id) }}" 
                                      method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data balita</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $balitas->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmDelete(balitaId) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data balita akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + balitaId).submit();
        }
    });
}
</script>
@endpush
@endsection