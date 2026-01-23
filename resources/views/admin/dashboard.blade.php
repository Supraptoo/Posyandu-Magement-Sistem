@extends('layouts.app')

@section('title', 'Dashboard Admin')

@push('styles')
<style>
    /* Page Header dengan efek glass */
.dashboard-header {
    background: linear-gradient(135deg, rgba(34, 40, 49, 0.95) 0%, rgba(57, 62, 70, 0.95) 100%);
    backdrop-filter: blur(10px);
    color: white;
    padding: 2rem;
    border-radius: 20px;
    margin-bottom: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.1);
    position: relative;
    overflow: hidden;
}

.dashboard-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #00ADB5, #3498db, #f39c12, #27ae60);
}

.dashboard-header h2 {
    margin: 0;
    font-weight: 700;
    font-size: 1.8rem;
}

.dashboard-header .breadcrumb {
    background: transparent;
    margin: 0.5rem 0 0 0;
    padding: 0;
}

.dashboard-header .breadcrumb-item,
.dashboard-header .breadcrumb-item a {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.9rem;
}

.dashboard-header .breadcrumb-item.active {
    color: var(--accent-cyan);
}

/* Real-time Clock */
.real-time-clock {
    text-align: right;
}

.real-time-clock .date-display {
    font-size: 1.1rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.real-time-clock .time-display {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--accent-cyan);
    font-family: 'Courier New', monospace;
}

.real-time-clock .seconds {
    font-size: 1.4rem;
    opacity: 0.8;
}

/* Stat Cards - Modern Design */
.stat-card-modern {
    background: white;
    border: none;
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    height: 100%;
    position: relative;
    z-index: 1;
}

.stat-card-modern::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    z-index: 2;
}

.stat-card-modern:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

