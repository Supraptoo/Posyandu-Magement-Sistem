@extends('layouts.kader')

@section('title', 'Input Pemeriksaan')
@section('page-name', 'Input Pemeriksaan')

@push('styles')
<style>
    .animate-slide-up { opacity: 0; animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    
    .form-group { margin-bottom: 1.25rem; }
    .form-label { display: block; font-size: 0.70rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; }
    .form-input {
        width: 100%; background-color: #f8fafc; border: 2px solid #e2e8f0; color: #0f172a;
        font-size: 0.875rem; border-radius: 0.75rem; padding: 0.75rem 1rem;
        outline: none; transition: all 0.3s ease; font-weight: 600;
        box-shadow: inset 0 2px 4px 0 rgb(0 0 0 / 0.02);
    }
    .form-input:focus { background-color: #ffffff; border-color: #6366f1; box-shadow: 0 4px 12px -3px rgba(99, 102, 241, 0.15); transform: translateY(-1px); }
    .form-input::placeholder { color: #94a3b8; font-weight: 500; }
    
    /* Class ini akan diatur oleh JavaScript (Realtime) */
    .dynamic-field { display: none; } 
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto animate-slide-up">
    
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-indigo-100 text-indigo-600 mb-4 shadow-inner">
            <i class="fas fa-stethoscope text-3xl"></i>
        </div>
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Input Pemeriksaan</h1>
        <p class="text-slate-500 mt-2 font-medium text-sm max-w-lg mx-auto">Pengukuran antropometri *real-time* tanpa *refresh*. Kolom akan menyesuaikan kategori otomatis.</p>
    </div>

    <form action="{{ route('kader.pemeriksaan.store') }}" method="POST" id="formPemeriksaan">
        @csrf
        
        <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden flex flex-col mb-8">
            
            <div class="p-6 sm:p-10 border-b border-slate-100 bg-slate-50/50">
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-sm">1</span>
                    <h3 class="text-lg font-extrabold text-slate-800">Pilih Pasien</h3>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6">
                    <div class="form-group">
                        <label class="form-label">Kategori Pasien <span class="text-rose-500">*</span></label>
                        <select name="kategori_pasien" id="kategoriSelect" required class="form-input" onchange="updateFormRealtime()">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="balita">Balita</option>
                            <option value="remaja">Remaja</option>
                            <option value="lansia">Lansia</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Periksa <span class="text-rose-500">*</span></label>
                        <input type="date" name="tanggal_periksa" value="{{ date('Y-m-d') }}" required max="{{ date('Y-m-d') }}" class="form-input">
                    </div>
                </div>

                <div class="form-group mb-0">
                    <label class="form-label">Cari & Pilih Nama Pasien <span class="text-rose-500">*</span></label>
                    <select name="pasien_id" id="pasienSelect" required class="form-input bg-white disabled:opacity-50" disabled>
                        <option value="">-- Pilih kategori pasien di atas terlebih dahulu --</option>
                    </select>
                </div>
            </div>

            <div class="p-6 sm:p-10">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-full bg-teal-500 text-white flex items-center justify-center font-bold text-sm">2</span>
                        <h3 class="text-lg font-extrabold text-slate-800">Parameter Pengukuran</h3>
                    </div>
                    <span id="labelKategori" class="px-3 py-1 bg-slate-100 text-slate-500 text-[10px] font-black uppercase rounded-lg border border-slate-200 tracking-wider transition-all">Menunggu Kategori</span>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-4">
                    <div class="form-group mb-0">
                        <label class="form-label">Berat B. (kg) <span class="text-rose-500">*</span></label>
                        <input type="number" step="0.01" name="berat_badan" required placeholder="0.0" class="form-input text-center">
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Tinggi B. (cm) <span class="text-rose-500">*</span></label>
                        <input type="number" step="0.01" name="tinggi_badan" required placeholder="0.0" class="form-input text-center">
                    </div>
                    
                    <div class="form-group mb-0 dynamic-field" data-kategori="balita">
                        <label class="form-label">L. Kepala (cm)</label>
                        <input type="number" step="0.1" name="lingkar_kepala" placeholder="0.0" class="form-input text-center border-rose-200 focus:border-rose-500">
                    </div>

                    <div class="form-group mb-0 dynamic-field" data-kategori="balita,remaja">
                        <label class="form-label">L. Lengan / LILA</label>
                        <input type="number" step="0.1" name="lingkar_lengan" placeholder="cm" class="form-input text-center">
                    </div>

                    <div class="form-group mb-0 dynamic-field" data-kategori="remaja,lansia">
                        <label class="form-label">Lingkar Perut</label>
                        <input type="number" step="0.1" name="lingkar_perut" placeholder="cm" class="form-input text-center">
                    </div>
                    <div class="form-group mb-0 dynamic-field" data-kategori="remaja,lansia">
                        <label class="form-label">Tensi Darah</label>
                        <input type="text" name="tekanan_darah" placeholder="120/80" class="form-input text-center">
                    </div>
                    
                    <div class="form-group mb-0 dynamic-field col-span-2 sm:col-span-2" data-kategori="remaja">
                        <label class="form-label text-sky-600">Hemoglobin (Hb)</label>
                        <input type="number" step="0.1" name="hemoglobin" placeholder="g/dL (Cek Anemia)" class="form-input text-center border-sky-200 focus:border-sky-500 bg-sky-50/30">
                    </div>
                    
                    <div class="form-group mb-0 dynamic-field" data-kategori="lansia">
                        <label class="form-label text-emerald-600">Gula Darah</label>
                        <input type="text" name="gula_darah" placeholder="mg/dL" class="form-input text-center border-emerald-200 bg-emerald-50/30">
                    </div>
                    <div class="form-group mb-0 dynamic-field" data-kategori="lansia">
                        <label class="form-label text-emerald-600">Asam Urat</label>
                        <input type="number" step="0.1" name="asam_urat" placeholder="mg/dL" class="form-input text-center border-emerald-200 bg-emerald-50/30">
                    </div>
                    <div class="form-group mb-0 dynamic-field" data-kategori="lansia">
                        <label class="form-label text-emerald-600">Kolesterol</label>
                        <input type="number" name="kolesterol" placeholder="mg/dL" class="form-input text-center border-emerald-200 bg-emerald-50/30">
                    </div>
                </div>

                <hr class="border-slate-100 my-6">

                <div class="form-group mb-0">
                    <label class="form-label">Keluhan Utama Pasien</label>
                    <textarea name="keluhan" rows="3" placeholder="Contoh: Sering pusing, demam 2 hari, mual..." class="form-input resize-none"></textarea>
                </div>
            </div>
            
            <div class="p-6 sm:px-10 sm:py-6 bg-white border-t border-slate-100">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-2xl mx-auto">
                    <a href="{{ route('kader.pemeriksaan.index') }}" class="w-full py-3.5 bg-slate-100 border border-slate-200 text-slate-600 font-bold text-sm rounded-xl hover:bg-slate-200 hover:text-slate-800 transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="w-full py-3.5 bg-indigo-600 text-white font-extrabold text-sm rounded-xl hover:bg-indigo-700 shadow-[0_4px_12px_rgba(79,70,229,0.3)] hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i> Simpan & Kirim ke Bidan
                    </button>
                </div>
            </div>
            
        </div>
    </form>
</div>

{{-- Menyisipkan data semua pasien dari Controller ke dalam Javascript dalam bentuk JSON --}}
<script>
    // Asumsi: Anda me-passing variabel $semuaPasien dari Controller ke view ini.
    // Variabel ini berisi array object pasien (Balita, Remaja, Lansia)
    // Contoh format yang harus dikirim dari controller: 
    // [ { id: 1, nama: "Budi", kategori: "balita", nik: "123" }, ... ]
    
    const masterDataPasien = @json($semuaPasien ?? []); 

    function updateFormRealtime() {
        const kategori = document.getElementById('kategoriSelect').value;
        const pasienSelect = document.getElementById('pasienSelect');
        const labelKategori = document.getElementById('labelKategori');
        const dynamicFields = document.querySelectorAll('.dynamic-field');

        // 1. UPDATE LABEL WARNA (Visual Effect)
        if (kategori === 'balita') {
            labelKategori.textContent = 'Parameter Balita';
            labelKategori.className = 'px-3 py-1 bg-rose-100 text-rose-600 text-[10px] font-black uppercase rounded-lg border border-rose-200 tracking-wider transition-all';
        } else if (kategori === 'remaja') {
            labelKategori.textContent = 'Parameter Remaja';
            labelKategori.className = 'px-3 py-1 bg-sky-100 text-sky-600 text-[10px] font-black uppercase rounded-lg border border-sky-200 tracking-wider transition-all';
        } else if (kategori === 'lansia') {
            labelKategori.textContent = 'Parameter Lansia';
            labelKategori.className = 'px-3 py-1 bg-emerald-100 text-emerald-600 text-[10px] font-black uppercase rounded-lg border border-emerald-200 tracking-wider transition-all';
        } else {
            labelKategori.textContent = 'Menunggu Pilihan';
            labelKategori.className = 'px-3 py-1 bg-slate-100 text-slate-500 text-[10px] font-black uppercase rounded-lg border border-slate-200 tracking-wider transition-all';
        }

        // 2. FILTER DROPDOWN PASIEN TANPA REFRESH
        pasienSelect.innerHTML = ''; // Kosongkan isi select
        
        if (kategori === '') {
            pasienSelect.innerHTML = '<option value="">-- Pilih kategori pasien di atas terlebih dahulu --</option>';
            pasienSelect.disabled = true;
        } else {
            pasienSelect.disabled = false;
            let optionsHtml = '<option value="">-- Cari dan Pilih Nama Pasien --</option>';
            
            // Filter data JSON berdasarkan kategori
            const pasienDifilter = masterDataPasien.filter(p => p.kategori === kategori);
            
            if (pasienDifilter.length > 0) {
                pasienDifilter.forEach(p => {
                    optionsHtml += `<option value="${p.id}">${p.nama} - (NIK/Kode: ${p.nik})</option>`;
                });
            } else {
                optionsHtml = '<option value="">(Tidak ada pasien terdaftar di kategori ini)</option>';
            }
            pasienSelect.innerHTML = optionsHtml;
        }

        // 3. TAMPIL / SEMBUNYIKAN KOLOM INPUT (Real-time)
        dynamicFields.forEach(field => {
            // Ambil data-kategori dari elemen (contoh: "balita,remaja")
            const targetCategories = field.getAttribute('data-kategori').split(',');
            
            // Cek apakah kolom input perlu diisi untuk kategori saat ini
            if (kategori && targetCategories.includes(kategori)) {
                field.style.display = 'block';
                // Tambahkan sedikit animasi fade-in sederhana
                field.style.opacity = 0;
                setTimeout(() => field.style.opacity = 1, 50);
                field.style.transition = "opacity 0.3s ease-in-out";
            } else {
                field.style.display = 'none';
                // Kosongkan value jika kolom disembunyikan agar data tidak bocor
                const input = field.querySelector('input');
                if(input) input.value = '';
            }
        });
    }

    // Jalankan saat halaman pertama kali dibuka
    document.addEventListener('DOMContentLoaded', function() {
        updateFormRealtime();
    });
</script>
@endsection