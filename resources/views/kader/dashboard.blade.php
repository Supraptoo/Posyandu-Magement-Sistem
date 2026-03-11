{{-- PATH: resources/views/kader/dashboard.blade.php --}}
@extends('layouts.kader')
@section('title','Dashboard Kader')
@section('page-name','Dashboard')

@section('content')
<style>
/* ── DASHBOARD PREMIUM STYLES ── */
@keyframes pulseRing { 0%, 100% { box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4) } 50% { box-shadow: 0 0 0 6px rgba(255, 255, 255, 0) } }
.animate-slide-up { opacity: 0; animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
@keyframes slideUpFade { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

/* HERO - Tema Indigo Premium */
.hero { background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%); border-radius: 24px; padding: 40px 48px; margin-bottom: 32px; display: flex; align-items: center; justify-content: space-between; gap: 24px; position: relative; overflow: hidden; box-shadow: 0 12px 30px -10px rgba(79, 70, 229, 0.4); }
.hero::before { content: ''; position: absolute; inset: 0; background-image: radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px); background-size: 24px 24px; opacity: 0.5; pointer-events: none; }
.hero-glow-1 { position: absolute; top: -100px; right: 100px; width: 400px; height: 400px; border-radius: 50%; background: radial-gradient(circle, rgba(99, 102, 241, 0.4) 0%, transparent 70%); pointer-events: none; }
.hero-glow-2 { position: absolute; bottom: -80px; right: -50px; width: 300px; height: 300px; border-radius: 50%; background: radial-gradient(circle, rgba(165, 180, 252, 0.2) 0%, transparent 70%); pointer-events: none; }

