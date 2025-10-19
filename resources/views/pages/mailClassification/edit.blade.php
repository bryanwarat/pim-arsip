@extends('layouts.app')

@section('title', 'Edit Sifat Surat')

@section('content')
    <div class="container mt-4">
        {{-- Hidden element for flash message (Success Alert) --}}
        @if (session('success'))
            <div id="success-alert" class="d-none" data-message="{{ session('success') }}"></div>
        @endif

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Edit Sifat Surat: {{ $classification->classification_name }}</h4>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Form Edit Data Sifat Surat
            </div>
            <div class="card-body">
                <form action="{{ route('mailclassification.update', $classification->id) }}" method="POST">
                    @csrf
                    @method('PUT') {{-- Penting untuk method update --}}

                    <div class="mb-3">
                        <label for="classification_name" class="form-label">Nama Sifat Surat</label>
                        <input type="text" class="form-control @error('classification_name') is-invalid @enderror"
                            id="classification_name" name="classification_name"
                            value="{{ old('classification_name', $classification->classification_name) }}" required>
                        @error('classification_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success">Perbarui</button>
                    <a href="{{ route('mailclassification.index') }}" class="btn btn-secondary">Batal</a>
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
