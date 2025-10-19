<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MailType;
use App\Models\IncomingMail;
use Illuminate\Http\Request;
use App\Models\MailClassification;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables; 
use Illuminate\Support\Facades\Storage; // Import Storage Facade

class IncomingMailController extends Controller
{
    /**
     * Menampilkan daftar semua surat masuk (Hanya View).
     */
    public function index()
    {
        return view('pages.incomingMail.index');
    }

    /**
     * Mengambil dan memproses data untuk Yajra DataTables (via AJAX).
     */
    public function getData()
    {
        $query = IncomingMail::select([
                'incoming_mails.*',
                'mail_types.type_name as mail_type_name',
                'mail_classifications.classification_name as classification_name'
            ])
            ->join('mail_types', 'incoming_mails.mail_type_id', '=', 'mail_types.id')
            ->join('mail_classifications', 'incoming_mails.classification_id', '=', 'mail_classifications.id');

        return DataTables::of($query)
            ->addColumn('action', function($mail) {
                // Action buttons for Detail, Edit, and Delete
                $detailUrl = route('incomingmail.detail', $mail->id);
                $editUrl = route('incomingmail.edit', $mail->id);
                $deleteUrl = route('incomingmail.destroy', $mail->id);

                return '
                    <a href="'.$detailUrl.'" class="btn btn-info btn-sm text-white me-1">Detail</a>
                    <a href="'.$editUrl.'" class="btn btn-warning btn-sm me-1">Edit</a>
                    <form action="'.$deleteUrl.'" method="POST" style="display:inline;">
                        '.csrf_field().'
                        '.method_field('DELETE').'
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">Hapus</button>
                    </form>';
            })
            ->editColumn('received_date', function($mail) {
                return \Carbon\Carbon::parse($mail->mail_date)->format('d F Y');
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Menampilkan form untuk membuat surat masuk baru.
     */
    public function create()
    {
        $mailTypes = MailType::pluck('type_name', 'id');
        $classifications = MailClassification::pluck('classification_name', 'id');
        
        return view('pages.incomingMail.create', compact('mailTypes', 'classifications'));
    }

    /**
     * Menyimpan surat masuk baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'mail_type_id'      => 'required|integer',
            'classification_id' => 'required|integer',
            'mail_number'       => 'required|string|max:150|unique:incoming_mails,mail_number',
            'mail_date'         => 'required|date',
            'received_date'     => 'required|date',
            'origin'            => 'required|string|max:255',
            'destination'       => 'required|string|max:255', // Validasi field 'destination'
            'subject'           => 'required|string|max:255',
            'file'              => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // Max 5MB
            'created_by'        => 'required|integer', 
        ]);

        $data = $request->except('file');
        
        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('incoming_mail_files', 'public');
        }

        IncomingMail::create($data);

        return redirect()->route('incomingmail.index')
                         ->with('success', 'Surat Masuk berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail spesifik dari surat masuk.
     */
    public function detail($id)
    {
        $mail = IncomingMail::findOrFail($id); 
        
        // Ambil nama tipe dan sifat secara manual (karena tidak pakai relasi di model)
        $mailType = MailType::find($mail->mail_type_id)->type_name ?? 'Tidak Ditemukan';
        $classification = MailClassification::find($mail->classification_id)->classification_name ?? 'Tidak Ditemukan';
        $createdBy = User::where('id', $mail->created_by)->first();
        
        return view('pages.incomingMail.detail', compact('mail', 'mailType', 'classification', 'createdBy'));
    }

    /**
     * Menampilkan form untuk mengedit surat masuk.
     */
    public function edit($id)
    {
        $mail = IncomingMail::findOrFail($id);
        $mailTypes = MailType::pluck('type_name', 'id');
        $classifications = MailClassification::pluck('classification_name', 'id');
        
        return view('pages.incomingMail.edit', compact('mail', 'mailTypes', 'classifications'));
    }

    /**
     * Memperbarui surat masuk yang sudah ada di database.
     */
    public function update(Request $request, $id)
    {
        $mail = IncomingMail::findOrFail($id);

        $request->validate([
            'mail_type_id'      => 'required|integer',
            'classification_id' => 'required|integer',
            'mail_number'       => 'required|string|max:150|unique:incoming_mails,mail_number,' . $mail->id,
            'mail_date'         => 'required|date',
            'received_date'     => 'required|date',
            'origin'            => 'required|string|max:255',
            'destination'       => 'required|string|max:255', // Validasi field 'destination'
            'subject'           => 'required|string|max:255',
            'file'              => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'created_by'        => 'required|integer', 
        ]);

        $data = $request->except('file');
        
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($mail->file_path) {
                Storage::disk('public')->delete($mail->file_path);
            }
            $data['file_path'] = $request->file('file')->store('incoming_mail_files', 'public');
        }

        $mail->update($data);

        return redirect()->route('incomingmail.index')
                         ->with('success', 'Surat Masuk berhasil diperbarui.');
    }

    /**
     * Menghapus surat masuk dari database.
     */
    public function destroy($id)
    {
        $mail = IncomingMail::findOrFail($id);
        
        // Hapus file fisik sebelum menghapus record
        if ($mail->file_path) {
            Storage::disk('public')->delete($mail->file_path);
        }
        
        $mail->delete();

        return redirect()->route('incomingmail.index')
                         ->with('success', 'Surat Masuk berhasil dihapus.');
    }
}
