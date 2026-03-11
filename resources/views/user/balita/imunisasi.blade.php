@extends('layouts.user')

@section('title', 'Riwayat Imunisasi')

@push('styles')
<style>
/* ═══════════════════════════════════════
   IMUNISASI — Professional Redesign
   ═══════════════════════════════════════ */

.imun-wrap {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 .25rem;
}

/* ── Page Header ── */
.imun-page-header {
    display: flex; align-items: center;
    gap: 1rem; margin-bottom: 2rem;
}
.imun-page-icon {
    width: 50px; height: 50px; border-radius: 14px;
    background: linear-gradient(135deg, #0ea5e9 0%, #14b8a6 100%);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 1.2rem; flex-shrink: 0;
    box-shadow: 0 6px 18px rgba(14,165,233,.3);
}
.imun-page-title {
    font-size: 1.3rem; font-weight: 800; color: #0f172a;
    margin: 0; font-family: 'Plus Jakarta Sans', sans-serif;
}
.imun-page-sub { font-size: .8rem; color: #94a3b8; margin-top: .2rem; }

/* ── Summary Strip ── */
.imun-summary {
    display: flex; gap: 1rem; margin-bottom: 1.5rem; flex-wrap: wrap;
}
.imun-sum-card {
    flex: 1; min-width: 140px;
    background: #fff; border: 1px solid #e8f4f2;
    border-radius: 16px; padding: 1rem 1.2rem;
    box-shadow: 0 2px 12px rgba(0,0,0,.05);
    position: relative; overflow: hidden;
}
.imun-sum-card .ss-stripe {
    position: absolute; left: 0; top: 0; bottom: 0;
    width: 4px; border-radius: 4px 0 0 4px;
}
.imun-sum-card .ss-label {
    font-size: .63rem; font-weight: 700; letter-spacing: .08em;
    text-transform: uppercase; color: #94a3b8; margin-bottom: .35rem;
}
.imun-sum-card .ss-val {
    font-size: 1.6rem; font-weight: 900; color: #0f172a;
    font-family: 'Plus Jakarta Sans', sans-serif; line-height: 1;
}
.imun-sum-card .ss-icon {
    position: absolute; right: .9rem; top: 50%;
    transform: translateY(-50%);
    font-size: 2rem; opacity: .06;
}

/* ── Main Card ── */
.imun-card {
    background: #fff;
    border: 1px solid #e8f4f2;
    border-radius: 20px;
    box-shadow: 0 4px 24px rgba(13,148,136,.07);
    overflow: hidden;
}
.imun-card-header {
    padding: 1.1rem 1.5rem;
    border-bottom: 1px solid #f1f5f9;
    display: flex; align-items: center; justify-content: space-between;
}
.imun-card-title {
    font-size: .92rem; font-weight: 800; color: #0f172a; margin: 0;
    display: flex; align-items: center; gap: .55rem;
    font-family: 'Plus Jakarta Sans', sans-serif;
}
.imun-title-icon {
    width: 30px; height: 30px; border-radius: 8px;
    background: linear-gradient(135deg, #0ea5e9, #14b8a6);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: .75rem;
}

/* Table */
.imun-table { width: 100%; border-collapse: collapse; }
.imun-table thead tr { background: #f8fafc; }
.imun-table thead th {
    padding: .8rem 1rem;
    font-size: .65rem; font-weight: 700; letter-spacing: .08em;
    text-transform: uppercase; color: #94a3b8;
    border-bottom: 1px solid #f1f5f9; white-space: nowrap;
}
.imun-table thead th:first-child { padding-left: 1.5rem; }
.imun-table tbody tr { border-bottom: 1px solid #f8fafc; transition: background .12s; }
.imun-table tbody tr:last-child { border-bottom: none; }
.imun-table tbody tr:hover { background: #f0fdfa; }
.imun-table tbody td { padding: .95rem 1rem; font-size: .84rem; color: #334155; vertical-align: middle; }
.imun-table tbody td:first-child { padding-left: 1.5rem; }

/* Jenis badge */
.imun-jenis {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .28rem .7rem; border-radius: 50px;
    font-size: .73rem; font-weight: 700;
    background: #ccfbf1; color: #0d9488; border: 1px solid #99f6e4;
}

/* Dosis badge */
.imun-dosis {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .2rem .55rem; border-radius: 50px;
    font-size: .68rem; font-weight: 600;
    background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe;
    margin-left: .35rem;
}

/* Penyelenggara cell */
.imun-peny {
    display: flex; align-items: center; gap: .55rem;
}
.imun-peny-icon {
    width: 28px; height: 28px; border-radius: 7px; flex-shrink: 0;
    background: #f0fdfa; border: 1px solid #ccfbf1;
    display: flex; align-items: center; justify-content: center;
    color: #0d9488; font-size: .7rem;
}

/* Count badge */
.imun-count {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .27rem .7rem; border-radius: 50px;
    font-size: .72rem; font-weight: 600;
    background: #ccfbf1; color: #0d9488; border: 1px solid #99f6e4;
}

/* Empty state */
.imun-empty { text-align: center; padding: 3.5rem 1.5rem; }
.imun-empty-icon {
    width: 68px; height: 68px; border-radius: 18px;
    background: #f0fdfa; border: 1.5px solid #ccfbf1;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.7rem; color: #5eead4; margin: 0 auto .9rem;
}
.imun-empty h6 { font-weight: 800; color: #0f172a; margin-bottom: .35rem; font-size: .92rem; }
.imun-empty p  { color: #94a3b8; font-size: .82rem; margin: 0; }
</style>
@endpush

@section('content')
<div class="imun-wrap animate-fade-in">

    {{-- ── Page Header ── --}}
    <div class="imun-page-header">
        <div class="imun-page-icon"><i class="fas fa-syringe"></i></div>
        <div>
            <h1 class="imun-page-title">Riwayat Imunisasi</h1>
            <div class="imun-page-sub">Daftar vaksinasi buah hati Anda</div>
        </div>
    </div>

    {{-- ── Summary Strip ── --}}
    <div class="imun-summary">
        <div class="imun-sum-card">
            <div class="ss-stripe" style="background:linear-gradient(180deg,#14b8a6,#5eead4);"></div>
            <i class="fas fa-syringe ss-icon" style="color:#14b8a6;"></i>
            <div class="ss-label">Total Imunisasi</div>
            <div class="ss-val">{{ $riwayatImunisasi->count() }}</div>
        </div>
        <div class="imun-sum-card">
            <div class="ss-stripe" style="background:linear-gradient(180deg,#0ea5e9,#38bdf8);"></div>
            <i class="fas fa-vial ss-icon" style="color:#0ea5e9;"></i>
            <div class="ss-label">Jenis Vaksin</div>
            <div class="ss-val">{{ $riwayatImunisasi->pluck('jenis_imunisasi')->unique()->count() }}</div>
        </div>
        @if($riwayatImunisasi->count() > 0)
        <div class="imun-sum-card">
            <div class="ss-stripe" style="background:linear-gradient(180deg,#8b5cf6,#a78bfa);"></div>
            <i class="fas fa-calendar-check ss-icon" style="color:#8b5cf6;"></i>
            <div class="ss-label">Terakhir</div>
            <div class="ss-val" style="font-size:1rem;padding-top:.15rem;">
                {{ \Carbon\Carbon::parse($riwayatImunisasi->sortByDesc('tanggal_imunisasi')->first()->tanggal_imunisasi)->format('d M Y') }}
            </div>
        </div>
        @endif
    </div>

    {{-- ── Table Card ── --}}
    <div class="imun-card">
        <div class="imun-card-header">
            <h6 class="imun-card-title">
                <div class="imun-title-icon"><i class="fas fa-list-ul"></i></div>
                Data Vaksinasi
            </h6>
            <span class="imun-count">{{ $riwayatImunisasi->count() }} Catatan</span>
        </div>
        <div class="table-responsive">
            <table class="imun-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis Imunisasi</th>
                        <th>Vaksin &amp; Dosis</th>
                        <th>Penyelenggara</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatImunisasi as $imun)
                    <tr>
                        <td>
                            <span style="font-weight:700;color:#0f172a;">
                                {{ \Carbon\Carbon::parse($imun->tanggal_imunisasi)->format('d M Y') }}
                            </span>
                        </td>
                        <td>
                            <span class="imun-jenis">
                                <i class="fas fa-shield-virus" style="font-size:.7rem;"></i>
                                {{ $imun->jenis_imunisasi }}
                            </span>
                        </td>
                        <td>
                            <span style="font-weight:600;color:#0f172a;">{{ $imun->vaksin ?? '—' }}</span>
                            @if($imun->dosis ?? false)
                            <span class="imun-dosis">Dosis {{ $imun->dosis }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="imun-peny">
                                <div class="imun-peny-icon"><i class="fas fa-hospital-alt"></i></div>
                                <span>{{ $imun->penyelenggara ?? 'Posyandu' }}</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">
                            <div class="imun-empty">
                                <div class="imun-empty-icon"><i class="fas fa-syringe"></i></div>
                                <h6>Belum Ada Data Imunisasi</h6>
                                <p>Belum ada catatan imunisasi yang tersimpan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection