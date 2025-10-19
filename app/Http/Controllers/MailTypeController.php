<?php

namespace App\Http\Controllers;

use App\Models\MailType;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MailTypeController extends Controller
{
    /**
     * Menampilkan daftar semua tipe surat.
     */
    public function index()
    {
        // Hanya me-return view. Data akan diambil via AJAX oleh getData()
        return view('pages.mailType.index');
    }

    /**
     * Mengambil dan memproses data untuk Yajra DataTables (via AJAX).
     */
    public function getData()
    {
        $query = MailType::select(['id', 'type_name', 'created_at']);
        
        return DataTables::of($query)
            ->addColumn('action', function($mailType) {
                // Tombol Aksi untuk Detail, Edit, dan Hapus
                $detailUrl = route('mailtype.detail', $mailType->id);
                $editUrl = route('mailtype.edit', $mailType->id);
                $deleteUrl = route('mailtype.destroy', $mailType->id);

                return '
                    <a href="'.$detailUrl.'" class="btn btn-info btn-sm text-white me-1">Detail</a>
                    <a href="'.$editUrl.'" class="btn btn-warning btn-sm me-1">Edit</a>
                    <form action="'.$deleteUrl.'" method="POST" style="display:inline;">
                        '.csrf_field().'
                        '.method_field('DELETE').'
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Menampilkan form untuk membuat tipe surat baru.
     */
    public function create()
    {
        return view('pages.mailType.create');
    }

    /**
     * Menyimpan tipe surat baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type_name' => 'required|string|max:100|unique:mail_types,type_name',
        ]);

        MailType::create($request->all());

        // Mengarahkan ke rute singular: mailtype.index
        return redirect()->route('mailtype.index')
                         ->with('success', 'tipe surat berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail spesifik dari tipe surat.
     * Menggunakan pengambilan data berdasarkan ID.
     */
    public function detail($id)
    {
        // Menggunakan findOrFail untuk menampilkan 404 jika ID tidak ditemukan
        $mailType = MailType::findOrFail($id); 
        
        return view('pages.mailType.detail', compact('mailType'));
    }

    /**
     * Menampilkan form untuk mengedit tipe surat.
     */
    public function edit($id)
    {
        // Menggunakan findOrFail untuk pengambilan data
        $mailType = MailType::findOrFail($id);
        
        return view('pages.mailType.edit', compact('mailType'));
    }

    /**
     * Memperbarui tipe surat yang sudah ada di database.
     */
    public function update(Request $request, $id)
    {
        // Menggunakan findOrFail untuk pengambilan data
        $mailType = MailType::findOrFail($id);

        $request->validate([
            // Memastikan nama unik, kecuali untuk dirinya sendiri
            'type_name' => 'required|string|max:100|unique:mail_types,type_name,' . $mailType->id,
        ]);

        $mailType->update($request->all());

        return redirect()->route('mailtype.index')
                         ->with('success', 'tipe surat berhasil diperbarui.');
    }

    /**
     * Menghapus tipe surat dari database.
     */
    public function destroy($id)
    {
        // Menggunakan findOrFail untuk pengambilan data dan penghapusan
        $mailType = MailType::findOrFail($id);
        
        // PENTING: Anda mungkin perlu menambahkan validasi di sini
        // untuk mencegah penghapusan jika MailType ini sudah digunakan
        // oleh IncomingMail atau OutgoingMail.

        $mailType->delete();

        return redirect()->route('mailtype.index')
                         ->with('success', 'tipe surat berhasil dihapus.');
    }
}