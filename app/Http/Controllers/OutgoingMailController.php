<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MailType;
use App\Models\OutgoingMail;
use Illuminate\Http\Request;
use App\Models\MailClassification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\ValidationException;

class OutgoingMailController extends Controller
{
    /**
     * Menampilkan daftar semua surat keluar (Hanya View).
     */
    public function index()
    {
        return view('pages.outgoingMail.index');
    }

    /**
     * Mengambil dan memproses data untuk Yajra DataTables (via AJAX).
     */
    public function getData()
    {
        // Melakukan JOIN untuk mendapatkan nama Tipe Surat dan Sifat Surat
        $query = OutgoingMail::select([
            'outgoing_mails.*',
            'mail_types.type_name as mail_type_name',
            'mail_classifications.classification_name as classification_name'
        ])
        ->leftJoin('mail_types', 'outgoing_mails.mail_type_id', '=', 'mail_types.id')
        ->leftJoin('mail_classifications', 'outgoing_mails.classification_id', '=', 'mail_classifications.id');

        return DataTables::of($query)
            ->addColumn('action', function($mail) {
                $detailUrl = route('outgoingmail.detail', $mail->id);
                $editUrl = route('outgoingmail.edit', $mail->id);
                $deleteUrl = route('outgoingmail.destroy', $mail->id);

                return '
                    <a href="'.$detailUrl.'" class="btn btn-info btn-sm text-white me-1">Detail</a>
                    <a href="'.$editUrl.'" class="btn btn-warning btn-sm me-1">Edit</a>
                    <form action="'.$deleteUrl.'" method="POST" style="display:inline;">
                        '.csrf_field().'
                        '.method_field('DELETE').'
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">Hapus</button>
                    </form>';
            })
            ->editColumn('mail_date', function($mail) {
                return \Carbon\Carbon::parse($mail->mail_date)->format('d F Y');
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Menampilkan form untuk membuat surat keluar baru.
     */
    public function create()
    {
        $mailTypes = MailType::pluck('type_name', 'id');
        $classifications = MailClassification::pluck('classification_name', 'id');
        return view('pages.outgoingMail.create', compact('mailTypes', 'classifications'));
    }

    /**
     * Menyimpan surat keluar baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'mail_type_id' => 'required|integer',
            'classification_id' => 'required|integer',
            'mail_number' => 'required|string|max:150|unique:outgoing_mails,mail_number',
            'mail_date' => 'required|date',
            'origin' => 'required|string|max:255', // Asal Surat
            'destination' => 'required|string|max:255', // Tujuan Surat
            'subject' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // Max 5MB
        ]);

        $data = $request->except('file');
        
        // Simpan file jika ada
        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('outgoing_mail_files', 'public');
        } else {
            $data['file_path'] = null;
        }

        // Asumsi user ID sedang login (Ganti dengan Auth::id() jika menggunakan otentikasi)
        $data['created_by'] = auth()->check() ? auth()->id() : 1; 

        OutgoingMail::create($data);

        return redirect()->route('outgoingmail.index')->with('success', 'Surat Keluar berhasil diinput.');
    }

    /**
     * Menampilkan detail spesifik dari surat keluar.
     */
    public function detail($id)
    {
        $mail = OutgoingMail::findOrFail($id);
        
        $mailType = MailType::find($mail->mail_type_id)->type_name ?? 'N/A';
        $classification = MailClassification::find($mail->classification_id)->classification_name ?? 'N/A';
        $createdBy = User::where('id', $mail->created_by)->first();
        
        return view('pages.outgoingMail.detail', compact('mail', 'mailType', 'classification', 'createdBy'));
    }

    /**
     * Menampilkan form untuk mengedit surat keluar.
     */
    public function edit($id)
    {
        $mail = OutgoingMail::findOrFail($id);
        $mailTypes = MailType::pluck('type_name', 'id');
        $classifications = MailClassification::pluck('classification_name', 'id');
        
        return view('pages.outgoingMail.edit', compact('mail', 'mailTypes', 'classifications'));
    }

    /**
     * Memperbarui surat keluar yang sudah ada di database.
     */
    public function update(Request $request, $id)
    {
        $mail = OutgoingMail::findOrFail($id);

        $request->validate([
            'mail_type_id' => 'required|integer',
            'classification_id' => 'required|integer',
            'mail_number' => 'required|string|max:150|unique:outgoing_mails,mail_number,' . $mail->id,
            'mail_date' => 'required|date',
            'origin' => 'required|string|max:255', // Asal Surat
            'destination' => 'required|string|max:255', // Tujuan Surat
            'subject' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        $data = $request->except('file');
        
        // Handle file update
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($mail->file_path) {
                Storage::disk('public')->delete($mail->file_path);
            }
            $data['file_path'] = $request->file('file')->store('outgoing_mail_files', 'public');
        }
        // Jika tidak ada file baru, file_path lama tetap dipertahankan

        $mail->update($data);

        return redirect()->route('outgoingmail.index')->with('success', 'Surat Keluar berhasil diperbarui.');
    }

    /**
     * Menghapus surat keluar dari database.
     */
    public function destroy($id)
    {
        $mail = OutgoingMail::findOrFail($id);

        // Hapus file dari storage sebelum menghapus record
        if ($mail->file_path) {
            Storage::disk('public')->delete($mail->file_path);
        }
        
        $mail->delete();

        return redirect()->route('outgoingmail.index')->with('success', 'Surat Keluar berhasil dihapus.');
    }
}
