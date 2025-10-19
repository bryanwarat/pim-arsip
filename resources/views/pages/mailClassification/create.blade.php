@extends('layouts.app')

@section('title', 'Tambah Sifat Surat')

@section('content')
    <div class="container mt-4">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Tambah Sifat Surat Baru</h4>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Form Data Sifat Surat
            </div>
            <div class="card-body">
                <form action="{{ route('mailclassification.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="classification_name" class="form-label">Nama Sifat Surat (Contoh: Rahasia)</label>
                        <input type="text" class="form-control @error('classification_name') is-invalid @enderror"
                            id="classification_name" name="classification_name" value="{{ old('classification_name') }}"
                            required>
                        @error('classification_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('mailclassification.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
