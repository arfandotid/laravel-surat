<?php

namespace App\Http\Controllers;

use App\Models\JenisSurat;
use App\Models\Surat;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenis_surat = JenisSurat::all();
        $surat = Surat::latest()->get();

        return view('surat.index', compact('jenis_surat', 'surat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->jenis) {
            $nomor_surat = Surat::generateNomorSurat();

            return view('surat.create', compact('nomor_surat'));
        } else {
            return redirect()->route('surat.index');
        }
    }

    private function replaceTemplate($isi, $data)
    {
        $data = [
            '[[NAMA_SURAT]]' => $data['nama_surat'],
            '[[NOMOR_SURAT]]' => $data['no_surat'],
            '[[TANGGAL_SURAT]]' => date('d F Y', strtotime($data['tgl_surat'])),
        ];

        return strtr($isi, $data);
    }

    public function preview(Request $request)
    {
        $jenis_surat = JenisSurat::findOrFail($request->jenis_surat_id);
        $data = $request->all();
        $data['nama_surat'] = $jenis_surat->nama_surat;

        $html = $this->replaceTemplate($jenis_surat->template_surat, $data);

        return view('surat.preview', compact('data', 'html'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_surat' => 'required|string|max:255',
            'tgl_surat' => 'required|date',
            'jenis_surat_id' => 'required',
            'isi_surat' => 'required',
        ]);

        $surat = new Surat();
        $surat->no_surat = $request->no_surat;
        $surat->tgl_surat = $request->tgl_surat;
        $surat->jenis_surat_id = $request->jenis_surat_id;
        $surat->isi_surat = $request->isi_surat;
        $surat->save();

        return redirect()->route('surat.index');
    }

    private function replaceImg($isi)
    {
        $data = [];
        $data['[[logo]]'] = '<img src="' . public_path('logo-surat.svg') . '" height="100" alt="Logo">';

        return strtr($isi, $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $surat = Surat::findOrFail($id);

        $html = $this->replaceImg($surat->isi_surat);

        $pdf = Pdf::setPaper('a4', 'portrait');
        $pdf->loadHTML($html);
        return $pdf->stream('surat.pdf');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $surat = Surat::findOrFail($id);
        return view('surat.edit', compact('surat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'isi_surat' => 'required',
        ]);

        $surat = Surat::findOrFail($id);
        $surat->isi_surat = $request->isi_surat;
        $surat->save();

        return redirect()->route('surat.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $surat = Surat::findOrFail($id);
        $surat->delete();

        return redirect()->route('surat.index');
    }
}
