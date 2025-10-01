<?php

namespace App\Http\Controllers;

use App\Models\JenisSurat;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class JenisSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenis_surat = JenisSurat::latest()->get();
        return view('jenis_surat.index', compact('jenis_surat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $template = $this->templateDasar();
        return view('jenis_surat.create', compact('template'));
    }

    private function templateDasar()
    {
        return '
        <table style="border-collapse: collapse; width: 100%;">
<tbody>
<tr>
<td style="width: 10%;">[[logo]]</td>
<td style="text-align: center; width: 90%;">
<p style="margin: 0; text-align: center;"><span style="font-size: 14pt;">PEMERINTAH KABUPATEN BOGOR<br>KECAMATAN CIAMPEA<strong><br>DESA BOJONG RANGKAS </strong></span></p>
<p style="margin: 0; text-align: center;"><em><span style="font-size: 10pt;"> Jl. Raya Cikampak No.100, RT.05/RW.06 Kode Pos: 16620</span></em></p>
</td>
</tr>
</tbody>
</table>
<hr style="border: 3px solid;">
<p><!-- pagebreak --></p>
<h4 style="margin: 0; text-align: center;"><span style="text-decoration: underline;">[[NAMA_SURAT]]</span></h4>
<p style="margin: 0; text-align: center;">Nomor : [[NOMOR_SURAT]]<br><br></p>
<p style="text-align: justify; text-indent: 30px;">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quasi ex vero necessitatibus aspernatur sequi sint nam itaque velit rem unde!</p>
<table style="border-collapse: collapse; width: 100%;" border="0">
<tbody>
<tr>
<td style="width: 53.835%; text-align: center;"> </td>
<td style="width: 46.165%; text-align: center;">Bogor, [[TANGGAL_SURAT]]</td>
</tr>
<tr>
<td style="width: 53.835%; text-align: center;"> </td>
<td style="width: 46.165%; text-align: center;">Kepala Desa Bojong Rangkas</td>
</tr>
<tr>
<td style="width: 53.835%; text-align: center;"> </td>
<td style="width: 46.165%; text-align: center;"><br><br><br></td>
</tr>
<tr>
<td style="width: 53.835%; text-align: center;"> </td>
<td style="width: 46.165%; text-align: center;">Ir. Lorem Ipsum, MBA</td>
</tr>
<tr>
<td style="width: 53.835%; text-align: center;"> </td>
<td style="width: 46.165%; text-align: center;"> </td>
</tr>
</tbody>
</table>
<div style="text-align: center;"> </div>
<p><!-- pagebreak --></p>
        ';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_surat' => 'required|string|max:255',
            'template_surat' => 'required|string',
        ]);

        $jenis_surat = new JenisSurat();
        $jenis_surat->nama_surat = $request->nama_surat;
        $jenis_surat->template_surat = $request->template_surat;
        $jenis_surat->save();

        return redirect()->route('jenis_surat.index');
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
        $jenis_surat = JenisSurat::findOrFail($id);

        $html = $this->replaceImg($jenis_surat->template_surat);

        $pdf = Pdf::setPaper('a4', 'portrait');
        $pdf->loadHTML($html);
        return $pdf->stream('surat.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jenis_surat = JenisSurat::findOrFail($id);
        return view('jenis_surat.edit', compact('jenis_surat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_surat' => 'required|string|max:255',
            'template_surat' => 'required|string',
        ]);

        $jenis_surat = JenisSurat::findOrFail($id);
        $jenis_surat->nama_surat = $request->nama_surat;
        $jenis_surat->template_surat = $request->template_surat;
        $jenis_surat->save();

        return redirect()->route('jenis_surat.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jenis_surat = JenisSurat::findOrFail($id);
        $jenis_surat->delete();

        return redirect()->route('jenis_surat.index');
    }
}
