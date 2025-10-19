@extends('layouts.app')

@section('title', 'Detail Surat Keluar')

@section('content')
    <div class="container mt-4">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Detail Surat Keluar: {{ $mail->mail_number }}</h4>
            </div>
            <a href="{{ route('outgoingmail.index') }}" class="btn btn-secondary btn-sm">Kembali ke Daftar</a>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                Informasi Surat
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <dl class="row">
                            <dt class="col-sm-4">Nomor Surat</dt>
                            <dd class="col-sm-8">{{ $mail->mail_number }}</dd>

                            <dt class="col-sm-4">Asal Surat</dt>
                            <dd class="col-sm-8">{{ $mail->origin }}</dd>

                            <dt class="col-sm-4">Tujuan Surat</dt>
                            <dd class="col-sm-8">{{ $mail->destination }}</dd>

                            <dt class="col-sm-4">Perihal</dt>
                            <dd class="col-sm-8">{{ $mail->subject }}</dd>

                            <dt class="col-sm-4">Tanggal Surat</dt>
                            <dd class="col-sm-8">{{ \Carbon\Carbon::parse($mail->mail_date)->format('d F Y') }}</dd>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl class="row">
                            <dt class="col-sm-4">Tipe Surat</dt>
                            <dd class="col-sm-8">{{ $mailType }}</dd>

                            <dt class="col-sm-4">Sifat Surat</dt>
                            <dd class="col-sm-8">{{ $classification }}</dd>

                            <dt class="col-sm-4">Diinput Oleh</dt>
                            {{-- ASUMSI: $createdBy di-load di controller dan memiliki properti 'name' --}}
                            <dd class="col-sm-8">{{ $createdBy->name ?? $mail->created_by }}</dd>

                            <dt class="col-sm-4">Waktu Input</dt>
                            <dd class="col-sm-8">{{ $mail->created_at->format('d F Y H:i:s') }}</dd>

                            <dt class="col-sm-4">File Lampiran</dt>
                            <dd class="col-sm-8">
                                @if ($mail->file_path)
                                    <a href="{{ asset('storage/' . $mail->file_path) }}" target="_blank"
                                        class="btn btn-sm btn-outline-primary">Lihat/Unduh File</a>
                                @else
                                    <span class="text-muted">Tidak Ada File</span>
                                @endif
                            </dd>
                        </dl>
                    </div>
                </div>

                <hr>
                <a href="{{ route('outgoingmail.edit', $mail->id) }}" class="btn btn-warning">Edit Data</a>
            </div>
        </div>

        @if ($mail->file_path)
            @php
                // Tentukan URL file publik
                $fileUrl = asset('storage/' . $mail->file_path);
                // Cek ekstensi file
                $extension = pathinfo($mail->file_path, PATHINFO_EXTENSION);
            @endphp

            @if (strtolower($extension) === 'pdf')
                <div class="card mt-4">
                    <div class="card-header">
                        Preview Dokumen PDF
                    </div>
                    <div class="card-body p-0">
                        {{-- Menggunakan iframe untuk menyematkan PDF --}}
                        <iframe src="{{ $fileUrl }}" width="100%" height="600px" style="border: none;">
                            <p>Browser Anda tidak mendukung iframe PDF. Anda dapat <a href="{{ $fileUrl }}">mengunduh
                                    file PDF</a>.</p>
                        </iframe>
                    </div>
                </div>
            @elseif (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                <div class="card mt-4">
                    <div class="card-header">
                        Preview Gambar
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ $fileUrl }}" class="img-fluid" style="max-height: 500px; border: 1px solid #ccc;"
                            alt="Preview Gambar">
                    </div>
                </div>
            @else
                <div class="alert alert-info mt-4">
                    Preview tidak tersedia untuk tipe file: **{{ strtoupper($extension) }}**. Silakan klik tombol
                    "Lihat/Unduh File" di atas.
                </div>
            @endif
        @endif
    </div>
@endsection
