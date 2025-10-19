<?php

namespace App\Http\Controllers;

use App\Models\MailClassification;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MailClassificationController extends Controller
{
    /**
     * Menampilkan daftar semua sifat surat (Hanya View).
     */
    public function index()
    {
        return view('pages.mailClassification.index');
    }

    /**
     * Mengambil dan memproses data untuk Yajra DataTables (via AJAX).
     */
    public function getData()
    {
        $query = MailClassification::select(['id', 'classification_name', 'created_at']);
        
        return DataTables::of($query)
            ->addColumn('action', function($classification) {
                // Tombol Aksi untuk Detail, Edit, dan Hapus
                $detailUrl = route('mailclassification.detail', $classification->id);
                $editUrl = route('mailclassification.edit', $classification->id);
                $deleteUrl = route('mailclassification.destroy', $classification->id);

                return '
                    <a href="'.$detailUrl.'" class="btn btn-info btn-sm text-white me-1">Detail</a>
                    <a href="'.$editUrl.'" class="btn btn-warning btn-sm me-1">Edit</a>
                    <form action="'.$deleteUrl.'" method="POST" style="display:inline;">
                        '.csrf_field().'
                        '.method_field('DELETE').'
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">Hapus</button>
                    </form>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Menampilkan form untuk membuat sifat surat baru.
     */
    public function create()
    {
        return view('pages.mailClassification.create');
    }

    /**
     * Menyimpan sifat surat baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'classification_name' => 'required|string|max:100|unique:mail_classifications,classification_name',
        ]);

        MailClassification::create($request->all());

        return redirect()->route('mailclassification.index')
                         ->with('success', 'Sifat Surat berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail spesifik dari sifat surat.
     */
    public function detail($id)
    {
        $classification = MailClassification::findOrFail($id); 
        return view('pages.mailClassification.detail', compact('classification'));
    }

    /**
     * Menampilkan form untuk mengedit sifat surat.
     */
    public function edit($id)
    {
        $classification = MailClassification::findOrFail($id);
        return view('pages.mailClassification.edit', compact('classification'));
    }

    /**
     * Memperbarui sifat surat yang sudah ada di database.
     */
    public function update(Request $request, $id)
    {
        $classification = MailClassification::findOrFail($id);
        $request->validate([
            'classification_name' => 'required|string|max:100|unique:mail_classifications,classification_name,' . $classification->id,
        ]);
        $classification->update($request->all());

        return redirect()->route('mailclassification.index')
                         ->with('success', 'Sifat Surat berhasil diperbarui.');
    }

    /**
     * Menghapus sifat surat dari database.
     */
    public function destroy($id)
    {
        $classification = MailClassification::findOrFail($id);
        
        // Tambahkan validasi keterkaitan jika diperlukan
        // if ($classification->incomingMails()->exists() || $classification->outgoingMails()->exists()) {
        //     return redirect()->route('mailclassification.index')->with('error', 'Tidak dapat menghapus. Sifat Surat ini sudah terpakai.');
        // }

        $classification->delete();

        return redirect()->route('mailclassification.index')
                         ->with('success', 'Sifat Surat berhasil dihapus.');
    }
}