/* Warna untuk setiap tipe stat card */
.stat-card-user::before { background: linear-gradient(90deg, #3498db, #2980b9); }
.stat-card-kader::before { background: linear-gradient(90deg, #f39c12, #e67e22); }
.stat-card-bidan::before { background: linear-gradient(90deg, #27ae60, #229954); }
.stat-card-admin::before { background: linear-gradient(90deg, #e74c3c, #c0392b); }
.stat-card-balita::before { background: linear-gradient(90deg, #9b59b6, #8e44ad); }
.stat-card-remaja::before { background: linear-gradient(90deg, #1abc9c, #16a085); }
.stat-card-lansia::before { background: linear-gradient(90deg, #34495e, #2c3e50); }
.stat-card-active::before { background: linear-gradient(90deg, #2ecc71, #27ae60); }
.stat-card-inactive::before { background: linear-gradient(90deg, #95a5a6, #7f8c8d); }

.stat-card-modern .card-body {
    padding: 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.stat-info {
    flex: 1;
}

.stat-number {
    font-size: 2.8rem;
    font-weight: 800;
    margin: 0;
    line-height: 1;
    background: linear-gradient(135deg, var(--dark-bg), var(--dark-secondary));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    letter-spacing: -1px;
}

.stat-label {
    font-size: 0.9rem;
    font-weight: 600;
    margin: 0.5rem 0 0 0;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-change {
    font-size: 0.8rem;
    margin-top: 0.25rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.stat-change.positive {
    color: #27ae60;
}

.stat-change.negative {
    color: #e74c3c;
}

.stat-change.info {
    color: #3498db;
}

.stat-icon-container {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    position: relative;
}

.stat-card-user .stat-icon-container { 
    background: rgba(52, 152, 219, 0.1); 
    color: #3498db; 
}
.stat-card-kader .stat-icon-container { 
    background: rgba(243, 156, 18, 0.1); 
    color: #f39c12; 
}
.stat-card-bidan .stat-icon-container { 
    background: rgba(39, 174, 96, 0.1); 
    color: #27ae60; 
}
.stat-card-admin .stat-icon-container { 
    background: rgba(231, 76, 60, 0.1); 
    color: #e74c3c; 
}
.stat-card-balita .stat-icon-container { 
    background: rgba(155, 89, 182, 0.1); 
    color: #9b59b6; 
}
.stat-card-remaja .stat-icon-container { 
    background: rgba(26, 188, 156, 0.1); 
    color: #1abc9c; 
}
.stat-card-lansia .stat-icon-container { 
    background: rgba(52, 73, 94, 0.1); 
    color: #34495e; 
}
.stat-card-active .stat-icon-container { 
    background: rgba(46, 204, 113, 0.1); 
    color: #2ecc71; 
}
.stat-card-inactive .stat-icon-container { 
    background: rgba(149, 165, 166, 0.1); 
    color: #95a5a6; 
}

/* Quick Actions - Glassmorphism */
.quick-actions-modern {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    margin-bottom: 2rem;
    overflow: hidden;
}

.quick-actions-modern .card-header {
    background: linear-gradient(135deg, var(--dark-bg) 0%, var(--dark-secondary) 100%);
    color: white;
    border: none;
    padding: 1.5rem;
}

.quick-actions-modern .card-header h5 {
    margin: 0;
    font-weight: 600;
    font-size: 1.2rem;
}

.btn-action-modern {
    border: none;
    border-radius: 12px;
    padding: 1rem;
    font-weight: 600;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    height: 100%;
    background: white;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.btn-action-modern:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.btn-action-modern .action-icon {
    font-size: 2rem;
    transition: transform 0.3s ease;
}

.btn-action-modern:hover .action-icon {
    transform: scale(1.1);
}

.btn-action-modern .action-text {
    font-size: 0.9rem;
    font-weight: 500;
}

/* Warna untuk action buttons */
.btn-user { 
    color: #3498db; 
    border-left: 4px solid #3498db; 
}
.btn-user:hover {
    background: #3498db;
    color: white;
}

.btn-kader { 
    color: #f39c12; 
    border-left: 4px solid #f39c12; 
}
.btn-kader:hover {
    background: #f39c12;
    color: white;
}

.btn-bidan { 
    color: #27ae60; 
    border-left: 4px solid #27ae60; 
}
.btn-bidan:hover {
    background: #27ae60;
    color: white;
}

.btn-setting { 
    color: #9b59b6; 
    border-left: 4px solid #9b59b6; 
}
.btn-setting:hover {
    background: #9b59b6;
    color: white;
}

.btn-report { 
    color: #e74c3c; 
    border-left: 4px solid #e74c3c; 
}
.btn-report:hover {
    background: #e74c3c;
    color: white;
}

.btn-pasien { 
    color: #1abc9c; 
    border-left: 4px solid #1abc9c; 
}
.btn-pasien:hover {
    background: #1abc9c;
    color: white;
}

/* Activity Timeline */
.activity-timeline {
    background: white;
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(0, 0, 0, 0.05);
    height: 100%;
    overflow: hidden;
}

.activity-timeline .card-header {
    background: linear-gradient(135deg, var(--dark-bg) 0%, var(--dark-secondary) 100%);
    color: white;
    border: none;
    padding: 1.5rem;
}

.timeline {
    padding: 1.5rem;
    margin: 0;
    list-style: none;
    max-height: 400px;
    overflow-y: auto;
}

.timeline-item {
    position: relative;
    padding-left: 2.5rem;
    padding-bottom: 1.5rem;
    border-left: 2px solid #e9ecef;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: -7px;
    top: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 0 0 2px;
}

.timeline-user::before { 
    box-shadow: 0 0 0 2px #3498db; 
    background: #3498db; 
}
.timeline-kader::before { 
    box-shadow: 0 0 0 2px #f39c12; 
    background: #f39c12; 
}
.timeline-bidan::before { 
    box-shadow: 0 0 0 2px #27ae60; 
    background: #27ae60; 
}
.timeline-admin::before { 
    box-shadow: 0 0 0 2px #e74c3c; 
    background: #e74c3c; 
}

.timeline-content {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 10px;
    border-left: 4px solid;
}

.timeline-user .timeline-content { border-left-color: #3498db; }
.timeline-kader .timeline-content { border-left-color: #f39c12; }
.timeline-bidan .timeline-content { border-left-color: #27ae60; }
.timeline-admin .timeline-content { border-left-color: #e74c3c; }

.timeline-title {
    font-weight: 600;
    margin-bottom: 0.25rem;
    font-size: 0.95rem;
}

.timeline-time {
    font-size: 0.8rem;
    color: #6c757d;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

/* System Status Cards */
.status-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(0, 0, 0, 0.05);
    height: 100%;
}

.status-card h5 {
    margin-bottom: 1.5rem;
    font-weight: 600;
    color: var(--dark-bg);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.status-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f1f1f1;
}

.status-item:last-child {
    border-bottom: none;
}

.status-label {
    font-weight: 500;
    color: #495057;
}

.status-value {
    font-weight: 600;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.status-good { 
    background: rgba(46, 204, 113, 0.1); 
    color: #27ae60; 
}
.status-warning { 
    background: rgba(243, 156, 18, 0.1); 
    color: #f39c12; 
}
.status-danger { 
    background: rgba(231, 76, 60, 0.1); 
    color: #e74c3c; 
}
.status-info { 
    background: rgba(52, 152, 219, 0.1); 
    color: #3498db; 
}

/* Chart Container */
.chart-container-modern {
    background: white;
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(0, 0, 0, 0.05);
    overflow: hidden;
    height: 100%;
}

.chart-container-modern .card-header {
    background: linear-gradient(135deg, var(--dark-bg) 0%, var(--dark-secondary) 100%);
    color: white;
    border: none;
    padding: 1.5rem;
}

.chart-wrapper {
    padding: 1.5rem;
    height: 300px;
}

/* List Group for Top Active Users */
.list-group-flush .list-group-item {
    border-left: 0;
    border-right: 0;
    border-radius: 0;
    padding: 0.75rem 0;
}

.list-group-flush .list-group-item:first-child {
    border-top: 0;
    padding-top: 0;
}

.list-group-flush .list-group-item:last-child {
    border-bottom: 0;
    padding-bottom: 0;
}

/* Loading Animation */
.loading-pulse {
    animation: pulse 1.5s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

/* Text Center */
.text-center {
    text-align: center;
}

.text-muted {
    color: #6c757d !important;
}

/* Badge Styles */
.badge {
    font-size: 0.75em;
    font-weight: 600;
    padding: 0.25em 0.6em;
}

.badge.rounded-circle {
    border-radius: 50%;
    width: 30px;
    height: 30px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0;
}

/* Animation Classes */
.animate-fade-in-up {
    animation: fadeInUp 0.6s ease forwards;
    opacity: 0;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Grid Delay Animation */
.delay-1 { animation-delay: 0.1s; }
.delay-2 { animation-delay: 0.2s; }
.delay-3 { animation-delay: 0.3s; }
.delay-4 { animation-delay: 0.4s; }
.delay-5 { animation-delay: 0.5s; }
.delay-6 { animation-delay: 0.6s; }
.delay-7 { animation-delay: 0.7s; }
.delay-8 { animation-delay: 0.8s; }
.delay-9 { animation-delay: 0.9s; }
.delay-10 { animation-delay: 1s; }

/* Scrollbar Styling */
.timeline::-webkit-scrollbar {
    width: 6px;
}

.timeline::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.timeline::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

.timeline::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Responsive Design */
@media (max-width: 768px) {
    .dashboard-header {
        padding: 1.5rem;
    }

    .dashboard-header h2 {
        font-size: 1.5rem;
    }

    .real-time-clock {
        text-align: left;
        margin-top: 1rem;
    }

    .stat-number {
        font-size: 2.2rem;
    }

    .stat-icon-container {
        width: 60px;
        height: 60px;
        font-size: 1.8rem;
    }

    .btn-action-modern {
        padding: 0.75rem;
    }

    .btn-action-modern .action-icon {
        font-size: 1.5rem;
    }

    .btn-action-modern .action-text {
        font-size: 0.8rem;
    }
    
    .real-time-clock .time-display {
        font-size: 1.5rem;
    }
    
    .real-time-clock .seconds {
        font-size: 1.2rem;
    }
}

@media (max-width: 576px) {
    .dashboard-header {
        padding: 1rem;
    }

    .real-time-clock .time-display {
        font-size: 1.3rem;
    }
    
    .real-time-clock .seconds {
        font-size: 1rem;
    }

    .stat-number {
        font-size: 1.8rem;
    }

    .stat-icon-container {
        width: 50px;
        height: 50px;
        font-size: 1.5rem;
    }
    
    .btn-action-modern {
        padding: 0.5rem;
    }
    
    .btn-action-modern .action-icon {
        font-size: 1.2rem;
    }
    
    .btn-action-modern .action-text {
        font-size: 0.7rem;
    }
}

/* Color Utilities */
.text-primary { color: #3498db !important; }
.text-success { color: #27ae60 !important; }
.text-warning { color: #f39c12 !important; }
.text-info { color: #17a2b8 !important; }
.text-danger { color: #e74c3c !important; }
.text-secondary { color: #6c757d !important; }

/* Background Color Utilities */
.bg-primary { background-color: #3498db !important; }
.bg-success { background-color: #27ae60 !important; }
.bg-warning { background-color: #f39c12 !important; }
.bg-info { background-color: #17a2b8 !important; }
.bg-danger { background-color: #e74c3c !important; }
.bg-secondary { background-color: #6c757d !important; }

/* Flex Utilities */
.d-flex { display: flex !important; }
.flex-column { flex-direction: column !important; }
.justify-content-between { justify-content: space-between !important; }
.justify-content-center { justify-content: center !important; }
.align-items-center { align-items: center !important; }
.align-items-start { align-items: flex-start !important; }
.flex-grow-1 { flex-grow: 1 !important; }

/* Margin & Padding Utilities */
.mb-0 { margin-bottom: 0 !important; }
.mb-1 { margin-bottom: 0.25rem !important; }
.mb-2 { margin-bottom: 0.5rem !important; }
.mb-3 { margin-bottom: 1rem !important; }
.mb-4 { margin-bottom: 1.5rem !important; }
.mb-5 { margin-bottom: 3rem !important; }

.mt-0 { margin-top: 0 !important; }
.mt-1 { margin-top: 0.25rem !important; }
.mt-2 { margin-top: 0.5rem !important; }
.mt-3 { margin-top: 1rem !important; }
.mt-4 { margin-top: 1.5rem !important; }
.mt-5 { margin-top: 3rem !important; }

.me-1 { margin-right: 0.25rem !important; }
.me-2 { margin-right: 0.5rem !important; }
.me-3 { margin-right: 1rem !important; }
.me-4 { margin-right: 1.5rem !important; }
.me-5 { margin-right: 3rem !important; }

.ms-1 { margin-left: 0.25rem !important; }
.ms-2 { margin-left: 0.5rem !important; }
.ms-3 { margin-left: 1rem !important; }
.ms-4 { margin-left: 1.5rem !important; }
.ms-5 { margin-left: 3rem !important; }

.p-0 { padding: 0 !important; }
.p-1 { padding: 0.25rem !important; }
.p-2 { padding: 0.5rem !important; }
.p-3 { padding: 1rem !important; }
.p-4 { padding: 1.5rem !important; }
.p-5 { padding: 3rem !important; }

.py-4 { padding-top: 1.5rem !important; padding-bottom: 1.5rem !important; }

/* Grid System */
.row {
    display: flex;
    flex-wrap: wrap;
    margin-right: -0.75rem;
    margin-left: -0.75rem;
}

.row.g-3 {
    margin-right: -0.75rem;
    margin-left: -0.75rem;
}

.row.g-3 > * {
    padding-right: 0.75rem;
    padding-left: 0.75rem;
}

.col {
    flex: 1 0 0%;
}

.col-1 { flex: 0 0 auto; width: 8.33333333%; }
.col-2 { flex: 0 0 auto; width: 16.66666667%; }
.col-3 { flex: 0 0 auto; width: 25%; }
.col-4 { flex: 0 0 auto; width: 33.33333333%; }
.col-5 { flex: 0 0 auto; width: 41.66666667%; }
.col-6 { flex: 0 0 auto; width: 50%; }
.col-7 { flex: 0 0 auto; width: 58.33333333%; }
.col-8 { flex: 0 0 auto; width: 66.66666667%; }
.col-9 { flex: 0 0 auto; width: 75%; }
.col-10 { flex: 0 0 auto; width: 83.33333333%; }
.col-11 { flex: 0 0 auto; width: 91.66666667%; }
.col-12 { flex: 0 0 auto; width: 100%; }

/* Responsive columns */
@media (min-width: 576px) {
    .col-sm-6 { flex: 0 0 auto; width: 50%; }
    .col-sm-12 { flex: 0 0 auto; width: 100%; }
}

@media (min-width: 768px) {
    .col-md-4 { flex: 0 0 auto; width: 33.33333333%; }
    .col-md-6 { flex: 0 0 auto; width: 50%; }
    .col-md-8 { flex: 0 0 auto; width: 66.66666667%; }
    .col-md-12 { flex: 0 0 auto; width: 100%; }
}

@media (min-width: 992px) {
    .col-lg-4 { flex: 0 0 auto; width: 33.33333333%; }
    .col-lg-5 { flex: 0 0 auto; width: 41.66666667%; }
    .col-lg-6 { flex: 0 0 auto; width: 50%; }
    .col-lg-7 { flex: 0 0 auto; width: 58.33333333%; }
    .col-lg-8 { flex: 0 0 auto; width: 66.66666667%; }
}

@media (min-width: 1200px) {
    .col-xl-2 { flex: 0 0 auto; width: 16.66666667%; }
    .col-xl-3 { flex: 0 0 auto; width: 25%; }
    .col-xl-4 { flex: 0 0 auto; width: 33.33333333%; }
    .col-xl-6 { flex: 0 0 auto; width: 50%; }
    .col-xl-8 { flex: 0 0 auto; width: 66.66666667%; }
}

/* Font Awesome icon sizes */
.fa-lg { font-size: 1.33333em; }
.fa-3x { font-size: 3em; }

/* Utility Classes */
.fw-medium { font-weight: 500; }
.fw-bold { font-weight: 700; }
.fw-600 { font-weight: 600; }
.fw-800 { font-weight: 800; }

/* Custom Variables */
:root {
    --dark-bg: #222831;
    --dark-secondary: #393E46;
    --accent-cyan: #00ADB5;
    --light-gray: #EEEEEE;
}
</style>
@endpush

@section('content')
<div class="main-content">
    <!-- Dashboard Header -->
    <div class="dashboard-header animate-fade-in-up">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2><i class="fas fa-tachometer-alt me-2"></i>Dashboard Admin</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item active"><i class="fas fa-home me-1"></i> Dashboard</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-6">
                <div class="real-time-clock">
                    <div class="date-display" id="currentDate">
                        {{ now()->isoFormat('dddd, D MMMM Y') }}
                    </div>
                    <div class="time-display">
                        <span id="currentTime">{{ now()->format('H:i') }}</span>
                        <span class="seconds" id="currentSeconds">:{{ now()->format('s') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Utama -->
    <div class="row mb-4">
        <!-- Total Warga -->
        <div class="col-xl-3 col-lg-4 col-md-6 mb-3 animate-fade-in-up delay-1">
            <div class="stat-card-modern stat-card-user">
                <div class="card-body">
                    <div class="stat-info">
                        <h3 class="stat-number" id="totalUsers">{{ $stats['total_users'] ?? 0 }}</h3>
                        <p class="stat-label">Total Warga Aktif</p>
                        @if(isset($stats['users_change_percent']))
                        <div class="stat-change {{ ($stats['users_change_percent'] ?? 0) >= 0 ? 'positive' : 'negative' }}">
                            <i class="fas fa-arrow-{{ ($stats['users_change_percent'] ?? 0) >= 0 ? 'up' : 'down' }}"></i>
                            <span>{{ number_format(abs($stats['users_change_percent'] ?? 0), 1) }}%</span>
                        </div>
                        @endif
                    </div>
                    <div class="stat-icon-container">
                        <i class="fas fa-user-friends"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Kader -->
        <div class="col-xl-3 col-lg-4 col-md-6 mb-3 animate-fade-in-up delay-2">
            <div class="stat-card-modern stat-card-kader">
                <div class="card-body">
                    <div class="stat-info">
                        <h3 class="stat-number" id="totalKaders">{{ $stats['total_kaders'] ?? 0 }}</h3>
                        <p class="stat-label">Total Kader Aktif</p>
                        @if(isset($stats['kaders_change_percent']))
                        <div class="stat-change {{ ($stats['kaders_change_percent'] ?? 0) >= 0 ? 'positive' : 'negative' }}">
                            <i class="fas fa-arrow-{{ ($stats['kaders_change_percent'] ?? 0) >= 0 ? 'up' : 'down' }}"></i>
                            <span>{{ number_format(abs($stats['kaders_change_percent'] ?? 0), 1) }}%</span>
                        </div>
                        @endif
                    </div>
                    <div class="stat-icon-container">
                        <i class="fas fa-user-nurse"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Bidan -->
        <div class="col-xl-3 col-lg-4 col-md-6 mb-3 animate-fade-in-up delay-3">
            <div class="stat-card-modern stat-card-bidan">
                <div class="card-body">
                    <div class="stat-info">
                        <h3 class="stat-number" id="totalBidans">{{ $stats['total_bidans'] ?? 0 }}</h3>
                        <p class="stat-label">Total Bidan Aktif</p>
                        @if(isset($stats['bidans_change_percent']))
                        <div class="stat-change {{ ($stats['bidans_change_percent'] ?? 0) >= 0 ? 'positive' : 'negative' }}">
                            <i class="fas fa-arrow-{{ ($stats['bidans_change_percent'] ?? 0) >= 0 ? 'up' : 'down' }}"></i>
                            <span>{{ number_format(abs($stats['bidans_change_percent'] ?? 0), 1) }}%</span>
                        </div>
                        @endif
                    </div>
                    <div class="stat-icon-container">
                        <i class="fas fa-user-md"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Pasien -->
        <div class="col-xl-3 col-lg-4 col-md-6 mb-3 animate-fade-in-up delay-4">
            <div class="stat-card-modern stat-card-balita">
                <div class="card-body">
                    <div class="stat-info">
                        <h3 class="stat-number" id="totalPatients">
                            {{ (($stats['total_balita'] ?? 0) + ($stats['total_remaja'] ?? 0) + ($stats['total_lansia'] ?? 0)) }}
                        </h3>
                        <p class="stat-label">Total Pasien</p>
                        <div class="stat-change info">
                            <i class="fas fa-chart-line"></i>
                            <span>Balita: {{ $stats['total_balita'] ?? 0 }}</span>
                        </div>
                    </div>
                    <div class="stat-icon-container">
                        <i class="fas fa-procedures"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Detail -->
    <div class="row mb-4">
        <!-- Balita -->
        <div class="col-xl-2 col-lg-4 col-md-6 mb-3 animate-fade-in-up delay-5">
            <div class="stat-card-modern stat-card-balita">
                <div class="card-body">
                    <div class="stat-info">
                        <h3 class="stat-number">{{ $stats['total_balita'] ?? 0 }}</h3>
                        <p class="stat-label">Balita</p>
                    </div>
                    <div class="stat-icon-container">
                        <i class="fas fa-baby"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Remaja -->
        <div class="col-xl-2 col-lg-4 col-md-6 mb-3 animate-fade-in-up delay-6">
            <div class="stat-card-modern stat-card-remaja">
                <div class="card-body">
                    <div class="stat-info">
                        <h3 class="stat-number">{{ $stats['total_remaja'] ?? 0 }}</h3>
                        <p class="stat-label">Remaja</p>
                    </div>
                    <div class="stat-icon-container">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lansia -->
        <div class="col-xl-2 col-lg-4 col-md-6 mb-3 animate-fade-in-up delay-7">
            <div class="stat-card-modern stat-card-lansia">
                <div class="card-body">
                    <div class="stat-info">
                        <h3 class="stat-number">{{ $stats['total_lansia'] ?? 0 }}</h3>
                        <p class="stat-label">Lansia</p>
                    </div>
                    <div class="stat-icon-container">
                        <i class="fas fa-user-tie"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aktif -->
        <div class="col-xl-3 col-lg-6 col-md-6 mb-3 animate-fade-in-up delay-8">
            <div class="stat-card-modern stat-card-active">
                <div class="card-body">
                    <div class="stat-info">
                        @php
                            $totalAllUsers = ($stats['total_users'] ?? 0) + ($stats['total_kaders'] ?? 0) + ($stats['total_bidans'] ?? 0) + ($stats['total_admins'] ?? 0);
                            $activePercentage = $totalAllUsers > 0 ? (($stats['users_active'] ?? 0) / $totalAllUsers) * 100 : 0;
                        @endphp
                        <h3 class="stat-number">{{ $stats['users_active'] ?? 0 }}</h3>
                        <p class="stat-label">User Aktif</p>
                        @if($totalAllUsers > 0)
                        <div class="stat-change">
                            <i class="fas fa-percentage"></i>
                            <span>{{ number_format($activePercentage, 1) }}%</span>
                        </div>
                        @endif
                    </div>
                    <div class="stat-icon-container">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nonaktif -->
        <div class="col-xl-3 col-lg-6 col-md-6 mb-3 animate-fade-in-up delay-9">
            <div class="stat-card-modern stat-card-inactive">
                <div class="card-body">
                    <div class="stat-info">
                        <h3 class="stat-number">{{ $stats['users_inactive'] ?? 0 }}</h3>
                        <p class="stat-label">User Nonaktif</p>
                    </div>
                    <div class="stat-icon-container">
                        <i class="fas fa-times-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Hari Ini -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="quick-actions-modern animate-fade-in-up delay-5">
                <div class="card-header">
                    <h5><i class="fas fa-calendar-day me-2"></i>Statistik Hari Ini</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
                            <div class="text-center">
                                <h3 class="text-primary">{{ $stats['login_today'] ?? 0 }}</h3>
                                <p class="text-muted mb-0">Login</p>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
                            <div class="text-center">
                                <h3 class="text-success">{{ $todayActivities['new_users_today'] ?? 0 }}</h3>
                                <p class="text-muted mb-0">User Baru</p>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
                            <div class="text-center">
                                <h3 class="text-warning">{{ $todayActivities['kunjungan_today'] ?? 0 }}</h3>
                                <p class="text-muted mb-0">Kunjungan</p>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
                            <div class="text-center">
                                <h3 class="text-info">{{ $todayActivities['pemeriksaan_today'] ?? 0 }}</h3>
                                <p class="text-muted mb-0">Pemeriksaan</p>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
                            <div class="text-center">
                                <h3 class="text-danger">{{ $todayActivities['imunisasi_today'] ?? 0 }}</h3>
                                <p class="text-muted mb-0">Imunisasi</p>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
                            <div class="text-center">
                                <h3 class="text-secondary">{{ $stats['new_users_month'] ?? 0 }}</h3>
                                <p class="text-muted mb-0">User Bulan Ini</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions dan System Status -->
    <div class="row mb-4">
        <!-- Quick Actions -->
        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="quick-actions-modern animate-fade-in-up delay-5">
                <div class="card-header">
                    <h5><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-action-modern btn-user">
                                <i class="fas fa-user-plus action-icon"></i>
                                <span class="action-text">Tambah Warga</span>
                            </a>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                            <a href="{{ route('admin.kaders.create') }}" class="btn btn-action-modern btn-kader">
                                <i class="fas fa-user-nurse action-icon"></i>
                                <span class="action-text">Tambah Kader</span>
                            </a>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                            <a href="{{ route('admin.bidans.create') }}" class="btn btn-action-modern btn-bidan">
                                <i class="fas fa-user-md action-icon"></i>
                                <span class="action-text">Tambah Bidan</span>
                            </a>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                            <a href="{{ route('admin.pasien.balita.create') }}" class="btn btn-action-modern btn-pasien">
                                <i class="fas fa-baby action-icon"></i>
                                <span class="action-text">Tambah Pasien</span>
                            </a>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                            <a href="{{ route('admin.settings.index') }}" class="btn btn-action-modern btn-setting">
                                <i class="fas fa-cog action-icon"></i>
                                <span class="action-text">Pengaturan</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Status -->
        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="status-card animate-fade-in-up delay-6">
                <h5><i class="fas fa-server me-2"></i>Status Sistem</h5>
                
                @php
                    $totalAllUsers = ($stats['total_users'] ?? 0) + ($stats['total_kaders'] ?? 0) + 
                                   ($stats['total_bidans'] ?? 0) + ($stats['total_admins'] ?? 0);
                    $totalInactive = $stats['users_inactive'] ?? 0;
                    $totalActive = $stats['users_active'] ?? 0;
                    $totalPatients = ($stats['total_balita'] ?? 0) + ($stats['total_remaja'] ?? 0) + ($stats['total_lansia'] ?? 0);
                @endphp
                
                <div class="status-item">
                    <span class="status-label">Total User</span>
                    <span class="status-value">{{ $totalAllUsers }}</span>
                </div>
                
                <div class="status-item">
                    <span class="status-label">User Aktif</span>
                    <span class="status-value">{{ $totalActive }} / {{ $totalAllUsers }}</span>
                </div>
                
                <div class="status-item">
                    <span class="status-label">User Baru Bulan Ini</span>
                    <span class="status-value">{{ $stats['new_users_month'] ?? 0 }}</span>
                </div>
                
                <div class="status-item">
                    <span class="status-label">Database</span>
                    <span class="status-badge status-good">Online</span>
                </div>
                
                <div class="status-item">
                    <span class="status-label">Server Status</span>
                    <span class="status-badge status-good">Normal</span>
                </div>
                
                <div class="status-item">
                    <span class="status-label">Total Data Pasien</span>
                    <span class="status-value">{{ $totalPatients }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity dan Chart -->
    <div class="row">
        <!-- Recent Activity - User Baru -->
        <div class="col-xl-6 mb-4">
            <div class="activity-timeline animate-fade-in-up delay-7">
                <div class="card-header">
                    <h5><i class="fas fa-user-plus me-2"></i>User Baru (7 Hari Terakhir)</h5>
                </div>
                <div class="card-body p-0">
                    @if(isset($recentActivities['new_users']) && $recentActivities['new_users']->count() > 0)
                        <ul class="timeline">
                            @foreach($recentActivities['new_users'] as $user)
                                @php
                                    $timelineClass = 'timeline-user';
                                    $roleText = 'Warga';
                                    $roleIcon = 'fas fa-user-circle';
                                    $badgeColor = 'primary';
                                    
                                    if($user->role == 'kader') {
                                        $timelineClass = 'timeline-kader';
                                        $roleText = 'Kader';
                                        $roleIcon = 'fas fa-user-nurse';
                                        $badgeColor = 'warning';
                                    } elseif($user->role == 'bidan') {
                                        $timelineClass = 'timeline-bidan';
                                        $roleText = 'Bidan';
                                        $roleIcon = 'fas fa-user-md';
                                        $badgeColor = 'success';
                                    } elseif($user->role == 'admin') {
                                        $timelineClass = 'timeline-admin';
                                        $roleText = 'Admin';
                                        $roleIcon = 'fas fa-user-shield';
                                        $badgeColor = 'danger';
                                    }
                                @endphp
                                <li class="timeline-item {{ $timelineClass }}">
                                    <div class="timeline-content">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <i class="{{ $roleIcon }} fa-lg"></i>
                                            </div>
                                            <div>
                                                <p class="timeline-title mb-1">
                                                    <strong>{{ $user->profile->full_name ?? 'User Baru' }}</strong>
                                                    <small class="ms-2 badge bg-{{ $badgeColor }}">
                                                        {{ $roleText }}
                                                    </small>
                                                </p>
                                                <p class="timeline-time mb-0">
                                                    <i class="far fa-clock me-1"></i>
                                                    {{ $user->created_at->diffForHumans() }}
                                                    <span class="ms-2">{{ $user->created_at->format('H:i') }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-user-plus fa-3x mb-3 text-muted"></i>
                            <p class="text-muted mb-0">Tidak ada user baru dalam 7 hari terakhir</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Chart -->
        <div class="col-xl-6 mb-4">
            <div class="chart-container-modern animate-fade-in-up delay-8">
                <div class="card-header">
                    <h5><i class="fas fa-chart-line me-2"></i>Statistik 6 Bulan Terakhir</h5>
                </div>
                <div class="chart-wrapper">
                    <canvas id="dashboardChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Login Activity -->
    <div class="row mb-4">
        <div class="col-xl-6 mb-4">
            <div class="activity-timeline animate-fade-in-up delay-9">
                <div class="card-header">
                    <h5><i class="fas fa-sign-in-alt me-2"></i>Login Terakhir</h5>
                </div>
                <div class="card-body p-0">
                    @if(isset($recentActivities['recent_logins']) && $recentActivities['recent_logins']->count() > 0)
                        <ul class="timeline">
                            @foreach($recentActivities['recent_logins'] as $login)
                                @php
                                    $timelineClass = 'timeline-user';
                                    $roleText = 'Warga';
                                    $roleIcon = 'fas fa-user-circle';
                                    $badgeColor = 'primary';
                                    
                                    if($login->user->role == 'kader') {
                                        $timelineClass = 'timeline-kader';
                                        $roleText = 'Kader';
                                        $roleIcon = 'fas fa-user-nurse';
                                        $badgeColor = 'warning';
                                    } elseif($login->user->role == 'bidan') {
                                        $timelineClass = 'timeline-bidan';
                                        $roleText = 'Bidan';
                                        $roleIcon = 'fas fa-user-md';
                                        $badgeColor = 'success';
                                    } elseif($login->user->role == 'admin') {
                                        $timelineClass = 'timeline-admin';
                                        $roleText = 'Admin';
                                        $roleIcon = 'fas fa-user-shield';
                                        $badgeColor = 'danger';
                                    }
                                @endphp
                                <li class="timeline-item {{ $timelineClass }}">
                                    <div class="timeline-content">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <i class="{{ $roleIcon }} fa-lg"></i>
                                            </div>
                                            <div>
                                                <p class="timeline-title mb-1">
                                                    <strong>{{ $login->user->profile->full_name ?? 'User' }}</strong>
                                                    <small class="ms-2 badge bg-{{ $badgeColor }}">
                                                        {{ $roleText }}
                                                    </small>
                                                </p>
                                                <p class="timeline-time mb-0">
                                                    <i class="far fa-clock me-1"></i>
                                                    {{ $login->login_at->diffForHumans() }}
                                                    <span class="ms-2">{{ $login->login_at->format('H:i:s') }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-sign-in-alt fa-3x mb-3 text-muted"></i>
                            <p class="text-muted mb-0">Tidak ada riwayat login</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Top Active Users -->
        <div class="col-xl-6 mb-4">
            <div class="status-card animate-fade-in-up delay-10">
                <h5><i class="fas fa-chart-bar me-2"></i>Top 5 User Aktif (30 Hari)</h5>
                
                @if(isset($topActiveUsers) && $topActiveUsers->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($topActiveUsers as $index => $user)
                        @php
                            $badgeColor = 'secondary';
                            if($index < 1) $badgeColor = 'primary';
                            elseif($index < 3) $badgeColor = 'info';
                            
                            $roleColor = 'primary';
                            if($user->user->role == 'kader') $roleColor = 'warning';
                            elseif($user->user->role == 'bidan') $roleColor = 'success';
                            elseif($user->user->role == 'admin') $roleColor = 'danger';
                        @endphp
                        <div class="list-group-item d-flex align-items-center">
                            <div class="me-3">
                                <span class="badge bg-{{ $badgeColor }} rounded-circle p-2">
                                    {{ $index + 1 }}
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <span class="fw-medium">{{ $user->user->profile->full_name ?? 'User' }}</span>
                                    <span class="badge bg-{{ $roleColor }}">
                                        {{ $user->user->role }}
                                    </span>
                                </div>
                                <small class="text-muted">{{ $user->login_count }} login</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-users fa-3x mb-3 text-muted"></i>
                        <p class="text-muted mb-0">Tidak ada data user aktif</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Real-time Clock
    function updateRealTimeClock() {
        const now = new Date();
        
        // Format date
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        const dayName = days[now.getDay()];
        const date = now.getDate();
        const monthName = months[now.getMonth()];
        const year = now.getFullYear();
        
        document.getElementById('currentDate').textContent = 
            `${dayName}, ${date} ${monthName} ${year}`;
        
        // Format time
        const hours = now.getHours().toString().padStart(2, '0');
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const seconds = now.getSeconds().toString().padStart(2, '0');
        
        document.getElementById('currentTime').textContent = `${hours}:${minutes}`;
        document.getElementById('currentSeconds').textContent = `:${seconds}`;
    }

    // Update clock every second
    setInterval(updateRealTimeClock, 1000);
    updateRealTimeClock();

    // Dashboard Chart
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('dashboardChart').getContext('2d');
        
        const months = @json($months ?? []);
        const userData = @json($userData ?? []);
        const kunjunganData = @json($kunjunganData ?? []);
        const pemeriksaanData = @json($pemeriksaanData ?? []);
        
        const dashboardChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [
                    {
                        label: 'User Baru',
                        data: userData,
                        backgroundColor: 'rgba(52, 152, 219, 0.7)',
                        borderColor: 'rgba(52, 152, 219, 1)',
                        borderWidth: 1,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Kunjungan',
                        data: kunjunganData,
                        backgroundColor: 'rgba(243, 156, 18, 0.7)',
                        borderColor: 'rgba(243, 156, 18, 1)',
                        borderWidth: 1,
                        yAxisID: 'y1'
                    },
                    {
                        label: 'Pemeriksaan',
                        data: pemeriksaanData,
                        backgroundColor: 'rgba(39, 174, 96, 0.7)',
                        borderColor: 'rgba(39, 174, 96, 1)',
                        borderWidth: 1,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'User Baru'
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Kunjungan & Pemeriksaan'
                        },
                        grid: {
                            drawOnChartArea: false
                        }
                    }
                }
            }
        });
        
        // Animate stats on page load
        animateStats();
        
        // Auto-refresh stats every 30 seconds
        setInterval(refreshStats, 30000);
    });
    
    function animateStats() {
        const statElements = document.querySelectorAll('.stat-number');
        statElements.forEach(element => {
            const targetValue = parseInt(element.textContent);
            if (!isNaN(targetValue) && targetValue > 0) {
                animateCounter(element, targetValue);
            }
        });
    }
    
    function animateCounter(element, targetValue) {
        let currentValue = 0;
        const increment = Math.ceil(targetValue / 50);
        const interval = setInterval(() => {
            currentValue += increment;
            if (currentValue >= targetValue) {
                element.textContent = targetValue;
                clearInterval(interval);
            } else {
                element.textContent = currentValue;
            }
        }, 30);
    }
    
    function refreshStats() {
        fetch('{{ route("admin.dashboard") }}/stats?refresh=true')
            .then(response => response.json())
            .then(data => {
                // Update visible stats
                updateStat('totalUsers', data.total_users);
                updateStat('totalKaders', data.total_kaders);
                updateStat('totalBidans', data.total_bidans);
                updateStat('loginToday', data.login_today);
            })
            .catch(error => console.error('Error refreshing stats:', error));
    }
    
    function updateStat(elementId, newValue) {
        const element = document.getElementById(elementId);
        if (element) {
            const currentValue = parseInt(element.textContent);
            if (currentValue !== newValue) {
                animateCounter(element, newValue);
            }
        }
    }
</script>
@endpush