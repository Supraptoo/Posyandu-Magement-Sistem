@extends('layouts.app')

@section('title', 'Pengaturan Sistem')

@push('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 15px rgba(155, 89, 182, 0.3);
    }

    .settings-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .settings-card .card-header {
        background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%);
        color: white;
        border: none;
        padding: 1.25rem 1.5rem;
    }

    .settings-card .card-header h5 {
        margin: 0;
        font-weight: 600;
    }

    .settings-tabs {
        border-bottom: 1px solid #e9ecef;
        padding: 0 1.5rem;
        margin: 0;
        list-style: none;
        display: flex;
        overflow-x: auto;
    }

    .settings-tabs .nav-link {
        border: none;
        border-bottom: 3px solid transparent;
        padding: 1rem 1.5rem;
        color: #6c757d;
        font-weight: 500;
        white-space: nowrap;
        transition: all 0.3s ease;
    }

    .settings-tabs .nav-link:hover {
        color: #9b59b6;
    }

    .settings-tabs .nav-link.active {
        color: #9b59b6;
        border-bottom-color: #9b59b6;
        background: transparent;
    }

    .settings-content {
        padding: 2rem;
    }

    .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .form-control-custom, .form-select-custom {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control-custom:focus, .form-select-custom:focus {
        border-color: #9b59b6;
        box-shadow: 0 0 0 0.2rem rgba(155, 89, 182, 0.25);
    }

    .setting-item {
        padding: 1.5rem;
        border-bottom: 1px solid #f1f1f1;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .setting-item:last-child {
        border-bottom: none;
    }

    .setting-info {
        flex: 1;
    }

    .setting-title {
        font-weight: 600;
        margin: 0 0 0.25rem 0;
        color: #2c3e50;
    }

    .setting-description {
        margin: 0;
        font-size: 0.875rem;
        color: #6c757d;
    }

    .setting-action {
        margin-left: 1rem;
    }

    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }

    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked + .toggle-slider {
        background-color: #9b59b6;
    }

    input:checked + .toggle-slider:before {
        transform: translateX(26px);
    }

    .btn-save {
        background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%);
        border: none;
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(155, 89, 182, 0.3);
    }

    .btn-cancel {
        background: white;
        border: 2px solid #dee2e6;
        color: #6c757d;
        padding: 0.75rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        background: #f8f9fa;
        border-color: #adb5bd;
    }

    .system-info {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px solid #e9ecef;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 500;
        color: #6c757d;
    }

    .info-value {
        font-weight: 600;
        color: #2c3e50;
    }

    .danger-zone {
        background: #f8d7da;
        border: 1px solid #f5c6cb;
        border-radius: 10px;
        padding: 1.5rem;
        margin-top: 2rem;
    }

    .danger-zone h6 {
        color: #721c24;
        margin-bottom: 1rem;
    }

    .btn-danger-zone {
        background: #dc3545;
        border: none;
        color: white;
        padding: 0.5rem 1.5rem;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-danger-zone:hover {
        background: #c82333;
        transform: translateY(-2px);
    }

    /* Tab Content Animation */
    .tab-pane {
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @media (max-width: 768px) {
        .settings-tabs {
            flex-direction: column;
        }
        
        .settings-tabs .nav-link {
            border-bottom: none;
            border-left: 3px solid transparent;
            padding: 0.75rem 1rem;
        }
        
        .settings-tabs .nav-link.active {
            border-left-color: #9b59b6;
            border-bottom-color: transparent;
        }
        
        .setting-item {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .setting-action {
            margin-left: 0;
            margin-top: 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="main-content">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h2><i class="fas fa-cog me-2"></i>Pengaturan Sistem</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Pengaturan</li>
                    </ol>
                </nav>
            </div>
            <div class="mt-3 mt-md-0">
                <button type="submit" form="settingsForm" class="btn btn-light">
                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                </button>
            </div>
        </div>
    </div>

    <!-- Settings Card -->
    <div class="settings-card">
        <div class="card-header">
            <h5><i class="fas fa-sliders-h me-2"></i>Konfigurasi Sistem</h5>
        </div>
        
        <!-- Settings Tabs -->
        <ul class="settings-tabs nav nav-tabs" id="settingsTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button">
                    <i class="fas fa-home me-2"></i>Umum
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="email-tab" data-bs-toggle="tab" data-bs-target="#email" type="button">
                    <i class="fas fa-envelope me-2"></i>Email
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button">
                    <i class="fas fa-shield-alt me-2"></i>Keamanan
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="notification-tab" data-bs-toggle="tab" data-bs-target="#notification" type="button">
                    <i class="fas fa-bell me-2"></i>Notifikasi
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="backup-tab" data-bs-toggle="tab" data-bs-target="#backup" type="button">
                    <i class="fas fa-database me-2"></i>Backup
                </button>
            </li>
        </ul>
        
        <!-- Settings Form -->
        <form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="mb-3">
        <label for="nama_posyandu" class="form-label">Nama Posyandu</label>
        <input type="text" class="form-control @error('nama_posyandu') is-invalid @enderror" 
               id="nama_posyandu" name="nama_posyandu" 
               value="{{ old('nama_posyandu', $settings['nama_posyandu'] ?? '') }}" required>
        @error('nama_posyandu')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="alamat_posyandu" class="form-label">Alamat Posyandu</label>
        <textarea class="form-control @error('alamat_posyandu') is-invalid @enderror" 
                  id="alamat_posyandu" name="alamat_posyandu" rows="3" required>{{ old('alamat_posyandu', $settings['alamat_posyandu'] ?? '') }}</textarea>
        @error('alamat_posyandu')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="telepon_posyandu" class="form-label">Telepon</label>
        <input type="text" class="form-control @error('telepon_posyandu') is-invalid @enderror" 
               id="telepon_posyandu" name="telepon_posyandu" 
               value="{{ old('telepon_posyandu', $settings['telepon_posyandu'] ?? '') }}" required>
        @error('telepon_posyandu')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email_posyandu" class="form-label">Email</label>
        <input type="email" class="form-control @error('email_posyandu') is-invalid @enderror" 
               id="email_posyandu" name="email_posyandu" 
               value="{{ old('email_posyandu', $settings['email_posyandu'] ?? '') }}" required>
        @error('email_posyandu')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="kepala_posyandu" class="form-label">Kepala Posyandu</label>
        <input type="text" class="form-control @error('kepala_posyandu') is-invalid @enderror" 
               id="kepala_posyandu" name="kepala_posyandu" 
               value="{{ old('kepala_posyandu', $settings['kepala_posyandu'] ?? '') }}" required>
        @error('kepala_posyandu')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="jam_operasional" class="form-label">Jam Operasional</label>
        <input type="text" class="form-control @error('jam_operasional') is-invalid @enderror" 
               id="jam_operasional" name="jam_operasional" 
               value="{{ old('jam_operasional', $settings['jam_operasional'] ?? '') }}" 
               placeholder="Senin-Jumat: 08:00-15:00" required>
        @error('jam_operasional')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Simpan Perubahan
        </button>
    </div>
</form>
        <form id="settingsForm" action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="tab-content" id="settingsTabContent">
                <!-- General Settings -->
                <div class="tab-pane fade show active" id="general" role="tabpanel">
                    <div class="settings-content">
                        <h6 class="mb-3" style="color: #9b59b6;">
                            <i class="fas fa-info-circle me-2"></i>Informasi Umum
                        </h6>
                        
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Posyandu</label>
                                <input type="text" 
                                       name="nama_posyandu" 
                                       class="form-control form-control-custom" 
                                       value="{{ $settings['nama_posyandu'] ?? 'Posyandu Sejahtera' }}"
                                       required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email Posyandu</label>
                                <input type="email" 
                                       name="email_posyandu" 
                                       class="form-control form-control-custom" 
                                       value="{{ $settings['email_posyandu'] ?? 'posyandu@example.com' }}"
                                       required>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Telepon Posyandu</label>
                                <input type="text" 
                                       name="telepon_posyandu" 
                                       class="form-control form-control-custom" 
                                       value="{{ $settings['telepon_posyandu'] ?? '081234567890' }}"
                                       required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kepala Posyandu</label>
                                <input type="text" 
                                       name="kepala_posyandu" 
                                       class="form-control form-control-custom" 
                                       value="{{ $settings['kepala_posyandu'] ?? 'Nama Kepala Posyandu' }}"
                                       required>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Alamat Posyandu</label>
                            <textarea name="alamat_posyandu" 
                                      class="form-control form-control-custom" 
                                      rows="3"
                                      required>{{ $settings['alamat_posyandu'] ?? 'Jl. Contoh No. 123, Kota Contoh' }}</textarea>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Jam Operasional</label>
                            <input type="text" 
                                   name="jam_operasional" 
                                   class="form-control form-control-custom" 
                                   value="{{ $settings['jam_operasional'] ?? 'Senin - Jumat: 08:00 - 14:00' }}"
                                   required>
                        </div>
                        
                        <!-- System Information -->
                        <div class="system-info">
                            <h6 class="mb-3">Informasi Sistem</h6>
                            <div class="info-item">
                                <span class="info-label">Versi Aplikasi</span>
                                <span class="info-value">v1.0.0</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Framework</span>
                                <span class="info-value">Laravel {{ app()->version() }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">PHP Version</span>
                                <span class="info-value">{{ PHP_VERSION }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Server Time</span>
                                <span class="info-value">{{ now()->format('Y-m-d H:i:s') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Email Settings -->
                <div class="tab-pane fade" id="email" role="tabpanel">
                    <div class="settings-content">
                        <h6 class="mb-3" style="color: #9b59b6;">
                            <i class="fas fa-envelope me-2"></i>Konfigurasi Email
                        </h6>
                        
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Mail Host</label>
                                <input type="text" 
                                       name="mail_host" 
                                       class="form-control form-control-custom" 
                                       value="{{ $settings['mail_host'] ?? 'smtp.gmail.com' }}">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Mail Port</label>
                                <input type="number" 
                                       name="mail_port" 
                                       class="form-control form-control-custom" 
                                       value="{{ $settings['mail_port'] ?? '587' }}">
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Mail Username</label>
                                <input type="email" 
                                       name="mail_username" 
                                       class="form-control form-control-custom" 
                                       value="{{ $settings['mail_username'] ?? '' }}">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Mail Encryption</label>
                                <select name="mail_encryption" class="form-select form-select-custom">
                                    <option value="tls" {{ ($settings['mail_encryption'] ?? 'tls') == 'tls' ? 'selected' : '' }}>TLS</option>
                                    <option value="ssl" {{ ($settings['mail_encryption'] ?? '') == 'ssl' ? 'selected' : '' }}>SSL</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Informasi:</strong> Konfigurasi email digunakan untuk mengirim notifikasi dan reset password.
                        </div>
                    </div>
                </div>
                
                <!-- Security Settings -->
                <div class="tab-pane fade" id="security" role="tabpanel">
                    <div class="settings-content">
                        <h6 class="mb-3" style="color: #9b59b6;">
                            <i class="fas fa-shield-alt me-2"></i>Pengaturan Keamanan
                        </h6>
                        
                        <div class="setting-item">
                            <div class="setting-info">
                                <h6 class="setting-title">Login dengan NIK</h6>
                                <p class="setting-description">Warga dapat login menggunakan NIK sebagai username</p>
                            </div>
                            <div class="setting-action">
                                <label class="toggle-switch">
                                    <input type="checkbox" name="nik_login" 
                                           {{ ($settings['nik_login'] ?? '1') == '1' ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="setting-item">
                            <div class="setting-info">
                                <h6 class="setting-title">Reset Password Mandiri</h6>
                                <p class="setting-description">User dapat reset password melalui email</p>
                            </div>
                            <div class="setting-action">
                                <label class="toggle-switch">
                                    <input type="checkbox" name="self_reset_password" 
                                           {{ ($settings['self_reset_password'] ?? '1') == '1' ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="setting-item">
                            <div class="setting-info">
                                <h6 class="setting-title">Captcha pada Login</h6>
                                <p class="setting-description">Tambahkan captcha untuk mencegah brute force attack</p>
                            </div>
                            <div class="setting-action">
                                <label class="toggle-switch">
                                    <input type="checkbox" name="login_captcha" 
                                           {{ ($settings['login_captcha'] ?? '0') == '1' ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="setting-item">
                            <div class="setting-info">
                                <h6 class="setting-title">Log Aktivitas User</h6>
                                <p class="setting-description">Catat semua aktivitas login dan perubahan data</p>
                            </div>
                            <div class="setting-action">
                                <label class="toggle-switch">
                                    <input type="checkbox" name="activity_logging" 
                                           {{ ($settings['activity_logging'] ?? '1') == '1' ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sesi Login (menit)</label>
                                <input type="number" 
                                       name="session_lifetime" 
                                       class="form-control form-control-custom" 
                                       value="{{ $settings['session_lifetime'] ?? '120' }}"
                                       min="5" max="1440">
                                <small class="text-muted">Durasi sesi login dalam menit</small>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Max Login Attempts</label>
                                <input type="number" 
                                       name="max_login_attempts" 
                                       class="form-control form-control-custom" 
                                       value="{{ $settings['max_login_attempts'] ?? '5' }}"
                                       min="1" max="10">
                                <small class="text-muted">Maksimal percobaan login sebelum terkunci</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Notification Settings -->
                <div class="tab-pane fade" id="notification" role="tabpanel">
                    <div class="settings-content">
                        <h6 class="mb-3" style="color: #9b59b6;">
                            <i class="fas fa-bell me-2"></i>Pengaturan Notifikasi
                        </h6>
                        
                        <div class="setting-item">
                            <div class="setting-info">
                                <h6 class="setting-title">Notifikasi Email</h6>
                                <p class="setting-description">Kirim notifikasi melalui email</p>
                            </div>
                            <div class="setting-action">
                                <label class="toggle-switch">
                                    <input type="checkbox" name="email_notifications" 
                                           {{ ($settings['email_notifications'] ?? '1') == '1' ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="setting-item">
                            <div class="setting-info">
                                <h6 class="setting-title">Notifikasi Sistem</h6>
                                <p class="setting-description">Tampilkan notifikasi di dashboard</p>
                            </div>
                            <div class="setting-action">
                                <label class="toggle-switch">
                                    <input type="checkbox" name="system_notifications" 
                                           {{ ($settings['system_notifications'] ?? '1') == '1' ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="setting-item">
                            <div class="setting-info">
                                <h6 class="setting-title">Reminder Jadwal Imunisasi</h6>
                                <p class="setting-description">Kirim reminder jadwal imunisasi ke orang tua</p>
                            </div>
                            <div class="setting-action">
                                <label class="toggle-switch">
                                    <input type="checkbox" name="immunization_reminders" 
                                           {{ ($settings['immunization_reminders'] ?? '1') == '1' ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="setting-item">
                            <div class="setting-info">
                                <h6 class="setting-title">Notifikasi Registrasi Baru</h6>
                                <p class="setting-description">Kirim notifikasi saat ada user baru mendaftar</p>
                            </div>
                            <div class="setting-action">
                                <label class="toggle-switch">
                                    <input type="checkbox" name="new_registration_notifications" 
                                           {{ ($settings['new_registration_notifications'] ?? '1') == '1' ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Backup Settings -->
                <div class="tab-pane fade" id="backup" role="tabpanel">
                    <div class="settings-content">
                        <h6 class="mb-3" style="color: #9b59b6;">
                            <i class="fas fa-database me-2"></i>Backup & Pemulihan Data
                        </h6>
                        
                        <div class="setting-item">
                            <div class="setting-info">
                                <h6 class="setting-title">Backup Otomatis</h6>
                                <p class="setting-description">Lakukan backup database secara otomatis setiap hari</p>
                            </div>
                            <div class="setting-action">
                                <label class="toggle-switch">
                                    <input type="checkbox" name="auto_backup" 
                                           {{ ($settings['auto_backup'] ?? '0') == '1' ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Backup Time</label>
                                <input type="time" 
                                       name="backup_time" 
                                       class="form-control form-control-custom" 
                                       value="{{ $settings['backup_time'] ?? '02:00' }}">
                                <small class="text-muted">Waktu eksekusi backup otomatis</small>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Retensi Backup (hari)</label>
                                <input type="number" 
                                       name="backup_retention" 
                                       class="form-control form-control-custom" 
                                       value="{{ $settings['backup_retention'] ?? '30' }}"
                                       min="1" max="365">
                                <small class="text-muted">Lama penyimpanan backup file</small>
                            </div>
                        </div>
                        
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Peringatan:</strong> Pastikan untuk melakukan backup secara berkala untuk mencegah kehilangan data.
                        </div>
                        
                        <div class="d-flex gap-2 mt-4">
                            <button type="button" class="btn btn-primary" onclick="backupNow()">
                                <i class="fas fa-download me-2"></i>Backup Sekarang
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="restoreBackup()">
                                <i class="fas fa-upload me-2"></i>Restore Backup
                            </button>
                        </div>
                        
                        <!-- Danger Zone -->
                        <div class="danger-zone">
                            <h6><i class="fas fa-exclamation-triangle me-2"></i>Zona Berbahaya</h6>
                            <p class="text-muted small mb-3">Tindakan ini akan menghapus semua data. Gunakan dengan hati-hati!</p>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-danger-zone" onclick="clearAllData()">
                                    <i class="fas fa-trash me-2"></i>Hapus Semua Data
                                </button>
                                <button type="button" class="btn btn-danger-zone" onclick="resetSystem()">
                                    <i class="fas fa-redo me-2"></i>Reset Sistem
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Save Button -->
            <div class="card-footer bg-white border-top p-3">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.dashboard') }}" class="btn-cancel">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Initialize tabs
    document.addEventListener('DOMContentLoaded', function() {
        const triggerTabList = [].slice.call(document.querySelectorAll('#settingsTab button'));
        triggerTabList.forEach(function (triggerEl) {
            const tabTrigger = new bootstrap.Tab(triggerEl);
            triggerEl.addEventListener('click', function (event) {
                event.preventDefault();
                tabTrigger.show();
            });
        });
    });

    // Backup Functions
    function backupNow() {
        if (confirm('Lakukan backup database sekarang?')) {
            // Show loading
            Toast.fire({
                icon: 'info',
                title: 'Memulai backup...'
            });
            
            // Simulate backup process
            setTimeout(() => {
                Toast.fire({
                    icon: 'success',
                    title: 'Backup berhasil!'
                });
            }, 2000);
        }
    }

    function restoreBackup() {
        alert('Fitur restore backup akan segera tersedia');
    }

    function clearAllData() {
        if (confirm('PERINGATAN! Tindakan ini akan menghapus SEMUA data. Lanjutkan?')) {
            if (confirm('Apakah Anda YAKIN? Tindakan ini TIDAK DAPAT DIBATALKAN!')) {
                Toast.fire({
                    icon: 'warning',
                    title: 'Menghapus semua data...'
                });
            }
        }
    }

    function resetSystem() {
        if (confirm('Reset sistem ke pengaturan awal? Data user akan dipertahankan.')) {
            Toast.fire({
                icon: 'info',
                title: 'Mereset sistem...'
            });
        }
    }

    // Form submission
    document.getElementById('settingsForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Show loading
        Toast.fire({
            icon: 'info',
            title: 'Menyimpan perubahan...'
        });
        
        // Submit form
        this.submit();
    });
</script>
@endpush