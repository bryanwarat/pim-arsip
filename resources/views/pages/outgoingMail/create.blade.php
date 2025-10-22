@extends('layouts.app')

@section('title', 'Input Surat Keluar')

@section('content')
    <div class="container mt-4">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Input Surat Keluar</h4>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Form Surat Keluar
            </div>
            <div class="card-body">
                <form action="{{ route('outgoingmail.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        {{-- Kolom Kiri --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="mail_number" class="form-label">Nomor Surat</label>
                                <input type="text" class="form-control @error('mail_number') is-invalid @enderror"
                                    id="mail_number" name="mail_number" value="{{ old('mail_number') }}" required>
                                @error('mail_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="mail_date" class="form-label">Tanggal Surat (Tgl Kirim)</label>
                                <input type="date" class="form-control @error('mail_date') is-invalid @enderror"
                                    id="mail_date" name="mail_date"
                                    value="{{ old('mail_date', \Carbon\Carbon::now()->format('Y-m-d')) }}" required>
                                @error('mail_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="origin" class="form-label">Asal Surat</label>
                                <input type="text" class="form-control @error('origin') is-invalid @enderror"
                                    id="origin" name="origin" value="{{ old('origin') }}" required>
                                @error('origin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="destination" class="form-label">Tujuan Surat</label>
                                <input type="text" class="form-control @error('destination') is-invalid @enderror"
                                    id="destination" name="destination" value="{{ old('destination') }}" required>
                                @error('destination')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Kolom Kanan --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="subject" class="form-label">Perihal</label>
                                <input type="text" class="form-control @error('subject') is-invalid @enderror"
                                    id="subject" name="subject" value="{{ old('subject') }}" required>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="mail_type_id" class="form-label">Tipe Surat</label>
                                <select class="form-select @error('mail_type_id') is-invalid @enderror" id="mail_type_id"
                                    name="mail_type_id" required>
                                    <option value="">-- Pilih Tipe --</option>
                                    @foreach ($mailTypes as $id => $name)
                                        <option value="{{ $id }}"
                                            {{ old('mail_type_id') == $id ? 'selected' : '' }}>{{ $name }}
                                        </option>
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
                                            {{ old('classification_id') == $id ? 'selected' : '' }}>{{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('classification_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="file" class="form-label">File (PDF/DOC/Gambar)</label>
                                <input type="file" class="form-control @error('file') is-invalid @enderror"
                                    id="file" name="file">
                                <small class="text-muted">Max. 5MB. Kosongkan jika tidak ada file.</small>
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success mt-3">Simpan Surat Keluar</button>
                    <a href="{{ route('outgoingmail.index') }}" class="btn btn-secondary mt-3">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection
