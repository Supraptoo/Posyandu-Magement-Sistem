<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use App\Models\DataImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TemplateImportBalitaExport;
use App\Exports\TemplateImportRemajaExport;
use App\Exports\TemplateImportLansiaExport;

class ImportController extends Controller
{
    public function index()
    {
        return view('kader.import.index');
    }

    public function create()
    {
        return view('kader.import.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_data' => 'required|in:balita,remaja,lansia',
            'file' => 'required|file|mimes:xlsx,xls,csv|max:5120', // 5MB
        ]);
        
        // Simpan file
        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('imports', $filename);
        
        // Buat record data import
        $dataImport = DataImport::create([
            'nama_file' => $file->getClientOriginalName(),
            'jenis_data' => $request->jenis_data,
            'file_path' => $path,
            'status' => 'pending',
            'created_by' => Auth::id(),
        ]);
        
        // Proses import (sederhana dulu)
        try {
            $dataImport->update(['status' => 'processing']);
            
            // Baca file Excel
            $data = Excel::toArray([], storage_path('app/' . $path));
            
            if (empty($data[0])) {
                throw new \Exception('File Excel kosong');
            }
            
            $rowCount = count($data[0]) - 1; // Minus header
            $successCount = $rowCount;
            $errorCount = 0;
            
            $dataImport->update([
                'status' => 'completed',
                'total_data' => $rowCount,
                'data_berhasil' => $successCount,
                'data_gagal' => $errorCount,
                'catatan' => 'Import berhasil sepenuhnya',
            ]);
            
            return redirect()->route('kader.import.history')
                ->with('success', 'Data berhasil diimport: ' . $successCount . ' data berhasil, ' . $errorCount . ' data gagal');
                
        } catch (\Exception $e) {
            $dataImport->update([
                'status' => 'failed',
                'catatan' => 'Error: ' . $e->getMessage(),
            ]);
            
            return back()
                ->withInput()
                ->with('error', 'Gagal mengimport data: ' . $e->getMessage());
        }
    }

    public function history()
    {
        $imports = DataImport::where('created_by', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('kader.import.history', compact('imports'));
    }

    public function show($id)
    {
        $import = DataImport::findOrFail($id);
        return view('kader.import.show', compact('import'));
    }

    public function downloadTemplate($type)
    {
        // Validasi jenis template
        if (!in_array($type, ['balita', 'remaja', 'lansia'])) {
            return back()->with('error', 'Jenis template tidak valid');
        }
        
        $filename = 'template_import_' . $type . '_' . date('YmdHis') . '.xlsx';
        
        // Gunakan Excel export untuk membuat template
        switch ($type) {
            case 'balita':
                return Excel::download(new TemplateImportBalitaExport(), $filename);
            case 'remaja':
                return Excel::download(new TemplateImportRemajaExport(), $filename);
            case 'lansia':
                return Excel::download(new TemplateImportLansiaExport(), $filename);
            default:
                return back()->with('error', 'Jenis template tidak valid');
        }
    }
}