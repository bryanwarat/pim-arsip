@extends('layouts.app')

@section('title', 'Edit Surat Masuk')

@section('content')
    {{-- Hidden element for flash message (Success Alert) --}}
    @if (session('success'))
        <div id="success-alert" class="d-none" data-message="{{ session('success') }}"></div>
    @endif

    <div class="container mt-4">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Edit Surat Masuk: {{ $mail->mail_number }}</h4>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Form Edit Surat Masuk
            </div>
            <div class="card-body">
                <form action="{{ route('incomingmail.update', $mail->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        {{-- Kolom Kiri --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="mail_number" class="form-label">Nomor Surat</label>
                                <input type="text" class="form-control @error('mail_number') is-invalid @enderror"
                                    id="mail_number" name="mail_number" value="{{ old('mail_number', $mail->mail_number) }}"
                                    required>
                                @error('mail_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="mail_date" class="form-label">Tanggal Surat (Tgl Terbit)</label>
                                <input type="date" class="form-control @error('mail_date') is-invalid @enderror"
                                    id="mail_date" name="mail_date" value="{{ old('mail_date', $mail->mail_date) }}"
                                    required>
                                @error('mail_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="received_date" class="form-label">Tanggal Terima</label>
                                <input type="date" class="form-control @error('received_date') is-invalid @enderror"
                                    id="received_date" name="received_date"
                                    value="{{ old('received_date', $mail->received_date) }}" required>
                                @error('received_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="origin" class="form-label">Asal Surat</label>
                                <input type="text" class="form-control @error('origin') is-invalid @enderror"
                                    id="origin" name="origin" value="{{ old('origin', $mail->origin) }}" required>
                                @error('origin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="subject" class="form-label">Perihal</label>
                                <input type="text" class="form-control @error('subject') is-invalid @enderror"
                                    id="subject" name="subject" value="{{ old('subject', $mail->subject) }}" required>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Kolom Kanan --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="mail_type_id" class="form-label">Tipe Surat</label>
                                <select class="form-select @error('mail_type_id') is-invalid @enderror" id="mail_type_id"
                                    name="mail_type_id" required>
                                    <option value="">-- Pilih Tipe --</option>
                                    @foreach ($mailTypes as $id => $name)
                                        <option value="{{ $id }}"
                                            {{ old('mail_type_id', $mail->mail_type_id) == $id ? 'selected' : '' }}>
                                            {{ $name }}</option>
                                    @endforeach
                                </select>
                                @error('mail_type_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="classification_id" class="form-label">Sifat Surat</label>
                                <select class="form-select @error('classification_id') is-invalid @enderror"
                                    id="classification_id" name="classification_id" required>
                                    <option value="">-- Pilih Sifat --</option>
                                    @foreach ($classifications as $id => $name)
                                        <option value="{{ $id }}"
                                            {{ old('classification_id', $mail->classification_id) == $id ? 'selected' : '' }}>
                                            {{ $name }}</option>
                                    @endforeach
                                </select>
                                @error('classification_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="destination" class="form-label">Tujuan (Internal)</label>
                                <input type="text" class="form-control @error('destination') is-invalid @enderror"
                                    id="destination" name="destination"
                                    value="{{ old('destination', $mail->destination) }}" required>
                                <small class="text-muted">Tujuan atau unit penerima internal.</small>
                                @error('destination')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="file" class="form-label">Ganti File (PDF/DOC/Gambar)</label>
                                <input type="file" class="form-control @error('file') is-invalid @enderror"
                                    id="file" name="file">
                                @if ($mail->file_path)
                                    <small class="text-muted">File saat ini: <a
                                            href="{{ asset('storage/' . $mail->file_path) }}" target="_blank">Lihat
                                            File</a></small>
                                @else
                                    <small class="text-muted">Tidak ada file terlampir saat ini.</small>
                                @endif
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Field created_by akan diisi otomatis, tetapi kita perlu input tersembunyi untuk mempertahankan nilai lama --}}
                            <input type="hidden" name="created_by" value="{{ old('created_by', $mail->created_by) }}">

                        </div>
                    </div>

                    <button type="submit" class="btn btn-success mt-3">Perbarui Surat Masuk</button>
                    <a href="{{ route('incomingmail.index') }}" class="btn btn-secondary mt-3">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Tampilkan SweetAlert jika ada pesan sukses dari session
        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: successAlert.dataset.message,
                showConfirmButton: false,
                timer: 2000
            });
        }
    </script>
@endpush