.hero-txt { position: relative; z-index: 1; }
.hero-badge { display: inline-flex; align-items: center; gap: 8px; background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(4px); border: 1px solid rgba(255, 255, 255, 0.2); color: #fff; font-size: 11px; font-weight: 800; padding: 6px 14px; border-radius: 50px; margin-bottom: 16px; letter-spacing: 1px; text-transform: uppercase; }
.hero-badge .pulse { width: 6px; height: 6px; border-radius: 50%; background: #fff; animation: pulseRing 2s infinite; }
.hero-title { font-size: 32px; font-weight: 900; color: #fff; line-height: 1.2; margin-bottom: 12px; letter-spacing: -0.5px; }
.hero-title span { color: #a5b4fc; font-weight: 800; }
.hero-desc { font-size: 14.5px; color: rgba(255, 255, 255, 0.8); margin-bottom: 24px; max-width: 480px; font-weight: 500; line-height: 1.6; }

/* STATS CARDS */
.stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 32px; }
.stat-card { background: #fff; border: 1px solid rgba(226, 232, 240, 0.8); border-radius: 20px; padding: 22px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02); transition: all 0.3s ease; position: relative; overflow: hidden; }
.stat-card:hover { transform: translateY(-4px); box-shadow: 0 12px 25px rgba(0, 0, 0, 0.05); border-color: #cbd5e1; }
.stat-icon { width: 48px; height: 48px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 16px; }
.stat-label { font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
.stat-value { font-size: 32px; font-weight: 900; color: #0f172a; line-height: 1; letter-spacing: -1px; }

/* RESPONSIVE */
@media(max-width: 1200px) { .stats-grid { grid-template-columns: repeat(4, 1fr); } }
@media(max-width: 900px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } .hero { padding: 32px 24px; } .hero-vis { display: none; } .hero-title { font-size: 26px; } }
@media(max-width: 580px) { .stats-grid { grid-template-columns: 1fr 1fr; gap: 12px; } .hero { border-radius: 20px; padding: 24px 20px; } .hero-title { font-size: 22px; } .stat-value { font-size: 28px; } }
</style>

<div class="animate-slide-up">
    
    <div class="hero">
        <div class="hero-glow-1"></div><div class="hero-glow-2"></div>
        <div class="hero-txt">
            <div class="hero-badge"><span class="pulse"></span> Dasbor Aktif</div>
            <h1 class="hero-title">Selamat Datang,<br><span>Kader {{ Str::words(Auth::user()->profile->full_name ?? 'Hebat', 2, '') }}!</span> 👋</h1>
            <p class="hero-desc">Pantau rekapitulasi data warga, jadwal kegiatan, dan grafik kesehatan posyandu Anda dengan mudah dan cepat.</p>
            
            <div class="flex flex-wrap items-center gap-3 mt-4">
                <div class="flex items-center gap-2 px-4 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 text-white text-sm font-semibold">
                    <i class="fas fa-calendar-day text-indigo-200"></i> {{ now()->translatedFormat('l, d F Y') }}
                </div>
                <div class="flex items-center gap-2 px-4 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 text-white text-sm font-semibold">
                    <i class="fas fa-users text-emerald-300"></i> {{ ($stats['total_balita']??0)+($stats['total_remaja']??0)+($stats['total_lansia']??0) }} Warga Terdaftar
                </div>
            </div>
        </div>
        <div class="hidden lg:flex items-center justify-center w-40 h-40 bg-white/10 backdrop-blur-xl border border-white/20 rounded-[2rem] shadow-2xl relative z-10 rotate-3 hover:rotate-0 transition-all duration-500">
            <i class="fas fa-clinic-medical text-6xl text-white drop-shadow-lg"></i>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon bg-rose-100 text-rose-600"><i class="fas fa-baby"></i></div>
            <div class="stat-label">Total Balita</div>
            <div class="stat-value">{{ $stats['total_balita'] ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-sky-100 text-sky-600"><i class="fas fa-child"></i></div>
            <div class="stat-label">Total Remaja</div>
            <div class="stat-value">{{ $stats['total_remaja'] ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-emerald-100 text-emerald-600"><i class="fas fa-user-clock"></i></div>
            <div class="stat-label">Total Lansia</div>
            <div class="stat-value">{{ $stats['total_lansia'] ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-indigo-100 text-indigo-600"><i class="fas fa-calendar-check"></i></div>
            <div class="stat-label">Jadwal Bulan Ini</div>
            <div class="stat-value">{{ $stats['jadwal_hari_ini'] ?? 0 }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <div class="lg:col-span-2 bg-white rounded-[24px] border border-slate-200/80 shadow-[0_4px_20px_rgba(0,0,0,0.03)] p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-base font-extrabold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-chart-area text-indigo-500"></i> Tren Kunjungan 7 Hari
                </h3>
                <div style="display:flex;gap:8px">
                    {{-- 👇 PERBAIKAN RUTE DI SINI 👇 --}}
                    <a href="{{ route('kader.kunjungan.index') }}" class="btn btn-secondary btn-sm" style="border: 1px solid #e2e8f0; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; text-decoration: none; color: #475569; background: #f8fafc;">
                        <i class="fas fa-arrow-up-right-from-square"></i> Detail
                    </a>
                    <a href="{{ route('kader.laporan.index') }}" class="btn btn-primary btn-sm" style="background: #0ea5e9; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; text-decoration: none; color: white;">
                        <i class="fas fa-file-chart-pie"></i> Laporan
                    </a>
                </div>
            </div>
            
            @if(empty($kunjungan_7_hari) || count($kunjungan_7_hari) == 0)
                <div class="h-64 flex flex-col items-center justify-center text-slate-400">
                    <i class="fas fa-chart-line text-4xl mb-3 opacity-50"></i>
                    <p class="font-medium text-sm">Belum ada data kunjungan dalam 7 hari terakhir</p>
                </div>
            @else
                <div class="relative h-64">
                    <canvas id="lineChart"></canvas>
                </div>
            @endif
        </div>

        <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_4px_20px_rgba(0,0,0,0.03)] p-6 flex flex-col">
            <h3 class="text-base font-extrabold text-slate-800 flex items-center gap-2 mb-6">
                <i class="fas fa-chart-pie text-amber-500"></i> Demografi Warga
            </h3>
            
            @php $totalW = ($stats['total_balita']??0)+($stats['total_remaja']??0)+($stats['total_lansia']??0); @endphp
            
            @if($totalW == 0)
                <div class="h-44 flex flex-col items-center justify-center text-slate-400 mb-6">
                    <i class="fas fa-users-slash text-4xl mb-3 opacity-50"></i>
                    <p class="font-medium text-sm">Belum ada warga terdaftar</p>
                </div>
            @else
                <div class="relative h-44 mb-6">
                    <canvas id="donutChart"></canvas>
                </div>
            @endif

            <div class="flex flex-col gap-3 mt-auto">
                <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                    <div class="flex items-center gap-3"><span class="w-3 h-3 rounded-full bg-rose-500"></span><span class="text-sm font-bold text-slate-600">Balita</span></div>
                    <span class="text-sm font-black text-slate-900">{{ $stats['total_balita'] ?? 0 }}</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                    <div class="flex items-center gap-3"><span class="w-3 h-3 rounded-full bg-sky-500"></span><span class="text-sm font-bold text-slate-600">Remaja</span></div>
                    <span class="text-sm font-black text-slate-900">{{ $stats['total_remaja'] ?? 0 }}</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                    <div class="flex items-center gap-3"><span class="w-3 h-3 rounded-full bg-amber-500"></span><span class="text-sm font-bold text-slate-600">Lansia</span></div>
                    <span class="text-sm font-black text-slate-900">{{ $stats['total_lansia'] ?? 0 }}</span>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  
  // 1. FORMAT TANGGAL UNTUK X-AXIS (Mengubah '2026-03-06' menjadi '06 Mar')
  const rawDates = {!! json_encode($kunjungan_7_hari->pluck('tanggal') ?? []) !!};
  const formattedDates = rawDates.map(dateStr => {
      const dateObj = new Date(dateStr);
      // Opsi untuk Bahasa Indonesia: 06 Mar
      return dateObj.toLocaleDateString('id-ID', { day: '2-digit', month: 'short' });
  });

  const rawData = {!! json_encode($kunjungan_7_hari->pluck('total') ?? []) !!};

  // 2. INISIALISASI LINE CHART KUNJUNGAN
  const lc = document.getElementById('lineChart');
  if(lc && rawDates.length > 0) {
    const ctx = lc.getContext('2d');
    
    // Gradient Background di bawah garis
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(79, 70, 229, 0.25)'); // Indigo-600 transparan
    gradient.addColorStop(1, 'rgba(79, 70, 229, 0)');

    new Chart(ctx, {
      type: 'line',
      data: {
        labels: formattedDates,
        datasets: [{
          label: 'Total Kunjungan',
          data: rawData,
          borderColor: '#4f46e5', // Warna garis Indigo
          backgroundColor: gradient,
          borderWidth: 3,
          fill: true,
          tension: 0.4, // Kurva melengkung mulus (smooth)
          pointBackgroundColor: '#ffffff',
          pointBorderColor: '#4f46e5',
          pointBorderWidth: 3,
          pointRadius: rawData.length === 1 ? 8 : 5, // Jika datanya cuma 1, titiknya diperbesar
          pointHoverRadius: 8
        }]
      },
      options: {
        responsive: true, 
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: '#1e293b',
            titleColor: '#fff',
            bodyColor: '#cbd5e1',
            padding: 14,
            borderRadius: 10,
            titleFont: { size: 14, family: 'Inter' },
            bodyFont: { size: 15, weight: 'bold', family: 'Inter' },
            displayColors: false, // Menghilangkan kotak warna di dalam tooltip
            callbacks: {
                label: function(context) {
                    return context.parsed.y + ' Orang dilayani';
                }
            }
          }
        },
        scales: {
          y: { 
              beginAtZero: true, 
              border: { display: false }, 
              grid: { color: '#f1f5f9', drawBorder: false }, 
              ticks: { 
                  stepSize: 1, // Memaksa y-axis menampilkan bilangan bulat (1, 2, 3...)
                  color: '#94a3b8', 
                  font: { weight: '600', family: 'Inter' },
                  precision: 0
              } 
          },
          x: { 
              border: { display: false }, 
              grid: { display: false }, 
              ticks: { color: '#94a3b8', font: { weight: '600', family: 'Inter' } } 
          }
        },
        interaction: {
            mode: 'index',
            intersect: false,
        },
      }
    });
  }

  // 3. INISIALISASI DONUT CHART DEMOGRAFI
  const dc = document.getElementById('donutChart');
  const balitaCount = {{ $stats['total_balita'] ?? 0 }};
  const remajaCount = {{ $stats['total_remaja'] ?? 0 }};
  const lansiaCount = {{ $stats['total_lansia'] ?? 0 }};
  const totalWarga = balitaCount + remajaCount + lansiaCount;

  if(dc && totalWarga > 0) {
    new Chart(dc, {
      type: 'doughnut',
      data: {
        labels: ['Balita', 'Remaja', 'Lansia'],
        datasets: [{
          data: [balitaCount, remajaCount, lansiaCount],
          backgroundColor: ['#f43f5e', '#0ea5e9', '#f59e0b'], // Rose, Sky, Amber
          borderWidth: 4,
          borderColor: '#ffffff',
          hoverOffset: 6,
          borderRadius: 5
        }]
      },
      options: {
        responsive: true, 
        maintainAspectRatio: false, 
        cutout: '75%', // Memperlebar lubang donat
        plugins: {
          legend: { display: false },
          tooltip: { 
              backgroundColor: '#1e293b', 
              padding: 14, 
              borderRadius: 10,
              titleFont: { size: 14, family: 'Inter' },
              bodyFont: { size: 14, weight: 'bold', family: 'Inter' },
              callbacks: {
                  label: function(context) {
                      let label = context.label || '';
                      let value = context.parsed || 0;
                      let percentage = Math.round((value / totalWarga) * 100) + '%';
                      return ` ${label}: ${value} Orang (${percentage})`;
                  }
              }
          }
        }
      }
    });
  }
});
</script>
@endpush